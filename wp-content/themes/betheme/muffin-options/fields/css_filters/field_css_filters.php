<?php
class MFN_Options_css_filters extends Mfn_Options_field
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

       'blur' => array(
         'id' => $meta."[blur]",
         'type' => 'sliderbar',
         'class' => 'css_filters_blur',
         'title' => __('Blur', 'mfn-opts'),
         'param' => array(
            'min' => '0',
            'max' => '20',
            'step' => '0.1',
            'unit' => 'px'
          )
       ),

       'brightness' => array(
         'id' => $meta."[brightness]",
         'type' => 'sliderbar',
         'class' => 'css_filters_blur',
         'title' => __('Brightness', 'mfn-opts'),
         'param' => array(
            'min' => '0',
            'max' => '200',
            'step' => '1',
            'unit' => '%'
          )
       ),

       'contrast' => array(
         'id' => $meta."[contrast]",
         'type' => 'sliderbar',
         'class' => 'css_filters_blur',
         'title' => __('Contrast', 'mfn-opts'),
         'param' => array(
            'min' => '0',
            'max' => '200',
            'step' => '1',
            'unit' => '%'
          )
       ),

       'saturate' => array(
         'id' => $meta."[saturate]",
         'type' => 'sliderbar',
         'class' => 'css_filters_blur',
         'title' => __('Saturation', 'mfn-opts'),
         'param' => array(
            'min' => '0',
            'max' => '200',
            'step' => '1',
            'unit' => '%'
          )
       ),

       'hue-rotate' => array(
         'id' => $meta."[hue-rotate]",
         'type' => 'sliderbar',
         'class' => 'css_filters_blur',
         'title' => __('Hue', 'mfn-opts'),
         'param' => array(
            'min' => '0',
            'max' => '360',
            'step' => '1',
            'unit' => 'deg'
          )
       ),

     );

     if( ! $vb ){
       echo '<a href="#" title="Edit" class="mfn-option-btn mfn-option-blank btn-medium mfn-typo-button"><span class="mfn-icon mfn-icon-edit"></span></a>';
     }

     echo '<div class="mfn-toggle-fields-wrapper">';

       $c = 0;

       foreach ( $used_fields as $u => $u_field ) {


           if( $vb ){

             if( $js ){
               echo $mfnvb->mfn_JsformElement($u_field, $u_field['type'], 'attr');
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

     echo '</div>';

   }

}
