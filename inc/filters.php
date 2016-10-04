<?php
/**
 * Arras template filters
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 4.0.0
 */

/**
 * Callable from theme templates to get an option from the Options class.
 *
 * @param null|string $option The option requested
 *
 * @return void
 */
function arras_get_option( $option = null ) {
	return apply_filters( 'arras_get_option', $option );
}
