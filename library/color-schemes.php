<?php
/**
 * color-schemes.php
 *
 * [Description]
 *
 * @author: Caspar Green <https://caspar.green>
 * @package: Arras
 * @version: 1.0.0
 */

namespace Arras\Inc;


/**
 * Class Color_Schemes
 * @package Arras\Inc
 */
class Color_Schemes {

	/**
	 * Constructor does nothing.
	 */
	public function __construct() {}

	/**
	 * Enqueue front-end CSS for color scheme.
	 *
	 * @return null
	 */
	public function enqueue_color_scheme_css() {
		$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );

		if ( 'default' === $color_scheme_option ) {
			return;
		}

		$color_scheme = $this->get_color_scheme_colors_array();

		$colors = array(
			'header_background_color'     => get_theme_mod( 'header_background_color', '#1e1b1a' ),
			'main_nav_link_color'         => $color_scheme[1],
			'hover_color'                 => $color_scheme[2],
			'supplemental_color'          => $color_scheme[3],
		);

//d($colors);
		$color_scheme_css = $this->create_color_scheme_css( $colors );

		wp_add_inline_style( 'arras-base', $color_scheme_css );
	}

	/**
	 * Gets an array of the current color scheme's colors.
	 *
	 * @since 3.0
	 *
	 * @return array Current color scheme colors
	 */
	public function get_color_scheme_colors_array() {
		$current_color_scheme = get_theme_mod( 'color_scheme', 'default' );
		$registered_color_schemes = $this->register_color_schemes();

		if ( array_key_exists( $current_color_scheme, $registered_color_schemes ) ) {
			return $registered_color_schemes[ $current_color_scheme ]['colors'];
		}

		return $registered_color_schemes['default']['colors'];
	}

	/**
	 * Output an Underscore template for generating CSS for the color scheme.
	 *
	 * The template generates the css dynamically for instant display in the Customizer
	 * preview.
	 *
	 * @see twentyfifteen_color_scheme_css_template()
	 */
	public function color_scheme_css_template() {
		$colors = array(
			'header_background_color' => '{{ data.header_background_color }}',
			'main_nav_link_color'     => '{{ data.main_nav_link_color }}',
			'hover_color'             => '{{ data.hover_color }}',
			'supplemental_color'      => '{{ data.supplemental_color }}',
		);
		?>
		<script type="text/html" id="tmpl-theme-color-scheme">
			<?php echo $this->create_color_scheme_css( $colors ); ?>
		</script>
		<?php
	}

	/**
	 * @param string $value Raw color scheme name from customizer input
	 *
	 * @return string Sanitized color scheme name
	 */
	public function sanitize_color_scheme( $value ) {
		$color_schemes = $this->get_color_scheme_names();

		if ( ! array_key_exists( $value, $color_schemes ) ) {
			$value = 'default';
		}

		return $value;
	}

	/**
	 * Gets a list of registered color scheme names
	 *
	 * @return array
	 */
	public function get_color_scheme_names() {
		$color_schemes = $this->register_color_schemes();
		$color_scheme_names = array();

		foreach ( $color_schemes as $color_scheme => $value ) {
			$color_scheme_names[ $color_scheme ] = $value['label'];
		}

		return $color_scheme_names;
	}


	/**
	 * Enqueue JS event listener to update customizer on coler scheme control change.
	 *
	 * Pass color scheme data as colorScheme global.
	 */
	public function enqueue_color_scheme_control_js() {
		wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '3.0', true );
		wp_localize_script( 'color-scheme-control', 'colorScheme', $this->register_color_schemes() );
	}

	/**
	 * Register theme color schemes.
	 *
	 * The order of colors in a colors array is:
	 * 0. Site Header Background
	 * 1. Main Navigation Background / Links
	 * 2. Link and Buttons on Hover
	 * 3. Top Menu Background
	 *
	 * @return mixed|void
	 */
	private function register_color_schemes() {
		return apply_filters( 'arras_color_schemes', array(
			'default' => array(
				'label'  => __( 'Default', 'arras' ),
				'colors' => array(
					'#1e1b1a',
					'#322c2c',
					'#383332',
					'#111111',
				),
			),
			'blue'    => array(
				'label'  => __( 'Blue', 'arras' ),
				'colors' => array(
					'#091e36',
					'#003773',
					'#0f3158',
					'#061424',
				),
			),
			'green'  => array(
				'label'  => __( 'Green', 'arras' ),
				'colors' => array(
					'#204000',
					'#336500',
					'#407e19',
					'#0d1900',
				),
			),
			'rust'    => array(
				'label'  => __( 'Rust', 'arras' ),
				'colors' => array(
					'#5c2203',
					'#87340e',
					'#632a0b',
					'#2e1101',
				),
			),
			'wine'  => array(
				'label'  => __( 'Wine', 'arras' ),
				'colors' => array(
					'#3d0a00',
					'#7e1e14',
					'#721b12',
					'#330800',
				),
			),
			'violet'   => array(
				'label'  => __( 'Violet', 'arras' ),
				'colors' => array(
					'#320a33',
					'#581259',
					'#4b0f4c',
					'#390b3b',
				),
			),
		) );
	}

	/**
	 * Generates CSS for color scheme overrides stylesheet
	 *
	 * @param array $colors Current color scheme
	 *
	 * @return string CSS
	 */
	private function create_color_scheme_css( $colors ) {

		$colors = wp_parse_args( $colors, array(
			'header_background_color'     => '',
			'main_nav_link_color'         => '',
			'hover_color'                 => '',
			'supplemental_color'          => '',
		) );

		$color_scheme_css = <<<CSS

		/* Header */
		.page-header {
			background: {$colors['header_background_color']};
			border-bottom-color: {$colors['hover_color']};
		}
		.primary-utility,
		.top-menu ul ul {
			background: {$colors['supplemental_color']};
		}
		.nav,
		.main-menu ul ul,
		.main-menu ul ul ul {
			background: {$colors['main_nav_link_color']};
		}
		.main-menu li:hover,
		.main-menu li li:hover {
			background-color: {$colors['hover_color']};
		}

		/* Headings */
		.home-title,
		.author-title,
		.archive-title {
			color: {$colors['header_background_color']};
		}

		/* Links and Buttons */
		a:link,
		a:visited {
			color: {$colors['main_nav_link_color']};
		}
		.a:hover {
			color: {$colors['hover_color']};
		}
		.posts-quick .quick-read-more a:hover,
		.comment-list .reply a:hover,
		.comments-navigation a:hover,
		.navigation a:hover,
		.read-more:hover {
			background: {$colors['hover_color']};
		}

		/* Widgets */
		.widgettitle {
			background: {$colors['main_nav_link_color']};
		}
CSS;

		return $color_scheme_css;
	}


}