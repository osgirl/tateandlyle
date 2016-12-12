<?php

namespace Drupal\tal_downloads\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\entity_reference_revisions\Plugin\Field\FieldFormatter\EntityReferenceRevisionsEntityFormatter;

/**
 * Plugin implementation of the 'entity reference rendered entity' formatter.
 *
 * @FieldFormatter(
 *   id = "tal_filegroup",
 *   label = @Translation("TAL Filegroup"),
 *   description = @Translation("Display the filegroup paragraphs rendered by entity_view()."),
 *   field_types = {
 *     "entity_reference_revisions"
 *   }
 * )
 */
class TalFileGroupFormatter extends EntityReferenceRevisionsEntityFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $count = $items->count();
    // Render file details directly if only one file is present.
    if ($count == 1) {
      return parent::viewElements($items, $langcode);
    }
    elseif ($count > 1) {
      // @todo: Show dropdown for multiple versions if count > 1.
      return parent::viewElements($items, $langcode);
    }

    return $elements;
  }

  /**
   * Builds a renderable array for field with multiple languages.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field values to be rendered.
   * @param string $langcode
   *   (optional) The language that should be used to render the field. Defaults
   *   to the current content language.
   *
   * @return array
   *   A renderable array for a themed field with its label and all its values.
   */
  private function viewMultiple(FieldItemListInterface $items, $langcode) {
    // @todo: Add code for language revision dropdown.
    return parent::view($items, $langcode);
  }

}
