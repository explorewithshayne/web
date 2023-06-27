<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Support extends Mfn_API {

	/**
	 * Mfn_Support constructor
	 */
	public function __construct(){

		parent::__construct();

		// It runs after the basic admin panel menu structure is in place.
		add_action( 'admin_menu', array( $this, 'init' ), 6 );

	}

	/**
	 * Add admin page & enqueue styles
	 */
	public function init(){

		if( WHITE_LABEL ){
			return;
		}

		$title = __( 'Manual & Support','mfn-opts' );

		$is_support_disabled = apply_filters('betheme_disable_support', false);

		if ( ! $is_support_disabled ) {
			$page = add_submenu_page(
				apply_filters('betheme_dynamic_slug', 'betheme'),
				$title,
				$title,
				'edit_theme_options',
				apply_filters('betheme_slug', 'be').'-support',
				array( $this, 'template' )
			);

			// Fires when styles are printed for a specific admin page based on $hook_suffix.
			add_action( 'admin_print_styles-'. $page, array( $this, 'enqueue' ) );
		}
	}

	/**
	 * Status template
	 */
	public function template(){
		include_once get_theme_file_path('/functions/admin/templates/support.php');
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue(){
		wp_enqueue_style( 'mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.css'), array(), MFN_THEME_VERSION );
		wp_enqueue_style( 'mfn-magnific-popup', get_theme_file_uri('/functions/admin/assets/plugins/magnific-popup/magnific-popup.css'), array(), MFN_THEME_VERSION );

		wp_enqueue_script( 'mfn-dashboard.js', get_theme_file_uri('/functions/admin/assets/dashboard.js'), false, MFN_THEME_VERSION, true );
		wp_enqueue_script( 'mfn-magnific-popup', get_theme_file_uri('/functions/admin/assets/plugins/magnific-popup/magnific-popup.min.js'), false, MFN_THEME_VERSION, true );
	}

}

$mfn_support = new Mfn_Support();
