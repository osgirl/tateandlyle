/**
 * @file
 * Attaches several functionalities to the dolciaprima tweaks.
 */

(function ($) {
  Drupal.behaviors.tl_tweaks_dolciaprima = {
    attach: function (context, settings) {
    var contactHeight = $('.pre-header').height();
    $('.tds_contact').click(function(e) {
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
	
	var Submitted = location.search.split('submitted=')[1]
	  if (Submitted == 'true') {
        $('.field--name-field-tds-thank-you').toggle();	  
	  }
    }
  };
})(jQuery);
