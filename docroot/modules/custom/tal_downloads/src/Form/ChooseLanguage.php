<?php

namespace Drupal\tal_downloads\Form;

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
    $inactive_link = $this->getEmptyWrapper($id);
    $suffix = render($inactive_link);

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['change_language'] = [
      '#type' => 'select',
      '#options' => $this->getLanguageOptions($filegroup_ids),
      '#suffix' => $suffix,
      '#attributes' => array(
        'id' => array(
          'edit-language-' . $id,
        ),
      ),
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
      0 => t('Select language'),
    );
    foreach ($entities as $entity_id => $entity) {
      $term = $entity->get('field_file_language')->referencedEntities();
      $options[$entity_id] = $term[0]->getName();
    }

    return $options;
  }

  /**
   * Renderable empty wrapper element for download link.
   *
   * @param int $id
   *   Unique id for wrapper element.
   *
   * @return mixed|array
   *   Returns empty renderable array with unique wrapper id.
   */
  private function getEmptyWrapper($id) {
    $message['element'] = [
      '#theme' => 'tal_download_link',
      '#content' => $this->t('<span class="download-inactive">Download</span>'),
      '#attributes' => array(
        'class' => 'tal-file-download-link',
        'id' => 'download-link-' . $id,
      ),
    ];

    return $message;
  }

}
