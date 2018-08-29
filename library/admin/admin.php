<?php
$notices = ''; // store notices here so that options_page.php will echo it out later

function arras_addmenu() {
	$options_page = add_theme_page( '', __( 'Arras Options', 'arras' ), 'edit_theme_options', 'arras-options', 'arras_admin' );

	$posttax_page = add_theme_page( __( 'Arras Post Types & Taxonomies', 'arras' ), __( 'Post Types & Tax.', 'arras' ), 'edit_theme_options', 'arras-posttax', 'arras_posttax' );

	add_action( 'admin_print_scripts-' . $options_page, 'arras_admin_scripts' );
	add_action( 'admin_print_scripts-' . $posttax_page, 'arras_admin_scripts' );
}

function arras_admin() {
	global $arras_options, $arras_image_sizes, $notices;

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'arras-options' ) {
		//print_r($_POST);

		if ( isset( $_REQUEST['save'] ) ) {
			arras_admin_save();
		}

		if ( isset( $_REQUEST['reset'] ) ) {
			arras_admin_reset();
		}

		if ( isset( $_REQUEST['arras-regen-thumbs'] ) && is_plugin_active( 'regenerate-thumbnails/regenerate-thumbnails.php' ) ) {
			check_admin_referer( 'arras-admin' );
			?>
			<script type="text/javascript">
                window.location = '<?php echo admin_url( 'tools.php?page=regenerate-thumbnails' ) ?>';
			</script>
			<?php
		} else {
			if ( ! is_plugin_active( 'regenerate-thumbnails/regenerate-thumbnails.php' ) ) {
				$notices = '<div class="error fade"><p>' . __( '<strong>Notice:</strong> Having <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> plugin installed and activated is highly recommended for Arras.', 'arras' ) . '</p></div>';
			}

			$arras_image_sizes = array();
			arras_add_default_thumbnails();
			include 'templates/options_page.php';
		}
	}
}

function arras_admin_save() {
	global $arras_options, $arras_image_sizes, $notices;
	check_admin_referer( 'arras-admin' );

	if ( isset( $_REQUEST['arras-tools-import'] ) && $_REQUEST['arras-tools-import'] != '' ) {
		$new_arras_options = maybe_unserialize( json_decode( $_REQUEST['arras-tools-import'] ) );

		if ( is_a( $new_arras_options, 'Options' ) ) {
			$arras_options = $new_arras_options;
			arras_update_options();
			$notices = '<div class="updated fade"><p>' . __( 'Your settings have been successfully imported.', 'arras' ) . '</p></div>';
		}
	} else {
		// Hack!
		$arras_options->layout = (string) $_POST['arras-layout-col'];
		$arras_image_sizes     = array();
		arras_add_default_thumbnails();

		$arras_custom_image_sizes = array();
		foreach ( $arras_image_sizes as $id => $args ) {
			if ( isset( $_POST['arras-reset-thumbs'] ) && $_POST['arras-reset-thumbs'] ) {
				$arras_custom_image_sizes[ $id ]['w'] = $arras_image_sizes[ $id ]['dw'];
				$arras_custom_image_sizes[ $id ]['h'] = $arras_image_sizes[ $id ]['dh'];
			} else {
				$arras_custom_image_sizes[ $id ]['w'] = (int) ( $_POST[ 'arras-' . $id . '-w' ] );
				$arras_custom_image_sizes[ $id ]['h'] = (int) ( $_POST[ 'arras-' . $id . '-h' ] );
			}
		}

		$arras_options->custom_thumbs = $arras_custom_image_sizes;
		$arras_options->save_options();
		arras_update_options();

		do_action( 'arras_admin_save' );

		$notices = '<div class="updated fade"><p>' . __( 'Your settings have been saved to the database.', 'arras' ) . '</p></div>';
	}
}

function arras_admin_reset() {
	global $notices;
	check_admin_referer( 'arras-admin' );

	delete_option( 'arras_options' );
	arras_flush_options();

	do_action( 'arras_admin_reset' );

	$notices = '<div class="updated fade"><p>' . __( 'Your settings have been reverted to the defaults.', 'arras' ) . '</p></div>';
}

function arras_posttax() {
	global $arras_options, $notices;

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'arras-posttax' ) {
		if ( isset( $_REQUEST['save'] ) ) {

			if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == 'posttype' ) {
				$arras_options->save_posttypes();
				arras_update_options();
				do_action( 'arras_admin_posttype_save' );
				$notices = '<div class="updated fade"><p>' . __( 'Your settings have been saved to the database.', 'arras' ) . '</p></div>';
			}

			if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == 'taxonomy' ) {
				$arras_options->save_taxonomies();
				arras_update_options();
				do_action( 'arras_admin_taxonomy_save' );
				$notices = '<div class="updated fade"><p>' . __( 'Your settings have been saved to the database.', 'arras' ) . '</p></div>';
			}

		}

		if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == 'taxonomy' ) {
			include 'templates/taxonomy_page.php';
		} else {
			include 'templates/posttype_page.php';
		}
	}
}

function arras_admin_scripts() {
	wp_enqueue_script( 'jquery-multiselect', get_template_directory_uri() . '/assets/js/jquery.multiselect.min.js', [
		'jquery-ui-widget',
		'jquery-ui-position',
		'jquery-ui-resizable',
	], '2.0.1', true );
	wp_enqueue_script( 'arras-admin-js', get_template_directory_uri() . '/assets/js/admin.js', [ 'jquery-ui-tabs' ], ARRAS_VERSION, true );
}

function get_remote_array( $url ) {
	if ( function_exists( 'wp_remote_request' ) ) {
		$options = array();
		$options['headers'] = array(
			'User-Agent' => 'Arras Feed Grabber' . ARRAS_VERSION . '; (' . home_url() . ')'
		);

		$response = wp_remote_request( $url, $options );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		if ( 200 != $response['response']['code'] ) {
			return false;
		}

		$content = unserialize( $response['body'] );

		if ( is_array( $content ) ) {
			return $content;
		}
	}

	return false;
}

function arras_get_contributors( $arr ) {
	if ( ! is_array( $arr ) ) {
		return false;
	}

	ksort( $arr );
	$i = count( $arr );
	foreach ( $arr as $name => $url ) {
		if ( $url ) {
			echo "<a href=\"$url\">$name</a>";
		} else {
			echo $name;
		}
		$i --;
		if ( $i == 1 ) {
			echo " & ";
		} elseif ( $i ) {
			echo ", ";
		}
	}
}

function arras_right_col() {
	$forum_contributors = array(
		'Giovanni' => 'http://www.animeblog.nl/',
		'Nedrago'  => 'http://www.nedrago.com/',
		'Dan'      => 'http://www.techunfolding.com/'
	); ?>
	<div id="arras-right-col">
		<div class="postbox">
			<h3><span><?php _e( 'Helpful Links', 'arras' ) ?></span></h3>
			<ul>
				<li><a href="https://www.arrastheme.net/"><?php _e( 'Community Forums', 'arras' ) ?></a></li>
				<li><a href="https://github.com/iCaspar/arras/"><?php _e( 'Arras on GitHub', 'arras' ) ?></a></li>
			</ul>
		</div>

		<div class="postbox">
			<h3><span><?php _e( 'How to Support?', 'arras' ) ?></span></h3>
			<p><?php _e( 'There are many ways you can support this theme:', 'arras' ) ?></p>
			<ul>
				<li><?php _e( 'Share other about the theme', 'arras' ) ?></li>
				<li><?php _e( 'Report bugs / Send patches', 'arras' ) ?></li>
				<li><?php _e( 'Contribute to the forums / wiki', 'arras' ) ?></li>
				<li><?php _e( 'Translate the theme', 'arras' ) ?></li>
			</ul>
		</div>

		<div class="postbox">
			<h3><span><?php _e( 'Thanks!', 'arras' ) ?></span></h3>
			<p><?php _e( 'Many thanks to those who have contributed to the theme:', 'arras' ) ?></p>
			<p><strong><?php _e( 'Forum Contributors', 'arras' ) ?></strong><br/>
				<?php arras_get_contributors( $forum_contributors ) ?></p>
		</div>

		<?php do_action( 'arras_admin_right_col' ); ?>

	</div>
	<?php
}

function arras_posttype_blacklist() {
	$_default = array( 'revision', 'nav_menu_item' );

	return apply_filters( 'arras_posttype_blacklist', $_default );
}

function arras_taxonomy_blacklist() {
	$_default = array();

	return apply_filters( 'arras_taxonomy_blacklist', $_default );
}