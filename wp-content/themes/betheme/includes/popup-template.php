<?php

$popup_show = true;

$popup_position = !empty( get_post_meta( $args['id'], 'popup_position', true) ) ? get_post_meta($args['id'], 'popup_position', true) : 'center';
$popup_offset = !empty( get_post_meta($args['id'], 'popup_offset', true) ) ? get_post_meta($args['id'], 'popup_offset', true) : false;
$popup_width = !empty( get_post_meta( $args['id'], 'popup_width', true) ) ? get_post_meta($args['id'], 'popup_width', true) : 'width-default';
$popup_display = !empty( get_post_meta($args['id'], 'popup_display', true) ) ? get_post_meta($args['id'], 'popup_display', true) : 'on-start';
$popup_display_rule = !empty( get_post_meta($args['id'], 'popup_display_visibility', true) ) ? get_post_meta($args['id'], 'popup_display_visibility', true) : false;
$popup_referer = !empty( get_post_meta($args['id'], 'popup_display_referer', true) ) ? get_post_meta($args['id'], 'popup_display_referer', true) : false;
$popup_hide = !empty( get_post_meta($args['id'], 'popup_hide', true) ) ? get_post_meta($args['id'], 'popup_hide', true) : false;
$popup_close_button = !empty( get_post_meta($args['id'], 'popup_close_button_display', true) ) ? get_post_meta($args['id'], 'popup_close_button_display', true) : false;


$popup_classes = array();
$popup_data = array();

$popup_classes[] = 'mfn-popup-tmpl-'.$popup_position;
$popup_classes[] = 'mfn-popup-tmpl-'.$popup_width;
$popup_classes[] = 'mfn-popup-tmpl-display-'.$popup_display;

if( !empty($popup_hide) ) {
	$popup_classes[] = 'mfn-popup-tmpl-hide-'.$popup_hide;
	$popup_data[] = !empty( get_post_meta($args['id'], 'popup_hide_delay', true) ) ? 'data-hidedelay="'.((float)get_post_meta($args['id'], 'popup_hide_delay', true)*1000).'"' : 'data-hidedelay="10000"';
}

if( !empty($popup_close_button) ) {
	$popup_classes[] = 'mfn-popup-tmpl-close-button-show-'.$popup_hide;
	$popup_data[] = !empty( get_post_meta($args['id'], 'popup_close_button_display_delay', true) ) ? 'data-closebuttondelay="'.((float)get_post_meta($args['id'], 'popup_close_button_display_delay', true)*1000).'"' : 'data-closebuttondelay="10000"';
}

// display events
if( $popup_display == 'start-delay' ) {
	$popup_data[] = !empty( get_post_meta($args['id'], 'popup_display_delay', true) ) ? 'data-display="'.((float)get_post_meta($args['id'], 'popup_display_delay', true) * 1000).'"' : 'data-display="5000"';
}else if( $popup_display == 'on-scroll' ) {
	$popup_data[] = !empty( get_post_meta($args['id'], 'popup_display_scroll', true) ) ? 'data-display="'.get_post_meta($args['id'], 'popup_display_scroll', true).'"' : 'data-display="100"';
}else if( $popup_display == 'scroll-to-element' ) {
	$popup_data[] = !empty( get_post_meta($args['id'], 'popup_display_scroll_element', true) ) ? 'data-display="'.get_post_meta($args['id'], 'popup_display_scroll_element', true).'"' : 'data-display="undefined"';
}

if( !empty($popup_display_rule) ) {
	$popup_classes[] = 'mfn-popup-tmpl-display-'.$popup_display_rule;
	if( $popup_display_rule == 'cookie-based' ) {
		$popup_data[] = !empty( get_post_meta($args['id'], 'popup_display_visibility_cookie_days', true) ) ? 'data-cookie="'.get_post_meta($args['id'], 'popup_display_visibility_cookie_days', true).'"' : 'data-cookie="3"';
	}
}

if( !empty($popup_referer) && (!$_SERVER['HTTP_REFERER'] || strpos($_SERVER['HTTP_REFERER'], $popup_referer) === false ) ) $popup_show = false; // hide popup if referer is empty or is different

if( empty($_GET['visual']) && in_array($popup_display_rule, array('one', 'cookie-based')) ) {
	$cookie_name = 'mfn_popup_'.$args['id'];
	if( isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] ) $popup_show = false; // hide if cookie is set
}

if( $popup_show ) {

	echo '<div data-id="'.$args['id'].'" id="mfn-popup-template-'.$args['id'].'" '.(!empty($_GET['visual']) ? 'data-id="'.$args['id'].'"' : '').' class="mfn-popup-tmpl '.implode(' ', $popup_classes).'" '.implode(' ', $popup_data).'>';

		echo '<div class="mfn-popup-tmpl-content">';
			echo '<a href="#" class="exit-mfn-popup">&#10005;</a>';
			$mfn_footer_builder = new Mfn_Builder_Front( $args['id'] );
			$mfn_footer_builder->show( false, $args['visual'] );
		echo '</div>';

	echo '</div>';

	echo '<style class="mfn-popup-tmpl-local-styles">';

	if( $popup_width == 'custom-width' ) {
		echo '#mfn-popup-template-'.$args['id'].'.mfn-popup-tmpl.mfn-popup-tmpl-custom-width .mfn-popup-tmpl-content{width: '. (!empty(get_post_meta($args['id'], 'popup_width_custom', true)) ? get_post_meta($args['id'], 'popup_width_custom', true).'px' : '640px'  ) .';}';
	}

	if( $popup_position !== 'center' && !empty($popup_offset) ) {
		echo 'body #mfn-popup-template-'.$args['id'].' { --mfn-popup-tmpl-offset: '.$popup_offset.'px; }';
	}

	echo '</style>';

}