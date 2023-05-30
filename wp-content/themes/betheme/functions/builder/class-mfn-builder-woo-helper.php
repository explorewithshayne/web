<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Builder_Woo_Helper {

  public static function get_woo_cat_image($attr, $cat){
  	$output = '';
  	if($attr['image'] == 1){
  		$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			if(isset($thumbnail_id) && !empty($thumbnail_id)){
				$output .= wp_get_attachment_image( $thumbnail_id, 'shop_catalog', false, array('class'=>'scale-with-grid' ) );
			}else{
				$output .= wc_placeholder_img();
			}
		}
		return $output;
  }

  public static function get_woo_cat_title($attr, $cat){
  	$output = '';
  	if($attr['title'] == 1){
			$output .= '<'.$attr['title_tag'].' class="woocommerce-loop-category__title">'.$cat->name;
			if(isset($attr['count']) && $attr['count'] == 1){ $output .= '<mark class="count">('.$cat->count.')</mark>'; }
			$output .= '</'.$attr['title_tag'].'>';
		}
		return $output;
  }

  public static function get_woo_product_title($product, $attr = false){

  	$output = '<div class="mfn-li-product-row mfn-li-product-row-title">';
  	ob_start();
  	do_action('woocommerce_before_shop_loop_item_title');
  	$output .= ob_get_clean();
  	$output .= '<'.$attr['title_tag'].' class="title"><a href="'.get_permalink($product->get_id()).'">'.get_the_title($product->get_id()).'</a></'.$attr['title_tag'].'>';
  	if ( wc_review_ratings_enabled() ) {
			$output .= wc_get_rating_html( $product->get_average_rating() );
		}
  	$output .= '</div>';

  	ob_start();
  	echo '<div class="mfn-after-shop-loop-item-title">';
  	do_action('woocommerce_after_shop_loop_item_title');
  	echo '</div>';
  	$output .= ob_get_clean();

		return $output;
  }

  public static function sample_item($type){
		$post = false;
		$posts = get_posts( array('post_type' => $type, 'numberposts' => 1, 'orderby' => 'ID', 'order' => 'ASC' ) );

		if( isset($posts) && count($posts) > 0 ){
			$post = $posts[0];
		}

		return $post;
	}

  public static function get_woo_product_image($product, $attr = false){

  	$wishlist_position = mfn_opts_get('shop-wishlist-position');

		$is_translatable = mfn_opts_get('translate');
  	$translate['translate-add-to-cart'] = $is_translatable ? mfn_opts_get('translate-add-to-cart', 'Add to cart') : __('Add to cart', 'woocommerce');
  	$translate['translate-view-product'] = $is_translatable ? mfn_opts_get('translate-view-product', 'View product') : __('View product', 'woocommerce');
  	$translate['translate-add-to-wishlist'] = $is_translatable ? mfn_opts_get('translate-add-to-wishlist', 'Add to wishlist') : __('Add to wishlist', 'betheme'); // ! betheme
  	$translate['translate-if-preview'] = $is_translatable ? mfn_opts_get('translate-if-preview', 'Preview') : __('Preview', 'woocommerce');

		// output -----

  	$output = '<div class="mfn-li-product-row mfn-li-product-row-image">';
  	$shop_images = mfn_opts_get( 'shop-images' );

  	if( 'plugin' == $shop_images ){

			$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'" class="product-loop-thumb">';
				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
				ob_start();
				do_action( 'woocommerce_before_shop_loop_item_title' );
				$output .= ob_get_clean();

			$output .= '</a>';

		} else {

			$output .= '<div class="image_frame scale-with-grid product-loop-thumb" ontouchstart="this.classList.toggle(\'hover\');">';

				if( mfn_opts_get('shop-wishlist') && isset($wishlist_position[1]) ){
					$output .= '<span data-position="left" data-id="'.$product->get_id().'" class="mfn-wish-button mfn-abs-top"><svg width="26" viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></span>';
				}

				ob_start();

				wc_get_template( 'single-product/sale-flash.php');
				do_action('mfn_product_image');

				$output .= ob_get_clean();

				// secondary image on hover

				$secondary_image_id = false;

				if( 'secondary' == $shop_images ){
					if( $attachment_ids = $product->get_gallery_image_ids() ) {
						if( isset( $attachment_ids['0'] ) ){
							$secondary_image_id = $attachment_ids['0'];
						}
					}
				}

				$output .= '<div class="image_wrapper '. ( $secondary_image_id ? 'hover-secondary-image' : '' ) .'">';

					$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'" tabindex="-1">';

						$output .= '<div class="mask"></div>';

						$output .= woocommerce_get_product_thumbnail();

						if( $secondary_image_id ){
							$output .= wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'image-secondary scale-with-grid' ) );
						}

					$output .= '</a>';

					$output .= '<div class="image_links">';

						if( $product->is_in_stock() && (! mfn_opts_get('shop-catalogue')) && (! in_array($product->get_type(), array('external', 'grouped', 'variable'))) ){

							if( mfn_opts_get('image-frame-style') == 'modern-overlay' ){

								if( $product->supports( 'ajax_add_to_cart' ) ){
									$output .= '<a rel="nofollow" tabindex="-1" data-tooltip="'. esc_html($translate['translate-add-to-cart']) .'" data-position="left" href="'. apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url())) .'" data-quantity="1" data-product_id="'. esc_attr($product->get_id()) .'" class="add_to_cart_button ajax_add_to_cart product_type_simple tooltip tooltip-txt"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"></polygon><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"></path></svg></a>';
								} else {
									$output .= '<a rel="nofollow" tabindex="-1" data-tooltip="'. esc_html($translate['translate-add-to-cart']) .'" data-position="left" href="'. apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url())) .'" data-quantity="1" data-product_id="'. esc_attr($product->get_id()) .'" class="add_to_cart_button product_type_simple tooltip tooltip-txt"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"></polygon><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"></path></svg></a>';
								}

							}else{

								if( $product->supports( 'ajax_add_to_cart' ) ){
									$output .= '<a rel="nofollow" tabindex="-1" href="'. apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url())) .'" data-quantity="1" data-product_id="'. esc_attr($product->get_id()) .'" class="add_to_cart_button ajax_add_to_cart product_type_simple"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"></polygon><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"></path></svg></a>';
								} else {
									$output .= '<a rel="nofollow" tabindex="-1" href="'. apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url())) .'" data-quantity="1" data-product_id="'. esc_attr($product->get_id()) .'" class="add_to_cart_button product_type_simple"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"></polygon><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"></path></svg></a>';
								}

							}
						}

						if( mfn_opts_get('image-frame-style') == 'modern-overlay' ){
							$output .= '<a class="link tooltip tooltip-txt" data-tooltip="'. esc_html($translate['translate-view-product']) .'" data-position="left" href="'. apply_filters('the_permalink', get_permalink($product->get_id())) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><path d="M10.17,8.76l2.12-2.12a5,5,0,0,1,7.07,0h0a5,5,0,0,1,0,7.07l-2.12,2.12" class="path"/><path d="M15.83,17.24l-2.12,2.12a5,5,0,0,1-7.07,0h0a5,5,0,0,1,0-7.07l2.12-2.12" class="path"/><line x1="10.17" y1="15.83" x2="15.83" y2="10.17" class="path"/></g></svg></a>';
						}else{
							$output .= '<a class="link" tabindex="-1" href="'. apply_filters('the_permalink', get_permalink($product->get_id())) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><path d="M10.17,8.76l2.12-2.12a5,5,0,0,1,7.07,0h0a5,5,0,0,1,0,7.07l-2.12,2.12" class="path"/><path d="M15.83,17.24l-2.12,2.12a5,5,0,0,1-7.07,0h0a5,5,0,0,1,0-7.07l2.12-2.12" class="path"/><line x1="10.17" y1="15.83" x2="15.83" y2="10.17" class="path"/></g></svg></a>';
						}

						if( mfn_opts_get('shop-wishlist') && isset($wishlist_position[2]) ){

							if( mfn_opts_get('image-frame-style') == 'modern-overlay' ){
								$output .= '<a href="#" tabindex="-1" data-tooltip="'. $translate['translate-add-to-wishlist'] .'" data-position="left" data-id="'.$product->get_id().'" class="mfn-wish-button tooltip tooltip-txt link"><svg width="26" viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></a>';
							}else{
								$output .= '<a href="#" tabindex="-1" data-id="'.$product->get_id().'" class="mfn-wish-button link"><svg width="26" viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></a>';
							}

						}

						if(mfn_opts_get('shop-quick-view') == 1){

							if( mfn_opts_get('image-frame-style') == 'modern-overlay' ){
								$output .= '<a href="#" tabindex="-1" data-tooltip="'. esc_html($translate['translate-if-preview']) .'" data-position="left" data-id="'.$product->get_id().'" data-id="'.$product->get_id().'" class="mfn-quick-view tooltip tooltip-txt"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><line x1="7" y1="7" x2="11.29" y2="11.29" class="path"/><line x1="14.62" y1="14.62" x2="18.91" y2="18.91" class="path"/><polyline points="7 15.57 7 19 10.43 19" class="path"/><polyline points="15.57 19 19 19 19 15.57" class="path"/><polyline points="10.43 7 7 7 7 10.43" class="path"/><polyline points="19 10.43 19 7 15.57 7" class="path"/><line x1="14.71" y1="11.29" x2="19" y2="7" class="path"/><line x1="7" y1="19" x2="11.29" y2="14.71" class="path"/></svg></a>';
							}else{
								$output .= '<a href="#" tabindex="-1" data-id="'.$product->get_id().'" data-id="'.$product->get_id().'" class="mfn-quick-view"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><line x1="7" y1="7" x2="11.29" y2="11.29" class="path"/><line x1="14.62" y1="14.62" x2="18.91" y2="18.91" class="path"/><polyline points="7 15.57 7 19 10.43 19" class="path"/><polyline points="15.57 19 19 19 19 15.57" class="path"/><polyline points="10.43 7 7 7 7 10.43" class="path"/><polyline points="19 10.43 19 7 15.57 7" class="path"/><line x1="14.71" y1="11.29" x2="19" y2="7" class="path"/><line x1="7" y1="19" x2="11.29" y2="14.71" class="path"/></svg></a>';
							}

						}

					$output .= '</div>';

				$output .= '</div>';

				if( ! $product->is_in_stock() && $soldout = mfn_opts_get( 'shop-soldout' ) ){
					$output .= '<span class="soldout"><h4>'. $soldout .'</h4></span>';
				}

				$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'" tabindex="-1"><span class="product-loading-icon added-cart"></span></a>';

			$output .= '</div>';
		}

		$output .= '</div>';
		return $output;
  }

  public static function get_woo_product_price($product, $attr = false){

  	ob_start();
		mfn_display_custom_attributes($product->get_id());
		$output = ob_get_clean();

  	$output .= '<div class="mfn-li-product-row mfn-li-product-row-price">';
  	$output .= '<p class="price">'.$product->get_price_html().'</p>';
  	$output .= '</div>';
		return $output;
  }

  public static function get_woo_product_description($product, $attr = false){

		$output = '';

  	if( get_the_excerpt($product->get_id()) ){
			$output .= '<div class="mfn-li-product-row mfn-li-product-row-description excerpt-'. ( !empty($attr['description']) ? $attr['description'] : 'unset') .'">';
				$output .= '<p class="excerpt">'. do_shortcode( get_the_excerpt($product->get_id()) ) .'</p>';
			$output .= '</div>';
		}

		return $output;
  }

  public static function get_woo_product_button($product, $attr = false){

		$classes = '';

		if( isset($attr['button']) && $attr['button'] == 0 ) return;

		$product->is_purchasable() ? $classes .= 'add_to_cart_button' : null;
		$product->supports( 'ajax_add_to_cart' ) ? $classes .= ' ajax_add_to_cart' : null;

		$output = '<div class="mfn-li-product-row mfn-li-product-row-button button-'. ( !empty($attr['button']) ? $attr['button'] : 'unset') .'">';

			$output .= apply_filters(
        'woocommerce_loop_add_to_cart_link',
        sprintf(
          '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
          esc_url(  $product->add_to_cart_url() ),
          esc_attr( $product->get_id() ),
          esc_attr( $product->get_sku() ),
          $classes,
          esc_attr( $product->get_type() ),
          esc_html( $product->add_to_cart_text() )
        ),
        $product
	    );

	    $wishlist = mfn_opts_get('shop-wishlist');
	    $wishlist_position = mfn_opts_get('shop-wishlist-position');

	    if( $wishlist && isset($wishlist_position[0]) && is_array($wishlist_position) && in_array(0, $wishlist_position)){
				$output .= '<a href="#" data-id="'.$product->get_id().'" class="mfn-wish-button"><svg width="26" viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></a>';
			}

		$output .= '</div>';

		return $output;
  }

  public static function sample_products_loop($attr) {
  	$sl_arr = array(
			'post_type' => 'product',
			'posts_per_page' => $attr['products'],
  	);
  	if( get_option('woocommerce_hide_out_of_stock_items') && get_option('woocommerce_hide_out_of_stock_items') == 'yes' ) {
  		$sl_arr['meta_query'] = array(
				array(
					'key' => '_stock_status',
					'value' => 'instock'
				),
			);
  	}
  	$sample_loop = new WP_Query( $sl_arr );
  	return $sample_loop;
  }

  public static function productslist($product, $attr, $classes) {
  	$order = str_replace(' ', '', $attr['order']);
		$order_arr = explode(',', $order);

		// if ( empty( $product ) || ! $product->is_visible() )  return;

		$output = '<li class="mfn-product-li-item '.implode(' ', wc_get_product_class( $classes, $product )).'">';

		ob_start();
  	echo '<div class="mfn-before-shop-loop-item">';
  	do_action('woocommerce_before_shop_loop_item');
  	echo '</div>';
  	$output .= ob_get_clean();

			if( isset($order_arr) && is_iterable($order_arr) ){
				foreach( $order_arr as $el ){
					if( ! isset( $attr[$el] ) || ( isset($attr[$el] ) && $attr[$el] ) ){
						$fun_name = 'get_woo_product_'.$el;
						if( method_exists('Mfn_Builder_Woo_Helper', $fun_name) ){
							$output .= self::$fun_name($product, $attr);
						}
					}
				}
			}

		ob_start();
  	echo '<div class="mfn-after-shop-loop-item">';
  	do_action('woocommerce_after_shop_loop_item');
  	echo '</div>';
  	$output .= ob_get_clean();

		$output .= '</li>';

		return $output;
  }

  public static function getDiscount($product) {
  	$percent = 0;
  	if( $product->is_type('variable') ){
  		$percentages = array();
	    $prices = $product->get_variation_prices();
	    foreach( $prices['price'] as $key => $price ){
	      if( $prices['regular_price'][$key] !== $price ){
	        $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
	      }
	    }
	    $percent = round(max($percentages));
  	}elseif($product->get_regular_price() && $product->get_sale_price()){
			$percent = round( (1 - ($product->get_sale_price() / $product->get_regular_price()))*100);
  	}
  	return $percent.'%';
  }

}
