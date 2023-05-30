<?php
	// featured image: parallax

	$class = '';
	$data_parallax = array();

	if (mfn_opts_get('img-subheader-attachment') == 'parallax') {
		$class = 'bg-parallax';

		if (mfn_opts_get('parallax') == 'stellar') {
			$data_parallax['key'] = 'data-stellar-background-ratio';
			$data_parallax['value'] = '0.5';
		} else {
			$data_parallax['key'] = 'data-enllax-ratio';
			$data_parallax['value'] = '0.3';
		}
	}
?>
<div id="Header_wrapper" class="<?php echo esc_attr($class); ?>" <?php if ($data_parallax) {
	printf('%s="%.1f"', $data_parallax['key'], $data_parallax['value']);} ?>>

	<?php
		if ('mhb' == mfn_header_style()) {

			// mfn_header action for header builder plugin

			do_action('mfn_header');
			echo mfn_slider();

		} else {

			echo '<header id="Header">';

				if ( has_nav_menu('skip-links-menu') ) {
					mfn_wp_accessibility_skip_links();
				}

				if ( 'header-creative' != mfn_header_style(true) ) {
					// NOT header creative
					if( 'header-shop' == mfn_header_style(true) ){
						// header style: shop
						get_template_part('includes/header', 'style-shop');
					} elseif( 'header-shop-split' == mfn_header_style(true) ){
						// header style: shop split
						get_template_part('includes/header', 'style-shop-split');
					} else {
						// default headers
						get_template_part('includes/header', 'top-area');
					}
				}

				if ( 'header-below' != mfn_header_style(true) ) {
					// header below
					echo mfn_slider();
				}

			echo '</header>';

		}
	?>

	<?php
		if ( 'intro' != get_post_meta( mfn_ID(), 'mfn-post-template', true ) ){
			if( 'all' != mfn_opts_get('subheader') ){
				if( ! get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ){

					$subheader_advanced = mfn_opts_get('subheader-advanced');

					if (is_search()) {

						echo '<div id="Subheader">';
							echo '<div class="container">';
								echo '<div class="column one">';

									if ( ! empty($_GET['s']) ) {
										global $wp_query;
										$total_results = $wp_query->found_posts;
									} else {
										$total_results = 0;
									}

									$translate['search-results'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-results', 'results found for:') : __('results found for:', 'betheme');
									echo '<h1 class="title">'. esc_html($total_results) .' '. esc_html($translate['search-results']) .' '. ( ! empty($_GET['s']) ? esc_html(stripslashes($_GET['s'])) : '' ) .'</h1>';

								echo '</div>';
							echo '</div>';
						echo '</div>';

					} elseif ( ! mfn_slider_isset() || isset( $subheader_advanced['slider-show'] ) ) {

						// subheader

						$subheader_options = mfn_opts_get('subheader');

						if (is_home() && ! get_option('page_for_posts') && ! mfn_opts_get('blog-page')) {
							$subheader_show = false;
						} elseif (is_array($subheader_options) && isset($subheader_options[ 'hide-subheader' ])) {
							$subheader_show = false;
						} elseif (get_post_meta(mfn_ID(), 'mfn-post-hide-title', true)) {
							$subheader_show = false;
						} else {
							$subheader_show = true;
						}

						// title

						if (is_array($subheader_options) && isset($subheader_options[ 'hide-title' ])) {
							$title_show = false;
						} else {
							$title_show = true;
						}

						// breadcrumbs

						if (is_array($subheader_options) && isset($subheader_options[ 'hide-breadcrumbs' ])) {
							$breadcrumbs_show = false;
						} else {
							$breadcrumbs_show = true;
						}

						if (is_array($subheader_advanced) && isset($subheader_advanced[ 'breadcrumbs-link' ])) {
							$breadcrumbs_link = 'has-link';
						} else {
							$breadcrumbs_link = 'no-link';
						}

						// output

						if ($subheader_show) {

							echo '<div id="Subheader">';
								echo '<div class="container">';
									echo '<div class="column one">';

										if ($title_show) {
											$title_tag = mfn_opts_get('subheader-title-tag', 'h1');
											echo '<'. esc_attr($title_tag) .' class="title">'. wp_kses(mfn_page_title(), mfn_allowed_html()) .'</'. esc_attr($title_tag) .'>';
										}

										if ($breadcrumbs_show) {
											mfn_breadcrumbs($breadcrumbs_link);
										}

									echo '</div>';
								echo '</div>';
							echo '</div>';

						}
					}

				}
			}
		}
	?>

</div>
