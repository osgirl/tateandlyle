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
      '#featured' => $this->buildFeaturedImagesBlock(),
    ];
    $build['#attached']['library'][] = 'tal_image_gallery/tal_image_gallery_download_image';
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

    foreach ($terms as $term) {
      $args = [$term->tid];
      if ($term->name != 'Featured') {
        $carousel[] = [
          'name' => $term->name,
          'carousel' => [
            '#type' => 'view',
            '#name' => 'image_gallery',
            '#display_id' => 'default',
            '#arguments' => $args,
          ],
        ];
      }
    }

    return $carousel;
  }

  /**
   * Returns promoted image and featured image blocks.
   */
  private function buildFeaturedImagesBlock() {
    // Render array.
    $build = [];
    // Generate Promoted image block.
    $view = Views::getView('image_gallery');
    $view->setDisplay('block');
    $view->preExecute();
    $view->execute();

    $build['promoted_image'] = $view->buildRenderable('block');
    $build['promoted_image']['#prefix'] = '<div class="tal--promoted-image">';
    $build['promoted_image']['#suffix'] = '</div>';

    // Generate featured images block.
    $view = Views::getView('image_gallery');
    $view->setDisplay('block_1');
    $view->preExecute();
    $view->execute();

    $build['featured_images'] = $view->buildRenderable('block_1');
    $build['featured_images']['#prefix'] = '<div class="tal--featured-image">';
    $build['featured_images']['#suffix'] = '</div>';
    $build['#prefix'] = '<div class="tal--image-gallery-featured-block-wrapper">';
    $build['#suffix'] = '</div>';

    return $build;
  }

}
