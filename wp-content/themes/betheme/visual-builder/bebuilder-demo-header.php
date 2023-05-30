<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BeBuilder | <?php echo get_the_title( $this->post_id ); ?></title>
	<?php 
	do_action( 'wp_enqueue_scripts' );
	do_action( 'wp_print_styles' );
	do_action( 'wp_print_scripts' );
	do_action( 'wp_head' ); 
	?>
</head>
<body class="mfn-preloader-active">