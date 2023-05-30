<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if( wp_get_referer() && strpos( wp_get_referer(), 'login' ) === false && strpos( wp_get_referer(), 'action=mfn-live-builder' ) === false ){
    $referrer = wp_get_referer();
}else{
    $referrer = admin_url( 'edit.php?post_type=page' );
}

$custom_replaced_logo = apply_filters('betheme_logo', '') ? 'style="background-image:url('. apply_filters('betheme_logo_nohtml', ''). ')"' : '';
$version = apply_filters('betheme_disable_theme_version', MFN_THEME_VERSION);

echo '<div class="sidebar-menu">
  <div class="sidebar-menu-inner">';

	  if( ! WHITE_LABEL ){
			echo '<div class="mfnb-logo" '.$custom_replaced_logo.'>Be Builder - Powered by Muffin Group <span class="mfnb-ver">'.($version ? 'V'.MFN_THEME_VERSION : "").'</span></div>';
		} else {
			echo '<div class="mfnb-logo" style="background-image:unset"></div>';
		}

    echo '<nav id="main-menu">
      <ul>
	      <li class="menu-items"><a data-tooltip="Elements" data-position="right" href="#">Elements</a></li>';

	      if( $this->template_type && $this->template_type == 'header' ){
	          echo '<li class="menu-sections"><a data-tooltip="Pre-built headers" data-position="right" href="#">Pre-built sections</a></li>';
	      }elseif( $this->template_type && $this->template_type == 'footer' ){
	          echo '<li class="menu-sections"><a data-tooltip="Pre-built footers" data-position="right" href="#">Pre-built sections</a></li>';
	      }else{
	          echo '<li class="menu-sections"><a data-tooltip="Pre-built sections" data-position="right" href="#">Pre-built sections</a></li>';
	      }

	      echo '<li class="menu-export"><a data-tooltip="Export / Import'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'" data-position="right" href="#">Export / Import</a></li>
	      <li class="menu-page"><a data-tooltip="Single page import'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'" data-position="right" href="#">Single page import</a></li>
      </ul>
    </nav>

    <nav id="settings-menu">
      <ul>

	      <li class="menu-navigator"><a href="#" data-tooltip="Navigator" data-position="right" class="btn-navigator-switcher"><span class="mfn-icon mfn-icon-navigator"></span></a></li>
	      <li class="menu-revisions"><a data-tooltip="History'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'" data-position="right" href="#">History'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'</a></li>';

	      if( $this->template_type && $this->template_type == 'header' ){
	          echo '<li class="menu-options"><a data-position="right" id="page-options-tab" class="mfn-view-options-tab" href="#" data-tooltip="Header options">Options</a></li>';
	      }elseif( $this->template_type && $this->template_type == 'footer' ){
	          echo '<li class="menu-options"><a data-position="right" id="page-options-tab" class="mfn-view-options-tab" href="#" data-tooltip="Footer options">Options</a></li>';
	      }elseif( $this->template_type && $this->template_type == 'megamenu' ) {
	          echo '<li class="menu-options"><a data-position="right" id="page-options-tab" class="mfn-view-options-tab" href="#" data-tooltip="Mega menu options">Options</a></li>';
	      }elseif( $this->template_type && $this->template_type == 'popup' ) {
	          echo '<li class="menu-options"><a data-position="right" id="page-options-tab" class="mfn-view-options-tab" href="#" data-tooltip="Popup options">Options</a></li>';
	      }else{
	          echo '<li class="menu-options"><a data-position="right" id="page-options-tab" class="mfn-view-options-tab" href="#" data-tooltip="Page options'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'">Options</a></li>';
	      }

	      echo '<li class="menu-themeoptions"><a data-tooltip="Theme options'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'" data-position="right" href="#">Theme options</a></li>';

	      echo '<li class="menu-settings"><a data-tooltip="Settings'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'" class="mfn-settings-tab" data-position="right" href="#">Settings</a></li>';

	      echo '<li class="menu-wordpress"><a data-position="right" href="'. ( is_admin() ? $referrer : '#' ) .'" data-tooltip="Back to WordPress'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'">Back to WordPress</a></li>

      </ul>
    </nav>

  </div>
</div>';
