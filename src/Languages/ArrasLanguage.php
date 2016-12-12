<?php
/**
 * Arras language settings.
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @since: 4.0.0
 */

namespace ICaspar\Arras\Languages;

/**
 * Class ArrasLanguage
 * @package ICaspar\Arras\Theme\Languages
 */
class ArrasLanguage implements Language {

	/**
	 * Make Arras translatable.
	 * @return void
	 */
	public function init() {
		$language_directory = apply_filters( 'arras_language', get_template_directory() . '/languages');
		load_theme_textdomain( 'arras', $language_directory );
	}
}