<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>
<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-message alert alert_success"<?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
		<div class="alert_icon"><svg viewBox="0 0 28 28" aria-hidden="true"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><polyline points="8.07 13 12.36 18.29 19.93 9.71" class="path"/><circle cx="14" cy="14" r="12" class="path"/></g></svg></div>
		<div class="alert_wrapper">
			<?php echo wc_kses_notice( str_replace( 'button wc-forward', 'wc-forward', $notice['notice'] ) ); ?>
		</div>
		<a href="#" class="close mfn-close-icon"><span class="icon">✕</span></a>
	</div>
<?php endforeach; ?>
