<?php
/**
 * Responsive | Side Slide
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

global $woocommerce;

$has_shop = false;
$has_user = false;
$has_cart = false;
$has_wishlist = false;

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

// responsive | mobile | options

$menu_pos = 'right';
if (in_array(mfn_opts_get('responsive-header-minimal'), array( 'ml-ll','ml-lc','ml-lr' ))) {
	$menu_pos = 'left';
}

if( is_rtl() || isset($_GET['mfn-rtl']) ){
	$menu_pos = 'left';
	if (in_array(mfn_opts_get('responsive-header-minimal'), array( 'ml-ll','ml-lc','ml-lr' ))) {
		$menu_pos = 'right';
	}
}

$side_class = $menu_pos;

// background color | brightness

$side_class .= ' '. mfn_brightness(mfn_opts_get('background-side-menu', '#191919'));

// side slide | hide

$ss_hide = mfn_opts_get('responsive-side-slide');
if ( isset( $ss_hide['social'] ) ) {
	$side_class .= ' hide-social';
}

echo '<div id="Side_slide" class="'. esc_attr($side_class) .'" data-width="'. esc_attr(mfn_opts_get('responsive-side-slide-width', 250)) .'" aria-expanded="false" role="banner" aria-label="'. __('responsive menu', 'betheme') .'">';

// close button

echo '<div class="close-wrapper">';
	echo '<a href="#" aria-label="'. __('menu close icon', 'betheme') .'" class="close"><i class="icon-cancel-fine"></i></a>';
echo '</div>';

// extras

echo '<div class="extras">';

	// action button

	if ( $action_link = mfn_opts_get('header-action-link') ) {
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

		echo '<a href="'. esc_url($action_link) .'" class="action_button'. esc_attr($action_class) .'" '. wp_kses_data($action_target) .'>'. wp_kses(mfn_opts_get('header-action-title'), mfn_allowed_html('button')) .'</a>';
	}

	// icons

	echo '<div class="extras-wrapper" role="navigation" aria-label="'. __('extras menu', 'betheme') .'">';

		// shop user

		if( $has_user ){

			echo '<a class="top-bar-right-icon myaccount_button top-bar-right-icon-user toggle-login-modal '. ( is_user_logged_in() ? 'logged-in' : 'logged-out' ) .'" href="'. get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) .'">';
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
					echo '<i class="'. $wishlist_icon .'" aria-label="'. __('whishlist icon', 'betheme') .'"></i>';
				} else {
					echo '<svg width="26" viewBox="0 0 26 26" aria-label="'. __('whishlist icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#333;stroke-width:1.5px;}</style></defs><path class="path" d="M16.7,6a3.78,3.78,0,0,0-2.3.8A5.26,5.26,0,0,0,13,8.5a5,5,0,0,0-1.4-1.6A3.52,3.52,0,0,0,9.3,6a4.33,4.33,0,0,0-4.2,4.6c0,2.8,2.3,4.7,5.7,7.7.6.5,1.2,1.1,1.9,1.7H13a.37.37,0,0,0,.3-.1c.7-.6,1.3-1.2,1.9-1.7,3.4-2.9,5.7-4.8,5.7-7.7A4.3,4.3,0,0,0,16.7,6Z"/></svg>';
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

			echo '<a id="header_cart" class="top-bar-right-icon top-bar-right-icon-cart '. esc_attr( $class ) .'" href="'. esc_url( wc_get_cart_url() ) .'">';

				if( $cart_icon ){
					echo '<i class="'. $cart_icon .'" aria-label="'. __('cart icon', 'betheme') .'"></i>';
				} else {
					echo '<svg width="26" viewBox="0 0 26 26" aria-label="'. __('cart icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><polygon class="path" points="20.4 20.4 5.6 20.4 6.83 10.53 19.17 10.53 20.4 20.4"/><path class="path" d="M9.3,10.53V9.3a3.7,3.7,0,1,1,7.4,0v1.23"/></svg>';
				}

				echo '<span class="header-cart-count">'. esc_html( $woocommerce->cart->cart_contents_count ) .'</span>';
				echo '<p class="header-cart-total">'. wp_strip_all_tags( $woocommerce->cart->get_cart_total() ) .'</p>';

			echo '</a>';

		}

		// search icon

		$search_icon = '<svg width="26" viewBox="0 0 26 26" aria-label="'. __('search icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle class="path" cx="11.35" cy="11.35" r="6"/><line class="path" x1="15.59" y1="15.59" x2="20.65" y2="20.65"/></svg>';

		if ( $header_search ) {

			echo '<a class="top-bar-right-icon top-bar-right-icon-search icon search" href="#">';
				echo $search_icon;
			echo '</a>';

		}

		// languages menu

		if (has_nav_menu('lang-menu')) {

			// custom languages menu
			echo '<a class="lang-active" href="#">'. esc_html(mfn_get_menu_name('lang-menu')) .'<i class="icon-down-open-mini" aria-hidden="true"></i></a>';

		} elseif (function_exists('icl_get_languages')) {

			// WPML | custom languages menu

			$lang_args = '';
			$lang_options = mfn_opts_get('header-wpml-options');
			$wmpl_flags = mfn_opts_get('header-wpml');

			if (isset($lang_options['link-to-home'])) {
				$lang_args .= 'skip_missing=0';
			} else {
				$lang_args .= 'skip_missing=1';
			}
			$languages = icl_get_languages($lang_args);

			if (is_array($languages) && $wmpl_flags != 'hide') {
				$active_lang = false;
				foreach ($languages as $lang_k=>$lang) {
					if ($lang['active']) {
						$active_lang = $lang;
					}
				}

				if ($active_lang) {

					echo '<a class="lang-active" href="#">';
						if ($wmpl_flags == 'dropdown-name') {
							echo esc_html($active_lang['native_name']);
						} elseif ($wmpl_flags == 'horizontal-code') {
							echo esc_html(strtoupper($active_lang['language_code']));
						} else {
							echo '<img src="'. esc_url($active_lang['country_flag_url']) .'" alt="'. esc_attr($active_lang['translated_name']) .'" width="18" height="12"/>';
						}
						if (count($languages) > 1) {
							echo '<i class="icon-down-open-mini" aria-label="'. __('language menu icon', 'betheme') .'"></i>';
						}
					echo '</a>';
				}
			}
		}

	echo '</div>';

echo '</div>';

// Search | wrapper

if (mfn_opts_get('header-search')) {
	echo '<div class="search-wrapper">';
		echo '<form id="side-form" method="get" action="'. esc_url(home_url('/')) .'" role="search" aria-label="'. __('side slide search', 'betheme') .'">';

			if (mfn_opts_get('header-search') == 'shop') {
				echo '<input type="hidden" name="post_type" value="product" />';
			}

			$translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder', 'Enter your search') : __('Enter your search', 'betheme');
			echo '<input type="text" class="field" name="s" placeholder="'. esc_attr($translate['search-placeholder']) .'" />';
			echo '<input type="submit" class="display-none" value="" />';

			do_action('wpml_add_language_form_field');

			echo '<a class="submit" href="#"><i class="icon-search-fine" aria-label="'. __('search submit icon', 'betheme') .'"></i></a>';

		echo '</form>';

		if ( mfn_opts_get('header-search-live') ) {
			get_template_part('includes/header', 'live-search');
		}

	echo '</div>';
}

// languages menu | wrapper

echo '<div class="lang-wrapper" role="navigation" aria-label="'. __('language menu', 'betheme') .'">';

	// languages menu
	if (has_nav_menu('lang-menu')) {

		// custom languages menu
		mfn_wp_lang_menu();

	} elseif (function_exists('icl_get_languages')) {

		// WPML | custom languages menu

		if (count($languages) > 1) {

			echo '<ul class="wpml-lang">';
				foreach ($languages as $lang) {
					echo '<li><a href="'. esc_url($lang['url']) .'" class="'. ($lang['active'] ? 'active' : false)  .'">';
						if ($wmpl_flags == 'dropdown-name') {
							echo esc_html($lang['native_name']);
						} elseif ($wmpl_flags == 'horizontal-code') {
							echo esc_html(strtoupper($lang['language_code']));
						} else {
							echo '<img src="'. esc_url($lang['country_flag_url']) .'" alt="'. esc_attr($lang['translated_name']) .'" width="18" height="12"/>';
						}
					echo '</a></li>';
				}
			echo '</ul>';

		} else {

			$translate['wpml-no'] = mfn_opts_get('translate') ? mfn_opts_get('translate-wpml-no', 'No translations available for this page') : __('No translations available for this page', 'betheme');
			echo '<ul class="wpml-no"><li><a href="#">'. esc_html($translate['wpml-no']) .'</a></li></ul>';

		}
	}

echo '</div>';

// main menu | jQuery content - DO NOT DELETE

echo '<div class="menu_wrapper" role="navigation" aria-label="'. __('main menu', 'betheme') .'"></div>';

// social

$action_bar = mfn_opts_get('action-bar');
if( isset($action_bar['side-slide']) ){
	get_template_part('includes/include', 'slogan');
}

if (has_nav_menu('social-menu')) {
	mfn_wp_social_menu();
} else {
	get_template_part('includes/include', 'social');
}

echo '</div>';
