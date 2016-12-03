<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Theme\Helpers;

class TemplateLoader {

	/**
	 * Like the original WP get_header(), only we return the template path to be included
	 * instead of loading it directly from the function.
	 * This allows us to keep all our variables in the same scope
	 * throughout the page load rather than creating more globals.
	 *
	 * @param null|string $name An alternate header name.
	 *
	 * @return string The path-to-header-filename.
	 */
	public function get_header( $name = null ) {
		do_action( 'get_header', $name );

		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "header-{$name}.php";
		}

		$templates[] = 'header.php';

		return locate_template( $templates );
	}

	/**
	 * Like the original WP get_footer(), only we return the template path to be included
	 * instead of loading it directly from the function.
	 * This allows us to keep all our variables in the same scope
	 * throughout the page load rather than creating more globals.
	 *
	 * @param null|string $name An alternate footer name.
	 *
	 * @return string The path-to-footer-filename.
	 */
	public function get_footer( $name = null ) {
		do_action( 'get_footer', $name );

		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "footer-{$name}.php";
		}

		$templates[] = 'footer.php';

		return locate_template( $templates );
	}

	/**
	 * Like the original WP get_footer(), only we return the template path to be included
	 * instead of loading it directly from the function.
	 * This allows us to keep all our variables in the same scope
	 * throughout the page load rather than creating more globals.
	 *
	 * @param null|string $name An alternate sidebar name.
	 *
	 * @return string The path-to-sidebar-filename.
	 */
	public function get_sidebar( $name = null ) {
		do_action( 'get_sidebar', $name );

		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "sidebar-{$name}.php";
		}

		$templates[] = 'sidebar.php';

		return locate_template( $templates );
	}

}