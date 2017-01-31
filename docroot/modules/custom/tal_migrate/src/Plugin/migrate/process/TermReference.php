<?php

namespace Drupal\tal_migrate\Plugin\migrate\process;

/**
 * @file
 * Contains \Drupal\migrate_plus\Plugin\migrate\process\TermReference.
 */

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateException;
use Drupal\migrate\Row;

/**
 * Looks up a taxonomy term by title.
 *
 * @MigrateProcessPlugin(
 *   id = "term_reference"
 * )
 */
class TermReference extends ProcessPluginBase {

  /**
   * Get the term id for article vocab.
   *
   * @param string $name
   *   Name of the terms in Story description.
   *
   * @return mixed
   *   Returns the term id.
   */
  protected function getTermId($name) {
    $name = trim(strtolower($name));
    if (!empty($name)) {
      if ($name == 'press packs') {
        $query = \Drupal::entityQuery('taxonomy_term');
        $query->condition('vid', "story_category");
        $query->condition('name', "Press Packs");
        $tids = $query->execute();
        $tid = array_values($tids);
        return $tid[0];
      }
      elseif ($name == 'press releases') {
        $query = \Drupal::entityQuery('taxonomy_term');
        $query->condition('vid', "story_category");
        $query->condition('name', "Press Release");
        $tids = $query->execute();
        $tid = array_values($tids);
        return $tid[0];
      }
      else {
        throw new MigrateException(sprintf('%s term does not exists.', var_export($name, TRUE)));
      }

    }
    else {
      throw new MigrateException(sprintf('%s is empty.', var_export($name, TRUE)));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    return $this->getTermId($value);
  }

}
