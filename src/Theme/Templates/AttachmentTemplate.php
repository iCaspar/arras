<?php
/**
 * Template for a WordPress attachment page.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

class AttachmentTemplate extends BaseTemplate implements Template {

	public function __construct( Container $arras ) {
		parent::__construct( $arras );
	}

	public function render() {
		$this->beforeContent();

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				include ARRAS_VIEWS_DIR . 'entry.php';
			}
			comments_template( '', true );
		} else {
			$this->no_posts();
		}

		$this->afterContent();
	}
}
