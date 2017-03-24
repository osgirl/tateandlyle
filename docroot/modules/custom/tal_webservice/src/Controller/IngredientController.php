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

    $data = file_get_contents($_FILES['files']['tmp_name']);
    $mime = $_FILES['files']['type'];
    $destination = 'public://' . $request->request->get('file_name');
    $file = file_save_data($data, $destination, FILE_EXISTS_REPLACE);

    $response['file_id'] = $file->id();
    $response['title'] = $request->request->get('title');
    $response['summary'] = $request->request->get('summary');
    $response['material_id'] = $request->request->get('material_id');
    $response['document_type'] = $request->request->get('document_type');
    $response['file_name'] = $request->request->get('file_name');

    return new JsonResponse($response);
  }

}
