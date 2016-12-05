<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different node bundles.
 */

use Drupal\Core\Url;
use Drupal\Core\LINK;

/**
 * Preprocessor function for "Ingredient" bundle.
 */
function tal_preprocess_node_ingredient($variables, $node) {
  $paragraphs = $node->get('field_ingredients_content')->referencedEntities();

  // Collect all submenu texts from different paragraph types.
  $submenu_text = array();
  foreach ($paragraphs as $paragraph) {
    $url = Url::fromUserInput('#', array('fragment' => 'paragraph-' . $paragraph->id()));
    $submenu_text[] = Link::fromTextAndUrl($paragraph->get('field_field_in_submenu_title')->value, $url);
  }
  kint($submenu_text);
  // Initialize variable with submenu list.
  $variables['submenu'] = array();
  if (!empty($submenu_text)) {
    $variables['submenu'] = array(
      '#theme' => 'item_list',
      '#items' => $submenu_text,
    );
  }

  return $variables;
}
