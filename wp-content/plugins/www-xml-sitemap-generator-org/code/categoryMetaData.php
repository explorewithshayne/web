<?php
namespace xmlSitemapGenerator;

include_once 'dataAccess.php';

class CategoryMetaData
{
 
	public static function addHooks()
	{
		$taxonomy = Helpers::getRequestValue('taxonomy','0' );
		add_action($taxonomy . '_edit_form',  array( __CLASS__, 'renderEdit' ) );
	    add_action($taxonomy . '_add_form_fields', array( __CLASS__, 'renderAdd' ) );
		add_action( 'created_' . $taxonomy, array( __CLASS__, 'save_metaData' ), 10, 2);
		add_action( 'edited_' . $taxonomy , array( __CLASS__, 'save_metaData' ), 10, 2); 
		
	}

 
	static function save_metaData( $term_id) {
		
		/* Verify the nonce before proceeding. */
	 	if ( !isset( $_POST['wpXSG_meta_nonce'] ) || !wp_verify_nonce( $_POST['wpXSG_meta_nonce'], basename( __FILE__ ) ) ) { return ;}

	 
		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( 'manage_categories') ) {return ;}

	 	$settings = new MetaSettings();
		
		$settings->id =  Helpers::getFieldValue('wpXSG-metaId' , '0' );
	 	$settings->itemId = $term_id ;
		$settings->itemType = "taxonomy";
	 	$settings->exclude = Helpers::getFieldValue('wpXSG-Exclude' , '0' );
	 	$settings->priority = Helpers::getFieldValue('wpXSG-Priority' , 'default' );
	  	$settings->frequency = Helpers::getFieldValue('wpXSG-Frequency', 'default' );
		$settings->inherit =Helpers::getFieldValue('wpXSG-Inherit', 0 );
		$settings->news =Helpers::getFieldValue('wpXSG-News', 0 );
		DataAccess::saveMetaItem($settings );

	}
	
	
	
 	static function renderAdd($term_id  ) 
	{
		self::addHooks();
			
		$settings = new MetaSettings(1,1,1,0);
		$globalSettings =   Core::getGlobalSettings();
		
		wp_nonce_field( basename( __FILE__ ), 'wpXSG_meta_nonce' );
		?>
 
	<h3>Sitemap settings</h3>
	
	<p>Sitemap settings can be setup for individual categories/tags overriding the global settings. Category/tag settings will be inherited by related posts.<br /><br /></p>
	
	 <div class="form-field term-description-wrap">
		
		<label for="wpXSG-Exclude">Sitemap inclusion</label>
		<select  name="wpXSG-Exclude" id="wpXSG-Exclude" ></select>

		<p>Exclude this category/tag from your sitemap.</p>
	</div>

	 <div class="form-field term-description-wrap">
		<label for="wpXSG-Priority">Relative priority</label>
		<select  name="wpXSG-Priority" id="wpXSG-Priority" ></select>
		<p>Relative priority for this category/tag.</p>
	</div>
	
	<div class="form-field term-description-wrap">
		<label for="wpXSG-Frequency">Update frequency</label>
		<select  name="wpXSG-Frequency" id="wpXSG-Frequency" ></select>
		<p>Sitemap update frequency for this category/tag .</p>
	</div>

	<div class="form-field term-description-wrap">
		<label for="wpXSG-Inherit">Posts inheritance</label>
		<select  name="wpXSG-Inherit" id="wpXSG-Inherit" ></select>
		<p>Immediate child posts/pages inherit these settings.</p>
	</div>

		<?php if ($globalSettings->newsMode == '2') {   ?>
		<div class="form-field term-description-wrap">
		 <label for="description">Include in news</label> 
			<td>
			<select  name="wpXSG-News" id="wpXSG-News" ></select>
			<p>Include this category/tag in news feeds.</p>
		</div>
	<?php } ?>
	
<script>
  xsg_populate("wpXSG-Exclude" ,excludeSelect, <?php echo esc_attr($settings->exclude ); ?>);
  xsg_populate("wpXSG-Priority" ,prioritySelect, <?php echo esc_attr($settings->priority);  ?>);
  xsg_populate("wpXSG-Frequency" ,frequencySelect, <?php echo esc_attr($settings->frequency);  ?>);
  xsg_populate("wpXSG-Inherit" ,inheritSelect, <?php echo esc_attr($settings->inherit);  ?>);
  xsg_populate("wpXSG-News" ,newsSelect, <?php echo esc_attr($settings->news) ?>);
</script>
		
		<?php
	
	}

	static function renderEdit($tag ) 
	{
		$term_id = $tag->term_id;
		self::addHooks();
		
		$settings =  DataAccess::getMetaItem($term_id , "taxonomy");  
		$globalSettings =   Core::getGlobalSettings();
	 
			wp_nonce_field( basename( __FILE__ ), 'wpXSG_meta_nonce' );
		?>

		
		<h3>Sitemap settings : 	 </h3>
	


		
		<table class="form-table">
		<tbody><tr class="form-field form-required term-name-wrap">
			<th scope="row"><label for="name">Sitemap inclusion</label></th>
			<td>
				<select  name="wpXSG-Exclude" id="wpXSG-Exclude" ></select>
				<p> Exclude this category/tag from your sitemap.</p>
			</td>
		</tr>
		<tr class="form-field term-slug-wrap">
			<th scope="row"><label for="slug">Relative priority</label></th>
			<td>
				<select  name="wpXSG-Priority" id="wpXSG-Priority" ></select>
				<p>Relative priority for this category/tag and related posts.</p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="description">Update frequency</label></th>
			<td>
			<select  name="wpXSG-Frequency" id="wpXSG-Frequency" ></select>
			<p>Sitemap update frequency for this category/tag.</p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row"><label for="description">Post inheritance</label></th>
			<td>
			<select  name="wpXSG-Inherit" id="wpXSG-Inherit" ></select>
			<p>Immediate child posts/pages inherit these settings.</p>
			</td>
		</tr>
		<?php if ($globalSettings->newsMode == '2') {   ?>
		<tr class="form-field">
			<th scope="row"><label for="description">Include in news</label></th>
			<td>
			<select  name="wpXSG-News" id="wpXSG-News" ></select>
			<p>Include this category/tag in news feeds.</p>
			</td>
		</tr>
	<?php } ?>
		</tbody></table>

<script>
  xsg_populate("wpXSG-Exclude" ,excludeSelect, <?php echo esc_attr($settings->exclude);  ?>);
  xsg_populate("wpXSG-Priority" ,prioritySelect, <?php echo esc_attr($settings->priority);  ?>);
  xsg_populate("wpXSG-Frequency" ,frequencySelect, <?php echo esc_attr($settings->frequency);  ?>);
  xsg_populate("wpXSG-Inherit" ,inheritSelect, <?php echo esc_attr($settings->inherit);  ?>);
  xsg_populate("wpXSG-News" ,newsSelect, <?php echo esc_attr($settings->news); ?>);
</script>


		<?php
	
	}
 
}

?>