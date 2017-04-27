<?php

namespace Drupal\tal_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use \Drupal\paragraphs\Entity\Paragraph;

/**
 * It saves D6 Article Body field to D8 Article Paragraph (Textarea) field.
 *
 * @MigrateProcessPlugin(
 *   id = "formatted_textarea"
 * )
 */
class FormattedTextarea extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $ppt_values = array(
      'id' => NULL,
      'type' => $this->configuration['paragraph_name'],
      $this->configuration['field'] => array('value' => $value, 'format' => 'advanced_rich_text'),
    );
    $ppt_paragraph = Paragraph::create($ppt_values);
    $ppt_paragraph->save();

    $target_id_dest = $ppt_paragraph->Id();
    $target_revision_id_dest = $ppt_paragraph->getRevisionId();
    $paragraphs = array('0' => $target_id_dest, '1' => $target_revision_id_dest);
    return $paragraphs;
  }

}
