<?php
/**
 * @file
 * A custom block with Tate & Lyle Fibres Contact Header.
 */

namespace Drupal\tl_fibres_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L Fibres Contact Header.
 *
 * @Block(
 *   id = "contactheader",
 *   admin_label = @Translation("Tate & Lyle Fibres Contact Header block"),
 *   category = @Translation("Custom")
 * )
 */
class TLFcontactheader extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    return array(
      '#markup' => t('<h2>Set up an interview with our media relations team</h2><p><a href="/contact-us">Contact us now</a></p>'),
    );
  }

}
