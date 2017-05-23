/**
 * @file
 * Attaches behaviors for ingredient search sort option widget.
 */

(function ($, Drupal) {

    'use strict';
    Drupal.behaviors.searchClearAll = {
        attach: function () {
            $(document).find('.clear-all-filters-button').once('SearchClearAll').each(function () {
                var text = '';
                var uri = '';
                var i = 0;
                $.each($(this).closest('section').siblings(), function (x, val1) {
                    var obj = $(this).find(".facets-checkbox:checkbox:checked");
                    var length = obj.length;
                    if(length > 0){
                        if(length == 1){
                            text += '&f[' + i + ']=' + obj.attr("id").replace("-", ":");
                            i++;
                        }else{
                            $.each(obj, function (n, val2) {
                                text += '&f[' + i + ']=' + $(this).attr("id").replace("-", ":");
                                i++;
                            });
                        }
                    }
                })
                var sortby = jQuery("#block-exposedformingredient-finderpage-1 select").val();
                var search = jQuery("#block-exposedformingredient-finderpage-1 input:text").val();
                $(this).attr('href', '/search/ingredients/results?'+ 's='+search +"&sort_by=" + sortby + text);
            });
        }

    };

})(jQuery, Drupal);
