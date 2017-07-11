/**
 * @file
 * Attaches behaviors for the article post filters.
 */

(function (Drupal, drupalSettings) {

    'use strict';

    Drupal.behaviors.postList = {
        attach: function (context) {
            jQuery('body').once('tag-list').each(function(){

                jQuery('.tal--focus-on-tag-list').on('click','.view-focus-on-tag-list .views-row', function(e) {
                    e.preventDefault();
                    jQuery('.use-ajax', this).trigger("click");

                });
            });
            jQuery('.tal--focus-on-tag-list .view-focus-on-tag-list .views-row a').click(function(e) {
                jQuery( document ).ajaxComplete(function() {
                    jQuery('html,body').animate({
                        scrollTop: jQuery(".tal-dynamic-post-wrapper #dynamic-post-list").offset().top - 140
                    }, 'slow');
                });
            });
        },
    };
})(Drupal, drupalSettings);
