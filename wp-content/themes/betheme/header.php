<?php
/**
 * The Header for our theme.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */
?><!DOCTYPE html>
<?php
	if ($_GET && key_exists('mfn-rtl', $_GET)):
		echo '<html class="no-js" lang="ar" dir="rtl">';
	else:
?>
<html <?php language_attributes(); ?> class="no-js <?php echo esc_attr(mfn_html_classes()); ?>"<?php mfn_tag_schema(); ?> >
<?php endif; ?>

<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php if( !empty(get_post_meta(get_the_ID(), 'mfn-post-one-page', true)) && get_post_meta(get_the_ID(), 'mfn-post-one-page', true) == '1' ) echo '<div id="home"></div>'; ?>

	<?php do_action('mfn_hook_top'); ?>

	<?php get_template_part('includes/header', 'sliding-area'); ?>

	<?php
		if (mfn_header_style(true) == 'header-creative') {
			get_template_part('includes/header', 'creative');
		}
	?>

	<div id="Wrapper">

	<?php
		if (mfn_header_style(true) == 'header-below') {
			echo mfn_slider();
		}

		$header_tmp_id = mfn_template_part_ID('header');

		// be setup wizard
		if( isset( $_GET['mfn-setup-preview'] ) ){
			$header_tmp_id = false;
		}

		if( $header_tmp_id ){
			$is_visual = false;
			if( !empty($_GET['visual']) ) $is_visual = true;
			get_template_part( 'includes/header', 'template', array( 'id' => $header_tmp_id, 'visual' => $is_visual ) );
		}else{
			get_template_part( 'includes/header', 'classic' );
		}

		if ( 'intro' == get_post_meta( mfn_ID(), 'mfn-post-template', true ) ) {
			get_template_part( 'includes/header', 'single-intro' );
		}
	?>

	<?php do_action( 'mfn_hook_content_before' );
