<?php
/**
 * @file
 * A custom block with Tate & Lyle Utility Navigation links.
 */

namespace Drupal\tl_block_utility\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a custom block with the T&L Utility Navigation links..
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
    $list = [
      '#theme' => 'links',
      '#attributes' => ['class' => ['utility-navigation']],
      '#links' => [

        'print' => [
          'title' => t('Print Link'),
          'url' => Url::fromUserInput('#'),
        ],

        'email' => [
          'title' => t('Email Link'),
          'url' => Url::fromUri('mailto:'),
        ],

        'contrast' => [
          'title' => t('C'),
          'url' => Url::fromUserInput('#'),
        ],

        'large-text' => [
          'title' => t('Large Text Link'),
          'url' => Url::fromUserInput('#'),
        ],

        'medium-text' => [
          'title' => t('Medium Text Link'),
          'url' => Url::fromUserInput('#'),
        ],

        'small-text' => [
          'title' => t('Small Text Link'),
          'url' => Url::fromUserInput('#'),
        ],

      ],
    ];

    return array(
      '#attached' => array(
        'library' => array(
          'tl_block_utility/tl_block_utility',
        ),
      ),
      '#markup' => render($list),
    );
  }

}
