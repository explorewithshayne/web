<?php
/**
 * Import single page remote API
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if ( ! defined( 'ABSPATH' ) ){
	exit;
}

class Mfn_Single_Page_Import_API extends Mfn_API {

	protected $code = '';
	protected $page = '';

	/**
	 * The constructor
	 */

	public function __construct( $page = false ){

		if( ! $page ){
			return false;
		}

		$this->code = mfn_get_purchase_code();
		$this->page = $page;

	}

	/**
	 * Remote get page
	 */

	public function remote_get_page(){

		$args = array(
			'code' => $this->code,
			'page' => $this->page,
		);

		if( mfn_is_hosted() ){
			$args[ 'ish' ] = mfn_get_ish();
		}

		$url = add_query_arg( $args, $this->get_url( 'pages_download' ) );

		$args = array(
			'user-agent' => 'WordPress/'. get_bloginfo( 'version' ) .'; '. network_site_url(),
			'timeout' => 30,
		);

		$response = wp_remote_get( $url, $args );

		if( is_wp_error( $response ) ){
			return $response;
		}

		$body = wp_remote_retrieve_body( $response );

		// remote get fallback
		if( empty( $body ) ){
			if( function_exists( 'ini_get' ) && ini_get( 'allow_url_fopen' ) ){
				$body = @file_get_contents( $url );
			}
		}

		if( empty( $body ) ){
			return new WP_Error( 'error_download', __( 'The package could not be downloaded. Please make sure your theme is registered for this domain.', 'mfn-opts' ) );
		}

    if( $json = json_decode( $body, true ) ){
			if( isset( $json['error'] ) ){
				return new WP_Error( 'invalid_response', $json['error'] );
			}
		}

		return $body;
	}

}
