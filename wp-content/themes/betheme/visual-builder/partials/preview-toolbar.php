<?php 


echo '<div class="mfn-preview-toolbar mfn-header mfn-header-green header-large">';

    echo '<div class="options-group group-title">';
    echo '<div class="header-label">Responsive mode</div>';
    echo '</div>';

    echo '<div class="options-group group-options">';
    echo '<a class="mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-opt btn-active" data-preview="desktop" title="Desktop" href="#" data-tooltip="Desktop" href="#" data-position="bottom"><span class="mfn-icon mfn-icon-desktop-light"></span></a>';
    echo '<a class="mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-opt" data-preview="tablet" title="Tablet" href="#" data-tooltip="Tablet" href="#" data-position="bottom"><span class="mfn-icon mfn-icon-tablet-light"></span></a>';
    echo '<a class="mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-opt" data-preview="mobile" title="Mobile" href="#" data-tooltip="Mobile" href="#" data-position="bottom"><span class="mfn-icon mfn-icon-mobile-light"></span></a>';

    echo '</div>';

    if( $this->template_type && $this->template_type == 'header' ){
        echo '<div class="options-group group-options mfn-header-type-preview">';

        echo '<a class="mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-opt-header btn-active" data-preview="header-default" title="Default" href="#" data-tooltip="Default" href="#" data-position="bottom">Default</a>';
        echo '<a class="disabled mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-opt-header" data-preview="header-sticky" title="Sticky" href="#" data-tooltip="Enable it in Header Options" href="#" data-position="bottom">Sticky</a>';
        echo '<a class="disabled mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-opt-header" data-preview="header-mobile" title="Mobile" href="#" data-tooltip="Enable it in Header Options" href="#" data-position="bottom">Mobile</a>';

        echo '</div>';
    }

    echo '<div class="options-group group-close">';
    echo '<a class="mfn-option-btn mfn-option-blank-dark btn-large mfn-preview-mode-close" title="Close" href="#"><span class="mfn-icon mfn-icon-close-light"></span></a>';
    echo '</div>';

echo '</div>';

?>