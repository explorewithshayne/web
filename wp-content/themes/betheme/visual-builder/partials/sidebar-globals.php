<?php  
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

echo '<div class="panel panel-global-sections" style="display: none;"><ul class="prebuilt-sections-list global-sections">';

$globals = mfna_templates('section');

if( count($globals) > 0 ){
    foreach( $globals as $g_section_key => $g_section_val ){
    echo '<li style="display: block;" data-id="'. $g_section_key .'">
        <div class="desc">
        <h6>'.$g_section_val.'</h6>
        <a class="mfn-option-btn mfn-option-text btn-icon-left mfn-option-green mfn-btn-insert mfn-insert-global-section" title="Insert" data-tooltip="Insert to your project" href="#">
            <span class="mfn-icon mfn-icon-add"></span><span class="text">Select</span>
        </a>
        </div>
    </li>';
    }
}else{
    echo '<div class="mfn-form-row mfn-vb-formrow "><div class="mfn-alert "><div class="alert-icon mfn-icon-information"></div><div class="alert-content"><p>No global sections have been created yet. If you would like to set global section, please <a target="_blank" href="'.admin_url('edit.php?post_type=template&tab=section').'">create it first.</a></p></div></div></div>';
}

    echo '</ul>';
    echo '<a target="_blank" href="'.admin_url('edit.php?post_type=template&tab=section').'" class="mfn-btn mfn-btn-fw mfn-btn-blue"><span class="btn-wrapper">Create a Global Section</span></a>'; 
echo '</div>';