<?php
/**
 * Custom post types
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Mfn_Post_Type' ) ) {
	class Mfn_Post_Type
	{
		protected $fields = array();
		protected $builder = '';

		/**
		 * Mfn_Post_Type constructor
		 */

		public function __construct()
		{

			// fires when styles are printed for a specific admin page based on $hook_suffix
  		add_action('admin_enqueue_scripts', array($this, 'enqueue'));

			// runs after the basic admin panel menu structure is in place
			add_action('admin_menu', array($this, 'meta_box'));

      // triggered whenever a post or page is created or updated
  		add_action('save_post', array($this, 'save_box'));
		}

    /**
     * Enqueue styles and scripts
     */

    public function enqueue($hook)
    {
			if ( ! in_array( $hook, array('post.php','post-new.php') ) ) {
				return;
	    }

      wp_enqueue_style('mfn-opts', get_theme_file_uri('/muffin-options/css/options.css'), false, MFN_THEME_VERSION, 'all');

      if (is_rtl()) {
				wp_enqueue_style('mfn-opts-rtl', get_theme_file_uri('/muffin-options/css/options-rtl.css'), false, MFN_THEME_VERSION, 'all');
			}

			// fields JS

			$fields_JS = [
				'box_shadow',
				'color',
				'checkbox', // post options only
				'checkbox_pseudo', // section: style only
				'dimensions',
				'dynamic_items',
				'font_select', // shortcodes manager only
				'gradient',
				'icon',
				'order',
				'pills',
				'radio_img',
				'sliderbar',
				'switch',
				'tabs',
				'textarea',
				'typography_vb',
				'upload',
				'upload_multi',
				'visual',
			];

			foreach ( $fields_JS as $type ){
				require_once( get_template_directory() .'/muffin-options/fields/'. $type .'/field_'. $type .'.php' );
				$field_class = 'MFN_Options_'. $type;
				$field_object = new $field_class();
				$field_object->enqueue();
			}

    }

		/**
		 * Get layouts
		 */

		public function get_layouts(){

			$layouts = array(
				0 => __('-- Default --', 'mfn-opts'),
			);

			$args = array(
				'post_type' => 'layout',
				'posts_per_page'=> -1,
			);
			$lay = get_posts($args);

			if (is_array($lay)) {
				foreach ($lay as $v) {
					$layouts[$v->ID] = $v->post_title;
				}
			}

			return $layouts;
		}

		/**
		 * Add meta box
		 */

		public function meta_box()
		{
			add_meta_box(
    		$this->fields['id'],
    		$this->fields['title'],
    		array( $this, 'show_box' ),
    		$this->fields['page'],
    		'normal',
    		'high');

			add_meta_box(
    		'mfn-meta-placeholder',
    		'Placeholder',
    		array( $this, 'show_placeholder' ),
    		$this->fields['page'],
    		'normal',
    		'high');
		}

		/**
		 * Fill meta box with fields
		 */

		public function show_box()
		{
			global $post;

			// nonce

			echo '<input type="hidden" name="mfn-builder-nonce" value="'. wp_create_nonce( 'mfn-builder-nonce' ) .'" />';

			// muffin builder

			if( method_exists( $this->builder, 'show' ) ){
				$this->builder->set_fields();
				$this->builder->show();
			}

			// meta fields

			echo '<div class="mfn-ui mfn-meta">';
				echo '<div class="mfn-meta-wrapper">';
					echo '<div class="mfn-form">';

		  			foreach ( $this->fields['fields'] as $field ) {

							if( empty( $field['type'] ) ){

								// row header

								self::row_header( $field['title'] );

							} else {

								// field

								if( $field['type'] == 'redirect_button' ){

									$link = admin_url('/post.php?post='. $post->ID .'&preview=true&action='. apply_filters('betheme_slug', 'mfn') .'-live-builder');

									if( get_post_status($post->ID) == 'publish' ){
										$link = admin_url('/post.php?post='. $post->ID .'&action='. apply_filters('betheme_slug', 'mfn').'-live-builder');
									}

									echo str_replace('link_here', $link, $field['html']);

								}else{
									$value = get_post_meta( $post->ID, $field['id'], true );

				  				if ( ! key_exists( 'std', $field ) ) {
				  					$field['std'] = false;
				  				}

									if( ! $value && $value !== '0' ){
										$value = stripslashes( htmlspecialchars( ( $field['std'] ), ENT_QUOTES ) );
									}

				  				Mfn_Builder_Admin::field( $field, $value );
								}



							}

		  			}

					echo '</div>';
				echo '</div>';
			echo '</div>';

		}

		public static function row_header( $title, $attr = [] ){

			$class = '';

			if( ! empty( $attr['class'] ) ){
				$class = $attr['class'];
			}

			echo '<div class="mfn-row row-header '. esc_attr( $class ) .'">';
        echo '<div class="row-column row-column-12">';
          echo '<h5 class="row-header-title">'. esc_html( $title ) .'</h5>';
        echo '</div>';
      echo '</div>';

		}

		/**
		 * WP 5.5 FIX | Show placeholder below block editor
		 */

		public function show_placeholder()
		{
			echo '<div class="mfn-meta-placeholder">&nbsp;</div>';
		}

		/**
		 * Save custom meta fileds
		 */

		function save_box( $post_id )
 		{
 			// verify nonce

			if ( empty( $_POST['mfn-builder-nonce'] ) ){
				return $post_id;
			}

			if ( ! wp_verify_nonce( $_POST['mfn-builder-nonce'], 'mfn-builder-nonce' ) ) {
				return $post_id;
			}

 			// check autosave

 			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
 				return $post_id;
 			}

 			// check permissions

			if ( isset( $_POST['post_type'] ) && ( 'page' == $_POST['post_type'] ) ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
			} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}

			// muffin builder

			if ( method_exists( $this->builder, 'save' ) ) {
				$this->builder->save( $post_id );
			}

			// save values

			if ( isset( $this->fields['fields'] ) && is_array( $this->fields['fields'] ) ) {

				foreach ( $this->fields['fields'] as $field ) {

					if ( empty( $field['id'] ) ){
						continue;
					}

	 				if ( isset( $_POST[$field['id']] ) ) {
	 					$new = $_POST[$field['id']];
	 				} else {
	 					continue;
	 				}

					$old = get_post_meta( $post_id, $field['id'], true );

	 				if ( isset( $new ) && ( $new != $old ) ) {
	 					update_post_meta( $post_id, $field['id'], $new );
	 				} elseif ( ( '' == $new ) && $old ) {
	 					delete_post_meta( $post_id, $field['id'], $old );
	 				}

	 			}

			}

 		}

	}
}
