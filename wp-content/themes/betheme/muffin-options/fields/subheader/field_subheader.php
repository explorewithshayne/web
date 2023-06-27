<?php
class MFN_Options_subheader extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		echo '<h5 class="row-header-title">'. $this->field['title'] .'</h5>';
	}
  
}
