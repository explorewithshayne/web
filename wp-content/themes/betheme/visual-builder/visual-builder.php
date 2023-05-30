<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

$replaced_logo = apply_filters('betheme_logo', '') ? 'style="background-image:url('. apply_filters('betheme_logo_nohtml', ''). ')"' : '';

require_once( get_theme_file_path('/functions/builder/class-mfn-builder-front.php') );
require_once( get_theme_file_path('/muffin-options/fields/class-mfn-options-field.php'));
require_once( get_theme_file_path('/functions/builder/class-mfn-builder-items.php') );
require_once( get_theme_file_path('/functions/builder/class-mfn-builder-ajax.php'));
require_once( get_theme_file_path('/muffin-options/icons.php') );

require_once( get_theme_file_path('/visual-builder/classes/visual-builder-class.php') );

if( is_admin() ){

	// classic editor link
	add_action( 'edit_form_after_title', 'mfnvb_ce_live_button' );

	function mfnvb_ce_live_button($post) {
		if( !current_user_can( 'edit_post', $post->ID ) ){ return; }
		if( in_array($post->post_type, array('page', 'post', 'portfolio', 'template', 'product')) ){
			global $replaced_logo;

			$link = admin_url('/post.php?post='. $post->ID .'&preview=true&action='. apply_filters('betheme_slug', 'mfn') .'-live-builder');

			if( get_post_status($post->ID) == 'publish' ) {
				$link = admin_url('/post.php?post='. $post->ID .'&action='. apply_filters('betheme_slug', 'mfn').'-live-builder');
			}

			echo '<div class="mfn-live-edit-page-button classic"><a '. $replaced_logo .' href="'.$link.'" class="mfn-btn mfn-switch-live-editor button-hero mfn-btn-green button button-primary">Edit with '. apply_filters('betheme_label', "Be") .'Builder</a></div>';
		}
	}

	// gutenberg script
	add_action( 'enqueue_block_editor_assets', 'mfnvb_gutenberg_functions' );

	function mfnvb_gutenberg_functions() {
	    wp_enqueue_script(
	        'mfn-page-edit-button',
	        get_theme_file_uri('/visual-builder/assets/js/button.js'),
	        array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
	        time()
	    );
	}

	// add live builder link in admin page table
	add_filter( 'post_row_actions', 'mfnvb_list_row_actions', 10, 2 );
	add_filter( 'page_row_actions', 'mfnvb_list_row_actions', 10, 2 );

	function mfnvb_list_row_actions( $actions, $post ) {
		if( !current_user_can( 'edit_post', $post->ID ) ) return $actions;
	    if ( in_array($post->post_type, array("page", "post", "portfolio", "template", "product")) ) {
	 		$actions[] = '<span class="mfn-edit-link"><a href="'.admin_url( 'post.php?post=' . $post->ID . '&action='. apply_filters('betheme_slug', 'mfn') .'-live-builder' ).'" aria-label="Edit with '. apply_filters('betheme_label', "Be") .'Builder">Edit with '. apply_filters('betheme_label', "Be") .'Builder</a></span>';
	    }
	    return $actions;
	}

	// init vb class
	add_action( 'post_action_'. apply_filters('betheme_slug', 'mfn') .'-live-builder', 'mfnvb_init_vb' );
}

function mfnvb_init_vb($id){

	if( ! current_user_can( 'edit_post', $id ) && ! defined('BEBUILDER_DEMO_VERSION') ){
		wp_die();
	}

	if( get_post_type($id) == 'template' ) flush_rewrite_rules(false);
	
	$mfnVisualBuilder = new MfnVisualBuilder();

	if( is_admin() ){
		add_action( 'admin_enqueue_scripts', array( $mfnVisualBuilder, 'mfn_append_vb_styles'), 9999 );
	}else{
		remove_action('wp_enqueue_scripts', 'mfn_styles');
		add_action( 'wp_enqueue_scripts', array( $mfnVisualBuilder, 'mfn_append_vb_styles'), 9999 );
	}

	$mfnVisualBuilder->mfn_load_sidebar();

	exit();
}

// save draft
add_action( 'wp_ajax_mfnvbsavedraft', 'mfnvb_save_draft'  );

function mfnvb_save_draft(){

	if( !current_user_can( 'edit_post', $_POST['id'] ) ){ wp_die(); }

	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	if( get_post_status($_POST['id']) == 'auto-draft' ){

		$name = 'BeBuilder #'.$_POST['id'];
		$slug = sanitize_title($name);

		wp_update_post( array(
			'ID'           	=> $_POST['id'],
			'post_title'    => $name,
		  	'post_name'		=> $slug,
			'post_status'   => 'draft',
		));

		update_post_meta($_POST['id'], 'mfn-page-items', '');

		if( !empty($_POST['tmpl']) ){
			update_post_meta($_POST['id'], 'mfn_template_type', $_POST['tmpl']);
		}

	}

	wp_die();
}

// take post editing
add_action( 'wp_ajax_takepostediting', 'mfnvb_take_post_editing'  );

function mfnvb_take_post_editing(){

	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }

	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$request = $_POST;
	$post_id = $request['pageid'];

	wp_set_post_lock( $post_id );

	wp_die();
}

// update view
add_action( 'wp_ajax_updatevbview', 'mfnvb_updateVbView' );

function mfnvb_updateVbView(){

	global $wpdb;

	$admin = new Mfn_Builder_Admin();
	$sel_prefix = '';

	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }

	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$style_str = '';
	$tmpl_type = false;

	$save = array();

	$request = $_POST;
	$post_id = $request['pageid'];
	$sections = json_decode( stripslashes ($request['sections']), true );

	$post_type = get_post_type($post_id);
	if( $post_type == 'template' ) $tmpl_type = get_post_meta($post_id, 'mfn_template_type', true);

	if( $post_type == 'template' && $tmpl_type == 'header' ){
		$style_str .= '.mfn-header-tmpl ';
	}

	$mfn_update_post = array(
    	'ID' => $post_id,
    	'post_modified' => date('Y-m-d H:i:s'),
    	'post_modified_gmt' => gmdate('Y-m-d H:i:s', time())
	);

	if( isset($request['savetype']) && in_array($request['savetype'], array('draft', 'publish')) ){
		$mfn_update_post['post_status'] = $request['savetype'];
	}

	if( defined( 'ICL_SITEPRESS_VERSION' ) ){
		wp_update_post( $mfn_update_post );
	}else{
		unset( $mfn_update_post['ID'] );
		$wpdb->update( $wpdb->posts, $mfn_update_post, array( 'ID' => $post_id ) );
	}

	/** START template conditions */
	if ( $post_type == 'template' ){
		// conditions
		if ( isset( $_POST['mfn_template_conditions'] ) && is_array( $_POST['mfn_template_conditions'] ) && count($_POST['mfn_template_conditions']) > 0 ) {
			$tmpl_conditions = $_POST['mfn_template_conditions'];
			update_post_meta( $post_id, 'mfn_template_conditions', json_encode( $tmpl_conditions ) );
		}else{
			delete_post_meta( $post_id, 'mfn_template_conditions' );
		}
		if( in_array($tmpl_type, array('single-product', 'shop-archive')) ){
			$admin->set_woo_templates_conditions();
		}else if( in_array($tmpl_type, array('popup')) ){
			$admin->set_addons_templates_conditions( $tmpl_type );
		}else{
			$admin->set_global_templates_conditions( $tmpl_type );
		}
	}

	if( $post_type == 'product' ){
		$admin->set_woo_templates_conditions();
	}
	/** END template conditions */

	if( isset($sections) && count($sections) > 0 ){

		$mfn_styles = Mfn_Helper::preparePostUpdate($sections, $post_id);

		if(isset($mfn_styles['fonts']) && count($mfn_styles['fonts']) > 0){
			update_post_meta( $post_id, 'mfn-page-fonts', json_encode($mfn_styles['fonts']) );
		}else{
			delete_post_meta( $post_id, 'mfn-page-fonts' );
		}

		if( count($mfn_styles) > 0 ){
			$styles = $mfn_styles;
			unset($styles['sections']);
			update_post_meta( $post_id, 'mfn-page-local-style', json_encode($styles) );
			Mfn_Helper::generate_css($styles, $post_id);

			unset($styles);
			//print_r($mfn_styles);
		}else{
			delete_post_meta( $post_id, 'mfn-page-local-style' );
		}

		$save = wp_unslash($mfn_styles['sections']);

		if ( 'encode' == mfn_opts_get('builder-storage') ) {
			$new = call_user_func('base'.'64_encode', serialize($save));
		}else{
			$new = wp_slash( $save );
		}
		$old = get_post_meta($post_id, 'mfn-page-items', true);

		if (isset($new) && $new != $old) {
			update_post_meta($post_id, 'mfn-page-items', $new);

			$mfn_ajax = new Mfn_Builder_Ajax();
			$revisions = $mfn_ajax->set_revision( $post_id, 'update', $new );

			wp_send_json( $mfn_ajax->get_revisions_json( $revisions ) );

		}

		// WP Rocket cache clear
		if ( function_exists( 'rocket_clean_domain' ) ) rocket_clean_domain();
		if ( function_exists( 'rocket_clean_minify' ) ) rocket_clean_minify();

	}else{
		delete_post_meta($post_id, 'mfn-page-items');
	}

	wp_die();
}

// generate preview
add_action( 'wp_ajax_generatepreview', 'mfnvb_generatePreview'  );

function mfnvb_generatePreview(){

	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$request = $_POST;
	$post_id = $request['pageid'];
	$type = $request['gtype'];
	$sections = json_decode( stripslashes ($request['sections']), true );

	if( isset($sections) && count($sections) > 0 ){

		$mfn_styles = Mfn_Helper::preparePostUpdate($sections, $post_id);

		if(count($mfn_styles['fonts']) > 0){
			update_post_meta( $post_id, 'mfn-builder-preview-fonts', json_encode($mfn_styles['fonts']) );
		}else{
			delete_post_meta( $post_id, 'mfn-builder-preview-fonts' );
		}

		if( count($mfn_styles) > 0 ){
			update_post_meta( $post_id, 'mfn-builder-preview-local-style', json_encode($mfn_styles) );
			Mfn_Helper::generate_css($mfn_styles, $post_id, 'preview');

			// print_r($mfn_styles);
		}else{
			delete_post_meta( $post_id, 'mfn-builder-preview-local-style' );
		}

		$save = wp_unslash($mfn_styles['sections']);

		if ( 'encode' == mfn_opts_get('builder-storage') ) {
			$new = call_user_func('base'.'64_encode', serialize($save));
		}else{
			$new = wp_slash( $save );
		}

		update_post_meta($post_id, $type, $new);

	}else{
		delete_post_meta($post_id, $type);
	}

	$preview_link = str_replace('preview=true', apply_filters('betheme_slug', 'mfn').'-preview=true', get_preview_post_link($post_id));
	wp_send_json( $preview_link );

	wp_die();
}

// set revision
add_action( 'wp_ajax_setrevision', 'mfnvb_set_revision'  );

function mfnvb_set_revision(){

	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$request = $_POST;
	$post_id = $request['pageid'];
	$type = $request['revtype'];

	if( !empty($request['sections']) ){
		$sections = json_decode( stripslashes ($request['sections']), true );

		ksort($sections);

		$save = wp_unslash($sections);

		$new = call_user_func('base'.'64_encode', serialize($save));

		$mfn_ajax = new Mfn_Builder_Ajax();
		$revisions = $mfn_ajax->set_revision( $post_id, $type, $new );
		wp_send_json( $mfn_ajax->get_revisions_json( $revisions ) );
	}else{
		echo 'empty';
	}



	wp_die();
}

// copy to clipboard

/*add_action( 'wp_ajax_mfntoclipboard', 'mfnvb_copytoclipboard' );

function mfnvb_copytoclipboard(){

	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	if( !empty($_POST['sections']) ){
		$save = $request['sections'];
		echo $save;
	}else{
		echo '';
	}

	wp_die();
}*/

// save preset

add_action( 'wp_ajax_mfnsavepreset', 'mfnvb_savepreset' );

function mfnvb_savepreset(){

	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$mfnvb = new MfnVisualBuilder();
	$all = $mfnvb->getPresets();

	$new_item = array();

	$items = !empty($_POST['sections']) ? $_POST['sections'] : [];
	$name = $_POST['name'];
	$item = $_POST['item'];

	$new_item['name'] = $name;
	$new_item['item'] = $item;
	$new_item['type'] = 'custom';
	$new_item['uid'] = Mfn_Builder_Helper::unique_ID();
	$new_item['fields'] = $items;

	$all[] = $new_item;

	update_option( 'mfn-presets', json_encode( $all ) );

	wp_send_json( $mfnvb->getPresets(true) );

	wp_die();
}

add_action('wp_ajax_mfnremovepreset', 'mfnvb_removepreset');

function mfnvb_removepreset() {
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$mfnvb = new MfnVisualBuilder();
	$all = $mfnvb->getPresets();

	$new = array();

	$id = $_POST['item'];

	if( count( $all ) > 0 ){

		foreach ($all as $v) {
			if( $v->uid != $id ){
				$new[] = $v;
			}
		}
	}

	update_option( 'mfn-presets', json_encode( $new ) );

	wp_die();
}


add_action('wp_ajax_mfnimportpreset', 'mfnvb_importpresets');

function mfnvb_importpresets() {
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$mfnvb = new MfnVisualBuilder();
	$all = $mfnvb->getPresets(true);
	$custom = $mfnvb->getPresets();

	$new = $_POST['val'];

	if( count( $new ) > 0 ){

		foreach ($new as $n) {
			//echo $n['uid'].' imported | ';
			$n['type'] = 'custom';

			$check_uid = array_filter($all, function($obj) use ($n) {
			    if (isset($obj->uid) && $obj->uid == $n['uid']) return true;

			    return false;
			});

			if( !$check_uid ) $custom[] = $n;
		}

	}

	update_option( 'mfn-presets', json_encode( $custom ) );
	wp_send_json( $mfnvb->getPresets(true) );

	wp_die();
}


// builder to seo

add_action( 'wp_ajax_mfnvb_builder_seo', 'mfnvb_builder_to_seo'  );

function mfnvb_builder_to_seo() {

	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$items = json_decode( stripslashes ($_POST['sections']), true );
	$id = $_POST['pageid'];

	$front = new Mfn_Builder_Front($id);

	Mfn_Builder_Front::$item_id = $id;

	ob_start();
	$front->show_sections($items, true);
	$html = ob_get_contents();
	ob_end_clean();

	Mfn_Builder_Front::$item_id = false;


	$striped_html = get_the_content(null, false, $id) . strip_tags( $html, array('p','a','h1','h2','h3','h4','h5','h6','ul','ol','li','strong','b','span', 'img') );

	wp_update_post( array(
		'ID'           	=> $id,
		'post_content'  => $striped_html,
	));

	wp_die();
}


// restore revision
add_action( 'wp_ajax_restorerevision', 'mfnvb_restore_revision'  );

function mfnvb_restore_revision(){

	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$uids = [];
	$return = array();

	$time = htmlspecialchars(trim($_POST['time']));
	$type = htmlspecialchars(trim($_POST['type']));
	$post_id = htmlspecialchars(trim($_POST['pageid']));

	if( ! $post_id || ! $time || ! $type ){
		return false;
	}

	$old = get_post_meta($post_id, 'mfn-page-items', true);

	// backup current version
	$mfn_ajax = new Mfn_Builder_Ajax();
	$revisions = $mfn_ajax->set_revision( $post_id, 'backup', $old );
	$return['revisions'] = $mfn_ajax->get_revisions_json( $revisions );

	$meta_key = 'mfn-builder-revision-'. $type;

	$revision_torestore = get_post_meta( $post_id, $meta_key, true );

	if( ! empty( $revision_torestore[$time] ) ){

		// unserialize backup

		if( !is_array($revision_torestore[$time]) ){
			$mfn_items = unserialize(call_user_func('base'.'64_decode', $revision_torestore[$time]));
		}else{
			$mfn_items = $revision_torestore[$time];
		}


		if ( is_array( $mfn_items ) ) {

			$render = mfnvb_renderView( $mfn_items, $post_id );

			$return['html'] = $render['html'];
			$return['form'] = $render['form'];
			$return['navigator'] = $render['navigator'];

			wp_send_json($return);

		}

	}


	wp_die();
}

// re render content
add_action('wp_ajax_rendercontent', 'mfnvb_contentrender');
add_action('wp_ajax_nopriv_rendercontent', 'mfnvb_contentrender');

function mfnvb_contentrender(){
	$return = array();
	//if(!is_user_logged_in()){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$val = wp_unslash($_POST['val']);
	//echo do_shortcode($val);

	if( !empty($_POST['vb_postid']) && get_post_type($_POST['vb_postid']) != 'template' && strpos($val, '}') !== false ){
		$val = str_replace('}', ':'.$_POST['vb_postid'].'}', $val);
	}

	$return['html'] = do_shortcode( be_dynamic_data($val), true);
	$return['uid'] = $_POST['uid'];

	wp_send_json($return);
	wp_die();
}

add_action('wp_ajax_mfn_post_option', 'mfnvb_savepostoption');

function mfnvb_savepostoption(){

	if( !current_user_can( 'edit_post', $_POST['id'] ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$id = $_POST['id'];
	$option = esc_html($_POST['option']);
	$value = esc_html($_POST['value']);

	if( $value == '0' && in_array($option, array('mfn_header_template', 'mfn_footer_template')) ){
		delete_post_meta($id, $option);
	}else{
		update_post_meta($id, $option, $value);

		if( strpos($option, 'style:') !== false ){
			$explode = explode(':', $option);

			$csspath = str_replace('postid', $id, $explode[1]);
			$csspath = str_replace('|hover', ':hover', $csspath);
			
			$style = $explode[2];

			$existed = get_post_meta($id, 'mfn-page-options-style', true);
			//$existed = false;

			if( !$existed ){
				$existed = array();
			}else{
				$existed = (array) $existed;
			}

			if( !isset($existed[$csspath]) ) $existed[$csspath] = array();

			$existed[$csspath][$style] = $value;

			update_post_meta( $id, 'mfn-page-options-style', $existed );
		}
	}

	wp_die();
}


// re render widget
add_action('wp_ajax_rerenderwidget', 'mfnvb_render_widget');

function mfnvb_render_widget(){
	//if(!is_user_logged_in()){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$type = $_POST['type'];
	$attr = $_POST['attri'];
	$content = '';

	if(isset($attr['tabs']) && count($attr['tabs']) > 0){
		foreach ($attr['tabs'] as $t=>$tab) {
			if(isset($tab['content'])){
				$attr['tabs'][$t]['content'] = wp_unslash( $tab['content'] );
			}
		}
	}

	$fun_name = 'sc_'.$type;

	if(!empty($attr['content'])){
		$content = $attr['content'];
		wp_send_json($fun_name($attr, $content));
	}elseif($type == 'slider_plugin'){
		wp_send_json('<div class="mfn-widget-placeholder mfn-wp-revolution"></div>');
	}elseif($type == 'image_gallery'){
		wp_send_json(sc_gallery($attr));
	}elseif($type == 'shop' && class_exists( 'WC_Shortcode_Products' )){
		if( isset($attr['category']) && $attr['category'] == 'All' ) unset($attr['category']);
		$shortcode = new WC_Shortcode_Products( $attr, $attr['type'] );
		wp_send_json($shortcode->get_content());
	}elseif($type == 'shop_products'){
		unset($attr['title']);
		wp_send_json( sc_shop_products($attr, 'sample') );
	}else{
		wp_send_json($fun_name($attr));
	}

	wp_die();
}

// import data
add_action('wp_ajax_importdata', 'mfnvb_import_data');

function mfnvb_import_data(){
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }

	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$return = array();

	$id = $_POST['id'];
	$count = $_POST['count'];
	$single = $_POST['single'] ? true : false;

	$import = wp_unslash( $_POST['import'] );
	$mfn_items = json_decode( $import, true );

	if( ! is_array( $mfn_items ) ) return false;

	if( $single ){
		$mfn_items = [
			$mfn_items[0]
		];
	}

	$navigator = MfnVisualBuilder::getNavigatorTree($mfn_items);

	$render = mfnvb_renderView( $mfn_items, $id );

	$return['html'] = $render['html'];
	$return['form'] = $render['form'];
	$return['navigator'] = $render['navigator'];

	wp_send_json($return);

	wp_die();
}

// import single page
add_action('wp_ajax_importsinglepage', 'mfnvb_import_single_page');

function mfnvb_import_single_page(){
	if( !current_user_can( 'edit_post', $_POST['pageid'] ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$request = $_POST;
	$post_id = $request['pageid'];
	$page = $request['import'];
	$count = $_POST['count'];

	$pages_api = new Mfn_Single_Page_Import_API( $page );
	$response = $pages_api->remote_get_page();

	if( ! $response ){

		_e( 'Remote API error.', 'mfn-opts' );

	} elseif( is_wp_error( $response ) ){

		echo $response->get_error_message();

	} else {

		// unserialize response

		$mfn_items = json_decode( $response, true );

		if( ! is_array( $mfn_items ) ){
			return false;
		}

		// remove images url

		$builderajax = new Mfn_Builder_Ajax();

		$elements_to_skip = ['slider_plugin'];
		$regex = '/http(.*)\.(png|jpg|jpeg|gif|svg|webp|mp4)/m';

		$mfn_items = $builderajax->builder_replace( $regex, '', $mfn_items, $elements_to_skip );

		if ( is_array( $mfn_items ) ) {

			$render = mfnvb_renderView( $mfn_items, $post_id );

			//print_r($mfn_items);

			/*$return['html'] = $render['html'];
			$return['form'] = $render['form'];
			$return['navigator'] = $render['navigator'];*/

			wp_send_json($render);

		}else{
			echo 'Something went wrong.';
		}

	}


	wp_die();
}

// import template
add_action('wp_ajax_importtemplate', 'mfnvb_import_template');

function mfnvb_import_template(){
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$return = array();
	$mfn_helper = new Mfn_Builder_Helper();

	$request = $_POST;
	$id = $request['id'];
	//$count = $request['count'];

	$is_global_section = !empty($request['isGlobalSection']) && ($request['isGlobalSection'] === 'true');

	if ($is_global_section) {
		$request['import'] = $id;
	}

	$mfndata = get_post_meta($request['import'], 'mfn-page-items', true);

	$uids = [];

	if( !is_array($mfndata) ){
		$mfn_items = unserialize( call_user_func('base'.'64_decode', $mfndata) );
	}else{
		$mfn_items = $mfndata;
	}

	if( ! is_array( $mfn_items ) ) return false;

	$mfn_items = $mfn_helper->unique_ID_reset($mfn_items, $uids);

	//be sections - because of that, we know that it's global
	if ($is_global_section) {
		$mfn_items[0]['mfn_global_section_id'] = $id;
	}
	$render = mfnvb_renderView( $mfn_items, $id );

	$return['html'] = $render['html'];
	$return['form'] = $render['form'];
	$return['navigator'] = $render['navigator'];

	wp_send_json($return);

	wp_die();
}


// import template __ wrap only
add_action('wp_ajax_importtemplate_wraponly', 'mfnvb_import_template_wraponly');

function mfnvb_import_template_wraponly(){
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$return = array();
	$mfn_helper = new Mfn_Builder_Helper();

	$request = $_POST;
	$id = $request['id']; //its an template id
	$count = 2;

	$is_global_wrap = !empty($request['isGlobalWrap']) && ($request['isGlobalWrap'] === 'true');

	if ($is_global_wrap) {
		$request['import'] = $id;
	}

	$mfndata = get_post_meta($request['import'], 'mfn-page-items', true);

	$uids = [];

	if( !is_array($mfndata) ){
		$mfn_items = unserialize( call_user_func('base'.'64_decode', $mfndata) );
	}else{
		$mfn_items = $mfndata;
	}

	if( ! is_array( $mfn_items ) ) return false;

	$mfn_items = $mfn_helper->unique_ID_reset($mfn_items, $uids);

	//be sections --- global sections pbl
	if ($is_global_wrap) {
		$mfn_items[0]['wraps'][0]['attr']['global_wraps_select'] = $id;
		$mfn_items[0]['wraps'][0]['title'] = 'Global Wrap';
	}


	$mfnvb = new MfnVisualBuilder();
	$form = $mfnvb->loadElementsArr($mfn_items);

	ob_start();

	$front = new Mfn_Builder_Front($id);

	$front->show_wraps($mfn_items[0]['wraps'][0], $count, true);

	$html = ob_get_contents();

	ob_end_clean();

	$navigator = MfnVisualBuilder::getNavigatorTree($mfn_items);

	$return['html'] = $html;
	$return['form'] = $form;
	$return['navigator'] = $navigator;

	wp_send_json($return);

	wp_die();

	wp_die();
}
// insert prebuilt
add_action('wp_ajax_insertprebuilt', 'mfnvb_insert_prebuilt');
add_action('wp_ajax_nopriv_insertprebuilt', 'mfnvb_insert_prebuilt');

function mfnvb_insert_prebuilt(){
	//if( !is_user_logged_in() || !apply_filters('is_bebuilder_demo', true) ){ wp_die(); }

	$count = $_POST['count']++;
	$id = $_POST['id'];
	$post_id = $_POST['pageid'];

	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$return = array();

	if( ! $id ){
		return false;
	}

	$sections_api = new Mfn_Pre_Built_Sections_API( $id );
	$response = $sections_api->remote_get_section();

	if( ! $response ){

		_e( 'Remote API error.', 'mfn-opts' );

	} elseif( is_wp_error( $response ) ){

		echo $response->get_error_message();

	} else {

		$mfn_items = unserialize(call_user_func('base'.'64_decode', $response));

		if( ! is_array( $mfn_items ) ) return false;

		$placeholder_url = get_template_directory_uri() .'/functions/builder/pre-built/images/placeholders/';

		$mfn_ajax = new Mfn_Builder_Ajax();

		$mfn_items = $mfn_ajax->builder_replace( '/\#mfn_placeholder\#/', $placeholder_url, $mfn_items );

		$render = mfnvb_renderView( $mfn_items, $post_id );

		$return['html'] = $render['html'];
		$return['form'] = $render['form'];
		$return['navigator'] = $render['navigator'];

		wp_send_json($return);

	}

	wp_die();
}


// import from clipboard
add_action('wp_ajax_importfromclipboard', 'mfnvb_importfromclipboard');

function mfnvb_importfromclipboard(){
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );
	$return = array();

	$id = $_POST['id'];
	$type = $_POST['type'];

	$mfn_items = json_decode( wp_unslash($_POST['import']), true);

	if( ! is_array( $mfn_items ) ) return false;

	$render = mfnvb_renderView( $mfn_items, $id, $type );

	$return['html'] = $render['html'];
	$return['form'] = $render['form'];
	$return['navigator'] = $render['navigator'];

	wp_send_json($return);

	wp_die();
}

// favorites
add_action('wp_ajax_mfn_builder_favorites', 'mfnvb_builder_favorites');

function mfnvb_builder_favorites(){
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	$return = 'set';

	$favs_key = 'mfn_fav_items_'.get_current_user_id();

	$item = $_POST['item'];

	$current_favs = get_option( $favs_key );

	if( !$current_favs ){
		$current_favs = array();
	}else{
		$current_favs = (array) json_decode($current_favs);
	}

	if( in_array($item, $current_favs) ) {
	    array_splice($current_favs, array_search($item, $current_favs ), 1);
	    $return = 'unset';
	}else{
		$current_favs[] = $item;
	}

	update_option( $favs_key, json_encode($current_favs), false );

	wp_send_json($return);

	wp_die();
}

// template type
add_action('wp_ajax_mfncreatetemplate', 'mfnvb_createtemplate');

function mfnvb_createtemplate(){

	global $wpdb;

	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	if( get_post_status($_POST['id']) == 'auto-draft' ){

		$name = $_POST['name'];
		$slug = sanitize_title($name);
		$tmpl = $_POST['tmpl'];

		if( defined( 'ICL_SITEPRESS_VERSION' ) ){

		wp_update_post( array(
			'ID'           	=> $_POST['id'],
			'post_title'    => $name,
		  	'post_name'		=> $slug,
			'post_status'   => 'publish',
		));

		}else{

			$wpdb->update(
				$wpdb->posts,
				array(
					'post_title'    => $name,
				  	'post_name'		=> $slug,
					'post_status'   => 'publish',
				),
				array( 'ID' => $_POST['id'] ),
				array(
					'%s',
					'%s',
					'%s'
				),
				array( '%d' )
			);

		}

		if( !empty($tmpl) ){
			update_post_meta($_POST['id'], 'mfn_template_type', $tmpl);
		}

		// prevent 404
		flush_rewrite_rules(false);

	}

	wp_die();

}

// save theme options
add_action('wp_ajax_mfn_vb_themeoptions', 'mfnvb_savethemeoptions');

function mfnvb_savethemeoptions(){
	if( !current_user_can( 'edit_posts' ) ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

	update_option('betheme', wp_unslash($_POST['betheme']));
	unset($_POST);

	wp_die();
}

// render rerender section html
add_action('wp_ajax_mfnrerendersection', 'mfnvb_rerendersection');

function mfnvb_rerendersection(){
	if(!is_user_logged_in() && ! defined('BEBUILDER_DEMO_VERSION') ){ wp_die(); }
	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );
	$html = '';

	$id = $_POST['id'];
	$mfn_items = wp_unslash($_POST['sections']);
	$type = $_POST['type'];

	if( ! is_array( $mfn_items ) ) return false;

	$front = new Mfn_Builder_Front($id);

	ob_start();
	if($type && $type == 'item'){
		foreach( $mfn_items as $i=>$item){
			$front->show_items($item, $i, true);
		}
	}else if($type && $type == 'wrap'){
		foreach( $mfn_items as $w=>$wrap){
			$front->show_wraps($wrap, $w, true);
		}
	}else{
		$front->show_sections($mfn_items);
	}
	$html = ob_get_contents();
	ob_end_clean();

	echo wp_unslash($html);

	wp_die();
}


// render html
add_action('wp_ajax_mfnrenderhtml', 'mfnvb_renderhtml');
add_action('wp_ajax_nopriv_mfnrenderhtml', 'mfnvb_renderhtml');

function mfnvb_renderhtml(){

	check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );
	$return = array();

	$id = $_POST['id'];
	$mfn_items = $_POST['sections'];

	if( ! is_array( $mfn_items ) ) return false;

	$render = mfnvb_renderView( $mfn_items, $id );

	$return['html'] = $render['html'];
	$return['form'] = $render['form'];
	$return['navigator'] = $render['navigator'];

	wp_send_json($return);

	wp_die();
}

function mfnvb_renderView( $mfn_items, $id, $type = false ){

	if( ! current_user_can( 'edit_posts' ) ){
		if( ! defined('BEBUILDER_DEMO_VERSION') ){
			wp_die();
		}
	}

	$html = '';
	$front = new Mfn_Builder_Front($id);
	$return = array();

	$mfn_helper = new Mfn_Builder_Helper();
	$uids = $mfn_helper->get_current_uids();

	$mfn_items = wp_unslash( $mfn_items );
	$mfn_items = $mfn_helper->unique_ID_reset($mfn_items, $uids);

	ob_start();
	if($type && $type == 'column'){
		foreach($mfn_items as $section) { foreach($section['wraps'] as $wrap){ foreach($wrap['items'] as $item){ $front->show_items($item, $count, true); } } }
	}else if($type && $type == 'wrap') {
		foreach($mfn_items as $section) { foreach($section['wraps'] as $wrap){ $front->show_wraps($wrap, $count, true); } }
	}else{
		$front->show_sections($mfn_items);
	}
	$html = ob_get_contents();
	ob_end_clean();
	//$html = ob_get_clean();

	$mfnvb = new MfnVisualBuilder();
	$form = $mfnvb->loadElementsArr($mfn_items);
	$navigator = MfnVisualBuilder::getNavigatorTree($mfn_items);

	$return['html'] = $html;
	$return['form'] = $form;
	$return['navigator'] = $navigator;

	return $return;
}
