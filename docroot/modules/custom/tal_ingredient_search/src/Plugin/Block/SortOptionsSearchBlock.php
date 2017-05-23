<?php

namespace Drupal\tal_ingredient_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides continue search block for search page.
 *
 * @Block(
 *   id = "search_sort_oprions",
 *   admin_label = @Translation("TAL Search Sort Options"),
 *   category = @Translation("Blocks")
 * )
 */
class SortOptionsSearchBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['sort_by'] = \Drupal::formBuilder()->getForm('Drupal\tal_ingredient_search\Form\IngredientSearchSortForm');

    return $build;
  }

}
