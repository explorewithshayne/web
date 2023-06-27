<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Mfn_Dashboard extends Mfn_API
{
	public $promo_version = 0;

	/**
	 * Mfn_Dashboard constructor
	 */

	public function __construct()
	{
		parent::__construct();

		$this->promo_version = $this->get_promo_version();

		// handle custom AJAX endpoint
		add_action( 'wp_ajax_mfn_survey', array( $this, '_survey' ) );
		add_action( 'wp_ajax_mfn_promo_close', array( $this, '_promo_close' ) );

		// after_switch_theme is triggered on the request immediately following a theme switch.
		add_action('after_switch_theme', array( $this, 'after_switch_theme' ));

		// switch_theme is triggered when the blog's theme is changed. Specifically, it fires after the theme has been switched but before the next request.
		add_action('switch_theme', array( $this, 'switch_theme' ));

		// Notices displayed near the top of admin pages. The hook function should echo a message to be displayed.
		add_action('admin_notices', array( $this, 'admin_notices' ), 1);

		// It runs after the basic admin panel menu structure is in place.
		add_action('admin_menu', array( $this, 'init' ), 1);

		// Load all necessary admin bar items.
		add_action('admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000); // group theme settings is allowed

		// bundled plugins
		add_filter('admin_body_class', array( $this, 'bundled_plugins' ));

		// betheme admin before tabs
		add_action('mfn-admin-before-tabs', array( $this, 'survey' ));

		// Notices displayed near the top of admin pages. The hook function should echo a message to be displayed.
		add_action('admin_notices', array( $this, 'wp_survey' ), 1);
	}

	/**
	 * Under Construction active | Admin notice
	 */

	public function admin_bar_menu()
	{
		if (mfn_opts_get('construction')) {
			global $wp_admin_bar;

			$wp_admin_bar->add_menu(array(
				'id' => 'mfn-notice-construction',
				'href' => 'admin.php?page=be-options#pages-under',
				'parent' => 'top-secondary',
				'title' => __('Under Construction active', 'mfn-opts'),
				'meta' => array( 'class' => 'mfn-notice' ),
			));
		}
	}

	/**
	 * Ajax | Survey close
	 */

	public function _survey(){

		set_site_transient( 'betheme_survey_25', 1, YEAR_IN_SECONDS );

		exit;

	}

	/**
	 * Be dashboard survey
	 */

	public function survey(){

		if( WHITE_LABEL || apply_filters('betheme_disable_survey', 0) ){
			return false;
		}

		if( get_site_transient( 'betheme_survey_25' ) ){
			return false;
		}

		include get_theme_file_path('/functions/admin/templates/parts/survey.php');
	}

	/**
	 * Wordpress dashboard survey
	 */

	public function wp_survey(){

		if( WHITE_LABEL || apply_filters('betheme_disable_survey', 0) ){
			return false;
		}

		if( get_site_transient( 'betheme_survey_25' ) ){
			return false;
		}

		// Current screen is not always available, most notably on the customizer screen.
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		$current_screen = get_current_screen();
		$current_screen = $current_screen->base;

		if ( 'dashboard' != $current_screen ) {
			return false;
		}

		include get_theme_file_path('/functions/admin/templates/parts/survey.php');
	}

	/**
	 * Ajax | Promo close
	 */

	public function _promo_close(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$version = htmlspecialchars(stripslashes($_POST['version']));

		if( empty( $version ) ){
			return;
		}

		update_site_option( 'betheme_promo_closed', $version );

		exit;

	}

	/**
	 * GET promo version
	 */

	function get_promo_version(){

		$this->force_check_promo_version();

		$version = get_site_transient( 'betheme_promo_version' );

		if( ! $version ){
			$version = $this->refresh_promo_version();
		}

		return $version;
	}

	/**
	 * Refresh theme version
	 * Remote get version
	 * Set transient
	 */

	function refresh_promo_version(){

		if( ! $version = $this->remote_get_promo_version() ){
			// set nagative value for transient which do not like 0 and false
			$version = -1;
		}

		// set transient
		set_site_transient( 'betheme_promo_version', $version, DAY_IN_SECONDS );

		return $version;
	}

	/**
	 * Remote get new promo version
	 */

	public function remote_get_promo_version(){

		$response = $this->remote_get( 'promo_version' );

		if( is_wp_error( $response ) ){
			return false;
		}

		if( empty( $response['version'] ) ){
			return false;
		}

		$banner = $this->remote_get( 'promo_download', false, false );

		if( $banner ){
			update_site_option( 'betheme_promo', $banner );
		} else {
			delete_site_option( 'betheme_promo' );
		}

		return $response['version'];
	}

	/**
	 * Force connection check and redirect
	 */

	function force_check_promo_version(){

		if( isset( $_GET['forcepromo'] ) ){
			$this->refresh_promo_version();
		}

	}

	/**
	 * GET promo banner code
	 */

	public function promo(){

 		// $last_promo_closed = get_site_option( 'betheme_promo_closed' );
		//
		// if ( version_compare( $this->promo_version, $last_promo_closed, '>' ) ) {
		// 	include_once get_theme_file_path('/functions/admin/templates/parts/promo.php');
		// }

		include_once get_theme_file_path('/functions/admin/templates/parts/promo.php');

 	}

	/**
	 * Add admin page & enqueue styles
	 */

	public function init()
	{

		$title = array(
			'betheme'	=> apply_filters('betheme_dynamic_slug', 'betheme'),
			'dashboard'	=> __('Dashboard', 'mfn-opts'),
			'label' => apply_filters('betheme_label', 'Betheme')
		);

		$icon = apply_filters('betheme_logo_nohtml', 'dashicons-minus');

		if ( WHITE_LABEL ) {
			$title['betheme'] = 'betheme';
			$title['label'] = 'Theme';
			$icon = 'dashicons-admin-generic';
		}

		$page = add_menu_page(
			$title['label'],
			$title['label'],
			'edit_theme_options',
			$title['betheme'],
			array( $this, 'template' ),
			$icon, // false
			2
		);

		add_submenu_page(
			$title['betheme'],
			$title['dashboard'],
			$title['dashboard'],
			'edit_theme_options',
			$title['betheme'],
			array( $this, 'template' )
		);

		// Fires when styles are printed for a specific admin page based on $hook_suffix.
		add_action('admin_print_styles-'. $page, array( $this, 'enqueue' ));
	}

	/**
	 * Dashboard template
	 */

	public function template()
	{
		include_once get_theme_file_path('/functions/admin/templates/dashboard.php');
	}

	/**
	 * Enqueue styles and scripts
	 */

	public function enqueue()
	{
		wp_enqueue_style('mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.css'), array(), MFN_THEME_VERSION);
		wp_enqueue_script('mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.js'), false, MFN_THEME_VERSION, true);
	}

	/**
	 * Redirect after switch theme
	 */

	public function after_switch_theme()
	{
		if( ! mfn_is_registered() ){
			return;
		}

		$error = false;

		$args = array(
			'user-agent' => 'WordPress/'. get_bloginfo('version') .'; '. network_site_url(),
			'timeout' => 30,
			'body' => array(
				'code' => urlencode(mfn_get_purchase_code()),
				'register' => 1,
			),
		);

		$response = $this->remote_post('register', $args);

		if (is_wp_error($response)) {
			$error = $response->get_error_message();
		} elseif (empty($response['success'])) {
			$error = true;
		}

		if( $error ){
			delete_site_option('envato_purchase_code_7758048');
		}

		// wp_safe_redirect(admin_url('admin.php?page=betheme'));
		wp_safe_redirect(admin_url('admin.php?page='.apply_filters('betheme_dynamic_slug', 'betheme')));

	}

	/**
	 * Theme deactivation - deactivate all theme related plugins
	 */

	public function switch_theme()
	{
		if (class_exists('Mfn_HB_Admin')) {
			deactivate_plugins('mfn-header-builder/mfn-header-builder.php');
		}
	}

	/**
	 * Admin notice - plase register
	 */

	public function admin_notices()
	{

		// Current screen is not always available, most notably on the customizer screen.
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}

		$current_screen = get_current_screen();
		$current_screen = $current_screen->base;

		$whitelist = array(
			'toplevel_page_betheme',
			'betheme_page_be-plugins',
			'betheme_page_be-websites',
			'betheme_page_be-status',
			'betheme_page_be-support',
		);

		if ( in_array( $current_screen, $whitelist ) ) {
			return false;
		}

		if ( mfn_is_registered() && ( 36 !== mfn_is_registered() ) ) {
			include_once get_theme_file_path( '/functions/admin/templates/notice-corrupted.php' );
		}

		if ( mfn_is_registered() || $this->is_localhost() ) {
			return false;
		}

		include_once get_theme_file_path( '/functions/admin/templates/notice-register.php' );
	}

	/**
	 * Bundled plugins | Hide intrusive notices
	 */

	function bundled_plugins( $classes ){
		if (! mfn_opts_get('plugin-rev')) {
			$classes .= ' bundled-rev ';
		}

		if (! mfn_opts_get('plugin-layer')) {
			$classes .= ' bundled-ls ';
		}

		if (! mfn_opts_get('plugin-visual')) {
			$classes .= ' bundled-wpb ';
		}

		return $classes;
	}

	/**
	 * Refresh site transients
	 */

	public function refresh_transients()
	{
		delete_site_transient('betheme_update_plugins');
		delete_site_transient('betheme_plugins');

		delete_site_transient('update_themes');
		do_action('wp_update_themes');
	}

}
