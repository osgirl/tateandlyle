<?php

namespace Drupal\tal_articles\Plugin\views\area;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\area\AreaPluginBase;

/**
 * Views area Custom sort order handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("searchfilter")
 */
class SearchFilter extends AreaPluginBase {

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
    $build['search_filter'] = \Drupal::formBuilder()->getForm('Drupal\tal_articles\Form\ArticleSearchFilterForm');
    $build['sort_by']['#prefix'] = '<div class="tal--article-search">';
    $build['sort_by']['#suffix'] = '</div>';

    return $build;
  }

}
