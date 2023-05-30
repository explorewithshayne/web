<?php
class MFN_Options_dimensions extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		$class = '';
		$pseudo = false;
		$value = '';
		$explode_val = false;
		$readonly = false;
		$input_class = false;

 		// inputs

    if( isset($this->field['version']) ){

    	$inputs = [
	      'top' => '',
	      'right' => '',
	      'bottom' => '',
	      'left' => ''
	    ];

	    if( strpos($this->field['id'], 'border-radius') !== false ){
	    	$inputs = [
		      'top' => '&#8598;',
		      'right' => '&#8599;',
		      'bottom' => '&#8600;',
		      'left' => '&#8601;'
		    ];
	    }

    } else {
    	$inputs = [
	      'top', 'right', 'bottom', 'left'
	    ];

	    if( strpos($this->field['id'], 'border-radius') !== false ){
	    	$inputs = [
		      '&#8598;',
		      '&#8599;',
		      '&#8600;',
		      '&#8601;'
		    ];
	    }

    }

    

    if ( $this->value ) {
		$value = $this->value;
		if( is_array($value) ){
			$explode_val = $value; // tu wrócić
		}else{
			$explode_val = explode(' ', $value);
		}
	} elseif( ! empty( $this->field['std'] ) ) {
		$value = $this->field['std'];
	} else {
		$value = '';
	}

	if($explode_val && (count($explode_val) == 4) && (count(array_unique($explode_val)) == 1) ){
		$class .= ' isLinked';
	}

	if(isset($this->field['version'])){
		$class .= ' '. $this->field['version'];
	} else {
		$class .= ' pseudo';
	}

	// output -----



	if( $js ){

		if(isset($this->field['version'])){
			echo '<div class="form-group multiple-inputs has-addons has-addons-append '. esc_attr( $class ) .' \' + ('.$js.' && '.$js.'.top && '.$js.'.right && '.$js.'.bottom && '.$js.'.left && '.$js.'.top == '.$js.'.right && '.$js.'.top == '.$js.'.left && '.$js.'.top == '.$js.'.bottom ? "isLinked" : "" ) + \'">';
		}else{
			echo '<div class="form-group multiple-inputs has-addons has-addons-append '. esc_attr( $class ) .' \' + ( '.$js.' && '.$js.'.length && '.$js.'.split(" ").every( (val) => val === '.$js.'.split(" ")[0] ) ? \'isLinked\' : \'\' ) + \'">';
		}

		echo '<div class="form-control">';

			if( !isset($this->field['version']) ) {
				echo '<input class="pseudo-field mfn-form-control mfn-field-value" type="hidden" '. $this->get_name( $meta ) .' value="\'+('.$js.' ? '.$js.' : "")+\'" autocomplete="off"/>';
			}

			foreach( $inputs as $i=>$input ){

				$sub_value = '';

				isset($explode_val[$i]) ? $sub_value = $explode_val[$i] : $sub_value = '';

				$input_class = 'field-'.esc_attr( $i );

				if(isset($this->field['version'])){
					$input_class .= ' mfn-field-value';
				}

				$in_class = false;

				if( 'top' != $i && '&#8598;' != $i && '0' != $i ){

					$in_class = 'disableable';

				}

				$dataKey = isset($this->field['version']) && !empty($inputs[$i]) ? $inputs[$i] : esc_attr( $i );

				if( !isset($this->field['version']) ){
					$dataKey = $inputs[$i];
				}

				echo '<div class="field '. esc_attr( $in_class ) .'" data-key="'. ( $dataKey ) .'">';
					echo '<input type="text" class="mfn-form-control mfn-form-input numeral  '. esc_attr( $input_class ) .' ';

					if( isset($this->field['version']) && $this->field['version'] == 'separated-fields' ){
						if( $i != 'top' ){
							echo '\' + ( '.$js.' && '.$js.'.top && '.$js.'.right && '.$js.'.bottom && '.$js.'.left && '.$js.'.top == '.$js.'.right && '.$js.'.top == '.$js.'.left && '.$js.'.top == '.$js.'.bottom ? \'readonly\' : \'\' ) + \'';
						}
					}else{
						echo '\' + ( '.$js.' && '.$js.'.length && '.$i.' > 0 && '.$js.'.split(" ").every( (val) => val === '.$js.'.split(" ")[0] ) ? \'readonly\' : \'\' ) + \'';
					}

					echo '" data-key="'. esc_attr( $i ) .'" ';

					if( isset($this->field['version']) && $this->field['version'] == 'separated-fields' ){
						echo $this->get_name( $meta, $i ) .' value="\'+( typeof '.$js.' !== \'undefined\' && typeof '.$js.'[\''.$i.'\'] !== \'undefined\' ? '.$js.'.'.$i.' : "")+\'"';
					}else{
						echo 'value="\'+('.$js.' && '.$js.'.split(" ")['.$i.'] ? '.$js.'.split(" ")['.$i.'] : "")+\'"';
					}

					echo  ' autocomplete="off" placeholder="" '.$readonly .' '; 

					if( isset($this->field['version']) ){ 
						if( $i != 'top' ){
							echo '\' + ( '.$js.' && '.$js.'.top && '.$js.'.right && '.$js.'.bottom && '.$js.'.left && '.$js.'.top == '.$js.'.right && '.$js.'.top == '.$js.'.left && '.$js.'.top == '.$js.'.bottom ? \'readonly="readonly"\' : \'\' ) + \'';
						}
					}else{
						echo '\' + ( '.$js.' && '.$js.'.length && '.$i.' > 0 && '.$js.'.split(" ").every( (val) => val === '.$js.'.split(" ")[0] ) ? \'readonly="readonly"\' : \'\' ) + \'';
					}
					
					echo '>';
					
				echo '</div>';

			}

			echo '</div>';

			echo '<div class="form-addon-append">';
				echo '<a href="#" class="link">';
					echo '<span class="label"><i class="icon-link"></i></span>';
				echo '</a>';
			echo '</div>';
		echo '</div>';

	}else{

		echo '<div class="form-group multiple-inputs has-addons has-addons-append '. esc_attr( $class ) .'">';
		echo '<div class="form-control">';

			if( !isset($this->field['version']) ) {
				echo '<input class="pseudo-field mfn-form-control mfn-field-value" type="hidden" '. $this->get_name( $meta ) .' value="'. $value .'" autocomplete="off"/>';
			}

			foreach( $inputs as $i=>$input ){

				$sub_value = '';

				isset($explode_val[$i]) ? $sub_value = $explode_val[$i] : $sub_value = '';

				$input_class = 'field-'.esc_attr( $i );

				if(isset($this->field['version'])){
					$input_class .= ' mfn-field-value';
				}

				$in_class = false;

				if( 'top' != $i && '&#8598;' != $i && '0' != $i ){

					$in_class = 'disableable';

				}

				echo '<div class="field '. esc_attr( $in_class ) .'" data-key="'. ( isset($this->field['version']) ? esc_attr( $i ) : $inputs[$i] ) .'">';
					echo '<input type="text" class="mfn-form-control mfn-form-input numeral  '. esc_attr( $input_class ) .' " data-key="'. esc_attr( $i ) .'" ';

					if( isset($this->field['version']) && $this->field['version'] == 'separated-fields' ){
						echo $this->get_name( $meta, $i ) .' value="'. esc_attr( $sub_value ) .'"';
					}else{
						echo 'value="'. esc_attr( $sub_value ).'"';
					}
					echo  ' autocomplete="off" placeholder="" '.$readonly .' >';
					
				echo '</div>';

			}

			echo '</div>';

			echo '<div class="form-addon-append">';
				echo '<a href="#" class="link">';
					echo '<span class="label"><i class="icon-link"></i></span>';
				echo '</a>';
			echo '</div>';
		echo '</div>';
	}
}


	/**
	 * Enqueue Function.
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-field-dimensions', MFN_OPTIONS_URI .'fields/dimensions/field_dimensions.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
