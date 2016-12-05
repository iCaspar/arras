<?php
/**
 * Description
 *
 * @author: Caspar Green <https://caspar.green/>
 * @package: Arras
 * @version: 1.0.0
 */

namespace ICaspar\Arras\Theme\Templates;

use Pimple\Container;

class TemplateLoader {

	/**
	 * Get the correct template for the current page load.
	 * Here's the order from the wp templateloader:
	 *
	 * if     ( is_embed()          && $template = get_embed_template()          ) :
	 * elseif ( is_404()            && $template = get_404_template()            ) :
	 * elseif ( is_search()         && $template = get_search_template()         ) :
	 * elseif ( is_front_page()     && $template = get_front_page_template()     ) :
	 * elseif ( is_home()           && $template = get_home_template()           ) :
	 * elseif ( is_post_type_archive() && $template = get_post_type_archive_template() ) :
	 * elseif ( is_tax()            && $template = get_taxonomy_template()       ) :
	 * elseif ( is_attachment()     && $template = get_attachment_template()     ) :
	 * remove_filter('the_content', 'prepend_attachment');
	 * elseif ( is_single()         && $template = get_single_template()         ) :
	 * elseif ( is_page()           && $template = get_page_template()           ) :
	 * elseif ( is_singular()       && $template = get_singular_template()       ) :
	 * elseif ( is_category()       && $template = get_category_template()       ) :
	 * elseif ( is_tag()            && $template = get_tag_template()            ) :
	 * elseif ( is_author()         && $template = get_author_template()         ) :
	 * elseif ( is_date()           && $template = get_date_template()           ) :
	 * elseif ( is_archive()        && $template = get_archive_template()        ) :
	 * elseif ( is_paged()          && $template = get_paged_template()          ) :
	 * else :
	 * $template = get_index_template();
	 * endif;
	 *
	 * @param Container $arras Theme services to pass into the template.
	 *
	 * @return Template
	 */
	public function get_template( Container $arras ) {
		if ( is_404() ) {
			$type = 'NotFound';
		} elseif ( is_search() ) {
			$type = 'Search';
		} elseif ( is_attachment() ) {
			$type = 'Attachment';
		} elseif ( is_single() ) {
			$type = 'Single';
		} elseif ( is_page() ) {
			$type = 'Page';
		} elseif ( is_author() ) {
			$type = 'Author';
		} elseif ( is_archive() ) {
			$type = 'Archive';
		} else {
			$type = 'Index';
		}

		$templateName = __NAMESPACE__ . '\\' . $type . 'Template';
		$template     = new $templateName( $arras );

		return $template;
	}

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