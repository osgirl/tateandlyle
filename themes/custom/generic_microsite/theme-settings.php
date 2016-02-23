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
  define('CSS7', 7);
  define('FRONTPAGE_ONECOLUMN', 1);
  define('FRONTPAGE_TWOCOLUMN', 2);

  $form['style'] = array(
    '#type' => 'details',
    '#title' => t('Advanced style settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['style']['global_style'] = array(
    '#type' => 'radios',
    '#title' => t('Global style sheet'),
    '#default_value' => empty(theme_get_setting('global_style')) ? '1' : theme_get_setting('global_style'),
    '#options' => array(
      constant('CSS1') => t('Blue Dark'),
      constant('CSS2') => t('Blue Light'),
      constant('CSS3') => t('Green Dark'),
      constant('CSS4') => t('Green Light'),
      constant('CSS7') => t('Orange Dark'),
      constant('CSS5') => t('Orange Light'),
      constant('CSS6') => t('Purple'),
    ),
    '#description' => t('Specify the global stylesheet you wish to use for the site.'),
  );

  $form['style']['frontpage_template'] = array(
    '#type' => 'radios',
    '#title' => t('Frontpage template'),
    '#default_value' => empty(theme_get_setting('frontpage_template')) ? '1' : theme_get_setting('frontpage_template'),
    '#options' => array(
      constant('FRONTPAGE_ONECOLUMN') => t('One column.'),
      constant('FRONTPAGE_TWOCOLUMN') => t('Two columns.'),
    ),
    '#description' => t('Specify the frontpage template you wish to use for the site.'),
  );

  $form['style']['bg_value1'] = array(
    '#type' => 'textfield',
    '#title' => t('Primary background color'),
    '#default_value' => empty(theme_get_setting('bg_value1')) ? '#b5cbe6' : theme_get_setting('bg_value1'),
    '#size' => 7,
    '#maxlength' => 7,
    '#description' => t('Specify the first background color for the site - default: #b5cbe6.'),
  );

  $form['style']['bg_value2'] = array(
    '#type' => 'textfield',
    '#title' => t('Secondary background color'),
    '#default_value' => empty(theme_get_setting('bg_value2')) ? '' : theme_get_setting('bg_value2'),
    '#size' => 7,
    '#maxlength' => 7,
    '#description' => t('Specify the second background color for the site (gradient) - default: #ffffff.'),
  );

  $form['style']['custom_css'] = array(
    '#type' => 'textarea',
    '#title' => t('Custom CSS'),
    '#default_value' => theme_get_setting('custom_css'),
    '#description' => t('Specify custom CSS.'),
  );

  $languages = \Drupal::languageManager()->getLanguages($flags = 1);
  $default_language = \Drupal::languageManager()->getDefaultLanguage()->getId();
  foreach ($languages as $language) {
    if ($language->getId() != $default_language) {
      $fid = theme_get_setting('logo_image_' . $language->getId());
      if ($fid) {
        $file = File::load($fid);
        if ($file) {
          $file_uri = $file->getFileUri();
          $image = '<img src="' . ImageStyle::load('medium')->buildUrl($file_uri) . '" /><br />';
        }
      }
      else {
        $image = "";
      }
      $form['style']['logo_image_' . $language->getId()] = array(
        '#type' => 'file',
        '#title' => t('Upload @language logo', array('@language' => $language->getName())),
        '#size' => 40,
        '#attributes' => array('enctype' => 'multipart/form-data'),
        '#default_value' => theme_get_setting('logo_image_' . $language->getId()),
        '#description' => t('Use this field to upload your @language logo image. Uploads limited to .png .gif .jpg .jpeg .apng .svg extensions', array('@language' => $language->getName())),
        '#element_validate' => array('generic_microsite_logo_validate'),
        '#suffix' => $image,
      );
    }
  }

  $form['style']['logo_redirect'] = array(
    '#type' => 'textfield',
    '#title' => t('Logo redirect path'),
    '#default_value' => empty(theme_get_setting('logo_redirect')) ? '' : theme_get_setting('logo_redirect'),
    '#size' => 100,
    '#maxlength' => 100,
    '#description' => t('Specify the path you wish to redirect to when you ckicl on the logo.'),
  );

}

/**
 * Check and save the uploaded logo image.
 */
function generic_microsite_logo_validate($element, FormStateInterface $form_state) {
  global $base_url;
  $languages = \Drupal::languageManager()->getLanguages($flags = 1);
  foreach ($languages as $language) {
    $validators = array('file_validate_extensions' => array('png gif jpg jpeg apng svg'));
    $file = file_save_upload('logo_image_' . $language->getId(), $validators, "public://", NULL, FILE_EXISTS_REPLACE);
    if (!empty($file)) {
      if ((is_object($file[0]) == 1)) {
        $file[0]->status = FILE_STATUS_PERMANENT;
        $file[0]->save();
        $uri = $file[0]->getFileUri();
        $file_url = file_create_url($uri);
        $file_url = str_ireplace($base_url, '', $file_url);
        $form_state->setValue('logo_image_' . $language->getId(), $file[0]->id());
      }
    }
  }
}
