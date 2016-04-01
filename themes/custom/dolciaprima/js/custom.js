function centerModal() {
  jQuery(this).css('display', 'block');
  var $dialog = jQuery(this).find(".modal-dialog");
  var offset = (jQuery(window).height() - $dialog.height()) / 2;
  // Center modal vertically in window.
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
        videoSRCauto = videoSRC + "&autoplay=1";
        if ($('body').hasClass('path-frontpage')) {
          $(theModal + ' iframe').attr('src', videoSRC);
        } else {
          $(theModal + ' iframe').attr('src', videoSRCauto);
        }
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
  
  // Open tout content.
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

      // Resize window.
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
      // Smooth scrolling on click menu items.
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
        no_results_text: "No hemos encontrado resultados!",
        allow_single_deselect: true
      })

      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
      $('form').validate({
        highlight: function(element) {
          $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
          $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
          if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
          } else {
            error.insertAfter(element);
          }
        }
      });
    }
  }

  // Select other for those who have the other option field.
  Drupal.behaviors.selectOther = {
    attach: function (context, settings) {
      $('#edit-field-other-industry-wrapper').insertAfter('#edit-field-industry-wrapper');
      var other_field = $('div[class*="field--name-field-other-"]');
      var other_field_label = $('div[class*="field--name-field-other-"] label');
      other_field_label.hide();
      other_field.hide();
      $("option:contains('Other')").parent().each(function() {
        $(this).change(
          function () {
            if ($('option:selected', this).filter(":contains('Other')").length === 1) {
              $(this).closest('.field--widget-options-select').next('div[class*="field--name-field-other-"]').fadeIn();
              $(this).closest('.field--widget-options-select').next('div[class*="field--name-field-other-"]').find('input').prop('required', true);
            }
            else {
              $(this).closest('.field--widget-options-select').next('div[class*="field--name-field-other-"]').hide();
              $(this).closest('.field--widget-options-select').next('div[class*="field--name-field-other-"]').find('input').prop('required', false);
            }
          }
        );
      })
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

      $('.btn-close-form').click(function(e) {
        e.preventDefault();
        $('.pre-header').slideToggle('slow');
        $('.st-content').removeClass('contact-reveal');
      });
    }
  }

  Drupal.behaviors.submitContact = {
    attach: function (context, settings) {
      // Show "Thank you" message after submiting the form.
      $('.pre-header form').submit(function(e) {
        $.post('', $(this).serialize(), function (data) {

        }).error(function() {

        });
        $('.pre-header .form-body, .pre-header .header-text').hide();
        $(this).hide();
        $('.btn-close-form-submit-thank-you-message').show();
        $('.pre-header .form-submit-thank-you-message').show();
        e.preventDefault();
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