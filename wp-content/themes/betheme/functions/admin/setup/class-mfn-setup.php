<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Setup extends Mfn_API{

	private $demo_page_title = '_be_setup_wizard_demo';
	private $demo_page_id = [];

	public $demos = [];
	public $categories = [];
	public $layouts = [];
	public $plugins = [];
	public $tresaurus = [];

	public $count = [
    'categories' => [],
    'layouts' => [],
    'all' => 0,
  ];

	public $fonts = [
		[ 'Poppins', 'Poppins' ],
		[ 'Raleway', 'Lato' ],
		[ 'Sansita', 'Open Sans' ],
		[ 'Elsie', 'Roboto' ],
		[ 'Corben', 'Nobile' ],
		[ 'Playfair Display', 'Fauna one' ],

		[ 'Yeseva One', 'Josefin Sans' ],
		[ 'DM Serif Display', 'DM Sans' ],
		[ 'Roboto Condensed', 'Roboto' ],
		[ 'Arvo', 'Lato' ],
		[ 'Roboto', 'Nunito' ],

		[ 'Rubik', 'Roboto Mono' ],
		[ 'Roboto Slab', 'PT Sans' ],
		[ 'Sintony', 'Poppins' ],
		[ 'Philosopher', 'Mulish' ],
		[ 'Josefin Sans', 'Inter' ],
	];

	public $colors = [
		// bg, text, h1-h4, h5-h6, theme/link color, hover color
		[ '#FCFCFC', '#626262', '#161922', '#5f6271', '#006edf', '#0089f7' ], // default
		[ '#ffffff', '#3c5c55', '#225c54', '#1a4d46', '#b7c958', '#9bac40' ],
		[ '#fdf7f2', '#626262', '#2d2e36', '#4e4540', '#bb5644', '#c7786a' ],
		[ '#f7f2ef', '#646464', '#252525', '#1f2b1f', '#578a53', '#69c656' ],
		[ '#fdf7f2', '#5b6375', '#01247d', '#80101e', '#cf142b', '#b61024' ],

		[ '#fdf7f2', '#5f2e7a', '#3D1C4F', '#a069b5', '#2dbb52', '#20a041' ],
		[ '#ffffff', '#626262', '#2d2e36', '#4e4540', '#fd3e04', '#d23100' ],
		[ '#ffffff', '#000000', '#1f2e88', '#303971', '#3385d7', '#5ea0e8' ],
		[ '#ffffff', '#44056c', '#2a0443', '#f7b821', '#ee2c2c', '#ec6363' ],
		[ '#fdf7f2', '#808080', '#000000', '#045ba8', '#14c9f4', '#13bfe8' ],
	];

	/**
	 * Mfn_Tools constructor
	 */

	public function __construct(){

		parent::__construct();

		// get demo page ID

		$posts = get_posts(
	    array(
        'post_type'              => 'page',
        'title'                  => $this->demo_page_title,
        'post_status'            => 'all',
        'numberposts'            => -1,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
	    )
		);

		if( ! empty($posts) ){
			foreach( $posts as $post ){
				$this->demo_page_id[] = $post->ID;
			}
		}

    // handle custom AJAX endpoint

		add_action( 'wp_ajax_mfn_setup_register', array( $this, '_register' ) );
		add_action( 'wp_ajax_mfn_setup_deregister', array( $this, '_deregister' ) );
		add_action( 'wp_ajax_mfn_setup_rate', array( $this, '_rate' ) );
		add_action( 'wp_ajax_mfn_setup_websites', array( $this, '_get_websites' ) );

		add_action( 'wp_ajax_mfn_setup_database_reset', array( $this, '_database_reset' ) );
		add_action( 'wp_ajax_mfn_setup_plugin_install', array( $this, '_plugin_install' ) );
		add_action( 'wp_ajax_mfn_setup_plugin_activate', array( $this, '_plugin_activate' ) );
		add_action( 'wp_ajax_mfn_setup_download', array( $this, '_download_package' ) );
		add_action( 'wp_ajax_mfn_setup_content', array( $this, '_content' ) );
		add_action( 'wp_ajax_mfn_setup_options', array( $this, '_options' ) );
		add_action( 'wp_ajax_mfn_setup_slider', array( $this, '_slider' ) );
		add_action( 'wp_ajax_mfn_setup_settings', array( $this, '_settings' ) );

		add_action( 'wp_ajax_mfn_setup_options_scratch', array( $this, '_options_scratch' ) );
		add_action( 'wp_ajax_mfn_setup_settings_scratch', array( $this, '_settings_scratch' ) );

		// after_switch_theme is triggered on the request immediately following a theme switch.
		add_action( 'after_switch_theme', array( $this, 'after_switch_theme' ));

		// It runs after the basic admin panel menu structure is in place.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 2 );

		// Fires after the query variable object is created, but before the actual query is run.
		add_action( 'pre_get_posts', array( $this, 'exclude_demo_page' ) );

	}

	/**
	 * Exclude setup wizard demo page from pages list
	 */

	function exclude_demo_page( $query ) {

		if( ! is_admin() || empty( $this->demo_page_id ) ){
			return $query;
		}

		global $pagenow;

		if( 'edit.php' == $pagenow && ( get_query_var('post_type') && 'page' == get_query_var('post_type') ) ){
			$query->set( 'post__not_in', $this->demo_page_id );
		}

		return $query;
	}

	/**
	 * Redirect to setup wizard after switch theme if theme is unregistered
	 */

	public function after_switch_theme(){

		flush_rewrite_rules(false);

		if( mfn_is_registered() ){
			return;
		}

		wp_safe_redirect(admin_url('admin.php?page=be-setup'));

	}

	/**
	 * Add admin page & enqueue styles
	 */

	public function admin_menu(){

		$disable = mfn_opts_get('theme-disable');

		if( WHITE_LABEL || isset($disable['demo-data']) ){
			return;
		}

		$title = __( 'Setup Wizard','mfn-opts' );

		$page = add_submenu_page(
			apply_filters('betheme_dynamic_slug', 'betheme'),
			$title,
			$title,
			'edit_theme_options',
			apply_filters('betheme_slug', 'be') .'-setup',
			array( $this, 'init' )
		);

		add_action( 'admin_print_styles-'. $page, array( $this, 'enqueue' ) );

	}

	/**
	 * Add admin page & enqueue styles
	 */

	public function init(){

		// include demos, categories, etc

		require_once( get_theme_file_path('/functions/importer/demos.php') );

		$this->demos = $demos;
		$this->categories = $categories;
		$this->layouts = $layouts;
		$this->plugins = $plugins;
		$this->tresaurus = $tresaurus;

		// count all websites
    $this->count['all'] = count($this->demos) - 1; // FIX: array_slice

    // count websites in categories and layouts
    $this->count_websites();

		// check active plugins
		$this->check_active_plugins();

		// set demo page
		$this->set_demo_page();

		// add demos list to JS
		$localize = [
			'themeURI' => get_template_directory_uri() .'/',
			'placeholdersURI' => get_template_directory_uri() .'/functions/builder/pre-built/images/placeholders/',
			'demos' => $this->demos,
		];
		wp_localize_script( 'mfn-opts-js', 'mfnSetup', $localize );

		// print template

		$this->template();

	}

	/**
	 * Template
	 */

	public function template(){

		if( mfn_is_registered() ){
			include_once get_theme_file_path('/functions/admin/setup/templates/setup.php');
		} else {
			include_once get_theme_file_path('/functions/admin/setup/templates/register.php');
    }

	}

	/**
	 * Enqueue styles and scripts
	 */

	public function enqueue(){

		wp_enqueue_style( 'mfn-importer', get_theme_file_uri('/functions/importer/assets/importer.css'), array(), MFN_THEME_VERSION );
		wp_enqueue_style( 'mfn-setup', get_theme_file_uri('/functions/admin/setup/assets/setup.css'), array(), MFN_THEME_VERSION );

		wp_enqueue_media();
		wp_enqueue_script( 'mfn-webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'mfn-opts-field-upload', MFN_OPTIONS_URI .'fields/upload/field_upload.js', array( 'jquery' ), MFN_THEME_VERSION, true );
		wp_enqueue_script( 'mfn-opts-field-radio_img', MFN_OPTIONS_URI .'fields/radio_img/field_radio_img.js', array( 'jquery' ), MFN_THEME_VERSION, true );
		wp_enqueue_script( 'mfn-setup', get_theme_file_uri('/functions/admin/setup/assets/setup.js'), false, MFN_THEME_VERSION, true );

	}

	/**
	 * Template
	 */

	public function set_demo_page(){

		if( !empty($this->demo_page_id) ){
			return;
		}

		$wp_filesystem = Mfn_Helper::filesystem();
		$file = get_template_directory_uri() .'/functions/admin/setup/assets/content.txt';
		$mfn_items = $wp_filesystem->get_contents( $file );

		// remove images url

		$regex = '/\#mfn_placeholder\#/';
		$placeholder_url = get_template_directory_uri() .'/functions/admin/setup/assets/images/placeholders/';

		$mfn_items = unserialize(call_user_func('base'.'64_decode', $mfn_items));
		$mfn_items = Mfn_Builder_Ajax::builder_replace( $regex, $placeholder_url, $mfn_items );
		$mfn_items = call_user_func('base'.'64_encode', serialize( $mfn_items) );

		// insert post

		$post = [
			'post_title' => $this->demo_page_title,
      'post_status' => 'draft',
      'post_type' => 'page',
      'meta_input' => [
				'mfn-post-hide-title' => 1,
				'mfn-post-remove-padding' => 1,
				'mfn-page-items' => $mfn_items,
			],
		];

		$this->demo_page_id[] = wp_insert_post( $post );

	}

	/*
	 * Ajax: Get websites
	 */

	public function _get_websites(){

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		require_once( get_theme_file_path('/functions/admin/setup/demos.php') );
		$this->demos = $demos;

    $this->the_websites( 100, -1 );

		exit();
	}

	/**
   * Show websites
   */

  function the_websites( $start = 0, $limit = 100 ){

    $demos = array_slice( $this->demos, $start, $limit, true );

    include get_theme_file_path('/functions/admin/setup/templates/parts/websites-items.php');

  }

	/*
	 * Count websites in layouts and categories
	 */

	protected function count_websites(){

    foreach( $this->demos as $demo ){
      if( ! empty( $demo['categories'] ) ){
        foreach( $demo['categories'] as $v ){
					if( empty( $this->count['categories'][$v] ) ){
						$this->count['categories'][$v] = 0;
					}
          $this->count['categories'][$v]++;
        }
      }
      if( ! empty( $demo['layouts'] ) ){
        foreach( $demo['layouts'] as $v ){
					if( empty( $this->count['layouts'][$v] ) ){
						$this->count['layouts'][$v] = 0;
					}
          $this->count['layouts'][$v]++;
        }
      }
    }

	}

	/**
	 * Check if specified plugin is installed
	 */

	function is_plugin_installed( $plugin_slug ){
		$installed_plugins = get_plugins();
		return array_key_exists( $plugin_slug, $installed_plugins ) || in_array( $plugin_slug, $installed_plugins, true );
	}

	/**
	 * Check which plugins are active
	 */

	function check_active_plugins(){

		$tgm_plugins = $GLOBALS['tgmpa']->plugins;

		foreach($this->plugins as $key => $plugin){

			$slug = $plugin['slug'];

			if( is_plugin_active( $tgm_plugins[$slug]['file_path'] ) ){
				// do nothing, plugin as already active
			} elseif( $this->is_plugin_installed( $tgm_plugins[$slug]['file_path'] ) ){
				$this->plugins[$key]['action'] = 'activate';
				$this->plugins[$key]['path'] = $tgm_plugins[$slug]['file_path'];
			} else {
				$this->plugins[$key]['action'] = 'install';
			}

		}

	}

	/**
   * GET synonym
   */

  function get_synonym( $name ){

    $synonym = false;

    $name = preg_replace('/[0-9]+/', '', $name);

    if( ! empty( $this->tresaurus[$name] ) ){
      $synonym = $this->tresaurus[$name];
    }

    return $synonym;

  }

	/**
   * AJAX | Deregister
   */

  public function _deregister(){

    check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

    $response = $this->deregister();

    echo json_encode($response);

    exit();

  }

	/**
   * AJAX | Register
   */

  public function _register(){

    $response = [
      'status' => false,
      'info' => 'Invalid purchase code format.',
    ];

    check_ajax_referer( 'mfn-setup-register', 'mfn-setup-nonce' );

    if( ! empty($_POST['code']) ){

      $code = $this->validate( $_POST['code'] );

      if( $code ){
        $response = $this->register( $code );
      }

    }

    echo json_encode($response);

    exit();

  }

	/**
   * AJAX | Rate setup process
   */

  public function _rate(){

    check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

    $rating = $_POST['rating'];
    $code = $this->validate( mfn_get_purchase_code() );

		$return = [
      'status' => false,
      'message' => 'Invalid purchase code.',
    ];

		$args = array(
			'user-agent' => 'WordPress/'. get_bloginfo('version') .'; '. network_site_url(),
			'timeout' => 30,
			'body' => array(
				'code' => urlencode($code),
				'rating' => $rating,
			),
		);

		$response = $this->remote_post('rate', $args);

		if ( is_wp_error($response) ) {
			$return['info'] = $response->get_error_message();
		} elseif ( ! empty($response['success']) ) {
			$return['status'] = true;
		}

    echo json_encode($response);
    // echo json_encode($return);

    exit();

  }

  /**
	 * Validate purchase code
	 */

	public function validate( $code )
	{
		$code = trim( $code );

		if ( ! $code ){
			return false;
		}

		$pattern = '/^[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}$/';
		if ( ! preg_match( $pattern, $code ) ){
			return false;
		}

		return $code;
	}

  /**
	 * Register theme
	 */

	protected function register( $code )
	{
    $return = [
      'status' => false,
      'message' => 'Invalid purchase code.',
    ];

		$args = array(
			'user-agent' => 'WordPress/'. get_bloginfo('version') .'; '. network_site_url(),
			'timeout' => 30,
			'body' => array(
				'code' => urlencode($code),
				'register' => 1,
			),
		);

		$response = $this->remote_post('register', $args);

		if ( is_wp_error($response) ) {
			$return['info'] = $response->get_error_message();
			return $return;
		}

		if (empty($response['success'])) {
			return $return;
		}

    $return['status'] = true;

    // set purchase code

    update_site_option('envato_purchase_code_7758048', $code);

    // refresh transients

    delete_site_transient('betheme_update_plugins');
    delete_site_transient('betheme_plugins');

    delete_site_transient('update_themes');
    do_action('wp_update_themes');

		return $return;
	}

	/**
	 * Deregister theme
	 */

	protected function deregister()
	{
		$return = [
      'status' => true,
    ];

		$code = mfn_get_purchase_code();

		if ( ! $code ) {
			return false;
		}

		$args = array(
			'user-agent' => 'WordPress/'. get_bloginfo('version') .'; '. network_site_url(),
			'timeout' => 30,
			'body' => array(
				'code' => urlencode($code),
				'deregister' => 1,
			),
		);

		$this->remote_post('register', $args);

		// set purchase code

    update_site_option('envato_purchase_code_7758048', '');

    // refresh transients

    delete_site_transient('betheme_update_plugins');
    delete_site_transient('betheme_plugins');

    delete_site_transient('update_themes');
    do_action('wp_update_themes');

		return $return;
	}

	/*
	 * Ajax | Database reset
	 */

	public function _database_reset(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$remove_media = !empty($_POST['media']) ? 1 : 0;

		$result = Mfn_Importer_Helper::database_reset( $remove_media );

		if( $result ){
			echo 'Database has been reseted';
		}

		exit();
	}

	/**
	 * AJAX | Activate plugin
	 */

	public function _plugin_activate(){

		$response = [
			'error' => false,
			'message' => '',
		];

		if ( current_user_can( 'activate_plugins' ) ) {

			check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

			$result = activate_plugin( $_POST['path'] );

			if( is_wp_error( $result ) ) {
				$response['message'] = $result->get_error_message();
				$response['error'] = true;
			}

			echo json_encode($response);

			$this->disable_plugins_redirect();

		}

		exit();

	}

	/**
	 * AJAX | Install plugin
	 */

	public function _plugin_install(){

		if ( current_user_can( 'install_plugins' ) ) {

			// deactivate plugin before update
			if( ! empty($_GET['tgmpa-update']) && ! empty($_GET['path']) ){
				// deactivate_plugins( esc_attr($_GET['path']) );
			}

			$GLOBALS['tgmpa']->install_plugins_page();
			$this->disable_plugins_redirect();

		}

		exit();

	}

	/*
	 * Ajax | Download package
	 */

	public function _download_package(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$website = htmlspecialchars(stripslashes($_POST['website']));
		$builder = htmlspecialchars(stripslashes($_POST['builder']));

		if( ! $website ){
			return false;
		}

		$importer = new Mfn_Importer_Helper($website, $builder);

		$result = $importer->download_package();

		if( $result ){
			echo 'Package downloaded and unziped';
		}

		exit();
	}

	/*
	 * Ajax | Content installation
	 */

	public function _content(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$website = htmlspecialchars(stripslashes($_POST['website']));
		$builder = htmlspecialchars(stripslashes($_POST['builder']));
		$attachments = htmlspecialchars(stripslashes($_POST['attachments']));
		$complete_import = htmlspecialchars(stripslashes($_POST['complete_import']));

		if( ! $website ){
			return false;
		}

		$importer = new Mfn_Importer_Helper($website, $builder);

		// complete pre-built website import

		if( $complete_import ){

			// remove menus

			$importer->remove_menus();

		}

		// content

		$importer->content( $attachments );

		exit();
	}

	/*
	 * Ajax | Theme options
	 */

	public function _options(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$website = htmlspecialchars(stripslashes($_POST['website']));
		$builder = htmlspecialchars(stripslashes($_POST['builder']));
		$complete_import = htmlspecialchars(stripslashes($_POST['complete_import']));

		if( ! $website ){
			return false;
		}

		$importer = new Mfn_Importer_Helper($website, $builder);

		// theme options

		$result = $importer->options();

		if( $result ){
			echo 'Theme Options imported';
			echo '<br />';
		}

		// complete pre-built website import

		if( $complete_import ){

			// menu location

			$result = $importer->menu();

			if( $result ){
				echo 'Menu locations imported';
				echo '<br />';
			}

			// widgets

			$result = $importer->widgets();

			if( $result ){
				echo 'Widgets imported';
			}

		}

		exit();
	}

	/*
	 * Ajax | Slider
	 */

	public function _slider(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$website = htmlspecialchars(stripslashes($_POST['website']));
		$builder = htmlspecialchars(stripslashes($_POST['builder']));

		if( ! $website ){
			return false;
		}

		$importer = new Mfn_Importer_Helper($website, $builder);

		$result = $importer->slider();

		if( $result ){
			echo 'Sliders imported';
		}

		exit();
	}

	/*
	 * Ajax | Settings
	 */

	public function _settings(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$editor = false; // editor is set only in setup wizard
		$website = htmlspecialchars(stripslashes($_POST['website']));
		$builder = htmlspecialchars(stripslashes($_POST['builder']));
		$complete_import = htmlspecialchars(stripslashes($_POST['complete_import']));

		$blogname = htmlspecialchars(stripslashes($_POST['blogname']));
		$blogdescription = htmlspecialchars(stripslashes($_POST['blogdescription']));

		if( isset($_POST['editor']) ){
			$editor = htmlspecialchars(stripslashes($_POST['editor']));
		}

		if( ! $website ){
			return false;
		}

		$importer = new Mfn_Importer_Helper($website, $builder);

		// set site title nad tagline

		if( $blogname ){
			// update_option( 'blogname', $blogname ); // Elementor hook crashes here, workaround below:
			$value = sanitize_option( 'blogname', $blogname );
			$result = $wpdb->update( $wpdb->options, ['option_value' => $value], ['option_name' => 'blogname'] );
		}

		if( $blogdescription ){
			// update_option( 'blogdescription', $blogdescription ); // Elementor hook crashes here, workaround below:
			$value = sanitize_option( 'blogdescription', $blogdescription );
			$result = $wpdb->update( $wpdb->options, ['option_value' => $value], ['option_name' => 'blogdescription'] );
		}

		echo 'Site title and tagline set';
		echo '<br />';

		// set text editor

		if( $editor ){

			$option = 'column-visual';

			if( 'code' == $editor ){
				$value = 0;
			} else {
				$value = 1;
			}

			$result = Mfn_Builder_Ajax::settings($option, $value);

			if( $result ){
				echo 'Default text editor set';
				echo '<br />';
			}

		}

		// complete pre-built website import

		if( $complete_import ){

			// set pages

			$result = $importer->set_pages();

			if( $result ){
				echo 'Pages set';
				echo '<br />';
			}

			// regenerate CSS

			$result = $importer->regenerate_CSS();

			if( $result ){
				echo 'CSS regenerated';
				echo '<br />';
			}

		}

		// delete temporary directory

		$result = $importer->delete_temp_dir();

		if( $result ){
			echo 'Temporary files removed';
			echo '<br />';
		}

		flush_rewrite_rules(false);

		exit();
	}

	/*
	 * Ajax | Scratch Theme options
	 */

	public function _options_scratch(){

		global $MFN_Options;
		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$options = $MFN_Options->_default_values();

		// header

		if( ! empty($_POST['scratch']['header']) ){

			$header = $_POST['scratch']['header'];

			if( is_numeric( $header ) ){

				// pre-built header

				$mfn_items = $this->import_template($header);

				if( $mfn_items ){

					// replace logo

					if( ! empty($_POST['scratch']['logo']) ){

						foreach( $mfn_items as $s_k => $section ){
							if( ! empty( $section['wraps'] ) ){
								foreach( $section['wraps'] as $w_k => $wrap ){
									if( ! empty( $wrap['items'] ) ){
										foreach( $wrap['items'] as $i_k => $item ){
											if( 'header_logo' == $item['type'] && ! empty($item['fields']['image']) ){
												$mfn_items[$s_k]['wraps'][$w_k]['items'][$i_k]['fields']['image'] = esc_url($_POST['scratch']['logo']);
											}
										}
									}
								}
							}
						}

					}

					// styles

					$mfn_styles = Mfn_Helper::preparePostUpdate(wp_slash( $mfn_items ));

					if( isset( $mfn_styles['sections'] ) ){
						unset( $mfn_styles['sections'] );
					}

					// insert post

					$post = [
						'post_title' => 'Header template',
			      'post_status' => 'publish',
			      'post_type' => 'template',
			      'meta_input' => [
							'mfn_template_type' => 'header',
							'mfn_template_conditions' => json_encode([
								0 => [
									'rule' => 'include',
									'var' => 'everywhere',
								],
							]),
							'mfn-page-items' => call_user_func('base'.'64_encode', serialize( $mfn_items) ),
							'mfn-page-local-style' => json_encode( $mfn_styles ),
						],
					];

					$template_id = wp_insert_post( $post );

					// set conditions

					update_option( 'mfn_header_offer_arch', $template_id );
					update_option( 'mfn_header_offer_single', $template_id );
					update_option( 'mfn_header_page_arch', $template_id );
					update_option( 'mfn_header_page_single', $template_id );
					update_option( 'mfn_header_portfolio_arch', $template_id );

					update_option( 'mfn_header_portfolio_single', $template_id );
					update_option( 'mfn_header_post_arch', $template_id );
					update_option( 'mfn_header_post_single', $template_id );
					update_option( 'mfn_header_product_arch', $template_id );
					update_option( 'mfn_header_product_single', $template_id );

					// generate CSS

					Mfn_Helper::generate_css( $mfn_styles, $template_id );

				}

			} else {

				// default
				$options['header-style'] = $header;

			}

		}

		// logo

		if( ! empty($_POST['scratch']['logo']) ){
			$options['logo-img'] = esc_url( $_POST['scratch']['logo'] );
		}

		// footer

		if( ! empty($_POST['scratch']['footer']) ){

			$footer = $_POST['scratch']['footer'];
			$footer = str_replace('_', ';', $footer);

			if( is_numeric( $footer ) ){

				// pre-built footer

				$mfn_items = $this->import_template($footer);

				if( $mfn_items ){

					// styles

					$mfn_styles = Mfn_Helper::preparePostUpdate(wp_slash( $mfn_items ));

					if( isset( $mfn_styles['sections'] ) ){
						unset( $mfn_styles['sections'] );
					}

					// insert post

					$post = [
						'post_title' => 'Footer template',
			      'post_status' => 'publish',
			      'post_type' => 'template',
			      'meta_input' => [
							'mfn_template_type' => 'footer',
							'mfn-page-items' => call_user_func('base'.'64_encode', serialize( $mfn_items) ),
							'mfn-page-local-style' => json_encode( $mfn_styles ),
						],
					];

					$template_id = wp_insert_post( $post );

					// set conditions

					update_option( 'mfn_footer_offer_arch', $template_id );
					update_option( 'mfn_footer_offer_single', $template_id );
					update_option( 'mfn_footer_page_arch', $template_id );
					update_option( 'mfn_footer_page_single', $template_id );
					update_option( 'mfn_footer_portfolio_arch', $template_id );

					update_option( 'mfn_footer_portfolio_single', $template_id );
					update_option( 'mfn_footer_post_arch', $template_id );
					update_option( 'mfn_footer_post_single', $template_id );
					update_option( 'mfn_footer_product_arch', $template_id );
					update_option( 'mfn_footer_product_single', $template_id );

					// generate CSS

					Mfn_Helper::generate_css( $mfn_styles, $template_id );

				}

			} else {

				// default
				$options['footer-layout'] = $footer;

			}

		}

		// typography

		if( ! empty($_POST['scratch']['fonts']) && is_array( $_POST['scratch']['fonts'] ) ){

			$fonts = $_POST['scratch']['fonts'];

			$options['font-title'] = $fonts[0];
			$options['font-headings'] = $fonts[0];
			$options['font-decorative'] = $fonts[0];

			$options['font-content'] = $fonts[1];
			$options['font-menu'] = $fonts[1];
			$options['font-headings-small'] = $fonts[1];
			$options['font-blockquote'] = $fonts[1];
			$options['button-font-family'] = $fonts[1];
		}

		// colors

		if( ! empty($_POST['scratch']['colors']) && is_array( $_POST['scratch']['colors'] ) ){

			$colors = $_POST['scratch']['colors'];

			// background

			$options['background-html'] = $colors[0];
			$options['background-body'] = $colors[0];

			// text

			$options['color-text'] = $colors[1];
			$options['color-tab'] = $colors[1];
			$options['color-blockquote'] = $colors[1];

			// heading h1-h4

			$options['color-h1'] = $colors[2];
			$options['color-h2'] = $colors[2];
			$options['color-h3'] = $colors[2];
			$options['color-h4'] = $colors[2];

			// heading h5-h6

			$options['color-h5'] = $colors[3];
			$options['color-h6'] = $colors[3];

			// link

			$options['color-action-bar-a'] = $colors[4];
			$options['mobile-color-action-bar-a'] = $colors[4];
			$options['color-menu-a-active'] = $colors[4];
			$options['color-menu-responsive-icon'] = $colors[4];
			$options['background-overlay-menu'] = $colors[4];
			$options['color-theme'] = $colors[4];
			$options['color-selection'] = $colors[4];
			$options['color-a'] = $colors[4];
			$options['background-fancy-link'] = $colors[4];
			$options['color-fancy-link-hover'] = $colors[4];
			$options['background-highlight'] = $colors[4];
			$options['color-hr'] = $colors[4];
			$options['background-highlight-section'] = $colors[4];
			$options['color-tab-title'] = $colors[4];
			$options['background-getintouch'] = $colors[4];
			$options['color-contentlink'] = $colors[4];
			$options['color-counter'] = $colors[4];
			$options['color-iconbar'] = $colors[4];
			$options['color-iconbox'] = $colors[4];
			$options['color-list-icon'] = $colors[4];
			$options['color-pricing-price'] = $colors[4];
			$options['background-pricing-featured'] = $colors[4];
			$options['background-progressbar'] = $colors[4];
			$options['color-quickfact-number'] = $colors[4];
			$options['background-slidingbox-title'] = $colors[4];
			$options['background-trailer-subtitle'] = $colors[4];
			$options['color-shop-single-image-icon']['hover'] = $colors[4];
			$options['color-footer-theme'] = $colors[4];
			$options['color-footer-a-hover'] = $colors[4];
			$options['color-sliding-top-theme'] = $colors[4];
			$options['color-sliding-top-a'] = $colors[4];

			$options['background-action-button'] = $colors[4];
			$options['color-imageframe-link']['hover'] = $colors[4];

			// link hover

			$options['color-action-bar-a-hover'] = $colors[5];
			$options['mobile-color-action-bar-a-hover'] = $colors[5];
			$options['color-a-hover'] = $colors[5];
			$options['background-fancy-link-hover'] = $colors[5];
			$options['color-sliding-top-a-hover'] = $colors[5];

		}

		// update options

		update_option( 'betheme', $options );

		exit();
	}

	/*
	 * Ajax | Scratch Settings
	 */

	public function _settings_scratch(){

		global $wpdb;

		check_ajax_referer( 'mfn-setup', 'mfn-setup-nonce' );

		$editor = htmlspecialchars(stripslashes($_POST['editor']));

		$blogname = htmlspecialchars(stripslashes($_POST['blogname']));
		$blogdescription = htmlspecialchars(stripslashes($_POST['blogdescription']));

		// set site title nad tagline

		if( $blogname ){
			// update_option( 'blogname', $blogname ); // Elementor hook crashes here, workaround below:
			$value = sanitize_option( 'blogname', $blogname );
			$result = $wpdb->update( $wpdb->options, ['option_value' => $value], ['option_name' => 'blogname'] );
		}

		if( $blogdescription ){
			// update_option( 'blogdescription', $blogdescription ); // Elementor hook crashes here, workaround below:
			$value = sanitize_option( 'blogdescription', $blogdescription );
			$result = $wpdb->update( $wpdb->options, ['option_value' => $value], ['option_name' => 'blogdescription'] );
		}

		echo 'Site title and tagline set';
		echo '<br />';

		// set text editor

		if( $editor ){

			$option = 'column-visual';

			if( 'code' == $editor ){
				$value = 0;
			} else {
				$value = 1;
			}

			$result = Mfn_Builder_Ajax::settings($option, $value);

			if( $result ){
				echo 'Default text editor set';
				echo '<br />';
			}

		}

		exit();
	}

	/**
	 * Import template
	 */

	public function import_template( $id ){

		if( ! $id ){
			return false;
		}

		$sections_api = new Mfn_Pre_Built_Sections_API( $id );
		$response = $sections_api->remote_get_section();

		if( ! $response ){

			_e( 'Remote API error.', 'mfn-opts' );

		} elseif( is_wp_error( $response ) ){

			echo $response->get_error_message();

		} else {

			// unserialize response

			$mfn_items = unserialize(call_user_func('base'.'64_decode', $response));

			if( ! is_array( $mfn_items ) ){
				return false;
			}

			// change images url

			$placeholder_url = get_template_directory_uri() .'/functions/builder/pre-built/images/placeholders/';

			$regex = '/\#mfn_placeholder\#/';
			$mfn_items = Mfn_Builder_Ajax::builder_replace( $regex, $placeholder_url, $mfn_items );

			return $mfn_items;

		}

		return false;

	}

	/**
	 * Disable plugin redirect after activation
	 */

	public function disable_plugins_redirect() {

		delete_transient( '_bbp_activation_redirect' );
		delete_transient( '_revslider_welcome_screen_activation_redirect' );
		delete_transient( '_tribe_events_activation_redirect' );
		delete_transient( '_wc_activation_redirect' );
		delete_transient( 'leadin_redirect_after_activation' );

	}

}

$mfn_setup = new Mfn_Setup();
