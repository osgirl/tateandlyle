<?php

namespace Drupal\tal_webform\Plugin\WebformHandler;

use Drupal\Component\Utility\Xss;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\Plugin\WebformHandler\EmailWebformHandler;
use \Drupal\Taxonomy\Entity\Term;

/**
 * Emails a webform submission.
 *
 * @WebformHandler(
 *   id = "tal_email",
 *   label = @Translation("TAL Email"),
 *   category = @Translation("Notification"),
 *   description = @Translation("Sends a TAL webform submission via an email."),
 *   cardinality=\Drupal\webform\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class TalEmailWebformHandler extends EmailWebformHandler {

  /**
   * This function validates the custom rules required for email notifications.
   *
   * @return bool
   *   Return true or false on the basis of criteria specified.
   */
  public function validateEmailRules($message) {
    $webform_submission = $message['webform_submission'];
    $te = $webform_submission->getData('type_of_enquiry');
    if ($te == 'other') {
      return $this->getOtherTermEmail($webform_submission->getData('others'));
    }
    elseif ($te == 'commercial_sales') {
      $routing = $this->isTermSalesForceOnEmail($webform_submission->getData('routing'));
      return $routing;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE) {
    $is_results_disabled = $webform_submission->getWebform()->getSetting('results_disabled');
    $is_completed = ($webform_submission->getState() == WebformSubmissionInterface::STATE_COMPLETED);
    if (($is_results_disabled || $is_completed)) {
      $message = $this->getMessage($webform_submission);
      $validated = $this->validateEmailRules($message);
      if ($validated['salesforce_on']) {
        $message['send_email'] = $validated['email'];
        $this->sendMessage($message);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function sendMessage(array $message) {
    // Send mail.
    $message['to_mail'] = !empty($message['send_email']) ? $message['send_email'] : $message['to_mail'];
    $to = $message['to_mail'];
    $from = $message['from_mail'] . (($message['from_name']) ? ' <' . $message['from_name'] . '>' : '');
    $current_langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $this->mailManager->mail('webform', 'email.' . $this->getHandlerId(), $to, $current_langcode, $message, $from);

    // Log message.
    $context = [
      '@form' => $this->getWebform()->label(),
      '@title' => $this->label(),
    ];
    $this->logger->notice('@form webform sent @title email.', $context);

    // Debug by displaying send email onscreen.
    if ($this->configuration['debug']) {
      $t_args = [
        '%from_name' => $message['from_name'],
        '%from_mail' => $message['from_mail'],
        '%to_mail' => $message['to_mail'],
        '%subject' => $message['subject'],
      ];
      $build = [];
      $build['message'] = [
        '#markup' => $this->t('%subject sent to %to_mail from %from_name [%from_mail].', $t_args),
        '#prefix' => '<b>',
        '#suffix' => '</b>',
      ];
      if ($message['html']) {
        $build['body'] = [
          '#markup' => $message['body'],
          '#allowed_tags' => Xss::getAdminTagList(),
          '#prefix' => '<div>',
          '#suffix' => '</div>',
        ];
      }
      else {
        $build['body'] = [
          '#markup' => $message['body'],
          '#prefix' => '<pre>',
          '#suffix' => '</pre>',
        ];
      }
      drupal_set_message(\Drupal::service('renderer')->render($build), 'warning');
    }
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
   *   returns the saleforce check and email.
   */
  public function getOtherTermEmail($id) {
    $term = Term::load($id);
    $email = $term->get('field_email')->value;
    return array('salesforce_on' => 1, 'email' => $email);
  }

  /**
   * Function used to get the true false for saleforce.
   *
   * @param int $id
   *   Id of the term.
   *
   * @return mixed
   *   returns the saleforce check and email.
   */
  public function isTermSalesForceOnEmail($id) {
    $term = Term::load($id);
    $email = $term->get('field_email')->value;
    return array('salesforce_on' => !(int) $term->get('field_saleforce_routing_on')->value, 'email' => $email);
  }

}
