/**
 * @file
 * Attaches several functionalities to the dolciaprima tweaks.
 */

(function ($) {
  Drupal.behaviors.tl_tweaks_dolciaprima = {
    attach: function (context, settings) {
    $('.tds_contact').click(function(e) {
      e.preventDefault();
      $('.st-pusher').toggleClass('show-contact');
      if ($('#st-container').hasClass('st-menu-open')) {
        $('#st-container').removeClass('st-menu-open');
      }
    });
	
	var Submitted = location.search.split('submitted=')[1]
	  if (Submitted == 'true') {
        $('.field--name-field-tds-thank-you').toggle();	  
	  }
    }
  };
})(jQuery);
