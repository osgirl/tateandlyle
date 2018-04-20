<?php

namespace Drupal\tal_webinar_gallery\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class WebinarGalleryController.
 */
class WebinarGalleryController extends ControllerBase {

  protected $entityTypeManager;

  /**
   * WebinarGalleryController constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   The EntityTypeManager service.
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Constructs a page with webinar gallary content.
   *
   * @return array
   *   Webinar content grouped by categories.
   */
  public function content() {

    return [
      '#theme' => 'tal_webinar_gallery',
      '#categories' => $this->getCategoriesContent(),
    ];

  }

  /**
   * Get images based on categories.
   *
   * @return array
   *   Returns an array of image carousel of all categories.
   */
  public function getCategoriesContent() {
    $carousel = [];

    // Load all terms from media gallery vocabulary.
    $terms = $this->entityTypeManager
      ->getStorage("taxonomy_term")
      ->loadTree('webinar_category');

    foreach ($terms as $term) {
      $carousel[] = [
        'name' => $term->name,
        'carousel' => [
          '#type' => 'view',
          '#name' => 'webinar_gallery',
          '#display_id' => 'block_1',
          '#arguments' => [$term->tid],
        ],
      ];
    }
    return $carousel;
  }

}
