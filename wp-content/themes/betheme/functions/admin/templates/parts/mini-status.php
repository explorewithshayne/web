<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>

<?php
	global $wpdb;

	require_once(get_theme_file_path('/functions/admin/class-mfn-helper.php'));
	$this->wp_filesystem = Mfn_Helper::filesystem();

	$htaccess_path = get_home_path() .'.htaccess';

	$data = array(
		'wp_uploads' 			=> wp_get_upload_dir(),

		'php'							=> phpversion(),
		'mysql'						=> $wpdb->db_version(),
		'memory_limit' 		=> wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) ),
		'time_limit' 			=> ini_get( 'max_execution_time' ),
		'max_input_vars' 	=> ini_get( 'max_input_vars' ),
		'max_upload_size'	=> size_format( wp_max_upload_size() ),

		'home'						=> home_url(),
		'siteurl'					=> get_option( 'siteurl' ),
		'wp_version'			=> get_bloginfo( 'version' ),
		'multisite'				=> is_multisite(),
		'debug'						=> defined( 'WP_DEBUG' ) && WP_DEBUG,
		'language'				=> get_locale(),
		'rtl'							=> is_rtl() ? 'RTL' : 'LTR',
		'suhosin'					=> extension_loaded( 'suhosin' ),
	);

	$status = array(
		'version' 				=> $this->version > 0,
		'uploads'					=> wp_is_writable($data['wp_uploads']['basedir']),
		'fs'							=> (Mfn_Helper::filesystem() || WP_Filesystem()) ? true : false,
		'zip'							=> class_exists( 'ZipArchive' ),
		'php'							=> version_compare( PHP_VERSION, '7.0' ) >= 0,

		'memory_limit'		=> $data['memory_limit'] >= 268435456,
		'time_limit'			=> ( ( $data['time_limit'] >= 180 ) || ( $data['time_limit'] == 0 ) ),
		'max_input_vars'	=> $data['max_input_vars'] >= 5000,
		'curl'						=> extension_loaded( 'curl' ),
		'dom'							=> class_exists( 'DOMDocument' ),
		'htaccess'				=> $this->wp_filesystem->is_writable($htaccess_path) && $this->wp_filesystem->is_readable($htaccess_path),

		'siteurl'					=> false,
		'https'						=> true,
		'wp_version'			=> version_compare( get_bloginfo( 'version' ), '5.0' ) >= 0,
	);

	$parse = array(
		'home' 		=> parse_url( $data['home'] ),
		'siteurl' => parse_url( $data['siteurl'] ),
	);

	if( isset( $parse['home']['host'] ) && isset( $parse['siteurl']['host'] ) ){
		if( $parse['home']['host'] == $parse['siteurl']['host'] ){
			$status['siteurl'] = true;
		}
	} elseif( isset( $parse['home']['path'] ) && isset( $parse['siteurl']['path'] ) ){
		if( $parse['home']['path'] == $parse['siteurl']['path'] ){
			$status['siteurl'] = true;
		}
	}

	// HTTPS

	if( isset( $parse['home']['scheme'] ) && 'https' != $parse['home']['scheme'] ){
		$status['https'] = false;
	}
	if( isset( $parse['siteurl']['scheme'] ) && 'https' != $parse['siteurl']['scheme'] ){
		$status['https'] = false;
	}

	// count errors

	$errors = 0;
	$result = 'ok';

	foreach( $status as $k => $v ){
		if( !$v ){
			$errors++;
		}
	}

	if( $errors ){
		$result = 'wrong';
	}
?>

<div class="mfn-card mfn-shadow-1" data-card="system-status-mini">

	<div class="card-header">
		<div class="card-title-group">
			<span class="card-icon mfn-icon-system-status"></span>
			<div class="card-desc">
				<h4 class="card-title">System status</h4>
			</div>
		</div>
	</div>

	<div class="card-content">
		<div class="mfn-icon-box <?php echo $result; ?>">
			<span class="icon-wrapper"></span>
			<div class="desc-wrapper">
				<h6 class="heading">Server configuration</h6>
				<p><span class="mfn-badge"><?php echo $errors; ?></span><?php echo _n( 'problem found', 'problems found', $errors, 'mfn-opts' ); ?></p>
			</div>
			<div class="link-wrapper">
				<a href="admin.php?page=be-status">Check</a>
			</div>
		</div>
	</div>

</div>
