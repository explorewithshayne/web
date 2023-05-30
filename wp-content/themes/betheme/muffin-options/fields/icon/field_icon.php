<?php
class MFN_Options_icon extends Mfn_Options_field{

	/**
	 * Render
	 */

	function render( $meta = false, $vb = false, $js = false ){

		$class = false;
		$placeholder = false;
		$preview = '';

		// class

		if( ! $this->value ){
			$class = 'empty';
		}

		// placeholder

		if( ! empty( $this->field['std'] ) ){
			$placeholder = $this->field['std'];
		}

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		// output -----

		if( $js ){
			echo '<div class="form-group browse-icon has-addons has-addons-prepend \'+('.$js.' ? "not-empty" : "empty") +\'">';
		}else{
			echo '<div class="form-group browse-icon has-addons has-addons-prepend '. esc_attr( $class ) .'">';
		}

			echo '<div class="form-addon-prepend">';
				echo '<a href="#" class="mfn-button-upload">';
					echo '<span class="label">';
						echo '<span class="text">'. esc_html__( 'Browse', 'mfn-opts' ) .'</span>';
						if( $js ){
							echo '<i class="\'+('.$js.' ? '.$js.' : "")+\'"></i>';
						}else{
							echo '<i class="'. esc_attr( $this->value ) .'"></i>';
						}
					echo '</span>';
				echo '</a>';
			echo '</div>';

			echo '<div class="form-control has-icon has-icon-right">';
				if( $js ){
					echo '<input class="mfn-form-control mfn-field-value mfn-form-input '. esc_attr( $preview ).'" type="text" '. $this->get_name( $meta ) .' value="\'+('.$js.' ? '.$js.' : "")+\'" placeholder="'. esc_attr( $placeholder ) .'" />';
				}else{
					echo '<input class="mfn-form-control mfn-field-value mfn-form-input '. esc_attr( $preview ).'" type="text" '. $this->get_name( $meta ) .' value="'. esc_attr( $this->value ) .'" placeholder="'. esc_attr( $placeholder ) .'" />';
				}
				
				echo '<a class="mfn-option-btn mfn-button-delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
			echo '</div>';

		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		}

	}

	/**
	 * Enqueue Function.
	*/

	function enqueue(){
		wp_enqueue_script( 'mfn-opts-field-icon', MFN_OPTIONS_URI .'fields/icon/field_icon.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
