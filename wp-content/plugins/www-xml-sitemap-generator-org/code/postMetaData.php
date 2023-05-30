<?php
namespace xmlSitemapGenerator;

include_once 'dataAccess.php';
include_once 'helpers.php';

class PostMetaData
{
 

	
	public static function addHooks() {

		add_action('save_post',  array(__CLASS__, 'handlePostBack' ) , 10, 2 );			
		add_action( 'add_meta_boxes', array(__CLASS__, 'addMetaBoxMenu' ) );	
	}
	
	static function addMetaBoxMenu() {
		add_meta_box(
			'wpXSG-meta',					// Unique ID
			'XML Sitemap',				// Title
			array(__CLASS__, 'render' ),	// Callback function
			null,						// Screen
			'side',						// Context - note side requires 2.7
			'core'						// Priority
		);
	}

	static function  handlePostBack( $post_id , $post) {

		/* Verify the nonce before proceeding. */
	 	if ( !isset( $_POST['wpXSG_meta_nonce'] ) || !wp_verify_nonce( $_POST['wpXSG_meta_nonce'], basename( __FILE__ ) ) ) {return ;}
	
	
		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );
		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {return $post_id;}

		if ( $parent_id = wp_is_post_revision( $post_id ) ) {$post_id = $parent_id;}

		$settings = new MetaSettings();
		$settings->itemId = $post_id;
		$settings->itemType = "post";
		$settings->exclude = Helpers::getFieldValue('wpXSG-Exclude', '0' );
		$settings->priority = Helpers::getFieldValue('wpXSG-Priority', 'default' );
		$settings->frequency = Helpers::getFieldValue('wpXSG-Frequency', 'default' );
		$settings->news = 0 ;

		 DataAccess::saveMetaItem($settings);
		 
		 return $post_id;

	}
	
	
	static function render( $post ) 
	{
	
		
	 	$settings =   dataAccess::getMetaItem($post->ID , "post");  
 
	  wp_nonce_field( basename( __FILE__ ), 'wpXSG_meta_nonce' );
	
		?>
		
		

	<div class="components-panel__row"><div class="components-base-control"><div class="components-base-control__field">
		<label class="components-base-control__label"  for="wpXSG-Exclude">Sitemap inclusion</label><br />
		<select  name="wpXSG-Exclude" id="wpXSG-Exclude" ></select>
	</div></div></div>
	<div class="components-panel__row"><div class="components-base-control"><div class="components-base-control__field">
		<label class="components-base-control__label"  for="wpXSG-Priority">Relative priority</label><br />
		<select  name="wpXSG-Priority" id="wpXSG-Priority" ></select>
	</div></div></div>
	<div class="components-panel__row"><div class="components-base-control"><div class="components-base-control__field">
		<label class="components-base-control__label"  for="wpXSG-Frequency">Update frequency</label><br />
		<select  name="wpXSG-Frequency" id="wpXSG-Frequency" ></select>
	</div></div></div>


<script>
  xsg_populate("wpXSG-Exclude" ,excludeSelect, <?php echo esc_attr($settings->exclude);  ?>);
  xsg_populate("wpXSG-Priority" ,prioritySelect, <?php echo esc_attr($settings->priority);  ?>);
  xsg_populate("wpXSG-Frequency" ,frequencySelect, <?php echo esc_attr($settings->frequency);  ?>);
	 
</script>
		<?php

	
	}
 

 

 

}

?>