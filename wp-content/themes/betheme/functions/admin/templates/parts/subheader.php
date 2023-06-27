<?php
	defined( 'ABSPATH' ) || exit;

	global $current_user;

	$is_custom_subheader = apply_filters('betheme_dashboard_subheader', 'filter_me') !== 'filter_me';

  $pages = [
    'dashboard' => [
      'title' => 'Welcome '. $current_user->display_name,
      'icon' => '',
      'breadcrumbs' => '<li>Dashboard</li>',
    ],
    'changelog' => [
      'title' => 'Changelog',
      'icon' => '<span class="subheader-icon mfn-icon-changelog"></span>',
      'breadcrumbs' => '<li><a href="admin.php?page=betheme">Betheme</a></li><li>Changelog</li>',
    ],
    'plugins' => [
      'title' => 'Plugins',
      'icon' => '<span class="subheader-icon mfn-icon-plugins"></span>',
      'breadcrumbs' => '<li><a href="admin.php?page=betheme">Betheme</a></li><li>Plugins</li>',
    ],
    'status' => [
      'title' => 'System status',
      'icon' => '<span class="subheader-icon mfn-icon-system-status"></span>',
      'breadcrumbs' => '<li><a href="admin.php?page=betheme">Betheme</a></li><li>System status</li>',
    ],
    'support' => [
      'title' => 'Manual & Support',
      'icon' => '<span class="subheader-icon mfn-icon-support"></span>',
      'breadcrumbs' => '<li><a href="admin.php?page=betheme">Betheme</a></li><li>Manual & Support</li>',
    ],
    'tools' => [
      'title' => 'Tools',
      'icon' => '<span class="subheader-icon mfn-icon-settings"></span>',
      'breadcrumbs' => '<li><a href="admin.php?page=betheme">Betheme</a></li><li>Tools</li>',
    ],
    'websites' => [
      'title' => 'Pre-built websites',
      'icon' => '<span class="subheader-icon mfn-icon-websites"></span>',
      'breadcrumbs' => '<li><a href="admin.php?page=betheme">Betheme</a></li><li>Pre-built websites</li>',
    ],
  ];

  // dashboard

  if( get_option('show_avatars') == 1 && get_option('avatar_default') != 'blank' ){
    $pages['dashboard']['icon'] = '<span class="subheader-icon">'. get_avatar( $current_user->ID, 72 ) .'</span>';
  } else {
    $pages['dashboard']['icon'] =  '<span class="subheader-icon mfn-icon-clients"></span>';
  }
?>

<div class="mfn-dashboard-subheader">

	<?php if( $is_custom_subheader ): ?>

  	<?php echo apply_filters('betheme_dashboard_subheader', ''); ?>
		
  <?php else: ?>

		<div class="subheader-title-group">
			<?php echo $pages[$current]['icon']; ?>
	    <div class="subheader-desc">
				<?php if( ! WHITE_LABEL ): ?>
	      <ul class="subheader-breadcrumbs">
	        <?php echo $pages[$current]['breadcrumbs']; ?>
	      </ul>
				<?php endif; ?>
	      <h2 class="subheader-title"><?php echo $pages[$current]['title']; ?></h2>
	    </div>
	  </div>

	  <div class="subheader-addons">

			<?php if( ! apply_filters('betheme_disable_theme_version', MFN_THEME_VERSION) ): ?>

			<?php elseif( mfn_is_registered() && version_compare( $this->version, MFN_THEME_VERSION, '>' )): ?>

				<a href="update-core.php" class="mfn-icon-box version-info update">
	        <span class="icon-wrapper mfn-icon-notification mfn-animation-shake"></span>
	        <div class="desc-wrapper">
	          <h5 class="heading"><?php esc_html_e( 'New version available', 'mfn-opts' ); ?></h5>
	          <p><?php esc_html_e( 'Update to', 'mfn-opts' ); ?> <?php echo esc_html( $this->version ); ?></p>
	        </div>
	      </a>

			<?php elseif( mfn_is_registered() ): ?>

				<div class="mfn-icon-box version-info">
	        <span class="icon-wrapper mfn-icon-check"></span>
	        <div class="desc-wrapper">
	          <h5 class="heading"><?php esc_html_e( 'Theme is up to date', 'mfn-opts' ); ?></h5>
	          <p><?php esc_html_e( 'Your version', 'mfn-opts' ); ?> <?php echo esc_html( MFN_THEME_VERSION ); ?></p>
	        </div>
	      </div>

			<?php else: ?>

				<a href="admin.php?page=betheme" class="mfn-icon-box version-info update">
	        <span class="icon-wrapper mfn-icon-password"></span>
	        <div class="desc-wrapper">
	          <h5 class="heading"><?php esc_html_e( 'Register to get updates', 'mfn-opts' ); ?></h5>
	          <p><?php esc_html_e( 'Your version', 'mfn-opts' ); ?> <?php echo esc_html( MFN_THEME_VERSION ); ?></p>
	        </div>
	      </a>

			<?php endif; ?>

	  </div>

	<?php endif; ?>

</div>
