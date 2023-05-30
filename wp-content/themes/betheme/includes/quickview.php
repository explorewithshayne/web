<?php
	$product = wc_get_product($args['id']);
	$attachment_ids = $product->get_gallery_image_ids();
	setup_postdata($product->get_id());
?>

<div class="mfn-popup mfn-popup-940 mfn-popup-quickview woocommerce">
	<div class="mfn-popup-content">
		<span class="mfn-close-popup mfn-close-icon"><span class="icon">&#10005;</span></span>
		<div class="mfn-popup-content-wrapper product">

			<div class="mfn-popup-content-col mfn-popup-content-photos">
				<div class="mfn-quickview-slider">
					<div class="mfn-qs-one mfn-qs-one-first"><?php echo get_the_post_thumbnail($args['id'], 'large'); ?></div>
					<?php if(count($attachment_ids) > 0): foreach( $attachment_ids as $attachment_id ) { ?>
						<div class="mfn-qs-one"><?php echo wp_get_attachment_image($attachment_id, 'large'); ?></div>
				  <?php } endif; ?>
				</div>
			</div>

			<div class="mfn-popup-content-col mfn-popup-content-text">
        <div class="mfn-popup-content-text-wrapper">
            <h3 class="heading"><?php echo get_the_title($args['id']); ?></h3>
            <p class="price"><?php echo $product->get_price_html(); ?></p>
            <div class="excerpt">
              <?php echo apply_filters( 'the_excerpt', get_the_excerpt( $args['id'] ) ); ?>
            </div>
            <div class="mfn-product-add-to-cart">
              <?php
                /*$funname = 'woocommerce_'.$product->get_type().'_add_to_cart';
                $funname(); */
                call_user_func('woocommerce_'. $product->get_type() .'_add_to_cart');
              ?>
            </div>
            <?php echo sc_product_meta(array(), $product); ?>
        </div>
			</div>

		</div>
	</div>
</div>

<?php wp_reset_postdata(); ?>
