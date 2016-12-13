<?php

namespace Drupal\tal_downloads\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

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
   * Form with 'add more' and 'remove' buttons.
   *
   * This example shows a button to "add more" - add another textfield, and
   * the corresponding "remove" button.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions'] = [
      '#type' => 'actions',
    ];

    $options = $this->getLanguages();
    $form['change_language'] = [
      '#type' => 'select',
      '#options' => $options,
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];
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
    // @todo: Add ajax callback for language selection.
    $output = t('Language Selected.');
    drupal_set_message($output);
  }

  /**
   * Fetches terms from language vocabulary for form options.
   *
   * @return array
   *   Options for language selection form.
   */
  private function getLanguages() {
    $vid = 'languages';
    $options = array(
      0 => t('Choose version'),
    );
    $terms = \Drupal::service('entity_type.manager')
      ->getStorage("taxonomy_term")
      ->loadTree($vid, $parent = 0, $max_depth = NULL, $load_entities = FALSE);
    foreach ($terms as $term) {
      $options[$term->tid] = $term->name;
    }
    return $options;
  }

}
