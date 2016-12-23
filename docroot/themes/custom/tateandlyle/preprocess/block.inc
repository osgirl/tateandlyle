<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different block types.
 */

use Drupal\Core\Url;

/**
 * Preprocessor function for single item promo block type.
 */
function tal_preprocess_block_single_item_promo($variables, $block) {
  // Checks if vertical orientation is enabled in the block.
  $is_vertical = $block->get('field_sip_vertical')->getValue();
  $is_vertical = array_shift($is_vertical)['value'];

  $background_color_content = $block->get('field_bg_color')->getValue();
  $background_color_content = array_shift($background_color_content);

  $icon = $block->get('field_icon')->getValue();
  $image = $block->get('field_sip_image')->getValue();

  $variables['is_icon'] = FALSE;
  $variables['is_image'] = FALSE;
  $variables['bg_color'] = $background_color_content['value'];
  $variables['overlay_color'] = $block->get('field_bg_color')->value;

  if ($is_vertical) {
    $variables['attributes']['class'] .= ' block--vertical';
  }

  if (!empty($icon)) {
    $variables['is_icon'] = TRUE;
  }

  if (isset($image)) {
    $variables['is_image'] = TRUE;
  }

  return $variables;
}

/**
 * Preprocessor function for talk to us block type.
 */
function tal_preprocess_block_talk_to_us($variables, $block) {
  // Custom block type helper classes.
  $variables['overlay_color'] = $block->get('field_bg_color')->value;

  $image = $block->get('field_bg_image')->referencedEntities();
  $image = array_shift($image);

  if (isset($image)) {
    $variables['is_image'] = TRUE;
    $image_url = file_create_url($image->getFileUri());
    $variables['style'] = 'background-image: url("' . $image_url . '")';
  }

  return $variables;
}

/**
 * Preprocessor function for facet block block type.
 */
function tal_preprocess_block_facet_block($variables, $block) {
  // Custom block type helper classes.
  $variables['#attached']['library'][] = 'tal_ingredient_search/tal_ingredient_clear_all_facets';
  return $variables;
}

/**
 * Preprocessor function for continue or browse block type.
 */
function tal_preprocess_block_continue_or_browse($variables, $block) {
  // Custom block type helper classes.
  $text = !empty($variables['content']['#link_text']) ? $variables['content']['#link_text'] : t('All matching ingredients');
  $link_url = !empty($variables['content']['#link_url']) ? $variables['content']['#link_url'] : 0;
  if ($link_url) {
    $url = Url::fromUserInput('/search/ingredients');
  }
  else {
    $query = \Drupal::request()->getQueryString();
    $query = !empty($query) ? '?' . $query : '';
    $url = Url::fromUserInput('/search/ingredients/results' . $query);
  }
  $url->setOption('attributes', array('class' => array('continue-search-link')));
  $variables['link'] = \Drupal::l($text, $url);
  $variables['#cache']['contexts'] = ['url.query_args'];

  return $variables;
}

/**
 * Preprocessor function for detail content promo block type.
 */
function tal_preprocess_block_detail_content_promo($variables, $block) {
  $field_dcp_content = $block->get('field_dcp_content_section')->referencedEntities();
  if (!empty($field_dcp_content) && count($field_dcp_content) > 0) {
    $variables['content_count'] = 'dcp-content-' . count($field_dcp_content);
  }
  // Custom block type helper classes.
  $color = $block->get('field_bg_color')->value;
  $variables['overlay_color'] = $block->get('field_bg_color')->value;

  if (!isset($color)) {
    $variables['overlay_color'] = 'no__bg';
  }

  return $variables;
}

/**
 * Preprocessor function for passive recruitment block type.
 */
function tal_preprocess_block_passive_recruitment($variables, $block) {
  // Custom block type helper classes.
  $variables['overlay_color'] = $block->get('field_bg_color')->value;

  $image = $block->get('field_bg_image')->referencedEntities();
  $image = array_shift($image);

  if (isset($image)) {
    $variables['is_image'] = TRUE;
    $image_url = file_create_url($image->getFileUri());
    $variables['style'] = 'background-image: url("' . $image_url . '")';
  }

  return $variables;
}

/**
 * Preprocessor function for banner block type.
 */
function tal_preprocess_block_banner($variables, $block) {
  $id = $block->get('id')->value;
  $video_id = $block->get('field_simple_text')->value;
  $variables['videos'] = FALSE;
  if (!empty($video_id)) {
    $variables['videos'] = TRUE;
    $variables['videoid'] = 'buto' . $id . '_' . $video_id;
    $variables['#attached']['drupalSettings']['tateandlyle']["banner-" . $id]['elementid'] = $variables['videoid'];
    $variables['#attached']['drupalSettings']['tateandlyle']["banner-" . $id]['videoid'] = $video_id;
    $variables['#attached']['drupalSettings']['tateandlyle']["banner-" . $id]['height'] = 261;
    $variables['#attached']['drupalSettings']['tateandlyle']["banner-" . $id]['width'] = 464;
    $variables['#attached']['library'][] = 'tateandlyle/buto-tv-script';
  }

  return $variables;
}

/**
 * Preprocessor function for quote block type.
 */
function tal_preprocess_block_quote($variables, $block) {
  // Check if background color is added.
  $background_color_content = $block->get('field_qt_bg_color')->getValue();
  $background_color_content = array_shift($background_color_content);

  $font_color = $block->get('field_bg_color')->getValue();
  $font_color = array_shift($font_color);

  $image = $block->get('field_tal_image')->referencedEntities();
  $image = array_shift($image);

  $variables['is_icon'] = FALSE;
  $variables['is_image'] = FALSE;

  if (isset($background_color_content)) {
    $variables['style'] = "background-color: " . $background_color_content['value'];
  }

  if (isset($image)) {
    $variables['is_image'] = TRUE;
    $image_url = file_create_url($image->getFileUri());
    $variables['style'] = 'background-image: url("' . $image_url . '")';
  }

  $variables['text_color'] = $font_color['value'];
  if (!isset($image) && !isset($background_color_content)) {
    $variables['background'] = 'no__bg';
  }

  return $variables;
}
