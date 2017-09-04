<?php

namespace Drupal\tal_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\node\NodeInterface;

/**
 * Class NodeController.
 */
class NodeController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Generates an overview table of older revisions of a node.
   *
   * @param \Drupal\node\NodeInterface $node
   *   A node object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function draftVersion(NodeInterface $node) {
    $entity_type = 'node';
    $view_mode = 'full';
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
    $build = $view_builder->view($node, $view_mode);
    return $build;
  }

}
