<?php

namespace xmlSitemapGenerator;

	class PostsProvider extends ProviderCore  implements ISitemapProvider
	{

	
		public $maxPageSize = 2500;
		
		public function getSuppportedTypes()
		{	
			$types = array("page", "post");
			$types = array_merge ($types,self::getPostTypes() );
			return $types;
		}
		
		public function getPageCount($type)
		{
			if ($this->exclude($type)) {return 0;}
			
			 // if type is "page" and included check if we should include pages or just the homepage.
			if ($this->excludePages()) {return 1;}
			
			global $wpdb;	

					
 
			$frontPageId = get_option( 'page_on_front' );		
			
			$sql = "SELECT Count(*)
						FROM {$wpdb->posts} as posts 
						WHERE posts.post_password = '' 
							AND posts.ID <> %d 
						 	AND post_type = %s 
							AND (post_status = 'publish' OR post_status = 'future' ) ";  
 
			$cmd = $wpdb->prepare($sql,$frontPageId, $type  ) ;
			$count = $wpdb->get_var($cmd)+1;
			return self::getPages($count, $this->maxPageSize);
		}
			
		public function getPage($type, $page)
		{
			
			if ($this->exclude($type)) {return [];}
			
			global $wpdb;
			
			if ($page == 1 && $type == 'page' ) { 	$this->addHomePage();	}
			
			$date = self::getDateField($this->sitemapDefaults->dateField);
			$frontPageId = get_option( 'page_on_front' );
	
			$offset = ( $page - 1 ) * $this->maxPageSize;
				
			$cmdSelect = "SELECT  posts.*,  postmeta.*, Tag_meta.* ,	UNIX_TIMESTAMP(posts.{$date}) as sitemapDate ";
						
			$cmdFrom = " FROM {$wpdb->posts} as posts 
					
						LEFT JOIN {$this->tablemeta} as postmeta ON posts.Id = postmeta.ItemId AND postmeta.itemId
						LEFT JOIN 
								(SELECT  
									terms.object_id as Post_id,
									Max(meta.exclude) as tagExclude,
									Max(meta.priority) as tagPriority,
									Max(meta.frequency) as tagFrequency
								FROM {$this->tablemeta} as meta 
									INNER JOIN {$wpdb->term_relationships} as terms
									ON  meta.itemId = terms.term_taxonomy_id AND meta.itemType = 'posts'
								WHERE meta.itemType = 'taxonomy' AND meta.inherit = 1
									
								GROUP BY terms.object_id 
								) as Tag_meta
							ON posts.Id = Tag_meta.Post_id ";
						
			$cmdWhere = " WHERE posts.post_password = '' 
								AND posts.ID <> %d 
								AND posts.post_type = %s    
								AND (posts.post_status = 'publish' OR posts.post_status = 'future' ) 
								
						ORDER BY ID DESC
						LIMIT %d,  %d ";
	 
			if ($this->globalSettings->enableImages)
			{
				$cmdSelect .= " , images.guid as imageUrl, images.post_title as imageTitle , images.post_excerpt as imageCaption, images.post_content as imageDescription";
				
				$cmdFrom .= " LEFT JOIN {$wpdb->postmeta} as pm 
								ON posts.id = pm.post_id   AND pm.meta_key = '_thumbnail_id'
								LEFT JOIN {$wpdb->posts} as images
									ON pm.meta_value = images.id ";
			}
					
					
			$cmd = $cmdSelect . $cmdFrom . $cmdWhere;
 
			$cmd = $wpdb->prepare($cmd, $frontPageId, $type , $offset , $this->maxPageSize) ;
		 
			$results = $wpdb->get_results($cmd);
			
			if ($results ) 
			{
				$this->doPopulate($results);
			}		
			return $this->urlsList;
			
		}


		
		function addHomePage( )
		{
			
			$defaults = $this->sitemapDefaults->homepage;
			$pageUrl = get_bloginfo( 'url' );

			$exclude = $defaults->exclude ;
					
			if ($exclude != 2)
			{	
					
				if ($this->isIncluded($pageUrl,$this->sitemapDefaults->excludeRules ))
				{
							
					$url = new MapItem();
					$url->location = $pageUrl;		
					$url->title = "Home page" ;
					$url->description = get_option( 'blogdescription');;
					$url->modified  =  DataAccess::getLastModified() ;
					$url->priority =   $defaults->priority  ;	
					$url->frequency  = $defaults->frequency ;					
						
					$this->addUrls(0, $url);
						 
				}
			}
		}




		private function doPopulate($results)
		{
			foreach( $results as $result ) {
						 

				$defaults = $this->postTypeDefault( $result->post_type );
				$exclude = $this->getMetaValue($result->exclude, $result->tagExclude, $defaults->exclude) ;
						
				if ($exclude == 2) { continue;}
				if ( $result->post_status =='future' && $defaults->scheduled == 0)  { continue;}

				$pageUrl =  get_permalink($result);	
		
				$url = new MapItem();
				$url->location = $pageUrl  ;				
				$url->title = get_the_title( $result ); 
				$url->description = $result->post_excerpt;
				$url->modified  =  $result->sitemapDate ;	
				$url->priority =    $this->getMetaValue($result->priority,$result->tagPriority,  $defaults->priority)  ;	
				$url->frequency  =  $this->getMetaValue($result->frequency,$result->tagFrequency,$defaults->frequency) ;				
					 
				
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

	private function excludePages()
	{
		$defaults = $this->postTypeDefault('page');
		return $this->isExcluded($defaults->exclude);
	}

	private function exclude($type)
	{

		$defaults = $this->postTypeDefault($type);
		
		if ($type == "page")
		{
			$defaults2 = $this->sitemapDefaults->homepage;
			if ( $this->isExcluded($defaults->exclude)  &&  $this->isExcluded($defaults2->exclude)   ) {return true;}
			return false;
		}
		else
		{
			return $this->isExcluded($defaults->exclude);
		}
		
	}
	
		private  function postTypeDefault($type)
		{
			if ($type == 'page')
			{
				return $this->sitemapDefaults->pages;
			}
			elseif ($type == 'post')
			{
				return $this->sitemapDefaults->posts;
			}
			else
			{
				return ( isset( $this->sitemapDefaults->{$type} ) ?  $this->sitemapDefaults->{$type} : $this->sitemapDefaults->posts );
			}		
		}
		
		private static function getPostTypes()
		{
			$args = array(
			   'public'   => true,
			   '_builtin' => false
				);
		  
			$output = 'names'; // 'names' or 'objects' (default: 'names')
			$operator = 'and'; // 'and' or 'or' (default: 'and')
			  
			$post_types = get_post_types( $args, $output, $operator );
		
			return $post_types;
		}
		
	}




?>