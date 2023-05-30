<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

$data = array(
	'page' => array(),
	'post' => array('category', 'post_tag'),
	'portfolio' => array('portfolio-types'),
	'offer' => array('offer-types'),
	'slide' => array('slide-types'),
);

if( function_exists('is_woocommerce') ) {
	$data['product'] = array('product_cat', 'product_tag');
}

?>
<div class="mfn-modal modal-dynamic-data" id="modal-dynamic-data">
	<div class="mfn-modalbox mfn-form mfn-shadow-1">

		<div class="modalbox-header">
			<div class="options-group">
				<div class="modalbox-title-group">
					<span class="modalbox-icon mfn-icon-add-big"></span>
					<div class="modalbox-desc">
						<h4 class="modalbox-title">Dynamic Data</h4>
					</div>
				</div>
			</div>
			
	      	<!-- <div class="options-group mfn-dd-filters right">
				<ul class="modalbox-tabs">
					<li data-filter="*" class="active"><a href="#">All</a></li>
					<li data-filter="page"><a href="#">Page</a></li>
					<li data-filter="post"><a href="#">Post</a></li>
					<?php if( function_exists('is_woocommerce') ) { ?><li data-filter="product"><a href="#">Shop</a></li><?php } ?>
					<li data-filter="portfolio"><a href="#">Portfolio</a></li>
					<li data-filter="offer"><a href="#">Offer</a></li>
				</ul>
			</div> -->
			
			<div class="options-group right">
				<div class="modalbox-search">
					<div class="form-control">
						<input class="mfn-form-control mfn-form-input mfn-search" type="text" placeholder="Search">
					</div>
				</div>
	      	</div>

			<div class="options-group">
				<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
			</div>
			
		</div>

		<div class="modalbox-content">

			<div class="mfn-dd-type-wrapper mfn-dd-type-wrapper-default">
				<h5>Dynamic</h5>
				<ul class="mfn-dd-dynamic-ul">
				</ul>
			</div>

			<div class="mfn-dd-type-wrapper mfn-dd-type-wrapper-global">
				<h5>Global</h5>
				<ul class="mfn-dd-global-ul">
				</ul>
			</div>

			<?php 

			foreach ($data as $d=>$el) {
				
				//$items = get_posts(array('post_type' => $d, 'numberposts' => 20, 'exclude' => array($this->post_id)));

				$items = $wpdb->get_results( "SELECT `ID`, `post_title` FROM {$wpdb->prefix}posts WHERE post_type = '{$d}' and post_status = 'publish' LIMIT 20" );

				if( is_iterable($items) && count($items) > 0 ){
				echo '<div class="mfn-dd-notbg mfn-dd-type-wrapper mfn-dd-dynamic-set mfn-dd-type-wrapper-'.$d.'">';
					echo '<h5>'.get_post_type_object($d)->label.'</h5>';
					echo '<ul>';
					foreach ($items as $item) {
						echo '<li data-name="'.esc_html(strtolower($item->post_title)).'"><span class="mfn-dd-copy" data-tooltip="Copy"><i class="far fa-copy"></i></span><a href="#" data-subtype=":'.$item->ID.'" data-type="title"><span class="mfn-dd-label">'.$item->post_title.'</span><span class="mfn-dd-code"></span></a></li>';
					}
					echo '</ul>';
				echo '</div>';
				}

				if( is_iterable($el) && count($el) > 0 ){
					foreach ($el as $term) {
						//$cats = get_terms( $term, array( 'hide_empty' => false ) );
						$cats = $wpdb->get_results( "SELECT tt.term_id, te.name FROM {$wpdb->prefix}term_taxonomy tt INNER JOIN {$wpdb->prefix}terms te ON tt.term_id = te.term_id WHERE tt.taxonomy = '{$term}' Limit 20 " );
						if( !empty($cats) && !is_wp_error( $cats ) ){
							echo '<div class="mfn-dd-notbg mfn-dd-type-wrapper mfn-dd-dynamic-set mfn-dd-type-wrapper-'.$d.'">';
								echo '<h5>'.get_taxonomy($term)->labels->name.'</h5>';
								echo '<ul>';
								foreach ($cats as $cat) {
									echo '<li data-name="'.esc_html(strtolower($cat->name)).'"><span class="mfn-dd-copy" data-tooltip="Copy"><i class="far fa-copy"></i></span><a href="#" data-subtype=":'.$cat->term_id.':term" data-type="title"><span class="mfn-dd-label">'.$cat->name.'</span><span class="mfn-dd-code"></span></a></li>';
								}
								echo '</ul>';
							echo '</div>';
						}
					}
				}

			}

			?>



		</div>

	</div>
</div>
