<?php

// default
$mfn_header_tmpl_class = array();
$mfn_header_offset_top = get_post_meta($args['id'], 'body_offset_header', true);
$mfn_header_content_anim = get_post_meta($args['id'], 'header_content_on_submenu', true);
$mfn_helper_offset_top = false;
$mfn_header_tmpl_mobile_pos = false;
$mfn_header_offset_top_mobile = false;
$mfn_header_tmpl_pos = get_post_meta($args['id'], 'header_position', true);
$mfn_hasStickyHeader = get_post_meta($args['id'], 'header_sticky', true);
$mfn_StickyHeaderWidth = get_post_meta($args['id'], 'header_sticky_width', true);
$mfn_HeaderWidth = get_post_meta($args['id'], 'header_width', true);
$mfn_hasMobileHeader = get_post_meta($args['id'], 'header_mobile', true);

if($mfn_header_tmpl_pos) {
	$mfn_header_tmpl_class[] = 'mfn-header-tmpl-'.$mfn_header_tmpl_pos;
}else{
	$mfn_header_tmpl_class[] = 'mfn-header-tmpl-default';
}

if( !empty( $mfn_header_offset_top ) ) {
	$mfn_header_tmpl_class[] = 'mfn-header-body-offset';
}

if( !empty( $mfn_HeaderWidth ) && $mfn_HeaderWidth == 'inherited' ){
	$mfn_header_tmpl_class[] = 'mfn-header-layout-width';
}

if( !empty($mfn_header_content_anim) ) {
	$mfn_header_tmpl_class[] = 'mfn-header-content-'.$mfn_header_content_anim;

	if( in_array($mfn_header_content_anim, array('overlay', 'blur')) ) {

		$mfn_header_overlay_styles = false;
		if( !empty(get_post_meta($args['id'], 'header_content_on_submenu_color', true)) ) {
			$mfn_header_overlay_styles = 'background-color:'.get_post_meta($args['id'], 'header_content_on_submenu_color', true).';';
		}else{
			$mfn_header_overlay_styles = 'background-color:rgba(0,0,0,0.5);';
		}

		if( !empty(get_post_meta($args['id'], 'header_content_on_submenu_blur', true)) ) {
			echo '<style type="text/css">.mfn-content-blur #Content, .mfn-content-blur .mfn-main-slider{filter:blur('.get_post_meta($args['id'], 'header_content_on_submenu_blur', true).'px);}</style>';
		}else{
			echo '<style type="text/css">.mfn-content-blur #Content, .mfn-content-blur .mfn-main-slider{filter:blur(2px);}</style>';
		}

		echo '<div style="'.$mfn_header_overlay_styles.'" class="mfn-header-overlay"></div>';
	}
}

// sticky
if( !empty($mfn_hasStickyHeader) && $mfn_hasStickyHeader == 'enabled' ) {
	$mfn_header_tmpl_class[] = 'mfn-hasSticky';
	if( !empty($mfn_StickyHeaderWidth) && $mfn_StickyHeaderWidth == 'inherited' ) $mfn_header_tmpl_class[] = 'mfn-sticky-layout-width';
}

// mobile
if( !empty($mfn_hasMobileHeader) && $mfn_hasMobileHeader == 'enabled' ) {

	$mfn_header_tmpl_class[] = 'mfn-hasMobile';
	$mfn_header_tmpl_mobile_pos = get_post_meta($args['id'], 'mobile_header_position', true);
	$mfn_header_offset_top_mobile = get_post_meta($args['id'], 'mobile_body_offset_header', true);

	if($mfn_header_tmpl_mobile_pos) {
		$mfn_header_tmpl_class[] = 'mfn-mobile-header-tmpl-'.$mfn_header_tmpl_mobile_pos;
	}else{
		$mfn_header_tmpl_class[] = 'mfn-mobile-header-tmpl-fixed';
	}

	if( !empty($mfn_header_offset_top_mobile) ){
		$mfn_header_tmpl_class[] = 'mfn-mobile-header-body-offset';
	}
}

if( $mfn_header_offset_top_mobile || $mfn_header_offset_top ) { $mfn_helper_offset_top = 'style="position: relative; pointer-events: none;"'; }

echo '<header id="mfn-header-template" data-id="'.$args['id'].'" '.$mfn_helper_offset_top.' data-mobile-type="'.$mfn_header_tmpl_mobile_pos.'" data-type="'.$mfn_header_tmpl_pos.'" class="mfn-header-tmpl mfn-header-main '.implode(' ', $mfn_header_tmpl_class).'">';
$mfn_header_builder = new Mfn_Builder_Front($args['id']);
$mfn_header_builder->show(false, $args['visual']);
echo '</header>';

echo mfn_slider();

if ( 'intro' != get_post_meta( mfn_ID(), 'mfn-post-template', true ) ){
	if( 'all' != mfn_opts_get('subheader') ){
		if( ! get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ){

			$subheader_advanced = mfn_opts_get('subheader-advanced');

			if (is_search()) {

				echo '<div id="Subheader">';
					echo '<div class="container">';
						echo '<div class="column one">';

							if ( ! empty($_GET['s']) ) {
								global $wp_query;
								$total_results = $wp_query->found_posts;
							} else {
								$total_results = 0;
							}

							$translate['search-results'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-results', 'results found for:') : __('results found for:', 'betheme');
							echo '<h1 class="title">'. esc_html($total_results) .' '. esc_html($translate['search-results']) .' '. ( ! empty($_GET['s']) ? esc_html(stripslashes($_GET['s'])) : '' ) .'</h1>';

						echo '</div>';
					echo '</div>';
				echo '</div>';

			} elseif ( ! mfn_slider_isset() || isset( $subheader_advanced['slider-show'] ) ) {

				// subheader

				$subheader_options = mfn_opts_get('subheader');

				if (is_home() && ! get_option('page_for_posts') && ! mfn_opts_get('blog-page')) {
					$subheader_show = false;
				} elseif (is_array($subheader_options) && isset($subheader_options[ 'hide-subheader' ])) {
					$subheader_show = false;
				} elseif (get_post_meta(mfn_ID(), 'mfn-post-hide-title', true)) {
					$subheader_show = false;
				} else {
					$subheader_show = true;
				}

				// title

				if (is_array($subheader_options) && isset($subheader_options[ 'hide-title' ])) {
					$title_show = false;
				} else {
					$title_show = true;
				}

				// breadcrumbs

				if (is_array($subheader_options) && isset($subheader_options[ 'hide-breadcrumbs' ])) {
					$breadcrumbs_show = false;
				} else {
					$breadcrumbs_show = true;
				}

				if (is_array($subheader_advanced) && isset($subheader_advanced[ 'breadcrumbs-link' ])) {
					$breadcrumbs_link = 'has-link';
				} else {
					$breadcrumbs_link = 'no-link';
				}

				// output

				if ($subheader_show) {

					echo '<div id="Subheader">';
						echo '<div class="container">';
							echo '<div class="column one">';

								if( function_exists('is_woocommerce') && is_woocommerce() ){

									// shop -----

									if ($title_show) {

										$title_tag = mfn_opts_get('subheader-title-tag', 'h1');

										// single product can not use H1
										if (function_exists('is_product') && is_product() && $title_tag == 'h1') {
											$title_tag = 'h2';
										}

										echo '<'. esc_attr($title_tag) .' class="title">';
											if (function_exists('is_product') && is_product() && mfn_opts_get('shop-product-title')) {
												the_title();
											} elseif(function_exists('woocommerce_page_title')){
												woocommerce_page_title();
											}else{
												echo 'Please enable WooCommerce plugin';
											}
										echo '</'. esc_attr($title_tag) .'>';
									}

									if (function_exists('woocommerce_breadcrumb') && $breadcrumbs_show) {
										$home = mfn_opts_get('translate') ? mfn_opts_get('translate-home', 'Home') : __('Home', 'betheme');
										$woo_crumbs_args = apply_filters('woocommerce_breadcrumb_defaults', array(
											'delimiter' => false,
											'wrap_before' => '<ul class="breadcrumbs woocommerce-breadcrumb">',
											'wrap_after' => '</ul>',
											'before' => '<li>',
											'after' => '<span><i class="icon-right-open" aria-label="breadcrumbs separator"></i></span></li>',
											'home' => esc_html($home),
										));

										woocommerce_breadcrumb($woo_crumbs_args);
									}

								} else {

									// default -----

									if ($title_show) {
										$title_tag = mfn_opts_get('subheader-title-tag', 'h1');
										echo '<'. esc_attr($title_tag) .' class="title">'. wp_kses(mfn_page_title(), mfn_allowed_html()) .'</'. esc_attr($title_tag) .'>';
									}

									if ($breadcrumbs_show) {
										mfn_breadcrumbs($breadcrumbs_link);
									}

								}

							echo '</div>';
						echo '</div>';
					echo '</div>';

				}
			}

		}
	}
}
