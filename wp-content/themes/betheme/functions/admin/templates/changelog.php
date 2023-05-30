<?php
	defined( 'ABSPATH' ) || exit;
?>

<div id="mfn-dashboard" class="mfn-ui mfn-dashboard" data-page="changelog">

	<input type="hidden" name="mfn-builder-nonce" value="<?php echo wp_create_nonce( 'mfn-builder-nonce' ); ?>">

	<?php
		// header
		include_once get_theme_file_path('/functions/admin/templates/parts/header.php');
	?>

	<div class="mfn-wrapper">

		<?php
			// subheader
			$current = 'changelog';
			include_once get_theme_file_path('/functions/admin/templates/parts/subheader.php');
		?>

		<div class="mfn-dashboard-wrapper">
			<div class="mfn-row">
				<div class="row-column row-column-12">

					<?php include get_theme_file_path('changelog.html'); ?>

					<a class="mfn-btn mfn-btn-fw" target="_blank" href="https://support.muffingroup.com/changelog/"><?php esc_html_e( 'See full changelog', 'mfn-opts' ); ?></a>

				</div>
			</div>
		</div>

		<?php
			// footer
			include_once get_theme_file_path('/functions/admin/templates/parts/footer.php');
		?>

	</div>

</div>
