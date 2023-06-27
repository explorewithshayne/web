<?php
	defined( 'ABSPATH' ) || exit;

	global $current_user;
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard" data-page="status">

	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<div class="mfn-wrapper">

		<?php
			// subheader
			$current = 'status';
			include_once get_theme_file_path('/functions/admin/templates/parts/subheader.php');
		?>

		<div class="mfn-dashboard-wrapper">

			<div class="mfn-row">

				<div class="row-column row-column-6">
					<div class="mfn-card mfn-shadow-1" data-card="system-status">

						<div class="card-header">
							<div class="card-title-group">
								<span class="card-icon mfn-icon-card"></span>
								<div class="card-desc">
									<h4 class="card-title">Server environment</h4>
								</div>
							</div>
						</div>
						<div class="card-content">
							<ul class="system-status-list">

								<li>
									<span class="label"><?php esc_html_e('API server connection', 'mfn-opts') ?></span>
									<?php if ($this->status['version']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
										<span class="desc"><a href="admin.php?page=betheme&forcecheck"><?php esc_html_e('check again', 'mfn-opts') ?></a></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="desc"><a href="admin.php?page=betheme&forcecheck"><?php esc_html_e('check again', 'mfn-opts') ?></a></span>
										<span class="status-notice status-error">Your server is blocking connection to API server <b>api.muffingroup.com</b><br />Please contact your hosting provider.<br /><a target="_blank" href="admin.php?page=betheme&forcecheck&be-debug">Debug informations</a></span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('PHP Version', 'mfn-opts'); ?></span>
									<?php if ($this->status['php']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
										<span class="desc">
											<span class="mfn-badge"><?php echo esc_html(PHP_VERSION); ?></span>
										</span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="desc">
											<span class="mfn-badge"><?php echo esc_html(PHP_VERSION); ?></span>
										</span>
										<span class="status-notice status-error">WordPress requires PHP version 7 or greater. <a target="_blank" href="https://wordpress.org/about/requirements/">Learn more</a></span>
									<?php endif; ?>
								</li>

								<?php if ( $this->data[ 'suhosin' ] ): ?>

									<li>
										<span class="label"><?php esc_html_e('SUHOSIN Installed', 'mfn-opts'); ?></span>
										<span class="status-icon mfn-icon-info-orange"></span>
										<span class="status-notice">Suhosin may need to be configured to increase its data submission limits.</span>
									</li>

								<?php else: ?>

									<li>
										<span class="label"><?php esc_html_e('PHP Memory Limit', 'mfn-opts'); ?></span>

										<?php if ( $this->status['memory_limit']): ?>

											<span class="status-icon mfn-icon-yes-green"></span>
											<span class="desc">
												<span class="mfn-badge"><?php echo esc_html(size_format($this->data['memory_limit'])); ?></span>
											</span>

										<?php else: ?>

											<?php if ($this->data['memory_limit'] < 134217728): ?>

												<span class="status-icon mfn-icon-no-red"></span>
												<span class="desc">
													<span class="mfn-badge"><?php echo esc_html(size_format($this->data['memory_limit'])); ?></span>
												</span>
												<span class="status-notice status-error">Minimum <strong>128 MB</strong> is required, <strong>256 MB</strong> is recommended. </span>

											<?php else: ?>

												<span class="status-icon mfn-icon-info-orange"></span>
												<span class="desc">
													<span class="mfn-badge"><?php echo esc_html(size_format($this->data['memory_limit'])); ?></span>
												</span>
												<span class="status-notice status-error">Current memory limit is OK, however <strong>256 MB</strong> is recommended. </span>

											<?php endif; ?>

										<?php endif; ?>
									</li>

									<li>
										<span class="label"><?php esc_html_e('PHP Time Limit', 'mfn-opts'); ?></span>

										<?php if ( $this->status['time_limit'] ): ?>

											<span class="status-icon mfn-icon-yes-green"></span>
											<span class="desc">
												<span class="mfn-badge"><?php echo esc_html($this->data['time_limit']); ?></span>
											</span>

										<?php else: ?>

											<?php if ($this->data['time_limit'] < 60): ?>

												<span class="status-icon mfn-icon-no-red"></span>
												<span class="desc">
													<span class="mfn-badge"><?php echo esc_html($this->data['time_limit']); ?></span>
												</span>
												<span class="status-notice status-error">Minimum <strong>60</strong> is required, <strong>180</strong> is recommended. </span>

											<?php else: ?>

												<span class="status-icon mfn-icon-info-orange"></span>
												<span class="desc">
													<span class="mfn-badge"><?php echo esc_html($this->data['time_limit']); ?></span>
												</span>
												<span class="status-notice status-error">Current time limit is OK, however <strong>180</strong> is recommended. </span>

											<?php endif; ?>

										<?php endif; ?>
									</li>

									<li>
										<span class="label"><?php esc_html_e('PHP Max Input Vars', 'mfn-opts'); ?></span>
										<?php if ($this->status['max_input_vars']): ?>
											<span class="status-icon mfn-icon-yes-green"></span>
											<span class="desc">
												<span class="mfn-badge"><?php echo esc_html($this->data['max_input_vars']); ?>
											</span>
										<?php else: ?>
											<span class="status-icon mfn-icon-no-red"></span>
											<span class="desc">
												<span class="mfn-badge"><?php echo esc_html($this->data['max_input_vars']); ?></span>
											</span>
											<span class="status-notice status-error">Minimum 5000 is required</span>
										<?php endif; ?>
									</li>

								<?php endif; ?>

								<li>
									<span class="label"><?php esc_html_e('cURL', 'mfn-opts'); ?></span>
									<?php if ($this->status['curl']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="status-notice status-error">Your server does not have <strong>cURL</strong> enabled. Please contact your hosting provider.</span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('DOMDocument', 'mfn-opts'); ?></span>
									<?php if ($this->status['dom']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="status-notice status-error">DOMDocument is required for WordPress Importer. Please contact your hosting provider.</span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('ZipArchive', 'mfn-opts') ?></span>
									<?php if ($this->status['zip']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="status-notice status-error">ZipArchive is required for pre-built websites and plugins installation. Please contact your hosting provider.</span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('Uploads folder writable', 'mfn-opts') ?></span>
									<?php if ($this->status['uploads']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="status-notice status-error">Uploads folder must be writable. Please set write permission to your wp-content/uploads folders</span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('.htaccess File Access', 'mfn-opts'); ?></span>
									<?php if ( $this->status['htaccess'] ): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="status-notice status-error">Access to .htaccess is required for <a target="_blank" href="admin.php?page=be-options#performance-general&cache">Cache</a>. Please contact your hosting provider.</span>
									<?php endif; ?>
								</li>

							</ul>

							<div class="mfn-alert ">
								<div class="alert-icon mfn-icon-information"></div>
								<div class="alert-content">
									<p>php.ini values are shown above. Real values may vary, please check your limits using <a target="_blank" href="http://php.net/manual/en/function.phpinfo.php">php_info()</a>
									</p>
								</div>
							</div>

						</div>

					</div>
				</div>

				<div class="row-column row-column-6">
					<div class="mfn-card mfn-shadow-1" data-card="system-status">

						<div class="card-header">
							<div class="card-title-group">
								<span class="card-icon mfn-icon-card"></span>
								<div class="card-desc">
									<h4 class="card-title">WordPress settings</h4>
								</div>
							</div>
						</div>

						<div class="card-content">
							<ul class="system-status-list short">

								<li class="url">
									<span class="label"><?php esc_html_e('Home URL', 'mfn-opts'); ?></span>
									<?php if ($this->status['https_home']): ?>
										<span class="desc"><?php echo esc_html($this->data['home']); ?></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="desc"><?php echo esc_html($this->data['home']); ?></span>
										<span class="status-notice status-error">Connection is not secure. Please use HTTPS.</span>
									<?php endif; ?>
								</li>

								<li class="url">
									<span class="label"><?php esc_html_e('Site URL', 'mfn-opts'); ?></span>
									<?php if ($this->status['siteurl'] && $this->status['https_site']): ?>
										<span class="desc"><?php echo esc_html($this->data['siteurl']); ?></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="desc"><?php echo esc_html($this->data['siteurl']); ?></span>
										<?php if ( ! $this->status['siteurl'] ): ?>
											<span class="status-notice status-error">Home URL host must be the same as Site URL host.</span>
										<?php else: ?>
											<span class="status-notice status-error">Connection is not secure. Please use HTTPS.</span>
										<?php endif; ?>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('WP Version', 'mfn-opts'); ?></span>
									<?php if ($this->status['wp_version']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
										<span class="desc">
											<span class="mfn-badge"><?php echo esc_html($this->data['wp_version']); ?></span>
										</span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="desc">
											<span class="mfn-badge"><?php echo esc_html($this->data['wp_version']); ?></span>
										</span>
										<span class="status-notice status-error">Please update WordPress to the latest version.</span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('WP File System', 'mfn-opts') ?></span>
									<?php if ($this->status['fs']): ?>
										<span class="status-icon mfn-icon-yes-green"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no-red"></span>
										<span class="status-notice status-error">File System access is required for pre-built websites and plugins installation. Please contact your hosting provider.</span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('WP Max Upload Size', 'mfn-opts'); ?></span>
									<span class="desc">
										<span class="mfn-badge"><?php echo esc_html($this->data['max_upload_size']); ?></span>
									</span>
								</li>

								<li class="secondary">
									<span class="label"><?php esc_html_e('WP Multisite', 'mfn-opts'); ?></span>
									<?php if ($this->data['multisite']): ?>
										<span class="status-icon mfn-icon-yes"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no"></span>
									<?php endif; ?>
								</li>

								<li class="secondary">
									<span class="label"><?php esc_html_e('WP Debug', 'mfn-opts'); ?></span>
									<?php if ($this->data['debug']): ?>
										<span class="status-icon mfn-icon-yes"></span>
									<?php else: ?>
										<span class="status-icon mfn-icon-no"></span>
									<?php endif; ?>
								</li>

								<li>
									<span class="label"><?php esc_html_e('Language', 'mfn-opts'); ?></span>
									<span class="desc"><?php printf('%s, text direction: %s', $this->data['language'], $this->data['rtl']); ?></span>
								</li>

								<li>
									<span class="label"><?php esc_html_e('Theme Version', 'mfn-opts'); ?></span>
									<span class="desc">
										<span class="mfn-badge"><?php echo esc_html(MFN_THEME_VERSION); ?></span>
									</span>
								</li>

								<?php if( ! empty($this->data['version_history']) ): ?>
									<li>
										<span class="label"><?php esc_html_e('Updates history', 'mfn-opts'); ?></span>
										<span class="desc">
											<?php
												foreach( array_reverse($this->data['version_history']) as $version ){
													echo '<span class="mfn-badge">'. $version['version'] .'</span> - '. date( get_option( 'date_format' ), $version['time'] ) .'<br />';
												}
											?>
										</span>
									</li>
								<?php endif; ?>

							</ul>
						</div>

					</div>
				</div>

			</div>

    </div>

		<?php
			// footer
			include_once get_theme_file_path('/functions/admin/templates/parts/footer.php');
		?>

	</div>

</div>
