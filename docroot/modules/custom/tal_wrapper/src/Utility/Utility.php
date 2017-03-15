<?php

namespace Drupal\tal_wrapper\Utility;

use Drupal\node\Entity\Node;
use Drupal\Core\Url;
use Drupal\Component\Utility\Xss;

/**
 * Contains the common function used.
 */
class Utility {

  /**
   * Lookup the next or previous node.
   *
   * @param string $nid
   *   A node unique id.
   * @param string $pub_date
   *   Publishing date field.
   * @param string $bundle
   *   Type of the content.
   * @param string $direction
   *   Either 'next' or 'previous'.
   *
   * @return array
   *   An title, node, url array to the next or previous node
   */
  public static function generateNextPrevious($nid, $pub_date, $bundle, $direction = 'next') {
    if ($direction === 'next') {
      $comparison_opperator = '>';
      $sort = 'ASC';
    }

    elseif ($direction === 'prev') {
      $comparison_opperator = '<';
      $sort = 'DESC';
    }

    // Lookup 1 node younger (or older) than the current node.
    $query = \Drupal::entityQuery('node');
    $next = $query->condition('field_date.value', $pub_date, $comparison_opperator)
      ->condition('nid', $nid, '<>')
      ->condition('type', $bundle)
      ->condition('status', 1)
      ->sort('field_date', $sort)
      ->sort('created', 'DESC')
      ->range(0, 1)
      ->execute();
    if (!empty($next)) {
      $nid = array_values($next)[0];
      $node = Node::load($nid);
      $title = $node->getTitle();

      return [
        'nid' => $node,
        'title' => xSS::filter($title),
        'url'   => Url::fromUserInput('/node/' . $nid),
      ];
    }
    return '';
  }

}
