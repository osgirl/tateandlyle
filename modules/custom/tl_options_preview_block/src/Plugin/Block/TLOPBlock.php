<?php
/**
 * @file
 * A custom block for Tate & Lyle Options Preview functionality.
 */

namespace Drupal\tl_options_preview_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Component\Utility\Html;

/**
 * Provides a custom block with the T&L Options Preview functionality.
 *
 * @Block(
 *   id = "tl_options_preview_block",
 *   admin_label = @Translation("Tate & Lyle Options Preview Block"),
 *   category = @Translation("Blocks")
 * )
 */
class TLOPBlock extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    if (isset($_POST['field_identifier'])) {
      $content = "<ul>";
      foreach ($_POST['field_identifier'] as $id) {
        $option = explode(" | ", Html::escape($id));
        $content .= "<li>" . $option[1] . "</li>";
      }
      $content .= "</ul>";
    }
    return [
      '#theme' => 'tl_options_preview_block',
      '#title' => [],
      '#content' => $content,
      '#tab' => Html::escape($_GET['tab']),
      '#attributes' => [],
    ];
  }

}
