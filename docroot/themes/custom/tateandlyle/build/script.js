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
      $(".in--country-read-more button").click(function () {
        $(".field--in-country .more-countries").addClass("view");
      });

      $(".ingredient--submenu ul li").first().click(function () {
        $(".ingredient--submenu ul li").toggleClass("view");
      });
    }
  };

  Drupal.behaviors.scrollFix = {
    attach: function () {
      if ($(".ingredient--submenu").length) {
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

      // Manage the offset of Anchor scroll links.
      function anchorOffset() {
        if (location.hash.length !== 0) {
          window.scrollTo(window.scrollX, window.scrollY - 180);
        }
      }

      window.addEventListener("hashchange", anchorOffset);
      window.setTimeout(anchorOffset, 1);
    }
  };
})(jQuery, Drupal);
