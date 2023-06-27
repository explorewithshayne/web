<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

defined( 'ABSPATH' ) || exit;

$custom_layout = mfn_layout_ID();
$layout_header_height = get_post_meta( $custom_layout, 'mfn-post-header-height', true );
?>
html{
	background-color: <?php echo esc_attr(mfn_opts_get('background-html', '#FCFCFC')); ?>;
}

#Wrapper,#Content,
.mfn-popup .mfn-popup-content,.mfn-off-canvas-sidebar .mfn-off-canvas-content-wrapper,.mfn-cart-holder,.mfn-header-login,
#Top_bar .search_wrapper, #Top_bar .top_bar_right .mfn-live-search-box,
.column_livesearch .mfn-live-search-wrapper, .column_livesearch .mfn-live-search-box{
	background-color: <?php echo esc_attr(mfn_opts_get('background-body', '#FCFCFC')); ?>;
}
.layout-boxed.mfn-bebuilder-header.mfn-ui #Wrapper .mfn-only-sample-content{ background-color: <?php echo esc_attr(mfn_opts_get('background-body', '#FCFCFC')); ?>; }

<?php if ( $custom_layout && ( '' !== $layout_header_height ) ) : ?>
	body:not(.template-slider) #Header{
		min-height: <?php echo esc_attr( $layout_header_height .'px' ); ?>;
	}
	body.header-below:not(.template-slider) #Header{
		padding-top: <?php echo esc_attr( $layout_header_height .'px' ); ?>;
	}
<?php else: ?>
	body:not(.template-slider) #Header{
		min-height: <?php echo esc_attr( mfn_opts_get( 'header-height', 250, [ 'unit' => 'px' ] ) ); ?>;
	}
	body.header-below:not(.template-slider) #Header{
		padding-top: <?php echo esc_attr( mfn_opts_get( 'header-height', 250, [ 'unit' => 'px' ] ) ); ?>;
	}
<?php endif; ?>

<?php if ( mfn_opts_get( 'subheader-padding' ) ) : ?>
	#Subheader {
		padding: <?php echo esc_attr( mfn_opts_get( 'subheader-padding' ) ); ?>;
	}
<?php endif; ?>

<?php if ( mfn_opts_get( 'footer-padding' ) ) : ?>
	#Footer .widgets_wrapper {
		padding: <?php echo esc_attr( mfn_opts_get( 'footer-padding' ) ); ?>;
	}
<?php endif; ?>

/**
 * Font | Family ********************************************************************************
 */

<?php
	$fonts = [
		'content' => mfn_opts_get('font-content'),
		'menu' => mfn_opts_get('font-menu'),
		'title' => mfn_opts_get('font-title'),
		'headings' => mfn_opts_get('font-headings'),
		'headings-small' => mfn_opts_get('font-headings-small'),
		'blockquote' => mfn_opts_get('font-blockquote'),
		'decorative' => mfn_opts_get('font-decorative'),
	];

	foreach( $fonts as $font_k => $font_v ){

		if( $font_v ){
			$fonts[$font_k] = '"'. str_replace('#', '', $font_v) .'"';
		}

		if( mfn_opts_get('google-font-mode') !== 'local') {
			if( $fonts[$font_k] ){
				$fonts[$font_k] .= ',';
			}
			$fonts[$font_k] .= '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';
		}

	}

?>

body, button, span.date_label, .timeline_items li h3 span, input[type="submit"], input[type="reset"], input[type="button"], input[type="date"],
input[type="text"], input[type="password"], input[type="tel"], input[type="email"], textarea, select, .offer_li .title h3, .mfn-menu-item-megamenu {
	font-family: <?php echo $fonts['content']; ?>;
}

#menu > ul > li > a, a.action_button, #overlay-menu ul li a {
	font-family: <?php echo $fonts['menu']; ?>;
}

#Subheader .title {
	font-family: <?php echo $fonts['title']; ?>;
}

h1, h2, h3, h4, .text-logo #logo {
	font-family: <?php echo $fonts['headings']; ?>;
}

h5, h6 {
	font-family: <?php echo $fonts['headings-small']; ?>;
}

blockquote {
	font-family: <?php echo $fonts['blockquote']; ?>;
}

.chart_box .chart .num, .counter .desc_wrapper .number-wrapper, .how_it_works .image .number,
.pricing-box .plan-header .price, .quick_fact .number-wrapper, .woocommerce .product div.entry-summary .price {
	font-family: <?php echo $fonts['decorative']; ?>;
}

/**
 * Font | Size & Style ********************************************************************************
 */

<?php

	$aFont = array(
		'content'	=> mfn_opts_get('font-size-content'),
		'big'			=> mfn_opts_get('font-size-big'),
		'menu'		=> mfn_opts_get('font-size-menu'),
		'title'		=> mfn_opts_get('font-size-title'),
		'h1'			=> mfn_opts_get('font-size-h1'),
		'h2'			=> mfn_opts_get('font-size-h2'),
		'h3'			=> mfn_opts_get('font-size-h3'),
		'h4'			=> mfn_opts_get('font-size-h4'),
		'h5'			=> mfn_opts_get('font-size-h5'),
		'h6'			=> mfn_opts_get('font-size-h6'),
		'intro'		=> mfn_opts_get('font-size-single-intro'),
	);

	// prevent passing not numeral value for letter spacing
	foreach( $aFont as $key => $val ){
		if( ! empty($val['letter_spacing']) ){
			$aFont[$key]['letter_spacing'] = intval($val['letter_spacing']);
		} else {
			$aFont[$key]['letter_spacing'] = 0;
		}
	}

	// main menu has no line height attribute
	$aFont['menu']['line_height'] = 0;

	// save initial values, we will use it later
	$aFontInit = $aFont;
?>

body, .mfn-menu-item-megamenu {
	font-size: <?php echo esc_attr($aFont['content']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['content']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['content']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['content']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['content']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
.big {
	font-size: <?php echo esc_attr($aFont['big']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['big']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['big']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['big']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['big']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
#menu > ul > li > a, a.action_button, #overlay-menu ul li a{
	font-size: <?php echo esc_attr($aFont['menu']['size']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['menu']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['menu']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['menu']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
#overlay-menu ul li a{
	line-height: <?php echo esc_attr($aFont['menu']['size'] * 1.5); ?>px;
}
#Subheader .title {
	font-size: <?php echo esc_attr($aFont['title']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['title']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['title']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['title']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['title']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
h1, .text-logo #logo {
	font-size: <?php echo esc_attr($aFont['h1']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['h1']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h1']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['h1']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['h1']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
h2 {
	font-size: <?php echo esc_attr($aFont['h2']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['h2']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h2']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['h2']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['h2']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
h3, .woocommerce ul.products li.product h3, .woocommerce #customer_login h2 {
	font-size: <?php echo esc_attr($aFont['h3']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['h3']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h3']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['h3']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['h3']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
h4, .woocommerce .woocommerce-order-details__title,
.woocommerce .wc-bacs-bank-details-heading, .woocommerce .woocommerce-customer-details h2 {
	font-size: <?php echo esc_attr($aFont['h4']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['h4']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h4']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['h4']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['h4']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
h5 {
	font-size: <?php echo esc_attr($aFont['h5']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['h5']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h5']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['h5']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['h5']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
h6 {
	font-size: <?php echo esc_attr($aFont['h6']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['h6']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h6']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['h6']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['h6']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}
#Intro .intro-title {
	font-size: <?php echo esc_attr($aFont['intro']['size']); ?>px;
	line-height: <?php echo esc_attr($aFont['intro']['line_height']); ?>px;
	font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['intro']['weight_style'])); ?>;
	letter-spacing: <?php echo esc_attr($aFont['intro']['letter_spacing']); ?>px;
	<?php
		if (strpos($aFont['intro']['weight_style'], 'italic')) {
			echo 'font-style: italic;';
		}
	?>
}

/**
 * Font | Size - Responsive ********************************************************************************
 */

<?php if ( mfn_opts_get('responsive') ): ?>

	<?php

		// auto font size

		$min_size = 13;
		$min_line = 19;

		// Tablet (Landscape) |  768 - 959

		if( mfn_opts_get('font-size-responsive') ){

			$multiplier = 0.85;

			foreach ($aFont as $key => $font) {
				if (is_numeric($font['size'])) {
					$aFont[$key]['size'] = round($font['size'] * $multiplier);
					if ($aFont[$key]['size'] < $min_size) {
						$aFont[$key]['size'] = $min_size;
					}
				}

				if (is_numeric($font['line_height'])) {
					$aFont[$key]['line_height'] = round($font['line_height'] * $multiplier);
					if ($aFont[$key]['line_height'] < $min_line) {
						$aFont[$key]['line_height'] = $min_line;
					}
				}

				if (is_numeric($font['letter_spacing'])) {
					$aFont[$key]['letter_spacing'] = round($font['letter_spacing'] * $multiplier);
				}
			}

		} else {

			// custom font size

			$aCustom = array(
				'content'	=> mfn_opts_get('font-size-content-tablet'),
				'big'			=> mfn_opts_get('font-size-big-tablet'),
				'menu'		=> mfn_opts_get('font-size-menu-tablet'),
				'title'		=> mfn_opts_get('font-size-title-tablet'),
				'h1'			=> mfn_opts_get('font-size-h1-tablet'),
				'h2'			=> mfn_opts_get('font-size-h2-tablet'),
				'h3'			=> mfn_opts_get('font-size-h3-tablet'),
				'h4'			=> mfn_opts_get('font-size-h4-tablet'),
				'h5'			=> mfn_opts_get('font-size-h5-tablet'),
				'h6'			=> mfn_opts_get('font-size-h6-tablet'),
				'intro'		=> mfn_opts_get('font-size-single-intro-tablet'),
			);

			foreach ( $aCustom as $key => $font ) {
				if( ! empty( $font['size'] ) ){
					foreach( $font as $attr_k => $attr_v ){
						if( ! empty($attr_v) ){
							$aFont[$key][$attr_k] = $attr_v;
						}
					}
				}
			}

		}

	?>

	@media only screen and (min-width:768px) and (max-width:959px){
		body, .mfn-menu-item-megamenu {
			font-size: <?php echo esc_attr($aFont['content']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['content']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['content']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['content']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['content']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		.big {
			font-size: <?php echo esc_attr($aFont['big']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['big']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['big']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['big']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['big']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#menu > ul > li > a, a.action_button, #overlay-menu ul li a{
			font-size: <?php echo esc_attr($aFont['menu']['size']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['menu']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['menu']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['menu']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#overlay-menu ul li a{
			line-height: <?php echo esc_attr($aFont['menu']['size'] * 1.5); ?>px;
		}

		#Subheader .title {
			font-size: <?php echo esc_attr($aFont['title']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['title']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['title']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['title']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['title']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h1, .text-logo #logo {
			font-size: <?php echo esc_attr($aFont['h1']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h1']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h1']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h1']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h1']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h2 {
			font-size: <?php echo esc_attr($aFont['h2']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h2']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h2']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h2']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h2']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h3, .woocommerce ul.products li.product h3, .woocommerce #customer_login h2 {
			font-size: <?php echo esc_attr($aFont['h3']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h3']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h3']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h3']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h3']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h4, .woocommerce .woocommerce-order-details__title,
		.woocommerce .wc-bacs-bank-details-heading, .woocommerce .woocommerce-customer-details h2 {
			font-size: <?php echo esc_attr($aFont['h4']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h4']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h4']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h4']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h4']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h5 {
			font-size: <?php echo esc_attr($aFont['h5']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h5']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h5']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h5']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h5']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h6 {
			font-size: <?php echo esc_attr($aFont['h6']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h6']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h6']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h6']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h6']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#Intro .intro-title {
			font-size: <?php echo esc_attr($aFont['intro']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['intro']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['intro']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['intro']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['intro']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}

		blockquote { font-size: 15px;}

		.chart_box .chart .num { font-size: 45px; line-height: 45px; }

		.counter .desc_wrapper .number-wrapper { font-size: 45px; line-height: 45px;}
		.counter .desc_wrapper .title { font-size: 14px; line-height: 18px;}

		.faq .question .title { font-size: 14px; }

		.fancy_heading .title { font-size: 38px; line-height: 38px; }

		.offer .offer_li .desc_wrapper .title h3 { font-size: 32px; line-height: 32px; }
		.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 32px; line-height: 32px; }

		.pricing-box .plan-header h2 { font-size: 27px; line-height: 27px; }
		.pricing-box .plan-header .price > span { font-size: 40px; line-height: 40px; }
		.pricing-box .plan-header .price sup.currency { font-size: 18px; line-height: 18px; }
		.pricing-box .plan-header .price sup.period { font-size: 14px; line-height: 14px;}

		.quick_fact .number-wrapper { font-size: 80px; line-height: 80px;}

		.trailer_box .desc h2 { font-size: 27px; line-height: 27px; }

		.widget > h3 { font-size: 17px; line-height: 20px; }
	}

	<?php

		// Tablet (Portrait) & Mobile (Landscape) | 480 - 767

		if( mfn_opts_get('font-size-responsive') ){

			$aFont = $aFontInit;
			$multiplier = 0.75;

			foreach ($aFont as $key => $font) {
				if (is_numeric($font['size'])) {
					$aFont[$key]['size'] = round($font['size'] * $multiplier);
					if ($aFont[$key]['size'] < $min_size) {
						$aFont[$key]['size'] = $min_size;
					}
				}

				if (is_numeric($font['line_height'])) {
					$aFont[$key]['line_height'] = round($font['line_height'] * $multiplier);
					if ($aFont[$key]['line_height'] < $min_line) {
						$aFont[$key]['line_height'] = $min_line;
					}
				}

				if (is_numeric($font['letter_spacing'])) {
					$aFont[$key]['letter_spacing'] = round($font['letter_spacing'] * $multiplier);
				}
			}

		} else {

			// custom font size

			$aCustom = array(
				'content'	=> mfn_opts_get('font-size-content-mobile'),
				'big'			=> mfn_opts_get('font-size-big-mobile'),
				'menu'		=> mfn_opts_get('font-size-menu-mobile'),
				'title'		=> mfn_opts_get('font-size-title-mobile'),
				'h1'			=> mfn_opts_get('font-size-h1-mobile'),
				'h2'			=> mfn_opts_get('font-size-h2-mobile'),
				'h3'			=> mfn_opts_get('font-size-h3-mobile'),
				'h4'			=> mfn_opts_get('font-size-h4-mobile'),
				'h5'			=> mfn_opts_get('font-size-h5-mobile'),
				'h6'			=> mfn_opts_get('font-size-h6-mobile'),
				'intro'		=> mfn_opts_get('font-size-single-intro-mobile'),
			);

			foreach ( $aCustom as $key => $font ) {
				if( ! empty( $font['size'] ) ){
					foreach( $font as $attr_k => $attr_v ){
						if( ! empty($attr_v) ){
							$aFont[$key][$attr_k] = $attr_v;
						}
					}
				}
			}

		}
	?>

	@media only screen and (min-width:480px) and (max-width:767px){
		body, .mfn-menu-item-megamenu {
			font-size: <?php echo esc_attr($aFont['content']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['content']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['content']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['content']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['content']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		.big {
			font-size: <?php echo esc_attr($aFont['big']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['big']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['big']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['big']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['big']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#menu > ul > li > a, a.action_button, #overlay-menu ul li a{
			font-size: <?php echo esc_attr($aFont['menu']['size']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['menu']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['menu']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['menu']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#overlay-menu ul li a{
			line-height: <?php echo esc_attr($aFont['menu']['size'] * 1.5); ?>px;
		}

		#Subheader .title {
			font-size: <?php echo esc_attr($aFont['title']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['title']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['title']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['title']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['title']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h1, .text-logo #logo {
			font-size: <?php echo esc_attr($aFont['h1']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h1']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h1']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h1']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h1']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h2 {
			font-size: <?php echo esc_attr($aFont['h2']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h2']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h2']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h2']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h2']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h3, .woocommerce ul.products li.product h3, .woocommerce #customer_login h2 {
			font-size: <?php echo esc_attr($aFont['h3']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h3']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h3']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h3']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h3']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h4, .woocommerce .woocommerce-order-details__title,
		.woocommerce .wc-bacs-bank-details-heading, .woocommerce .woocommerce-customer-details h2 {
			font-size: <?php echo esc_attr($aFont['h4']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h4']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h4']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h4']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h4']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h5 {
			font-size: <?php echo esc_attr($aFont['h5']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h5']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h5']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h5']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h5']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h6 {
			font-size: <?php echo esc_attr($aFont['h6']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h6']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h6']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h6']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h6']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#Intro .intro-title {
			font-size: <?php echo esc_attr($aFont['intro']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['intro']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['intro']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['intro']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['intro']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}

		blockquote { font-size: 14px;}

		.chart_box .chart .num { font-size: 40px; line-height: 40px; }

		.counter .desc_wrapper .number-wrapper { font-size: 40px; line-height: 40px;}
		.counter .desc_wrapper .title { font-size: 13px; line-height: 16px;}

		.faq .question .title { font-size: 13px; }

		.fancy_heading .title { font-size: 34px; line-height: 34px; }

		.offer .offer_li .desc_wrapper .title h3 { font-size: 28px; line-height: 28px; }
		.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 28px; line-height: 28px; }

		.pricing-box .plan-header h2 { font-size: 24px; line-height: 24px; }
		.pricing-box .plan-header .price > span { font-size: 34px; line-height: 34px; }
		.pricing-box .plan-header .price sup.currency { font-size: 16px; line-height: 16px; }
		.pricing-box .plan-header .price sup.period { font-size: 13px; line-height: 13px;}

		.quick_fact .number-wrapper { font-size: 70px; line-height: 70px;}

		.trailer_box .desc h2 { font-size: 24px; line-height: 24px; }

		.widget > h3 { font-size: 16px; line-height: 19px; }
	}

	<?php

		// Mobile (Portrait) | < 479

		if( mfn_opts_get('font-size-responsive') ){

			$aFont = $aFontInit;
			$multiplier = 0.6;

			foreach ($aFont as $key => $font) {
				if (is_numeric($font['size'])) {
					$aFont[$key]['size'] = round($font['size'] * $multiplier);
					if ($aFont[$key]['size'] < $min_size) {
						$aFont[$key]['size'] = $min_size;
					}
				}

				if (is_numeric($font['line_height'])) {
					$aFont[$key]['line_height'] = round($font['line_height'] * $multiplier);
					if ($aFont[$key]['line_height'] < $min_line) {
						$aFont[$key]['line_height'] = $min_line;
					}
				}

				if (is_numeric($font['letter_spacing'])) {
					$aFont[$key]['letter_spacing'] = round($font['letter_spacing'] * $multiplier);
				}
			}

		}
	?>

	@media only screen and (max-width:479px){
		body, .mfn-menu-item-megamenu {
			font-size: <?php echo esc_attr($aFont['content']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['content']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['content']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['content']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['content']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		.big {
			font-size: <?php echo esc_attr($aFont['big']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['big']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['big']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['big']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['big']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#menu > ul > li > a, a.action_button, #overlay-menu ul li a{
			font-size: <?php echo esc_attr($aFont['menu']['size']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['menu']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['menu']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['menu']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#overlay-menu ul li a{
			line-height: <?php echo esc_attr($aFont['menu']['size'] * 1.5); ?>px;
		}

		#Subheader .title {
			font-size: <?php echo esc_attr($aFont['title']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['title']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['title']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['title']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['title']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h1, .text-logo #logo {
			font-size: <?php echo esc_attr($aFont['h1']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h1']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h1']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h1']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h1']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h2 {
			font-size: <?php echo esc_attr($aFont['h2']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h2']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h2']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h2']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h2']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h3, .woocommerce ul.products li.product h3, .woocommerce #customer_login h2 {
			font-size: <?php echo esc_attr($aFont['h3']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h3']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h3']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h3']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h3']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h4, .woocommerce .woocommerce-order-details__title,
		.woocommerce .wc-bacs-bank-details-heading, .woocommerce .woocommerce-customer-details h2 {
			font-size: <?php echo esc_attr($aFont['h4']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h4']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h4']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h4']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h4']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h5 {
			font-size: <?php echo esc_attr($aFont['h5']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h5']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h5']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h5']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h5']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		h6 {
			font-size: <?php echo esc_attr($aFont['h6']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['h6']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['h6']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['h6']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['h6']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}
		#Intro .intro-title {
			font-size: <?php echo esc_attr($aFont['intro']['size']); ?>px;
			line-height: <?php echo esc_attr($aFont['intro']['line_height']); ?>px;
			font-weight: <?php echo esc_attr(str_replace('italic', '', $aFont['intro']['weight_style'])); ?>;
			letter-spacing: <?php echo esc_attr($aFont['intro']['letter_spacing']); ?>px;
			<?php
				if (strpos($aFont['intro']['weight_style'], 'italic')) {
					echo 'font-style: italic;';
				}
			?>
		}

		blockquote { font-size: 13px;}

		.chart_box .chart .num { font-size: 35px; line-height: 35px; }

		.counter .desc_wrapper .number-wrapper { font-size: 35px; line-height: 35px;}
		.counter .desc_wrapper .title { font-size: 13px; line-height: 26px;}

		.faq .question .title { font-size: 13px; }

		.fancy_heading .title { font-size: 30px; line-height: 30px; }

		.offer .offer_li .desc_wrapper .title h3 { font-size: 26px; line-height: 26px; }
		.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 26px; line-height: 26px; }

		.pricing-box .plan-header h2 { font-size: 21px; line-height: 21px; }
		.pricing-box .plan-header .price > span { font-size: 32px; line-height: 32px; }
		.pricing-box .plan-header .price sup.currency { font-size: 14px; line-height: 14px; }
		.pricing-box .plan-header .price sup.period { font-size: 13px; line-height: 13px;}

		.quick_fact .number-wrapper { font-size: 60px; line-height: 60px;}

		.trailer_box .desc h2 { font-size: 21px; line-height: 21px; }

		.widget > h3 { font-size: 15px; line-height: 18px; }
	}

<?php endif; ?>

/**
 * Sidebar | Width ********************************************************************************
 */

<?php
	$sidebarW = mfn_opts_get('sidebar-width', '23');
	$contentW = 100 - $sidebarW;
	$sidebar2W = $sidebarW - 5;
	$content2W = 100 - ($sidebar2W * 2);
	$sidebar2M = $content2W + $sidebar2W;
	$content2M = $sidebar2W;
?>

.with_aside .sidebar.columns {
	width: <?php echo esc_attr($sidebarW); ?>%;
}
.with_aside .sections_group {
	width: <?php echo esc_attr($contentW); ?>%;
}

.aside_both .sidebar.columns {
	width: <?php echo esc_attr($sidebar2W); ?>%;
}
.aside_both .sidebar.sidebar-1{
	margin-left: -<?php echo esc_attr($sidebar2M); ?>%;
}
.aside_both .sections_group {
	width: <?php echo esc_attr($content2W); ?>%;
	margin-left: <?php echo esc_attr($content2M); ?>%;
}

/**
 * Grid | Width ********************************************************************************
 */

<?php if (mfn_opts_get('responsive')): ?>

	<?php
		$gridW = mfn_opts_get('grid-width', 1240);
	?>

	@media only screen and (min-width:1240px){
		#Wrapper, .with_aside .content_wrapper {
			max-width: <?php echo esc_attr($gridW); ?>px;
		}
		body.layout-boxed.mfn-header-scrolled .mfn-header-tmpl.mfn-sticky-layout-width{
			max-width: <?php echo esc_attr($gridW); ?>px;
			left: 0;
			right: 0;
			margin-left: auto;
			margin-right: auto;
		}
		body.layout-boxed:not(.mfn-header-scrolled) .mfn-header-tmpl.mfn-header-layout-width,
		body.layout-boxed .mfn-header-tmpl.mfn-header-layout-width:not(.mfn-hasSticky){
			max-width: <?php echo esc_attr($gridW); ?>px;
			left: 0;
			right: 0;
			margin-left: auto;
			margin-right: auto;
		}
		body.layout-boxed.mfn-bebuilder-header.mfn-ui .mfn-only-sample-content{ max-width: <?php echo esc_attr($gridW); ?>px; margin-left: auto; margin-right: auto;}
		.section_wrapper, .container {
			max-width: <?php echo esc_attr($gridW - 20); ?>px;
		}
		.layout-boxed.header-boxed #Top_bar.is-sticky{
			max-width: <?php echo esc_attr($gridW); ?>px;
		}
	}

	<?php
		if ($box_padding = mfn_opts_get('layout-boxed-padding')):
	?>

		@media only screen and (min-width:768px){

			.layout-boxed #Subheader .container,
			.layout-boxed:not(.with_aside) .section:not(.full-width),
			.layout-boxed.with_aside .content_wrapper,
			.layout-boxed #Footer .container { padding-left: <?php echo esc_attr($box_padding); ?>; padding-right: <?php echo esc_attr($box_padding); ?>;}

			.layout-boxed.header-modern #Action_bar .container,
			.layout-boxed.header-modern #Top_bar:not(.is-sticky) .container { padding-left: <?php echo esc_attr($box_padding); ?>; padding-right: <?php echo esc_attr($box_padding); ?>;}
		}

	<?php endif; ?>

	<?php
		$mobileGridW = mfn_opts_get('mobile-grid-width', 700);
	?>

	@media only screen and (max-width: 767px){
		.content_wrapper .section_wrapper,
		.container,
		.four.columns .widget-area { max-width: <?php echo esc_attr($mobileGridW + 70); ?>px !important; }
	}

<?php endif; ?>

/**
 * WOO Lightbox ********************************************************************************
 */

 <?php if( mfn_opts_get('product-lightbox-caption') == 'off' ){ ?> body .pswp .pswp__caption{ display: none; }<?php } ?>
 <?php if( mfn_opts_get('product-lightbox-bg') ){ ?> body .pswp .pswp__bg{ background-color: <?php echo mfn_opts_get('product-lightbox-bg');?>; }<?php } ?>

/**
 * Buttons ********************************************************************************
 */

.button-default .button, .button-flat .button, .button-round .button {
	background-color: <?php echo esc_attr(mfn_opts_get('background-button', '#f7f7f7')) ?>;
	color: <?php echo esc_attr(mfn_opts_get('color-button', '#747474')) ?>;
}

.button-stroke .button {
	border-color: <?php echo esc_attr(mfn_opts_get('background-button', '#f7f7f7')) ?>;
	color: <?php echo esc_attr(mfn_opts_get('color-button', '#747474')) ?>;
}

.button-stroke .button:hover{
	background-color: <?php echo esc_attr(mfn_opts_get('background-button', '#f7f7f7')) ?>;
	color: #fff;
}

/* button | theme */

.button-default .button_theme, .button-default button,
.button-default input[type="button"], .button-default input[type="reset"], .button-default input[type="submit"],
.button-flat .button_theme, .button-flat button,
.button-flat input[type="button"], .button-flat input[type="reset"], .button-flat input[type="submit"],
.button-round .button_theme, .button-round button,
.button-round input[type="button"], .button-round input[type="reset"], .button-round input[type="submit"],
.woocommerce #respond input#submit,.woocommerce a.button:not(.default),.woocommerce button.button,.woocommerce input.button,
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover{
	color: <?php echo esc_attr(mfn_opts_get('color-button-theme', '#ffffff')) ?>;
}

/* button | woocommerce */

.button-default #respond input#submit.alt.disabled,
.button-default #respond input#submit.alt.disabled:hover,
.button-default #respond input#submit.alt:disabled,
.button-default #respond input#submit.alt:disabled:hover,
.button-default #respond input#submit.alt:disabled[disabled],
.button-default #respond input#submit.alt:disabled[disabled]:hover,
.button-default a.button.alt.disabled,
.button-default a.button.alt.disabled:hover,
.button-default a.button.alt:disabled,
.button-default a.button.alt:disabled:hover,
.button-default a.button.alt:disabled[disabled],
.button-default a.button.alt:disabled[disabled]:hover,
.button-default button.button.alt.disabled,
.button-default button.button.alt.disabled:hover,
.button-default button.button.alt:disabled,
.button-default button.button.alt:disabled:hover,
.button-default button.button.alt:disabled[disabled],
.button-default button.button.alt:disabled[disabled]:hover,
.button-default input.button.alt.disabled,
.button-default input.button.alt.disabled:hover,
.button-default input.button.alt:disabled,
.button-default input.button.alt:disabled:hover,
.button-default input.button.alt:disabled[disabled],
.button-default input.button.alt:disabled[disabled]:hover,
.button-default #respond input#submit.alt,
.button-default a.button.alt,
.button-default button.button.alt,
.button-default input.button.alt,
.button-default #respond input#submit.alt:hover,
.button-default a.button.alt:hover,
.button-default button.button.alt:hover,
.button-default input.button.alt:hover,
.button-flat #respond input#submit.alt.disabled,
.button-flat #respond input#submit.alt.disabled:hover,
.button-flat #respond input#submit.alt:disabled,
.button-flat #respond input#submit.alt:disabled:hover,
.button-flat #respond input#submit.alt:disabled[disabled],
.button-flat #respond input#submit.alt:disabled[disabled]:hover,
.button-flat a.button.alt.disabled,
.button-flat a.button.alt.disabled:hover,
.button-flat a.button.alt:disabled,
.button-flat a.button.alt:disabled:hover,
.button-flat a.button.alt:disabled[disabled],
.button-flat a.button.alt:disabled[disabled]:hover,
.button-flat button.button.alt.disabled,
.button-flat button.button.alt.disabled:hover,
.button-flat button.button.alt:disabled,
.button-flat button.button.alt:disabled:hover,
.button-flat button.button.alt:disabled[disabled],
.button-flat button.button.alt:disabled[disabled]:hover,
.button-flat input.button.alt.disabled,
.button-flat input.button.alt.disabled:hover,
.button-flat input.button.alt:disabled,
.button-flat input.button.alt:disabled:hover,
.button-flat input.button.alt:disabled[disabled],
.button-flat input.button.alt:disabled[disabled]:hover,
.button-flat #respond input#submit.alt,
.button-flat a.button.alt,
.button-flat button.button.alt,
.button-flat input.button.alt,
.button-flat #respond input#submit.alt:hover,
.button-flat a.button.alt:hover,
.button-flat button.button.alt:hover,
.button-flat input.button.alt:hover,
.button-round #respond input#submit.alt.disabled,
.button-round #respond input#submit.alt.disabled:hover,
.button-round #respond input#submit.alt:disabled,
.button-round #respond input#submit.alt:disabled:hover,
.button-round #respond input#submit.alt:disabled[disabled],
.button-round #respond input#submit.alt:disabled[disabled]:hover,
.button-round a.button.alt.disabled,
.button-round a.button.alt.disabled:hover,
.button-round a.button.alt:disabled,
.button-round a.button.alt:disabled:hover,
.button-round a.button.alt:disabled[disabled],
.button-round a.button.alt:disabled[disabled]:hover,
.button-round button.button.alt.disabled,
.button-round button.button.alt.disabled:hover,
.button-round button.button.alt:disabled,
.button-round button.button.alt:disabled:hover,
.button-round button.button.alt:disabled[disabled],
.button-round button.button.alt:disabled[disabled]:hover,
.button-round input.button.alt.disabled,
.button-round input.button.alt.disabled:hover,
.button-round input.button.alt:disabled,
.button-round input.button.alt:disabled:hover,
.button-round input.button.alt:disabled[disabled],
.button-round input.button.alt:disabled[disabled]:hover,
.button-round #respond input#submit.alt,
.button-round a.button.alt,
.button-round button.button.alt,
.button-round input.button.alt,
.button-round #respond input#submit.alt:hover,
.button-round a.button.alt:hover,
.button-round button.button.alt:hover,
.button-round input.button.alt:hover{
	background-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
	color: <?php echo esc_attr(mfn_opts_get('color-button-theme', '#ffffff')) ?>;
}

.button-stroke.woocommerce a.button:not(.default),
.button-stroke .woocommerce a.button:not(.default),
.button-stroke #respond input#submit.alt.disabled,
.button-stroke #respond input#submit.alt.disabled:hover,
.button-stroke #respond input#submit.alt:disabled,
.button-stroke #respond input#submit.alt:disabled:hover,
.button-stroke #respond input#submit.alt:disabled[disabled],
.button-stroke #respond input#submit.alt:disabled[disabled]:hover,
.button-stroke a.button.alt.disabled,
.button-stroke a.button.alt.disabled:hover,
.button-stroke a.button.alt:disabled,
.button-stroke a.button.alt:disabled:hover,
.button-stroke a.button.alt:disabled[disabled],
.button-stroke a.button.alt:disabled[disabled]:hover,
.button-stroke button.button.alt.disabled,
.button-stroke button.button.alt.disabled:hover,
.button-stroke button.button.alt:disabled,
.button-stroke button.button.alt:disabled:hover,
.button-stroke button.button.alt:disabled[disabled],
.button-stroke button.button.alt:disabled[disabled]:hover,
.button-stroke input.button.alt.disabled,
.button-stroke input.button.alt.disabled:hover,
.button-stroke input.button.alt:disabled,
.button-stroke input.button.alt:disabled:hover,
.button-stroke input.button.alt:disabled[disabled],
.button-stroke input.button.alt:disabled[disabled]:hover,
.button-stroke #respond input#submit.alt,
.button-stroke a.button.alt,
.button-stroke button.button.alt,
.button-stroke input.button.alt{
	border-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
	background: none;
	color: <?php echo esc_attr(mfn_opts_get('color-theme', '#ffffff')) ?>;
}

.button-stroke.woocommerce a.button:not(.default):hover,
.button-stroke .woocommerce a.button:not(.default):hover,
.button-stroke #respond input#submit.alt:hover,
.button-stroke a.button.alt:hover,
.button-stroke button.button.alt:hover,
.button-stroke input.button.alt:hover,
.button-stroke a.action_button:hover{
	background-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
	color: <?php echo esc_attr(mfn_opts_get('color-button-theme', '#ffffff')) ?>;
}

/* button | action */

.action_button, .action_button:hover{
	background-color: <?php echo esc_attr(mfn_opts_get('background-action-button', '#0089f7')) ?>;
	color: <?php echo esc_attr(mfn_opts_get('color-action-button', '#ffffff')) ?>;
}
.button-stroke a.action_button{
	border-color: <?php echo esc_attr(mfn_opts_get('background-action-button', '#0089f7')) ?>;
}

/* button | footer */

.footer_button{
	color: <?php echo esc_attr(mfn_opts_get('color-footer-backtotop', '#65666C')) ?>!important;
	<?php if ( mfn_opts_get( 'background-footer-backtotop' ) ) : ?>
		background: <?php echo esc_attr(mfn_opts_get('background-footer-backtotop')) ?>;
	<?php else: ?>
		background-color:transparent;
		box-shadow:none!important;
	<?php endif; ?>
}

<?php if( mfn_opts_get( 'background-footer-backtotop' ) ) : ?>
.button-stroke .footer_button{
	border-color: <?php echo esc_attr(mfn_opts_get('background-footer-backtotop')) ?>;
}
.button-stroke .footer_button:hover{
	background-color: <?php echo esc_attr(mfn_opts_get('background-footer-backtotop')) ?> !important;
}
<?php else : ?>
.footer_button:after{
	display:none!important;
}
<?php endif; ?>

/* button | custom */

<?php
	$button_font = shortcode_atts( array(
		'size' => 14,
		'weight_style' => 400,
		'letter_spacing' => 0,
	), mfn_opts_get( 'button-font' ));

	$button_padding = mfn_opts_get( 'button-padding' );

?>

.button-custom.woocommerce .button,.button-custom .button,.button-custom .action_button,.button-custom .footer_button,.button-custom button,.button-custom button.button,
.button-custom input[type="button"],.button-custom input[type="reset"],.button-custom input[type="submit"],
.button-custom .woocommerce #respond input#submit,.button-custom .woocommerce a.button,.button-custom .woocommerce button.button,.button-custom .woocommerce input.button{
	font-family: <?php echo esc_attr( str_replace( '#', '', mfn_opts_get('button-font-family') ) ) ?>;
	font-size: <?php echo esc_attr( $button_font['size'] ); ?>px;
	line-height: <?php echo esc_attr( $button_font['size'] ); ?>px;
	font-weight: <?php echo esc_attr( str_replace( 'italic', '', $button_font['weight_style'] ) ); ?>;
	letter-spacing: <?php echo esc_attr( $button_font['letter_spacing'] ); ?>px;
	<?php
		if ( strpos( $button_font['weight_style'], 'italic' ) ) {
			echo 'font-style:italic;';
		}
	?>
	padding: <?php echo mfn_opts_get( 'button-padding', '12px 20px', [ 'implode' => ' ', 'unit' => 'px' ] ); ?>;
	border-width: <?php echo mfn_opts_get( 'button-border-width', 0, [ 'unit' => 'px' ] ); ?>;
	border-radius: <?php echo mfn_opts_get( 'button-border-radius', 0, [ 'unit' => 'px' ] ); ?>;
	<?php
		if ( ! empty( mfn_opts_get( 'button-box-shadow' ) ) ) {
			echo 'box-shadow:'. mfn_opts_get( 'button-box-shadow' );
		}
	?>
}

body.button-custom .button{
	color: <?php echo mfn_opts_get( 'button-color', '#626262', [ 'key' => 'normal' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-background', '#dbdddf', [ 'key' => 'normal' ] ); ?>;
	border-color: <?php echo mfn_opts_get( 'button-border-color', 'transparent', [ 'key' => 'normal', 'not_empty' => true ] ); ?>;
}
body.button-custom .button:hover{
	color: <?php echo mfn_opts_get( 'button-color', '#626262', [ 'key' => 'hover' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-background', '#d3d3d3', [ 'key' => 'hover' ] ); ?>;
	border-color: <?php echo mfn_opts_get( 'button-border-color', 'transparent', [ 'key' => 'hover', 'not_empty' => true ] ); ?>;
}

body .button-custom .button_theme,body.button-custom .button_theme,.button-custom button,.button-custom input[type="button"],.button-custom input[type="reset"],.button-custom input[type="submit"],
.button-custom .woocommerce #respond input#submit,body.button-custom.woocommerce a.button:not(.default),.button-custom .woocommerce button.button,.button-custom .woocommerce input.button,.button-custom .woocommerce a.button_theme:not(.default){
	color: <?php echo mfn_opts_get( 'button-highlighted-color', '#ffffff', [ 'key' => 'normal' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-highlighted-background', '#0095eb', [ 'key' => 'normal' ] ); ?>;
	border-color: <?php echo mfn_opts_get( 'button-highlighted-border-color', 'transparent', [ 'key' => 'normal', 'not_empty' => true ] ); ?>;
	<?php
		if ( ! empty( mfn_opts_get( 'button-highlighted-box-shadow' ) ) ) {
			echo 'box-shadow:'. mfn_opts_get( 'button-highlighted-box-shadow' );
		} else {
			echo 'box-shadow:unset';
		}
	?>
}

body .button-custom .button_theme:hover,body.button-custom .button_theme:hover,.button-custom button:hover,.button-custom input[type="button"]:hover,.button-custom input[type="reset"]:hover,.button-custom input[type="submit"]:hover,
.button-custom .woocommerce #respond input#submit:hover,body.button-custom.woocommerce a.button:not(.default):hover,.button-custom .woocommerce button.button:hover,.button-custom .woocommerce input.button:hover,.button-custom .woocommerce a.button_theme:not(.default):hover{
	color: <?php echo mfn_opts_get( 'button-highlighted-color', '#ffffff', [ 'key' => 'hover' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-highlighted-background', '#007cc3', [ 'key' => 'hover' ] ); ?>;
	border-color: <?php echo mfn_opts_get( 'button-highlighted-border-color', 'transparent', [ 'key' => 'hover', 'not_empty' => true ] ); ?>;
}

body.button-custom .action_button{
	color: <?php echo mfn_opts_get( 'button-action-color', '#626262', [ 'key' => 'normal' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-action-background', '#dbdddf', [ 'key' => 'normal' ] ); ?>;
	border-color: <?php echo mfn_opts_get( 'button-action-border-color', 'transparent', [ 'key' => 'normal', 'not_empty' => true ] ); ?>;
	<?php
		if ( ! empty( mfn_opts_get( 'button-action-box-shadow' ) ) ) {
			echo 'box-shadow:'. mfn_opts_get( 'button-action-box-shadow' );
		} else {
			echo 'box-shadow:unset';
		}
	?>
}
body.button-custom .action_button:hover{
	color: <?php echo mfn_opts_get( 'button-action-color', '#626262', [ 'key' => 'hover' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-action-background', '#d3d3d3', [ 'key' => 'hover' ] ); ?>;
	border-color: <?php echo mfn_opts_get( 'button-action-border-color', 'transparent', [ 'key' => 'hover', 'not_empty' => true ] ); ?>;
}

/* button | custom woocommerce */

.button-custom #respond input#submit.alt.disabled,
.button-custom #respond input#submit.alt.disabled:hover,
.button-custom #respond input#submit.alt:disabled,
.button-custom #respond input#submit.alt:disabled:hover,
.button-custom #respond input#submit.alt:disabled[disabled],
.button-custom #respond input#submit.alt:disabled[disabled]:hover,
.button-custom a.button.alt.disabled,
.button-custom a.button.alt.disabled:hover,
.button-custom a.button.alt:disabled,
.button-custom a.button.alt:disabled:hover,
.button-custom a.button.alt:disabled[disabled],
.button-custom a.button.alt:disabled[disabled]:hover,
.button-custom button.button.alt.disabled,
.button-custom button.button.alt.disabled:hover,
.button-custom button.button.alt:disabled,
.button-custom button.button.alt:disabled:hover,
.button-custom button.button.alt:disabled[disabled],
.button-custom button.button.alt:disabled[disabled]:hover,
.button-custom input.button.alt.disabled,
.button-custom input.button.alt.disabled:hover,
.button-custom input.button.alt:disabled,
.button-custom input.button.alt:disabled:hover,
.button-custom input.button.alt:disabled[disabled],
.button-custom input.button.alt:disabled[disabled]:hover,
.button-custom #respond input#submit.alt,
.button-custom a.button.alt,
.button-custom button.button.alt,
.button-custom input.button.alt{
	line-height: <?php echo esc_attr( $button_font['size'] ); ?>px;
	padding: <?php echo mfn_opts_get( 'button-padding', '12px 20px', [ 'implode' => ' ', 'unit' => 'px' ] ); ?>;
	color: <?php echo mfn_opts_get( 'button-highlighted-color', '#ffffff', [ 'key' => 'normal' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-highlighted-background', '#0095eb', [ 'key' => 'normal' ] ); ?>;
	font-family: <?php echo esc_attr( str_replace( '#', '', mfn_opts_get('button-font-family') ) ) ?>;
	font-size: <?php echo esc_attr( $button_font['size'] ); ?>px;
	font-weight: <?php echo esc_attr( str_replace( 'italic', '', $button_font['weight_style'] ) ); ?>;
	letter-spacing: <?php echo esc_attr( $button_font['letter_spacing'] ); ?>px;
	border-width: <?php echo mfn_opts_get( 'button-border-width', 0, [ 'unit' => 'px' ] ); ?>;
	border-radius: <?php echo mfn_opts_get( 'button-border-radius', 0, [ 'unit' => 'px' ] ); ?>;
}
.button-custom #respond input#submit.alt:hover,
.button-custom a.button.alt:hover,
.button-custom button.button.alt:hover,
.button-custom input.button.alt:hover,
.button-custom a.action_button:hover{
	color: <?php echo mfn_opts_get( 'button-highlighted-color', '#ffffff', [ 'key' => 'hover' ] ); ?>;
	background-color: <?php echo mfn_opts_get( 'button-highlighted-background', '#007cc3', [ 'key' => 'hover' ] ); ?>;
}

/**
 * Logo ********************************************************************************
 */

<?php
	$aLogo = array(
		'height' => intval(mfn_opts_get('logo-height', 60)),
		'vertical_padding' => intval(mfn_opts_get('logo-vertical-padding', 15)),
	);

	$aLogo['top_bar_right_H'] = $aLogo['height'] + ($aLogo['vertical_padding'] * 2);
	$aLogo['top_bar_right_T'] = ($aLogo['top_bar_right_H'] / 2) - 20;

	$aLogo['menu_padding'] = ($aLogo['top_bar_right_H'] / 2) - 30;
	$aLogo['menu_margin'] = ($aLogo['top_bar_right_H'] / 2) - 25;
	// $aLogo['responsive_menu_T'] = ($aLogo['height'] / 2) + 10; /* mobile logo | margin: 10px */

	$aLogo['header_fixed_LH'] = ($aLogo['top_bar_right_H'] - 30) / 2 ;
?>

#Top_bar #logo,
.header-fixed #Top_bar #logo,
.header-plain #Top_bar #logo,
.header-transparent #Top_bar #logo {
	height: <?php echo esc_attr($aLogo['height']); ?>px;
	line-height: <?php echo esc_attr($aLogo['height']); ?>px;
	padding: <?php echo esc_attr($aLogo['vertical_padding']); ?>px 0;
}
.logo-overflow #Top_bar:not(.is-sticky) .logo {
  height: <?php echo esc_attr($aLogo['top_bar_right_H']); ?>px;
}
#Top_bar .menu > li > a {
  padding: <?php echo esc_attr($aLogo['menu_padding']); ?>px 0;
}
.menu-highlight:not(.header-creative) #Top_bar .menu > li > a {
	margin: <?php echo esc_attr($aLogo['menu_margin']); ?>px 0;
}
.header-plain:not(.menu-highlight) #Top_bar .menu > li > a span:not(.description) {
  line-height: <?php echo esc_attr($aLogo['top_bar_right_H']); ?>px;
}
.header-fixed #Top_bar .menu > li > a {
  padding: <?php echo esc_attr($aLogo['header_fixed_LH']); ?>px 0;
}

<?php if (! $aLogo['vertical_padding']): ?>
.logo-overflow #Top_bar.is-sticky #logo{padding:0!important;}
<?php endif; ?>

<?php if ($aLogo['vertical_padding']): ?>
@media only screen and (max-width: 767px){
	.mobile-header-mini #Top_bar #logo{
		height:50px!important;
		line-height:50px!important;
		margin:5px 0;
	}
}
<?php endif; ?>

<?php

	// SVG logo width

	$logo_width = mfn_opts_get( 'logo-width', 100 );
	echo '#Top_bar #logo img.svg{width:'. $logo_width .'px}';

	if( $logo_width_tablet = mfn_opts_get( 'logo-width-tablet' ) ){
		echo '@media(max-width: 959px){
			#Top_bar #logo img.svg{width:'. $logo_width_tablet .'px}
		}';
	}

	if( $logo_width_mobile = mfn_opts_get( 'logo-width-mobile' ) ){
		echo '@media(max-width: 767px){
			#Top_bar #logo img.svg{width:'. $logo_width_mobile .'px}
		}';
	}

?>

/**
 * Other ********************************************************************************
 */

/* Image frame */

.image_frame,.wp-caption{
	border-width:<?php echo esc_attr(mfn_opts_get('image-frame-border-width', 0, ['unit' => 'px'])); ?>
}

/* Alerts */

<?php
	$alert_border_radius = mfn_opts_get('alert-border-radius', 0, ['unit' => 'px']);
?>

<?php if ($alert_border_radius): ?>

	.alert{
		border-radius:<?php echo esc_attr($alert_border_radius); ?>
	}

<?php endif; ?>

/* Search + Live search */

#Top_bar .top_bar_right .top-bar-right-input input{
	width:<?php echo mfn_opts_get('header-search-input-width', 200, ['unit' => 'px']); ?>
}

.mfn-live-search-box .mfn-live-search-list{
	max-height:<?php echo mfn_opts_get('header-search-live-container-height', 300, ['unit' => 'px']); ?>
}

/* Form | Border width */

<?php
	$form_border_width = trim(mfn_opts_get('form-border-width'));
	if( $form_border_width || ($form_border_width === '0') ):
?>

	input[type="date"],input[type="email"],input[type="number"],input[type="password"],input[type="search"],
	input[type="tel"],input[type="text"],input[type="url"],select,textarea,.woocommerce .quantity input.qty{
		border-width:<?php echo esc_attr($form_border_width); ?>;
		<?php if ($form_border_width != '1px'): ?>
			box-shadow:unset;
			resize:none;
		<?php endif; ?>
	}

	.select2-container--default .select2-selection--single,.select2-dropdown,
	.select2-container--default.select2-container--open .select2-selection--single{
		border-width:<?php echo esc_attr($form_border_width); ?>;
	}

<?php endif; ?>

<?php
	$form_border_radius = trim(mfn_opts_get('form-border-radius'));
	if( is_numeric( $form_border_radius ) ){
		$form_border_radius .= 'px';
	}
?>

<?php if ($form_border_radius): ?>

	input[type="date"],input[type="email"],input[type="number"],input[type="password"],input[type="search"],
	input[type="tel"],input[type="text"],input[type="url"],select,textarea,.woocommerce .quantity input.qty{
		border-radius:<?php echo esc_attr($form_border_radius); ?>
	}

	.select2-container--default .select2-selection--single,
	.select2-dropdown, .select2-container--default.select2-container--open .select2-selection--single{
		border-radius:<?php echo esc_attr($form_border_radius); ?>
	}

<?php endif; ?>

/* Side Slide */

#Side_slide{
	right:-<?php echo esc_attr(mfn_opts_get('responsive-side-slide-width', 250)); ?>px;
	width:<?php echo esc_attr(mfn_opts_get('responsive-side-slide-width', 250)); ?>px;
}
#Side_slide.left{
	left:-<?php echo esc_attr(mfn_opts_get('responsive-side-slide-width', 250)); ?>px;
}

/* Other */

/* Blog teaser | Android phones 1pt line fix - do NOT move it somewhere else */

.blog-teaser li .desc-wrapper .desc{background-position-y:-1px;}

/**
 * Responsive ********************************************************************************
 */

@media only screen and ( max-width: 767px ){
	<?php if ( trim( mfn_opts_get( 'mobile-header-height' ) ) || '0' === mfn_opts_get( 'mobile-header-height' ) ) : ?>
		body:not(.template-slider) #Header{
			min-height: <?php echo esc_attr( mfn_opts_get( 'mobile-header-height', false, [ 'unit' => 'px' ] ) ); ?>;
		}
	<?php endif; ?>
	<?php if ( trim( mfn_opts_get( 'mobile-subheader-padding' ) ) || '0' === mfn_opts_get( 'mobile-subheader-padding' ) ) : ?>
		#Subheader{
			padding: <?php echo esc_attr( mfn_opts_get( 'mobile-subheader-padding', false, [ 'unit' => 'px' ] ) ); ?>;
		}
	<?php endif; ?>
}
