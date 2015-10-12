/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {
    var $style = $( '#color-scheme-css' ),
        api = wp.customize;

    if ( ! $style.length ) {
        $style = $( 'head' ).append( '<style type="text/css" id="color-scheme-css" />' )
            .find( '#color-scheme-css' );
    }

    // Color Scheme CSS.
    api.bind( 'preview-ready', function() {
        api.preview.bind( 'update-color-scheme-css', function( css ) {
            $style.html( css );
        } );
    } );

} )( jQuery );
