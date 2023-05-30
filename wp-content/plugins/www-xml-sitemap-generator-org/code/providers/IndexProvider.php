<?php

namespace xmlSitemapGenerator;

	class IndexProvider extends ProviderCore  implements ISitemapProvider
	{

		public $maxPageSize = -1;
		
		public function getSuppportedTypes()
		{
			$types[] = ("index");
			
			return $types;
		}
		

		
		public function getPageCount($type)
		{
				return 1;
		}


		private function addRssLatest()
		{
			$globalSettings = Core::getGlobalSettings();
			$url = new MapItem();
			$url->location = $this->blogUrl . "/" . $globalSettings->urlRssLatest;	
			$url->title = "Latest posts sitemap.";
			$this->addUrls(0, $url);	
		}
		private function addNews()
		{
			$globalSettings = Core::getGlobalSettings();
                  if (strlen($globalSettings->urlNewsSitemap) > 0) {
                        $url = new MapItem();
                        $url->location = $this->blogUrl . "/" . $globalSettings->urlNewsSitemap;	
                        $url->title = "News sitemap.";
                        $this->addUrls(0, $url);	                        
                  }
		}
		
		public function getPage($type, $page)
		{
			
			$providers = SitemapProvider::getProviderList();
			$globalSettings = Core::getGlobalSettings();
			
                  // for XML sitemaps with news enabled add the news feed
                  // or if RSS add the RSS latest feed
			if ($this->format == "xml" && $globalSettings->newsMode > 0 ) {$this->addNews();	 }
			elseif ($this->format == "rss") {$this->addRssLatest();}
		
			 foreach($providers as $providerName) 
			 {

				if ($providerName == "news" || $providerName == "index") {continue;}
                        if ($this->format == "xml" && $providerName == "latest" ) {continue ;}

				 $provider = SitemapProvider::getInstance($providerName);
				 $types = $provider->getSuppportedTypes();
				 
				 foreach($types as $typeName) 
				 { 			
					 $pages = $provider->getPageCount($typeName);
					 if ($pages > 0)
					 {
						$this->doPopulate($providerName, $typeName, $pages);						 
					 }

				 }

			 }
			  return $this->urlsList;
		}

		private function doPopulate($provider, $type, $pages)
		{
			$blogUrl = get_bloginfo( 'url' );

			$providerT = ucfirst($provider);
			$typeT = ucfirst($type);
				
			for ( $i= 1 ; $i <= $pages ; $i++)
			{
				$pageUrl = $blogUrl . "/sitemap-files/{$this->format}/{$provider}/{$type}/{$i}/" ;
				
				$url = new MapItem();
				$url->location = $pageUrl;	
				
				if ($provider == $type)
					{$url->title = "{$providerT} sitemap. Page {$i}.";}
				else
					{$url->title = "{$providerT} - {$typeT} sitemap. Page {$i}.";}
					
				$this->addUrls(0, $url);				
			}
		}
		
	}

?>