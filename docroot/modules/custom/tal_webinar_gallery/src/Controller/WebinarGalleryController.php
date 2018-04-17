<?php

namespace Drupal\tal_webinar_gallery\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class WebinarGalleryController.
 */
class WebinarGalleryController extends ControllerBase {

  /**
   * Constructs a page with webinar gallary content.
   */
  public function content() {

    $build = [
      '#theme' => 'tal_webinar_gallery',
      '#categories' => $this->getCategoriesContent(),
    ];

    return $build;
  }

  /**
   * Returns an array of image carousel of all categories.
   */
  public function getCategoriesContent() {
    $carousel = [];

    // Load all terms from media gallery vocabulary.
    $terms = \Drupal::service('entity_type.manager')
      ->getStorage("taxonomy_term")
      ->loadTree('webinar_category');

    foreach ($terms as $term) {
      $termIds = [$term->tid];
      $carousel[] = [
        'name' => $term->name,
        'carousel' => [
          '#type' => 'view',
          '#name' => 'webinar_gallery',
          '#display_id' => 'block_1',
          '#arguments' => $termIds,
        ],
      ];
    }
    return $carousel;
  }

}
