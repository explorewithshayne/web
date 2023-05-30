<?php
class MFN_Options_text extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		$class = array( 'form-group' );
		$placeholder = '';
		$preview = '';
		$type = 'text';

		// class

		if ( ! empty( $this->field['before'] ) ) {
			$class['has-addons'] = 'has-addons';
			$class[] = 'has-addons-prepend';
		}

		if ( ! empty( $this->field['after'] ) ) {
			$class['has-addons'] = 'has-addons';
			$class[] = 'has-addons-append';
		}

		$class = implode( ' ', $class );

		// placeholder

		if( ! empty( $this->field['placeholder'] ) ){
			$placeholder = $this->field['placeholder'];
		}

		if( ! empty( $this->field['std'] ) ){
			$placeholder = $this->field['std'];
		}

		// preview

		if( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		// default unit
		if( isset($this->field['default_unit']) ){
			$preview .= ' has-default-unit';
		}

		// type

		if ( ! empty( $this->field['param'] ) ){
			$type = $this->field['param'];
		}

		// output -----

		if( $vb && empty( $this->field['before'] ) && empty( $this->field['after'] ) && empty( $this->field['param'] ) ){

			if( $js ){
				echo '<input '. ( isset($this->field['default_unit']) ? 'data-unit="'.$this->field['default_unit'].'"' : null ) .' class="mfn-field-value mfn-form-control mfn-form-input '. esc_attr( $preview ) .'" type="'. esc_attr( $type ) .'" value="\'+('.$js.' && '.$js.'.length ? '.$js.'.replaceAll(/"/g, "&quot;") : "")+\'" '. $this->get_name( $meta ) .' placeholder="'. esc_attr( $placeholder ) .'"/>';
			}else{
				echo '<input '. ( isset($this->field['default_unit']) ? 'data-unit="'.$this->field['default_unit'].'"' : null ) .' class="mfn-field-value mfn-form-control mfn-form-input '. esc_attr( $preview ) .'" type="'. esc_attr( $type ) .'" value="'. esc_attr( $this->value ) .'" '. $this->get_name( $meta ) .' placeholder="'. esc_attr( $placeholder ) .'"/>';
			}

			if( !empty($this->field['dynamic_data']) ){
				echo Mfn_Options_field::dynamic_data_options($this->field['dynamic_data']);
			}
			
			
		}else{

		echo '<div class="'. esc_attr( $class ) .'">';

			if( ! empty( $this->field['before'] ) ){
				echo '<div class="form-addon-prepend">';
					echo '<span class="label">'. esc_attr( $this->field['before'] ) .'</span>';
				echo '</div>';
			}

			echo '<div class="form-control">';

				if( $js ){
					echo '<input '. ( isset($this->field['default_unit']) ? 'data-unit="'.$this->field['default_unit'].'"' : null ) .' class="mfn-field-value mfn-form-control mfn-form-input '. esc_attr( $preview ) .'" type="'. esc_attr( $type ) .'" '. $this->get_name( $meta ) .' value="\'+('.$js.' && '.$js.'.length ? '.$js.'.replaceAll(/"/g, "&quot;") : "")+\'" placeholder="'. esc_attr( $placeholder ) .'"/>';
				}else{
					echo '<input '. ( isset($this->field['default_unit']) ? 'data-unit="'.$this->field['default_unit'].'"' : null ) .' class="mfn-field-value mfn-form-control mfn-form-input '. esc_attr( $preview ) .'" type="'. esc_attr( $type ) .'" '. $this->get_name( $meta ) .' value="'. esc_attr( $this->value ) .'" placeholder="'. esc_attr( $placeholder ) .'"/>';
				}

			echo '</div>';

			if( ! empty( $this->field['after'] ) ){
				echo '<div class="form-addon-append">';
	        echo '<span class="label">'. esc_attr( $this->field['after'] ) .'</span>';
	      echo '</div>';
			}

		echo '</div>';

		}

		if( ! $vb ){
			echo $this->get_description();
		}

	}
}
