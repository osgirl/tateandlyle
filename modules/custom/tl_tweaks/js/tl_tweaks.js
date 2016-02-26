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
    }, 3000);
  };
})(jQuery);
