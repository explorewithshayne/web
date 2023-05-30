<?php
class Mfn_Options_field
{

	protected $field = [];
	protected $value = false;
	protected $prefix = false;

	/**
	 * Constructor
	 */

	public function __construct( $field = false, $value = false, $prefix = false )
	{
		$this->field = $field;
		$this->value = $value;
		$this->prefix = $prefix;
	}

  /**
   * Get input name
   * Builder uses field types: select, text, textarea, upload, tabs, icon
   */

  public function get_name( $meta = false, $key = false  ){

  	$name = '';

		if( isset( $this->field['id'] ) ){
			$name = $this->field['id'];
		}

		// theme options 'betheme[name]'

		if( ! $meta ){
			 $name = $this->prefix .'['. $name .']';
		}

		// field that returns array, i.e. "dimensions"

		if( $key ){
			$name = $name .'['. $key .']';
		}

		// prepare 'name="name"'

		$name = 'name="'. esc_attr( $name ) .'"';

		// builder empty field 'data-name="name"'

		if( 'empty' === $meta ) {
			$name = 'data-'. $name;
		}

    return $name;

  }

  /**
   * Get field bottom description
   */

  public function get_description(){

		if ( ! empty( $this->field['desc'] ) ) {
			echo '<div class="desc-group">';
				echo '<span class="description">'. $this->field['desc'] .'</span>';
			echo '</div>';
		}

  	}

  	public static function dynamic_data_options($filter = false){
  		$html = '<a class="mfn-option-btn mfn-button-dynamic-data" title="Dynamic data" href="#"><span class="mfn-icon mfn-icon-dynamic-data"></span></a>';
		return $html;
	}

	/**
	 * Responsive switchers
	 */

 	public static function get_responsive_swither( $active ){

		/*if( empty( $this->field['responsive'] ) ){
			return false;
		}
		// in visual: Uncaught Error: Using $this when not in object context in
 		$active = $this->field['responsive'];*/

 		/*if( !$active ){
			return false;
		}*/

 		$devices = [
 			'desktop' => __('Desktop','mfn-opts'),
 			'tablet' => __('Tablet','mfn-opts'),
 			'mobile' => __('Mobile','mfn-opts'),
 		];

 		echo '<ul class="responsive-switcher">';

 			foreach ( $devices as $key => $device ){

 				$class = ( $active == $key ) ? 'active' : '';

 				echo '<li class="'. esc_attr( $class ) .'" data-device="'. esc_attr( $key ) .'" data-tooltip="'. esc_html( $device ) .'">';
 					echo '<span data-device="'. esc_attr( $key ) .'" class="mfn-icon mfn-icon-'. esc_attr( $key ) .'"></span>';
 				echo '</li>';

 			}

 		echo '</ul>';

 	}

 	/**
	 * Icon Info
	 */

 	public static function get_icon_info($info){
 		echo '<a class="mfn-option-btn mfn-option-blank mfn-fr-info-icon" target="_blank" data-tooltip="Click for more info" href="'.$info.'"><span class="mfn-icon mfn-icon-information"></span></a>';
 	}

 	public static function get_icon_desc(){
 		echo '<a class="mfn-option-btn mfn-option-blank mfn-fr-help-icon" target="_blank" data-tooltip="Toggle description" href="#"><span class="mfn-icon mfn-icon-desc"></span></a>';
 	}

  /**
   * Render
   */

  public function render(){

		// Silence is goodness

  }

}
