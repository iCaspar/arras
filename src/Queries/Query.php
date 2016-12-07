<?php
/**
 * Interface (contract) for a query class.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Queries;

/**
 * Interface Query
 * @package ICaspar\Arras\Queries
 */
interface Query {

	/**
	 * Query constructor.
	 *
	 * @param array $args WP_Query arguments to use.
	 *
	 * @see https://codex.wordpress.org/Class_Reference/WP_Query for what's available.
	 */
	public function __construct( array $args = [] );

	/**
	 * Set query arguments
	 *
	 * @param array $args Query arguments to be set.
	 *
	 * @return void
	 */
	public function set( array $args );

	/**
	 * Run a WordPress query.
	 * @return \WP_Query
	 */
	public function run();

	/**
	 * Clean up after a secondary query.
	 * @return mixed
	 */
	public function end();
}