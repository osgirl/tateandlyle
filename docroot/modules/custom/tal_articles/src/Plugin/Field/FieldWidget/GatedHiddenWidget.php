<?php

namespace Drupal\tal_articles\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Plugin\Field\FieldWidget\InlineParagraphsWidget;

/**
 * Plugin implementation of the 'entity_reference paragraphs' widget.
 *
 * We hide add / remove buttons when translating to avoid accidental loss of
 * data because these actions effect all languages.
 *
 * @FieldWidget(
 *   id = "gated_hidden_widget",
 *   label = @Translation("Gated Hidden Widget"),
 *   description = @Translation("A paragraphs inline form widget."),
 *   field_types = {
 *     "entity_reference_revisions"
 *   }
 * )
 */
class GatedHiddenWidget extends InlineParagraphsWidget {

  /**
   * {@inheritdoc}
   *
   * @see \Drupal\content_translation\Controller\ContentTranslationController::prepareTranslation()
   *   Uses a similar approach to populate a new translation.
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $build_info = $form_state->getBuildInfo();
    if (in_array($build_info['form_id'], array(
      'node_press_release_form',
      'node_company_story_form',
      'node_company_story_edit_form',
      'node_press_release_edit_form',
    ))) {
      if (isset($element['subform']['field_gated'])) {
        $element['subform']['field_gated']['#access'] = FALSE;
      }
    }
    return $element;
  }

}
