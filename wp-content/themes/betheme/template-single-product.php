<?php

// 1. from product
// 2. by conditions (cat, tag)
// 3. from theme options by default

if( function_exists( 'mfn_ID' ) ){
	$tmp_id = mfn_ID();
}

if( ( empty($_GET['visual']) || !empty($_GET['mfn-template-id']) ) && isset( $tmp_id ) && is_numeric( $tmp_id ) && get_post_type( $tmp_id ) == 'template' ){

	echo '<div class="product">';

		echo '<div class="section_wrapper clearfix">';
			do_action( 'woocommerce_before_single_product' );
		echo '</div>';

		$mfn_builder = new Mfn_Builder_Front( $tmp_id );
		$mfn_builder->show();

		echo '<div class="section_wrapper clearfix">';
			do_action('woocommerce_after_single_product');
		echo '</div>';

	echo '</div>';

}else{

	echo '<div class="section section_product_before_tabs">';
		echo '<div class="section_wrapper clearfix">';
			woocommerce_content();
		echo '</div>';
	echo '</div>';
	
}

?>
