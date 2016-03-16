/**
 * @file
 * Attaches several functionalities to the dolciaprima tweaks.
 */

(function ($) {
  Drupal.behaviors.tl_tweaks = {
    attach: setTimeout(function (context, settings) {
      if($('#download').length) {
        document.getElementById('download').click();
      }
    }, 3000)
  };

  Drupal.behaviors.tl_placeholder = {
    attach: function (context, settings) {
    	$("input[name='field_touts_tout_add_more']").val('Block');
    	$('#edit-field-touts-wrapper .placeholder').text('Block');
  	}
  };

})(jQuery);
