<?php

namespace Drupal\tal_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateException;

/**
 * Returns the formatted date.
 *
 * @MigrateProcessPlugin(
 *   id = "press_release_status"
 * )
 */
class PressReleaseStatus extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   *
   * Returns the formatted string.
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (isset($value) && !empty($value)) {
      if ($value == 'Embargoed') {
        return ($this->configuration['wmoderation'] == 'yes') ? 'draft' : 0;
      }
      else {
        return ($this->configuration['wmoderation'] == 'yes') ? 'published' : 1;
      }
    }
    else {
      throw new MigrateException(sprintf('%s is empty.', var_export($value, TRUE)));
    }
  }

}
