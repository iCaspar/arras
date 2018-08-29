<?php
/**
 * AssetService.php
 */

namespace Arras;

/**
 * Class AssetService
 *
 * @package Arras
 */
class AssetService {

	/**
	 * @var array
	 */
	private $config = [];

	/**
	 * @var string
	 */
	private $baseUrl = '';

	/**
	 * @var bool
	 */
	private $isDevEnv = false;

	/**
	 * @var array
	 */
	private $styleSchemes = [];

	/**
	 * @var string
	 */
	private $inlineCSS = '';

	/**
	 * AssetService constructor.
	 *
	 * @param array $config
	 * @param string $baseUrl
	 * @param bool $isDevEnv
	 */
	public function __construct( array $config, $baseUrl, $isDevEnv = false ) {
		$this->config   = $config;
		$this->baseUrl  = $baseUrl . '/';
		$this->isDevEnv = $isDevEnv;
	}

	/**
	 * @return void
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'registerStyles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueStyles' ], 15 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'registerStyles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdminStyles' ], 15 );
	}

	/**
	 * @throws \RuntimeException
	 * @return array URLs of registered styles.
	 */
	public function registerStyles() {
		if ( ! $this->hasStyles() ) {
			throw new \RuntimeException( 'Missing styles in configuration.' );
		}

		$result = [];

		foreach ( $this->config['styles'] as $handle => $args ) {
			if ( ! isset( $args['filename'] ) ) {
				continue;
			}

			$src      = $this->getAssetUrl( $args['filename'], 'css' );
			$result[] = wp_register_style(
				$handle,
				$src,
				isset( $args['deps'] ) ? $args['deps'] : [],
				isset( $args['version'] ) ? $args['version'] : '',
				isset( $args['media'] ) ? $args['media'] : 'all'
			) ? [ $handle => $src ] : '';

			if ( $this->isSelectableScheme( $args ) ) {
				$scheme_name                   = isset( $args['nicename'] )
					? $args['nicename']
					: ucfirst( $args['filename'] );
				$this->styleSchemes[ $handle ] = $scheme_name;
			}
		}

		return $result;
	}

	/**
	 * @return void
	 */
	public function enqueueStyles() {
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'ionicons', 'https://unpkg.com/ionicons@4.3.0/dist/css/ionicons.min.css', [], '4.3.0', 'all' );
		$handle = $this->getCurrentStyleHandle();
		wp_enqueue_style( $handle );

		if ( $this->inlineCSS ) {
			wp_add_inline_style( $handle, $this->inlineCSS );
		}

		if ( is_rtl() ) {
			wp_enqueue_style( 'arras-rtl' );
		}

		do_action( 'arras_load_styles' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'hoverIntent' );
		wp_enqueue_script(
			'superfish',
			$this->getAssetUrl( 'superfish', 'js' ),
			[ 'jquery' ],
			'1.7.10',
			true
		);
		wp_enqueue_script(
			'arras-superfish',
			$this->getAssetUrl( 'superfish-config', 'js' ),
			[ 'superfish' ],
			ARRAS_VERSION,
			true
		);
	}

	/**
	 * @return string
	 */
	public function getCurrentStyleHandle() {
		$style = arras_get_option( 'style' );

		if ( ! isset( $style ) ) {
			$style = '';
		}

		return $style;
	}

	/**
	 * @return void
	 */
	public function enqueueAdminStyles( $hook ) {
		$arrasPages = [ 'appearance_page_arras-options', 'appearance_page_arras-posttax' ];
		if ( ! in_array( $hook, $arrasPages ) ) {
			return;
		}

		//wp_enqueue_style( 'smoothness' );
		wp_enqueue_style( 'admin' );

		if ( is_rtl() ) {
			wp_enqueue_style( 'admin-rtl' );
		}
	}

	/**
	 * @param string $css CSS to be inlined.
	 *
	 * @return void
	 */
	public function addInlineStyle( $css ) {
		$this->maybe_add_inline_styles( $css );
	}

	/**
	 * Add inline styles for legacy style sets.
	 *
	 * @since 4.0.0
	 *
	 * @param string $css CSS to be inlined.
	 *
	 * @return void
	 */
	protected function maybe_add_inline_styles( $css ) {
		if ( 'arras-nova' == $this->getCurrentStyleHandle() ) {
			return;
		}

		$this->inlineCSS .= $css;
	}

	/**
	 * @return bool
	 */
	private function hasStyles() {
		return isset( $this->config['styles'] ) && is_array( $this->config['styles'] );
	}

	/**
	 * @param string $filename
	 * @param string $filetype
	 *
	 * @return string The asset url.
	 */
	private function getAssetUrl( $filename, $filetype ) {
		if ( $this->isDevEnv ) {
			return $this->baseUrl . $filetype . '/' . $filename . '.' . $filetype;
		} else {
			return $this->baseUrl . $filetype . '/' . $filename . '.min.' . $filetype;
		}
	}

	/**
	 * @param array $styleArgs Style config arguments.
	 *
	 * @return bool
	 */
	private function isSelectableScheme( array $styleArgs ) {
		return isset( $styleArgs['scheme'] ) && true == $styleArgs['scheme'];
	}

	/**
	 * @return string HTML for style chooser select.
	 */
	public function buildStyleSchemeChooser() {
		$menuOpts = [];

		foreach ( $this->styleSchemes as $scheme => $file ) {
			$menuOpts[ $scheme ] = $file;
		}

		return arras_form_dropdown( 'arras-style', $menuOpts, arras_get_option( 'style' ) );
	}
}
