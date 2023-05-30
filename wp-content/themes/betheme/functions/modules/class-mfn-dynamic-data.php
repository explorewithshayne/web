<?php
defined( 'ABSPATH' ) || exit;

/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

class MfnDynamicData {

	public $id = false;
	public $second_param = false;
	public $first_param = false;

	public function render( $string, $post_id = false ) {

		//if( empty(Mfn_Builder_Front::$item_id) && Mfn_Builder_Front::$is_bebuilder ) return $string;

		if( strpos($string, '{') === false ) return $string;

		//preg_match_all( '/(.*?)\{(.*)\}\.?(.*[^;]+)?/m', $string, $match );
		preg_match_all( '/\{([^<>&\/\[\]\x00-\x20=]++)/', $string, $match );

		/*echo '<pre>';
		print_r($match);
		echo '</pre>';*/

		if( is_array($match[0]) ){
			foreach($match[0] as $dd){

				$mfn_dyn = str_replace(array('{', '}'), '', $dd);
				$this->prepare_string($mfn_dyn, $post_id);
				$fun_name = strpos($mfn_dyn, ':') !== false ? explode(':', $mfn_dyn)[0] : $mfn_dyn;

				if( method_exists( $this, $fun_name ) ){
					$ready_string = $this->$fun_name();
					$string = str_replace($dd, $ready_string, $string);
				}

			}
		}

		return $string;

	}

	public function prepare_string($string, $post_id = false){

		if( strpos($string, ':') !== false ){
			
			$explode = explode(':', $string);

			$this->first_param = $explode[0];

			if( !empty($explode[2]) && !empty($explode[1]) && is_numeric($explode[1]) ) {
				$this->id = $explode[1];
				$this->second_param = $explode[2];
			}elseif( !empty($explode[2]) && !empty($explode[1]) && is_numeric($explode[2]) ) {
				$this->id = $explode[2];
				$this->second_param = $explode[1];
			}elseif( !empty($explode[1]) && is_numeric($explode[1]) ) {
				$this->id = $explode[1];
			}elseif( !empty($explode[1]) ) {
				$this->second_param = $explode[1];
			}

			if( !$this->id && $post_id ) $this->id = $post_id;
			if( !$this->id && !empty(Mfn_Builder_Front::$item_id) ) $this->id = Mfn_Builder_Front::$item_id;
			if( !$this->second_param && !empty(Mfn_Builder_Front::$item_type) ) $this->second_param = Mfn_Builder_Front::$item_type;

		}else if( !empty(Mfn_Builder_Front::$item_id) ){
			$this->id = Mfn_Builder_Front::$item_id;
			if( !$this->second_param && !empty(Mfn_Builder_Front::$item_type) ) $this->second_param = Mfn_Builder_Front::$item_type;
		}else if( $post_id ){
			$this->id = $post_id;
		}else if( is_singular() ){
			$this->id = get_the_ID();
		}else if( is_archive() ){
			if( function_exists('is_woocommerce') && is_shop() && !empty(wc_get_page_id('shop')) ){
				$this->id = wc_get_page_id('shop');
			}else if( function_exists('is_woocommerce') && is_product_category() ){
				$qo = get_queried_object();
				$this->id = $qo->term_id;
				if( !$this->second_param ) $this->second_param = 'term';
			}
		}

	}

	public function postmeta(){

		//echo $this->id.' / '.$this->second_param;

		if( $this->id && $this->second_param ){
			return get_post_meta($this->id, $this->second_param, true);
		}

		return 'Meta unavailable';
	}

	public function title(){

		//echo $this->id.' / '.$this->second_param;

		if( $this->second_param && $this->second_param == 'site' ){
			return get_option( 'blogname' );
		}else if( $this->second_param && $this->second_param == 'term' ){
			$term = get_term($this->id);
			return $term->name;
		}else if( is_singular() && $this->second_param && $this->second_param == 'author' ){
			return get_the_author( $this->id );
		}else if( $this->id ){
			return get_the_title( $this->id );
		}else if( is_home() && get_option( 'page_for_posts' ) ){
			return get_the_title( get_option( 'page_for_posts' ) );
		}else if( is_archive() ){
			if( function_exists('is_woocommerce') && is_shop() ){
				return get_the_title( wc_get_page_id('shop') );
			}else{
				return single_term_title('', false);
			}
		}
	}

	public function featured_image(){

		//echo $this->id.' x/x '.$this->second_param;

		if( $this->second_param && $this->second_param == 'site' ){
			return mfn_opts_get('logo-img', get_theme_file_uri('/images/logo/logo.png'));
		}else if( $this->second_param && $this->second_param == 'term' ){
			$term = get_term($this->id);
			if( get_term_meta( $term->term_id, 'thumbnail_id', true ) ){
				return wp_get_attachment_url( get_term_meta( $term->term_id, 'thumbnail_id', true ), 'full' );
			}else{
				return get_theme_file_uri('/muffin-options/svg/placeholders/image.svg');
			}
		}else if( $this->id ){
			if( has_post_thumbnail($this->id) ) {
				if( $this->second_param && $this->second_param == 'tag' ){
					return '<img src="'.get_the_post_thumbnail_url($this->id, 'full').'" alt="">';
				}else{
					return get_the_post_thumbnail_url($this->id, 'full');
				}
			}else{
				if( $this->second_param && $this->second_param == 'tag' ){
					return '<img src="'.get_the_post_thumbnail_url($this->id, 'full').'" alt="">';
				}else{
					return get_theme_file_uri('/muffin-options/svg/placeholders/image.svg');
				}
			}
		}else if( function_exists('is_woocommerce') && is_product_category() ){
			$qo = get_queried_object();
			if( get_term_meta( $qo->term_id, 'thumbnail_id', true ) ){
				return wp_get_attachment_url( get_term_meta( $qo->term_id, 'thumbnail_id', true ), 'full' );
			}else{
				return get_theme_file_uri('/muffin-options/svg/placeholders/image.svg');
			}
		}else if( function_exists('is_woocommerce') && is_shop() ){
			if( has_post_thumbnail(wc_get_page_id('shop')) ) {
				return get_the_post_thumbnail_url(wc_get_page_id('shop'), 'full');
			}else{
				return get_theme_file_uri('/muffin-options/svg/placeholders/image.svg');
			}
			
		}else if( is_home() && get_option( 'page_for_posts' ) ){
			if( has_post_thumbnail( get_option( 'page_for_posts' ) ) ) {
				return get_the_post_thumbnail_url( get_option( 'page_for_posts' ), 'full' );
			}else{
				return get_theme_file_uri('/muffin-options/svg/placeholders/image.svg');
			}
		}

		return get_theme_file_uri('/muffin-options/svg/placeholders/image.svg');

	}

	public function permalink(){
		if( $this->second_param && $this->second_param == 'home' ){
			return get_home_url();
		}else if( $this->second_param && $this->second_param == 'term' ){
			$term = get_term($this->id);
			return get_term_link($term);
		}else{
			return get_the_permalink($this->id);
		}
	}

	public function excerpt(){
		if( (is_singular() || $this->id) && $this->second_param != 'term' ){
			return get_the_excerpt($this->id);
		}else if( $this->id && $this->second_param && $this->second_param == 'term' ){
			$term = get_term($this->id);
			return $term->description;
		}else if( function_exists('is_woocommerce') && is_shop() ){
			return get_the_content(wc_get_page_id('shop'));
		}else if( is_archive() ){
			return term_description();
		}
	}

	public function content(){
		
		//echo '<br>'.$this->id.' x/x '.$this->second_param;

		if( (is_singular() || $this->id) && $this->second_param != 'term' ){
			return get_the_content($this->id);
		}else if( $this->second_param && $this->second_param == 'term' ){
			$term = get_term($this->id);
			return $term->description;
		}else if( function_exists('is_woocommerce') && is_shop() ){
			return get_the_content(wc_get_page_id('shop'));
		}else if( is_archive() ){
			return term_description();
		}
	}

	public function date(){
		if( !empty($this->second_param) && $this->second_param == 'modified' ){
			return get_the_modified_date('', $this->id);
		}else{
			return get_the_date('', $this->id);
		}
	}

	public function author(){
		$post = get_post($this->id);
		return get_the_author_meta( 'display_name', $post->post_author );

		//return get_the_author();
	}

	public function categories(){

		if( !$this->id ) return '';

		$post_type = get_post_type($this->id);

		if( $post_type == 'page' ) return '';
		if( !empty($this->second_param) && $this->second_param == 'term' ) return '';

		if( $post_type == 'post' ){
			$terms = get_the_terms( $this->id, 'category' );
		}else if( $post_type == 'product' ){
			$terms = get_the_terms( $this->id, 'product_cat' );
		}else if( $post_type == 'portfolio' ){
			$terms = get_the_terms( $this->id, 'portfolio-types' );
		}else if( $post_type == 'offer' ){
			$terms = get_the_terms( $this->id, 'offer-types' );
		}else if( $post_type == 'client' ){
			$terms = get_the_terms( $this->id, 'client-types' );
		}else if( $post_type == 'slide' ){
			$terms = get_the_terms( $this->id, 'slide-types' );
		}

		if( is_array($terms) ){
			return join(', ', wp_list_pluck($terms, 'name'));
		}else{
			return $terms;
		}
		
	}

	public function category(){

		if( !$this->id ) return '';

		$post_type = get_post_type($this->id);

		if( $post_type == 'page' ) return '';
		if( !empty($this->second_param) && $this->second_param == 'term' ) return '';

		if( $post_type == 'post' ){
			$terms = get_the_terms( $this->id, 'category' );
		}else if( $post_type == 'product' ){
			$terms = get_the_terms( $this->id, 'product_cat' );
		}else if( $post_type == 'portfolio' ){
			$terms = get_the_terms( $this->id, 'portfolio-types' );
		}else if( $post_type == 'offer' ){
			$terms = get_the_terms( $this->id, 'offer-types' );
		}else if( $post_type == 'client' ){
			$terms = get_the_terms( $this->id, 'client-types' );
		}else if( $post_type == 'slide' ){
			$terms = get_the_terms( $this->id, 'slide-types' );
		}

		$main = array();

		if (!is_wp_error($terms) && !empty($terms)) {
		    foreach ($terms as $term) {
		      	if( $term->parent ) continue;
		        $main[] = $term;
		    }
		}

		if( count($main) > 0 ){
			return join(', ', wp_list_pluck($main, 'name'));
		}elseif( is_array($terms) && count($terms) > 0 ){
			return join(', ', wp_list_pluck($terms, 'name'));
		}else{
			return $terms;
		}
		
	}

	public function acf(){
		if( !class_exists( 'ACF' ) ) return 'ACF is not installed.';

		$string = 'ACF field doesn\'t exists.';

		if( get_field($this->second_param, $this->id ) ){
			$string = get_field($this->second_param, $this->id );
		}

		return $string;
	}

	public function price(){
		if( !function_exists('is_woocommerce') ) return false;

		$product = wc_get_product($this->id);

		if( !$product ) return 'Price unaivailable';

		return $product->get_price_html();

	}
}