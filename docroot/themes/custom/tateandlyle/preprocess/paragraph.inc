<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different paragraph types.
 */

use Drupal\field\Entity\FieldConfig;

/**
 * Preprocessor function for talk to us paragraph type.
 */
function tal_preprocess_paragraph_talk_to_us($variables, $paragraph) {
  $contact = $paragraph->get('field_ttu_contact')->referencedEntities();
  // Sets filed button text value.
  $variables['field_button_text'] = $paragraph->get('field_button_text')->value;

  // Sets filed link text value.
  $variables['field_or_link_text'] = $paragraph->get('field_or_link_text')->value;

  // Sets filed simple text value.
  $variables['field_simple_text'] = $paragraph->get('field_simple_text')->value;

  // Sets filed talk to us text value.
  $variables['field_ttu_link_text'] = $paragraph->get('field_ttu_link_text')->value;

  // Sets filed talk to us or button text value.
  $variables['field_ttu_or_button'] = $paragraph->get('field_ttu_or_button')->value;

  // Sets contact phone and title text values.
  $variables['field_ttu_contact_phone'] = '';
  $variables['field_ttu_contact_title'] = '';

  if (!empty($contact)) {
    $contact = array_shift($contact);

    $variables['field_ttu_contact_phone'] = $contact->get('field_phone_number')->value;
    $variables['field_ttu_contact_title'] = $contact->label();
  }

  return $variables;
}

/**
 * Preprocessor function for "wysiwyg with country and region" paragraph type.
 */
function tal_preprocess_paragraph_wysiwyg_with_country_and_region($variables, $paragraph) {
  // Checks if we need to put bordered around the paragraph.
  $variables['show_border'] = FALSE;

  if ($paragraph->get('field_in_border_title')->value) {
    $variables['show_border'] = TRUE;
  }
  // Retrieve the country and region counts.
  $variables['country_count'] = $paragraph->get('field_in_country')->count();
  $variables['region_count'] = $paragraph->get('field_in_region')->count();

  // Fetch the list of all countries.
  $field_definition = FieldConfig::loadByName('paragraph', 'wysiwyg_with_country_and_region', 'field_in_country');
  $countries = \Drupal::service('country.field.manager')->getSelectableCountries($field_definition);

  $selected_countries = $paragraph->get('field_in_country')->getValue(FALSE);
  $selected_countries_name = array();

  foreach ($selected_countries as $country) {
    $selected_countries_name[] = $countries[$country['value']];
  }

  // Populate the variable with the selected countries.
  $variables['list_country']  = array(
    '#theme' => 'item_list',
    '#items' => $selected_countries_name,
  );

  $regions = $paragraph->get('field_in_region')->getValue();
  $regions_name = array();

  foreach ($regions as $region) {
    $regions_name[] = $region['value'];
  }
  // Populate the variable with selected regions.
  $variables['list_regions'] = array(
    '#theme' => 'item_list',
    '#items' => $regions_name,
  );

  $variables['all_regions'] = FALSE;
  if ($variables['region_count'] == 1 && $regions[0]['value'] == 'All') {
    $variables['all_regions'] = TRUE;
  }

  return $variables;
}

/**
 * Preprocessor function for "ingredient accrdion" paragraph type.
 */
function tal_preprocess_paragraph_ingredient_accordion($variables, $paragraph) {
  // Checks if we need to put bordered around the paragraph.
  $variables['show_border'] = FALSE;

  if ($paragraph->get('field_in_border_title')->value) {
    $variables['show_border'] = TRUE;
  }

  return $variables;
}

/**
 * Preprocessor function for "wysiwyg_with_block_reference" paragraph type.
 */
function tal_preprocess_paragraph_wysiwyg_with_block_reference($variables, $paragraph) {
  // Checks if we need to put bordered around the paragraph.
  $variables['show_border'] = FALSE;

  if ($paragraph->get('field_in_border_title')->value) {
    $variables['show_border'] = TRUE;
  }

  return $variables;
}

/**
 * Preprocessor function for "wysiwyg" paragraph type.
 */
function tal_preprocess_paragraph_wysiwyg($variables, $paragraph) {
  // Checks if we need to put bordered around the paragraph.
  $variables['show_border'] = FALSE;

  if ($paragraph->get('field_in_border_title')->value) {
    $variables['show_border'] = TRUE;
  }

  return $variables;
}

/**
 * Preprocessor function for "block_reference" paragraph type.
 */
function tal_preprocess_paragraph_block_reference($variables, $paragraph) {
  // Checks if we need to put bordered around the paragraph.
  $variables['show_border'] = FALSE;

  if ($paragraph->get('field_in_border_title')->value) {
    $variables['show_border'] = TRUE;
  }

  return $variables;
}
