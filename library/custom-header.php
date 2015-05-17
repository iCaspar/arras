<?php
/**
 * custom-header.php
 *
 * Displays custom header, if enabled from Appearance > Header
 * Adapted from Automattic's Twenty_Thirteen.
 *
 * This compliments the Arras Logo Option
 *
 * @package Arras
 * @since  1.6
 *
 * @uses add_theme_support() to register header support.
 * @uses arras_header_style() to style front-end.
 * @uses arras_admin_header_style() to style wp-admin form.
 * @uses arras_admin_header_image() to add custom markup to wp-admin form.
 *
 */

/**
 * Add theme support for custom images in header
 * @return null
 */
function arras_custom_header_setup() {
  $args = array(
    'default-text-color'      =>  'ffffff',
    'default-image'           =>  '',
    'flex-width'              =>  true,
    'width'                   =>  980,
    'flex-height'             =>  true,
    'height'                  =>  200,
    'header-text'             =>  true,
    'uploads'                 =>  true,
    'wp-head-callback'        =>  'arras_header_style',
    'admin-head-callback'     =>  'arras_admin_header_style',
    'admin-preview-callback'  =>  'arras_admin_header_image'
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
    #branding {
      background: url(<?php header_image(); ?>) no-repeat scroll left;
      background-size: cover;
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
  </style>
  <?php
}