<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different block types.
 */

use Drupal\Core\Url;
use Drupal\Component\Utility\Html;

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
    $variables['attributes']['class'] = ' block--vertical';
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
 * Preprocessor function for freedom wysiwyg block type.
 */
function tal_preprocess_block_freefrom_wysiwyg($variables, $block) {
  // Custom block type helper classes.
  $title = $block->get('field_block_title')->value;

  if (isset($title)) {
    $variables['title_present'] = 'border--block';
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
  $top_title = $block->get('field_simple_text')->value;
  $bottom_link = $block->get('field_tal_link')->getValue();

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
  $variables['top_title'] = FALSE;
  $variables['bottom_link'] = FALSE;
  if (!empty($bottom_link)) {
    $variables['bottom_link'] = TRUE;
  }
  if (!empty($top_title)) {
    $variables['top_title'] = TRUE;
  }
  $variables['text_color'] = $font_color['value'];
  if (!isset($image) && !isset($background_color_content)) {
    $variables['background'] = 'noblock--bg';
  }
  if (!empty($top_title) || !empty($bottom_link)) {
    $variables['top_bottom'] = 'top--bottom';
  }

  $variables['background_color'] = FALSE;
  if (isset($background_color_content) && !isset($image)) {
    $variables['background_color'] = TRUE;
  }

  if ($background_color_content['value'] == '#ffffff' && !isset($image)) {
    $variables['background_color_block'] = 'noblock--bg';
  }
  return $variables;
}

/**
 * Preprocessor function for download block type.
 */
function tal_preprocess_block_download($variables, $block) {
  $class = isset($variables['attributes']['class']) ? $variables['attributes']['class'] : '';
  $variables['attributes']['class'] = 'file--downloads ' . $class;

  return $variables;
}

/**
 * Preprocessor function for homepage-banner block type.
 */
function tal_preprocess_block_homepage_banner($variables, $block) {
  $left_icon = empty($block->get('field_icon')->getValue()) ? FALSE : TRUE;
  $right_icon = empty($block->get('field_right_icon')->getValue()) ? FALSE : TRUE;

  $variables['left_icon'] = $left_icon;
  $variables['right_icon'] = $right_icon;

  if (empty($left_icon) || empty($right_icon)) {
    $variables['no_icon_dsc'] = 'no__icon--banner';
    $variables['no_icon'] = TRUE;
  }

  return $variables;
}

/**
 * Preprocessor function for detail content promo block type.
 */
function tal_preprocess_block_history($variables, $block) {
  // Get paragraph's id to generate unique ids for history tabs.
  $tab_wrapper = $block->get('field_history_tab')->referencedEntities();
  $tab_wrapper_id = Html::getUniqueId('history-tabs-wrapper');
  $tabs = [];

  foreach ($tab_wrapper as $tab) {
    // Get Tab title from History tab paragraphs.
    $title = $tab->get('field_tab_title')->getValue();
    $tabs[] = [
      'id' => 'history-tab-nav-' . $tab->id(),
      'title' => array_shift($title)['value'],
    ];
  }
  if (count($tabs) > 4) {
    $variables['content_count'] = 'more__tabs';
  }
  $variables['tabs'] = $tabs;
  $variables['wrapper_id'] = $tab_wrapper_id;
  return $variables;
}

/**
 * Preprocessor function for Dynamic posts block type.
 */
function tal_preprocess_block_dynamic_posts($variables, $block) {
  $categories = $block->get('field_artice')->getValue();
  $tag_vocab = $block->get('field_tags')->getValue();

  // Initialize variables.
  $terms = [];
  $tags = [];
  $arg = [];
  // Fetch all categories.
  foreach ($categories as $category) {
    $terms[] = $category['target_id'];
  }

  // Featch all tags.
  foreach ($tag_vocab as $term) {
    $tags[] = $term['target_id'];
  }

  $terms = implode('+', $terms);
  $tags = implode('+', $tags);

  $arg[0] = $terms;
  if ($tags != '') {
    $arg[1] = $tags;
  }

  // Add Dynamic block.
  $variables['dynamic_posts'] = array(
    '#type' => 'view',
    '#name' => 'articles_post',
    '#arguments' => $arg,
  );

  if ($block->get('field_choose_articles_display')->value == 'teaser') {
    // Store current block object for later processing.
    $tempstore = \Drupal::service('user.private_tempstore')->get('dynamic_post_block');
    $tempstore->set('block', $block);

    // Set current block.
    $variables['dynamic_posts_id'] = $block->id();
    // Set display type.
    $variables['dynamic_posts']['#display_id'] = 'block_1';
    $variables['dynamic_posts']['#prefix'] = '<div class="tal--dynamic-post-list" id="dynamic-post-list">';
    $variables['dynamic_posts']['#suffix'] = '</div>';

    // Add tag filters.
    $variables['focus_on_tag_list'] = array(
      '#type' => 'view',
      '#name' => 'focus_on_tag_list',
      '#display_id' => 'block_1',
      '#prefix' => '<div class="tal--focus-on-tag-list">',
      '#suffix' => '</div>',
    );
  }

  // Latest news.
  if ($block->get('field_choose_articles_display')->value == '3_col') {
    $variables['dynamic_posts']['#display_id'] = 'block_2';
    $variables['chosen_view_mode'] = 'three--columns';
  }

  // Latest Publications.
  if ($block->get('field_choose_articles_display')->value == 'teaser_latest_publication') {
    $variables['dynamic_posts']['#display_id'] = 'block_3';
    $variables['dynamic_posts']['#arguments'][]['text'] = $block->get('field_header_text')->value;
    $variables['dynamic_posts']['#prefix'] = '<div class="tal--dynamic-post-list">';
    $variables['dynamic_posts']['#suffix'] = '</div>';
  }

  // Dairy case studies.
  if ($block->get('field_choose_articles_display')->value == '2_col') {
    $variables['dynamic_posts']['#display_id'] = 'block_4';
    $variables['chosen_view_mode'] = 'two--columns';
  }

  $variables['#attached']['library'][] = 'tal_articles/tal_articles_post_list';

  return $variables;
}

/**
 * Preprocessor function for content promo with image block type.
 */
function tal_preprocess_block_content_promo_with_image($variables, $block) {
  $image = $block->get('field_bg_image')->referencedEntities();
  $image = array_shift($image);

  $featured_icon = $block->get('field_featured_block_icon')->referencedEntities();
  $featured_icon = array_shift($featured_icon);

  $featured_links = $block->get('field_featured_links')->getValue();

  $has_summary = $block->get('field_short_summary')->getValue();

  if (!empty($has_summary)) {
    $variables['summary'] = 'block__promo--summary';
  }

  if (isset($featured_icon)) {
    $variables['icon'] = 'featured__icon';
  }

  if (!empty($featured_links)) {
    $variables['link'] = 'featured__link';
  }

  if (isset($image)) {
    $image_url = file_create_url($image->getFileUri());
    $variables['style'] = 'background-image: url("' . $image_url . '")';
    $variables['bg-image'] = "has__bg";
  }

  if (!isset($image)) {
    $variables['background'] = 'no__bg';
  }

  $field_promo_content = $block->get('field_content_details')->referencedEntities();
  if (!empty($field_promo_content)) {
    $variables['content_count'] = 'promo__images-' . count($field_promo_content);
  }
  return $variables;
}

/**
 * Preprocessor function for single item promo block type.
 */
function tal_preprocess_block_sip_with_background($variables, $block) {

  $background_color_content = $block->get('field_bg_color')->getValue();
  $background_color_content = array_shift($background_color_content);

  $image = $block->get('field_sip_bg_image')->referencedEntities();
  $image = array_shift($image);
  if (isset($image)) {
    $image_url = file_create_url($image->getFileUri());
    $variables['style'] = 'background-image: url("' . $image_url . '")';
  }
  if (!isset($image)) {
    $variables['background'] = 'block__sip--nobackground';
  }
  $variables['bg_color'] = $background_color_content['value'];
  return $variables;
}
