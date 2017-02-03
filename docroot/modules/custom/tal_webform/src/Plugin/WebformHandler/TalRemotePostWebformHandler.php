<?php

namespace Drupal\tal_webform\Plugin\WebformHandler;

use Drupal\Core\Serialization\Yaml;
use Drupal\webform\WebformSubmissionInterface;
use GuzzleHttp\Exception\RequestException;
use Drupal\webform\Plugin\WebformHandler\RemotePostWebformHandler;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\Taxonomy\Entity\Term;

/**
 * Webform submission remote post handler.
 *
 * @WebformHandler(
 *   id = "tal_remote_post",
 *   label = @Translation("TAL Remote post"),
 *   category = @Translation("External"),
 *   description = @Translation("Posts TAL webform submissions to a URL."),
 *   cardinality=\Drupal\webform\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class TalRemotePostWebformHandler extends RemotePostWebformHandler {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $field_names = array_keys(\Drupal::service('entity_field.manager')->getBaseFieldDefinitions('webform_submission'));
    $excluded_data = array_combine($field_names, $field_names);
    return [
      'type' => 'x-www-form-urlencoded',
      'insert_url' => '',
      'update_url' => '',
      'delete_url' => '',
      'excluded_data' => $excluded_data,
      'custom_data' => '',
      'insert_custom_data' => '',
      'update_custom_data' => '',
      'delete_custom_data' => '',
      'debug' => FALSE,
      'debugEmail' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $form['debugEmail'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Debug Mail Id'),
      '#description' => $this->t('Mail id will be used to send debug data from Sales force when enabled.'),
      '#return_value' => TRUE,
      '#default_value' => $this->configuration['debugEmail'],
    ];
    return $form;
  }

  /**
   * This function validates the custom rules required for email notifications.
   *
   * @param array $data
   *   Array of webformsubmission data.
   *
   * @return bool
   *   Return true or false on the basis of criteria specified.
   */
  public function validateSalesForcePostRules(array $data) {
    // $tc = $data['tc'];.
    $te = $data['post_data']['type_of_enquiry'];
    $newList = $this->isTermSalesForceOn($data['post_data']['routing']);
    // Rule 1.
    $rule1 = ($te == 'commercial_sales') && $newList;
    if ($rule1) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $operation = ($update) ? 'update' : 'insert';
    $this->remotePost($operation, $webform_submission);
  }

  /**
   * Execute a remote post.
   *
   * @param string $operation
   *   The type of webform submission operation to be posted. Can be 'insert',
   *   'update', or 'delete'.
   * @param \Drupal\webform\WebformSubmissionInterface $webform_submission
   *   The webform submission to be posted.
   */
  protected function remotePost($operation, WebformSubmissionInterface $webform_submission) {
    $request_url = $this->configuration[$operation . '_url'];
    if (empty($request_url)) {
      return;
    }

    $request_type = $this->configuration['type'];
    $data = $this->getPostData($operation, $webform_submission);
    $validated = $this->validateSalesForcePostRules($data);
    $request_post_data = $data['post_data'];
    $request_post_data['oid'] = '00DP000000037No';
    $request_post_data['retURL'] = $data['url'];
    // Category has unique id to post.
    $request_post_data['00NP0000000xvHb'] = $request_post_data['category'];

    // Message has unique id to post.
    $request_post_data['00NP0000001FiDS'] = $request_post_data['message'];

    // Update the term name for Industry and Category.
    $request_post_data['category'] = $this->getTermName($request_post_data['category']);
    $request_post_data['industry'] = $this->getTermName($request_post_data['industry']);

    // Debug parameters.
    if ($this->configuration['debug']) {
      $request_post_data['debug'] = 1;
      $request_post_data['debugEmail'] = $this->configuration['debugEmail'];
    }

    if ($validated) {
      try {
        switch ($request_type) {
          case 'json':
            $response = $this->httpClient->post($request_url, ['json' => $request_post_data]);
            break;

          case 'x-www-form-urlencoded':
          default:
            $response = $this->httpClient->post($request_url, ['form_params' => $request_post_data]);
            break;
        }
      }
      catch (RequestException $request_exception) {
        $message = $request_exception->getMessage();
        $response = $request_exception->getResponse();

        // If debugging is enabled, display the error message on screen.
        $this->debug($message, $operation, $request_url, $request_type, $request_post_data, $response, 'error');

        // Log error message.
        $context = [
          '@form' => $this->getWebform()->label(),
          '@operation' => $operation,
          '@type' => $request_type,
          '@url' => $request_url,
          '@message' => $message,
          'link' => $this->getWebform()->toLink(t('Edit'), 'handlers-form')->toString(),
        ];
        $this->logger->error('@form webform remote @type post (@operation) to @url failed. @message', $context);
        return;
      }

      // If debugging is enabled, display the request and response.
      $this->debug(t('Remote post successful!'), $operation, $request_url, $request_type, $request_post_data, $response, 'warning');
    }
    else {
      return;
    }

  }

  /**
   * Get a webform submission's post data.
   *
   * @param string $operation
   *   The type of webform submission operation to be posted. Can be 'insert',
   *   'update', or 'delete'.
   * @param \Drupal\webform\WebformSubmissionInterface $webform_submission
   *   The webform submission to be posted.
   *
   * @return array
   *   A webform submission converted to an associative array.
   */
  protected function getPostData($operation, WebformSubmissionInterface $webform_submission) {
    // Get submission and elements data.
    $data = $webform_submission->toArray(TRUE);
    // Flatten data.
    // Prioritizing elements before the submissions fields.
    $data = $data['data'] + $data;
    unset($data['data']);

    // Generated return absolute url for salesforce return url.
    $uri = "base:" . $data['uri'];
    $url = Url::fromUri($uri);
    $url->setAbsolute(TRUE);
    $url = $url->toString();

    // Salesforce validate ttu type of content field data.
    $tc = $data['tc'];

    // Excluded selected submission data.
    $data = array_diff_key($data, $this->configuration['excluded_data']);
    // Append custom data.
    if (!empty($this->configuration['custom_data'])) {
      $data = Yaml::decode($this->configuration['custom_data']) + $data;
    }

    // Append operation data.
    if (!empty($this->configuration[$operation . '_custom_data'])) {
      $data = Yaml::decode($this->configuration[$operation . '_custom_data']) + $data;
    }

    // Replace tokens.
    $data = $this->tokenManager->replace($data, $webform_submission);

    return array('post_data' => $data, 'tc' => $tc, 'url' => $url);
  }

  /**
   * Function used to get the term name.
   *
   * @param int $id
   *   Id of the term.
   *
   * @return mixed
   *   returns the termname.
   */
  public function getTermName($id) {
    $term = Term::load($id);
    return $term->getName();
  }

  /**
   * Function used to get the term name.
   *
   * @param int $id
   *   Id of the term.
   *
   * @return mixed
   *   returns the termname.
   */
  public function isTermSalesForceOn($id) {
    $term = Term::load($id);
    return (int) $term->get('field_saleforce_routing_on')->value;
  }

}
