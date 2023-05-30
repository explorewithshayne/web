<?php
class MFN_Options_order extends Mfn_Options_field
{
	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{

		// output -----

		echo '<div class="form-group order-field">';
			echo '<div class="form-control">';

			echo '<ul class="tabs-wrapper">';

				if( $js ){
					$stdArray = explode( ',', $this->field['std']);
				}else{
					$stdArray = explode( ',', $this->value );
				}
				

				foreach( $stdArray as $value ){
					echo '<li class="tab">';

						echo '<div class="tab-header">';
							echo '<span class="title">'. ucfirst( $value ) .'</span>';
						echo '</div>';

					echo '</li>';
				}

			echo '</ul>';

			echo '</div>';
			if( $js ){
				echo '<input type="hidden" class="mfn-form-control mfn-field-value order-input-hidden" '. $this->get_name( $meta ) .' value="\'+('.$js.' ? '.$js.' : "")+\'" />';
			}else{
				echo '<input type="hidden" class="mfn-form-control mfn-field-value order-input-hidden" '. $this->get_name( $meta ) .' value="'. $this->value .'" />';
			}
		echo '</div>';

		if( ! $vb ){
			echo $this->get_description();
			//$this->enqueue();
		}

	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_media();
		wp_enqueue_script( 'mfn-opts-field-order', MFN_OPTIONS_URI .'fields/order/field_order.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}
}
