<?php
/**
 * Muffin Builder | Ajax actions
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Builder_Ajax {

	/**
	 * Constructor
	 */

	public function __construct() {

		// handle custom AJAX endpoint

		add_action( 'wp_ajax_mfn_builder_add_element', array( $this, '_add_element' ) );

		add_action( 'wp_ajax_mfn_builder_seo', array( $this, '_seo' ) );
		add_action( 'wp_ajax_mfn_builder_export', array( $this, '_export' ) );
		add_action( 'wp_ajax_mfn_builder_import', array( $this, '_import' ) );
		add_action( 'wp_ajax_mfn_builder_import_page', array( $this, '_import_page' ) );
		add_action( 'wp_ajax_mfn_builder_import_wraponly', array( $this, '_import_wraponly' ) );
		add_action( 'wp_ajax_mfn_builder_template', array( $this, '_template' ) );
		add_action( 'wp_ajax_mfn_builder_settings', array( $this, '_settings' ) );
		add_action( 'wp_ajax_mfn_builder_revision_restore', array( $this, '_revision_restore' ) );
		add_action( 'wp_ajax_mfn_builder_pre_built_section', array( $this, '_pre_built_section' ) );

		add_action( 'wp_ajax_mfn_history_delete', array($this, '_tool_history_delete') );
		add_action( 'wp_ajax_mfn_regenerate_css', array($this, '_tool_regenerate_css') );
		add_action( 'wp_ajax_mfn_regenerate_fonts', array($this, '_tool_regenerate_fonts') );

		add_action( 'wp_ajax_mfn_set_transient', array($this, '_set_transient') );
		add_action( 'wp_ajax_mfn_delete_transient', array($this, '_delete_transient') );

		add_action( 'wp_ajax_mfn_refresh_cache', array($this, '_refresh_cache') );

		add_action( 'wp_ajax_mfn_regenerate_thumbnails', array($this, '_regenerate_thumbnails') );
		add_action( 'wp_ajax_mfn_ajax_progress', array($this, '_ajax_progress') );
	}

	/**
	 * Regenerate thumbnails | Progress Bar
	 */

	public function _ajax_progress(){

		if( empty($_POST['type']) ) {
			return;
			wp_die();
		}

		$type = $_POST['type'];

		if( $type == 'regenerate_thumbnails' && !empty(get_option('be_regenerate_thumbnails')) ){

			$attachments = get_posts(array(
				'post_type' => 'attachment',
				'posts_per_page' => -1
			));

			return wp_send_json(array('current' => get_option('be_regenerate_thumbnails'), 'total' => count($attachments)));
		}

		return false;
		wp_die();
	}

	/**
	 * Regenerate thumbnails
	 */

	public function _regenerate_thumbnails() {

		$attachments = get_posts(array(
			'post_type' => 'attachment',
			'posts_per_page' => -1
		));

		$offset = 0;

		if( !empty(get_option('be_regenerate_thumbnails')) ){
			$offset = get_option('be_regenerate_thumbnails');
		}

		if( is_iterable($attachments) ){
			foreach( $attachments as $a=>$at ){

				if( $a < $offset ) continue;

				$imagePath = wp_get_original_image_path($at->ID);
				$img = get_post_meta($at->ID, '_wp_attached_file', true);

				$imagePath = wp_upload_dir()['basedir'].'/'.$img;

        if ($img && file_exists( $imagePath )) {
            $attach_data = wp_generate_attachment_metadata($at->ID, $imagePath);
            wp_update_attachment_metadata( $at->ID, $attach_data );
            unset($attach_data);
        }

        unset($attach_data);

        update_option('be_regenerate_thumbnails', $a);

	    }
    }

    delete_option('be_regenerate_thumbnails');

    wp_die();
	}

	/*
	 * Builder - add element
	 */

	public function _add_element(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$type = htmlspecialchars(stripslashes($_POST['type']));

		if( empty( $type ) ){
			return;
		}

		$builder = new Mfn_Builder_Admin( 'ajax' );
		$builder->set_fields();

		if( 'section' == $type ){

			$builder->section();

		} elseif( 'wrap' == $type ){

			$builder->wrap();

		} else {

			$builder->item( $type );

		}

		wp_die();
	}

	/*
	 * Transient (old_value)
	 */

	public function _set_transient(){

		$name = htmlspecialchars(stripslashes($_GET['name']));

		set_transient( 'betheme_'. $name, 'changed', 30 * MINUTE_IN_SECONDS );
		wp_die();
	}

	public function _delete_transient(){

		$name = htmlspecialchars(stripslashes($_GET['name']));

		delete_transient( 'betheme_'. $name );
		wp_die();
	}

	/*
	* Refresh Cache
	*/

	public function _refresh_cache(){

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		@clearstatcache();

		_e('Done','mfn-opts');

		wp_die();
	}

	/**
	 * Regenerate Google Fonts stored local
	 */

	public function _tool_regenerate_fonts(){

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );
		$wp_filesystem = Mfn_Helper::filesystem();

		$path_be = mfn_uploads_dir('basedir');
		$path_fonts = wp_normalize_path( $path_be .'/fonts' );

		// scrap and save font
		$content_of_css = '';

		// useragent
		$user_agent = array(
			'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:104.0) Gecko/20100101 Firefox/104.0',
			'timeout' => 30,
		);

		// if no dir, create
		if( ! file_exists( $path_be ) ){
			wp_mkdir_p( $path_be );
		}

		if( ! file_exists( $path_fonts ) ){
			wp_mkdir_p( $path_fonts );
		}

		// get used fonts names
		$fonts = [];
		$fonts = mfn_fonts_selected('builder_fonts');
		$google_fonts = mfn_fonts('all');

		// theme default font
		if( !in_array("Poppins", $fonts) ){
			$fonts[] = "Poppins";
		}

		// custom button font
		$custom_button_font = mfn_opts_get('button-font-family');
		if ( !in_array($custom_button_font, $fonts) ){
			$fonts[] = $custom_button_font;
		}

		// styles
		$subset = mfn_opts_get( 'font-subset', ['latin','latin-ext'] );
		$weight = mfn_opts_get( 'font-weight', ['400'] );

		//default subsets
		if( !in_array('latin', $subset) ){
			$subset[] = 'latin';
		}
		if( !in_array('latin-ext', $subset) ){
			$subset[] = 'latin-ext';
		}

		// clear the dir before CDN scrapping
		$wp_filesystem->delete($path_fonts.'/', true, 'd');

		// fonts, remove duplicates if they exists
		$fonts = array_unique($fonts);

		foreach ($fonts as $font) {
			$font_slug = str_replace(' ', '+', $font);
			$fonts_dir = mfn_uploads_dir('basedir', 'fonts');
			$font_location = $fonts_dir .'/'. $font_slug;
			$css_location  = wp_normalize_path($font_location .'/'.$font_slug.'.css');

			if ( in_array($font, $google_fonts) ) {

				// every regenerate remove dir, so we need to create it once more
				wp_mkdir_p( $font_location );

				// system fonts weights
				if( in_array( $font_slug, array('Poppins', "Roboto", "Open Sans") )){
					$weight_set = array_unique(array_merge($weight, array(400, 500, 600)));
				}else{
					$weight_set = $weight;
				}

				foreach ($weight_set as $item){
					$url_created = 'https://fonts.googleapis.com/css?family='. $font_slug .':'. $item .'&display=swap';

					$response = wp_remote_get($url_created, $user_agent);
					$code 	  = wp_remote_retrieve_response_code( $response );
					$google_fonts_response = wp_remote_retrieve_body( $response );

					// empty response === this type does not exists && if weight exists, do not insert it
					if (!empty($google_fonts_response) ){
						$arr_links_to_get[] = $google_fonts_response[0];

						preg_match_all('/(\*(.*)\*)/U', $google_fonts_response, $font_online_subset);
						preg_match_all('/(https:\/\/(.*).(woff2|woff))/U', $google_fonts_response, $font_online_src);

						// Pair subset name with subset link
						$fonts_links = [];
						$fonts_css = [];
						$prevent_duplicates = [];
						foreach ($font_online_subset as $key => $value) {
							// my god, loop in loop in loop in loop (O.O)
							foreach ($value as $subset_key => $subset_name) {
								$subset_name_flatt = preg_replace("/[^a-zA-Z0-9\-]+/", '', $subset_name);

								if( in_array($subset_name_flatt, $subset) && !in_array($subset_name_flatt, $prevent_duplicates) ){
									$prevent_duplicates[] = $subset_name_flatt;
									$fonts_links[$subset_name_flatt] = str_replace('/', '\/', $font_online_src[$key][$subset_key]);

									preg_match("/(\/\* ($subset_name_flatt) \*.[\s\S]*\})/U", $google_fonts_response, $matches);


									$fonts_css[] = $matches[0];
								}
							}
						}

						// Download fonts
						$font_face_number = 0;
						foreach ($fonts_links as $key => $value) {
							preg_match("/\(\'.*.\'\)/", $fonts_css[$font_face_number], $extension);

							$extension = preg_replace("/[^a-zA-Z0-9\.]+/", '', $extension);
							$extension = $extension[0];

							$internal_link = $wp_filesystem->get_contents( stripslashes($value) );

							// weights save
							$location_of_icon = wp_normalize_path($font_location .'/'. $font_slug .'-'. $item  .'-'.$key.'.'.$extension);
							$wp_filesystem->put_contents( $location_of_icon, $internal_link, FS_CHMOD_FILE );

							// replace the SRC and keep all font-weights in single filk
							$content_of_css .= preg_replace("($value)", "'./".$font_slug."/".$font_slug."-".$item."-".$key.".".$extension."'", $fonts_css[$font_face_number]);

							$font_face_number++;
						}


					}

				}

			}
		}

		// save .css file with @font-face, we do not need to keep it in for
		$wp_filesystem->put_contents( wp_normalize_path( $fonts_dir .'/mfn-local-fonts.css' ), $content_of_css, FS_CHMOD_FILE );

		_e('Done','mfn-opts');

		wp_die();
	}

	/**
	 * Some Builder styles are saved in CSS files in the uploads folder and database. Recreate those files and settings.
	 */

	public function _tool_regenerate_css(){
		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$items = get_posts( array(
			'post_type' => array('page', 'post', 'portfolio', 'product', 'template'),
			'post_status' => 'publish',
			'posts_per_page' => -1,
		) );

		if(count($items) > 0){
			foreach($items as $item){
				if( get_post_meta( $item->ID, 'mfn-page-local-style') ){
					$mfn_styles = json_decode( get_post_meta( $item->ID, 'mfn-page-local-style', true ), true );
					Mfn_Helper::generate_css($mfn_styles, $item->ID);
				}
			}
		}

		wp_die();
	}

	/**
	 * Delete history (revisions)
	 */

	public function _tool_history_delete(){

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$types = ['revision', 'update', 'autosave', 'backup'];

		$items = get_posts( array(
			'post_type' => array('page', 'post', 'portfolio', 'product', 'template'),
			'posts_per_page' => -1,
		) );

		if( count( $items ) ){
			foreach( $items as $item ){
				foreach( $types as $type ){
					$meta_key = 'mfn-builder-revision-'. $type;
					delete_post_meta( $item->ID, $meta_key );
				}
			}
		}

		wp_die();
	}

	/**
	 * Copy builder content to WP Editor where it is useful for SEO plugins like Yoast
	 */

	public function _seo() {

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		// values to skip

		$skip = [
			'1',
			'default',
			'horizontal',
		];

		// items loop

		if ( isset( $_POST['mfn-item-type'] ) && is_array( $_POST['mfn-item-type'] ) ) {

			$seo_content = '';

			foreach ( $_POST['mfn-item-type'] as $type_k => $type ) {

				$uid = $_POST['mfn-item-id'][$type_k];

				if ( isset( $_POST['mfn-item'][$uid] ) && is_array( $_POST['mfn-item'][$uid] ) ) {
					foreach ( $_POST['mfn-item'][$uid] as $attr_k => $attr ) {

						$value = $attr;

						if ( 'tabs' == $attr_k ) {

							// field type: TABS

							$item_tabs = $value;

							foreach( $item_tabs as $tab_key => $tab_fields ){
								foreach( $tab_fields as $tab_index => $tab_field ){

									$value = stripslashes( $tab_field );

									// FIX | Yoast SEO

									$seo_val = trim( $value );
									if ( $seo_val && $seo_val !== '1' ) {
										$seo_content .= $seo_val ."\n";
									}

								}
							}

						} else {

							// all other field types

							if( ! is_string( $value ) ){
								continue;
							}

							// FIX | Yoast SEO

							$seo_val = trim( $value );

							if ( $seo_val && ! in_array( $seo_val, $skip ) ) {
								if ( in_array( $attr_k, array( 'image', 'src' ) ) ) {
									$seo_content .= '<img src="'. esc_url( $seo_val ) .'" alt="'. mfn_get_attachment_data($seo_val, 'alt') .'"/>'."\n";
								} elseif ( 'link' == $attr_k ) {
									$seo_content .= '<a href="'. esc_url( $seo_val ) .'">'. $seo_val .'</a>'."\n";
								} else {
									$seo_content .= $seo_val ."\n";
								}
							}

						}
					}

					$seo_content .= "\n";
				}
			}
		}

		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'target' => array(),
				'title' => array(),
			),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'img' => array(
				'src' => array(),
				'alt' => array(),
			),
		);

		echo wp_kses( $seo_content, $allowed_html );

		exit;

	}


	/**
	 * Export builder (wrap) content as serialized string
	 * Accepts Muffin Builder items and converts it to serialized string
	 */
	public function _import_wraponly(){

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$html = '';
		$return = array();
		$uids = [];
		$mfndata = [];

		$mfn_helper = new Mfn_Builder_Helper();
		$request = $_POST;

		$id = $request['id']; //its an template id
		$parent_wrap_id = $request['parentWrapId'];

		if($request['isGlobalWrap'] === 'true'){
			$mfndata = get_post_meta($id, 'mfn-page-items', true);
		}

		if( !is_array($mfndata) ){
			$mfn_items = unserialize( call_user_func('base'.'64_decode', $mfndata) );
		}else{
			$mfn_items = $mfndata;
		}

		if( ! is_array( $mfn_items ) ) return false;

		$mfn_items = $mfn_helper->unique_ID_reset($mfn_items, $uids);

		// Global Wraps Attr
		if( $request['isGlobalWrap'] === 'true') {
			$mfn_items[0]['wraps'][0]['attr']['global_wraps_select'] = $id;
		}

		$front = new Mfn_Builder_Admin();
		$front->set_fields();

		$front->wrap($mfn_items[0]['wraps'][0], $parent_wrap_id, false);

		$html = ob_get_contents();

		ob_end_clean();

		echo $html;

		exit;
	}

	/**
	 * Export builder content as serialized string
	 * Accepts Muffin Builder items and converts it to serialized string
	 */

	public function _export(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		// variables

		$mfn_items = array();
		$mfn_wraps = array();

		// LOOP sections

		if ( isset( $_POST['mfn-section-id'] ) && is_array( $_POST['mfn-section-id'] ) ) {

			foreach ( $_POST['mfn-section-id'] as $sectionID_k => $sectionID ) {

				$uid = $_POST['mfn-section-id'][$sectionID_k];

				$section = [
					'uid' => $uid,
					'wraps' => [],
					'mfn_global_section_id' => '',
				];

				// attributes

				if ( isset( $_POST['mfn-section'][$uid] ) && is_array( $_POST['mfn-section'][$uid] ) ) {
					foreach ($_POST['mfn-section'][$uid] as $section_attr_k => $section_attr) {
						$section['attr'][$section_attr_k] = $section_attr;
					}
				}

				//global sections, prepare to save, pbl be
				if( isset($_POST['mfn-global-section'][$uid]) ) {
					$section['mfn_global_section_id'] = $_POST['mfn-global-section'][$uid];
				}

				// assign

				$mfn_items[] = $section;
			}

			$section_IDs = $_POST['mfn-section-id'];
			$section_IDs_key = array_flip($section_IDs);
		}

		// LOOP wraps

		if ( isset( $_POST['mfn-wrap-id'] ) && is_array( $_POST['mfn-wrap-id'] ) ) {

			foreach ( $_POST['mfn-wrap-id'] as $wrapID_k => $wrapID ) {

				$uid = $_POST['mfn-wrap-id'][$wrapID_k];

				$wrap = [
					'uid' => $uid,
					'size' => $_POST['mfn-wrap-size'][$wrapID_k],
					'items' => [],
				];

				// attributes

				if ( isset( $_POST['mfn-wrap'][$uid] ) && is_array( $_POST['mfn-wrap'][$uid] ) ) {
					foreach ($_POST['mfn-wrap'][$uid] as $wrap_attr_k => $wrap_attr) {
						$wrap['attr'][$wrap_attr_k] = $wrap_attr;
					}
				}

				// assign

				$mfn_wraps[$wrapID] = $wrap;
			}

			$wrap_IDs = $_POST['mfn-wrap-id'];
			$wrap_IDs_key = array_flip($wrap_IDs);
			$wrap_parents = $_POST['mfn-wrap-parent'];
		}

		// LOOP items

		if ( isset( $_POST['mfn-item-type'] ) && is_array( $_POST['mfn-item-type'] ) ) {

			foreach ( $_POST['mfn-item-type'] as $type_k => $type ) {

				$uid = $_POST['mfn-item-id'][$type_k];

				$item = [
					'type' => $type,
					'uid' => $uid,
					'size' => $_POST['mfn-item-size'][$type_k],
				];

				if ( isset( $_POST['mfn-item'][$uid] ) && is_array( $_POST['mfn-item'][$uid] ) ) {
					foreach ( $_POST['mfn-item'][$uid] as $attr_k => $attr ) {

						$value = $attr;

						if ( 'tabs' == $attr_k ) {

							// field type: TABS

							$item_tabs = $value;
							$tabs = [];

							foreach( $item_tabs as $tab_key => $tab_fields ){
								foreach( $tab_fields as $tab_index => $tab_field ){

									$value = stripslashes( $tab_field );
									$tabs[$tab_index][$tab_key] = $value;

								}
							}

							$item['fields']['tabs'] = $tabs;

						} else {

							// all other field types

							if( is_string( $value ) ){
								$value = stripslashes( $value );
							}

							$item['fields'][$attr_k] = $value;

						}
					}

				}

				// parent wrap

				$parent_wrap_ID = $_POST['mfn-item-parent'][ $type_k ];

				if ( ! isset( $mfn_wraps[ $parent_wrap_ID ]['items'] ) || ! is_array( $mfn_wraps[ $parent_wrap_ID ]['items'] ) ) {
					$mfn_wraps[ $parent_wrap_ID ]['items'] = array();
				}

				$mfn_wraps[ $parent_wrap_ID ]['items'][] = $item;
			}
		}

		// assign wraps with items to sections

		foreach ( $mfn_wraps as $wrap_ID => $wrap ) {

			$wrap_key = $wrap_IDs_key[ $wrap_ID ];
			$section_ID = $wrap_parents[ $wrap_key ];
			$section_key = $section_IDs_key[ $section_ID ];

			if (! isset($mfn_items[ $section_key ]['wraps']) || ! is_array($mfn_items[ $section_key ]['wraps'])) {
				$mfn_items[ $section_key ]['wraps'] = array();
			}
			$mfn_items[ $section_key ]['wraps'][] = $wrap;

		}

		// prepare data to save

		if ( $mfn_items ) {

			$new = call_user_func('base'.'64_encode', serialize($mfn_items));

			// PREVIEW

			if( ! empty( $_POST['preview'] ) ){

				$post_id = $_POST['preview'];

				$meta_key = [
					'items' => 'mfn-builder-preview',
					'fonts' => 'mfn-builder-preview-fonts',
					'styles' => 'mfn-builder-preview-local-style',
				];

				// local styles and fonts

				$mfn_items = wp_slash( $mfn_items );

				$mfn_styles = Mfn_Helper::preparePostUpdate($mfn_items, $post_id);

				if( isset( $mfn_styles['sections'] ) ){
					unset( $mfn_styles['sections'] );
				}

				if( isset($mfn_styles['fonts']) && count($mfn_styles['fonts']) > 0 ){
					update_post_meta( $post_id, $meta_key['fonts'], json_encode($mfn_styles['fonts']) );
				}else{
					delete_post_meta( $post_id, $meta_key['fonts'] );
				}

				if( count( $mfn_styles ) ){
					update_post_meta( $post_id, $meta_key['styles'], json_encode($mfn_styles) );
					Mfn_Helper::generate_css( $mfn_styles, $post_id, 'preview' );
				} else {
					delete_post_meta( $post_id, $meta_key['styles'] );
				}

				update_post_meta( $post_id, $meta_key['items'], $new );
			}

			// REVISION

			if( ! empty( $_POST['revision-type'] ) ){

				$type = htmlspecialchars(trim($_POST['revision-type']));
				$id = htmlspecialchars(trim($_POST['post-id']));

				$revisions = $this->set_revision( $id, $type, $new );
				echo $this->get_revisions_json( $revisions );

				exit;

			}

			print_r( json_encode($mfn_items) );

		}

		exit;

	}

	/**
	 * Import builder content.
	 * Accepts serialized string and converts it to Muffin Builder items
	 */

	public function _import() {

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$mfn_items = json_decode( wp_unslash($_POST['mfn-items-import']), true );

		if( ! $mfn_items || ! is_array( $mfn_items ) ) {
			exit;
		}

		// reset uniqueID

		$mfn_items = Mfn_Builder_Helper::unique_ID_reset( $mfn_items );

		$builder = new Mfn_Builder_Admin( 'ajax' );
		$builder->set_fields();

		foreach ( $mfn_items as $section ) {
			$builder->section( $section );
		}

		exit;

	}

	/**
	 * Import template
	 * Get builder content from target page and converts it to Muffin Builder items
	 */

	public function _template() {

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$id = isset($_POST['templateId']) ? intval($_POST['templateId'], 10 ) : intval( $_POST['mfn-items-import-template'], 10 );

		if ( ! $id ) {
			exit;
		}

		// unserialize received items data

		$mfn_items = get_post_meta( $id, 'mfn-page-items', true );

		if ( ! $mfn_items ){
			exit;
		}

		if ( ! is_array( $mfn_items ) ) {
			$mfn_items = unserialize(call_user_func('base'.'64_decode', $mfn_items));
		}

		// be sections --- global sections pbl
		if( isset($_POST['isGlobalSection']) && $_POST['isGlobalSection'] === 'true') {
			$mfn_items[0]['mfn_global_section_id'] = $id;
		}

		// reset uniqueID

		$mfn_items = Mfn_Builder_Helper::unique_ID_reset( $mfn_items );

		if ( is_array( $mfn_items ) ) {

			$builder = new Mfn_Builder_Admin( 'ajax' );
			$builder->set_fields();

			foreach ( $mfn_items as $section ) {
				$builder->section( $section );
			}

		}

		exit;

	}

	/**
	 * Builder settings
	 */

	public function _settings(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$option = htmlspecialchars(trim($_POST['option']));
		$value = htmlspecialchars(trim($_POST['value']));

		self::settings($option, $value);

		exit;

	}

	/**
	 * Builder settings non ajax
	 */

	public static function settings($option, $value){


		$user_id = get_current_user_id();

		if( ! $option ){
			return false;
		}

		$options = get_site_option( 'betheme_builder_'. $user_id );

		if( ! $options ){
			$options = [];
		}

		$options[$option] = $value;

		update_site_option( 'betheme_builder_'. $user_id, $options );

		if( 'dashboard-ui' == $option ){
			echo 'saved: '. $option .':'. $value;
			return true;
		}

		// force items form regenerate

		$fields_form = get_template_directory() .'/visual-builder/assets/js/forms/bebuilder-'.MFN_THEME_VERSION.'.js';
		if( file_exists( $fields_form ) ){
			wp_delete_file( $fields_form );
		}

		update_option('betheme_form_uid', Mfn_Builder_Helper::unique_ID());

		return true;

	}

	/**
	 * Builder settings
	 */

	public function _revision_restore(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$time = htmlspecialchars(trim($_POST['time']));
		$type = htmlspecialchars(trim($_POST['type']));
		$post_id = htmlspecialchars(trim($_POST['post_id']));

		if( ! $post_id || ! $time || ! $type ){
			return false;
		}

		$meta_key = 'mfn-builder-revision-'. $type;

		$revisions = get_post_meta( $post_id, $meta_key, true );

		if( ! empty( $revisions[$time] ) ){

			// unserialize backup

			$mfn_items = unserialize(call_user_func('base'.'64_decode', $revisions[$time]));

			// reset uniqueID

			$mfn_items = Mfn_Builder_Helper::unique_ID_reset( $mfn_items );

			if ( is_array( $mfn_items ) ) {

				$builder = new Mfn_Builder_Admin( 'ajax' );
				$builder->set_fields();

				foreach ( $mfn_items as $section ) {
					$builder->section( $section );
				}

			}

		}

		exit;

	}

	/**
	 * Save builder content as revision
	 */

	public function set_revision( $post_id, $type, $mfn_items ){

		if( ! $post_id || ! $type || ! $mfn_items ){
			return false;
		}

		$limit = 10; // max number of revisions of specified type

		$meta_key = 'mfn-builder-revision-'. $type;

		$revisions = get_post_meta( $post_id, $meta_key, true );

		if( $revisions ){

			if( count( $revisions ) >= $limit ){
				reset( $revisions );
				$rev_key = key( $revisions );
				unset( $revisions[$rev_key] );
			}

		} else {

			$revisions = [];

		}

		$time = time();

		$revisions[$time] = $mfn_items;

		update_post_meta( $post_id, $meta_key, $revisions );

		return $revisions;
	}

	/**
	 * Get revisions in json format
	 */

	public function get_revisions_json( $revisions ){

		if( ! is_array( $revisions ) ){
			return false;
		}

		$date_format = get_option( 'date_format' );
		$time_format = get_option( 'time_format' );

		$json = [];

		foreach( $revisions as $rev_key => $rev_val ){
			$json[$rev_key] = date( $date_format .' '. $time_format , $rev_key );
		}

		return json_encode($json);
	}

	/**
	 * Pre-built sections
	 */

	public function _pre_built_section(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$id = intval( $_POST['id'] );

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

			// unserialize response

			$mfn_items = unserialize(call_user_func('base'.'64_decode', $response));

			if( ! is_array( $mfn_items ) ){
				return false;
			}

			// change images url

			$placeholder_url = get_template_directory_uri() .'/functions/builder/pre-built/images/placeholders/';

			$regex = '/\#mfn_placeholder\#/';
			$mfn_items = self::builder_replace( $regex, $placeholder_url, $mfn_items );

			// reset uniqueID

			$mfn_items = Mfn_Builder_Helper::unique_ID_reset( $mfn_items );

			if ( is_array( $mfn_items ) ) {

				$builder = new Mfn_Builder_Admin( 'ajax' );
				$builder->set_fields();

				foreach ( $mfn_items as $section ) {
					$builder->section( $section );
				}

			}

		}

		exit;

	}

	/**
	 * Import single page
	 */

	public function _import_page(){

		// function verifies the AJAX request, to prevent any processing of requests which are passed in by third-party sites or systems

		check_ajax_referer( 'mfn-builder-nonce', 'mfn-builder-nonce' );

		$page = esc_url( $_POST['mfn-items-import-page'] );

		if( ! $page ){
			return false;
		}

		$pages_api = new Mfn_Single_Page_Import_API( $page );
		$response = $pages_api->remote_get_page();

		if( ! $response ){

			_e( 'Remote API error.', 'mfn-opts' );

		} elseif( is_wp_error( $response ) ){

			echo $response->get_error_message();

		} else {

			$mfn_items = json_decode( $response, true );

			if( ! $mfn_items || ! is_array( $mfn_items ) ) {
				exit;
			}

			// remove images url

			$regex = '/http(.*)\.(png|jpg|jpeg|gif|svg|webp|mp4)/m';

			$mfn_items = self::builder_replace( $regex, '', $mfn_items );

			// reset uniqueID

			$mfn_items = Mfn_Builder_Helper::unique_ID_reset( $mfn_items );

			if ( is_array( $mfn_items ) ) {

				$builder = new Mfn_Builder_Admin( 'ajax' );
				$builder->set_fields();

				foreach ( $mfn_items as $section ) {
					$builder->section( $section );
				}

			}

		}

		exit;

	}

	/**
	 * Replace Builder URLs
	 * @param skip_elements array of elements which should be skipped during import, especially elements with ob_end_clean
	 */

	public static function builder_replace( $search, $replace, $subject, $skip_elements = false ){

		// sections

		foreach( $subject as $section_key => $section ){

			$remove_section = false;

			// attributes

			if( ! empty( $section['attr'] ) ){
				foreach( $section['attr'] as $attribute_key => $attribute ){
					$attribute = preg_replace( $search, $replace, $attribute );
					$subject[$section_key]['attr'][$attribute_key] = $attribute;
				}
			}

			// FIX | Muffin Builder 2 compatibility
			// there were no wraps inside section in Muffin Builder 2

			if( ! isset( $section['wraps'] ) && is_array( $section['items'] ) ){

				$fix_wrap = array(
					'size' => '1/1',
					'uid' => Mfn_Builder_Helper::unique_ID(),
					'items'	=> $section['items'],
				);

				$section['wraps'] = array( $fix_wrap );

				$subject[$section_key]['wraps'] = $section['wraps'];
				unset( $subject[$section_key]['items'] );

			}

			// wraps

			if( ! empty( $section['wraps'] ) ){
				foreach( $section['wraps'] as $wrap_key => $wrap ){

					// attributes

					if( ! empty( $wrap['attr'] ) ){
						foreach( $wrap['attr'] as $attribute_key => $attribute ){
							$attribute = preg_replace( $search, $replace, $attribute );
							$subject[$section_key]['wraps'][$wrap_key]['attr'][$attribute_key] = $attribute;
						}
					}

					// items

					if( ! empty( $wrap['items'] ) ){
						foreach( $wrap['items'] as $item_key => $item ){

							// skip elements

							if( is_array( $skip_elements ) ){
								if( in_array( $item['type'], $skip_elements ) ){
									$remove_section = true;
								}
							}

							// fields

							if( ! empty( $item['fields'] ) ){
								foreach( $item['fields'] as $field_key => $field ){

									// replace values for

									if( is_string( $field ) ){
										$field = preg_replace( $search, $replace, $field );
										$subject[$section_key]['wraps'][$wrap_key]['items'][$item_key]['fields'][$field_key] = $field;
									}

								}
							}

						}
					}

				}
			}

			if( $remove_section ){
				unset($subject[$section_key]);
			}

		}

		return $subject;

	}

}

$mfn_builder_ajax = new Mfn_Builder_Ajax();
