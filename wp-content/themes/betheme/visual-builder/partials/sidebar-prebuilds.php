<?php  
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

echo '<div class="panel panel-prebuilt-sections" style="display: none;"><ul class="prebuilt-sections-list">';

$prebuilts = Mfn_Pre_Built_Sections::get_sections();
foreach( $prebuilts as $p_section_key => $p_section ){
        
        if( $this->template_type && $this->template_type == 'header' && $p_section['category'] != 'header' ) continue;
        if( $this->template_type && $this->template_type == 'footer' && $p_section['category'] != 'footer' ) continue;
        if( !$this->template_type && in_array($p_section['category'], array('header', 'footer')) ) continue;

        echo '<li style="display: block;" class="category-all category-'. esc_attr( $p_section['category'] ).'" data-id="'. esc_attr( $p_section_key ).'">
            <div class="photo">
                 <img src="'. get_theme_file_uri( '/functions/builder/pre-built/images/'. $p_section_key .'.png' ) .'" alt="" />
            </div>
            <div class="desc">
                <h6>'. esc_html( $p_section['title'] ).'</h6>
                <a class="mfn-option-btn mfn-option-text btn-icon-left mfn-option-green mfn-btn-insert mfn-insert-prebuilt" title="Insert" data-tooltip="Insert to your project" href="#">
                    <span class="mfn-icon mfn-icon-add"></span><span class="text">Insert</span>
                </a>
            </div>
        </li>';
        }

    echo '</ul>';                     
echo '</div>';