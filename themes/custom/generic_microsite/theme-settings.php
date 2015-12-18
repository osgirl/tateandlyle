<?php

/**
 * @file
 * Custom theme settings for the Generic Microsites sub-theme.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * Custom theme settings.
 */
function generic_microsite_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
  define('CSS1', 1);
  define('CSS2', 2);
  define('CSS3', 3);
  define('CSS4', 4);
  define('CSS5', 5);
  define('CSS6', 6);
  define('FRONTPAGE_ONECOLUMN', 1);
  define('FRONTPAGE_TWOCOLUMN', 2);
  $fid = theme_get_setting('bg_image');

  if ($fid) {
    $file = File::load($fid);
    $file_uri = $file->getFileUri();
    $image = '<img src="' . ImageStyle::load('medium')->buildUrl($file_uri) . '" /><br />';
  }
  else {
    $image = "";
  }

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
      constant('CSS1') => t('Global Style Sheet 1.'),
      constant('CSS2') => t('Global Style Sheet 2.'),
      constant('CSS3') => t('Global Style Sheet 3.'),
      constant('CSS4') => t('Global Style Sheet 4.'),
      constant('CSS5') => t('Global Style Sheet 5.'),
      constant('CSS6') => t('Global Style Sheet 6.'),
    ),
  );

  $form['style']['frontpage_template'] = array(
    '#type' => 'radios',
    '#title' => t('Frontpage template'),
    '#default_value' => theme_get_setting('frontpage_template'),
    '#options' => array(
      constant('FRONTPAGE_ONECOLUMN') => t('One column.'),
      constant('FRONTPAGE_TWOCOLUMN') => t('Two columns.'),
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
    '#suffix' => $image,
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
      $form_state->setValue('bg_image', $file[0]->id());
    }
  }
}
