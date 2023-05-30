<?php
class MFN_Options_color_multi extends Mfn_Options_field
{

  /**
	 * Constructor
	 */

	public function __construct( $field, $value = false, $prefix = false )
	{
    parent::__construct( $field, $value, $prefix );

		if( ! is_array( $this->value ) ){
      $this->value = $field['std'];
    }

		foreach( $field['std'] as $s_key => $s_val ){
			if( empty( $this->value[$s_key] ) ){
				$this->value[$s_key] = $field['std'][$s_key];
			}
		}
	}

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		// alpha

		if ( isset( $this->field[ 'alpha' ] ) ) {
			$alpha = 'data-alpha="true"';
		} else {
			$alpha = false;
		}

		$classes = 'color-picker-vb';

		if( isset($this->field['old_picker']) && $this->field['old_picker'] ){
			$classes = '';
		}

		// output -----

		echo '<div class="form-group color-picker multi has-addons has-addons-prepend">';

			foreach( $this->field['std'] as $s_key => $s_val ){

				// border

				if( 'light' == mfn_brightness( $this->value[$s_key], 240 ) ){
					$border = false;
				} else {
					$border = $this->value[$s_key];
				}

				echo '<div class="color-picker-group color-'. esc_attr( $s_key ) .'-field" data-key="'. esc_attr( $s_key ) .'">';

					echo '<div class="form-addon-prepend">';
					if( $js ){
						echo '<a href="#" class="color-picker-open"><span class="label"><i class="icon-bucket"></i></span></a>';
					}else{
						echo '<a href="#" class="color-picker-open"><span class="label '. esc_attr( mfn_brightness( $this->value[$s_key] ) ) .'" style="background-color:'. esc_attr( $this->value[$s_key] ) .';border-color:'. esc_attr( $border ) .'"><i class="icon-bucket"></i></span></a>';
					}
					echo '</div>';

					echo '<div class="form-control has-icon has-icon-right">';
					if( $js ){
						echo '<input class="mfn-form-control mfn-form-input mfn-field-value '.$classes.'" type="text" '. $this->get_name( $meta, $s_key ) .' data-key="'.$s_key.'" data-name="'.$meta.'" value="\'+(typeof '.$js.' !== \'undefined\' && typeof '.$js.'[\''.$s_key.'\'] !== \'undefined\' ? '.$js.'[\''.$s_key.'\'] : "")+\'"  autocomplete="off" />';
					}else{
						echo '<input class="mfn-form-control mfn-form-input" type="text" '. $this->get_name( $meta, $s_key ) .' value="'. esc_attr( $this->value[$s_key] ) .'" autocomplete="off" />';
					}
						echo '<a class="mfn-option-btn mfn-option-text color-picker-clear" href="#"><span class="text">Clear</span></a>';
					echo '</div>';

					if( ! $vb ){
					echo '<input class="has-colorpicker" type="text" value="'. esc_attr( $this->value[$s_key] ) .'" data-key="'. esc_attr( $s_key ) .'" '. $alpha .' autocomplete="off" />';
					}

				echo '</div>';

			}

		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
			$this->enqueue();
		}

	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'mfn-opts-field-color', MFN_OPTIONS_URI .'fields/color/field_color.js', array( 'wp-color-picker' ), MFN_THEME_VERSION, true );
	}

}
