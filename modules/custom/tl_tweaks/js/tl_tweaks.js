/**
 * @file
 * Attaches several functionalities to the dolciaprima tweaks.
 */

(function ($) {
  Drupal.behaviors.tl_tweaks = {
    attach: function (context, settings) {
      if($('#download').lenght) {
        document.getElementById('download').click();
      }
    }
  };
})(jQuery);
