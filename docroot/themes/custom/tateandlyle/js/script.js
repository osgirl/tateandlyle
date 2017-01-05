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

  Drupal.behaviors.carousel = {
    attach: function () {
      $("#carousel-example-generic").carousel({
        interval: 4000
      });

      $(".carousel .item").each(function () {
        var next = $(this).next();

        if (!next.length) {
          next = $(this).siblings(":first");
        }
        next.children(":first-child").clone().appendTo($(this));
        for (var i = 0; i < 2; i++) {
          next = next.next();
          if (!next.length) {
            next = $(this).siblings(":first");
          }
          next.children(":first-child").clone().appendTo($(this));
        }
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
