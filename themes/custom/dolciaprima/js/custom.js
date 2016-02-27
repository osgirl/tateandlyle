(function($) {
  // Override HTML.
  Drupal.behaviors.overrideHTML = {
    attach: function (context, settings) {
      // Unrap elements.
      $('.paragraph--type--text img').unwrap();
      $('.paragraph--type--tout a').unwrap(); 
      $('.field--name-field-video-text a.video-button').unwrap();  
      $('a.video-button').insertAfter('.field--name-field-video-text h2');

      // Make trademark and registered symbols superscript.
      $('body :not(script)').contents().filter(function() {
        return this.nodeType === 3;
      }).replaceWith(function() {
        return this.nodeValue.replace(/[™®]/g, '<sup>$&</sup>');
      });
    }
  }

  // Modal video.
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

  // Calculate the size of touts.
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

  // Back to top functionality.
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

  // Chosen options.
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
    }
  }

})(jQuery);