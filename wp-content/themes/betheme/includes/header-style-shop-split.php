<?php
defined( 'ABSPATH' ) || exit;

$action_bar = mfn_opts_get('action-bar');

?>

<?php if ( isset($action_bar['show']) ): ?>
	<div id="Action_bar">
		<div class="container">
			<div class="column one">

				<?php
					get_template_part('includes/include', 'slogan');

					if (has_nav_menu('social-menu')) {
						mfn_wp_social_menu();
					} else {
						get_template_part('includes/include', 'social');
					}
				?>

			</div>
		</div>
	</div>
<?php endif; ?>

<div class="header_placeholder"></div>

<div id="Top_bar" class="loading">

	<div class="container">
		<div class="column one">

      <div class="top_bar_row top_bar_row-first clearfix">

        <?php

					// main menu

					if ( 'hide' != mfn_opts_get('menu-style') ){
						echo '<div class="menu_wrapper">';
							mfn_wp_nav_menu();

              // responsive menu button

							$mb_class = '';
							if (mfn_opts_get('header-menu-mobile-sticky')) {
								$mb_class .= ' is-sticky';
							}

							echo '<a class="responsive-menu-toggle '. esc_attr($mb_class) .'" href="#" aria-label="'. __('mobile menu', 'betheme') .'">';
							if ( $menu_text = trim( mfn_opts_get('header-menu-text') ) ) {
								echo '<span>'. wp_kses( $menu_text, mfn_allowed_html() ) .'</span>';
							} else {
								echo '<i class="icon-menu-fine" aria-hidden="true"></i>';
							}
							echo '</a>';

						echo '</div>';
					}

          // logo

          get_template_part('includes/include', 'logo');

          // top bar right

  				get_template_part('includes/header', 'top-bar-right');

        ?>

      </div>

      <div class="search_wrapper">
				<?php
					get_search_form(true);
					if ( mfn_opts_get('header-search-live') ) {
						get_template_part('includes/header', 'live-search');
					}
				?>
			</div>

		</div>
	</div>
</div>
