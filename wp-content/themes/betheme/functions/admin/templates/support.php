<?php
	defined( 'ABSPATH' ) || exit;
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard" data-page="support">

	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<div class="mfn-wrapper">

		<?php
			// subheader
			$current = 'support';
			include_once get_theme_file_path('/functions/admin/templates/parts/subheader.php');
		?>

		<div class="mfn-dashboard-wrapper">

			<div class="mfn-row">

				<div class="row-column row-column-8">

					<div class="mfn-card mfn-shadow-1" data-card="video">
						<div class="card-content">
							<iframe width="711" height="400" src="https://www.youtube.com/embed/MkeTBSMQEIE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>

					<div class="mfn-card mfn-shadow-1" data-card="last-videos">

						<div class="card-header">
							<div class="card-title-group">
								<span class="card-icon mfn-icon-card"></span>
								<div class="card-desc">
									<h4 class="card-title">Introductory videos</h4>
								</div>
							</div>
							<div class="card-links-group">
								<a target="_blank" href="https://support.muffingroup.com/video-tutorials/">
									<span class="mfn-icon mfn-icon-layout-grid"></span> See all video tutorials </a>
							</div>
						</div>

						<div class="card-content">
							<ul class="last-videos-list">
								<li>
									<a href="https://www.youtube.com/watch?v=fj1_NO8meJQ" class="lightbox">
										<img src="https://support.muffingroup.com/wp-content/uploads/2022/07/header-builder-2.webp" alt="" />
										<i class="fab fa-youtube play-icon"></i>
									</a>
									<h5>Header Builder 2.0</h5>
								</li>
								<li>
									<a href="https://www.youtube.com/watch?v=qDabDsmoct4" class="lightbox">
										<img src="https://support.muffingroup.com/wp-content/uploads/2022/07/footer-builder.webp" alt="" />
										<i class="fab fa-youtube play-icon"></i>
									</a>
									<h5>Footer Builder</h5>
								</li>
								<li>
									<a href="https://www.youtube.com/watch?v=AvIN8hfomBc" class="lightbox">
										<img src="https://support.muffingroup.com/wp-content/uploads/2022/07/mega-menu-builder.webp" alt="" />
										<i class="fab fa-youtube play-icon"></i>
									</a>
									<h5>Building Mega Menus</h5>
								</li>
								<li>
									<a href="https://www.youtube.com/watch?v=8gRTpdSHF9U" class="lightbox">
										<img src="https://support.muffingroup.com/wp-content/uploads/2022/03/responsive-editing.webp" alt="" />
										<i class="fab fa-youtube play-icon"></i>
									</a>
									<h5>Responsive Editing</h5>
								</li>
							</ul>
						</div>

					</div>

					<div class="mfn-card mfn-shadow-1" data-card="support-info">
						<div class="card-content">
							<div class="mfn-row">
								<div class="row-column row-column-6 support-item">
									<span class="support-icon mfn-icon-yes-green"></span>
									<h5>Item support <span class="include">includes</span>: </h5>
									<p>Responding to questions or problems regarding the item and its features.</p>
									<p>Fixing bugs and reported issues.</p>
									<p>Providing updates to ensure compatibility with new WordPress versions.</p>
								</div>
								<div class="row-column row-column-6 support-item">
									<span class="support-icon mfn-icon-no-red"></span>
									<h5>Item support does <span class="include">not include</span>: </h5>
									<p>Customization and installation services.</p>
									<p>Support for third party software and plugins.</p>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="row-column row-column-4">

					<div class="mfn-card mfn-shadow-1" data-card="create-a-ticket">
						<div class="card-content">
							<h3>Can't find <br /> what you need? </h3>
							<p>Submit a ticket and get help.</p>
							<a target="_blank" class="mfn-btn" href="https://forum.muffingroup.com/betheme/">
								<span class="btn-wrapper">Create a ticket</span>
							</a>
						</div>
					</div>

					<div class="mfn-card mfn-shadow-1" data-card="support-center">
						<div class="card-content">
							<div class="mfn-icon-box">
								<div class="image-wrapper">
									<img class="icon-light" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg//support-center.svg'); ?>" alt="" />
									<img class="icon-dark" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/_dark/support-center.svg'); ?>" alt="" />
								</div>
								<div class="desc-wrapper">
									<h5 class="heading">Support Center</h5>
									<p>Have a problem? <br> Let us help you solve it!</p>
									<a target="_blank" href="https://support.muffingroup.com/">Go to Center</a>
								</div>
							</div>
						</div>
					</div>

					<div class="mfn-card mfn-shadow-1" data-card="support-documentation">
						<div class="card-content">
							<div class="mfn-icon-box">
								<div class="image-wrapper">
									<img class="icon-light" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg//support-docs.svg'); ?>" alt="" />
									<img class="icon-dark" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/_dark/support-docs.svg'); ?>" alt="" />
								</div>
								<div class="desc-wrapper">
									<h5 class="heading">Documentation</h5>
									<p>BeTheme Options & Features step by step guidebook.</p>
									<a target="_blank" href="https://support.muffingroup.com/documentation/">Go to Docs</a>
								</div>
							</div>
						</div>
					</div>

					<div class="mfn-card mfn-shadow-1" data-card="support-forum">
						<div class="card-content">
							<div class="mfn-icon-box">
								<div class="image-wrapper">
									<img class="icon-light" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg//support-forum.svg'); ?>" alt="" />
									<img class="icon-dark" src="<?php echo get_theme_file_uri('/functions/admin/assets/svg/_dark/support-forum.svg'); ?>" alt="" />
								</div>
								<div class="desc-wrapper">
									<h5 class="heading">Support Forum</h5>
									<p>Submit a ticket and receive an answer in no time.</p>
									<a target="_blank" href="https://forum.muffingroup.com/betheme/">Go to Forum</a>
								</div>
							</div>
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
