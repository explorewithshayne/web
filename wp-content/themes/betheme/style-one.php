<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

defined( 'ABSPATH' ) || exit;

if( isset( $_GET['mfn-o'] ) ){
	$color_one = '#'. $_GET['mfn-o']; // demo
} else {
	$color_one = mfn_opts_get('color-one', '#2991D6');
}
?>

/**
 * Backgrounds *****
 */

#Header_wrapper, #Intro {
	background-color: #13162f;
}
#Subheader {
	<?php
		$subheaderA = mfn_opts_get('subheader-transparent', 100);
		$subheaderA = $subheaderA / 100;
		$subheaderA = str_replace(',', '.', $subheaderA);
	?>
	background-color: <?php echo esc_attr(mfn_hex2rgba('#F7F7F7', $subheaderA)); ?>;
}
.header-classic #Action_bar, .header-stack #Action_bar {
  background-color: #2C2C2C;
}

#Sliding-top {
	background-color: #545454;
}
#Sliding-top a.sliding-top-control {
	border-right-color: #545454;
}
#Sliding-top.st-center a.sliding-top-control,
#Sliding-top.st-left a.sliding-top-control {
	border-top-color: #545454;
}

#Footer {
	background-color: #545454;
}

/**
 * Colors *****
 */

/* Content font */

body, ul.timeline_items, .icon_box a .desc, .icon_box a:hover .desc, .feature_list ul li a, .list_item a, .list_item a:hover,
.widget_recent_entries ul li a, .flat_box a, .flat_box a:hover, .story_box .desc, .content_slider.carousel  ul li a .title,
.content_slider.flat.description ul li .desc, .content_slider.flat.description ul li a .desc {
	color: #626262;
}

/* Theme color */

.themecolor, .opening_hours .opening_hours_wrapper li span, .fancy_heading_icon .icon_top,
.fancy_heading_arrows .icon-right-dir, .fancy_heading_arrows .icon-left-dir, .fancy_heading_line .title,
.button-love a.mfn-love, .format-link .post-title .icon-link, .pager-single > span, .pager-single a:hover,
.widget_meta ul, .widget_pages ul, .widget_rss ul, .widget_mfn_recent_comments ul li:after, .widget_archive ul,
.widget_recent_comments ul li:after, .widget_nav_menu ul, .woocommerce ul.products li.product .price, .shop_slider .shop_slider_ul li .item_wrapper .price,
.woocommerce-page ul.products li.product .price, .widget_price_filter .price_label .from, .widget_price_filter .price_label .to,
.woocommerce ul.product_list_widget li .quantity .amount, .woocommerce .product div.entry-summary .price, .woocommerce .star-rating span,
#Error_404 .error_pic i, .style-simple #Filters .filters_wrapper ul li a:hover, .style-simple #Filters .filters_wrapper ul li.current-cat a,
.style-simple .quick_fact .title {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Theme background */

.themebg,#comments .commentlist > li .reply a.comment-reply-link,#Filters .filters_wrapper ul li a:hover,#Filters .filters_wrapper ul li.current-cat a,.fixed-nav .arrow,
.offer_thumb .slider_pagination a:before,.offer_thumb .slider_pagination a.selected:after,.pager .pages a:hover,.pager .pages a.active,.pager .pages span.page-numbers.current,.pager-single span:after,
.portfolio_group.exposure .portfolio-item .desc-inner .line,.Recent_posts ul li .desc:after,.Recent_posts ul li .photo .c,
.slider_pagination a.selected,.slider_pagination .slick-active a,.slider_pagination a.selected:after,.slider_pagination .slick-active a:after,
.testimonials_slider .slider_images,.testimonials_slider .slider_images a:after,.testimonials_slider .slider_images:before,#Top_bar .header-cart-count,#Top_bar .header-wishlist-count,
.widget_categories ul,.widget_mfn_menu ul li a:hover,.widget_mfn_menu ul li.current-menu-item:not(.current-menu-ancestor) > a,.widget_mfn_menu ul li.current_page_item:not(.current_page_ancestor) > a,.widget_product_categories ul,.widget_recent_entries ul li:after,
.woocommerce-account table.my_account_orders .order-number a,.woocommerce-MyAccount-navigation ul li.is-active a,
.style-simple .accordion .question:after,.style-simple .faq .question:after,.style-simple .icon_box .desc_wrapper .title:before,.style-simple #Filters .filters_wrapper ul li a:after,.style-simple .article_box .desc_wrapper p:after,.style-simple .sliding_box .desc_wrapper:after,.style-simple .trailer_box:hover .desc,
.tp-bullets.simplebullets.round .bullet.selected,.tp-bullets.simplebullets.round .bullet.selected:after,.tparrows.default,.tp-bullets.tp-thumbs .bullet.selected:after{
	background-color: <?php echo esc_attr($color_one); ?>;
}

.Latest_news ul li .photo, .Recent_posts.blog_news ul li .photo, .style-simple .opening_hours .opening_hours_wrapper li label,
.style-simple .timeline_items li:hover h3, .style-simple .timeline_items li:nth-child(even):hover h3,
.style-simple .timeline_items li:hover .desc, .style-simple .timeline_items li:nth-child(even):hover,
.style-simple .offer_thumb .slider_pagination a.selected {
	border-color: <?php echo esc_attr($color_one); ?>;
}

/* Links color */

a {
	color: <?php echo esc_attr($color_one); ?>;
}

a:hover {
	color: <?php echo esc_attr(mfn_hex2rgba($color_one, 0.8)); ?>;
}

/* Selections */

*::-moz-selection {
	background-color: <?php echo esc_attr($color_one); ?>;
}
*::selection {
	background-color: <?php echo esc_attr($color_one); ?>;
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
	color: #a8a8a8;
}

/* Headings font */

h1, h1 a, h1 a:hover, .text-logo #logo { color: #161922; }
h2, h2 a, h2 a:hover { color: #161922; }
h3, h3 a, h3 a:hover { color: #161922; }
h4, h4 a, h4 a:hover, .style-simple .sliding_box .desc_wrapper h4 { color: #161922; }
h5, h5 a, h5 a:hover { color: #5f6271; }
h6, h6 a, h6 a:hover,
a.content_link .title { color: #161922; }

.woocommerce #respond .comment-reply-title,
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author{color:#161922}

/* Highlight */

.dropcap, .highlight:not(.highlight_image) {
	background-color: <?php echo esc_attr($color_one) ?>;
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
	background-color: <?php echo esc_attr($color_one) ?>;
}

.button-stroke .button_theme,
.button-stroke .button_theme .button_icon i,
.button-stroke button, .button-stroke input[type="submit"], .button-stroke input[type="reset"], .button-stroke input[type="button"],
.button-stroke .woocommerce #respond input#submit,.button-stroke .woocommerce a.button:not(.default),.button-stroke .woocommerce button.button,.button-stroke.woocommerce input.button {
	border-color: <?php echo esc_attr($color_one) ?>;
	color: <?php echo esc_attr($color_one) ?> !important;
}
.button-stroke .button_theme:hover,
.button-stroke button:hover, .button-stroke input[type="submit"]:hover, .button-stroke input[type="reset"]:hover, .button-stroke input[type="button"]:hover {
	background-color: <?php echo esc_attr($color_one) ?>;
}

/* button | woocommerce */

.button-default .single_add_to_cart_button, .button-flat .single_add_to_cart_button, .button-round .single_add_to_cart_button,
.button-default .woocommerce .button:disabled, .button-flat .woocommerce .button:disabled, .button-round .woocommerce .button:disabled,
.button-default .woocommerce .button.alt, .button-flat .woocommerce .button.alt, .button-round .woocommerce .button.alt{
	background-color: <?php echo esc_attr($color_one) ?>!important;
}
.button-stroke .single_add_to_cart_button:hover,
.button-stroke #place_order:hover {
	background-color: <?php echo esc_attr($color_one) ?>!important;
}

/* Fancy Link */

a.mfn-link {
	color: #656B6F;
}
a.mfn-link-2 span, a:hover.mfn-link-2 span:before, a.hover.mfn-link-2 span:before, a.mfn-link-5 span, a.mfn-link-8:after, a.mfn-link-8:before {
	background: <?php echo esc_attr($color_one); ?>;
}
a:hover.mfn-link {
	color: <?php echo esc_attr($color_one); ?>;
}
a.mfn-link-2 span:before, a:hover.mfn-link-4:before, a:hover.mfn-link-4:after, a.hover.mfn-link-4:before, a.hover.mfn-link-4:after, a.mfn-link-5:before, a.mfn-link-7:after, a.mfn-link-7:before {
	background: <?php echo esc_attr($color_one); ?>;
}
a.mfn-link-6:before {
	border-bottom-color: <?php echo esc_attr($color_one); ?>;
}

/* Lists */

.column_column ul, .column_column ol, .the_content_wrapper ul, .the_content_wrapper ol {
	color: #737E86;
}

/* Dividers */

hr.hr_color, .hr_color hr, .hr_dots span {
	color: <?php echo esc_attr($color_one); ?>;
	background: <?php echo esc_attr($color_one); ?>;
}
.hr_zigzag i {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Highlight section */

.highlight-left:after,
.highlight-right:after {
	background: <?php echo esc_attr($color_one); ?>;
}
@media only screen and (max-width: 767px) {
	.highlight-left .wrap:first-child,
	.highlight-right .wrap:last-child {
		background: <?php echo esc_attr($color_one); ?>;
	}
}

/**
 * Header *****
 */

#Header .top_bar_left, .header-classic #Top_bar, .header-plain #Top_bar, .header-stack #Top_bar, .header-split #Top_bar,
.header-fixed #Top_bar, .header-below #Top_bar, #Header_creative, #Top_bar #menu, .sticky-tb-color #Top_bar.is-sticky {
	background-color: #ffffff;
}

#Top_bar .top_bar_right:before {
	background-color: #e3e3e3;
}
#Header .top_bar_right {
	background-color: #f5f5f5;
}

#Top_bar .menu > li > a, #Top_bar .top_bar_right a:not(.action_button) {
	color: #444444;
}
#Top_bar .menu > li.current-menu-item > a,
#Top_bar .menu > li.current_page_item > a,
#Top_bar .menu > li.current-menu-parent > a,
#Top_bar .menu > li.current-page-parent > a,
#Top_bar .menu > li.current-menu-ancestor > a,
#Top_bar .menu > li.current-page-ancestor > a,
#Top_bar .menu > li.current_page_ancestor > a,
#Top_bar .menu > li.hover > a {
	color: <?php echo esc_attr($color_one); ?>;
}
#Top_bar .menu > li a:after {
	background: <?php echo esc_attr($color_one); ?>;
}

.menu-highlight #Top_bar #menu > ul > li.current-menu-item > a,
.menu-highlight #Top_bar #menu > ul > li.current_page_item > a,
.menu-highlight #Top_bar #menu > ul > li.current-menu-parent > a,
.menu-highlight #Top_bar #menu > ul > li.current-page-parent > a,
.menu-highlight #Top_bar #menu > ul > li.current-menu-ancestor > a,
.menu-highlight #Top_bar #menu > ul > li.current-page-ancestor > a,
.menu-highlight #Top_bar #menu > ul > li.current_page_ancestor > a,
.menu-highlight #Top_bar #menu > ul > li.hover > a {
	background: <?php echo esc_attr($color_one); ?>;
}

.menu-arrow-bottom #Top_bar .menu > li > a:after {
 		border-bottom-color: <?php echo esc_attr($color_one); ?>;
}
.menu-arrow-top #Top_bar .menu > li > a:after {
    border-top-color: <?php echo esc_attr($color_one); ?>;
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
	background: #F2F2F2;
	color: <?php echo esc_attr($color_one); ?>;
}

.header-plain #Top_bar .top_bar_right .top-bar-right-icon:hover {
	background: #F2F2F2;
}

.header-plain #Top_bar,
.header-plain #Top_bar .menu > li > a span:not(.description),
.header-plain #Top_bar .top_bar_right .top-bar-right-icon,
.header-plain #Top_bar .wpml-languages,
.header-plain #Top_bar .action_button {
	border-color: #F2F2F2;
}

#Top_bar .menu > li ul {
	background-color: #F2F2F2;
}
#Top_bar .menu > li ul li a {
	color: #5f5f5f;
}
#Top_bar .menu > li ul li a:hover,
#Top_bar .menu > li ul li.hover > a {
	color: #2e2e2e;
}

#Subheader .title  {
	color: #444;
}

.overlay-menu-toggle {
	color: <?php echo esc_attr($color_one); ?> !important;
}
#Overlay {
	background: <?php echo esc_attr(mfn_hex2rgba($color_one, 0.95)); ?>;
}
#overlay-menu ul li a, .header-overlay .overlay-menu-toggle.focus {
	color: #ffffff;
}
#overlay-menu ul li.current-menu-item > a,
#overlay-menu ul li.current_page_item > a,
#overlay-menu ul li.current-menu-parent > a,
#overlay-menu ul li.current-page-parent > a,
#overlay-menu ul li.current-menu-ancestor > a,
#overlay-menu ul li.current-page-ancestor > a,
#overlay-menu ul li.current_page_ancestor > a {
	color: rgba(255, 255, 255, 0.7);
}

#Top_bar .responsive-menu-toggle,
#Header_creative .creative-menu-toggle,
#Header_creative .responsive-menu-toggle {
	color: <?php echo esc_attr($color_one); ?>;
}

/**
 * Footer *****
 */

#Footer, #Footer .widget_recent_entries ul li a {
	color: #cccccc;
}

#Footer a {
	color: <?php echo esc_attr($color_one); ?>;
}

#Footer a:hover {
	color: <?php echo esc_attr(mfn_hex2rgba($color_one, 0.8)); ?>;
}

#Footer h1, #Footer h1 a, #Footer h1 a:hover,
#Footer h2, #Footer h2 a, #Footer h2 a:hover,
#Footer h3, #Footer h3 a, #Footer h3 a:hover,
#Footer h4, #Footer h4 a, #Footer h4 a:hover,
#Footer h5, #Footer h5 a, #Footer h5 a:hover,
#Footer h6, #Footer h6 a, #Footer h6 a:hover {
	color: #ffffff;
}

/* Theme color */

.themecolor, .opening_hours .opening_hours_wrapper li span, .fancy_heading_icon .icon_top,
.fancy_heading_arrows .icon-right-dir, .fancy_heading_arrows .icon-left-dir, .fancy_heading_line .title,
.button-love a.mfn-love, .format-link .post-title .icon-link, .pager-single > span, .pager-single a:hover,
.widget_meta ul, .widget_pages ul, .widget_rss ul, .widget_mfn_recent_comments ul li:after, .widget_archive ul,
.widget_recent_comments ul li:after, .widget_nav_menu ul, .woocommerce ul.products li.product .price, .shop_slider .shop_slider_ul li .item_wrapper .price,
.woocommerce-page ul.products li.product .price, .widget_price_filter .price_label .from, .widget_price_filter .price_label .to,
.woocommerce ul.product_list_widget li .quantity .amount, .woocommerce .product div.entry-summary .price, .woocommerce .star-rating span,
#Error_404 .error_pic i, .style-simple #Filters .filters_wrapper ul li a:hover, .style-simple #Filters .filters_wrapper ul li.current-cat a,
.style-simple .quick_fact .title, .mfn-cart-holder .mfn-ch-content .mfn-ch-product .woocommerce-Price-amount,
.woocommerce .comment-form-rating p.stars a:before, .wishlist .wishlist-row .price {
	color: <?php echo esc_attr($color_one); ?>;
}

.mfn-wish-button.loved:not(.link) .path {
	fill: <?php echo esc_attr($color_one) ?>;
	stroke: <?php echo esc_attr($color_one) ?>;
}

/* Theme background */

.themebg,#comments .commentlist > li .reply a.comment-reply-link,#Filters .filters_wrapper ul li a:hover,#Filters .filters_wrapper ul li.current-cat a,.fixed-nav .arrow,
.offer_thumb .slider_pagination a:before,.offer_thumb .slider_pagination a.selected:after,.pager .pages a:hover,.pager .pages a.active,.pager .pages span.page-numbers.current,.pager-single span:after,
.portfolio_group.exposure .portfolio-item .desc-inner .line,.Recent_posts ul li .desc:after,.Recent_posts ul li .photo .c,
.slider_pagination a.selected,.slider_pagination .slick-active a,.slider_pagination a.selected:after,.slider_pagination .slick-active a:after,
.testimonials_slider .slider_images,.testimonials_slider .slider_images a:after,.testimonials_slider .slider_images:before,#Top_bar .header-cart-count,#Top_bar .header-wishlist-count,
.widget_categories ul,.widget_mfn_menu ul li a:hover,.widget_mfn_menu ul li.current-menu-item:not(.current-menu-ancestor) > a,.widget_mfn_menu ul li.current_page_item:not(.current_page_ancestor) > a,.widget_product_categories ul,.widget_recent_entries ul li:after,
.woocommerce-account table.my_account_orders .order-number a,.woocommerce-MyAccount-navigation ul li.is-active a,
.style-simple .accordion .question:after,.style-simple .faq .question:after,.style-simple .icon_box .desc_wrapper .title:before,.style-simple #Filters .filters_wrapper ul li a:after,.style-simple .article_box .desc_wrapper p:after,.style-simple .sliding_box .desc_wrapper:after,.style-simple .trailer_box:hover .desc,
.tp-bullets.simplebullets.round .bullet.selected,.tp-bullets.simplebullets.round .bullet.selected:after,.tparrows.default,.tp-bullets.tp-thumbs .bullet.selected:after,
.fake-tabs > ul li a:after, .fake-tabs > ul li a .number{
	background-color: <?php echo esc_attr($color_one); ?>;
}

/* Grey */

#Footer .Recent_posts ul li a .desc .date, #Footer .widget_recent_entries ul li .post-date, #Footer .tp_recent_tweets .twitter_time,
#Footer .widget_price_filter .price_label, #Footer .shop-filters .woocommerce-result-count, #Footer ul.product_list_widget li .quantity,
#Footer .widget_shopping_cart ul.product_list_widget li dl {
	color: #a8a8a8;
}

/**
 * Sliding Top *****
 */

#Sliding-top, #Sliding-top .widget_recent_entries ul li a {
	color: #cccccc;
}

#Sliding-top a {
	color: <?php echo esc_attr($color_one); ?>;
}

#Sliding-top a:hover {
	color: <?php echo esc_attr(mfn_hex2rgba($color_one, 0.8)); ?>;
}

#Sliding-top h1, #Sliding-top h1 a, #Sliding-top h1 a:hover,
#Sliding-top h2, #Sliding-top h2 a, #Sliding-top h2 a:hover,
#Sliding-top h3, #Sliding-top h3 a, #Sliding-top h3 a:hover,
#Sliding-top h4, #Sliding-top h4 a, #Sliding-top h4 a:hover,
#Sliding-top h5, #Sliding-top h5 a, #Sliding-top h5 a:hover,
#Sliding-top h6, #Sliding-top h6 a, #Sliding-top h6 a:hover {
	color: #ffffff;
}

/* Theme color */

#Sliding-top .themecolor, #Sliding-top .widget_meta ul, #Sliding-top .widget_pages ul, #Sliding-top .widget_rss ul, #Sliding-top .widget_mfn_recent_comments ul li:after, #Sliding-top .widget_archive ul,
#Sliding-top .widget_recent_comments ul li:after, #Sliding-top .widget_nav_menu ul, #Sliding-top .widget_price_filter .price_label .from, #Sliding-top .widget_price_filter .price_label .to,
#Sliding-top .star-rating span {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Theme background */

#Sliding-top .themebg, #Sliding-top .widget_categories ul, #Sliding-top .Recent_posts ul li .desc:after, #Sliding-top .Recent_posts ul li .photo .c,
#Sliding-top .widget_recent_entries ul li:after, #Sliding-top .widget_mfn_menu ul li a:hover, #Sliding-top .widget_product_categories ul {
	background-color: <?php echo esc_attr($color_one); ?>;
}

/* Grey */

#Sliding-top .Recent_posts ul li a .desc .date, #Sliding-top .widget_recent_entries ul li .post-date, #Sliding-top .tp_recent_tweets .twitter_time,
#Sliding-top .widget_price_filter .price_label, #Sliding-top .shop-filters .woocommerce-result-count, #Sliding-top ul.product_list_widget li .quantity,
#Sliding-top .widget_shopping_cart ul.product_list_widget li dl {
	color: #a8a8a8;
}

/**
 * Shortcodes *****
 */

/* Blockquote */

blockquote, blockquote a, blockquote a:hover {
	color: #444444;
}

/* Image frames & Google maps & Icon bar */

.image_frame .image_wrapper .image_links,
.portfolio_group.masonry-hover .portfolio-item .masonry-hover-wrapper .hover-desc {
	background: <?php echo esc_attr(mfn_hex2rgba($color_one, 0.8)); ?>;
}

.masonry.tiles .post-item .post-desc-wrapper .post-desc .post-title:after,.masonry.tiles .post-item.no-img,.masonry.tiles .post-item.format-quote,.blog-teaser li .desc-wrapper .desc .post-title:after,.blog-teaser li.no-img,.blog-teaser li.format-quote {
	background: <?php echo esc_attr($color_one); ?>;
}

.image_frame .image_wrapper .image_links a {
	color: #ffffff;
}
.image_frame .image_wrapper .image_links a:hover,
.image_frame .image_wrapper .image_links a:focus {
	background: #ffffff;
	color: <?php echo esc_attr($color_one); ?>;
}

/* Sliding box */

.sliding_box .desc_wrapper {
	background: <?php echo esc_attr($color_one); ?>;
}
.sliding_box .desc_wrapper:after {
	border-bottom-color: <?php echo esc_attr($color_one); ?>;
}

/* Counter & Chart */

.counter .icon_wrapper i {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Quick facts */

.quick_fact .number-wrapper {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Progress bar */

.progress_bars .bars_list li .bar .progress {
	background-color: <?php echo esc_attr($color_one); ?>;
}

/* Icon bar */

a:hover.icon_bar {
	color: <?php echo esc_attr($color_one); ?> !important;
}

/* Content links */

a.content_link, a:hover.content_link {
	color: <?php echo esc_attr($color_one); ?>;
}
a.content_link:before {
	border-bottom-color: <?php echo esc_attr($color_one); ?>;
}
a.content_link:after {
	border-color: <?php echo esc_attr($color_one); ?>;
}

/* Get in touch & Infobox */

.get_in_touch, .infobox {
	background-color: <?php echo esc_attr($color_one); ?>;
}
.google-map-contact-wrapper .get_in_touch:after {
	border-top-color: <?php echo esc_attr($color_one); ?>;
}

/* Timeline & Post timeline */

.timeline_items li h3:before,
.timeline_items:after,
.timeline .post-item:before {
	border-color: <?php echo esc_attr($color_one); ?>;
}

/* How it works */

.how_it_works .image .number {
	background: <?php echo esc_attr($color_one); ?>;
}

/* Trailer box */
.trailer_box .desc .subtitle,
.trailer_box.plain .desc .line {
	background-color: <?php echo esc_attr($color_one); ?>;
}
.trailer_box.plain .desc .subtitle {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Icon box */

.icon_box .icon_wrapper, .icon_box a .icon_wrapper,
.style-simple .icon_box:hover .icon_wrapper {
	color: <?php echo esc_attr($color_one); ?>;
}
.icon_box:hover .icon_wrapper:before,
.icon_box a:hover .icon_wrapper:before {
	background-color: <?php echo esc_attr($color_one); ?>;
}

/* Clients */

ul.clients.clients_tiles li .client_wrapper:hover:before {
	background: <?php echo esc_attr($color_one); ?>;
}
ul.clients.clients_tiles li .client_wrapper:after {
	border-bottom-color: <?php echo esc_attr($color_one); ?>;
}

/* List */

.list_item.lists_1 .list_left {
	background-color: <?php echo esc_attr($color_one); ?>;
}
.list_item .list_left {
	color: <?php echo esc_attr($color_one); ?>;
}

/* Features list */

.feature_list ul li .icon i {
	color: <?php echo esc_attr($color_one); ?>;
}
.feature_list ul li:hover,
.feature_list ul li:hover a {
	background: <?php echo esc_attr($color_one); ?>;
}

/* Tabs, Accordion, Toggle, Table, Faq */

.ui-tabs .ui-tabs-nav li.ui-state-active a,
.accordion .question.active > .title > .acc-icon-plus,
.accordion .question.active > .title > .acc-icon-minus,
.accordion .question.active > .title,
.faq .question.active > .title > .acc-icon-plus,
.faq .question.active > .title,
.fake-tabs > ul li.active a {
	color: <?php echo esc_attr($color_one); ?>;
}
.ui-tabs .ui-tabs-nav li.ui-state-active a:after {
	background: <?php echo esc_attr($color_one); ?>;
}
body.table-hover:not(.woocommerce-page) table tr:hover td {
	background: <?php echo esc_attr($color_one); ?>;
}

/* Pricing */

.pricing-box .plan-header .price sup.currency,
.pricing-box .plan-header .price > span {
	color: <?php echo esc_attr($color_one); ?>;
}
.pricing-box .plan-inside ul li .yes {
	background: <?php echo esc_attr($color_one); ?>;
}
.pricing-box-box.pricing-box-featured {
	background: <?php echo esc_attr($color_one); ?>;
}

/**
 * Shop *****
 */

.woocommerce span.onsale, .shop_slider .shop_slider_ul li .item_wrapper span.onsale {
	background-color: <?php echo esc_attr($color_one); ?> !important;
}
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {
	border-color: <?php echo esc_attr($color_one); ?> !important;
}

/**
 * Responsive *****
 */

<?php if( mfn_opts_get('responsive') ): ?>

@media only screen and (max-width: 767px){
	#Top_bar, #Action_bar { background: <?php echo esc_attr(mfn_opts_get('background-top-left', '#ffffff')); ?> !important;}
}

<?php endif; ?>
