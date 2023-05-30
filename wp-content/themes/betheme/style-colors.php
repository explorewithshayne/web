<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

defined( 'ABSPATH' ) || exit;

$color_theme = mfn_opts_get('color-theme', '#0089F7');
?>
/**
 * Variables *****
 */

body{
  --mfn-clients-tiles-hover:<?php echo esc_attr($color_theme); ?>; /* Theme color */
  --mfn-icon-box-icon:<?php echo esc_attr(mfn_opts_get('color-iconbox', '#0089F7')); ?>; /* Icon box 2 - icon color */
  --mfn-sliding-box-bg:<?php echo esc_attr(mfn_opts_get('background-slidingbox-title', '#0089F7')); ?>; /* Sliding box - Title bar bg */

  --mfn-woo-body-color:<?php echo esc_attr(mfn_opts_get('color-text', '#626262')) ?>; /* Text color */
  --mfn-woo-heading-color:<?php echo esc_attr(mfn_opts_get('color-text', '#626262')) ?>; /* Text color, previously H1 #161922 */
  --mfn-woo-themecolor:<?php echo esc_attr($color_theme); ?>; /* Theme color */
  --mfn-woo-bg-themecolor:<?php echo esc_attr($color_theme); ?>; /* Theme color */
  --mfn-woo-border-themecolor:<?php echo esc_attr($color_theme); ?>; /* Theme color */
}

/**
 * Backgrounds *****
 */

#Header_wrapper, #Intro{
	background-color: <?php echo esc_attr(mfn_opts_get('background-header', '#13162f')) ?>
}
#Subheader{
	<?php
		$subheaderB = mfn_opts_get('background-subheader', '#F7F7F7');
		$subheaderA = mfn_opts_get('subheader-transparent', 100);
		$subheaderA = $subheaderA / 100;
		$subheaderA = str_replace(',', '.', $subheaderA);
	?>
	background-color:<?php echo esc_attr(mfn_hex2rgba($subheaderB, $subheaderA)); ?>
}
.header-classic #Action_bar, .header-fixed #Action_bar, .header-plain #Action_bar, .header-split #Action_bar, .header-shop #Action_bar, .header-shop-split #Action_bar, .header-stack #Action_bar{
	background-color:<?php echo esc_attr(mfn_opts_get('background-action-bar', '#101015')) ?>
}

#Sliding-top{
	background-color:<?php echo esc_attr(mfn_opts_get('background-sliding-top', '#545454')) ?>
}
#Sliding-top a.sliding-top-control{
	border-right-color:<?php echo esc_attr(mfn_opts_get('background-sliding-top', '#545454')) ?>
}
#Sliding-top.st-center a.sliding-top-control,
#Sliding-top.st-left a.sliding-top-control{
	border-top-color:<?php echo esc_attr(mfn_opts_get('background-sliding-top', '#545454')) ?>
}

#Footer {
	background-color: <?php echo esc_attr(mfn_opts_get('background-footer', '#101015')) ?>;
}

.grid .post-item, .masonry:not(.tiles) .post-item, .photo2 .post .post-desc-wrapper{
	background-color: <?php echo esc_attr(mfn_opts_get('background-archives-post', 'transparent')) ?>;
}
.portfolio_group .portfolio-item .desc{
	background-color: <?php echo esc_attr(mfn_opts_get('background-archives-portfolio', 'transparent')) ?>;
}
.woocommerce ul.products li.product, .shop_slider .shop_slider_ul li .item_wrapper .desc{
	background-color: <?php echo esc_attr(mfn_opts_get('background-archives-product', 'transparent')) ?>;
}

/**
 * Colors *****
 */

/* Content font */

body, ul.timeline_items, .icon_box a .desc, .icon_box a:hover .desc, .feature_list ul li a, .list_item a, .list_item a:hover,
.widget_recent_entries ul li a, .flat_box a, .flat_box a:hover, .story_box .desc, .content_slider.carousel  ul li a .title,
.content_slider.flat.description ul li .desc, .content_slider.flat.description ul li a .desc, .post-nav.minimal a i {
	color: <?php echo esc_attr(mfn_opts_get('color-text', '#626262')) ?>;
}
.post-nav.minimal a svg {
	fill: <?php echo esc_attr(mfn_opts_get('color-text', '#626262')) ?>;
}

/* Theme color */

<?php $theme_color = mfn_opts_get('color-theme', '#0089F7'); ?>

.themecolor, .opening_hours .opening_hours_wrapper li span, .fancy_heading_icon .icon_top,
.fancy_heading_arrows .icon-right-dir, .fancy_heading_arrows .icon-left-dir, .fancy_heading_line .title,
.button-love a.mfn-love, .format-link .post-title .icon-link, .pager-single > span, .pager-single a:hover,
.widget_meta ul, .widget_pages ul, .widget_rss ul, .widget_mfn_recent_comments ul li:after, .widget_archive ul,
.widget_recent_comments ul li:after, .widget_nav_menu ul, .woocommerce ul.products li.product .price, .shop_slider .shop_slider_ul li .item_wrapper .price,
.woocommerce-page ul.products li.product .price, .widget_price_filter .price_label .from, .widget_price_filter .price_label .to,
.woocommerce ul.product_list_widget li .quantity .amount, .woocommerce .product div.entry-summary .price, .woocommerce .product .woocommerce-variation-price .price, .woocommerce .star-rating span,
#Error_404 .error_pic i, .style-simple #Filters .filters_wrapper ul li a:hover, .style-simple #Filters .filters_wrapper ul li.current-cat a,
.style-simple .quick_fact .title, .mfn-cart-holder .mfn-ch-content .mfn-ch-product .woocommerce-Price-amount,
.woocommerce .comment-form-rating p.stars a:before, .wishlist .wishlist-row .price, .search-results .search-item .post-product-price,
.progress_icons.transparent .progress_icon.themebg{
	color: <?php echo esc_attr($theme_color) ?>;
}

.mfn-wish-button.loved:not(.link) .path {
	fill: <?php echo esc_attr($theme_color) ?>;
	stroke: <?php echo esc_attr($theme_color) ?>;
}

/* Theme background */

.themebg,#comments .commentlist > li .reply a.comment-reply-link,#Filters .filters_wrapper ul li a:hover,#Filters .filters_wrapper ul li.current-cat a,.fixed-nav .arrow,
.offer_thumb .slider_pagination a:before,.offer_thumb .slider_pagination a.selected:after,.pager .pages a:hover,.pager .pages a.active,.pager .pages span.page-numbers.current,.pager-single span:after,
.portfolio_group.exposure .portfolio-item .desc-inner .line,.Recent_posts ul li .desc:after,.Recent_posts ul li .photo .c,
.slider_pagination a.selected,.slider_pagination .slick-active a,.slider_pagination a.selected:after,.slider_pagination .slick-active a:after,
.testimonials_slider .slider_images,.testimonials_slider .slider_images a:after,.testimonials_slider .slider_images:before,
#Top_bar .header-cart-count,#Top_bar .header-wishlist-count,.mfn-footer-stickymenu ul li a .header-wishlist-count, .mfn-footer-stickymenu ul li a .header-cart-count,
.widget_categories ul,.widget_mfn_menu ul li a:hover,.widget_mfn_menu ul li.current-menu-item:not(.current-menu-ancestor) > a,.widget_mfn_menu ul li.current_page_item:not(.current_page_ancestor) > a,.widget_product_categories ul,.widget_recent_entries ul li:after,
.woocommerce-account table.my_account_orders .order-number a,.woocommerce-MyAccount-navigation ul li.is-active a,
.style-simple .accordion .question:after,.style-simple .faq .question:after,.style-simple .icon_box .desc_wrapper .title:before,.style-simple #Filters .filters_wrapper ul li a:after,.style-simple .trailer_box:hover .desc,
.tp-bullets.simplebullets.round .bullet.selected,.tp-bullets.simplebullets.round .bullet.selected:after,.tparrows.default,.tp-bullets.tp-thumbs .bullet.selected:after{
	background-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

.Latest_news ul li .photo, .Recent_posts.blog_news ul li .photo, .style-simple .opening_hours .opening_hours_wrapper li label,
.style-simple .timeline_items li:hover h3, .style-simple .timeline_items li:nth-child(even):hover h3,
.style-simple .timeline_items li:hover .desc, .style-simple .timeline_items li:nth-child(even):hover,
.style-simple .offer_thumb .slider_pagination a.selected {
	border-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

/* Links color */

a {
	color: <?php echo esc_attr(mfn_opts_get('color-a', '#006edf')) ?>;
}

a:hover {
	color: <?php echo esc_attr(mfn_opts_get('color-a-hover', '#0089f7')) ?>;
}

/* Selections */

<?php $selection_color = mfn_opts_get('color-selection', '#0089F7'); ?>
*::-moz-selection {
	background-color: <?php echo esc_attr($selection_color); ?>;
	color: <?php echo esc_attr(mfn_brightness($selection_color, 169, true)); ?>;
}
*::selection {
	background-color: <?php echo esc_attr($selection_color); ?>;
	color: <?php echo esc_attr(mfn_brightness($selection_color, 169, true)); ?>;
}

/* Grey */

.blockquote p.author span, .counter .desc_wrapper .title, .article_box .desc_wrapper p, .team .desc_wrapper p.subtitle,
.pricing-box .plan-header p.subtitle, .pricing-box .plan-header .price sup.period, .chart_box p, .fancy_heading .inside,
.fancy_heading_line .slogan, .post-meta, .post-meta a, .post-footer, .post-footer a span.label, .pager .pages a, .button-love a .label,
.pager-single a, #comments .commentlist > li .comment-author .says, .fixed-nav .desc .date, .filters_buttons li.label, .Recent_posts ul li a .desc .date,
.widget_recent_entries ul li .post-date, .tp_recent_tweets .twitter_time, .widget_price_filter .price_label, .shop-filters .woocommerce-result-count,
.woocommerce ul.product_list_widget li .quantity, .widget_shopping_cart ul.product_list_widget li dl, .product_meta .posted_in,
.woocommerce .shop_table .product-name .variation > dd, .shipping-calculator-button:after,  .shop_slider .shop_slider_ul li .item_wrapper .price del,
.woocommerce .product .entry-summary .woocommerce-product-rating .woocommerce-review-link,
.woocommerce .product.style-default .entry-summary .product_meta .tagged_as,
.woocommerce .tagged_as, .wishlist .sku_wrapper, .woocommerce .column_product_rating .woocommerce-review-link,
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__verified,
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__dash,
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__published-date,
.testimonials_slider .testimonials_slider_ul li .author span, .testimonials_slider .testimonials_slider_ul li .author span a, .Latest_news ul li .desc_footer,
.share-simple-wrapper .icons a {
	color: <?php echo esc_attr(mfn_opts_get('color-note', '#a8a8a8')) ?>;
}

/* Headings font */

h1, h1 a, h1 a:hover, .text-logo #logo{
  color:<?php echo esc_attr(mfn_opts_get('color-h1', '#161922')) ?>
}
h2, h2 a, h2 a:hover{
  color:<?php echo esc_attr(mfn_opts_get('color-h2', '#161922')) ?>
}
h3, h3 a, h3 a:hover{
  color:<?php echo esc_attr(mfn_opts_get('color-h3', '#161922')) ?>
}
h4, h4 a, h4 a:hover, .style-simple .sliding_box .desc_wrapper h4{
  color:<?php echo esc_attr(mfn_opts_get('color-h4', '#161922')) ?>
}
h5, h5 a, h5 a:hover{
  color:<?php echo esc_attr(mfn_opts_get('color-h5', '#5f6271')) ?>
}
h6, h6 a, h6 a:hover,a.content_link .title{
  color: <?php echo esc_attr(mfn_opts_get('color-h6', '#161922')) ?>
}

.woocommerce #customer_login h2{
  color:<?php echo esc_attr(mfn_opts_get('color-h3', '#161922')) ?>
} /* h3 */

.woocommerce .woocommerce-order-details__title,.woocommerce .wc-bacs-bank-details-heading,.woocommerce .woocommerce-customer-details h2,
.woocommerce #respond .comment-reply-title,.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author{
  color:<?php echo esc_attr(mfn_opts_get('color-h4', '#161922')) ?>
} /* h4 */

/* Highlight */

.dropcap, .highlight:not(.highlight_image) {
	background-color: <?php echo esc_attr(mfn_opts_get('background-highlight', '#0089F7')) ?>;
}

/* button | theme */

.button-default .button_theme, .button-default button,
.button-default input[type="button"], .button-default input[type="reset"], .button-default input[type="submit"],
.button-flat .button_theme, .button-flat button,
.button-flat input[type="button"], .button-flat input[type="reset"], .button-flat input[type="submit"],
.button-round .button_theme, .button-round button,
.button-round input[type="button"], .button-round input[type="reset"], .button-round input[type="submit"],
.woocommerce #respond input#submit,.woocommerce a.button:not(.default),.woocommerce button.button,.woocommerce input.button,
.woocommerce #respond input#submit:hover, .woocommerce a.button:not(.default):hover, .woocommerce button.button:hover, .woocommerce input.button:hover{
	background-color:<?php echo esc_attr($color_theme); ?>;
}

.button-stroke .button_theme,
.button-stroke .button_theme .button_icon i,
.button-stroke button, .button-stroke input[type="submit"], .button-stroke input[type="reset"], .button-stroke input[type="button"],
.button-stroke .woocommerce #respond input#submit,.button-stroke .woocommerce a.button:not(.default),.button-stroke .woocommerce button.button,.button-stroke.woocommerce input.button {
	border-color:<?php echo esc_attr($color_theme); ?>;
	color:<?php echo esc_attr($color_theme); ?>;
}
.button-stroke .button_theme:hover,
.button-stroke button:hover, .button-stroke input[type="submit"]:hover, .button-stroke input[type="reset"]:hover, .button-stroke input[type="button"]:hover {
	background-color:<?php echo esc_attr($color_theme); ?>;
  color:<?php echo esc_attr(mfn_brightness($color_theme, 169, true)); ?>;
}

/* button | woocommerce */

.button-default .single_add_to_cart_button, .button-flat .single_add_to_cart_button, .button-round .single_add_to_cart_button,
.button-default .woocommerce .button:disabled, .button-flat .woocommerce .button:disabled, .button-round .woocommerce .button:disabled,
.button-default .woocommerce .button.alt, .button-flat .woocommerce .button.alt, .button-round .woocommerce .button.alt{
	background-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

.button-stroke .single_add_to_cart_button:hover,
.button-stroke #place_order:hover {
	background-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

/* Fancy Link */

a.mfn-link {
	color: <?php echo esc_attr(mfn_opts_get('color-fancy-link', '#656B6F')) ?>;
}
a.mfn-link-2 span, a:hover.mfn-link-2 span:before, a.hover.mfn-link-2 span:before, a.mfn-link-5 span, a.mfn-link-8:after, a.mfn-link-8:before {
	background: <?php echo esc_attr(mfn_opts_get('background-fancy-link', '#006edf')) ?>;
}
a:hover.mfn-link {
	color: <?php echo esc_attr(mfn_opts_get('color-fancy-link-hover', '#006edf')) ?>;
}
a.mfn-link-2 span:before, a:hover.mfn-link-4:before, a:hover.mfn-link-4:after, a.hover.mfn-link-4:before, a.hover.mfn-link-4:after, a.mfn-link-5:before, a.mfn-link-7:after, a.mfn-link-7:before {
	background: <?php echo esc_attr(mfn_opts_get('background-fancy-link-hover', '#0089f7')) ?>;
}
a.mfn-link-6:before {
	border-bottom-color: <?php echo esc_attr(mfn_opts_get('background-fancy-link-hover', '#0089f7')) ?>;
}
a.mfn-link svg .path {
  stroke: <?php echo esc_attr(mfn_opts_get('color-fancy-link-hover', '#006edf')) ?>;
}

/* Lists */

.column_column ul, .column_column ol, .the_content_wrapper:not(.is-elementor) ul, .the_content_wrapper:not(.is-elementor) ol {
	color: <?php echo esc_attr(mfn_opts_get('color-list', '#737E86')) ?>;
}

/* Dividers */

hr.hr_color, .hr_color hr, .hr_dots span {
	color: <?php echo esc_attr(mfn_opts_get('color-hr', '#0089F7')) ?>;
	background: <?php echo esc_attr(mfn_opts_get('color-hr', '#0089F7')) ?>;
}
.hr_zigzag i {
	color: <?php echo esc_attr(mfn_opts_get('color-hr', '#0089F7')) ?>;
}

/* Highlight section */

.highlight-left:after,
.highlight-right:after {
	background: <?php echo esc_attr(mfn_opts_get('background-highlight-section', '#0089F7')) ?>;
}
@media only screen and (max-width: 767px) {
	.highlight-left .wrap:first-child,
	.highlight-right .wrap:last-child {
		background: <?php echo esc_attr(mfn_opts_get('background-highlight-section', '#0089F7')) ?>;
	}
}

/**
 * Header *****
 */

<?php if (mfn_opts_get('border-top-bar')): ?>
#Top_bar {
	border-bottom-color: <?php echo esc_attr(mfn_opts_get('border-top-bar')) ?>;
}
<?php endif; ?>

#Header .top_bar_left, .header-classic #Top_bar, .header-plain #Top_bar, .header-stack #Top_bar, .header-split #Top_bar, .header-shop #Top_bar, .header-shop-split #Top_bar,
.header-fixed #Top_bar, .header-below #Top_bar, #Header_creative, #Top_bar #menu, .sticky-tb-color #Top_bar.is-sticky {
	background-color: <?php echo esc_attr(mfn_opts_get('background-top-left', '#ffffff')) ?>;
}
#Top_bar .wpml-languages a.active, #Top_bar .wpml-languages ul.wpml-lang-dropdown {
	background-color: <?php echo esc_attr(mfn_opts_get('background-top-left', '#ffffff')) ?>;
}

#Top_bar .top_bar_right:before {
	background-color: <?php echo esc_attr(mfn_opts_get('background-top-middle', '#e3e3e3')) ?>;
}
#Header .top_bar_right {
	background-color: <?php echo esc_attr(mfn_opts_get('background-top-right', '#f5f5f5')) ?>;
}
#Top_bar .top_bar_right .top-bar-right-icon,
#Top_bar .top_bar_right .top-bar-right-icon svg .path {
	color: <?php echo esc_attr(mfn_opts_get('color-top-right-a', '#444444')) ?>;
	stroke: <?php echo esc_attr(mfn_opts_get('color-top-right-a', '#444444')) ?>;
}

#Top_bar .menu > li > a,
#Top_bar #menu ul li.submenu .menu-toggle {
	color: <?php echo esc_attr(mfn_opts_get('color-menu-a', '#2a2b39')) ?>;
}
#Top_bar .menu > li.current-menu-item > a,
#Top_bar .menu > li.current_page_item > a,
#Top_bar .menu > li.current-menu-parent > a,
#Top_bar .menu > li.current-page-parent > a,
#Top_bar .menu > li.current-menu-ancestor > a,
#Top_bar .menu > li.current-page-ancestor > a,
#Top_bar .menu > li.current_page_ancestor > a,
#Top_bar .menu > li.hover > a {
	color: <?php echo esc_attr(mfn_opts_get('color-menu-a-active', '#0089F7')) ?>;
}
#Top_bar .menu > li a:not(.menu-toggle):after {
	background: <?php echo esc_attr(mfn_opts_get('color-menu-a-active', '#0089F7')) ?>;
}

.menuo-arrows #Top_bar .menu > li.submenu > a > span:not(.description)::after {
	border-top-color: <?php echo esc_attr(mfn_opts_get('color-menu-a', '#2a2b39')) ?>;
}
#Top_bar .menu > li.current-menu-item.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.current_page_item.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.current-menu-parent.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.current-page-parent.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.current-menu-ancestor.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.current-page-ancestor.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.current_page_ancestor.submenu > a > span:not(.description)::after,
#Top_bar .menu > li.hover.submenu > a > span:not(.description)::after {
	border-top-color: <?php echo esc_attr(mfn_opts_get('color-menu-a-active', '#0089F7')) ?>;
}

.menu-highlight #Top_bar #menu > ul > li.current-menu-item > a,
.menu-highlight #Top_bar #menu > ul > li.current_page_item > a,
.menu-highlight #Top_bar #menu > ul > li.current-menu-parent > a,
.menu-highlight #Top_bar #menu > ul > li.current-page-parent > a,
.menu-highlight #Top_bar #menu > ul > li.current-menu-ancestor > a,
.menu-highlight #Top_bar #menu > ul > li.current-page-ancestor > a,
.menu-highlight #Top_bar #menu > ul > li.current_page_ancestor > a,
.menu-highlight #Top_bar #menu > ul > li.hover > a {
	background: <?php echo esc_attr(mfn_opts_get('background-menu-a-active', '#F2F2F2')) ?>;
}

.menu-arrow-bottom #Top_bar .menu > li > a:after {
 		border-bottom-color: <?php echo esc_attr(mfn_opts_get('color-menu-a-active', '#0089F7')) ?>;
}
.menu-arrow-top #Top_bar .menu > li > a:after {
    border-top-color: <?php echo esc_attr(mfn_opts_get('color-menu-a-active', '#0089F7')) ?>;
}

.header-plain #Top_bar .menu > li.current-menu-item > a,
.header-plain #Top_bar .menu > li.current_page_item > a,
.header-plain #Top_bar .menu > li.current-menu-parent > a,
.header-plain #Top_bar .menu > li.current-page-parent > a,
.header-plain #Top_bar .menu > li.current-menu-ancestor > a,
.header-plain #Top_bar .menu > li.current-page-ancestor > a,
.header-plain #Top_bar .menu > li.current_page_ancestor > a,
.header-plain #Top_bar .menu > li.hover > a,
.header-plain #Top_bar .wpml-languages:hover,
.header-plain #Top_bar .wpml-languages ul.wpml-lang-dropdown {
	background: <?php echo esc_attr(mfn_opts_get('background-menu-a-active', '#F2F2F2')) ?>;
	color: <?php echo esc_attr(mfn_opts_get('color-menu-a-active', '#0089F7')) ?>;
}

.header-plain #Top_bar .top_bar_right .top-bar-right-icon:hover {
	background: <?php echo esc_attr(mfn_opts_get('background-menu-a-active', '#F2F2F2')) ?>;
}

.header-plain #Top_bar,
.header-plain #Top_bar .menu > li > a span:not(.description),
.header-plain #Top_bar .top_bar_right .top-bar-right-icon,
.header-plain #Top_bar .top_bar_right .top-bar-right-button,
.header-plain #Top_bar .top_bar_right .top-bar-right-input,
.header-plain #Top_bar .wpml-languages{
	border-color: <?php echo esc_attr(mfn_opts_get('border-menu-plain', '#f2f2f2')) ?>;
}

#Top_bar .menu > li ul {
	background-color: <?php echo esc_attr(mfn_opts_get('background-submenu', '#F2F2F2')) ?>;
}
#Top_bar .menu > li ul li a {
	color: <?php echo esc_attr(mfn_opts_get('color-submenu-a', '#5f5f5f')) ?>;
}
#Top_bar .menu > li ul li a:hover,
#Top_bar .menu > li ul li.hover > a {
	color: <?php echo esc_attr(mfn_opts_get('color-submenu-a-hover', '#2e2e2e')) ?>;
}

.overlay-menu-toggle {
	color: <?php echo esc_attr(mfn_opts_get('color-menu-responsive-icon', '#0089F7')) ?> !important;
	background: <?php echo esc_attr(mfn_opts_get('background-menu-responsive-icon', 'transparent')) ?>;
}
#Overlay {
	background: <?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-overlay-menu', '#0089F7'), .95)) ?>;
}
#overlay-menu ul li a, .header-overlay .overlay-menu-toggle.focus {
	color: <?php echo esc_attr(mfn_opts_get('background-overlay-menu-a', '#ffffff')) ?>;
}
#overlay-menu ul li.current-menu-item > a,
#overlay-menu ul li.current_page_item > a,
#overlay-menu ul li.current-menu-parent > a,
#overlay-menu ul li.current-page-parent > a,
#overlay-menu ul li.current-menu-ancestor > a,
#overlay-menu ul li.current-page-ancestor > a,
#overlay-menu ul li.current_page_ancestor > a {
	color: <?php echo esc_attr(mfn_opts_get('background-overlay-menu-a-active', '#B1DCFB')) ?>;
}

#Top_bar .responsive-menu-toggle,
#Header_creative .creative-menu-toggle,
#Header_creative .responsive-menu-toggle {
	color: <?php echo esc_attr(mfn_opts_get('color-menu-responsive-icon', '#0089F7')) ?>;
	background: <?php echo esc_attr(mfn_opts_get('background-menu-responsive-icon', 'transparent')) ?>;
}

.mfn-footer-stickymenu {
	background-color:<?php echo esc_attr(mfn_opts_get('background-top-left', '#ffffff')) ?>;
}
.mfn-footer-stickymenu ul li a, .mfn-footer-stickymenu ul li a .path{
	color: <?php echo esc_attr(mfn_opts_get('color-top-right-a', '#444444')) ?>;
	stroke: <?php echo esc_attr(mfn_opts_get('color-top-right-a', '#444444')) ?>;
}

#Side_slide{
	background-color: <?php echo esc_attr(mfn_opts_get('background-side-menu', '#191919')) ?>;
	border-color: <?php echo esc_attr(mfn_opts_get('background-side-menu', '#191919')) ?>;
}

#Side_slide,
#Side_slide #menu ul li.submenu .menu-toggle,
#Side_slide .search-wrapper input.field,
#Side_slide a:not(.action_button){
	color: <?php echo esc_attr(mfn_opts_get('color-side-menu-a', '#a6a6a6')) ?>;
}
#Side_slide .extras .extras-wrapper a svg .path{
	stroke: <?php echo esc_attr(mfn_opts_get('color-side-menu-a', '#a6a6a6')) ?>;
}

#Side_slide #menu ul li.hover > .menu-toggle,
#Side_slide a.active,
#Side_slide a:not(.action_button):hover{
	color: <?php echo esc_attr(mfn_opts_get('color-side-menu-a-hover', '#ffffff')) ?>;
}
#Side_slide .extras .extras-wrapper a:hover svg .path{
	stroke: <?php echo esc_attr(mfn_opts_get('color-side-menu-a-hover', '#ffffff')) ?>;
}

#Side_slide #menu ul li.current-menu-item > a,
#Side_slide #menu ul li.current_page_item > a,
#Side_slide #menu ul li.current-menu-parent > a,
#Side_slide #menu ul li.current-page-parent > a,
#Side_slide #menu ul li.current-menu-ancestor > a,
#Side_slide #menu ul li.current-page-ancestor > a,
#Side_slide #menu ul li.current_page_ancestor > a,
#Side_slide #menu ul li.hover > a,#Side_slide #menu ul li:hover > a{
	color: <?php echo esc_attr(mfn_opts_get('color-side-menu-a-hover', '#ffffff')) ?>;
}

#Action_bar .contact_details{
	color: <?php echo esc_attr(mfn_opts_get('color-action-bar', '#bbbbbb')) ?>
}

#Action_bar .contact_details a{
	color: <?php echo esc_attr(mfn_opts_get('color-action-bar-a', '#006edf')) ?>
}

#Action_bar .contact_details a:hover{
	color: <?php echo esc_attr(mfn_opts_get('color-action-bar-a-hover', '#0089f7')) ?>
}

#Action_bar .social li a,
#Header_creative .social li a,
#Action_bar:not(.creative) .social-menu a{
	color: <?php echo esc_attr(mfn_opts_get('color-action-bar-social', '#bbbbbb')) ?>
}

#Action_bar .social li a:hover,
#Header_creative .social li a:hover,
#Action_bar:not(.creative) .social-menu a:hover{
	color: <?php echo esc_attr(mfn_opts_get('color-action-bar-social-hover', '#ffffff')) ?>
}

#Subheader .title  {
	color: <?php echo esc_attr(mfn_opts_get('color-subheader', '#161922')) ?>;
}
#Subheader ul.breadcrumbs li, #Subheader ul.breadcrumbs li a  {
	color: <?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('color-subheader', '#161922'), .6)) ?>;
}

/**
 * Footer *****
 */

.mfn-footer, .mfn-footer .widget_recent_entries ul li a {
	color: <?php echo esc_attr(mfn_opts_get('color-footer', '#bababa')) ?>;
}

.mfn-footer a:not(.button, .icon_bar, .mfn-btn, .mfn-option-btn) {
	color: <?php echo esc_attr(mfn_opts_get('color-footer-a', '#d1d1d1')) ?>;
}

.mfn-footer a:not(.button, .icon_bar, .mfn-btn, .mfn-option-btn):hover {
	color: <?php echo esc_attr(mfn_opts_get('color-footer-a-hover', '#0089f7')) ?>;
}

.mfn-footer h1, .mfn-footer h1 a, .mfn-footer h1 a:hover,
.mfn-footer h2, .mfn-footer h2 a, .mfn-footer h2 a:hover,
.mfn-footer h3, .mfn-footer h3 a, .mfn-footer h3 a:hover,
.mfn-footer h4, .mfn-footer h4 a, .mfn-footer h4 a:hover,
.mfn-footer h5, .mfn-footer h5 a, .mfn-footer h5 a:hover,
.mfn-footer h6, .mfn-footer h6 a, .mfn-footer h6 a:hover {
	color: <?php echo esc_attr(mfn_opts_get('color-footer-heading', '#ffffff')) ?>;
}

.mfn-footer .themecolor, .mfn-footer .widget_meta ul, .mfn-footer .widget_pages ul, .mfn-footer .widget_rss ul, .mfn-footer .widget_mfn_recent_comments ul li:after, .mfn-footer .widget_archive ul,
.mfn-footer .widget_recent_comments ul li:after, .mfn-footer .widget_nav_menu ul, .mfn-footer .widget_price_filter .price_label .from, .mfn-footer .widget_price_filter .price_label .to,
.mfn-footer .star-rating span {
	color: <?php echo esc_attr(mfn_opts_get('color-footer-theme', '#0089F7')) ?>;
}

.mfn-footer .themebg, .mfn-footer .widget_categories ul, .mfn-footer .Recent_posts ul li .desc:after, .mfn-footer .Recent_posts ul li .photo .c,
.mfn-footer .widget_recent_entries ul li:after, .mfn-footer .widget_mfn_menu ul li a:hover, .mfn-footer .widget_product_categories ul {
	background-color: <?php echo esc_attr(mfn_opts_get('color-footer-theme', '#0089F7')) ?>;
}

.mfn-footer .Recent_posts ul li a .desc .date, .mfn-footer .widget_recent_entries ul li .post-date, .mfn-footer .tp_recent_tweets .twitter_time,
.mfn-footer .widget_price_filter .price_label, .mfn-footer .shop-filters .woocommerce-result-count, .mfn-footer ul.product_list_widget li .quantity,
.mfn-footer .widget_shopping_cart ul.product_list_widget li dl {
	color: <?php echo esc_attr(mfn_opts_get('color-footer-note', '#a8a8a8')) ?>;
}

.mfn-footer .footer_copy .social li a,
.mfn-footer .footer_copy .social-menu a{
	color: <?php echo esc_attr(mfn_opts_get('color-footer-social', '#65666C')) ?>;
}

.mfn-footer .footer_copy .social li a:hover,
.mfn-footer .footer_copy .social-menu a:hover{
	color: <?php echo esc_attr(mfn_opts_get('color-footer-social-hover', '#ffffff')) ?>;
}

.mfn-footer .footer_copy{
	border-top-color: <?php echo esc_attr(mfn_opts_get('border-copyright', 'rgba(255,255,255,.1)')) ?>;
}

/**
 * Sliding top *****
 */

#Sliding-top, #Sliding-top .widget_recent_entries ul li a {
	color: <?php echo esc_attr(mfn_opts_get('color-sliding-top', '#cccccc')) ?>;
}

#Sliding-top a {
	color: <?php echo esc_attr(mfn_opts_get('color-sliding-top-a', '#006edf')) ?>;
}

#Sliding-top a:hover {
	color: <?php echo esc_attr(mfn_opts_get('color-sliding-top-a-hover', '#0089f7')) ?>;
}

#Sliding-top h1, #Sliding-top h1 a, #Sliding-top h1 a:hover,
#Sliding-top h2, #Sliding-top h2 a, #Sliding-top h2 a:hover,
#Sliding-top h3, #Sliding-top h3 a, #Sliding-top h3 a:hover,
#Sliding-top h4, #Sliding-top h4 a, #Sliding-top h4 a:hover,
#Sliding-top h5, #Sliding-top h5 a, #Sliding-top h5 a:hover,
#Sliding-top h6, #Sliding-top h6 a, #Sliding-top h6 a:hover {
	color: <?php echo esc_attr(mfn_opts_get('color-sliding-top-heading', '#ffffff')) ?>;
}

/* Theme color */

#Sliding-top .themecolor, #Sliding-top .widget_meta ul, #Sliding-top .widget_pages ul, #Sliding-top .widget_rss ul, #Sliding-top .widget_mfn_recent_comments ul li:after, #Sliding-top .widget_archive ul,
#Sliding-top .widget_recent_comments ul li:after, #Sliding-top .widget_nav_menu ul, #Sliding-top .widget_price_filter .price_label .from, #Sliding-top .widget_price_filter .price_label .to,
#Sliding-top .star-rating span {
	color: <?php echo esc_attr(mfn_opts_get('color-sliding-top-theme', '#0089F7')) ?>;
}

/* Theme background */

#Sliding-top .themebg, #Sliding-top .widget_categories ul, #Sliding-top .Recent_posts ul li .desc:after, #Sliding-top .Recent_posts ul li .photo .c,
#Sliding-top .widget_recent_entries ul li:after, #Sliding-top .widget_mfn_menu ul li a:hover, #Sliding-top .widget_product_categories ul {
	background-color: <?php echo esc_attr(mfn_opts_get('color-sliding-top-theme', '#0089F7')) ?>;
}

/* Grey */

#Sliding-top .Recent_posts ul li a .desc .date, #Sliding-top .widget_recent_entries ul li .post-date, #Sliding-top .tp_recent_tweets .twitter_time,
#Sliding-top .widget_price_filter .price_label, #Sliding-top .shop-filters .woocommerce-result-count, #Sliding-top ul.product_list_widget li .quantity,
#Sliding-top .widget_shopping_cart ul.product_list_widget li dl {
	color: <?php echo esc_attr(mfn_opts_get('color-sliding-top-note', '#a8a8a8')) ?>;
}

/**
 * Shortcodes *****
 */

/* Blockquote */

blockquote, blockquote a, blockquote a:hover {
	color:<?php echo esc_attr(mfn_opts_get('color-blockquote', '#444444')) ?>
}

/* Image frames & Google maps & Icon bar */

.portfolio_group.masonry-hover .portfolio-item .masonry-hover-wrapper .hover-desc,
.masonry.tiles .post-item .post-desc-wrapper .post-desc .post-title:after,.masonry.tiles .post-item.no-img,.masonry.tiles .post-item.format-quote,.blog-teaser li .desc-wrapper .desc .post-title:after,.blog-teaser li.no-img,.blog-teaser li.format-quote{
	background:<?php echo esc_attr(mfn_opts_get('background-imageframe-link', '#ffffff', [ 'key' => 'normal' ])) ?>;
}

.image_frame .image_wrapper .image_links a{
  background:<?php echo esc_attr(mfn_opts_get('background-imageframe-link', '#ffffff', [ 'key' => 'normal' ])) ?>;
	color:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'normal' ])) ?>;
  border-color:<?php echo esc_attr(mfn_opts_get('border-imageframe-link', 'transparent', [ 'key' => 'normal', 'not_empty' => true ])) ?>;
}
.image_frame .image_wrapper .image_links a.loading:after{
  border-color:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'normal' ])) ?>;
}
.image_frame .image_wrapper .image_links a .path{
  stroke:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'normal' ])) ?>;
}
.image_frame .image_wrapper .image_links a.mfn-wish-button.loved .path{
  fill:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'normal' ])) ?>;
  stroke:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'normal' ])) ?>;
}
.image_frame .image_wrapper .image_links a.mfn-wish-button.loved:hover .path{
  fill:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'hover' ])) ?>;
  stroke:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#161922', [ 'key' => 'hover' ])) ?>;
}

.image_frame .image_wrapper .image_links a:hover{
	background:<?php echo esc_attr(mfn_opts_get('background-imageframe-link', '#ffffff', [ 'key' => 'hover' ])) ?>;
	color:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#0089f7', [ 'key' => 'hover' ])) ?>;
  border-color:<?php echo esc_attr(mfn_opts_get('border-imageframe-link', 'transparent', [ 'key' => 'hover', 'not_empty' => true ])) ?>;
}
.image_frame .image_wrapper .image_links a:hover .path{
  stroke:<?php echo esc_attr(mfn_opts_get('color-imageframe-link', '#0089f7', [ 'key' => 'hover' ])) ?>;
}

.image_frame {
  	border-color: <?php echo esc_attr(mfn_opts_get('border-imageframe', '#f8f8f8')) ?>;
}
.image_frame .image_wrapper .mask::after {
  	background: <?php echo esc_attr(mfn_opts_get('color-imageframe-mask-new', 'rgba(0,0,0,.15)')) ?>;
}

/* Counter & Chart */

.counter .icon_wrapper i {
	color: <?php echo esc_attr(mfn_opts_get('color-counter', '#0089F7')) ?>;
}

/* Quick facts */

.quick_fact .number-wrapper .number {
	color: <?php echo esc_attr(mfn_opts_get('color-quickfact-number', '#0089F7')) ?>;
}

/* Progress bar */

.progress_bars .bars_list li .bar .progress {
	background-color: <?php echo esc_attr(mfn_opts_get('background-progressbar', '#0089F7')) ?>;
}

/* Icon bar */

a:hover.icon_bar {
	color: <?php echo esc_attr(mfn_opts_get('color-iconbar', '#0089F7')) ?> !important;
}

/* Content links */

a.content_link, a:hover.content_link {
	color: <?php echo esc_attr(mfn_opts_get('color-contentlink', '#0089F7')) ?>;
}
a.content_link:before {
	border-bottom-color: <?php echo esc_attr(mfn_opts_get('color-contentlink', '#0089F7')) ?>;
}
a.content_link:after {
	border-color: <?php echo esc_attr(mfn_opts_get('color-contentlink', '#0089F7')) ?>;
}

/* Get in touch & Infobox */

.mcb-item-contact_box-inner, .mcb-item-info_box-inner, .column_column .get_in_touch, .google-map-contact-wrapper {
	background-color: <?php echo esc_attr(mfn_opts_get('background-getintouch', '#0089F7')) ?>;
}
.google-map-contact-wrapper .get_in_touch:after {
	border-top-color: <?php echo esc_attr(mfn_opts_get('background-getintouch', '#0089F7')) ?>;
}

/* Timeline & Post timeline */

.timeline_items li h3:before,
.timeline_items:after,
.timeline .post-item:before {
	border-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

/* How it works */

.how_it_works .image_wrapper .number {
	background: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

/* Trailer box */

.trailer_box .desc .subtitle,
.trailer_box.plain .desc .line {
	background-color: <?php echo esc_attr(mfn_opts_get('background-trailer-subtitle', '#0089F7')) ?>;
}
.trailer_box.plain .desc .subtitle {
	color: <?php echo esc_attr(mfn_opts_get('background-trailer-subtitle', '#0089F7')) ?>;
}

/* Icon box */

.icon_box .icon_wrapper, .icon_box a .icon_wrapper,
.style-simple .icon_box:hover .icon_wrapper {
	color: <?php echo esc_attr(mfn_opts_get('color-iconbox', '#0089F7')) ?>;
}
.icon_box:hover .icon_wrapper:before,
.icon_box a:hover .icon_wrapper:before {
	background-color: <?php echo esc_attr(mfn_opts_get('color-iconbox', '#0089F7')) ?>;
}

/* List */

.list_item.lists_1 .list_left {
	background-color: <?php echo esc_attr(mfn_opts_get('color-list-icon', '#0089F7')) ?>;
}
.list_item .list_left {
	color: <?php echo esc_attr(mfn_opts_get('color-list-icon', '#0089F7')) ?>;
}

/* Features list */

.feature_list ul li .icon i {
	color: <?php echo esc_attr(mfn_opts_get('color-list-icon', '#0089F7')) ?>;
}
.feature_list ul li:hover,
.feature_list ul li:hover a {
	background: <?php echo esc_attr(mfn_opts_get('color-list-icon', '#0089F7')) ?>;
}

/* Tabs, Accordion, Toggle, Table, Faq */

.ui-tabs .ui-tabs-nav li a,.accordion .question > .title,.faq .question > .title,table th,
.fake-tabs > ul li a{
	color: <?php echo esc_attr(mfn_opts_get('color-tab', '#444444')) ?>;
}
.ui-tabs .ui-tabs-nav li.ui-state-active a,
.accordion .question.active > .title > .acc-icon-plus,
.accordion .question.active > .title > .acc-icon-minus,
.accordion .question.active > .title,
.faq .question.active > .title > .acc-icon-plus,
.faq .question.active > .title,
.fake-tabs > ul li.active a {
	color: <?php echo esc_attr(mfn_opts_get('color-tab-title', '#0089F7')) ?>;
}
.ui-tabs .ui-tabs-nav li.ui-state-active a:after,
.fake-tabs > ul li a:after, .fake-tabs > ul li a .number {
	background: <?php echo esc_attr(mfn_opts_get('color-tab-title', '#0089F7')) ?>;
}
body.table-hover:not(.woocommerce-page) table tr:hover td {
	background: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}

/* Pricing */

.pricing-box .plan-header .price sup.currency,
.pricing-box .plan-header .price > span {
	color: <?php echo esc_attr(mfn_opts_get('color-pricing-price', '#0089F7')) ?>;
}
.pricing-box .plan-inside ul li .yes {
	background: <?php echo esc_attr(mfn_opts_get('color-pricing-price', '#0089F7')) ?>;
}
.pricing-box-box.pricing-box-featured {
	background: <?php echo esc_attr(mfn_opts_get('background-pricing-featured', '#0089F7')) ?>;
}

/**
 * Alerts *****
 */

.alert_warning{
  background:<?php echo esc_attr(mfn_opts_get('background-alert-warning', '#fef8ea')) ?>
}
.alert_warning,.alert_warning a,.alert_warning a:hover,.alert_warning a.close .icon{
  color:<?php echo esc_attr(mfn_opts_get('color-alert-warning', '#8a5b20')) ?>
}
.alert_warning .path{
  stroke:<?php echo esc_attr(mfn_opts_get('color-alert-warning', '#8a5b20')) ?>
}

.alert_error{
  background:<?php echo esc_attr(mfn_opts_get('background-alert-error', '#fae9e8')) ?>
}
.alert_error,.alert_error a,.alert_error a:hover,.alert_error a.close .icon{
  color:<?php echo esc_attr(mfn_opts_get('color-alert-error', '#962317')) ?>
}
.alert_error .path{
  stroke:<?php echo esc_attr(mfn_opts_get('color-alert-error', '#962317')) ?>
}

.alert_info{
  background:<?php echo esc_attr(mfn_opts_get('background-alert-info', '#efefef')) ?>
}
.alert_info,.alert_info a,.alert_info a:hover,.alert_info a.close .icon{
  color:<?php echo esc_attr(mfn_opts_get('color-alert-info', '#57575b')) ?>
}
.alert_info .path{
  stroke:<?php echo esc_attr(mfn_opts_get('color-alert-info', '#57575b')) ?>
}

.alert_success{
  background:<?php echo esc_attr(mfn_opts_get('background-alert-success', '#eaf8ef')) ?>
}
.alert_success,.alert_success a,.alert_success a:hover,.alert_success a.close .icon{
  color:<?php echo esc_attr(mfn_opts_get('color-alert-success', '#3a8b5b')) ?>
}
.alert_success .path{
  stroke:<?php echo esc_attr(mfn_opts_get('color-alert-success', '#3a8b5b')) ?>
}

/**
 * Forms *****
 */

/* Transparency */

<?php
	$formAlpha = mfn_opts_get('form-transparent', 100);
	$formAlpha = str_replace(',', '.', ($formAlpha / 100));
?>

/* Input, Select & Textarea */

input[type="date"], input[type="email"], input[type="number"], input[type="password"], input[type="search"], input[type="tel"], input[type="text"], input[type="url"],
select, textarea, .woocommerce .quantity input.qty, .wp-block-search input[type="search"],
.dark input[type="email"],.dark input[type="password"],.dark input[type="tel"],.dark input[type="text"],.dark select,.dark textarea{
	color:<?php echo esc_attr(mfn_opts_get('color-form', '#626262')) ?>;
	background-color:<?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-form', '#ffffff'), $formAlpha)) ?>;
	border-color:<?php echo esc_attr(mfn_opts_get('border-form', '#EBEBEB')) ?>;
}
.wc-block-price-filter__controls input{ border-color:<?php echo esc_attr(mfn_opts_get('border-form', '#EBEBEB')) ?> !important; } /* Widget price border color fix */

::-webkit-input-placeholder {
	color:<?php echo esc_attr(mfn_opts_get('color-form-placeholder', '#929292')) ?>;
}
::-moz-placeholder {
  color:<?php echo esc_attr(mfn_opts_get('color-form-placeholder', '#929292')) ?>;
}
:-ms-input-placeholder {
  color:<?php echo esc_attr(mfn_opts_get('color-form-placeholder', '#929292')) ?>;
}

/* Focus */

input[type="date"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="text"]:focus, input[type="url"]:focus, select:focus, textarea:focus {
  color:<?php echo esc_attr(mfn_opts_get('color-form-focus', '#0089F7')) ?>;
  background-color:<?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-form-focus', '#e9f5fc'), $formAlpha)) ?>;
  border-color:<?php echo esc_attr(mfn_opts_get('border-form-focus', '#d5e5ee')) ?>;
}
.wc-block-price-filter__controls input:focus { border-color:<?php echo esc_attr(mfn_opts_get('border-form-focus', '#d5e5ee')) ?> !important; } /* Widget price border color fix */

select:focus{
  background-color:<?php echo esc_attr(mfn_opts_get('background-form-focus', '#e9f5fc')) ?>!important;
}

:focus::-webkit-input-placeholder {
	color:<?php echo esc_attr(mfn_opts_get('color-form-placeholder-focus', '#929292')) ?>;
}
:focus::-moz-placeholder {
  color:<?php echo esc_attr(mfn_opts_get('color-form-placeholder-focus', '#929292')) ?>;
}

/* Select 2 */

.select2-container--default .select2-selection--single{
  background-color:<?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-form', '#ffffff'), $formAlpha)) ?>;
  border-color:<?php echo esc_attr(mfn_opts_get('border-form', '#EBEBEB')) ?>;
}
.select2-dropdown{
  background-color:<?php echo esc_attr(mfn_opts_get('background-form', '#ffffff')) ?>;
  border-color:<?php echo esc_attr(mfn_opts_get('border-form', '#EBEBEB')) ?>;
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
  color:<?php echo esc_attr(mfn_opts_get('color-form', '#626262')) ?>;
}
.select2-container--default.select2-container--open .select2-selection--single{
  border-color:<?php echo esc_attr(mfn_opts_get('border-form', '#EBEBEB')) ?>;
}
.select2-container--default .select2-search--dropdown .select2-search__field{
  color:<?php echo esc_attr(mfn_opts_get('color-form', '#626262')) ?>;
  background-color:<?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-form', '#ffffff'), $formAlpha)) ?>;
  border-color:<?php echo esc_attr(mfn_opts_get('border-form', '#EBEBEB')) ?>;
}

.select2-container--default .select2-search--dropdown .select2-search__field:focus{
  color:<?php echo esc_attr(mfn_opts_get('color-form-focus', '#0089F7')) ?>;
  background-color:<?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-form-focus', '#e9f5fc'), $formAlpha)) ?> !important;
  border-color:<?php echo esc_attr(mfn_opts_get('border-form-focus', '#d5e5ee')) ?>;
} /* focus */

.select2-container--default .select2-results__option[data-selected="true"],
.select2-container--default .select2-results__option--highlighted[data-selected]{
  background-color:<?php echo esc_attr($color_theme); ?>;
  color:<?php echo esc_attr(mfn_brightness($color_theme, 169, true)); ?>;
} /* theme color + text auto */

/**
 * Shop *****
 */

.woocommerce span.onsale, .shop_slider .shop_slider_ul li .item_wrapper span.onsale {
	background-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?>;
}
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {
	border-color: <?php echo esc_attr(mfn_opts_get('color-theme', '#0089F7')) ?> !important;
}
.woocommerce div.product div.images .woocommerce-product-gallery__wrapper .zoomImg{
	background-color: <?php echo esc_attr(mfn_opts_get('background-body', '#FCFCFC')); ?>;
}

.mfn-wish-button .path{
	stroke: <?php echo esc_attr(mfn_opts_get('color-wishlist','rgba(0,0,0,.15)',[ 'key' => 'normal' ])) ?>;
}
.mfn-wish-button:hover .path {
	stroke: <?php echo esc_attr(mfn_opts_get('color-wishlist','rgba(0,0,0,.3)',[ 'key' => 'hover' ])) ?>;
}
.mfn-wish-button.loved:not(.link) .path {
	stroke: <?php echo esc_attr(mfn_opts_get('color-wishlist','rgba(0,0,0,.3)',[ 'key' => 'hover' ])) ?>;
	fill: <?php echo esc_attr(mfn_opts_get('color-wishlist','rgba(0,0,0,.3)',[ 'key' => 'hover' ])) ?>;
}

.woocommerce div.product div.images .woocommerce-product-gallery__trigger,
.woocommerce div.product div.images .mfn-wish-button,
.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger,
.woocommerce .mfn-product-gallery-grid .mfn-wish-button{
  background-color: <?php echo esc_attr(mfn_opts_get('background-shop-single-image-icon','#fff',[ 'key' => 'normal' ])) ?>;
}
.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover,
.woocommerce div.product div.images .mfn-wish-button:hover,
.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger:hover,
.woocommerce .mfn-product-gallery-grid .mfn-wish-button:hover{
  background-color: <?php echo esc_attr(mfn_opts_get('background-shop-single-image-icon','#fff',[ 'key' => 'hover' ])) ?>;
}

.woocommerce div.product div.images .woocommerce-product-gallery__trigger:before,
.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger:before{
  border-color: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#161922',[ 'key' => 'normal' ])) ?>;
}
.woocommerce div.product div.images .woocommerce-product-gallery__trigger:after,
.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger:after{
  background-color: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#161922',[ 'key' => 'normal' ])) ?>;
}
.woocommerce div.product div.images .mfn-wish-button path,
.woocommerce .mfn-product-gallery-grid .mfn-wish-button path{
  stroke: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#161922',[ 'key' => 'normal' ])) ?>;
}

.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover:before,
.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger:hover:before{
  border-color: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#0089f7',[ 'key' => 'hover' ])) ?>;
}
.woocommerce div.product div.images .woocommerce-product-gallery__trigger:hover:after,
.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger:hover:after{
  background-color: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#0089f7',[ 'key' => 'hover' ])) ?>;
}
.woocommerce div.product div.images .mfn-wish-button:hover path,
.woocommerce .mfn-product-gallery-grid .mfn-wish-button:hover path{
  stroke: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#0089f7',[ 'key' => 'hover' ])) ?>;
}
.woocommerce div.product div.images .mfn-wish-button.loved path,
.woocommerce .mfn-product-gallery-grid .mfn-wish-button.loved path{
	stroke: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#0089f7',[ 'key' => 'hover' ])) ?>;
	fill: <?php echo esc_attr(mfn_opts_get('color-shop-single-image-icon','#0089f7',[ 'key' => 'hover' ])) ?>;
}
/**
 * GDPR
 */

#mfn-gdpr{
  background-color: <?php echo esc_attr(mfn_opts_get('gdpr-container-background','#eef2f5')); ?>;
  border-radius: <?php echo mfn_opts_get( 'gdpr-container-border-radius', 0, [ 'unit' => 'px' ] ); ?>;
  <?php
    $shadow = mfn_opts_get( 'gdpr-container-box_shadow', '', [ 'unit' => 'px' ] );
    if( is_array( $shadow ) ){
      echo 'box-shadow:'. ( $shadow['inset'] ? 'inset' : '') .' '. $shadow['x'] .' '. $shadow['y'] .' '. $shadow['blur'] .' '. $shadow['spread'] .' '. $shadow['color'];
    }
  ?>
}

#mfn-gdpr .mfn-gdpr-content,
#mfn-gdpr .mfn-gdpr-content h1,
#mfn-gdpr .mfn-gdpr-content h2,
#mfn-gdpr .mfn-gdpr-content h3,
#mfn-gdpr .mfn-gdpr-content h4,
#mfn-gdpr .mfn-gdpr-content h5,
#mfn-gdpr .mfn-gdpr-content h6,
#mfn-gdpr .mfn-gdpr-content ol,
#mfn-gdpr .mfn-gdpr-content ul{
  color: <?php echo esc_attr(mfn_opts_get('gdpr-container-font_color','#626262')); ?>;
}

#mfn-gdpr .mfn-gdpr-content a,
#mfn-gdpr a.mfn-gdpr-readmore{
  color: <?php echo esc_attr(mfn_opts_get('gdpr-more-info-font_color','#161922',[ 'key' => 'normal' ])); ?>;
}

#mfn-gdpr .mfn-gdpr-content a:hover,
#mfn-gdpr a.mfn-gdpr-readmore:hover{
  color: <?php echo esc_attr(mfn_opts_get('gdpr-more-info-font_color','#0089f7',[ 'key' => 'hover' ])); ?>;
}

#mfn-gdpr .mfn-gdpr-button{
  background-color: <?php echo esc_attr(mfn_opts_get('gdpr-button-background','#006edf',[ 'key' => 'normal' ])); ?>;
  color: <?php echo esc_attr(mfn_opts_get('gdpr-button-font_color','#ffffff',[ 'key' => 'normal' ])); ?>;
  border-color: <?php echo esc_attr(mfn_opts_get('gdpr-button-border_color','transparent',[ 'key' => 'normal', 'not_empty' => true ])); ?>;
}

#mfn-gdpr .mfn-gdpr-button:hover{
  background-color: <?php echo esc_attr(mfn_opts_get('gdpr-button-background','#0089f7',[ 'key' => 'hover' ])); ?>;
  color: <?php echo esc_attr(mfn_opts_get('gdpr-button-font_color','#ffffff',[ 'key' => 'hover' ])); ?>;
  border-color: <?php echo esc_attr(mfn_opts_get('gdpr-button-border_color','transparent',[ 'key' => 'hover', 'not_empty' => true ])); ?>;
}

/**
 * Responsive *****
 */

<?php if (mfn_opts_get('responsive')): ?>

@media only screen and ( min-width: 768px ){
	.header-semi #Top_bar:not(.is-sticky) {
		background-color: <?php echo esc_attr(mfn_hex2rgba(mfn_opts_get('background-top-left', '#ffffff'), .8)) ?>;
	}
}

@media only screen and ( max-width: 767px ){
	#Top_bar{
		background-color: <?php echo esc_attr(mfn_opts_get('background-top-left', '#ffffff')) ?> !important;
	}

	#Action_bar{
		background-color: <?php echo esc_attr(mfn_opts_get('mobile-background-action-bar', '#ffffff')) ?> !important;
	}

	#Action_bar .contact_details{
		color: <?php echo esc_attr(mfn_opts_get('mobile-color-action-bar', '#222222')) ?>
	}

	#Action_bar .contact_details a{
		color: <?php echo esc_attr(mfn_opts_get('mobile-color-action-bar-a', '#006edf')) ?>
	}

	#Action_bar .contact_details a:hover{
		color: <?php echo esc_attr(mfn_opts_get('mobile-color-action-bar-a-hover', '#0089f7')) ?>
	}

	#Action_bar .social li a,
	#Action_bar .social-menu a{
		color: <?php echo esc_attr(mfn_opts_get('mobile-color-action-bar-social', '#bbbbbb')) ?>!important
	}

	#Action_bar .social li a:hover,
	#Action_bar .social-menu a:hover{
		color: <?php echo esc_attr(mfn_opts_get('mobile-color-action-bar-social-hover', '#777777')) ?>!important
	}
}

<?php endif; ?>
