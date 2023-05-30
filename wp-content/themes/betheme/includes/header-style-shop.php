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

          // logo

          get_template_part('includes/include', 'logo');

          // top bar right

  				get_template_part('includes/header', 'top-bar-right');

        ?>

      </div>

      <?php if ( 'hide' != mfn_opts_get('menu-style') ): ?>

      <div class="top_bar_row top_bar_row_second clearfix">

        <div class="menu_wrapper">
					<?php
						mfn_wp_nav_menu();
					?>
				</div>

      </div>

      <?php endif; ?>

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
