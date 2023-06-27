<?php
/**
 * Muffin Builder | Items
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if( ! class_exists('Mfn_Builder_Items') )
{
  class Mfn_Builder_Items {

  	/**
		 * [popup_exit]
		 */

    public static function item_popup_exit( $fields ){
			echo sc_popup_exit( $fields );
		}

  	/**
		 * [megamenu_menu]
		 */

    public static function item_megamenu_menu( $fields ){
			echo sc_megamenu_menu( $fields );
		}

		/**
		 * [footer_menu]
		 */

    public static function item_footer_menu( $fields ){
			echo sc_footer_menu( $fields );
		}

  	/**
		 * [logo]
		 */

    public static function item_header_logo( $fields ){
			echo sc_header_logo( $fields );
		}

		/**
		 * [footer_logo]
		 */

    public static function item_footer_logo( $fields ){
			echo sc_footer_logo( $fields );
		}

		/**
		 * [header_menu]
		 */

    public static function item_header_menu( $fields ){
			echo sc_header_menu( $fields );
		}

		/**
		 * [header_icon]
		 */

    public static function item_header_icon( $fields ){
			echo sc_header_icon( $fields );
		}

		/**
		 * [header_burger]
		 */

    public static function item_header_burger( $fields ){
			echo sc_header_burger( $fields );
		}

		/**
		 * [header_search]
		 */

    public static function item_header_search( $fields ){
			echo sc_header_search( $fields );
		}

		/**
		 * [top_bar]
		 */

    public static function item_header_promo_bar( $fields ){
			echo sc_header_promo_bar( $fields );
		}

		/**
		 * [top_bar]
		 */

    public static function item_header_language_switcher( $fields ){
			echo sc_header_language_switcher( $fields );
		}

  	/**
		 * [shop_products]
		 */

    public static function item_shop_products( $fields ){
    	if( get_post_type() == 'template' ){
    		echo sc_shop_products( $fields, 'sample' );
    	}else{
    		echo sc_shop_products( $fields );
    	}
		}

		/**
		 * [shop_categories]
		 */

    public static function item_shop_categories( $fields ){
			echo sc_shop_categories( $fields );
		}

		/**
		 * [shop_title]
		 */

    public static function item_shop_title( $fields ){
			echo sc_shop_title( $fields );
		}

		/**
		 * [product_title]
		 */

    public static function item_product_title( $fields ){
    	$product = wc_get_product();
			echo sc_product_title( $fields, $product );
		}

		/**
		 * [product_images]
		 */

    public static function item_product_images( $fields ){
    	$product = wc_get_product();
    	echo sc_product_images( $fields, $product );
		}

		/**
		 * [product_price]
		 */

    public static function item_product_price( $fields ){
    	$product = wc_get_product();
			echo sc_product_price( $fields, $product );
		}

		/**
		 * [product_cart_button]
		 */

    public static function item_product_cart_button( $fields ){
    	$product = wc_get_product();
    	echo sc_product_cart_button( $fields, $product);
		}

		/**
		 * [product_reviews]
		 */

    public static function item_product_reviews( $fields ){
    	$product = wc_get_product();
    	echo sc_product_reviews( $fields, $product);
		}

		/**
		 * [product_rating]
		 */

    public static function item_product_rating( $fields ){
    	$product = wc_get_product();
    	echo sc_product_rating( $fields, $product);
		}

		/**
		 * [product_stock]
		 */

    public static function item_product_stock( $fields ){
    	$product = wc_get_product();
    	echo sc_product_stock( $fields, $product );
		}

		/**
		 * [product_meta]
		 */

    public static function item_product_meta( $fields ){
			$product = wc_get_product();
			echo sc_product_meta($fields, $product);
		}

		/**
		 * [product_meta]
		 */

    public static function item_product_breadcrumbs( $fields ){
			$product = wc_get_product();
			echo sc_product_breadcrumbs($fields, $product);
		}

		/**
		 * [product_short_description]
		 */

    public static function item_product_short_description( $fields ){
    	$product = wc_get_product();
    	echo sc_product_short_description( $fields, $product );
		}

		/**
		 * [product_additional_information]
		 */

    public static function item_product_additional_information( $fields ){
    	$product = wc_get_product();
			echo sc_product_additional_information( $fields, $product );
		}

		/**
		 * [product_upsells]
		 */

    public static function item_product_upsells( $fields ){
			$product = wc_get_product();
    	echo sc_product_upsells( $fields, $product );
		}

		/**
		 * [product_related]
		 */

    public static function item_product_related( $fields ){
    	$product = wc_get_product();
    	echo sc_product_related( $fields, $product );
		}

		/**
		 * [product_content]
		 */

    public static function item_product_content( $fields ){
    	$product = wc_get_product();
			echo sc_product_content( $fields, $product );
		}

		/**
		 * [accordion]
		 */

    public static function item_accordion( $fields ){
			echo sc_accordion( $fields );
		}

		/**
		 * [article_box]
		 */

    public static function item_article_box( $fields ){
			echo sc_article_box( $fields );
		}

		/**
		 * [before_after]
		 */

    public static function item_before_after( $fields ){
			echo sc_before_after( $fields );
		}

		/**
		 * [blockquote]
		 */

    public static function item_blockquote( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_blockquote( $fields, $fields['content'] );
		}

		/**
		 * [blog]
		 */

    public static function item_blog( $fields ){
			echo sc_blog( $fields );
		}

		/**
		 * [blog_news]
		 */

    public static function item_blog_news( $fields ){
			echo sc_blog_news( $fields );
		}

		/**
		 * [blog_slider]
		 */

    public static function item_blog_slider( $fields ){
			echo sc_blog_slider( $fields );
		}

		/**
		 * [blog_teaser]
		 */

    public static function item_blog_teaser( $fields ){
			echo sc_blog_teaser( $fields );
		}

		/**
		 * [button]
		 */

		public static function item_button( $fields ){
			echo sc_button( $fields );
		}

		/**
		 * [call_to_action]
		 */

		public static function item_call_to_action( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_call_to_action( $fields, $fields['content'] );
		}

		/**
		 * [chart]
		 */

		public static function item_chart( $fields ){
			echo sc_chart( $fields );
		}

		/**
		 * [clients]
		 */

		public static function item_clients( $fields ){
			echo sc_clients( $fields );
		}

		/**
		 * [clients_slider]
		 */

		public static function item_clients_slider( $fields ){
			echo sc_clients_slider( $fields );
		}

		/**
		 * [code]
		 */

		public static function item_code( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_code( $fields, $fields['content'] );
		}

		/**
		 * [column]
		 */

		public static function item_column( $fields ){

			$column_class = '';
			$column_attr = '';
			$style = '';

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			// align

			if( ! empty( $fields['align']) ){
				$column_class	.= ' align_'. $fields['align'];
			}

			if( ! empty( $fields['align-mobile'] ) ) {
				$column_class	.= ' mobile_align_'. $fields['align-mobile'];
			}

			// background

			if( ! empty( $fields['column_bg'] ) ) {
				$style .= 'background-color:'. $fields['column_bg'] .';';
			}

			if( ! empty( $fields['bg_image'] ) ) {

				// background image

				$style .= "background-image:url('". $fields['bg_image'] ."');";

				// background position

				if( ! empty( $fields['bg_position'] ) ) {

					$bg_pos = $fields['bg_position'];

					if ($bg_pos) {
						$background_attr = explode(';', $bg_pos);
						$aBg[] = 'background-repeat:'. $background_attr[0];
						$aBg[] = 'background-position:'. $background_attr[1];

						$style .= implode(';', $aBg) .';';
					}

				}

				// background size

				if (isset($fields['bg_size']) && ($fields['bg_size'] != 'auto')) {
					$column_class .= ' bg-'. $fields['bg_size'];
				}
			}

			// padding

			if( ! empty( $fields['padding'] ) ) {
				$style .= 'padding:'. $fields['padding'] .';';
			}

			// custom | style

			if( ! empty( $fields['style'] ) ) {
				$style .= $fields['style'];
			}

			if( empty(Mfn_Builder_Front::$item_id) && !empty($fields['vb_postid']) && get_post_type($fields['vb_postid']) != 'template' && strpos($fields['content'], '}') !== false ){
				$fields['content'] = str_replace('}', ':'.$fields['vb_postid'].'}', $fields['content']);
			}

			// output -----

			echo '<div class="column_attr mfn-inline-editor clearfix'. esc_attr( $column_class ) .'"'. $column_attr .' style="'. $style .'">';
				echo do_shortcode( be_dynamic_data($fields['content']) );
			echo '</div>';
		}

		/**
		 * [contact_box]
		 */

		public static function item_contact_box( $fields ){
			echo sc_contact_box( $fields );
		}

		/**
		 * [content]
		 */

		public static function item_content( $fields = false ){
			echo '<div class="the_content">';
				echo '<div class="the_content_wrapper">';
					the_content();
				echo '</div>';
			echo '</div>';
		}

		/**
		 * [countdown]
		 */

		public static function item_countdown( $fields ){
			echo sc_countdown( $fields );
		}

		/**
		 * [counter]
		 */

		public static function item_counter( $fields ){
			echo sc_counter( $fields );
		}

		/**
		 * [divider_2]
		 */

		public static function item_divider_2( $fields ){
			echo sc_divider_2( $fields );
		}

		/**
		 * [divider]
		 */

		public static function item_divider( $fields ){
			echo sc_divider( $fields );
		}

		/**
		 * [fancy_divider]
		 */

		public static function item_fancy_divider( $fields ){
			echo sc_fancy_divider( $fields );
		}

		/**
		 * [fancy_heading]
		 */

		public static function item_fancy_heading( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_fancy_heading( $fields, $fields['content'] );
		}

		/**
		 * [faq]
		 */

		public static function item_faq( $fields ){
			echo sc_faq( $fields );
		}

		/**
		 * [feature_box]
		 */

		public static function item_feature_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_feature_box( $fields, $fields['content'] );
		}

		/**
		 * [feature_list]
		 */

		public static function item_feature_list( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_feature_list( $fields, $fields['content'] );
		}

		/**
		 * [flat_box]
		 */

		public static function item_flat_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_flat_box( $fields, $fields['content'] );
		}

		/**
		 * [heading]
		 */

		public static function item_heading( $fields ){
			echo sc_heading( $fields );
		}

		/**
		 * [helper]
		 */

		public static function item_helper( $fields ){
			echo sc_helper( $fields );
		}

		/**
		 * [hover_box]
		 */

		public static function item_hover_box( $fields ){
			echo sc_hover_box( $fields );
		}

		/**
		 * [hover_color]
		 */

		public static function item_hover_color( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_hover_color( $fields, $fields['content'] );
		}

		/**
		 * [how_it_works]
		 */

		public static function item_how_it_works( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_how_it_works( $fields, $fields['content'] );
		}

		/**
		 * [icon_box]
		 */

		public static function item_icon_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_icon_box( $fields, $fields['content'] );
		}

		/**
		 * [icon_box_2]
		 */

		public static function item_icon_box_2( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_icon_box_2( $fields, $fields['content'] );
		}

		/**
		 * [image]
		 */

		public static function item_image( $fields ){
			echo sc_image( $fields );
		}

		/**
		 * [image_gallery]
		 */

		public static function item_image_gallery( $fields ){
			$fields['link'] = 'file';
			echo sc_gallery( $fields );
		}

		/**
		 * [info_box]
		 */

		public static function item_info_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_info_box( $fields, $fields['content'] );
		}

		/**
		 * [list_2]
		 */

		public static function item_list_2( $fields ){
			echo sc_list_2( $fields );
		}

		/**
		 * [list]
		 */

		public static function item_list( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_list( $fields, $fields['content'] );
		}

		/**
		 * [livesearch]
		 */

		public static function item_livesearch( $fields ){
			echo sc_livesearch( $fields );
		}

		/**
		 * [map_basic]
		 */

		public static function item_map_basic( $fields ){
			echo sc_map_basic( $fields );
		}

		/**
		 * [map]
		 */

		public static function item_map( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}
			echo sc_map( $fields, $fields['content'] );

		}

		/**
		 * [offer]
		 */

		public static function item_offer( $fields ){
			echo sc_offer( $fields );
		}

		/**
		 * [offer_thumb]
		 */

		public static function item_offer_thumb( $fields ){
			echo sc_offer_thumb( $fields );
		}

		/**
		 * [opening_hours]
		 */

		public static function item_opening_hours( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_opening_hours( $fields, $fields['content'] );
		}

		/**
		 * [our_team]
		 */

		public static function item_our_team( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_our_team( $fields, $fields['content'] );
		}

		/**
		 * [our_team_list]
		 */

		public static function item_our_team_list( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_our_team_list( $fields, $fields['content'] );
		}

		/**
		 * [lottie]
		 */

		public static function item_lottie( $fields ){
			echo sc_lottie( $fields );
		}

		/**
		 * [payment_methods]
		 */

		public static function item_payment_methods( $fields ){
			echo sc_payment_methods( $fields );
		}

		/**
		 * [photo_box]
		 */

		public static function item_photo_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_photo_box( $fields, $fields['content'] );
		}

		/**
		 * [plain_text]
		 */

		public static function item_plain_text( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_plain_text( $fields, $fields['content'] );
		}

		/**
		 * [placeholder]
		 */

		public static function item_placeholder( $fields ){
			echo '<div class="placeholder">&nbsp;</div>';
		}

		/**
		 * [portfolio]
		 */

		public static function item_portfolio( $fields ){
			echo sc_portfolio( $fields );
		}

		/**
		 * [portfolio_grid]
		 */

		public static function item_portfolio_grid( $fields ){
			echo sc_portfolio_grid( $fields );
		}

		/**
		 * [portfolio_photo]
		 */

		public static function item_portfolio_photo( $fields ){
			echo sc_portfolio_photo( $fields );
		}

		/**
		 * [portfolio_slider]
		 */

		public static function item_portfolio_slider( $fields ){
			echo sc_portfolio_slider( $fields );
		}

		/**
		 * [pricing_item]
		 */

		public static function item_pricing_item( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_pricing_item( $fields, $fields['content'] );
		}

		/**
		 * [progress_bars]
		 */

		public static function item_progress_bars( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_progress_bars( $fields, $fields['content'] );
		}

		/**
		 * [promo_box]
		 */

		public static function item_promo_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_promo_box( $fields, $fields['content'] );
		}

		/**
		 * [quick_fact]
		 */

		public static function item_quick_fact( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_quick_fact( $fields, $fields['content'] );
		}

		/**
		 * [shop]
		 */

		public static function item_shop( $fields ){

			if( empty($fields['type']) ){
				$fields['type'] = '';
			}

			if( isset($fields['category']) && $fields['category'] == 'All' ) unset($fields['category']);

			if( class_exists( 'WC_Shortcode_Products' ) ){
				$shortcode = new WC_Shortcode_Products( $fields, $fields['type'] );
				echo $shortcode->get_content();
			}

		}

		/**
		 * [shop_slider]
		 */

		public static function item_shop_slider( $fields ){
			echo sc_shop_slider( $fields );
		}

		/**
		 * [sidebar_widget]
		 */

		public static function item_sidebar_widget( $fields, $vb = false ){
			if( $vb ){
				echo '<img src="'.get_theme_file_uri( '/muffin-options/svg/placeholders/sidebar_widget.svg' ).'" alt="">';
			}else{
				echo sc_sidebar_widget( $fields );
			}
		}

		/**
		 * [slider]
		 */

		public static function item_slider( $fields ){
			echo sc_slider( $fields );
		}

		/**
		 * [slider_plugin]
		 */

		public static function item_slider_plugin( $fields ){
			echo sc_slider_plugin( $fields );
		}

		/**
		 * [sliding_box]
		 */

		public static function item_sliding_box( $fields ){
			echo sc_sliding_box( $fields );
		}

		/**
		 * [story_box]
		 */

		public static function item_story_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_story_box( $fields, $fields['content'] );
		}

		/**
		 * [table_of_contents]
		 */

		public static function item_table_of_contents( $fields ){
			echo sc_table_of_contents( $fields );
		}

		/**
		 * [tabs]
		 */

		public static function item_tabs( $fields ){
			echo sc_tabs( $fields );
		}

		/**
		 * [testimonials]
		 */

		public static function item_testimonials( $fields ){
			echo sc_testimonials( $fields );
		}

		/**
		 * [testimonials_list]
		 */

		public static function item_testimonials_list( $fields ){
			echo sc_testimonials_list( $fields );
		}

		/**
		 * [timeline]
		 */

		public static function item_timeline( $fields ){
			echo sc_timeline( $fields );
		}

		/**
		 * [toggle]
		 */

		public static function item_toggle( $fields ){
			echo sc_toggle( $fields );
		}

		/**
		 * [trailer_box]
		 */

		public static function item_trailer_box( $fields ){
			echo sc_trailer_box( $fields );
		}

		/**
		 * [video]
		 */

		public static function item_video( $fields ){
			echo sc_video( $fields );
		}

		/**
		 * [visual]
		 */

		public static function item_visual( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			if( empty(Mfn_Builder_Front::$item_id) && !empty($fields['vb_postid']) && get_post_type($fields['vb_postid']) != 'template' && strpos($fields['content'], '}') !== false ){
				$fields['content'] = str_replace('}', ':'.$fields['vb_postid'].'}', $fields['content']);
			}

			echo '<div class="mfn-visualeditor-content mfn-inline-editor">';
				echo do_shortcode( be_dynamic_data($fields['content']) );
			echo '</div>';
		}

		/**
		 * [zoom_box]
		 */

		public static function item_zoom_box( $fields ){

			if( empty($fields['content']) ){
				$fields['content'] = '';
			}

			echo sc_zoom_box( $fields, $fields['content'] );
		}

		/**
		 * BeBuilder BLOCKS
		 */

		public static function blocks( $item, $fields ){

			// return;

			$output = '';

			if( empty($item['attr']) ){
				return;
			}

			$item_type = $item['type'];
			$item_fields = $fields->get_item_fields( $item_type );

			// label

			$label = false;
			if( ! empty( $item['attr']['title'] ) ){
				$label = $item['attr']['title'];
			}

			// header

			$output .= '<div class="card-header">';
				$output .= '<div class="card-title-group">';
					$output .= '<span class="card-icon"></span>';
					$output .= '<div class="card-desc">';
						$output .= '<h5 class="card-title">'. esc_html( $item_fields['title'] ) .'</h5>';
						// subtitle shows in simple view only
						$output .= '<p class="card-subtitle mfn-item-label">'. esc_html( $label ) .'</p>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			// content

			$preview = [
				'image' => '',
				'title' => '',
				'subtitle' => '',
				'content' => '',
				'style' => '',
				'number' => '',
				'category' => '',
				'category-all' => '',
				'icon' => '',
				'tabs' => '',
				'images' => '',
				'align' => '',
			];

			$preview_empty = [];
			$preview_tabs_primary = 'title';

			// $output .= json_encode($item['attr']);

			if( ! empty($item_fields['attr']) ){

				foreach ( $item_fields['attr'] as $field ) {
					if ( isset( $field['preview'] ) ){

						$prev_key = $field['preview'];
						$prev_id = $field['id'];

						// existing item or default value

						if( isset( $item['attr'] ) ){

							if( isset( $item['attr'][$prev_id] ) ){
								$preview[$prev_key] = $item['attr'][$prev_id];
							}

							if( 'tabs' === $field['type'] && empty( $item['attr']['tabs'] ) ){
								$preview[$prev_key] = '';
							}

						} elseif( ! empty( $field['std'] ) ){

							$preview[$prev_key] = $field['std'];

						}

						// tabs

						if( 'tabs' == $field['preview'] ){
							if( ! empty( $field['primary'] ) ){
								$preview_tabs_primary = $field['primary'];
							}
						}

						// category

						if( 'category' == $field['preview'] ){

							if( $preview['category'] ){

								$cat_obj = get_category_by_slug( $preview['category'] );

								if( is_object( $cat_obj ) ){
									$preview['category'] = $cat_obj->name;
								} else {
									$preview['category'] = 'All';
								}

							} else {
								$preview['category'] = 'All';
							}

						}

					}
				}

			}

			// multiple categories

			if ( $preview['category-all'] ){
				$preview['category'] = $preview['category-all'];
			}

			// icon

			if ( in_array( $item_type, ['counter','icon_box','icon_box_2','list'] ) && $preview['image'] ){
				// image replaces icon in some items
				$preview['icon'] = '';
			}

			// SVG placeholder

			if ( in_array( $item_type, ['map','map_basic'] ) ){
				$preview['image'] = get_theme_file_uri( '/muffin-options/svg/placeholders/map.svg' );
			}

			if ( in_array( $item_type, ['code','content','fancy_divider','livesearch','lottie','sidebar_widget','slider_plugin','video'] ) ){
				$preview['image'] = get_theme_file_uri( '/muffin-options/svg/placeholders/'. $item_type .'.svg' );
			}

			// image dynamic data

			if( ! empty($preview['image']) && false !== strpos('{featured_image}', $preview['image']) ){
				$src_dynamic = be_dynamic_data($preview['image']);
				if( is_numeric( $src_dynamic ) ){
					$preview['image'] = wp_get_attachment_image_url( $src_dynamic, 'full' );
				}
			}

			// empty

			foreach( $preview as $prev_key => $prev_val ){
				if( $prev_val ){
					$preview_empty[ $prev_key ] = '';
				} else {
					$preview_empty[ $prev_key ] = 'empty';
				}
			}

			// content limit

			if ( $preview['content'] ){

				$excerpt = $preview['content'];

				if ( in_array( $item_type, ['column', 'visual'] ) ){

					// remove unwanted HTML tags
					$excerpt = wp_kses( $excerpt, Mfn_Builder_Helper::allowed_html() );

					// wrap shortcodes into span to highlight
					$excerpt = preg_replace( '/(\[(.*?)?\[\/)((.*?)?\])|(\[(.*?)?\])/', '<span class="item-preview-shortcode">$0</span>', $excerpt);

					// autoclose tags
					$excerpt = force_balance_tags( $excerpt );

				} else {

					$excerpt = strip_shortcodes( strip_tags( $excerpt ) );

					$excerpt = preg_split( '/\b/', $excerpt, 16 * 2 + 1 );

					array_pop( $excerpt );
					$excerpt = implode( $excerpt );

					if( strlen( $excerpt ) < strlen( $preview['content'] ) ){
						$excerpt = $excerpt .'...';
					}

				}

				$preview['content'] = $excerpt;

			}

			$output .= '<div class="card-content item-preview align-'. esc_attr( $preview['align'] ) .'">';

				$output .= '<div class="preview-group image '. esc_attr( $preview_empty['image'] ) .'">';
					$output .= '<img class="item-preview-image" src="'. esc_url( $preview['image'] ) .'" />';
				$output .= '</div>';

				$output .= '<div class="preview-group content">';

					$output .= '<p class="item-preview-title '. esc_attr( $preview_empty['title'] ) .'">'. esc_html( $preview['title'] ) .'</p>';
					$output .= '<p class="item-preview-subtitle '. esc_attr( $preview_empty['subtitle'] ) .'">'. esc_html( $preview['subtitle'] ) .'</p>';
					$output .= '<div class="item-preview-content '. esc_attr( $preview_empty['content'] ) .'">'. $preview['content'] .'</div>';

					$output .= '<p class="item-preview-placeholder-parent">';

						$placeholder_type = self::get_item_placeholder_type( $item_type );

						if( 'standard' == $placeholder_type ){

							$placeholder = get_theme_file_uri( '/muffin-options/svg/placeholders/'. $item_type .'.svg' );
							$output .= '<img class="item-preview-placeholder" src="'. esc_url( $placeholder ) .'" />';

						} elseif ( 'variable' == $placeholder_type ) {

							// existing item or default value

							if( isset( $item['fields'] ) ){
								$item_style = str_replace( array( ',', ' ' ), '-', $item['fields']['style'] );
							} else {
								$item_style = 'grid';
							}

							$placeholder_dir = get_theme_file_uri( '/muffin-options/svg/select/'. $item_type .'/' );
							$placeholder = $placeholder_dir . $item_style .'.svg';

							$output .= '<img class="item-preview-placeholder" src="'. esc_url( $placeholder ) .'" data-dir="'. esc_url( $placeholder_dir ) .'"/>';

						}

						$output .= '<span class="item-preview-number '. esc_attr( $preview_empty['number'] ) .'">'. esc_html( $preview['number'] ) .'</span>';

					$output .= '</p>';

					$output .= '<p class="item-preview-icon '. esc_attr( $preview_empty['icon'] ) .'"><i class="'. esc_attr( $preview['icon'] ) .'"></i></p>';
					$output .= '<p class="item-preview-category-parent '. esc_attr( $preview_empty['category'] ) .'"><span class="label">'. esc_html__('Category', 'mfn-opts') .':</span><span class="item-preview-category">'. esc_html( $preview['category'] ) .'</span></p>';

					$output .= '<ul class="item-preview-tabs '. esc_attr( $preview_empty['tabs'] ) .'">';
						if ( $preview['tabs'] ){
							foreach ( $preview['tabs'] as $tab ) {
								$output .= '<li>'. $tab[$preview_tabs_primary] .'</li>';
							}
						}
					$output .= '</ul>';

					$output .= '<ul class="item-preview-images '. esc_attr( $preview_empty['images'] ) .'">';
						if ( $preview['images'] ){
							$preview['images'] = explode( ',', $preview['images'] );
							foreach ( $preview['images'] as $image ){
								$output .= '<li>'. wp_get_attachment_image( $image, 'thumbnail' ) .'</li>';
							}
						}
					$output .= '</ul>';

				$output .= '</div>';

			$output .= '</div>';

			return $output;

 		}

		/**
		 * BeBuilder BLOCKS GET item placeholder type
		 */

		public static function get_item_placeholder_type( $item ){

			$return = false;

			$array = [
				'standard' => [
					'blog_news', 'blog_slider', 'blog_teaser', 'clients', 'clients_slider', 'offer', 'offer_thumb',
					'portfolio_grid', 'portfolio_photo', 'portfolio_slider', 'shop', 'shop_slider',
				 	'slider', 'testimonials', 'testimonials_list'
				],
				'variable' => [
					'blog', 'portfolio'
				],
			];

			foreach( $array as $type => $items ){
				if( in_array( $item, $items ) ){
					$return = $type;
					break;
				}
			}

			return $return;

		}

  }
}
