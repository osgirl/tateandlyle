  //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG

(function($) {

  // Unwrap html tags.
  Drupal.behaviors.overrideHTML = {
    attach: function (context, settings) {
      $('.paragraph--type--text img').unwrap();
      $('.paragraph--type--tout a').unwrap(); 
      $('.field--name-field-video-text a.video-button').unwrap();  
      $('a.video-button').insertAfter('.field--name-field-video-text h2');
      $('.field--name-field-title, h1, h2, h3, a, p ').each(function(i, elem) {
        $(elem).html(function(i, html) {
            return html.replace('®', "<sup>&reg;</sup>");
        });
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

  // Disable dropdown toggle.
  Drupal.behaviors.disableDropdowntoggle = {
    attach: function (context, settings) {
      $('a.dropdown-toggle').addClass('disabled');
    }
  }

// Open tout content
  Drupal.behaviors.opencloseTout = {
    attach: function (context, settings) {
      $('.field--name-field-title').click(function(e) {
        e.preventDefault();
        $(this).closest('.paragraph--type--tout').children('.field--name-field-text:first').fadeIn('fast');
        return false;
      });
      $(".btn-close").click(function (e) {
        e.preventDefault();
        $(this).closest(".field--name-field-text").fadeOut('fast');
        return false;
      });
    }
  }
    //Calculate size of touts.
    Drupal.behaviors.toutHeight = {
    attach: function (context, settings) {
       $height_content = $('.tout-parent').height() + 230;
       $height_content = $height_content/2;
       $('.tout-child').css('height', $height_content);
       if ( $( ".path-frontpage" ).length ) {
        $height_content = $('.paragraph--type--video').height() / 2;
        $('.tout-child').css('height', $height_content);
       }

      // Resize window
      $(window).resize(function(){
        $height_content = $('.tout-parent').height() + 230;
        $height_content = $height_content/2;
        $('.tout-child').css('height', $height_content);
        if ( $( ".path-frontpage" ).length ) {
          $height_content = $('.paragraph--type--video').height() / 2;
          $('.tout-child').css('height', $height_content);
       }
      })
    }
  };
  // Show language block on click.
  Drupal.behaviors.headerMobile = {
    attach: function (context, settings) {
      // Set variables.
      var language_icon = $('.language-switcher-language-url');
      var language_contents = $('.language-switcher-language-url').contents();
      var search_icon = $('.search-block-form');
      var search_contents = $('.search-block-form').contents();

      // Page load on mobile.
      if ($(window).outerWidth() <= 767) {
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
        if ($(window).outerWidth() <= 767) {
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
        if ($(window).outerWidth() <= 767) {
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
        if ($(window).outerWidth() <= 767) {
          search_icon.removeClass('active');
          $(this).toggleClass('active');
          search_mobile.hide();
          language_mobile.slideToggle();
        }
      });
    }
  };

  // Contact form reveal.
  Drupal.behaviors.toggleContact = {
    attach: function (context, settings) {
      var contactHeight = $('.pre-header').height();
      $('.menu.nav > li:last-child a, a[href="#contact-us"]').click(function(e) {
        e.preventDefault();
        $('.st-content').toggleClass('contact-reveal');
        if ($('.st-content').hasClass('contact-reveal')) {
          $('#st-container').removeClass('st-menu-open');
          $('.st-content').css({
            "transform": "translate3d(0px, " + contactHeight + "px, 0px)",
            'transition': 'all 0.3s',
          });
        } else {
          $('#st-container').removeClass('st-menu-open');
          $('.st-content').css({
            "transform": "translate3d(0px, 0px, 0px)",
            'transition': 'all 0.3s',
          });
        }
      });
      $('.bt-close-form').click(function(e) {
        e.preventDefault();
        $('.st-content').removeClass('contact-reveal');
          $('.st-content').css({
            "transform": "translate3d(0px, 0px, 0px)",
            'transition': 'all 0.8s',
          });
      });
    }
  }

  // Add touch events for Bootstrap carousel.
  Drupal.behaviors.swipeCarousel = {
    attach: function (context, settings) {
      $(".carousel").swiperight(function() {
        $(this).carousel('prev');
      });
      $(".carousel").swipeleft(function() {
        $(this).carousel('next');
      });
    }
  }

  Drupal.behaviors.BacktoTop = {
    attach: function (context, settings) {
      // Smooth scrolling on click menu items
      $('#back-to-top').on('click', function(e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 600);
      });
    }
  };

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