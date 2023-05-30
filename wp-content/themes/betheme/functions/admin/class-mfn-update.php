<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Update extends Mfn_API {

	protected $code = '';

	/**
	 * Mfn_Update constructor
	 */

	public function __construct(){

		$this->code = mfn_get_purchase_code();

		// It runs when wordpress check for updates
		add_filter( 'pre_set_site_transient_update_themes', array( $this, 'pre_set_site_transient_update_themes' ) );

		// Prepares themes for JavaScript
		add_filter( 'wp_prepare_themes_for_js', array( $this, 'autoupdate' ), 10, 2 );

	}

	/**
	 * Filter WP Update transient
	 *
	 * @param unknown $transient
	 * @return unknown
	 */

	public function pre_set_site_transient_update_themes( $transient ) {

		if( ! mfn_is_registered() ){
			return $transient;
		}

		$new_version = $this->remote_get_version();
		$theme_template = get_template();

		if( version_compare( wp_get_theme( $theme_template )->get( 'Version' ), $new_version, '<' ) ) {

			$args = array(
				'code' => $this->code,
			);

			if( mfn_is_hosted() ){
				$args[ 'ish' ] = mfn_get_ish();
			}

			$transient->response[ $theme_template ] = array(
				'theme' => $theme_template,
				'new_version' => $new_version,
				'url' => $this->get_url( 'changelog' ),
				'package' => add_query_arg( $args, $this->get_url( 'theme_download' ) ),
			);

		}

		return $transient;
	}

	/**
	 * Auto-updates, iterate throu the themes to enable or disable auto-updates
	 */

	public static function autoupdate( $prepared_themes ){

		$customized_themes = [];

		foreach ( $prepared_themes as $theme ) {

			if( 'betheme' == $theme['id'] ){

				$enable_or_disable = mfn_opts_get('automatic-updates');

				$auto_update = $enable_or_disable ? true : false;
				$auto_update_action = $enable_or_disable ? 'enable-auto-update' : 'disable-auto-update';

				$theme['autoupdate']['supported'] = $auto_update;
				$theme['autoupdate']['enabled'] = $auto_update;

				$theme['actions']['autoupdate'] = current_user_can( 'update_themes' )
					? wp_nonce_url( admin_url( 'themes.php?action=' . $auto_update_action . '&amp;theme=' . $theme['id'] ), 'updates' )
					: null;

			}

			$customized_themes[] = $theme;
		}

		return $customized_themes;

	}

}

$mfn_update = new Mfn_Update();
