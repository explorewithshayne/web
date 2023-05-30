<?php

namespace xmlSitemapGenerator;

	class NewsProvider extends ProviderCore  implements ISitemapProvider
	{
		
		
		public $maxPageSize = -1;
		
		public function getSuppportedTypes()
		{
			return array( "news");	
		}
		
		public function getPageCount($type)
		{
			$globalSettings =   Core::getGlobalSettings();
			if ($globalSettings->newsMode == '0')
			{
				return 0;				
			}
			else
			{
				return 1;		
			}
		}
			
		public function getPage($type,$page)
		{
			global $wpdb;
			
			$globalSettings =   Core::getGlobalSettings();
			if ($globalSettings->newsMode == '0') {return [];}
			
			
			$cmdSelect = "SELECT posts.*, UNIX_TIMESTAMP(posts.post_date) as sitemapDate ";
					 
						
			$cmdFrom = "		FROM {$wpdb->posts} as posts  ";
	

			$cmdWhere =	"	WHERE (posts.post_status = 'publish'  ) AND ( posts.post_type = 'post' )   
						AND posts.post_date > (NOW() - INTERVAL 48 HOUR)
						AND posts.post_password = ''  
				";
			
			if ($globalSettings->newsMode == '2') 
			{ 
		
				$cmdWhere.= "	AND posts.ID IN 
								 (
								  SELECT  object_id
								  FROM {$wpdb->term_relationships}  as term_rel 
								  INNER JOIN {$wpdb->terms} as terms ON term_rel.term_taxonomy_id = terms.term_id
								  INNER JOIN {$wpdb->term_taxonomy} as term_tax ON term_rel.term_taxonomy_id = term_tax.term_taxonomy_id
								  INNER JOIN {$this->tablemeta} as meta ON  meta.itemId = terms.term_id AND meta.itemType = 'taxonomy'
								  WHERE meta.news = 1
								) ";
									
			}
			
			if ($this->globalSettings->enableImages)
			{
				$cmdSelect .= " , images.guid as imageUrl, images.post_title as imageTitle , images.post_excerpt as imageCaption, images.post_content as imageDescription";
				
				$cmdFrom .= " LEFT JOIN {$wpdb->postmeta} as pm 
								ON posts.id = pm.post_id   AND pm.meta_key = '_thumbnail_id'
								LEFT JOIN {$wpdb->posts} as images
									ON pm.meta_value = images.id ";
			}
					
					
			$cmd = $cmdSelect . $cmdFrom . $cmdWhere;
			$cmd .=	" ORDER BY posts.post_date DESC
					LIMIT 1000 ";
					
			
			$results = $wpdb->get_results($cmd);
			if ($results ) 
			{
				$this->doPopulate($results);
			}		

			return $this->urlsList;	
		}

		private function doPopulate($results)
		{
			foreach( $results as $result ) {
						 

				$pageUrl =  get_permalink($result);	
	 
				$url = new MapItem();
				$url->location = $pageUrl  ;				
				$url->title =    $result->post_title;
				$url->description = $result->post_excerpt;
				$url->modified  =  $result->sitemapDate ;	
						
				if ($this->globalSettings->enableImages)
				{
					$url->images = [];
					
				 	$images = $this->getImage($result);
				 	if (!empty($images)) { array_push($url->images, $images  ); }
					$images = $this->getImages($result->post_content) ;
					if (!empty($images)) {$url->images =	array_merge($url->images, $images  ); } 

				}			
				
				$this->addUrls(0, $url);

			}
		}

		
	}




?>