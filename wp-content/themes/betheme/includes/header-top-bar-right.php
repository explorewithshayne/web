<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

global $woocommerce;

$has_shop = false;
$has_user = false;
$has_cart = false;
$has_wishlist = false;
$has_menu = false;

// has shop

if( isset( $woocommerce ) && function_exists('is_woocommerce') ){
	$has_shop = true;
}

// shop icons hide

$shop_icons_hide = mfn_opts_get('shop-icons-hide');

// shop user

if( $has_shop && empty( $shop_icons_hide['user'] ) ){
	$has_user = true;
}

$user_icon = trim( mfn_opts_get('shop-user') ?? '' );

// shop wishlist

if( $has_shop && empty( $shop_icons_hide['wishlist'] ) && mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-page') ){
	$has_wishlist = true;
}

$wishlist_icon = trim( mfn_opts_get('shop-icon-wishlist') ?? '' );

// shop cart

if( $has_shop && empty( $shop_icons_hide['cart'] ) ){
	$has_cart = true;
}

$cart_icon = trim( mfn_opts_get('shop-cart') ?? '' );

// search

$header_search = mfn_opts_get('header-search');

// action button

$action_link = mfn_opts_get('header-action-link');

// WPML icon

if (has_nav_menu('lang-menu')) {
	$wpml_icon = true;
} elseif (function_exists('icl_get_languages') && mfn_opts_get('header-wpml') != 'hide') {
	$wpml_icon = true;
} else {
	$wpml_icon = false;
}

// header shop menus

if( 'header-shop' == mfn_header_style(true) && 'hide' != mfn_opts_get('menu-style') ){
	$has_menu = true;
}

// class

$class = [];

$shop_cart_total_hide = mfn_opts_get('shop-cart-total-hide');
if( is_array( $shop_cart_total_hide ) ){
	unset( $shop_cart_total_hide['post-meta'] );
	foreach( $shop_cart_total_hide as $val=>$k ){
		$class[] = 'hide-total-'. $val;
	}
}

$class = implode(' ', $class);

$translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder', 'Enter your search') : __('Enter your search', 'betheme');

// output -----

if ( $has_user || $has_wishlist || $has_cart || $header_search || $action_link || $wpml_icon || $has_menu ) {
	echo '<div class="top_bar_right '. esc_attr( $class ).'">';
		echo '<div class="top_bar_right_wrapper">';

			$search_icon = '<svg width="26" viewBox="0 0 26 26" aria-label="'. __('search icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle class="path" cx="11.35" cy="11.35" r="6"/><line class="path" x1="15.59" y1="15.59" x2="20.65" y2="20.65"/></svg>';

			// header style shop

			if ( 'header-shop' == mfn_header_style(true) && 'input' == $header_search ){

				echo '<div class="top-bar-right-input has-input">';
					echo '<form method="get" class="top-bar-search-form" id="searchform" action="'. esc_url(home_url('/')) .'" role="search" aria-label="'. __('header search form', 'betheme') .'">';

						echo $search_icon;
						echo '<input type="text" class="field" name="s" autocomplete="off" placeholder="'. esc_html($translate['search-placeholder']) .'" aria-label="'. esc_html($translate['search-placeholder']) .'" />';

						do_action('wpml_add_language_form_field');

						echo '<input type="submit" class="submit" value="" style="display:none;" />';

						if ( mfn_opts_get('header-search-live') ) {
							get_template_part('includes/header', 'live-search');
						}

					echo '</form>';
				echo '</div>';

			}

			// shop user

			if( $has_user ){

				$modal_type = 'is-boxed';
				if ( 'header-creative' == mfn_header_style(true) ) {
					$modal_type = false;
				}

				echo '<a class="top-bar-right-icon myaccount_button top-bar-right-icon-user toggle-login-modal '. esc_attr($modal_type) .' '. ( is_user_logged_in() ? 'logged-in' : 'logged-out' ) .'" href="'. get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) .'">';
					if( is_user_logged_in() && get_option('show_avatars') == 1 && get_option('avatar_default') != 'blank' ){
						$current_user = wp_get_current_user();
						echo get_avatar( $current_user->ID, 32 );
					} else {
						mfn_user_icon( $user_icon );
					}
				echo '</a>';

			}

			// shop wishlist

			if( $has_wishlist ){
				echo '<a id="wishlist_button" class="top-bar-right-icon top-bar-right-icon-wishlist" href="'. get_permalink( mfn_opts_get('shop-wishlist-page') ). '">';
					if( $wishlist_icon ){
						echo '<i class="'. $wishlist_icon .'" aria-label="'. __('wishlist icon', 'betheme') .'"></i>';
					} else {
						echo '<svg width="26" viewBox="0 0 26 26" aria-label="'. __('wishlist icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"/></svg>';
					}
					echo '<span class="header-wishlist-count">0</span>';
				echo '</a>';
			}

			// shop cart

			if ( $has_cart ) {

				if( mfn_opts_get('shop-sidecart') && ! is_cart() && ! is_checkout() ){
					$class = 'toggle-mfn-cart';
				} else {
					$class = false;
				}

				echo '<a id="header_cart" class="top-bar-right-icon header-cart top-bar-right-icon-cart '. esc_attr( $class ) .'" href="'. esc_url( wc_get_cart_url() ) .'">';

					if( $cart_icon ){
						echo '<i class="'. $cart_icon .'" aria-label="'. __('cart icon', 'betheme') .'"></i>';
					} else {
						echo '<svg width="26" viewBox="0 0 26 26" aria-label="'. __('cart icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"/><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"/></svg>';
					}

					if(mfn_opts_get('shop-icon-count-if-zero') == 1 || $woocommerce->cart->cart_contents_count > 0){
						echo '<span class="header-cart-count">'. esc_html( $woocommerce->cart->cart_contents_count ) .'</span>';
						echo '<p class="header-cart-total">'. wp_strip_all_tags( $woocommerce->cart->get_cart_total() ) .'</p>';
					}

				echo '</a>';

			}

			// search icon

			if ( 'input' == $header_search ) {

				if ( 'header-shop' != mfn_header_style(true) ){

					echo '<div class="top-bar-right-input has-input">';
						echo '<form method="get" class="top-bar-search-form" id="searchform" action="'. esc_url(home_url('/')) .'" role="search" aria-label="'. __('header search form', 'betheme') .'">';

							echo $search_icon;
							echo '<input type="text" class="field" name="s" autocomplete="off" placeholder="'. esc_html($translate['search-placeholder']) .'" aria-label="'. esc_html($translate['search-placeholder']) .'"/>';

							do_action('wpml_add_language_form_field');

							echo '<input type="submit" class="submit" value="" style="display:none;" />';

							if ( mfn_opts_get('header-search-live') ) {
								get_template_part('includes/header', 'live-search');
							}

						echo '</form>';
					echo '</div>';

				}

			} elseif ( $header_search ) {

				echo '<a id="search_button" class="top-bar-right-icon top-bar-right-icon-search search_button" href="#">';
					echo $search_icon;
				echo '</a>';

			}

			// languages menu

			get_template_part('includes/include', 'wpml');

			// action button

			if ($action_link) {
				$action_options = mfn_opts_get('header-action-target');

				if (isset($action_options['target'])) {
					$action_target = 'target="_blank"';
				} else {
					$action_target = false;
				}

				if (isset($action_options['scroll'])) {
					$action_class = ' scroll';
				} else {
					$action_class = false;
				}

				echo '<a href="'. esc_url($action_link) .'" class="action_button top-bar-right-button '. esc_attr($action_class) .'" '. wp_kses_data($action_target) .'>'. wp_kses(mfn_opts_get('header-action-title'), mfn_allowed_html('button')) .'</a>';
			}

			// header style: shop | menu button

			if( $has_menu ){

				// responsive menu button
				$mb_class = '';
				if (mfn_opts_get('header-menu-mobile-sticky')) {
					$mb_class .= ' is-sticky';
				}

				echo '<a class="responsive-menu-toggle '. esc_attr($mb_class) .'" href="#" aria-label="'. __('mobile menu', 'betheme') .'">';
				if ( $menu_text = trim( mfn_opts_get('header-menu-text') ?? '' ) ) {
					echo '<span aria-hidden="true">'. wp_kses($menu_text, mfn_allowed_html()) .'</span>';
				} else {
					echo '<i class="icon-menu-fine" aria-hidden="true"></i>';
				}
				echo '</a>';

			}

		echo '</div>';
	echo '</div>';
}

?>
