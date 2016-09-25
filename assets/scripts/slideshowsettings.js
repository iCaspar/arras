/**
 * slideshowsettings.js
 *
 * Inserts settings for slideshow (jQuery Cycle)
 * @since 1.5.4.1
 *
 */

jQuery(document).ready(function() {
  jQuery('#featured-slideshow').cycle( {
      fx: 'fade',
      speed: 250,
      next: '#controls .next',
      prev: '#controls .prev',
      timeout: 6000,
      pause: 1,
  });
});
