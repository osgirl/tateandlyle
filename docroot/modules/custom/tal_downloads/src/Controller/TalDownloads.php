<?php

namespace Drupal\tal_downloads\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\paragraphs\Entity\Paragraph;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticlesController.
 */
class TalDownloads extends ControllerBase {

  /**
   * Returns a ajax response.
   *
   * Our router maps this method to the path 'articles/list_posts'.
   */
  public function getFile($pid) {
    $id = 'something';

    // Current paragraph entity id.
    if (!empty($pid)) {
      $item = Paragraph::load($pid);
      $file = $item->get('field_download_attach_file')->referencedEntities()[0];
      $link = $item->get('field_tal_link')->view('default');
      $element = array(
        '#theme' => 'tal_download_link',
        '#file' => $file,
        '#external_download_link' => $link,
        '#attributes' => array(
          'class' => 'tal-file-download-link',
          'id' => 'download-link-' . $id,
        ),
      );
      $message['element'] = $element;
    }
    else {
      $message = $this->getEmptyLinkWrapper($id);
    }
    $response = new Response(render($message));

    return $response;
  }

  /**
   * Renderable empty wrapper element for download link.
   *
   * @param int $id
   *   Unique id for wrapper element.
   *
   * @return mixed|array
   *   Returns empty renderable array with unique wrapper id.
   */
  private function getEmptyLinkWrapper($id) {
    $message['element'] = [
      '#theme' => 'tal_download_link',
      '#content' => $this->t('<span class="download-inactive">Download</span>'),
      '#attributes' => array(
        'class' => 'tal-file-download-link',
        'id' => 'download-link-' . $id,
      ),
    ];

    return $message;
  }

}
