<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version		3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

// gallery

if( isset($_GET['mfn-demo-product-gallery']) ){
	$gallery_style = $_GET['mfn-demo-product-gallery'];
} else {
	$gallery_style = mfn_opts_get('shop-product-gallery');
}

if( isset($_GET['mfn-demo-product-gallery-overlay']) ){
	$gallery_overlay = 'mfn-thumbnails-'. $_GET['mfn-demo-product-gallery-overlay'];
} else {
	$gallery_overlay = mfn_opts_get('shop-product-gallery-overlay');
}

if( isset($_GET['mfn-demo-product-gallery-overlay']) && 'overlay' == $_GET['mfn-demo-product-gallery-overlay'] ){
	$thumbnails_margin = '15px';
	$main_margin = 'mfn-mim-15';
} else {
	$thumbnails_margin = mfn_opts_get( 'shop-product-thumbnails-margin', 0, ['unit'=>'px'] );
	$main_margin = mfn_opts_get( 'shop-product-main-image-margin', 'mfn-mim-0' );
}

// wishlist

$wishlist_position = mfn_opts_get('shop-wishlist-position');

// translate

$translate['translate-add-to-wishlist'] = mfn_opts_get('translate') ? mfn_opts_get('translate-add-to-wishlist', 'Add to wishlist') : __('Add to wishlist', 'betheme');

// output -----

if( 'mfn-gallery-grid' == $gallery_style ){
	$attachment_ids = $product->get_gallery_image_ids();

	if( $product->is_type( 'variable' ) ){
		$variations = $product->get_available_variations();
		if( is_array($variations) && count($variations) > 0 ){
			foreach($variations as $variation){

				if( $variation['variation_is_visible'] && !empty($variation['image_id']) && !in_array($variation['image_id'], $attachment_ids) ){
					$attachment_ids[] = $variation['image_id'];
				}

				// woocommerce plugin additional gallery
				if( $variation['variation_is_visible'] && !empty( get_post_meta($variation['variation_id'], '_wc_additional_variation_images', true) ) ){
					$explode_add_imgs = explode(',', get_post_meta($variation['variation_id'], '_wc_additional_variation_images', true));
					$attachment_ids = array_merge($attachment_ids, $explode_add_imgs);
				}

			}
		}
	}

	$count = $attachment_ids ? count($attachment_ids)+1 : 1;
?>

<style type="text/css">
	.woocommerce .mfn-product-gallery-grid{
		column-gap:<?php echo $thumbnails_margin; ?>;
	}
	.woocommerce .mfn-product-gg-img{
		margin-bottom:<?php echo $thumbnails_margin; ?>;
	}
</style>

<div class="mfn-product-gallery-grid mfn-product-gallery-<?php echo $count; ?>-images">
	<?php do_action('mfn_product_image'); ?>
	<?php wc_get_template( 'single-product/sale-flash.php'); ?>
	<?php if( mfn_opts_get('shop-wishlist') && isset($wishlist_position[1]) ){
		echo '<a href="#" data-id="'.$product->get_id().'" data-tooltip="'. $translate['translate-add-to-wishlist'] .'" data-position="left" class="mfn-wish-button tooltip tooltip-txt"><svg width="26" viewBox="0 0 26 26" aria-label="'. $translate['translate-add-to-wishlist'] .'"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></a>';
	} ?>
	<div class="mfn-product-gg-img" data-index="0">
		<a href="#" class="woocommerce-product-gallery__trigger"></a>
		<?php if(has_post_thumbnail()){ echo wc_get_gallery_image_html( get_post_thumbnail_id() ); }else{ echo wc_placeholder_img( 'shop_catalog' ); } ?>
	</div>
	<?php
	$a = 0;
	if(count($attachment_ids) > 0): foreach( $attachment_ids as $attachment_id ) { ?>
		<div class="mfn-product-gg-img" data-index="<?php echo ++$a; ?>">
			<a href="#" class="woocommerce-product-gallery__trigger"></a>
			<?php echo wc_get_gallery_image_html($attachment_id); ?>
		</div>
  <?php } endif; ?>
</div>

<?php } else {

wp_enqueue_script('mfn-swiper', get_theme_file_uri('/js/swiper.js'), array('jquery'), MFN_THEME_VERSION, true);

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = $product->get_image_id();
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
$html = '';
?>

<div class="<?php echo esc_attr( implode( ' ', array_map('sanitize_html_class', $wrapper_classes) ) ); ?> <?php if( !empty($gallery_style) ){ echo 'mfn-product-gallery '. esc_attr($gallery_style) .' '. esc_attr($gallery_overlay) .' '. esc_attr($main_margin); } ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

	<?php if( mfn_opts_get('shop-wishlist') && isset($wishlist_position[1]) ){
		echo '<span href="#" data-id="'.$product->get_id().'" data-tooltip="'. $translate['translate-add-to-wishlist'] .'" data-position="left" class="mfn-wish-button tooltip tooltip-txt"><svg width="26" viewBox="0 0 26 26" aria-label="'. $translate['translate-add-to-wishlist'] .'"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"></path></svg></span>';
	} ?>

	<figure class="woocommerce-product-gallery__wrapper" data-columns="<?php echo esc_attr( $columns ); ?>">

		<?php
			$attributes = array(
				'title'			=> get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'	=> get_post_field( 'post_excerpt', $post_thumbnail_id ),
			);

			if ( ! empty( $full_size_image ) ) {
				$attributes['data-src']                = $full_size_image[0];
				$attributes['data-large_image']        = $full_size_image[0];
				$attributes['data-large_image_width']  = $full_size_image[1];
				$attributes['data-large_image_height'] = $full_size_image[2];
			}

			if ( $product->get_image_id() ) {

				if( version_compare( WC_VERSION, '3.3.2', '<' ) ){

					// WC < 3.3.2 backward compatibility

					$html .= '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
					$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
					$html .= '</a></div>';

				} else {
					// WC 3.3.2+
					$html  .= wc_get_gallery_image_html( $post_thumbnail_id, true );
				}
			} else {
				$html .= '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped single image in gal
			do_action( 'woocommerce_product_thumbnails' );
		?>
		<?php wc_get_template( 'single-product/sale-flash.php'); ?>
		<?php do_action('mfn_product_image'); ?>
	</figure>

</div>

<?php } ?>
