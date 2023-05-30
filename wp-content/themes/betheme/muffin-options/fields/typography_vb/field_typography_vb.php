<?php
class MFN_Options_typography_vb extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
		if( $vb ){
			$mfnvb = new MfnVisualBuilder();
		} else {
			$meta = $this->field['id'];
		}

		$used_fields = array(

			'font-size' => array(
				'id' => $meta."[font-size]",
				'type' => 'sliderbar',
				'responsive' => 'desktop',
				'class' => 'mfn_field_desktop typo-font-size',
				'title' => __('Size', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
				)
			),

			'font-size_tablet' => array(
				'id' => $meta."[font-size_tablet]",
				'type' => 'sliderbar',
				'responsive' => 'tablet',
				'class' => 'mfn_field_tablet typo-font-size',
				'title' => __('Size', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
				)
			),

			'font-size_mobile' => array(
				'id' => $meta."[font-size_mobile]",
				'type' => 'sliderbar',
				'responsive' => 'mobile',
				'class' => 'mfn_field_mobile typo-font-size',
				'title' => __('Size', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
				)
			),

			'line-height' => array(
				'id' => $meta."[line-height]",
				'type' => 'sliderbar',
				'responsive' => 'desktop',
				'class' => 'mfn_field_desktop typo-line-height',
				'title' => __('Line height', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
				),
			),

			'line-height_tablet' => array(
				'id' => $meta."[line-height_tablet]",
				'type' => 'sliderbar',
				'responsive' => 'tablet',
				'class' => 'mfn_field_tablet typo-line-height',
				'title' => __('Line height', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
				),
			),

			'line-height_mobile' => array(
				'id' => $meta."[line-height_mobile]",
				'type' => 'sliderbar',
				'responsive' => 'mobile',
				'class' => 'mfn_field_mobile typo-line-height',
				'title' => __('Line height', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 10, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 100, 'step' => 1),
				),
			),

			'font-weight' => array(
				'id' => $meta."[font-weight]",
				'type' => 'select',
				'class' => 'typo-font-weight',
				'title' => __('Font weight', 'mfn-opts'),
				'options' => array(
					'' => 'Default',
					'normal' => 'Normal',
					'bold' => 'Bold',
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900'
				),
			),

			'letter-spacing' => array(
				'id' => $meta."[letter-spacing]",
				'type' => 'sliderbar',
				'responsive' => 'desktop',
				'class' => 'mfn_field_desktop typo-letter-spacing',
				'title' => __('Letter spacing', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 20, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 3, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 3, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 3, 'step' => 0.1),
				),
			),

			'letter-spacing_tablet' => array(
				'id' => $meta."[letter-spacing_tablet]",
				'type' => 'sliderbar',
				'responsive' => 'tablet',
				'class' => 'mfn_field_tablet typo-letter-spacing',
				'title' => __('Letter spacing', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 20, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 3, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 3, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 3, 'step' => 0.1),
				),
			),

			'letter-spacing_mobile' => array(
				'id' => $meta."[letter-spacing_mobile]",
				'type' => 'sliderbar',
				'responsive' => 'mobile',
				'class' => 'mfn_field_mobile typo-letter-spacing',
				'title' => __('Letter spacing', 'mfn-opts'),
				'units' => array(
					'px' 	=> array('min' => 1, 'max' => 20, 'step' => 1),
					'em' 	=> array('min' => 0.1, 'max' => 3, 'step' => 0.1),
					'rem' 	=> array('min' => 0.1, 'max' => 3, 'step' => 0.1),
					'vw' 	=> array('min' => 1, 'max' => 20, 'step' => 1),
				),
			),

			'text-transform' => array(
				'id' => $meta."[text-transform]",
				'type' => 'select',
				'title' => __('Transform', 'mfn-opts'),
				'class' => 'typo-text-transform',
				'options' => array(
					'' => 'Default',
					'uppercase' => 'Uppercase',
					'lowercase' => 'Lowercase',
					'capitalize' => 'Capitalize',
					'none' => 'Normal',
				),
			),

			'font-family' => array(
				'id' => $meta."[font-family]",
				'class' => 'typo-font-family',
				'type' => 'font_select',
				'title' => __( 'Font family', 'mfn-opts' ),
				'std' => ''
			),

			'font-style' => array(
				'id' => $meta."[font-style]",
				'type' => 'select',
				'class' => 'typo-font-style',
				'title' => __('Style', 'mfn-opts'),
				'options' => array(
					'' => 'Default',
					'italic' => 'Italic',
					'normal' => 'Normal',
					'oblique' => 'Oblique',
				),
			),

			'text-decoration' => array(
				'id' => $meta."[text-decoration]",
				'type' => 'select',
				'class' => 'typo-text-decoration',
				'title' => __('Decoration', 'mfn-opts'),
				'options' => array(
					'' => 'Default',
					'underline' => 'Underline',
					'overline' => 'Overline',
					'line-through' => 'Line through',
					'none' => 'None',
				),
			),
		);

		if( ! $vb ){
			echo '<a href="#" title="Edit" class="mfn-option-btn mfn-option-blank btn-medium mfn-typo-button"><span class="mfn-icon mfn-icon-edit"></span></a>';
		}

		echo '<div class="mfn-toggle-fields-wrapper">';

			$limit = 99;

			if( isset($this->field['typography']) && $this->field['typography'] == 'simple' ){
				$limit = 8;
			}

			$c = 0;

			foreach ( $used_fields as $u => $u_field ) {
				if( ++$c <= $limit ){

					if( $vb ){

						if( $js ){
							echo $mfnvb->mfn_JsformElement($u_field, $u_field['type'], 'fields');
						}else{
							echo $mfnvb->mfn_JsformElement($u_field, '', $uid, $u_field['id'], 'mcb-item-'.$uid, $release);
						}

					} else {

						$meta = 'filled'; // filled field uses 'name'
						$value = $this->value[$u] ?? null;

						if ( empty( $value ) || ( is_array( $value ) && ! array_filter( $value ) ) ){
							$meta = 'empty'; // 'empty' = field uses 'data-name'
						}

						Mfn_Builder_Admin::field( $u_field, $value, $meta );

					}

				}
			}

		echo '</div>';

	}

	/**
	 * Enqueue Function.
	 */

	public function enqueue()
	{
		wp_enqueue_script( 'mfn-field-typography_vb', MFN_OPTIONS_URI .'fields/typography_vb/field_typography_vb.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}

}
