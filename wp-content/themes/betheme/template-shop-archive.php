<?php

// 1. by conditions (cat, tags)
// 2. from theme options by default

wp_enqueue_script('mfn-waypoints', get_theme_file_uri('/js/plugins/waypoints.min.js'), ['jquery'], MFN_THEME_VERSION, true);

if ( mfn_opts_get('shop-layout') === 'masonry' ) {
	wp_enqueue_script('mfn-isotope', get_theme_file_uri('/js/plugins/isotope.min.js'), ['jquery'], MFN_THEME_VERSION, true);
}

if( function_exists( 'mfn_ID' ) ){
	$tmp_id = mfn_ID();
}

if( isset( $tmp_id ) && is_numeric( $tmp_id ) && get_post_type( $tmp_id ) == 'template' ){

	$mfn_builder = new Mfn_Builder_Front($tmp_id);
	$mfn_builder->show();

} else {
	echo '<div class="section">';
		echo '<div class="section_wrapper clearfix default-woo-list">';
			woocommerce_content();
		echo '</div>';
	echo '</div>';
}


?>
