<?php

namespace Drupal\tal_downloads\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\entity_reference_revisions\Plugin\Field\FieldFormatter\EntityReferenceRevisionsEntityFormatter;

/**
 * Plugin implementation of the 'entity reference rendered entity' formatter.
 *
 * @FieldFormatter(
 *   id = "tal_sap_downloads",
 *   label = @Translation("TAL SAP Downloads"),
 *   description = @Translation("Display the customized entity view for SAP Downloads."),
 *   field_types = {
 *     "entity_reference_revisions"
 *   }
 * )
 */
class TalSAPDownloadsFormatter extends EntityReferenceRevisionsEntityFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $count = $items->count();
    if ($count >= 1) {
      foreach ($this->getEntitiesToView($items, $langcode) as $key => $entity) {
        $delta = 0;
        $type = array();
        $sds_file = '';
        $spec_file = '';
        $product_file = '';
        $id = $entity->id();
        $sds = $entity->get('field_sap_sds_file')->referencedEntities();
        $gated = $entity->get('field_gated')->value;
        if (isset($sds[$delta])) {
          $sds_file = $sds[$delta];
          $type['sds_file_' . $id] = $this->t('SDS File');
        }
        $spec = $entity->get('field_sap_spec_sheet')->referencedEntities();
        if (isset($spec[$delta])) {
          $spec_file = $spec[$delta];
          $type['spec_file_' . $id] = $this->t('Spec Sheet');
        }
        $product = $entity->get('field_product_info_sheet')->referencedEntities();
        if (isset($product[$delta])) {
          $product_file = $product[$delta];
          $type['product_file_' . $id] = $this->t('Product Info Sheet');
        }
        $title = $entity->get('field_sap_title')->view('default');
        $summary = $entity->get('field_sap_summary')->view('default');
        $elements[$key] = array(
          '#theme' => 'tal_sap_download_link',
          '#title' => $title,
          '#summary' => $summary,
          '#file_type' => $type,
          '#gated' => $gated,
          '#file_entity' => array(
            'sds_file' => $sds_file,
            'spec_file' => $spec_file,
            'product_file' => $product_file,
          ),
          '#para_id' => $entity->id(),
        );
      }
      return $elements;
    }
    return array();
  }

}
