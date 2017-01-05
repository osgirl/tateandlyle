<?php

namespace Drupal\tal_mega_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides continue search block for search page.
 *
 * @Block(
 *   id = "tal_mega_menu",
 *   admin_label = @Translation("Tal Main Menu"),
 *   category = @Translation("Custom menu block")
 * )
 */
class TalMegaMenu extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /*$build = [
    '#theme' => 'tal_video_gallery',
    '#categories' => $this->buildVideoGallery(),
    '#featured' => $this->buildFeaturedVideoBlock(),
    ];*/
    $block_config = [
      'menu_name' => 'main-menu',
      'depth' => 3,
    ];
    // Get menu tree.
    $tree = tal_mega_menus_build_tree($block_config);
    // Build menu class.
    $build = [
      '#theme' => 'tal_mega_menu',
      '#data' => $this->talBuildSubMenuParent($tree['#items'], 1),
    ];
    $build['#markup'] = '<p>TEST</p>';
    return $build;
  }

  /**
   * Add 'menuparent' class.
   *
   * @param mixed $items
   *   Mixed items vars containing main menu tree.
   *
   * @return mixed
   *   Mixed items vars containing main menu tree.
   */
  public function talBuildSubMenuParent($items, $level) {
    $data['#data'] = [];
    foreach ($items as $k => &$item) {
      if (isset($item['below']) && $item['below']) {
        $item['attributes']->addClass('menuparent');
        $item['#childdata'] = $this->talBuildSubMenuParent($item['below'], ++$level);
        --$level;
      }

      switch ($level) {
        case 1:
          $childdata = isset($item['#childdata']) && $item['#childdata'] ? $item['#childdata'] : '';
          $data['#data'][$k] = [
            '#theme' => 'tal_menu_col_level1',
            '#link' => $item['title'],
            '#level' => $level,
            '#data' => $childdata,
          ];
          break;

        case 2:
          $url = $item['url'];
          $url->setOption('attributes', array('class' => array('focus--title')));
          if ($item['title'] == '<none>') {
            $url->setOption('attributes', array('class' => array('hide')));
          }
          $childdata = isset($item['#childdata']) && $item['#childdata'] ? $item['#childdata'] : '';
          $level2_link = \Drupal::l($item['title'], $item['url']);
          $data['#data'][$k] = [
            '#theme' => 'tal_menu_col_level2',
            '#link' => $level2_link,
            '#level' => $level,
            '#data' => $childdata,
          ];
          break;

        case 3:
          $item_desc = $item['original_link']->getDescription();
          $url = $item['url'];
          $url->setOption('attributes', array('class' => array('focus--title')));
          $level3_link = \Drupal::l($item['title'], $item['url']);
          $data['#data'][$k] = [
            '#theme' => 'tal_menu_col_list_level3',
            '#link' => $level3_link,
            '#desc' => $item_desc,
            '#level' => $level,
          ];
          break;
      }

    }
    if (isset($data['#data'])) {
      return $data['#data'];
    }
    else {
      return '';
    }
  }

}