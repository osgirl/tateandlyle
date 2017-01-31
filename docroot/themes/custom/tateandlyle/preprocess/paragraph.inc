<?php

/**
 * @file
 * The primary file to hold preprocessor functions of different paragraph types.
 */

use Drupal\field\Entity\FieldConfig;
use Drupal\taxonomy\Entity\Term;

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
  $variables['contact'] = FALSE;
  $email = '';
  if (!empty($contact)) {
    $variables['contact'] = TRUE;
    $contact = array_shift($contact);
    $email = $contact->get('field_email')->value;
    $variables['field_ttu_contact_phone'] = $contact->get('field_phone_number')->value;
    $variables['field_ttu_contact_title'] = $contact->label();
  }
  $tc = $paragraph->get('field_ttu_type_of_content')->getValue();
  $tc_machin_name = '';
  if (!empty($tc)) {
    $term_id = $tc['0']['target_id'];
    $term = Term::load($term_id);
    $tc_machin_name = $term->get('field_tc_machine_name')->value;
  }
  // Contact form added.
  $variables['contact_form'] = [
    '#type' => 'webform',
    '#webform' => 'contact_form',
    '#default_data' => ['send_mail' => $email, 'tc' => $tc_machin_name],
  ];

  return $variables;
}

/**
 * Preprocessor function for "wysiwyg with country and region" paragraph type.
 */
function tal_preprocess_paragraph_wysiwyg_with_country_and_region($variables, $paragraph) {
  // Checks if we need to put bordered around the paragraph.
  $variables['show_border'] = FALSE;
  $parent = $paragraph->getParentEntity();
  $variables['parent_node_title'] = '';
  $variables['common_names'] = '';
  if ($parent->bundle() == "ingredient") {
    $variables['common_names'] = $parent->get('field_in_common_names')->value;
  }
  if (method_exists($parent, 'getTitle')) {
    $variables['parent_node_title'] = $parent->getTitle();
  }
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

  // Add four countries in a chunk.
  $chunks = array_chunk($selected_countries_name, 4, TRUE);

  foreach ($chunks as $i => $chunk) {
    // Populate the variable with the selected countries.
    $variables['list_country'][$i] = array(
      '#theme' => 'item_list',
      '#items' => $chunk,
    );
    // Need to add a wrapper if countries are more than 8.
    if ($i == 2) {
      $variables['list_country'][$i]['#prefix'] = '<div class="more-countries">';
    }
  }

  if ($i >= 2) {
    $variables['list_country'][$i]['#suffix'] = '</div>';
  }

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
  $parent = $paragraph->getParentEntity();
  $variables['trends_solution'] = '';
  $config = \Drupal::config('tal_admin_config.settings');
  $raw_data = $config->getRawData();
  $variables['default_trends_solution'] = $raw_data;
  // Get rich html markup submitted in config form for TAI Summary.
  $variables['default_trends_solution']['tai_summary'] = [
    '#markup' => $raw_data['tai_summary'],
  ];
  if ($parent->bundle() == "ingredient") {
    $values = $parent->toArray();
    $variables['trends_solution'] = [
      '#type' => 'view',
      '#name' => 'trends_insight_ingredient_block',
      '#display_id' => 'block_1',
      '#arguments' => [(int) $values['nid'][0]['value']],
    ];
  }
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

/**
 * Preprocessor function for "component_accordion_items" paragraph type.
 */
function tal_preprocess_paragraph_component_accordion_items($variables, $paragraph) {
  $parent = $paragraph->getParentEntity();
  $parent_field_name = $paragraph->toArray();
  $field_name = $parent_field_name['parent_field_name'][0]['value'];
  $variables['field_unique_id'] = $parent->getEntityTypeId() . $parent->id() . $field_name;
  return $variables;
}

/**
 * Preprocessor function for "component_accordion_items" paragraph type.
 */
function tal_preprocess_paragraph_ingredient_accordion_items($variables, $paragraph) {
  $parent = $paragraph->getParentEntity();
  $parent_field_name = $paragraph->toArray();
  $field_name = $parent_field_name['parent_field_name'][0]['value'];
  $variables['field_unique_id'] = $parent->getEntityTypeId() . $parent->id() . $field_name;
  return $variables;
}
