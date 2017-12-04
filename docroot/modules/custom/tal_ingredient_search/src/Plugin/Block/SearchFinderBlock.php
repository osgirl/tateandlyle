<?php

namespace Drupal\tal_ingredient_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides continue search block for search page.
 *
 * @Block(
 *   id = "search_finder_block",
 *   admin_label = @Translation("Search Finder Block"),
 *   category = @Translation("Blocks")
 * )
 */
class SearchFinderBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['search_form'] = \Drupal::formBuilder()->getForm('Drupal\tal_ingredient_search\Form\TalSearchfinderForm');

    return $build;
  }

}
