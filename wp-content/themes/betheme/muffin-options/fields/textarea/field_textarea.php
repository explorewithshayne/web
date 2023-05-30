<?php
class MFN_Options_textarea extends Mfn_Options_field
{

	private $inline_shortcodes = array();

	/**
	 * Constructor
	 */

	public function __construct( $field = false, $value = false, $prefix = false ){

		parent::__construct( $field, $value, $prefix );

		if( $field ){
			require_once( get_theme_file_path( '/functions/builder/class-mfn-builder-fields.php' ) );
			$this->inline_shortcodes = Mfn_Builder_Fields::get_inline_shortcode();
		}

	}

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		$cm = ''; // theme options: CSS, JS
		$editor = ''; // builder: basic (bold, i, etc), full (media, shortcodes) | HTML

		$class = '';
		$placeholder = '';
		$preview = '';

		// codemirror

		if( ! empty( $this->field['cm'] ) ){
			$cm = $this->field['cm'];
		}

		// editor

		if( ! empty( $this->field['editor'] ) ){
			$editor = $this->field['editor'];
		}

		if( $cm || $editor ){
			$class = 'html-editor';
		}

		// user settings

		if ( 'false' == get_user_option( 'syntax_highlighting' ) ){
			$class .= ' disabled';
		}

		// placeholder

		if( ! empty( $this->field['placeholder'] ) ){
			$placeholder = $this->field['placeholder'];
		}

		if( ! empty( $this->field['std'] ) ){
			$placeholder = $this->field['std'];
		}

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		// output -----

		if( $vb && empty( $this->field['editor'] ) && empty( $this->field['cm'] )){

			if( $js ){
				echo '<textarea class="mfn-form-control mfn-field-value mfn-form-textarea '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' rows="4" placeholder="'. esc_attr( $placeholder ) .'" '. $cm .' '. $editor .'>\'+('.$js.' ? '.$js.' : "")+\'</textarea>';
			}else{
				echo '<textarea class="mfn-form-control mfn-field-value mfn-form-textarea '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' rows="4" placeholder="'. esc_attr( $placeholder ) .'" '. $cm .' '. $editor .'>'. esc_attr( $this->value ) .'</textarea>';
			}

			if( !empty($this->field['dynamic_data']) ) {
				echo Mfn_Options_field::dynamic_data_options($this->field['dynamic_data']);
			}
			

		}else{

		echo '<div class="form-group '. esc_attr( $class ) .'">';
			echo '<div class="form-control">';

				if( $editor ){

	        echo '<div class="editor-header">';

		        if( 'full' == $editor ){

		        // visual builder
				if( !$js ){
		        	echo '<a class="mfn-option-btn mfn-option-text btn-icon-left btn-medium" title="Media" href="#" data-type="media"><span class="mfn-icon mfn-icon-add"></span><span class="text">Add media</span></a>';
		      	}else{
		      		echo '<div class="mfn-content-buttons">';

		      		echo '<a class="mfn-option-btn mfn-option-text btn-icon-left btn-medium" title="Media" href="#" data-type="media"><span class="mfn-icon mfn-icon-add"></span><span class="text">Media</span></a>';
		      	}

		          echo '<div class="mfn-option-dropdown dropdown-megamenu">';

		            echo '<a class="mfn-option-btn mfn-option-text btn-icon-right btn-medium" href="#"><span class="text">Shortcode</span><span class="mfn-icon mfn-icon-unfold"></span></a>';

								echo '<div class="dropdown-wrapper">';

		              echo '<a class="mfn-dropdown-item" title="Alert" href="#" data-type="alert"><span class="mfn-icon mfn-icon-shortcode"></span> Alert</a>';
		              echo '<a class="mfn-dropdown-item" title="Blockquote" href="#" data-type="blockquote"><span class="mfn-icon mfn-icon-shortcode"></span> Blockquote</a>';
		              echo '<a class="mfn-dropdown-item" title="Button" href="#" data-type="button"><span class="mfn-icon mfn-icon-shortcode"></span> Button</a>';
		              echo '<a class="mfn-dropdown-item" title="Code" href="#" data-type="code"><span class="mfn-icon mfn-icon-shortcode"></span> Code</a>';
		              echo '<a class="mfn-dropdown-item" title="Content_Link" href="#" data-type="content_link"><span class="mfn-icon mfn-icon-shortcode"></span> Content Link</a>';
		              echo '<a class="mfn-dropdown-item" title="Counter_Inline" href="#" data-type="counter_inline"><span class="mfn-icon mfn-icon-shortcode"></span> Counter Inline</a>';
		              echo '<a class="mfn-dropdown-item" title="Dropcap" href="#" data-type="dropcap"><span class="mfn-icon mfn-icon-shortcode"></span> Dropcap</a>';
		              echo '<a class="mfn-dropdown-item" title="Divider" href="#" data-type="divider"><span class="mfn-icon mfn-icon-shortcode"></span> Divider</a>';
		              echo '<a class="mfn-dropdown-item" title="Fancy_Link" href="#" data-type="fancy_link"><span class="mfn-icon mfn-icon-shortcode"></span> Fancy Link</a>';
		              echo '<a class="mfn-dropdown-item" title="Google_Font" href="#" data-type="google_font"><span class="mfn-icon mfn-icon-shortcode"></span> Google Font</a>';
		              echo '<a class="mfn-dropdown-item" title="Heading" href="#" data-type="heading"><span class="mfn-icon mfn-icon-shortcode"></span> Heading</a>';
		              echo '<a class="mfn-dropdown-item" title="Highlight" href="#" data-type="highlight"><span class="mfn-icon mfn-icon-shortcode"></span> Highlight</a>';
		              echo '<a class="mfn-dropdown-item" title="Hr" href="#" data-type="hr"><span class="mfn-icon mfn-icon-shortcode"></span> Hr</a>';
		              echo '<a class="mfn-dropdown-item" title="Icon" href="#" data-type="icon"><span class="mfn-icon mfn-icon-shortcode"></span> Icon</a>';
		              echo '<a class="mfn-dropdown-item" title="Icon_Bar" href="#" data-type="icon_bar"><span class="mfn-icon mfn-icon-shortcode"></span> Icon Bar</a>';
		              echo '<a class="mfn-dropdown-item" title="Icon_Block" href="#" data-type="icon_block"><span class="mfn-icon mfn-icon-shortcode"></span> Icon Block</a>';
		              echo '<a class="mfn-dropdown-item" title="Idea" href="#" data-type="idea"><span class="mfn-icon mfn-icon-shortcode"></span> Idea</a>';
		              echo '<a class="mfn-dropdown-item" title="Image" href="#" data-type="image"><span class="mfn-icon mfn-icon-shortcode"></span> Image</a>';
		              echo '<a class="mfn-dropdown-item" title="Popup" href="#" data-type="popup"><span class="mfn-icon mfn-icon-shortcode"></span> Popup</a>';
		              echo '<a class="mfn-dropdown-item" title="Progress_Icons" href="#" data-type="progress_icons"><span class="mfn-icon mfn-icon-shortcode"></span> Progress Icons</a>';
		              echo '<a class="mfn-dropdown-item" title="Share_Box" href="#" data-type="share_box"><span class="mfn-icon mfn-icon-shortcode"></span> Share Box</a>';
		              echo '<a class="mfn-dropdown-item" title="Tooltip" href="#" data-type="tooltip"><span class="mfn-icon mfn-icon-shortcode"></span> Tooltip</a>';
		              echo '<a class="mfn-dropdown-item" title="Tooltip_Image" href="#" data-type="tooltip_image"><span class="mfn-icon mfn-icon-shortcode"></span> Tooltip Image</a>';
		            echo '</div>';

		          echo '</div>';

						}

		        echo '<div class="mfn-option-dropdown">';

							echo '<a class="mfn-option-btn btn-icon-right mfn-option-text btn-icon-right btn-medium" href="#"><span class="text">Format</span><span class="mfn-icon mfn-icon-unfold"></span></a>';

							echo '<div class="dropdown-wrapper">';

		            echo '<h6>Headings</h6>';

		            echo '<a class="mfn-dropdown-item" title="h1" href="#" data-type="h1"><span class="mfn-icon mfn-icon-format-h1"></span> Heading 1</a>';
		            echo '<a class="mfn-dropdown-item" title="h2" href="#" data-type="h2"><span class="mfn-icon mfn-icon-format-h2"></span> Heading 2</a>';
		            echo '<a class="mfn-dropdown-item" title="h3" href="#" data-type="h3"><span class="mfn-icon mfn-icon-format-h3"></span> Heading 3</a>';
		            echo '<a class="mfn-dropdown-item" title="h4" href="#" data-type="h4"><span class="mfn-icon mfn-icon-format-h4"></span> Heading 4</a>';
		            echo '<a class="mfn-dropdown-item" title="h5" href="#" data-type="h5"><span class="mfn-icon mfn-icon-format-h5"></span> Heading 5</a>';
		            echo '<a class="mfn-dropdown-item" title="h6" href="#" data-type="h6"><span class="mfn-icon mfn-icon-format-h6"></span> Heading 6</a>';

								echo '<div class="mfn-dropdown-divider"></div>';

								echo '<h6>Others</h6>';

		            echo '<a class="mfn-dropdown-item" title="Paragraph" href="#" data-type="paragraph"><span class="mfn-icon mfn-icon-format-p"></span> Paragraph</a>';
		            echo '<a class="mfn-dropdown-item" title="Big" href="#" data-type="big"><span class="mfn-icon mfn-icon-format-p-big"></span> Big paragraph</a>';
		            echo '<a class="mfn-dropdown-item" title="Code" href="#" data-type="code"><span class="mfn-icon mfn-icon-format-code"></span> Code</a>';

							echo '</div>';

		        echo '</div>';

		        // visual builder
				if( !$js ){
		        	echo '<span class="mfn-option-sep"></span>';
		        }else{
		        	if( 'full' == $editor ){ echo '</div>'; }
		        }

						echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Paragraph" data-type="paragraph" href="#"><span class="mfn-icon mfn-icon-format-p"></span></a>';
		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Bold" data-type="bold" href="#"><span class="mfn-icon mfn-icon-bold"></span></a>';
		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Italic" data-type="italic" href="#"><span class="mfn-icon mfn-icon-italic"></span></a>';
		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Underline" data-type="underline" href="#"><span class="mfn-icon mfn-icon-underline"></span></a>';

						echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Text color" data-type="text color" href="#">';
							echo '<span class="mfn-icon mfn-icon-textcolor"></span>';
							 echo '<div class="mfn-color-tooltip-picker">';
								Mfn_Builder_Admin::field( array(
									'id' => 'color',
									'type' => 'color',
									'title' => '',
									'old_picker' => true,
									'placeholder' => '#fff',
									'alpha' => true
								) , '', $meta, 'old' );


			        echo '</div>';
						echo '</a>';

		        echo '<span class="mfn-option-sep"></span>';

		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="List ordered" href="#" data-type="list ordered"><span class="mfn-icon mfn-icon-listordered"></span></a>';
		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="List unordered" href="#" data-type="list unordered"><span class="mfn-icon mfn-icon-listunordered"></span></a>';

		        echo '<span class="mfn-option-sep"></span>';

		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Link" data-type="link" href="#"><span class="mfn-icon mfn-icon-link"></span></a>';
		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Break" data-type="break" href="#"><span class="mfn-icon mfn-icon-break"></span></a>';

		        if( 'full' == $editor ){
	            echo '<a class="mfn-option-btn btn-medium mfn-option-blank mfn-table-creator-btn" title="Table" data-type="table" href="#"><span class="mfn-icon mfn-icon-table"></span> <div class="mfn-table-creator"></div></a>';
	            echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Divider" data-type="divider" href="#"><span class="mfn-icon mfn-icon-divider"></span></a>';
	            echo '<a class="mfn-option-btn btn-medium mfn-option-blank mfn-lorem-creator-btn" title="Lorem" data-type="lorem" href="#"><span class="mfn-icon mfn-icon-lorem"></span></a>';
		        }

		        echo '<span class="mfn-option-sep"></span>';

		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Undo" data-type="undo" href="#"><span class="mfn-icon mfn-icon-undo"></span></a>';
		        echo '<a class="mfn-option-btn btn-medium mfn-option-blank" title="Redo" data-type="redo" href="#"><span class="mfn-icon mfn-icon-redo"></span></a>';


		        if( 'full' == $editor ){

			        echo '<span class="mfn-option-sep"></span>';
			        echo '<a class="mfn-option-btn btn-medium mfn-option-blank mfn-button-dynamic-data" title="Dynamic Data" data-type="dynamic_data" href="#"><span class="mfn-icon mfn-icon-dynamic-data"></span></a>';

			    }

					echo '</div>';
				}

				echo '<div class="editor-content">';

					if( 'full' == $editor ){
						echo '<div class="mfn-tooltip-sc-editor">';
							echo '<a class="mfn-option-btn mfn-option-blank" data-type="edit" title="Edit" href="#"><span class="mfn-icon mfn-icon-edit-light"></span></a>';
							echo '<a class="mfn-option-btn mfn-option-blank" data-type="remove" title="Remove" href="#"><span class="mfn-icon mfn-icon-delete-light"></span></a>';
						echo '</div>';
					}

					if( $cm ){
						$cm = 'data-cm="'. $this->field['cm'] .'"';
					}

					if( $editor ){
						$editor = 'data-editor="'. $this->field['editor'] .'"';
					}

					if( $js ){
						echo '<textarea class="mfn-form-control mfn-field-value mfn-form-textarea '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' rows="4" placeholder="'. esc_attr( $placeholder ) .'" '. $cm .' '. $editor .'>\'+('.$js.' ? '.$js.' : "")+\'</textarea>';
					}else{
						echo '<textarea class="mfn-form-control mfn-field-value mfn-form-textarea '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' rows="4" placeholder="'. esc_attr( $placeholder ) .'" '. $cm .' '. $editor .'>'. esc_attr( $this->value ) .'</textarea>';
					}
					
					// echo '<textarea id="mfn-validator" data-validator="'. $validator_type .'" class="mfn-form-control mfn-form-textarea" '. $this->get_name( $meta ) .' rows="8">'. esc_attr( $this->value ) .'</textarea>';

				echo'</div>';


			echo '</div>';
		echo '</div>';

		}

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
		wp_enqueue_script( 'mfn-opts-field-textarea', MFN_OPTIONS_URI .'fields/textarea/field_textarea.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

	public function vbenqueue()
	{
		wp_enqueue_script( 'mfn-opts-field-textarea-vb', MFN_OPTIONS_URI .'fields/textarea/field_textarea_vb.js', array( 'jquery' ), time(), true );
	}

}
