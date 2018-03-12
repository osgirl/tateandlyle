<?php
/**
 * Created by PhpStorm.
 * User: pratikkamble
 * Date: 01/03/18
 * Time: 7:51 AM
 */

namespace Drupal\tal_domain_redirect;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;


class TALDomainFileReaderFilter implements IReadFilter {

    public function readCell($column, $row, $worksheetName = '') {
        if (in_array($column,range('A','C'))) {
            return TRUE;
        }
        return FALSE;
    }

}
