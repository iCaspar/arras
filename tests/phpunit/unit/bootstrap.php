<?php
/**
 * Bootstraps the Arras Unit Tests.
 *
 * @package     Arras\Tests\Unit
 * @since       4.0.0
 * @link        http://www.arrastheme.net
 * @license     GNU-2.0+
 */

namespace Arras\Tests\Unit;

use function Arras\Tests\init_test_suite;

require_once dirname( dirname( __FILE__ ) ) . '/functions.php';
init_test_suite( 'unit' );

define( 'ARRAS_TESTS_LIB_DIR', ARRAS_THEME_DIR . 'src' . DIRECTORY_SEPARATOR );

// Let's define ABSPATH as it is in WordPress, i.e. relative to the filesystem's WordPress root path.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( dirname( dirname( ARRAS_THEME_DIR ) ) ) . '/' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound -- Valid use case for our testing suite.
}

require_once ARRAS_TESTS_DIR . '/ArrasUnitTestCase.php';
