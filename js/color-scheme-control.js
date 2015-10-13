/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

( function( api ) {
    var cssTemplate = wp.template( 'theme-color-scheme' ),
        colorSchemeKeys = [
            'header_background_color',
            'main_nav_link_color',
            'hover_color',
            'supplemental_color'
        ],
        colorSettings = [
            'header_background_color'
        ];

    api.controlConstructor.select = api.Control.extend( {
        ready: function() {
            if ( 'color_scheme' === this.id ) {
                this.setting.bind( 'change', function( value ) {
                    // Update Header/Sidebar Background Color.
                    api( 'header_background_color' ).set( colorScheme[value].colors[0] );
                    api.control( 'header_background_color' ).container.find( '.color-picker-hex' )
                        .data( 'data-default-color', colorScheme[value].colors[0] )
                        .wpColorPicker( 'defaultColor', colorScheme[value].colors[0] );
                } );
            }
        }
    } );

    // Generate the CSS for the current Color Scheme.
    function updateCSS() {
        var scheme = api( 'color_scheme' )(), css,
            colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

        // Merge in color scheme overrides.
        _.each( colorSettings, function( setting ) {
            colors[ setting ] = api( setting )();
        });

        css = cssTemplate( colors );

        api.previewer.send( 'update-color-scheme-css', css );
    }

    // Update the CSS whenever a color setting is changed.
    _.each( colorSettings, function( setting ) {
        api( setting, function( setting ) {
            setting.bind( updateCSS );
        } );
    } );
} )( wp.customize );