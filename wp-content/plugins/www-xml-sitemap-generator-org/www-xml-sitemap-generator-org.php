<?php
namespace xmlSitemapGenerator;
/*
Plugin Name:  XML Sitemap Generator for Google
Plugin URI: https://XmlSitemapGenerator.org
Description: HTML, RSS and Google XML Sitemap generator compatible with Google, Bing, Baidu, Yandex and more.
Version: 2.0.7
Author: XmlSitemapGenerator.org
Author URI: https://XmlSitemapGenerator.org
License: GPL2
*/

include 'code/core.php';


function myPluginFile() {
	
	return __FILE__;
}
function xsgPluginPath() {
	return plugins_url() . "/" .  XSG_PLUGIN_NAME . "/";
	 
}

 
if(defined('ABSPATH') && defined('WPINC')) {

	register_activation_hook(__FILE__, 'xmlSitemapGenerator\Core::activatePlugin');
	 
	add_action("init", 'xmlSitemapGenerator\Core::initialisePlugin');
	
	// used to redirect the user to the plugin settings when activated manually.
	add_action( 'activated_plugin', 'xmlSitemapGenerator\Core::activated');
		
	// when ever a new blog is created in network mode
	add_action( 'wp_initialize_site', 'xmlSitemapGenerator\Core::activateNewBlog', 900 );
	
	add_action( 'upgrader_process_complete', 'xmlSitemapGenerator\Core::activatePlugin' );
	
	 
}



?>
