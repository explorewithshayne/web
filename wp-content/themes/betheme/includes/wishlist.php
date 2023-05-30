<?php
$wish_arr = array(0);

if( isset($_COOKIE['mfn_wishlist']) ){
  $wishlist = $_COOKIE['mfn_wishlist'];
  $wish_arr = explode(',', $wishlist);
}

$translate['translate-empty-wishlist'] = mfn_opts_get('translate') ? mfn_opts_get('translate-empty-wishlist', 'Your wishlist is empty.') : __('Your wishlist is empty.', 'betheme');

$wish_query = new WP_Query( array(
  'post_type' => 'product',
  'posts_per_page' => -1,
  'post__in'=> $wish_arr
) ); ?>

<div class="section wishlist woocommerce">
  <div class="section_wrapper clearfix">
    <?php if($wish_query->have_posts()): ?>

      <?php while($wish_query->have_posts()): $wish_query->the_post();
        $product = wc_get_product(get_the_ID());
      ?>
        <div class="wishlist-row">

          <div class="column one-fourth">
            <div class="mcb-column-inner">
              <?php echo Mfn_Builder_Woo_Helper::get_woo_product_image($product); ?>
            </div>
          </div>

          <div class="column one-second">
            <div class="mcb-column-inner">
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="price"><?php echo $product->get_price_html(); ?></p>
              <?php the_excerpt(); ?>
              <?php woocommerce_template_single_meta(); ?>
            </div>
          </div>

          <div class="column one-fourth wishlist-options">
            <div class="mcb-column-inner">
              <?php echo Mfn_Builder_Woo_Helper::get_woo_product_button( $product ); ?>
            </div>
          </div>

        </div>
      <?php endwhile; ?>

    <?php else: ?>

      <div class="wishlist-info">
        <h3><?php echo $translate['translate-empty-wishlist']; ?></h3>
        <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="button mfn-btn"><?php esc_html_e( 'Go to shop', 'woocommerce' ); ?></a>
      </div>

    <?php endif; ?>

    <div class="wishlist-info" style="display: none;">
      <h3><?php echo $translate['translate-empty-wishlist']; ?></h3>
      <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="button mfn-btn"><?php esc_html_e( 'Go to shop', 'woocommerce' ); ?></a>
    </div>

  </div>
</div>
