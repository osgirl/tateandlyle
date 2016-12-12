/**
 * @file
 * Contains Tate and Lyle Custom Javascript behaviours.
 */

/**
 * Implements Drupal.behaviours.
 */
(function ($, Drupal) {
  "use strict";

  Drupal.behaviors.collapse = {
    attach: function () {
      $(".panel-accordion").each(function () {
        $(this).find(".collapse").first().addClass("in");
        $(this).find(".accordion-toggle").first().removeClass("collapsed");
      });

      $(".in--country-read-more button").click(function () {
        $(".field--in-country .more-countries").addClass("show");
      });

      $(".ingredient--submenu ul li").first().click(function () {
        $(".ingredient--submenu ul li").toggleClass("show");
      });
    }
  };

  Drupal.behaviors.scrollFix = {
    attach: function () {
      var position = $(".ingredient--submenu").offset().top;
      var nav = $(".ingredient--submenu");

      $(window).scroll(function () {
        if ($(this).scrollTop() > position) {
          nav.addClass("navbar-fixed-top");
        }
        else {
          nav.removeClass("navbar-fixed-top");
        }
      });
    }
  };
})(jQuery, Drupal);
