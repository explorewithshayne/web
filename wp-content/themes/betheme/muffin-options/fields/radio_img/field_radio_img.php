<?php
class MFN_Options_radio_img extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render($meta = false, $vb = false, $js = false)
	{

		// alias

		$alias = $this->field['id'];

		if( ! empty( $this->field['alias'] ) ){
			$alias = $this->field['alias'];
		}

		// output -----

		echo '<div class="form-group visual-options positioning-options checkboxes-list">';
			echo '<div class="form-control">';
				echo '<ul>';

					foreach ( $this->field['options'] as $k => $v ) {

						if( checked( $this->value, $k, false ) ){
							$class = 'active';
						} else {
							$class = false;
						}

						if( $js ){
							echo '<li class="\'+('.$js.' && '.$js.' == "'. esc_attr($k) .'" ? "active" : "") +\'">';
							echo '<input type="checkbox" '. $this->get_name( $meta ) .' \'+('.$js.' && '.$js.' == "'. esc_attr($k) .'" ? "checked" : "") +\' value="'. esc_attr( $k ) .'" autocomplete="off"/>';
						}else{
							echo '<li class="'.$class.'">';
							echo '<input type="checkbox" '. $this->get_name( $meta ) .' value="'. esc_attr( $k ) .'" '. checked( $this->value, $k, false ) .' autocomplete="off"/>';
						}

							echo '<a href="#">';
								echo '<div class="mfn-icon" data-tooltip="'.esc_attr( str_replace(array('<span>', '</span>', '<br>'), ' ', $v) ).'">';

									if( ! $k ){
										$k = '_default';
									} else {
										$k = str_replace( array( ',', ';', ' ' ), '-', $k );
									}

									echo '<img src="'. esc_url( MFN_OPTIONS_URI .'svg/select/'. $alias .'/'. $k .'.svg' ) .'" alt="'. esc_attr( $v ) .'" />';

								echo '</div>';
								echo '<span class="label">'. wp_kses( str_replace('\'','&apos;',$v), mfn_allowed_html('desc') ) .'</span>';
							echo '</a>';
						echo '</li>';
					}

				echo '</ul>';
			echo '</div>';
		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		} else {
			$this->enqueue();
		}

	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-opts-field-radio_img', MFN_OPTIONS_URI .'fields/radio_img/field_radio_img.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
