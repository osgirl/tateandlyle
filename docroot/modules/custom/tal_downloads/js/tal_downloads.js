(function ($, Drupal) {
    Drupal.behaviors.ShowDownloadLink = {
        attach: function (context, settings) {
            $('[id^=edit-language-]').each(function () {
                $(this).change(function(){
                    var wid, str, pid;
                    str = $(this).attr('id');
                    wid = str.replace('edit-language-', '');
                    pid = $(this).val();
                    jQuery('#download-link-' + wid).load("/downloads/file/" + wid + "/" + pid);
                });
            });
        }
    };
})(jQuery, Drupal);