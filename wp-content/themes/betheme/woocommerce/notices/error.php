<?php
/**
 * Show error messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/error.php.
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
<div class="alert alert_error">
	<div class="alert_icon"><svg viewBox="0 0 28 28" aria-hidden="true"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><circle cx="14" cy="20" r="0.33" class="path"/><line x1="14" y1="8.72" x2="14" y2="16.72" class="path"/><path d="M12.6,3.42,1.54,22.58A1.61,1.61,0,0,0,2.93,25H25.07a1.61,1.61,0,0,0,1.39-2.42L15.4,3.42A1.61,1.61,0,0,0,12.6,3.42Z" class="path"/></g></svg></div>
	<div class="alert_wrapper">
		<?php foreach ( $notices as $notice ) : ?>
			<?php echo wc_kses_notice( $notice['notice'] ); ?><br>
		<?php endforeach; ?>
	</div>
	<a href="#" class="close mfn-close-icon"><span class="icon">✕</span></a>
</div>
