/**
 * @file
 * Attaches behaviors for image gallery download widget.
 */
(function ($, Drupal) {

    "use strict";

    Drupal.behaviors.DownloadImage = {
        attach: function (context, settings) {
            $(context).bind('cbox_complete', function () {
                // Add download link and move title.
                if ($('#cboxLoadedContent > img').attr('src')) {
                    var fullHref = $('#cboxLoadedContent > img').attr('src').replace(/styles\/large\/public\//,'');
                    var fullLink = $('<a/>');
                    var filename =  fullHref.substr(fullHref.lastIndexOf("/")+1);
                    fullLink.attr('href', fullHref);
                    fullLink.attr('class', 'btn-primary download-image');
                    fullLink.attr('target', 'new');
                    fullLink.attr('title', Drupal.t('Right click to download'));
                    fullLink.attr('download', filename);
                    fullLink.text(Drupal.t('Download'));
                    $('#cboxLoadedContent').append(fullLink);
                }
            });
        }
    };

})(jQuery, Drupal);

