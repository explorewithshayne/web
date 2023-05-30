<?php
class MFN_Options_text_shadow extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$value = '';
		$explode_val = false;
		$input_class = false;

 		// inputs

    $inputs = [
      'horizontal', 'vertical', 'blur'
    ];

    if ( isset($this->value) ) {
			$value = $this->value;
			$explode_val = explode(' ', $value);
		} elseif( ! empty( $this->field['std'] ) ) {
			$value = $this->field['std'];
		}

		// output -----

		echo '<div class="form-group multiple-inputs pseudo equal-full-inputs">';

			echo '<div class="form-control">';

				// pseudo field
				if( $js ){
					echo '<input class="pseudo-field mfn-field-value mfn-form-control" type="hidden" '. $this->get_name( $meta  ) .' value="\'+('.$js.' ? '.$js.' : "")+\'" autocomplete="off"/>';
				}else{
					echo '<input class="pseudo-field mfn-field-value mfn-form-control" type="hidden" '. $this->get_name( $meta  ) .' value="'. $value .'" autocomplete="off"/>';
				}

				foreach( $inputs as $i=>$input ){

					$input_class = 'mfn-group-field-'.$input;

					echo '<div class="field numeral" data-key="'. esc_attr( $input ) .'">';
						if( $js ){
							echo '<input type="text" class="mfn-form-control mfn-form-input numeral '. esc_attr( $input_class ) .'" data-key="'. esc_attr( $input ) .'" value="\'+('.$js.' && '.$js.'.split(" ")['.$i.'] ? '.$js.'.split(" ")['.$i.'] : "")+\'" autocomplete="off" placeholder="" />';
						}else{
							echo '<input type="text" class="mfn-form-control mfn-form-input numeral '. esc_attr( $input_class ) .'" data-key="'. esc_attr( $input ) .'" value="'. esc_attr( isset($explode_val[$i]) ? $explode_val[$i] : '' ) .'" autocomplete="off" placeholder="" />';
						}
					echo '</div>';

				}

			echo '</div>';

			echo '<div class="form-group color-picker has-addons has-addons-prepend">';

				echo '<div class="color-picker-group">';

					$brightness = isset($explode_val[3]) ? $explode_val[3] : '#fff';

					echo '<div class="form-addon-prepend">';
						echo '<a href="#" class="color-picker-open"><span class="label '. esc_attr( mfn_brightness($brightness) ) .'" style="background-color:'. esc_attr( isset($explode_val[3]) ? $explode_val[3] : '#f6f7f7' ) .';"><i class="icon-bucket"></i></span></a>';
					echo '</div>';

					echo '<div class="form-control has-icon field has-icon-right field">';
						if( $js ){
							echo '<input class="mfn-form-control mfn-form-input color-picker-vb" type="text" value="\'+('.$js.' && '.$js.'.split(" ")[3] ? '.$js.'.split(" ")[3] : "")+\'" autocomplete="off" />';
						}else{
							echo '<input class="mfn-form-control mfn-form-input color-picker-vb" type="text" value="'. esc_attr( $explode_val[3] ?? '' ) .'" autocomplete="off" />';
						}
						
						echo '<a class="mfn-option-btn mfn-option-text color-picker-clear" href="#"><span class="text">Clear</span></a>';
					echo '</div>';

					if( ! $vb ){
						echo '<input class="has-colorpicker" type="text" value="'. esc_attr( $explode_val[3] ?? '' ) .'" data-alpha="true" autocomplete="off" style="visibility:hidden" />';
					}

				echo '</div>';

			echo '</div>';

		echo '</div>';

	}

	/**
	 * Enqueue Function.
	 */

	public function enqueue()
	{
		// this field uses also: field_dimensions.js and field_color.js
	}

}
