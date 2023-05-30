<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Importer extends Mfn_Setup {

	/**
	 * Mfn_Tools constructor
	 */

	public function __construct(){

		// It runs after the basic admin panel menu structure is in place.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 3 );

	}

	/**
	 * Add admin page & enqueue styles
	 */

	public function admin_menu(){

		$disable = mfn_opts_get('theme-disable');

		if( WHITE_LABEL || isset($disable['demo-data']) ){
			return;
		}

		$title = __( 'Pre-built websites', 'mfn-opts' );

		$this->page = add_submenu_page(
			apply_filters('betheme_dynamic_slug', 'betheme'),
			$title,
			$title,
			'edit_theme_options',
			apply_filters('betheme_slug', 'be').'-websites',
			array( $this, 'init' )
		);

		// Fires when styles are printed for a specific admin page based on $hook_suffix.
		add_action( 'admin_print_styles-'. $this->page, array( $this, 'enqueue' ) );
	}

	/**
	 * Status template
	 */

	public function template(){

		include_once get_theme_file_path('/functions/importer/templates/importer.php');

	}

	/**
	 * Enqueue styles and scripts
	 */

	public function enqueue(){
		wp_enqueue_style( 'mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.css'), array(), MFN_THEME_VERSION );
		wp_enqueue_style( 'mfn-importer', get_theme_file_uri('/functions/importer/assets/importer.css'), array(), MFN_THEME_VERSION );

		wp_enqueue_script('mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.js'), false, MFN_THEME_VERSION, true);
		wp_enqueue_script('mfn-importer', get_theme_file_uri('/functions/importer/assets/importer.js'), false, MFN_THEME_VERSION, true);
	}

}

$mfn_importer = new Mfn_Importer();
