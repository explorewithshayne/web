<?php
/**
 * Custom post type: Icons
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (! class_exists('Mfn_Post_Type_Icons')) {
	class Mfn_Post_Type_Icons extends Mfn_Post_Type
	{

		/**
		 * Mfn_Post_Type_Icons constructor
		 */

		public $path_be = '';
		public $path_icons = '';

		public function __construct()
		{
			parent::__construct();

      $upload_dir = wp_upload_dir();
      $this->path_be = wp_normalize_path( $upload_dir['basedir'] .'/betheme' );
      $this->path_icons = wp_normalize_path( $this->path_be .'/icons' );

			// fires after WordPress has finished loading but before any headers are sent
			add_action( 'init', array($this, 'register' ));

      // create the directory in uploads, to keep the icons
      add_action( 'init', array($this, 'make_dir' ));

      // when delete icon post delete also icon files in upload dir
      add_action( 'trashed_post', array($this, 'single_post_remove' ));

      if ( is_admin() ) {
				$this->fields = $this->set_fields();
			}

      // post

      add_action( 'wp_footer', array($this, 'load_icons'), 1);
      add_action( 'admin_footer', array($this, 'load_icons'), 1);
		}

		/**
		 * Set post type fields
		 */

		private function set_fields(){

      $unique_id = Mfn_Builder_Helper::unique_id();

			return array(

				'id' => 'mfn-meta-icons',
				'title' => esc_html__('Icons Options', 'mfn-opts'),
				'page' => 'icons',
				'fields' => array(

					array(
						'id' => 'mfn-icon-name',
						'type' => 'text',
						'title' => __('Name', 'mfn-opts'),
            'desc' => __('Must be unique', 'mfn-opts'),
            'std' => "My icon ". $unique_id,
            'row_class' => 'hidden'
					),

          array(
						'id' => 'mfn-icon-prefix',
						'type' => 'text',
						'title' => __('Prefix', 'mfn-opts'),
            'desc' => __('Must be unique', 'mfn-opts'),
            'std' => "ci-". $unique_id,
            'row_class' => 'hidden'
					),

					array(
						'id' => 'mfn-icon-upload',
						'type' => 'upload_icon',
						'title' => __('Icon pack', 'mfn-opts'),
            'desc' => __('Upload an <a href="https://icomoon.io/app/" target="_blank">Icomoon</a> zip file', 'mfn-opts'),
            'data' => 'icon'
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
				'name' => esc_html__('Icons', 'mfn-opts'),
				'singular_name' => esc_html__('Icons', 'mfn-opts'),
				'add_new' => esc_html__('Add New', 'mfn-opts'),
				'add_new_item' => esc_html__('Add New Icons', 'mfn-opts'),
				'edit_item' => esc_html__('Edit Icons', 'mfn-opts'),
				'new_item' => esc_html__('New Icons', 'mfn-opts'),
				'view_item' => esc_html__('View Icons', 'mfn-opts'),
				'search_items' => esc_html__('Search Icons', 'mfn-opts'),
				'not_found' => esc_html__('No icons found', 'mfn-opts'),
			  );

			$args = array(
				'labels' => $labels,
				'public' => false,
				'show_ui' => true,
        'show_in_menu' => apply_filters('betheme_dynamic_slug', 'betheme'),
				'supports' => array('title'),
			);

			register_post_type('icons', $args);
		}

    /**
     * Directories creation
     */

    public function make_dir(){

      if( ! file_exists( $this->path_be ) ){
        wp_mkdir_p( $this->path_be );
      }

      if( ! file_exists( $this->path_icons ) ){
        wp_mkdir_p( $this->path_icons );
      }

    }

		/**
     * While trashing the post, remove the directory of icon
     */

	  public function single_post_remove( $post_id ) {
      if ( 'icons' === get_post_type( $post_id ) ){

        $icon_name = get_post_field( 'mfn-icon-name-parsed', $post_id );
        $src = $this->path_icons.'/'.$icon_name;

        $wp_filesystem = Mfn_Helper::filesystem();
        $wp_filesystem->delete($src, true);

        // empty wp trash because there are no files to restore
        wp_delete_post($post_id, true);

      }
	  }

		/**
		 * GET icons
		 */

    static function load_icons(){

      $css_link_files_string = '';

      $args = array(
        'post_type' => 'icons',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'order' => 'ASC'
      );

      $icons_fetched = get_posts($args);

      foreach ( $icons_fetched as $icon ){
        $is_style_available = get_post_field('mfn-icon-upload', $icon->ID);

        if( ! empty( $is_style_available ) ){
          $css_link_files_string .= '<link rel="stylesheet" id="mfn-custom-icons-' .get_post_field( 'mfn-icon-name-parsed', $icon->ID ). '" href="' .get_post_field( 'mfn-icon-url', $icon->ID ). '/style.css" media="all">';
        }
      }

      echo $css_link_files_string;
    }

		/**
		 * GET icons list
		 */

    static function get_list_of_icons () {

      $icon_list = [];

      $args = array(
        'post_type' => 'icons',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'order' => 'ASC'
      );

      $icons_fetched = get_posts($args);

      foreach ( $icons_fetched as $icon ){
        $icons_fetched = get_post_field('mfn-icon-titles-array', $icon->ID);

        if( ! empty( $icons_fetched ) ) {
          $icon_list[] = get_post_field('mfn-icon-titles-array', $icon->ID);
        }
      }

      return $icon_list;
    }

	}
}

new Mfn_Post_Type_Icons();
