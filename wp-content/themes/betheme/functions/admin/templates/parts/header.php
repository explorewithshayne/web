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
			<li data-page="dashboard"><a href="admin.php?page=<?php echo apply_filters('betheme_dynamic_slug', 'betheme'); ?>"><span class="mfn-icon mfn-icon-dashboard"></span><?php _e('Dashboard','mfn-opts'); ?></a></li>
			<li data-page="plugins"><a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-plugins"><span class="mfn-icon mfn-icon-plugins"></span><?php _e('Plugins','mfn-opts'); ?></a></li>

			<?php if( ! WHITE_LABEL && ! isset($disable['demo-data']) ): ?>
			<li data-page="websites"><a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-websites"><span class="mfn-icon mfn-icon-websites"></span><?php _e('Websites','mfn-opts'); ?></a></li>
			<?php endif; ?>

			<li data-page="templates"><a href="edit.php?post_type=template"><span class="mfn-icon mfn-icon-templates"></span><?php _e('Templates','mfn-opts'); ?></a></li>
			<li data-page="options"><a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-options"><span class="mfn-icon mfn-icon-theme-options"></span><?php _e('Options','mfn-opts'); ?></a></li>
			<li>
				<a><span class="mfn-icon mfn-icon-maintenance"></span><?php _e('Other','mfn-opts'); ?></a>
				<ul>
					<?php if( ! WHITE_LABEL && ! isset($disable['demo-data']) ): ?>
					<li>
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-setup">
							<span class="mfn-icon mfn-icon-setup-wizzard"></span>
							<div class="inner-link">
								<span class="label"><?php _e('Setup Wizard','mfn-opts'); ?></span>
								<span class="desc"><?php _e('Configure your website','mfn-opts'); ?></span>
							</div>
						</a>
					</li>
					<?php endif; ?>
					<li data-page="status">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-status">
							<span class="mfn-icon mfn-icon-system-status"></span>
							<div class="inner-link">
								<span class="label"><?php _e('System status','mfn-opts'); ?></span>
								<span class="desc"><?php _e('Check your server config','mfn-opts'); ?></span>
							</div>
						</a>
					</li>
					<?php if( ! WHITE_LABEL && ! apply_filters('betheme_disable_support', false) ): ?>
					<li data-page="support">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-support">
							<span class="mfn-icon mfn-icon-support"></span>
							<div class="inner-link">
								<span class="label"><?php _e('Manual & Support','mfn-opts'); ?></span>
								<span class="desc"><?php _e('Need help? We are here for you!','mfn-opts'); ?></span>
							</div>
						</a>
					</li>
					<?php endif; ?>
					<?php if( ! WHITE_LABEL && ! apply_filters('betheme_disable_changelog', false) ): ?>
					<li data-page="changelog">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-changelog">
							<span class="mfn-icon mfn-icon-changelog"></span>
							<div class="inner-link">
								<span class="label"><?php _e('Changelog','mfn-opts'); ?></span>
								<span class="desc"><?php _e('See what\'s new','mfn-opts'); ?></span>
							</div>
						</a>
					</li>
					<?php endif; ?>
					<?php if( ! WHITE_LABEL ): ?>
					<li data-page="tools">
						<a href="admin.php?page=<?php echo apply_filters('betheme_slug', 'be'); ?>-tools">
							<span class="mfn-icon mfn-icon-settings"></span>
							<div class="inner-link">
								<span class="label"><?php _e('Tools','mfn-opts'); ?></span>
								<span class="desc"><?php _e('Miscellaneous stuff for managing','mfn-opts'); ?></span>
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
