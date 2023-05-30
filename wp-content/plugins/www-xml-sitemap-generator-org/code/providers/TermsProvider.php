<?php

namespace xmlSitemapGenerator;

	class TermsProvider extends ProviderCore  implements ISitemapProvider
	{
		
		
		public $maxPageSize = 10000;
		
		public function getSuppportedTypes()
		{
			return  get_taxonomies(array( "public" => "1",  "show_ui" =>"1" ), 'names' ,'and');	
		}
		
		public function getPageCount($type)
		{
			if ($this->exclude($type)) {return 0;}
			
			global $wpdb;
			
			$sql = "SELECT  Count(DISTINCT terms.term_id)
						FROM {$wpdb->terms} as terms
							INNER JOIN {$wpdb->term_relationships} as Relationships ON terms.Term_id = Relationships.term_taxonomy_id
							INNER JOIN {$wpdb->term_taxonomy} as tax ON terms.term_id = tax.term_id
						WHERE tax.taxonomy = %s";
							
				$cmd = $wpdb->prepare($sql, $type ) ;
				
				return self::getPages($wpdb->get_var($cmd),$this->maxPageSize);
		}
			
		public function getPage($type, $page)
		{
			
			if ($this->exclude($type)) {return [];}
			
			global $wpdb;


			
			$date = self::getDateField($this->sitemapDefaults->dateField);

			$offset = ( $page - 1 ) * $this->maxPageSize;
				
				$sql = "SELECT  terms.term_id, terms.name, terms.slug, terms.term_group,
							tax.term_taxonomy_id,  tax.taxonomy, tax.description,   tax.description,
								meta.exclude, meta.priority, meta.frequency,
								UNIX_TIMESTAMP(Max(posts.{$date})) as sitemapDate,  Count(posts.ID) as posts
						  
						FROM {$wpdb->terms} as terms
							INNER JOIN {$wpdb->term_relationships} as Relationships ON terms.Term_id = Relationships.term_taxonomy_id
							INNER JOIN {$wpdb->posts} as posts ON Relationships.object_id = posts.Id
									AND posts.post_status = 'publish' AND posts.post_password = ''
							INNER JOIN {$wpdb->term_taxonomy} as tax ON terms.term_id = tax.term_id
							LEFT JOIN {$this->tablemeta} as meta ON terms.term_Id = meta.ItemId AND meta.itemType = 'taxonomy'
						WHERE tax.taxonomy = %s
						GROUP BY  terms.term_id, terms.name, terms.slug, terms.term_group, tax.description, tax.term_taxonomy_id,  tax.taxonomy, tax.description, meta.exclude, meta.priority, meta.frequency
						ORDER BY terms.term_id
						LIMIT %d,  %d ";

			$cmd = $wpdb->prepare($sql,  $type , $offset , $this->maxPageSize) ;

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
			if ($result->taxonomy == 'category')
				{$defaults = $this->sitemapDefaults->taxonomyCategories;}
			else
				{$defaults = $this->sitemapDefaults->taxonomyTags;}	
				
				$exclude = $this->getMetaValue(null, $result->exclude, $defaults->exclude) ;
						
				if ($exclude != 2)
				{
					$pageUrl =   get_category_link($result);	

					if ($this->isIncluded($pageUrl,$this->sitemapDefaults->excludeRules ))
					{
						
						$url = new MapItem();
						$url->location = $pageUrl;			
						$url->title = $result->name;
						$url->description = $result->description;
						$url->modified  =  $result->sitemapDate ;
						$url->priority = $this->getMetaValue(null,$result->priority,$defaults->priority)  ;	
						$url->frequency  =  $this->getMetaValue(null,$result->frequency,$defaults->frequency) ;		
								
						$this->addUrls($result->posts, $url);
								
					}
				}
			}
		}	
		

		private function  exclude($type)
		{
			if ($type == 'category')
			{
				$defaults = $this->sitemapDefaults->taxonomyCategories;
			}
			else
			{
				$defaults = $this->sitemapDefaults->taxonomyTags;
			}		
 
			return $this->isExcluded($defaults->exclude);
		}



	}




?>