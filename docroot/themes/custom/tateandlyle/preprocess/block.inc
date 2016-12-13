<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different block types.
 */

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
  $variables['overlay_color'] = $variables['elements']['content']['#block_content']->get('field_bg_color')->value;

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
  $variables['overlay_color'] = $variables['elements']['content']['#block_content']->get('field_bg_color')->value;

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
 * Preprocessor function for detail content promo block type.
 */
function tal_preprocess_block_detail_content_promo($variables, $block) {
  // Custom block type helper classes.
  $variables['overlay_color'] = $variables['elements']['content']['#block_content']->get('field_bg_color')->value;

  return $variables;
}

/**
 * Preprocessor function for passive recruitment block type.
 */
function tal_preprocess_block_passive_recruitment($variables, $block) {
  // Custom block type helper classes.
  $variables['overlay_color'] = $variables['elements']['content']['#block_content']->get('field_bg_color')->value;

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
  $id = $variables['elements']['content']['#block_content']->get('id')->value;
  $video_id = $variables['elements']['content']['#block_content']->get('field_simple_text')->value;
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

  if (!isset($image) && !isset($background_color_content)) {
    $variables['style'] = "color:" . $font_color['value'];
  }

  return $variables;
}
