<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Plugins extends Mfn_API {

	/**
	 * Mfn_Plugins constructor
	 */

  private $plugins = [
    'becustom' => [
      'desc' => 'Rebrand Be & WordPress admin and take your business to the next level. Be like PRO!',
      'dark' => true,
      'premium' => true,
    ],
    'revslider' => [
      'desc' => 'Slider Revolution - More than just a WordPress Slider.',
      'premium' => true,
    ],
    'LayerSlider' => [
      'desc' => 'LayerSlider is a premium multi-purpose content creation and animation platform.',
      'premium' => true,
    ],
    'contact-form-7' => [
      'desc' => 'Just another contact form plugin. Simple but flexible.',
    ],
    'duplicate-post' => [
      'desc' => 'The go-to tool for cloning posts and pages, including the powerful Rewrite & Republish feature.',
    ],
    'elementor' => [
      'desc' => 'The Elementor Website Builder has it all: drag and drop page builder, pixel perfect design, mobile responsive editing, and more.',
      'dark' => true,
    ],
    'force-regenerate-thumbnails' => [
      'desc' => 'Delete and REALLY force the regenerate thumbnail.',
      'dark' => true,
    ],
    'leadin' => [
      'desc' => 'HubSpot’s official WordPress plugin allows you to add forms, popups, and live chat to your website and integrate with the best WordPress CRM.',
      'dark' => true,
    ],
    'woocommerce' => [
      'desc' => 'An eCommerce toolkit that helps you sell anything. Beautifully.',
      'dark' => true,
    ],
		'js_composer' => [
      'desc' => 'Drag and drop page builder for WordPress.',
      'premium' => true,
    ],
  ];

	public function __construct(){

		parent::__construct();

		// It runs after the basic admin panel menu structure is in place.
		add_action( 'admin_menu', array( $this, 'init' ), 2 );

	}

	/**
	 * Add admin page & enqueue styles
	 */

	public function init(){

		$title = __( 'Plugins','mfn-opts' );

		$page = add_submenu_page(
			apply_filters('betheme_dynamic_slug', 'betheme'),
			$title,
			$title,
			'edit_theme_options',
			apply_filters('betheme_slug', 'be').'-plugins',
			array( $this, 'template' )
		);

		// Fires when styles are printed for a specific admin page based on $hook_suffix.
		add_action( 'admin_print_styles-'. $page, array( $this, 'enqueue' ) );
	}

	/**
	 * Template
	 */

	public function template(){

    $tgm_plugins = $GLOBALS['tgmpa']->plugins;
    $installed_plugins = get_plugins();

    if( ! is_array($tgm_plugins) ){
      return;
    }

    foreach( $tgm_plugins as $tgm_plugin ){

      $path = $tgm_plugin['file_path'];
      $slug = $tgm_plugin['slug'];

      $plugin = [
        'name' => str_replace('DEPRECATED', '', $tgm_plugin['name']),
        'slug' => $tgm_plugin['slug'],
        'version' => $tgm_plugin['version'],
        'action' => '',
      ];

			if( empty($plugin['version']) ){
				if ( ! empty( $installed_plugins[$path]['Version'] ) ) {
  				$plugin['version'] = $installed_plugins[$path]['Version'];
  			}
			}

      if( is_plugin_active( $path ) ){

        // active, check if update is available

        $version_available = $tgm_plugin['version'];

        $version_installed = '';
        if ( ! empty( $installed_plugins[$path]['Version'] ) ) {
  				$version_installed = $installed_plugins[$path]['Version'];
  			}

        if( version_compare( $version_available, $version_installed, '>' ) ){
          $plugin['action'] = 'update';
					$plugin['path'] = $path;
        }

			} elseif( array_key_exists( $path, $installed_plugins ) || in_array( $path, $installed_plugins, true ) ){

        // installed but NOT active

      	$plugin['action'] = 'activate';
				$plugin['path'] = $path;

			} else {

        // NOT installed

				$plugin['action'] = 'install';

			}

			if( is_array($this->plugins[$slug]) && is_array($plugin) ){
        $this->plugins[$slug] = array_merge( $this->plugins[$slug], $plugin );
      }
    }

    // print_r( $this->plugins );

		include_once get_theme_file_path('/functions/admin/templates/plugins.php');

	}

	/**
	 * Enqueue styles and scripts
	 */

	public function enqueue(){
		wp_enqueue_style( 'mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.css'), array(), MFN_THEME_VERSION );
		wp_enqueue_script('mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.js'), false, MFN_THEME_VERSION, true);
	}

}

$mfn_plugins = new Mfn_Plugins();
