<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="alert alert_info">
	<div class="alert_icon"><svg viewBox="0 0 28 28" aria-hidden="true"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><g><circle class="path" cx="14" cy="14" r="12"/><path class="path" d="M11.2,9.12a3.4,3.4,0,0,1,3-1.69,2.84,2.84,0,0,1,3,2.76,3.16,3.16,0,0,1-.84,2.23c-.63.74-1.58,1.18-2.19,1.88a1,1,0,0,0-.26.64v2.32"/><circle class="path" cx="14" cy="20" r="0.33"/></g></svg></div>
	<div class="alert_wrapper"><?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></div>
</div>
