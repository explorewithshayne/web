<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Status extends Mfn_API {

	private $data 	= array();
	private $status = array();
	public $wp_filesystem = '';

	/**
	 * Mfn_Status constructor
	 */
	public function __construct(){

		parent::__construct();

		require_once(get_theme_file_path('/functions/admin/class-mfn-helper.php'));
		$this->wp_filesystem = Mfn_Helper::filesystem();

		// It runs after the basic admin panel menu structure is in place.
		add_action( 'admin_menu', array( $this, 'init' ), 5 );

	}

	/**
	 * Add admin page & enqueue styles
	 */
	public function init(){

		$title = __( 'System Status','mfn-opts' );

		$page = add_submenu_page(
			apply_filters('betheme_dynamic_slug', 'betheme'),
			$title,
			$title,
			'edit_theme_options',
			apply_filters('betheme_slug', 'be').'-status',
			array( $this, 'template' )
		);

		// Fires when styles are printed for a specific admin page based on $hook_suffix.
		add_action( 'admin_print_styles-'. $page, array( $this, 'enqueue' ) );

	}

	/**
	 * Status template
	 */
	public function template(){

		$this->set_status();

		include_once get_theme_file_path('/functions/admin/templates/status.php');
	}

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue(){
		wp_enqueue_style( 'mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.css'), array(), MFN_THEME_VERSION );
		wp_enqueue_script('mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.js'), false, MFN_THEME_VERSION, true);
	}

	/**
	 * Get system status array
	 */
	public function set_status(){

		global $wpdb;

		$htaccess_path = get_home_path() .'.htaccess';

		$data = array(
			'wp_uploads' 			=> wp_get_upload_dir(),

			'mysql'						=> $wpdb->db_version(),
			'php'							=> phpversion(),
			'memory_limit' 		=> wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) ),
			'time_limit' 			=> ini_get( 'max_execution_time' ),
			'max_input_vars' 	=> ini_get( 'max_input_vars' ),
			'max_upload_size'	=> size_format( wp_max_upload_size() ),

			'home'						=> home_url(),
			'siteurl'					=> get_option( 'siteurl' ),
			'wp_version'			=> get_bloginfo( 'version' ),
			'multisite'				=> is_multisite(),
			'debug'						=> defined( 'WP_DEBUG' ) && WP_DEBUG,
			'language'				=> get_locale(),
			'rtl'							=> is_rtl() ? 'RTL' : 'LTR',
			'suhosin'					=> extension_loaded( 'suhosin' ),

			'version_history' => get_site_option( 'betheme_updates_history' ),
		);

		$status = array(
			'version' 				=> $this->version > 0,
			'uploads'					=> wp_is_writable($data['wp_uploads']['basedir']),
			'fs'							=> (Mfn_Helper::filesystem() || WP_Filesystem()) ? true : false,
			'zip'							=> class_exists( 'ZipArchive' ),
			'php'							=> version_compare( PHP_VERSION, '7.0' ) >= 0,

			'memory_limit'		=> $data['memory_limit'] >= 268435456,
			'time_limit'			=> ( ( $data['time_limit'] >= 180 ) || ( $data['time_limit'] == 0 ) ),
			'max_input_vars'	=> $data['max_input_vars'] >= 5000,
			'curl'						=> extension_loaded( 'curl' ),
			'dom'							=> class_exists( 'DOMDocument' ),
			'htaccess'				=> $this->wp_filesystem->is_writable($htaccess_path) && $this->wp_filesystem->is_readable($htaccess_path),

			'siteurl'					=> false,
			'https_home'			=> true,
			'https_site'			=> true,
			'wp_version'			=> version_compare( get_bloginfo( 'version' ), '5.0' ) >= 0,
		);

		$parse = array(
			'home' 		=> parse_url( $data['home'] ),
			'siteurl' => parse_url( $data['siteurl'] ),
		);

		if( isset( $parse['home']['host'] ) && isset( $parse['siteurl']['host'] ) ){
			if( $parse['home']['host'] == $parse['siteurl']['host'] ){
				$status['siteurl'] = true;
			}
		} elseif( isset( $parse['home']['path'] ) && isset( $parse['siteurl']['path'] ) ){
			if( $parse['home']['path'] == $parse['siteurl']['path'] ){
				$status['siteurl'] = true;
			}
		}

		// HTTPS

		if( isset( $parse['home']['scheme'] ) && 'https' != $parse['home']['scheme'] ){
			$status['https_home'] = false;
		}
		if( isset( $parse['siteurl']['scheme'] ) && 'https' != $parse['siteurl']['scheme'] ){
			$status['https_site'] = false;
		}

		$this->data		= $data;
		$this->status = $status;

	}

}

$mfn_status = new Mfn_Status();
