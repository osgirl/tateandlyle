<?php
/**
 * @file
 * Custom theme settings for the Generic Microsites sub-theme.
 */

use Drupal\Core\Url;

/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * Custom theme settings.
 */
function generic_microsite_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {

  $form['style'] = array(
    '#type' => 'details',
    '#title' => t('Advanced style settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['style']['global_style'] = array(
    '#type' => 'radios',
    '#title' => t('Global style sheet'),
    '#default_value' => theme_get_setting('global_style'),
    '#options' => array(
      1 => t('Global Style Sheet 1.'),
      2 => t('Global Style Sheet 2.'),
      3 => t('Global Style Sheet 3.'),
      4 => t('Global Style Sheet 4.'),
      5 => t('Global Style Sheet 5.'),
      6 => t('Global Style Sheet 6.'),
    ),
  );

  $form['style']['frontpage_template'] = array(
    '#type' => 'radios',
    '#title' => t('Frontpage template'),
    '#default_value' => theme_get_setting('frontpage_template'),
    '#options' => array(
      1 => t('One column.'),
      2 => t('Two columns.'),
    ),
  );

  $form['style']['bg_value'] = array(
    '#type' => 'textfield',
    '#title' => t('Background color'),
    '#default_value' => theme_get_setting('bg_value'),
    '#size' => 6,
    '#maxlength' => 6,
    '#description' => t('Specify the background color for the site.'),
  );

  $form['style']['bg_image'] = array(
    '#type' => 'file',
    '#title' => t('Upload background image'),
    '#size' => 40,
    '#attributes' => array('enctype' => 'multipart/form-data'),
    '#default_value' => theme_get_setting('bg_image'),
    '#description' => t('Use this field to upload your background image. Uploads limited to .png .gif .jpg .jpeg .apng .svg extensions'),
    '#element_validate' => array('generic_microsite_bg_validate'),
    '#suffix' => '<img width="250px" src="' . Url::fromUri('base:' . theme_get_setting('bg_image'))->toString() . '" /><br />',
  );

  $form['style']['custom_css'] = array(
    '#type' => 'textarea',
    '#title' => t('Custom CSS'),
    '#default_value' => theme_get_setting('custom_css'),
    '#description' => t('Specify the background color for the site.'),
  );
}

/**
 * Check and save the uploaded background image.
 */
function generic_microsite_bg_validate($element, FormStateInterface $form_state) {
  global $base_url;

  $validators = array('file_validate_extensions' => array('png gif jpg jpeg apng svg'));
  $file = file_save_upload('bg_image', $validators, "public://", NULL, FILE_EXISTS_REPLACE);

  if (!empty($file)) {
    if ((is_object($file[0]) == 1)) {
      $file[0]->status = FILE_STATUS_PERMANENT;
      $file[0]->save();
      $uri = $file[0]->getFileUri();
      $file_url = file_create_url($uri);
      $file_url = str_ireplace($base_url, '', $file_url);
      $form_state->setValue('bg_image', $file_url);
    }
  }
}
