<?php
/**
 * @file
 * A custom block with Tate & Lyle footer cookie policy link.
 */

namespace Drupal\tl_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L logo.
 *
 * @Block(
 *   id = "tl_advisory_block",
 *   admin_label = @Translation("Tate & Lyle Prospective purchasers Advisory"),
 *   category = @Translation("Blocks")
 * )
 */
class TLAdvisoryBlock extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    return array(
      '#markup' => t('Prospective purchasers are advised to conduct their own tests, studies, and regulatory review to determine the fitness of Tate & Lyle products for their particular purposes,
product claims, ‘natural’ claims or specifications.'),
    );
  }

}
