<?php
$notices = ''; // store notices here so that options_page.php will echo it out later

function arras_addmenu() {
	$options_page = add_theme_page( 'Arras Options', __('Arras Options', 'arras'), 'edit_theme_options', 'arras-options', 'arras_admin');

//	$posttax_page = add_theme_page( '', __('Arras Post Types & Taxonomies', 'arras'), 'edit_theme_options', 'arras-posttax', 'arras_posttax', 64 );

	add_action('admin_print_scripts-'. $options_page, 'arras_admin_scripts');
	add_action('admin_print_styles-'. $options_page, 'arras_admin_styles');

//	add_action('admin_print_scripts-' . $posttax_page, 'arras_admin_scripts');
//	add_action('admin_print_styles-' . $posttax_page, 'arras_admin_styles');

}

function arras_admin() {
	global $arras_options, $arras_image_sizes, $notices;

	if ( isset($_GET['page']) && $_GET['page'] == 'arras-options' ) {
		//print_r($_POST);

		if ( isset($_REQUEST['save']) ) {
			arras_admin_save();
		}

		if ( isset($_REQUEST['reset']) ) {
			arras_admin_reset();
		}

		if ( isset( $_REQUEST['arras-regen-thumbs'] ) && is_plugin_active( 'regenerate-thumbnails/regenerate-thumbnails.php' ) ) {
			check_admin_referer('arras-admin');
			?>
			<script type="text/javascript">
				window.location = '<?php echo admin_url( 'tools.php?page=regenerate-thumbnails' ) ?>';
			</script>
			<?php
		} else {
			if ( !is_plugin_active( 'regenerate-thumbnails/regenerate-thumbnails.php' ) ) {
				$notices = '<div class="error fade"><p>' . __( '<strong>Notice:</strong> Having <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> plugin installed and activated is highly recommended for Arras.', 'arras' ) . '</p></div>';
		}

	$arras_image_sizes = array();
	include 'templates/options_page.php';
		}
	}
}

function arras_admin_save() {
	global $arras_options, $arras_image_sizes, $notices;
	check_admin_referer('arras-admin');

	// code for saving arras-options->logo used to be here

	// Hack!
	//$arras_options->layout = (string)$_POST['arras-layout-col'];
	$arras_image_sizes = array();

	$arras_custom_image_sizes = array();
	foreach ($arras_image_sizes as $id => $args) {
		if ( isset($_POST['arras-reset-thumbs']) && $_POST['arras-reset-thumbs'] ) {
			$arras_custom_image_sizes[$id]['w'] = $arras_image_sizes[$id]['dw'];
			$arras_custom_image_sizes[$id]['h'] = $arras_image_sizes[$id]['dh'];
		} else {
			$arras_custom_image_sizes[$id]['w'] = (int)($_POST['arras-' . $id . '-w']);
			$arras_custom_image_sizes[$id]['h'] = (int)($_POST['arras-' . $id . '-h']);
		}
	}

	$arras_options->custom_thumbs = $arras_custom_image_sizes;
	$arras_options->save_options();
			$arras_options->save_posttypes();
			$arras_options->save_taxonomies();
	arras_update_options();

	do_action('arras_admin_save');
			do_action('arras_admin_posttype_save');
			do_action('arras_admin_taxonomy_save');

	$notices = '<div class="updated fade"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';

}

function arras_admin_reset() {
	global $notices;
	check_admin_referer('arras-admin');

	delete_option('arras_options');
	arras_flush_options();

	do_action('arras_admin_reset');

	$notices = '<div class="updated fade"><p>' . __('Your settings have been reverted to the defaults.', 'arras') . '</p></div>';
}


function arras_admin_scripts() {
	wp_enqueue_script( 'jquery-multiselect', get_template_directory_uri() . '/js/jquery.multiselect.min.js', null, 'jquery' );
	wp_enqueue_script( 'arras-admin-js', get_template_directory_uri() . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs') );
    wp_enqueue_script( 'wp-color-picker-script', get_template_directory_uri() . '/js/colorpicker.js', array( 'wp-color-picker' ), false, true );
}

function arras_admin_styles() {
    wp_enqueue_style( 'wp-color-picker' );
	if ( is_rtl() )
		wp_enqueue_style( 'arras-admin', get_template_directory_uri() . '/css/admin-rtl.css', false, '2011-12-12', 'all' );
	else
		wp_enqueue_style( 'arras-admin', get_template_directory_uri() . '/css/admin.css', false, '2011-12-12', 'all' );
}

function get_remote_array($url) {
	if ( function_exists('wp_remote_request') ) {
		$options = array();
		$options['headers'] = array(
			'User-Agent' => 'Arras Feed Grabber' . ARRAS_VERSION . '; (' . home_url() .')'
		 );

		$response = wp_remote_request($url, $options);

		if ( is_wp_error( $response ) )
			return false;

		if ( 200 != $response['response']['code'] )
			return false;

		$content = unserialize($response['body']);

		if (is_array($content))
			return $content;
	}
	return false;
}

function arras_get_contributors($arr) {
	if ( !is_array($arr) ) return false;

	ksort($arr);
	$i = count($arr);
	foreach ($arr as $name => $url)
	{
		if ($url)
			echo "<a href=\"$url\">$name</a>";
		else
			echo $name;
		$i--;
		if ($i == 1)
			echo " & ";
		elseif ($i)
			echo ", ";
	}
}

function arras_right_col() {
	?>
	<div id="arras-right-col">
		<div class="postbox">
			<h3><span><?php _e('Helpful Links', 'arras') ?></span></h3>
			<ul>
				<li><a href="http://arrastheme.net"><?php _e('Arras Theme Website', 'arras') ?></a></li>
				<li><a href="http://forum.arrastheme.net"><?php _e('Arras Theme Forums', 'arras') ?></a></li>
				<li><a href="https://github.com/icaspar/arras"><?php _e('Arras on GitHub', 'arras') ?></a></li>
			</ul>
		</div>

		<div class="postbox">
			<h3><span><?php _e('How to Support?', 'arras') ?></span></h3>
			<p><?php _e('There are many ways you can support this theme:', 'arras') ?></p>
			<ul>
				<li><?php _e('Share it!', 'arras') ?></li>
				<li><?php _e('Report bugs / Send patches', 'arras') ?></li>
				<li><?php _e('Contribute to the forums / wiki', 'arras') ?></li>
				<li><?php _e('Translate the theme', 'arras') ?></li>
			</ul>
		</div>

		<div class="postbox">
			<h3><span><?php _e('Thanks!', 'arras') ?></span></h3>
			<p>Many Thanks to Everyone who has contributed to Arras over the years.</p>
			<p>Special Thanks to <strong>Arras</strong>'s Creator and former Lead Developer, <strong><a href="http://www.zy.sg/" title="Melvin Lee">Melvin Lee</a></strong>,
				for releasing <strong>Arras</strong> for further development.</p>
			<p><strong>Arras</strong> is licensed under <a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html">GNU General Public License, v.2</a>.

		</div>

		<?php do_action('arras_admin_right_col'); ?>

	</div>
	<?php
}

function arras_posttype_blacklist() {
	$_default = array('revision', 'nav_menu_item');
	return apply_filters('arras_posttype_blacklist', $_default);
}

function arras_taxonomy_blacklist() {
	$_default = array();
	return apply_filters('arras_taxonomy_blacklist', $_default);
}
