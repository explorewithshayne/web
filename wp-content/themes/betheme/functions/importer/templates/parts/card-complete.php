<?php
	defined( 'ABSPATH' ) || exit;
?>

<!-- Complete -->

<div class="mfn-dashboard-card mfn-setup-card card-complete" data-step="complete">

  <div class="card-header">
    <h2>Complete setup</h2>
    <p>Import data selected in previous step, including all required plugins if necessary.</p>
  </div>

  <div class="card-content">

    <a class="mfn-btn mfn-btn-blue btn-large setup-complete">Start installation</a>

    <div class="card-columns">

      <div class="column left">
        <ul class="complete-steps">
          <li class="reset hidden" data-action="reset">Database reset</li>

          <?php
            foreach( $this->plugins as $plugin_key => $plugin ){
              $class = $plugin_key;

              if( empty( $plugin['action'] ) ){
                echo '<li class="plugin done '. esc_attr($class) .'" data-action="">Plugin: '. esc_attr($plugin['name']) .'</li>';
              } elseif( 'activate' == $plugin['action'] ){
                echo '<li class="plugin '. esc_attr($class) .'" data-plugin="'. esc_attr($plugin['slug']) .'" data-path="'. esc_attr($plugin['path']) .'" data-action="plugin-activate">Plugin: '. esc_attr($plugin['name']) .'</li>';
              } elseif( 'install' == $plugin['action'] ){
                echo '<li class="plugin '. esc_attr($class) .'" data-plugin="'. esc_attr($plugin['slug']) .'" data-page="'. apply_filters('betheme_slug', 'be') .'-tgmpa' .'" data-action="plugin-install">Plugin: '. esc_attr($plugin['name']) .'</li>';
              }

            }
          ?>

          <li class="download pre" data-action="download">Package download</li>
          <li class="content pre" data-action="content">Content</li>
          <li class="options" data-action="options">Theme Options</li>
          <li class="slider pre" data-action="slider">Slider</li>
          <li class="settings" data-action="settings">Site settings</li>

        </ul>
      </div>

      <div class="column right">
        <img class="website-image" src="https://muffingroup.com/betheme/assets/images/demos/theme.jpg" alt="Pre-built website"/>
      </div>

    </div>

  </div>

	<div class="card-hidden hidden">
		<?php // DO NOT delete this div, fallback for 524 timeout images on last screen ?>
		<span class="mfn-icon-yes-green"></span>
	</div>

</div>
