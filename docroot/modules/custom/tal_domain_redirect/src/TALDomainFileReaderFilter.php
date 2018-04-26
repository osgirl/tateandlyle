<?php

namespace Drupal\tal_domain_redirect;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

/**
 * Provides filter fo phpspreadsheet.
 */
class TALDomainFileReaderFilter implements IReadFilter {

  /**
   * {@inheritdoc}
   */
  public function readCell($column, $row, $worksheetName = '') {

    if (in_array($column, range('A', 'B'))) {
      return TRUE;
    }
    return FALSE;
  }

}
