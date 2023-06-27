<?php
class MFN_Options_transform extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$placeholder = [
			'translateX' => false,
			'translateY' => false,
			'rotate' => false,
			'scaleX' => false,
			'scaleY' => false,
			'skewX' => false,
			'skewY' => false
		];

		// inputs
		$inputs = [
			'translateX', 'translateY', 'scaleX', 'scaleY', 'skewX', 'skewY', 'rotate',
		];

		$value = $this->value;
		if ( ! $value ) {
			$value = $this->field['std'];
		}

		// output -----

		echo '<div class="form-group multiple-inputs multiple-inputs-with-color has-addons has-addons-append transform_field">';

			echo '<input type="hidden" '. $this->get_name( $meta, 'string' ) .' class="mfn-field-value mfn-pseudo-val" value="">';

			echo '<div class="form-control">';

				foreach( $inputs as $input ){

					$min = '';
					$max = '';
					$unit = '';
					$step = '';

					if ('rotate' === $input) {
						$unit = 'deg';
						$min = -180;
						$max = 180;
						$step = 1;
					} elseif('skewX' === $input || 'skewY' === $input){
						$unit = '';

						$min = -4;
						$max = 4;
						$step = 0.05;
					} elseif ('scaleX' === $input || 'scaleY' === $input) {
						$unit = '';

						$min = 0;
						$max = 3;
						$step = 0.05;
					} else {
						$min = -1040;
						$max = 1040;
						$step = 1;
						$unit = '%';
					}

					echo '<div class="field" data-key="'. esc_attr( $input ) .'">';
						echo '<div class="form-group range-slider">';
							if( $js ){
								echo '<input '. $this->get_name( $meta, $input ) .' class="mfn-form-control mfn-form-input field-to-object transform_one mfn-sliderbar-value" type="number" data-unit="'.$unit.'" data-step="'.$step.'" min="'.$min.'" max="'.$max.'" value="\'+('.$js.' && typeof '.$js.'["'.$input.'"] !== \'undefined\' ? '.$js.'["'.$input.'"] : "")+\'" data-key="'.$input.'">';
							}
							echo '<div class="sliderbar"></div>';
						echo '</div>';
					echo '</div>';
				}

			echo '</div>';
		echo '</div>';

	}

}
