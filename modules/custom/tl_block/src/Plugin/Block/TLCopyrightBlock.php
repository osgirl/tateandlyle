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
 *   id = "tl_copyright_block",
 *   admin_label = @Translation("Dolcia Copyright"),
 *   category = @Translation("Blocks")
 * )
 */
class TLCopyrightBlock extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    $image_path = base_path() . drupal_get_path('module', 'tl_block') . '/images/tl-footer.png';
    return array(
      '#markup' => '<img src="' . $image_path . '" /><p>© 2016 Tate & Lyle - All rights reserved</p><a href="http://www.tateandlyle.com/pages/termsandconditions.aspx" target="_blank">Terms & Conditions</a><a href="http://www.tateandlyle.com/Pages/Privacy.aspx" target="_blank">Privacy Statement</a>',
    );
  }

}
