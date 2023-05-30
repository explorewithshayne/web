<?php
class MFN_Options_switch extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render($meta = false, $vb = false, $js = false )
	{
		$preview = '';

		$class = 'segmented-options';

		if( isset($this->field['visual_options']) ){
			$class .= ' visual-segmented-options';
		}

		if( isset($this->field['version']) && $this->field['version'] == 'multiple' ){
			$class .= ' multiple-segmented-options';
		}else{
			$class .= ' single-segmented-option';
		}

		if( isset($this->field['invert']) ){
			$class .= ' invert';
		}

		if( isset( $this->field['active_tooltip'] ) ){
			$class .= ' active-tooltip-ready';
		}

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		$this->value = preg_replace( '/\s+/', ' ', $this->value );
		$values = explode( ' ', $this->value );

		// output -----

		echo '<div class="form-group '. $class .' checkboxes-list">';

			if( !$vb ) echo '<div class="form-control">';

				if( isset($this->field['version']) && $this->field['version'] == 'multiple' ){
					if( $js ){
						echo '<input type="hidden" class="mfn-field-value" value="\'+('.$js.' && typeof '.$js.' !== \'undefined\' ? '.$js.' : "")+\'" '. $this->get_name( $meta ) .'>';
					}else{
						echo '<input type="hidden" class="mfn-field-value" value="'. esc_attr( $this->value ) .'" '. $this->get_name( $meta ) .'>';
					}
				}

				echo '<ul class="'. esc_attr( $preview ) .'">';

					foreach ( $this->field['options'] as $k => $v ) {
						$check = 'xxxx';
						$class = false;

						$tooltip = false;
						$tooltipActive = false;

						if( isset($this->field['visual_options']) ){
							$tooltip = 'data-tooltip="'.esc_attr( str_replace(array('<span>', '</span>'), '', $v) ).'"';
						}

						if( isset($this->field['active_tooltip'][$k]) ){
							$tooltipActive = 'data-tooltip-active="'.esc_attr( str_replace(array('<span>', '</span>', '<br>'), '', $this->field['active_tooltip'][$k]) ).'"';
						}

						foreach( $values as $val ){
							// if value == 0 || option key is number > 0
							if( ! $val || $k && is_int( $k ) ){
								if( $k == $val ){
									$check = $k;
									$class = "active";
								}
							// strict compare
							} else {
								if( $k === $val ){
									$check = $k;
									$class = "active";
								}
							}
						}

						// print_r([ $k, $values ]);

						if( $js ){
							if( isset($this->field['version']) && $this->field['version'] == 'multiple' ){
								echo '<li class="\'+( typeof('.$js.') !== \'undefined\' && '.$js.'.includes("'. esc_attr($k) .'") ? "active" : "") +\'" '. $tooltip .' '. $tooltipActive .'>';
							}else{
								echo '<li class="\'+( ( typeof('.$js.') === \'undefined\' && "'. esc_attr($k) .'" == "" ) || '.$js.' == "'. esc_attr($k) .'" ? "active" : "") +\'" '. $tooltip .' '. $tooltipActive .'>';
							}
						}else{
						echo '<li class="'. $class .'" '. $tooltip .' '. $tooltipActive .'>';
						}
							echo '<fieldset>';
								if( $js ){
									if( isset($this->field['version']) && $this->field['version'] == 'multiple' ){
										echo '<input type="checkbox" \'+(typeof('.$js.') !== \'undefined\' && '.$js.'.includes("'. esc_attr($k) .'") ? "checked" : "") +\' value="'. esc_attr( $k ) .'" '. $this->get_name( $meta ) .' autocomplete="off" />';
									}else{
										echo '<input class="condition-field" type="checkbox" \'+( ( typeof('.$js.') === \'undefined\' && "'. esc_attr($k) .'" == "" ) || '.$js.' == "'. esc_attr($k) .'" ? "checked" : "") +\' value="'. esc_attr( $k ) .'" '. $this->get_name( $meta ) .' autocomplete="off" />';
									}
								}else{
									echo '<input type="checkbox" '. ( !isset($this->field['version']) || $this->field['version'] == 'single' ? $this->get_name( $meta ) : null ) .' value="'. esc_attr( $k ) .'" '. checked( $check, $k, false ) .' autocomplete="off" />';
								}
								
								echo '<a href="#">';
								if( isset( $this->field['visual_options'][$k] ) ){
									echo '<span class="img img-'. esc_attr( $k ) .'">'. ( $this->field['visual_options'][$k] ?? '' ) .'</span>';
								}else{
									echo '<span class="text">'. esc_attr($v) .'</span>';
								}
								echo '</a>';
							echo '</fieldset>';
						echo '</li>';
					}

					// Option for settings, which needs to be executed ONCE while turning it on

					if( isset( $this->field['old_value'] ) ) {
						echo '<input class="old-value" type="hidden" data-id="'. esc_attr($this->field['id']) .'" value="'. esc_attr( $this->value ) .'">';
					}

				echo '</ul>';
		

			if( !$vb ) echo '</div>';

		echo '</div>';

		// visual builder

		if( ! $vb ){
			echo $this->get_description();
		}

	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-opts-field-switch', MFN_OPTIONS_URI .'fields/switch/field_switch.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

	public function vbenqueue()
	{
		wp_enqueue_script( 'mfn-opts-field-switch', MFN_OPTIONS_URI .'fields/switch/vb_field_switch.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}
}
