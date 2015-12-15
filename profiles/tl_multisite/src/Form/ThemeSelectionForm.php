<?php
/**
 * @file
 * Contains \Drupal\tl_multisite\Form\ThemeSelectionForm.
 */

namespace Drupal\tl_multisite\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements custom config form for tl_multisite.
 */
class ThemeSelectionForm extends FormBase {

  /**
   * Custom config form for tl_multisite.
   */
  public function getFormId() {
    return 'custom_config_form';
  }

  /**
   * Custom config form for tl_multisite.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $themesdir = 'themes/custom';
    $themes = scandir($themesdir);
    $themes_list = array();
    foreach ($themes as $theme) {
      if ($theme != "." && $theme != ".." && !is_file($theme)) {
        $themedir = 'themes/custom/' . $theme;
        if (file_exists($themedir . "/" . $theme . '.theme')) {
          $themes_list[$theme] = $theme;
        }
      }
    }
    $form['theme_list'] = array(
      '#type' => 'select',
      '#title' => t('Select frontend theme'),
      '#options' => $themes_list,
      '#default_value' => 0,
      '#description' => t('Set the frontend theme for your site.'),
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  /**
   * Submit for the custom config form for tl_multisite.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Custom submit handler code.
    \Drupal::service('theme_installer')->install(array($form_state->getValue('theme_list')), $install_dependencies = TRUE);
    $config = \Drupal::configFactory()->getEditable('system.theme');
    $config->set('default', $form_state->getValue('theme_list'));
    $config->save();
  }

}
