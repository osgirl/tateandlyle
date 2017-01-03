<?php

namespace Drupal\tal_video_gallery\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

/**
 * Class videoGalleryController.
 */
class VideoGalleryController extends ControllerBase {

  /**
   * Constructs a page with descriptive content.
   *
   * Our router maps this method to the path 'video gallery'.
   */
  public function page() {
    $build = [
      '#theme' => 'tal_video_gallery',
      '#categories' => $this->buildVideoGallery(),
    ];

    return $build;
  }

  /**
   * Returns an array of video carousel of all categories.
   */
  private function buildVideoGallery() {
    // Load all terms from media gallery vocabulary.
    $terms = \Drupal::service('entity_type.manager')
      ->getStorage("taxonomy_term")
      ->loadTree('media_gallery');

    // Build video carousel for each category.
    $carousel = [];
    $view = Views::getView('video_gallery');
    $view->setDisplay('video_term_block');

    foreach ($terms as $term) {
      $args = [$term->tid];
      $carousel[] = [
        'name' => $term->name,
        'carousel' => [
          '#type' => 'view',
          '#name' => 'video_gallery',
          '#display_id' => 'video_term_block',
          '#arguments' => $args,
        ],
      ];
    }

    return $carousel;
  }

}
