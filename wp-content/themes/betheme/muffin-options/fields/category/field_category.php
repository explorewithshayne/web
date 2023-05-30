<?php
class MFN_Options_category extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
    $preview = '';
    $taxonomy = false;

		// preview

		if ( ! empty( $this->field['preview'] ) ){
			$preview = 'preview-'. $this->field['preview'];
		}

    // taxonomy

    if ( ! empty( $this->field['taxonomy'] ) ){
      $taxonomy = $this->field['taxonomy'];
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

    if( $js ){

      $output = wp_dropdown_categories( [
        'name' => $this->field['id'],
        'class' => 'mfn-form-control mfn-field-value mfn-form-select mfn-form-category '. esc_attr( $preview ),

        'taxonomy' => $taxonomy,

        'show_option_all' => __('All','mfn-opts'),
        'value_field' => 'slug',
        'hierarchical' => true,
        'echo' => false,
      ] );

      $output = str_replace("'", '"', $output); // change to double quote
      $output = str_replace("\n", "", $output);
      $output = str_replace("\t", "", $output);

      echo $output;

    } else {

      echo '<div class="form-group">';
  			echo '<div class="form-control">';

          wp_dropdown_categories( [
            'name' => $this->field['id'],
            'class' => 'mfn-form-control mfn-field-value mfn-form-select mfn-form-category '. esc_attr( $preview ),

            'taxonomy' => $taxonomy,
            'selected' => $this->value,

            'show_option_all' => __('All','mfn-opts'),
            'value_field' => 'slug',
            'hierarchical' => true,
          ] );

  			echo '</div>';
  		echo '</div>';

    }

		if( ! $vb ){
			echo $this->get_description();
		}

	}
}
