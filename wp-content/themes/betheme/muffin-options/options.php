<?php
if ( ! class_exists( 'MFN_Options' ) ) {

	if ( ! defined( 'MFN_OPTIONS_DIR' ) ) {
		define( 'MFN_OPTIONS_DIR', get_template_directory() .'/muffin-options/' );
	}

	if ( ! defined( 'MFN_OPTIONS_URI' ) ) {
		define( 'MFN_OPTIONS_URI', get_template_directory_uri() .'/muffin-options/' );
	}

	class MFN_Options
	{
		public $dir = MFN_OPTIONS_DIR;
		public $url = MFN_OPTIONS_URI;
		public $page = '';

		public $args = array();
		public $sections = array();

		public $errors = array();
		public $warnings = array();

		public $options = array();

		public $menu = array();

		/**
		 * Class Constructor. Defines the args for the theme options class
		 */

		public function __construct($menu = array(), $sections = array())
		{
			$this->menu = apply_filters('mfn-opts-menu', $menu);

			$defaults = array();

			$defaults['opt_name'] = 'betheme';

			$defaults['menu_icon'] = MFN_OPTIONS_URI .'/img/menu_icon.png';
			$defaults['menu_title'] = __('Theme Options', 'mfn-opts');
			$defaults['page_title'] = __('Theme Options', 'mfn-opts');
			$defaults['page_slug'] = apply_filters('betheme_slug', 'be').'-options';
			$defaults['page_cap'] = 'edit_theme_options';
			$defaults['page_type'] = 'menu';
			$defaults['page_parent'] = '';
			$defaults['page_position'] = 100;

			// get args

			$this->args = $defaults;
			$this->args = apply_filters( 'mfn-opts-args', $this->args );
			$this->args = apply_filters( 'mfn-opts-args-'. $this->args['opt_name'], $this->args );

			// get sections

			$this->sections = apply_filters( 'mfn-opts-sections', $sections );
			$this->sections = apply_filters( 'mfn-opts-sections-'. $this->args['opt_name'], $this->sections );

			// set option with defaults
			add_action( 'init', array( $this, '_set_default_options' ) );
			add_action( 'init', array( $this, '_backward_compatibility' ) );

			// save new custom fonts
			add_action( 'init', array( $this, '_register_custom_social' ), 11 );
			add_action( 'init', array( $this, '_register_custom_fonts' ), 12 );

			// options page
			add_action( 'admin_menu', array( $this, '_options_page' ), 4 );
			add_filter( 'admin_body_class', array( $this, '_admin_body_class' ) );

			// register setting
			add_action( 'admin_init', array( $this, '_register_setting' ) );

			if( empty( $_GET['action'] ) || $_GET['action'] != apply_filters('betheme_slug', 'mfn') .'-live-builder' ){
				// first action hooked into the admin scripts actions
				add_action( 'admin_enqueue_scripts', array( $this, '_enqueue' ) );
			}

			// hook into the wp feeds for downloading the exported settings
			add_action( 'do_feed_mfn-opts-'. $this->args['opt_name'], array( $this, '_download_options' ), 1, 1 );

			// add actions before form
			add_action( 'mfn-opts-page-before-form', array( $this, '_static_CSS' ), 10 );
			add_action( 'mfn-opts-page-before-form', array( $this, '_cache_manager' ), 11 );
			add_action( 'mfn-opts-page-before-form', array( $this, '_flush_cache' ), 12 );

			// get the options for use later on
			$this->options = get_option( $this->args['opt_name'] );
		}

		/**
		 * Backward compatibility with older Betheme versions
		 * @since 21.9.1
		 */

		public function _backward_compatibility(){

			if( ! is_array($this->options) ){
				$this->options = [];
			}

			// Minimalist header @since 21.9.1

			if( isset( $this->options['minimalist-header'] ) ) {

				if( 'no' === $this->options['minimalist-header'] ) {

					$this->options['header-height'] = '0'; // use string not integer
					$this->options['mobile-subheader-padding'] = '80px 0';

				} elseif( '1' === $this->options['minimalist-header'] ) {

					$this->options['header-height'] = '0';

					if( 'modern' == $this->options['header-style'] ){
						$this->options['header-height'] = '147';
					}

					if( 'simple' == $this->options['header-style'] ){
						$this->options['header-height'] = '130';
					}

					if( 'fixed' == $this->options['header-style'] ){
						$this->options['header-height'] = '60';
					}

				} else {

					$this->options['header-height'] = '250';

				}

			}

			// Custom Variation Swatches @since 25.0.3

			if( ! isset( $this->options['variable-swatches'] ) ) {
				$this->options['variable-swatches'] = '1';
			}

			// Social icons order @since 25.1.6

			$socials = ['skype','whatsapp','facebook','twitter','vimeo','youtube','flickr','linkedin','pinterest','dribbble','instagram','snapchat','behance','tumblr','tripadvisor','vkontakte','viadeo','xing','custom','rss'];

			if( empty( $this->options['social-link']['order'] ) ) {
				$this->options['social-link'] = [];
				$this->options['social-link']['order'] = implode( ',', $socials );
			}

			foreach( $socials as $social ){
				if( isset( $this->options['social-'. $social] ) ) {
					$this->options['social-link'][$social] = $this->options['social-'. $social];
				}
			}

		}

		/**
		 * This is used to return and option value from the options array
		 */

		public function get( $opt_name, $default = null )
 		{
 			if( ! is_array( $this->options ) ){
 				return $default;
 			}

 			if( ! key_exists( $opt_name, $this->options ) ){
 				return $default;
 			}

 			if( empty( $this->options[$opt_name] ) && ( '0' !== $this->options[$opt_name] ) ){
 				return $default;
 			}

 			return $this->options[$opt_name];
 		}

		/**
		 * Get default options into an array suitable for the settings API
		 */

		public function _default_values()
		{
			$defaults = array();

			foreach ( $this->sections as $k => $section ) {
				if ( isset( $section['fields'] ) ) {
					foreach ( $section['fields'] as $fieldk => $field ) {

						if ( empty( $field['id'] ) ){
							continue;
						}

						if ( ! isset( $field['std'] ) ) {
							$field['std'] = '';
						}

						$defaults[ $field['id'] ] = $field['std'];

					}
				}
			}

			$defaults['last_tab'] = false;
			return $defaults;
		}

		/**
		 * Set default options on admin_init if option doesnt exist (theme activation hook caused problems, so admin_init it is)
		 */

		public function _set_default_options()
		{
			if ( ! get_option($this->args['opt_name']) ) {
				add_option($this->args['opt_name'], $this->_default_values());
			}
			$this->options = get_option($this->args['opt_name']);

			// be setup wizard
			if( isset( $_GET['mfn-setup-preview'] ) ){
				$this->options = $this->_default_values();
			}
		}

		/**
		 * Class Theme Options Page Function, creates main options page.
		 */

		public function _options_page()
		{
			$this->page = add_submenu_page(
				apply_filters('betheme_dynamic_slug', 'betheme'),
				$this->args['page_title'],
				$this->args['page_title'],
				$this->args['page_cap'],
				apply_filters('betheme_slug', 'be').'-options',
				array( $this, '_options_page_html' )
			);

			// Fires when styles are printed for a specific admin page based on $hook_suffix.
			add_action( 'admin_print_styles-'. $this->page, array( $this, '_enqueue_options_page' ) );
		}

		/**
		 * Admin body class
		 * @param string $classes
		 */

		public function _admin_body_class( $classes )
		{
			$classes .= ' theme_page_be-options';

			// load google fonts
			if ( mfn_opts_get('google-font-mode') !== 'disabled' ) {
				$classes .= ' has-googlefonts';
			}

			// hide wordpress editor
			if ( mfn_opts_get('hide_editor') ) {
				$classes .= ' hide-wp-editor';
			}

			// UI options

			$ui_options = Mfn_Builder_Helper::get_options();
			$screen = get_current_screen();

			if( is_object( $screen ) ){
				$screen = $screen->base;
			}

			$be_dark = array(
				'toplevel_page_betheme',
				'betheme_page_be-setup',
				'betheme_page_be-plugins',
				'betheme_page_be-websites',
				'betheme_page_be-options',
				'betheme_page_be-status',
				'betheme_page_be-support',
				'betheme_page_be-changelog',
				'betheme_page_be-tools',
			);

			// dark mode
			if( ! empty( $ui_options['dashboard-ui'] ) && 'dark' == $ui_options['dashboard-ui'] && in_array( $screen, $be_dark ) ){
				$classes .= ' mfn-ui-dark';
			} else {
				$classes .= ' mfn-ui-light';
			}

			return $classes;
		}

		/**
		 * Enqueue styles/js GLOBAL
		 */

		public function _enqueue()
 		{
 			// styles

			if ( ! mfn_opts_get('google-font-mode') ) {
				wp_enqueue_style('mfn-opts-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600', false, MFN_THEME_VERSION, 'all');
			} elseif ( 'local' === mfn_opts_get( 'google-font-mode' ) ) {
				$path_fonts = mfn_uploads_dir('baseurl', 'fonts');
				wp_enqueue_style('mfn-opts-font', $path_fonts.'/mfn-local-fonts.css', false, MFN_THEME_VERSION, 'all');
			}

			$performance_assets_disable = mfn_opts_get('performance-assets-disable');

			if ( ! isset( $performance_assets_disable[ 'font-awesome' ] ) ) {
				wp_enqueue_style('mfn-opts-fontawesome', get_theme_file_uri('/fonts/fontawesome/fontawesome.css'), false, MFN_THEME_VERSION, 'all');
			}

 			wp_enqueue_style('mfn-opts-icons', get_theme_file_uri('/fonts/mfn/icons.css'), false, MFN_THEME_VERSION, 'all');
 			wp_enqueue_style('mfn-opts', $this->url .'css/options.css', false, MFN_THEME_VERSION, 'all');

			// magnific popup

			wp_enqueue_style( 'mfn-magnific-popup', get_theme_file_uri('/functions/admin/assets/plugins/magnific-popup/magnific-popup.css'), array(), MFN_THEME_VERSION );
			wp_enqueue_script( 'mfn-magnific-popup', get_theme_file_uri('/functions/admin/assets/plugins/magnific-popup/magnific-popup.min.js'), false, MFN_THEME_VERSION, true );

			// scripts

			wp_enqueue_script( 'mfn-opts-plugins', $this->url .'js/plugins.js', array('jquery'), MFN_THEME_VERSION, true );

			wp_register_script( 'mfn-opts-js', $this->url .'js/options.js', array('jquery'), MFN_THEME_VERSION, true );

			$screen = get_current_screen();

			if( is_object( $screen ) && 'toplevel_page_revslider' !== $screen->base ){

				// syntax highlight

	 			$cm_args = array(
	 				'autoRefresh' => true,
	 			  'lint' => true,
	 				'indentUnit' => 2,
	 				'tabSize' => 2,
	 			);

	 			$codemirror['css']['codeEditor'] = wp_enqueue_code_editor(array(
	 				'type' => 'text/css', // required for lint
	 				'codemirror' => $cm_args,
	 			));

	 			$codemirror['html']['codeEditor'] = wp_enqueue_code_editor(array(
	 				'type' => 'text/html', // required for lint
	 				'codemirror' => $cm_args,
	 			));

	 			$codemirror['javascript']['codeEditor'] = wp_enqueue_code_editor(array(
	 				'type' => 'javascript', // required for lint
	 				'codemirror' => $cm_args,
	 			));

	 			wp_localize_script( 'mfn-opts-js', 'mfn_cm', $codemirror );

			}

 			wp_enqueue_script( 'mfn-opts-js' );

 		}

		/**
		 * Enqueue styles/js THEME OPTIONS only
		 */

		public function _enqueue_options_page()
 		{
			wp_enqueue_style( 'mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.css'), array(), MFN_THEME_VERSION );
			wp_enqueue_script('mfn-dashboard', get_theme_file_uri('/functions/admin/assets/dashboard.js'), false, MFN_THEME_VERSION, true);
 		}

		/**
		 * Download the options file, or display it
		 */

		public function _download_options()
		{
			if (! isset($_GET['secret']) || $_GET['secret'] != md5(AUTH_KEY.SECURE_AUTH_KEY)) {
				wp_die('Invalid Secret for options use');
				exit;
			}
			if (! isset($_GET['feed'])) {
				wp_die('No Feed Defined');
				exit;
			}

			$backup_options = get_option(str_replace('mfn-opts-', '', $_GET['feed']));
			$backup_options['mfn-opts-backup'] = '1';

			if (isset($_GET['action']) && $_GET['action'] == 'download_options') {
				header('Content-Description: File Transfer');
				header('Content-type: application/txt');
				header('Content-Disposition: attachment; filename="'. str_replace('mfn-opts-', '', $_GET['feed']) .'_options_'. date('d-m-Y') .'.txt"');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				echo '###'. serialize($backup_options) .'###';
				exit;
			} else {
				echo '###'. serialize($backup_options) .'###';
				exit;
			}
		}

		/**
		 * Static CSS
		 */

		public function _static_CSS()
		{
			if( empty($_GET['settings-updated']) || empty($this->options['static-css']) ){
				return false;
			};

			$wp_filesystem = Mfn_Helper::filesystem();

			$upload_dir = wp_upload_dir();
			$path_be = wp_normalize_path( $upload_dir['basedir'] .'/betheme' );
			$path_css = wp_normalize_path( $path_be .'/css' );
			$path = wp_normalize_path( $path_css .'/static.css' );

			if( ! file_exists( $path_be ) ){
				wp_mkdir_p( $path_be );
			}

			if( ! file_exists( $path_css ) ){
				wp_mkdir_p( $path_css );
			}

			$css = "/* theme options */\n";
			$css .= mfn_styles_dynamic();

			$wp_filesystem->put_contents( $path, $css, FS_CHMOD_FILE );
		}

		/**
		 * Flush W3 Total Cache
		 */

		public function _flush_cache()
		{
			if( empty($_GET['settings-updated']) ){
				return false;
			};

			if ( function_exists('w3tc_flush_all') ){
				w3tc_flush_all();
			}
		}

		/**
		 * Caching
		 */

		public function _cache_manager()
		{
			$cache_created = get_transient('betheme_hold-cache');
			$cache_activate = intval(mfn_opts_get('hold-cache'));

			if( 'changed' == $cache_created ){

				if ( $cache_activate ) {

					$this->_setup_cache();
					delete_transient('betheme_hold-cache');
					@clearstatcache();

				} else {

					$this->_remove_cache();
					delete_transient('betheme_hold-cache');
					@clearstatcache();

				}

			}

		}

		public function _setup_cache()
		{
			if( empty($_GET['settings-updated'] ) || ! mfn_opts_get('hold-cache') ) {
				return false;
			}

			$wp_filesystem = Mfn_Helper::filesystem();
			$htaccess_path = get_home_path() .'.htaccess';

			$htaccess_content = $wp_filesystem->get_contents($htaccess_path);
			$htaccess_new_content = $htaccess_content . Mfn_Helper::get_cache_text();

			$wp_filesystem->put_contents($htaccess_path, $htaccess_new_content, 0644);
		}

		public function _remove_cache()
		{
			$wp_filesystem = Mfn_Helper::filesystem();
			$htaccess_path = get_home_path() .'.htaccess';

			$htaccess_content = $wp_filesystem->get_contents($htaccess_path);
			$htaccess_new_content = preg_replace('/(# BEGIN BETHEME)(.|\n)*?(# END BETHEME)/', '', $htaccess_content);

			$wp_filesystem->put_contents($htaccess_path, $htaccess_new_content, 0644);
		}

		/**
		 * Theme Options -> Social -> Custom
		 * Save only filled fields (dynamically added)
		 */

		public function _register_custom_social()
		{
			if( empty( $this->options['custom-icon-count'] ) ){
				return false;
			};

			$number_loaded = 2; // we start from 2, because 1 custom icon is default
			$custom_amount = intval( $this->options['custom-icon-count'] ) + $number_loaded;

			$loop = 2; // we start from 2, because 1 custom icon is default

			for( $loop; $loop < $custom_amount; $loop++ ){

				if ( ! empty( $this->options['social-custom-icon-'. $loop] ) ) {

					$this->options['social-custom-icon-'. $number_loaded] = $this->options['social-custom-icon-'. $loop];
					$this->options['social-custom-link-'. $number_loaded] = $this->options['social-custom-link-'. $loop];
					$this->options['social-custom-title-'. $number_loaded] = $this->options['social-custom-title-'. $loop];

					// increase flag, it means one custom dynamically social is loaded

					$number_loaded++;

				} else {

					// Empty ALL values if icon is not provided

					$this->options['social-custom-icon-'. $loop] = '';
					$this->options['social-custom-link-'. $loop] = '';
					$this->options['social-custom-title-'. $loop] = '';

					// remove icon from social order field

					if( ! empty( $this->options['social-link']['order'] ) ){
						$name = 'custom-'. $number_loaded;
						$names = [
							$name .',',
							','. $name,
						]; // removes also "," sign
						$this->options['social-link']['order'] = str_replace($names, '', $this->options['social-link']['order']);
					}

				}

			}

			// update the new fields amount, to know how many fields have to appear
			$this->options['custom-icon-count'] = $number_loaded - 2;
		}

		/**
		 * Theme Options -> Fonts -> Custom
		 * Save only filled fields (dynamically added)
		 */

		public function _register_custom_fonts()
		{
			if( ! mfn_opts_get('font-custom-fields') ){
				return false;
			};

			$font_number_loaded = 3; // we start from 3, because 2 custom fonts are default ones
			$loop = 3; // we start from 3, because 2 custom fonts are default ones
			$custom_amount = intval(mfn_opts_get('font-custom-fields')) + $loop;

			for( $loop; $loop < $custom_amount; $loop++ ){

				if ( ! empty( mfn_opts_get( 'font-custom'. $loop ) ) ) {

					// Overwrite the most early font field, with values from field
					$this->options['font-custom'. $font_number_loaded] = mfn_opts_get( 'font-custom'. $loop );
					$this->options['font-custom'. $font_number_loaded .'-woff'] = mfn_opts_get( 'font-custom'. $loop .'-woff' );
					$this->options['font-custom'. $font_number_loaded .'-ttf' ] = mfn_opts_get( 'font-custom'. $loop .'-ttf' );

					// increase flag, it means one custom dynamically font is loaded.
					$font_number_loaded++;

				} else {

					// Empty ALL values if title is not provided
					$this->options['font-custom'. $loop] = '';
					$this->options['font-custom'. $loop .'-woff']	= '';
					$this->options['font-custom'. $loop .'-ttf'] = '';

				}

			}

			// update the new fields amount, to know how many fields have to appear
			$this->options['font-custom-fields'] = $font_number_loaded - 3;
		}

		/**
		 * Validate the Options options before insertion
		 */

		public function _validate_options($plugin_options)
		{
			set_transient('mfn-opts-saved', '1', 1000);

			// options | import

			if (! empty($plugin_options['import'])) {

				if ($plugin_options['import_code'] != '') {

					// import from file
					$import = $plugin_options['import_code'];

				} elseif ($plugin_options['import_link'] != '') {

					// import from URL
					$import = wp_remote_retrieve_body(wp_remote_get($plugin_options['import_link']));

				}

				$imported_options = @unserialize(trim($import, '###'));

				// FIX | Import 1-click Demo Data encoded options file

				if ($imported_options === false) {
					$import_tmp_fn = 'base'.'64_decode'; // it will return FALSE if NOT base64
					$import = call_user_func($import_tmp_fn, trim($import));
					$imported_options = unserialize($import);
				}

				if (is_array($imported_options)) {
					$imported_options['imported'] = 1;
					$imported_options['last_tab'] = false;
					return $imported_options;
				}

			}

			// options | defaults

			if (isset($plugin_options['defaults']) && ($plugin_options['defaults'] == 'Resetting...')) {
				$plugin_options = $this->_default_values();
				return $plugin_options;
			}

			// validate fields (if needed)

			$plugin_options = $this->_validate_values($plugin_options, $this->options);

			// JS error handling

			if ( $this->errors ) {
				set_transient( 'mfn-opts-errors', $this->errors, 1000 );
			}

			if ( $this->warnings ) {
				set_transient( 'mfn-opts-warnings', $this->warnings, 1000 );
			}

			// after validate hooks

			do_action('mfn-opts-options-validate', $plugin_options, $this->options);
			do_action('mfn-opts-options-validate-'.$this->args['opt_name'], $plugin_options, $this->options);

			// unset unwanted attributes

			if( ! wp_doing_ajax() ){
				unset($plugin_options['defaults']);
				unset($plugin_options['import']);
				unset($plugin_options['import_code']);
				unset($plugin_options['import_link']);
			}

			return $plugin_options;
		}

		/**
		 * Validate values from options form (used in settings api validate function)
		 * calls the custom validation class for the field so authors can override with custom classes
		 */

		public function _validate_values($plugin_options, $options)
		{
			foreach ($this->sections as $k => $section) {
				if (isset($section['fields'])) {
					foreach ($section['fields'] as $fieldk => $field) {

						$field['section_id'] = $k;

						if ( empty( $field['id'] ) || empty( $plugin_options[$field['id']] ) ) {
							continue;
						}

						// force validate of specified filed types

						/*
						if (isset($field[ 'type' ]) && ! isset($field[ 'validate' ])) {
							if ($field[ 'type' ] == 'color' || $field[ 'type' ] == 'color_multi') {
								$field[ 'validate' ] = 'color';
							}
						}
						*/

						// validate fields

						if ( isset($field['validate']) ) {

							$validate = 'MFN_Validation_'.$field['validate'];

							if (! class_exists($validate)) {
								require_once($this->dir .'validation/'. $field['validate'] .'/validation_'. $field[ 'validate' ] .'.php');
							}

							if (class_exists($validate)) {

								$validation = new $validate($field, $plugin_options[ $field['id'] ], $options[ $field['id'] ]);

								$plugin_options[ $field['id'] ] = $validation->value;

								if (isset($validation->error)) {
									$this->errors[] = $validation->error;
								}

								if (isset($validation->warning)) {
									$this->warnings[] = $validation->warning;
								}

								continue;
							}
						}

						if (isset($field['validate_callback']) && function_exists($field['validate_callback'])) {
							$callbackvalues = call_user_func($field['validate_callback'], $field, $plugin_options[$field['id']], $options[$field['id']]);

							$plugin_options[$field['id']] = $callbackvalues['value'];

							if (isset($callbackvalues['error'])) {
								$this->errors[] = $callbackvalues['error'];
							}

							if (isset($callbackvalues['warning'])) {
								$this->warnings[] = $callbackvalues['warning'];
							}
						}

					}
				}
			}

			return $plugin_options;
		}

		/**
		 * Register settings
		 * Add setting section
		 */

		public function _register_setting()
		{
			require_once( $this->dir .'fields/class-mfn-options-field.php' );

			register_setting( $this->args['opt_name'] .'_group', $this->args['opt_name'], array( $this, '_validate_options' ) );

			foreach ( $this->sections as $k => $section ) {

				add_settings_section( $k .'_section', $section['title'], false, $k .'_page' );

				if ( isset( $section['fields'] ) ) {
					foreach ( $section['fields'] as $field_key => $field ) {

						if ( isset( $field['title'] ) ) {
							// Muffin -> Custom label
							$field['title'] = apply_filters('betheme_options_filed_title', $field['title']);
							$th = isset( $field['sub_desc'] ) ? $field['title'] .'<span class="description">'. $field['sub_desc'] .'</span>' : $field['title'];
						} else {
							$th = '';
						}

						// Muffin -> Custom label
						if ( isset($field['options']) ) {
							$field['options'] = apply_filters('betheme_options_filed_options', $field['options']);
						}

						// both below for removing links and changing anchors
						if ( isset($field['sub_desc']) ) {
							$field['sub_desc'] = apply_filters('betheme_options_filed_desc', $field['sub_desc']);
						}

						if ( isset($field['desc']) ) {
							$field['desc'] = apply_filters('betheme_options_filed_desc', $field['desc']);
						}

						add_settings_field( $field_key .'_field', $th, array( $this, '_field_input' ), $k .'_page', $k .'_section', $field );
					}
				}

			}
		}

		/**
		 * Add setting field
		 */

		function _field_input( $field ){

			if( empty( $field['type'] ) ){
				return false;
			}

			$field_class = 'MFN_Options_'. $field['type'];

			if ( ! class_exists( $field_class ) ) {
				require_once( $this->dir .'fields/'. $field['type'] .'/field_'. $field['type'] .'.php' );
			}

			if( class_exists( $field_class ) ){

				if( isset( $this->options[$field['id']] ) ){
					$value = $this->options[$field['id']];
				} else {
					$value = isset($field['std']) ? $field['std'] : '';
				}

				$field_object = new $field_class( $field, $value, $this->args['opt_name'] );
				$field_object->render();

				// enqueue field JS and optional CSS

				if( method_exists( $field_class, 'enqueue' ) ){
					$field_object->enqueue();
				}

			}

		}

		/**
		 * Open options card HTML
		 */

		function card_open( $title, $args = [] ){

			$class = false;
			$param = false;

			$id = str_replace( ' ', '-', strtolower( $title ) );
			$id = str_replace( '&-', '', strtolower( $id ) );

			if( ! empty($args['prefix']) ){
				$id .= '-'. $args['prefix'];
			}

			$title = str_replace( '_', '', $title ); // duplicated names

			// class

			if( ! empty( $args['class'] ) ){
				$class = $args['class'];
			}

			// parameters

			if( ! empty( $args['attr'] ) ){
				$param = 'data-attr="'. $args['attr'] .'"';
			}

			// output -----

			echo '<div '. ( isset($args['id'] ) ? 'id="'. $args['id'] .'"' : null ) .' '. ( isset($args['condition']) ? 'class="mfn-card mfn-shadow-1 '. $class .' activeif activeif-'. $args['condition']['id'] .'" data-id="'. $args['condition']['id'] .'" data-opt="'. $args['condition']['opt'] .'" data-val="'. $args['condition']['val'] .'"' : 'class="mfn-card mfn-shadow-1 '. $class .'"' ) .' data-card="'. $id .'" '. $param .'>';

        echo '<div class="card-header">';
          echo '<div class="card-title-group">';
            echo '<span class="card-icon mfn-icon-card"></span>';
            echo '<div class="card-desc">';
              echo '<h4 class="card-title">'. $title .'</h4>';
              if( ! empty( $args['sub_desc'] ) ){
								echo '<p class="card-subtitle">'. $args['sub_desc'] .'</p>';
							}
            echo '</div>';
          echo '</div>';
        echo '</div>';

        echo '<div class="card-content">';
        	echo '<div class="mfn-form mfn-form-horizontal">';

		}

		/**
		 * Close options card HTML
		 */

		function card_close(){

					echo '</div>';
				echo '</div>';
			echo '</div>';

		}

		/**
		 * Form row HTML
		 */

		function form_row( $field, $class = false ){

			$conditions = '';
			$row_class = '';

			if( isset( $field['args']['responsive'] ) ){
				$row_class .= 'mfn_field_'. $field['args']['responsive'];
			}

			if( isset( $field['args']['condition'] ) ){
				$row_class .= ' activeif activeif-'. $field['args']['condition']['id'];
				$conditions = 'data-id="'. $field['args']['condition']['id'] .'" data-opt="'. $field['args']['condition']['opt'] .'" data-val="'. $field['args']['condition']['val'] .'"';
			}

			echo '<div class="mfn-form-row mfn-row '. esc_attr( $row_class ) .'" id="'. $field['args']['id'] .'" '. $conditions .'>';

				echo '<div class="row-column row-column-2">';
					echo '<label class="form-label">'. $field['args']['title'] .'</label>';
					if( ! empty($field['args']['responsive']) ){
						Mfn_Options_field::get_responsive_swither($field['args']['responsive']);
					}
				echo '</div>';

				echo '<div class="row-column row-column-10">';
					echo '<div class="form-content '. esc_attr( $class ) .'">';

						call_user_func( $field['callback'], $field['args'] );

					echo '</div>';
				echo '</div>';

			echo '</div>';

		}

		/**
		 * Custom do_settings_sections HTML
		 */

		function do_settings_sections( $page ) {

      global $wp_settings_sections, $wp_settings_fields;

      if ( ! isset( $wp_settings_sections[ $page ] ) ) {
        return;
      }

      foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

        if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
          continue;
        }

				$section_tab_id = str_replace( '_section', '', $section['id'] );

				echo '<div class="mfn-card-group" data-tab="'. $section_tab_id .'">';

					$this->do_settings_fields( $page, $section['id'] );

					$this->card_close();

				echo '</div>';

      }

  	}

		/**
		 * Custom do_settings_fields HTML
		 */

		function do_settings_fields( $page, $section ) {
	    global $wp_settings_fields;

	    if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
        return;
	    }

	    foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {
        $class = '';

        if ( ! empty( $field['args']['class'] ) ) {
          $class = $field['args']['class'];
        }

				if( empty( $field['args']['type'] ) ){

					// card wrapper

					if( isset( $field['args']['join'] ) ){
						$this->card_close();
					}

					if( ! isset( $field['args']['sub_desc'] ) ){
						$field['args']['sub_desc'] = false;
					}

					/* Custom Custom Fonts -> Kinda like dynamic load */

					if ( ! empty($field['args']['class']) && 'mfn_new_font' == $field['args']['class'] )  {
						$this->custom_font_loader($field);
					}

					if ( ! empty($field['args']['class']) && 'custom-icon-card' == $field['args']['class'] )  {
						$this->custom_social_loader($field);
					}

					$this->card_open( $field['args']['title'], $field['args'] );

				} elseif( 'info' == $field['args']['type'] ) {

					// info field

					if( isset( $field['args']['join'] ) ){
						$this->card_close();
					}

					call_user_func( $field['callback'], $field['args'] );

				} else {

					// fields

	        $this->form_row( $field, $class );

				}

	    }
		}

		/**
		 * HTML OUTPUT
		 */

		function _options_page_html(){

			$form_class = '';

			// Plugin: Muffin Header Builder

			if( class_exists( 'Mfn_HB_Admin' ) && get_option( 'mfn_header_builder' ) ){
				$form_class = 'mhb-active';
			}

			echo '<div id="mfn-options" class="mfn-ui mfn-options loading" data-page="options">';

				echo '<input type="hidden" name="mfn-builder-nonce" value="'. wp_create_nonce( 'mfn-builder-nonce' ) .'">';

				// dashboard header
				$is_theme_options = true;
				include_once get_theme_file_path('/functions/admin/templates/parts/header.php');

				do_action('mfn-opts-page-before-form');

				echo '<form class="'. esc_attr( $form_class ) .'" method="post" action="options.php" enctype="multipart/form-data" >';

					settings_fields( $this->args['opt_name'] .'_group' );

					$this->options['last_tab'] = isset( $this->options['last_tab'] ) ? $this->options['last_tab'] : false;
					echo '<input type="hidden" id="last_tab" name="'. $this->args['opt_name'] .'[last_tab]" value="'. $this->options['last_tab'] .'" />';

					// menu

				  echo '<div class="mfn-overlay"></div>';

				  echo '<div class="mfn-menu">';

			      echo '<nav>';
							echo '<ul>';

								foreach( $this->menu as $menu_key => $menu_item ){

									echo '<li class="mfn-menu-'. $menu_key .'">';

										echo '<a href="#"><span class="mfn-icon"></span>'. $menu_item['title']. '</a>';

										if( is_array( $menu_item['sections'] ) ){
											echo '<ul class="mfn-submenu">';
												foreach( $menu_item['sections'] as $sub_item ){
						              echo '<li data-id="'. $sub_item .'"><a href="#'. $sub_item .'"><span>'. $this->sections[$sub_item]['title'] .'</span></a></li>';
												}
					            echo '</ul>';
										}

									echo '</li>';

								}

								// import

								echo '<li class="mfn-menu-backup">';
									echo '<a href="#"><span class="mfn-icon"></span>'. __('Backup & Reset', 'mfn-opts'). '</a>';
									echo '<ul class="mfn-submenu">';
										echo '<li data-id="backup-reset"><a href="#backup-reset"><span>'. __('General', 'mfn-opts'). '</span></a></li>';
									echo '</ul>';
								echo '</li>';

							echo '</ul>';
			      echo '</nav>';

				  echo '</div>';

					// content

					echo '<div class="mfn-wrapper device-wrapper" data-device="desktop">';

				    echo '<div class="mfn-top">';

					    echo '<span class="mfn-icon mfn-icon-card"></span>';

					    echo '<div class="mfn-topbar">';
					      echo '<div class="subheader-options-group topbar-title">';
					        echo '<h3><span class="page-title"></span> <span class="sep">&raquo;</span> <span class="subpage-title"></span></h3>';
					      echo '</div>';
					    echo '</div>';

							echo '<div class="mfn-subheader-placeholder"></div>';

					    echo '<div class="mfn-subheader">';
					      echo '<div class="subheader-options-group subheader-tabber">';
					        echo '<ul class="subheader-tabs">';
					        echo '</ul>';
					      echo '</div>';

					      echo '<div class="subheader-options-group subheader-buttons">';
					        echo '<a class="mfn-btn mfn-btn-blank btn-only-icon" target="_blank" href="https://support.muffingroup.com/" data-tooltip="'. __('Help Center', 'mfn-opts'). '"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-support"></span></span></a>';
									echo '<a class="mfn-btn mfn-btn-blank btn-only-icon" target="_blank" href="https://support.muffingroup.com/changelog/" data-tooltip="'. __('Changelog', 'mfn-opts'). '"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-changelog"></span></span></a>';
					        // echo '<a class="mfn-btn mfn-btn-blank btn-only-icon" href="#" data-tooltip="Settings"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-settings"></span></span></a>';

									if( mfn_is_registered() ){
										echo '<input type="submit" value="'. __('Save changes', 'mfn-opts') .'" class="mfn-btn mfn-btn-green btn-save-changes"/>';
									} else {
										echo '<a href="admin.php?page=betheme" class="mfn-btn btn-save-changes">Register now</a>';
									}

								echo '</div>';
					    echo '</div>';

					   echo '</div>';

				    echo '<div class="mfn-content">';

							if( $form_class ){
								echo '<div class="mfn-alert">';
									echo '<div class="alert-icon mfn-icon-information"></div>';
									echo '<div class="alert-content">';
									echo '<p>Betheme <a target="_blank" href="admin.php?page='. apply_filters('betheme_slug', 'be') .'-header">Header Builder</a> plugin is <b>active</b>. Header related options are hidden.</p>';									echo '</div>';
								echo '</div>';
							}

							foreach( $this->sections as $section_key => $section ){
								$this->do_settings_sections( $section_key .'_page' );
							}

							echo '<div class="mfn-card-group" data-tab="backup-reset">';

								$this->card_open( __('Export', 'mfn-opts') );

								echo '<div class="mfn-form-row mfn-row">';

									echo '<div class="row-column row-column-12">';
										echo '<div class="form-content form-content-full-width backup-export">';

											echo '<div class="desc-group">';

												echo '<p>'. __('Here, you can copy/download your theme’s option settings. Keep this safe, as you can use it as a backup. You can also use it to restore your settings on this site (or any other). You also have the handy option to copy the link to yours sites settings which you can then use to duplicate on another site.', 'mfn-opts') .'</p>';

												echo '<a class="mfn-btn backup-export-show-textarea" href="#"><span class="btn-wrapper">'. __('Copy', 'mfn-opts') .'</span></a>&nbsp;';
												echo '<a class="mfn-btn backup-export-show-input" href="#"><span class="btn-wrapper">'. __('Copy link', 'mfn-opts') .'</span></a>&nbsp;';
												echo '<a class="mfn-btn mfn-btn-blue" href="'. esc_url( add_query_arg( array( 'feed' => 'mfn-opts-'. $this->args['opt_name'], 'action' => 'download_options', 'secret' => md5( AUTH_KEY.SECURE_AUTH_KEY ) ), site_url() ) ) .'"><span class="btn-wrapper">'. __('Download', 'mfn-opts') .'</span></a>';

												$options = $this->options;
												$options['mfn-opts-backup'] = '1';
												$options = '###'. serialize( $options ) .'###';

												echo '<textarea class="mfn-form-control mfn-form-textarea backup-export-textarea" rows="8">'. $options .'</textarea>';

												echo '<input class="mfn-form-control mfn-form-input backup-export-input" type="text"  value="'. esc_url( add_query_arg( array( 'feed' => 'mfn-opts-'.$this->args['opt_name'], 'secret' => md5( AUTH_KEY.SECURE_AUTH_KEY ) ), site_url() ) ) .'" />';

											echo '</div>';

										echo '</div>';
									echo '</div>';

								echo '</div>';

								$this->card_close();

								$this->card_open( __('Import', 'mfn-opts') );

								echo '<div class="mfn-form-row mfn-row">';

									echo '<div class="row-column row-column-12">';
										echo '<div class="form-content form-content-full-width backup-import">';

											echo '<div class="desc-group">';

												echo '<a class="mfn-btn backup-import-show-textarea" href="#"><span class="btn-wrapper">'. __('Import from file', 'mfn-opts') .'</span></a>&nbsp;';
												echo '<a class="mfn-btn backup-import-show-input" href="#"><span class="btn-wrapper">'. __('Import from link', 'mfn-opts') .'</span></a>';

												echo '<div class="backup-import-group backup-import-textarea">';

													echo '<p>'. __('Paste content of your backup file below and hit <b>Import</b> to restore your site’s options from a backup.', 'mfn-opts') .'</p>';
													echo '<textarea class="mfn-form-control mfn-form-textarea" name="'. $this->args['opt_name'] .'[import_code]" rows="8"></textarea>';

													echo '<input type="submit" class="mfn-btn mfn-btn-blue" name="'. $this->args['opt_name'] .'[import]" value="'. __( 'Import', 'mfn-opts' ) .'">';
													echo '<span class="warning">'. __('WARNING! This will overwrite all existing options, please proceed with caution!', 'mfn-opts') .'</span>';

												echo '</div>';

												echo '<div class="backup-import-group backup-import-input">';

													echo '<p>'. __('Paste the link to another site’s options set and hit <b>Import</b> to load the options from that site.', 'mfn-opts') .'</p>';
													echo '<input type="text" class="mfn-form-control mfn-form-input" name="'. $this->args['opt_name'] .'[import_link]" value="" />';

													echo '<input type="submit" class="mfn-btn mfn-btn-blue" name="'. $this->args['opt_name'] .'[import]" value="'. __( 'Import', 'mfn-opts' ) .'">';
													echo '<span class="warning">'. __('WARNING! This will overwrite all existing options, please proceed with caution!', 'mfn-opts') .'</span>';

												echo '</div>';

											echo '</div>';

										echo '</div>';
									echo '</div>';

								echo '</div>';

								$this->card_close();

								$this->card_open( __('Reset', 'mfn-opts') );

								echo '<div class="mfn-form-row mfn-row">';

									echo '<div class="row-column row-column-12">';
										echo '<div class="form-content form-content-full-width backup-reset">';

											echo '<div class="desc-group">';

												echo '<div class="backup-reset-step step-1">';
													echo '<a href="#" class="mfn-btn mfn-btn-primary backup-reset-pre-confirm">'. __( 'Reset to default', 'mfn-opts' ) .'</a>';
													echo '<span class="warning">'. __('WARNING! This will overwrite all existing options, please proceed with caution!', 'mfn-opts') .'</span>';
												echo '</div>';

												echo '<div class="backup-reset-step step-2">';
													echo 'Insert security code: <b>r3s3t</b>';
													echo '<input class="mfn-form-control mfn-form-input backup-reset-security-code" type="text" value="" autocomplete="off" />';
													echo '<input type="submit" class="mfn-btn mfn-btn-blue backup-reset-confirm" name="'. $this->args['opt_name'] .'[defaults]" value="'. __( 'Confirm reset ALL options', 'mfn-opts' ). '" />';
												echo '</div>';

											echo '</div>';

										echo '</div>';
									echo '</div>';

								echo '</div>';

								$this->card_close();

							echo '</div>';

						echo '</div>';

					echo '</div>';

				echo '</form>';

				// modal | icon select

				Mfn_Icons::the_modal();

				// modal | icon select

				if( ! mfn_is_registered() ){
					Mfn_Helper::the_modal_register();
				}

			echo '</div>';
		}

		/**
		 * Custom social loader
		 */

		public function custom_social_loader($field){
			$loop = 2;
			$custom_amount = intval(mfn_opts_get('custom-icon-count')) + $loop;
			$callback = $field['callback'];
			$class = '';

			for( $loop; $loop < $custom_amount; $loop++ ){

				$this->card_open( __('Custom '.$loop, 'mfn-opts'), array(
					'args' => 'Custom '.$loop,
					'join' => true,
				) );

				$this->form_row( array(
					'args' => array(
						'id' => 'social-custom-icon-'.$loop,
						'type' => 'icon',
						'title' => __('Icon', 'mfn-opts'),
					),
					'callback' => $callback,
				), $class );

				$this->form_row( array(
					'args' => array(
						'id' => 'social-custom-link-'.$loop,
						'type' => 'text',
						'title' => __('Link', 'mfn-opts'),
					),
					'callback' => $callback,
				), $class );

				$this->form_row( array(
					'args' => array(
						'id' => 'social-custom-title-'.$loop,
						'type' => 'text',
						'title' => __( 'Title', 'mfn-opts' ),
					),
					'callback' => $callback,
				), $class );

				$this->card_close();
			}
		}

		/**
		 * Custom font loader
		 */

		public function custom_font_loader($field){
			$loop = 3;
			$custom_amount = intval(mfn_opts_get('font-custom-fields')) + $loop;
			$callback = $field['callback'];
			$class = '';

			for( $loop; $loop < $custom_amount; $loop++ ){

				$this->card_open( __('Font '.$loop, 'mfn-opts'), array(
					'args' => 'Font '.$loop,
					'join' => true,
				) );

				$this->form_row( array(
					'args' => array(
						'id' => 'font-custom'.$loop,
						'type' => 'text',
						'title' => __('Name', 'mfn-opts'),
						'desc' => __( 'Name for Custom Font uploaded below.<br />Font will show on fonts list after <b>click the Save Changes</b> button.' , 'mfn-opts' ),
					),
					'callback' => $callback,
				), $class );

				$this->form_row( array(
					'args' => array(
						'id' => 'font-custom'.$loop.'-woff',
						'type' => 'upload',
						'title' => __('.woff', 'mfn-opts'),
						'desc' => __( 'WordPress 5.0 blocks .woff upload. Please use <a target="_blank" href="plugin-install.php?s=Disable+Real+MIME+Check&tab=search&type=term">Disable Real MIME Check</a> plugin.', 'mfn-opts' ),
						'data' => 'font',
					),
					'callback' => $callback,
				), $class );

				$this->form_row( array(
					'args' => array(
						'id' => 'font-custom'.$loop.'-ttf',
						'type' => 'upload',
						'title' => __( '.ttf', 'mfn-opts' ),
						'desc' => __( 'WordPress 5.0 blocks .ttf upload. Please use <a target="_blank" href="plugin-install.php?s=Disable+Real+MIME+Check&tab=search&type=term">Disable Real MIME Check</a> plugin.', 'mfn-opts' ),
						'data' => 'font',
					),
					'callback' => $callback,
				), $class );

				$this->card_close();
			}
		}

	}

}
