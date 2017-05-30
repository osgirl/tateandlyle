(function ($, Drupal) {
    Drupal.behaviors.GatedDownloadsRedirect = {
        attach: function (context, settings) {
            $( document ).ready(function() {
                window.location.href = '/downloads/gated/file';
            });
        }
    };
})(jQuery, Drupal);

