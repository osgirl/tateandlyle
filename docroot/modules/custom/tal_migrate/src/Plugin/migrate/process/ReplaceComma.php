<?php

namespace Drupal\tal_migrate\Plugin\migrate\process;

/**
 * @file
 * Contains \Drupal\migrate_plus\Plugin\migrate\process\ReplaceComma.
 */

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Looks up a taxonomy term by title.
 *
 * @MigrateProcessPlugin(
 *   id = "replace_comma"
 * )
 */
class ReplaceComma extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $name = trim($value);
    if (!empty($name)) {
      $name = str_replace('__*__', ',', $name);
    }
    return $name;
  }

}
