<?php

  $classes = [];
  $step = 1;

  if( mfn_is_registered() ){
    $classes[] = 'mfn-registered';
    $step = 2;
  } else {
    $classes[] = 'mfn-unregistered';
  }

  $classes = implode(' ', $classes);
?>

<div id="mfn-setup" class="mfn-ui mfn-setup mfn-importer mfn-registered loading" data-step="type" data-type="start">

  <header class="mfn-menu">

    <?php
  		$logo = '<div class="logo"></div>';

  		echo apply_filters('betheme_logo', $logo);
  	?>

    <div class="menu-wrapper">

      <ul class="setup-menu" data-type="start">
        <li data-step="type" class="active"><span class="mfn-icon mfn-icon-setup-type"></span>Setup type</li>
      </ul>

      <ul class="setup-menu" data-type="pre-built">
        <li data-step="type"><span class="mfn-icon mfn-icon-setup-type"></span>Setup type</li>
        <li data-step="title"><span class="mfn-icon mfn-icon-basics"></span>Basics</li>
        <li data-step="pre-built"><span class="mfn-icon mfn-icon-websites"></span>Websites</li>
        <li data-step="complete"><span class="mfn-icon mfn-icon-complete"></span>Complete</li>
      </ul>

      <ul class="setup-menu" data-type="new">
        <li data-step="type"><span class="mfn-icon mfn-icon-setup-type"></span>Setup type</li>
        <li data-step="title"><span class="mfn-icon mfn-icon-basics"></span>Basics</li>
        <li data-step="layout"><span class="mfn-icon mfn-icon-dashboard"></span>Layout</li>
        <li data-step="typography"><span class="mfn-icon mfn-icon-design"></span>Design</li>
        <!-- <li data-step="content"><i class="fas fa-align-left"></i>Content</li> -->
        <li data-step="plugins"><span class="mfn-icon mfn-icon-plugins"></span>Plugins</li>
        <li data-step="complete"><span class="mfn-icon mfn-icon-complete"></span>Complete</li>
      </ul>

      <ul class="setup-menu" data-type="finish">
        <li data-step="finish" class="active"><span class="mfn-icon mfn-icon-finish"></span>Finished</li>
      </ul>

    </div>

    <span class="mfn-color-scheme">
      <i class="icon-moon dark"></i>
      <i class="icon-light-up light"></i>
    </span>

    <span class="setup-progress-bar"></span>
    <span class="setup-progress-label">14%</span>

  </header>

  <footer class="mfn-footer">
    <a class="mfn-btn mfn-btn-blank setup-previous">Previous step</a>
    <ul>
      <li><a class="mfn-btn mfn-btn-blank btn-only-icon" target="_blank" href="https://support.muffingroup.com/" data-tooltip="Help Center"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-support"></span></span></a></li><li><a class="mfn-btn mfn-btn-blank btn-only-icon" target="_blank" href="https://support.muffingroup.com/changelog/" data-tooltip="Changelog"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-changelog"></span></span></a></li>
    </ul>
    <a class="mfn-btn mfn-btn-blue setup-next">Next step</a>
  </footer>

  <div class="mfn-wrapper">

    <form class="mfn-form-setup" method="post">

      <input type="hidden" name="mfn-setup-nonce" value="<?php echo wp_create_nonce( 'mfn-setup' ); ?>">
      <input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">
      <input type="hidden" name="mfn-tgmpa-nonce" value="<?php echo wp_create_nonce( 'tgmpa-install' ); ?>">

      <input type="hidden" name="action" value="mfn_setup_wizard">

      <input type="hidden" name="type" id="setup-type" value="pre-built" autocomplete="off">
      <input type="hidden" name="type" id="setup-builder" value="be" autocomplete="off">
      <input type="hidden" name="type" id="setup-editor" value="visual" autocomplete="off">
      <input type="hidden" name="type" id="setup-website" value="" autocomplete="off">

      <!-- Setup type -->

      <div class="mfn-setup-card card-setup active" data-step="type">

        <div class="card-header">
          <h2>Setup type</h2>
          <p>Please choose, if you want to use one of the pre-built websites or start from scratch</p>
        </div>

        <ul class="choose choose-big setup-type">

          <li data-type="pre-built" class="active">

            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 139.99 96.27">
            	<defs><style>.cls-a{fill:url(#linear-gradient);}.cls-b{fill:url(#linear-gradient-2);}</style><linearGradient id="linear-gradient" x1="24.89" y1="55.2" x2="97.14" y2="-43.96" gradientUnits="userSpaceOnUse"><stop offset="0.09" stop-color="#0089f7"/><stop offset="0.92" stop-color="#0dc7ff"/></linearGradient><linearGradient id="linear-gradient-2" x1="84" y1="91.61" x2="155.58" y2="15.55" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#0089f7"/><stop offset="1" stop-color="#0dc7ff"/></linearGradient></defs>
            	<path class="cls-a" d="M55.29,47a32.17,32.17,0,0,0,7.38-3.7,21.26,21.26,0,0,0,5-4.74,18.31,18.31,0,0,0,2.88-5.58,20.92,20.92,0,0,0,.91-6.18,27.53,27.53,0,0,0-2-10.65A19.68,19.68,0,0,0,63.13,8a32,32,0,0,0-11.3-5.16A66.64,66.64,0,0,0,35,1H0V96.22H38A48.7,48.7,0,0,0,53.26,94,32.38,32.38,0,0,0,64.47,88a25.82,25.82,0,0,0,6.9-9.11,27.24,27.24,0,0,0,2.35-11.31q0-8-4.51-13.17T55.29,47ZM22.09,17.53H35a30.93,30.93,0,0,1,6.44.59,11.24,11.24,0,0,1,4.48,2,8.22,8.22,0,0,1,2.61,3.63,16.32,16.32,0,0,1,.85,5.65,13.52,13.52,0,0,1-1.08,5.76,8.37,8.37,0,0,1-3.14,3.59,13.7,13.7,0,0,1-5,1.83,37.76,37.76,0,0,1-6.6.52H22.09ZM51.31,71.58a9.79,9.79,0,0,1-2.16,4,11.56,11.56,0,0,1-4.35,2.88,19.51,19.51,0,0,1-7.15,1.11H22.09V55.83H37.51a25.41,25.41,0,0,1,6.93.79,11.42,11.42,0,0,1,4.41,2.22,7.73,7.73,0,0,1,2.36,3.53,15.24,15.24,0,0,1,.68,4.7A18.05,18.05,0,0,1,51.31,71.58Z" transform="translate(0 -1)"/>
            	<path class="cls-b" d="M137.67,65.64a2.75,2.75,0,0,0,1.41-1.18,5.83,5.83,0,0,0,.72-2.29,28.76,28.76,0,0,0,.19-3.72,36,36,0,0,0-2.25-13.11,27.91,27.91,0,0,0-6.28-9.77,26.83,26.83,0,0,0-9.6-6.07,37.46,37.46,0,0,0-26.28.58A31.34,31.34,0,0,0,78.39,48a36,36,0,0,0-2.32,12.88,42.42,42.42,0,0,0,2.72,15.81,32.54,32.54,0,0,0,7.38,11.37A30.84,30.84,0,0,0,97.09,95a38.17,38.17,0,0,0,13.36,2.32,58.71,58.71,0,0,0,7.29-.49A40.66,40.66,0,0,0,125.39,95a35.08,35.08,0,0,0,7.45-3.53,30.08,30.08,0,0,0,6.76-5.85l-5.88-7.25a4.18,4.18,0,0,0-3.66-1.76,7.57,7.57,0,0,0-3.5.85q-1.66.84-3.66,1.89a30.72,30.72,0,0,1-4.54,1.9,19.54,19.54,0,0,1-6.08.84,15.33,15.33,0,0,1-10.78-3.82Q97.32,74.46,96.33,66h39.09A6.79,6.79,0,0,0,137.67,65.64ZM96.53,54.2c.7-4.14,2.13-7.31,4.32-9.51s5.2-3.3,9.08-3.3a12.59,12.59,0,0,1,5.55,1.11,10.3,10.3,0,0,1,3.7,2.91,11.48,11.48,0,0,1,2,4.08,18.12,18.12,0,0,1,.62,4.71Z" transform="translate(0 -1)"/>
            </svg>

            <h4>Pre-built website</h4>
            <p>Use one of our built-in 650+ pre-built websites</p>
          </li>

          <li data-type="new">

            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 142 99">
            	<defs><style>.cls-1{fill:transparent;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:1.5px}</style></defs>
            	<path class="cls-1" d="M55.29,47a32.17,32.17,0,0,0,7.38-3.7,21.26,21.26,0,0,0,5-4.74,18.31,18.31,0,0,0,2.88-5.58,20.92,20.92,0,0,0,.91-6.18,27.53,27.53,0,0,0-2-10.65A19.68,19.68,0,0,0,63.13,8a32,32,0,0,0-11.3-5.16A66.64,66.64,0,0,0,35,1H0V96.22H38A48.7,48.7,0,0,0,53.26,94,32.38,32.38,0,0,0,64.47,88a25.82,25.82,0,0,0,6.9-9.11,27.24,27.24,0,0,0,2.35-11.31q0-8-4.51-13.17T55.29,47ZM22.09,17.53H35a30.93,30.93,0,0,1,6.44.59,11.24,11.24,0,0,1,4.48,2,8.22,8.22,0,0,1,2.61,3.63,16.32,16.32,0,0,1,.85,5.65,13.52,13.52,0,0,1-1.08,5.76,8.37,8.37,0,0,1-3.14,3.59,13.7,13.7,0,0,1-5,1.83,37.76,37.76,0,0,1-6.6.52H22.09ZM51.31,71.58a9.79,9.79,0,0,1-2.16,4,11.56,11.56,0,0,1-4.35,2.88,19.51,19.51,0,0,1-7.15,1.11H22.09V55.83H37.51a25.41,25.41,0,0,1,6.93.79,11.42,11.42,0,0,1,4.41,2.22,7.73,7.73,0,0,1,2.36,3.53,15.24,15.24,0,0,1,.68,4.7A18.05,18.05,0,0,1,51.31,71.58Z" transform="translate(1 0)"/>
            	<path class="cls-1" d="M137.67,65.64a2.75,2.75,0,0,0,1.41-1.18,5.83,5.83,0,0,0,.72-2.29,28.76,28.76,0,0,0,.19-3.72,36,36,0,0,0-2.25-13.11,27.91,27.91,0,0,0-6.28-9.77,26.83,26.83,0,0,0-9.6-6.07,37.46,37.46,0,0,0-26.28.58A31.34,31.34,0,0,0,78.39,48a36,36,0,0,0-2.32,12.88,42.42,42.42,0,0,0,2.72,15.81,32.54,32.54,0,0,0,7.38,11.37A30.84,30.84,0,0,0,97.09,95a38.17,38.17,0,0,0,13.36,2.32,58.71,58.71,0,0,0,7.29-.49A40.66,40.66,0,0,0,125.39,95a35.08,35.08,0,0,0,7.45-3.53,30.08,30.08,0,0,0,6.76-5.85l-5.88-7.25a4.18,4.18,0,0,0-3.66-1.76,7.57,7.57,0,0,0-3.5.85q-1.66.84-3.66,1.89a30.72,30.72,0,0,1-4.54,1.9,19.54,19.54,0,0,1-6.08.84,15.33,15.33,0,0,1-10.78-3.82Q97.32,74.46,96.33,66h39.09A6.79,6.79,0,0,0,137.67,65.64ZM96.53,54.2c.7-4.14,2.13-7.31,4.32-9.51s5.2-3.3,9.08-3.3a12.59,12.59,0,0,1,5.55,1.11,10.3,10.3,0,0,1,3.7,2.91,11.48,11.48,0,0,1,2,4.08,18.12,18.12,0,0,1,.62,4.71Z" transform="translate(1 0)"/>
            </svg>

            <h4>From scratch</h4>
            <p>Step by step wizard based on your preferences</p>
          </li>

        </ul>

        <a class="mfn-btn mfn-btn-blue btn-large setup-type-next">Let's get started</a>

      </div>

      <!-- Basic details -->

      <div class="mfn-setup-card card-title-tagline" data-step="title">

        <div class="card-header">
          <h2>Site title and tagline</h2>
          <p>Set your site basic details. These informations will be used in site metadata.</p>
          <h2 class="inner-navigation next">Text editor</h2>
        </div>

        <div class="card-content">

          <div class="input-wrapper">
            <span class="label">Site Title</span>
            <input id="input-blogname" type="text" name="blogname" value="<?php echo get_bloginfo('name') ?>" >
          </div>

          <div class="input-wrapper">
            <span class="label">Tagline</span>
            <input id="input-blogdescription" type="text" name="blogdescription" value="<?php echo get_bloginfo('description') ?>" >
          </div>

        </div>

      </div>

      <!-- Editor -->

      <div class="mfn-setup-card card-editor" data-step="editor">

        <div class="card-header">
          <h2>Text editor</h2>

          <p>Choose the editor that suits your needs best.</p>
          <h2 class="inner-navigation prev">Site title and tagline</h2>
          <h2 class="inner-navigation next">What type of business...</h2>
        </div>

        <ul class="choose choose-big choose-editor">

          <li data-type="visual" class="active">
            <h4>Visual</h4>
            <p>WYSIWYG editor, best especially for beginners</p>
          </li>

          <li data-type="code">
            <h4>Code</h4>
            <p>Codemirror with syntax highlighting</p>
          </li>

        </ul>

        <div class="card-content">

          <p>
            <a href="https://www.youtube.com/watch?v=lirABcHeF-Y" class="lightbox">Not sure? Compare both.</a>
          </p>

        </div>

      </div>

      <!-- Category -->

      <div class="mfn-setup-card card-category" data-step="category">

        <div class="card-header">
          <h2>What type of business do you have?</h2>
          <p>Check the category/categories that best suit your type of business. Otherwise, skip this step.</p>
          <h2 class="inner-navigation prev">Text editor</h2>
          <h2 class="inner-navigation next">Your favourite builder</h2>
        </div>

        <ul class="list-business-type">
          <?php
            foreach ( $this->categories as $key_category => $category ) {
              echo '<li data-filter=".'. $key_category .'">'. $category .'</li>';
            }
          ?>
        </ul>

      </div>

      <!-- Pre-built website -->

      <div class="mfn-setup-card card-pre-built" data-step="pre-built">

        <?php include_once get_theme_file_path('/functions/admin/setup/templates/websites.php'); ?>

      </div>

      <!-- Layout -->

      <div class="mfn-setup-card card-iframe" data-step="iframe">

        <div class="card-header" data-step="layout">
          <h2>Layout</h2>
          <p>Set things like header, logo and footer for your website and preview them live.</p>
        </div>

        <div class="card-header" data-step="typography">
          <h2>Typography</h2>
          <p>Choose from different types of typography, that you can change later if needed.</p>
          <h2 class="inner-navigation next">Colors</h2>
        </div>

        <div class="card-header" data-step="colors">
          <h2>Colors</h2>
          <p>Choose from various sets of colours, that you can customize anytime later.</p>
          <h2 class="inner-navigation prev">Typography</h2>
        </div>

        <div class="card-content">
          <div class="iframe-wrapper">
            <div class="browser-bar">
              <span class="dot red"></span>
              <span class="dot yellow"></span>
              <span class="dot green"></span>
            </div>
            <iframe id="setup-preview" data-src="<?php echo get_home_url() .'?mfn-setup-preview&page_id='. $this->demo_page_id[0]; ?>"></iframe>
          </div>
        </div>

      </div>

      <!-- Content -->

      <div class="mfn-setup-card card-contents" data-step="content">

        <div class="card-header">
          <h2>Content</h2>
          <p>Set your site basic details. These informations will be used in site metadata.</p>
        </div>

        <div class="card-content">

        </div>

      </div>

      <!-- Plugins -->

      <div class="mfn-setup-card card-plugins" data-step="plugins">

        <div class="card-header">
          <h2>Plugins</h2>
          <p>Select the plugins you would like to install. Otherwise, please skip this step.</p>
        </div>

        <ul class="choose choose-big choose-plugin">

  				<?php
  					foreach( $this->plugins as $plugin_key => $plugin ){

  						echo '<li data-plugin="'. esc_attr($plugin_key) .'">';

                echo '<div class="plugin-logo">';
          				if( ! empty($plugin['dark']) ){
          					echo '<img class="icon-light" src="'. get_theme_file_uri('/functions/admin/assets/svg/plugins/'. esc_attr($plugin['slug']) .'.svg') .'" alt="" />';
          					echo '<img class="icon-dark" src="'. get_theme_file_uri('/functions/admin/assets/svg/_dark/plugins/'. esc_attr($plugin['slug']) .'.svg') .'" alt="" />';
          				} else {
          					echo '<img src="'. get_theme_file_uri('/functions/admin/assets/svg/plugins/'. esc_attr($plugin['slug']) .'.svg') .'" alt="" />';
          				}
          			echo '</div>';

  							echo '<h4>'. esc_attr($plugin['name']) .'</h4>';
  							echo '<p>'. $plugin['desc'] .'</p>';
  						echo '</li>';
  					}
  				?>

  			</ul>

      </div>

      <?php
				// card: builder
				include_once get_theme_file_path('/functions/importer/templates/parts/card-builder.php');

				// card: data
				include_once get_theme_file_path('/functions/importer/templates/parts/card-data.php');

				// card: complete
				include_once get_theme_file_path('/functions/importer/templates/parts/card-complete.php');

				// card: finish
				include_once get_theme_file_path('/functions/importer/templates/parts/card-finish.php');
			?>

    </form>

  </div>

  <?php
		// modal: database reset confirm
		include_once get_theme_file_path('/functions/importer/templates/parts/modal-reset.php');
	?>

  <!-- sidebar -->

  <div class="mfn-sidebar">

    <!-- <span class="sidebar-toggle"><i class="icon-left-open-big"></i></span> -->

    <!-- sidebar card: layout -->

    <div class="sidebar-card mfn-form" data-step="layout">

      <div class="toggle-list layout-select">

        <div class="toggle-item" data-item="header">

          <div class="header">
            <span class="step-number">
              <span class="number">1</span>
              <i class="icon fas fa-check"></i>
            </span>
            <div class="title-bar">
              <h5 class="title">Header</h5>
              <p class="desc">Set your site global header layout</p>
            </div>
          </div>

          <div class="content">
            <div class="content-wrapper">
              <div class="tabs">
                <ul>
                  <li class="active">Default</li>
                  <li>Pre-built</li>
                </ul>
                <div class="tab select-header-default active">
                  <?php
                    Mfn_Builder_Admin::field([
                      'id' => 'header-style',
            					'type' => 'radio_img',
            					'title' => __( 'Style', 'mfn-opts' ),
            					'options' => mfna_header_style(),
            					'alias' => 'header',
            					'class' => 'no-row',
            					'value' => 'classic',
                    ], '', false );
                  ?>
                </div>
                <div class="tab">
                  <ul class="select-pre select-header-pre">
                    <?php
                      $sections = Mfn_Pre_Built_Sections::get_sections('header');
                      foreach( $sections as $section_key => $section ){
                        echo '<li data-id="'. esc_attr( $section_key ).'">';
    		                  echo '<div class="photo">';
    		                    echo '<img src="'. get_theme_file_uri( '/functions/builder/pre-built/images/'. $section_key .'.png' ) .'" alt="" />';
    		                  echo '</div>';
    		                  echo '<div class="desc">';
    		                    echo '<h6>'. esc_html( $section['title'] ).'</h6>';
    		                  echo '</div>';
    		                echo '</li>';
                      }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="toggle-item" data-item="logo">

          <div class="header">
            <span class="step-number">
              <span class="number">2</span>
              <i class="icon fas fa-check"></i>
            </span>
            <div class="title-bar">
              <h5 class="title">Logo</h5>
              <p class="desc">Set your site global logo</p>
            </div>
          </div>

          <div class="content">
            <div class="content-wrapper">

              <div class="form-group browse-image has-addons has-addons-append empty">

                <div class="form-control has-icon has-icon-right">
      						<input id="layout-logo" type="text" name="setup-logo" class="widefat mfn-form-control mfn-field-value mfn-form-input" value="">
      						<a class="mfn-option-btn mfn-button-delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>
      					</div>

      					<div class="form-addon-append">
      						<a href="#" class="mfn-button-upload"><span class="label">Browse</span></a>
      					</div>

      					<div class="selected-image">
                  <img src="" alt="" />
                </div>

              </div>

            </div>
          </div>

        </div>

        <div class="toggle-item" data-item="footer">

          <div class="header">
            <span class="step-number">
              <span class="number">3</span>
              <i class="icon fas fa-check"></i>
            </span>
            <div class="title-bar">
              <h5 class="title">Footer</h5>
              <p class="desc">Set your site global footer layout</p>
            </div>
          </div>

          <div class="content">
            <div class="content-wrapper">
              <div class="tabs">
                <ul>
                  <li class="active">Default</li>
                  <li>Pre-built</li>
                </ul>
                <div class="tab select-footer-default active">
                  <?php
                    Mfn_Builder_Admin::field([
                      'id' => 'footer-layout',
            					'type' => 'radio_img',
            					'title' => __( 'Layout', 'mfn-opts' ),
            					'options' => mfna_footer_style(),
                      'class' => 'no-row',
                    ], '', false );
                  ?>
                </div>
                <div class="tab">
                  <ul class="select-pre select-footer-pre">
                    <?php
                      $sections = Mfn_Pre_Built_Sections::get_sections('footer');
                      foreach( $sections as $section_key => $section ){
                        echo '<li data-id="'. esc_attr( $section_key ).'">';
    		                  echo '<div class="photo">';
    		                    echo '<img src="'. get_theme_file_uri( '/functions/builder/pre-built/images/'. $section_key .'.png' ) .'" alt="" />';
    		                  echo '</div>';
    		                  echo '<div class="desc">';
    		                    echo '<h6>'. esc_html( $section['title'] ).'</h6>';
    		                  echo '</div>';
    		                echo '</li>';
                      }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- sidebar card: typography -->

    <div class="sidebar-card mfn-form scrollable" data-step="typography">

      <ul class="select-font">

        <?php
          $class = 'active';

          foreach( $this->fonts as $f_key => $font ){

            echo '<li class="'. esc_attr($class) .'" data-id="'. esc_attr($f_key) .'" data-font="'. implode(',',$font) .'" style="--mfn-font-family-0:'. $font[0] .';--mfn-font-family-1:'. $font[1] .'">';

              if( $font[0] == $font[1] ){
                echo '<h1 class="heading">'. $font[0] .'</h1>';
              } else {
                echo '<h1 class="heading">'. $font[0] .' + '. $font[1] .'</h1>';
              }

              echo '<h5 class="subheading">Subheading</h5>';
              echo '<p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';

            echo '</li>';

            $class = false;
          }
        ?>

      </ul>

    </div>

    <!-- sidebar card: colors -->

    <div class="sidebar-card mfn-form scrollable" data-step="colors">

      <ul class="select-color">

        <?php
          $class = 'active';


          foreach( $this->colors as $c_key => $color ){

            $style = [];
            foreach( $color as $ck => $cv ){
              $style[] = '--mfn-color-'. $ck .':'. $cv;
            }
            $style = implode(';',$style);

            echo '<li class="'. esc_attr($class) .'" data-id="'. esc_attr($c_key) .'" data-color="'. implode(',',$color) .'" style="'. $style .'">';

              echo '<span class="color color-0"></span>';
              echo '<span class="color color-1"></span>';
              echo '<span class="color color-2"></span>';
              echo '<span class="color color-3"></span>';
              echo '<span class="color color-4"></span>';
              echo '<span class="color color-5"></span>';

            echo '</li>';


            $class = false;
          }
        ?>

      </ul>

    </div>

  </div>

</div>
