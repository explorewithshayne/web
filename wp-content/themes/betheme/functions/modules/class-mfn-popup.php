<?php
defined( 'ABSPATH' ) || exit;

/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

class MfnPopup {

	public $id = false;
	public $classes = array();
	public $datatags = array();
	public $popup_show = true;
	public $popup_width = false;
	public $popup_position = false;
	public $popup_offset = false;
	public $popup_close_button_align = false;

	public function __construct( $id ){

		$this->id = $id;

		$this->popup_position = !empty( get_post_meta( $this->id, 'popup_position', true) ) ? get_post_meta($this->id, 'popup_position', true) : 'center';
		$this->popup_offset = !empty( get_post_meta($this->id, 'popup_offset', true) ) ? get_post_meta($this->id, 'popup_offset', true) : false;
		$this->popup_width = !empty( get_post_meta( $this->id, 'popup_width', true) ) ? get_post_meta($this->id, 'popup_width', true) : 'width-default';
		$popup_display = !empty( get_post_meta($this->id, 'popup_display', true) ) ? get_post_meta($this->id, 'popup_display', true) : 'on-start';
		$popup_display_rule = !empty( get_post_meta($this->id, 'popup_display_visibility', true) ) ? get_post_meta($this->id, 'popup_display_visibility', true) : false;
		$popup_referer = !empty( get_post_meta($this->id, 'popup_display_referer', true) ) ? get_post_meta($this->id, 'popup_display_referer', true) : false;
		$popup_hide = !empty( get_post_meta($this->id, 'popup_hide', true) ) ? get_post_meta($this->id, 'popup_hide', true) : false;
		$popup_close_button = !empty( get_post_meta($this->id, 'popup_close_button_display', true) ) ? get_post_meta($this->id, 'popup_close_button_display', true) : 'on-start';

		$popup_close_button_align = !empty( get_post_meta($this->id, 'popup_close_button_align', true) ) ? get_post_meta($this->id, 'popup_close_button_align', true) : 'right';
		$popup_close_overlay_click = !empty( get_post_meta($this->id, 'popup_close_on_overlay_click', true) ) ? get_post_meta($this->id, 'popup_close_on_overlay_click', true) : false;

		$this->classes[] = 'mfn-popup-tmpl-'.$this->popup_position;
		$this->classes[] = 'mfn-popup-tmpl-'.$this->popup_width;
		$this->classes[] = 'mfn-popup-tmpl-display-'.$popup_display;

		empty( get_post_meta($this->id, 'popup_close_button_active', true) ) ? $this->classes[] =  'mfn-popup-tmpl-close-button-hidden' : false;
		!empty( get_post_meta($this->id, 'popup_entrance_animation', true) ) ? $this->classes[] =  'mfn-popup-animate-'.get_post_meta($this->id, 'popup_entrance_animation', true) : false;

		$this->datatags[] = !empty(get_post_meta($this->id, 'popup_overlay_blur', true)) ? 'data-blur="'.get_post_meta($this->id, 'popup_overlay_blur', true).'"' : '';

		if( $popup_close_overlay_click ) $this->classes[] = 'mfn-popup-close-on-'.$popup_close_overlay_click;

		$this->classes[] = 'mfn-popup-close-button-'.$popup_close_button_align;

		if( !empty($popup_hide) ) {
			$this->classes[] = 'mfn-popup-tmpl-hide-'.$popup_hide;
			$this->datatags[] = !empty( get_post_meta($this->id, 'popup_hide_delay', true) ) ? 'data-hidedelay="'.((float)get_post_meta($this->id, 'popup_hide_delay', true)*1000).'"' : 'data-hidedelay="10000"';
		}

		if( !empty($popup_close_button) ) {
			$this->classes[] = 'mfn-popup-tmpl-close-button-show-'.$popup_close_button;
			$this->datatags[] = !empty( get_post_meta($this->id, 'popup_close_button_display_delay', true) ) ? 'data-closebuttondelay="'.((float)get_post_meta($this->id, 'popup_close_button_display_delay', true)*1000).'"' : 'data-closebuttondelay="3000"';
		}

		// display events
		if( $popup_display == 'start-delay' ) {
			$this->datatags[] = !empty( get_post_meta($this->id, 'popup_display_delay', true) ) ? 'data-display="'.((float)get_post_meta($this->id, 'popup_display_delay', true) * 1000).'"' : 'data-display="5000"';
		}else if( $popup_display == 'on-scroll' ) {
			$this->datatags[] = !empty( get_post_meta($this->id, 'popup_display_scroll', true) ) ? 'data-display="'.get_post_meta($this->id, 'popup_display_scroll', true).'"' : 'data-display="100"';
		}else if( $popup_display == 'scroll-to-element' ) {
			$this->datatags[] = !empty( get_post_meta($this->id, 'popup_display_scroll_element', true) ) ? 'data-display="'.get_post_meta($this->id, 'popup_display_scroll_element', true).'"' : 'data-display="undefined"';
		}

		if( !empty($popup_display_rule) ) {
			$this->classes[] = 'mfn-popup-tmpl-display-'.$popup_display_rule;
			if( $popup_display_rule == 'cookie-based' ) {
				$this->datatags[] = !empty( get_post_meta($this->id, 'popup_display_visibility_cookie_days', true) ) ? 'data-cookie="'.get_post_meta($this->id, 'popup_display_visibility_cookie_days', true).'"' : 'data-cookie="3"';
			}
		}

		if( !empty($popup_referer) && (!$_SERVER['HTTP_REFERER'] || strpos($_SERVER['HTTP_REFERER'], $popup_referer) === false ) ) $this->popup_show = false; // hide popup if referer is empty or is different

		if( empty($_GET['visual']) && in_array($popup_display_rule, array('one', 'cookie-based')) ) {
			$cookie_name = 'mfn_popup_'.$this->id;
			if( isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] ) $this->popup_show = false; // hide if cookie is set
		}

	}

	public function classes() {
		return $this->classes;
	}
	

	public function render(){

		if( !$this->popup_show ) return;

		echo '<div data-id="'.$this->id.'" id="mfn-popup-template-'.$this->id.'" '.(!empty($_GET['visual']) ? 'data-id="'.$this->id.'"' : '').' class="mfn-popup-tmpl '.implode(' ', $this->classes).'" '.implode(' ', $this->datatags).'>';

			echo '<div class="mfn-popup-tmpl-content">';
				echo '<a href="#" class="exit-mfn-popup exit-mfn-popup-abs">&#10005;</a>';
				echo '<div class="mfn-popup-tmpl-content-wrapper">';
				$mfn_footer_builder = new Mfn_Builder_Front( $this->id );
				$mfn_footer_builder->show( false );
				echo '</div>';
			echo '</div>';

		echo '</div>';

		$this->css();

	}

	public function css(){

		if( !$this->popup_show ) return;

		$tablet_styles = array();
		$mobile_styles = array();

		$get_styles = get_post_meta($this->id, 'mfn-page-options-style', true);

		if( $get_styles ){

			$styles = $get_styles;

			echo '<style class="mfn-popup-tmpl-local-styles">';

			foreach($styles as $s=>$style) {
				echo str_replace('|', ':', $s).'{';
					foreach ($style as $st => $value) {
						if( strpos($st, '_tablet') === false && strpos($st, '_mobile') === false ) {
							echo $st.':'.$value.';';
						}else{
							if( strpos($st, '_tablet') !== false ) {
								$tablet_styles[$s][str_replace('_tablet', '', $st)] = $value;
							}else if( strpos($st, '_mobile') !== false ) {
								$mobile_styles[$s][str_replace('_mobile', '', $st)] = $value;
							}
						}
					}
				echo '}';
			}

			if( count($tablet_styles) > 0 ){
				echo '@media(max-width: 959px) {';
				foreach($tablet_styles as $s=>$style) {
					echo $s.'{';
						foreach($style as $st=>$value){
							echo $st.':'.$value.';';
						}
					echo '}';
				}
				echo '}';
			}

			if( count($mobile_styles) > 0 ){
				echo '@media(max-width: 767px) {';
				foreach($mobile_styles as $s=>$style) {
					echo $s.'{';
						foreach($style as $st=>$value){
							echo $st.':'.$value.';';
						}
					echo '}';
				}
				echo '}';
			}

			echo '</style>';

			/*echo '<pre>';
			print_r($tablet_styles);
			echo '</pre>';*/

		}
	}

}