<?php

namespace Drupal\tal_ingredient_search\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Views area Custom sort order handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("sortorder")
 */
class SortOptions extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    $build = [];
    $build['sort_by'] = \Drupal::formBuilder()->getForm('Drupal\tal_ingredient_search\Form\IngredientSearchSortForm');
    $build['sort_by']['#prefix'] = '<div class="tal--sortorder">';
    $build['sort_by']['#suffix'] = '</div>';

    return $build;
  }

}
