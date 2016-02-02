  //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG

(function($) {

  // Unwrap html tags.
  Drupal.behaviors.overrideHTML = {
    attach: function (context, settings) {    

      $(".products .tout-container").click(function() {
        window.location = $(this).find("a").attr("href"); 
        return false;
      });

      $(".field--name-field-touts .tout-container").click(function() {
        window.location = $(this).find("a").attr("href"); 
        return false;
      });

      if($('.is-form').length) {
        $height_form = $('.field--name-field-form').height() + $('.field--name-field-form-header').height() + 222;
        $('.field--name-field-main-content').css('height', $height_form )
      }
      // Resize window
       $(window).resize(function(){
         if($('.is-form').length) {
           $height_form = $('.field--name-field-form').height() + $('.field--name-field-form-header').height() + 218;
           $('.field--name-field-main-content').css('height', $height_form )
         }
      })
    

    }
  };

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
        placeholder_text_multiple: "(Select up to 3)",
        max_selected_options: 3,
      });

      $('select').chosen({
        disable_search: true,
      });

      // Add empty option value
      //$(".chosen-container-single ul").prepend("<li class='active-result result-selected' data-option-array-index="0"></li>");
    }
  }

})(jQuery);