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
      foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
        $file = $entity->get('field_download_attach_file')->referencedEntities()[$delta];
        $link = $entity->get('field_tal_link')->view('default');
        $gated = $entity->get('field_gated')->value;
        $elements[$delta] = array(
          '#theme' => 'tal_download_link',
          '#file' => $file,
          '#external_download_link' => $link,
          '#gated' => $gated,
          '#id' => $entity->id(),
          '#attributes' => array(
            'class' => 'tal-file-download-link',
          ),
        );
      }
      return $elements;
    }
    elseif ($count > 1) {
      return $this->viewMultiple($items, $langcode);
    }

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
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $filegroup_ids[] = $entity->id();
    }
    $form = \Drupal::formBuilder()->getForm('Drupal\tal_downloads\Form\ChooseLanguage', $filegroup_ids);

    return $form;
  }

}
