<?php
/**
 * The main template file.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

$translate['search-placeholder'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-placeholder','Enter your search') : __('Enter your search','betheme');

$icon = isset( $args['icon'] ) ? '<span class="icon_search"><i class="'.$args['icon'].'"></i></span>' : '<svg class="icon_search" width="26" viewBox="0 0 26 26" aria-label="'. __('search icon', 'betheme') .'"><defs><style>.path{fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:1.5px;}</style></defs><circle class="path" cx="11.35" cy="11.35" r="6"></circle><line class="path" x1="15.59" y1="15.59" x2="20.65" y2="20.65"></line></svg>';

if( isset($args['placeholder']) ) $translate['search-placeholder'] = $args['placeholder'];

?>

<form method="get" class="form-searchform" action="<?php echo esc_url(home_url('/')); ?>">

	<?php if( mfn_opts_get('header-search') == 'shop' ): ?>
		<input type="hidden" name="post_type" value="product" />
	<?php endif; ?>

  <?php echo $icon; ?>

  <span class="mfn-close-icon icon_close" tabindex="0"><span class="icon">✕</span></span>

	<?php if( mfn_opts_get('keyboard-support') ): ?>
		<label for="s" class="screen-reader-text"><?php echo esc_html($translate['search-placeholder']); ?></label>
	<?php endif;?>

	<input type="text" class="field" name="s" autocomplete="off" placeholder="<?php echo esc_html($translate['search-placeholder']); ?>" />
	<input type="submit" class="display-none" value="" />

</form>
