<?php
/**
 * @file
 * A custom block with Tate & Lyle logo.
 */

namespace Drupal\tl_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L logo.
 *
 * @Block(
 *   id = "tl_block",
 *   admin_label = @Translation("Tate & Lyle Logo"),
 *   category = @Translation("Blocks")
 * )
 */
class TLBlock extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    $image_path = base_path() . drupal_get_path('module', 'tl_block') . '/images/tateandlyle.png';
    return array(
      '#markup' => '<a href="http://www.tateandlyle.com" target="_blank"><img src="' . $image_path . '" /></a>',
    );
  }

}
