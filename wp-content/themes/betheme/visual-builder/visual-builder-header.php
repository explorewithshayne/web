<?php
header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );
if ( ! defined( 'WP_ADMIN' ) ) {
	require_once __DIR__ . '/admin.php';
}

global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow,
	$update_title, $total_update_count, $parent_file;


// Catch plugins that include admin-header.php before admin.php completes.
if ( empty( $current_screen ) ) {
	set_current_screen();
}

get_admin_page_title();
$title = apply_filters('betheme_label', 'Be') .'Builder';

if ( is_network_admin() ) {
	/* translators: Network admin screen title. %s: Network title. */
	$admin_title = sprintf( __( 'Network Admin: %s' ), get_network()->site_name );
} elseif ( is_user_admin() ) {
	/* translators: User dashboard screen title. %s: Network title. */
	$admin_title = sprintf( __( 'User Dashboard: %s' ), get_network()->site_name );
} else {
	$admin_title = get_bloginfo( 'name' );
}

if ( $admin_title === $title ) {
	/* translators: Admin screen title. %s: Admin screen name. */
	$admin_title = sprintf( __( '%s &#8212; WordPress' ), $title );
} else {
	/* translators: Admin screen title. 1: Admin screen name, 2: Network or site name. */
	$admin_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; WordPress' ), $title, $admin_title );
}

if ( wp_is_recovery_mode() ) {
	/* translators: %s: Admin screen title. */
	$admin_title = sprintf( __( 'Recovery Mode &#8212; %s' ), $admin_title );
}

if( !empty($_GET['action']) && $_GET['action'] == 'mfn-live-builder' ){
	$admin_title = "BeBuilder | ".get_the_title($_GET['post']);
}

/**
 * Filters the title tag content for an admin page.
 *
 * @since 3.1.0
 *
 * @param string $admin_title The page title, with extra context added.
 * @param string $title       The original page title.
 */
$admin_title = apply_filters( 'admin_title', $admin_title, $title );

wp_user_settings();

_wp_admin_html_begin();

?>
<title><?php echo esc_html( $admin_title ); ?></title>
<?php

// favicon

if( mfn_opts_get('favicon-img' ) || ( ! has_site_icon() ) ){
	echo '<link rel="shortcut icon" href="'. esc_url(mfn_opts_get('favicon-img', get_theme_file_uri('/images/favicon.ico'))) .'" type="image/x-icon" />'."\n";
}

wp_enqueue_style( 'colors' );

do_action( 'admin_enqueue_scripts' );
do_action( 'admin_print_styles' );
do_action( 'admin_print_scripts' );
do_action( 'admin_head' );

$body_classes = apply_filters( 'admin_body_class', '' );

if(is_rtl()) $body_classes .= ' rtl';
$body_classes .= ' mfn-preloader-active';
?>
</head>
<body class="<?php echo $body_classes; ?>">
