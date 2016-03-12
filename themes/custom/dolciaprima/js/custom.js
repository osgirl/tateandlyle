function centerModal() {
  jQuery(this).css('display', 'block');
  var $dialog = jQuery(this).find(".modal-dialog");
  var offset = (jQuery(window).height() - $dialog.height()) / 2;
  // Center modal vertically in window
  $dialog.css("margin-top", offset);
}

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

  // Disable accordion toggle when are links inside.
  Drupal.behaviors.enableAccordionlink = {
    attach: function (context, settings) {
      $('.accordion-set a').click(function(e){
        e.stopPropagation(); 
      });
    }
  }

  // Modal style.
  Drupal.behaviors.modalstyle = {
    attach: function (context, settings) {
      $('.modal').on('show.bs.modal', centerModal);
      $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
      });
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

  // Redirect selector.
  Drupal.behaviors.redirectSelector123 = {
    attach: function (context, settings) {
      var redirect_link = $('#redirect_selector option:selected').val();
      $('#redirect_selector').attr("action", redirect_link);
      $( '#redirect_selector').change(function() {
        var redirect_link = $('#redirect_selector option:selected').val();
        $('#redirect_selector').attr("action", redirect_link);
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

      $('select').chosen({
        disable_search: true,
      })

      // Marketing form
      // Other Job Title visibility
      $('#edit-field-other-job-title-wrapper').hide();
      $('#edit-field-other-job-title-wrapper label').hide();
      $('#edit-field-job-title').change(
        function () {
          if ($("#edit-field-job-title option:selected").filter(":contains('Other')").length != 0) {
            $("#edit-field-other-job-title-wrapper").fadeIn();
            $("#edit-field-other-job-title-wrapper input").prop('required',true);
          }
          else {
            $("#edit-field-other-job-title-wrapper").hide();
            $("#edit-field-other-job-title-wrapper input").prop('required',false);
          }
        }
      );

      // Other Industry visibility
      $('#edit-field-other-industry-wrapper').hide();
      $('#edit-field-other-industry-wrapper label').hide();
      $('#edit-field-industry').change(
        function () {
          if ($("#edit-field-industry option:selected").filter(":contains('Other')").length != 0) {
            $("#edit-field-other-industry-wrapper").fadeIn();
            $("#edit-field-other-industry-wrapper input").prop('required',true);
          }
          else {
            $("#edit-field-other-industry-wrapper").hide();
            $("#edit-field-other-industry-wrapper input").prop('required',false);
          }
        }
      );

      // Other Primary Application visibility
      $('#edit-field-other-primary-application-wrapper').hide();
      $('#edit-field-other-primary-application-wrapper label').hide();
      $('#edit-field-primary-application').change(
        function () {
          if ($("#edit-field-primary-application option:selected").filter(":contains('Other')").length != 0) {
            $("#edit-field-other-primary-application-wrapper").fadeIn();
            $("#edit-field-other-primary-application-wrapper input").prop('required',true);
          }
          else {
            $("#edit-field-other-primary-application-wrapper").hide();
            $("#edit-field-other-primary-application-wrapper input").prop('required',false);
          }
        }
      );

      // Dolcia Prima Header Top
      // Other Job Title visibility
      $('#edit-field-other-job-title-wrapper--2').hide();
      $('#edit-field-other-job-title-wrapper--2 label').hide();
      $('#edit-field-job-title--2').change(
        function () {
          if ($("#edit-field-job-title--2 option:selected").filter(":contains('Other')").length != 0) {
            $("#edit-field-other-job-title-wrapper--2").fadeIn();
            $("#edit-field-other-job-title-wrapper--2 input").prop('required',true);
          }
          else {
            $("#edit-field-other-job-title-wrapper--2").hide();
            $("#edit-field-other-job-title-wrapper--2 input").prop('required',false);
          }
        }
      );

      // Other Industry visibility
      $('#edit-field-other-industry-wrapper--2').hide();
      $('#edit-field-other-industry-wrapper--2 label').hide();
      $('#edit-field-other-industry-wrapper').insertAfter('#edit-field-industry-wrapper');
      $('#edit-field-industry--2').change(
        function () {
          if ($("#edit-field-industry--2 option:selected").filter(":contains('Other')").length != 0) {
            $("#edit-field-other-industry-wrapper--2").fadeIn();
            $("#edit-field-other-industry-wrapper--2 input").prop('required',true);
          }
          else {
            $("#edit-field-other-industry-wrapper--2").hide();
            $("#edit-field-other-industry-wrapper--2 input").prop('required',false);
          }
        }
      );

      // Other Primary Application visibility
      $('#edit-field-other-primary-application-wrapper--2').hide();
      $('#edit-field-other-primary-application-wrapper--2 label').hide();
      $('#edit-field-primary-application--2').change(
        function () {
          if ($("#edit-field-primary-application--2 option:selected").filter(":contains('Other')").length != 0) {
            $("#edit-field-other-primary-application-wrapper--2").fadeIn();
            $("#edit-field-other-primary-application-wrapper--2 input").prop('required',true);
          }
          else {
            $("#edit-field-other-primary-application-wrapper--2").hide();
            $("#edit-field-other-primary-application-wrapper--2 input").prop('required',false);
          }
        }
      );
    }
  }

    // Contact form reveal.
  Drupal.behaviors.toggleContact = {
    attach: function (context, settings) {
      $('.menu.nav > li:last-child a, a[href="#contact-us"]').click(function(e) {
        e.preventDefault();
        $('.pre-header').slideToggle('fast');
        $('.st-content').toggleClass('contact-reveal');
        if ($('.st-content').hasClass('contact-reveal')) {
          $('#st-container').removeClass('st-menu-open');
        } else {
          $('#st-container').removeClass('st-menu-open');
        }
      });

      $('.bt-close-form').click(function(e) {
        e.preventDefault();
        $('.pre-header').slideToggle('slow');
        $('.st-content').removeClass('contact-reveal');
      });
    }
  }

    // External links in new window
    $("a[href^='http']:not([href*='" + window.location.host + "'])").addClass("external").attr({ target: "_blank" });

    var hashVal = window.location.hash.split("#")[1];
    if (hashVal == 'contact') {
        $('.pre-header').slideDown('slow');
    }
    else if (hashVal == 'video') {
        setTimeout(function(){
            $(".btn-video-play").click();
        },1500);
        setTimeout(function(){
            if ( videoPlayer != undefined ) {
                videoPlayer.play();
            }
        },2500);
    }
    else if ($.inArray(hashVal, ['soda','baking','dairy']) > -1) {
        console.log('yes');
        $(".btn-media-library-play." + hashVal).click();
    }

})(jQuery);