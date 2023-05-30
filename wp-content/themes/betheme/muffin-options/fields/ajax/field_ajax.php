<?php
class MFN_Options_ajax extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false )
	{
		$action = isset( $this->field['action'] ) ? $this->field['action'] : '';
		$param 	= isset( $this->field['param'] ) ? $this->field['param'] : '';

		$button = isset( $this->field['button'] ) ? $this->field['button'] : __( 'Randomize', 'mfn-opts' );

		echo '<div class="form-group ajax">';
			echo '<div class="form-control">';

				echo '<a class="mfn-btn mfn-btn-blue" href="#" data-nonce="'. wp_create_nonce( 'mfn-builder-nonce' ) .'" data-ajax="'. esc_url( admin_url( 'admin-ajax.php' ) ) .'" data-action="'. esc_attr( $action ) .'" data-param="'. esc_attr( $param ) .'">';
					echo '<span class="btn-wrapper">'. esc_html( $button ) .'</span>';
				echo '</a>';

			echo '</div>';
		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		}

		// enqueue

		$this->enqueue();
	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-opts-field-ajax', MFN_OPTIONS_URI .'fields/ajax/field_ajax.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}
}
