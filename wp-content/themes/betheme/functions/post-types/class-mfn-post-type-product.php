<?php
/**
 * Custom post type: Template
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (! class_exists('Mfn_Post_Type_Product')) {
	class Mfn_Post_Type_Product extends Mfn_Post_Type
	{

		/**
		 * Mfn_Post_Type_Product constructor
		 */

		public function __construct()
		{
			parent::__construct();

			// fires after WordPress has finished loading but before any headers are sent
			//add_action('init', array($this, 'defaults'));

			// admin only methods

			if( is_admin() ){
				$this->fields = $this->set_fields();
				$this->builder = new Mfn_Builder_Admin();

			}

		}

		/*public function defaults() {
			remove_post_type_support( 'product', 'editor' );
		}*/

		/**
		 * Set post type fields
		 */

		public function set_fields(){

			$ref = parse_url(wp_get_referer());

			$type = 'default';

			return array(
				'id' => 'mfn-meta-product',
				'title' => esc_html__('Product Options', 'mfn-opts'),
				'page' => 'product',
				'fields' => array(

					array(
	  					'title' => __('Header & Footer', 'mfn-opts'),
	  				),

	  				array(
	  					'id' => 'mfn_header_template',
	  					'type' => 'select',
	  					'title' => __('Custom Header Template', 'mfn-opts'),
	  					'desc' => __('To overwrite template set with conditions in <a target="_blank" href="edit.php?post_type=template&tab=header">Templates</a> section, please select appropriate template from dropdown select. Afterwards, please reload the page to refresh the options.', 'mfn-opts'),
	  					'options' => mfna_templates('header'),
	  					'js_options' => 'headers',
	  				),

	  				array(
	  					'id' => 'mfn_footer_template',
	  					'type' => 'select',
	  					'title' => __('Custom Footer Template', 'mfn-opts'),
	  					'desc' => __('To overwrite template set with conditions in <a target="_blank" href="edit.php?post_type=template&tab=footer">Templates</a> section, please select appropriate template from dropdown select. Afterwards, please reload the page to refresh the options.', 'mfn-opts'),
	  					'options' => mfna_templates('footer'),
	  					'js_options' => 'footers',
	  				),

	  				array(
	  					'id' => 'mfn_single_product_template',
	  					'type' => 'select',
	  					'title' => __('Custom Single Product Template', 'mfn-opts'),
	  					'options' => mfna_templates('single-product'),
	  					'js_options' => 'singleproducts',
	  				),

				),
			);
		}


	}
}

new Mfn_Post_Type_Product();
