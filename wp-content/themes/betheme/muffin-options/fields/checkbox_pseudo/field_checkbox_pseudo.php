<?php
class MFN_Options_checkbox_pseudo extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		if ( ! is_array( $this->field[ 'options' ] ) ) {
			return false;
		}

		// prepare values array

		$this->value = preg_replace( '/\s+/', ' ', $this->value );
		$values = explode( ' ', $this->value );

		// output -----

		echo '<div class="form-group checkboxes pseudo">';

			if( $js ){
				echo '<input class="value mfn-field-value" type="hidden" '. $this->get_name( $meta ) .' value="\'+('.$js.' ? '.$js.' : "")+\'"/>';
			}else{
				echo '<input class="value" type="hidden" '. $this->get_name( $meta ) .' value="'. esc_attr( $this->value ) .'"/>';
			}

			echo '<div class="form-control">';
				echo '<ul>';

					foreach ( $this->field['options'] as $k => $v ) {

						$class_js = '';

						// deprecated

						if( in_array($k, array('full-screen', 'full-width', 'equal-height', 'equal-height-wrap')) && !in_array( $k, $values ) ) {
							if( $js ){
								// in visual builder we do not know values here
								$class_js = 'mfn-deprecated';
							} else {
								continue;
							}
						};

						if( $js ){

							echo '<li class="'.$class_js.' \'+('.$js.' && '.$js.'.split(\' \').includes(\''. esc_attr($k) .'\') ? "active" : "") +\'">';
								echo '<input type="checkbox" class="mfn-form-checkbox" \'+('.$js.' && '.$js.'.includes(\''. esc_attr($k) .'\') ? "checked" : "") +\' value="'. esc_attr( $k ) .'" />';

						}else{

							$check = false;
							$class = '';

							if ( in_array( $k, $values ) ) {
								$check = $k;
								$class = "active";
							}

							echo '<li class="'. esc_attr( $class ) .'">';
								echo '<input type="checkbox" class="mfn-form-checkbox" value="'. esc_attr( $k ) .'" '. checked( $check, $k, false ) .' />';

						}

							echo '<span class="title">'. wp_kses( $v, mfn_allowed_html('desc') ) .'</span>';
						echo '</li>';

					}

				echo '</ul>';
			echo '</div>';

		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		}

	}

	/**
	 * Enqueue Function
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-opts-field-checkbox-pseudo', MFN_OPTIONS_URI .'fields/checkbox_pseudo/field_checkbox_pseudo.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
