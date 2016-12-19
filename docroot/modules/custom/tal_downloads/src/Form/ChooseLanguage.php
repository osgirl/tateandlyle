<?php

namespace Drupal\tal_downloads\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Implements the ajax demo form controller.
 *
 * This example demonstrates using ajax callbacks to populate the options of a
 * color select element dynamically based on the value selected in another
 * select element in the form.
 *
 * @see \Drupal\Core\Form\FormBase
 * @see \Drupal\Core\Form\ConfigFormBase
 */
class ChooseLanguage extends FormBase {

  /**
   * Form for language selection options.
   *
   * @param array $form
   *   Form to render Language selection dropdown.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   FormState object.
   * @param mixed $filegroup_ids
   *   Entity id of filegroup paragraph.
   *
   * @return array
   *   Renderable form array.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $filegroup_ids = NULL) {
    // Generate a unique salt for placeholder id.
    $id = substr(md5(rand()), 0, 5);

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['change_language'] = [
      '#type' => 'select',
      '#options' => $this->getLanguageOptions($filegroup_ids),
      '#ajax' => [
        'event' => 'change',
        'callback' => array($this, 'showDownloadLink'),
      ],
      '#suffix' => '<span id="download-link-' . $id . '"></span>',
    ];
    $form['id'] = array(
      '#type' => 'hidden',
      '#default_value' => $id,
    );

    $form_state->setCached(FALSE);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'tal_downloads_language_selection';
  }

  /**
   * Final submit handler.
   *
   * Reports what values were finally set.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $output = t('Language Selected.');
    drupal_set_message($output);
  }

  /**
   * Fetches terms from language vocabulary for form options.
   *
   * @return array
   *   Options for language selection form.
   */
  private function getLanguageOptions($filegroup_ids) {
    $entities = Paragraph::loadMultiple($filegroup_ids);
    $options = array(
      0 => t('Choose version'),
    );
    foreach ($entities as $entity_id => $entity) {
      $term = $entity->get('field_file_language')->referencedEntities();
      $options[$entity_id] = $term[0]->getName();
    }

    return $options;
  }

  /**
   * Ajax Callback function for language selection.
   *
   * @param array $form
   *   Form to render Language selection dropdown.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   FormState object.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   AjaxResoponse with Download link and size details.
   */
  public function showDownloadLink(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $message['#markup'] = '<span class="download-inactive">Download</span>';

    // Current paragraph entity id.
    $pid = $form_state->getValue('change_language');
    $id = $form_state->getValue('id');

    if (!empty($pid)) {
      $item = Paragraph::load($pid);
      $file = $item->get('field_download_attach_file')->referencedEntities()[0];
      $element = array(
        '#theme' => 'tal_download_link',
        '#file' => $file,
        '#attributes' => array(
          'class' => 'tal-file-download-link',
        ),
      );
      $message['element'] = $element;
    }

    $response->addCommand(new ReplaceCommand('#download-link-' . $id, $message));

    return $response;
  }

}
