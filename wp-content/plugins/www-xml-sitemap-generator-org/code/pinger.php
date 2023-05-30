<?php

namespace xmlSitemapGenerator;

include_once 'dataAccess.php';

class Pinger
{

	public static function doPing($tag = "manual")
	{
		$sitemapUrl = urlencode( get_bloginfo( 'url' ) .   '/xmlsitemap.xml');
		$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . $sitemapUrl;
		$response = Core::doRequest($url);
		Core::statusUpdate("Google {$tag} ping - {$response}");

		$url = "http://www.bing.com/ping?sitemap=" . $sitemapUrl;
		$response = Core::doRequest($url);
		Core::statusUpdate("Bing {$tag} ping - {$response}");
	
		update_option('xmsg_LastPing', time());
	}
	
	public static function doManualPing()
	{

		 self::doPing("Manual");
		
		
	}
	public static function doAutoPings($date)
	{
		$lasModified = DataAccess::getLastModified($date);
		$lastPing = get_option('xmsg_LastPing',0);
		// using UNIX times 
		if ($lastPing < $lasModified )
		{
			self::doPing("Auto");
			update_option('xmsg_LastPing', $lasModified);
		}
		else
		{
			Core::statusUpdate("Auto ping skipped. No modified posts");
		}
	}


	
}
?>