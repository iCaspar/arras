/**
 * Helper for menu display.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

(function ($, window, document, undefined) {
    $(function () {
        $(".menu-main li").on('mouseenter mouseleave', function () {
            if ($('ul', this).length) {
                var submenu = $('ul:first', this);
                var offset = submenu.offset();
                var left = offset.left;
                var width = submenu.width();
                var docWidth = $(".menu-main-container").width();
                var isEntirelyVisible = (left + width <= docWidth);
                if (!isEntirelyVisible) {
                    $(this).addClass('edge');
                } else {
                    $(this).removeClass('edge');
                }
            }
        });
    });
})(jQuery, window, document);