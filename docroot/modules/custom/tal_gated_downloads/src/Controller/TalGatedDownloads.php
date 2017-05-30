<?php

namespace Drupal\tal_gated_downloads\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Drupal\file\Entity\File;

/**
 * Class ArticlesController.
 */
class TalGatedDownloads extends ControllerBase {

  /**
   * Returns a binary file response.
   *
   * Our router maps this method to the path '/downloads/gated/file/{fid}'.
   */
  public function getFile() {
    $output = array(
      '#type' => 'marker',
      '#marker' => '<div class="error">' . $this->t('File not found on the server.') . '</div>',
    );
    $tempstore = \Drupal::service('user.private_tempstore')->get('tal_gated_downlods');
    $fid = $tempstore->get('fid');

    $response = new Response(render($output));

    if ($fid) {
      $file = File::load($fid);
      $uri = $file->getFileUri();
      // This should return the file to the browser as response.
      $response = new BinaryFileResponse($uri);

      // To generate a file download, you need the mimetype of the file.
      $mimeTypeGuesser = \Drupal::service('file.mime_type.guesser');
      // Guess the mimetype of the file according to the extension of the file.
      $response->headers->set('Content-Type', $mimeTypeGuesser->guess($uri));

      // Set content disposition inline of the file.
      $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT, $file->getFilename()
      );
      $tempstore->set('fid', '');
    }

    return $response;
  }

  /**
   * Returns a renderable array as response.
   */
  public function getMessagePage() {
    return array(
      '#markup' => t('Your download will start automatically.'),
      '#attached' => array(
        'library' => array(
          'tal_gated_downloads/tal_gated_downloads_redirect',
        ),
      ),
    );
  }

}
