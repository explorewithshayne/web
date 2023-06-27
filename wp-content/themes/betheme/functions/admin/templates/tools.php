<?php
	defined( 'ABSPATH' ) || exit;
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard" data-page="tools">

	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<div class="mfn-wrapper">

		<?php
			// subheader
			$current = 'tools';
			include_once get_theme_file_path('/functions/admin/templates/parts/subheader.php');
		?>

		<div class="mfn-dashboard-wrapper">
			<div class="mfn-row">

				<div class="row-column row-column-4">

					<div class="mfn-card mfn-shadow-1" data-card="tool-item">
						<div class="card-content">
							<div class="tool-logo">
								<span class="local-css">Local <b>CSS</b>
								</span>
							</div>
							<p>Some BeBuilder styles are saved in CSS files in the uploads folder and database. Recreate those files and settings.</p>
							<a data-nonce="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>" data-action="mfn_regenerate_css" class="mfn-btn mfn-btn-fw tools-do-ajax" href="#">
								<span class="btn-wrapper"><?php esc_html_e( 'Regenerate files', 'mfn-opts' ); ?></span>
							</a>
						</div>
					</div>

				</div>

				<div class="row-column row-column-4">

					<div class="mfn-card mfn-shadow-1" data-card="tool-item">
						<div class="card-content">
							<div class="tool-logo">
								<span class="local-fonts">Local <b>Fonts</b>
								</span>
							</div>
							<p>You chose to Cache fonts local in <a target="_blank" href="admin.php?page=be-options#performance-general">Performance</a> tab. </p>
							<p>Please Regenerate fonts every time you change anything in <a target="_blank" href="admin.php?page=be-options#font-family">Fonts &gt; Family</a> tab. </p>
							<a data-nonce="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>" data-action="mfn_regenerate_fonts" href="#" class="mfn-btn mfn-btn-fw tools-do-ajax">
								<span class="btn-wrapper"><?php esc_html_e( 'Regenerate fonts', 'mfn-opts' ); ?></span>
							</a>
						</div>
					</div>

				</div>

				<div class="row-column row-column-4">

					<div class="mfn-card mfn-shadow-1" data-card="tool-item">
						<div class="card-content">
							<div class="tool-logo">
								<span class="delete-history">Delete <b>History</b>
								</span>
							</div>
							<p>Delete all BeBuilder history entries.</p>
							<a data-nonce="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>" data-action="mfn_history_delete" href="#" class="mfn-btn mfn-btn-fw tools-do-ajax confirm">
								<span class="btn-wrapper"><?php esc_html_e( 'Delete', 'mfn-opts' ); ?></span>
							</a>
						</div>
					</div>

				</div>

				<div class="row-column row-column-4">

					<div class="mfn-card mfn-shadow-1" data-card="tool-item">
						<div class="card-content">
							<div class="tool-logo">
								<span class="regenerate-thumbnails">Regenerate <b>Thumbnails</b>
								</span>
							</div>
							<p>Allows you to regenerate thumbnail sizes for all images that have been uploaded to your media library and <b>restore missing SVG images dimensions</b>.</p>
							<p>This is useful when you switch theme or import <a target="_blank" href="admin.php?page=be-websites">Pre-built Website</a>.</p>
							<a data-nonce="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>" data-action="mfn_regenerate_thumbnails" href="#" class="mfn-btn mfn-btn-fw mfn-regenerate-thumbnails">
								<span class="btn-wrapper"><?php esc_html_e( 'Regenerate thumbnails', 'mfn-opts' ); ?></span>
							</a>
						</div>
					</div>

				</div>

				<div class="row-column row-column-4">

					<div class="mfn-card mfn-shadow-1" data-card="tool-item">
						<div class="card-content">
							<div class="tool-logo">
								<span class="analyze-builder">Analyze <b>Builder</b> content
								</span>
							</div>
							<p>Prepare builder content in format readable for external plugins and post search</b>.</p>
							<p>This action does not need to be run again. It is performed automatically when saving a post.</p>
							<a data-nonce="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>" data-action="mfn_analyze_builder" class="mfn-btn mfn-btn-fw tools-do-ajax" href="#">
								<span class="btn-wrapper"><?php esc_html_e( 'Analyze content', 'mfn-opts' ); ?></span>
							</a>
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
