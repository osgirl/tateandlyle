// Vertical align the modal.
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
      // Make trademark and registered sybmols superscript.
      $('body :not(script)').contents().filter(function() {
        return this.nodeType === 3;
      }).replaceWith(function() {
        return this.nodeValue.replace(/[™®]/g, '<sup>$&</sup>');
      });

      // Show the first block after the main image/slider on mobile.
      if ($('.tl-one-sidebar.path-frontpage .field--name-field-touts >div').css('float') == 'left') {
        // Target desktop media query.
      } else {
        // Target max-width sm media query. 
        $('.tl-one-sidebar.path-frontpage .field--name-field-touts>.field--item:first-child').addClass('home-two-col-left-block');
        $('.tl-one-sidebar.path-frontpage .field--name-field-touts .home-two-col-left-block').appendTo('.tl-one-sidebar.path-frontpage aside');
      }

      $(window).resize(function() {
        // Show the first block after the main image/slider on mobile.
        if ($('.tl-one-sidebar.path-frontpage .field--name-field-touts > div').css('float') == 'left') {
          // Target desktop media query.
          if ($('.tl-one-sidebar.path-frontpage aside .home-two-col-left-block').length) {
            // If home-two-col-left-block is in the sidebar.
            $('.tl-one-sidebar.path-frontpage aside .home-two-col-left-block').insertBefore('.tl-one-sidebar.path-frontpage .field--name-field-touts > div');
            $('.tl-one-sidebar.path-frontpage .field--name-field-touts .home-two-col-left-block').removeClass('home-two-col-left-block');
          } else {
            // If home-two-col-left-block is not in the sidebar.
          }
       
        } else {
          if ($('.tl-one-sidebar.path-frontpage aside .home-two-col-left-block').length) {
            // If home-two-col-left-block is in the sidebar.
          } else {
            // If home-two-col-left-block is not in the sidebar.
            $('.tl-one-sidebar.path-frontpage .field--name-field-touts>.field--item:first-child').addClass('home-two-col-left-block');
            $('.tl-one-sidebar.path-frontpage .field--name-field-touts .home-two-col-left-block').appendTo('.tl-one-sidebar.path-frontpage aside');
          }
        }
      })
    }
  }

  // Modify header region for mobile.
  Drupal.behaviors.headerMobile = {
    attach: function (context, settings) {
      // Set the variables.
      var language_icon = $('.language-switcher-language-url');
      var language_contents = $('.language-switcher-language-url').contents();
      var search_icon = $('header .search-api-page-block-form');
      var search_contents = $('header .search-api-page-block-form').contents();

      var MacOS = navigator.appVersion.indexOf("Mac")!=-1; // Get Mac Operationg System
      var Windows = navigator.appVersion.indexOf("Win")!=-1; // Get Windows

      var firefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");

      var windowWidth = 974;

      if (firefox) {
        windowWidth = 991;
      }

      if (!!navigator.userAgent.match(/Trident.*rv\:11\./)) { // If Internet Explorer, return version number
        windowWidth = 991;
      }

      if (MacOS) {
        windowWidth = 991;
      }

      if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        windowWidth = 991; // Target Safari
      }

      if (jQuery && jQuery.browser && (m = (navigator.userAgent).match(/Edge\/(1[2-9]|[2-9]\d|\d{3,})\./))) {
        windowWidth = 991; // Target Microsoft Edge
      }

      // Page load on mobile.
      if ($(window).outerWidth() <= windowWidth) {
        // Place Search mobile section in the Header Bottom section.
        search_contents.insertAfter('.header-right');
        search_contents.wrapAll('<section class="header-bottom"></section>');
        search_contents.wrapAll('<section class="search-mobile"></section>');

        // Place Language mobile section in the Header Bottom section.
        language_contents.insertAfter('.search-mobile');
        language_contents.wrapAll('<section class="language-mobile"></section>');
      } else {
        language_icon.removeClass('active');
        search_icon.removeClass('active');
      }

      // Window resize event.
      $(window).resize(function() {
        var language_contents_mobile = $('.language-mobile').contents();
        var search_contents_mobile = $('.search-mobile').contents();
        if ($(window).outerWidth() <= windowWidth) {
          // Place Search mobile section in the Header Bottom section.
          if (search_contents.parent().hasClass('search-api-page-block-form')) {
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
          search_contents_mobile.appendTo('header .search-api-page-block-form');
          language_contents_mobile.appendTo('.language-switcher-language-url');
          language_icon.removeClass('active');
          search_icon.removeClass('active');
        }
      });

      // Search block slide toggle effect.
      search_icon.click(function() {
        var language_mobile = $('.language-mobile');
        var search_mobile = $('.search-mobile');
        if ($(window).outerWidth() <= windowWidth) {
          language_icon.removeClass('active');
          $(this).toggleClass('active');
          language_mobile.hide();
          search_mobile.slideToggle();
        }
      });

      // Language block slide toggle effect.
      language_icon.click(function() {
        var language_mobile = $('.language-mobile');
        var search_mobile = $('.search-mobile');
        if ($(window).outerWidth() <= windowWidth) {
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

  // Modal style.
  Drupal.behaviors.modalstyle = {
    attach: function (context, settings) {
      $('.modal').on('show.bs.modal', centerModal);
      $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
      });
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
  
  // Carousel options.
  Drupal.behaviors.carouselOptions = {
    attach: function (context, settings) {
      $('.carousel').each(function() {
         $(this).attr('data-interval', $(this).closest('.paragraph--type--slide').find('.field--name-field-timeout').text());
      });
    }
  }

  // Select "Other" field for those who have the other option field.
  Drupal.behaviors.selectOther = {
    attach: function (context, settings) {
      $('.pre-header .field--name-field-other-industry').insertAfter('.pre-header .field--name-field-industry');
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

  Drupal.behaviors.ValidateEachForm = {
    attach: function (context, settings) {
      $.validator.setDefaults({ ignore: ":hidden:not(select)" });
      $('form').each(function() {  // attach to all form elements on page.
        $(this).validate({       // initialize plugin on each form.

          errorPlacement: function(error, element) {
            if(element.parent('.form-group').length) {
              error.insertAfter(element.parent());
            } else if (element.is('select')) {
              error.insertBefore(element);
            } else {
              error.insertAfter(element);
            }
          },

          highlight: function (element) {
            $(element).closest('.form-wrapper').removeClass('checked').addClass('error');
            //$(element).next().removeClass('checked').addClass('error');
          },
          success: function (element) {
            $(element).closest('.form-wrapper').removeClass('error').addClass('checked');
            //$(element).next().removeClass('error').addClass('checked');
          }

        });
      });

      $("option[value='_none']").attr("disabled", true);
     
      $('select').on('change', function () {
          $(this).valid();
      });
    }
  }

  // Mailto functionality from the Utility navigation.
  Drupal.behaviors.mailTo = {
    attach: function (context, settings) {
      $('.utility-navigation .email a').on('click', function(e) {
        var pageTitle = document.title;
        var pageURL = location.href;
        
        pageTitle = encodeURIComponent(pageTitle);
        pageURL = encodeURIComponent(pageURL);
        
        mail_str = "mailto:?subject= " + pageTitle;
        mail_str += "&body=Have a look at the " + pageTitle + " page : " + pageURL;

        e.preventDefault();
        location.href = mail_str;
      });
    }
  }

})(jQuery);