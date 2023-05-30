<?php

namespace xmlSitemapGenerator;

	
	class RssRenderer  extends RendererCore implements ISitemapRenderer
	{
		
		function renderItem( $url, $isIndex)
		{
			
			 echo '<item>'  ;
				echo '<guid>'  . esc_url($url->location) . '</guid>';
				echo '<title>'  .esc_attr( $url->title) . '</title>';
				echo '<link>'  . esc_url($url->location) . '</link>';
				echo '<description>' . esc_attr($url->description) . '</description>';
				
			if(!$isIndex)
			{
                        
				echo '<pubDate>' .  $this->getDateString($url->modified, \DateTime::RSS)   . '</pubDate>';
			}

			 echo "</item>\n" ;
		}

		function renderIndex($urls)
		{
			$this->doRender($urls, true);
		}
		
		function renderPages($urls)
		{
			$this->doRender($urls, false);
		}
		
		function doRender($urls,$isIndex){
			
			$urlXls  = xsgPluginPath(). '/assets/SitemapRSS.xsl';
			
			
		  	ob_get_clean();
		 	ob_start();
			header('Content-Type: text/xml; charset=utf-8');
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>';
			echo  "\n";
			echo '<?xml-stylesheet type="text/xsl" href="' . esc_url_raw($urlXls) . '"?>';
			echo  "\n";
			
			$this->renderComment();
			echo  "\n";
			echo  '<rss version="2.0">';
			echo  "\n";
			echo  '<channel>';
			echo  "\n";

											
			echo '<title>'  . esc_attr(get_option('blogname')) . '</title>';
			echo '<link>'  . esc_url_raw(get_bloginfo( 'url' )) . '</link>';
			echo '<description>' . esc_attr(get_option( 'blogdescription')). '</description>';
			

			
			echo  "\n";
			if (isset($urls))
			{
				foreach( $urls as $url ) 
				{
					
					$this->renderItem($url, $isIndex);
				}	
			}
			echo  "\n";
			echo '</channel>';
			echo  "\n";
			echo '</rss>';
			echo  "\n";
			$this->renderComment();
			echo  "\n";
			ob_end_flush();
						
		}
		
		
	}
	
	
	
?>