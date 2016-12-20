/**
 * @file
 * Attaches behaviors for ingredient search sort option widget.
 */

(function (Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.SearchSortOrder = {
        attach: function (context) {
            // Fetch the search keyword the submit the form on change.
            jQuery('#tal-sort-by').change(function() {
                var keyword = jQuery('#edit-s').val();
                jQuery('#tal-search-sort-by :input[name="keyword"]').val(keyword);
                jQuery('#tal-search-sort-by').submit();
            });
        },
    };

})(Drupal, drupalSettings);
