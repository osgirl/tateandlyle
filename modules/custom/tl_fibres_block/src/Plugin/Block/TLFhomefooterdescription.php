<?php
/**
 * @file
 * A custom block with Tate & Lyle home footer description.
 */

namespace Drupal\tl_fibres_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L Fibres home footer description.
 *
 * @Block(
 *   id = "homefooterdescription",
 *   admin_label = @Translation("Tate & Lyle Fibres Home Footer Description"),
 *   category = @Translation("Blocks")
 * )
 */
class TLFhomefooterdescription extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
    return array(
      '#markup' => t('<p>*Up to 65 grams of PROMITOR® Soluble Fibre per day is well tolerated; this is more than twice the daily amount of inulin that is typically well tolerated amongst generally healthy adults: Housez B et al., ‘Evaluation of digestive tolerance of a soluble corn fibre’,&nbsp;<em>J Hum Nutr Diet</em>&nbsp;2012, 25:488. Grabitske HA, Slavin JL: ‘Gastrointestinal effects of low-digestible carbohydrates’,&nbsp;<em>Crit Rev Food Sci Nutr</em>&nbsp;2009, 49:327.<br />**Amongst leading oat beta glucan suppliers.</p>'),
    );
  }

}
