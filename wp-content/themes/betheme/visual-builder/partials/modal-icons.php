<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

$icons = Mfn_Icons::get_icons();

$custom_icon_bundle = [];

if( class_exists('Mfn_Post_Type_Icons') ){
	$custom_icon_bundle = Mfn_Post_Type_Icons::get_list_of_icons();
}

$performance_assets_disable = mfn_opts_get('performance-assets-disable');
$fa_disabled = false;

if ( ! empty( $performance_assets_disable[ 'font-awesome' ] ) ) {
	$fa_disabled = 'disabled="disabled"';
}

echo '<div class="mfn-modal modal-select-icon" id="modal-select-icon"><div class="mfn-modalbox mfn-form mfn-shadow-1"><div class="modalbox-header"><div class="options-group"><div class="modalbox-title-group"><span class="modalbox-icon mfn-icon-add-big"></span><div class="modalbox-desc"><h4 class="modalbox-title">Select an icon</h4></div></div></div><div class="options-group modalbox-search"><div class="form-control"><select class="mfn-form-control mfn-form-select mfn-select"><option value="mfnicons">Default</option><option value="fontawesome" '. $fa_disabled .'>Font Awesome</option>';

foreach( $custom_icon_bundle as $icon_pack ){
	echo '<option value="'. preg_replace('[\W]', '', $icon_pack[0]) .'">'. __($icon_pack[0], 'mfn-opts') .'</option>';
}

echo '</select></div><div class="form-control"><input class="mfn-form-control mfn-form-input search mfn-search" type="text" placeholder="Search"/></div></div><div class="options-group"><a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a></div></div><div class="modalbox-content">

<ul class="mfn-items-list list">';

foreach( $icons['mfn'] as $icon ){
	$name = str_replace( 'icon-', '', $icon );
	echo '<li class="mfnicons" data-rel="'.$icon.'"><a href="#"><span class="mfn-icon"><i class="'.$icon.'"></i></span> <p class="titleicon">'.$name.'</p></a></li>';
}

foreach( $icons['fa'] as $icon ){
	$name = str_replace( ['fas fa-', 'far fa-', 'fab fa-'], '', $icon );
	echo '<li style="display: none;" class="fontawesome" data-rel="'.$icon.'"><a href="#"><span class="mfn-icon"><i class="'.$icon.'"></i></span><p class="titleicon">'.$name.'</p></a></li>';
}

foreach( $custom_icon_bundle as $icon_pack ){

	$icon_pack_name = $icon_pack[0];
	$icon_pack_prefix = $icon_pack[1];
		$icon_pack = array_slice( $icon_pack, 2 );

		foreach( $icon_pack as $icon ){
			echo '<li class="'. preg_replace('[\W]', '', $icon_pack_name) .'" data-rel="'. esc_attr( $icon_pack_prefix .'-'. $icon ) .'"><a href="#"><span class="mfn-icon"><i class="'. esc_attr( $icon_pack_prefix .'-'. $icon ) .'"></i></span> <p>'. esc_attr( $icon ) .'</p></a></li>';
		}
}

echo '</ul></div></div></div>';
?>
