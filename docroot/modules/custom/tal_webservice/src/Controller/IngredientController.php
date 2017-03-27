<?php

namespace Drupal\tal_webservice\Controller;

use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Access\AccessResult;

/**
 * Process ingredient contents.
 */
class IngredientController {

  /**
   * Allow access for logged-in, authenitcated users.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   */
  public function access(AccountInterface $account) {
    return AccessResult::allowedIf($account->isAuthenticated());
  }

  /**
   * Process posted files.
   */
  public function create(Request $request) {
    if (strpos($request->headers->get('Content-Type'), 'multipart/form-data;') !== 0) {
      $res = new JsonResponse();
      $res->setStatusCode(400, 'must submit multipart/form-data');
      return $res;
    }

    if ($error = $this->validate($request) !== TRUE) {
      $res = new JsonResponse();
      $res->setStatusCode(400, $error);
      return $res;
    }

    // Initialize the file variable.
    $file = 'NOFILE';

    // The attached file will only be processed, if it has an associated name.
    if ($request->request->get('file_name') != 'NOFILE') {
      $data = file_get_contents($_FILES['files']['tmp_name']);
      $destination = 'public://' . $request->request->get('file_name');
      $file = file_save_data($data, $destination, FILE_EXISTS_REPLACE);
    }

    $paragraphs = $this->getParagraphByMaterialId($request->request->get('material_id'));

    // Material Id will be unique and it is expected to return single
    // paragraph entity.
    $paragraph = array_shift($paragraphs);
    $paragraph->field_sap_summary->setValue(['value' => $request->request->get('summary')]);
    $paragraph->field_sap_title->setValue(['value' => $request->request->get('title')]);

    $this->attachFile($paragraph, $file, $request->request->get('document_type'));
    // Save the updated paragraph.
    $paragraph->save();
    // Get all parent ingredients node of this paragraph.
    $ingredients = $this->getParentNode($paragraph->id());

    $nids = [];

    foreach ($ingredients as $ingredient) {
      $nids[] = $ingredient->id();
    }

    $respon = new JsonResponse("Nodes updated: " . implode(',', $nids));
    $respon->setStatusCode(200, 'Success.');

    return $respon;
  }

  /**
   * Returns the paragraph objects based on the material id.
   */
  private function getParagraphByMaterialId($material_id = NULL) {
    $query = \Drupal::entityQuery('paragraph');

    $query->condition('type', 'sap_documents', '=');
    $query->condition('field_sap_material_code.value', $material_id, '=');

    $ids = $query->execute();
    $ids = array_values($ids);

    $entity_storage = \Drupal::entityTypeManager()->getStorage('paragraph');

    // Load multiple nodes.
    $paragraphs = $entity_storage->loadMultiple($ids);

    return $paragraphs;
  }

  /**
   * Returns the parent ingredient node of the given paragraph id.
   */
  private function getParentNode($pid) {
    $query = \Drupal::entityQuery('node');

    $query->condition('type', 'ingredient', '=');
    $query->condition('field_sap_documents.target_id', $pid, '=');

    $ids = $query->execute();
    $ids = array_values($ids);

    $entity_storage = \Drupal::entityTypeManager()->getStorage('node');

    // Load multiple nodes.
    return $ingredients = $entity_storage->loadMultiple($ids);
  }

  /**
   * This function attaches the uploaded file to the paragraph.
   */
  private function attachFile(&$paragraph, $file, $doc_type) {
    $id = $file == 'NOFILE' ? '' : $file->id();

    switch ($doc_type) {
      case "SDS":
        $paragraph->field_sap_sds_file->setValue(['target_id' => $id]);
        break;

      case "SPECSHEET":
        $paragraph->field_sap_spec_sheet->setValue(['target_id' => $id]);
        break;

      case "PRODUCTINFOSHEET":
        $paragraph->field_product_info_sheet->setValue(['target_id' => $id]);
        break;

      default:
        $paragraph->field_sap_sds_file->setValue(['target_id' => '']);
        $paragraph->field_sap_spec_sheet->setValue(['target_id' => '']);
        $paragraph->field_product_info_sheet->setValue(['target_id' => '']);
        break;
    }
  }

  /**
   * Validate the POST data.
   */
  private function validate(Request $request) {
    $error = TRUE;

    // Material Id is mandatory.
    if ($request->request->get('material_id') == '') {
      $error = t('Invalid post data, material id was missing.');
      return $error;
    }

    // Node does not exits of given material id.
    if (empty($this->getParagraphByMaterialId($request->request->get('material_id')))) {
      $error = t('Invalid post data, No Matching material code found.');
      return $error;
    }

    // Check title.
    if ($request->request->get('title') == '') {
      $error = t('Invalid post data, empty title.');
      return $error;
    }

    // Check summary.
    if ($request->request->get('summary') == '') {
      $error = t('Invalid post data, empty summary.');
      return $error;
    }

    // Check document type.
    if ($request->request->get('document_type') == ''
      || !in_array(
        $request->request->get('document_type'),
        ['SDS', 'SPECSHEET', 'PRODUCTINFOSHEET']
      )
    ) {
      $error = t('Invalid post data, empty document_type or type not found.');
      return $error;
    }

    // Check summary.
    if ($request->request->get('file_name') == '') {
      $error = t('Invalid post data, empty file name.');
      return $error;
    }
  }

}