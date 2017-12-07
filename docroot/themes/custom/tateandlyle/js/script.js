/**
 * @file
 * Contains Tate and Lyle Custom Javascript behaviours.
 */

/**
 * Implements Drupal.behaviours.
 */
(function ($, Drupal, window) {
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

      $(".navbar-head .navbar-toggle").on("click", function () {
        $("body").toggleClass("black__overlay");
      });

      $(".ingredient--submenu .dropdown-toggle").text(
        $(".ingredient--submenu li:first a").text()
      );
    }
  };

  Drupal.behaviors.addplaceholder = {
    attach: function () {
      $("#block-mobile-menu .input--wrapper input").attr("placeholder", "Search here");
    }
  };

  Drupal.behaviors.movetitle = {
    attach: function () {
      if ($(".block--single-item-promo-background").hasClass("block__sip--nobackground")) {
        $(".block__sip--nobackground .block-title").prependTo(".block__sip--nobackground");
      }

      $(".form-type-textfield").each(function () {
        var $input = $(this);

        $input.find(".description").appendTo($input.find(".input--title"));
      });
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

  Drupal.behaviors.ellipsis = {
    attach: function () {
      $(".twocol__title__wrap").dotdotdot();
      $(".threecol__title__wrap").dotdotdot();
      $(".three--columns.block--dynamic-posts .field--name-body").dotdotdot();
      $(".two--columns.block--dynamic-posts .field--name-body").dotdotdot();
    }
  };

  Drupal.behaviors.arrowToggle = {
    attach: function () {
      $(".dropdown").on("show.bs.dropdown hide.bs.dropdown", function () {
        $(this).find(".caret").toggleClass("caretup");
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
      if ($(".ingredient--submenu").length) {
        $(".ingredient--submenu .dropdown-menu a").on("click", function (e) {
          e.preventDefault();

          // Animate.
          $("html, body").animate({
            scrollTop: $(this.hash).offset().top - 180
          }, 300);
        });
      }
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
          if (index == $.QueryString.active) {
            $(this).addClass("active");
          }
        });
      });

      if ($(".field--type-link .field--item").hasClass("active")) {
        $(".no__icon--banner .dropdown-toggle").text(
          $(".field--type-link .active a").text()
        );
      }
      else {
        $(".no__icon--banner .dropdown-toggle").text(
          $(".field--type-link .field--item a").first().text()
        );
      }
    }
  };

  Drupal.behaviors.dynamicPost = {
    attach: function (context) {
      $("body").once(".tal-dynamic").each(function () {
        var id = "";
        var href = "";

        id = jQuery("div[data-id]", context).attr("data-id");
        jQuery(".view-focus-on-tag-list .views-row .use-ajax-link", context).each(function () {
          href = $(this).attr("href");
          href = href + "/" + id;
          $(this).attr("href", href);
        });
        Drupal.reattach_ajax_behaviors(context);
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

  /**
   * Javascript function to reattach ajax behaviors.
   */
  // Bind Ajax behaviors to all items showing the class.
  Drupal.reattach_ajax_behaviors = function (context) {
    $(".use-ajax-link", context).once("tal-ajax").each(function () {
      var element_settings = {};

      // Clicked links look better with the throbber than the progress bar.
      element_settings.progress = { type: "throbber" };
      var href = $(this).attr("href");

      // For anchor tags, these will go to the target of the anchor rather
      // than the usual location.
      if (href) {
        element_settings.url = href;
        element_settings.event = "click";
      }
      element_settings.dialogType = $(this).data("dialog-type");
      element_settings.dialog = $(this).data("dialog-options");
      element_settings.base = $(this).attr("id");
      element_settings.element = this;
      Drupal.ajax(element_settings);
    });
  };

  Drupal.behaviors.newsletterSubscription = {
    attach: function (context) {

      $('#webform-submission-newsletter-subsciption-form', context).once('scroll-subscription').each(function () {
        var query_string = window.location.search.substr(1).split("&");
        if(query_string.length == 2) {
          var token = query_string[0].split("=");
          var webform = query_string[1].split("=");
          if(token[0] == 'token' && token[1] != "" && webform[0] == 'webform_id' && webform[1] == 'newsletter_subsciption') {
            $("html,body").animate({
                  scrollTop: $("#webform-submission-newsletter-subsciption-form").offset().top - 100 }, "slow");
          }
        }
      });
    }
  };


})(jQuery, Drupal, this);
