<?php

foreach( $demos as $key=>$demo ){

  $classes = [
    'mfn' => 'mfn',  // all websites are muffin builder based by default
  ];

  if( isset( $demo['layouts'] ) ){
    foreach( $demo['layouts'] as $lay ){

      // remove default muffin builder attribute for elementor based websites
      if( 'ele' == $lay ){
        unset( $classes['mfn'] );
      }

      $classes[] = $lay;

    }
  }

  if( isset( $demo['categories'] ) ){
    foreach( $demo['categories'] as $cat ){
      $classes[] = $cat;
    }
  }

  if( isset( $demo['new'] ) ){
    $classes[] = 'new';
  }

  $classes = implode( ' ', $classes );

  if( isset( $demo['url'] ) ){
    $url = $demo['url'];
  } else {
    $url = 'https://themes.muffingroup.com/be/'. $key;
  }

  if( isset( $demo['name'] ) ){
    $title = $demo['name'];
  } else {
    $title = ucfirst($key);
  }

  // data-title

  $data_title = $key;

  // tresaurus

  $synonym = $this->get_synonym($key);

  if( $synonym ){
    $data_title .= ' '. $synonym;
  }

  // placeholder

  $placeholder = get_theme_file_uri( '/functions/admin/setup/assets/images/placeholder.png' );

  // output -----

  echo '<div class="website '. $classes .'" data-title="'. $data_title .'" data-website="'. $key .'">';
    echo '<img data-src="https://muffingroup.com/betheme/assets/images/demos/'. $key .'.jpg" src="'. $placeholder .'" alt="'. $title .'"/>';
    echo $title;
    if( mfn_is_registered() ){
      echo '<span class="select" data-href="'. $url .'">'. __('Select','mfn-opts') .'</span>';
    } else {
      echo '<a href="admin.php?page=betheme" class="select">'. __('Register','mfn-opts') .'</a>';
    }
    echo '<span class="preview" data-href="'. $url .'"><i class="far fa-eye"></i></span>';
  echo '</div>';

}
