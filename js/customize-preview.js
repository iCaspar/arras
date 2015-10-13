/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
    var $style = $( '#theme-color-scheme-css' ),
        api = wp.customize;

    if ( ! $style.length ) {
        $style = $( 'head' ).append( '<style type="text/css" id="theme-color-scheme-css" />' )
            .find( '#theme-color-scheme-css' );
    }

    // Color Scheme CSS.
    api.bind( 'preview-ready', function() {
        api.preview.bind( 'update-color-scheme-css', function( css ) {
            $style.html( css );
        } );
    } );

} )( jQuery );
