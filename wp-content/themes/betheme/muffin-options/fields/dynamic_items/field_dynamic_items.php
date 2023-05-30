<?php
class MFN_Options_dynamic_items extends Mfn_Options_field
{
	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		// output -----

		echo '<div class="form-group dynamic-items">';
			echo '<div class="form-control">';

			echo '<div class="dynamic_items_wrapper" data-name="'.$this->field['id'].'" data-preview="'.$this->field['options']['preview'].'">';

				// preview

				if( $js ){

					echo '<ul class="dynamic_items_preview di-preview-'.$this->field['options']['preview'].'">';
						echo '\'+ ( '.$js.' && '.$js.'.length ? '.$js.'.map( (el, i) => \'<li data-uid="\'+el.uid+\'" class="uid-\'+el.uid+\'" data-order="\'+i+\'"><img src="\'+el.url+\'" alt=""><a class="mfn-option-btn mfn-button-delete di-remove" data-tooltip="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a></li>\' ).join(\'\') : "" ) +\'';
					echo '</ul>';

				} else {

					if( empty($this->value) ){
						$this->value = '';
					}

					// echo '<input type="text" class="dynamic-items-pseudo mfn-field-value" '. $this->get_name( $meta ) .' value="'. esc_attr( json_encode($this->value) ) .'"/>';

					echo '<ul class="dynamic_items_preview di-preview-'. $this->field['options']['preview'] .'" data-count="'. count($this->value) .'">';
						if( ! empty($this->value) ){
							$i = 0;
							foreach( $this->value as $el ){
								echo '<li data-uid="'. $el['uid'] .'" class="uid-'. $el['uid'] .'">';
									echo '<img src="'. $el['url'] .'" alt="">';
									echo '<a class="mfn-option-btn mfn-button-delete di-remove" data-tooltip="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
									echo '<input type="hidden" name="'.$this->field['id'].'['.$i.'][url]" value="'. $el['url'] .'">';
									echo '<input type="hidden" name="'.$this->field['id'].'['.$i.'][id]" value="'. $el['id'] .'">';
									echo '<input type="hidden" name="'.$this->field['id'].'['.$i.'][uid]" value="'. $el['uid'] .'">';
									echo '<input type="hidden" name="'.$this->field['id'].'['.$i.'][type]" value="'. $el['type'] .'">';
								echo '</li>';
								$i++;
							}
						}
					echo '</ul>';

					echo '<ul class="new-item-wrapper">';
						echo '<li data-uid="">';
							echo '<img src="" alt="">';
							echo '<a class="mfn-option-btn mfn-button-delete di-remove" data-tooltip="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
							echo '<input class="url" type="hidden" data-name="'.$this->field['id'].'[99][url]" value="">';
							echo '<input class="id" type="hidden" data-name="'.$this->field['id'].'[99][id]" value="">';
							echo '<input class="uid" type="hidden" data-name="'.$this->field['id'].'[99][uid]" value="">';
							echo '<input class="type" type="hidden" data-name="'.$this->field['id'].'[99][type]" value="predefined">';
						echo '</li>';
					echo '</ul>';

				}

				// add new form

				echo '<label>Add new</label>';
				echo '<div class="dynamic_items_form">';
					echo '<div class="dynamic_items_row">';

						if( isset( $this->field['options']['var'] ) && is_array($this->field['options']['var']) ){
							echo '<div class="di-input-wrapper di-input-rule">';
								echo '<select class="mfn-form-control di-input">';
								foreach($this->field['options']['var'] as $v=>$var) echo '<option value="'.$v.'">'.$var.'</option>';
								echo '</select>';
							echo '</div>';
						}

						if( isset( $this->field['options']['options'] ) && is_array($this->field['options']['options']) ){
							$x = 0;
							foreach( $this->field['options']['options'] as $f=>$field ){
								$input_class = 'di-input-active';
								if( isset( $this->field['options']['options'] ) ) {
									$input_class = "di-if-".$f;
									if( ++$x == 1 ) $input_class .= ' di-input-active';
								}

								switch ( $field['type'] ) {

									case 'select-img':
										$input_uid = Mfn_Builder_Helper::unique_ID();
										echo '<div class="di-input-wrapper '.$input_class.'">';
										echo '<a href="#" data-modal="mfn-modal-'.$input_uid.'" class="di-show-modal mfn-btn btn-icon-left"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add"></span>Select</span></a>';

										echo '<div class="mfn-modal mfn-modal-payments" id="mfn-modal-'.$input_uid.'"><div class="mfn-modalbox mfn-form mfn-shadow-1"><div class="modalbox-header"><div class="options-group"><div class="modalbox-title-group"><span class="modalbox-icon mfn-icon-add-big"></span><div class="modalbox-desc"><h4 class="modalbox-title">Select payment method</h4></div></div></div><div class="options-group"><a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close inner" href="#"><span class="mfn-icon mfn-icon-close"></span></a></div></div><div class="modalbox-content"><ul class="mfn-items-list list">';

										foreach( $field['options'] as $l=>$li ){
											echo '<li><a href="#"><span class="mfn-icon"><img src="'.esc_url($li).'" alt=""></span><p class="titleicon">'.$l.'</p></a></li>';
										}

										echo '</ul></div></div></div></div>';
										break;

									case 'upload':
										echo '<div class="di-input-wrapper '.$input_class.'">';
										echo '<div class="form-group browse-image has-addons has-addons-append empty">';
											echo '<div class="form-control has-icon has-icon-right"><input type="text" name="" class="mfn-form-control mfn-field-value mfn-form-input preview-icon" value="" /><a class="mfn-option-btn mfn-button-delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a></div>';
											echo '<div class="form-addon-append"><a href="#" class="mfn-button-upload"><span class="label">'. esc_html__( 'Browse', 'mfn-opts' ) .'</span></a></div>';
											echo '<div class="selected-image"></div>';
											echo '</div>';
										echo '</div>';
										break;

									default:
										echo '<div class="di-input-wrapper '.$input_class.'">';
											echo 'default field';
										echo '</div>';
										break;
								}
							}
						}
					echo '</div>';
				echo '</div>';

				if( $this->field['options']['add_button'] ){
					echo '<a href="#" class="mfn-btn mfn-btn-green btn-icon-left dynamic_items_add"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add"></span>Add new</span></a>';
				}

			echo '</div>';

			echo '</div>';

		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		}

	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_media();
		wp_enqueue_script( 'mfn-opts-field-dynamic_items', MFN_OPTIONS_URI .'fields/dynamic_items/field_dynamic_items.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}
}
