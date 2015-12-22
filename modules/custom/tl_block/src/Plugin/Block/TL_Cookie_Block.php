<?php
/**
 * @file
 * A custom block with Tate & Lyle footer cookie policy link
 */

namespace Drupal\tl_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a custom block with the T&L logo.
 *
 * @Block(
 *   id = "tl_cookie_block",
 *   admin_label = @Translation("Tate & Lyle Cookie link"),
 *   category = @Translation("Blocks")
 * )
 */
class TL_Cookie_Block extends BlockBase {
  public function build() {
    return array('#markup' => t('<a href=":link" target="_blank">This site uses cookies to give you the best experience. By using the site you consent to this. For information and settings click here</a>', array(':link' => 'http://www.tateandlyle.com/Pages/CookiePolicy.aspx')));
  }
}
