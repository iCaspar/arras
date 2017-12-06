<?php
/**
 * update.php
 */

add_filter( 'site_transient_update_themes', 'arrasMaybeAddUpdateToWP' );
add_filter( 'transient_update_themes', 'arrasMaybeAddUpdateToWP' );

function arrasMaybeAddUpdateToWP( $updates ) {
	if ( defined( 'DISALLOW_FILE_MODS' ) && true == DISALLOW_FILE_MODS ) {
		return $updates;
	}

	if ( isset( $updates->response['arras'] ) ) {
		unset( $updates->response['arras'] );
	}

	$arrasUpdate = arrasCheckUpdate();

	if ( $arrasUpdate ) {
		$updates->response['arras'] = $arrasUpdate;
	}

	return $updates;
}

function arrasCheckUpdate() {
	static $arrasUpdate;
	global $wp_version;

	if ( ! arras_get_option( 'auto_update' ) ) {
		return [];
	}

	if ( ! $arrasUpdate ) {
		$arrasUpdate = get_transient( 'arras_update' );
	}

	if ( ! $arrasUpdate ) {
		$url  = 'https://api.arrastheme.net/v1/updates/theme';
		$data = [
			'body' => [
				'arras_version' => ARRAS_VERSION,
				'php_version'   => phpversion(),
				'uri'           => home_url(),
				'stylesheet'    => get_stylesheet(),
				'user-agent'    => 'WordPress/' . $wp_version,
				'wp_version'    => $wp_version,
			],
		];

		$response     = wp_remote_post( $url, $data );
		$responseBody = wp_remote_retrieve_body( $response );

		if ( 'error' === $responseBody || is_wp_error( $response ) ) {
			$arrasUpdate = [ 'new_version' => ARRAS_VERSION ];
			set_transient( 'arras_update', $arrasUpdate, HOUR_IN_SECONDS );

			return [];
		}

		$arrasUpdate = json_decode( $responseBody, true );
		set_transient( 'arras_update', $arrasUpdate, DAY_IN_SECONDS );
	}

	if ( version_compare( ARRAS_VERSION, $arrasUpdate['new_version'], '>=' ) ) {
		return [];
	}

	return $arrasUpdate;
}