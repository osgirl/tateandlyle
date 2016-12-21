/**
 * @file
 * Attaches behaviors for ingredient search sort option widget.
 */

(function (Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.SearchSortOrder = {
        attach: function (context) {
            // Fetch the search keyword the submit the form on change.
            jQuery('.form-select').change(function(e) {
                var element = e.target;
                var keyword = jQuery('#edit-s').val();
                var form = jQuery(element).closest("form").get();

                jQuery('input[name="keyword"]', form).val(keyword);
                jQuery(form).submit();
            });
        },
    };

})(Drupal, drupalSettings);
