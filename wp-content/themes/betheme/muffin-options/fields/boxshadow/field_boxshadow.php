<?php
class MFN_Options_boxshadow extends Mfn_Options_field
{

	/**
	 * Render
	 */

	// box shadow in visual builder name is box_shadow

	public function render( $meta = false )
	{
		$placeholder = [
			'x' => false,
			'y' => false,
			'blur' => false,
			'spread' => false,
			'color' => false,
			'inset' => false
		];

		// inputs
		$inputs = [
			'x', 'y', 'blur', 'spread', 'color'
		];

		// value

		if( ! is_array( $this->value ) ){
			$this->value = $this->field['std'];
		}

		// placeholder

		if( ! empty( $this->field['std'] ) && is_array( $this->field['std'] ) ){
			$placeholder = $this->field['std'];
		}

		// output -----

		echo '<div class="form-group multiple-inputs multiple-inputs-with-color has-addons has-addons-append '. ($this->value['inset'] ? 'isInset' : '')  .' ">';

			echo '<div class="form-control">';

				foreach( $inputs as $input ){

					if( $input === 'color' ){

						// Box shadow color MIRROR

						echo '<div class="field color-mirror" data-key="color">';
							echo '<input data-unit="" type="hidden" class="mfn-form-control mfn-to-bs-input mfn-form-input" '. $this->get_name( $meta, $input ) .' data-key="'. esc_attr( $input ) .'" value="'. $this->value['color'] .'" autocomplete="off"/>';
						echo '</div>';

					}else{

						echo '<div class="field" data-key="'. esc_attr( $input ) .'">';
							echo '<input data-unit="px" type="text" class="mfn-form-control mfn-to-bs-input mfn-form-input numeral" '. $this->get_name( $meta, $input ) .' data-key="'. esc_attr( $input ) .'" value="'. esc_attr( $this->value[$input] ) .'" autocomplete="off" placeholder="'. esc_attr( $placeholder[$input] ).'" />';
						echo '</div>';

					}

				}

				echo '<div class="field form-addon-append">';
					echo '<a href="#" class="inset">';
						echo '<span class="label">Inset</span>';
						echo '<input type="hidden" '. $this->get_name( $meta, 'inset' ) .' value="'. esc_attr( $this->value['inset'] ) .'" autocomplete="off"/>';
					echo '</a>';
				echo '</div>';

				//Box shadow color
				echo '<div class="field color-mirror-source" data-key="color">';
					Mfn_Builder_Admin::field( array(
						'id' => 'color-mirror',
						'type' => 'color',
						'alpha' => true,
						'title' => '',
						'class' => 'no-row',
						'std' => $this->value['color'],
					) , '', false );
				echo '</div>';

			echo '</div>';

		echo '</div>';

		echo $this->get_description();

	}

	/**
	 * Enqueue Function.
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-field-boxshadow', MFN_OPTIONS_URI .'fields/boxshadow/field_boxshadow.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
