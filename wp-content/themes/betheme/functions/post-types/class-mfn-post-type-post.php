<?php
/**
 * Custom post type: Post
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (! class_exists('Mfn_Post_Type_Post')) {
	class Mfn_Post_Type_Post extends Mfn_Post_Type
	{

		/**
		 * Mfn_Post_Type_Post constructor
		 */

		public function __construct() {

			parent::__construct();

			// admin only methods

			if( is_admin() ){
				$this->fields = $this->set_fields();
				$this->builder = new Mfn_Builder_Admin();
			}

			add_action( 'admin_init', array($this, 'mfn_add_posts_cat_image') );

		}

		/**
		 * Set post type fields
		*/

		public function mfn_add_posts_cat_image(){

			add_action( 'category_edit_form_fields', array( $this, 'mfn_edit_posts_cat_image_field' ) );
			add_action( 'category_add_form_fields', array( $this, 'mfn_edit_posts_cat_image_field' ) );

			add_action( 'saved_category', array( $this, 'mfn_posts_cat_save' ) );
			add_action( 'create_category', array( $this, 'mfn_posts_cat_save' ) );
		}

		public function mfn_edit_posts_cat_image_field ($tag) {

			$current_value = '';

			wp_enqueue_media();

			if(isset( $tag->taxonomy )) {
				$current_value = !empty( get_term_meta($tag->term_id, 'thumbnail_id', true) ) ? get_term_meta($tag->term_id, 'thumbnail_id', true) : '';
			}

			$placeholder_url = get_theme_file_uri( '/muffin-options/svg/placeholders/image.svg' );

		    $field_label = 'Choose image';
		    $field_name = 'mfn_category_field_image';

		    if(isset( $tag->taxonomy )) { ?>
			<tr class="form-field mfn-tax-image">
		        <th valign="top" scope="row"><label for="mfn_tax_field"><?php echo $field_label; ?></label></th>
		        <?php $current_value = wp_get_attachment_url($current_value); ?>
				<td><input type="hidden" id="mfn_tax_field" value="<?php echo $current_value; ?>" name="<?php echo $field_name; ?>" class="<?php echo $field_name; ?>">
					<div class="mfn-custom-img-container">
					    <img data-src="<?php echo $placeholder_url; ?>" src="<?php if ( !empty($current_value) ) : echo $current_value; else: echo $placeholder_url; endif; ?>" alt="" style="max-width:100%;" />
						<a class="upload-custom-img button" href="#"><?php _e('Set category image') ?></a>
						<a class="delete-custom-img button <?php if ( ! $current_value ) { echo 'hidden'; } ?>" href="#"><?php _e('Remove image') ?></a>
					</div>
		        </td>
		    </tr>
		    <?php }else{ ?>
				<div class="form-field mfn-tax-image">
			        <label for="mfn_tax_field"><?php echo $field_label; ?></label>
			        <input type="hidden" id="mfn_tax_field" value="" name="<?php echo $field_name; ?>" class="<?php echo $field_name; ?>">
					<div class="mfn-custom-img-container">
					    <img data-src="<?php echo $placeholder_url; ?>" src="<?php if ( !empty($current_value) ) : echo $current_value; else: echo $placeholder_url; endif; ?>" alt="" style="max-width:100%;" />
						<a class="upload-custom-img button <?php if ( $current_value  ) { echo 'hidden'; } ?>" href="#"><?php _e('Set custom image') ?></a>
						<a class="delete-custom-img button <?php if ( ! $current_value ) { echo 'hidden'; } ?>" href="#"><?php _e('Remove image') ?></a>
					</div>
		    	</div>
			<?php }
		}

		public function mfn_posts_cat_save($term_id) {

			if( !empty( $_POST['mfn_category_field_image']) ){
				update_term_meta( $term_id, 'thumbnail_id', $_POST['mfn_category_field_image'] );
			}else if( !empty( get_term_meta($term_id, 'thumbnail_id', true) ) ){
				delete_term_meta($term_id, 'thumbnail_id');
			}

		}

		/**
		 * Set post type fields
		*/

		public function set_fields(){

		return array(
      	'id' => 'mfn-meta-post',
      	'title' => esc_html__('Post Options', 'mfn-opts'),
      	'page' => 'post',
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
  					'id' => 'mfn-post-subheader-image',
  					'type' => 'upload',
  					'title' => __('Subheader image', 'mfn-opts'),
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
      			'id' => 'mfn-post-hide-image',
      			'type' => 'switch',
      			'title' => __('Featured image', 'mfn-opts'),
      			'options'	=> array(
							'1' => __('Hide', 'mfn-opts'),
							'0' => __('Show', 'mfn-opts'),
						),
						'std' => '0'
      		),

      		// advanced

					array(
      			'title' => __('Advanced', 'mfn-opts'),
      		),

      		array(
      			'id' => 'mfn-post-link',
      			'type' => 'text',
      			'title' => __('External link', 'mfn-opts'),
      			'desc' => __('for Post Format: Link', 'mfn-opts'),
      		),

      		array(
      			'id' => 'mfn-post-bg',
      			'type' => 'color',
      			'title' => __('Background color', 'mfn-opts'),
      			'desc' => __('for blog Layout: Masonry Tiles and Template: Intro', 'mfn-opts'),
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
						'desc' => __('Custom CSS code for this post', 'mfn-opts'),
						'class' => 'form-content-full-width',
						'cm' => 'css',
					),

      	),
      );

		}

	}
}

new Mfn_Post_Type_Post();
