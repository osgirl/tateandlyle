<?php

/**
 * @file
 * Definition of \Drupal\youtube_ckeditor\Plugin\CKEditorPlugin\YoutubeCkeditor.
 */

namespace Drupal\youtube_ckeditor\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\Component\Plugin\PluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "YoutubeCkeditor" plugin.
 *
 * @CKEditorPlugin(
 *   id = "youtube",
 *   label = @Translation("YoutubeCkeditor")
 * )
 */
class YoutubeCkeditor extends PluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface {

  /**
   * Implements CKEditorPluginInterface::getDependencies().
   */
  public function getDependencies(Editor $editor) {
    return array();
  }

  /**
   * Implements CKEditorPluginInterface::getLibraries().
   */
  public function getLibraries(Editor $editor) {
    return array();
  }

  /**
   * Implements CKEditorPluginInterface::isInternal().
   */
  public function isInternal() {
    return FALSE;
  }

  /**
   * Implements CKEditorPluginInterface::getFile().
   */
  public function getFile() {
    return drupal_get_path('module', 'youtube_ckeditor') . '/plugins/youtube/plugin.js';
  }

  /**
   * Implements CKEditorPluginButtonsInterface::getButtons().
   */
  public function getButtons() {
    return array(
      'Youtube' => array(
        'label' => t('Youtube Video'),
        'image' => drupal_get_path('module', 'youtube_ckeditor') . '/plugins/youtube/images/icon.png',
      ),
    );
  }

  /**
   * Implements CKEditorPluginInterface::getConfig().
   */
  public function getConfig(Editor $editor) {
    return array();
  }

}
