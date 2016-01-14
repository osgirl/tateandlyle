(function($) {
  // Show language block on click
  Drupal.behaviors.toggleLanguageblock = {
    attach: function (context, settings) {
      // Clickable parent menu dropdown link
       $('a.dropdown-toggle').addClass('disabled');
       
      // Language switcher functionality settings
      $('.language-switcher-language-url').click(function() {
        if ($('#search-block-form').is(':visible')) {
          $('#search-block-form').hide();
        }
        $('header .links').fadeToggle('slow', 'linear');
      });

       // Functionality settings
      $('.search-block-form').click(function() {
        if ($('header .links').is(':visible')) {
          $('header .links').hide()
        }
        $('#search-block-form').fadeToggle('slow', 'linear');
      });

      // Page load on mobile
      if ($(window).outerWidth() <= 767) {
     /* Language block
        Visibility settings */
        if ($('.language-switcher-language-url .links').is(':visible')) {
          $('.language-switcher-language-url .links').hide();
        }
        // Position settings
        if ($('.header-right').next() != '.links') {
          $('.language-switcher-language-url .links').insertAfter('.header-right');
        }

     /* Search block
        Visibility settings */
        if ($('.search-block-form form').is(':visible')) {
          $('.search-block-form form').hide();
        }

        // Position settings
        if ($('.header-right').next().next() != '#search-block-form') {
          $('#search-block-form').insertAfter('.header-right');
        }
      }

      // Resize window
      $(window).resize(function(){
        if ($(window).outerWidth() <= 767) {
       /* Language block
          Visibility settings */
          if ($('.language-switcher-language-url .links').is(':visible')) {
            $('.language-switcher-language-url .links').hide();
          }
          // Position settings
          if ($('.header-right').next() != '.links') {
            $('.language-switcher-language-url .links').insertAfter('.header-right');
          }

       /* Search block
          Visibility settings */
          if ($('#search-block-form').is(':visible')) {
            $('#search-block-form').hide();
          }
          // Position settings
          if ($('.header-right').next().next() != '#search-block-form') {
            $('#search-block-form').insertAfter('.header-right');
          }
        }
        else {
        /* Language block
           Position settings */
          if ($('.language-switcher-language-url div').next() != '.links') {
            $('header > .links').insertAfter('.language-switcher-language-url div');
          }
          // Visibility settings
          if (!$('.language-switcher-language-url .links').is(':visible')) {
            $('.language-switcher-language-url .links').show();
          }

        /* Search block
           Position settings */
          if ($('.search-block-form div').next() != '#search-block-form') {
            $('#search-block-form').insertAfter('.search-block-form > div');
          }
          // Visibility settings
          if (!$('#search-block-form').is(':visible')) {
            $('#search-block-form').show();
          }
        }
      })
    }
  };

})(jQuery);