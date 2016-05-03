// Vertical align the modal.
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
      $('.field--name-field-text img, .field--name-field-body img').unwrap();
      
      $('.field--name-field-video-text a.video-button').unwrap();  
      $('a.video-button').insertAfter('.field--name-field-video-text h2');

      // Make the products clickable.
      $(".products .tout-container").click(function() {
        window.location = $(this).find("a").attr("href"); 
        return false;
      });

      // Make the homepage touts clickable.
      $(".field--name-field-touts .tout-container").click(function() {
        window.location = $(this).find("a").attr("href"); 
        return false;
      });

      // Set same height on elements on form page.
      if ($('.is-form').length) {
        if($('.field--name-field-form').length) {
          $height_form = $('.field--name-field-form')[0].getBoundingClientRect().height + $('.field--name-field-form-header')[0].getBoundingClientRect().height;
          $height_form_2 = $height_form - $('.field--name-field-form-header').innerHeight();
          $('.field--name-field-form').css('height', $height_form_2);
          $('.field--name-field-main-content').css('height', $height_form);
        }
        else {
          $height_form = $('.field--name-field-main-content')[0].getBoundingClientRect().height;
          $('.field--name-field-form-header').css('height', $height_form);
        }
      }

      // Resize window.
       $(window).resize(function() {
         // Set same height on elements on form page.
         if($('.is-form').length) {
          if($('.field--name-field-form').length) {
            $height_form = $('.field--name-field-form')[0].getBoundingClientRect().height + $('.field--name-field-form-header')[0].getBoundingClientRect().height;
            $height_form_2 = $height_form - $('.field--name-field-form-header').innerHeight();
            $('.field--name-field-form').css('height', $height_form_2);
            $('.field--name-field-main-content').css('height', $height_form )
          }
          else {
            if($(window).width() > 1006) {
              $height_form = $('.field--name-field-main-content')[0].getBoundingClientRect().height;
              $('.field--name-field-form-header').css('height', $height_form);
            } else {
              $('.field--name-field-form-header').css('height', '');
            }
          }
        }
      })

      // Make trademark and registered symbols superscript.
      $('body :not(script)').contents().filter(function() {
        return this.nodeType === 3;
      }).replaceWith(function() {
        return this.nodeValue.replace(/[™®]/g, '<sup>$&</sup>');
      });

      // Add form before content on mobile.
      if ($('.is-form .field--name-field-form-header').css('width') == '70%') {
        // Do nothing.
      } else {
        $('.is-form .field--name-field-main-content').insertAfter('.is-form .field--name-field-form');
      }

      // Set the height for the footer.
      var NavHeight = $('#navbar').height();
      var FooterHeight = $('.full-footer').height();
      if ($('.navbar').css('position') == 'absolute') {
        $('.region-navigation').height(NavHeight - FooterHeight);
      } else {
        $('.region-navigation').height('auto');
      }
      $(window).resize(function() {
        if ($('.navbar').css('position') == 'absolute') {
          $('.region-navigation').height(NavHeight - FooterHeight);
        } else {
          $('.region-navigation').height('auto');
        }
      })
    }
  };

  // Carousel options.
  Drupal.behaviors.carouselOptions = {
    attach: function (context, settings) {
      $('.carousel').each(function() {
         $(this).attr('data-interval', $(this).closest('.paragraph--type--slide').find('.field--name-field-timeout').text());
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

  // Modal video.
  Drupal.behaviors.modalVideo = {
    attach: function (context, settings) {
      var trigger = $("body").find('[data-toggle="modal"]');
      trigger.click(function () {
        var theModal = $(this).data("target"),
        videoSRC = $(this).attr("data-theVideo"),
        videoSRCauto = videoSRC + "&autoplay=1";
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

  // Validate forms.
  Drupal.behaviors.ValidateEachForm = {
    attach: function (context, settings) {
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });

      $('form').each(function() {  // attach to all form elements on page
        $(this).validate({       // initialize plugin on each form
            highlight: function (element) {
              $(element).closest('.form-group').removeClass('checked').addClass('error');
              $(element).next().removeClass('checked').addClass('error');
            },
            success: function (element) {
              $(element).closest('.form-group').removeClass('error').addClass('checked');
              $(element).next().removeClass('error').addClass('checked');
            }
        });
      });

      $("option[value='_none']").attr("disabled", true);
     

      $('select').on('change', function () {
        $(this).valid();
      });

    }
  }
 
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
      });
    }
  }

  // Select other for those who have the other option field.
  Drupal.behaviors.selectOther = {
    attach: function (context, settings) {
      var other_field = $('div[class*="field--name-field-other-"]');
      var other_field_label = $('div[class*="field--name-field-other-"] label');
      other_field_label.hide();
      other_field.hide();  
      $('option[value="other"]').parent().each(function() {
        $(this).change(
          function () {
            if ($('option:selected', this).val() == 'other') {
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

})(jQuery);