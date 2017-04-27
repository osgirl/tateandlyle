<?php

namespace Drupal\tal_admin_config\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'tal_text_trimmed' formatter.
 *
 * @see \Drupal\text\Field\Formatter\TextSummaryOrTrimmedFormatter
 *
 * @FieldFormatter(
 *   id = "tal_text_trimmed",
 *   label = @Translation("Trimmed Plain Text"),
 *   field_types = {
 *     "string_long",
 *   },
 *   quickedit = {
 *     "editor" = "form"
 *   }
 * )
 */
class TrimTextStringFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array('trim_length' => '600') + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['trim_length'] = array(
      '#title' => t('Trimmed limit'),
      '#type' => 'number',
      '#field_suffix' => t('characters'),
      '#default_value' => $this->getSetting('trim_length'),
      '#description' => t('If the summary is not set, the trimmed %label field will end at the last full sentence before this character limit.', array('%label' => $this->fieldDefinition->getLabel())),
      '#min' => 1,
      '#required' => TRUE,
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();
    $summary[] = t('Trimmed limit: @trim_length characters', array('@trim_length' => $this->getSetting('trim_length')));
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    foreach ($items as $delta => $item) {
      $view_value = $this->viewValue($item);
      $elements[$delta] = $view_value;
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return array
   *   The textual output generated as a render array.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return [
      '#type' => 'inline_template',
      '#template' => '{{ value|nl2br }}',
      '#context' => [
        'value' => text_summary(
          $item->value, NULL, $this->getSetting('trim_length')
        ),
      ],
    ];
  }

}
