<?php

namespace xmlSitemapGenerator;


class Upgrader
{
	
	public static function doUpgrade()
	{
		
		$current_update = 4;
		
		$installed_Update =  intval(get_option( "xmsg_Update"   , 0  ));
		
		if ($installed_Update < $current_update )
		{
			self::runScripts($installed_Update);
			update_option( "xmsg_Update", $current_update , true);
		}

	}
	
	public static function runScripts($installed_Update)
	{
		global $wpdb;		
		$tablemeta = $wpdb->prefix . 'xsg_sitemap_meta';

		if ($installed_Update < 1)
		{
			$cmd = "UPDATE {$tablemeta} SET frequency = 8 WHERE frequency = 7";
			$wpdb->query($cmd);
		}
		
		if ($installed_Update < 4)
		{
			$cmd = "ALTER TABLE {$tablemeta} ADD COLUMN news INT NOT NULL DEFAULT 0";
			$wpdb->query($cmd);
			
		}
	}

	
}
?>