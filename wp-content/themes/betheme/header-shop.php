<?php
/**
 * The Header for our theme.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */
?><!DOCTYPE html>
<?php
	if ($_GET && key_exists('mfn-rtl', $_GET)):
		echo '<html class="no-js" lang="ar" dir="rtl">';
	else:
?>
<html <?php language_attributes(); ?> class="no-js <?php echo esc_attr(mfn_html_classes()); ?>"<?php mfn_tag_schema(); ?> >
<?php endif; ?>

<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php do_action('mfn_hook_top'); ?>

	<?php get_template_part('includes/header', 'sliding-area'); ?>

	<?php
		if (mfn_header_style(true) == 'header-creative') {
			get_template_part('includes/header', 'creative');
		}
	?>

	<div id="Wrapper">

		<?php

		$header_tmp_id = mfn_template_part_ID('header');

		if( $header_tmp_id ){
			$is_visual = false;
			if( !empty($_GET['visual']) ) $is_visual = true;
			get_template_part( 'includes/header', 'template', array('id' => $header_tmp_id, 'visual' => $is_visual) );

			function mfn_woocommerce_show_page_title(){
				return false;
			}

			add_filter('woocommerce_show_page_title', 'mfn_woocommerce_show_page_title');

		}else{

			// featured image: parallax

			$class = '';
			$data_parallax = array();

			if (mfn_opts_get('img-subheader-attachment') == 'parallax') {
				$class = 'bg-parallax';

				if (mfn_opts_get('parallax') == 'stellar') {
					$data_parallax['key'] = 'data-stellar-background-ratio';
					$data_parallax['value'] = '0.5';
				} else {
					$data_parallax['key'] = 'data-enllax-ratio';
					$data_parallax['value'] = '0.3';
				}
			}

			$shop_id = mfn_ID();

			if (mfn_header_style(true) == 'header-below') {
				if (is_shop() || (mfn_opts_get('shop-slider') == 'all')) {
					echo mfn_slider($shop_id);
				}
			}
		?>

		<div id="Header_wrapper" class="<?php echo esc_attr($class); ?>" <?php if ($data_parallax) {
			printf('%s="%.1f"', $data_parallax['key'], $data_parallax['value']);
		} ?>>

			<?php
				if ('mhb' == mfn_header_style()) {

					// mfn_header action for header builder plugin
					do_action('mfn_header');
					if (is_shop() || (mfn_opts_get('shop-slider') == 'all')) {
						echo mfn_slider($shop_id);
					}

				} else {

					echo '<header id="Header">';

						if ( has_nav_menu('skip-links-menu') ) {
							mfn_wp_accessibility_skip_links();
						}

						if ( 'header-creative' != mfn_header_style(true) ) {
							// NOT header creative
							if( 'header-shop' == mfn_header_style(true) ){
								// header style: shop
								get_template_part('includes/header', 'style-shop');
							} elseif( 'header-shop-split' == mfn_header_style(true) ){
								// header style: shop split
								get_template_part('includes/header', 'style-shop-split');
							} else {
								// default headers
								get_template_part('includes/header', 'top-area');
							}
						}

						if ( 'header-below' != mfn_header_style(true) ) {
							// header below
							if ( function_exists('is_shop') && is_shop() || ( 'all' == mfn_opts_get('shop-slider') ) ) {
								echo mfn_slider($shop_id);
							}
						}

					echo '</header>';

				}
			?>

			<?php
				function mfn_woocommerce_show_page_title()
				{
					return false;
				}
				add_filter('woocommerce_show_page_title', 'mfn_woocommerce_show_page_title');

				$subheader_advanced = mfn_opts_get('subheader-advanced');

				if (! mfn_slider_isset($shop_id) || is_product() || (is_array($subheader_advanced) && isset($subheader_advanced['slider-show']))) {

					// subheader

					$subheader_options = mfn_opts_get('subheader');

					if (is_array($subheader_options) && isset($subheader_options['hide-subheader'])) {
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

					if (is_array($subheader_options) && isset($subheader_options['hide-breadcrumbs'])) {
						$breadcrumbs_show = false;
					} else {
						$breadcrumbs_show = true;
					}

					// output

					if ($subheader_show) {

						echo '<div id="Subheader">';
							echo '<div class="container">';
								echo '<div class="column one">';

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

								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
				}
			?>

		</div>

		<?php } ?>

		<?php do_action('mfn_hook_content_before');
