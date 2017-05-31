(function ($, Drupal) {
    Drupal.behaviors.ShowDownloadLink = {
        attach: function (context, settings) {
            $('[id^=edit-language-]', context).each(function () {
                $(this).change(function(){
                    var wid, str, pid;
                    str = $(this).attr('id');
                    wid = str.replace('edit-language-', '');
                    pid = $(this).val();
                    jQuery('#download-link-' + wid).load("/downloads/file/" + wid + "/" + pid, function (){
                       Drupal.attachBehaviors($('#download-link-' + wid)); 
                    });
                });
            });

            $(".select-variant select").change(function () {
                $(this).find("option:selected").each(function () {
                    var optionValue = $(this).attr("value");
                    if(optionValue){
                        $(".paragraph--type--sap-downloads").not("." + optionValue).css("display", "none");
                        $("." + optionValue).css("display", "table");
                    }

                    if($(this).attr("value") == "empty_select") {
                        $(".paragraph--type--sap-downloads").css("display", "none");
                    }
                });

                $(".sap__downloads--button").first().removeClass('hide-content');
            }).change();

            $(".sap__downloads select").change(function () {
                $(this).find("option:selected").each(function () {
                    var selectValue = $(this).attr("value");
                    if(selectValue) {
                        $(".sap__downloads--button, .inactive--download").addClass('hide-content');
                        $("." + selectValue).removeClass('hide-content').addClass('show-inline');
                    }

                    if($(this).attr("value") == "empty_selector") {
                        $(".sap__downloads--button").addClass('hide-content');
                        $(".inactive--download").removeClass('hide-content').addClass('show-inline');
                    }
                });
            }).change();

            $(".sap__downloads--button").first().removeClass('hide-content');
        }
    };

    Drupal.behaviors.gateddownloads = {
        attach: function (context, settings) {
            $('.btn--download', context).each(function () {
                $(this).on('click', function(e){
                   e.preventDefault();
                    var fid = '';
                    fid = $(this).attr('data-file');
                    $('#edit-file-id').val(fid);
                });
            });
        }
    };
})(jQuery, Drupal);
