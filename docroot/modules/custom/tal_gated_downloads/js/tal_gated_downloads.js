(function ($, Drupal) {
    Drupal.behaviors.GatedDownloadsRedirect = {
        attach: function (context, settings) {
            $( document ).ready(function() {
                var path = window.location.pathname;
                var elements = [];
                var fid = '';
                elements = path.split('/');
                fid = elements[elements.length - 1];
                window.location.href = '/downloads/gated/file/' + fid;
            });
        }
    };
})(jQuery, Drupal);

