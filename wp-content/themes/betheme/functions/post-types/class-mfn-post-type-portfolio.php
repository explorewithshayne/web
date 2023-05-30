<?php
/**
 * Custom post type: Portfolio
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mfn_Post_Type_Portfolio' ) ) {
	class Mfn_Post_Type_Portfolio extends Mfn_Post_Type
	{

		/**
		 * Mfn_Post_Type_Portfolio constructor
		 */

		public function __construct()
		{
			parent::__construct();

			// fires after WordPress has finished loading but before any headers are sent
			add_action('init', array($this, 'register'));

			// applied to the list of columns to print on the manage posts screen for a custom post type
			add_filter('manage_edit-portfolio_columns', array($this, 'add_columns'));

			// allows to add or remove (unset) custom columns to the list post/page/custom post type pages
			add_action('manage_posts_custom_column', array($this, 'custom_column'));

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

				'id' => 'mfn-meta-portfolio',
				'title' => esc_html__('Portfolio Options', 'mfn-opts'),
				'page' => 'portfolio',
				'fields' => array(

					array(
  					'title' => __('Header & Footer', 'mfn-opts'),
  				),

  				array(
  					'id' => 'mfn_header_template',
  					'type' => 'select',
  					'title' => __('Custom Header', 'mfn-opts'),
  					'options' => mfna_templates('header'),
  					'js_options' => 'headers',
  				),

  				array(
  					'id' => 'mfn_footer_template',
  					'type' => 'select',
  					'title' => __('Custom Footer', 'mfn-opts'),
  					'options' => mfna_templates('footer'),
  					'js_options' => 'footers',
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

					array(
						'id' => 'mfn-post-template',
						'type' => 'select',
						'title' => __('Template', 'mfn-opts'),
						'options' => array(
							'' => __('-- Default --', 'mfn-opts'),
							'builder' => __('Builder', 'mfn-opts'),
							'intro' => __('Intro Header', 'mfn-opts'),
						),
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
      			'id' => 'mfn-post-header-bg',
      			'type' => 'upload',
      			'title' => __('Header image', 'mfn-opts'),
      		),

      		array(
      			'id' => 'mfn-post-video',
      			'type' => 'text',
      			'title' => __('Video ID', 'mfn-opts'),
      			'desc' => __('YouTube or Vimeo', 'mfn-opts'),
      		),

      		array(
      			'id' => 'mfn-post-video-mp4',
      			'type' => 'upload',
      			'title' => __('Video MP4', 'mfn-opts'),
      			'data' => 'video',
      		),

					// description

  				array(
  					'title' => __('Description', 'mfn-opts'),
  				),

					array(
						'id' => 'mfn-post-client',
						'type' => 'text',
						'title' => __('Client', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-link',
						'type' => 'text',
						'title' => __('Website', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-task',
						'type' => 'text',
						'title' => __('Task', 'mfn-opts'),
					),

					// options

					array(
						'title' => __('Options', 'mfn-opts'),
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
						'id' => 'mfn-post-slider-header',
						'type' => 'switch',
						'title' => __('Slider location', 'mfn-opts'),
						'options' => array(
							'0' => __('Content', 'mfn-opts'),
							'1' => __('Header', 'mfn-opts'),
						),
						'std' => '0'
					),

					array(
						'id' => 'mfn-post-custom-layout',
						'type' => 'select',
						'title' => __('Custom layout', 'mfn-opts'),
						'desc' => __('Custom Layout overwrites Theme Options', 'mfn-opts'),
						'options' 	=> $this->get_layouts(),
						'js_options' => 'layouts',
					),

					// advanced

					array(
						'title' => __('Advanced', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-bg',
						'type' => 'upload',
						'title' => __('Background image', 'mfn-opts'),
						'desc' => __('for Portfolio Layout: List', 'mfn-opts'),
					),

					array(
						'id' => 'mfn-post-bg-hover',
						'type' => 'color',
						'title' => __('Background color', 'mfn-opts'),
						'desc' => __('for Portfolio Layout: List & Masonry Hover Details', 'mfn-opts'),
					),



					array(
						'id' => 'mfn-post-size',
						'type' => 'select',
						'title' => __('Item size', 'mfn-opts'),
						'desc' => __('for Portfolio Layout: Masonry Flat', 'mfn-opts'),
						'options' => array(
							'' => __('Default', 'mfn-opts'),
							'wide' => __('Wide', 'mfn-opts'),
							'tall' => __('Tall', 'mfn-opts'),
							'wide tall'	=> __('Big', 'mfn-opts'),
						),
					),

					// intro

					array(
						'title' => __('Intro header', 'mfn-opts'),
					),

					array(
      			'id' => 'mfn-post-intro',
      			'type' => 'checkbox',
      			'title' => __('Options', 'mfn-opts'),
      			'desc' => __('for Template: Intro', 'mfn-opts'),
      			'options' => array(
      				'light' => __('Light image, dark text', 'mfn-opts'),
      				'full-screen' => __('Full Screen', 'mfn-opts'),
      				'parallax' => __('Parallax', 'mfn-opts'),
      				'cover' => __('Background size: Cover<span>enabled by default in parallax</span>', 'mfn-opts'),
      			),
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
						'desc' => __('Custom CSS code for this portfolio project', 'mfn-opts'),
						'class' => 'form-content-full-width',
						'cm' => 'css',
					),

				),
			);

		}

		/**
		 * Register new post type and related taxonomy
		 */

		public function register()
		{
			$slug = esc_attr(mfn_opts_get('portfolio-slug', 'portfolio-item'));
			$tax = esc_attr(mfn_opts_get('portfolio-tax', 'portfolio-types'));

			$labels = array(
				'name' => esc_html__('Portfolio', 'mfn-opts'),
				'singular_name' => esc_html__('Portfolio item', 'mfn-opts'),
				'add_new' => esc_html__('Add New', 'mfn-opts'),
				'add_new_item' => esc_html__('Add New Portfolio item', 'mfn-opts'),
				'edit_item' => esc_html__('Edit Portfolio item', 'mfn-opts'),
				'new_item' => esc_html__('New Portfolio item', 'mfn-opts'),
				'view_item' => esc_html__('View Portfolio item', 'mfn-opts'),
				'search_items' => esc_html__('Search Portfolio items', 'mfn-opts'),
				'not_found' => esc_html__('No portfolio items found', 'mfn-opts'),
				'not_found_in_trash' => esc_html__('No portfolio items found in Trash', 'mfn-opts'),
				'parent_item_colon' => '',
			  );

			$args = array(
				'labels' => $labels,
				'menu_icon' => 'dashicons-portfolio',
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'show_in_rest' => true,
				'rewrite' => array(
					'slug' => $slug,
				),
				'supports' => array('author', 'comments', 'custom-fields', 'editor', 'excerpt', 'page-attributes', 'thumbnail', 'title'),
			);

			register_post_type('portfolio', $args);

			register_taxonomy('portfolio-types', 'portfolio', array(
				'label' => esc_html__('Portfolio categories', 'mfn-opts'),
				'hierarchical' => true,
				'query_var' => true,
				'show_in_rest' => true,
				'rewrite' => array(
					'slug' => $tax,
				),
			));
		}

		/**
		 * Add new columns to posts screen
		 */

		public function add_columns($columns)
		{
			$newcolumns = array(
				'cb' => '<input type="checkbox" />',
				'portfolio_thumbnail' => esc_html__('Thumbnail', 'mfn-opts'),
				'title' => esc_html__('Title', 'mfn-opts'),
				'portfolio_types' => esc_html__('Categories', 'mfn-opts'),
				'portfolio_order' => esc_html__('Order', 'mfn-opts'),
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
				case 'portfolio_thumbnail':
					if (has_post_thumbnail()) {
						the_post_thumbnail('50x50');
					}
					break;
				case 'portfolio_types':
					echo get_the_term_list($post->ID, 'portfolio-types', '', ', ', '');
					break;
				case 'portfolio_order':
					echo esc_attr($post->menu_order);
					break;
			}
		}

	}
}

new Mfn_Post_Type_Portfolio();
