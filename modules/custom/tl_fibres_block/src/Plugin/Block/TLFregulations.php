<?php
/**
 * @file
 * A custom block with Tate & Lyle Fibres Regulations.
 */

namespace Drupal\tl_fibres_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L Fibres Regulations.
 *
 * @Block(
 *   id = "regulationallrightsblock",
 *   admin_label = @Translation("Tate & Lyle Fibres Regulations block"),
 *   category = @Translation("Custom")
 * )
 */
class TLFregulations extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    return array(
      '#markup' => t('<p>Regulations on claims and labeling vary by country, please consult your Regulatory department.</p><p>© 2016 Tate &amp; Lyle - All rights reserved</p>'),
    );
  }

}
