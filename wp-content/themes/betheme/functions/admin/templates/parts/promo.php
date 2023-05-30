<?php
  $banner = get_site_option( 'betheme_promo' );
?>

<?php if( $banner ): ?>

<ul class="slider-promo" data-version="<?php echo esc_attr( $this->promo_version ); ?>">
  <?php echo $banner; ?>
</ul>

<?php endif; ?>
