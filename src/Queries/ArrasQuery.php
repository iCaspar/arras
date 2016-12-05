<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Queries;

class ArrasQuery implements Query {

	/**
	 * WP_Query arguments.
	 *
	 * @var array
	 */
	protected $args;

	/**
	 * ArrasQuery constructor.
	 *
	 * @param array $args WP_Query arguments to use.
	 *
	 * @see https://codex.wordpress.org/Class_Reference/WP_Query for what's available.
	 */
	public function __construct( array $args = [] ) {
		$this->set( $args );
	}

	/**
	 * Set new query arguments.
	 *
	 * @param array $args Query arguments to be set.
	 *
	 * @return void
	 */
	public function set( array $args ) {
		$this->args = ( $args );
	}

	/**
	 * Run a WordPress query.
	 * @return \WP_Query
	 */
	public function run() {
		return new \WP_Query( $this->args );
	}

	/**
	 * Clean up after a secondary query.
	 * @return void
	 */
	public function end() {
		wp_reset_postdata();
	}
}