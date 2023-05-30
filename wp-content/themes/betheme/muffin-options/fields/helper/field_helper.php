<?php
class MFN_Options_helper extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render($meta = false)
	{

		// output -----

		echo '<div class="mfn-help-info"><a href="'. esc_url( $this->field['link'] ) .'" target="_blank"><span class="mfn-icon mfn-icon-desc"></span>'. $this->field['title'] .'</a></div>';

	}
}
