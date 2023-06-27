<?php
/**
 * Muffin Builder 3.1
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 *
 * @changelog
 *
 * 3.1
 * added: unique IDs for all builder elements
 */

if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if (! class_exists('Mfn_Builder'))
{
  class Mfn_Builder {

  	/**
  	 * Constructor
  	 */

  	public function __construct() {

			require_once(get_theme_file_path('/functions/builder/class-mfn-builder-helper.php'));

      if(function_exists('is_woocommerce')):
        require_once(get_theme_file_path('/functions/builder/class-mfn-builder-woo-helper.php'));
      endif;

			add_filter( 'mfn-builder-get', array( 'Mfn_Builder_Helper', 'filter_builder_get' ) );

      if ( is_admin() || apply_filters('is_bebuilder_demo', false)  ) {

      	require_once(get_theme_file_path('/functions/builder/class-mfn-builder-fields.php'));
      	require_once(get_theme_file_path('/functions/builder/class-mfn-builder-admin.php'));
      	require_once(get_theme_file_path('/functions/builder/class-mfn-builder-ajax.php'));
      	require_once(get_theme_file_path('/functions/builder/pre-built/class-mfn-pre-built-sections.php'));
      	require_once(get_theme_file_path('/functions/builder/pre-built/class-mfn-pre-built-sections-api.php'));
      	require_once(get_theme_file_path('/functions/builder/pre-built/class-mfn-single-page-import-api.php'));

      } else {

				if( mfn_is_blocks() ){
					require_once(get_theme_file_path('/functions/builder/class-mfn-builder-fields.php'));
				}

				require_once(get_theme_file_path('/functions/builder/class-mfn-builder-styles.php'));
				require_once(get_theme_file_path('/functions/builder/class-mfn-builder-front.php'));
				require_once(get_theme_file_path('/functions/builder/class-mfn-builder-items.php'));

			}

  	}

  }
}

$mfn_builder = new Mfn_Builder();
