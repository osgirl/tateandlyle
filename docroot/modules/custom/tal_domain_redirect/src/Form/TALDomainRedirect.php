<?php

namespace Drupal\tal_domain_redirect\Form;

use Drupal\tal_domain_redirect\TALDomainFileReaderFilter;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Provides form for uploading file containing redirect URLs.
 */
class TALDomainRedirect extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'resume_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['import_file'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload File'),
      '#description' => $this->t("Upload the file to import redirect URLs. Maximum Upload size is 10MB. Allowed extensions are csv and xlsx."),
      '#multiple' => FALSE,
      '#upload_validators' => [
        'file_validate_extensions' => array('xlsx'),
        'file_validate_size' => array(100 * 1024 * 10),
      ],
    ];
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );
    return $form;
  }

  /**
   * Final submit handler.
   *
   * Updates Domain redirect Config.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $uploaded_excel = $form_state->getValue('import_file');
    // Load the file by its fid.
    $file = File::load($uploaded_excel[0]);
    // Make the status of the file as permanent.
    $file->setPermanent();
    // Save the file in the database.
    $file->save();
    $file_uri = $file->getFileUri();
    // Read the content and convert it into array.
    $fileData = $this->readFile($file_uri);
    if (!empty($fileData)) {
      // Remove invalid/empty rows.
      $fileData = $this->removeEmptyOrInvalidRows($fileData);
      $configData = $this->getDomainRedirectConfigData();
      if (!empty($fileData)) {
        $this->mergeFileAndConfigData($fileData, $configData);
      }
      else {
        drupal_set_message("Uploaded file does not contain any valid data.", 'warning');
      }
    }
    else {
      drupal_set_message("Uploaded file does not contains any data.", 'warning');
    }
  }

  /**
   * Read the the content of file and convert them into the array.
   *
   * @param string $path
   *   Path of the file.
   *
   * @return array
   *   Content of the file.
   */
  public function readFile($path) {
    $rows = array();
    $stream_wrapper_manager = \Drupal::service('stream_wrapper_manager')->getViaUri($path);
    // Get absolute path of the excel sheet.
    $file_path = $stream_wrapper_manager->realpath();

    $reader = IOFactory::createReader("Xlsx");
    // Add filter to remove data after 3rd column.
    $reader->setReadFilter(new TALDomainFileReaderFilter());
    $spreadsheet = $reader->load($file_path);
    if (isset($spreadsheet)) {
      // Convert data to array.
      $rows = $spreadsheet->getActiveSheet()->toArray(NULL, TRUE, TRUE, TRUE);
      array_shift($rows);
    }
    return $rows;
  }

  /**
   * Get existing Redirect Domain configuration.
   */
  public function getDomainRedirectConfigData() {
    $config = \Drupal::config('redirect_domain.domains');
    $domain_redirects = $config->get('domain_redirects');
    return $domain_redirects;

  }

  /**
   * Removes invalid/empty rows.
   */
  public function removeEmptyOrInvalidRows($rows) {
    $data = [];
    $count = 2;
    foreach ($rows as $row) {
      array_splice($row, 3);
      if (!empty($row['A']) && !empty($row['C'])) {
        if (strpos($row['A'], '://') !== FALSE) {
          drupal_set_message("Row " . $count . " from spreadsheet is invalid. No protocol should be included in the redirect domain.", 'error');
        }
        else {
          $data[] = $row;
        }

      }
      else {
        drupal_set_message("Row " . $count . " from spreadsheet is invalid. Domain or Redirect path can not be empty.", 'error');
      }
    }

    return $data;
  }

  /**
   * Update/Add the domain redirects configuration.
   */
  public function mergeFileAndConfigData($fileData, $domainRedirects) {
    $newRedirectCount = 0;
    $updatedRedirectsCount = 0;
    $config = \Drupal::configFactory()->getEditable('redirect_domain.domains');
    foreach ($fileData as $row) {
      $pathExists = FALSE;
      $row['A'] = str_replace('.', ':', $row['A']);
      if (array_key_exists($row['A'], $domainRedirects)) {
        $count = 0;
        foreach ($domainRedirects[$row['A']] as $redirect) {
          if (strcmp($redirect['sub_path'], '/' . ltrim($row['B'], '/')) === 0) {
            $pathExists = TRUE;
            $domainRedirects[$row['A']][$count] = [
              'sub_path' => '/' . ltrim($row['B'], '/'),
              'destination' => $row['C'],
            ];
            $updatedRedirectsCount++;
            break;
          }
          $count++;
        }
        if (!$pathExists) {
          $domainRedirects[$row['A']][] = [
            'sub_path' => '/' . ltrim($row['B'], '/'),
            'destination' => $row['C'],
          ];
          $newRedirectCount++;
        }
      }
      else {
        $domainRedirects[$row['A']][] = [
          'sub_path' => '/' . ltrim($row['B'], '/'),
          'destination' => $row['C'],
        ];
        $newRedirectCount++;
      }

    }

    $config->set('domain_redirects', $domainRedirects);
    $config->save();

    if ($updatedRedirectsCount > 0) {
      $message = \Drupal::translation()->formatPlural($updatedRedirectsCount,
        'One Domain redirect URL is updated.',
        '@count Domain redirect URL are updated.');
      drupal_set_message($message);
    }
    if ($newRedirectCount > 0) {
      $message = \Drupal::translation()->formatPlural($newRedirectCount,
        'One Domain redirect URL is added.',
        '@count Domain redirect URL are added.');
      drupal_set_message($message);
    }

  }

}
