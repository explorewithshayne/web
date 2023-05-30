<?php
class MFN_Options_font_select extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		$js_ex_0 = false;

		if( $js && strpos($js, '][') !== false ){
			$js_ex = explode('][', $js);
			$js_ex_0 = $js_ex[0].']';
		}

		$fonts = mfn_fonts();

		$is_google = $this->value;

		if( in_array( $this->value, $fonts['system'] ) || in_array( $this->value, $fonts['custom'] ) ){
			$is_google = false;
		}

		// output -----

		echo '<div class="form-group font-family-select">';
			echo '<div class="form-control">';

				echo '<select class="mfn-field-value mfn-form-control mfn-form-select" '. $this->get_name( $meta ); 

				if( $js ){
					if( $js_ex_0 && !empty($js_ex_0) ){
						echo ' data-value="\'+( '.$js_ex_0.' && '.$js.' && typeof '.$js_ex_0.' !== \'undefined\' && typeof '.$js.' !== \'undefined\' ? '.$js.' : "")+\'">';
					}else{
						echo ' data-value="\'+( '.$js.' && typeof '.$js.' !== \'undefined\' ? '.$js.' : "")+\'">';
					}
				}else{
					echo ' data-value="'. esc_attr($is_google) .'">';
				}
				

					if( ! empty( $this->field['param']['allow-empty'] ) ){
						echo '<optgroup label="'. esc_html__( 'Default', 'mfn-opts' ) .'">';
							if( $vb ){
								echo '<option value="">'. esc_html__( 'Default', 'mfn-opts' ) .'</option>';
							}else{
								echo '<option value="" '. selected($this->value, '', false).'>'. esc_html__( 'Default', 'mfn-opts' ) .'</option>';
							}
							
						echo '</optgroup>';
					}

					// system fonts

					echo '<optgroup label="'. esc_html__( 'System', 'mfn-opts' ) .'">';
						foreach ($fonts['system'] as $font) {
							$font_name = $font;
							if( '' === $font_name ){
								if( $meta ){
									$font_name = __('Default','mfn-opts');
								} else {
									$font_name = __('System font','mfn-opts'); // theme options
								}
							}
							if( $js ){
								if( $js_ex_0 && !empty($js_ex_0) ){
									echo '<option \'+( '.$js_ex_0.' && typeof '.$js_ex_0.' !== \'undefined\' && '.$js.' && typeof '.$js.' !== \'undefined\' && '.$js.' == "'. esc_attr($font) .'" ? "selected" : "") +\' value="'. esc_attr($font) .'">'. esc_html($font_name) .'</option>';
								}else{
									echo '<option \'+('.$js.' && typeof '.$js.' !== \'undefined\' && '.$js.' == "'. esc_attr($font) .'" ? "selected" : "") +\' value="'. esc_attr($font) .'">'. esc_html($font_name) .'</option>';
								}
								
							}else{
								echo '<option value="'. esc_attr($font) .'" '. selected($this->value, $font, false).'>'. esc_html($font_name) .'</option>';
							}
							
						}
					echo '</optgroup>';

					// custom font | uploaded in theme options

					if ( ! empty( $fonts['custom'] ) ) {
						echo '<optgroup label="'. esc_html__( 'Custom Fonts', 'mfn-opts' ) .'">';
							foreach ($fonts['custom'] as $font) {

								if( $js ){
									
									if( $js_ex_0 && !empty($js_ex_0) ){
										echo '<option \'+( '.$js_ex_0.' && typeof '.$js_ex_0.' !== \'undefined\' && '.$js.' && typeof '.$js.' !== \'undefined\' && '.$js.' == "'. esc_attr($font) .'" ? "selected" : "") +\' value="'. esc_attr($font) .'">'. esc_html(str_replace('#', '', $font)) .'</option>';
									}else{
										echo '<option \'+('.$js.' && typeof '.$js.' !== \'undefined\' && '.$js.' == "'. esc_attr($font) .'" ? "selected" : "") +\' value="'. esc_attr($font) .'">'. esc_html(str_replace('#', '', $font)) .'</option>';
									}

								}else{
									echo '<option value="'. esc_attr($font) .'" '. selected($this->value, $font, false).'>'. esc_html(str_replace('#', '', $font)) .'</option>';
								}
								
							}
						echo '</optgroup>';
					}

					// google fonts | all

					if ( ! empty( $fonts['all'] ) ) {
						echo '<optgroup data-type="google-fonts" label="'. esc_html__( 'Google Fonts', 'mfn-opts' ) .'">';

							if( $is_google ){
								echo '<option selected value="'. esc_attr($this->value) .'">'. esc_html($this->value) .'</option>';
							}

							echo '<option disabled value="">'. esc_html__( 'Loading...', 'mfn-opts' ) .'</option>';

							// foreach ($fonts['all'] as $font) {
								// echo '<option value="'. esc_attr($font) .'" '. selected($this->value, $font, false) .'>'. esc_html($font) .'</option>';
							// }

						echo '</optgroup>';
					}

				echo '</select>';

			echo '</div>';
		echo '</div>';

		// visual builder

		/*if( $vb ){
			$this->vbenqueue();
		}*/
	}

	/**
	 * Enqueue
	 */

	public function enqueue()
 	{
 		if( wp_script_is( 'mfn-opts-field-font-select', 'enqueued') ){
 			return; // prevent localize script more than once
 		}

 		wp_register_script( 'mfn-opts-field-font-select', MFN_OPTIONS_URI .'fields/font_select/field_font_select.js', array( 'jquery' ), MFN_THEME_VERSION, true );

 		$google_fonts = mfn_fonts('all');
 		wp_localize_script( 'mfn-opts-field-font-select', 'mfn_google_fonts', $google_fonts );

 		wp_enqueue_script( 'mfn-opts-field-font-select' );
 	}

	public function vbenqueue()
	{
		if( wp_script_is( 'mfnvb-opts-field-font-select', 'enqueued') ){
 			return; // prevent localize script more than once
 		}

		// google fonts loaded in visual class
		wp_register_script( 'mfnvb-opts-field-font-select', MFN_OPTIONS_URI .'fields/font_select/vb_field_font_select.js', array( 'jquery' ), MFN_THEME_VERSION, true );
		$google_fonts = mfn_fonts('all');
		wp_localize_script( 'mfnvb-opts-field-font-select', 'mfn_google_fonts', $google_fonts );
		wp_enqueue_script( 'mfnvb-opts-field-font-select' );
	}
}
