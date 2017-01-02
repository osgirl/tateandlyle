<?php

namespace Drupal\tal_image_gallery\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

/**
 * Class ImageGalleryController.
 */
class ImageGalleryController extends ControllerBase {

  /**
   * Constructs a page with descriptive content.
   *
   * Our router maps this method to the path 'image-gallery'.
   */
  public function page() {
    $build = [
      '#theme' => 'tal_image_gallery',
      '#categories' => $this->buildImageGallery(),
    ];

    return $build;
  }

  /**
   * Returns an array of image carousel of all categories.
   */
  private function buildImageGallery() {
    // Load all terms from media gallery vocabulary.
    $terms = \Drupal::service('entity_type.manager')
      ->getStorage("taxonomy_term")
      ->loadTree('media_gallery');

    // Build image carousel for each category.
    $carousel = [];
    $view = Views::getView('image_gallery');
    $view->setDisplay('default');

    foreach ($terms as $term) {
      $args = [$term->tid];
      $view->setArguments($args);
      $view->preExecute();
      $view->execute();
      $carousel[] = ['name' => $term->name, 'carousel' => $view->buildRenderable('default')];
    }

    return $carousel;
  }

}
