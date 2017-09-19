/**
 * @file
 * Contains function for buto tv player. Pure HTML5 embed (note the `delivery` parameter that's passed into the player object)
 */

function buto_tv_player(d, conf) {
    var b = d.createElement('script');
    b.setAttribute('async', true);
    b.src = '//embed.buto.tv/js/' + conf.object_id;
    if (b.addEventListener) {
        b.addEventListener('load', function () {
            if (window.buto) {
                buto.addPlayer(conf);
            }
        }, false);
    }
    else if (b.readyState) {
        b.onreadystatechange = function () {
            if (window.buto) {
                buto.addPlayer(conf);
            }
        };
    }
    var s = d.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(b, s);
}


Drupal.behaviors.talbutotv = {
    attach: function (context) {
        jQuery.each(drupalSettings.tateandlyle, function (k, data) {
            buto_tv_player(context, {
                object_id: data.videoid,
                element_id: data.elementid,
                width: data.width,
                height: data.height});
        });
    }
};
