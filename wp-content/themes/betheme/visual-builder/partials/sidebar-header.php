<?php  
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}
 
echo '<div class="sidebar-panel-header">

    <div class="header header-global-sections" id="header-global-sections" style="display: none;">
    <div class="title-group">
    <span class="sidebar-panel-icon mfn-icon-predefined-sections"></span>
    <div class="sidebar-panel-desc">
        <h5 class="sidebar-panel-title">Global sections</h5>
    </div>
    </div>
    </div>

	<div class="header header-edit-item" id="header-edit-item" style="display: none;">
        <div class="title-group">
            <span class="sidebar-panel-icon mfn-icon-column"></span>
            <div class="sidebar-panel-desc">
                <h5 class="sidebar-panel-title">Column</h5>
            </div>
        </div>

        <div class="options-group">

            <div class="mfn-option-dropdown mfn-presets-list">
                <a title="Presets" href="#" class="mfn-option-btn btn-large btn-icon-right mfn-option-blank"><span class="mfn-icon mfn-icon-preset"></span><span style="width: 9px;" class="mfn-icon mfn-icon-unfold"></span></a>
                <ul class="dropdown-wrapper"></ul>
            </div>

            <a class="mfn-option-btn mfn-option-blank btn-large back-to-widgets" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>       
        </div>
    </div>

    <div class="header header-settings" id="header-settings" style="display: none;">
        <div class="title-group">
            <span class="sidebar-panel-icon mfn-icon-settings"></span>
            <div class="sidebar-panel-desc">
                <h5 class="sidebar-panel-title">Settings</h5>
            </div>
        </div>
        <div class="options-group">
            <a class="mfn-option-btn mfn-option-blank btn-large back-to-widgets" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
        </div>
    </div>
    <div class="header header-view-options" id="header-view-options" style="display: none;">
        <div class="title-group">
            <span class="sidebar-panel-icon mfn-icon-options"></span>
            <div class="sidebar-panel-desc">
                <h5 class="sidebar-panel-title">';

                if( $this->template_type && $this->template_type == 'header' ){
                	echo 'Header options';
                }else if( $this->template_type && $this->template_type == 'footer' ){
                    echo 'Footer options';
                }else if( $this->template_type && $this->template_type == 'megamenu' ){
                	echo 'Mega menu options';
                }else if( $this->template_type && $this->template_type == 'popup' ){
                    echo 'Popup options';
                }else{
                	echo 'Page options';
                }

                echo '</h5>
            </div>
        </div>
        <div class="options-group">
            <a class="mfn-option-btn mfn-option-blank btn-large back-to-widgets" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
        </div>
    </div>

    <div class="header header-items" id="header-items">
        <div class="title-group">
        <span class="sidebar-panel-icon mfn-icon-add-big"></span>
        <div class="sidebar-panel-desc">
            <h5 class="sidebar-panel-title">Add Element</h5>
        </div>
        </div>';

        if( !$this->template_type || ($this->template_type && $this->template_type != 'header' ) ){
        echo '<div class="options-group">
            <div class="mfn-option-dropdown">
                <a title="More" href="#" class="mfn-option-btn btn-large mfn-option-text btn-icon-right mfn-option-blank"><span class="text filter-items-current">All</span><span class="mfn-icon mfn-icon-arrow-down"></span></a>
                <div class="dropdown-wrapper">
                    <h6>Filter by:</h6>                    
                <a class="mfn-dropdown-item mfn-filter-items active" data-filter="all" href="#"> All</a>
                <div class="mfn-dropdown-divider"></div>';

                if( get_post_type($this->post_id) == 'template' && get_post_meta($this->post_id, 'mfn_template_type', true) == 'single-product' ){
                	echo '<a class="mfn-dropdown-item mfn-filter-items" data-filter="category-single-product" href="#"> Product</a>';
                }elseif( get_post_type($this->post_id) == 'template' && get_post_meta($this->post_id, 'mfn_template_type', true) == 'shop-archive' ){
                	echo '<a class="mfn-dropdown-item mfn-filter-items" data-filter="category-shop-archive" href="#"> Shop</a>';
                }

                echo '<a class="mfn-dropdown-item mfn-filter-items" data-filter="category-typography" href="#"> Typography</a>
                <a class="mfn-dropdown-item mfn-filter-items" data-filter="category-boxes" href="#"> Boxes</a>
                <a class="mfn-dropdown-item mfn-filter-items" data-filter="category-blocks" href="#"> Blocks</a>
                <a class="mfn-dropdown-item mfn-filter-items" data-filter="category-elements" href="#"> Elements</a>';
                if( !$this->template_type || ($this->template_type && $this->template_type != 'popup' ) ) echo '<a class="mfn-dropdown-item mfn-filter-items" data-filter="category-loops" href="#"> Loops</a>';
                echo '<a class="mfn-dropdown-item mfn-filter-items" data-filter="category-other" href="#"> Other</a>
                </div>
            </div>
        </div>';
        }
    echo '</div>';


    echo '<div class="header header-prebuilt-sections" id="header-prebuilt-sections" style="display: none;">
        <div class="title-group">
        <span class="sidebar-panel-icon mfn-icon-predefined-sections"></span>
        <div class="sidebar-panel-desc">
            <h5 class="sidebar-panel-title">';
            if( $this->template_type && $this->template_type == 'header' ){
            	echo 'Headers library';
            }elseif( $this->template_type && $this->template_type == 'popup' ){
                echo 'Popups library';
            }elseif( $this->template_type && $this->template_type == 'footer' ){
                echo 'Footers library';
            }else{
            	echo 'Sections library';
            }
        echo '</h5>
        </div>
        </div>';

        if( !$this->template_type || $this->template_type != 'header' ){
   echo '<div class="options-group">
            <div class="mfn-option-dropdown">
                <a title="More" href="#" class="mfn-option-btn btn-large mfn-option-text btn-icon-right mfn-option-blank"><span class="text pre-built-current">All</span><span class="mfn-icon mfn-icon-arrow-down"></span></a>
                <div class="dropdown-wrapper">
                    <h6>Filter by:</h6>';

                    $categories = Mfn_Pre_Built_Sections::get_categories();

                    foreach( $categories as $category_key => $category ){
                    	echo '<a class="mfn-dropdown-item pre-built-opt" data-filter="category-'. esc_attr( $category_key ) .'" href="#"> '. esc_html( $category ) .'</a>';
                    	if( $category_key == 'all'){
                    		echo '<div class="mfn-dropdown-divider"></div>';
                    	}
					}
                
                echo '</div>
            </div>
        </div>';
    }
    
    echo '</div><div class="header header-revisions" id="header-revisions" style="display: none;">
        <div class="title-group">
            <span class="sidebar-panel-icon mfn-icon-revisions"></span>
            <div class="sidebar-panel-desc">
                <h5 class="sidebar-panel-title">History</h5>
            </div>
        </div>
        <div class="options-group">
            <div class="mfn-option-dropdown">
                <a title="More" href="#" class="mfn-option-btn btn-large mfn-option-text btn-icon-right mfn-option-blank"><span class="text revisions-current">'. ( empty(mfn_opts_get('builder-autosave')) ? 'Autosave' : 'Update' ) .'</span><span class="mfn-icon mfn-icon-arrow-down"></span></a>
                <div class="dropdown-wrapper">';
                    if( empty(mfn_opts_get('builder-autosave')) ) echo '<a class="mfn-dropdown-item mfn-revisions-opt active" data-filter="panel-revisions" href="#"> Autosave</a>';
                    echo '<a class="mfn-dropdown-item mfn-revisions-opt" data-filter="panel-revisions-update" href="#"> Update</a>
                    <a class="mfn-dropdown-item mfn-revisions-opt" data-filter="panel-revisions-revision" href="#"> Revision</a>
                    <a class="mfn-dropdown-item mfn-revisions-opt" data-filter="panel-revisions-backup" href="#"> Backup</a>
                </div>
            </div>
        </div>
    </div>

    <div class="header header-themeoptions" id="header-themeoptions" style="display: none;">
        <div class="title-group">
            <span class="sidebar-panel-icon mfn-icon-themeoptions"></span>
            <div class="sidebar-panel-desc">
                <h5 class="sidebar-panel-title">Theme options</h5>
            </div>
        </div>
        <div class="options-group header-to-back" style="display: none;">
        <a title="More" href="#" class="mfn-option-btn btn-medium mfn-option-text btn-icon-left mfn-option-blank"><span class="mfn-icon mfn-icon-arrow-left"></span><span class="text">Back to list</span></a>
        </div>
    </div>

    <div class="header header-export-import" id="header-export-import" style="display: none;">
        <div class="title-group">
        <span class="sidebar-panel-icon mfn-icon-export-import"></span>
        <div class="sidebar-panel-desc">
            <h5 class="sidebar-panel-title">Export / Import</h5>
        </div>
        </div>
        <div class="options-group">
            <div class="mfn-option-dropdown">
                <a title="More" href="#" class="mfn-option-btn btn-large mfn-option-text btn-icon-right mfn-option-blank"><span class="text export-import-current">Export</span><span class="mfn-icon mfn-icon-arrow-down"></span></a>
                <div class="dropdown-wrapper">
                    <a class="mfn-dropdown-item mfn-export-import-opt active" data-filter="panel-export-import" href="#"> Export</a>
                    <a class="mfn-dropdown-item mfn-export-import-opt" data-filter="panel-export-import-import" href="#"> Import</a>
                    <a class="mfn-dropdown-item mfn-export-import-opt" data-filter="panel-export-import-templates" href="#"> Templates</a>
                    <a class="mfn-dropdown-item mfn-export-import-opt" data-filter="panel-export-import-single-page" href="#"> Single page</a>
                    <a class="mfn-dropdown-item mfn-export-import-opt" data-filter="panel-export-import-presets" href="#"> Presets</a>';
                    if( !$this->template_type ){ echo '<a class="mfn-dropdown-item mfn-export-import-opt" data-filter="panel-export-import-seo" href="#"> Builder &rarr; SEO</a>'; }
                echo '</div>
            </div>
        </div>
    </div>

</div>';

?>