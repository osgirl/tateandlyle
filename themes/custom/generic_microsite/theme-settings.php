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
    '#default_value' => empty(theme_get_setting('global_style')) ? '1' : theme_get_setting('global_style'),
    '#options' => array(
      constant('CSS1') => t('Blue Dark'),
      constant('CSS2') => t('Blue Light'),
      constant('CSS3') => t('Green Dark'),
      constant('CSS4') => t('Green Light'),
      constant('CSS5') => t('Orange'),
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
}
