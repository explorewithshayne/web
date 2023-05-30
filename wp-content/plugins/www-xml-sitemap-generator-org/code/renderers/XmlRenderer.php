<?php

namespace xmlSitemapGenerator;


	class XmlRenderer extends RendererCore implements ISitemapRenderer
	{
  
		private function getFrequency($value)
		{
			switch ($value) {
				case 0:
					return "";
					break;
				case 1:
					return "default";
					break;
				case 2:
					return "never";
					break;
				case 3:
					return "yearly";
					break;
				case 4:
					return "monthly";
					break;
				case 5:
					return "weekly";
					break;
				case 6:
					return "daily";
					break;
				case 7:
					return "hourly";
					break;
				case 8:
					return "always";
					break;
				default:
					return "xxx";
			}
		}

		private function getPriority($value)
		{
			switch ($value) {
				case 0:
					return "";
					break;
				case 1:
					return "default";
					break;
				case 2:
					return "0.0";
					break;
				case 3:
					return "0.1";
					break;
				case 4:
					return "0.2";
					break;
				case 5:
					return "0.3";
					break;
				case 6:
					return "0.4";
					break;
				case 7:
					return "0.5";
					break;
				case 8:
					return "0.6";
					break;
				case 9:
					return "0.7";
					break;
				case 10:
					return "0.8";
					break;
				case 11:
					return "0.9";
					break;
				case 12:
					return "1.0";
					break;
				default:
					return "xxx";
			}
		}
		
		
		private function renderImages($images)
		{

			foreach( $images as $image ) 
			{
				echo '<image:image>'  ;
				echo '<image:loc>'  . esc_url($image->location) . '</image:loc>';
				if (!empty($image->caption)) {echo '<image:caption>' . esc_attr($image->caption) . '</image:caption>';}
				if (!empty($image->title)) {  echo '<image:title>' . esc_attr($image->title) . '</image:title>';}
				echo "</image:image>\n" ;	
			}
			
		}
		
       
		private function renderItem( $url)
		{
			
			 echo '<url>'  ;
				echo '<loc>'  . esc_url($url->location) . '</loc>';
                  
				 echo '<lastmod>' . $this->getDateString($url->modified, 'Y-m-d\TH:i:sP') . '</lastmod>';
				 
				 if (!$url->frequency==0) {
					 echo '<changefreq>' .  esc_attr($this->getFrequency($url->frequency) ). '</changefreq>';
				 }
				 
				 if (!$url->priority==0) {
					 echo "<priority>" . esc_attr($this->getPriority($url->priority)) . "</priority>";
				 } 
				 
				if (isset($url->images))
				{	
					$this->renderImages($url->images);
				}
			 echo "</url>\n" ;
		}
		

		public function renderIndex($urls)
		{
			
			$urlXls  = xsgPluginPath(). '/assets/SitemapXML.xsl';
		
			ob_get_clean();
		 	ob_start();
			header('Content-Type: text/xml; charset=utf-8');
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>';
			echo  "\n";
			echo '<?xml-stylesheet type="text/xsl" href="' . esc_url($urlXls)  . '"?>';
			echo  "\n";
			$this->renderComment();
			echo  "\n";
			echo  '<sitemapindex ';
			echo ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
			echo ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" ';
			echo ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"'; 
			echo ' >';
			echo  "\n";

			if (isset($urls))
			{	
				foreach( $urls as $url ) 
				{
					echo '<sitemap>'  ;
					echo '<loc>'  . esc_url($url->location) . '</loc>'; 
					echo "</sitemap>\n" ;
				}
			}
			
			echo  "\n";
			echo '</sitemapindex>';
			echo  "\n";
			$this->renderComment();
			echo  "\n";
			ob_end_flush();
	
		}
		
		public function renderPages($urls){
			

			$urlXls  = xsgPluginPath(). '/assets/SitemapXML.xsl';
			
		  	ob_get_clean();		
		 	ob_start();
			header('Content-Type: text/xml; charset=utf-8');
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>';
			echo  "\n";
			echo '<?xml-stylesheet type="text/xsl" href="' . esc_url($urlXls)  . '"?>';
			echo  "\n";
			$this->renderComment();
			echo  "\n";
			echo  '<urlset ';
			echo ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
			echo ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" ';
			echo ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd"'; 
			echo ' >';
			echo  "\n";

			if (isset($urls))
			{	
				foreach( $urls as $url ) 
				{
					$this->renderItem($url);
				}
			}
			
			echo  "\n";
			echo '</urlset>';
			echo  "\n";
			$this->renderComment();
			echo  "\n";
			ob_end_flush();
	
		}		
		

	}
	
?>