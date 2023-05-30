<?php
class MFN_Options_upload extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$class = false;
		$data = 'image';
		$preview = '';

		// class

		if ( ! $this->value ){
			$class = 'empty';
		}

		// data

		if ( ! empty( $this->field['data'] ) ){
			$data = $this->field['data'];
		}

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		// output -----

		if( $js ){
			echo '<div class="form-group browse-image has-addons has-addons-append \'+('.$js.' ? "not-empty" : "empty") +\'">';
		}else{
			echo '<div class="form-group browse-image has-addons has-addons-append '. esc_attr( $class ) .'">';
		}

			echo '<div class="form-control has-icon has-icon-right">';

				if( !empty($this->field['dynamic_data']) ){
					echo Mfn_Options_field::dynamic_data_options($this->field['dynamic_data']);
				}

				if( $js ){

				echo '<input class="mfn-form-control mfn-field-value mfn-form-input '. esc_attr( $preview ) .'" type="text" '. $this->get_name( $meta ) .' value="\'+('.$js.' ? '.$js.' : "")+\'" data-type="'. esc_attr( $data ) .'"/>';
				}else{
					echo '<input class="mfn-form-control mfn-field-value mfn-form-input '. esc_attr( $preview ) .'" type="text" '. $this->get_name( $meta ) .' value="'. esc_attr( $this->value ) .'" data-type="'. esc_attr( $data ) .'"/>';
				}
				echo '<a class="mfn-option-btn mfn-button-delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
			echo '</div>';

			echo '<div class="form-addon-append">';
				echo '<a href="#" class="mfn-button-upload"><span class="label">'. esc_html__( 'Browse', 'mfn-opts' ) .'</span></a>';
			echo '</div>';

			if( $js ){
				echo '<div class="break"></div>';
				echo '<div class="selected-image">';
					echo '\'+( '.$js.' && '.$js.'.length && !'.$js.'.includes(\'{\') ? \'<img src="\'+('.$js.')+\'" alt="" />\' : \'\' )+\'';
				echo '</div>';
			}elseif ( 'image' == $data ) {
				echo '<div class="break"></div>';
				echo '<div class="selected-image">';
					echo '<img src="'. esc_attr( $this->value ) .'" alt="" />';
				echo '</div>';
			}

		echo '</div>';

		// visual builder

		if( ! $vb ){
			echo $this->get_description();
		}else{
			$this->vbenqueue();
		}

	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_media();
		wp_enqueue_script( 'mfn-opts-field-upload', MFN_OPTIONS_URI .'fields/upload/field_upload.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

	public function vbenqueue()
	{
		wp_enqueue_media();
		wp_enqueue_script( 'mfn-opts-field-upload', MFN_OPTIONS_URI .'fields/upload/vb_field_upload.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
