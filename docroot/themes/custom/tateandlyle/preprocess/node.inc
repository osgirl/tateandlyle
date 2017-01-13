<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different node bundles.
 */

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Utility\UrlHelper;
use Drupal\tal_wrapper\Utility\Utility as TalWrapperUtility;

/**
 * Preprocessor function for "Ingredient" bundle.
 */
function tal_preprocess_node_ingredient($variables, $node) {
  $paragraphs = $node->get('field_ingredients_content')->referencedEntities();
  // Collect all submenu texts from different paragraph types.
  $submenu_text = array();
  foreach ($paragraphs as $paragraph) {
    if ($paragraph->hasField('field_field_in_submenu_title')) {
      $url = Url::fromUserInput('#', array('fragment' => 'paragraph-' . $paragraph->id()));
      $submenu_text[] = Link::fromTextAndUrl($paragraph->get('field_field_in_submenu_title')->value, $url);
    }
  }
  // Initialize variable with submenu list.
  $variables['submenu'] = array();
  if (!empty($submenu_text)) {
    $variables['submenu'] = array(
      '#theme' => 'item_list',
      '#items' => $submenu_text,
    );
  }

  if ($variables['view_mode'] == 'search_result') {
    $path = \Drupal::request()->getUri();
    $parameters = UrlHelper::parse($path);
    $keyword = isset($parameters['query']['s']) ? $parameters['query']['s'] : '';
    $variables['field_in_common_names'] = search_excerpt($keyword, $node->get('field_in_common_names')->value);
    $variables['body'] = search_excerpt($keyword, $node->get('body')->value);
  }
  // Initialise the variable.
  $variables['hide_title'] = $node->get('field_hide_title')->value;

  return $variables;
}

/**
 * Preprocessor function for "company_story" bundle.
 */
function tal_preprocess_node_company_story($variables, $node) {
  $node = $variables['node'];
  $value = $node->get('field_category')->getValue();
  $tid = array_shift($value)['target_id'];
  $term = \Drupal\taxonomy\Entity\Term::load($tid);

  $nid = $node->id();
  $bundle = 'company_story';

  $variables['next'] = TalWrapperUtility::generateNextPrevious($nid, $bundle, 'next');
  $variables['prev'] = TalWrapperUtility::generateNextPrevious($nid, $bundle, 'prev');
  $variables['icon'] = $term->get('field_ac_icon')->view('default');
  $variables['image'] = $node->get('field_image')->view();
  $image_size = $node->get('field_image_size')->value;

  $variables['image'][0]['#image_style'] = 'article_small_312_x_169';
  if ($image_size) {
    $variables['image'][0]['#image_style'] = 'article_large_880_x_477';
  }

  if ($variables['view_mode'] == 'search_result') {
    $path = \Drupal::request()->getUri();
    $parameters = UrlHelper::parse($path);
    $keyword = isset($parameters['query']['s']) ? $parameters['query']['s'] : '';
    $variables['body'] = search_excerpt($keyword, $node->get('body')->value);
  }

  return $variables;
}

/**
 * Preprocessor function for "Icon" bundle.
 */
function tal_preprocess_node_icon($variables, $node) {

  $variables['title_attributes']['class'] = 'hide';
  return $variables;
}

/**
 * Preprocessor function for "iframe_content" bundle.
 */
function tal_preprocess_node_iframe_content($variables, $node) {
  $variables['raw_field_iframe_code'] = $node->get('field_iframe_code')->value;
  return $variables;
}
