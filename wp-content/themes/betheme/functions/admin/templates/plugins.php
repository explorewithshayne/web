<?php
	defined( 'ABSPATH' ) || exit;
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard" data-page="plugins">

	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<div class="mfn-wrapper">

		<?php
			// subheader
			$current = 'plugins';
			include_once get_theme_file_path('/functions/admin/templates/parts/subheader.php');
		?>

		<div class="mfn-dashboard-wrapper">

      <input type="hidden" name="mfn-setup-nonce" value="<?php echo wp_create_nonce( 'mfn-setup' ); ?>">
      <input type="hidden" name="mfn-tgmpa-nonce-install" value="<?php echo wp_create_nonce( 'tgmpa-install' ); ?>">
      <input type="hidden" name="mfn-tgmpa-nonce-update" value="<?php echo wp_create_nonce( 'tgmpa-update' ); ?>">

      <div class="mfn-alert ">
      	<div class="alert-icon mfn-icon-information"></div>
      	<div class="alert-content">
      		<p>
      			<strong>Server limits:</strong> if you are not sure about server's settings and limits, please activate necessary plugins only.
      		</p>
      	</div>
      </div>

      <div class="mfn-row">
      	<div class="row-column row-column-12">
      		<ul class="plugin-items-list">

            <?php
              foreach( $this->plugins as $plugin ){

								if( WHITE_LABEL && in_array( $plugin['slug'], ['becustom','mfn-header-builder'] ) ){
									continue;
								}

                $class = '';
                if( ! empty($plugin['deprecated']) ){
                  $class = 'deprecated';
                }

                echo '<li>';
          				echo '<div class="mfn-card mfn-shadow-1" data-card="plugin-item">';
          					echo '<div class="card-content '. esc_attr($class) .'">';

                      if( ! empty($plugin['premium']) ){
                        echo '<span class="premium-plugin mfn-icon-star" data-tooltip="Premium plugin"></span>';
                      }

          						echo '<div class="plugin-logo">';
                        if( ! empty($plugin['dark']) ){
                          echo '<img class="icon-light" src="'. get_theme_file_uri('/functions/admin/assets/svg/plugins/'. esc_attr($plugin['slug']) .'.svg') .'" alt="" />';
            							echo '<img class="icon-dark" src="'. get_theme_file_uri('/functions/admin/assets/svg/_dark/plugins/'. esc_attr($plugin['slug']) .'.svg') .'" alt="" />';
                        } else {
                          echo '<img src="'. get_theme_file_uri('/functions/admin/assets/svg/plugins/'. esc_attr($plugin['slug']) .'.svg') .'" alt="" />';
                        }
          						echo '</div>';

          						echo '<h4>'. esc_html($plugin['name']) .'</h4>';

                      echo '<p class="source">'. $plugin['desc'] .'</p>';

                      echo '<div class="plugin-options">';

												echo '<span>';
													if( ! empty($plugin['version']) ){
														echo 'Version: <span class="mfn-badge">'. esc_attr($plugin['version']) .'</span>';
													}
												echo '</span>';

												if( ! empty($plugin['premium']) && ! mfn_is_registered() ){
													echo '<a class="mfn-btn mfn-btn-red" href="admin.php?page=betheme"><span class="btn-wrapper">Register</span></a>';
												} elseif( 'update' == $plugin['action'] ){
                          echo '<a data-plugin="'. esc_attr($plugin['slug']) .'" data-page="be-tgmpa" data-path="'. esc_attr($plugin['path']) .'" class="mfn-btn mfn-btn-blue plugin-update" href="#"><span class="btn-wrapper">Update</span></a>';
												} elseif( empty( $plugin['action'] ) ){
                          echo '<a data-plugin="'. esc_attr($plugin['slug']) .'" data-page="be-tgmpa" class="mfn-btn disabled"><span class="btn-wrapper">Active</span></a>';
                        } elseif( 'activate' == $plugin['action'] ){
                          echo '<a data-plugin="'. esc_attr($plugin['slug']) .'" data-page="be-tgmpa" data-path="'. esc_attr($plugin['path']) .'" class="mfn-btn mfn-btn-green plugin-activate" href="#"><span class="btn-wrapper">Activate</span></a>';
                        } elseif( 'install' == $plugin['action'] ){
                          echo '<a data-plugin="'. esc_attr($plugin['slug']) .'" data-page="be-tgmpa" class="mfn-btn mfn-btn-green plugin-install" href="#"><span class="btn-wrapper">Install</span></a>';
                        }

          						echo '</div>';

          					echo '</div>';
          				echo '</div>';
          			echo '</li>';
              }
            ?>

      		</ul>
      	</div>
      </div>

		</div>

		<?php
			// footer
			include_once get_theme_file_path('/functions/admin/templates/parts/footer.php');
		?>

	</div>

</div>
