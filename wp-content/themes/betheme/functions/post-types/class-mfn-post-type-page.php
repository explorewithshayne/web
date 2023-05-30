<?php
/**
 * Custom post type: Page
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mfn_Post_Type_Page' ) ) {
	class Mfn_Post_Type_Page extends Mfn_Post_Type
	{

		/**
		 * Mfn_Post_Type_Page constructor
		 */

		public function __construct()
		{
			parent::__construct();

			// admin only methods

			if( is_admin() ){
				$this->fields = $this->set_fields();
				$this->builder = new Mfn_Builder_Admin();
			}

		}

		/**
		 * Set post type fields
		 */

		public function set_fields(){

			return array(

  			'id' => 'mfn-meta-page',
  			'title' => esc_html__( 'Page Options', 'mfn-opts' ),
  			'page' => 'page',
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
  					'title' => __('Popup', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn_popup_included',
  					'type' => 'select',
  					'title' => __('Popup', 'mfn-opts'),
  					'desc' => __('Choose popup to display', 'mfn-opts'),
  					'options' => mfna_templates('popup'),
  					'js_options' => 'popups',
  				),

  				// layout

  				array(
  					'title' => __('Layout', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-post-hide-content',
  					'type' => 'switch',
  					'title' => __('The content', 'mfn-opts'),
  					'desc' => __('The content from the WordPress editor', 'mfn-opts'),
  					'options'	=> array(
							'1' => __('Hide', 'mfn-opts'),
							'0' => __('Show', 'mfn-opts'),
						),
  					'std' => '0'
  				),

					array(
						'id' => 'mfn-post-layout',
						'type' => 'radio_img',
						'title' => __('Layout', 'mfn-opts'),
						'desc' => __('Full width sections works only without sidebars', 'mfn-opts'),
						'options' => array(
							'no-sidebar' => __('Full width', 'mfn-opts'),
							'left-sidebar' => __('Left sidebar', 'mfn-opts'),
							'right-sidebar' => __('Right sidebar', 'mfn-opts'),
							'both-sidebars' => __('Both sidebars', 'mfn-opts'),
							'offcanvas-sidebar' => __('Off-canvas sidebar', 'mfn-opts'),
						),
						'std' => 'no-sidebar',
						'alias' => 'sidebar',
						'class' => 'form-content-full-width small',
					),

  				array(
  					'id' => 'mfn-post-sidebar',
  					'type' => 'select',
  					'title' => __('Sidebar', 'mfn-opts'),
  					'desc' => __('Shows only if layout with sidebar is selected', 'mfn-opts'),
  					'options' => mfn_opts_get('sidebars'),
  					'js_options' => 'sidebars',
  				),

  				array(
  					'id' => 'mfn-post-sidebar2',
  					'type' => 'select',
  					'title' => __('Sidebar 2nd', 'mfn-opts'),
  					'desc' => __('Shows only if layout with both sidebars is selected', 'mfn-opts'),
  					'options' => mfn_opts_get('sidebars'),
  					'js_options' => 'sidebars',
  				),

				// media

  				array(
  					'title' => __('Media', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-post-slider',
  					'type' => 'select',
  					'title' => __('Slider Revolution', 'mfn-opts'),
  					'options' => Mfn_Builder_Helper::get_sliders('rev'),
  					'js_options' => 'rev_slider',
  				),

  				array(
  					'id' => 'mfn-post-slider-layer',
  					'type' => 'select',
  					'title' => __('Layer Slider', 'mfn-opts'),
  					'options' => Mfn_Builder_Helper::get_sliders('layer'),
  					'js_options' => 'layer_slider',
  				),

  				array(
  					'id' => 'mfn-post-slider-shortcode',
  					'type' => 'text',
  					'title' => __('Slider shortcode', 'mfn-opts'),
  					'desc' => __('Paste slider shortcode if you use other slider plugin', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-post-subheader-image',
  					'type' => 'upload',
  					'title' => __('Subheader image', 'mfn-opts'),
  				),

					// options

  				array(
  					'title' => __('Options', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-post-one-page',
  					'type' => 'switch',
  					'title' => __('One Page', 'mfn-opts'),
  					'options'	=> array(
							'0' => __('Disable', 'mfn-opts'),
							'1' => __('Enable', 'mfn-opts'),
						),
  					'std' => '0'
  				),

  				array(
  					'id' => 'mfn-post-full-width',
  					'type' => 'switch',
  					'title' => __('Full width', 'mfn-opts'),
  					'desc' => __('Set page to full width ignoring <a target="_blank" href="admin.php?page=be-options#general">Site width</a> option. Works for Layout Full width only.', 'mfn-opts'),
  					'options'	=> array(
							'0' => __('Disable', 'mfn-opts'),
							'site' => __('Enable', 'mfn-opts'),
							'content' => __('Content only', 'mfn-opts'),
						),
  					'std' => '0'
  				),

  				array(
  					'id' => 'mfn-post-hide-title',
  					'type' => 'switch',
  					'title' => __('Subheader', 'mfn-opts'),
  					'options'	=> array(
							'1' => __('Hide', 'mfn-opts'),
							'0' => __('Show', 'mfn-opts'),
						),
  					'std' => '0'
  				),

  				array(
  					'id' => 'mfn-post-remove-padding',
  					'type' => 'switch',
  					'title' => __('Content top padding', 'mfn-opts'),
  					'options' => array(
							'1' => __('Hide', 'mfn-opts'),
							'0' => __('Show', 'mfn-opts'),
						),
  					'std' => '0'
  				),

  				array(
  					'id' => 'mfn-post-custom-layout',
  					'type' => 'select',
  					'title' => __('Custom layout', 'mfn-opts'),
  					'desc' => __('Custom layout overwrites Theme Options', 'mfn-opts'),
  					'options' => $this->get_layouts(),
  					'js_options' => 'layouts',
  				),

  				array(
  					'id' => 'mfn-post-menu',
  					'type' => 'select',
  					'title' => __('Custom menu', 'mfn-opts'),
  					'desc' => __('Does not work with Split Menu', 'mfn-opts'),
  					'options' => mfna_menu(),
  					'js_options' => 'menus',
  				),

					// seo

  				array(
  					'title' => __('SEO', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-meta-seo-title',
  					'type' => 'text',
  					'title' => __('Title', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-meta-seo-description',
  					'type' => 'text',
  					'title' => __('Description', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-meta-seo-keywords',
  					'type' => 'text',
  					'title' => __('Keywords', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-meta-seo-og-image',
  					'type' => 'upload',
  					'title' => __('Open Graph image', 'mfn-opts'),
  					'desc' => __('Facebook share image', 'mfn-opts'),
  				),

					// custom css

  				array(
  					'title' => __('Custom CSS', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn-post-css',
  					'type' => 'textarea',
  					'title' => __('Custom CSS', 'mfn-opts'),
  					'desc' => __('Custom CSS code for this page', 'mfn-opts'),
  					'class' => 'form-content-full-width',
						'cm' => 'css',
  				),

  			),
  		);

		}

	}
}

new Mfn_Post_Type_Page();
