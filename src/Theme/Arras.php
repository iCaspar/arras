<?php
/**
 * Where Arras begins.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Theme;

/**
 * Class Arras
 * @package ICaspar\Arras\Theme
 * @since 4.0.0
 */
class Arras {

	/**
	 * @var array Theme configuration.
	 */
	protected $config = array();

	/**
	 * Arras constructor.
	 */
	public function __construct() {
	}

	/**
	 * Initialize the theme.
	 *
	 * Sets the hooks for WP to call basic theme components.
	 *
	 * @param array $config
	 *
	 * @return void
	 */
	public function init( array $config ) {
		$this->config = apply_filters( 'arras_main_configuration', $config );

		add_action( 'after_setup_theme', array( $this, 'arras_i18n' ) );
		add_action( 'after_setup_theme', array( $this, 'arras_theme_support' ) );
		add_action( 'after_setup_theme', array( $this, 'arras_menus' ) );
		add_action( 'widgets_init', array( $this, 'arras_add_sidebars' ) );

	}

	/**
	 * Make Arras Translatable
	 * For how to translate Arras, see the Codex:
	 * https://codex.wordpress.org/I18n_for_WordPress_Developers
	 * @return null
	 */
	function arras_i18n() {
		load_theme_textdomain( 'arras', get_template_directory() . '/languages' );
	} // end arras_i18n()

	/**
	 * Declare various theme supports for WP and plugins
	 * @return null
	 */
	function arras_theme_support() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background', array( 'default-color' => 'f0f0f0' ) );
		add_theme_support( 'html5', array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'widgets'
		) );
	} // end arras_theme_support()

	/**
	 * Define our theme menu locations
	 * @return null
	 */
	function arras_menus() {
		register_nav_menus( array(
			'main-menu' => __( 'Main Menu', 'arras' ),
			'top-menu'  => __( 'Top Menu', 'arras' )
		) );
	} // end arras_menus()

	/**
	 * Register widgetized areas and update sidebar with default widgets.
	 * @return  null
	 */
	function arras_add_sidebars() {
		/* Default sidebars */
		register_sidebar( array(
			'name'          => 'Primary Sidebar',
			'id'            => 'primary',
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
			'after_widget'  => '</li>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>'
		) );
		register_sidebar( array(
			'name'          => 'Secondary Sidebar',
			'id'            => 'secondary',
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
			'after_widget'  => '</li>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>'
		) );
		register_sidebar( array(
			'name'          => 'Bottom Content #1',
			'id'            => 'below-content-1',
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
			'after_widget'  => '</li>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>'
		) );
		register_sidebar( array(
			'name'          => 'Bottom Content #2',
			'id'            => 'below-content-2',
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
			'after_widget'  => '</li>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>'
		) );
		register_sidebar( array(
			'name'          => 'Header Widgets',
			'id'            => 'header-widgets',
			'description'   => 'A small widget area in the header. Use for small widgets',
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer group">',
			'after_widget'  => '</li>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>'
		) );

		/* Footer sidebars (Up to 4 sidebars based on user preference) */
		/*	$footer_sidebars = arras_get_option('footer_columns');
			if ($footer_sidebars == '') $footer_sidebars = 1;

			for( $i = 1; $i < $footer_sidebars + 1; $i++ ) {
				register_sidebar( array(
					'name' => 'Footer Sidebar #' . $i,
					'id'	=> 'footer-sidebar-' . $i,
					'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
					'after_widget' => '</li>',
					'before_title' => '<h5 class="widgettitle">',
					'after_title' => '</h5>'
				) );
			}*/
	} // end arras_add_sidebars()

	/* Todo: Load and instantiate color scheme controller class */


}