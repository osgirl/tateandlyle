<?php

namespace Drupal\tal_video_gallery\Controller;

use Drupal\Core\Controller\ControllerBase;

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
      '#featured' => $this->buildFeaturedVideoBlock(),
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
    foreach ($terms as $term) {
      $args = [$term->tid];
      if ($term->name != 'Featured') {
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
    }
    return $carousel;
  }

  /**
   * Returns promoted video and featured video blocks.
   */
  private function buildFeaturedVideoBlock() {
    // Render array.
    $build = [];
    $build['promoted_video'] = [
      '#type' => 'view',
      '#name' => 'video_gallery',
      '#display_id' => 'promoted_video_block',
    ];
    $build['promoted_video']['#prefix'] = '<div class="tal--promoted-image video">';
    $build['promoted_video']['#suffix'] = '</div>';

    $build['featured_videos'] = [
      '#type' => 'view',
      '#name' => 'video_gallery',
      '#display_id' => 'featured_video_block',
    ];
    $build['featured_videos']['#prefix'] = '<div class="tal--featured-image video">';
    $build['featured_videos']['#suffix'] = '</div>';
    $build['#prefix'] = '<div class="tal--image-gallery-featured-block-wrapper">';
    $build['#suffix'] = '</div>';

    return $build;
  }

}
