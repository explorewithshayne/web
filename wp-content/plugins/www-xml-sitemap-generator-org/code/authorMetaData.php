<?php
namespace xmlSitemapGenerator;

include_once 'dataAccess.php';
include_once 'helpers.php';

class AuthorMetaData
{
 
	public static function addHooks()
	{
	 
		add_action('edit_user_profile',  array( __CLASS__, 'renderEdit' ) );
		add_action( 'profile_update'   , array( __CLASS__, 'save_metaData' ), 10, 2); 
		
	}

 
	static function save_metaData($userId ) {
		
		/* Verify the nonce before proceeding. */
	 	if ( !isset( $_POST['wpXSG_meta_nonce'] ) || !wp_verify_nonce( $_POST['wpXSG_meta_nonce'], basename( __FILE__ ) ) ) {return ;}

		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( 'edit_user') ){return ;}

 
	 	$settings = new MetaSettings();
		
		$settings->id =  helpers::getFieldValue('wpXSG-metaId' , '0' );
	 	$settings->itemId = $userId ;
		$settings->itemType = "author";
	 	$settings->exclude = Helpers::getFieldValue('wpXSG-Exclude' , '0' );
	 	$settings->priority = Helpers::getFieldValue('wpXSG-Priority' , 'default' );
	  	$settings->frequency = Helpers::getFieldValue('wpXSG-Frequency' , 'default' );
		$settings->inherit = Helpers::getFieldValue('wpXSG-Inherit' , 0 );
			
		DataAccess::saveMetaItem($settings );


	}
	
	
 

	static function renderEdit($WP_User ) 
	{
		$userId = $WP_User->ID;
		self::addHooks();
		
		$settings =  DataAccess::getMetaItem($userId , "author");  
 
	 
			wp_nonce_field( basename( __FILE__ ), 'wpXSG_meta_nonce' );
		?>

		
		<h3>Sitemap settings : 	 </h3>
	


		
		<table class="form-table" aria-label="Sitemap settings">  
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
		<tr class="form-field term-description-wrap">
			<th scope="row"><label for="description">Update frequency</label></th>
			<td>
			<select  name="wpXSG-Frequency" id="wpXSG-Frequency" ></select>
			<p>Sitemap update frequency for this category/tag.</p>
			</td>
		</tr>

		</tbody></table>

<script>
  xsg_populate("wpXSG-Exclude" ,excludeSelect, <?php echo esc_attr($settings->exclude)  ?>);
  xsg_populate("wpXSG-Priority" ,prioritySelect, <?php echo esc_attr($settings->priority)  ?>);
  xsg_populate("wpXSG-Frequency" ,frequencySelect, <?php echo esc_attr($settings->frequency) ?>);
  xsg_populate("wpXSG-Inherit" ,inheritSelect, <?php echo esc_attr($settings->inherit)  ?>);
</script>


		<?php
	
	}
 


		
 

}

?>