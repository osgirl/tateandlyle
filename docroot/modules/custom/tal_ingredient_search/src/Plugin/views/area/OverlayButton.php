<?php

namespace Drupal\tal_ingredient_search\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;
use Drupal\block\Entity\Block;

/**
 * Views area Custom sort order handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("Overlay_button")
 */
class OverlayButton extends AreaPluginBase {

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
    $build['overlay_button']['#prefix'] = '<div class="tal--overlay-button">';
    $build['overlay_button']['#suffix'] = '</div>';
    $build['#theme'] = 'tal_search_result_overlay';

    // Load custom sort option form.
    $build['#blocks']['sortoptions'] = \Drupal::formBuilder()->getForm('Drupal\tal_ingredient_search\Form\IngredientSearchSortForm');

    // Load application facet block.
    $block = Block::load('applicationsonsearchresult');
    $block_content = \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view($block);
    $build['#blocks']['application'] = $block_content;

    // Load trends and solution facet block.
    $block = Block::load('trendssolutionsonsearchresult');
    $block_content = \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view($block);
    $build['#blocks']['trends'] = $block_content;

    // Load types facet block.
    $block = Block::load('typesonsearchresult');
    $block_content = \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view($block);
    $build['#blocks']['type'] = $block_content;

    return $build;
  }

}
