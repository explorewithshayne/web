<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Helper {

	/**
	 * Initialises and connects the WordPress Filesystem
	 */

	public static function filesystem(){

		global $wp_filesystem;

		if( ! defined( 'FS_METHOD' ) ){
			define( 'FS_METHOD', 'direct' );
		}

		if( ! defined( 'FS_CHMOD_DIR' ) ){
			define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
		}

		if( ! defined( 'FS_CHMOD_FILE' ) ){
			define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
		}

		if( empty( $wp_filesystem ) ){
			require_once wp_normalize_path( ABSPATH .'/wp-admin/includes/file.php' );
		}

		WP_Filesystem();

		return $wp_filesystem;
	}

	/**
	 * Prepare local styles and fonts before update
	 */

	public static function preparePostUpdate($sections, $post_id = false){
		$return = array();
		$return['custom'] = array();
		$return['global'] = array();
		$return['tablet'] = array();
		$return['mobile'] = array();
		$return['fonts'] = array();
		$return['sections'] = array(); // sorted sections

		ksort($sections);

		foreach ($sections as $s => $section) {

			if( strpos($section['uid'], '/') !== false ) $sections[$s]['uid'] = Mfn_Builder_Helper::unique_ID();

			if(isset($section['wraps']) && count($section['wraps']) > 0){
				ksort($section['wraps']);
				$sections[$s]['wraps'] = $section['wraps'];

				if(isset($section['attr']) && count($section['attr']) > 0){
					foreach($section['attr'] as $x=>$sattr){

						if ( strpos( $x, 'style:' ) !== false && !empty($sattr) ) {

							if( is_array($sattr) ){

								foreach ($sattr as $g => $d) {

									if( strpos( $x, 'gradient' ) !== false && $g != 'string' ) continue;
									if( strpos( $x, ':filter' ) !== false && $g != 'string' ) continue;

									if( strpos( $x, '_tablet' ) !== false || strpos( $g, '_tablet' ) !== false){
										$return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle($x.'_'.$g, $d, $section['uid'], $post_id));
									}elseif( strpos( $x, '_mobile' ) !== false || strpos( $g, '_mobile' ) !== false){
										$return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle($x.'_'.$g, $d, $section['uid'], $post_id));
									}else{
										$return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle($x.'_'.$g, $d, $section['uid'], $post_id));
									}
								}

							}else{

								if(strpos( $x, '_tablet' ) !== false){
									$return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle($x, $sattr, $section['uid'], $post_id));
								}elseif(strpos( $x, '_mobile' ) !== false){
									$return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle($x, $sattr, $section['uid'], $post_id));
								}else{
									$return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle($x, $sattr, $section['uid'], $post_id));
								}

							}

						}
					}
				}

				foreach($section['wraps'] as $w => $wrap){

					if( strpos($wrap['uid'], '/') !== false ) $sections[$s]['wraps'][$w]['uid'] = Mfn_Builder_Helper::unique_ID();

					if(isset($wrap['attr']) && count($wrap['attr']) > 0){

						foreach($wrap['attr'] as $a=>$attr){
							if ( strpos( $a, 'style:' ) !== false && !empty($attr) ) {

								if( is_array($attr) ){

									foreach ($attr as $o => $p) {

										if( strpos( $a, 'gradient' ) !== false && $o != 'string' ) continue;
										if( strpos( $a, ':transform' ) !== false && $o != 'string' ) continue;

										if(strpos( $a, '_tablet' ) !== false || strpos( $o, '_tablet' ) !== false){
											$return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle($a.'_'.$o, $p, $wrap['uid'], $post_id));
		  								}elseif(strpos( $a, '_mobile' ) !== false || strpos( $o, '_mobile' ) !== false){
		  									$return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle($a.'_'.$o, $p, $wrap['uid'], $post_id));
		  								}else{
		  									$return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle($a.'_'.$o, $p, $wrap['uid'], $post_id));
		  								}
									}

								}else{
									if(strpos( $a, '_tablet' ) !== false){
										$return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle($a, $attr, $wrap['uid'], $post_id));
	  								}elseif(strpos( $a, '_mobile' ) !== false){
	  									$return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle($a, $attr, $wrap['uid'], $post_id));
	  								}else{
	  									$return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle($a, $attr, $wrap['uid'], $post_id));
	  								}
								}

							}
						}
					}

					if(isset($wrap['items']) && count($wrap['items']) > 0){
						ksort($wrap['items']);
						$sections[$s]['wraps'][$w]['items'] = $wrap['items'];

						foreach($wrap['items'] as $y=>$item){

							if( isset($item['uid']) && strpos($item['uid'], '/') !== false ) $sections[$s]['wraps'][$w]['items'][$y]['uid'] = Mfn_Builder_Helper::unique_ID();

							if(isset($item['fields']) && count($item['fields']) > 0){

								if( !empty($item['fields']['used_fonts']) ){
									$fonts_arr = explode(',', $item['fields']['used_fonts']);
									$return['fonts'] = array_unique(array_merge($return['fonts'],$fonts_arr));
								}

								foreach($item['fields'] as $f=>$field){
									if($item['type'] == 'shop_products' && $f == 'products'){
										update_post_meta( $post_id, 'mfn_template_perpage', $field );
									}elseif($item['type'] == 'product_cart_button' && $f == 'cart_button_text'){
										update_post_meta( $post_id, 'mfn_cart_button', $field );
									}elseif ( strpos( $f, 'style:' ) !== false && !empty($field) ) {

										if( is_array($field) ){

											foreach($field as $n=>$m){

												if( strpos( $n, 'font-family' ) !== false && !in_array($m, $return['fonts']) && !empty($m) ){
													$return['fonts'][] = $m;
													$m = "'".$m."'";
												}

												if( strpos( $f, 'gradient' ) !== false && $n != 'string' ) continue;
												if( strpos( $f, ':transform' ) !== false && $n != 'string' ) continue;

												if( strpos( $f, '_tablet' ) !== false || strpos( $n, '_tablet' ) !== false ){
		  											$return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle($f.'_'.$n, $m, $item['uid'], $post_id));
				  								}elseif( strpos( $f, '_mobile' ) !== false || strpos( $n, '_mobile' ) !== false ){
				  									$return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle($f.'_'.$n, $m, $item['uid'], $post_id));
				  								}elseif( strpos( $f, '_custom' ) !== false || strpos( $n, '_custom' ) !== false ){
				  									$return['custom'] = array_merge_recursive($return['custom'], self::mfnLocalStyle($f.'_'.$n, $m, $item['uid'], $post_id));
				  								}else{
				  									$return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle($f.'_'.$n, $m, $item['uid'], $post_id));
				  								}
											}

										}else{


											if( strpos( $f, '_tablet' ) !== false ){
	  											$return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle($f, $field, $item['uid'], $post_id));
	  											if( strpos( $f, ':flex_tablet' ) !== false ) $return['tablet'] = array_merge_recursive($return['tablet'], self::mfnLocalStyle(str_replace(':flex', ':max-width', $f), $field, $item['uid'], $post_id));
			  								}elseif(strpos( $f, '_mobile' ) !== false){
			  									$return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle($f, $field, $item['uid'], $post_id));
			  									if( strpos( $f, ':flex_mobile' ) !== false ) $return['mobile'] = array_merge_recursive($return['mobile'], self::mfnLocalStyle(str_replace(':flex', ':max-width', $f), $field, $item['uid'], $post_id));
			  								}elseif(strpos( $f, '_custom' ) !== false){
			  									$return['custom'] = array_merge_recursive($return['custom'], self::mfnLocalStyle($f, $field, $item['uid'], $post_id));
			  								}else{
			  									$return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle($f, $field, $item['uid'], $post_id));
			  									if( strpos( $f, ':flex' ) !== false && strpos( $f, ':flex-' ) === false ) $return['global'] = array_merge_recursive($return['global'], self::mfnLocalStyle(str_replace(':flex', ':max-width', $f), $field, $item['uid'], $post_id));
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

		$return['sections'] = $sections;

		return $return;
	}

	/**
	 * Local style
	 */

	public static function mfnLocalStyle($sel, $val, $uid, $post_id = false) {

		if( empty($val) || $val == 'cover-ultrawide' || $val == 'custom' ) {
			return array();
		}

		$style_arr = array();

		$style_sel = explode(':', $sel);
		array_shift( $style_sel );

		$selector = $style_sel[0];

		if( $uid ){
			$selector = str_replace('mfnuidelement', $uid, $style_sel[0]);

			$selector = str_replace('mcb-section-inner', 'mcb-section-inner-'.$uid, $selector);
			$selector = str_replace('section_wrapper', 'mcb-section-inner-'.$uid, $selector);
			$selector = str_replace('mcb-wrap-inner', 'mcb-wrap-inner-'.$uid, $selector);
			$selector = str_replace('mcb-column-inner', 'mcb-column-inner-'.$uid, $selector);
		}

		$style_name = $style_sel[1];

		$values_prefixes = array(
			'flex' => '0 0 ',
			'background-image' => 'url(',
			'background-image_tablet' => 'url(',
			'background-image_mobile' => 'url(',
			'-webkit-mask-image' => 'url(',
			'transformtranslatex' => 'translateX(',
			'transformtranslatey' => 'translateY(',
			'transform_string' => 'matrix(',
		);

		$values_postfixes = array(
			'background-image' => ')',
			'background-image_tablet' => ')',
			'background-image_mobile' => ')',
			'-webkit-mask-image' => ')',
			'transformtranslatex' => ')',
			'transformtranslatey' => ')',
			'transform_string' => 'deg)'
		);

		$additional_styles = array(
			'font-size' => 'line-height: 1.3em;'
		);

		$selector = str_replace('|', ':', $selector);

		$style_name = str_replace(array('_mobile', '_tablet', 'typography_', 'translatex', 'translatey', '_v2'), '', $style_name);
		$style_name = str_replace(array('_'), '-', $style_name);

		$style_value = str_replace('gradient-string', 'background-image', $style_name).':';
		$style_value = str_replace('filter-string', 'filter', $style_value);
		$style_value = str_replace('transform-string', 'transform', $style_value);

		if( !empty($values_prefixes[$style_sel[1]]) ){
			$style_value .= $values_prefixes[$style_sel[1]];
		}

		if ( $style_sel[1] === 'transform_string' ) {
			$val = preg_replace("/(\,+)(?!.*,)/", ") rotate(", $val);
		}

		$style_value .= $val;

		if( !empty($values_postfixes[$style_sel[1]]) ){
			$style_value .= $values_postfixes[$style_sel[1]];
		}

		if( strpos( $val, '{featured_image' ) !== false ) $style_value = 'background-image: var(--mfn-featured-image)';

		$style_value .= ';';

		$style_arr[$selector] = $style_value;
		return $style_arr;
	}

	public static function generate_css($mfn_styles, $post_id, $preview = false){

	  	$wp_filesystem = self::filesystem();

		$upload_dir = wp_upload_dir();
		$path_be = wp_normalize_path( $upload_dir['basedir'] .'/betheme' );
		$path_css = wp_normalize_path( $path_be .'/css' );

		if( $preview ){
			$path = wp_normalize_path( $path_css .'/post-'.$post_id.'-preview.css' );
		}else{
			$path = wp_normalize_path( $path_css .'/post-'.$post_id.'.css' );
		}

		if( ! file_exists( $path_be ) ){
			wp_mkdir_p( $path_be );
		}

		if( ! file_exists( $path_css ) ){
			wp_mkdir_p( $path_css );
		}

		$css = "";

		if( isset($mfn_styles['global']) ){
			foreach($mfn_styles['global'] as $sel=>$st){
				if(is_array($st)){
					$css .= $sel.'{';
					foreach($st as $style){
						$css .= $style;
					}
					$css .= '}';
				}else{
					$css .= $sel.'{'.$st.'}';
				}
			}
		}

		if( isset($mfn_styles['tablet']) ){
			$css .= '@media(max-width: 959px){';
			foreach($mfn_styles['tablet'] as $sel=>$st){
				if(is_array($st)){
					$css .= $sel.'{';
					foreach($st as $style){
						$css .= $style;
					}
					$css .= '}';
				}else{
					$css .= $sel.'{'.$st.'}';
				}
			}
			$css .= '}';
		}

		if( isset($mfn_styles['mobile']) ){
			$css .= '@media(max-width: 767px){';
			foreach($mfn_styles['mobile'] as $sel=>$st){
				if(is_array($st)){
					$css .= $sel.'{';
					foreach($st as $style){
						$css .= $style;
					}
					$css .= '}';
				}else{
					$css .= $sel.'{'.$st.'}';
				}
			}
			$css .= '}';
		}

		if( isset($mfn_styles['custom']) ){
			foreach($mfn_styles['custom'] as $sel=>$st){

				if(is_array($st)){
					foreach($st as $style){
						$mq = str_replace( array('show-under-custom', 'hide-under-custom', ':', ';'), '', $style );
						if( strpos( $style, 'hide-under' ) !== false ){
							$css .= '@media(max-width: '.$mq.'){ '.$sel.'{display: none;}}';
						}else if( strpos( $style, 'show-under' ) !== false ){
							$css .= $sel.'{display: none;}';
							$css .= '@media(max-width: '.$mq.'){ '.$sel.'{display: block;}}';
						}
					}
				}else{
					$mq = str_replace( array('show-under-custom', 'hide-under-custom', ':', ';'), '', $st );
					if( strpos( $st, 'hide-under' ) !== false ){
						$css .= '@media(max-width: '.$mq.'){ '.$sel.'{display: none;}}';
					}else if( strpos( $st, 'show-under' ) !== false ){
						$css .= $sel.'{display: none;}';
						$css .= '@media(max-width: '.$mq.'){ '.$sel.'{display: block;}}';
					}
				}


			}
		}

		//echo $css;
		$wp_filesystem->put_contents( $path, $css, FS_CHMOD_FILE );

	}

	public static function generate_bebuilder_items($bepath, $beitems){
		$wp_filesystem = self::filesystem();
		$folder_path = get_template_directory().'/visual-builder/assets/js/forms';
		if( ! file_exists( $folder_path ) ) wp_mkdir_p( $folder_path );
		$path = wp_normalize_path( $bepath );
		$make = $wp_filesystem->put_contents( $path, $beitems, FS_CHMOD_FILE );
		return $make;
	}

	/**
	 * Registration modal
	 */

	public static function the_modal_register(){

		?>

			<div class="mfn-register-now">
				<div class="inner-content">
					<div class="be">
						<img class="be-logo" src="<?php echo get_theme_file_uri( 'muffin-options/svg/others/be-gradient.svg' ); ?>" alt="Be">
					</div>
					<div class="info">
                        <span class="mfn-register-now-icon"></span>
						<h4>Please register the license<br />to get the access to Muffin Options</h4>
						<p class="">This page reload is required after theme registration</p>
						<a class="mfn-btn mfn-btn-green btn-large" href="admin.php?page=betheme" target="_blank"><span class="btn-wrapper">Register now</span></a>
					</div>
				</div>
			</div>

		<?php

	}

	/**
	 * Cache string
	 */

	public static function get_cache_text()
	{
		$content = '
# BEGIN BETHEME';

		$content .= '
<IfModule mod_expires.c>
ExpiresActive On

# Images
ExpiresByType image/jpeg "access plus 1 year"
ExpiresByType image/gif "access plus 1 year"
ExpiresByType image/png "access plus 1 year"
ExpiresByType image/webp "access plus 1 year"
ExpiresByType image/svg+xml "access plus 1 year"
ExpiresByType image/x-icon "access plus 1 year"

# Video
ExpiresByType video/webm "access plus 1 year"
ExpiresByType video/mp4 "access plus 1 year"
ExpiresByType video/mpeg "access plus 1 year"

# Fonts
ExpiresByType font/ttf "access plus 1 year"
ExpiresByType font/otf "access plus 1 year"
ExpiresByType font/woff "access plus 1 year"
ExpiresByType font/woff2 "access plus 1 year"
ExpiresByType application/font-woff "access plus 1 year"

# CSS, JavaScript
ExpiresByType text/css "access plus 6 months"
ExpiresByType text/javascript "access plus 6 months"
ExpiresByType application/javascript "access plus 6 months"

# Others
ExpiresByType application/pdf "access plus 6 months"
ExpiresByType image/vnd.microsoft.icon "access plus 1 year"

ExpiresDefault "access 1 month"

</IfModule>
';

		$content .= '# END BETHEME';
		return $content;
	}

}
