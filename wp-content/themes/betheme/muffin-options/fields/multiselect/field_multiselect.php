<?php
class MFN_Options_multiselect extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		// output -----

		echo '<div class="form-group mfn-multiselect-field-wrapper">';
			echo '<div class="form-control">';
				
				if( $js ) echo '\'+( typeof '.$js.' === \'object\' && '.$js.'.length ? '.$js.'.map( (it) => \'<span data-id="\'+it.key+\'">&#10005; \'+it.value+\'</span>\' ).join("") : \'\' )+\'';
				
				echo '<input type="text" class="mfn-multiselect-input" placeholder="Type...">';
			echo '</div>';

			echo '<ul class="mfn-multiselect-options">';

			if( $js ){
				if( isset( $this->field['js_hierarchical_options'] ) ) {

					echo '\'+mfnDbLists.'.$this->field['js_hierarchical_options'].'.map( (el) => \'<li data-name="\'+el.name.toLowerCase().replaceAll("&nbsp;", "")+\'" data-id="\'+el.id+\'" \'+( typeof '.$js.' === \'object\' && '.$js.'.filter( (item) => item.key == el.id ).length ? "class=\"selected\"" : "" )+\' >\'+el.name+\'</li>\' ).join("")+\'';

				}elseif( isset( $this->field['js_options'] ) ) {

					echo '\'+mfnDbLists.'.$this->field['js_options'].'.map( (el) => \'<li data-name="\'+el.name.toLowerCase().replaceAll("&nbsp;", "")+\'" data-id="\'+el.id+\'" \'+( typeof '.$js.' === \'object\' && '.$js.'.filter( (item) => item.key == el.id ).length ? "class=\"selected\"" : "" )+\' >\'+el.name+\'</li>\' ).join("")+\'';

				}

			}

			echo '</ul>';

		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
		}

	}
}
