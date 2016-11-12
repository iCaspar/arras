/**
 * Handle WP Customizer postMessage calls.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

(function ($) {
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.home-link').html(to);
        });
    });

    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').html(to);
        });
    });

    wp.customize('arras-options[footer-message]', function (value) {
        value.bind(function (to) {
            $('.footer-message').html(to);
        });
    });
})(jQuery);
