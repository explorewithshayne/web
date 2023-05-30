<?php

namespace xmlSitemapGenerator;

	class ArchiveProvider extends ProviderCore   implements ISitemapProvider
	{
		
		public $maxPageSize = 10000;
		
		public function getSuppportedTypes()
		{
			return array( "recentarchive" , "oldarchive");	
		}
		
		public function getPageCount($type)
		{
			if ($this->exclude($type)) {return 0;}
			
			global $wpdb;

                  if ($type == 'recentarchive') {
				$clause = " >= now() - interval 30 DAY"; 
			}
                  else {
                        $clause = "  < now() - interval 30 DAY";
                  }
			
			$sql = "SELECT  Count(*)
				FROM {$wpdb->posts} as posts
				WHERE post_status = 'publish' AND post_type = 'post' AND posts.post_password = '' AND post_date {$clause} 

				GROUP BY YEAR(post_date), MONTH(post_date)
				ORDER BY YEAR(post_date) ,MONTH(post_date)";
							
				$cmd = $wpdb->prepare($sql, $type ) ;

				if ($wpdb->get_var($cmd) > 0 ) return 1;
                        return 0;

		}
			
		public function getPage($type,$page)
		{
			
			if ($this->exclude($type)) {return [];}

                  if ($type == 'recentarchive') {
				$clause = " >= now() - interval 30 DAY"; 
			}
                  else {
                        $clause = "  < now() - interval 30 DAY";
                  }

			global $wpdb;
                  
			$date = self::getDateField($this->sitemapDefaults->dateField);
				
			$sql = "SELECT DISTINCT YEAR(post_date) AS year,MONTH(post_date) AS month, 
						UNIX_TIMESTAMP(MAX(posts.{$date})) AS sitemapDate, 	Count(posts.ID) as posts
				FROM {$wpdb->posts} as posts
				WHERE post_status = 'publish' AND post_type = 'post' AND posts.post_password = '' AND post_date {$clause} 

				GROUP BY YEAR(post_date), MONTH(post_date)
				ORDER BY YEAR(post_date) ,MONTH(post_date)";
	 

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
					
				
					if($result->month == date("n") && $result->year == date("Y"))
					{
						$defaults = $this->sitemapDefaults->recentArchive;	
					}
					else
					{
						$defaults = $this->sitemapDefaults->oldArchive;
					}
			 
					$exclude =   $defaults->exclude  ;

					$pageUrl = get_month_link( $result->year , $result->month) ;
				
					
					if ($exclude != 2 && $this->isIncluded($pageUrl,$this->sitemapDefaults->excludeRules))
					{	
			
							$url = new MapItem();
							$url->location = $pageUrl;		
							$url->title = date('F', strtotime("2012-$result->month-01")) . " | " . $result->year ;
							$url->description = "";
							$url->modified  =  $result->sitemapDate ;
							$url->priority =     $defaults->priority  ;	
							$url->frequency  =  $defaults->frequency ;					
							
							$this->addUrls($result->posts, $url);
		
					}
					
				}
		}

		private function  exclude($type)
		{

                  if ($type == 'recentarchive') {
				$defaults = $this->sitemapDefaults->recentArchive; 
			}
                  else {
                        $defaults = $this->sitemapDefaults->oldArchive;
                  }
				
			return $this->isExcluded($defaults->exclude);
			
		}


	}




?>