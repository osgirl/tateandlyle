<?php
/**
 * @file
 * A custom block with Tate & Lyle Utility Navigation links.
 */

namespace Drupal\tl_block_utility\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L logo.
 *
 * @Block(
 *   id = "tl_utility_block",
 *   admin_label = @Translation("Tate & Lyle Utility Navigation"),
 *   category = @Translation("Blocks")
 * )
 */
class TLUtilityBlock extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    return array(
      '#attached' => array(
        'library' => array(
          'tl_block_utility/tl_block_utility',
        ),
      ),
      '#markup' => '<div id="utilitynavigation">
                      <ul class="utility-navigation">
                        <li class="print"><a title="Print" href="#"></a></li>
                        <li class="email"><a title="Email" href="mailto:"></a></li>
                        <li class="contrast"><a title="High-contrast version" href="#">C</a></li>
                        <li class="large-text"><a title="Large text size" onclick="" href="#"></a></li>
                        <li class="medium-text"><a title="Medium text size" onclick="" href="#"></a></li>
                        <li class="small-text"><a title="Small text size" onclick="" href="#"></a></li>
                      </ul>
                    </div>',
    );
  }

}
