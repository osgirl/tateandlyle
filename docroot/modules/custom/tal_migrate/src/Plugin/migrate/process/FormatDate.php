<?php

namespace Drupal\tal_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateException;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Returns the formatted date.
 *
 * @MigrateProcessPlugin(
 *   id = "format_date"
 * )
 */
class FormatDate extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   *
   * Returns the formatted string.
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (isset($value) && !empty($value)) {
      $date = DrupalDateTime::createFromFormat($this->configuration['from_format'], $value);
      return $date->format($this->configuration['to_format']);
    }
    else {
      throw new MigrateException(sprintf('%s is empty.', var_export($value, TRUE)));
    }
  }

}
