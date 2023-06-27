<?php
class MFN_Options_social extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render( $meta = false, $vb = false, $js = false )
	{
    // socials

    $socials = [
      'skype' => [
        'title' => 'Skype',
        'desc' => __('Skype login. You can use callto: or skype: prefix', 'mfn-opts'),
        'icon' => 'icon-skype',
      ],
      'whatsapp' => [
        'title' => 'WhatsApp',
        'desc' => __('WhatsApp URL. You can use whatsapp: prefix', 'mfn-opts'),
        'icon' => 'icon-whatsapp',
      ],
      'facebook' => [
        'title' => 'Facebook',
        'icon' => 'icon-facebook',
      ],
      'twitter' => [
        'title' => 'Twitter',
        'icon' => 'icon-twitter',
      ],
      'vimeo' => [
        'title' => 'Vimeo',
        'icon' => 'icon-vimeo',
      ],
      'youtube' => [
        'title' => 'YouTube',
        'icon' => 'icon-play',
      ],
      'flickr' => [
        'title' => 'Flickr',
        'icon' => 'icon-flickr',
      ],
      'linkedin' => [
        'title' => 'LinkedIn',
        'icon' => 'icon-linkedin',
      ],
      'pinterest' => [
        'title' => 'Pinterest',
        'icon' => 'icon-pinterest',
      ],
      'dribbble' => [
        'title' => 'Dribbble',
        'icon' => 'icon-dribbble',
      ],
      'instagram' => [
        'title' => 'Instagram',
        'icon' => 'icon-instagram',
      ],
      'snapchat' => [
        'title' => 'Snapchat',
        'icon' => 'icon-snapchat',
      ],
      'behance' => [
        'title' => 'Behance',
        'icon' => 'icon-behance',
      ],
      'tumblr' => [
        'title' => 'Tumblr',
        'icon' => 'icon-tumblr',
      ],
      'tripadvisor' => [
        'title' => 'Tripadvisor',
        'icon' => 'icon-tripadvisor',
      ],
      'vkontakte' => [
        'title' => 'VKontakte',
        'icon' => 'icon-vkontakte',
      ],
      'viadeo' => [
        'title' => 'Viadeo',
        'icon' => 'icon-viadeo',
      ],
      'xing' => [
        'title' => 'Xing',
        'icon' => 'icon-xing',
      ],
			'custom' => true,
			'rss' => true,
    ];

    // order

      if( ! empty( $this->value['order'] ) ){

        $order = $this->value['order'];
        $order = explode( ',', $order );

        $order = array_unique( array_merge( $order, array_keys( $socials ) ) );

      } else {

        $order = array_keys( $socials );

      }

  

		// output -----

		echo '<div class="form-group social-icons">';

      echo '<ul class="social-wrapper">';

        foreach( $order as $key ){

					if( false !== strpos($key, 'custom') ){

						if( 'custom' === $key ){
							$option = 'social-custom-icon';
						} else {
							$option = str_replace('custom-', '', $key);
							$option = 'social-custom-icon-'. $option;
						}

						if( ! empty( mfn_opts_get($option) ) ){
							$icon = mfn_opts_get($option);
						} else {
							$icon = 'fas fa-question';
						}

						echo '<li data-key="'. esc_attr($key) .'">';
	            echo '<div class="drag"><i class="icon-arrow-combo"></i></div>';
	            echo '<div class="label"><i class="'. esc_attr($icon) .'"></i>'. str_replace('-', ' ', ucfirst($key)) .'</div>';
	            echo '<div class="form-control">';
	              echo '<span>'. sprintf( __('Custom icon selected <a href="%s">below</a>', 'mfn-opts'), 'admin.php?page=be-options#social&'. esc_attr($key) ) .'</span>';
	            echo '</div>';
	          echo '</li>';

					} elseif( 'rss' == $key ) {

						echo '<li data-key="rss">';
	            echo '<div class="drag"><i class="icon-arrow-combo"></i></div>';
	            echo '<div class="label"><i class="icon-rss"></i> RSS</div>';
	            echo '<div class="form-control">';
	              echo '<span>'. sprintf( __('Show the RSS icon if enabled <a href="%s">below</a>', 'mfn-opts'), 'admin.php?page=be-options#social&rss' ) .'<span>';
	            echo '</div>';
	          echo '</li>';

					} else {

						$social = $socials[$key];

	          if( ! empty( $this->value[$key] ) ){
	            $value = $this->value[$key];
	          } else {
	            $value = '';
	          }

	          if( ! empty( $social['desc'] ) ){
	            $desc = $social['desc'];
	          } else {
	            $desc = __('Link to the profile page', 'mfn-opts');
	          }

            if( $js ){

              echo '<li data-key="'. esc_attr($key) .'">';
                echo '<div class="drag"><i class="icon-arrow-combo"></i></div>';
                echo '<div class="label" data-tooltip="'. esc_attr($desc) .'"><i class="'. esc_attr( $social['icon'] ) .'"></i> '. esc_html( $social['title'] ) .'</div>';
                echo '<div class="form-control">';
                  echo '<input class="mfn-form-control mfn-field-value mfn-form-input" type="text" '. $this->get_name( $meta, $key ) .' value="\'+('.$js.' && typeof '.$js.'[\''.$key.'\'] !== \'undefined\' && '.$js.'[\''.$key.'\'].length ? '.$js.'[\''.$key.'\'] : "")+\'"/>';
                echo '</div>';
              echo '</li>';

            }else{

  	          echo '<li data-key="'. esc_attr($key) .'">';
  	            echo '<div class="drag"><i class="icon-arrow-combo"></i></div>';
  	            echo '<div class="label" data-tooltip="'. esc_attr($desc) .'"><i class="'. esc_attr( $social['icon'] ) .'"></i> '. esc_html( $social['title'] ) .'</div>';
  	            echo '<div class="form-control">';
  	              echo '<input class="mfn-form-control mfn-field-value mfn-form-input" type="text" '. $this->get_name( $meta, $key ) .' value="'. esc_attr( $value ) .'"/>';
  	            echo '</div>';
  	          echo '</li>';

            }

					}

        }

      echo '</ul>';

      if( $js ){
        echo '<input type="hidden" data-obj="order" class="social-order mfn-field-value" '. $this->get_name( $meta, 'order' ) .' value="\'+('.$js.' && typeof '.$js.'[\'order\'] !== \'undefined\' && '.$js.'[\'order\'].length ? '.$js.'[\'order\'] : "")+\'" />';
      }else{
        echo '<input type="hidden" data-obj="order" class="social-order mfn-field-value" '. $this->get_name( $meta, 'order' ) .' value="'. esc_attr( implode( ',', $order ) ) .'" />';
      }

		echo '</div>';

		echo $this->get_description();

    // enqueue

    $this->enqueue();

	}

  /**
   * Enqueue
   */

  public function enqueue()
  {
    wp_enqueue_script( 'mfn-opts-field-social', MFN_OPTIONS_URI .'fields/social/field_social.js', array( 'jquery' ), MFN_THEME_VERSION, true );
  }
}
