<?php

/**
 * @file
 * Custom theme settings for the Tateandlylefibres sub-theme.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * Custom theme settings.
 */
function tateandlylefibres_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {

  $form['style'] = array(
    '#type' => 'details',
    '#title' => t('Advanced style settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['style']['bg_value'] = array(
    '#type' => 'textfield',
    '#title' => t('Primary background color'),
    '#default_value' => empty(theme_get_setting('bg_value')) ? '#ffffff' : theme_get_setting('bg_value'),
    '#size' => 7,
    '#maxlength' => 7,
    '#description' => t('Specify the primary background color for the site .'),
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
        '#element_validate' => array('tateandlylefibres_logo_validate'),
        '#suffix' => $image,
      );
    }
  }

}

/**
 * Check and save the uploaded logo image.
 */
function tateandlylefibres_logo_validate($element, FormStateInterface $form_state) {
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
