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
            jQuery('.panel-accordion .panel-heading a').on('click', function(e) {
                var self = jQuery(this);
                setTimeout(function() {
                    var targetOffset = self.offset();
                    jQuery('body, html').animate({ scrollTop: targetOffset.top -140 }, 1000);
                }, 350);
            });
            jQuery(window).bind("wheel", function() {
                jQuery("html, body").stop();
            });
        }
    };
})(Drupal, drupalSettings);
