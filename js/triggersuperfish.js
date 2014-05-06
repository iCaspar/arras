/**
 * triggersuperfish.js
 *
 * Calls jQuery superfish on the main menu
 *
 * @author  Caspar Green <caspar@iCasparWebDevelopment>
 * @package Arras
 * @since 1.5.4.1
 * 
 */

jQuery(document).ready(function() {
    jQuery('ul.sf-menu').superfish( {
      dropShadows: 'true'
    });
  });