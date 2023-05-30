<?php
	defined( 'ABSPATH' ) || exit;

	// registered

	if( mfn_is_registered() ){
		$registered = 'registered';
	} else {
		$registered = 'unregistered';
	}

	// theme support

	$disable = mfn_opts_get('theme-disable');
?>

<header class="mfn-dashboard-menu">

	<?php
		$logo = '<div class="logo '. $registered .'"></div>';

		if( ! WHITE_LABEL ){
			echo apply_filters('betheme_logo', $logo);
		}
	?>

	<div class="menu-wrapper">

		<ul class="dashboard-menu">
			<li data-page="dashboard"><a href="admin.php?page=<?php echo apply_filters('betheme_dynamic_slug', 'betheme'); ?>"><span class="mfn-icon mfn-icon-dashboard"></span>Dashboard</a></li>
			<li data-page="plugins"><a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-plugins"><span class="mfn-icon mfn-icon-plugins"></span>Plugins</a></li>

			<?php if( ! WHITE_LABEL && ! isset($disable['demo-data']) ): ?>
			<li data-page="websites"><a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-websites"><span class="mfn-icon mfn-icon-websites"></span>Websites</a></li>
			<?php endif; ?>

			<li data-page="templates"><a href="edit.php?post_type=template"><span class="mfn-icon mfn-icon-templates"></span>Templates</a></li>
			<li data-page="options"><a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-options"><span class="mfn-icon mfn-icon-theme-options"></span>Options</a></li>
			<li>
				<a><span class="mfn-icon mfn-icon-maintenance"></span>Other</a>
				<ul>
					<?php if( ! WHITE_LABEL && ! isset($disable['demo-data']) ): ?>
					<li>
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-setup">
							<span class="mfn-icon mfn-icon-setup-wizzard"></span>
							<div class="inner-link">
								<span class="label">Setup Wizard</span>
								<span class="desc">Configure your website</span>
							</div>
						</a>
					</li>
					<?php endif; ?>
					<li data-page="status">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-status">
							<span class="mfn-icon mfn-icon-system-status"></span>
							<div class="inner-link">
								<span class="label">System status</span>
								<span class="desc">Check your server config</span>
							</div>
						</a>
					</li>
					<?php if( ! WHITE_LABEL && ! apply_filters('betheme_disable_support', false) ): ?>
					<li data-page="support">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-support">
							<span class="mfn-icon mfn-icon-support"></span>
							<div class="inner-link">
								<span class="label">Manual & Support</span>
								<span class="desc">Need help? We are here for you!</span>
							</div>
						</a>
					</li>
					<?php endif; ?>
					<?php if( ! WHITE_LABEL && ! apply_filters('betheme_disable_changelog', false) ): ?>
					<li data-page="changelog">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-changelog">
							<span class="mfn-icon mfn-icon-changelog"></span>
							<div class="inner-link">
								<span class="label">Changelog</span>
								<span class="desc">See what's new</span>
							</div>
						</a>
					</li>
					<?php endif; ?>
					<?php if( ! WHITE_LABEL ): ?>
					<li data-page="tools">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-tools">
							<span class="mfn-icon mfn-icon-settings"></span>
							<div class="inner-link">
								<span class="label">Tools</span>
								<span class="desc">Miscellaneous stuff for managing</span>
							</div>
						</a>
					</li>
					<?php endif; ?>
				</ul>
			</li>
		</ul>

	</div>

	<?php
		if( ! empty($is_theme_options) ){
			echo '<a class="mfn-option-btn btn-large mfn-option-blank responsive-menu" href="#"><span class="mfn-icon mfn-icon-menu"></span></a>';
		}
	?>

	<a class="mfn-option-btn btn-large mfn-option-blank mfn-color-scheme">
		<i class="icon-moon dark"></i>
		<i class="icon-light-up light"></i>
	</a>

</header>
