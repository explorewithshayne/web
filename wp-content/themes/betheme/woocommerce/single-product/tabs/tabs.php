<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

if( isset($_GET['mfn-demo-product']) ){
	$style = $_GET['mfn-demo-product']; // demo single product style
} else {
	$style = mfn_opts_get( 'shop-product-style' );
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

// start building in product desc tab
if( !isset($product_tabs['description']) && !empty($_GET['visual']) ){
	$product_tabs['description'] = array(
		"title" => __('Description', 'woocommerce'),
		"priority" => 10,
		"callback" => "mfn_woo_description_callback" 
	);
	sort($product_tabs);
}

if ( ! empty( $product_tabs ) ) : ?>

	<?php
		if( 'default' == $style ):

			// close: section_product_before_tabs

					echo '</div>'; // <div id="product-[ID]" class="...">
				echo '</div>'; // <div class="section_wrapper clearfix">
			echo '</div>'; // <div class="section section_product_before_tabs">

			// tabs

			echo '<div class="product_tabs_wrapper fake-tabs fake-tabs-count-'. esc_attr( count( $product_tabs ) ) .'">';

				echo '<ul class="fake-tabs-nav">';

					$first = 'active';

					foreach ( $product_tabs as $key => $product_tab ){

						echo '<li class="'. esc_attr( $first ) .'" data-tab="'. esc_attr( $key ) .'">';
							echo '<a href="#">';
								echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) );
							echo '</a>';
						echo '</li>';

						$first = false;

					}

				echo '</ul>';

				$first = 'active';
				$tab_index = '0';

				foreach ( $product_tabs as $key => $product_tab ){

					echo '<div class="tab tab-'. esc_attr( $key ) .' '. esc_attr( $first ) .'" tab-index="'. esc_attr( $tab_index ) .'">';
						if ( isset( $product_tab['callback'] ) ) {

							if( 'description' == $key ){
								call_user_func( $product_tab['callback'], $key, $product_tab );
							} else {
								echo '<div class="section section_product_tab_'. esc_attr( $key ) .'">';
									echo '<div class="section_wrapper clearfix">';
										call_user_func( $product_tab['callback'], $key, $product_tab );
									echo '</div>';
								echo '</div>';
							}

						}
					echo '</div>';

					$first = false;
					$tab_index = '-1';

				}

			echo '</div>';

			// open: section_product_after_tabs

			echo '<div class="section section_product_after_tabs">';
				echo '<div class="section_wrapper clearfix">';
					echo '<div class="product style-default">';

		elseif( in_array( $style, array( 'default', 'tabs', 'wide tabs', 'modern' ) ) ):
	?>

		<div class="jq-tabs tabs_wrapper">

			<ul class="tabs wc-tabs" role="tablist">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a href="#tab-<?php echo esc_attr( $key ); ?>">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php
				foreach ( $product_tabs as $key => $product_tab ){
					echo '<div id="tab-'. $key .'">';
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						}
					echo '</div>';
				}
			?>

		</div>

	<?php else: ?>

		<div class="accordion">
			<div class="mfn-acc accordion_wrapper open1st">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

					<div class="question">

						<div class="title">
							<i class="icon-plus acc-icon-plus" aria-hidden="true"></i><i class="icon-minus acc-icon-minus" aria-hidden="true"></i>
							<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
						</div>

						<div class="answer">
							<?php
								if ( isset( $product_tab['callback'] ) ) {
									call_user_func( $product_tab['callback'], $key, $product_tab );
								}
							?>
						</div>

					</div>

				<?php endforeach; ?>
			</div>
		</div>

	<?php endif; ?>

<?php endif; ?>
