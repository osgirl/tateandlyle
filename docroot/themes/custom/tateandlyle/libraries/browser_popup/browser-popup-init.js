/**
 * @file
 * Contains Tate and Lyle Browser popup behaviours. To display a message on unsupported OS version.
 */

/**
 * Implements Drupal.behaviours.
 */
Drupal.behaviors.browserPopup = {
    attach: function (context) {
        var ver = iOSversion();
        if (ver !== null) {
            if (parseFloat(ver) < 10.3) {
                jQuery.confirm('For better browsing experience please update to IOS 10.3 or above', 'IOS Alert');
            }
        }
    }
};

/**
 * Function to detect iOS version.
 */
function iOSversion() {
    var ua = navigator.userAgent;
    var uaindex;
    if (ua.match(/iPad/i) || ua.match(/iPod/i) || ua.match(/iPhone/i)) {
        userOS = 'iOS';
        uaindex = ua.indexOf('OS ');
        userOSver = ua.substr(uaindex + 3, 5).replace(/\_/g, '.');
        return userOSver;
    }
}
