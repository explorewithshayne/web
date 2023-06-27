<?php
class MFN_Options_select extends Mfn_Options_field
{

	/**
	 * Render
	 * @deprecated $vb
	 * @deprecated $js
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$preview = '';

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

		// options

		if( empty($this->field['options']) && ! empty($this->field['php_options']) ){
			$this->field['options'] = $this->field['php_options'];
		}

		// WPML

		if ( ! empty( $this->field['wpml'] ) ) {
			if ( $this->value && function_exists( 'icl_object_id' ) ) {
				$term = get_term_by( 'slug', $this->value, $this->field['wpml'] );
				$term = apply_filters( 'wpml_object_id', $term->term_id, $this->field['wpml'], true );
				$this->value = get_term_by( 'term_id', $term, $this->field['wpml'] )->slug;
			}
		}

		// output -----

		echo '<div class="form-group">';
			echo '<div class="form-control">';

				echo '<select class="mfn-form-control mfn-field-value mfn-form-select '. esc_attr( $preview ) .'" '. $this->get_name( $meta ) .' autocomplete="off">';

					if ( isset( $this->field['hierarchical_options'] ) && is_array($this->field['hierarchical_options']) ) {
						echo '<option>'. esc_html__('All', 'mfn-opts') .'</option>';
						foreach ( $this->field['hierarchical_options'] as $k => $v ) {
							echo '<option value="'. esc_attr($v->slug) .'" '. selected($this->value, $v->slug, false) .'>'. esc_html($v->name) .'</option>';
						}
					} else if ( !empty($this->field['options']) && is_array($this->field['options']) ) {
						foreach ( $this->field['options'] as $k => $v ) {

							if( 0 === strpos($k, '#optgroup') ){
								if( $v ){
									echo '<optgroup label="'. esc_attr($v) .'">';
								} else {
									echo '</optgroup>';
								}
								continue;
							}

							echo '<option value="'. esc_attr($k) .'" '. selected($this->value, $k, false) .'>'. esc_html($v) .'</option>';
						}
					}
				echo '</select>';

			echo '</div>';
		echo '</div>';

		echo $this->get_description();

	}
}
