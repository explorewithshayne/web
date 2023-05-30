<?php
defined( 'ABSPATH' ) || exit;

/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

class MfnMegaMenu {

	public $id = false;
	public $classes = array();
	public $inlinecss = false;

	public function __construct( $id ){
		$this->id = $id;

		$mm_width = get_post_meta($this->id, 'megamenu_width', true);
		$mm_pos = get_post_meta($this->id, 'megamenu_custom_position', true);

		$this->classes[] = !empty($mm_width) ? 'mfn-megamenu-'.$mm_width : 'mfn-megamenu-full-width'; // custom, full or grid

		if( !empty($mm_width) && $mm_width == 'custom-width' && get_post_meta($this->id, 'megamenu_custom_width', true) ){
			$this->inlinecss = 'style="width: '.get_post_meta($this->id, 'megamenu_custom_width', true).'"';

			if( $mm_pos ){ 
				$this->classes[] = 'mfn-megamenu-pos-'.$mm_pos;
			}else{
				$this->classes[] = 'mfn-megamenu-pos-left';
			}

		}

	}

	public function classes() {
		return $this->classes;
	}


	public function render(){

		echo '<div id="mfn-megamenu-'.$this->id.'" class="mfn-menu-item-megamenu '.implode(' ', $this->classes).'" '.$this->inlinecss.'>';

		$mfn_mm_builder = new Mfn_Builder_Front( $this->id );
		$mfn_mm_builder->show();

		echo '</div>';

		$this->css();

	}

	public function css(){

		$get_styles = get_post_meta($this->id, 'mfn-page-options-style', true);

		if( $get_styles ){

			$styles = $get_styles;

			echo '<style class="mfn-megamenu-tmpl-local-styles">';

			foreach($styles as $s=>$style) {
				echo $s.'{';
					foreach ($style as $st => $value) {
						echo $st.':'.$value.';';
					}
				echo '}';
			}

			echo '</style>';

		}
	}

}