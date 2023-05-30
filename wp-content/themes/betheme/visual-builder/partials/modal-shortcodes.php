<?php 
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}
?>
<!-- modal: add shortcode / edit shortcode -->

<div class="mfn-modal has-footer modal-small modal-add-shortcode">

	<div class="mfn-modalbox mfn-form mfn-form-verical mfn-shadow-1 mfn-sc-editor">

		<div class="modalbox-header">

			<div class="options-group">
				<div class="modalbox-title-group">
					<span class="modalbox-icon mfn-icon-add-big"></span>
					<div class="modalbox-desc">
						<h4 class="modalbox-title">Shortcode</h4>
					</div>
				</div>
			</div>

			<div class="options-group">
				<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#">
					<span class="mfn-icon mfn-icon-close"></span>
				</a>
			</div>

		</div>

		<div class="modalbox-content">
			<!-- element meta -->
		</div>

		<div class="modalbox-footer">
			<div class="options-group right">
				<a class="mfn-btn mfn-btn-blue btn-modal-close" href="#"><span class="btn-wrapper">Add Shortcode</span></a>
			</div>
		</div>

	</div>

	<div class="mfn-element-meta mfn-isc-builder">
		<?php
			foreach ( $inline_shortcodes as $shortcode ) {
				echo '<div class="mfn-isc-builder-'. esc_attr( $shortcode['type'] ) .'" data-shortcode="'. esc_attr( $shortcode['type'] ) .'">';
					foreach( $shortcode['fields'] as $sc_field ){

						$sc_placeholder = '';

						if( isset( $sc_field['std'] ) ){
						  $sc_placeholder = $sc_field['std'];
						}

						Mfn_Builder_Admin::field( $sc_field, $sc_placeholder, 'empty', 'vb' );

					}
				echo '</div>';
			}
		?>
	</div>

</div>

