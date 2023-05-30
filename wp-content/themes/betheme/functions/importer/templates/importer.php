<?php
	defined( 'ABSPATH' ) || exit;

  $classes = [];

  if( mfn_is_registered() ){
    $classes[] = 'mfn-registered';
    $step = 2;
  } else {
    $classes[] = 'mfn-unregistered';
  }

  $classes = implode(' ', $classes);
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard mfn-importer loading <?php echo $classes; ?>" data-page="websites" data-step="pre-built">

	<input type="hidden" name="mfn-setup-nonce" value="<?php echo wp_create_nonce( 'mfn-setup' ); ?>">
	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">
	<input type="hidden" name="mfn-tgmpa-nonce" value="<?php echo wp_create_nonce( 'tgmpa-install' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<footer class="mfn-footer">
    <a class="mfn-btn mfn-btn-blank setup-previous">Previous step</a>
    <ul>
      <li><a class="mfn-btn mfn-btn-blank btn-only-icon" target="_blank" href="https://support.muffingroup.com/" data-tooltip="Help Center"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-support"></span></span></a></li><li><a class="mfn-btn mfn-btn-blank btn-only-icon" target="_blank" href="https://support.muffingroup.com/changelog/" data-tooltip="Changelog"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-changelog"></span></span></a></li>
    </ul>
    <a class="mfn-btn mfn-btn-blue setup-next">Next step</a>
  </footer>

	<div id="websites" class="mfn-wrapper">

    <div class="mfn-dashboard-subheader">

    	<div class="subheader-title-group">
    		<span class="subheader-icon mfn-icon-websites"></span>
        <div class="subheader-desc">
          <ul class="subheader-breadcrumbs">
            <li><a href="admin.php?page=betheme">Betheme</a></li>
            <li>Pre-built websites</li>
          </ul>
          <h2 class="subheader-title">Pre-built websites</h2>
        </div>
      </div>

      <div class="subheader-addons subheader-search">

        <div class="search-wrapper">
          <div class="input-wrapper">
            <i class="search icon-search-line"></i>
            <i class="close icon-cancel-fine"></i>
            <input class="search" type="text" placeholder="Search for a website" autocomplete="off">
          </div>
        </div>

      </div>

    </div>

		<div class="mfn-dashboard-wrapper">

      <!-- Pre-built websites -->

      <div class="mfn-dashboard-card card-websites active" data-step="pre-built">

        <?php
          // do NOT delete, isotope ajax loaded websites image height fix
          $placeholder = get_theme_file_uri( '/functions/admin/setup/assets/images/placeholder.png' );
          echo '<img style="visibility:hidden;height:1px;oveflow:hidden" src="'. esc_url($placeholder) .'" alt=""/>';
        ?>

        <div class="websites-group clearfix">

          <aside class="filters">
            <div class="sidebar__inner">

              <div class="filters-group first">
                <h4>Layout</h4>
                <nav>
                  <ul class="layout" data-filter-group="layout">
                    <?php
                      foreach ($this->layouts as $key_layout => $layout) {
                        echo '<li data-count="'. $this->count['layouts'][$key_layout] .'" data-filter=".'. $key_layout .'"><a href="#">'. $layout .'</a></li>';
                      }
                     ?>
                  </ul>
                </nav>
              </div>

              <div class="filters-group second">
                <h4>Subject</h4>
                <nav>
                  <ul class="subject" data-filter-group="subject">
                    <?php
                      foreach ($this->categories as $key_category => $category) {
                        echo '<li data-count="'. $this->count['categories'][$key_category] .'" data-filter=".'. $key_category .'"><a href="#">'. $category .'</a></li>';
                      }
                    ?>
                  </ul>
                </nav>
              </div>

            </div>
          </aside>

          <section class="websites">

            <div class="results" data-count="<?php echo $this->count['all'];?>"><strong>All <?php echo $this->count['all'];?></strong> pre-built websites</div>

            <div class="websites-iso">
              <?php $this->the_websites( 0, $this->count['all'] ); ?>
            </div>

          </section>

        </div>

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

		</div>

		<?php
			// footer
			include_once get_theme_file_path('/functions/admin/templates/parts/footer.php');
		?>

	</div>

	<?php
		// modal: database reset confirm
		include_once get_theme_file_path('/functions/importer/templates/parts/modal-reset.php');
	?>

</div>
