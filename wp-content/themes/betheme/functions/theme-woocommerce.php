<?php
/**
 * WooCommerce functions.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
* WooCommerce | Theme support & actions
*/

function mfn_woo_support(){

	$thumbnail_image_width = mfn_opts_get( 'shop-image-width', 800 );
	$single_image_width = mfn_opts_get( 'shop-image-width', 800 );

	if( 'modern' == mfn_opts_get('shop-product-style') ){
		$single_image_width = 1200;
	}

	add_theme_support('woocommerce', array(
		'thumbnail_image_width' => $thumbnail_image_width,
		'single_image_width' => $single_image_width,
	));

}
add_action( 'after_setup_theme', 'mfn_woo_support' );

// WooCommerce 2.7+ single product gallery

add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

if( 'disable-zoom' == mfn_opts_get('shop-single-image') ){
	remove_theme_support( 'wc-product-gallery-zoom' );
}

/**
 * WooCommerce | Actions | Remove
 */

if( get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' ){
	add_filter( 'wc_add_to_cart_message_html', '__return_false' );
}

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'WC_Structured_Data::generate_website_data', 30);

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

if ( mfn_opts_get('shop-catalogue') ) {
	// add_filter( 'woocommerce_is_purchasable', '__return_false');
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}

/**
 * WooCommerce | Actions | Add
 */

function mfn_woocommerce_product_reviews_tab_title( $title ){
	$title = str_replace( '(', '<span class="number">', $title );
	$title = str_replace( ')', '</span>', $title );
	return $title;
}
add_filter( 'woocommerce_product_reviews_tab_title', 'mfn_woocommerce_product_reviews_tab_title' );

function mfn_woocommerce_before_quantity_input_field(){
	echo '<a href="#" class="quantity-change minus"><i class="icon-minus" aria-label="quantity minus icon"></i></a>';
}
add_action( 'woocommerce_before_quantity_input_field', 'mfn_woocommerce_before_quantity_input_field' );

function mfn_woocommerce_after_quantity_input_field(){
	echo '<a href="#" class="quantity-change plus"><i class="icon-plus" aria-label="quantity plus icon"></i></a>';
}
add_action( 'woocommerce_after_quantity_input_field', 'mfn_woocommerce_after_quantity_input_field' );

add_filter( 'woocommerce_product_description_heading', '__return_false' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );

/**
 * SVG icons in notices
 */

function mfn_woocommerce_kses_notice_allowed_tags( $allowed_tags ){

	$svg_args = [
		'svg' => [
			'viewbox' => true,
		],
		'defs' => true,
		'style' => true,
		'g' => true,
		'circle' => [
			'cx' => true,
			'cy' => true,
			'r' => true,
			'class' => true,
		],
		'line' => [
			'x1' => true,
			'y1' => true,
			'x2' => true,
			'y2' => true,
			'class' => true,
		],
		'path' => [
			'd' => true,
			'class' => true,
		],
		'polyline' => [
			'points' => true,
			'class' => true,
		],
	];

	$allowed_tags = array_merge( $allowed_tags, $svg_args );

	return $allowed_tags;
}
add_filter( 'woocommerce_kses_notice_allowed_tags', 'mfn_woocommerce_kses_notice_allowed_tags' );

/**
 * Action | Empty cart message
 */

if (! function_exists('mfn_wc_empty_cart_message')) {
	function mfn_wc_empty_cart_message()
	{ ?>
			<div class="cart-empty">
				<p class="cart-empty-icon"><svg width="26" viewBox="0 0 26 26" aria-hidden="true"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"></polygon><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"></path></svg></p>
				<p><?php _e('Your cart is currently empty.', 'woocommerce'); ?></p>
			</div>
		<?php
	}
}
add_action('woocommerce_cart_is_empty', 'mfn_wc_empty_cart_message', 10);

/**
 * Filter | Not enough stock already in cart
 */

function mfn_woocommerce_cart_product_not_enough_stock_already_in_cart_message( $message, $product_data, $stock_quantity, $stock_quantity_in_cart ){

	$message = sprintf(
		'%s <a href="%s" class="separated">%s</a> ',
		/* translators: 1: quantity in stock 2: current quantity */
		sprintf( __( 'You cannot add that amount to the cart &mdash; we have %1$s in stock and you already have %2$s in your cart.', 'woocommerce' ), wc_format_stock_quantity_for_display( $stock_quantity, $product_data ), wc_format_stock_quantity_for_display( $stock_quantity_in_cart, $product_data ) ),
		wc_get_cart_url(),
		__( 'View cart', 'woocommerce' )
	);

	return $message;

}
add_filter('woocommerce_cart_product_not_enough_stock_already_in_cart_message','mfn_woocommerce_cart_product_not_enough_stock_already_in_cart_message', 10, 4 );

/**
 * WooCommerce | Styles
 */

if (! function_exists('mfn_woo_styles')) {
	function mfn_woo_styles()
	{
		$min_css = '';
		$min_js = '';

		$performance_minify_css = mfn_opts_get('minify-css','');
		$performance_minify_js = mfn_opts_get('minify-js','');

		if( $performance_minify_css ){
			$min_css = '.min';
		}

		if( $performance_minify_js ){
			$min_js = '.min';
		}

		wp_enqueue_style('mfn-woo', get_theme_file_uri('/css/woocommerce'. $min_css .'.css'), 'woocommerce-general-css', MFN_THEME_VERSION, 'all');

		wp_enqueue_script('mfn-imagesloaded', get_theme_file_uri('/js/plugins/imagesloaded.min.js'), ['jquery'], MFN_THEME_VERSION, true);
		wp_enqueue_script('mfn-slick', get_theme_file_uri('/js/plugins/slick.min.js'), ['jquery'], MFN_THEME_VERSION, true);
		wp_enqueue_script('mfn-woojs', get_theme_file_uri('/js/woocommerce'. $min_js .'.js'), ['jquery'], MFN_THEME_VERSION, true);

		if(mfn_opts_get('shop-quick-view') == 1){
			wp_enqueue_script('wc-add-to-cart-variation');
		}

		if( isset($_GET['mfn-demo-product-gallery-overlay']) ){
			$gallery_overlay = 'mfn-thumbnails-'. $_GET['mfn-demo-product-gallery-overlay']; // demo only
		} else {
			$gallery_overlay = mfn_opts_get('shop-product-gallery-overlay');
		}

		if( isset($_GET['mfn-demo-product-gallery-overlay']) && 'overlay' == $_GET['mfn-demo-product-gallery-overlay'] ){
			$thumbnails_margin = '15px'; // demo only
			$main_margin = 'mfn-mim-15';
		} else {
			$thumbnails_margin = mfn_opts_get( 'shop-product-thumbnails-margin', 0, ['unit'=>'px'] );
			$main_margin = mfn_opts_get( 'shop-product-main-image-margin', 'mfn-mim-0' );
		}

		wp_localize_script( 'mfn-woojs', 'mfnwoovars',
      array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'wpnonce' => wp_create_nonce( 'mfn-woo-nonce' ),
        'rooturl' => get_home_url(null, '', 'relative'),
        'productthumbsover' => $gallery_overlay,
        'productthumbs' => $thumbnails_margin,
        'mainimgmargin' => $main_margin,
        'myaccountpage' => get_permalink( get_option('woocommerce_myaccount_page_id') ) ?? '/',
				'groupedQuantityErrori18n' => esc_html__( 'Please choose the quantity of items you wish to add to your cart…', 'betheme' ),
      )
    );

	}
}
add_action('wp_enqueue_scripts', 'mfn_woo_styles');


function mfn_admin_scripts() {
	if( is_admin() && function_exists('is_woocommerce') ) {
        wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
 		wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );
    }
}
add_action( 'admin_enqueue_scripts', 'mfn_admin_scripts' );

// WooCommerce 3.0+ | Image size

if (! function_exists('mfn_woocommerce_get_image_size_gallery_thumbnail')) {
	function mfn_woocommerce_get_image_size_gallery_thumbnail()
	{
		return array(
			'width' => 300,
			'height' => 300,
			'crop' => 1,
		);
	}
}
add_filter('woocommerce_get_image_size_gallery_thumbnail', 'mfn_woocommerce_get_image_size_gallery_thumbnail');

/**
 *	WooCommerce | Products per line/page
 */

function mfn_woo_loop_shop_columns()
{
	return 3;
}

add_filter('loop_shop_columns', 'mfn_woo_loop_shop_columns', 20);

/**
 *	WooCommerce | Overrides Elementor
 */

function mfn_theme_needs_template_override( $need_override_location, $location ) {
	$tmp_id = mfn_ID();

	if ( isset($tmp_id) && is_numeric($tmp_id) && get_post_type($tmp_id) == 'template' && ( get_post_status($tmp_id) == 'publish' || !empty( $_GET['visual'] ) ) ) {
		$need_override_location = false;
	}
	return $need_override_location;
}
add_filter( 'elementor/theme/need_override_location', 'mfn_theme_needs_template_override', 11, 2 );

/**
 *	WooCommerce | Woo classess if preview template
 */

add_filter( 'body_class','woo_template_body_classes' );
function woo_template_body_classes( $classes ) {
	$tmp_id = mfn_ID();

 	if( is_singular('template') && in_array( get_post_meta(get_the_ID(), 'mfn_template_type', true), array('shop-archive', 'single-product') ) ){
	    $classes[] = 'woocommerce';
    }

    if ( is_product() ) {
    	$product = wc_get_product( get_the_ID() );
    	if(!$product->managing_stock()) $classes[] = 'stock-disabled';

    	if ( !comments_open( $product->get_id() ) ) $classes[] = 'reviews-disabled';
	}

	if(mfn_opts_get('shop-wishlist')){
		$classes[] = 'wishlist-active';
	}

	if( empty(mfn_opts_get('shop-list-active-filters')) && empty(mfn_opts_get('shop-list-perpage')) && empty(mfn_opts_get('shop-list-layout')) && empty(mfn_opts_get('shop-list-sorting')) && empty(mfn_opts_get('shop-list-results-count')) ){
		$classes[] = 'mfn-all-shop-filters-disabled';
	}

	if( get_theme_support( 'wc-product-gallery-zoom' ) ){
		$classes[] = 'product-gallery-zoom';
	}

	$wishlist_position = mfn_opts_get('shop-wishlist-position');
	if( isset($wishlist_position[0]) ){
		$classes[] = 'wishlist-button';
	}

	if(mfn_opts_get('mobile-products-row') == 2){
		$classes[] = 'mobile-row-2-products';
	}

	if(mfn_opts_get('variable-swatches') == 1){
		$classes[] = 'mfn-variable-swatches';
	}

	if( mfn_opts_get('shop-icon-count-if-zero') == 0 ){
		$classes[] = 'mfn-hidden-icon-count';
	}

	if( ('disable-zoom' == mfn_opts_get('shop-single-image') ) || (isset($tmp_id) && is_numeric($tmp_id) && get_post_status($tmp_id) == 'publish' && get_post_type($tmp_id) == 'template' && get_post_meta($tmp_id, 'mfn_template_product_image_zoom', true) == 0 ) ){
		$classes[] = 'product-zoom-disabled';
	}

	if( mfn_opts_get('sticky-shop-menu') == 1 ){
		$classes[] = 'footer-menu-sticky';
	}

	if( mfn_opts_get('shop-sidecart') == 1 ){
		$classes[] = 'shop-sidecart-active';
	}

	if( get_option('woocommerce_enable_ajax_add_to_cart') == 'yes'){
		$classes[] = 'mfn-ajax-add-to-cart';
	}

	if( mfn_opts_get('shop-product-cart-button-extra') == 1 ){
		$classes[] = 'mfn-cart-button-wrap';
	}

  return $classes;
}

add_action( 'mfn_hook_bottom', 'mfn_footer_content' );

function mfn_footer_content(){
	if( mfn_opts_get('sticky-shop-menu') == 1 && function_exists('is_woocommerce') ){
		get_template_part('includes/footer-stickymenu');
	}
}

/**
 *	WooCommerce | Image Zoom Remove
 */

function remove_image_zoom_support() {
	$tmp_id = mfn_ID();
	if(isset($tmp_id) && is_numeric($tmp_id) && get_post_status($tmp_id) == 'publish' && get_post_type($tmp_id) == 'template' && get_post_meta($tmp_id, 'mfn_template_product_image_zoom', true) == 0 ){
    	remove_theme_support( 'wc-product-gallery-zoom' );
	}
}
add_action( 'wp', 'remove_image_zoom_support', 100 );

/**
 *	WooCommerce | Change number of related products on product page
 */

if (! function_exists('mfn_woo_related_products_args')) {
	function mfn_woo_related_products_args($args)
	{
		$args['posts_per_page'] = intval(mfn_opts_get('shop-related', 3));
		return $args;
	}
}
add_filter('woocommerce_output_related_products_args', 'mfn_woo_related_products_args');

/**
 *	WooCommerce | Ensure cart contents update when products are added to the cart via AJAX
 */

if ( ! function_exists( 'woocommerce_header_add_to_cart_fragment' ) ) {
	function woocommerce_header_add_to_cart_fragment( $fragments ){
		global $woocommerce;
		$total = WC()->cart->get_cart_contents_count();
		if(mfn_opts_get('shop-icon-count-if-zero') == 0 && $total == 0){
			$fragments['.header-cart-count'] = '';
			$fragments['.header-cart-total'] = '';
			return $fragments;
		}

		ob_start();
		echo '<span class="header-cart-count">'. esc_html( $total ) .'</span>';
		$fragments['.header-cart-count'] = ob_get_clean();

		ob_start();
		echo '<p class="header-cart-total">'. wp_strip_all_tags( wp_kses_post( WC()->cart->get_cart_subtotal() ) ) .'</p>';
		$fragments['.header-cart-total'] = ob_get_clean();

		return $fragments;
	}
}

add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

/**
 *	WooCommerce | Excerpt in loop
 */

add_action( 'woocommerce_after_shop_loop_item_title', 'mfn_append_excerpt_loop', 5 );

function mfn_append_excerpt_loop(){
	global $product;
	$excerpt = mfn_opts_get( 'shop-excerpt' );
	if( $excerpt ){
		echo '<div class="excerpt excerpt-'. esc_attr($excerpt) .'">'. apply_filters( 'woocommerce_short_description', get_the_excerpt( $product->get_id() ) ) .'</div>';
	}
}

/**
 *	WooCommerce | Wishlist
 */

$wishlist_position = mfn_opts_get('shop-wishlist-position');

if( mfn_opts_get('shop-wishlist') && isset($wishlist_position[0]) ){
	add_action( 'woocommerce_after_add_to_cart_button', 'mfn_append_wishlist_button' );
	add_action( 'woocommerce_after_shop_loop_item', 'mfn_append_wishlist_button' );
}
function mfn_append_wishlist_button(){
	global $product;
	$translate['translate-add-to-wishlist'] = mfn_opts_get('translate') ? mfn_opts_get('translate-add-to-wishlist', 'Add to wishlist') : __('Add to wishlist', 'betheme');
	echo '<a href="#" data-id="'.$product->get_id().'" class="mfn-wish-button"><svg width="26" viewBox="0 0 26 26" aria-label="Add to wishlist"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></a>';
}

/**
 * WooCommerce | Additional Attributes Fields
 */

function mfn_woo_attr_types() {
	return array( 'select', 'label', 'color', 'image' );
}

/**
 * WooCommerce | Additional Attributes Fields
 */

function mfn_action_woocommerce_after_attr_form() {
	if( mfn_opts_get('variable-swatches') == 0 ){
		return;
	}
	$value = 'select';
	$types = mfn_woo_attr_types();
	$field_name = 'mfn_attr_display_type';
	$field_label = 'Display Type';
	if( !empty($_GET['edit']) ){
		$taxonomies = wc_get_attribute_taxonomies();
		if(isset($taxonomies) && count($taxonomies) > 0){
			foreach($taxonomies as $tx){
				if($tx->attribute_id == $_GET['edit']) $value = $tx->attribute_type;
			}
		}
		$show_in_loop = get_option('attr_loop_'.$_GET['edit']);
		echo '<tr class="form-field"><th valign="top" scope="row"><label for="mfn_attr_display">'.$field_label.'</label></th><td><select id="mfn_attr_display" name="'.$field_name.'">';
	    foreach($types as $t){ echo '<option '.( isset($value) && $value == $t ? "selected" : null ).' value="'.$t.'">'.ucfirst($t).'</option>'; }
	    echo '</select></td></tr>';

	    echo '<tr class="form-field"><th valign="top" scope="row"><label for="mfn_attribute_showloop"><input name="mfn_attribute_showloop" id="mfn_attribute_showloop" '.( $show_in_loop && $show_in_loop == 1 ? "checked" : null ).' type="checkbox" value="1"> Show in loop?</label></th><td><p class="description">Enable this if you want to display this attribute in products archives.</p></td></tr>';
	}else{
    	echo '<div class="form-field"><label for="mfn_attr_display">'.$field_label.'</label><select id="mfn_attr_display" name="'.$field_name.'">';
        foreach($types as $t){ echo '<option '.( isset($value) && $value == $t ? "selected" : null ).' value="'.$t.'">'.ucfirst($t).'</option>'; }
       	echo '</select></div>';
       	echo '<div class="form-field"><label for="mfn_attribute_showloop"><input name="mfn_attribute_showloop" id="mfn_attribute_showloop" type="checkbox" value="1"> Show in loop?</label><p class="description">Enable this if you want to display this attribute in products archives.</p></div>';
	}
}

add_action( 'woocommerce_after_edit_attribute_fields', 'mfn_action_woocommerce_after_attr_form', 10, 0 );
add_action( 'woocommerce_after_add_attribute_fields', 'mfn_action_woocommerce_after_attr_form' );

/**
 * WooCommerce | Additional Attributes Fields Save
 */

function mfn_save_attr_display_type( $id ) {

	if( mfn_opts_get('variable-swatches') == 0 ){
		return;
	}

	global $wpdb;
    if ( is_admin() && isset( $_POST['mfn_attr_display_type'] ) && in_array( $_POST['mfn_attr_display_type'], array('select', 'label', 'color', 'image') ) ) {
        $wpdb->update(
        	$wpdb->prefix . 'woocommerce_attribute_taxonomies',
        	array( 'attribute_type' => $_POST['mfn_attr_display_type'] ),
        	array( 'attribute_id' => $id ),
        	array('%s'),
        	array('%d')
        );
        if( !empty($_POST['mfn_attribute_showloop']) ){
        	update_option( 'attr_loop_'.$id, '1');
        }else{
        	delete_option( 'attr_loop_'.$id );
        }
    }
}

add_action( 'woocommerce_attribute_deleted', 'mfn_woo_attribute_deleted', 10, 3 );

function mfn_woo_attribute_deleted( $attribute_id ) {
    delete_option( 'attr_loop_'.$attribute_id );
};

add_action( 'woocommerce_attribute_added', 'mfn_save_attr_display_type' );
add_action( 'woocommerce_attribute_updated', 'mfn_save_attr_display_type' );

/**
 * WooCommerce | Display Attributes
*/

if ( ! mfn_opts_get('shop-catalogue') ) {
	add_action( 'woocommerce_after_shop_loop_item_title',  'mfn_display_custom_attributes_loop', 5 );
}

add_action( 'woocommerce_before_variations_form', 'mfn_display_custom_attributes_single' );

function mfn_display_custom_attributes_single(){
	global $product;
	mfn_display_custom_attributes($product, true);
}

function mfn_display_custom_attributes_loop($p = false){
	if($p){
		$product = wc_get_product( $p );
	}else{
		$product = wc_get_product( get_the_ID() );
	}
	mfn_display_custom_attributes($product, false);
}

function mfn_display_custom_attributes($p, $show = false){
	if( !mfn_opts_get('variable-swatches') || mfn_opts_get('shop-catalogue') ) return;

	$product = wc_get_product( $p );
	$product_attributes = $product->get_attributes();

	if ( $product->is_type( 'variable' ) ):

	// prevents empty variations
	if( isset($product_attributes) && is_iterable($product_attributes) ){
		foreach ($product_attributes as $prodatr) {
			if( isset( $prodatr['options'] ) && count($prodatr['options']) == 0 ){
				return false;
			}
		}
	}

	$taxonomies = wc_get_attribute_taxonomies();

	$class = 'mfn-variations-wrapper-loop';
	if( $show ) {
		$class = 'mfn-variations-wrapper';
	}

	$display_arr = get_post_meta( $product->get_id(), '_product_attributes', true );

	echo '<div class="'.$class.'">';

	if(isset($display_arr) && is_iterable($display_arr)){

	foreach($display_arr as $a=>$atr){

		if( $atr['is_variation'] == 0){
			continue;
		}

		$loop_enabled = 0;
		$display_type = 'select';


		$atr_slug = str_replace('attribute_', '', $a);
		$atr_id = wc_attribute_taxonomy_id_by_name( $atr_slug );


		if( $atr['is_taxonomy'] == 1 ){

			// if not custom
			if(isset($taxonomies) && count($taxonomies) > 0){
				foreach($taxonomies as $tx){
					if($tx->attribute_id == $atr_id) {
						$display_type = $tx->attribute_type;
						$loop_enabled = get_option( 'attr_loop_'.$tx->attribute_id );
					}
				}
			}

			if( !$show && $loop_enabled == 0 ) continue;

			if( empty($atr[0]) ){
				$atr = wc_get_product_terms( $product->get_id(), $atr['name'], array( 'fields' => 'names' ));
			}

		}else if( isset($atr['value']) && !empty($atr['value']) ){
			$atr = explode('|', $atr['value']);
		}

		echo '<div class="mfn-vr">';
			echo '<label>'.wc_attribute_label($atr_slug, $product).'</label>';
			switch ($display_type) {
				case 'label':
					echo '<ul class="mfn-vr-options attribute_'.$atr_slug.' mfn-vr-labels" data-atr="'.$atr_slug.'">';
						foreach($atr as $item){
							$atr_item = get_term_by('slug', $item, $atr_slug);
							if( !isset($atr_item->name) ) $atr_item = get_term_by('name', $item, $atr_slug);

							if(isset($atr_item->name)){
							echo '<li class="attr_'.esc_attr($atr_item->slug).'"><a href="'.get_the_permalink($product->get_id()).'?'.$a.'='.$atr_item->slug.'" data-id="'.esc_attr($atr_item->slug).'">'.esc_html($atr_item->name).'</a></li>';
							}
						}
					echo '</ul>';
					break;
				case 'color':
					echo '<ul class="mfn-vr-options attribute_'.$atr_slug.' mfn-vr-color" data-atr="'.$atr_slug.'">';
						foreach($atr as $item){
							$atr_item = get_term_by('slug', $item, $atr_slug);
							if( !isset($atr_item->name) ) $atr_item = get_term_by('name', $item, $atr_slug);
							if(isset($atr_item->name)){
							$mfn_value = get_term_meta($atr_item->term_id, 'mfn_attr_field', true);
							//if( !isset($mfn_value) || empty($mfn_value) || ( isset($mfn_value) && strpos('#', $mfn_value) === false ) ) $mfn_value = ''; // no color
							echo '<li class="attr_'.esc_attr($atr_item->slug).' tooltip tooltip-txt" data-tooltip="'.esc_html($atr_item->name).'"><a href="'.get_the_permalink($product->get_id()).'?'.$a.'='.$atr_item->slug.'" data-id="'.$atr_item->slug.'"><span style="background-color: '.$mfn_value.';"></span></a></li>';
							}
						}
					echo '</ul>';
					break;
				case 'image':
					echo '<ul class="mfn-vr-options attribute_'.$atr_slug.' mfn-vr-image" data-atr="'.$atr_slug.'">';
						foreach($atr as $item){
							$atr_item = get_term_by('slug', $item, $atr_slug);
							if( !isset($atr_item->name) ) $atr_item = get_term_by('name', $item, $atr_slug);
							if(isset($atr_item->name)){
							$mfn_value = get_term_meta($atr_item->term_id, 'mfn_attr_field', true);
							echo '<li class="attr_'.esc_attr($atr_item->slug).' tooltip tooltip-txt" data-tooltip="'.esc_html($atr_item->name).'"><a href="'.get_the_permalink($product->get_id()).'?'.$a.'='.$atr_item->slug.'" data-id="'.$atr_item->slug.'">'.wp_get_attachment_image($mfn_value, 'thumbnail').'</a></li>';
							}
						}
					echo '</ul>';
					break;
				default:
					echo '<select class="mfn-vr-select attribute_'.$atr_slug.'" data-atr="'.$atr_slug.'">';
						echo '<option data-link="" value="">'.__('Choose an option', 'woocommerce').'</option>';
						foreach($atr as $item){
							$atr_item = get_term_by('name', $item, $atr_slug);
							if( !isset($atr_item->name) ) $atr_item = get_term_by('name', $item, $atr_slug);
							if(isset($atr_item->slug)){
								echo '<option data-link="'.get_the_permalink($product->get_id()).'?'.$a.'='.$atr_item->slug.'" value="'.esc_attr($atr_item->slug).'">'.esc_html($atr_item->name).'</option>';
							}else{
								echo '<option data-link="'.get_the_permalink($product->get_id()).'?'.$a.'='.trim($item).'" value="'.esc_attr(trim($item)).'">'.esc_html(trim($item)).'</option>';
							}
						}
					echo '</select>';
					break;
			}
		echo '</div>';
	}

	}
	echo '</div>';

	endif;
}

/**
 * WooCommerce | Configure Terms
 */

add_action('admin_init', 'mfn_add_product_taxonomy_meta');

function mfn_add_product_taxonomy_meta(){
	if( mfn_opts_get('variable-swatches') == 0 ){
		return;
	}
	$attr_taxonomies = wc_get_attribute_taxonomies();
	if(count($attr_taxonomies) > 0){
		foreach($attr_taxonomies as $attr){
			if( in_array($attr->attribute_type, array('color', 'image') )){
				add_action( 'pa_'.$attr->attribute_name.'_edit_form_fields', 'mfn_edit_tax_attr_form_fields' );
				add_action( 'pa_'.$attr->attribute_name.'_add_form_fields', 'mfn_edit_tax_attr_form_fields' );

				add_action( 'saved_pa_'.$attr->attribute_name, 'mfn_saved_product_attr' );
				add_action( "create_pa_".$attr->attribute_name, 'mfn_saved_product_attr' );
			}
		}
	}
}

function mfn_edit_tax_attr_form_fields ($tag) {

	if( mfn_opts_get('variable-swatches') == 0 ) {
		return;
	}

	$current_value = '';

	if(isset( $tag->taxonomy )) {
		$current = $tag->taxonomy;
		$current_value = get_term_meta($tag->term_id, 'mfn_attr_field', true);
	}else{
		$current = $tag;
	}

	$placeholder_url = get_theme_file_uri( '/muffin-options/svg/placeholders/image.svg' );
	wp_enqueue_media();

    $attr_taxonomies = wc_get_attribute_taxonomies();
	if(count($attr_taxonomies) > 0){ foreach($attr_taxonomies as $attr){ if( $attr->attribute_name == str_replace('pa_', '', $current) ){ $current_obj = $attr; } } }

    $field_label = 'Choose '.$current_obj->attribute_type;
    $field_name = 'mfn_tax_field_'.$current_obj->attribute_type;

    if(isset( $tag->taxonomy )){ ?>
	<tr class="form-field mfn-tax-image">
        <th valign="top" scope="row"><label for="mfn_tax_field"><?php echo $field_label; ?></label></th>
        <td><input type="<?php echo $current_obj->attribute_type == 'color' ? 'text' : 'hidden'; ?>" id="mfn_tax_field" value="<?php echo $current_value; ?>" name="mfn_tax_field" class="<?php echo $field_name; ?>" required>
        	<?php if($current_obj->attribute_type == 'image'){
        		$current_value = wp_get_attachment_url($current_value); ?>
				<div class="mfn-custom-img-container">
				    <img data-src="<?php echo $placeholder_url; ?>" src="<?php if ( $current_value ) : echo $current_value; else: echo $placeholder_url; endif; ?>" alt="" style="max-width:100%;" />
					<a class="upload-custom-img button" href="#"><?php _e('Set custom image') ?></a>
					<a class="delete-custom-img button <?php if ( ! $current_value ) { echo 'hidden'; } ?>" href="#"><?php _e('Remove image') ?></a>
				</div>
			<?php } ?>
        </td>
    </tr>
    <?php
	}else{ ?>
		<div class="form-field mfn-tax-image">
	        <label for="mfn_tax_field"><?php echo $field_label; ?></label>
	        <input type="<?php echo $current_obj->attribute_type == 'color' ? 'text' : 'hidden'; ?>" id="mfn_tax_field" value="<?php echo $current_value; ?>" name="mfn_tax_field" class="<?php echo $field_name; ?>" required>
	        <?php if($current_obj->attribute_type == 'image'){
	        	$current_value = wp_get_attachment_url($current_value); ?>
				<div class="mfn-custom-img-container">
				    <img data-src="<?php echo $placeholder_url; ?>" src="<?php if ( $current_value ) : echo $current_value; else: echo $placeholder_url; endif; ?>" alt="" style="max-width:100%;" />
					<a class="upload-custom-img button <?php if ( $current_value  ) { echo 'hidden'; } ?>" href="#"><?php _e('Set custom image') ?></a>
					<a class="delete-custom-img button <?php if ( ! $current_value ) { echo 'hidden'; } ?>" href="#"><?php _e('Remove image') ?></a>
				</div>
			<?php } ?>
    	</div>
	<?php }
}

function mfn_saved_product_attr($term_id){
	if( mfn_opts_get('variable-swatches') == 0 ){
		return;
	}

	if( isset( $_POST['mfn_tax_field']) ){
		update_term_meta( $term_id, 'mfn_attr_field', $_POST['mfn_tax_field'] );
	}
}

function mfn_get_woo_sidecart_content(){

	if(WC()->cart->get_cart()){
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

		$classes = array('mfn-ch-product');
		if(isset( $cart_item['mnm_container'] )) $classes[] = 'mfn-sidecart-subproduct';

		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key ); ?>

		<div class="<?php echo implode(' ', $classes); ?>" data-row-key="<?php echo $cart_item_key; ?>" data-product-id="<?php echo $product_id; ?>">
			<div class="mfn-chp-col mfn-chp-image">
				<?php
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				echo '<a href="'.$_product->get_permalink().'">'.$thumbnail.'</a>';
				?>
			</div>
			<div class="mfn-chp-col mfn-chp-info">
				<h6><a href="<?php echo $_product->get_permalink(); ?>"><?php echo $_product->get_name(); ?></a></h6>
				<?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
				echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
				?>
				<p class="price"><?php esc_html_e( 'Price', 'woocommerce' ); ?>: <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></p>
			</div>
			<div class="mfn-chp-col align_right mfn-chp-price">
				<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
			</div>
			<div class="mfn-chp-footer">
				<div class="mfn-chpf-col mfn-chpf-left">
					<div class="mfn-chp-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $_product->get_max_purchase_quantity(),
										'min_value'    => '0',
										'product_name' => $_product->get_name(),
									),
									$_product,
									false
								);
							}
							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</div>
				</div>
				<div class="mfn-chpf-col mfn-chpf-right"><a href="#" data-id="<?php echo $product_id; ?>" class="mfn-chp-remove"><i class="icon-trash-line" aria-hidden="true"></i> <?php _e('Remove', 'woocommerce'); ?></a></div>
			</div>
		</div>

		<?php }
	}else{ ?>
		<div class="cart-empty">
			<p class="cart-empty-icon">
			<?php if(mfn_opts_get('shop-cart')): echo '<i class=" '.mfn_opts_get('shop-cart'). '"></i>'; else: echo '<svg width="26" viewBox="0 0 26 26" aria-hidden="true"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"/><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"/></svg>'; endif; ?>
			</p>
			<p><?php _e('Your cart is currently empty.', 'woocommerce'); ?></p>
		</div>
	<?php
	}
}

function mfn_get_woo_sidecart_footer(){
	//WC()->cart->calculate_totals();

	$is_translatable = mfn_opts_get('translate');
	$translate['translate-side-cart-shipping-free'] = $is_translatable ? mfn_opts_get('translate-side-cart-shipping-free', 'Free!') : __('Free!', 'woocommerce');

	// output ---

	echo '<div class="mfn-chft-row mfn-chft-subtotal">'.__( 'Subtotal', 'woocommerce' ).': '; wc_cart_totals_subtotal_html(); echo '</div>';
	if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) :

		$total = esc_html($translate['translate-side-cart-shipping-free']);

	    if ( 0 < WC()->cart->get_shipping_total() ) {

	      if ( WC()->cart->display_prices_including_tax() ) {
	        $total = wc_price( WC()->cart->shipping_total + WC()->cart->shipping_tax_total );

	        if ( WC()->cart->shipping_tax_total > 0 && ! wc_prices_include_tax() ) {
	          $total .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
	        }
	      } else {
	        $total = wc_price( WC()->cart->shipping_total );

	        if ( WC()->cart->shipping_tax_total > 0 && wc_prices_include_tax() ) {
	          $total .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
	        }
	      }
	    }

		echo '<div class="mfn-chft-row mfn-chft-row-shipping">'.__( 'Shipping', 'woocommerce' ).': <span>'. $total .'</span></div>';
	endif;
	echo '<div class="mfn-chft-row mfn-chft-total">'.__( 'Total', 'woocommerce' ).': '; wc_cart_totals_order_total_html(); echo '</div>';
}

// fix for ajax & wcml
add_filter( 'wcml_multi_currency_ajax_actions', 'mfn_add_action_to_multi_currency_ajax', 10, 1 );
function mfn_add_action_to_multi_currency_ajax( $ajax_actions ) {
    $ajax_actions[] = 'mfnrefreshcart'; // Add a AJAX action to the array
    return $ajax_actions;
}

add_action( 'wp_ajax_mfnrefreshcart', 'mfn_refreshsidecart' );
add_action( 'wp_ajax_nopriv_mfnrefreshcart', 'mfn_refreshsidecart' );

function mfn_refreshsidecart(){
	check_ajax_referer( 'mfn-woo-nonce', 'mfn-woo-nonce' );
	$return = array();

	/*if ( is_plugin_active( 'woocommerce-payments/woocommerce-payments.php' ) ) {
		$mc = \WCPay\MultiCurrency\MultiCurrency::instance();
		$mc->init();
	}*/

	WC()->cart->calculate_totals();

	ob_start();
	mfn_get_woo_sidecart_content();
	$return['content'] = ob_get_clean();

	ob_start();
	mfn_get_woo_sidecart_footer();
	$return['footer'] = ob_get_clean();

	$return['total'] = WC()->cart->get_cart_contents_count();

	wp_send_json($return);
	wp_die();
}

add_action( 'wp_ajax_mfnremovewooproduct', 'mfn_removefromcart' );
add_action( 'wp_ajax_nopriv_mfnremovewooproduct', 'mfn_removefromcart' );

function mfn_removefromcart() {
	check_ajax_referer( 'mfn-woo-nonce', 'mfn-woo-nonce' );
	$id = $_POST['pid'];
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	     if ( $cart_item_key == $id ) {
	          WC()->cart->remove_cart_item( $cart_item_key );
	     }
	}
	wp_die();
}

add_action( 'wp_ajax_mfnchangeqtyproduct', 'mfn_qtyproductcart' );
add_action( 'wp_ajax_nopriv_mfnchangeqtyproduct', 'mfn_qtyproductcart' );

function mfn_qtyproductcart() {
	check_ajax_referer( 'mfn-woo-nonce', 'mfn-woo-nonce' );
	$id = $_POST['pid'];
	$qty = $_POST['qty'];

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	     if ( $cart_item_key == $id ) {
	          WC()->cart->set_quantity($cart_item_key, $qty);
	     }
	}

	wp_die();
}

add_action( 'wp_ajax_mfnproductquickview', 'mfn_quickview' );
add_action( 'wp_ajax_nopriv_mfnproductquickview', 'mfn_quickview' );

function mfn_quickview() {
	check_ajax_referer( 'mfn-woo-nonce', 'mfn-woo-nonce' );
	$id = $_POST['id'];

	ob_start();
	get_template_part( 'includes/quickview', '', array('id' => $id) );
	$return = ob_get_clean();

	wp_send_json($return);
	wp_die();
}


function mfn_woo_attr_filter( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {

    	if( !empty($_GET['mfn_attr_filter']) ){

    		// filters woocommerce attributes

	    	unset($_GET['mfn_attr_filter']);
	    	$taxquery = array('relation' => 'AND');

	    	foreach($_GET as $f=>$filter){
	    		if( strpos($f, 'mfn_') !== false ){
	        		$taxquery[] =array(
			            'taxonomy' => str_replace('mfn_', '', $f),
			            'field' => 'slug',
			            'terms' => $filter,
			            'operator'=> 'IN'
				    );
	        }
	    	}
	      $query->set( 'tax_query', $taxquery );
	    }
    }
}

add_action( 'pre_get_posts', 'mfn_woo_attr_filter' );

add_action('woocommerce_before_shop_loop', 'mfn_woo_products_list_filter_wrapper_start', 5);
function mfn_woo_products_list_filter_wrapper_start() {
	$class = '';
	if(mfn_opts_get('shop-list-perpage') == 1 || mfn_opts_get('shop-list-layout') == 1){
		$class .= ' mfn-additional-shop-options-active';
	}

	echo '<div class="mfn-woo-filters-wrapper shop-filters'.$class.'">';
}

if( mfn_opts_get('shop-list-sorting') == 0 ){
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}
if( mfn_opts_get('shop-list-results-count') == 0 ){
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
}

add_action('woocommerce_before_shop_loop', 'mfn_woo_products_list_options', 20);
function mfn_woo_products_list_options(){
	if(mfn_opts_get('shop-list-perpage') == 1 || mfn_opts_get('shop-list-layout') == 1) get_template_part('includes/woocommerce-list-options');
}

add_action('woocommerce_before_shop_loop', 'mfn_woo_products_list_filter_wrapper_end', 35);
function mfn_woo_products_list_filter_wrapper_end() {

	$sidebar = mfn_sidebar(true);

	$translate['translate-shop-filters'] = mfn_opts_get('translate') ? mfn_opts_get('translate-shop-filters', 'Filters') : __('Filters', 'woocommerce');

	if( ( mfn_opts_get('mobile-sidebar') == 1 || isset($sidebar['layout']) && $sidebar['layout'] == 'offcanvas-sidebar' ) && ( isset( $sidebar['sidebar']['first'] ) || isset( $sidebar['sidebar']['second'] ) ) ){
		echo '<a class="open-filters mfn-off-canvas-switcher '. ( !isset($sidebar['layout']) || $sidebar['layout'] != 'offcanvas-sidebar' ? 'mfn-only-mobile-ofcs' : null ) .'" href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-label="Offcanvas sidebar icon"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;}</style></defs><g><line x1="8" y1="11" x2="14" y2="11" class="path"/><line x1="2" y1="11" x2="4" y2="11" class="path"/><line x1="12" y1="5" x2="14" y2="5" class="path"/><line x1="2" y1="5" x2="8" y2="5" class="path"/><circle cx="6" cy="11" r="2" class="path"/><circle cx="10" cy="5" r="2" class="path"/></g></svg>';
			echo $translate['translate-shop-filters'];
		echo '</a>';
	}

	echo '</div>';

	if(mfn_opts_get('shop-list-active-filters') == 1) {
		get_template_part('includes/woocommerce-active-filters');
	}

}

if (! function_exists('mfn_woo_per_page')) {
	function mfn_woo_per_page($cols){
		return mfn_get_per_page();
	}
}
add_filter('loop_shop_per_page', 'mfn_woo_per_page', 20);

add_filter( 'woocommerce_product_single_add_to_cart_text', 'mfn_template_single_add_to_cart_text' );
function mfn_template_single_add_to_cart_text() {
	global $product;
	$tmp_id = mfn_ID();

	if( method_exists($product,'get_id') && get_post_meta($product->get_id(), '_button_text', true)){
		return get_post_meta($product->get_id(), '_button_text', true);
	}else{
		if(isset($tmp_id) && is_numeric($tmp_id) && get_post_status($tmp_id) == 'publish' && get_post_type($tmp_id) == 'template' && !empty(get_post_meta($tmp_id, 'mfn_cart_button', true)) ){
			return get_post_meta($tmp_id, 'mfn_cart_button', true);
		}
		return __( 'Add to cart', 'woocommerce' );
	}
}

add_filter( 'woocommerce_product_tabs', 'mfn_woo_description_tab' );
function mfn_woo_description_tab( $tabs ) {

	global $post;

	$content = get_post_field( 'post_content', $post->ID );
	$content = apply_filters( 'the_content', $content );
	$builder = get_post_meta( $post->ID, 'mfn-page-items', true );

	if( $content || $builder ){
		$tabs['description']['title'] = __( 'Description', 'woocommerce' );
		$tabs['description']['priority'] = 10;
		$tabs['description']['callback'] = 'mfn_woo_description_callback';
	}

	return $tabs;
}

function mfn_woo_description_callback() {
	wc_get_template( 'single-product/tabs/description.php' );
}

add_action( 'mfn_after_content', 'mfn_display_wishlist' );

function mfn_display_wishlist(){
	if(function_exists('is_woocommerce') && mfn_opts_get('shop-wishlist-page') && mfn_opts_get('shop-wishlist-page') == get_the_ID()) get_template_part('includes/wishlist');
}

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// before and after div in cart
add_action('mfn_before_content', 'mfn_carts_page_before');
function mfn_carts_page_before() {

	if( is_cart() ){
		$step = 1;
	}elseif( is_wc_endpoint_url( 'order-received' ) ){
		$step = 3;
	}elseif( is_checkout() ){
		$step = 2;
	}

	if( is_cart() || is_checkout() || is_wc_endpoint_url( 'order-received' ) ){
		echo '<div class="mfn-cart-step mfn-cart-step-'.$step.'">';
		echo '<div class="section_wrapper clearfix"><div class="the_content_wrapper">
			<ul class="mfn-checkout-steps">
				<li '.( isset($step) && $step >= 1 ? 'class="active"' : null ).'><span class="mfn-step-number">'.($step > 1 ? '<i class="icon-check" aria-hidden="true"></i>' : 1).'</span> '. __( 'Cart', 'woocommerce' ) .'</li>
				<li '.( isset($step) && $step >= 2 ? 'class="active"' : null ).'><span class="mfn-step-number">'.($step > 2 ? '<i class="icon-check" aria-hidden="true"></i>' : 2).'</span> '. __( 'Checkout', 'woocommerce' ) .'</li>
				<li '.( isset($step) && $step == 3 ? 'class="active"' : null ).'><span class="mfn-step-number">'.($step == 3 ? '<i class="icon-check" aria-hidden="true"></i>' : 3).'</span> '. __( 'Order', 'woocommerce' ) .'</li>
			</ul>
		</div></div>';
	}

}

add_action('mfn_after_content', 'mfn_carts_page_after');
function mfn_carts_page_after() {
	if( is_cart() || is_checkout() || is_wc_endpoint_url( 'order-received' ) ){
		echo '</div>';
	}
}

add_action('woocommerce_after_cart_totals', 'mfn_continue_shippping_link');
function mfn_continue_shippping_link(){
	echo '<a href="'.get_permalink( wc_get_page_id( 'shop' ) ).'" class="mfn-woo-cart-link">'. __('Continue shopping', 'woocommerce') .'</a>';
}

add_action('woocommerce_review_order_after_submit', 'mfn_return_cart_link');
function mfn_return_cart_link(){
	echo '<a href="'.get_permalink( wc_get_page_id( 'cart' ) ).'" class="mfn-woo-cart-link">'. __('Return to cart', 'woocommerce') .'</a>';
}

// add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'mfn_woo_ajax_add_to_cart_single');
// add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'mfn_woo_ajax_add_to_cart_single');

function mfn_woo_ajax_add_to_cart_single() {

	_deprecated_function( 'mfn_woo_ajax_add_to_cart_single', '25.1.5', 'WC_AJAX::add_to_cart()' );

	global $woocommerce;
	$before_add = $_POST['current_cart'];
    $product_id = $_POST['product_id'];

    WC()->cart->add_to_cart();

    $after_add = $woocommerce->cart->cart_contents_count;

    if( $after_add == $before_add ){
    	return wp_send_json('error');
    }

    WC_AJAX :: get_refreshed_fragments();

    wp_die();
}

add_action( 'mfn_product_image', 'mfn_new_badge_woo_product', 3 );

function mfn_new_badge_woo_product() {
	if(mfn_opts_get('product-badge-new') == 1){
		global $product;
		$newness_days = mfn_opts_get('product-badge-new-days') ? mfn_opts_get('product-badge-new-days') : 14;
		$created = strtotime( $product->get_date_created() );
		$label = mfn_opts_get('product-badge-new-text', __( 'NEW', 'woocommerce' ));
		if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
		  echo '<span class="mfn-new-badge onsale-label onsale">' . esc_html( $label ) . '</span>';
		}
	}
}

function mfn_get_per_page( $from_panel = false ){
	$tmp_id = mfn_ID();
	$perpage = filter_input(INPUT_GET, 'per_page', FILTER_SANITIZE_NUMBER_INT);

	if( isset($perpage) && !$from_panel ){
		return absint($perpage);
	}else if(isset($tmp_id) && is_numeric($tmp_id) && get_post_status($tmp_id) == 'publish' && get_post_type($tmp_id) == 'template' && '' !== get_post_meta($tmp_id, 'mfn_template_perpage', true) && get_post_meta($tmp_id, 'mfn_template_perpage', true) > 0 ){
		// if is template
		return absint(get_post_meta($tmp_id, 'mfn_template_perpage', true));
	}else{
		// theme options
		return absint(mfn_opts_get('shop-products', 12));
	}
}

function mfn_get_layout( $from_panel = false ){
	if( ! empty( $_GET['mfn-shop'] ) ){
		$shop_layout = esc_html( $_GET['mfn-shop'] ); // demo
	} else {
		$shop_layout = mfn_opts_get( 'shop-layout', 'grid' );
	}

	return $shop_layout;
}

function mfn_product_cat_content_form_fields( $array ) {
	$field_name_1 = 'mfn_prod_cat_top_content';
	$field_label_1 = 'Top Content';
	$field_name_2 = 'mfn_prod_cat_bottom_content';
	$field_label_2 = 'Bottom Content';


    if( !empty($_GET['taxonomy']) && !empty($_GET['tag_ID']) && $_GET['taxonomy'] == 'product_cat' ){

    	$val_1 = get_term_meta($_GET['tag_ID'], 'mfn_product_cat_top_content', true);
    	$val_2 = get_term_meta($_GET['tag_ID'], 'mfn_product_cat_bottom_content', true);

		echo '<tr class="form-field"><th valign="top" scope="row"><label for="'.$field_name_1.'">'.$field_label_1.'</label></th><td><textarea rows="5" cols="40" id="'.$field_name_1.'" name="'.$field_name_1.'">'.$val_1.'</textarea><p class="description">Shortcodes are allowed. This will be displayed at the top of the category.</p></td></tr>';

	    echo '<tr class="form-field"><th valign="top" scope="row"><label for="'.$field_name_2.'">'.$field_label_2.'</label></th><td><textarea rows="5" cols="40" id="'.$field_name_2.'" name="'.$field_name_2.'">'.$val_2.'</textarea><p class="description">Shortcodes are allowed. This will be displayed at the bottom of the category.</p></td></tr>';
	}else{
    	echo '<div class="form-field"><label for="'.$field_name_1.'">'.$field_label_1.'</label><textarea rows="5" cols="40" id="'.$field_name_1.'" name="'.$field_name_1.'">';
       	echo '</textarea><p>Shortcodes are allowed. This will be displayed at the top of the category.</p></div>';
       	echo '<div class="form-field"><label for="'.$field_name_2.'">'.$field_label_2.'</label><textarea rows="5" cols="40" id="'.$field_name_2.'" name="'.$field_name_2.'">';
       	echo '</textarea><p>Shortcodes are allowed. This will be displayed at the bottom of the category.</p></div>';
	}
};
add_action( 'product_cat_add_form_fields', 'mfn_product_cat_content_form_fields');
add_action( 'product_cat_edit_form_fields', 'mfn_product_cat_content_form_fields', 10, 1 );

function mfn_save_product_cat_fields( $id ) {
	if(!empty($_POST['mfn_prod_cat_top_content'])){
		update_term_meta( $id, 'mfn_product_cat_top_content', $_POST['mfn_prod_cat_top_content'] );
	}else{
		delete_term_meta($id, 'mfn_product_cat_top_content');
	}
    if(!empty($_POST['mfn_prod_cat_bottom_content'])){
		update_term_meta( $id, 'mfn_product_cat_bottom_content', $_POST['mfn_prod_cat_bottom_content'] );
	}else{
		delete_term_meta($id, 'mfn_product_cat_bottom_content');
	}
};
add_action( 'saved_product_cat', 'mfn_save_product_cat_fields' );
add_action( 'create_product_cat', 'mfn_save_product_cat_fields' );

add_action('woocommerce_before_main_content', 'mfn_before_shop_content');
function mfn_before_shop_content() {
	if( is_product_category() ){
		$cat = get_queried_object();
		$top_content = get_term_meta($cat->term_id, 'mfn_product_cat_top_content', true);
		if(!empty($top_content)){
			echo do_shortcode($top_content);
		}
	}
}
add_action('woocommerce_after_main_content', 'mfn_after_shop_content', 5);
function mfn_after_shop_content() {
	if( is_product_category() ){
		$cat = get_queried_object();
		$bottom_content = get_term_meta($cat->term_id, 'mfn_product_cat_bottom_content', true);
		if(!empty($bottom_content)){
			echo do_shortcode($bottom_content);
		}
	}
}
