<?php

namespace xmlSitemapGenerator;

// settings for generating a map


class Settings
{
	
	public static function addHooks()
	{
		add_action('admin_menu', array(  __CLASS__, 'admin_menu' ) );
		add_action('admin_init', array( __CLASS__, 'register_settings' ) );
	}

	public static function admin_menu() 
	{
		add_options_page( 'XML Sitemap settings','XML Sitemap','manage_options', XSG_PLUGIN_NAME , array( __CLASS__ , 'render' ) );
	}
	
	public static function register_settings()
	{
		register_setting( XSG_PLUGIN_NAME, XSG_PLUGIN_NAME );
	}

     static function getPostTypes()
	{
		$args = array(
		   'public'   => true,
		   '_builtin' => false
		);
		  
		$output = 'names'; // 'names' or 'objects' (default: 'names')
		$operator = 'and'; // 'and' or 'or' (default: 'and')
		  
		return get_post_types( $args, $output, $operator );	
		
	}

	static function postTypeDefault($sitemapDefaults,$name)
	{
		
		return ( isset( $sitemapDefaults->{$name} ) ?  $sitemapDefaults->{$name} : $sitemapDefaults->posts );
	}
	
	static function getDefaults($name){
		
		$settings = new metasettings();

		$settings->exclude = Helpers::getFieldValue($name . 'Exclude', 0);
		$settings->priority  = Helpers::getFieldValue($name . 'Priority' , 0);
		$settings->frequency  = Helpers::getFieldValue($name . 'Frequency', 0);
		$settings->scheduled  = Helpers::getFieldValue($name . 'Scheduled', 0);
		
		return $settings;
	}

	

	static function  handlePostBack(){
		
        if (strtoupper(Helpers::geServerValue('REQUEST_METHOD', '')) != 'POST'){ return;  }

		/* Verify the nonce before proceeding. */
	 	if ( !isset( $_POST['wpXSG_meta_nonce'] ) || !wp_verify_nonce( $_POST['wpXSG_meta_nonce'], basename( __FILE__ ) ) ) {return ;}
		
		
		if ( !current_user_can( 'manage_options') ) {return;}

		
			$globalsettings = new globalsettings();
			
			$register = Helpers::getFieldValue('register', 0);
			
			$globalsettings->newsMode  = Helpers::getFieldValue('newsMode', 0); 
			$globalsettings->enableImages  = Helpers::getFieldValue('enableImages', 0);  
			$globalsettings->addRssToHead  = Helpers::getFieldValue('addRssToHead', 0);  
			$globalsettings->pingSitemap = Helpers::getFieldValue('pingSitemap', 0 );
			$globalsettings->addToRobots = Helpers::getFieldValue('addToRobots', 0 );
			$globalsettings->sendStats = Helpers::getFieldValue('sendStats', 0 );
			$globalsettings->smallCredit = Helpers::getFieldValue('smallCredit', 0 );
			$globalsettings->robotEntries = Helpers::getTextAreaValue('robotEntries', "" );
			$globalsettings->registerEmail = Helpers::getEmailValue('registerEmail', "" );
			
			$globalsettings->urlXmlSitemap = Helpers::getFieldValue('urlXmlSitemap' , "xmlsitemap.xml");
			$globalsettings->urlNewsSitemap = Helpers::getFieldValue('urlNewsSitemap', "newssitemap.xml");
			$globalsettings->urlRssSitemap = Helpers::getFieldValue('urlRssSitemap' , "rsssitemap.xml");
			$globalsettings->urlRssLatest = Helpers::getFieldValue('urlRssLatest', "rsslatest.xml");
			$globalsettings->urlHtmlSitemap = Helpers::getFieldValue('urlHtmlSitemap', "htmlsitemap.htm");
			
			$globalsettings->register = $register;
			

			// if new registration status then .....
			if ($register != get_option('wpXSG_registered'))
			{
				$postData = array(
					'email' => $globalsettings->registerEmail,
					'website' => get_bloginfo( 'url' ),
					'register' => $register,
					'id' => get_option('wpXSG_MapId')
					);

                        // legacy - to be retired
				$url = 'https://xmlsitemapgenerator.org/services/WordpressOptIn.aspx';
				try
				{
                              $response = wp_remote_post($url,array('method' => 'POST','body' => $postData));		
				} 
				catch (Exception $e) 
				{}

                        $url = 'https://xmlsitemapgenerator.org/newsletter/wordpress';

				try
				{
                              $response = wp_remote_post($url,array('method' => 'POST','body' => $postData));		
				} 
				catch (Exception $e) 
				{}

			}
			
			update_option( "wpXSG_global" ,  $globalsettings , true);	
			update_option( "wpXSG_registered" ,  $register , true);
			
			
			Core::add_rewrite_rules();
			flush_rewrite_rules();
 
		
		
			$sitemapDefaults = new SitemapDefaults();
			
			$sitemapDefaults->dateField = Helpers::getFieldValue('dateField', $sitemapDefaults->dateField );
			$sitemapDefaults->homepage  = self::getDefaults("homepage");
			$sitemapDefaults->pages = self::getDefaults("pages");
			$sitemapDefaults->posts = self::getDefaults("posts");
			$sitemapDefaults->taxonomyCategories = self::getDefaults("taxonomyCategories");
			$sitemapDefaults->taxonomyTags = self::getDefaults("taxonomyTags");
		 
			$sitemapDefaults->recentArchive = self::getDefaults("recentArchive");
			$sitemapDefaults->oldArchive  = self::getDefaults("oldArchive");
			$sitemapDefaults->authors  = self::getDefaults("authors");
			
			$sitemapDefaults->excludeRules = Helpers::getFieldValue('excludeRules',"" );
			
			foreach ( self::getPostTypes()  as $post_type ) 
			{
				$sitemapDefaults->{$post_type}  = self::getDefaults($post_type);
			}
			
		 	update_option( "wpXSG_sitemapDefaults" ,  $sitemapDefaults , false);	
     
}
 
	static function RenderDefaultSection($title,$name,$defaults,$scheduled){
		
			?>
							
							<tr>
								<td><?php echo esc_attr($title); ?></td>
								<td><select  name="<?php echo esc_attr($name); ?>Exclude" id="<?php echo esc_attr($name); ?>Exclude" ></select> </td>
								<td><select  name="<?php echo esc_attr($name); ?>Priority" id="<?php echo esc_attr($name); ?>Priority" ></select>   </td>
								<td><select  name="<?php echo esc_attr($name); ?>Frequency" id="<?php echo esc_attr($name); ?>Frequency" ></select>  </td>
							<?php	if ($scheduled) { ?>
								<td><input type="checkbox"  name="<?php echo esc_attr($name); ?>Scheduled" id="<?php echo esc_attr($name); ?>Scheduled"  
									<?php	if ($defaults->scheduled) { echo 'checked="checked"';} ?>
								></input>  </td>
							<?php	}
								else
								{ echo '<td></td>';}
							 ?>
							</tr>
							<script>
                xsg_populate("<?php echo esc_attr($name); ?>Exclude" ,excludeDefaults, <?php echo esc_attr($defaults->exclude);  ?>);
                xsg_populate("<?php echo esc_attr($name); ?>Priority" ,priorityDefaults, <?php echo esc_attr($defaults->priority);  ?>);
                xsg_populate("<?php echo esc_attr($name); ?>Frequency" ,frequencyDefaults, <?php echo esc_attr($defaults->frequency);  ?>);
		 
							</script>
			
			<?php

	}

      public static function renderSitemapLink($globalsettings, $property, $name) {
            $blogUrl = get_bloginfo( 'url' ) ;
		$fileUrl = Helpers::safeRead($globalsettings,$property) ;
            if (strlen($fileUrl) > 0 ) {
                  echo '<li><a target="_blank" href="' . esc_url($blogUrl .'/' . $fileUrl)  . '">' . esc_attr($name) .  '</a></li>';
            }
            else {
                  echo '<li>' . esc_attr($name) .  ' (disabled)</li>';
            }
            
      }
	

	public static function render()
	{
		 
		self::handlePostBack();
		
		$globalsettings =   Core::getGlobalsettings();
		$sitemapDefaults =  get_option( "wpXSG_sitemapDefaults"   , new SitemapDefaults()  );
		
 
		?>


<style>
	.defaultsList li {padding: 5px;}
</style>
		
<form method="post"  > 

   <?php 	wp_nonce_field( basename( __FILE__ ), 'wpXSG_meta_nonce' ); ?>
		
		
<div class="wrap" >

        <h2>Google XML Sitemap Generator</h2>

 

		<p>Here you can edit your admin settings and defaults. You can override categories, tags, pages and posts when adding and editing them.</p>
		<p>Please support us with a <a target="_blank" href="<?php echo  XSG_DONATE_URL ?>">small donation</a>. If you have any comments, questions,
		suggestions and bugs please <a target="_blank" href="https://xmlsitemapgenerator.org/contact.aspx">contact us</a>.</strong></p>
		
<div id="poststuff" class="metabox-holder has-right-sidebar">

            <div class="inner-sidebar">
                <div   class="meta-box-sortabless ui-sortable" style="position:relative;">

                    <div  class="postbox">
                        <h3 class="hndle"><span>Sitemap related urls</span></h3>
                        <div class="inside">
						<p>Pages that are created or modified by Xml Sitemap Generator</p>
                            <ul>
		<?php  
			self::renderSitemapLink($globalsettings,"urlXmlSitemap", "XML Sitemap");
                  self::renderSitemapLink($globalsettings,"urlRssSitemap", "RSS Sitemap");
                  self::renderSitemapLink($globalsettings,"urlRssLatest", "RSS New Pages");
                  self::renderSitemapLink($globalsettings,"urlHtmlSitemap", "HTML Sitemap");

		?>
		
							</ul>
               
                        </div>
                    </div>
					
					
					
                    <div  class="postbox">
                        <h3 class="hndle"><span>Webmaster tools</span></h3>
                        <div class="inside">
						<p>It is highly recommended you register your sitemap 
						with webmaster tools to obtain performance insights.</p>
                            <ul>
								<li><a href="https://www.google.com/webmasters/tools/">Google Webmaster tools</a></li>
								<li><a href="http://www.bing.com/toolbox/webmaster">Bing Webmaster tools</a></li>
								<li><a href="http://zhanzhang.baidu.com/">Baidu Webmaster tools</a></li>
								<li><a href="https://webmaster.yandex.com/">Yandex Webmaster tools</a></li>
								
							</ul>
                        </div>
                    </div>
				
				
                    <div  class="postbox">
                        <h3 class="hndle"><span>Useful links</span></h3>
                        <div class="inside">
                            <ul>
							<li><a href="https://xmlsitemapgenerator.org/Wordpress-sitemap-plugin.aspx">Help and support</a></li>
								<li><a href="http://blog.xmlsitemapgenerator.org/">blog.XmlSitemapGenerator.org</a></li>
								<li><a href="https://twitter.com/createsitemaps">twitter : @CreateSitemaps</a></li>
								<li><a href="https://www.facebook.com/XmlSitemapGenerator">facebook XmlSitemapGenerator</a></li>
		
							</ul>
               
                        </div>
                    </div>		
                </div>
            </div>

			
 <div class="has-sidebar">
 

					
<div id="post-body-content" class="has-sidebar-content">
				
	<div class="meta-box-sortabless">

	 
			
	<div  class="postbox" <?php if (!get_option('wpXSG_registered')) {echo 'style="border-left:solid 4px #dc3232;"';} ?>">
		<h3 class="hndle"><span>Register for important updates</span></h3>
		<div class="inside">


				<?php if (!get_option('wpXSG_registered')) {echo "<p><strong>Please ensure you register for important updates to stay up-to-date.</strong></p>";} ?> 


				<p>
					<input type="checkbox" name="register" id="register" value="1" <?php checked($globalsettings->register, '1'); ?> /> Recieve important news and updates about the plugin. <a href="https://xmlsitemapgenerator.org/help/privacy.aspx" target="_blank" rel="nofollow">Privacy Policy</a>.
				</p>
			<table><tr><td>
				<p>
					<label for="email"   >Email address</label><br />
					<input type="text" name="registerEmail" size="40" value="<?php echo Helpers::safeRead2($globalsettings,"registerEmail",get_option( 'admin_email' ) ); ?>" />
				</p> 
			</td><td>&nbsp;</td><td>  
				<p>
					<label for="website">Website</label><br />
					<input type="text" name="website" size="40" readonly value="<?php echo esc_url_raw(site_url()); ?>" />
				</p>
			</td></tr></table>
		</div>
	</div> 

      <div  class="postbox" style="background-color:#faf9e8">
		<h3 class="hndle"><span>Please support my work</span></h3>
 
             <div class="inside">
			 
			 <p>If you find this plugin useful, please help support my work and keep the project alive with a small annual contribution.</p>
                   <p>You can support me via paypal or Buy Me A Coffee. Some suggestions are below :</p>
		
				<div style=" display:inline-block; text-align:center; padding:1em; width:150px;border:solid 1px #CCCCCC; margin-right:1em;">
                              <h4>Individuals</h4>
                              <p>£5 GBP<br />~ $6.30 USD</p>
					<p><a href="https://www.paypal.com/webapps/billing/plans/subscribe?plan_id=P-7CH14255BF477193PMJWYA3I" target="blank">
                              <img src="<?php echo xsgPluginPath(); ?>assets/paypal.png" /></a></p>
                              <p><a href="https://www.buymeacoffee.com/xmlsitemaps"  target="blank"  >
                                    <img width="120" height="35" src="<?php echo xsgPluginPath(); ?>assets/buymeacoffee.png" /> </a></p>       

                        </div>

                        <div style=" display:inline-block; text-align:center; padding:1em; width:150px;border:solid 1px #CCCCCC; margin-right:1em;">
                              <h4>Sole traders</h4>
                              <p>£10 GBP<br />~ $12.60 USD</p>
					<p><a href="https://www.paypal.com/webapps/billing/plans/subscribe?plan_id=P-9AF72318UN401454TMJWYB5I" target="blank">
                              <img src="<?php echo xsgPluginPath(); ?>assets/paypal.png" /></a></p>
                              <p><a href="https://www.buymeacoffee.com/xmlsitemaps"  target="blank"  >
                                    <img width="120" height="35" src="<?php echo xsgPluginPath(); ?>assets/buymeacoffee.png" /> </a></p>     
                        </div>

                        <div style=" display:inline-block; text-align:center; padding:1em; width:150px;border:solid 1px #CCCCCC; margin-right:1em;">
                              <h4>Small busineses</h4>
                              <p>£20 GBP<br />~ $25.20 USD</p>
					<p><a href="https://www.paypal.com/webapps/billing/plans/subscribe?plan_id=P-8D144606MX3223435MJWYDCI" target="blank">
                              <img src="<?php echo xsgPluginPath(); ?>assets/paypal.png" /></a></p>
                              <p><a href="https://www.buymeacoffee.com/xmlsitemaps"  target="blank"  >
                                    <img width="120" height="35" src="<?php echo xsgPluginPath(); ?>assets/buymeacoffee.png" /> </a></p>      
                        </div>				
                        
                        <div style=" display:inline-block; text-align:center; padding:1em; width:150px;border:solid 1px #CCCCCC; margin-right:1em;">
                              <h4>Larger businesses</h4>
                              <p>£50 GBP <br />~ $61.67  USD</p>
					<p><a href="https://www.paypal.com/webapps/billing/plans/subscribe?plan_id=P-0A784764VU256342JMJWYD7I" target="blank">
                              <img src="<?php echo xsgPluginPath(); ?>assets/paypal.png" /></a></p>
                              <p><a href="https://www.buymeacoffee.com/xmlsitemaps"  target="blank"  >
                                    <img width="120" height="35" src="<?php echo xsgPluginPath(); ?>assets/buymeacoffee.png" /> </a></p>       
                         </div>

                        </div>
      </div>

	<div  class="postbox">
		<h3 class="hndle"><span>Output urls</span></h3>
		<div class="inside">
				<p>You can change the URL for the various sitemap files using the settings below. Set it to an empty string to disable.</p>
				<p>Caution should be take to avoid conflicts with other plugins which might output similar files. Please ensure it is a simple filename with no slashes and only one dot.</p>
				<table><tr><td>
					<p>
						<label for="email"   >XML Sitemap URL</label><br />
						<input type="text" name="urlXmlSitemap" size="40" value="<?php echo Helpers::safeRead($globalsettings,"urlXmlSitemap"); ?>" />
					</p>
	
					<p>
						<label for="email"   >RSS Sitemap URL</label><br />
						<input type="text" name="urlRssSitemap" size="40" value="<?php echo Helpers::safeRead($globalsettings,"urlRssSitemap"); ?>" />
					</p>
					<p>
						<label for="email"   >HTML Sitemap URL</label><br />
						<input type="text" name="urlHtmlSitemap" size="40" value="<?php echo Helpers::safeRead($globalsettings,"urlHtmlSitemap"); ?>" />
					</p> 
				</td><td>&nbsp;</td><td style="vertical-align:top">
				<p>
						<label for="email"   >XML News Sitemap URL</label><br />
						<input type="text" name="urlNewsSitemap" size="40" value="<?php echo Helpers::safeRead($globalsettings,"urlNewsSitemap"); ?>" />
					</p>
					<p>
						<label for="email"   >RSS Latest URLs</label><br />
						<input type="text" name="urlRssLatest" size="40" value="<?php echo Helpers::safeRead($globalsettings,"urlRssLatest"); ?>" />
					</p> 
				

				</td></tr></table>
		</div>
	</div> 
		
	<div  class="postbox">
		<h3 class="hndle"><span>General settings</span></h3>
		<div class="inside">

			
					<ul class="defaultsList">
					
						<li>News sitemap : <input type="radio" name="newsMode" value="0" <?php checked($globalsettings->newsMode, '0'); ?>  > 
							Disabled &nbsp;<input type="radio" name="newsMode" value="1" <?php checked($globalsettings->newsMode, '1'); ?> > 
							Include all posts &nbsp;<input type="radio" name="newsMode" value="2" <?php checked($globalsettings->newsMode, '2'); ?> > Selected tags / categories 
						</li>
					
						<li>
							<input type="checkbox" name="enableImages" id="enableImages" value="1" <?php checked($globalsettings->enableImages, '1'); ?> /> 
							<label for="sm_b_ping">Enable images in sitemap</label><br>
						</li>

						<li>
							<input type="checkbox" name="pingSitemap" id="pingSitemap" value="1" <?php checked($globalsettings->pingSitemap, '1'); ?> /> 
							<label for="sm_b_ping">Automatically ping Google / Bing (MSN & Yahoo) daily</label><br>
						</li>
						<li>
							<input type="checkbox" name="addRssToHead" id=""addRssToHead" value="1" <?php checked($globalsettings->addRssToHead, '1'); ?> />
							<label for="sm_b_ping">Add latest pages / post RSS feed to head tag</label><br>
						</li>
						<li>
							<input type="checkbox" name="addToRobots" id="addToRobots" value="1" <?php checked($globalsettings->addToRobots, '1'); ?> />
							<label for="sm_b_ping">Add sitemap links to your robots.txt file</label><br>
						</li>

					</ul>
		</div>
	</div> 

 
	
		
	<div  class="postbox">
		<h3 class="hndle"><span>Sitemap defaults</span></h3>
		<div class="inside">
		
               
				<p>Set the defaults for your sitemap here.</p>
				
				<ul>
										<li>
							<select name="dateField" id="dateField">
								<option  <?php  if ($sitemapDefaults->dateField == "created") {echo 'selected="selected"';} ?>>created</option>
								<option <?php  if ($sitemapDefaults->dateField == "updated") {echo 'selected="selected"';} ?>>updated</option>
							</select>
							<label for="sm_b_ping">  date field to use for modified date / recently updated.</label><br>
						</li>
					</ul>
					
				<p>You can override the sitemap default settings for taxonomy items (categories, tags, etc), pages and posts when adding and editing them.</p>
		
						<table class="wp-list-table widefat fixed striped tags" style="clear:none;"  aria-label="General sitemap defaults">
							<thead>
							<tr>
								<th scope="col">Page / area</th>
								<th scope="col">Exclude</th>
								<th scope="col">Relative priority</th>
								<th scope="col">Update frequency</th>
								<th scope="col">Include scheduled</th>
							</tr>
							</thead>
							<tbody id="the-list" >
							
							
<?php 

		self::RenderDefaultSection("Home page","homepage",$sitemapDefaults->homepage, false);
		self::RenderDefaultSection("Regular page","pages",$sitemapDefaults->pages, true);
		self::RenderDefaultSection("Post page","posts",$sitemapDefaults->posts, true);
		self::RenderDefaultSection("Taxonomy - categories","taxonomyCategories",$sitemapDefaults->taxonomyCategories, false);
		self::RenderDefaultSection("Taxonomy - tags","taxonomyTags",$sitemapDefaults->taxonomyTags, false);
 
		self::RenderDefaultSection("Archive - recent","recentArchive",$sitemapDefaults->recentArchive, false);
		self::RenderDefaultSection("Archive - old","oldArchive",$sitemapDefaults->oldArchive, false);
		self::RenderDefaultSection("Authors","authors",$sitemapDefaults->authors, false);
?>
</table>

<p>Custom post types<p/>
<table class="wp-list-table widefat fixed striped tags" style="clear:none;"  aria-label="Custom posts sitemap defaults">
							<thead>
							<tr>
								<th scope="col">Page / area</th>
								<th scope="col">Exclude</th>
								<th scope="col">Relative priority</th>
								<th scope="col">Update frequency</th>
								<th scope="col">Include scheduled</th>
							</tr>
							</thead>
							
<?php 
		foreach ( self::getPostTypes()  as $post_type ) 
		{
			self::RenderDefaultSection($post_type,$post_type, self::postTypeDefault($sitemapDefaults,$post_type), true);
		}
 ?>
							
						
				
							
						</tbody></table>
                		 
          </div>
	</div>

		<div  class="postbox">
		<h3 class="hndle"><span>Robots.txt</span></h3> 
		<div class="inside">
			 <p>Add custom entries to your robots.txt file.</p>  		 
			<textarea name="robotEntries" id="robotEntries" rows="10" style="width:98%;"><?php echo Helpers::safeRead($globalsettings,"robotEntries"); ?></textarea>
			
		</div>
	</div> 
	
<?php submit_button(); ?>


	<div  class="postbox">
		<h3 class="hndle"><span>Log</span></h3> 
		<div class="inside">
			   		 
			<?php echo Core::getStatusHtml();?>
		</div>
	</div> 
						
</div>

</div>

</div>

</div>
</div>

</form>

	<?php 

	}
	

	
}	 




?>