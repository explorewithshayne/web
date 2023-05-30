<?php
class MFN_Options_sliderbar extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$class = array( 'form-group', 'range-slider' );
		$placeholder = '';
		$js_ex_0 = false; // typo & css filters


		$value = '';

		if( $js && strpos($js, '][') !== false ){
			$js_ex = explode('][', $js);
			$js_ex_0 = $js_ex[0].']';
		}

		// class

		if( ! empty( $this->field['after'] ) ) {
			$class['has-addons'] = 'has-addons';
			$class[] = 'has-addons-append';
		}

		if( $meta ){
			$class[] = 'pseudo';
		}

		$class = implode( ' ', $class );

		// placeholder

		if( !empty( $this->field['std'] ) ) {
			$placeholder = $this->field['std'];
		}

		if( !empty($this->field['default_value']) ) $value = $this->field['default_value'];

		if( ! empty($this->value) ){
			$value = $this->value;
		}

		// parameters

		$min = isset( $this->field['param']['min'] ) ? $this->field['param']['min'] : 1;
		$max = isset( $this->field['param']['max'] ) ? $this->field['param']['max'] : 100;
		$step = isset( $this->field['param']['step'] ) ? $this->field['param']['step'] : 1;
		$unit = isset( $this->field['param']['unit'] ) ? $this->field['param']['unit'] : '';

		$clean_value = '';

		if(isset($this->field['units'])){

			if( $unit == '' ) $unit = 'px';

			if( !empty($value) ){
				$clean_value = str_replace(array('px', 'rem', 'em', '%', 'vw', 'vh'), '', $value);

				if( strpos($value, 'rem') !== false ){
					$unit = 'rem';
				}else if( strpos($value, 'em') !== false ){
					$unit = 'em';
				}else if( strpos($value, 'vw') !== false ){
					$unit = 'vw';
				}else if( strpos($value, 'vh') !== false ){
					$unit = 'vh';
				}else if( strpos($value, '%') !== false ){
					$unit = '%';
				}
			}

		} elseif( isset( $value ) ){
			$clean_value = str_replace( array($unit, 'background'), '', $value );
		}

		// output -----

		echo '<div class="'. esc_attr( $class ) .'">';

			// units

			if( isset( $this->field['units'] ) ){
				if( $js ){
					echo '<ul class="mfn-slider-unit">';
						foreach ($this->field['units'] as $u => $nit) {
							if( $js_ex_0 ){
								echo '<li class="\'+( '.$js_ex_0.' && '.$js.' && typeof '.$js.' !== \'undefined\' && '.$js.'.replace(/[0-9\.]/g, "") == "'.$u.'" ? "active" : ( ( (!'.$js_ex_0.' || !'.$js.' && typeof '.$js.' === \'undefined\' || typeof '.$js_ex_0.' === \'undefined\') || ( '.$js_ex_0.' && !'.$js.' ) ) && "'.$u.'" == "px" ? "active" : ""  ) )+\'" data-min="'.$nit['min'].'" data-max="'.$nit['max'].'" data-step="'.$nit['step'].'"><a href="#">'.$u.'</a></li>';
							}else{
								echo '<li class="\'+( '.$js.' && typeof '.$js.' !== \'undefined\' && '.$js.'.replace(/[0-9\.]/g, "") == "'.$u.'" ? "active" : ( ( (!'.$js.' && typeof '.$js.' === \'undefined\') || ( !'.$js.' ) ) && "'.$u.'" == "px" ? "active" : ""  ) )+\'" data-min="'.$nit['min'].'" data-max="'.$nit['max'].'" data-step="'.$nit['step'].'"><a href="#">'.$u.'</a></li>';
							}
						}
					echo '</ul>';

				}else{
					echo '<ul class="mfn-slider-unit">';
						foreach ($this->field['units'] as $u => $nit) {
							echo '<li '.( isset($this->field['units']) && $unit == $u ? 'class="active"' : null ).' data-min="'.$nit['min'].'" data-max="'.$nit['max'].'" data-step="'.$nit['step'].'"><a href="#">'.$u.'</a></li>';
						}
					echo '</ul>';
				}

			}

			// except theme options

			if( $meta ){
				if( $js ){
					if( $js_ex_0 && !empty($js_ex_0) ){
						echo '<input type="hidden" class="mfn-field-value" '. $this->get_name( $meta ) .' value="\'+( '.$js_ex_0.' && '.$js.' && typeof '.$js_ex_0.' !== \'undefined\' && typeof '.$js.' !== \'undefined\' ? '.$js.' : "")+\'">';
					}else{
						echo '<input type="hidden" class="mfn-field-value" '. $this->get_name( $meta ) .' value="\'+( '.$js.' && typeof '.$js.' !== \'undefined\' ? '.$js.' : "")+\'">';
					}
				}else{
					echo '<input type="hidden" class="mfn-field-value" '. $this->get_name( $meta ) .' value="'. esc_attr( $value ) .'">';
				}
			}

			echo '<div class="form-control">';
				if( $js ){
					if( $js_ex_0 ){
						echo '<input class="mfn-form-control mfn-form-input mfn-sliderbar-value" type="number" step="'. esc_attr( $step ) .'" data-step="'. esc_attr( $step ) .'" data-unit="'. esc_attr( $unit ) .'" min="'. esc_attr( $min ) .'" max="'. esc_attr( $max ) .'" '. ( ! $meta ? $this->get_name( $meta ) : null ) .' value="\'+( '.$js_ex_0.' && '.$js.' && typeof '.$js_ex_0.' !== \'undefined\' && typeof '.$js.' !== \'undefined\' ? '.$js.'.replaceAll(/[a-z\%\s]/g, "") : "")+\'" placeholder="'. esc_attr( $placeholder ) .'" />';
					}else{
						if( !empty($unit) ){
							echo '<input class="mfn-form-control mfn-form-input mfn-sliderbar-value" type="number" step="'. esc_attr( $step ) .'" data-step="'. esc_attr( $step ) .'" data-unit="'. esc_attr( $unit ) .'" min="'. esc_attr( $min ) .'" max="'. esc_attr( $max ) .'" '. ( ! $meta ? $this->get_name( $meta ) : null ) .' value="\'+( '.$js.' && typeof '.$js.' !== \'undefined\' ? '.$js.'.replaceAll(/[a-z\%\s]/g, "") : "")+\'" placeholder="'. esc_attr( $placeholder ) .'" />';
						}else{
							echo '<input class="mfn-form-control mfn-form-input mfn-sliderbar-value" type="number" step="'. esc_attr( $step ) .'" data-step="'. esc_attr( $step ) .'" min="'. esc_attr( $min ) .'" max="'. esc_attr( $max ) .'" '. ( ! $meta ? $this->get_name( $meta ) : null ) .' value="\'+( '.$js.' && typeof '.$js.' !== \'undefined\' ? '.$js.' : "")+\'" placeholder="'. esc_attr( $placeholder ) .'" />';
						}

					}
				}else{

					// var_dump($this->value);
					// var_dump($clean_value);

					if( ! $meta ){ // theme options
						if( '' === $this->value ){ // empty value
							$clean_value = $this->field['std'];
						} elseif( '0' === $this->value ){ // zero
							$clean_value = 0;
						}
					}
					
					echo '<input class="mfn-form-control mfn-form-input mfn-sliderbar-value" type="number" step="'. esc_attr( $step ) .'" data-step="'. esc_attr( $step ) .'" data-unit="'. esc_attr( $unit ) .'" min="'. esc_attr( $min ) .'" max="'. esc_attr( $max ) .'" '. ( ! $meta ? $this->get_name( $meta ) : null ) .' value="'. esc_attr( $clean_value ) .'" placeholder="'. esc_attr( $placeholder ) .'" />';
				}

			echo '</div>';

			if( ! empty( $this->field['after'] ) ){
				echo '<div class="form-addon-append">';
					echo '<span class="label">'. esc_attr( $this->field['after'] ) .'</span>';
				echo '</div>';
			}

			echo '<div class="sliderbar"></div>';

			if( ! $meta ){
				echo '<div class="range">'. esc_attr( $min ) .' - '. esc_attr( $max ) .'</div>';
			}

		echo '</div>';

		// theme options

		if( ! $meta ){
			echo $this->get_description();
		}
	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_style( 'mfn-opts-jquery-ui-css' );
		wp_enqueue_script( 'mfn-opts-field-sliderbar', MFN_OPTIONS_URI .'fields/sliderbar/field_sliderbar.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-slider' ), MFN_THEME_VERSION, true );
	}
}
