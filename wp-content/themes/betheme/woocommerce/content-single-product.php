<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// post navigation, prev/next post

$post_navigation = array(
	'hide-header'	=> false,
	'hide-sticky'	=> false,
);

$post_navigation_options = mfn_opts_get( 'prev-next-nav' );

if( isset( $post_navigation_options['hide-header'] ) ){
	$post_navigation['hide-header'] = true;
}
if( isset( $post_navigation_options['hide-sticky'] ) ){
	$post_navigation['hide-sticky'] = true;
}

$post_prev = get_adjacent_post( false, '', true );
$post_next = get_adjacent_post( false, '', false );
$shop_page_id = wc_get_page_id( 'shop' );

// post classes

$classes = [];

// style

if( isset($_GET['mfn-demo-product']) ){
	$style = $_GET['mfn-demo-product']; // demo single product style
} else {
	$style = mfn_opts_get( 'shop-product-style' );
}

$classes[] = 'style-'. $style;

// column

$column = [
	'left' => 'one-second',
	'right' => 'one-second',
];

if( 'default' == $style ){
	$column['left'] = 'three-fifth';
	$column['right'] = 'two-fifth';
}

// share

if( 'hide-mobile' == mfn_opts_get( 'share' ) ){
	$classes[] = 'no-share-mobile';
} elseif( ! mfn_opts_get( 'share' ) ) {
	$classes[] = 'no-share';
}

if( mfn_opts_get( 'share-style' ) ){
	$classes[] = 'share-'. mfn_opts_get( 'share-style' );
}

// translate
$translate['all'] = mfn_opts_get( 'translate' ) ? mfn_opts_get( 'translate-all', 'Show all' ) : __( 'Show all', 'betheme' );

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( $classes, $product ); ?> >

	<?php

		// sticky navigation prev/next

		if( ! $post_navigation['hide-sticky'] ){
			echo mfn_post_navigation_sticky( $post_prev, 'prev', 'icon-left-open-big' );
			echo mfn_post_navigation_sticky( $post_next, 'next', 'icon-right-open-big' );
		}

		// header navigation

		if( ! $post_navigation['hide-header'] ){
			echo mfn_post_navigation_header( $post_prev, $post_next, $shop_page_id, $translate );
		}

	?>

	<div class="product_wrapper clearfix">

		<div class="product_image_wrapper column <?php esc_attr_e( $column['left'] ); ?>">
			<div class="mcb-column-inner clearfix">

				<?php
					/**
					 * woocommerce_before_single_product_summary hook.
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
				?>

			</div>
		</div>

		<div class="entry-summary column <?php esc_attr_e( $column['right'] ); ?>">
			<div class="mcb-column-inner">

				<?php

					if( 'default' == $style ){
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

						add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10);
						add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
					}

					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10 / style-default: 20
					 * @hooked woocommerce_template_single_excerpt - 20 / style-default: 10
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );

					// share

					echo mfn_share( 'footer' );

					// product content in right column

					if( in_array( $style, array( 'default', 'wide', 'wide tabs' ) ) ) {
						remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
					}

					// remove upsell and related from this action we will display them later

					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

					/**
					 * woocommerce_after_single_product_summary hook.
					 *
					 * @hooked woocommerce_output_product_data_tabs - 10
					 * @hooked woocommerce_upsell_display - 15
					 * @hooked woocommerce_output_related_products - 20
					 */
					do_action( 'woocommerce_after_single_product_summary' );

				?>

			</div>
		</div>

		<?php echo mfn_share( 'header' ); ?>

	</div>

	<?php

		// product content full width below image

		if( in_array( $style, array( 'default', 'wide', 'wide tabs' ) ) ) {
			woocommerce_output_product_data_tabs();
		}

	?>

	<?php

		// upsell and related products removed from woocommerce_after_single_product_summary

		woocommerce_upsell_display();

		if( mfn_opts_get( 'shop-related' ) ){
			woocommerce_output_related_products();
		}

	?>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
