<?php
/**
 * Custom post type: Layout
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (! class_exists('Mfn_Post_Type_Layout')) {
	class Mfn_Post_Type_Layout extends Mfn_Post_Type
	{

		/**
		 * Mfn_Post_Type_Layout constructor
		 */

		public function __construct()
		{
			parent::__construct();

			// fires after WordPress has finished loading but before any headers are sent
			add_action('init', array($this, 'register'));

			// applied to the list of columns to print on the manage posts screen for a custom post type
			add_filter('manage_edit-layout_columns', array($this, 'add_columns'));

			// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
			add_action('manage_posts_custom_column', array($this, 'custom_column'));

			// admin only methods

			if( is_admin() ){
				$this->fields = $this->set_fields();
			}

		}

		/**
		 * Set post type fields
		 */

		private function set_fields(){

			return array(

				'id' => 'mfn-meta-layout',
				'title' => esc_html__('Layout Options', 'mfn-opts'),
				'page' => 'layout',
				'fields' => array(

					// layout

					array(
						'title' => __('Layout', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-layout',
						'type' => 'radio_img',
						'title' => __('Layout', 'mfn-opts'),
						'options' => array(
							'full-width' => __('Full width', 'mfn-opts'),
							'boxed' => __('Boxed', 'mfn-opts'),
						),
						'alias' => 'layout',
						'std' => 'full-width',
						'class' => 'form-content-full-width',
					),

					// background

					array(
						'title' => __('Background', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-bg',
						'type' => 'upload',
						'title' => __('Image', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-bg-pos',
						'type' => 'select',
						'title' => __('Position', 'mfn-opts'),
						'desc' => __('Use only with image selected above', 'mfn-opts'),
						'options' => mfna_bg_position(),
						'std' => 'center top no-repeat',
					),

					// logo

					array(
						'title' => __('Logo', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-logo-img',
						'type' => 'upload',
						'title' => __('Logo', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-retina-logo-img',
						'type' => 'upload',
						'title' => __('Retina', 'mfn-opts'),
						'desc' => __('Retina Logo should be 2x larger than Custom Logo', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-sticky-logo-img',
						'type' => 'upload',
						'title' => __('Sticky Header', 'mfn-opts'),
						'desc' => __('Use if you want different logo for Sticky Header', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-sticky-retina-logo-img',
						'type' => 'upload',
						'title' => __('Sticky Header Retina', 'mfn-opts'),
						'desc' => __('Retina Logo should be 2x larger than Sticky Logo', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-responsive-logo-img',
						'type' => 'upload',
						'title' => __('Mobile', 'mfn-opts'),
						'desc' => __('Use if you want different logo for Mobile', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-responsive-retina-logo-img',
						'type' => 'upload',
						'title' => __('Mobile Retina', 'mfn-opts'),
						'desc' => __('Retina Logo should be 2x larger than Mobile Logo', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-responsive-sticky-logo-img',
						'type' => 'upload',
						'title' => __('Mobile Sticky Header', 'mfn-opts'),
						'desc' => __('Use if you want different logo for Mobile Sticky Header', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-responsive-sticky-retina-logo-img',
						'type' => 'upload',
						'title' => __('Mobile Sticky Header Retina', 'mfn-opts'),
						'desc' => __('Retina Logo should be 2x larger than Mobile Sticky Header Logo', 'mfn-opts'),
					),

					// header

					array(
						'title' => __('Header', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-header-style',
						'type' => 'radio_img',
						'title' => __( 'Style', 'mfn-opts' ),
						'options' => mfna_header_style(),
						'alias' => 'header',
						'class' => 'form-content-full-width',
						'std' => 'classic',
					),

					array(
						'id' => 'mfn-post-header-height',
						'type' => 'text',
						'title' => __('Height', 'mfn-opts'),
						'after' => 'px',
						'param' => 'number',
						'class' => 'narrow',
					),

					array(
						'id' => 'mfn-post-sticky-header',
						'type' => 'switch',
						'title' => __('Sticky', 'mfn-opts'),
						'options' => array(
							'0' => __('Disable', 'mfn-opts'),
							'1' => __('Enable', 'mfn-opts'),
						),
						'std' => '1'
					),

					array(
						'id' => 'mfn-post-sticky-header-style',
						'type' => 'select',
						'title' => __('Sticky | Style', 'mfn-opts'),
						'options'	=> array(
							'tb-color' => __('The same as Top Bar Left background', 'mfn-opts'),
							'white' => __('White', 'mfn-opts'),
							'dark' => __('Dark', 'mfn-opts'),
						),
					),

					// colors

					array(
						'title' => __('Colors', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-skin',
						'type' => 'select',
						'title' => __('Skin', 'mfn-opts'),
						'options' => mfna_skin(),
						'std' => 'custom',
					),

					array(
						'id' => 'mfn-post-background-subheader',
						'type' => 'color',
						'title' => __('Subheader background', 'mfn-opts'),
						'std' => '#F7F7F7',
					),

					array(
						'id' => 'mfn-post-color-subheader',
						'type' => 'color',
						'title' => __('Subheader text', 'mfn-opts'),
						'std' => '#888888',
					),

				),
			);

		}

		/**
		 * Register new post type and related taxonomy
		 */

		public function register()
		{
			$labels = array(
				'name' => esc_html__('Layouts', 'mfn-opts'),
				'singular_name' => esc_html__('Layout', 'mfn-opts'),
				'add_new' => esc_html__('Add New', 'mfn-opts'),
				'add_new_item' => esc_html__('Add New Layout', 'mfn-opts'),
				'edit_item' => esc_html__('Edit Layout', 'mfn-opts'),
				'new_item' => esc_html__('New Layout', 'mfn-opts'),
				'view_item' => esc_html__('View Layout', 'mfn-opts'),
				'search_items' => esc_html__('Search Layouts', 'mfn-opts'),
				'not_found' => esc_html__('No layouts found', 'mfn-opts'),
				'not_found_in_trash' => esc_html__('No layouts found in Trash', 'mfn-opts'),
			  );

			$args = array(
				'labels' => $labels,
				'menu_icon' => 'dashicons-edit',
				'public' => false,
				'show_ui' => true,
				'supports' => array( 'title', 'page-attributes' ),
			);

			register_post_type('layout', $args);
		}

		/**
		 * Add new columns to posts screen
		 */

		public function add_columns($columns)
		{
			$newcolumns = array(
				'cb' => '<input type="checkbox" />',
				'title' => esc_html__('Title', 'mfn-opts'),
				'layout_ID' => esc_html__('Layout ID', 'mfn-opts'),
  		);
			$columns = array_merge($newcolumns, $columns);

			return $columns;
		}

		/**
		 * Custom column on posts screen
		 */

		public function custom_column($column)
		{
			global $post;

			switch ($column) {
				case 'layout_ID':
					echo esc_attr($post->ID);
					break;
			}
		}

	}
}

new Mfn_Post_Type_Layout();
