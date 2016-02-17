<?php
/**
 * @file
 * Contains \Drupal\tl_tweaks\Form\ContactFormSettingsForm.
 */

namespace Drupal\tl_tweaks\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements custom settings form for tl_tweaks.
 */
class ContactFormSettingsForm extends FormBase {

  /**
   * Custom settings form for tl_tweaks.
   */
  public function getFormId() {
    return 'tl_tweaks_settings_form';
  }

  /**
   * Custom settings form for tl_tweaks.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    foreach (entity_get_bundles()['contact_message'] as $key => $contact_message) {
      if ($contact_message['label'] != 'Personal contact form') {
        $form['style'][$key] = array(
          '#type' => 'textfield',
          '#title' => t("@form form submit button text.", array('@form' => $contact_message['label'])),
          '#default_value' => empty(\Drupal::configFactory()->get('tl_tweaks.settings')->get($key)) ? 'Submit' : \Drupal::configFactory()->get('tl_tweaks.settings')->get($key),
          '#size' => 75,
          '#maxlength' => 75,
          '#description' => t('Specify the submit button text for the @form form.', array('@form' => $contact_message['label'])),
        );
      }
    }
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  /**
   * Custom submit form for tl_tweaks.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::configFactory();
    foreach (entity_get_bundles()['contact_message'] as $key_entity => $contact_message) {
      foreach ($form_state->getValues() as $key => $value) {
        if ($key_entity == $key) {
          $config->getEditable('tl_tweaks.settings')->set($key, $value)->save();
        }
      }
    }
  }

}
