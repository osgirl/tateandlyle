<?php

namespace Drupal\tal_articles\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Class ArticlesController.
 */
class ArticlesController extends ControllerBase {

  /**
   * Returns a ajax response.
   *
   * Our router maps this method to the path 'articles/list_posts'.
   */
  public function listPosts($tid) {
    $response = new AjaxResponse();
    // Get the saved block object for the processing.
    $tempstore = \Drupal::service('user.private_tempstore')->get('dynamic_post_block');
    $block = $tempstore->get('block');

    $categories = $block->get('field_artice')->getValue();
    $terms = [];

    foreach ($categories as $category) {
      $terms[] = $category['target_id'];
    }

    $terms = implode('+', $terms);
    $render['dynamic_posts'] = array(
      '#type' => 'view',
      '#name' => 'articles_post',
      '#display_id' => 'block_1',
      '#arguments' => [$terms, $tid],
      '#prefix' => '<div class="tal--dynamic-post-list" id="dynamic-post-list">',
      '#suffix' => '</div>',
    );

    $response->addCommand(new ReplaceCommand('#dynamic-post-list', $render));

    return $response;
  }

}
