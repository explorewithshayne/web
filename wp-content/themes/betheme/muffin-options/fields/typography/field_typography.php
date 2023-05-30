<?php
class MFN_Options_typography extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$disable = false;

		// name

		$name = $this->prefix .'['. $this->field['id'] .']';

		// disable

		if( isset( $this->field['disable'] ) ){
			$disable = $this->field['disable'];
		}

		// std

		if( empty($this->field['std']) ){
			$this->field['std'] = [
				'size' => '',
				'line_height' => '',
				'weight_style' => '',
				'letter_spacing' => '',
			];
		}

		// value

		$value = $this->value;

		if ( ! $value ) {

			$value = $this->field['std'];

		} elseif ( ! is_array($value)) {

			// compatibility with Be < 13.5
			$value = array(
				'size' => $value,
				'line_height' => $this->field['std']['line_height'],
				'weight_style' => $this->field['std']['weight_style'],
				'letter_spacing' => $this->field['std']['letter_spacing'],
			);

		}

		// output -----

		// font size

		echo '<div class="form-group typography has-addons has-addons-append">';

			if( $js ){

				echo '<div class="form-control" data-key="'. esc_html__('Font size', 'mfn-opts') .'">';
					echo '<input class="mfn-form-control mfn-form-number" type="number" name="'. esc_attr( $name ) .'[size]" value="\'+('.$js.' && typeof '.$js.'["size"] !== \'undefined\' ? '.$js.'["size"] : "")+\'" data-obj="size" data-key="font-size" placeholder="'. esc_attr( $this->field['std']['size'] ) .'" '.( !empty($this->field['std']['size']) ? 'data-std="'.$this->field['std']['size'].'"' : '' ).' data-style="font-size" data-unit="px">';
				echo '</div>';
				echo '<div class="form-addon-append">';
					echo '<span class="label">px</span>';
				echo '</div>';

				if ( 'line_height' != $disable ) {

					echo '<div class="form-control" data-key="'. esc_html__('Line height', 'mfn-opts') .'">';
						echo '<input class="mfn-form-control mfn-form-number" type="number" name="'. esc_attr( $name ) .'[line_height]" value="\'+('.$js.' && typeof '.$js.'["line_height"] !== \'undefined\' ? '.$js.'["line_height"] : "")+\'" data-obj="line_height" data-key="line-height" placeholder="'. esc_attr( $this->field['std']['line_height'] ) .'" '.( !empty($this->field['std']['line_height']) ? 'data-std="'.$this->field['std']['line_height'].'"' : '' ).' data-style="line-height" data-unit="px">';
					echo '</div>';
					echo '<div class="form-addon-append">';
						echo '<span class="label">px</span>';
					echo '</div>';

				}

				echo '<div class="form-control form-control-font" data-key="'. esc_html__('Font weight & style', 'mfn-opts') .'">';
				echo '<select class="mfn-form-control mfn-form-select" name="'. esc_attr( $name ) .'[weight_style]" '.( !empty($this->field['std']['weight_style']) ? 'data-std="'.$this->field['std']['weight_style'].'"' : '' ).' data-key="weight-style" data-obj="weight_style" data-style="font-weight" data-unit="">';
					echo '<option value="">'. esc_html__('Default', 'mfn-opts') .'</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "100" ? "selected" : "")+\' value="100">100 thin</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "100italic" ? "selected" : "")+\' value="100italic">100 thin italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "200" ? "selected" : "")+\' value="200">200 extra-light</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "200italic" ? "selected" : "")+\' value="200italic">200 extra-light italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "300" ? "selected" : "")+\' value="300">300 light</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "300italic" ? "selected" : "")+\' value="300italic">300 light italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "400" ? "selected" : "")+\' value="400">400 regular</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "400italic" ? "selected" : "")+\' value="400italic">400 regular italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "500" ? "selected" : "")+\' value="500">500 medium</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "500italic" ? "selected" : "")+\' value="500italic">500 medium italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "600" ? "selected" : "")+\' value="600">600 semi-bold</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "600italic" ? "selected" : "")+\' value="600italic">600 semi-bold italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "700" ? "selected" : "")+\' value="700">700 bold</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "700italic" ? "selected" : "")+\' value="700italic">700 bold italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "800" ? "selected" : "")+\' value="800">800 extra-bold</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "800italic" ? "selected" : "")+\' value="800italic">800 extra-bold italic</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "900" ? "selected" : "")+\' value="900">900 black</option>';
					echo '<option \'+('.$js.' && typeof '.$js.'["weight_style"] !== \'undefined\' && '.$js.'["weight_style"] == "900italic" ? "selected" : "")+\' value="900italic">900 black italic</option>';
				echo '</select>';
				echo '</div>';


				echo '<div class="form-control" data-key="'. esc_html__('Letter spacing', 'mfn-opts') .'">';
					echo '<input class="mfn-form-control mfn-form-number" type="number" name="'. esc_attr( $name ) .'[letter_spacing]" value="\'+('.$js.' && typeof '.$js.'["letter_spacing"] !== \'undefined\' ? '.$js.'["letter_spacing"] : "")+\'" '.( !empty($this->field['std']['letter_spacing']) ? 'data-std="'.$this->field['std']['letter_spacing'].'"' : '' ).' data-key="letter-spacing" data-obj="letter_spacing" placeholder="'. esc_attr( $this->field['std']['letter_spacing'] ) .'" data-style="letter-spacing" data-unit="px">';
				echo '</div>';

				echo '<div class="form-addon-append">';
					echo '<span class="label">px</span>';
				echo '</div>';


			}else{

				if( empty($value['size']) ){
					$value['size'] = $this->field['std']['size'] ?? '';
				}
				if( empty($value['line_height']) ){
					$value['line_height'] = $this->field['std']['line_height'] ?? '';
				}
				if( ! isset($value['letter_spacing']) ){
					$value['letter_spacing'] = $this->field['std']['letter_spacing'] ?? '';
				}

				echo '<div class="form-control" data-key="'. esc_html__('Font size', 'mfn-opts') .'">';
					echo '<input class="mfn-form-control mfn-form-number" type="number" name="'. esc_attr( $name ) .'[size]" value="'. esc_attr( $value['size'] ) .'" data-key="font-size" placeholder="'. esc_attr( $this->field['std']['size'] ) .'">';
				echo '</div>';
				echo '<div class="form-addon-append">';
					echo '<span class="label">px</span>';
				echo '</div>';

				if ( 'line_height' != $disable ) {

					echo '<div class="form-control" data-key="'. esc_html__('Line height', 'mfn-opts') .'">';
						echo '<input class="mfn-form-control mfn-form-number" type="number" name="'. esc_attr( $name ) .'[line_height]" value="'. esc_attr( $value['line_height'] ) .'" data-key="line-height" placeholder="'. esc_attr( $this->field['std']['line_height'] ) .'">';
					echo '</div>';
					echo '<div class="form-addon-append">';
						echo '<span class="label">px</span>';
					echo '</div>';

				}

				echo '<div class="form-control form-control-font" data-key="'. esc_html__('Font weight & style', 'mfn-opts') .'">';
					echo '<select class="mfn-form-control mfn-form-select" name="'. esc_attr( $name ) .'[weight_style]" data-key="weight-style">';
						echo '<option value="" '. selected($value['weight_style'], '', false) .'>'. esc_html__('Default', 'mfn-opts') .'</option>';
						echo '<option value="100" '. selected($value['weight_style'], '100', false) .'>100 thin</option>';
						echo '<option value="100italic" '. selected($value['weight_style'], '100italic', false) .'>100 thin italic</option>';
						echo '<option value="200" '. selected($value['weight_style'], '200', false) .'>200 extra-light</option>';
						echo '<option value="200italic" '. selected($value['weight_style'], '200italic', false) .'>200 extra-light italic</option>';
						echo '<option value="300" '. selected($value['weight_style'], '300', false) .'>300 light</option>';
						echo '<option value="300italic" '. selected($value['weight_style'], '300italic', false) .'>300 light italic</option>';
						echo '<option value="400" '. selected($value['weight_style'], '400', false) .'>400 regular</option>';
						echo '<option value="400italic" '. selected($value['weight_style'], '400italic', false) .'>400 regular italic</option>';
						echo '<option value="500" '. selected($value['weight_style'], '500', false) .'>500 medium</option>';
						echo '<option value="500italic" '. selected($value['weight_style'], '500italic', false) .'>500 medium italic</option>';
						echo '<option value="600" '. selected($value['weight_style'], '600', false) .'>600 semi-bold</option>';
						echo '<option value="600italic" '. selected($value['weight_style'], '600italic', false) .'>600 semi-bold italic</option>';
						echo '<option value="700" '. selected($value['weight_style'], '700', false) .'>700 bold</option>';
						echo '<option value="700italic" '. selected($value['weight_style'], '700italic', false) .'>700 bold italic</option>';
						echo '<option value="800" '. selected($value['weight_style'], '800', false) .'>800 extra-bold</option>';
						echo '<option value="800italic" '. selected($value['weight_style'], '800italic', false) .'>800 extra-bold italic</option>';
						echo '<option value="900" '. selected($value['weight_style'], '900', false) .'>900 black</option>';
						echo '<option value="900italic" '. selected($value['weight_style'], '900italic', false) .'>900 black italic</option>';
					echo '</select>';
				echo '</div>';

				echo '<div class="form-control" data-key="'. esc_html__('Letter spacing', 'mfn-opts') .'">';
					echo '<input class="mfn-form-control mfn-form-number" type="number" name="'. esc_attr( $name ) .'[letter_spacing]" value="'. esc_attr( $value['letter_spacing'] ) .'" data-key="letter-spacing" placeholder="'. esc_attr( $this->field['std']['letter_spacing'] ) .'">';
				echo '</div>';

				echo '<div class="form-addon-append">';
					echo '<span class="label">px</span>';
				echo '</div>';

			}

		echo '</div>';

		// description

		if( ! $vb )echo $this->get_description();

	}
}
