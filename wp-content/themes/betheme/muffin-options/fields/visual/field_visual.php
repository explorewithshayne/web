<?php
class MFN_Options_visual extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		$preview = '';

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		// visual bulder
		if( strpos( $meta, 'sections[' ) === false ){
			$visu_id = 'mfn-editor';
		}else{
			$visu_id = 've_'.rand(0, 9999);
		}

		// output -----

		echo '<div class="form-group visual-editor">';
			echo '<div class="form-control">';

				echo '<div class="wp-core-ui wp-editor-wrap tmce-active">';

					if ( 'false' != get_user_option( 'syntax_highlighting' ) ){

						echo '<div class="wp-editor-tools hide-if-no-js">';
							echo '<div class="wp-media-buttons">';
							echo '<button type="button" class="button insert-media add_media" data-editor="'. $visu_id .'"><span class="wp-media-buttons-icon"></span> Add Media</button>';
						echo '</div>';
						echo '<div class="wp-editor-tabs">';
							echo '<button type="button" class="wp-switch-editor switch-tmce" data-wp-editor-id="'. $visu_id .'">Visual</button>';
							echo '<button type="button" class="wp-switch-editor switch-html" data-wp-editor-id="'. $visu_id .'">Text</button>';
						echo '</div>';
					echo '</div>';

					}
					echo '<div class="wp-editor-container">';
						if( $js ){
							echo '<textarea class="mfn-form-control editor wp-editor-area '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' data-visual="mce" id="'. $visu_id .'" rows="8">\'+('.$js.' ? '.$js.' : "")+\'</textarea>';
						}else{
							echo '<textarea class="mfn-form-control editor wp-editor-area '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' data-visual="mce" data-id="'. $visu_id .'" rows="8">'. esc_textarea( $this->value ) .'</textarea>';
						}
					echo '</div>';

				echo '</div>';

			echo '</div>';
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
		$localize = array(
			'mfnsc' => get_theme_file_uri( '/functions/tinymce/plugin.js' ),
		);

		wp_enqueue_media();

		wp_enqueue_script( 'mfn-opts-field-visual', MFN_OPTIONS_URI .'fields/visual/field_visual.js', array( 'jquery' ), MFN_THEME_VERSION, true );
		wp_localize_script( 'mfn-opts-field-visual', 'fieldVisualJS', $localize);
	}

}
