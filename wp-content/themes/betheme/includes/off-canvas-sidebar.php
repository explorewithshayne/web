<?php

$sidebar = mfn_sidebar(true);

if( !isset($sidebar['layout']) || $sidebar['layout'] != 'offcanvas-sidebar' || ( !isset( $sidebar['sidebar']['first'] ) && !isset( $sidebar['sidebar']['second'] ) ) ){
	return false;
}

?>

<div class="mfn-off-canvas-overlay"></div>

<div class="mfn-off-canvas-sidebar">

	<div class="mfn-off-canvas-switcher">
		<?php
		$ofcsicon = 'icon-list';
		if(mfn_opts_get('ofcs-global-icon')){
			$ofcsicon = mfn_opts_get('ofcs-global-icon');
		}
		echo '<i class="'.$ofcsicon.'" aria-label="'. __('off-canvas sidebar switch icon', 'betheme') .'"></i>';
		?>
	</div>

	<div class="mfn-off-canvas-content-wrapper">
    <div class="mfn-off-canvas-content">
      <?php
        if( isset( $sidebar['sidebar']['first'] ) ){
        	dynamic_sidebar( $sidebar['sidebar']['first'] );
        }

        if( isset( $sidebar['sidebar']['second'] ) ){
        	dynamic_sidebar( $sidebar['sidebar']['second'] );
        }
      ?>
    </div>
	</div>

</div>
