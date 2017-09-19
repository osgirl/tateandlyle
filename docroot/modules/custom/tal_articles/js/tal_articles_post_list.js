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

            jQuery('.tal--focus-on-tag-list .view-focus-on-tag-list .views-row a').on('click', function(e) {
                jQuery( document ).on('ajaxComplete', function() {
                    var targetOffset = jQuery('.tal-dynamic-post-wrapper #dynamic-post-list').offset().top -140;
                    jQuery('html, body').animate({scrollTop: targetOffset}, 1000);
                    return false;
                });
            });
            jQuery(window).bind("wheel", function() {
                jQuery("html, body").stop();
            });
        }
    };
})(Drupal, drupalSettings);
