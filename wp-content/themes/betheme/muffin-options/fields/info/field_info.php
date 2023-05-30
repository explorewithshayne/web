<?php
class MFN_Options_info extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render($meta = false)
	{

		$conditions = '';
		$php = '';
		$class = '';

		if( ! empty($this->field['class']) ){
			$class = $this->field['class'];
		}

		// condition

		if( ! empty( $this->field['condition'] ) ){
			$class .= ' activeif activeif-'. $this->field['condition']['id'];
			$conditions = 'data-id="'. $this->field['condition']['id'] .'" data-opt="'. $this->field['condition']['opt'] .'" data-val="'. $this->field['condition']['val'] .'"';
		}

		// php

		if( ! empty( $this->field['php'] ) ){

			if( ! empty( $this->field['php']['function'] ) ){
				if( function_exists( $this->field['php']['function'] ) ){
					return;
				}
			}

		}

		// output -----

		echo '<div class="mfn-alert '. esc_attr($class) .'" '. $conditions .'>';

			echo '<div class="alert-icon mfn-icon-information"></div>';

			echo '<div class="alert-content">';
				echo '<p>'. wp_kses( str_replace('\'','&apos;',$this->field['title']), mfn_allowed_html('desc') ) .'</p>';
			echo '</div>';

			if( isset( $this->field['link'] ) && isset( $this->field['label'] ) ){

				echo '<div class="alert-options">';
					echo '<a target="_blank" href="'. esc_url( $this->field['link'] ) .'">'. esc_html( $this->field['label'] ) .'</a>';
				echo '</div>';

			}

		echo '</div>';

	}
}
