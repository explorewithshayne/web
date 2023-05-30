<?php
$has_shop = false;
$has_user = false;
$has_cart = false;
$has_wishlist = false;

global $woocommerce;

// has shop

if( function_exists('is_woocommerce') ){
	$has_shop = true;
}

// shop icons hide

$shop_icons_hide = mfn_opts_get('shop-icons-hide');

// shop user

if( $has_shop && empty( $shop_icons_hide['user'] ) ){
	$has_user = true;
}

$user_icon = trim( mfn_opts_get('shop-user') );

// shop wishlist

if( $has_shop && empty( $shop_icons_hide['wishlist'] ) && mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-page') ){
	$has_wishlist = true;
}

$wishlist_icon = trim( mfn_opts_get('shop-icon-wishlist') );

// shop cart

if( $has_shop && empty( $shop_icons_hide['cart'] ) ){
	$has_cart = true;
}

$cart_icon = trim( mfn_opts_get('shop-cart') );
?>

<div class="mfn-footer-stickymenu">
	<ul>

		<?php if($has_shop){ ?>
			<li>
				<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>">
					<svg viewBox="0 0 26 26" aria-hidden="true"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g id="Layer_4" data-name="Layer 4"><rect x="15" y="5" width="6" height="6" class="path"/><rect x="5" y="5" width="6" height="6" class="path"/><rect x="5" y="15" width="6" height="6" class="path"/><rect x="15" y="15" width="6" height="6" class="path"/></g></svg>
          <span class="sm-item"><?php _e('Shop', 'woocommerce'); ?></span>
				</a>
			</li>
		<?php } ?>

		<?php if($has_user){ ?>
			<li>
				<?php echo '<a class="top-bar-right-icon myaccount_button top-bar-right-icon-user toggle-login-modal '. ( is_user_logged_in() ? 'logged-in' : 'logged-out' ) .'" href="'. get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) .'">'; ?>
					<?php
					if( is_user_logged_in() && get_option('show_avatars') == 1 && get_option('avatar_default') != 'blank' ){
						$current_user = wp_get_current_user();
						echo get_avatar( $current_user->ID, 32 );
					} else {
						mfn_user_icon( $user_icon );
					}
					?>
					<span class="sm-item"><?php _e('My account', 'woocommerce'); ?></span>
				</a>
			</li>
		<?php } ?>

		<?php if($has_cart){ ?>
			<li>
				<a <?php if( mfn_opts_get('shop-sidecart') && ! is_cart() && ! is_checkout() ){ echo 'class="toggle-mfn-cart header-cart"'; }else{echo 'class="header-cart"';} ?> href="<?php echo wc_get_page_permalink( 'cart' ); ?>">
					<?php
					if( $cart_icon ){
						echo '<i class="'. $cart_icon .'" aria-hidden="true"></i>';
					} else {
						echo '<svg viewBox="0 0 26 26" aria-hidden="true"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"/><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"/></svg>';
					}
					?>
					<span class="header-cart-count"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
					<span class="sm-item"><?php _e('Cart', 'woocommerce'); ?></span>
				</a>
			</li>
		<?php } ?>

		<?php if($has_wishlist){ ?>
			<li>
				<a href="<?php echo get_permalink(mfn_opts_get('shop-wishlist-page')); ?>">
					<?php
					if( $wishlist_icon ){
						echo '<i class="'. $wishlist_icon .'" aria-hidden="true"></i>';
					} else {
						echo '<svg viewBox="0 0 26 26" aria-hidden="true"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"/></svg>';
					}
					?>
					<span class="header-wishlist-count">0</span>
					<span class="sm-item"><?php echo get_the_title( mfn_opts_get('shop-wishlist-page') ); ?></span>
				</a>
			</li>
		<?php } ?>

	</ul>
</div>
