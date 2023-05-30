<?php
class MFN_Options_box_shadow extends Mfn_Options_field
{

	/**
	 * Render
	 */

	// box shadow in theme options gpdr name is boxshadow

	public function render( $meta = false, $vb = false, $js = false )
	{

		$explode_val = false;
		$input_class = false;

 		// inputs

    $inputs = [
    	'inset',
      'x',
			'y',
			'blur',
			'spread',
			'color',
    ];

		// TODO: TMP

		if( is_array($this->value) ){
			$this->value = implode(' ', $this->value);
		}

    // box-shadow: inset 0px 4px 24px 0px rgba(66, 68, 90, 1);

    if ( ! empty($this->value) ) {
			$explode_val = explode(' ', $this->value);
		}

		// output -----

		if( $js ){
			echo '<div class="form-group multiple-inputs pseudo equal-full-inputs has-addons has-addons-append \'+ ( '.$js.' && '.$js.'.length && '.$js.'.split(" ")[0] == "inset" ? "isInset" : "" ) +\'">';
		}else{
			echo '<div class="form-group multiple-inputs pseudo equal-full-inputs has-addons has-addons-append '.( !empty($explode_val[0]) && $explode_val[0] == 'inset' ? 'isInset' : null ).'">';
		}

			echo '<div class="form-control">';

				// pseudo field
				if( $js ){
					echo '<input class="pseudo-field mfn-form-control mfn-field-value" type="hidden" '. $this->get_name( $meta  ) .' value="\'+('.$js.' ? '.$js.' : "")+\'" autocomplete="off"/>';
				}else{
					echo '<input class="pseudo-field mfn-form-control mfn-field-value" type="hidden" '. $this->get_name( $meta  ) .' value="'. $this->value .'" autocomplete="off"/>';
				}

				echo '<div class="field">';
					if( $js ){
						echo '<input type="hidden" class="mfn-form-input boxshadow-inset" value="\'+ ( '.$js.' && '.$js.'.length && '.$js.'.split(" ")[0] == "inset" ? '.$js.'.split(" ")[0] : "" ) +\'">';
					}else{
						echo '<input type="hidden" class="mfn-form-input boxshadow-inset" value="'. (!empty($explode_val[0]) && $explode_val[0] ? $explode_val[0] : null) .'">';
					}
				echo '</div>';

				foreach( $inputs as $i=>$input ){

					$input_class = 'mfn-group-field-'.$input;

					if( ! in_array( $input, array('color', 'inset') ) ){

						echo '<div class="field" data-key="'. esc_attr( $input ) .'">';
							if( $js ){
								echo '<input type="text" class="mfn-form-control mfn-form-input numeral '. esc_attr( $input_class ) .'" data-key="'. esc_attr( $input ) .'" value="\'+ ( '.$js.' && '.$js.'.length && '.$js.'.split(" ")['.$i.'].length ? '.$js.'.split(" ")['.$i.'] : "" ) +\'" autocomplete="off" placeholder="" />';
							}else{
								echo '<input type="text" class="mfn-form-control mfn-form-input numeral '. esc_attr( $input_class ) .'" data-key="'. esc_attr( $input ) .'" value="'. esc_attr( isset($explode_val[$i]) ? $explode_val[$i] : '' ) .'" autocomplete="off" placeholder="" />';
							}
						echo '</div>';

					}

				}

			echo '</div>';

			// inset

			echo '<div class="form-addon-append">';
				echo '<a href="#" class="inset">';
					echo '<span class="label">Inset</span>';
				echo '</a>';
			echo '</div>';

			echo '<div class="form-group color-picker has-addons has-addons-prepend">';
				echo '<div class="color-picker-group">';

					$brightness = isset($explode_val[5]) ? $explode_val[5] : '#fff';

					echo '<div class="form-addon-prepend">';
						echo '<a href="#" class="color-picker-open"><span class="label '. esc_attr( mfn_brightness($brightness) ) .'" style="background-color:'. esc_attr( isset($explode_val[5]) ? $explode_val[5] : '#f6f7f7' ) .';"><i class="icon-bucket"></i></span></a>';
					echo '</div>';

					echo '<div class="form-control has-icon field has-icon-right field">';
						if( $js ){
							echo '<input class="mfn-form-control mfn-form-input color-picker-vb" type="text" value="\'+ ( '.$js.' && '.$js.'.length && '.$js.'.split(" ")[5].length ? '.$js.'.split(" ")[5] : "" ) +\'" autocomplete="off" />';
						}else{
							echo '<input class="mfn-form-control mfn-form-input color-picker-vb" type="text" value="'. esc_attr( $explode_val[5] ?? '' ) .'" autocomplete="off" />';
						}
						
						echo '<a class="mfn-option-btn mfn-option-text color-picker-clear" href="#"><span class="text">Clear</span></a>';
					echo '</div>';

					if( ! $vb ){
						echo '<input class="has-colorpicker" type="text" value="'. esc_attr( $explode_val[5] ?? '' ) .'" data-alpha="true" autocomplete="off" style="visibility:hidden" />';
					}

				echo '</div>';
			echo '</div>';

		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		}

	}

	/**
	 * Enqueue Function.
	 */

	public function enqueue()
	{
		// this field uses field_dimensions.js and field_color.js

		wp_enqueue_script( 'mfn-field-box-shadow', MFN_OPTIONS_URI .'fields/box_shadow/field_box_shadow.js', array( 'jquery' ), MFN_THEME_VERSION, true );

	}

}
