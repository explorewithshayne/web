<?php
/**
 * Theme functions
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Allowed HTML elements for wp_kses
 */

if (! function_exists('mfn_allowed_html')) {
	function mfn_allowed_html($type = false)
	{
		switch ($type) {

			case 'button':

				$allowed_html = array(
					'i' => array(
						'class' => array(),
					),
					'del' => array(),
					'span' => array(),
					'strong' => array(),
				);
				break;

			case 'caption':

				$allowed_html = array(
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
					'b' => array(),
					'br' => array(),
					'em' => array(),
					'span' => array(),
					'strong' => array(),
					'u' => array(),
				);
				break;

			case 'desc':

				$allowed_html = array(
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
					'b' => array(),
					'br' => array(),
					'em' => array(),
					'i' => array(
						'class'  => array(),
					),
					'li' => array(),
					'span' => array(),
					'strong' => array(),
					'u' => array(),
					'ul' => array(),
				);
				break;

			default:

				$allowed_html = array(
					'b' => array(),
					'br' => array(),
					'em' => array(),
					'i' => array(
						'class'  => array(),
					),
					'span' => array(
						'id' => array(),
						'class' => array(),
						'style' => array(),
					),
					'strong' => array(),
					'u' => array(),
				);

		}

		return $allowed_html;
	}
}

/**
 * Image Size | Add
 * TIP: add_image_size ( string $name, int $width, int $height, bool|array $crop = false )
 */

if (! function_exists('mfn_add_image_size')) {
	function mfn_add_image_size()
	{
		// featured image in wp-admin
		set_post_thumbnail_size(260, 146, false);

		// thumbnails in wp-admin lists
		add_image_size('50x50', 50, 50, false);

		// clients
		add_image_size('clients-slider', 150, 75, false);

		// slider (builder items)
		add_image_size('slider-content', 1630, 860, true);

		// testimonials
		add_image_size('testimonials', 85, 85, true);

		// sticky navigation * widget: recent posts
		add_image_size('blog-navi', 80, 80, true);

		// portfolio | style: masonry flat
		add_image_size('portfolio-mf', 1280, 1000, true);
		add_image_size('portfolio-mf-w', 1280, 500, true);	/* Wide */
		add_image_size('portfolio-mf-t', 768, 1200, true);	/* Tall	*/

		// portfolio | style: list
		add_image_size('portfolio-list', 1920, 750, true);

		// blog & portfolio: dynamic sizes
		$archivesW = mfn_opts_get('featured-blog-portfolio-width', 960);
		$archivesH = mfn_opts_get('featured-blog-portfolio-height', 750);
		$archivesC = mfn_opts_get('featured-blog-portfolio-crop', 'crop');
		$archivesC = ($archivesC == 'resize') ? false : true;

		add_image_size('blog-portfolio', $archivesW, $archivesH, $archivesC);

		$singleW = mfn_opts_get('featured-single-width', 1200);
		$singleH = mfn_opts_get('featured-single-height', 480);
		$singleC = mfn_opts_get('featured-single-crop', 'crop');
		$singleC = ($singleC == 'resize') ? false : true;

		add_image_size('blog-single', $singleW, $singleH, $singleC);
	}
}
add_action('after_setup_theme', 'mfn_add_image_size', 11);

/**
 * Image size | Get size dimensions
 */

if (! function_exists('mfn_get_image_sizes')) {
	function mfn_get_image_sizes($size, $string = false)
	{
		$sizes = array();

		$sizes['width'] = get_option("{$size}_size_w");
		$sizes['height'] = get_option("{$size}_size_h");
		$sizes['crop'] = (bool) get_option("{$size}_crop");

		if ($string) {
			$crop = $sizes['crop'] ? ', crop' : '';
			return 'max width: '. esc_attr($sizes['width']) .', max height: '. esc_attr($sizes['height']) . esc_attr($crop);
		}

		return $sizes;
	}
}

/**
 * SVG && JSON files upload
 */

if (! function_exists('mfn_mimes_support')) {
 	function mfn_mimes_support( $file_types )
 	{
		$theme_disable = mfn_opts_get('theme-disable');

		if( empty($theme_disable['svg-allow']) ){
			$file_types['svg'] = 'image/svg+xml';
			$file_types['svgz'] = 'image/svg+xml';
		}

		if( empty($theme_disable['json-allow']) ){
			$file_types['json'] = 'application/json';
		}

		return $file_types;
 	}
}
add_action('upload_mimes', 'mfn_mimes_support');

/**
 * SVG files upload
 */

function mfn_check_filetype_and_ext( $checked, $file, $filename, $mimes ) {

	if ( ! $checked['type'] ) {

		$check_filetype = wp_check_filetype( $filename, $mimes );
		$ext = $check_filetype['ext'];
		$type = $check_filetype['type'];
		$proper_filename	= $filename;

		if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) {
			$ext = $type = false;
		}

		$checked = compact( 'ext','type','proper_filename' );
	}

	return $checked;

}
add_filter( 'wp_check_filetype_and_ext', 'mfn_check_filetype_and_ext', 10, 4 );

/**
 * JSON files upload
 */

if (! function_exists('mfn_json_support')) {
 	function mfn_json_support( $file, $filename, $mimes )
 	{

		$theme_disable = mfn_opts_get('theme-disable');
		if( ! empty($theme_disable['json-allow']) ){
			return $file;
		}

		if ( $file['ext'] && $file['type'] ) {
			return $file;
		}

		$filetype = wp_check_filetype( $mimes );

		if ( $filetype['ext'] === 'json' ) {
			$file['ext'] = 'json';
			$file['type'] = 'application/json';
		}

		return $file;
 	}
}
add_action('wp_check_filetype_and_ext', 'mfn_json_support', 10, 3);

/**
 * Excerpt | Lenght
 */

if (! function_exists('mfn_excerpt_length')) {
	function mfn_excerpt_length($length)
	{
		return esc_attr(mfn_opts_get('excerpt-length', 26));
	}
}
add_filter('excerpt_length', 'mfn_excerpt_length', 999);

/**
 * Excerpt | Wrap [...] into <span>
 */

if (! function_exists('mfn_trim_excerpt')) {
	function mfn_trim_excerpt($text)
	{
		return '<span class="excerpt-hellip"> […]</span>';
	}
}
add_filter('excerpt_more', 'mfn_trim_excerpt');

/**
 * Excerpt | for Pages
 */

if (! function_exists('mfn_add_excerpts_to_pages')) {
	function mfn_add_excerpts_to_pages()
	{
		add_post_type_support('page', 'excerpt');
	}
}
add_action('init', 'mfn_add_excerpts_to_pages');

/**
 * Slug | Generate
 */

if (! function_exists('mfn_slug')) {
	function mfn_slug($string = false)
	{
		return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
	}
}

/**
 * Blog Page | Order
 */

if (! function_exists('mfn_blog_order')) {
	function mfn_blog_order($query)
	{
		if ($query->is_main_query()) {
			if (is_home() || is_category() || is_tag()) {
				$orderby = mfn_opts_get('blog-orderby', 'date');
				$order = mfn_opts_get('blog-order', 'DESC');

				if ($orderby == 'date' && $order == 'DESC') {
					return true;
				}

				$query->set('orderby', $orderby);
				$query->set('order', $order);
			}
		}

		return $query;
	}
}
add_action('pre_get_posts', 'mfn_blog_order');

/**
 * Blog Page | Exclude category
 */

if (! function_exists('mfn_get_excluded_categories')) {
	function mfn_get_excluded_categories()
	{
		$categories = array();

		if ($exclude = mfn_opts_get('exclude-category')) {
			$exclude = str_replace(' ', '', $exclude);
			$exclude = explode(',', $exclude);

			if (is_array($exclude)) {
				$categories = $exclude;
			}
		}

		return $categories;
	}
}

if (! function_exists('mfn_exclude_category')) {
	function mfn_exclude_category($query)
	{
		if (is_home() && $query->is_main_query()) {
			$exclude_ids = array();

			if ($exclude = mfn_get_excluded_categories()) {
				foreach ($exclude as $slug) {
					$category = get_category_by_slug($slug);
					if( ! empty($category->term_id) ){
						$exclude_ids[] = $category->term_id * -1;
					}
				}
			}

			$exclude_ids = implode(',', $exclude_ids);

			$query->set('cat', $exclude_ids);
		}

		return $query;
	}
}
add_filter('pre_get_posts', 'mfn_exclude_category');

/**
 * SSL | Compatibility
*/

if ( !function_exists('mfn_ssl') ) {
	function mfn_ssl($echo = false)
	{
		$ssl = '';

		if (is_ssl()) {
			$ssl = 's';
		}

		if ($echo) {
			echo esc_attr($ssl);
		}

		return $ssl;
	}
}

/**
 * SSL | Attachments
 */

if (! function_exists('mfn_ssl_attachments')) {
	function mfn_ssl_attachments($url)
	{
		if (is_ssl()) {
			return str_replace('http://', 'https://', $url);
		}
		return $url;
	}
}
add_filter('wp_get_attachment_url', 'mfn_ssl_attachments');

/**
 * White Label | Admin Body Class
 */

if (! function_exists('mfn_white_label_class')) {
	function mfn_white_label_class($classes)
	{
		if (WHITE_LABEL) {
			$classes .= ' white-label ';
		}
		return $classes;
	}
}
add_filter('admin_body_class', 'mfn_white_label_class');

if (! function_exists('remove_standard_woo_actions_archive')) {
	function remove_standard_woo_actions_archive(){

		// Prevents duplicate price, rate in templates

		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	}
}

/**
 * Get Real Post ID
 */

if (! function_exists('mfn_ID')) {
	function mfn_ID( $param = false )
	{
		global $post;

		// 404

		if( is_404() ){
			return false;
		}

		$post_id = get_the_ID();

		// force template

		if( !empty($_GET['mfn-template-id']) && is_numeric( $_GET['mfn-template-id'] ) && get_post_type( $_GET['mfn-template-id'] ) == 'template' && ( get_post_status( $_GET['mfn-template-id'] ) == 'publish' || (!empty($_GET['visual']) && $_GET['visual'] == 'iframe' ) ) ){
			remove_standard_woo_actions_archive();
			return $_GET['mfn-template-id'];
		}

		// wpml fix
		if( defined( 'ICL_SITEPRESS_VERSION' ) ){
			$default_lang = apply_filters('wpml_default_language', NULL );
			$current_lang = apply_filters( 'wpml_current_language', NULL );
		}

		// woocommerce

		if (function_exists('is_woocommerce') && is_woocommerce() ) {

			if( is_product() ){

				// single product

				if( get_post_meta( $post_id, 'mfn_single_product_template', true ) && get_post_status( get_post_meta( $post_id, 'mfn_single_product_template', true ) ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return get_post_meta( $post_id, 'mfn_single_product_template', true ); // single product template
				}

				/**
				 * 
				 * NEW BASED ON OPTIONS 
				 * for entire shop, all cats, all tags
				 * 
				 * */

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option('mfn_sinle_product_tmpl_all_cats_'.$current_lang) ){
					remove_standard_woo_actions_archive();
					return get_option('mfn_sinle_product_tmpl_all_cats_'.$current_lang);
				}elseif( get_option('mfn_sinle_product_tmpl_all_cats') && get_post_status( get_option('mfn_sinle_product_tmpl_all_cats') ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return get_option('mfn_sinle_product_tmpl_all_cats');
				}

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option('mfn_sinle_product_tmpl_all_tags_'.$current_lang) ){
					remove_standard_woo_actions_archive();
					return get_option('mfn_sinle_product_tmpl_all_tags_'.$current_lang);
				}elseif( get_option('mfn_sinle_product_tmpl_all_tags') && get_post_status( get_option('mfn_sinle_product_tmpl_all_tags') ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return get_option('mfn_sinle_product_tmpl_all_tags');
				}

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option('mfn_sinle_product_tmpl_entire_shop_'.$current_lang) ){
					remove_standard_woo_actions_archive();
					return get_option('mfn_sinle_product_tmpl_entire_shop_'.$current_lang);
				}elseif( get_option('mfn_sinle_product_tmpl_entire_shop') && get_post_status( get_option('mfn_sinle_product_tmpl_entire_shop') ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return get_option('mfn_sinle_product_tmpl_entire_shop');
				}

				/**
				 * 
				 * END
				 * 
				 * */

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_post_meta($post_id, 'mfn_product_cat_template'.'_'.$current_lang) ){
					if( is_numeric(get_post_meta( $post_id, 'mfn_product_cat_template'.'_'.$current_lang, true )) && get_post_status( get_post_meta( $post_id, 'mfn_product_cat_template'.'_'.$current_lang, true ) ) == 'publish' ){
						// wpml all categories product template
						remove_standard_woo_actions_archive();
						return get_post_meta($post_id, 'mfn_product_cat_template'.'_'.$current_lang, true);
					}else{
						return false;
					}

				}elseif( get_post_meta($post_id, 'mfn_product_cat_template') ){
					if( is_numeric(get_post_meta( $post_id, 'mfn_product_cat_template', true )) && get_post_status( get_post_meta( $post_id, 'mfn_product_cat_template', true ) ) == 'publish' ){
						remove_standard_woo_actions_archive();
						return get_post_meta($post_id, 'mfn_product_cat_template', true); // all categories product template
					}else{
						return false;
					}
				}

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_post_meta($post_id, 'mfn_product_tag_template'.'_'.$current_lang) ) {
					if( is_numeric(get_post_meta( $post_id, 'mfn_product_tag_template'.'_'.$current_lang, true )) && get_post_status( get_post_meta( $post_id, 'mfn_product_tag_template'.'_'.$current_lang, true ) ) == 'publish' ){
						remove_standard_woo_actions_archive();
						return get_post_meta($post_id, 'mfn_product_tag_template'.'_'.$current_lang, true); // wpml all tags product template
					}else{
						return false;
					}
				}elseif( get_post_meta($post_id, 'mfn_product_tag_template') ) {
					if( is_numeric(get_post_meta( $post_id, 'mfn_product_tag_template', true )) && get_post_status( get_post_meta( $post_id, 'mfn_product_tag_template', true ) ) == 'publish' ){
						remove_standard_woo_actions_archive();
						return get_post_meta($post_id, 'mfn_product_tag_template', true); // all tags product template
					}else{
						return false;
					}
				}

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_post_meta($post_id, 'mfn_product_template'.'_'.$current_lang) ){
					if( is_numeric(get_post_meta( $post_id, 'mfn_product_template'.'_'.$current_lang, true )) && get_post_status( get_post_meta( $post_id, 'mfn_product_template'.'_'.$current_lang, true ) ) == 'publish' ){
						remove_standard_woo_actions_archive();
						return get_post_meta($post_id, 'mfn_product_template'.'_'.$current_lang, true); // wpml shop product template
					}else{
						return false;
					}
				}else if( get_post_meta($post_id, 'mfn_product_template') ){
					if( is_numeric(get_post_meta( $post_id, 'mfn_product_template', true )) && get_post_status( get_post_meta( $post_id, 'mfn_product_template', true ) ) == 'publish' ){
						remove_standard_woo_actions_archive();
						return get_post_meta($post_id, 'mfn_product_template', true); // shop product template
					}else{
						return false;
					}
				}

				// theme option product template

				if( mfn_opts_get('shop-product-template') && get_post_status( mfn_opts_get('shop-product-template') ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return mfn_opts_get('shop-product-template');
				}

				if( 'perfect_match' == $param ){
					return $post_id;
				}


			}else{

				$qo = get_queried_object();

				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && (is_product_category() || is_product_tag()) && isset($qo->term_id) && !empty(get_term_meta($qo->term_id, 'mfn_shop_template'.'_'.$current_lang, true)) ){
					if( is_numeric(get_term_meta($qo->term_id, 'mfn_shop_template'.'_'.$current_lang, true)) && get_post_status( get_term_meta($qo->term_id, 'mfn_shop_template'.'_'.$current_lang, true) ) == 'publish' ){
						remove_standard_woo_actions_archive();
						return get_term_meta($qo->term_id, 'mfn_shop_template'.'_'.$current_lang, true);
					}else{
						return false;
					}
				}elseif( (is_product_category() || is_product_tag()) && isset($qo->term_id) && !empty(get_term_meta($qo->term_id, 'mfn_shop_template', true)) ){
					if( is_numeric(get_term_meta($qo->term_id, 'mfn_shop_template', true)) && get_post_status( get_term_meta($qo->term_id, 'mfn_shop_template', true) ) == 'publish'  ){
						remove_standard_woo_actions_archive();
						return get_term_meta($qo->term_id, 'mfn_shop_template', true);
					}else{
						// is excluded
						return false;
					}
				}

				$shop_id = wc_get_page_id('shop');

				// wpml fix
				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && !empty(apply_filters( 'wpml_object_id', wc_get_page_id('shop'), 'page', null, $current_lang )) && !empty( get_post_meta(apply_filters( 'wpml_object_id', wc_get_page_id('shop'), 'page', null, $current_lang ), 'mfn_shop_template'.'_'.$current_lang, true) ) ){
					remove_standard_woo_actions_archive();
					return get_post_meta( apply_filters( 'wpml_object_id', wc_get_page_id('shop'), 'page', null, $current_lang ), 'mfn_shop_template'.'_'.$current_lang, true);
				}else if( !empty(get_post_meta($shop_id, 'mfn_shop_template')) && get_post_status( get_post_meta($shop_id, 'mfn_shop_template', true) ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return get_post_meta($shop_id, 'mfn_shop_template', true);
				}

				if( !empty(mfn_opts_get('shop-template')) && get_post_status( mfn_opts_get('shop-template') ) == 'publish' ){
					remove_standard_woo_actions_archive();
					return mfn_opts_get('shop-template');
				}

			}

			return wc_get_page_id('shop');
		}

		// search

		if( is_search() ){
			return false;
		}

		// taxonomy

		if( is_tax() ){
			return mfn_opts_get('portfolio-page');
		}

		// archive

		if( ! is_singular() ) {
			if( is_post_type_archive() || in_array( get_post_type(), array( 'post', 'tribe_events' ) ) ) {
				return mfn_get_blog_ID();
			}
		}

		return get_the_ID();

	}
}

/**
 * Template Part ID
 */

if (! function_exists('mfn_template_part_ID')) {
	function mfn_template_part_ID( $type, $id = false ) {
		global $post;
		global $wp_query;

		$term = false;

		if( !empty($_GET['mfn-'.$type.'-template']) && is_numeric( $_GET['mfn-'.$type.'-template'] ) && $_GET['mfn-'.$type.'-template'] != '0' && get_post_type( $_GET['mfn-'.$type.'-template'] ) == 'template' && get_post_meta($_GET['mfn-'.$type.'-template'], 'mfn_template_type', true) && get_post_meta($_GET['mfn-'.$type.'-template'], 'mfn_template_type', true) == $type && ( get_post_status( $_GET['mfn-'.$type.'-template'] ) == 'publish' || (!empty($_GET['visual']) && $_GET['visual'] == 'iframe' ) ) ){
			return $_GET['mfn-'.$type.'-template'];
		}

		// wpml fix
		if( defined( 'ICL_SITEPRESS_VERSION' ) ){
			$default_lang = apply_filters('wpml_default_language', NULL );
			$current_lang = apply_filters( 'wpml_current_language', NULL );
		}

		// always 1 newest template is active
		// if excluded we check this one only

		if( $id || is_singular() || is_search() ){

			//echo 'is singular';
			$post_id = $id ? $id : get_the_ID();
			$post_type = get_post_type($post_id);

			if( empty($post_type) || (!empty($post_type) && !in_array($post_type, array('page', 'post', 'offer', 'portfolio', 'product', 'template'))) ) {
				$post_type = 'page';
			}

			// single post header | set in single post/page edit

			$setin_postedit = get_post_meta( $post_id, 'mfn_'.$type.'_template', true );
			if( $setin_postedit && is_numeric( $setin_postedit ) && get_post_status( $setin_postedit ) == 'publish' && get_post_type( $setin_postedit ) == 'template' )
				return $setin_postedit;

			// post type header
			$single = get_post_meta( $post_id, 'mfn_'.$type.'_post', true );
			if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang ){
				// wpml
				$single_lang = get_post_meta( $post_id, 'mfn_'.$type.'_'.$current_lang.'_post', true );
				if( !get_post_meta( $post_id, 'mfn_'.$type.'_'.$current_lang.'_post_excluded', true ) && $single_lang && is_numeric( $single_lang ) && get_post_status( $single_lang ) == 'publish' && get_post_type( $single_lang ) == 'template' ){
					return $single_lang;
				}else if( !get_post_meta( $post_id, 'mfn_'.$type.'_post_excluded', true ) && $single && is_numeric( $single ) && get_post_status( $single ) == 'publish' && get_post_type( $single ) == 'template' ){
					return $single;
				}
			}elseif( !get_post_meta( $post_id, 'mfn_'.$type.'_post_excluded', true ) && $single && is_numeric( $single ) && get_post_status( $single ) == 'publish' && get_post_type( $single ) == 'template' ){
				return $single;
			}

			// post type all
			$posttype = get_option( 'mfn_'.$type.'_'.$post_type.'_single' );
			if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang ){
				// wpml
				$posttype_lang = get_option( 'mfn_'.$type.'_'.$current_lang.'_'.$post_type.'_single' );
				if( !get_option( 'mfn_'.$type.'_'.$current_lang.'_'.$posttype.'_single_excluded' ) && $posttype_lang && is_numeric( $posttype_lang ) && get_post_status( $posttype_lang ) == 'publish' && get_post_type( $posttype_lang ) == 'template' ){
					return $posttype_lang;
				}else if( !get_option( 'mfn_'.$type.'_'.$posttype.'_single_excluded' ) && $posttype && is_numeric( $posttype ) && get_post_status( $posttype ) == 'publish' && get_post_type( $posttype ) == 'template' ){
					return $posttype;
				}
			}elseif( !get_option( 'mfn_'.$type.'_'.$post_type.'_single_excluded' ) && $posttype && is_numeric( $posttype ) && get_post_status( $posttype ) == 'publish' && get_post_type( $posttype ) == 'template' ){
				return $posttype;
			}

		}else{

			$queried_obj = get_queried_object();

			// by term id
			if( isset($queried_obj->term_id) ){
				$term = get_term_meta( $queried_obj->term_id, 'mfn_'.$type.'_term', true );
				// wpml
				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang ){
					$term_lang = get_term_meta( $queried_obj->term_id, 'mfn_'.$type.'_'.$current_lang.'_term', true );
					if( $term_lang && is_numeric( $term_lang ) && get_post_status( $term_lang ) == 'publish' && get_post_type( $term_lang ) == 'template' ){
						if( get_term_meta( $queried_obj->term_id, 'mfn_'.$type.'_'.$current_lang.'_term_excluded', true ) ) {
							return false;
						}else{
							return $term_lang;
						}
					}else{
						if( get_term_meta( $queried_obj->term_id, 'mfn_'.$type.'_term_excluded', true ) ) return;
						if( $term && is_numeric( $term ) && get_post_status( $term ) == 'publish' && get_post_type( $term ) == 'template' )
							return $term;
					}
				}else{
					if( get_term_meta( $queried_obj->term_id, 'mfn_'.$type.'_term_excluded', true ) ) return;
					if( $term && is_numeric( $term ) && get_post_status( $term ) == 'publish' && get_post_type( $term ) == 'template' )
						return $term;
				}
			}

			// by post type

			$posttype = false;

			if( is_home() || is_category() || is_author() || is_date() ){
				//echo 'blog';
				$posttype = get_option( 'mfn_'.$type.'_post_arch' );
				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option( 'mfn_'.$type.'_'.$current_lang.'_post_arch' ) ){
					$posttype = get_option( 'mfn_'.$type.'_'.$current_lang.'_post_arch' );
					if( get_option( 'mfn_'.$type.'_'.$current_lang.'_post_arch_excluded' ) ) $posttype = false;
				}else{
					if( get_option( 'mfn_'.$type.'_post_arch_excluded' ) ) $posttype = false;
				}
			}elseif( function_exists('is_woocommerce') && is_woocommerce() ){
				//echo 'product';
				$posttype = get_option( 'mfn_'.$type.'_product_arch' );
				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option( 'mfn_'.$type.'_'.$current_lang.'_product_arch' ) ){
					$posttype = get_option( 'mfn_'.$type.'_'.$current_lang.'_product_arch' );
					if( get_option( 'mfn_'.$type.'_'.$current_lang.'_product_arch_excluded' ) ) $posttype = false;
				}else{
					if( get_option( 'mfn_'.$type.'_product_arch_excluded' ) ) $posttype = false;
				}
			}elseif( is_post_type_archive('portfolio') ){
				//echo 'portfolio';
				$posttype = get_option( 'mfn_'.$type.'_portfolio_arch' );
				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option( 'mfn_'.$type.'_'.$current_lang.'_portfolio_arch' ) ){
					$posttype = get_option( 'mfn_'.$type.'_'.$current_lang.'_portfolio_arch' );
					if( get_option( 'mfn_'.$type.'_'.$current_lang.'_portfolio_arch_excluded' ) ) $posttype = false;
				}else{
					if( get_option( 'mfn_'.$type.'_portfolio_arch_excluded' ) ) $posttype = false;
				}
			}elseif( is_post_type_archive('offer') ){
				//echo 'offer';
				$posttype = get_option( 'mfn_'.$type.'_offer_arch' );
				if( !empty($default_lang) && !empty($current_lang) && $current_lang != $default_lang && get_option( 'mfn_'.$type.'_'.$current_lang.'_offer_arch' ) ){
					$posttype = get_option( 'mfn_'.$type.'_'.$current_lang.'_offer_arch' );
					if( get_option( 'mfn_'.$type.'_'.$current_lang.'_offer_arch_excluded' ) ) $posttype = false;
				}else{
					if( get_option( 'mfn_'.$type.'_offer_arch_excluded' ) ) $posttype = false;
				}
			}elseif( is_archive() ){
				// all others archives
				$posttype = get_option( 'mfn_'.$type.'_post_arch' );
			}

			if( !empty($queried_obj->term_id) && get_term_meta( $queried_obj->term_id, 'mfn_'.$type.'_term_excluded', true ) ) return false;

			if( $posttype && is_numeric( $posttype ) && get_post_status( $posttype ) == 'publish' && get_post_type( $posttype ) == 'template' ){
				return $posttype;
			}
		}

		return false;
	}
}


/**
 * Addons ID
 */

if (! function_exists('mfn_addons_ID')) {
	function mfn_addons_ID( $type, $id = false ) {
		global $post;
		global $wp_query;

		$return = array();

		if( $id || is_singular() || is_search() ){

			$addons = get_option('mfn_'.$type.'_addons_singular');

			if( $addons ){

				$post_id = $id ? $id : get_the_ID();
				$post_type = get_post_type($post_id);

				if( empty($post_type) || (!empty($post_type) && !in_array($post_type, array('page', 'post', 'offer', 'portfolio', 'product', 'template'))) ) {
					$post_type = 'page';
				}

				// seting from page option
				if( !empty( get_post_meta($post_id, 'mfn_popup_included', true) ) ){
					$return[] = get_post_meta($post_id, 'mfn_popup_included', true);
				}

				// for post type
				if( !empty($addons[$post_type]['all']) ) $return = array_merge($return, $addons[$post_type]['all']);

				if( $post_type == 'post' ){
					$terms = get_the_terms( $post_id, 'category' );
				}elseif( $post_type == 'product' && function_exists('is_woocommerce') ){
					$terms = get_the_terms( $post_id, 'product_cat' );
				}elseif( $post_type == 'portfolio' ){
					$terms = get_the_terms( $post_id, 'portfolio-types' );
				}elseif( $post_type == 'offer' ){
					$terms = get_the_terms( $post_id, 'offer-types' );
				}

				if ( isset($terms) && $terms && ! is_wp_error( $terms ) ){
					foreach($terms as $term) {

						if( !empty($addons[$term->term_id]) && is_array($addons[$term->term_id]) ) {
							foreach($addons[$term->term_id] as $a=>$at){
								if( $a != 'excluded' ){
									$return = array_merge($return, $at);
								}
							}
							
						}

						if( isset($addons[$term->term_id]['exclude']) && is_array($addons[$term->term_id]['exclude']) ) {
							
							// remove
							foreach( $addons[$term->term_id]['exclude'] as $ex ){

								foreach( $return as $r=>$ret ){
									if( $ex == $ret ) unset($return[$r]);
								}

							}
							
						}

					}
				}
			
			}

		}else{

			$addons = get_option('mfn_'.$type.'_addons_archives');

			if( $addons ){

				if( !empty( $addons['post']['all'] ) && ( is_home() || is_category() || is_author() || is_date() ) ){
					//echo 'blog';
					$return = array_merge($return, $addons['post']['all']);
				}elseif( !empty($addons['product']['all']) && function_exists('is_woocommerce') && is_woocommerce() ){
					//echo 'product';
					$return = array_merge($return, $addons['product']['all']);
				}elseif( !empty($addons['portfolio']['all']) && is_post_type_archive('portfolio') ){
					//echo 'portfolio';
					$return = array_merge($return, $addons['portfolio']['all']);
				}elseif( !empty($addons['offer']['all']) && is_post_type_archive('offer') ){
					//echo 'offer';
					$return = array_merge($return, $addons['offer']['all']);
				}

				$queried_obj = get_queried_object();

				if( isset($queried_obj->term_id) ){

					if( !empty($addons[$queried_obj->term_id]) && is_array($addons[$queried_obj->term_id]) ) {
						foreach($addons[$queried_obj->term_id] as $a=>$at){
							if( $a != 'excluded' ){
								$return = array_merge($return, $at);
							}
						}
						
					}

					if( isset($addons[$queried_obj->term_id]['exclude']) && is_array($addons[$queried_obj->term_id]['exclude']) ) {
						
						// remove
						foreach( $addons[$queried_obj->term_id]['exclude'] as $ex ){

							foreach( $return as $r=>$ret ){
								if( $ex == $ret ) unset($return[$r]);
							}

						}
						
					}

				}

			}

		}

		/*echo '<pre>';
			print_r($addons);
			echo '</pre>';*/

		return array_unique($return);

	}
}

/**
 * Get blog page ID
 */

if (! function_exists('mfn_get_blog_ID')) {
	function mfn_get_blog_ID(){

		$id = get_option('page_for_posts');

		if( ! $id ){
			$id = mfn_opts_get('blog-page');
		}

		return $id;
	}
}

/**
 * Get Layout ID
 */

if (! function_exists('mfn_layout_ID')) {
	function mfn_layout_ID()
	{
		$layoutID = false;

		if (mfn_ID()) {

			if (is_single() && get_post_type() == 'post') {

				// Theme Options | Single Post
				$layoutID = mfn_opts_get('blog-single-layout');

			} elseif (is_single() && get_post_type() == 'portfolio') {

				if (get_post_meta(mfn_ID(), 'mfn-post-custom-layout', true)) {

					// Page Options | Single Portfolio
					$layoutID = get_post_meta(mfn_ID(), 'mfn-post-custom-layout', true);

				} else {

					// Theme Options | Single Portfolio
					$layoutID = mfn_opts_get('portfolio-single-layout');

				}

			} else {

				// Page Options | Page
				$layoutID = get_post_meta(mfn_ID(), 'mfn-post-custom-layout', true);

			}

		}

		return $layoutID;
	}
}

/**
 * Slider | Isset
 */

if (! function_exists('mfn_slider_isset')) {
	function mfn_slider_isset($id = false)
	{
		$slider = false;

		// global slider shortcode

		if (is_page() && mfn_opts_get('slider-shortcode')) {
			return 'global';
		}

		if ($id || is_home() || is_category() || is_tax() || get_post_type() == 'page' || (get_post_type(mfn_ID()) == 'portfolio' && get_post_meta(mfn_ID(), 'mfn-post-slider-header', true))) {

			if (! $id) {
				$id = mfn_ID();
			} // do NOT move it before IF

			if (get_post_meta($id, 'mfn-post-slider', true)) {

				// Revolution Slider
				$slider = 'rev';

			} elseif (get_post_meta($id, 'mfn-post-slider-layer', true)) {

				// Layer Slider
				$slider = 'layer';

			} elseif (get_post_meta($id, 'mfn-post-slider-shortcode', true)) {

				// Custom Slider
				$slider = 'custom';

			}
		}

		return $slider;
	}
}

/**
 * Slider | Get
 */

if (! function_exists('mfn_slider')) {
	function mfn_slider($id = false)
	{
		$slider = false;
		$slider_type = mfn_slider_isset($id);

		if (! $id) {
			$id = mfn_ID();
		} // do NOT move it before IF

		switch ($slider_type) {

			case 'global':
				$slider = '<div class="mfn-main-slider" id="mfn-global-slider">';
					$slider .= do_shortcode(mfn_opts_get('slider-shortcode'));
				$slider .= '</div>';
				break;

			case 'rev':
				$slider = '<div class="mfn-main-slider mfn-rev-slider">';
					$slider .= do_shortcode('[rev_slider '. get_post_meta($id, 'mfn-post-slider', true) .']');
				$slider .= '</div>';
				break;

			case 'layer':
				$slider = '<div class="mfn-main-slider mfn-layer-slider">';
					$slider .= do_shortcode('[layerslider id="'. get_post_meta($id, 'mfn-post-slider-layer', true) .'"]');
				$slider .= '</div>';
				break;

			case 'custom':
				$slider = '<div class="mfn-main-slider" id="mfn-custom-slider">';
					$slider .= do_shortcode(get_post_meta($id, 'mfn-post-slider-shortcode', true));
				$slider .= '</div>';
				break;

		}

		return $slider;
	}
}

/**
 * Share
 */

if (! function_exists('mfn_share')) {
	function mfn_share($container = false)
	{
		$type = false;
		$class = false;

		if ( ! mfn_opts_get('share') && 'item' !== $container ) {
			return false;
		}

		$style = mfn_opts_get('share-style', 'classic');

		// type

		if (($container == 'header') && ($style == 'classic')) {
			$type = 'classic';
		}

		if ($container == 'intro') {
			if ($style == 'simple') {
				$type = 'simple';
			} else {
				$type = 'classic';
			}
		}

		if (($container == 'footer') && ($style == 'simple')) {
			$type = 'simple';
		}

		if ($container == 'item') {
			$type = $style;
			$class = 'share_item';
		}

		// output

		$output = '';

		if ($type == 'simple') {

			// simple

			$translate['share'] = mfn_opts_get('translate') ? mfn_opts_get('translate-share', 'Share') : __('Share', 'betheme');

			$output .= '<div class="share-simple-wrapper '. esc_attr($class) .'">';

				$output .= '<span class="share-label">'. esc_html($translate['share']) .'</span>';

				$output .= '<div class="icons">';
					$output .= '<a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u='. urlencode(esc_url(get_permalink())) .'"><i class="icon-facebook" aria-label="facebook icon"></i></a>';
					$output .= '<a target="_blank" class="twitter" href="https://twitter.com/intent/tweet?text='. urlencode( esc_attr(wp_get_document_title()) .'. '. esc_url(get_permalink()) ) .'"><i class="icon-twitter" aria-label="twitter icon"></i></a>';
					$output .= '<a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url='. urlencode(esc_url(get_permalink())) .'"><i class="icon-linkedin" aria-label="linkedin icon"></i></a>';
					$output .= '<a target="_blank" class="pinterest" href="https://pinterest.com/pin/find/?url='. urlencode(esc_url(get_permalink())) .'"><i class="icon-pinterest" aria-label="pinterest icon"></i></a>';
				$output .= '</div>';

				if ($container != 'item') {
					$output .= '<div class="button-love">'. mfn_love() .'</div>';
				}

			$output .= '</div>';

		} elseif ($type == 'classic') {

			// classic

			wp_enqueue_script('share-this', 'https://ws.sharethis.com/button/buttons.js', false, null, true);
			$share_this_inline = 'stLight.options({publisher:"1390eb48-c3c3-409a-903a-ca202d50de91",doNotHash:false,doNotCopy:false,hashAddressBar:false});';
			wp_add_inline_script('share-this', $share_this_inline);

			$output .= '<div class="share_wrapper '. esc_attr($class) .'">';

				$output .= '<span class="st_facebook_vcount"></span>';
				$output .= '<span class="st_twitter_vcount"></span>';
				$output .= '<span class="st_pinterest_vcount"></span>';

			$output .= '</div>';
		}

		return $output;
	}
}

/**
 * WP Mobile Detect | Quick FIX: parallax on mobile
 */

if (! function_exists('mfn_is_mobile')) {
	function mfn_is_mobile()
	{
		$mobile = wp_is_mobile();

		if (mfn_opts_get('responsive-parallax')) {
			$mobile = false;
		}

		return $mobile;
	}
}

/**
 * User OS
 * @deprecated Be 25.1
 */

if (! function_exists('mfn_user_os')) {
	function mfn_user_os()
	{
		// use mfn_html_classes() instead
		return mfn_html_classes();
	}
}

/**
 * User Agent | For: Prallax - Safari detect & future use
 */

if (! function_exists('mfn_user_agent')) {
	function mfn_user_agent()
	{
		$user_agent = $_SERVER['HTTP_USER_AGENT']; // context is safe and necessary

		if (stripos($user_agent, 'Chrome/') !== false) {
			$user_agent = 'chrome';
		} elseif ((stripos($user_agent, 'Safari/') !== false) && (stripos($user_agent, 'Mobile/') !== false)) {
			$user_agent = 'safari mobile';
		} elseif (stripos($user_agent, 'Safari/') !== false) {
			$user_agent = 'safari';
		} else {

			// for future use
			$user_agent = false;
		}

		return $user_agent;
	}
}

/**
 * Show user icon
 */

if (! function_exists('mfn_user_icon')) {
	function mfn_user_icon( $user_icon = false ){
		if( $user_icon ){
			echo '<i class="'. $user_icon .'" aria-label="user icon"></i>';
		} else {
			echo '<svg width="26" viewBox="0 0 26 26" aria-label="user icon"><defs><style>.path{fill:none;stroke:#333333;stroke-width:1.5px;}</style></defs><circle class="path" cx="13" cy="9.7" r="4.1"/><path class="path" d="M19.51,18.1v2.31h-13V18.1c0-2.37,2.92-4.3,6.51-4.3S19.51,15.73,19.51,18.1Z"/></svg>';
		}
	}
}

/**
 * Paralllax | Plugin
 */

if (! function_exists('mfn_parallax_plugin')) {
	function mfn_parallax_plugin()
	{
		$parallax = mfn_opts_get('parallax');

		if ($parallax == 'translate3d no-safari') {
			if (mfn_user_agent() == 'safari') {
				$parallax = 'enllax';
			} else {
				$parallax = 'translate3d';
			}
		}

		return $parallax;
	}
}

/**
 * Paralllax | Code - Section & wrapper background
 */

if (! function_exists('mfn_parallax_data')) {
	function mfn_parallax_data()
	{
		$parallax = mfn_parallax_plugin();

		if ($parallax == 'translate3d') {
			$parallax = 'data-parallax="3d"';
		} elseif ($parallax == 'stellar') {
			$parallax = 'data-stellar-background-ratio="0.5"';
		} else {
			$parallax = 'data-enllax-ratio="-0.3"';
		}

		return $parallax;
	}
}

/**
 * Pagination for Blog and Portfolio
 */

if (! function_exists('mfn_pagination')) {
	function mfn_pagination($query = false, $load_more = false)
	{
		global $wp_query;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

		// default $wp_query

		if (! $query) {
			$query = $wp_query;
		}

		$translate['prev'] = mfn_opts_get('translate') ? mfn_opts_get('translate-prev', '&lsaquo; Prev page') : __('Prev page', 'betheme');
		$translate['next'] = mfn_opts_get('translate') ? mfn_opts_get('translate-next', 'Next page &rsaquo;') : __('Next page', 'betheme');
		$translate['load-more'] = mfn_opts_get('translate') ? mfn_opts_get('translate-load-more', 'Load more') : __('Load more', 'betheme');

		isset($query->query_vars['paged']) && $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;

		if (empty($paged)) {
			$paged = 1;
		}
		$prev = $paged - 1;
		$next = $paged + 1;

		$end_size = 1;
		$mid_size = 2;
		$show_all = mfn_opts_get('pagination-show-all');
		$dots = false;

		if (! $total = $query->max_num_pages) {
			$total = 1;
		}

		$output = '';

		if ($total > 1) {

			if ($load_more) {

				// load more

				if ($paged < $total) {
					$output .= '<div class="column one pager_wrapper pager_lm">';
						$output .= '<a class="pager_load_more button has-icon" href="'. esc_url(get_pagenum_link($next) ).'">';
							$output .= '<span class="button_icon"><i class="icon-layout" aria-hidden="true"></i></span>';
							$output .= '<span class="button_label">'. esc_html($translate['load-more']) .'</span>';
						$output .= '</a>';
					$output .= '</div>';
				}

			} else {

				// default

				$output .= '<div class="column one pager_wrapper">';
					$output .= '<div class="pager">';

						if ($paged >1) {
							$output .= '<a class="prev_page" href="'. esc_url(get_pagenum_link($prev)) .'"><i class="icon-left-open" aria-hidden="true"></i>'. esc_html($translate['prev']) .'</a>';
						}

						$output .= '<div class="pages">';
						for ($i=1; $i <= $total; $i++) {
							if ($i == $current) {
								$output .= '<a href="'. esc_url(get_pagenum_link($i)) .'" class="page active">'. esc_html($i) .'</a>';
								$dots = true;
							} else {
								if ($show_all || ($i <= $end_size || ($current && $i >= $current - $mid_size && $i <= $current + $mid_size) || $i > $total - $end_size)) {
									$output .= '<a href="'. esc_url(get_pagenum_link($i)) .'" class="page">'. esc_html($i) .'</a>';
									$dots = true;
								} elseif ($dots && ! $show_all) {
									$output .= '<span class="page">...</span>';
									$dots = false;
								}
							}
						}
						$output .= '</div>';

						if ($paged < $total) {
							$output .= '<a class="next_page" href="'. esc_url(get_pagenum_link($next)) .'">'. esc_html($translate['next']) .'<i class="icon-right-open" aria-hidden="true"></i></a>';
						}

					$output .= '</div>';
				$output .= '</div>'."\n";

			}

		}
		return $output;
	}
}

/**
 * Current page URL
 */

if (! function_exists('mfn_current_URL')) {
	function mfn_current_URL()
	{
		$env = $_SERVER; // context is safe and necessary

		$pageURL = 'http';
		if (is_ssl()) {
			$pageURL .= 's';
		}

		$pageURL .= '://';

		if( in_array( $env['SERVER_PORT'], array(80, 443) ) ){
			$pageURL .= $env['SERVER_NAME'].$env['REQUEST_URI'];
		} else {
			$pageURL .= $env['SERVER_NAME'] .':'. $env['SERVER_PORT'].$env['REQUEST_URI'];
		}

		return $pageURL;
	}
}

/**
 * Subheader | Page Title
 */

if (! function_exists('mfn_page_title')) {
	function mfn_page_title($echo = false)
	{
		if (is_home()) {

			// blog
			$title = get_the_title(mfn_ID());

		} elseif ( is_category() ) {

			$title = single_cat_title( '', false );

		} elseif ( is_tag() ) {

			$title = single_tag_title( '', false );

		} elseif ( is_author() ) {

			$title = get_the_author();

		} elseif ( is_year() ) {

			$title = get_the_time( 'Y' );

		} elseif ( is_month() ) {

			$title = get_the_time( 'F Y' );

		} elseif ( is_day() ) {

			$title = get_the_time( 'F j, Y' );

		} elseif ( is_post_type_archive() ) {

			$title = post_type_archive_title( '', false );

		} elseif ( is_single() || is_page() ) {

			$title = get_the_title(mfn_ID());

		} elseif (get_post_taxonomies()) {

			$title = single_cat_title('', false);

		} elseif (function_exists('tribe_is_month') && (tribe_is_event_query() || tribe_is_month() || tribe_is_event() || tribe_is_day() || tribe_is_venue())) {

			// The Events Calendar
			$title = tribe_get_events_title();

		} else {

			$title = get_the_title(mfn_ID());

		}

		if ($echo) {
			echo wp_kses($title, mfn_allowed_html());
		}

		return $title;
	}
}

/**
 * Breadcrumbs
 */

if (! function_exists('mfn_breadcrumbs')) {
	function mfn_breadcrumbs($class = false)
	{
		global $post;

		$breadcrumbs = array();
		$separator = ' <span><i class="icon-right-open" aria-label="breadcrumbs separator"></i></span>';

		// translate

		$translate['home'] = mfn_opts_get('translate') ? mfn_opts_get('translate-home', 'Home') : __('Home', 'betheme');

		// plugin: bbPress

		if (function_exists('is_bbpress') && is_bbpress()) {
			bbp_breadcrumb(array(
				'before' => '<ul class="breadcrumbs">',
				'after' => '</ul>',
				'sep' => '<i class="icon-right-open" aria-label="breadcrumbs separator"></i>',
				'crumb_before' => '<li>',
				'crumb_after' => '</li>',
				'home_text' => esc_html($translate['home']),
			));
			return true; // exit
		}

		// home prefix

		$breadcrumbs[] = '<a href="'. esc_attr(home_url()) .'">'. esc_html($translate['home']) .'</a>';

		// blog

		if ( 'post' == get_post_type() ) {

			$blogID = false;

			if (get_option('page_for_posts')) {
				$blogID = get_option('page_for_posts');	// Setings / Reading
			}

			if ($blogID) {
				$blog_post = get_post($blogID);

				// blog page has parent

				if ($blog_post && $blog_post->post_parent) {

					$parent_id  = $blog_post->post_parent;
					$parents = array();

					while ($parent_id) {
						$page = get_page($parent_id);
						$parents[] = '<a href="'. get_permalink($page->ID) .'">'. wp_kses(get_the_title($page->ID), mfn_allowed_html()) .'</a>';
						$parent_id  = $page->post_parent;
					}

					$parents = array_reverse($parents);
					$breadcrumbs = array_merge_recursive($breadcrumbs, $parents);
				}

				$breadcrumbs[] = '<a href="'. esc_url(get_permalink($blogID)) .'">'. wp_kses(get_the_title($blogID), mfn_allowed_html()) .'</a>';
			}
		}

		if ( is_front_page() || is_home() ) {

			// do nothing

		} elseif ( is_category() ) {

			$cat = get_term_by('name', single_cat_title('', false), 'category');
			if ($cat && $cat->parent) {
				$breadcrumbs[] = get_category_parents($cat->parent, true, $separator);
			}

			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html(single_cat_title('', false)) .'</a>';

		} elseif ( is_tag() ) {

			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html(single_tag_title('', false)) . '</a>';

		} elseif ( is_author() ) {

			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html(get_the_author()) .'</a>';

		} elseif ( is_year() ) {

			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html(get_the_time('Y')) .'</a>';

		} elseif ( is_month() ) {

			$breadcrumbs[] = '<a href="'. esc_url(get_year_link(get_the_time('Y'))) .'">' . esc_html(get_the_time('Y')) . '</a>';
			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html(get_the_time('F')) .'</a>';

		} elseif ( is_day() ) {

			$breadcrumbs[] = '<a href="'. esc_url(get_year_link(get_the_time('Y'))) . '">'. esc_html( get_the_time('Y') ) .'</a>';
			$breadcrumbs[] = '<a href="'. esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) .'">'. esc_html( get_the_time('F') ) .'</a>';
			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html( get_the_time('d') ) .'</a>';

		} elseif ( is_post_type_archive() ) {

			$breadcrumbs[] = '<a href="'. esc_url( mfn_current_URL() ) .'">'. esc_html( post_type_archive_title( '', false ) ) .'</a>';

		} elseif (is_single() && ! is_attachment()) {

			if ( 'post' != get_post_type() ) {

				// portfolio

				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$portfolio_page_id = mfn_wpml_ID(mfn_opts_get('portfolio-page'));

				// portfolio page

				if ($slug['slug'] == mfn_opts_get('portfolio-slug', 'portfolio-item') && $portfolio_page_id) {
					$breadcrumbs[] = '<a href="'. esc_url(get_page_link($portfolio_page_id)) .'">'. esc_html(get_the_title($portfolio_page_id)) .'</a>';
				}

				// category

				if ($portfolio_page_id) {
					$terms = get_the_terms(get_the_ID(), 'portfolio-types');
					if (! empty($terms) && ! is_wp_error($terms)) {
						$breadcrumbs[] = get_term_parents_list($terms[0], 'portfolio-types', array('separator' => $separator ));
					}
				}

				// single

				$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. get_the_title().'</a>';

			} else {

				// blog single

				$cat = get_the_category();
				if (! empty($cat)) {
					$breadcrumbs[] = get_category_parents($cat[0], true, $separator);
				}

				$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. get_the_title() .'</a>';
			}

		} elseif (! is_page() && get_post_taxonomies()) {

			// taxonomy portfolio

			$post_type = get_post_type_object(get_post_type());
			if ($post_type->name == 'portfolio' && $portfolio_page_id = mfn_wpml_ID(mfn_opts_get('portfolio-page'))) {
				$breadcrumbs[] = '<a href="'. esc_url(get_page_link($portfolio_page_id)) .'">'. esc_html(get_the_title($portfolio_page_id)) .'</a>';
			}

			$breadcrumbs[] = '<a href="'. esc_url(mfn_current_URL()) .'">'. esc_html(single_cat_title('', false)) .'</a>';

		} elseif (is_page() && $post->post_parent) {

			// page with parent

			$parent_id = $post->post_parent;
			$parents = array();

			while ($parent_id) {
				$page = get_page($parent_id);
				$parents[] = '<a href="'. esc_url(get_permalink($page->ID)) .'">'. wp_kses(get_the_title($page->ID), mfn_allowed_html()) .'</a>';
				$parent_id = $page->post_parent;
			}

			$parents = array_reverse($parents);
			$breadcrumbs = array_merge_recursive($breadcrumbs, $parents);

			$breadcrumbs[] = '<a href="'. esc_url(get_permalink($post->ID)) .'">'. wp_kses(get_the_title(mfn_ID()), mfn_allowed_html()) .'</a>';

		// } elseif (function_exists('tribe_is_month') && (tribe_is_event_query() || tribe_is_month() || tribe_is_event() || tribe_is_day() || tribe_is_venue())) {
		//
		// 	// plugin: Events Calendar
		//
		// 	if (function_exists('tribe_get_events_link')) {
		// 		$breadcrumbs[] = '<a href="'. esc_url(tribe_get_events_link()) .'">'. esc_html(tribe_get_events_title()) .'</a>';
		// 	}

		} else {

			// default

			$breadcrumbs[] = '<a href="'. esc_url(get_permalink($post->ID)) .'">'. wp_kses(get_the_title(mfn_ID()), mfn_allowed_html()) .'</a>';

		}

		// output -----

		echo '<ul class="breadcrumbs '. esc_attr($class) .'">';

			$count = count($breadcrumbs);
			$i = 1;

			foreach ($breadcrumbs as $bk => $bc) {

				if (strpos($bc, $separator)) {

					// category parent

					echo '<li>'. $bc .'</li>';

				} else {

					if ($i == $count) {
						$separator = '';
					}
					echo '<li>'. $bc . $separator .'</li>';

				}

				$i++;
			}

		echo '</ul>';
	}
}

/**
 * Hex 2 rgba
 */

if (! function_exists('mfn_hex2rgba')) {
	function mfn_hex2rgba($hex, $alpha = 1, $echo = false)
	{
		if( strpos($hex, 'rgb') !== false ){
			return $hex;
		}

		$hex = str_replace("#", "", $hex);

		if (strlen($hex) == 3) {
			$r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
			$g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
			$b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
		} else {
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
		}

		$rgba = 'rgba('. $r.','. $g .','. $b .','. $alpha .')';

		if ($echo) {
			echo esc_attr($rgba);
			return true;
		}

		return $rgba;
	}
}

/**
 * Is dark color
 */

if (! function_exists('mfn_brightness')) {
	function mfn_brightness( $hex, $tolerance = 169, $oposite_color = false )
	{
		if( ! $hex ){
			return false;
		}

		$hex = str_replace("#", "", $hex);

		if( 6 != strlen( $hex ) ){
			return false;
		}

		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));

		$brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

		if ($brightness > $tolerance) {
			$brightness = 'light';
		} else {
			$brightness = 'dark';
		}

		if ($oposite_color) {
			if ($brightness == 'light') {
				$brightness = 'black';
			} else {
				$brightness = 'white';
			}
		}

		return $brightness;
	}
}

/**
 * jPlayer HTML
 */

if (! function_exists('mfn_jplayer_html')) {
	function mfn_jplayer_html($video_m4v, $poster = false)
	{
		$player_id = mt_rand(0, 999);

		$output = '<div id="jp_container_'. esc_attr($player_id) .'" class="jp-video mfn-jcontainer">';
		$output .= '<div class="jp-type-single">';
		$output .= '<div id="jquery_jplayer_'. esc_attr($player_id) .'" class="jp-jplayer mfn-jplayer" data-m4v="'. esc_url($video_m4v) .'" data-img="'. esc_url($poster) .'" data-swf="'. get_theme_file_uri('/assets/jplayer') .'"></div>';
		$output .= '<div class="jp-gui">';
		$output .= '<div class="jp-video-play">';
		$output .= '<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>';
		$output .= '</div>';
		$output .= '<div class="jp-interface">';
		$output .= '<div class="jp-progress">';
		$output .= '<div class="jp-seek-bar">';
		$output .= '<div class="jp-play-bar"></div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="jp-current-time"></div>';
		$output .= '<div class="jp-duration"></div>';
		$output .= '<div class="jp-controls-holder">';
		$output .= '<ul class="jp-controls">';
		$output .= '<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>';
		$output .= '</ul>';
		$output .= '<div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div>';
		$output .= '<ul class="jp-toggles">';
		$output .= '<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>';
		$output .= '<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>';
		$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div class="jp-title"><ul><li>jPlayer Video Title</li></ul></div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '<div class="jp-no-solution"><span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="https://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a></div>';
		$output .= '</div>';
		$output .= '</div>'."\n";

		return $output;
	}
}

/**
 * jPlayer
 */

if (! function_exists('mfn_jplayer')) {
	function mfn_jplayer($postID, $sizeH = 'full')
	{
		// masonry square video fix

		if ( $sizeH == 'blog-masonry' ) {
			$sizeH = 'blog-square';
		}

		$video_m4v	= get_post_meta( $postID, 'mfn-post-video-mp4', true );

		$poster	= wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), $sizeH );

		if( ! empty($poster[0]) ){
			$poster	= $poster[0];
		} else {
			$poster = '';
		}

		$theme_disable = mfn_opts_get( 'theme-disable' );

		if ( isset( $theme_disable[ 'html5-player' ] ) ) {

			$output = '<video preload="metadata" poster="'. esc_url( $poster ) .'" controls="1" style="max-width:100%">';
				$output .= '<source type="video/mp4" src="'. esc_url( $video_m4v ) .'" />';
			$output .= '</video>';

		} else {

			$output = mfn_jplayer_html( $video_m4v, $poster );

		}

		return $output;
	}
}

/**
 * Post Format
 */

if (! function_exists('mfn_post_format')) {
	function mfn_post_format($postID)
	{
		if (get_post_type($postID) == 'portfolio' && is_single($postID)) {

			// portfolio

			if (get_post_meta(get_the_ID(), 'mfn-post-video', true)) {

				// video: embed
				$format = 'video';

			} elseif (get_post_meta(get_the_ID(), 'mfn-post-video-mp4', true)) {

				// video: HTML5
				$format = 'video';

			} else {

				// image
				$format = false;

			}

		} else {

			// blog
			$format = get_post_format($postID);

		}

		return $format;
	}
}

/**
 * Check if we use lazy load images
 */

if (! function_exists('mfn_is_lazy')) {
	function mfn_is_lazy( $lazy_load = false ){

		if ( ! empty($_GET['visual']) || wp_doing_ajax() ){
			return false; // disable lazy load in Bebuilder
		}

		if( 'disable' == $lazy_load ){
			$lazy = false;
		} elseif( 'lazy' == $lazy_load ){
			$lazy = true;
		} elseif( 'lazy' == mfn_opts_get('lazy-load') ){
			$lazy = true;
		} else {
			$lazy = false;
		}

		return $lazy;
	}
}

/**
 * Attachment | GET attachment ID by URL
 */

if (! function_exists('mfn_get_attachment_id_url')) {
	function mfn_get_attachment_id_url($image_url){

		// https://forum.muffingroup.com/betheme/discussion/65515/selecting-specific-image-size-fails-and-falls-back-to-full-when-large-image-is-scaled#latest
		return attachment_url_to_postid($image_url);

		// global $wpdb;
		//
		// $image_url = esc_url($image_url);
		// $attachment = $wpdb->get_col($wpdb->prepare( "SELECT `ID` FROM $wpdb->posts WHERE `guid` = %s", $image_url ));
		//
		// if (isset($attachment[0])) {
		// 	return $attachment[0];
		// }
		//
		// // QUICK FIX https
		// $image_url = str_replace('https://', 'http://', $image_url);
		// $attachment = $wpdb->get_col($wpdb->prepare( "SELECT `ID` FROM $wpdb->posts WHERE `guid` = %s", $image_url ));
		//
		// if (isset($attachment[0])) {
		// 	return $attachment[0];
		// }

	}
}

/**
 * Attachment | GET attachment data
 */

if ( ! function_exists( 'mfn_get_attachment_data' ) ) {
 	function mfn_get_attachment_data( $image, $data, $with_key = false )
 	{
 		$return = false;
 		$size = false;

 		if ( ! is_numeric( $image ) ) {
 			$image = mfn_get_attachment_id_url( $image );
 		}

 		// WPML workaround

 		$image = apply_filters( 'wpml_object_id', $image, 'attachment', true );

 		// ALT

 		if ( 'alt' == $data ) {
 			$return = get_post_meta( $image, '_wp_attachment_image_alt', true );

 			if ( ! $return ) {
 				$return = get_the_title( $image );
 			}
 		}

 		// WIDTH or HEIGHT

 		if ( ! $return ) {
 			$meta = get_post_meta( $image, '_wp_attachment_metadata', true );

 			if ( ! empty( $meta[$data] ) && $meta[$data] !== 1 ) {
 				$return = $meta[$data];
 			}
 		}

 		if ( $return && $with_key ) {
 			$return = esc_attr( $data ) .'="'. esc_attr( $return ) .'"';
 		}

 		return $return;
 	}
}

/**
 * Srcset for Image
 */

if (! function_exists('mfn_srcset')) {
	function mfn_srcset( $attachment_id, $html_tag = true ){

		if( ! $attachment_id || mfn_opts_get('srcset-featured-image') === '0'){
			return false;
		}

		$image_srcset = '';

		if ( $html_tag ){
			$image_srcset .= 'srcset="';
		}

		$image_srcset .= wp_get_attachment_image_srcset($attachment_id, array(400, 200));

		if ( $html_tag ){
			$image_srcset .= '"';
		}

		return $image_srcset;
	}
}

/**
 * Post Thumbnail | GET post thumbnail type
 */

if (! function_exists('mfn_post_thumbnail_type')) {
	function mfn_post_thumbnail_type($postID)
	{
		$type = 'image';
		$post_format = mfn_post_format($postID);

		if ($post_format == 'image') {
			$type = 'image';
		} elseif ($post_format == 'video' && get_post_meta($postID, 'mfn-post-video', true)) {
			$type = 'video embed';
		} elseif ($post_format == 'video' && get_post_meta($postID, 'mfn-post-video-mp4', true)) {
			$type = 'video html5';
		} elseif (get_post_meta($postID, 'mfn-post-slider', true) || get_post_meta($postID, 'mfn-post-slider-layer', true)) {
			$type = 'slider';
		}

		return $type;
	}
}

/**
 * Post Thumbnail | GET post thumbnail
 */

if (! function_exists('mfn_post_thumbnail')) {
	function mfn_post_thumbnail($postID, $type = false, $style = false, $featured_image = false)
	{
		$output = '';
		$sizeH = 'full';
		$sizeV = 'full';
		$is_srcset_enabled = mfn_opts_get('srcset-featured-image');
		$tooltip = [
			'class' => false,
			'zoom' => false,
			'website' => false,
			'details' => false,
		];

		// tooltips

		if( mfn_opts_get('image-frame-style') == 'modern-overlay' ){
			$data_tooltip_position = 'left';
			$tooltip = [
				'class' => 'tooltip',
				'zoom' => 'data-tooltip="'. esc_html__('Zoom','betheme') .'" data-position="'. $data_tooltip_position .'"',
				'website' => 'data-tooltip="'. esc_html__('Go to website','betheme') .'" data-position="'. $data_tooltip_position .'"',
				'details' => 'data-tooltip="'. esc_html__('Details','betheme') .'" data-position="'. $data_tooltip_position .'"',
			];
		}

		// image size -----

		if ($type == 'portfolio') {

			// portfolio

			if ($style == 'list') {

				// portfolio: list

				$sizeH = 'portfolio-list';

			} elseif ($style == 'masonry-flat') {

				// portfolio: masonry flat

				$size = get_post_meta($postID, 'mfn-post-size', true);
				if ($size == 'wide') {
					$sizeH = 'portfolio-mf-w';
				} elseif ($size == 'tall') {
					$sizeH = 'portfolio-mf-t';
				} else {
					$sizeH = 'portfolio-mf';
				}

			} elseif ($style == 'masonry-minimal') {

				// portfolio: masonry minimal

				$sizeH = 'full';

			} else {

				// portfolio: default

				$sizeH = 'blog-portfolio';

			}

		} elseif( 'blog' == $type && in_array($style, array('photo', 'photo2')) ){

			// blog: photo

			$sizeH = 'blog-single';
			$sizeV = 'blog-single';

		} elseif( in_array( $type, ['blog','related'] ) ){

			// related posts

			$sizeH = 'blog-portfolio';

		} elseif ( is_single( $postID ) ) {

			// blog & portfolio: single

			$sizeH = 'blog-single';

		} else {

			// default

			$sizeH = 'blog-portfolio';

		}

		// link wrap -----

		$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'large');

		if( ! $large_image_url ){
			$large_image_url[0] = false;
		}

		if ( is_single($postID) && 'blog' !== $type ) {

			// single

			$link_before = '<a href="'. esc_url($large_image_url[0]) .'" rel="prettyphoto">';
				$link_before .= '<div class="mask"></div>';

				$link_after = '</a>';
			$link_after .= '<div class="image_links">';
				$link_after .= '<a class="zoom '. esc_attr($tooltip['class']) .'" '. $tooltip['zoom'] .' rel="prettyphoto" href="'. esc_url($large_image_url[0]) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle cx="11.35" cy="11.35" r="6" class="path"></circle><line x1="15.59" y1="15.59" x2="20.65" y2="20.65" class="path"></line></svg></a>';
			$link_after .= '</div>';

			// single: post

			if (get_post_type() == 'post') {

				// blog: single - disable image zoom

				if (! mfn_opts_get('blog-single-zoom')) {
					$link_before = '';
					$link_after = '';
				}

				// blog single: structured data

				if ( mfn_opts_get('mfn-seo-schema-type') ) {

					$link_after_schema = '';

					$link_before .= '<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';

						$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($postID), 'full');

						if( ! empty( $image_url[0] ) ){
							$link_after_schema .= '<meta itemprop="url" content="'. esc_url($image_url[0]) .'"/>';
							$link_after_schema .= '<meta itemprop="width" content="'. esc_attr(mfn_get_attachment_data($image_url[0], 'width')) .'"/>';
							$link_after_schema .= '<meta itemprop="height" content="'. esc_attr(mfn_get_attachment_data($image_url[0], 'height')) .'"/>';
						}

					$link_after_schema .= '</div>';

					$link_after = $link_after_schema . $link_after;
				}
			}

		} elseif ($type == 'portfolio') {

			// portfolio

			if( in_array( $style, array('flat', 'masonry-flat') ) ) {
				$is_srcset_enabled = false;
			}

			$external = mfn_opts_get('portfolio-external');

			// external link to project page

			$image_links = get_post_meta(get_the_ID(), 'mfn-post-link', true);

			// image link

			if ($external == 'popup') {

				// popup

				$link_before = '<a href="'. esc_url($large_image_url[0]) .'" rel="prettyphoto">';
				$link_title = '<a href="'. esc_url($large_image_url[0]) .'" rel="prettyphoto">';

			} elseif ( $external == 'disable' ) {

				// disable details

				$link_before = '<a href="'. esc_url($large_image_url[0]) .'" rel="prettyphoto[portfolio]">';
				$link_title = '<a href="'. esc_url($large_image_url[0]) .'" rel="prettyphoto">';

			} elseif ($external && $image_links) {

				// link to project website

				$link_before = '<a href="'. esc_url($image_links) .'" target="'. esc_attr($external) .'">';
				$link_title = '<a href="'. esc_url($image_links) .'" target="'. esc_attr($external ).'">';

			} else {

				// link to project details

				$link_before = '<a href="'. esc_url(get_permalink()) .'">';
				$link_title = '<a href="'. esc_url(get_permalink()) .'">';

			}

			$link_before .= '<div class="mask"></div>';

			$link_after = '</a>';

			// hover

			if (mfn_opts_get('portfolio-hover-title')) {

				// hover: title

				$link_after .= '<div class="image_links hover-title">';
					$link_after .= $link_title . wp_kses(get_the_title(), mfn_allowed_html()) .'</a>';
				$link_after .= '</div>';

			} elseif ($external != 'disable') {

				// hover: icons

				$link_after .= '<div class="image_links">';
					if (! in_array($external, array( '_self', '_blank' ))) {
						$link_after .= '<a class="zoom '. esc_attr($tooltip['class']) .'" '. $tooltip['zoom'] .' rel="prettyphoto" href="'. esc_url($large_image_url[0]) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle cx="11.35" cy="11.35" r="6" class="path"></circle><line x1="15.59" y1="15.59" x2="20.65" y2="20.65" class="path"></line></svg></a>';
					}
					if ($image_links) {
						$link_after .= '<a class="external '. esc_attr($tooltip['class']) .'" '. $tooltip['website'] .' target="_blank" href="'. esc_url($image_links) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><polyline points="18 14 18 20 6 20 6 8 12 8" class="path"/><line x1="10.34" y1="15.66" x2="19.71" y2="6.29" class="path"/><polyline points="20 12 20 6 14 6" class="path"/></g></svg></a>';
					}
					$link_after .= '<a class="link '. esc_attr($tooltip['class']) .'" '. $tooltip['details'] .' href="'. esc_url(get_permalink()) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><path d="M10.17,8.76l2.12-2.12a5,5,0,0,1,7.07,0h0a5,5,0,0,1,0,7.07l-2.12,2.12" class="path"></path><path d="M15.83,17.24l-2.12,2.12a5,5,0,0,1-7.07,0h0a5,5,0,0,1,0-7.07l2.12-2.12" class="path"></path><line x1="10.17" y1="15.83" x2="15.83" y2="10.17" class="path"></line></g></svg></a>';
				$link_after .= '</div>';
			}

		} else {

			// blog

			$link_before = '<a href="'. esc_url(get_permalink()) .'">';
				$link_before .= '<div class="mask"></div>';

			$link_after = '</a>';
			$link_after .= '<div class="image_links double">';
				$link_after .= '<a class="zoom '. esc_attr($tooltip['class']) .'" '. $tooltip['zoom'] .' rel="prettyphoto" href="'. esc_url($large_image_url[0]) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle cx="11.35" cy="11.35" r="6" class="path"></circle><line x1="15.59" y1="15.59" x2="20.65" y2="20.65" class="path"></line></svg></a>';
				$link_after .= '<a class="link '. esc_attr($tooltip['class']) .'" '. $tooltip['details'] .' href="'. esc_url(get_permalink()) .'"><svg viewBox="0 0 26 26"><defs><style>.path{fill:none;stroke:#333;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><path d="M10.17,8.76l2.12-2.12a5,5,0,0,1,7.07,0h0a5,5,0,0,1,0,7.07l-2.12,2.12" class="path"></path><path d="M15.83,17.24l-2.12,2.12a5,5,0,0,1-7.07,0h0a5,5,0,0,1,0-7.07l2.12-2.12" class="path"></path><line x1="10.17" y1="15.83" x2="15.83" y2="10.17" class="path"></line></g></svg></a>';
			$link_after .= '</div>';
		}

		// post format -----

		$post_format = mfn_post_format($postID);

		// featured image: available types

		// no slider if load more

		if ( 'no_slider' == $featured_image ) {
			$type = 'portfolio';
		}

		// images only option

		if ( 'image' == $featured_image ) {
			if (! in_array($post_format, array( 'quote', 'link', 'image' ))) {
				$post_format = 'image-only';
			}
		}

		// image attributes and srcset

		$image_attrs = [
			'class'=>'scale-with-grid',
		];

		if( $is_srcset_enabled ){
			$image_attrs['srcset'] = mfn_srcset( get_post_thumbnail_id($postID), false );
		}

		// switch

		switch ($post_format) {

			case 'quote':
			case 'link':

				// quote - Quote - without image

				return false;
				break;

			case 'image':

				// image - Vertical Image

				if (has_post_thumbnail()) {
					$output .= $link_before;
						$output .= get_the_post_thumbnail($postID, $sizeV, $image_attrs);
					$output .= $link_after;
				}
				break;

			case 'video':

				// video - Video

				if ($video = get_post_meta($postID, 'mfn-post-video', true)) {
					if (is_numeric($video)) {
						// Vimeo
						$output .= '<iframe class="scale-with-grid" src="https://player.vimeo.com/video/'. esc_attr($video) .'" allowFullScreen></iframe>'."\n";
					} else {
						// YouTube
						$output .= '<iframe class="scale-with-grid" src="https://www.youtube.com/embed/'. esc_attr($video) .'?wmode=opaque&rel=0" allowfullscreen></iframe>'."\n";
					}
				} elseif (get_post_meta($postID, 'mfn-post-video-mp4', true)) {
					$output .= mfn_jplayer($postID);
				}
				break;

			case 'image-only':

				// images only option

				if (has_post_thumbnail()) {
					$output .= $link_before;
						$output .= get_the_post_thumbnail($postID, $sizeH, $image_attrs);
					$output .= $link_after;
				}
				break;

			default:

				// standard - Text, Horizontal Image, Slider

				$rev_slider = get_post_meta($postID, 'mfn-post-slider', true);
				$lay_slider = get_post_meta($postID, 'mfn-post-slider-layer', true);

				if (('portfolio' != $type) && ($rev_slider || $lay_slider)) {

					if ($rev_slider) {
						// Revolution Slider
						$output .= do_shortcode('[rev_slider '. $rev_slider .']');
					} elseif ($lay_slider) {
						// Layer Slider
						$output .= do_shortcode('[layerslider id="'. $lay_slider .'"]');
					}

				} elseif ( has_post_thumbnail() ) {

					// Image

					$output .= $link_before;
						$output .= get_the_post_thumbnail($postID, $sizeH, $image_attrs);
					$output .= $link_after;

				}
		}

		return $output;
	}
}

/**
 * FIX: WP sometimes returns 1 as image width & height
 */

function mfn_get_attachment_image_src( $image, $attachment_id, $size, $icon ){

	// width

	if( !empty($image[1]) && $image[1] === 1 ){
		$image[1] = false;
	}

	// height

	if( !empty($image[2]) && $image[2] === 1 ){
		$image[2] = false;
	}

	return $image;

}
add_filter( 'wp_get_attachment_image_src', 'mfn_get_attachment_image_src', 10, 4 );

/**
 * Single Post Navigation | SET query order
 */

// previous

if (! function_exists('mfn_filter_previous_post_sort')) {
	function mfn_filter_previous_post_sort($sort)
	{
		if (mfn_get_portfolio_order() == 'ASC') {
			$order = 'DESC';
		} else {
			$order = 'ASC';
		}
		$sort = "ORDER BY p.". esc_sql(mfn_get_portfolio_orderby()) ." ". $order ." LIMIT 1";
		return $sort;
	}
}

if (! function_exists('mfn_filter_previous_post_where')) {
	function mfn_filter_previous_post_where($where)
	{
		global $post, $wpdb;

		$orderby = mfn_get_portfolio_orderby();
		$where = preg_replace("/(.*)p.post_type/", "AND p.post_type", $where);

		if (mfn_get_portfolio_order() == 'ASC') {
			$where_pre = $wpdb->prepare("WHERE p.". esc_sql($orderby) ." < %s", $post->$orderby);
		} else {
			$where_pre = $wpdb->prepare("WHERE p.". esc_sql($orderby) ." > %s", $post->$orderby);
		}

		$where = $where_pre.' '.$where;
		return $where;
	}
}

// next

if (! function_exists('mfn_filter_next_post_sort')) {
	function mfn_filter_next_post_sort($sort)
	{
		$sort = "ORDER BY p.". esc_sql(mfn_get_portfolio_orderby()) ." ". esc_sql(mfn_get_portfolio_order()) ." LIMIT 1";
		return $sort;
	}
}

if (! function_exists('mfn_filter_next_post_where')) {
	function mfn_filter_next_post_where($where)
	{
		global $post, $wpdb;

		$orderby = mfn_get_portfolio_orderby();
		$where = preg_replace("/(.*)p.post_type/", "AND p.post_type", $where);

		if (mfn_get_portfolio_order() == 'ASC') {
			$where_pre = $wpdb->prepare("WHERE p.". esc_sql($orderby) ." > %s", $post->$orderby);
		} else {
			$where_pre = $wpdb->prepare("WHERE p.". esc_sql($orderby) ." < %s", $post->$orderby);
		}

		$where = $where_pre.' '.$where;
		return $where;
	}
}

// helpers

if (! function_exists('mfn_get_portfolio_order')) {
	function mfn_get_portfolio_order()
	{
		return mfn_opts_get('portfolio-order', 'DESC');
	}
}

if (! function_exists('mfn_get_portfolio_orderby')) {
	function mfn_get_portfolio_orderby()
	{
		$orderby = mfn_opts_get('portfolio-orderby', 'date');
		switch ($orderby) {
			case 'title':
				$orderby = 'post_title';
				break;
			case 'menu_order':
				$orderby = 'menu_order';
				break;
			default:
				$orderby = 'post_date';
		}
		return $orderby;
	}
}

// filters

if (! function_exists('mfn_post_navigation_sort')) {
	function mfn_post_navigation_sort()
	{
		add_filter('get_previous_post_sort', 'mfn_filter_previous_post_sort');
		add_filter('get_previous_post_where', 'mfn_filter_previous_post_where');
		add_filter('get_next_post_sort', 'mfn_filter_next_post_sort');
		add_filter('get_next_post_where', 'mfn_filter_next_post_where');
	}
}

/**
 * Single Post Navigation | GET header navigation
 */

if (! function_exists('mfn_post_navigation_header')) {
	function mfn_post_navigation_header($post_prev, $post_next, $post_home, $translate = array())
	{
		$style = mfn_opts_get('prev-next-style');

		$output = '<div class="column one post-nav '. esc_attr($style) .'">';

		if ($style == 'minimal') {

				// minimal

			if ($post_prev) {
				$output .= '<a class="prev" href="'. esc_url(get_permalink($post_prev)) .'"><i class="icon icon-left-open-big" aria-label="previous post"></i></a>';
			}
			if ($post_next) {
				$output .= '<a class="next" href="'. esc_url(get_permalink($post_next)) .'"><i class="icon icon-right-open-big" aria-label="next post"></i></a>';
			}
			if ($post_home) {
				$output .= '<a class="home" href="'. esc_url(get_permalink($post_home)) .'"><svg class="icon" aria-label="all posts" width="22" height="22" xmlns="https://www.w3.org/2000/svg"><path d="M7,2v5H2V2H7 M9,0H0v9h9V0L9,0z"/><path d="M20,2v5h-5V2H20 M22,0h-9v9h9V0L22,0z"/><path d="M7,15v5H2v-5H7 M9,13H0v9h9V13L9,13z"/><path d="M20,15v5h-5v-5H20 M22,13h-9v9h9V13L22,13z"/></svg></a>';
			}

		} else {

				// default

			$output .= '<ul class="next-prev-nav">';
			if ($post_prev) {
				$output .= '<li class="prev"><a class="button default the-icon" href="'. esc_url(get_permalink($post_prev)) .'"><span class="button_icon"><i class="icon-left-open" aria-label="previous post"></i></span></a></li>';
			}
			if ($post_next) {
				$output .= '<li class="next"><a class="button default the-icon" href="'. esc_url(get_permalink($post_next)) .'"><span class="button_icon"><i class="icon-right-open" aria-label="next post"></i></span></a></li>';
			}
			$output .= '</ul>';

			if ($post_home) {
				$output .= '<a class="list-nav" href="'. esc_url(get_permalink($post_home)) .'"><i class="icon-layout" aria-hidden="true"></i>'. esc_html($translate['all']) .'</a>';
			}
		}

		$output .= '</div>';

		return $output;
	}
}

/**
 * Single Post Navigation | GET sticky navigation
 */

if (! function_exists('mfn_post_navigation_sticky')) {
	function mfn_post_navigation_sticky($post, $next_prev, $icon)
	{
		$has_date = mfn_opts_get('prev-next-date','1');

		$output = '';

		if (is_object($post)) {

			// move this DOM element with JS

			$style = mfn_opts_get('prev-next-sticky-style', 'default');

			$output .= '<a class="fixed-nav fixed-nav-'. esc_attr($next_prev) .' format-'. esc_attr(get_post_format($post)) .' style-'. esc_attr($style) .'" href="'. esc_url(get_permalink($post)) .'">';

				$output .= '<span class="arrow"><i class="'. esc_attr($icon) .'" aria-hidden="true"></i></span>';

				$output .= '<div class="photo">';
					$output .= get_the_post_thumbnail($post->ID, 'blog-navi');
				$output .= '</div>';

				$output .= '<div class="desc">';
					$output .= '<h6>'. wp_kses(get_the_title($post), array()) .'</h6>';
					if( $has_date ){
						$output .= '<span class="date"><i class="icon-clock" aria-hidden="true"></i>'. esc_html(get_the_date(get_option('date_format'), $post->ID)) .'</span>';
					}
				$output .= '</div>';

			$output .= '</a>';
		}

		return $output;
	}
}

/**
 * Search | SET add custom fields to search query
 */

if (! function_exists('mfn_search')) {
 	function mfn_search( $search_query )
 	{
 		global $wpdb;

 		if ( is_admin() ) {
 			return false;
 		}

 		if ( is_search() && $search_query->is_main_query() && $search_query->is_search() ) {

 			$keyword = get_search_query();
 			$is_search_shop_only = mfn_opts_get('header-search') === 'shop' ? true : false;

 			if ( ! $keyword ) {
 				return false;
 			}

 			// WooCommerce uses default search Query

 			if (function_exists('is_woocommerce') && is_woocommerce()) {
 				return false;
 			}

 			$keyword = '%'. $wpdb->esc_like($keyword) .'%';

 			// post title

 			$post_ids_title = $wpdb->get_col($wpdb->prepare("
 				SELECT DISTINCT `ID` FROM {$wpdb->posts}
 				WHERE `post_title` LIKE %s
 			", $keyword));

 			// post conatnt

 			$post_ids_content = $wpdb->get_col($wpdb->prepare("
 				SELECT DISTINCT `ID` FROM {$wpdb->posts}
 				WHERE `post_content` LIKE %s
 			", $keyword));

 			// custom fields

 			$post_ids_meta = $wpdb->get_col($wpdb->prepare("
 				SELECT DISTINCT `post_id` FROM {$wpdb->postmeta}
 				WHERE `meta_key` = 'mfn-page-items-seo'
 				AND `meta_value` LIKE %s
 			", $keyword));

 			$post_ids = array_merge($post_ids_title, $post_ids_content, $post_ids_meta);

 			// live search -- category load

 			if ( isset($_GET['mfn_livesearch']) ) {
 				/* CONFIG */
 					//We need the string(categories), and word array (for posts and page search)
 					$words_string = preg_replace('/\s/', ',', $keyword);
 					$words_array = explode(',', preg_replace('/\%/', '', $words_string) );

 					$posts_array = [];
 					/* Default queue: Posts/Pages -> Categories -> WooCategories */
 				/* END OF CONFIG */

 				if( !$is_search_shop_only ){
 					/* POSTS AND PAGE NAME QUERY */
 					foreach ($words_array as $words_key => $words_value){ //RELATION: OR
 						$args_title = array( 's' => $words_value, 'posts_per_page' => -1 );
 						$query_title = new WP_Query($args_title);


 						if($query_title->have_posts()){
 							$posts_array = $query_title->get_posts();

 							foreach($posts_array as $post_item_key => $post_item_val){
 								$post_ids[] = strval($post_item_val->ID);
 							}
 						}
 					}
 					/* END OF POSTS AND PAGE NAME QUERY */

 					/* POSTS AND PAGE CATEGORIES QUERY */
 					foreach($words_array as $words_key => $words_value){
 						$args_category = array( 'category_name' => $words_value, 'posts_per_page' => -1, 'fields' => 'ids'); // replace space => comma
 						$query_category = new WP_Query($args_category);

 						if($query_category->have_posts()){
 							$posts_array = $query_category->get_posts();

 							foreach($posts_array as $cat_item_key => $cat_item_val){
 								$post_ids[] = strval($cat_item_val);
 							}
 						}
 					}
 					/* END OF POSTS AND PAGE  CATEGORIES QUERY */
 				}

 				/* WOOCOMMERCE CATEGORIES QUERY */
 				foreach($words_array as $words_key => $words_value){
 					$args_category = array( 'product_cat' => $words_value, 'posts_per_page' => -1, 'fields' => 'ids', 'post_type' => 'product'); // replace space => comma
 					$query_category = new WP_Query($args_category);

 					if($query_category->have_posts()){
 						$posts_array = $query_category->get_posts();

 						foreach($posts_array as $cat_item_key => $cat_item_val){
 							$post_ids[] = strval($cat_item_val);
 						}
 					}
 				}
 				/* END OF WOOCOMMERCE CATEGORIES QUERY */

 				if( $is_search_shop_only ){
 					$search_query->set('post_type', 'product');
 					//limit the search to products, prevent searching for posts/pages
 				}

 				$search_amount_posts = esc_attr(mfn_opts_get('header-search-live-load-posts', 10));
 				$search_query->set('posts_per_page', $search_amount_posts);
 				//if value above will be < 10, then button of show more in livesearch will not appear!
 			}

 			if ( ! count($post_ids) ) {
 				return false;
 			}

 			$search_query->set('s', false);
 			$search_query->set('post__in', $post_ids);
 			$search_query->set('orderby', 'post__in');
 		}
 	}
}
add_action('pre_get_posts', 'mfn_search');

/**
 * All categories available
 */

if (! function_exists('mfn_list_categories')) {
	function mfn_list_categories()
	{
		$portfolio_terms = get_terms( array( 'taxonomy' => 'portfolio-types', 'hide_empty' => false ) );
		$blog_terms = get_terms( 'category', array( 'hide_empty' => false ) );
		$shop_terms = get_terms( 'product_cat', array( 'hide_empty' => false ) );

		$all_terms = [];

		if ( $portfolio_terms && empty($portfolio_terms->errors) ) {
			$all_terms[] = $portfolio_terms;
		}

		if ( $blog_terms && empty($blog_terms->errors) ) {
			$all_terms[] = $blog_terms;
		}

		if ( $shop_terms && empty($shop_terms->errors) ) {
			$all_terms[] = $shop_terms;
		}

		$all_terms = array_merge( [], ...$all_terms );
		$all_terms = json_decode( json_encode($all_terms), true );

		$categories_found = array();
		foreach($all_terms as $key => $value){
			$categories_found[get_category_link($value['term_id'])] = $value['name'];
		}

		$categories_found = array_unique($categories_found);

		return $categories_found;
	}
}

/**
 * Posts per page & pagination fix
 */

if (! function_exists('mfn_option_posts_per_page')) {
	function mfn_option_posts_per_page($value)
	{
		if (is_tax('portfolio-types')) {
			$posts_per_page = mfn_opts_get('portfolio-posts', 6, ['not_empty' => true]);
		} else {
			$posts_per_page = mfn_opts_get('blog-posts', 5, ['not_empty' => true]);
		}
		return $posts_per_page;
	}
}

if (! function_exists('mfn_posts_per_page')) {
	function mfn_posts_per_page()
	{
		add_filter('option_posts_per_page', 'mfn_option_posts_per_page');
	}
}
add_action('init', 'mfn_posts_per_page', 0);

/**
 *	Comments number with text
 */

if (! function_exists('mfn_comments_number')) {
	function mfn_comments_number()
	{
		$translate['comment'] = mfn_opts_get('translate') ? mfn_opts_get('translate-comment', 'comment') : __('comment', 'betheme');
		$translate['comments'] = mfn_opts_get('translate') ? mfn_opts_get('translate-comments', 'comments') : __('comments', 'betheme');
		$translate['comments-off'] = mfn_opts_get('translate') ? mfn_opts_get('translate-comments-off', 'comments off') : __('comments off', 'betheme');

		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

		if (comments_open()) {
			if ($num_comments != 1) {
				$comments = '<a href="'. esc_url(get_comments_link()) .'">'. esc_html($num_comments).'</a> '. esc_html($translate['comments']);
			} else {
				$comments = '<a href="'. esc_url(get_comments_link()) .'">1</a> '. esc_html($translate['comment']);
			}
		} else {
			$comments = $translate['comments-off'];
		}
		return $comments;
	}
}

/**
 *	Menu title in selected location
 */

if (! function_exists('mfn_get_menu_name')) {
	function mfn_get_menu_name($location)
	{
		if (! has_nav_menu($location)) {
			return false;
		}

		$menus = get_nav_menu_locations();
		$menu_title = wp_get_nav_menu_object($menus[$location])->name;

		return $menu_title;
	}
}

/**
 *	GET | WordPress Authors
 */

if (! function_exists('mfn_get_authors')) {
	function mfn_get_authors()
	{
		$authors = get_users( array( 'role__in' => array( 'contributor', 'author', 'editor', 'administrator' ) ) );

		if (is_array($authors)) {
			foreach ($authors as $ka => $author) {

				// remove authors without posts

				$posts_count = count_user_posts( $author->ID, 'post', true );

				if( $posts_count < 1 ){
					unset($authors[$ka]);
				}

			}
		}

		return $authors;
	}
}

/**
 * GET Categories
 * Categories for posts or specified taxonomy
 */

if (! function_exists('mfn_get_categories')) {
	function mfn_get_categories($category)
	{
		$categories = get_categories(array(
			'taxonomy' => $category,
			'hide_empty' => false,
		));

		$array = array(
			'' => esc_html__('All', 'mfn-opts'),
		);

		foreach ($categories as $cat) {
			if (is_object($cat)) {
				$array[$cat->slug] = $cat->name;
			}
		}

		return $array;
	}
}

/**
 * GET Hierarchical Taxonomy
 * Categories for posts or specified taxonomy with hierarchy
 */

if (! function_exists('mfn_hierarchical_taxonomy')) {
	function mfn_hierarchical_taxonomy($type){

		// 1st level
		$taxonomy = get_terms( array(
			'taxonomy' => $type,
			'hide_empty' => false,
			'parent' => 0
		) );

		$array = array();

		if( !empty($taxonomy) && is_array($taxonomy) && count($taxonomy) > 0 ){
			foreach ($taxonomy as $t=>$taxo) {
				if (is_object($taxo) ) {
					$array[] = (object) array('id' => $taxo->term_id, 'slug' => $taxo->slug, 'name' => $taxo->name);

					// 2nd level
					$childrens = get_terms( array(
						'taxonomy' => $type,
						'hide_empty' => false,
						'parent' => $taxo->term_id
					) );

					if( count($childrens) > 0 ){
						foreach ($childrens as $ch) {
							if(is_object($ch) ) {
								$array[] = (object) array('id' => $ch->term_id, 'slug' => $ch->slug, 'name' => '&nbsp;&nbsp;'.$ch->name);

								// 3rd level
								$childs = get_terms( array(
									'taxonomy' => $type,
									'hide_empty' => false,
									'parent' => $ch->term_id
								) );

								if( count($childs) > 0 ){
									foreach ($childs as $chi) {
										if(is_object($chi) ) {
											$array[] = (object) array('id' => $chi->term_id, 'slug' => $chi->slug, 'name' => '&nbsp;&nbsp;&nbsp;&nbsp;'.$chi->name);

											// 4th level
											$childs4 = get_terms( array(
												'taxonomy' => $type,
												'hide_empty' => false,
												'parent' => $chi->term_id
											) );

											if( count($childs4) > 0 ){
												foreach ($childs4 as $ch4) {
													if(is_object($ch4) ) {
														$array[] = (object) array('id' => $ch4->term_id, 'slug' => $ch4->slug, 'name' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ch4->name);

														// 5th level
														$childs5 = get_terms( array(
															'taxonomy' => $type,
															'hide_empty' => false,
															'parent' => $ch4->term_id
														) );

														if( count($childs5) > 0 ){
															foreach ($childs5 as $ch5) {
																if(is_object($ch5) ) {
																	$array[] = (object) array('id' => $ch5->term_id, 'slug' => $ch5->slug, 'name' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ch5->name);
																}
															}
														}


													}
												}
											}

										}
									}
								}


							}
						}
					}

				}
			}
		}

		return $array;
	}
}

/**
 * GET Post Types
 * post types and its categories
 */

if (! function_exists('mfn_get_posttypes')) {
	function mfn_get_posttypes( $nested = false )
	{
		// $nested = posts || tax

		$array = array( '' => esc_html__('All', 'mfn-opts') );

		if( $nested && $nested == 'posts' ){

			$array['page'] = array(
				'label' => esc_html__('Pages', 'mfn-opts'),
				'items' => get_posts( array( 'post_type' => 'page', 'numberposts' => -1 ) )
			);

			if( function_exists('is_woocommerce') ){
				$array['product'] = array(
					'label' => esc_html__('Shop', 'mfn-opts'),
					'items' => get_posts( array( 'post_type' => 'product', 'numberposts' => -1 ) )
				);
			}

			$array['post'] = array(
				'label' => esc_html__('Posts', 'mfn-opts'),
				'items' => get_posts( array( 'post_type' => 'post', 'numberposts' => -1 ) )
			);

			$array['portfolio'] = array(
				'label' => esc_html__('Portfolio', 'mfn-opts'),
				'items' => get_posts( array( 'post_type' => 'portfolio', 'numberposts' => -1 ) )
			);

			$array['offer'] = array(
				'label' => esc_html__('Offer', 'mfn-opts'),
				'items' => get_posts( array( 'post_type' => 'offer', 'numberposts' => -1 ) )
			);

		}else if( $nested && $nested == 'tax' ){

			$array['page'] = array(
				'label' => esc_html__('Pages', 'mfn-opts'),
				'items' => false
			);

			if( function_exists('is_woocommerce') ){
				$array['product'] = array(
					'label' => esc_html__('Shop', 'mfn-opts'),
					'items' => mfn_hierarchical_taxonomy('product_cat')
				);
			}

			$array['post'] = array(
				'label' => esc_html__('Posts', 'mfn-opts'),
				'items' => mfn_hierarchical_taxonomy('category')
			);

			$array['portfolio'] = array(
				'label' => esc_html__('Portfolio', 'mfn-opts'),
				'items' => mfn_hierarchical_taxonomy('portfolio-types')
			);

			$array['offer'] = array(
				'label' => esc_html__('Offer', 'mfn-opts'),
				'items' => mfn_hierarchical_taxonomy('offer-types')
			);

		}else{

			$array['page'] 		= esc_html__('Pages', 'mfn-opts');
			if( function_exists('is_woocommerce') ){
				$array['woocommerce'] = esc_html__('Shop', 'mfn-opts');
			}
			$array['post'] 		= esc_html__('Posts', 'mfn-opts');
			$array['portfolio'] = esc_html__('Portfolio', 'mfn-opts');
			$array['offer'] 	= esc_html__('Offer', 'mfn-opts');

		}

		return $array;
	}
}

/**
 *	Under Construction
 */

if (! function_exists('mfn_under_construction')) {
	function mfn_under_construction()
	{
		$php_self = $_SERVER['PHP_SELF']; // context is safe and necessary

		if (mfn_opts_get('construction')) {

			if (isset($_POST['_wpcf7'])) {
				// contact form 7 compatibility
			} else {
				if (! is_user_logged_in() && ! is_admin()
				&& basename($php_self) != 'wp-login.php'
				&& basename($php_self) != 'wp-cron.php'
				&& basename($php_self) != 'xmlrpc.php') {
					get_template_part('under-construction');
					exit();
				}
			}

		}
	}
}
add_action('init', 'mfn_under_construction', 30);

/**
 * Repetitive Link | Accessibility PBL
 */

if (! function_exists('mfn_repetitive_link')) {
	function mfn_repetitive_link( $link, $title, $repetitive_link = '' )
	{
		$ready_repetetive_text = false;
		$response = '';

		if( !empty( $repetitive_link ) ) {

			$ready_repetetive_text = $repetitive_link;

		} else {

			$post_id = url_to_postid( esc_url($link) );

			switch ( true ) {
				case $link[0] === '#' && isset($link[1]): // Scroll to section, probably anchor.
					$cleared_section_name = preg_replace('/#*/', '', $link);
					$ready_repetetive_text = 'Scroll to '.$cleared_section_name.' section';
					break;
				case $post_id === 0 || ($link[0] === '#'): // No repetitve text, do nothing
					break;
				case $post_id > 0: // Get the Title
					$ready_repetetive_text = get_the_title( $post_id );
					break;
			}

		}

		if ( ! is_bool( $ready_repetetive_text ) ) {
			$response = $title .'<span class="screen-reader-text"> - '. $ready_repetetive_text .'</span>';
		} else {
			$response = $title;
		}

		return $response;
	}
}

/**
 *	Set Max Content Width
 */

if (! isset($content_width)) {
	$content_width = 1220;
}

/**
 *	WPML | Date Format
 */

if (! function_exists('mfn_wpml_date_format')) {
	function mfn_wpml_date_format($format)
	{
		if (function_exists('icl_translate')) {
			$format = icl_translate('Formats', $format, $format);
		}
		return $format;
	}
}
add_filter('option_date_format', 'mfn_wpml_date_format');

/*
 * WPML | Workaround for compsupp-5901
 */

function mfn_wpml_encode_custom_field( $custom_field_val, $custom_field_name ) {
  if ( $custom_field_name === 'mfn-page-items' ) {
    $custom_field_val = base64_encode( serialize($custom_field_val) );
  }
  return $custom_field_val;
}
add_filter( 'wpml_encode_custom_field', 'mfn_wpml_encode_custom_field', 10, 2 );

function mfn_wpml_decode_custom_field( $custom_field_val, $custom_field_name ) {
	if ( $custom_field_name === 'mfn-page-items' && is_string($custom_field_val) ) {
		$custom_field_val = maybe_unserialize( base64_decode($custom_field_val) );
	}
	return $custom_field_val;
}
add_filter( 'wpml_decode_custom_field', 'mfn_wpml_decode_custom_field', 10, 2 );

/**
 *	WPML | ID
 *	@param type string – 'post', 'page', 'post_tag' or 'category'
 */

if (! function_exists('mfn_wpml_ID')) {
	function mfn_wpml_ID($id, $type = 'page')
	{
		if (function_exists('icl_object_id')) {
			return icl_object_id($id, $type, true);
		} else {
			return $id;
		}
	}
}

/**
 *	WPML | Term slug
 */

if (! function_exists('mfn_wpml_term_slug')) {
	function mfn_wpml_term_slug($slug, $type, $multi = false)
	{
		if (function_exists('icl_object_id')) {
			if ($multi) {

				// multiple categories

				$slugs = explode(',', $slug);

				if (is_array($slugs)) {
					foreach ($slugs as $slug_k => $slug) {
						$slug = trim($slug);

						$term = get_term_by('slug', $slug, $type);
						$term = apply_filters('wpml_object_id', $term->term_id, $type, true);
						$slug = get_term_by('term_id', $term, $type)->slug;

						$slugs[$slug_k] = $slug;
					}
				}

				$slug = implode(',', $slugs);
			} else {

				// single category

				$term = get_term_by('slug', $slug, $type);
				$term = apply_filters('wpml_object_id', $term->term_id, $type, true);
				$slug = get_term_by('term_id', $term, $type)->slug;
			}
		}

		return $slug;
	}
}

/**
 * Hubspot Impact leading code
 */

function mfn_get_hubspot_affiliate_code() {
	 return 'oegjYn';
}

add_filter( 'leadin_impact_code', 'mfn_get_hubspot_affiliate_code' );

function disable_redirect() {
  remove_all_actions( 'leadin_redirect' );
}

add_action( 'leadin_activate', 'disable_redirect' );

/**
 *	Schema | Auto Get Schema Type By Post Type
 */

if (! function_exists('mfn_tag_schema')) {
	function mfn_tag_schema()
	{
		$schema = 'https://schema.org/';

		// Is Woocommerce product
		if (function_exists('is_product') && is_product()) {
			$type = false;
		} elseif (is_single() && get_post_type() == 'post') {

			// Single post
			$type = "Article";
		} elseif (is_author()) {

			// Author page
			$type = 'ProfilePage';
		} elseif (is_search()) {

			// Search results
			$type = 'SearchResultsPage';
		} else {

			// Default
			$type = 'WebPage';
		}

		if (mfn_opts_get('mfn-seo-schema-type') && $type) {
			echo ' itemscope itemtype="'. esc_url($schema) . esc_attr($type) .'"';
		}

		return true;
	}
}

/**
 * Uploads Folder
 */

if (! function_exists('mfn_uploads_dir')) {
	function mfn_uploads_dir( $dir = 'baseurl', $depth1 = '', $depth2 = '' ){

		$upload_dir = wp_upload_dir();
		$path_be = $upload_dir[$dir] .'/betheme';

		if ( !empty($depth1) ) {
			$path_be .= '/' . $depth1;
		}

		if ( !empty($depth2) ) {
			$path_be .= '/' . $depth2;
		}

		return wp_normalize_path($path_be);
	}
}

/**
 * Bundled plugins
 */

if (! function_exists('mfn_bundled_plugins')) {
	function mfn_bundled_plugins(){

		if (! mfn_opts_get('plugin-rev')) {
	  	if (function_exists('set_revslider_as_theme')) {
	  		set_revslider_as_theme();
	  	}
	  }

	  if (! mfn_opts_get('plugin-visual')) {
	  	function mfn_vc_set_as_theme(){
	  		vc_set_as_theme();
	  	}
			add_action('vc_before_init', 'mfn_vc_set_as_theme');
	  }

	}
}
mfn_bundled_plugins();

/**
 * Is Elementor
 */

function mfn_is_elementor( $post_id ){

 	if ( ! did_action( 'elementor/loaded' ) ) {
 		return false;
 	}

 	if ( ! $post_id || wp_doing_ajax()) {
 		return false;
 	}

 	if( is_object( \Elementor\Plugin::$instance->documents->get( $post_id ) ) ){
 		return \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor();
 	}
}

/**
 *	Registration | Is hosted
 */

function mfn_is_hosted()
{
	return defined( 'ENVATO_HOSTED_KEY' ) ? true : false;
}

/**
 *	Registration | Is registered
 */

 function mfn_is_registered()
 {
 	if ( mfn_is_hosted() ) {
 		return mfn_is_hosted();
 	}

 	if ( mfn_get_purchase_code() ) {
 		return strlen( mfn_get_purchase_code() );
 	}

 	return false;
 }

/**
 *	Registration | Get purchase code
 */

function mfn_get_purchase_code()
{
 	if ( mfn_is_hosted() ) {
 		return SUBSCRIPTION_CODE;
 	}

 	$code = get_site_option( 'envato_purchase_code_7758048' );

 	if( ! $code ){
 		// BeTheme < 21.0.8 backward compatibility
 		$code = get_site_option( 'betheme_purchase_code' );
 		if( $code ){
 			update_site_option( 'envato_purchase_code_7758048', $code );
 			delete_site_option( 'betheme_purchase_code' );
 			delete_site_option( 'betheme_registered' );
 		}
 	}

	return $code;
}

/**
 *	Registration | Get purchase code with asterisk
 */

function mfn_get_purchase_code_hidden()
{
	$code = mfn_get_purchase_code();

	if ($code) {
		$code = substr($code, 0, 13);
		$code = $code .'-****-****-************';
	}

	return $code;
}

/**
 *	Registration | Get ish
 */

function mfn_get_ish()
{
	if (! defined('ENVATO_HOSTED_KEY')) {
		return false;
	}

	return substr(ENVATO_HOSTED_KEY, 0, 16);
}

/**
 * Theme support
 */

if( ! mfn_opts_get('google-font-mode') ){
	add_editor_style(array('css/editor-styles.min.css','https://fonts.googleapis.com/css?family=Poppins'));
}

add_theme_support('automatic-feed-links');
add_theme_support('custom-logo', array('width'=> 145, 'height' => 35, 'flex-height' => true, 'flex-width' => true));
add_theme_support('editor-styles');
add_theme_support('post-formats', array('image', 'video', 'quote', 'link'));
add_theme_support('post-thumbnails');
add_theme_support('title-tag');
