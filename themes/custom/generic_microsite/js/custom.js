(function($) {
  // Show language block on click.
  Drupal.behaviors.headerMobile = {
    attach: function (context, settings) {
      // Set variables.
      var language_icon = $('.language-switcher-language-url');
      var language_contents = $('.language-switcher-language-url').contents();
      var search_icon = $('.search-block-form');
      var search_contents = $('.search-block-form').contents();

      // Page load on mobile.
      if ($(window).outerWidth() <= 750) {
        // Place Search mobile section in the Header Bottom section.
        search_contents.insertAfter('.header-right');
        search_contents.wrapAll('<section class="header-bottom"></section>');
        search_contents.wrapAll('<section class="search-mobile"></section>');

        // Place Language mobile section in the Header Bottom section.
        language_contents.insertAfter('.search-mobile');
        language_contents.wrapAll('<section class="language-mobile"></section>');
      }

      // Window resize.
      $(window).resize(function() {
        var language_contents_mobile = $('.language-mobile').contents();
        var search_contents_mobile = $('.search-mobile').contents();
        if ($(window).outerWidth() <= 750) {
          // Place Search mobile section in the Header Bottom section.
          if (search_contents.parent().hasClass('search-block-form')) {
            search_contents.insertAfter('.header-right');
            search_contents.wrapAll('<section class="header-bottom"></section>');
            search_contents.wrapAll('<section class="search-mobile"></section>');
          }

          // Place Language mobile section in the Header Bottom section.
          if (language_contents.parent().hasClass('language-switcher-language-url')) {
            language_contents.insertAfter('.search-mobile');
            language_contents.wrapAll('<section class="language-mobile"></section>');
          }
        }
        else {
          // Place Search and Language in the Header Right section.
          $('.header-bottom').remove();
          search_contents_mobile.appendTo('.search-block-form');
          language_contents_mobile.appendTo('.language-switcher-language-url');
        }
      });

      // Search block fade effect.
      search_icon.click(function() {
        var language_mobile = $('.language-mobile');
        var search_mobile = $('.search-mobile');
        if ($(window).outerWidth() <= 750) {
          language_icon.removeClass('active');
          $(this).toggleClass('active');
          language_mobile.hide();
          search_mobile.slideToggle();
        }
      });

      // Language block fade effect.
      language_icon.click(function() {
        var language_mobile = $('.language-mobile');
        var search_mobile = $('.search-mobile');
        if ($(window).outerWidth() <= 750) {
          search_icon.removeClass('active');
          $(this).toggleClass('active');
          search_mobile.hide();
          language_mobile.slideToggle();
        }
      });
    }
  };

  // Disable dropdown toggle.
  Drupal.behaviors.disableDropdowntoggle = {
    attach: function (context, settings) {
      $('a.dropdown-toggle').addClass('disabled');
    }
  }

   // Disable accordion toggle when are links inside.
  Drupal.behaviors.enableAccordionlink = {
    attach: function (context, settings) {
      $('.accordion-set a').click(function(e){
        e.stopPropagation(); 
      });
    }
  }

  // Redirect selector.
  Drupal.behaviors.redirectSelector = {
    attach: function (context, settings) {
      var redirect_link = $('#redirect_selector option:selected').val();
      $('#redirect_selector').attr("action", redirect_link);
      $( '#redirect_selector').change(function() {
        var redirect_link = $('#redirect_selector option:selected').val();
        $('#redirect_selector').attr("action", redirect_link);
      });
    }
  }


    //Modal video
  Drupal.behaviors.modalVideo = {
    attach: function (context, settings) {
      var trigger = $("body").find('[data-toggle="modal"]');
      trigger.click(function () {
        var theModal = $(this).data("target"),
        videoSRC = $(this).attr("data-theVideo"),
        videoSRCauto = videoSRC + "?autoplay=1";
        $(theModal + ' iframe').attr('src', videoSRCauto);
        $(theModal + ' button.close').click(function () {
          $(theModal + ' iframe').attr('src', videoSRC);
        });
        $('.modal').click(function () {
          $(theModal + ' iframe').attr('src', videoSRC);
        });
      });
    }
  }
        
  Drupal.behaviors.carouselOptions = {
    attach: function (context, settings) {
      $('.field--name-field-timeout').hide();
      $('.carousel').each(function() {
         $(this).attr('data-interval', $(this).closest('.paragraph--type--slide').find('.field--name-field-timeout').text())
      });
    }
  }

  Drupal.behaviors.chosen = {
    attach: function (context, settings) {
      $('.field--name-field-primary-application select, .field--name-field-interests select').chosen({
        disable_search: true,
        placeholder_text_multiple: "(Select up to 3)",
        max_selected_options: 3,
      });

      $('#edit-field-country-list').chosen({
        disable_search: false,
      });

      $('select').chosen({
        disable_search: true,
      });
    }
  }

})(jQuery);