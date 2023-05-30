<?php
class MFN_Options_gradient extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		$value = false;
		$border = false;
		$pseudoval = '';

	  // background-color: transparent;
	  // background-image: linear-gradient(270deg, #C65A5A 50%, #0A0909 100%); // linear
	  // background-image: radial-gradient(at center center, #C65A5A 50%, #0A0909 100%); // radial

	  if ( isset($this->value) ) {
			$value = $this->value;
		}

		if( isset($value['color']) && isset($value['color2']) && isset($value['location']) && isset($value['location2']) && isset($value['type']) && isset($value['angle']) && isset($value['position']) ){

			$pseudoval .= $value['type'].'(';

			if( $value['type'] == 'linear-gradient' ){
				$pseudoval .= $value['angle'].'deg, ';
			}else{
				$pseudoval .= 'at '.$value['position'].', ';
			}

			$pseudoval .= $value['color'].' ';
			$pseudoval .= $value['location'].'%, ';
			$pseudoval .= $value['color2'].' ';
			$pseudoval .= $value['location2'].'%)';

		}

		$rand = md5(time().rand(0, 9999));

		echo '<div class="gradient-form">';

			echo '<input '. $this->get_name( $meta, 'string' ) .' class="pseudo-field gradient-hidden mfn-field-value" type="hidden" data-key="string" value="'.$pseudoval.'" autocomplete="off"/>';

			// color 1

			echo '<div class="form-control">';
				echo '<label>Color</label>';
				echo '<div class="form-group color-picker has-addons has-addons-prepend">';
					echo '<div class="color-picker-group">';

						echo '<div class="form-addon-prepend">';
							echo '<a href="#" class="color-picker-open"><span class="label '. ( isset($value['color']) ? esc_attr( mfn_brightness( $value['color'] ) ) : null ) .'" style="background-color:'. ( isset($value['color']) ? esc_attr( $value['color'] ) : '' ) .';border-color:'. esc_attr( $border ) .'"><i class="icon-bucket"></i></span></a>';
						echo '</div>';

						echo '<div class="form-control has-icon has-icon-right">';
							if( $js ){
								echo '<input '. $this->get_name( $meta, 'color' ) .' class="mfn-form-control field-to-object gradient-color mfn-form-input color-picker-vb" type="text" value="\'+('.$js.' && '.$js.'["color"] ? '.$js.'["color"] : "")+\'" autocomplete="off" data-key="color" />';
							}else{
								echo '<input '. $this->get_name( $meta, 'color' ) .' class="mfn-form-control gradient-color mfn-form-input color-picker-vb" type="text" value="'. ( isset($value['color']) ? esc_attr( $value['color'] ) : '' ) .'" autocomplete="off" data-key="color" />';
							}
							echo '<a class="mfn-option-btn mfn-option-text color-picker-clear" href="#"><span class="text">Clear</span></a>';
						echo '</div>';

						if( ! $vb ){
							echo '<input class="has-colorpicker" type="text" value="'. esc_attr( $value['color'] ?? '' ) .'" data-alpha="true" autocomplete="off" style="visibility:hidden" />';
						}

					echo '</div>';
				echo '</div>';
			echo '</div>';

			// location 1

			echo '<div class="form-control">';
				echo '<label>Location</label>';
				echo '<div class="form-group range-slider">';
					echo '<div class="form-control">';
						if( $js ){
							echo '<input '. $this->get_name( $meta, 'location' ) .' class="mfn-form-control field-to-object mfn-form-input gradient-location mfn-sliderbar-value mfn-gradient-field" type="number" data-unit="" data-step="1" min="0" max="100" value="\'+('.$js.' && '.$js.'["location"] ? '.$js.'["location"] : "0")+\'" data-key="location">';
						}else{
							echo '<input '. $this->get_name( $meta, 'location' ) .' class="mfn-form-control mfn-form-input gradient-location mfn-sliderbar-value mfn-gradient-field" type="number" data-unit="" data-step="1" min="0" max="100" value="'. ( $value['location'] ?? '0' ) .'" data-key="location">';
						}
					echo '</div>';
					echo '<div class="sliderbar"></div>';
				echo '</div>';
			echo '</div>';

			// color 2

			echo '<div class="form-control">';
				echo '<label>Second color</label>';
				echo '<div class="form-group color-picker has-addons has-addons-prepend">';
					echo '<div class="color-picker-group">';

						echo '<div class="form-addon-prepend">';
							echo '<a href="#" class="color-picker-open"><span class="label '. ( isset($value['color2']) ? esc_attr( mfn_brightness( $value['color2'] ) ) : null ) .'" style="background-color:'. ( isset($value['color2']) ? esc_attr( $value['color2'] ) : '' ) .';border-color:'. esc_attr( $border ) .'"><i class="icon-bucket"></i></span></a>';
						echo '</div>';

						echo '<div class="form-control has-icon has-icon-right">';
							if( $js ){
								echo '<input '. $this->get_name( $meta, 'color2' ) .' class="mfn-form-control field-to-object gradient-color2 mfn-form-input color-picker-vb" type="text" value="\'+('.$js.' && '.$js.'["color2"] ? '.$js.'["color2"] : "")+\'" autocomplete="off" data-key="color2" />';
							}else{
								echo '<input '. $this->get_name( $meta, 'color2' ) .' class="mfn-form-control gradient-color2 mfn-form-input color-picker-vb" type="text" value="'. ( isset($value['color2']) ? esc_attr( $value['color2'] ) : '' ) .'" autocomplete="off" data-key="color2" />';
							}
							echo '<a class="mfn-option-btn mfn-option-text color-picker-clear" href="#"><span class="text">Clear</span></a>';
						echo '</div>';

						if( ! $vb ){
							echo '<input class="has-colorpicker" type="text" value="'. esc_attr( $value['color2'] ?? '' ) .'" data-alpha="true" autocomplete="off" style="visibility:hidden" />';
						}

					echo '</div>';
				echo '</div>';
			echo '</div>';

			// location 2

			echo '<div class="form-control">';
				echo '<label>Second location</label>';
				echo '<div class="form-group range-slider">';
					echo '<div class="form-control">';
						if( $js ){
							echo '<input '. $this->get_name( $meta, 'location2' ) .' class="mfn-form-control field-to-object mfn-form-input gradient-location2 mfn-sliderbar-value mfn-gradient-field" type="number" data-unit="" data-step="1" min="0" max="100" value="\'+('.$js.' && '.$js.'["location2"] ? '.$js.'["location2"] : "100")+\'" data-key="location2">';
						}else{
							echo '<input '. $this->get_name( $meta, 'location2' ) .' class="mfn-form-control mfn-form-input gradient-location2 mfn-sliderbar-value mfn-gradient-field" type="number" data-unit="" data-step="1" min="0" max="100" value="'. ( $value['location2'] ?? '100' ) .'" data-key="location2">';
						}
					echo '</div>';
					echo '<div class="sliderbar"></div>';
				echo '</div>';
			echo '</div>';

			// type

			echo '<div class="form-control mfn-form-row" id="gradient-type'.$rand.'">';
				echo '<label>Type</label>';
				echo '<div class="form-group">';
					echo '<select '. $this->get_name( $meta, 'type' ) .' class="mfn-form-control field-to-object condition-field mfn-form-input gradient-type" data-key="type">';
						if( $js ){
							echo '<option \'+('.$js.' && '.$js.'["type"] && '.$js.'["type"] == "linear-gradient" ? "selected" : null)+\' value="linear-gradient">Linear gradient</option>';
							echo '<option \'+('.$js.' && '.$js.'["type"] && '.$js.'["type"] == "radial-gradient" ? "selected" : null)+\' value="radial-gradient">Radial gradient</option>';
						}else{
							echo '<option '. ( isset($value['type']) && $value['type'] == "linear-gradient" ? "selected" : null ) .' value="linear-gradient">Linear gradient</option>';
							echo '<option '. ( isset($value['type']) && $value['type'] == "radial-gradient" ? "selected" : null ) .' value="radial-gradient">Radial gradient</option>';
						}
					echo '</select>';
				echo '</div>';
			echo '</div>';

			// location 2

			echo '<div class="form-control mfn-form-row activeif activeif-gradient-type'.$rand.'" data-conditionid="gradient-type'.$rand.'" data-val="linear-gradient" data-opt="is">';
				echo '<label>Angle</label>';
				echo '<div class="form-group range-slider">';
					echo '<div class="form-control">';
						if( $js ){
							echo '<input '. $this->get_name( $meta, 'angle' ) .' class="mfn-form-control field-to-object mfn-form-input gradient-angle mfn-sliderbar-value mfn-gradient-field" type="number" data-unit="" data-step="1" min="0" max="360" value="\'+('.$js.' && '.$js.'["angle"] ? '.$js.'["angle"] : "0")+\'" data-key="angle">';
						}else{
							echo '<input '. $this->get_name( $meta, 'angle' ) .' class="mfn-form-control mfn-form-input gradient-angle mfn-sliderbar-value mfn-gradient-field" type="number" data-unit="" data-step="1" min="0" max="360" value="'. ( $value['angle'] ?? '0' ) .'" data-key="angle">';
						}
					echo '</div>';
					echo '<div class="sliderbar"></div>';
				echo '</div>';
			echo '</div>';

			// position

			echo '<div class="form-control mfn-form-row activeif activeif-gradient-type'.$rand.'" data-conditionid="gradient-type'.$rand.'" data-val="radial-gradient" data-opt="is">';
				echo '<div class="form-group">';
					echo '<label>Position</label>';
					echo '<select '. $this->get_name( $meta, 'position' ) .' class="mfn-form-control field-to-object mfn-form-input gradient-position">';
						if( $js ){
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "center center" ? "selected" : null)+\' value="center center">Center Center</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "center left" ? "selected" : null)+\' value="center left">Center Left</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "center right" ? "selected" : null)+\' value="center right">Center Right</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "top center" ? "selected" : null)+\' value="top center">Top Center</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "top left" ? "selected" : null)+\' value="top left">Top Left</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "top right" ? "selected" : null)+\' value="top right">Top Right</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "bottom center" ? "selected" : null)+\' value="bottom center">Bottom Center</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "bottom left" ? "selected" : null)+\' value="bottom left">Bottom Left</option>';
							echo '<option \'+('.$js.' && '.$js.'["position"] && '.$js.'["position"] == "bottom right" ? "selected" : null)+\' value="bottom right">Bottom Right</option>';
						}else{
							echo '<option '.( !empty($value['position']) && $value['position'] == 'center center' ? "selected" : null ).' value="center center">Center Center</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'center left' ? "selected" : null ).' value="center left">Center Left</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'center right' ? "selected" : null ).' value="center right">Center Right</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'top center' ? "selected" : null ).' value="top center">Top Center</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'top left' ? "selected" : null ).' value="top left">Top Left</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'top right' ? "selected" : null ).' value="top right">Top Right</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'bottom center' ? "selected" : null ).' value="bottom center">Bottom Center</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'bottom left' ? "selected" : null ).' value="bottom left">Bottom Left</option>';
							echo '<option '.( !empty($value['position']) && $value['position'] == 'bottom right' ? "selected" : null ).' value="bottom right">Bottom Right</option>';
						}
					echo '</select>';
				echo '</div>';
			echo '</div>';

		echo '</div>';

	}


	/**
	 * Enqueue Function.
	 */

	public function enqueue()
	{
		// this field uses field_dimensions.js and field_color.js

		wp_enqueue_script( 'mfn-field-gradient', MFN_OPTIONS_URI .'fields/gradient/field_gradient.js', array( 'jquery' ), MFN_THEME_VERSION, true );

	}

}
