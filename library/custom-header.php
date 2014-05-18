<?php
/**
 * custom-header.php
 *
 * Displays custom header, if enabled from Appearance > Header
 * (Adapted from Twenty_Thirteen)
 * 
 * Handles custom header colors, if set in Arras Options
 *
 * @package Arras
 * @since  1.6
 * 
 */

/**
 * Add theme support for custom images in header
 * @return null
 */
function arras_custom_header_setup() {
  $args = array(
    'default-text-color'  =>  'cecece',
    'default-image'       =>  '',
    'flex-width'          =>  true,
    'width'               =>  980,
    'flex-height'         =>  true,
    'height'              =>  200,
    'header-text'         =>  true,
    'uploads'             =>  true,
    'wp-head-callback'    =>  'arras_header_style',
  );

  add_theme_support( 'custom-header', $args );
}

add_action( 'after_setup_theme', 'arras_custom_header_setup', 11 );


/**
 * Load appropriate header styles
 * @return null
 */
function arras_header_style() {
  $header_image = get_header_image();
  $text_color   = get_header_textcolor();

  // If no custom options for text are set, let's bail.
  if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
    return;

  // If we get this far, we have custom styles.
  ?>
  <style type="text/css" id="custom-header-css">
  <?php
    if ( ! empty( $header_image ) ) :
  ?>
    .logo {
      background: url(<?php header_image(); ?>) no-repeat scroll left;
      width: 590px;
      min-height: 134px;
    }
  <?php
    endif;

    // Has the text been hidden?
    if ( ! display_header_text() ) :
  ?>
    .site-title,
    .site-description {
      position: absolute;
      clip: rect(1px 1px 1px 1px); /* IE7 */
      clip: rect(1px, 1px, 1px, 1px);
    }
  <?php
      if ( empty( $header_image ) ) :
  ?>
    .site-header .home-link {
      min-height: 0;
    }
  <?php
      endif;

    // If the user has set a custom color for the text, use that.
    elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
  ?>
    .site-title,
    .site-description {
      color: #<?php echo esc_attr( $text_color ); ?>;
    }
  <?php endif; ?>
  <?php if ( arras_get_option( 'header_color' ) ) {
    $header_color = arras_get_option( 'header_color' );
    ?>
    #header {
      background-color: #<?php echo esc_attr( $header_color ); ?>;
    }
  <?php } ?>
  </style>
  <?php
}
