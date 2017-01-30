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
      $("body").once("more-event").each(function () {
        var originalString = $(".in--country-read-more button").text();

        $(".in--country-read-more button").click(function () {
          $(".field--in-country .more-countries").slideToggle("slow", function () {
            $(".in--country-read-more button").toggleClass("btn-less");
            if ($(".in--country-read-more button").text() !== "Show less") {
              $(".in--country-read-more button").text(Drupal.t("Show less"));
            }
            else {
              $(".in--country-read-more button").text(originalString);
            }
          });
        });
      });

      $("#block-talmainmenu .dropdown").hover(
        function () {
          $(".dropdown-menu", this).stop(true, true).fadeIn("fast");
          $(this).toggleClass("open");
        },
        function () {
          $(".dropdown-menu", this).stop(true, true).fadeOut("fast");
          $(this).toggleClass("open");
        });

      $("#block-talmainmenu .dropdown").on("click", function () {
        $(this).find(".dropdown-toggle").removeAttr("data-toggle").trigger("click");
      });

      $(".no__icon--banner .dropdown-toggle").text(
        $(".field--name-field-left-link .active a").text()
      );
    }
  };

  Drupal.behaviors.carouselimit = {
    attach: function () {
      if ($(".carousel-inner .item").length < 5) {
        $("a.carousel-control").css("display", "none");
      }
    }
  };

  Drupal.behaviors.addplaceholder = {
    attach: function () {
      $(".input--wrapper input").attr("placeholder", "Search here");
    }
  };

  Drupal.behaviors.changeToggle = {
    attach: function () {
      $("#changetoggle").click(function () {
        $("#navbar-hamburger").toggleClass("hidden");
        $("#navbar-close").toggleClass("hidden");
      });
    }
  };

  Drupal.behaviors.arrowToggle = {
    attach: function () {
      $(".dropdown").on("show.bs.dropdown hide.bs.dropdown", function () {
        $(this).find(".caret").toggleClass("caretup");
      });
    }
  };

  Drupal.behaviors.carousel = {
    attach: function () {
      $(".tal--image-gallery-categories .carousel").carousel({
        interval: false
      });

      $(".tal--image-gallery-categories .carousel .item").each(function () {
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

  Drupal.behaviors.scrollToTop = {
    attach: function () {
      $("#back-to-top").bind("click", function (e) {
        var id;

        // Prevent a page reload when a link is pressed.
        e.preventDefault();

        id = $(this).attr("href");

        // Remove "link" from the ID.
        id = id.replace("link", "");

        // Scroll to the div.
        $("html,body").animate({
          scrollTop: $(id).offset().top },
            "slow");
      });
    }
  };
  Drupal.behaviors.toggleaccordion = {
    attach: function () {
      function toggleIcon(e) {
        $(e.target).prev(".panel-heading").find(".more-less").toggleClass("glyphicon-plus glyphicon-minus");
      }
      $(".panel-group").on("hidden.bs.collapse", toggleIcon);
      $(".panel-group").on("shown.bs.collapse", toggleIcon);
      $(".history--tabs").tabCollapse();
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
  Drupal.behaviors.showMoreDownloads = {
    attach: function () {
      $("body").once("download-event").each(function () {
        var originalString = $("#download-more > a").text();

        $("#download-more > a").click(function () {
          $("#more-items-wrapper").slideToggle("slow", function () {
            $("#download-more > a").toggleClass("btn-less");
            if ($("#download-more > a").text() !== "See less") {
              $("#download-more > a").text(Drupal.t("See less"));
            }
            else {
              $("#download-more > a").text(originalString);
            }
          });
        });
      });
    }
  };

  Drupal.behaviors.activeLink = {
    attach: function () {
      $("body").once("active-link").each(function () {
        var fieldClass = "";

        if ($.QueryString.field === "field_left_link") {
          fieldClass = ".field--name-field-left-link";
        }
        else if ($.QueryString.field === "field_right_link") {
          fieldClass = ".field--name-field-right-link";
        }

        $(fieldClass + " .field--item").each(function (index, value) {
          if (index === $.QueryString.active) {
            $(this).addClass("active");
          }
        });
      });
    }
  };

  // Retrieve query string parameters.
  $.QueryString = (function (a) {
    if (a === "") {
      return {};
    }
    var b = {};

    for (var i = 0; i < a.length; ++i) {
      var p = a[i].split("=", 2);

      if (p.length !== 2) {
        continue;
      }
      b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
    }

    return b;
  })(window.location.search.substr(1).split("&"));
})(jQuery, Drupal);
