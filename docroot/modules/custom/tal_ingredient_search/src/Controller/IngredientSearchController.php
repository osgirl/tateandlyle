<?php

namespace Drupal\tal_ingredient_search\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\views\Views;

/**
 * Class IngredientSearchController.
 */
class IngredientSearchController extends ControllerBase {

  /**
   * Constructs a page with descriptive content.
   *
   * Our router maps this method to the path 'search/ingredients'.
   */
  public function page() {
    // Load ingredient search form.
    $view = Views::getView('ingredient_finder');
    $view->setDisplay('page_1');

    $output = $this->t('<p>Our extraordinary ingredients are a product of scientific and technical expertise, meticulous research and innovation and listening to and working with our customers.</p>');

    // Assemble the markup.
    $build = array(
      'summary' => array(
        '#markup' => $output,
        '#prefix' => '<div class="page--tal-ingredient-finder-summary">',
        '#suffix' => '</div>',
      ),
      'search_form' => $view->display_handler->viewExposedFormBlocks(),
      'facet' => array(
        '#markup' => $this->t('<h2>Or browse by category</h2>'),
        '#prefix' => '<div class="tal-category-facet-title">',
        '#suffix' => '</div>',
      ),
    );

    return $build;
  }

  /**
   * This is the helper function for nodeCountState() to get the count.
   *
   * Of the published or unpublished content of particular content type.
   *
   * @param bool $status
   *   Node status.
   * @param string $type
   *   Machine name of the content type.
   *
   * @return numeric
   *   Returns the count of node published or unpublished in the Content Type.
   */
  public static function nodeCountState($status, $type) {
    $query = \Drupal::entityQuery('node')
      ->condition('status', $status)
      ->condition('type', $type);
    $result = $query->count()->execute();
    return $result;
  }

}
