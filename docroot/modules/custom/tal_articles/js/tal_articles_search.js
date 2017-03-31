/**
 * @file
 * Attaches behaviors for ingredient search sort option widget.
 */

(function (Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.Searcharticle = {
        attach: function (context) {
            //Fetch the search keyword and year the submit the form on change.
            jQuery('.select-year-press-article').change(function(e) {
                var element = e.target;
                var keyword = jQuery('#tal-search-filter').val();
                var year = jQuery('#tal-search-year-filter').val();
                var form = jQuery(element).closest("form").get();

                jQuery('input[name="keyword"]', form).val(keyword);
                jQuery('input[name="year"]', form).val(year);
                jQuery(form).submit();
            });
        },
    };

})(Drupal, drupalSettings);
