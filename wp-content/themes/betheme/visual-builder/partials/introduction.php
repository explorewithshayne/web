<?php

if( defined('BEBUILDER_DEMO_VERSION') ){

  echo '<div class="mfn-intro-overlay demo" style="display:none">';
    echo '<div class="mfn-intro-container">';

      echo '<a class="mfn-intro-close close-button mfn-option-btn btn-large" href="#"><span class="mfn-icon mfn-icon-close-light"></span></a>';

      echo '<ul>';

        echo '<li>
          <img class="icon" alt="" src="'. get_theme_file_uri( '/visual-builder/assets/svg/others/welcome-demo.svg' ) .'">
          <div class="desc">
            <h4>Bear in mind that this is a <b>Bebuilder demo</b>, therefore following features are <b>unavailable</b>:</h4>
            <div class="demo-pills">
              <span class="pill">Site update and preview</span>
              <span class="pill">Import and Export</span>
              <span class="pill">History</span>
              <span class="pill">Page options</span>
              <span class="pill">Theme options</span>
              <span class="pill">Settings</span>
            </div>
            <a class="mfn-intro-close mfn-btn" href="#">Continue</a>
          </div>
        </li>';

      echo '</ul>';

    echo '</div>';
  echo '</div>';

} else if( ! class_exists('Be_custom') ){

  $slides = [
    '<h1>Fast & intuitive BeBuilder</h1>',
    '<h2>View an element and customise it<br /> at the same time</h2>',
    '<h2>Hundreds of pre-built sections<br /> ready to use on click</h2>',
    '<h2>Create, save & restore whenever<br /> you want with Revisions</h2>',
    '<h2>Import & Export of content<br /> or single sections</h2>',
    '<h2>Live responsive preview for<br /> mobile, tablet & desktop layout</h2>',
  ];

  $max = count( $slides );
  $index = 1;

  echo '<div class="mfn-intro-overlay" style="display:none">';
    echo '<div class="mfn-intro-container">';

      echo '<a class="mfn-intro-close close-button mfn-option-btn btn-large" href="#"><span class="mfn-icon mfn-icon-close-light"></span></a>';

      echo '<ul>';

        foreach( $slides as $slide ){

          echo '<li class="step-'. $index .'">
            <div class="pic"></div>
            <div class="desc">
              <p class="slide-number">'. $index .' / '. $max .'</p>
              '. $slide .'
              <a class="mfn-intro-close start-now" href="#">Skip</a>
            </div>
          </li>';

          $index++;
        }

      echo '</ul>';
    echo '</div>';
  echo '</div>';

}

?>
