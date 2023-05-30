<?php

namespace xmlSitemapGenerator;

	class AuthorsProvider extends ProviderCore  implements ISitemapProvider
	{
		
		public $maxPageSize = -1;
		
		public function getSuppportedTypes()
		{
			return array( "authors");	
		}
		
		
		public function getPageCount($type)
		{
			if ($this->exclude($type)) {return 0;}
			return 1;
		 
		}
			
		public function getPage($type,$page)
		{
			
			if ($this->exclude()) {return [];}
			
			global $wpdb;
				
			$date = self::getDateField($this->sitemapDefaults->dateField);
	
			$sql = "SELECT users.ID, users.user_nicename, users.user_login, users.display_name ,meta.exclude, meta.priority, meta.frequency,
						UNIX_TIMESTAMP(MAX(posts.{$date})) AS sitemapDate, 	Count(posts.ID) as posts
					FROM {$wpdb->users} users LEFT JOIN {$wpdb->posts} as posts ON users.Id = posts.post_author 
							AND posts.post_type = 'post' AND posts.post_status = 'publish' AND posts.post_password = ''
					LEFT JOIN {$this->tablemeta} as meta ON users.ID = meta.ItemId AND meta.itemType = 'author'
					GROUP BY users.ID, users.user_nicename, users.user_login, users.display_name, meta.exclude, meta.priority, meta.frequency
					ORDER BY users.ID";
			
			
			$cmd = $wpdb->prepare($sql) ;

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
	
					$defaults = $this->sitemapDefaults->authors;					
			
					$exclude = $this->getMetaValue(null, $result->exclude, $defaults->exclude) ;
					
					if ($exclude != 2)
					{
						$pageUrl =   get_author_posts_url($result->ID, $result->user_nicename);	

						if ($this->isIncluded($pageUrl,$this->sitemapDefaults->excludeRules ))
						{
							
							$url = new MapItem();
							$url->location = $pageUrl;			
							$url->title = $result->display_name ;
						 	$url->description = "";
							$url->modified  =  $result->sitemapDate ;
							$url->priority =   $this->getMetaValue(null,$result->priority,$defaults->priority)  ;	
							$url->frequency  = $this->getMetaValue(null,$result->frequency,$defaults->frequency) ;
												
							$this->addUrls($result->posts, $url);
						}
					}
				}
		}

		private function  exclude()
		{
			if ($this->isExcluded($this->sitemapDefaults->authors->exclude) ) {return true;}
			return false;
		}


	}




?>