<?php
	defined( 'ABSPATH' ) || exit;

	global $current_user;
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard" data-page="dashboard">

	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<div class="mfn-wrapper">

		<?php
			// subheader
			$current = 'dashboard';
			include_once get_theme_file_path('/functions/admin/templates/parts/subheader.php');
		?>

		<div class="mfn-dashboard-wrapper">

			<?php if( ! mfn_is_registered() ): ?>

				<div class="mfn-row">

					<div class="row-column row-column-8">

						<div class="mfn-card mfn-shadow-1" data-card="theme-register">

							<div class="card-header">
								<div class="card-title-group">
									<span class="card-icon mfn-icon-register-light"></span>
									<div class="card-desc">
										<h4 class="card-title">Theme Registration</h4>
									</div>
								</div>
								<?php if( ! WHITE_LABEL ): ?>
								<div class="card-links-group">
									<a href="#" class="data-collection" data-modal="data-collection"><span class="mfn-icon mfn-icon-support-light"></span> Data collection</a>
									<a target="_blank" href="https://api.muffingroup.com/licenses/"><span class="mfn-icon mfn-icon-folder-open-light"></span> Check your licenses</a>
								</div>
								<?php endif; ?>
							</div>

							<div class="card-content">
								<form class="form-register mfn-form mfn-form-reg" method="post">

									<input type="hidden" name="mfn-setup-nonce" value="<?php echo wp_create_nonce( 'mfn-setup-register' ); ?>">
					        <input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">
					        <input type="hidden" name="action" value="mfn_setup_register">
					        <input type="submit" name="submit" value="mfn_setup_register" style="display:none">

									<div class="form-register-input">

										<span class="mfn-icon mfn-icon-password-light"></span>
										<input type="text" name="code" placeholder="Paste your purchase code here" class="mfn-form-control of-input" size="36">

										<div class="mfn-tooltip-box where-is">
											<a>Where is code?</a>
											<div class="tooltip-box-inner">
												<p><strong>Where can I find my purchase code?</strong></p>
												<ol>
													<li>Please go to <a target="_blank" href="https://themeforest.net/downloads">ThemeForest.net/downloads</a></li>
													<li>Click the <strong>Download</strong> button in Betheme row</li>
													<li>Select <strong>License Certificate &amp; Purchase code</strong></li>
													<li>Copy <strong>Item Purchase Code</strong></li>
												</ol>
											</div>
										</div>

										<span class="form-message">aaa</span>

									</div>

									<a id="register" class="mfn-btn mfn-btn-fw mfn-btn-green"><span class="btn-wrapper">Register theme</span></a>

								</form>

								<?php
									// new license
									include get_theme_file_path('/functions/admin/templates/parts/new-license.php');
								?>

							</div>
						</div>

					</div>

					<div class="row-column row-column-4">

						<?php
							// mini system status
							include get_theme_file_path('/functions/admin/templates/parts/mini-status.php');

							// suggestion
							include get_theme_file_path('/functions/admin/templates/parts/suggestion.php');
						?>

					</div>

				</div>

			<?php endif; ?>

			<?php if( ! WHITE_LABEL ): ?>

      <div class="mfn-row">

        <div class="row-column row-column-4">
          <div class="mfn-card mfn-shadow-1" data-card="setup-wizard">
            <div class="card-content">
              <h3>Step by step<br /> website creator</h3>
              <p>Let us guide you through this process. Promise, it won't take more than a couple of seconds.</p>
              <a class="mfn-btn" href="admin.php?page=be-setup"><span class="btn-wrapper">Let’s get started</span></a>
            </div>
          </div>
        </div>

        <div class="row-column row-column-8">
          <div class="mfn-card mfn-shadow-1" data-card="news-carousel">
            <div class="card-content">
              <!-- <ul class="slider-promo">
                <li><a href="#"><img src="https://api.muffingroup.com/promo/images/26.jpg" alt="" /></a></li>
                <li><a href="#"><img src="https://api.muffingroup.com/promo/images/26.jpg" alt="" /></a></li>
              </ul> -->
							<?php $this->promo(); ?>
            </div>
          </div>
        </div>

      </div>

			<?php endif; ?>

			<?php
				// latest websites
				include_once get_theme_file_path('/functions/admin/templates/parts/websites.php');
			?>

			<?php if( mfn_is_registered() ): ?>

				<div class="mfn-row">

					<div class="row-column row-column-8">

						<div class="mfn-card mfn-shadow-1" data-card="theme-register">

							<div class="card-header">
								<div class="card-title-group">
									<span class="card-icon mfn-icon-register-light"></span>
									<div class="card-desc">
										<h4 class="card-title">Theme Registration</h4>
									</div>
								</div>
								<div class="card-links-group">
									<a href="#" class="data-collection" data-modal="data-collection"><span class="mfn-icon mfn-icon-support-light"></span> Data collection</a>
									<a target="_blank" href="https://api.muffingroup.com/licenses/"><span class="mfn-icon mfn-icon-folder-open-light"></span> Check your licenses</a>
								</div>
							</div>

							<div class="card-content">

								<form class="form-register mfn-form" method="post">
									<div class="form-register-input">

										<span class="mfn-icon mfn-icon-password-light"></span>
										<input type="text" value="<?php echo esc_html( mfn_get_purchase_code_hidden() ); ?>" class="mfn-form-control of-input" size="36" readonly="readonly">

										<a id="deregister" class="mfn-btn mfn-btn-green deregister-theme"><span class="btn-wrapper">Deregister theme</span></a>

									</div>
								</form>

								<?php
									// new license
									include get_theme_file_path('/functions/admin/templates/parts/new-license.php');
								?>

							</div>

						</div>

					</div>

					<div class="row-column row-column-4">

						<?php
							// mini system status
							include get_theme_file_path('/functions/admin/templates/parts/mini-status.php');

							// suggestion
							include get_theme_file_path('/functions/admin/templates/parts/suggestion.php');
						?>

					</div>

				</div>

			<?php endif; ?>

			<?php if( ! WHITE_LABEL ): ?>

			<div class="mfn-row">
				<div class="row-column row-column-12">

					<div class="mfn-card mfn-shadow-1" data-card="integrations">
						<div class="card-header">
							<div class="card-title-group">
								<span class="card-icon mfn-icon-plugins"></span>
								<div class="card-desc">
									<h4 class="card-title">Betheme integrations</h4>
								</div>
							</div>
						</div>
						<div class="card-content">
							<div class="mfn-row">
								<div class="row-column row-column-4 plugin-item">
									<img class="icon-light" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/plugins/integration-hubspot.svg'); ?>" alt="HubSpot" />
									<img class="icon-dark" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/_dark/plugins/integration-hubspot.svg'); ?>" alt="HubSpot" />
									<h5>CRM, Marketing and Sales</h5>
									<p>CRM platform contains the marketing, sales, service, operations, and website-building software you need to grow your business.</p>
									<a class="mfn-btn btn-wide" target="_blank" href="https://hubspot.sjv.io/c/1289117/1389270/12893">
										<span class="btn-wrapper">Sign up for free</span>
									</a>
								</div>
								<div class="row-column row-column-4 plugin-item">
									<img class="icon-light" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/plugins/integration-wpml.svg'); ?>" alt="WPML" />
									<img class="icon-dark" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/_dark/plugins/integration-wpml.svg'); ?>" alt="WPML" />
									<h5>Multilingual sites</h5>
									<p>Plugin that makes over a million WordPress sites multilingual. It’s powerful enough for corporate sites, yet simple for blogs.</p>
									<a class="mfn-btn btn-wide" target="_blank" href="https://wpml.org/?aid=29349&affiliate_key=aCEsSE0ka33p">
										<span class="btn-wrapper">Buy and download</span>
									</a>
								</div>
								<div class="row-column row-column-4 plugin-item">
									<img src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/plugins/integration-toolset.svg'); ?>" alt="Toolset" />
									<h5>Dynamic websites</h5>
									<p>Toolset helps WordPress professionals build advanced sites without programming. Everything you need in one package.</p>
									<a class="mfn-btn btn-wide" target="_blank" href="https://toolset.com/?aid=69517&affiliate_key=nDVNSTMzHjGg">
										<span class="btn-wrapper">Buy now</span>
									</a>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		<?php endif; ?>

    </div>

		<?php
			// footer
			include get_theme_file_path('/functions/admin/templates/parts/footer.php');
		?>

	</div>

	<!-- modal: data collection -->

  <div class="mfn-modal modal-medium modal-data-collection">
    <div class="mfn-modalbox mfn-form mfn-shadow-1">

			<div class="modalbox-header">

				<div class="options-group">
					<div class="modalbox-title-group">
						<span class="modalbox-icon mfn-icon-card"></span>
						<div class="modalbox-desc">
							<h4 class="modalbox-title"><?php esc_html_e('Data collection', 'mfn-opts'); ?></h4>
						</div>
					</div>
				</div>

				<div class="options-group">
					<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
				</div>

			</div>

			<div class="modalbox-content">

				<span class="mfn-icon mfn-icon-support"></span>
				<h3><?php esc_html_e('Data collection', 'mfn-opts'); ?></h3>

				<p>Betheme does not collect any personal data. However, we gather some basic information about your website to validate your license and product registration. These are:</p>

				<ul class="default">
					<li>The purchase code that was used for product registration</li>
					<li>The domain name that your website uses</li>
				</ul>

				<p>In order to serve and check for updates, from time to time, your WordPress installation establishes an anonymous connection to our servers.</p>

			</div>

    </div>

  </div>

</div>
