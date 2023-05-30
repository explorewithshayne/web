<p><?php
	esc_html_e( 'Would you like to boost your website sharing abilities?', 'og ' );
?></p>
<p>
<?php
printf(
	esc_html__( 'Don\'t wait, install plugin %s!', 'og' ),
	sprintf(
		'<a href="%s" target="_blank"><strong>%s</strong></a>',
		$args['plugin_wp_home'],
		$args['plugin_name']
	)
);
?>
</p>
 <p class="iworks-rate-center"><a href="<?php echo esc_url( $args['install_plugin_url'] ); ?>" class="iworks-rate-button iworks-rate-button--green dashicons-admin-plugins
"><?php echo esc_html( __( 'Install', 'og' ) ); ?></a></p>

