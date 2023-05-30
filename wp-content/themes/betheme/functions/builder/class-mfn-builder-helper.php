<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Builder_Helper {

	/**
	 * GET builder options
	 */

	public static function get_options(){

		$user_id = get_current_user_id();

		$defaults= [
			'intro' => true,
			'simple-view' => false,
			'hover-effects' => true,
			'pre-completed' => true,
			'column-visual' => true,
			'mfn-modern-nav' => false,
		];

		$options = get_site_option( 'betheme_builder_'. $user_id );

		if( ! is_array( $options ) ){
			$options = [];
		}

		$options = array_merge( $defaults, $options );

		return $options;

	}

	/**
   * All Fonts of BeBuilder
   * Get all BeBuilder related fonts
   */

	public static function get_bebuilder_fonts(){

		$items = get_posts( array(
			'post_type' => array('page', 'post', 'portfolio', 'product', 'template'),
			'post_status' => 'publish',
			'posts_per_page' => -1,
		) );

		$fonts = [];

		if(count($items) > 0){
			foreach($items as $item){

				$remove_signs = function($value) {
					$value = preg_replace("/[^A-Za-z0-9 ]/", '', $value);
					return $value;
				};

				if ( $response = get_post_meta($item->ID, 'mfn-page-fonts', true) ){
					$response = explode(',', $response); // post meta returns it as a string
					$fonts = array_merge($fonts, array_map($remove_signs, $response));
				}
			}
		}

		return array_unique($fonts);
	}

  /**
   * Unique ID
   * Generate unique ID and check for collisions
   */

  public static function unique_ID($uids = array()){

  	if (function_exists('openssl_random_pseudo_bytes')) {

  		// openssl_random_pseudo_bytes

  		$uid = substr(bin2hex(openssl_random_pseudo_bytes(5)), 0, 9);

  	} else {

  		// fallback

  		$keyspace = '0123456789abcdefghijklmnopqrstuvwxyz';
  		$keyspace_length = 36;
  		$uid = '';

  		for ($i = 0; $i < 9; $i++) {
  			$uid .= $keyspace[rand(0, $keyspace_length - 1)];
      }

  	}

   	if( in_array( $uid, $uids ) ){
   		return self::unique_ID($uids);
   	}

   	return $uid;
  }

  /**
	 * Set new uniqueID for all builder sections, wrap and items
	 * This function also checks for possible collisions
	 */

	public static function unique_ID_reset($data, $uids = []){

		if (! is_array($data)) {
			return false;
		}

		foreach($data as $section_k => $section){

			$uids[] = self::unique_ID($uids);
			$data[$section_k]['uid'] = end($uids);

			if(isset($section['wraps']) && is_array($section['wraps'])){
				foreach($section['wraps'] as $wrap_k => $wrap){

					if( !is_array($data[$section_k]['wraps'][$wrap_k]) ){
						continue;
					}

						$uids[] = self::unique_ID($uids);
						$data[$section_k]['wraps'][$wrap_k]['uid'] = end($uids);

						if(isset($wrap['items']) && is_array($wrap['items'])){
							foreach($wrap['items'] as $item_k => $item){

								if( !is_array( $data[$section_k]['wraps'][$wrap_k]['items'][$item_k] ) ){
									continue;
								}

								$uids[] = self::unique_ID($uids);
								$data[$section_k]['wraps'][$wrap_k]['items'][$item_k]['uid'] = end($uids);

							}
						}

				}
			}

		}

		return $data;

	}

  /**
	 * GET current builder uniqueIDs form $_POST
	 */

	public static function get_current_uids(){

		$uids_section = isset( $_POST['mfn-section-id'] ) ? $_POST['mfn-section-id'] : array();
		$uids_wrap = isset( $_POST['mfn-wrap-id'] ) ? $_POST['mfn-wrap-id'] : array();
		$uids_item = isset( $_POST['mfn-item-id'] ) ? $_POST['mfn-item-id'] : array();

		return array_merge( $uids_section, $uids_wrap, $uids_item );

	}

	/**
	 * GET Sliders
	 * Layer Slider
	 * Revolution Slider
	 */

	public static function get_sliders( $plugin = 'rev' ){

		global $wpdb;

		$sliders = array( 0 => esc_html__('-- Select --', 'mfn-opts') );

		if( 'layer' == $plugin ){

			// layer slider

			if (function_exists('layerslider')) {

				$table_prefix = mfn_opts_get('table_prefix', 'base_prefix');
				if ($table_prefix == 'base_prefix') {
					$table_prefix = $wpdb->base_prefix;
				} else {
					$table_prefix = $wpdb->prefix;
				}
				$table_name = $table_prefix . "layerslider";

				$array = $wpdb->get_results($wpdb->prepare("SELECT `id`, `name` FROM `$table_name` WHERE `flag_hidden` = %d AND `flag_deleted` = %d ORDER BY `name` ASC", 0, 0));

				if (is_array($array)) {
					foreach ($array as $v) {
						$sliders[$v->id] = $v->name;
					}
				}
			}

		} else {

			// revolution slider

			if (function_exists('rev_slider_shortcode')) {

				if ( 'base_prefix' == mfn_opts_get('table_prefix', 'base_prefix') ) {
					$table_prefix = $wpdb->base_prefix;
				} else {
					$table_prefix = $wpdb->prefix;
				}
				$table_name = $table_prefix . "revslider_sliders";

				$array = $wpdb->get_results($wpdb->prepare("SELECT `alias`, `title` FROM `$table_name` WHERE `type` != %s ORDER BY `title` ASC", 'template'));

				if (is_array($array)) {
					foreach ($array as $v) {
						$sliders[$v->alias] = $v->title;
					}
				}
			}

		}

		return $sliders;

	}

	/**
	 * Get all revisions for the post
	 */

	public static function get_revisions( $post_id ){

		$array = [
			'autosave' => [],
			'update' => [],
			'revision' => [],
			'backup' => [],
		];

		// $types = ['autosave', 'update', 'revision', 'backup'];

		$date_format = get_option( 'date_format' );
		$time_format = get_option( 'time_format' );

		foreach( $array as $type => $value ){

			$meta_key = $meta_key = 'mfn-builder-revision-'. $type;

			$revisions = get_post_meta( $post_id, $meta_key, true );

			if( is_array( $revisions ) ){
				foreach( $revisions as $rev_key => $rev_val ){
					$array[$type][$rev_key] = date( $date_format .' '. $time_format , $rev_key );
				}
			}

		}

		return $array;

	}

	/**
	 * Allowed HTML for wp_kses in builder preview
	 */

	public static function allowed_html(){

		$allowed = [
			'a' => [
				'href' => [],
			],
			'b' => [],
			'blockquote' => [],
			'br' => [],
			'em' => [],
			'h1' => [],
			'h2' => [],
			'h3' => [],
			'h4' => [],
			'h5' => [],
			'h6' => [],
			'i' => [
				'class' => [],
			],
			'img' => [
				'src' => [],
			],
			'li' => [],
			'ol' => [],
			'p' => [],
			'span' => [],
			'strong' => [],
			'u' => [],
			'ul' => [],
			'table' => [],
			'tr' => [],
			'th' => [
				'colspan' => [],
			],
			'td' => [
				'colspan' => [],
			],
		];

		return $allowed;

	}

	/**
	 * Fiter for: GET builder items
	 */

	public static function filter_builder_get($builder){

		// FIX | Muffin builder 2 compatibility

		if( ( ! $builder ) || is_array($builder) ){
			return $builder;
		}

		return unserialize(call_user_func('base'.'64_decode', $builder));

  }

	/**
	 * Live Builder
	 * Header tools for sections
	 */

  public static function sectionTools($section = false){

  	$html = '<a href="#" data-tooltip="Add new section" class="btn-section-add mfn-icon-add-light mfn-section-add siblings prev" data-position="before">Add section</a> <div class="section-header mfn-section-sort-handler mfn-header header-large"><a class="mfn-option-btn mfn-option-blue mfn-element-menu mfn-element-edit" href="#" data-tooltip="Edit section" data-position="right"><span class="mfn-icon mfn-icon-section"></span></a><div class="options-group"> <a class="mfn-option-btn mfn-option-text mfn-option-green btn-large mfn-wrap-add" title="Add wrap" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">Wrap</span></a> <a class="mfn-option-btn mfn-option-text mfn-option-green btn-large mfn-wrap-add mfn-divider-add" title="Add divider" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">Divider</span></a>'; 

  	$html .= '</div><div class="options-group"> <a class="mfn-option-btn mfn-option-green btn-large mfn-element-drag mfn-section-drag" title="Drag" data-tooltip="Drag" href="#"><span class="mfn-icon mfn-icon-drag"></span></a> <a class="mfn-option-btn mfn-option-green btn-large mfn-element-edit" title="Edit" data-tooltip="Edit" href="#"><span class="mfn-icon mfn-icon-edit"></span></a> <a class="mfn-option-btn mfn-option-green btn-large mfn-module-clone mfn-section-clone" title="Clone" data-tooltip="Clone" href="#"><span class="mfn-icon mfn-icon-clone"></span></a> <a class="mfn-option-btn mfn-option-green btn-large mfn-element-delete" data-tooltip="Delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a> <div class="mfn-option-dropdown"> <a class="mfn-option-btn mfn-option-green btn-large" title="More" href="#"><span class="mfn-icon mfn-icon-more"></span></a> <div class="dropdown-wrapper"> <h6>Actions</h6> <a class="mfn-dropdown-item mfn-section-hide" href="#"><span class="mfn-icon mfn-icon-hide"></span><span class="mfn-icon mfn-icon-show"></span><span class="label label-hide-section">Hide section</span><span class="label label-show-section">Show section</span></a> <a class="mfn-dropdown-item mfn-section-move-up" href="#"><span class="mfn-icon mfn-icon-move-up"></span> Move up</a><a class="mfn-dropdown-item mfn-section-move-down" href="#"><span class="mfn-icon mfn-icon-move-down"></span> Move down</a>  <div class="mfn-dropdown-divider"></div><h6>Import / Export</h6> <a class="mfn-dropdown-item mfn-section-export" href="#"><span class="mfn-icon mfn-icon-export"></span> Export section</a> <a class="mfn-dropdown-item mfn-section-import mfn-section-import-before" href="#"><span class="mfn-icon mfn-icon-import-after"></span> Import before</a> <a class="mfn-dropdown-item mfn-section-import mfn-section-import-after" href="#"><span class="mfn-icon mfn-icon-import-before"></span> Import after</a></div></div></div></div>';

  	return $html;
  }

	/**
	 * Live Builder
	 * Header tools for wraps
	 */

  public static function wrapTools($wrap = false){

  	$html = '<a href="#" class="btn-item-add mfn-item-add mfn-icon-add-light mfn-wrap-add-item" data-tooltip="Add element">Add element</a><div class="wrap-header mfn-header mfn-header-grey"><a class="mfn-option-btn mfn-option-blue mfn-element-menu mfn-element-edit" href="#" data-tooltip="Edit wrap" data-position="right"><span class="mfn-icon mfn-icon-wrap"></span></a>';

  	if($wrap['size'] != 'divider'){
  		$html .= '<a class="mfn-option-btn mfn-option-grey mfn-size-change mfn-size-decrease" title="Decrease" data-tooltip="Decrease" href="#"><span class="mfn-icon mfn-icon-dec"></span></a> <a class="mfn-option-btn mfn-option-grey mfn-size-change mfn-size-increase" title="Increase" data-tooltip="Increase" href="#"><span class="mfn-icon mfn-icon-inc"></span></a> <a class="mfn-option-btn mfn-option-text mfn-option-grey mfn-wrap-sort-handler mfn-size-label" title="Size" data-tooltip="Size"><span class="text mfn-element-size-label">'.$wrap['size'].'</span></a> <a class="mfn-option-btn mfn-option-text btn-icon-left mfn-option-grey mfn-item-add" title="Add element" data-tooltip="Add element" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">Element</span></a>';
  	}

  	$html .= '<a class="mfn-option-btn mfn-option-grey mfn-element-drag mfn-wrap-drag" title="Drag & Drop" data-tooltip="Drag" href="#"><span class="mfn-icon mfn-icon-drag"></span></a>';

  	if($wrap['size'] != 'divider'){
  		$html .= '<a class="mfn-option-btn mfn-option-grey mfn-element-edit" title="Edit" data-tooltip="Edit" href="#"><span class="mfn-icon mfn-icon-edit"></span></a>';
  	}

  	$html .= '<a class="mfn-option-btn mfn-option-grey mfn-module-clone mfn-wrap-clone" title="Clone" data-tooltip="Clone" href="#"><span class="mfn-icon mfn-icon-clone"></span></a> <a class="mfn-option-btn mfn-option-grey mfn-element-delete" data-tooltip="Delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a> </div>';

  	return $html;
  }

	/**
	 * Live Builder
	 * Header tools for items
	 */

  public static function itemTools($size){

  	$html = '<div class="item-header mfn-header mfn-header-blue"><a data-tooltip="Edit element" class="mfn-option-btn mfn-option-blue mfn-element-menu mfn-element-edit" href="#"><span class="mfn-icon mfn-icon-item"></span></a><a class="mfn-option-btn mfn-option-blue mfn-size-change mfn-size-decrease" title="Decrease" data-tooltip="Decrease" href="#"><span class="mfn-icon mfn-icon-dec"></span></a> <a class="mfn-option-btn mfn-option-blue mfn-size-change mfn-size-increase" title="Increase" data-tooltip="Increase" href="#"><span class="mfn-icon mfn-icon-inc"></span></a> <a class="mfn-option-btn mfn-size-label mfn-option-text mfn-option-blue" title="Size" data-tooltip="Size"><span class="text mfn-element-size-label">'.$size.'</span></a> <a class="mfn-option-btn mfn-option-blue mfn-element-drag mfn-column-drag" title="Drag &amp; Drop" data-tooltip="Drag" href="#"><span class="mfn-icon mfn-icon-drag"></span></a> <a class="mfn-option-btn mfn-option-blue mfn-element-edit" title="Edit" data-tooltip="Edit" href="#"><span class="mfn-icon mfn-icon-edit"></span></a> <a class="mfn-option-btn mfn-option-blue mfn-module-clone mfn-element-clone" title="Clone" data-tooltip="Clone" href="#"><span class="mfn-icon mfn-icon-clone"></span></a> <a class="mfn-option-btn mfn-option-blue mfn-element-delete" data-tooltip="Delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a> </div><div class="mfn-drag-helper mfn-dh-before placeholder-column"></div><div class="mfn-drag-helper mfn-dh-after placeholder-column"></div>';

  	return $html;
  }

	/**
	 * GET Shape dividers
	 * @param primary_key special values:
	 * 'options' - get single dimensional array with key, value
	 * 'invert' - get coma separated list of invert dividers (for conditions)
	 */

	public static function get_shape_divider( $primary_key = false, $secondary_key = false, $uid = false ){

		if( ! $uid ){
			$uid = 'mfn-uid-'.rand(0, 999).'-'.rand(0, 999);
		}

		// NOTICE: keys MUST contain _NUMBER

		$shape_dividers = [
			'arc_opacity_1' => [
				'title' => __('Arc Opacity','mfn-opts'),
				'viewbox' => '0 0 1000 100',
				'svg' => '<path d="M0 0v11s177 85 500 85 500-84 500-84V0z" opacity=".3"></path><path d="M0-1s177 90 500 90 500-89 500-89z" opacity=".5"></path><path d="M0 0v13s177 62 500 62 500-61 500-61V0z"></path>',
			],
			'arc_opacity_2' => [
				'title' => __('Arc Opacity 2','mfn-opts'),
				'viewbox' => '0 0 1000 100',
				'svg' => '<path d="M-1-.4h1004v34a874.4 874.4 0 01-178.7 17.8c-68.8-.4-106.2-8.9-150.6-14-172-19.7-238 35.3-411.7 34.2A860 860 0 01-1 27.4"></path><path d="M-1 5.4h1004v31c-57.6 13-118 26-178.7 25.8-68.9-.4-106.2-9.7-150.6-15.3-172-21.7-238 38.7-411.7 37.4C201.4 84 110.6 69.4-1 29.5" opacity=".5"></path><path d="M492.6 100.6a442.8 442.8 0 01233-4c3.8 1-1.3-2.8-1.9-3.3a36.2 36.2 0 00-11.6-6.1A447 447 0 00476 91c-.6.1 6.9 5.5 7.5 6 2 1.1 6.5 4.3 9 3.6z" opacity=".5"></path><path d="M699.5 68.2a336.2 336.2 0 00-181-5.9c-2 .5 4.3 4.5 4.8 4.8 2 1.3 8 5.8 10.8 5.1A332.4 332.4 0 01713 77.6c3.8 1.2-1.4-3-2-3.3a41 41 0 00-11.5-6.1z"></path>',
			],
			'arrow_1' => [
				'title' => __('Arrow','mfn-opts'),
				'svg' => '<path d="M649.97 0L550.03 0 599.91 54.12 649.97 0z" class="shape-fill"></path>',
				'invert' => '<path d="M649.97 0L599.91 54.12 550.03 0 0 0 0 120 1200 120 1200 0 649.97 0z" class="shape-fill"></path>',
			],
			'blobs_1' => [
				'title' => __('Blobs','mfn-opts'),
				'viewbox' => '0 0 1000 78',
				'svg' => '<path d="M1837 0H0v9c8-5 20-1 24 7 3 5 5 12 10 12a7 7 0 007-4c2-3 1-8 0-12 3-2 7 0 8 3l1 10c-1 4-2 9 1 12a5 5 0 007 1c2-2 2-5 2-8 0-4 1-8 6-7a6 6 0 013 4 8 8 0 003 3 2 2 0 003-2c0-3-1-5 1-7a4 4 0 014-3c3 1 4 5 4 8-1 2-2 5-1 7a4 4 0 001 1c1 2 5 0 4-3a10 10 0 010-6 5 5 0 015-3c3-1 4 2 4 5l-2 6c-3 4-5 8-5 13s2 11 7 12c4 1 9-1 9-5 1-2 0-5-2-7l-1-3a19 19 0 013-20 7 7 0 017-2c4 1 5 6 4 10v11c1 4 7 5 8 1l2-9c3-3 8-6 11-2a7 7 0 012 5l-3 9-1 4c-2 4-2 9 2 11a7 7 0 008-1c4-3 5-9 3-13v-1c-1-4-4-8-3-13a9 9 0 0110-7c4 0 10 5 9 10v2a33 33 0 01-1 8 42 42 0 01-2 7c-2 4-2 10 2 14 3 3 7 5 11 3a8 8 0 005-5c2-6-3-11-6-17a10 10 0 010-2 13 13 0 012-10c6-7 16-2 17 5a15 15 0 011 5l-1 7c-1 4 1 10 6 9a7 7 0 006-5c1-4 0-8-2-11-2-4-4-7-3-11a8 8 0 012-6c4-4 11-1 15 2 5 4 10 8 15 6 4-1 6-4 7-7l7-11a7 7 0 016 0c5 1 5 6 4 10l-4 9c0 4 3 8 7 7a6 6 0 004-4c1-5-2-9-2-14 0-4 4-8 8-5a6 6 0 011 4 104 104 0 011 20l-1 10c1 6 8 9 12 5 3-3 4-8 4-12a23 23 0 00-1-3 50 50 0 00-3-9c-2-4-4-9-3-13 1-6 9-11 13-3a10 10 0 010 7c-1 4-1 12 5 13a6 6 0 005-3c3-5 1-9 2-14 1-3 4-6 8-6 4 1 7 5 7 9l2 13a10 10 0 005 6 6 6 0 005 0 6 6 0 001-1 7 7 0 003-4c1-5-2-9-3-14 0-3 1-8 4-9l2 9c3 4 8 6 12 2a8 8 0 001-3c2-4 1-7 0-11a18 18 0 0115 0l6 3a8 8 0 003 1 8 8 0 002-1c3 0 5-2 7-3a18 18 0 0115 0c-1 4-2 7-1 11a8 8 0 002 3c4 4 9 2 11-2l3-9c3 2 4 6 3 9 0 5-3 9-2 14a7 7 0 002 4c5 4 10 0 12-5l1-13c0-5 4-8 8-9 3 0 6 3 7 6 1 5 0 10 3 14a6 6 0 005 3c5-1 6-9 5-13a10 10 0 010-7c4-7 12-3 13 3 1 5-1 9-3 13s-4 8-4 12 1 9 4 12c4 4 11 1 11-5V26a6 6 0 012-4c3-3 8 1 8 5 0 5-3 9-2 14a6 6 0 004 4c4 1 7-3 6-7l-3-9c-1-4-1-9 3-10a7 7 0 016 0c4 3 6 7 7 11 2 3 4 6 7 7 6 2 11-2 15-5 5-4 11-7 16-3a8 8 0 012 6c0 8-7 14-6 22a7 7 0 006 6c5 0 7-6 7-10s-2-8-1-12c2-7 12-12 18-5a12 12 0 012 12c-3 6-9 12-7 17a8 8 0 005 5c5 2 9 0 12-3 4-4 4-9 2-14a37 37 0 01-3-15v-2c-1-5 4-10 9-10a9 9 0 0110 7c1 5-2 9-4 14-1 5 0 10 4 13a7 7 0 008 1c4-2 4-7 2-11-1-4-4-8-4-13a7 7 0 012-5c3-4 8-1 10 2s2 6 2 10c2 3 7 1 9-2s0-7-1-11c0-4 1-9 5-10a7 7 0 017 2 19 19 0 013 20c-2 4-4 7-4 10 1 5 6 7 10 5 5-1 7-7 7-12 0-4-3-9-5-12l-2-7c-1-2 1-6 4-5a5 5 0 014 3 10 10 0 010 6c-1 3 3 5 5 3a2 2 0 000-1v-7c0-3 0-7 3-7a4 4 0 015 2v7a2 2 0 004 2 8 8 0 003-3 6 6 0 013-4c4-1 6 3 6 7 0 3-1 6 2 8a5 5 0 007-1c2-3 2-8 1-12V15c1-3 6-5 8-3 0 4-1 8 1 12a7 7 0 007 4c5 0 7-7 9-12a13 13 0 0125 0c2 5 4 12 9 12a7 7 0 007-4c2-4 1-8 1-12 2-2 7 0 8 3v10c-1 4-1 9 1 12a5 5 0 007 1c3-2 2-5 2-8 0-4 2-8 6-7a6 6 0 014 4 8 8 0 002 3 2 2 0 004-2v-7a4 4 0 015-3c3 1 3 5 3 8v7a4 4 0 000 1c2 2 6 0 5-3a10 10 0 010-6 5 5 0 014-3c3-1 5 2 4 5l-2 6-5 13c0 5 2 11 8 12 4 1 8-1 9-5 1-3-2-6-4-10a19 19 0 014-20 7 7 0 016-2c5 1 5 6 5 10-1 4-2 7-1 11s7 5 9 1c0-3 0-6 2-9s7-6 10-2a7 7 0 012 5c0 5-3 8-4 13-1 4-1 9 3 11a7 7 0 007-1c5-3 5-9 4-13-2-5-5-9-4-14a9 9 0 0110-7c5 0 10 5 10 10v2a37 37 0 01-4 15c-2 4-2 10 2 14 3 3 8 5 12 3a8 8 0 005-5c2-6-4-11-6-17a12 12 0 011-12c6-7 16-3 18 5 1 4-1 8-1 12s2 10 7 9a7 7 0 006-5c2-8-6-14-6-22a8 8 0 012-6c5-4 11-1 16 2s9 8 15 6c3-1 5-4 7-7 2-4 3-8 7-11a7 7 0 016-1c4 2 4 7 3 11l-3 9c0 4 2 8 6 7a6 6 0 004-4c1-5-2-9-2-14 0-4 5-8 8-5a6 6 0 012 4v30c0 6 7 9 11 5h1c3-3 4-8 3-12l-4-12c-2-4-4-9-3-13 1-6 9-11 13-3a10 10 0 010 7c-1 4 0 12 5 13a6 6 0 006-3c2-5 1-9 2-14 1-3 4-6 7-6 4 1 7 5 8 9l1 13c2 5 7 9 12 5a7 7 0 002-4c1-5-1-9-2-14-1-3 0-7 3-9l3 9c2 4 7 6 11 2a8 8 0 002-3c1-4 0-7-1-11a18 18 0 0115 0c3 1 4 3 7 3a16 16 0 005 0l6-3a18 18 0 0115 0c-1 4-2 7 0 11a8 8 0 001 3c4 4 9 2 12-2l2-9c3 2 4 6 4 9-1 5-3 9-3 14a7 7 0 003 4c4 4 10 0 11-5l2-13c1-5 3-8 8-9 3 0 6 3 7 6 1 5 0 9 2 14a6 6 0 005 3c6-1 6-9 5-13a10 10 0 011-7c3-8 11-3 12 3 1 4-1 9-3 13l-4 12c-1 4 1 9 4 12 4 4 12 1 12-5s-2-18 0-30a6 6 0 011-4c4-3 8 1 8 5 1 5-2 9-1 14a6 6 0 003 4c4 1 7-3 7-7l-3-9c-2-4-1-9 3-10a7 7 0 016 0c4 3 5 7 7 11 1 3 4 6 7 7 5 2 10-2 15-5s11-7 15-3a8 8 0 013 6c0 8-8 14-6 22a7 7 0 006 6c5 0 7-6 6-10V41c1-7 12-12 17-5a13 13 0 012 12c-3 6-8 12-6 17a8 8 0 005 5c4 2 8 0 11-3 4-4 4-9 2-14a37 37 0 01-3-15v-2c0-5 5-10 9-10a9 9 0 0110 7c1 5-2 9-3 14s-1 10 3 13a7 7 0 008 1c4-2 4-7 3-11-2-5-5-8-5-13a7 7 0 012-5c4-4 9-1 11 2l2 10c1 3 7 1 8-2s0-7 0-11c-1-4 0-9 4-10a7 7 0 017 2 19 19 0 013 20c-1 4-4 7-3 10 1 5 5 7 9 5 5-1 8-7 7-12 0-4-2-9-4-13l-3-6c0-2 1-6 5-5a5 5 0 014 3 10 10 0 010 6c-1 3 3 5 5 3a4 4 0 000-1v-7c-1-3 0-7 3-7a4 4 0 014 2c2 2 1 5 1 7a2 2 0 003 2 8 8 0 003-3 6 6 0 013-4c5-1 6 3 6 7 0 3 0 7 2 8a5 5 0 007-1c3-3 2-8 2-12-1-3-2-6 0-10s5-5 8-3c-1 4-2 9 0 13a7 7 0 007 4c6-1 7-8 10-13s9-9 15-9 13 4 16 9c2 5 4 12 9 13a7 7 0 007-4c2-4 1-9 0-13 3-2 7 0 9 3s0 7 0 10c-1 4-2 9 1 12a5 5 0 007 1c3-1 2-5 2-8 0-4 2-8 6-7a6 6 0 013 4 8 8 0 003 3 2 2 0 004-2v-7a4 4 0 015-2c3 0 3 4 3 7v7a2 2 0 000 1c2 2 6 0 5-3a10 10 0 010-6 5 5 0 014-3c3-1 5 3 4 5l-2 6c-2 4-5 9-5 13 0 5 2 11 7 12 4 2 9 0 10-5 0-3-2-6-4-10a19 19 0 013-20 7 7 0 017-2c4 1 5 6 4 10v11c1 4 7 5 9 2 0-4 0-7 2-10s7-6 10-2a7 7 0 012 5c0 5-3 8-4 13-2 4-2 9 2 11a7 7 0 008-1c4-3 5-8 3-13-1-5-4-9-3-14a9 9 0 0110-7c5 0 10 5 9 10v2a37 37 0 01-3 15c-2 4-2 10 2 14 3 3 7 5 12 3a8 8 0 005-5c2-6-4-11-7-17a13 13 0 012-12c6-7 16-2 18 5 1 4-1 8-1 12s2 10 6 10a7 7 0 006-6c2-8-5-14-5-22a8 8 0 012-6c5-4 11-1 16 2 4 4 9 8 14 6 4-1 6-4 7-7 2-4 4-8 8-11a7 7 0 016 0c4 1 4 6 3 10l-3 9c-1 4 2 8 6 7a6 6 0 004-4c1-5-2-9-2-14 0-4 5-8 8-5a6 6 0 012 4v30c0 6 7 9 11 5 3-3 4-8 4-12s-2-8-4-12-4-9-3-13c1-6 9-11 13-3a10 10 0 010 7c-1 4 0 12 5 13a6 6 0 005-3c3-5 1-9 3-14 0-3 4-6 7-6 4 1 7 5 8 9l1 13c2 5 7 9 11 5a7 7 0 003-4c1-5-2-9-2-14-1-3 0-8 3-9l3 9c2 4 7 6 11 2a8 8 0 002-3c1-4 0-7-1-11a18 18 0 0115 0c2 1 4 3 7 3a8 8 0 002 1 8 8 0 003-1l6-3a18 18 0 0115 0c-1 4-2 7-1 11a8 8 0 002 3c4 4 9 2 12-2l2-9c3 1 4 6 4 9-1 5-4 9-3 14a7 7 0 003 4 6 6 0 001 1 6 6 0 005 0 10 10 0 005-6l2-13c1-5 3-8 7-9s7 3 8 6c1 5-1 9 2 14a6 6 0 005 3c5-1 6-9 5-13a10 10 0 010-7c4-8 12-3 13 3 1 4-1 9-3 13a50 50 0 00-3 9 24 24 0 00-1 3c0 4 1 9 4 12 4 4 11 1 11-5V46a105 105 0 010-20 6 6 0 012-4c4-3 8 1 8 5 0 5-3 9-2 14a6 6 0 004 4c4 1 7-3 7-7l-4-9c-1-4-1-9 4-11a7 7 0 016 1l7 11c1 3 3 6 7 7 5 2 10-2 14-6 4-2 8-4 11-4V0z"></path>',
			],
			'blobs_2' => [
				'title' => __('Blobs 2','mfn-opts'),
				'viewbox' => '0 0 1000 78',
				'svg' => '<path d="M207 37a1 1 0 00-1 1h2a1 1 0 001 0l-2-1zM209 28a2 2 0 00-1 3c0 1 2 2 3 1a2 2 0 001-2 2 2 0 00-3-2zM215 33a2 2 0 00-1-1c-2 1-2 5-2 7a3 3 0 001 1 2 2 0 002 0 3 3 0 001-1 5 5 0 000-5 3 3 0 00-1-1zM177 27c-3-1-6 1-5 4a4 4 0 006 2 3 3 0 001-2 4 4 0 00-2-4zM119 53c-2-1-4 1-3 3a3 3 0 004 2 2 2 0 001-2 3 3 0 00-2-3zM135 23a1 1 0 000 1c0 1 1 2 2 1a1 1 0 001-1l-3-1zM539 28a2 2 0 00-1 3c0 1 2 2 3 1a2 2 0 001-2 2 2 0 00-3-2zM537 37a1 1 0 00-1 1h2a1 1 0 001 0l-2-1zM545 33a2 2 0 00-1-1c-2 1-2 5-2 7a2 2 0 001 1 2 2 0 002 0 3 3 0 001-1 5 5 0 000-5 3 3 0 00-1-1zM449 53c-2-1-4 1-3 3a3 3 0 004 2 2 2 0 001-2 3 3 0 00-2-3zM507 27c-3-1-6 1-5 4a4 4 0 006 2 3 3 0 001-2 4 4 0 00-2-4zM465 23a1 1 0 000 1c0 1 1 2 2 1a1 1 0 001-1l-3-1zM879 28a2 2 0 00-1 3c0 1 2 2 4 1a2 2 0 000-2 2 2 0 00-3-2zM886 33a2 2 0 00-2-1c-2 1-2 5-2 7a2 2 0 002 1 2 2 0 001 0 3 3 0 001-1 5 5 0 001-5 3 3 0 00-1-1zM877 37a1 1 0 00-1 1h3c0-1-1-2-2-1zM847 27c-3-1-6 1-5 4a4 4 0 006 2 3 3 0 001-2 4 4 0 00-2-4zM789 53c-2-1-4 1-3 3a3 3 0 004 2 2 2 0 001-2 3 3 0 00-2-3zM805 23a1 1 0 000 1c0 1 1 2 2 1a1 1 0 001-1l-3-1z"></path><path d="M1914 0H0v25h1c5 1 12 15 12 35 0 5 0 8 3 9h5c4-3 0-9 1-13 1-3 4-7 7-4l3 3c3 1 4-1 4-3 1-4-2-19 3-25 3-5 8-6 12-4 7 3 18 2 23 9 2 4 2 25-1 30-1 2-3 4-3 7 0 5 5 9 10 9a8 8 0 002 0c6-2 9-9 4-15-2-3-5-14-5-21 1-12 7-22 14-30l14 14a12 12 0 013 10c-2 6 0 12 6 12 6-1 8-5 7-9a13 13 0 00-2-5c-3-4 2-13 7-15a13 13 0 0113 3c5 4 4 8 4 12 0 22-3 27-3 33 0 3 3 7 5 7 7 2 11-2 11-9-1-8-4-10-3-28 0-2 2-4 4-3s0 6 1 8a4 4 0 004 3 4 4 0 004-3l-1-10c-1-8 6-15 15-13 8 1 12 8 13 25l-2 6a6 6 0 003 9 9 9 0 006 0c4-1 5-6 3-9a26 26 0 00-2-3 10 10 0 01-1-5c-1-5 0-9 1-12a63 63 0 018-15c8 9 16 12 16 18 0 3-1 6 1 8h6c3-2 1-4 1-6 0-5 2-8 6-8 9 2 7 8 7 13l1 5c1 1 3 0 4-1s2-3 4-2c3 1 2 6 2 8a42 42 0 00-1 7c0 4 5 8 9 8s8-5 8-9l-2-13c1-6 4-8 7-8 7 0 6 6 10 4 4-1 2-6 4-10 2-1 4 0 5 1s0 4 2 4 1-3 2-5c0-2 3-3 6-2 5 0 4 7 3 8a5 5 0 01-1 2c-4 5-2 11 5 11 5 1 11-5 8-10s-3-10-1-16a3 3 0 002 2 9 9 0 003 1c5 1 13 15 13 35 0 5 0 8 3 9h5c4-3 0-10 1-13s4-7 7-4l3 3c3 1 4-1 4-3 1-4-2-19 3-25 3-5 8-6 11-4 7 2 19 1 24 9 2 4 2 25-1 30-1 2-3 4-3 7 0 4 5 9 10 9a8 8 0 002 0c6-2 9-9 4-15-2-3-5-14-5-21 0-12 7-22 14-30l14 14a12 12 0 013 10c-2 6 0 12 6 12 6-1 7-5 7-9a13 13 0 00-2-5c-3-4 1-13 7-15a13 13 0 0113 3c5 4 4 8 4 12 0 22-3 27-3 33 0 3 3 7 5 7 7 2 11-2 11-9-1-8-4-10-3-28 0-2 2-4 4-3s0 6 1 8a4 4 0 004 3 4 4 0 004-3l-1-10c-1-8 6-15 15-13 8 1 12 8 13 25l-2 6a6 6 0 003 9 9 9 0 006 0c4-1 4-6 3-9a27 27 0 00-2-3 10 10 0 01-1-5c-1-5 0-9 1-12a63 63 0 018-15c9 9 16 12 16 18l1 8h6c3-2 1-4 1-6 0-5 2-8 6-8 10 2 7 8 7 13l1 5c1 1 3 0 4-1s2-3 4-2c3 1 2 6 2 8a42 42 0 00-1 7c0 4 5 8 9 8s8-5 8-9c-1-3-2-10-1-13 0-6 3-8 6-8 7 0 6 6 11 4 3-1 1-6 4-10 1-1 3 0 4 1s0 4 2 4 1-3 2-5c0-2 3-3 6-2 5 0 4 7 3 8a5 5 0 01-1 2c-4 5-2 11 5 11 6 1 11-5 8-10-6-10 1-19 7-27l3 7c0 2-1 5 1 6a9 9 0 004 1c5 1 13 15 12 35 0 5 0 8 3 9h5c4-3 0-10 1-13s5-7 7-4c2 0 2 2 4 3s3-1 4-3c0-4-3-19 2-25 3-5 9-6 12-4 7 2 18 1 23 9 2 4 2 25-1 30-1 2-3 4-3 7 0 4 5 9 10 9a8 8 0 002 0c6-2 9-9 4-15-2-3-5-14-5-21 1-12 7-22 14-30l14 14a12 12 0 013 10c-2 6 0 12 7 12 5-1 7-5 6-9a13 13 0 00-2-5c-3-4 2-13 7-15a13 13 0 0113 3c5 4 4 8 4 12 0 22-3 27-3 33 0 3 3 7 5 7 7 2 12-2 11-9-1-8-4-10-3-28 0-2 2-4 4-3s0 6 1 8a4 4 0 004 3 4 4 0 004-3l-1-10c-1-8 6-15 16-13 8 1 12 8 12 25l-2 6a6 6 0 003 9 9 9 0 006 0c4-1 5-6 3-9a27 27 0 00-2-3 10 10 0 01-1-5c-1-5 0-9 1-12a63 63 0 018-15c9 9 16 12 16 18 0 3 0 6 2 8h5c3-2 1-4 1-6 0-5 2-8 6-8 10 2 7 8 7 13l1 5c1 1 3 0 4-1s2-3 4-2c3 1 2 6 2 8a44 44 0 00-1 7c0 4 5 8 9 8s8-5 8-9c-1-3-2-10-1-13 0-6 3-8 6-8 7 0 6 6 11 4 3-1 1-6 4-10 1-1 3 0 4 1s0 4 2 4 1-3 2-5 3-3 7-2c4 0 3 7 3 8a5 5 0 01-1 2c-5 5-2 11 4 11 6 1 11-5 8-10-5-8-1-16 4-23 5 7 9 15 4 23-3 5 3 11 8 10 7 0 9-6 5-11a5 5 0 01-1-2c-1-1-2-8 3-8 3-1 6 0 7 2s-1 5 1 5 2-2 3-4 3-2 4-1c2 4 0 9 4 10 4 2 4-4 10-4 3 0 6 2 7 8l-1 13c-1 4 2 8 7 9s9-4 9-8a44 44 0 00-1-7c0-2-1-7 2-8 2-1 3 1 4 2s3 2 4 1l1-5c0-5-2-11 7-13 5 0 6 3 6 8 0 2-1 4 1 6h6c2-2 1-5 1-8 0-6 8-9 16-18a63 63 0 018 15c2 3 2 7 2 12a10 10 0 01-2 5 27 27 0 00-2 3c-1 3-1 8 3 9a9 9 0 006 0 6 6 0 003-9l-2-6c1-17 5-24 13-25 9-2 16 5 15 13v10a4 4 0 003 3 4 4 0 004-3c1-2-1-7 2-8 1-1 3 1 3 3 1 18-2 20-3 28 0 7 4 11 11 9 3 0 5-4 5-7 0-6-3-11-3-33 0-4 0-8 4-12a13 13 0 0113-3c6 2 10 11 7 15a13 13 0 00-2 5c0 4 1 8 7 9 6 0 8-6 6-12a12 12 0 013-10l14-14c7 8 14 18 14 30 0 7-3 18-5 21-5 6-2 13 4 15a8 8 0 002 0c5 0 10-4 10-9 0-3-2-5-3-7-3-5-3-26-1-30 5-7 16-6 23-9 4-2 9-1 12 4 5 6 2 21 3 25 0 2 1 4 4 3l3-3c3-3 6 1 7 4 1 4-3 10 1 13h5c3-1 3-4 3-9 0-20 7-34 12-35a9 9 0 004-1c2-1 1-4 2-6l3-7c5 8 12 18 6 27-3 5 3 11 8 11 7-1 9-7 5-12a5 5 0 01-1-2c-1-1-2-8 3-8 3-1 6 0 7 2s-1 5 1 5 2-2 3-4 2-2 4-1c2 4 0 9 4 10 4 2 4-4 10-4 3 0 6 2 7 8l-1 13c-1 4 2 8 7 9s9-4 9-8a42 42 0 00-1-6c0-3-1-8 2-9 2-1 3 1 4 2s3 2 4 1l1-5c0-5-2-11 7-13 5 0 6 3 6 8 0 2-1 4 1 6h6c2-2 1-5 1-8 0-6 8-9 16-18a63 63 0 018 15c2 3 2 7 2 12a10 10 0 01-2 5 27 27 0 00-2 3c-1 3-1 8 3 10a9 9 0 006-1 6 6 0 003-9l-2-6c1-17 5-24 13-25 10-2 17 5 15 13v10a4 4 0 003 3 4 4 0 005-3c0-2-1-7 1-8 1-1 3 1 3 3 1 18-2 20-3 28 0 7 4 11 11 9 3 0 5-4 5-7 0-6-2-11-2-33 0-4-1-8 3-12a13 13 0 0113-3c6 2 10 11 7 15a13 13 0 00-1 5c-1 4 1 8 6 9 6 0 8-6 6-12a12 12 0 013-10l14-14c7 8 14 18 14 30 0 7-2 18-5 21-5 6-2 13 4 15a8 8 0 003 0c5 0 9-4 9-9 1-3-1-5-3-7-3-5-3-26-1-30 5-7 17-6 24-9 3-2 8-1 12 4 4 6 1 21 2 25 0 2 2 4 4 3l3-3c3-3 6 1 7 4 1 4-3 10 2 13h5c2-1 2-4 2-9 0-20 8-34 13-35a9 9 0 003-1 3 3 0 002-1c2 5 3 10-1 15-3 6 3 11 8 11 7-1 9-7 5-12a5 5 0 01-1-2c-1-1-2-8 3-8 3-1 6 0 7 2s-1 5 1 5 2-2 3-4 3-2 4-1c2 4 0 9 4 10 4 2 4-4 10-4 3 0 6 2 7 8l-1 13c-1 4 2 8 7 9s9-3 9-8a42 42 0 00-1-6c0-3-1-8 2-9 2-1 3 1 4 2s3 2 4 1l1-5c0-5-2-11 7-13 5 0 6 3 6 8 0 2-1 4 1 6 2 1 4 2 6 0s1-5 1-8c0-6 8-9 16-18a63 63 0 018 15c2 3 2 7 2 12a10 10 0 01-2 5 26 26 0 00-2 3c-1 3-1 8 3 10a9 9 0 006-1 6 6 0 003-9l-2-6c1-17 5-24 13-25 10-2 17 5 15 13v10a4 4 0 003 3 4 4 0 005-3c0-2-1-7 1-8 1-1 3 1 3 3 1 18-2 20-3 28 0 7 4 11 11 9 3 0 5-4 5-7 0-6-2-11-2-33 0-4-1-8 3-12a13 13 0 0113-3c6 2 10 11 7 15a13 13 0 00-1 5c-1 4 1 8 6 9 6 0 8-6 6-12a12 12 0 013-10l14-14c7 8 14 18 14 30 0 7-2 18-5 21-5 6-2 13 4 15a8 8 0 003 0c5 0 9-4 9-9 1-3-1-5-3-7-3-5-3-26-1-30 5-7 17-6 24-9 3-2 8-1 12 4 4 6 1 21 2 25 0 2 2 4 4 3l3-3c3-3 6 1 7 4 1 4-3 10 2 13h5c2-1 2-4 2-9 0-20 8-34 13-35V0z"></path><path d="M1794 38a1 1 0 000-1c-1-1-2 0-2 1h2zM1792 31a2 2 0 00-1-3 2 2 0 00-2 2 2 2 0 000 2c1 1 3 0 3-1zM1787 32a2 2 0 00-2 1 3 3 0 00-1 1 5 5 0 000 5 3 3 0 001 1 2 2 0 002 0 3 3 0 001-2c1-1 0-5-1-6zM1865 23l-2 1a1 1 0 001 1c0 1 2 0 1-1a1 1 0 000-1zM1881 53a3 3 0 00-1 3 2 2 0 001 2 3 3 0 004-2c0-2-2-4-4-3zM1824 27a4 4 0 00-3 4 3 3 0 002 2 4 4 0 006-2c1-3-3-5-5-4zM1551 53a3 3 0 00-1 3 2 2 0 001 2 3 3 0 004-2c0-2-2-4-4-3zM1535 23l-2 1a1 1 0 001 1c0 1 2 0 1-1a1 1 0 000-1zM1464 38a1 1 0 000-1c-1-1-2 0-2 1h2zM1457 32a2 2 0 00-2 1 3 3 0 00-1 1 5 5 0 000 5 3 3 0 001 1 2 2 0 002 0 2 2 0 001-2c1-1 0-5-1-6zM1494 27a4 4 0 00-3 4 3 3 0 002 2 4 4 0 006-2c1-3-3-5-5-4zM1462 31a2 2 0 00-1-3 2 2 0 00-2 2 2 2 0 000 2c1 1 3 0 3-1zM1124 38a1 1 0 000-1c-1-1-2 0-2 1h2zM1116 32a2 2 0 00-1 1 3 3 0 00-1 1 5 5 0 000 5 3 3 0 001 1 2 2 0 002 0 2 2 0 001-2c1-1 0-5-2-6zM1122 31a2 2 0 00-1-3 2 2 0 00-3 2 2 2 0 001 2c1 1 3 0 3-1zM1195 23l-3 1a1 1 0 002 1c0 1 2 0 1-1a1 1 0 000-1zM1153 27a4 4 0 00-2 4 3 3 0 001 2 4 4 0 007-2c1-3-3-5-6-4zM1211 53a3 3 0 00-2 3 2 2 0 001 2 3 3 0 005-2c0-2-2-4-4-3z"></path>',
			],
			'book_1' => [
				'title' => __('Book','mfn-opts'),
				'svg' => '<path d="M1200,0H0V120H281.94C572.9,116.24,602.45,3.86,602.45,3.86h0S632,116.24,923,120h277Z" class="shape-fill"></path>',
				'invert' => '<path d="M602.45,3.86h0S572.9,116.24,281.94,120H923C632,116.24,602.45,3.86,602.45,3.86Z" class="shape-fill"></path>',
			],
			'christmas_trees_1' => [
				'title' => __('Christmas Trees','mfn-opts'),
				'viewbox' => '0 0 500 95.32',
				'svg' => '<path class="cls-1" d="M386.28,33.33l5,11.14a6.47,6.47,0,0,0-1.33.18c-.78.19-1.78.08-1.78.74s5.44,11.76,5.44,11.76a15.45,15.45,0,0,0-1.67.19c-.44.11-.26.89-.26.89s-1-1.19-1.44-.93.52,1.52.52,1.52l5.14,11.31a5.49,5.49,0,0,0-1.74.15c-.48.22-.15,1.15-.15,1.15a11,11,0,0,0-1.73.26c-.71.18,10.8,22.23,10.8,22.23s.51,1.4.88,1.4,10.84-22.26,10.84-22.26.67-.93.19-.93.25-1.15-.52-1.33-1.45-1.55-1.45-1.55l4.67-12.06s.88-1.26,0-1.44a4.67,4.67,0,0,0-1.67,0l4.18-8.25s-.07-.74-.59-.74,4.7-11,4.7-11,1.55-1.78-.15-2.18a3.14,3.14,0,0,0-2.89.92s.48-1.74-1.25-1.74-4.11,2.52-4.11,2.37,1.85-3.11.67-3.11-3.07,3-3.07,3,.88-2.29-.12-2.29-1.51,0-1.51,0v-7.1H399.59v7.47s0-1.4-.92-1.29-1.37,1.55-1.37,1.55.41-1.4-.56-1.66S395,34.18,395,34.18s-.71-2.88-2.11-2.88-.82,2.66-.82,2.66-1.1-3.07-2.29-2.84-.52,2.51-.52,2.51-2-1.63-2.55-1.63S386.28,33.33,386.28,33.33Z" transform="translate(0)"/><path class="cls-1" d="M354.1,32,356.39,37a2.78,2.78,0,0,0-.61.09c-.35.08-.8,0-.8.33s2.47,5.35,2.47,5.35a7.18,7.18,0,0,0-.76.09c-.2.05-.12.4-.12.4s-.43-.54-.65-.42.23.69.23.69l2.34,5.15a2.24,2.24,0,0,0-.79.07c-.22.1-.07.52-.07.52a4.71,4.71,0,0,0-.79.12c-.32.08,4.92,10.11,4.92,10.11s.23.64.4.64S367.09,50,367.09,50s.3-.42.08-.42.12-.52-.23-.61-.66-.71-.66-.71l2.12-5.48s.41-.57,0-.66a2.13,2.13,0,0,0-.75,0l1.9-3.76s0-.33-.27-.33,2.13-5,2.13-5,.71-.81-.06-1a1.42,1.42,0,0,0-1.32.42s.22-.79-.57-.79-1.87,1.14-1.87,1.08.85-1.42.31-1.42-1.4,1.36-1.4,1.36.41-1-.05-1-.69,0-.69,0V28.45h-5.6v3.4s0-.64-.42-.59-.62.7-.62.7.18-.63-.26-.75-.79,1.12-.79,1.12-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.39-1-1.29-.24,1.14-.24,1.14-.9-.74-1.16-.74S354.1,32,354.1,32Z" transform="translate(0)"/><path class="cls-1" d="M98.34,16.1l2.28,5.06a2.67,2.67,0,0,0-.6.09c-.35.08-.81,0-.81.33s2.47,5.35,2.47,5.35a7.07,7.07,0,0,0-.75.09c-.2.05-.12.4-.12.4s-.44-.54-.66-.42.24.69.24.69l2.34,5.15a2.51,2.51,0,0,0-.79.07c-.22.1-.07.52-.07.52a4.71,4.71,0,0,0-.79.12c-.32.08,4.91,10.11,4.91,10.11s.24.64.41.64,4.93-10.13,4.93-10.13.3-.42.08-.42.12-.52-.24-.61-.65-.7-.65-.7L112.64,27s.4-.57,0-.66a2.18,2.18,0,0,0-.76,0l1.9-3.75s0-.34-.27-.34,2.14-5,2.14-5,.71-.81-.07-1a1.41,1.41,0,0,0-1.31.42s.22-.79-.57-.79-1.87,1.14-1.87,1.08.84-1.42.3-1.42-1.39,1.37-1.39,1.37.4-1,0-1-.69,0-.69,0V12.6h-5.61V16s0-.64-.42-.59-.62.71-.62.71.19-.64-.25-.76-.79,1.13-.79,1.13-.32-1.32-1-1.32-.37,1.21-.37,1.21-.51-1.39-1-1.29-.23,1.14-.23,1.14-.91-.74-1.16-.74S98.34,16.1,98.34,16.1Z" transform="translate(0)"/><path class="cls-1" d="M122.15,17.68l3.08,6.81a3.93,3.93,0,0,0-.81.11c-.48.11-1.09,0-1.09.45s3.33,7.2,3.33,7.2a8.29,8.29,0,0,0-1,.11c-.27.07-.16.54-.16.54s-.59-.72-.88-.56.31.93.31.93l3.15,6.92a3.16,3.16,0,0,0-1.06.09c-.3.13-.09.7-.09.7a6.43,6.43,0,0,0-1.07.16c-.43.11,6.61,13.59,6.61,13.59s.32.86.54.86S139.62,42,139.62,42s.41-.57.11-.57.16-.7-.31-.81-.89-1-.89-1l2.85-7.37s.55-.77,0-.88a2.77,2.77,0,0,0-1,0l2.55-5s0-.45-.36-.45,2.87-6.72,2.87-6.72.95-1.09-.09-1.34a1.9,1.9,0,0,0-1.76.57s.29-1.06-.77-1.06-2.51,1.53-2.51,1.44,1.13-1.9.41-1.9-1.88,1.84-1.88,1.84.54-1.41-.07-1.41-.93,0-.93,0V13H130.3v4.57s0-.86-.57-.79-.83.95-.83.95.25-.86-.34-1-1.07,1.52-1.07,1.52-.43-1.77-1.29-1.77-.49,1.63-.49,1.63-.68-1.88-1.41-1.74-.31,1.54-.31,1.54-1.22-1-1.56-1S122.15,17.68,122.15,17.68Z" transform="translate(0)"/><path class="cls-1" d="M63.47,20l2.29,5.07a3,3,0,0,0-.61.08c-.35.09-.81,0-.81.34s2.48,5.35,2.48,5.35a6.5,6.5,0,0,0-.76.08c-.2,0-.12.41-.12.41s-.44-.54-.65-.42.23.69.23.69l2.34,5.15a2.42,2.42,0,0,0-.79.06c-.22.1-.07.52-.07.52a6.21,6.21,0,0,0-.79.12c-.32.09,4.91,10.11,4.91,10.11s.24.64.41.64,4.93-10.13,4.93-10.13.3-.42.08-.42.12-.52-.23-.6-.66-.71-.66-.71l2.12-5.48s.4-.58,0-.66a2.36,2.36,0,0,0-.76,0l1.9-3.75s0-.34-.27-.34,2.14-5,2.14-5,.71-.81-.07-1a1.41,1.41,0,0,0-1.31.42s.22-.79-.57-.79S77,20.88,77,20.81s.84-1.41.3-1.41-1.39,1.36-1.39,1.36.4-1-.05-1-.69,0-.69,0V16.5h-5.6v3.4s0-.64-.43-.59-.62.71-.62.71.19-.64-.25-.76-.79,1.13-.79,1.13-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.4-1-1.3-.24,1.15-.24,1.15-.91-.74-1.16-.74S63.47,20,63.47,20Z" transform="translate(0)"/><path class="cls-1" d="M30.77,24.55l3.44,7.64a4.56,4.56,0,0,0-.91.12c-.53.13-1.22,0-1.22.51s3.73,8.06,3.73,8.06a9.27,9.27,0,0,0-1.14.13c-.3.08-.18.61-.18.61s-.66-.81-1-.64.36,1,.36,1l3.52,7.76a3.75,3.75,0,0,0-1.19.1c-.33.16-.1.79-.1.79a7.71,7.71,0,0,0-1.19.18c-.48.13,7.4,15.24,7.4,15.24s.36,1,.61,1,7.43-15.26,7.43-15.26.46-.64.13-.64.18-.78-.36-.91-1-1.07-1-1.07l3.2-8.26s.61-.86,0-1a3.22,3.22,0,0,0-1.14,0L54,34.24s0-.51-.4-.51,3.22-7.53,3.22-7.53,1.06-1.22-.1-1.5a2.17,2.17,0,0,0-2,.64s.33-1.19-.86-1.19-2.82,1.72-2.82,1.62,1.27-2.13.46-2.13-2.11,2.05-2.11,2.05.61-1.57-.07-1.57-1,0-1,0V19.28H39.89V24.4s0-1-.63-.89-.94,1.07-.94,1.07.28-1-.38-1.14-1.19,1.7-1.19,1.7-.48-2-1.45-2S34.75,25,34.75,25,34,22.88,33.17,23s-.35,1.73-.35,1.73-1.37-1.12-1.75-1.12S30.77,24.55,30.77,24.55Z" transform="translate(0)"/><path class="cls-1" d="M421.48,23.47,424.42,30a3.71,3.71,0,0,0-.78.11c-.45.11-1,0-1,.43s3.18,6.88,3.18,6.88-.71.05-1,.11-.15.52-.15.52-.56-.69-.85-.54.31.89.31.89l3,6.62a3.06,3.06,0,0,0-1,.08c-.28.13-.09.67-.09.67a8.19,8.19,0,0,0-1,.15c-.41.11,6.32,13,6.32,13s.3.83.52.83,6.34-13,6.34-13,.39-.54.11-.54.15-.67-.31-.78-.84-.9-.84-.9l2.73-7.06s.51-.73,0-.84a2.73,2.73,0,0,0-1,0l2.45-4.83s0-.43-.35-.43,2.75-6.42,2.75-6.42.91-1-.09-1.28a1.84,1.84,0,0,0-1.69.54s.28-1-.73-1-2.4,1.47-2.4,1.38,1.08-1.82.39-1.82-1.8,1.75-1.8,1.75.52-1.34-.06-1.34-.89,0-.89,0V19h-7.2v4.37s0-.82-.55-.76-.8.91-.8.91.24-.82-.32-1-1,1.45-1,1.45-.41-1.69-1.23-1.69-.48,1.56-.48,1.56-.64-1.8-1.34-1.67-.3,1.47-.3,1.47-1.17-.95-1.49-.95S421.48,23.47,421.48,23.47Z" transform="translate(0)"/><path class="cls-1" d="M339.73,32,342,37a2.78,2.78,0,0,0-.61.09c-.35.08-.8,0-.8.33s2.47,5.35,2.47,5.35a7.18,7.18,0,0,0-.76.09c-.2.05-.12.4-.12.4s-.43-.54-.65-.42.23.69.23.69l2.34,5.15a2.24,2.24,0,0,0-.79.07c-.22.1-.07.52-.07.52a4.71,4.71,0,0,0-.79.12c-.32.08,4.92,10.11,4.92,10.11s.23.64.4.64S352.72,50,352.72,50s.3-.42.08-.42.12-.52-.23-.61-.66-.71-.66-.71L354,42.8s.41-.57,0-.66a2.19,2.19,0,0,0-.76,0l1.91-3.76s0-.33-.27-.33S357,33,357,33s.71-.81-.06-1a1.42,1.42,0,0,0-1.32.42s.22-.79-.57-.79-1.87,1.14-1.87,1.08.85-1.42.31-1.42-1.4,1.36-1.4,1.36.4-1-.05-1-.69,0-.69,0V28.45h-5.6v3.4s0-.64-.42-.59-.63.7-.63.7.19-.63-.25-.75-.79,1.12-.79,1.12-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.39-1-1.29-.24,1.14-.24,1.14-.91-.74-1.16-.74S339.73,32,339.73,32Z" transform="translate(0)"/><path class="cls-1" d="M369.61,27.7l2.29,5.07a3.11,3.11,0,0,0-.61.08c-.35.09-.8,0-.8.34S373,38.54,373,38.54a6.5,6.5,0,0,0-.76.08c-.2.05-.11.41-.11.41s-.44-.54-.66-.42.23.68.23.68L374,44.44a2.51,2.51,0,0,0-.79.07c-.22.1-.06.52-.06.52a6.26,6.26,0,0,0-.8.12c-.32.08,4.92,10.11,4.92,10.11s.23.64.4.64,4.93-10.13,4.93-10.13.3-.42.08-.42.12-.52-.23-.6-.66-.71-.66-.71l2.12-5.49s.41-.57,0-.65a2,2,0,0,0-.75,0l1.9-3.75s0-.34-.27-.34,2.13-5,2.13-5,.71-.81-.06-1a1.42,1.42,0,0,0-1.31.42s.21-.79-.58-.79-1.86,1.15-1.86,1.08.84-1.41.3-1.41-1.4,1.36-1.4,1.36.41-1-.05-1h-.69V24.2h-5.6v3.4s0-.64-.42-.59-.62.71-.62.71.18-.64-.26-.76-.79,1.13-.79,1.13-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.4-1-1.3-.24,1.15-.24,1.15-.9-.74-1.16-.74S369.61,27.7,369.61,27.7Z" transform="translate(0)"/><path class="cls-1" d="M304.86,29.44l2.29,5.07a3,3,0,0,0-.61.08c-.35.09-.81,0-.81.34s2.48,5.35,2.48,5.35a6.5,6.5,0,0,0-.76.08c-.2,0-.12.41-.12.41s-.44-.54-.66-.42.24.69.24.69l2.34,5.14a2.51,2.51,0,0,0-.79.07c-.22.1-.07.52-.07.52a6.21,6.21,0,0,0-.79.12C307.28,47,312.51,57,312.51,57s.24.64.41.64,4.93-10.13,4.93-10.13.3-.42.08-.42.12-.52-.24-.6-.65-.71-.65-.71l2.12-5.48s.4-.58,0-.66a2.34,2.34,0,0,0-.76,0l1.9-3.75s0-.34-.27-.34,2.14-5,2.14-5,.71-.81-.07-1a1.44,1.44,0,0,0-1.31.42s.22-.79-.57-.79-1.87,1.15-1.87,1.08.84-1.41.3-1.41-1.39,1.36-1.39,1.36.4-1-.05-1h-.69V25.94h-5.61v3.4s0-.64-.42-.59-.62.71-.62.71.19-.64-.25-.76-.79,1.13-.79,1.13-.32-1.31-1-1.31-.37,1.21-.37,1.21-.51-1.4-1-1.3-.24,1.15-.24,1.15-.91-.74-1.16-.74S304.86,29.44,304.86,29.44Z" transform="translate(0)"/><path class="cls-1" d="M281.94,26.41l2.79,6.18a3.7,3.7,0,0,0-.74.1c-.43.11-1,.05-1,.42s3,6.53,3,6.53a8.49,8.49,0,0,0-.93.1c-.24.07-.14.5-.14.5s-.53-.66-.8-.52.29.85.29.85l2.85,6.28a2.84,2.84,0,0,0-1,.09c-.27.12-.08.63-.08.63a5.93,5.93,0,0,0-1,.15c-.39.1,6,12.35,6,12.35s.29.78.49.78,6-12.37,6-12.37.37-.52.11-.52.14-.63-.29-.74-.8-.86-.8-.86l2.59-6.7s.49-.7,0-.8a2.73,2.73,0,0,0-.93,0l2.32-4.58s0-.41-.32-.41,2.61-6.11,2.61-6.11.86-1-.09-1.21a1.73,1.73,0,0,0-1.6.51s.27-1-.7-1-2.28,1.4-2.28,1.31,1-1.72.37-1.72-1.7,1.66-1.7,1.66.49-1.27-.07-1.27-.84,0-.84,0V22.13h-6.84v4.15s0-.78-.52-.72-.76.87-.76.87.23-.78-.3-.93-1,1.38-1,1.38-.39-1.6-1.17-1.6-.45,1.48-.45,1.48-.62-1.71-1.28-1.59-.29,1.4-.29,1.4-1.11-.9-1.41-.9S281.94,26.41,281.94,26.41Z" transform="translate(0)"/><path class="cls-1" d="M112.73,16.1,115,21.16a2.78,2.78,0,0,0-.61.09c-.35.08-.8,0-.8.33s2.47,5.35,2.47,5.35a7.18,7.18,0,0,0-.76.09c-.2.05-.12.4-.12.4s-.43-.54-.65-.42.23.69.23.69l2.34,5.15a2.51,2.51,0,0,0-.79.07c-.22.1-.07.52-.07.52a4.71,4.71,0,0,0-.79.12c-.32.08,4.92,10.11,4.92,10.11s.23.64.4.64,4.93-10.13,4.93-10.13.3-.42.08-.42.12-.52-.23-.61-.66-.7-.66-.7L127,27s.41-.57,0-.66a2.19,2.19,0,0,0-.76,0l1.91-3.75s0-.34-.27-.34,2.13-5,2.13-5,.71-.81-.06-1a1.42,1.42,0,0,0-1.32.42s.22-.79-.57-.79-1.87,1.14-1.87,1.08.85-1.42.31-1.42-1.4,1.37-1.4,1.37.4-1,0-1-.69,0-.69,0V12.6h-5.6V16s0-.64-.42-.59-.63.71-.63.71.19-.64-.25-.76-.79,1.13-.79,1.13-.32-1.32-1-1.32-.37,1.21-.37,1.21-.5-1.39-1-1.29-.24,1.14-.24,1.14-.91-.74-1.16-.74S112.73,16.1,112.73,16.1Z" transform="translate(0)"/><path class="cls-1" d="M140.65,15,142.94,20a2.78,2.78,0,0,0-.61.09c-.35.08-.8,0-.8.33S144,25.8,144,25.8a7.18,7.18,0,0,0-.76.09c-.2.05-.12.4-.12.4s-.43-.54-.65-.42.23.69.23.69L145,31.71a2.42,2.42,0,0,0-.79.06c-.22.11-.07.53-.07.53a5.47,5.47,0,0,0-.79.11c-.32.09,4.92,10.12,4.92,10.12s.23.64.4.64S153.64,33,153.64,33s.3-.42.08-.42.12-.53-.23-.61-.66-.71-.66-.71L155,25.82s.41-.57,0-.66a2.19,2.19,0,0,0-.76,0l1.91-3.76s0-.33-.27-.33,2.13-5,2.13-5,.71-.81-.06-1a1.42,1.42,0,0,0-1.32.42s.22-.79-.57-.79-1.87,1.14-1.87,1.07.85-1.41.31-1.41-1.4,1.36-1.4,1.36.4-1-.05-1-.69,0-.69,0V11.47h-5.6v3.4s0-.64-.42-.59-.63.7-.63.7.19-.64-.25-.75-.79,1.12-.79,1.12-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.39-1-1.29S142,15.1,142,15.1s-.91-.74-1.16-.74S140.65,15,140.65,15Z" transform="translate(0)"/><path class="cls-1" d="M70.73,20.21l4.73,10.47a6.1,6.1,0,0,0-1.25.17c-.73.18-1.67.07-1.67.7s5.12,11.06,5.12,11.06a14.71,14.71,0,0,0-1.57.17c-.42.11-.24.84-.24.84s-.91-1.11-1.36-.87.49,1.43.49,1.43l4.83,10.64a5,5,0,0,0-1.63.14C77.72,55.17,78,56,78,56a11.44,11.44,0,0,0-1.64.24c-.66.17,10.16,20.91,10.16,20.91s.49,1.32.84,1.32S97.59,57.57,97.59,57.57s.62-.87.17-.87.25-1.08-.49-1.25S95.92,54,95.92,54l4.38-11.35s.84-1.18,0-1.35a4.33,4.33,0,0,0-1.56,0l3.93-7.75s-.07-.7-.56-.7,4.42-10.33,4.42-10.33,1.46-1.67-.14-2a2.92,2.92,0,0,0-2.71.87s.45-1.64-1.19-1.64S98.63,22,98.63,21.88s1.74-2.92.63-2.92-2.89,2.81-2.89,2.81.84-2.15-.1-2.15-1.43,0-1.43,0V13H83.26v7s0-1.32-.87-1.22-1.29,1.46-1.29,1.46.38-1.32-.52-1.56S78.94,21,78.94,21s-.66-2.72-2-2.72-.77,2.51-.77,2.51-1-2.89-2.15-2.68-.49,2.37-.49,2.37S71.67,19,71.15,19,70.73,20.21,70.73,20.21Z" transform="translate(0)"/><path class="cls-1" d="M52.12,19.25l2.8,6.19a3.62,3.62,0,0,0-.74.1c-.43.1-1,0-1,.41s3,6.54,3,6.54a8.14,8.14,0,0,0-.92.1c-.25.06-.15.49-.15.49s-.53-.66-.8-.51.29.84.29.84l2.86,6.29a3.11,3.11,0,0,0-1,.08c-.27.12-.08.64-.08.64a6.72,6.72,0,0,0-1,.14c-.39.1,6,12.35,6,12.35s.29.78.5.78,6-12.37,6-12.37.37-.51.1-.51.14-.64-.29-.74-.8-.86-.8-.86l2.59-6.7s.49-.7,0-.81a2.67,2.67,0,0,0-.92,0L71,27.1s0-.41-.33-.41,2.61-6.1,2.61-6.1.86-1-.08-1.22a1.76,1.76,0,0,0-1.61.52s.27-1-.69-1-2.29,1.4-2.29,1.32,1-1.73.37-1.73-1.7,1.67-1.7,1.67.49-1.28-.06-1.28-.85,0-.85,0V15H59.52v4.15s0-.78-.51-.72-.76.86-.76.86.22-.78-.31-.92-1,1.37-1,1.37-.39-1.6-1.17-1.6-.45,1.48-.45,1.48-.62-1.71-1.27-1.58-.29,1.4-.29,1.4-1.11-.91-1.42-.91S52.12,19.25,52.12,19.25Z" transform="translate(0)"/><path class="cls-1" d="M439.19,25.49l2.29,5.07a3,3,0,0,0-.6.08c-.36.09-.81,0-.81.34s2.47,5.35,2.47,5.35a6.71,6.71,0,0,0-.76.08c-.2.05-.11.41-.11.41s-.44-.54-.66-.42.24.69.24.69l2.33,5.15a2.42,2.42,0,0,0-.79.06c-.22.1-.06.52-.06.52a6,6,0,0,0-.79.12c-.32.09,4.91,10.11,4.91,10.11s.23.64.4.64,4.93-10.13,4.93-10.13.3-.42.09-.42.11-.52-.24-.6-.66-.71-.66-.71l2.12-5.48s.41-.58,0-.66a2.29,2.29,0,0,0-.75,0l1.9-3.75s0-.33-.27-.33,2.14-5,2.14-5,.7-.81-.07-1a1.4,1.4,0,0,0-1.31.42s.21-.79-.58-.79-1.86,1.14-1.86,1.07.84-1.41.3-1.41-1.4,1.36-1.4,1.36.41-1,0-1-.69,0-.69,0V22h-5.6v3.39s0-.64-.42-.58-.62.7-.62.7.18-.64-.26-.76-.79,1.13-.79,1.13-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.4-1-1.29-.23,1.14-.23,1.14-.91-.74-1.17-.74S439.19,25.49,439.19,25.49Z" transform="translate(0)"/><path class="cls-1" d="M463,24.18,466.09,31a4.06,4.06,0,0,0-.82.11c-.47.12-1.08,0-1.08.46s3.32,7.19,3.32,7.19-.74,0-1,.11-.16.55-.16.55-.59-.73-.89-.57.32.93.32.93l3.15,6.92a3.53,3.53,0,0,0-1.07.09c-.29.14-.09.7-.09.7a7.78,7.78,0,0,0-1.06.16c-.43.12,6.6,13.6,6.6,13.6s.32.86.55.86,6.63-13.62,6.63-13.62.4-.57.11-.57.16-.7-.32-.81-.88-1-.88-1l2.85-7.38s.54-.76,0-.88a3,3,0,0,0-1,0l2.56-5s0-.45-.36-.45,2.87-6.72,2.87-6.72.95-1.08-.09-1.33a1.91,1.91,0,0,0-1.76.56s.29-1.06-.77-1.06-2.51,1.54-2.51,1.45,1.13-1.9.4-1.9-1.88,1.83-1.88,1.83.55-1.4-.06-1.4-.93,0-.93,0V19.48h-7.53v4.57s0-.86-.57-.8-.84.95-.84.95.25-.85-.34-1-1.06,1.51-1.06,1.51-.43-1.76-1.29-1.76-.5,1.63-.5,1.63-.68-1.88-1.4-1.75-.32,1.54-.32,1.54-1.22-1-1.56-1S463,24.18,463,24.18Z" transform="translate(0)"/><path class="cls-1" d="M450.61,25.49l2.29,5.07a3.11,3.11,0,0,0-.61.08c-.35.09-.81,0-.81.34S454,36.33,454,36.33a6.5,6.5,0,0,0-.76.08c-.2.05-.12.41-.12.41s-.43-.54-.65-.42.23.69.23.69L455,42.24a2.42,2.42,0,0,0-.79.06c-.22.1-.07.52-.07.52a6.21,6.21,0,0,0-.79.12c-.32.09,4.91,10.11,4.91,10.11s.24.64.41.64,4.93-10.13,4.93-10.13.3-.42.08-.42.12-.52-.23-.6-.66-.71-.66-.71l2.12-5.48s.4-.58,0-.66a2.36,2.36,0,0,0-.76,0l1.9-3.75s0-.33-.26-.33,2.13-5,2.13-5,.71-.81-.07-1a1.41,1.41,0,0,0-1.31.42s.22-.79-.57-.79-1.87,1.14-1.87,1.07.84-1.41.31-1.41-1.4,1.36-1.4,1.36.4-1-.05-1-.69,0-.69,0V22h-5.6v3.39s0-.64-.42-.58-.63.7-.63.7.19-.64-.25-.76-.79,1.13-.79,1.13-.32-1.31-1-1.31-.37,1.21-.37,1.21-.5-1.4-1-1.29-.24,1.14-.24,1.14-.91-.74-1.16-.74S450.61,25.49,450.61,25.49Z" transform="translate(0)"/><path class="cls-1" d="M481.51,21.93,483.8,27a3,3,0,0,0-.61.08c-.35.09-.81,0-.81.34s2.48,5.35,2.48,5.35a6.5,6.5,0,0,0-.76.08c-.2,0-.12.41-.12.41s-.44-.54-.66-.42.24.69.24.69l2.34,5.14a2.51,2.51,0,0,0-.79.07c-.22.1-.07.52-.07.52a6.21,6.21,0,0,0-.79.12c-.32.09,4.91,10.11,4.91,10.11s.24.64.41.64S494.5,40,494.5,40s.3-.42.08-.42.12-.52-.24-.6-.65-.71-.65-.71l2.12-5.48s.4-.58,0-.66a2.34,2.34,0,0,0-.76,0l1.9-3.75s0-.34-.27-.34,2.14-5,2.14-5,.71-.81-.07-1a1.43,1.43,0,0,0-1.31.43s.22-.8-.57-.8S495,22.81,495,22.74s.84-1.41.3-1.41-1.39,1.36-1.39,1.36.4-1-.05-1h-.69V18.43h-5.61v3.4s0-.64-.42-.59-.62.71-.62.71.19-.64-.25-.76-.79,1.13-.79,1.13-.32-1.31-1-1.31-.37,1.21-.37,1.21-.51-1.4-1-1.3-.24,1.15-.24,1.15-.91-.74-1.16-.74S481.51,21.93,481.51,21.93Z" transform="translate(0)"/><path class="cls-1" d="M500,0H0V27.62S71,13.81,151.36,13.81,283.78,31,369.61,31,500,17.66,500,17.66Z" transform="translate(0)"/>',
			],
			'clouds_1' => [
				'title' => __('Clouds','mfn-opts'),
				'viewbox' => '0 0 500.01 95.43',
				'svg' => '<circle class="cls-1" cx="380.12" cy="35.58" r="13.88"/><circle class="cls-1" cx="363.75" cy="44.12" r="13.88"/><rect class="cls-1" x="0.01" width="500" height="36" transform="translate(500.01 36) rotate(180)"/><circle class="cls-1" cx="348.09" cy="38.42" r="13.88"/><circle class="cls-1" cx="338.12" cy="29.88" r="13.88"/><circle class="cls-1" cx="97.43" cy="27.68" r="23.58"/><circle class="cls-1" cx="74.61" cy="49.2" r="23.58"/><circle class="cls-1" cx="46.38" cy="47.12" r="23.58"/><ellipse class="cls-1" cx="23.87" cy="36.76" rx="23.86" ry="23.58"/><circle class="cls-1" cx="168.65" cy="37.32" r="34.12"/><circle class="cls-1" cx="213.83" cy="61.3" r="34.12"/><circle class="cls-1" cx="253.75" cy="37.6" r="34.12"/><circle class="cls-1" cx="423.13" cy="34.26" r="13.74"/><circle class="cls-1" cx="440.52" cy="43.87" r="13.74"/><circle class="cls-1" cx="456.52" cy="47.87" r="13.74"/><circle class="cls-1" cx="471.52" cy="42.87" r="13.74"/><circle class="cls-1" cx="485.52" cy="33.87" r="13.74"/><circle class="cls-1" cx="399.45" cy="37.4" r="11.6"/><circle class="cls-1" cx="302.83" cy="37.98" r="23.58"/><circle class="cls-1" cx="134.52" cy="39.87" r="23.58"/>',
			],
			'clouds_2' => [
        'title' => __('Clouds 2','mfn-opts'),
        'viewbox' => '0 0 500.01 129',
        'svg' => '<path class="opacity-5" d="M46.51,87a34.3,34.3,0,0,0,15.77-3.82,34.49,34.49,0,0,0,57.59,7.56,34.48,34.48,0,0,0,41.7-9.86,34.51,34.51,0,1,0-15.13-53.76,34.53,34.53,0,0,0-38.3,10.14,34.48,34.48,0,0,0-30.41.56A34.5,34.5,0,1,0,46.51,87Z" transform="translate(0)"/><path class="opacity-5" d="M280.51,105a48.55,48.55,0,0,0,12.37-1.6,48.48,48.48,0,0,0,59.42,9.36,48.49,48.49,0,0,0,80.58-12.69,48.5,48.5,0,1,0-27.75-65.14,48.55,48.55,0,0,0-40.42,3.31A48.52,48.52,0,0,0,316.13,23.6,48.5,48.5,0,1,0,280.51,105Z" transform="translate(0)"/></g><g id="Layer_1" data-name="Layer 1"><circle class="cls-2" cx="380.12" cy="35.58" r="13.88"/><circle class="cls-2" cx="363.75" cy="44.12" r="13.88"/><rect class="cls-2" x="0.01" width="500" height="36" transform="translate(500.01 36) rotate(180)"/><circle class="cls-2" cx="348.09" cy="38.42" r="13.88"/><circle class="cls-2" cx="338.12" cy="29.88" r="13.88"/><circle class="cls-2" cx="97.43" cy="27.68" r="23.58"/><circle class="cls-2" cx="74.61" cy="49.2" r="23.58"/><circle class="cls-2" cx="46.38" cy="47.12" r="23.58"/><ellipse class="cls-2" cx="23.87" cy="36.76" rx="23.86" ry="23.58"/><circle class="cls-2" cx="168.65" cy="37.32" r="34.12"/><circle class="cls-2" cx="213.83" cy="61.3" r="34.12"/><circle class="cls-2" cx="253.75" cy="37.6" r="34.12"/><circle class="cls-2" cx="423.13" cy="34.26" r="13.74"/><circle class="cls-2" cx="440.52" cy="43.87" r="13.74"/><circle class="cls-2" cx="456.52" cy="47.87" r="13.74"/><circle class="cls-2" cx="471.52" cy="42.87" r="13.74"/><circle class="cls-2" cx="485.52" cy="33.87" r="13.74"/><circle class="cls-2" cx="399.45" cy="37.4" r="11.6"/><circle class="cls-2" cx="302.83" cy="37.98" r="23.58"/><circle class="cls-2" cx="134.52" cy="39.87" r="23.58"/>',
      ],
			'curve_1' => [
				'title' => __('Curve','mfn-opts'),
				'svg' => '<path d="M0,0V7.23C0,65.52,268.63,112.77,600,112.77S1200,65.52,1200,7.23V0Z" class="shape-fill"></path>',
				'invert' => '<path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" class="shape-fill"></path>',
			],
			'curve_corner_opacity_1' => [
				'title' => __('Curve Corner Opacity','mfn-opts'),
				'viewbox' => '0 0 35.278 3.62',
				'svg' => '<path d="M35.278.092S8.238.267 0 3.62V.092z" opacity=".2" fill="%23000000"></path><path d="M35.278.092S8.238.246 0 3.194V.092z" opacity=".2" fill="%23000000"></path><path d="M35.278.092S8.238.223 0 2.738V.092zM35.278.092H0V0h35.278z" fill="%23000000"></path>',
			],
			'curve_asymmetrical_1' => [
				'title' => __('Curve Asymmetrical','mfn-opts'),
				'svg' => '<path d="M0,0V6c0,21.6,291,111.46,741,110.26,445.39,3.6,459-88.3,459-110.26V0Z" class="shape-fill"></path>',
				'invert' => '<path d="M741,116.23C291,117.43,0,27.57,0,6V120H1200V6C1200,27.93,1186.4,119.83,741,116.23Z" class="shape-fill"></path>',
			],
			'crazy_waves_1' => [
				'title' => __('Crazy Waves','mfn-opts'),
				'viewbox' => '0 0 1000 84.2',
				'svg' => '<circle cx="666" cy="43.7" r="14"></circle><circle cx="132.7" cy="44.1" r="14"></circle><path d="M253 54l-7 12 7 11h12l7-11-7-12h-12zM372 61l-3 6 3 7h8l4-7-4-6h-8zM22 67l-4 7 4 8h9l4-8-4-7h-9zM588 61l-6 10 6 9h11l6-9-6-10h-11zM1217 33a9 9 0 109 8 9 9 0 00-9-8zM840 58l-6 12 6 11h13l6-11-6-12h-13zM960 65l-4 7 4 6h7l4-6-4-7h-7zM1175 65l-5 10 5 9h12l5-9-5-10h-12zM1303 68l-4 7 4 6h7l4-6-4-7h-7z"></path><path d="M1918 0H0v49c10 8 26 12 40 10a32 32 0 0011 3c13 1 15-1 18-1 18-5 25-20 39-32 8-7 16-15 27-16 13-1 24 9 31 20s11 24 20 33 25 15 35 7c11-9 9-29 22-37a15 15 0 012-1c6-2 13-1 18 1a58 58 0 019 5l10 6a93 93 0 0045 14c7 0 14 0 19-5a12 12 0 004-11c0-4-3-7-5-11a11 11 0 01-1-9 17 17 0 0115-12c13-1 24 9 31 20s11 24 20 33 25 15 35 7c11-9 10-28 21-36a16 16 0 011-1c6-3 14-2 21 0a50 50 0 015 3l13 8a93 93 0 0045 14c5 0 11 0 16-3 4-2 7-6 8-11a35 35 0 006 0 44 44 0 0013-5c19-10 20-16 35-22 13-6 27-5 41-5s28-1 40 5c16 6 17 12 35 22a44 44 0 0013 5 35 35 0 007 0c0 5 3 9 8 11 5 3 10 3 16 3a93 93 0 0045-14l12-8a50 50 0 016-3c6-2 14-3 20 0a16 16 0 012 1c11 8 10 27 21 36 10 8 26 3 34-7s14-22 21-33 17-21 30-20h1a17 17 0 0115 12 11 11 0 01-1 9c-2 4-5 7-6 11a12 12 0 004 11c6 5 13 5 20 5a93 93 0 0045-14l10-6a58 58 0 018-5c6-2 13-3 19-1a15 15 0 011 1c13 8 11 28 23 37 10 8 26 3 35-7s13-22 20-33 17-21 30-20a24 24 0 015 1c8 2 16 9 23 15 14 12 21 27 38 32l4 1 4-1c18-5 24-20 38-32 7-6 15-13 24-15a24 24 0 014-1c13-1 24 9 30 20s12 24 21 33 24 15 34 7c12-9 10-29 23-37a15 15 0 011-1c6-2 13-1 19 1a58 58 0 018 5l10 6a93 93 0 0045 14c7 0 14 0 20-5a12 12 0 004-11c-1-4-4-7-6-11a11 11 0 01-1-9 17 17 0 0115-12h1c13-1 24 9 31 20s11 24 20 33 24 15 34 7c11-9 10-28 21-36a16 16 0 012-1c6-3 14-2 20 0a50 50 0 016 3l12 8a93 93 0 0046 14c5 0 11 0 15-3 5-2 8-6 8-11a35 35 0 007 0 44 44 0 0013-5c18-10 19-16 35-22 12-6 26-5 40-5s28-1 41 5c15 6 16 12 35 22a44 44 0 0013 5 35 35 0 006 0c1 5 4 9 8 11 5 3 11 3 16 3h3V0z"></path><circle cx="1874.5" cy="43.7" r="14"></circle><circle cx="1341.3" cy="44.1" r="14"></circle><path d="M1461 54l-6 12 6 11h13l6-11-6-12h-13zM1958 63l-4 8 5 8h10l4-9-5-8-10 1zM1231 67l-5 7 5 8h8l5-8-5-7h-8zM1074 54l-5 8 5 8h9l4-8-4-8h-9zM1796 61l-5 10 5 9h12l5-9-5-10h-12z"></path>',
			],
			'gradient_opacity_1' => [
				'title' => __('Gradient Opacity','mfn-opts'),
				'viewbox' => '0 0 400 60',
				'svg' => '<defs><linearGradient id="'. $uid .'-a"><stop offset="0.16" stop-color="var(--mfn-shape-divider)"></stop><stop offset="1" stop-color="var(--mfn-shape-divider)" stop-opacity="0"></stop></linearGradient><linearGradient gradientUnits="userSpaceOnUse" y2="97.857" x2="-336.875" y1="97.857" x1="-396.875" id="'. $uid .'-b" xlink:href="#'. $uid .'-a"></linearGradient></defs><path class="transparent" fill="url(#'. $uid .'-b)" d="M-396.875 -102.143H-336.875V297.85699999999997H-396.875z" transform="rotate(90 -49.509 347.366)"></path>',
			],
			'hexagons_opacity_1' => [
				'title' => __('Hexagons Opacity','mfn-opts'),
				'viewbox' => '0 0 750 77',
				'svg' => '<path opacity=".5" d="M1993 46V24l-19-11-19 11v22l19 11 19-11zM1942 72V60l-10-5-10 5v12l10 5 10-5z"></path><path opacity=".75" d="M1961 52V36l-14-8-14 8v16l14 9 14-9zM1969 69v-8l-7-4-6 4v8l6 4 7-4z"></path><path opacity=".5" d="M1871 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M1903 52V36l14-8 14 8v16l-14 9-14-9zM1895 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M1855 46V24l-19-11-19 11v22l19 11 19-11zM1803 72V60l-9-5-10 5v12l10 5 9-5z"></path><path opacity=".75" d="M1823 52V36l-14-8-14 8v16l14 9 14-9zM1831 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M1733 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M1765 52V36l14-8 14 8v16l-14 9-14-9zM1757 69v-8l6-4 7 4v8l-7 4-6-4z"></path><path opacity=".5" d="M1717 46V24l-19-11-19 11v22l19 11 19-11zM1665 72V60l-9-5-10 5v12l10 5 9-5z"></path><path opacity=".75" d="M1685 52V36l-14-8-14 8v16l14 9 14-9zM1693 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M1594 46V24l19-11 20 11v22l-20 11-19-11z"></path><path opacity=".75" d="M1626 52V36l14-8 15 8v16l-15 9-14-9zM1618 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M1579 46V24l-19-11-20 11v22l20 11 19-11zM1527 72V60l-10-5-9 5v12l9 5 10-5z"></path><path opacity=".75" d="M1547 52V36l-14-8-15 8v16l15 9 14-9zM1555 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M1456 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M1488 52V36l14-8 14 8v16l-14 9-14-9zM1480 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M1441 46V24l-20-11-19 11v22l19 11 20-11zM1389 72V60l-10-5-9 5v12l9 5 10-5z"></path><path opacity=".75" d="M1408 52V36l-14-8-14 8v16l14 9 14-9zM1416 69v-8l-6-4-7 4v8l7 4 6-4z"></path><path opacity=".5" d="M1318 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M1350 52V36l14-8 14 8v16l-14 9-14-9zM1342 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M1302 46V24l-19-11-19 11v22l19 11 19-11zM1251 72V60l-10-5-10 5v12l10 5 10-5z"></path><path opacity=".75" d="M1270 52V36l-14-8-14 8v16l14 9 14-9zM1278 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M1180 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M1212 52V36l14-8 14 8v16l-14 9-14-9zM1204 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M1164 46V24l-19-11-19 11v22l19 11 19-11zM1112 72V60l-9-5-10 5v12l10 5 9-5z"></path><path opacity=".75" d="M1132 52V36l-14-8-14 8v16l14 9 14-9zM1140 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M1041 46V24l20-11 19 11v22l-19 11-20-11z"></path><path opacity=".75" d="M1074 52V36l14-8 14 8v16l-14 9-14-9zM1066 69v-8l6-4 7 4v8l-7 4-6-4z"></path><path opacity=".5" d="M1026 46V24l-19-11-20 11v22l20 11 19-11zM974 72V60l-9-5-10 5v12l10 5 9-5z"></path><path opacity=".75" d="M994 52V36l-14-8-14 8v16l14 9 14-9zM1002 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M903 46V24l19-11 20 11v22l-20 11-19-11z"></path><path opacity=".75" d="M935 52V36l14-8 15 8v16l-15 9-14-9zM927 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M888 46V24l-20-11-19 11v22l19 11 20-11zM836 72V60l-10-5-9 5v12l9 5 10-5z"></path><path opacity=".75" d="M856 52V36l-15-8-14 8v16l14 9 15-9zM864 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M765 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M797 52V36l14-8 14 8v16l-14 9-14-9zM789 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M749 46V24l-19-11-19 11v22l19 11 19-11zM698 72V60l-10-5-9 5v12l9 5 10-5z"></path><path opacity=".75" d="M717 52V36l-14-8-14 8v16l14 9 14-9zM725 69v-8l-7-4-6 4v8l6 4 7-4z"></path><path opacity=".5" d="M627 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M659 52V36l14-8 14 8v16l-14 9-14-9zM651 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M611 46V24l-19-11-19 11v22l19 11 19-11zM560 72V60l-10-5-10 5v12l10 5 10-5z"></path><path opacity=".75" d="M579 52V36l-14-8-14 8v16l14 9 14-9zM587 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M489 46V24l19-11 19 11v22l-19 11-19-11z"></path><path opacity=".75" d="M521 52V36l14-8 14 8v16l-14 9-14-9zM513 69v-8l7-4 6 4v8l-6 4-7-4z"></path><path opacity=".5" d="M473 46V24l-19-11-19 11v22l19 11 19-11zM421 72V60l-9-5-10 5v12l10 5 9-5z"></path><path opacity=".75" d="M441 52V36l-14-8-14 8v16l14 9 14-9zM449 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M350 46V24l20-11 19 11v22l-19 11-20-11z"></path><path opacity=".75" d="M382 52V36l15-8 14 8v16l-14 9-15-9zM374 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M335 46V24l-19-11-20 11v22l20 11 19-11zM283 72V60l-10-5-9 5v12l9 5 10-5z"></path><path opacity=".75" d="M303 52V36l-14-8-14 8v16l14 9 14-9zM311 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M212 46V24l19-11 20 11v22l-20 11-19-11z"></path><path opacity=".75" d="M244 52V36l14-8 14 8v16l-14 9-14-9zM236 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M197 46V24l-20-11-19 11v22l19 11 20-11zM145 72V60l-10-5-9 5v12l9 5 10-5z"></path><path opacity=".75" d="M164 52V36l-14-8-14 8v16l14 9 14-9zM173 69v-8l-7-4-7 4v8l7 4 7-4z"></path><path opacity=".5" d="M74 46V24l19-11 19 11v22L93 57 74 46z"></path><path opacity=".3" d="M53 68V54l13-8 13 8v14l-13 8-13-8zM191 68V54l13-8 13 8v14l-13 8-13-8zM330 68V54l13-8 13 8v14l-13 8-13-8zM468 68V54l13-8 13 8v14l-13 8-13-8zM606 68V54l13-8 13 8v14l-13 8-13-8zM744 68V54l13-8 13 8v14l-13 8-13-8zM883 68V54l12-8 13 8v14l-13 8-12-8zM1021 68V54l13-8 13 8v14l-13 8-13-8zM1159 68V54l13-8 13 8v14l-13 8-13-8zM1297 68V54l13-8 13 8v14l-13 8-13-8zM1435 68V54l13-8 13 8v14l-13 8-13-8zM1574 68V54l13-8 12 8v14l-12 8-13-8zM1712 68V54l13-8 13 8v14l-13 8-13-8zM1850 68V54l13-8 13 8v14l-13 8-13-8z"></path><path opacity=".75" d="M106 52V36l14-8 14 8v16l-14 9-14-9zM98 69v-8l7-4 7 4v8l-7 4-7-4z"></path><path opacity=".5" d="M58 46V24L39 13 20 24v22l19 11 19-11z"></path><path opacity=".75" d="M34 69v-8l-7-4-6 4v8l6 4 7-4z"></path><path d="M2001 0v15l-21 12-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-24-14-23 14-23-14-23 14-24-14-23 14-23-14-24 14-23-14-23 14-23-14-24 14L0 13V0h2001z"></path><path opacity=".75" d="M12 28L0 35v19l12 7 14-9V36l-14-8z"></path><path opacity=".3" d="M2001 46l-13 8v14l13 8V46z"></path>',
			],
			'hills_1' => [
				'title' => __('Hills','mfn-opts'),
				'viewbox' => '0 0 1143.58 27.83',
				'svg' => '<path d="M1143.58 1.7H0V0h1143.58ZM0 1.7h2.94c-.98 0-1.96.23-2.91.23zm1143.58 0v6.8a85.35 85.35 0 0 0-34.47-6.8Zm-105.96 26.08a103.1 103.1 0 0 0-61.39-26.14h126.42a102.87 102.87 0 0 0-65 26.17zm-137.32 0A103.1 103.1 0 0 0 838.9 1.64h122.56a104.75 104.75 0 0 0-61.12 26.14zm-137.32 0c-39.16-34.66-97.92-34.66-136.8 0a103.1 103.1 0 0 0-61.37-26.14h259.34a104.75 104.75 0 0 0-61.12 26.14zm-274.1 0a102.98 102.98 0 0 0-65-26.09h126.19a104.48 104.48 0 0 0-61.12 26.14zm-137.06 0A102.98 102.98 0 0 0 286.83 1.7h129.8c-23.27.8-46.4 9.8-64.7 26.14zm-137.06 0A102.98 102.98 0 0 0 149.78 1.7h129.8a102.66 102.66 0 0 0-64.71 26.14zm-137.05 0A101.68 101.68 0 0 0 15.05 1.7H142.5c-23.28.8-46.4 9.8-64.71 26.14z" fill="%23000000"></path>',
			],
			'hills_opacity_1' => [
				'title' => __('Hills Opacity','mfn-opts'),
				'viewbox' => '0 0 78 7',
				'svg' => '<path d="M0 0a1 1 0 005 0 1 1 0 003 0 1 1 0 004 0 1 1 0 003 0 1 1 0 002 0 1 1 0 005 0 1 1 0 007 0 1 1 0 005 0 1 1 0 0010 0 1 1 0 005 0 1 1 0 008 0 1 1 0 005 0 1 1 0 006 0 1 1 0 005 0 1 1 0 0011 0 1 1 0 005 0 1 1 0 008 0 1 1 0 006 0 1 1 0 008 0 1 1 0 0010 0 1 1 0 007 0z" fill="%23000000"></path><path d="M0 0a1 1 0 007 0 1 1 0 0010 0 1 1 0 008 0 1 1 0 0011 0 1 1 0 0013 0 1 1 0 0010 0 1 1 0 0012 0 1 1 0 0013 0 1 1 0 0011 0 1 1 0 009 0 1 1 0 0012 0 1 1 0 0012 0z" fill="%23000000" opacity=".66"></path>',
			],
			'mountains_1' => [
				'title' => __('Mountains','mfn-opts'),
				'viewbox' => '0 0 1000 100',
				'svg' => '<path d="M167 61zM98 62zM98 60a1 1 0 000 1 1 1 0 010 1 5 5 0 001-1l-1-1zM171 71a3 3 0 000 1v-1 1a1 1 0 000-1zM229 64l-1 1v1a7 7 0 000 1l1-2v-1zM270 62v1a6 6 0 000 1v-1-1z" fill-rule="evenodd"></path><path d="M9 61l2 1a6 6 0 010-2v2a3 3 0 010 1l2 1v-1 2a21 21 0 011-2v-1 0h1v-2 1a4 4 0 010-2v1a4 4 0 011-1v-1-1 1a6 6 0 010 1 6 6 0 010 1 2 2 0 011 1v-1c0-1 0 1 0 0a9 9 0 010-2h0v3a3 3 0 011 2 7 7 0 011 1v-1l1 2 1-1c1 0 0 1 0 0v1h2v2a15 15 0 010 1c0 2 1-1 1 1v1c0 2-1-1-1-1a1 1 0 000 1 1 1 0 010 1h-1l1-1h-1v1a4 4 0 010-1v-1l-1-1v0l-1-1v4l1 1v3h1a3 3 0 010 1v-2h2a1 1 0 010-1c0-1 0 0 0 0v1a3 3 0 010-1v1s0-1 0 0a3 3 0 010 1v-1a2 2 0 010 1l1-2v1h1a4 4 0 010-2v1a15 15 0 002-1l2-4v-1-1-1c0-1 0 0 0 0v2l1-1a2 2 0 010 1l-1 1v-1a2 2 0 000 1c1 1 1 2 2 1l4-5h4l3-2a5 5 0 004-2c1-1 0-4 2-4h5l4 1h1l2 3v1a17 17 0 011-4v4c0 1 0 0 0 0v-2 1a5 5 0 010 1 6 6 0 010-2h1a4 4 0 010-1v-2 1a6 6 0 010 1 25 25 0 010 5v1a2 2 0 002 1v-1l1-2v1l1 2v-2l1 1h1v1a5 5 0 010 1h2a10 10 0 011-2c0-1 0 0 0 0v-2-1h1v2l2 1a2 2 0 010 1 3 3 0 010 1 5 5 0 010-2c1-1 1 1 1 2v-1 1h1a2 2 0 000-1h0v1-1a3 3 0 010-1 3 3 0 000-1 1 1 0 010-1h1v-1 0c0-1 1-2 1 0s-1 0-1 1c0 2 1 1 1 1a7 7 0 010 1h1v-1-1l1 2v-1a3 3 0 010 1v-1-1c0-1 0 0 0 0v-1l1 1v-2 2a4 4 0 000-1v-1l1 1v0a11 11 0 010 2v-2 1s0-1 0 0a3 3 0 011 0v-1-1l1-1v-1c0-1 0 0 0 0v0l1 1v1l1-5v1c0 1 0 0 0 0v1l1-1v-1-1 4l1-4v0l1-1v-2 1a5 5 0 010 1 6 6 0 010-2 4 4 0 011-1v-2 1a6 6 0 010 1 25 25 0 011 5v2h1v0a4 4 0 010 1 7 7 0 010 1 17 17 0 011-2v0l-1-1a1 1 0 011-1v-1h1v3l1-2v1h2v3c1 2 1-1 1 1a13 13 0 001-1 4 4 0 010-1v1l2-4 2-4c2-2 3-4 4-3a4 4 0 013 2l2 1 2-3c1-1 1-4 3-5l3-2a3 3 0 011-2v2a4 4 0 011 0v-1-1-1l1 2v-1l1-2v3l1-2v2l1-1v2a6 6 0 001-2l1-2 1 2v0a5 5 0 012-2l3-1a11 11 0 010-2 15 15 0 010-2 8 8 0 010-2l1-1v1h1s1-1 1 1l-1-1v2l1-1v1a8 8 0 010 2l1-1v-1-2a3 3 0 010 2 11 11 0 002-2c0-3 2-6 3-4l4 8 3 9c1-1 2 2 3 4v-1a8 8 0 010 2l1 1v-2a6 6 0 010 3l1 1v-3-1c1 0 1 2 2 1l-1-2c0-1 0 1 0 0l1-2 1-3v2l-1 1 1 1a1 1 0 010 1c-1 1-1-3-1-2a8 8 0 000 2 5 5 0 000 1v-1c1 1 1 5 2 3l-1-1a3 3 0 011-2 5 5 0 011-2v-1a7 7 0 010 3c0 1-1-1-1 1a5 5 0 000 1h1a8 8 0 011 3 4 4 0 010 1l-1 2v2l1 4v-2l1 2v-2 1a3 3 0 011-1v-1-1h1v1l1-1v1l1 1a9 9 0 010 2 6 6 0 010 1 5 5 0 01-1 1l1-1h-1c0 1 0 1 0 0a1 1 0 010-1l-1 1v-1 3l1 1c0-1 0-1 0 0l1-2a2 2 0 010-1h1v1a14 14 0 011-3l-1 2 1 1v-2 1a9 9 0 010-1l1-2a11 11 0 010 1v-2 1a6 6 0 010 1 3 3 0 010 1 3 3 0 001-2l-1-2a14 14 0 011 2 4 4 0 010 1l1 1v-1a3 3 0 010-1s0 1 0 0v-1a6 6 0 010 2 4 4 0 010 1v1c1 0 0-6 1-5v8-1c0-1 0-2 1-1a5 5 0 010 1v-1a7 7 0 010-3h1c0-1 0 0 0 0v-1 5l1-2v2a3 3 0 012 3 7 7 0 013-1c4-1 3 0 4 2a5 5 0 000 1 13 13 0 011 2 2 2 0 001-1s0 1 0 0v-2-3c1-1 1 3 1 1l1-2v3l-1 2c1 1 1-2 2-1a5 5 0 010 2h-1a3 3 0 000 1c1 1 1-1 1 1a1 1 0 010 1l-1-1c0 3 2 1 2 4a9 9 0 01-1 3l-1 1v-2-2-3l-1 2v2a43 43 0 011 3v1l1 1v-1 1l2-1a4 4 0 00-1-1v-3 1a3 3 0 011-3v1l1-1v1s1-1 1 1-2-1-1 2a6 6 0 000 1 9 9 0 001-2 10 10 0 010-3 7 7 0 011 2v-1a4 4 0 000-1v-1l-1-1-1 1v-5 4c-1 2-1 2-2 0v-1c0-5 2-5 3-4 0 0 0-1 0 0v1c0 2 1 0 1 0l1-1 1-1 1-1v-1 2l1-2v3c0 1 0 0 0 0l1-5 1-3a4 4 0 010 1c1-3 0-4 2-5a22 22 0 002-2l4 1c1-1 2-1 2 1s0 9 2 10 1 2 3 1l3-3c2-3 1-4 3-4s3 1 4 4v-1a4 4 0 010 1s0-1 0 0v2a9 9 0 011-1s0-1 0 0l-1 1a7 7 0 001 1v1a11 11 0 010-2v2h1v-1-1-2 1a5 5 0 010 1 6 6 0 011-3v1a4 4 0 010-1v-1-1 1a7 7 0 010 1 25 25 0 010 5v1h2v-1l1-1 1 2a7 7 0 011-1v1h1l5-6 4 6 5 6 4 3h1v-1c0-1 0 1 0 0a7 7 0 010-1v2h2v-1 1a9 9 0 000-2 3 3 0 010-1l1-1v-1-1s0-1 0 0v3l1-3c0-1 0-2 0 0v2a6 6 0 010 1l1 1v-1 0l1-1-1-1c1-2 1 1 1 2v-1a2 2 0 010 1v-1h1c0-3-1 0-1-1v-1l1-1c1 0 0 0 0 0v1a1 1 0 010 1 1 1 0 011 0v-1l-1-1a1 1 0 011-1v2c0-1 0 0 0 0h1l1-1v-1a4 4 0 000 1c0 1 0 0 0 0v-3 3a1 1 0 001-1v-1 1c0 1 0 1 0 0l1-5v4l1-1c1 0 0-1 0 0v-2-1 1h1l-1 3v-1 1l1-4v-1 1a4 4 0 010 1 1 1 0 000 1l1-1v-2c0-1 0 0 0 0v-2c0-1 0 0 0 0a5 5 0 010 1 6 6 0 011-2v1a4 4 0 010-1v-1-2 1a6 6 0 010 2 25 25 0 010 5v1a3 3 0 011 2l-1-1v1a11 11 0 012-2v-1l1-1a3 3 0 011 1l1-1h2l1-1h1v-5c1-1 1 1 1 2l-1 1 1-1 1-1c1 0 0 0 0 0v-1c0-1 0 0 0 0v-1l1 2v-1l1-3-1 3 1 1c0 1 0 0 0 0l1-2v1l1 1-1 1h1a6 6 0 001-2l1-2 1 2h-1l1 1v-1h1s0-2 1-1v1l-1 3h1v1l-1 1 2-1 1-1v1a6 6 0 011 0 11 11 0 004 0 6 6 0 013 0 6 6 0 010-2l1-2a4 4 0 00-1-2v-1a6 6 0 010-2v-1l1 4v-1-1 1l1-1 1 2h1v1c1 0 0 0 0 0v-1 2l1-1 1 1v-1a12 12 0 000 2l1 1 1-1 2 6v1c1-1 1 0 1 1l-1-1 2 4v-3-2 3l1-2a7 7 0 010 3l-1 2v1a4 4 0 000 1 5 5 0 011-1v-1l1 1-1-5 1-1 1 1v-2c0-1 0 1 0 0v-2c1-2 1-5 2-3l-1 1 1 1-1 1 1 1a1 1 0 010 1c-1 1-1-3-1-2a8 8 0 000 2 5 5 0 000 1v-1c1 1 1 4 2 3l-1-2a3 3 0 010-1 5 5 0 012-2h1v-1a7 7 0 01-1 3s0-1 0 0a5 5 0 000 2l1-1a8 8 0 011 3 2 2 0 010 1h6l4-1h2V42v28c4-7 10-7 10-7l1 1a6 6 0 010-2l1 1v-1 2c0-1 0 0 0 0a3 3 0 010 1l1 1v-1l1 1v-1-1 2l1-2v1a3 3 0 010 1h-1 1v-2-1-2 1a3 3 0 010 1l1-1a4 4 0 010-1v-1-2l1 1a6 6 0 01-1 1v1a6 6 0 011 1l1-1h-1a9 9 0 011-1v-1a4 4 0 010 1v2a3 3 0 011 2 7 7 0 010 1v-1l1 1v2l1-1c0-1 0 0 0 0h1l1 1v2c0 1 0 0 0 0v-1l1 2v1a3 3 0 010-1v1c0 3 0-1-1 0a2 2 0 000 1v-1 1h-1a3 3 0 011 0l-1-1-1-1v-1 1l-1 2h1v3a2 2 0 010 1v1h1s0-1 0 0v-1a3 3 0 010 1v-1h1l1-1v0a1 1 0 010-1 1 1 0 010 1l1-1-1 1a3 3 0 010 2l1-1v-1a4 4 0 000 1l1-1a5 5 0 010-1v1a15 15 0 002-1c0-1 0 0 0 0l2-5v-1-1c0-1 0 0 0 0v1h1a2 2 0 010 1h-1c-1-1 1 0 0 0a2 2 0 000 1c2 1 1 2 3 1s2-5 3-5h4c2-1 2-3 4-3a5 5 0 003-2c1-1 0-3 2-3h5l4 1h1l2 3v1a2 2 0 000-1 16 16 0 011-3v3a6 6 0 010 1v-2c0-1 0 0 0 0a5 5 0 010 1 6 6 0 011-2v1a4 4 0 010-1v-1-1a6 6 0 010 2 25 25 0 010 5 2 2 0 002 1 1 1 0 010-1l1-1 1 2v-1h1v1h1c1 0 0 0 0 0a5 5 0 010 1 18 18 0 002 0 9 9 0 011-2s0 1 0 0v-1-2c0-1 0 0 0 0h1v3l2 1a2 2 0 010 1 5 5 0 010-2l1 2v-1 1h1v-1c0-1 0 0 0 0v1a3 3 0 010-2h1a1 1 0 01-1-1h1a2 2 0 010-1v-1 1c0-1 1-2 1 0v1 1a4 4 0 010 1 2 2 0 011 0v-1-1c0-2 1 0 1 1v-1-1-1h1v2a4 4 0 001-1l-1-1a1 1 0 010-1l1 1v1a11 11 0 010 1v-1 1l1-1-1 1a3 3 0 011 0v-1 1a1 1 0 010-1v-1-1h1a4 4 0 000 1c0 1 0 0 0 0v-3 3a1 1 0 001-1v-2 2l1-5v3l1-2v-1 3c0 1 0 0 0 0s0 1 0 0l1-4v1a4 4 0 010 1 1 1 0 000 1v-1-2l1-1v-2 1a5 5 0 010 1 6 6 0 011-2v-1-2 1a6 6 0 010 2 25 25 0 010 4v2a2 2 0 010 1h1v0a4 4 0 011 1 7 7 0 010 1 17 17 0 010-2v-1a1 1 0 010-1l1-1 1 2v-1h1v1h1c1 0 0-1 0 0v2l1 1v-2a15 15 0 010 2c0 1 1-1 1 1a13 13 0 001-2l1-3 2-4c1-2 3-4 5-4a4 4 0 013 2l3 2 1-4 3-4 4-3a3 3 0 010-1v1l1 1a4 4 0 010-1v-1l1 1v-2h-1 1v1l1-1 1-2-1 3 1 1 1-3-1 3 1-1v2h1c1 0-1 0 0 0a6 6 0 001-2v-2c1 0 2 0 1 1v1h1a5 5 0 011-2l3-1v-1 1l1-1a11 11 0 01-1-2 15 15 0 010-2 8 8 0 010-2l1-1 1 2v-1l2 1h-1v1a8 8 0 011 2v-1h1v-2a3 3 0 010 2 11 11 0 001-3c1-2 3-5 4-3l3 7c1 0 3 10 4 9l2 5 1-1a8 8 0 010 2s0-2 1-1a6 6 0 010 2v-1l1-1v-1l1 2-1-2 1-1v-2l1-3v5a1 1 0 010 1s0-4-1-3a8 8 0 000 2 5 5 0 000 1h1l1 2v-1a4 4 0 010-1 5 5 0 011-2h1v-1a7 7 0 01-1 3h-1a5 5 0 001 2l1-1a8 8 0 010 3 4 4 0 010 2l-1 2 1 2c0 1 0 4 1 3v-1-1l1 2a3 3 0 010-1 3 3 0 010-1h1v-1-1l1 2s0-1 0 0v-1l1 1v1a9 9 0 010 1v1c-1 0 0 0 0 0a9 9 0 010 1 5 5 0 010 1v-1a1 1 0 010-1l-1-1v3a1 1 0 010 1l1 1a1 1 0 010-1l1-2s0-1 0 0h1a13 13 0 010-3v3a15 15 0 010-1c0-1 0 0 0 0a3 3 0 010 1h1a7 7 0 010-1v-3a11 11 0 010 2v-1-1a6 6 0 010 2 3 3 0 010 1 1 1 0 011 0 3 3 0 000-3v-2a14 14 0 011 3v-1a4 4 0 010 1v0a3 3 0 010-1h1a6 6 0 010 1 4 4 0 010 1v1h-1l1-4v7a1 1 0 010-1l1-1a5 5 0 010 1v-1a7 7 0 010-2l1-1 1-1-1 4v1h1v-1 2a3 3 0 012 2 7 7 0 013-1c4-1 3 0 4 2a4 4 0 000 1 14 14 0 012 2h1l-1-2 1-1v-2l1 1v-2l1 2-1 2c0 2 1-1 1-1a5 5 0 010 2c0 1 0-1 0 0a3 3 0 000 2c0 1 1-1 1 1a1 1 0 010 1l-1-1 1 3a9 9 0 010 3l-1 1v-1l-1-2v-3 2h-1l1 1a40 40 0 011 4c0 2 0 2 1 1l1-1v-3l-1 2v-2a3 3 0 011-2l1 1v-1l1 1h1c0 3-2 0-2 2a6 6 0 000 1 9 9 0 002-2 10 10 0 010-3 7 7 0 010 3l1-1a4 4 0 000-1l-1 1v-3l-1-1v-2l-1-1v4c0 2-1 1-1 0l-1-1c0-5 2-5 3-5l1 1-1 1h1l1-1 2-1v-1-2l1 2v-2 3h1l1-4a2 2 0 010-1v-2a4 4 0 010 1l2-5a22 22 0 003-3l4 2c1 0 1-2 2 1s0 8 1 9 2 2 3 1l3-3c2-3 1-4 3-4s3 1 4 4l1-1a4 4 0 010 1h-1a3 3 0 000 1l1 2a9 9 0 010-1c0-1 0-1 0 0 0 0 0-1 0 0v2h1a11 11 0 010-1v1a3 3 0 000 1v-2-1-2l1 1c1 0 0 0 0 0a5 5 0 010 1 6 6 0 010-2l1-1v-2 1a6 6 0 010 2 25 25 0 010 4v2h2v-1l1-1c1 0 0 0 0 0v2h1a7 7 0 010-1h1v1a2 2 0 001-1l5-6 4 6 5 7 4 2h1a8 8 0 010-1v2h1v-1a2 2 0 011 1v-2 1a9 9 0 000-2 3 3 0 010-1h1v-2-1 0c0-1 1-2 1 0s0 0-1 1c0 2 1 1 1 1a7 7 0 010 1v1a2 2 0 010 1l1-2v-1-1l1 2s0-1 0 0v-1-1c0-1 0 0 0 0v-1l1 1v-2 0l1 1-1 1h1v-1a2 2 0 010 1 5 5 0 010-1v1s0-1 0 0h1v-1-1l1-1v1a4 4 0 00-1 0v1l1-1v-3 1l1 1v-4c1-1 1 0 1 1v1l1 1v-3-1 4l1-4v0l1-1v-2 1a5 5 0 010 1 6 6 0 010-2 4 4 0 011-1v-1-1 1a6 6 0 010 1 25 25 0 010 5v2a3 3 0 010 1s0-1 0 0a11 11 0 012-2v-1l1-1a3 3 0 010 1l2-1c0-1 0 0 0 0h2v-1h1l1-5v3l1-1v-1h1v-1h-1l1-1v2l1-1 1-2-1 3h1l1-2-1 2 1-1v2 1h1v-1a6 6 0 001-1l1-3v3l1-1h1v-1 4c0 1 0-1 0 0v2h2a2 2 0 010-1l1-1v1a6 6 0 011 0 11 11 0 004 0 6 6 0 012 0 6 6 0 011-2v-2a4 4 0 000-1l-1-2a6 6 0 011-2v3l1-1v-1 1l1-1 1 2v1h1c0 1 0-1 0 0v1l1-1v1l1-1a13 13 0 000 2v1h2l2 6 1 1-1-1 1 4v-2l1-3v3c1 0 0-2 1-1a7 7 0 01-1 3v2a1 1 0 010 1 4 4 0 010-1v-1h1s0 2 1 1l-1-5h1v-1s1 3 1 1l-1-2h1v-2l1-3v3c0 1 0 0 0 0v2c0 1 0-3-1-2a8 8 0 000 2 5 5 0 000 1h1l1 2v-1a3 3 0 010-2 5 5 0 011-1l1-1c1 0 0-1 0 0a7 7 0 01-1 3h-1a5 5 0 001 1h1a8 8 0 010 3 2 2 0 010 1h7l4-1h2v-1c4-7 9-7 9-7l2 1a6 6 0 011-2v2c0-1 0 0 0 0a3 3 0 010 1l1 1 1-1v1a19 19 0 010-2v2l1-2v1a4 4 0 010 1v-2-1-2 1h1a3 3 0 010 1v-1a4 4 0 010-1v-1-2l1 1a6 6 0 01-1 1v1a6 6 0 011 1l1-1h-1a9 9 0 011-1v-1a4 4 0 010 1v2a3 3 0 011 2 6 6 0 010 1l1-1v1l1 2v-1c0-1 0 0 0 0h2v3h1v-1a15 15 0 010 2l1 1v-1 1c0 3-1-1-2 0 0 1 0 0 0 0v0l-1-1h-1v-1 6a2 2 0 010 1v1h1s0-1 0 0v-1a3 3 0 011 1v-1c0-1 0 0 0 0a3 3 0 011 0v-1 0a1 1 0 010-1h1a1 1 0 010 1v-1 1h-1 1a3 3 0 010 2v-1l1-1v1-1h1a4 4 0 010-1v1a16 16 0 001-1c0-1 0 0 0 0l2-5v-1-1c0-1 0 0 0 0h1v1c1 0 0 0 0 0a2 2 0 010 1s0 1 0 0a2 2 0 000 1c1 1 0 2 2 1s3-5 4-5h3l4-3a5 5 0 003-2c1-1 1-3 3-3h4l5 1c0-1 0 0 0 0 1 0 1-1 3 3v1a2 2 0 000-1 16 16 0 010-3v2c0-1 0 0 0 0h1a5 5 0 010 1 6 6 0 010-2v1a4 4 0 010-1v-1l1-1c1 0 0 0 0 0a6 6 0 01-1 2 1 1 0 011 0 25 25 0 010 5 2 2 0 002 1v-1-1h1v2h1v-1s0 1 0 0v1h2a5 5 0 010 1 18 18 0 002 0 9 9 0 010-2s0 1 0 0v-1-2h1l1 3 1 1a2 2 0 010 1h1a5 5 0 010-2v2h1v-1 0c0-1 0 0 0 0v1a3 3 0 011-2s0 1 0 0v-1a2 2 0 010-1v-1 4c1 1 1-2 1-3s0-2 0 0v2a5 5 0 011 0 4 4 0 010 1 1 1 0 010-1v1l1-1v-1 1l1-1c0-2-1 1-1-1l1-1v0l1 2v-1 1a4 4 0 000-1v-1a1 1 0 010-1v2a11 11 0 010 1v-1l1 1v-1 1-1 1a1 1 0 010-1l1-1v-1s0-1 0 0a4 4 0 000 1c0 1 0 0 0 0l1-3v3a1 1 0 000-1v-2 1l1 1v-5 3l1-1v-1 1l1-2v0l-1 3h1s0 1 0 0v-4 2s0-2 1-1-1 1-1 1l1-2v1a4 4 0 010 1 1 1 0 000 1v-1-2-1-2 1h1a5 5 0 010 1 6 6 0 010-2v-1l1-2v1a6 6 0 01-1 2 25 25 0 011 4v2a2 2 0 010 1h1v0a4 4 0 010 1 7 7 0 010 1 17 17 0 011-2l-1-1a1 1 0 011-1v-1h1v2l1-1v1h2v1l1 2v1a13 13 0 001-2l2-3 2-4 4-4a4 4 0 013 2l3 2c1 0 0-3 2-4s1-3 3-4l3-3a3 3 0 010-1c1-1 1 1 1 1v-1l1 1v-2s0 1 0 0c0 0 0-1 0 0 0 0 0 2 1 1v-1l1-2-1 3h1v1l1-3-1 3 1-1 1 1-1 1h1a6 6 0 001-2l1-2 1 1-1 1h1a5 5 0 012-2l2-1v-1l1 1v-1a11 11 0 01-1-2 15 15 0 010-2 8 8 0 010-2l1-1 1 2v-1l2 1h-1v1a8 8 0 011 2l1-1v-2a3 3 0 010 2 11 11 0 001-3c1-2 3-5 4-3l3 7s3 10 4 9l3 5v-1a8 8 0 010 2l1-1a6 6 0 010 2l1 2-1-3 1-1v-1l1 2-1-2 1-1v-2l1-3v2l1 1-1 1 1 1a1 1 0 01-1 1s0-4-1-3a7 7 0 000 2 4 4 0 000 1h1l1 2v-1a4 4 0 010-1 5 5 0 011-2h1v-1a6 6 0 01-1 3s0-1 0 0a5 5 0 000 2l1-1a8 8 0 011 3 4 4 0 01-1 2l-1 2 1 2c0 1 0 4 1 3v-1 1l1-2v2a3 3 0 010-1 3 3 0 010-1h1v-1-1l1 2s0-1 0 0l1-1v1l1 1a9 9 0 010 1v1h-1a6 6 0 010 1 5 5 0 010 1v-1a1 1 0 010-1v-1l-1 2v-2 4l1 1a2 2 0 010-1l1-2s0-1 0 0h1a14 14 0 010-3v3a15 15 0 010-1c0-1 0 0 0 0h1a3 3 0 010 1 9 9 0 010-1c0-2 0-4 1-3a10 10 0 01-1 2l1-1v-1 1a6 6 0 010 1 3 3 0 010 1 3 3 0 000-3v-2a14 14 0 011 3v1h1a2 2 0 010-1s-1 1 0 0c0-1 0 0 0 0v-1a6 6 0 010 1 1 1 0 010 1 4 4 0 010 1v-4 7h1a5 5 0 010-1v-1a5 5 0 010 1h1v-1h-1a7 7 0 011-2v-1l1 1v-1l-1 3v1h1v-1 2a3 3 0 012 2 7 7 0 013-1c4-1 3 1 4 3a4 4 0 001 1 14 14 0 011 1h1l-1-2 1-1v-2l1 1v-2l1 2-1 3 1-2a5 5 0 010 2c0 1 0-1 0 0a3 3 0 000 2c0 1 1-1 1 1a1 1 0 010 1l-1-1 1 4a9 9 0 010 2l-1 1v-1l-1-2v-3 2h-1l1 1v2l1 2c0 2 0 2 1 1l1-1v-3l-1 2v-2a3 3 0 011-2l1 1v-1l1 1h1c0 3-2 0-2 2a6 6 0 000 1 9 9 0 002-2 10 10 0 010-3 7 7 0 010 3l1-1a4 4 0 000-1l-1 1v-3l-1-1v-2c0-1 0-2-1-1v4c0 2-1 1-1 0l-1-1c0-5 2-5 3-5l1 1-1 1h1l1-1 2-1v-1-1l1 1v-2 3h1l1-4a2 2 0 010-1v-2a4 4 0 010 1l2-5a22 22 0 003-3l4 2c1 0 1-2 2 1s0 8 1 9 2 2 4 1l2-3 3-4c1 0 3 1 4 4l1-1a3 3 0 010 1 3 3 0 000 1v1a7 7 0 010-1l1 1h-1v1a7 7 0 001 0v1a11 11 0 010-1v0l1-1v-2 1a5 5 0 010 1 6 6 0 010-2 4 4 0 011 0v-1-2 1a6 6 0 010 2 25 25 0 010 4v2h2v-1l1-1 1 2a7 7 0 010-1h1v1a2 2 0 001-1l5-6 4 7 5 6 4 2h1v-1 2h1v-1a2 2 0 010 1h1v-2 1a9 9 0 000-1 3 3 0 010-2v-2h1v-1 1s1-3 1-1 0 0-1 1c0 2 1 1 1 1a7 7 0 010 1v1a2 2 0 010 1l1-2v-1-1l1 2s0-1 0 0v-1-1c0-1 0 0 0 0v-1l1 1v-2 2h1v-1a2 2 0 010 1 7 7 0 010-1v1s0-1 0 0h1v-1-1l1-1-1 1v1l1-1v-2c0-1 0 0 0 0v0l1 1v1l1-5v1c0 1 0 0 0 0v2l1-1v-1-2 4l1-4v0l1-1v-2 1a5 5 0 010 1 6 6 0 010-2 4 4 0 011-1v-2 1a7 7 0 010 1 25 25 0 010 5v2a3 3 0 011 1 11 11 0 012-2l1-2v1l1-1h1c0-1 0 0 0 0h1l1-1 1 1 1-6v3l1-1v-1s0 1 0 0v-1l1-1v2l1-1c0-1 0-3 1-2s-1 2-1 3c1 0 1-3 2-2s-1 3-1 3l1-1v1a6 6 0 001-1l1-2 1 1v1h1v-1l1-1v4c1 1 0 0 0 0v2h1a2 2 0 011-1v-1 1a6 6 0 012 0 11 11 0 004 0 6 6 0 012 0 6 6 0 010-2l1-2a4 4 0 000-1l-1-2a6 6 0 011-2v3c0 1 0-1 0 0l1-2v1l1-1 1 2c0 1 0 0 0 0v2h1v-1 1h1v1l1-2a12 12 0 00-1 2l1 1v1l1-1s1-1 3 6l1 1-1-1 1 4v-2c0-1 0-3 1-2s-1 3 0 2v-1a7 7 0 010 3l-1 1 1 1a1 1 0 010 1v-2h1v-4h1v-1s0 3 1 1l-1-2h1v-2l1-3v3c0 1 0 0 0 0v2l-1-2a7 7 0 000 2 4 4 0 000 1h1l1 2v-1a3 3 0 010-1 5 5 0 011-2c0-1 0-1 0 0l1-1a7 7 0 01-1 3h-1a5 5 0 000 1h2a8 8 0 010 3 2 2 0 010 1h7l4-1h2V0L0-2v70c4-7 9-7 9-7zm12 10v-1 1zm0 2v-1 1zm0-3v0zm0 5zm0-4l1-1-1 1zm1 0s0 1 0 0a2 2 0 010 1v-1zm1 2h-1v-1h1c0-1 0 0 0 0a1 1 0 010 1zm0 0v0c0-1 0-1 0 0zm167 7v-1 1zm0-1v-1s1 1 0 0zm164-7zm0 2h0zm1-2v0zm0 5v-1 1zm0-4v-1 1zm0 0v-1 1h0zm1 1v-1 1zm1 0v0l-1 1v-1h1c0 1 0 0 0 0zm167 7v-1 1zm0-1zm163-8zm1 2zm0-2v0zm0 5v-1 1zm0-4v-1 1zm1 0h-1l1-1v1zm0 1v-1 1zm1 0v1h-1 1v-1c0 1 0 0 0 0zm167 7v-1 1zm0-1zm130-31h1l-1-1v1zm-1 1l1 1a3 3 0 010 2l-1-2 1-1zm-8-6l1-1-1 1zm-5 5l1 2-1-2zm-1 6h1v2a3 3 0 010-2zm0-3v-1 1zm-1-1a1 1 0 01-1 1l1-1zm-2-2l1 2v-2zm-3 13a2 2 0 010-1h-1l1-2 1-1a3 3 0 010 1l-1 1v2zm2-3l-1 1v1l-1-1a3 3 0 011-1h1zm-3-5h1v-1a3 3 0 011 1v1l-1-1v2c0 1 0 0 0 0l-1-2zm0 5l1-1v1a3 3 0 01-1 1h-1l1-1zm0-8a3 3 0 010 1v-1zm-1 2zm-3-10l2-1v-1 4l-1-2h-1zm1 4a7 7 0 010-2h1l-1 1 1 1v1s0-1 0 0l-1-1v1l-1 1 1-2zm-2-5h0zm0 3h1v-1a2 2 0 010 1v1l-1 1a3 3 0 010-2zm0 12v-1-2a15 15 0 010-2 8 8 0 010-2l1-1 1 2v-1s1-1 1 1l-1-1v2l1-1v3l1 1h-1s0-1 0 0v1l-1 1 1 1-1 1s1 0 0 0v1l-1 1v2l-1-1 1-1a3 3 0 000-1l-1-1c0-1 0 0 0 0h1v-2 1l-2-1h1zm-5-9l1-1-1 1zm-14 17v-1a1 1 0 010 1zm0-8a9 9 0 010-1h1l-1 1zm0 3v0zm0 2a16 16 0 010-3v3a4 4 0 010 2v-1zm-2-2a3 3 0 011 0v-1a6 6 0 010 1c0 1 0 1 0 0h-1zm0 3a9 9 0 011-1s0-1 0 0l-1 1zm0-2v-1a4 4 0 010 1s0-1 0 0v1a5 5 0 010 1v-1c0-1 0 1 0 0a9 9 0 010-1zm-2-3a9 9 0 010-1v1zm-1 4h1-1zm0 2a16 16 0 010-4v3a4 4 0 010 2v-1zm-1-3v-1a6 6 0 010 2v-1s0 1 0 0zm0 3a9 9 0 010-1v1zm-1-2v-1a3 3 0 010 1v1a5 5 0 010 1v-1c0-1 0 1 0 0a9 9 0 010-1zm-2 7h1l-1-2 1 1-1 1zm1-7v-2 2zm-1 4a8 8 0 010-3l1 1v-1 2a2 2 0 010-1v2l-1-1v1a9 9 0 010-1c1-1 0 0 0 0v1zm0 1v-2a6 6 0 010 2zm-4-2v2a6 6 0 010-2zm-2 8v-1 2s0 1 0 0v-1zm-27-6c0 1 0 1 0 0zm1-7v-1a9 9 0 010-1v2zm-1 3h1c0 1 0 0 0 0h-1zm0 2a16 16 0 010-3v3a4 4 0 010 1v-1zm-1-2a3 3 0 010-1v-1a6 6 0 010 2zm0 2a9 9 0 010-1c0 1 0 0 0 0v1zm-1-2v-1a3 3 0 010 1v1a5 5 0 010 1v-1s0 1 0 0a9 9 0 010-1zm-1-11a4 4 0 010 1v-2zm-1 9v-1a9 9 0 010-1v2zm0 3v0zm-1 2a16 16 0 011-3v3a4 4 0 01-1 1v-1zm-1-2a3 3 0 010-1l1-1a6 6 0 010 2h-1zm-11-2v-1c0 2-1 2-1 1zm-7-16v0zm0 8v0zm-10 3c1-1 1 2 1 3l-1-3zm-5 9l1 1-1-1zm1-2c0 1-1 0 0 0l-1-1c0-2 1 0 1 1zm-2-1v3s0-3 1-2a8 8 0 010 3l-1-1c-1 0 0 0 0 0v-3zm-2 0c1-1 1-1 1 1 0 0 0-1 0 0l-1 1a12 12 0 010-2zm-1 2c0-2 1-3 1-1v1l-1 2a6 6 0 010-2zm-9-3a4 4 0 011 3l-1 1v-4zm-1-5v1l-1 1 1-2zm-1 5h1l-1 1 1 1-1-2zm-5-5a10 10 0 010-1h1l-1 1zm0 3v0zm0 2a16 16 0 010-3v3a4 4 0 010 1s0 1 0 0v-1zm-2-5h0zm-2 1a9 9 0 010-1c0-1 0 0 0 0v1zm-1 3l1 1-1-1zm0-6a9 9 0 010 3c0 1 0 0 0 0v-3zm-1 7l-1 2 1-2zm0-1v-1a6 6 0 010 1c0 1 0 1 0 0zm-5-31v1l-1-2zm-1 2v1a3 3 0 010 1v-2zm-8-7s0-1 0 0zm-6 6l1 2-1-2zm-1 2l1-1-1 1zm-8-4h-1v-1h-1v1a7 7 0 010-3h1l-1 1 1 1v1h1zm-1-5l1-2-1 2v0l-1 1 1-1zm-2-4h0zm0 3v0zm-1 4l1-1v-1a2 2 0 010 1v3a3 3 0 01-1-2zm-5 2l1-1-1 1zm-30 31s0-1 0 0zm-5-5c0 1 0 1 0 0zm1-7v-1a9 9 0 010-1v2zm-1 3h1c0 1 0 0 0 0h-1zm0 2a16 16 0 010-3v3a4 4 0 010 1v-1zm-1-2a3 3 0 010-1v-1a6 6 0 010 2zm0 2a9 9 0 010-1c0 1 0 0 0 0v1zm-1-2v-1a3 3 0 010 1v1a5 5 0 010 1v-1 1a9 9 0 010-2zm-2-2v-1a9 9 0 010-1v2zm0 3v0zm-1 2a16 16 0 011-3v3a4 4 0 01-1 1v-1zm-1-2a3 3 0 010-1l1-1a6 6 0 010 2h-1zm0 3a7 7 0 010-2l1 1h-1v1zm0-3v-1a3 3 0 010 1v1a5 5 0 010 2v-2l-1 1a9 9 0 011-2zm-2 7s0 1 0 0v-1 2zm0-7v-2l1 1-1 2v-1zm-1 4a8 8 0 011-3v2c0-1 0 0 0 0v1a8 8 0 010-1c0-1 0 0 0 0l-1 1zm0 1v-1a6 6 0 010 1zm-3-1c0-1 0 0 0 0l-1 1a6 6 0 010-1zm-2 1h0zm-1 7l1-1c1 0 0-1 0 0l-1 1s0 1 0 0v-1zm-2-9a9 9 0 010 3c0 1 0 0 0 0v-3zm-1 7v0zm-1 0v0zm-1 1v1a7 7 0 010-2v1zm0-4v2-2zm-1 0s0 1 0 0v1a1 1 0 010-1zm-1 1v1s0 1 0 0a2 2 0 010-1zm-6 4v-1a1 1 0 010 1zm0-8v-1a9 9 0 010-1v2zm0 3v0zm0 2a16 16 0 010-3v3a4 4 0 010 1s0 1 0 0v-1zm-2-2a3 3 0 011-1v0a6 6 0 010 1c0 1 0 0 0 0h-1zm0 3a9 9 0 011-1c0-1 0-1 0 0l-1 1zm0-3s0-1 0 0v2a5 5 0 010 1v-1c0-1 0 1 0 0a9 9 0 010-2zm-2-2a9 9 0 010-1c0-1 0 0 0 0v1zm-1 3l1 1-1-1zm-1 0c0-1 0 0 0 0v-1a6 6 0 010 1c0 1 0 0 0 0zm-32 12s0-1 0 0zm-1 1v0zm-1-2c0-1 0 0 0 0zm0 2a1 1 0 010-1v1zm0-2v-1zm-1 4v-1a3 3 0 010 1zm0-1c0-1 0-1 0 0zm0-5a2 2 0 010 1v-1zm-1 3a2 2 0 011-1v1zm0 1v0zm0-5v0zm0 2v0zm0 4zm0-1h-1a2 2 0 011 1h-1a1 1 0 010-1s0 1 0 0a2 2 0 010-1v1a2 2 0 011 1v-1zm0 2a4 4 0 010-2 5 5 0 010 2zm0-6v-1zm-5-5c0 1 0 1 0 0v-1 1zm0-7v-1a8 8 0 011-1l-1 2zm0 3c0-1 0 0 0 0 0 1 0 0 0 0zm0 2a17 17 0 010-3v3a4 4 0 010 1v-1zm-1-2a3 3 0 010-1v-1a6 6 0 010 2zm0 2a9 9 0 010-1c0 1 0 0 0 0v1zm-3-4v-1a10 10 0 010-1v2zm0 3c0-1 0 0 0 0 0 1 0 0 0 0zm-1 2a16 16 0 010-3v3a4 4 0 010 1v-1zm-1-2a3 3 0 010-1v-1a6 6 0 010 2zm0 2a9 9 0 010-1c0 1 0 0 0 0v2zm-1-2l1-1a4 4 0 010 1h-1v1a5 5 0 010 1v-1 1a9 9 0 010-2zm-1 0v-2 2zM11 60v-1l1-1v1l-1 1zm2 0v-1 2a5 5 0 010 1v-1c0-1-1 1 0 0a9 9 0 010-2s0-1 0 0zm1 1l-1 1a9 9 0 010-1h1zm0-2c0 1 0 1 0 0h-1 1v-1a6 6 0 010 1zm1 2a4 4 0 010 1h-1l1-1a16 16 0 010-3v3zm0-1v-1 1zm0-5v1a7 7 0 010-1c0-1 0 0 0 0zm3 5v1a7 7 0 010-1c0-1 0-1 0 0zm0-2c0 1 0 0 0 0a3 3 0 010-1v0a6 6 0 010 1zm1 5v-1 1zm0-3a4 4 0 010 1v-1a16 16 0 010-3v3zm1-1v-1 1zm0-5v0a7 7 0 010-1v1zm6 18c0 1 0 0 0 0zm-1-4v-1 1zm-1-1zm0 5s0-1 0 0a3 3 0 000-1v1a2 2 0 010-1 2 2 0 010 1zm0 1a5 5 0 010-1 4 4 0 010 1zm1 0a1 1 0 01-1-1l1 1c0 1 0 0 0 0zm0-4h-1zm0 2v0zm0-1s0 1 0 0c0 0 0-1 0 0zm0-2h0zm1 5h0v-1a2 2 0 010 1zm0-3v-1 1zm0 1c0-1 0 0 0 0zm1-2zm0 3v-1 1zm1-2zm33-11h-1v-1l1-1a6 6 0 010 2zm1 0c0-1 0 0 0 0zm0-5v1a9 9 0 010-1zm2 4v1a5 5 0 010 1v-1c0-1 0 1 0 0a9 9 0 010-1l1-1a4 4 0 01-1 1zm1 1c0 1 0 0 0 0v1a9 9 0 010-1zm0-1v-1c0-1 0 1 0 0v-1a6 6 0 010 2zm1 4v-1 1zm0-3a4 4 0 010 2v-1a16 16 0 010-4v3zm1-1h-1 1zm0-5v1a9 9 0 010-1zm6 6l-1 1a2 2 0 011-2v1zm1-1h-1a1 1 0 011-1v1zm0 0v0zm0 4v1a7 7 0 010-2v1zm2-1l-1-1 1 1zm1-1l-1 2 1-2zm0-3v-1-2a10 10 0 010 3zm3 6h-1l1-1v-1s0-1 0 0v2zm1-8v0zm1 0a6 6 0 010-1v1c0 1 0 1 0 0zm4 0h-1l1-1a6 6 0 010 1zm0 3v-1-1l1 1-1 1zm0-4v1a9 9 0 010-2c0-1 0 0 0 0v1a8 8 0 010-3v1h1l-1 1h1l-1 1zm1-3v-1-1 2zm1 0v-1 2a5 5 0 010 1v-1c0-1 0 1 0 0a9 9 0 010-2s0-1 0 0a3 3 0 010 1zm1 1v1a9 9 0 010-1s0-1 0 0zm0-2c0 1 0 1 0 0v-1a6 6 0 010 1zm1 2a4 4 0 010 1c0 1 0 1 0 0v-1a16 16 0 010-3v3zm0-1v-1 1zm1-5l-1 1a9 9 0 011-1c0-1 0 0 0 0zm2 3c0 1 0 0 0 0v2a5 5 0 01-1 1l1-1h-1a9 9 0 011-2s0-1 0 0zm1 2h-1v1a9 9 0 010-1h1zm0-2h-1c0-1 0 0 0 0l1-1a6 6 0 010 1zm1 5l-1-1a1 1 0 011 1zm-1-3h1a4 4 0 01-1 1s0 1 0 0v-1a16 16 0 011-3v3zm1-1v-1 1zm0-5v0a10 10 0 010-1v1zm4 13h1zm39-33l-1-2h-1l1-1 1-2v5zm-2-3l-1-1 1 1zm-6 5v-1 1zm6-2l-1 1v1a3 3 0 010-2v-1-1a2 2 0 011 2zm0-7l1 1-1-1zm1 10v-1h-1v1c-1 0 0 0 0 0v-1a7 7 0 011-2c0-1 0-1 0 0v2h1v1h-1zm10 4v-1 1zm1-3v0zm5-5l1-1-1 1zm9 9l-1-2v-1l1 1a3 3 0 010 2zm0-5l1 1-1-1zm6 32l-1 2v-2zm0 0h-1c0-1 0 0 0 0a3 3 0 010-1h1v-1a6 6 0 010 2zm0-3v-1-2a9 9 0 010 3zm1 3c0-1 0 0 0 0 0 1 0 0 0 0zm0-3v-1a10 10 0 010-1v2zm10 0v-1 1zm-8-2l1 1-1-1zm2 6a4 4 0 010 1v-1a16 16 0 010-3v3zm1-2h-1 1c0 1 0 0 0 0zm0-5v1a9 9 0 010-1zm5 6v0zm1 4s0 1 0 0l1-3a4 4 0 010 2l-1 1zm10 0v1a6 6 0 010-2l1-1-1 2zm1-2v2a12 12 0 010-3l1 1h-1zm2 3v-1h-1v-3 3l1-2a8 8 0 010 3zm1-1v0zm0-2v-1l1 2-1-1zm5-4v-2 3zm9-6v0zm0-5v-2h1l-1 2zm7 14l1-2-1 2zm12 1c0 1 0 1 0 0 0 0 0 1 0 0v-1a6 6 0 010 1zm1 2a4 4 0 010 1v-1a16 16 0 010-3v3zm0-1v-1 1zm1-5l-1 1a10 10 0 011-1c0-1 0 0 0 0zm1-7c-1 1-1-1-1-2l1 1a3 3 0 010 1zm1 10c0 1 0 0 0 0v2a5 5 0 01-1 1l1-1h-1a9 9 0 011-2s0-1 0 0zm1 2h-1v1a9 9 0 010-1h1zm0-2h-1c0-1 0 0 0 0l1-1a6 6 0 010 1zm1 5l-1-1a1 1 0 011 1zm-1-3h1a4 4 0 01-1 1s0 1 0 0v-1a17 17 0 011-3v3zm1-1v-1 1zm0-4a9 9 0 010-2v2zm26 14v0l1-1s0-1 0 0c0 2 0 1-1 1zm2-7a6 6 0 011-1l-1 1zm4 0s0 1 0 0v-1a6 6 0 010 1zm1 3v-1s0 1 0 0v-1 2zm0-4a9 9 0 010-1c0-1 0 0 0 0l-1 1a8 8 0 011-3v3zm0-3v-1-2l1 1-1 2zm2-1v2a5 5 0 010 1v-1h-1a9 9 0 011-2v-1a4 4 0 010 1zm1 2s0-1 0 0l-1 1a9 9 0 010-1h1zm0-2h-1a3 3 0 010-1h1a6 6 0 010 1zm1 2a4 4 0 01-1 1v-1a17 17 0 011-3v3zm0-1v-1 1zm0-5v0a9 9 0 010-1v1zm2 3v1a5 5 0 010 2v-2 1a9 9 0 010-2l1-1a4 4 0 01-1 1zm1 2s0-1 0 0v1a9 9 0 010-2v1zm0-2c0 1 0 0 0 0a3 3 0 010-1v-1a6 6 0 010 2zm1 5v-1a1 1 0 010 1zm0-4v1a4 4 0 010 1v-1a16 16 0 010-3v2zm1 0l-1-1c1-1 1 0 1 1zm0-6v1a7 7 0 010-1zm20-17h-1zm3 14v-2a3 3 0 010 2zm0 1h-1 1zm-3-6v0a7 7 0 010-3l1 1h-1l1 1 1 1h-1v-1h-1v1zm1-3v-2l-1 1 1-1 1-2-1 2v2zm-2 0v-1a2 2 0 010 1v3a3 3 0 01-1-2l1-1zm0-3v0zm-6 6l1-1-1 1zm9 8l-1 2v2l-1 1-1 1v1c-1 0 0 0 0 0v-1a3 3 0 000-1v-1-1h1c1-1 0-2-1-2v1s-1 1-1-1v-1l1 1-1-3a15 15 0 010-2 8 8 0 010-2l1-1 1 2v-1l2 1h-1v2l1 2 1 1-1-1h-1l1 1zm1 5l1-2v-1 1a3 3 0 010 1l-1 1zm2 2a2 2 0 01-1-1v-1l1-1v-2a3 3 0 010 1v2 2zm1-4a1 1 0 010 1h-1v0a3 3 0 010-1h1zm-1-3v-1s0 1 0 0v1h-1v-2c1-1 0 1 0 0l1-1a3 3 0 010 1l1 1-1 1zm3-6v1-1zm1 3l-1-1h1a1 1 0 010 1zm1-1l1-1-1 1zm1 5a3 3 0 010-1v-1h1v1l-1 1zm0-7l1 2-1-2zm14 3v-2 1a3 3 0 010 1zm0-5l1 1v1l-1-2zm-8-4s0 1 0 0zm33 20v-1-2 3zm1-1v1a5 5 0 010 1v-1 1a9 9 0 010-2v-1a4 4 0 010 1zm1 2v-1 1a7 7 0 010-1v1zm0-2a3 3 0 010-1v-1a6 6 0 010 2zm1 1v1a4 4 0 010 1v-1a16 16 0 010-3v2zm1-1h-1 1c0 1 0 0 0 0zm0-5v1a8 8 0 010-1zm3 5c0 1 0 0 0 0l-1 1a7 7 0 010-1h1zm0-1h-1a3 3 0 010-1h1v-1a6 6 0 010 2zm1 4c0 1 0 0 0 0v-1 1zm0-3v1a4 4 0 010 1h-1l1-1a17 17 0 010-3v2zm0-1c0-1 0 0 0 0 0 1 0 0 0 0zm0-5v1a6 6 0 010-1zm6 19a1 1 0 010-1v1zm-1-5v-1 1zm0 0v-1 1zm0 4h-1a2 2 0 010 1 1 1 0 010-1s0 1 0 0a2 2 0 010-1v0a2 2 0 011 2v-1zm0 1a5 5 0 010-1 4 4 0 010 2zm0 0zm0-3v-1 1zm0 2v0zm1-2l-1 1a2 2 0 010-1h1zm0-2a3 3 0 010 1v-1zm0 6v-1a2 2 0 010 1zm0-4l1-1-1 1zm1 2a1 1 0 010-1v1zm0-2zm1 3a2 2 0 010-1l-1-1 1 2zm1-2v-1 1zm32-12c0 1 0 0 0 0a3 3 0 010-1v0a6 6 0 010 1zm1 1v-1 1zm1-5l-1 1 1-1a9 9 0 010-1v1zm2 3c0 1 0 0 0 0v2a5 5 0 010 1v-1h-1a9 9 0 011-2v-1a4 4 0 010 1zm1 2l-1 1a9 9 0 010-1h1zm0-2h-1a3 3 0 010-1h1c1 0 0-1 0 0a6 6 0 010 1zm1 5v-1 1zm0-3a4 4 0 01-1 1v-1a16 16 0 011-3v3zm0-1v-1 1zm0-5v0a7 7 0 010-1v1zm6 6c0-1 0 1 0 0a2 2 0 010-1v1zm1-2v1a1 1 0 010-1v1zm0 0l1 2-1-2zm1 4v1a7 7 0 010-2v1zm1 0v-1 1zm1-1s0 2-1 1 1-2 1-1zm1-4c0 1 0 0 0 0v-3a9 9 0 010 3zm2 6s0 1 0 0v-1-1l1 1-1 1zm1-7h0zm1 0a6 6 0 010-1v1zm4 0v-1a6 6 0 010 1zm1 3v-1s0 1 0 0v-1 2zm0-4a9 9 0 010-1h-1v1a8 8 0 011-3v2c0-1 0 0 0 0v1zm0-3v-1-2 3zm2-1h-1v1a5 5 0 010 2v-2 1a9 9 0 010-2l1-1a4 4 0 010 1zm0 2s0-1 0 0v1a9 9 0 010-1c0-1 0-1 0 0zm0-2c0 1 0 0 0 0a3 3 0 010-1 6 6 0 010 1zm1 1v1a4 4 0 010 1v-1a16 16 0 011-3l-1 2zm1 0v-1 1zm0-6v1a9 9 0 010-1zm2 4v1a5 5 0 010 1v-1 1a9 9 0 010-2v-1a4 4 0 010 1zm1 1c0 1 0 0 0 0v1a9 9 0 010-1zm0-1a3 3 0 010-1v-1a6 6 0 010 2zm1 4c0 1 0 1 0 0zm0-3v1a4 4 0 010 1v-1a16 16 0 010-3v2zm0-1h0zm1-5l-1 2 1-1a8 8 0 010-1zm4 14s0-1 0 0zm30-31l1-1-1 1zm8-2v-2h-1l1-1 1-2-1 2v2zm-2-3v-1 1zm0 2v3a3 3 0 01-1-2l1-1v-1a2 2 0 010 1zm0-6h0zm2 9l-1-1c-1 0 0 0 0 0v1a7 7 0 010-3l1 1h-1l1 1v1h0zm9 4l1-1-1 1zm1-2l1 2-1-2zm6-6s0-1 0 0zm8 9v-2 1a3 3 0 010 1zm0-5l1 1v1l-1-2zm6 33l-1 1 1-1zm0-1c0 1 0 1 0 0v-1a6 6 0 010 1zm1-3h-1l1-3a9 9 0 010 3zm0 4v-1l1 1h-1zm0-4h1a9 9 0 010-1c0-1 0 0 0 0l-1 1zm10 1v-2 2zm-7-2h0zm2 5a4 4 0 01-1 1s0 1 0 0v-1a16 16 0 011-3v3zm0-1v-1 1zm0-5v1a10 10 0 010-1c0-1 0 0 0 0zm5 6h1l-1 1 1 1-1-2zm2 4v-4a4 4 0 010 3v1zm9-1v2a6 6 0 010-2c0-2 1-3 1-1l-1 1zm2-1l-1 1a12 12 0 010-2c0-1 1-1 1 1 0 0 0-1 0 0zm2 3l-1-1v-3 3s0-3 1-2a8 8 0 010 3zm0-1l1 1-1-1zm1-2l-1-1c0-2 1 0 1 1h-1zm5-4l-1-3 1 3zm8-6c1-1 1 0 1 1l-1-1zm1-6v-2 2zm6 14c1 0 1-3 1-1l-1 1zm12 2c0 1 0 0 0 0a3 3 0 010-1v-1a6 6 0 010 2zm1 1v1a4 4 0 010 1v-1a16 16 0 011-3l-1 2zm1 0v-1 1zm0-6v1a9 9 0 010-1zm1-6v-2-1a2 2 0 000 1 3 3 0 010 2zm1 10v1a5 5 0 010 1v-1 1a9 9 0 010-2v-1a4 4 0 010 1zm1 1c0 1 0 0 0 0v1a9 9 0 010-1zm0-1a3 3 0 010-1v-1a6 6 0 010 2zm1 4c0 1 0 1 0 0zm0-3v1a4 4 0 010 1v-1a16 16 0 010-3v2zm0-1c0-1 0 0 0 0 0 1 0 0 0 0zm0-3l1-1a9 9 0 010-1l-1 2zm27 14s0 1 0 0v-1-1 2zm2-7a7 7 0 010-2v2zm4 0h-1l1-2a6 6 0 010 2zm0 2c0-1 0 0 0 0v-2l1 1-1 1zm0-3v-1 1a9 9 0 010-2v1s0 1 0 0a8 8 0 010-2v1l1-1-1 2a2 2 0 010-1l1 1-1 1zm1-4v-2 2zm1 0v1a5 5 0 010 1v-1c0-1 0 1 0 0a9 9 0 010-1v-1a4 4 0 010 1zm1 1v1a9 9 0 010-1zm0-1v-1s0 1 0 0v-1a6 6 0 010 2zm1 1a4 4 0 010 2v-1a16 16 0 010-4v3zm0-1c0-1 0 0 0 0 1 0 0 0 0 0zm1-5l-1 1h1a9 9 0 010-1zm2 4s0-1 0 0v1a5 5 0 010 1v-1h-1a9 9 0 011-1v-1a4 4 0 010 1zm1 1l-1 1a7 7 0 010-1h1zm0-2h-1c-1-1 0 1 0 0h1v-1a6 6 0 010 1zm1 5v-1a1 1 0 010 1zm0-3a4 4 0 01-1 2v-1a16 16 0 011-4v3zm0-1v-1 1zm0-5v1a7 7 0 010-1zm14-8v-1 1zm9 4v-1a3 3 0 010 1zm0 1c0 1-1 0 0 0zm-2-5h-1v-1a7 7 0 011-2s0-1 0 0v2h1v1h-1v-1h-1l1 1zm-2-3c1-1 0-2 1-1a2 2 0 010 1l-1 1v1a3 3 0 010-2zm0-3h0zm1-4l1 1-1-1zm2 7l-1-2h-1l2-1v-1 4zm0 11l-1 1v1 1c0 1 1 0 0 0v1l-1 1v2l-1-1 1-1a3 3 0 000-1l-1-1c0-1 0 0 0 0l1-1v-1l-1 1-1-1h1v-1-2a15 15 0 010-2 8 8 0 010-2l1-1 1 2v-1s1-1 1 1l-1-1v2l1-1v3l1 1h-1s0-1 0 0v1zm1 4l1-1 1-1v1a3 3 0 01-1 1h-1zm2 2a2 2 0 010-1h-1l1-2 1-1a3 3 0 010 1l-1 1v2zm1-3v2l-1-1a3 3 0 011-1c0-1 0-1 0 0zm0-4l-1-1v2l-1-2h1v-1a3 3 0 011 1v1c0 1 0 0 0 0zm2-6l1 2-1-2zm1 3h-1l1-1a1 1 0 010 1zm2 0v-1 1zm0 5a3 3 0 010-2h1l-1 2zm1-8v0zm5-5l1-1-1 1zm9 9l-1-2v-1l1 1a3 3 0 010 2zm0-5v1h1l-1-1zm13-10l-1 1 1-1z" fill-rule="evenodd"></path><path d="M301 59v2a2 2 0 000 1l1-1-1-2zM98 61s0 1 0 0l-1 1a4 4 0 011-1l-1-1-1-1v0h-1v3h1a6 6 0 01-1 1 2 2 0 001 0 4 4 0 001-1c0 1 0 1 0 0a3 3 0 001 0v-1zm-2 1v-1 1zm0-1l1 1-1-1zm1 1v-1 1zM171 61l-1 2c-1 0 0 0 0 0v3a3 3 0 010 1c0 1 0 0 0 0v1a1 1 0 011-1v-1l1 2a11 11 0 00-1-6v-1zM264 71zM198 70zM264 71zM23 74zM23 76v-1 1h1l-1-1a2 2 0 000 1zM22 76c0 1 0 0 0 0zM62 61v0c0-1 0 0 0 0zM72 66v-2 2zM19 67v1zM11 62v0c0-1 0 0 0 0zM15 62zM94 59v-1a2 2 0 00-1 1h1a3 3 0 000 1l1 3v-1-1l-1-2zM74 65a1 1 0 000 1h1v-1h-1zM91 52l-1 1v0a3 3 0 010 1 7 7 0 000 1l1-2v-1zM165 60zM88 58a2 2 0 000-1v1zM84 62v-1 1zM85 62a4 4 0 000-1 1 1 0 010 1zM407 67a1 1 0 000 1h1v-1h-1zM396 62l-1 1 1 1v-1-1zM499 62v-1a3 3 0 000 1zM421 59a2 2 0 000-1 2 2 0 010 1zM418 63zM405 67h1a8 8 0 000-1l-1 1zM352 69h1zM348 64v-1a1 1 0 000 1zM344 64c1-1 0 0 0 0zM357 76zM357 77a1 1 0 000 1 1 1 0 010-1zM355 77v1a1 1 0 010-1zM418 64v-1 1zM531 72v-1 1zM562 66v1a7 7 0 000 1v-1-1zM504 63v5a3 3 0 010 1v-1 1a1 1 0 010-1l1-1v2a11 11 0 00-1-5v-1zM604 64s-1 1 0 0l-1 1v-1a3 3 0 010 1 6 6 0 000 1l1-2v-1 1zM505 72h-1v1h1a2 2 0 000-1zM597 73zM598 73zM635 61l-1 2h1v-1-1zM424 54v1a7 7 0 000 1v-1-1zM501 63zM428 61v-1h-1a2 2 0 000 1 3 3 0 001 1v-1zM431 63v-1l-1-1h-1v-1 4c0-1 0-1 0 0a6 6 0 010 1 4 4 0 002-1h-1l1-1v0zm-2 0h0zm1 0v0zm0 1v-1 1zM431 63v1-1z" fill-rule="evenodd"></path><path d="M432 62a1 1 0 00-1 0 2 2 0 000 1l1-1-1 1h1v-1zM740 67a1 1 0 000 1h1v-1h-1zM751 63zM738 67h1v-1l-1 1zM751 64v-1 1zM761 61v-1h-1a2 2 0 000 1 3 3 0 001 1v2l1-2-1-1zM757 54v1a7 7 0 000 1v-1-1zM755 59a2 2 0 000-1 2 2 0 01-1 1h1zM682 64v-1a1 1 0 000 1zM677 64h0zM686 69zM729 62v1h-1l1 1v-1-1zM690 76zM690 77a1 1 0 000 1 1 1 0 010-1zM688 77a8 8 0 000 1h1a1 1 0 01-1-1zM931 73zM895 66v1a7 7 0 000 1v-1-1zM832 62a1 1 0 000-1 1 1 0 000 1zM837 63v5a3 3 0 010 1v-1 1h1a1 1 0 010-1v-1 2a11 11 0 000-5l-1-1zM864 72l1-1-1 1zM937 64s0 1 0 0v0h-1a3 3 0 010 1 7 7 0 000 1c1 1 1-1 1-2v-1 1zM968 61v2a2 2 0 00-1 0h1v-1-1zM930 73h1-1zM838 72h-1a3 3 0 000 1 3 3 0 001 0 2 2 0 000-1z" fill-rule="evenodd"></path><path d="M765 63h-1s0 1 0 0v-1l-1-1s0 1 0 0l-1-1c-1 0 0 0 0 0v4c0-1 0-1 0 0a6 6 0 010 1 2 2 0 001 0 4 4 0 001-1v-1 1l1-1zm-2 0zm0 0v0zm0 1v-1 1z" fill-rule="evenodd"></path><path d="M764 63v1l1-1h-1zM765 62a1 1 0 00-1 0 2 2 0 001 1v-1 0zM834 63z" fill-rule="evenodd"></path>',
			],
			'mountains_2' => [
				'title' => __('Mountains 2','mfn-opts'),
				'viewbox' => '0 0.1 35.33 3.38',
				'svg' => '<path d="M34.08.22C33.4.87-1.22-1.3.03 1.45c.42.02.84-.06 1.25 0 .09-.07.18-.1.27 0 .31-.02.59-.02.87.18.16 0 .32.31.48.12.24.25.52-.1.72.1.66.06 1.27.31 1.9.3.22-.22.43.06.65-.13.16-.05.34-.05.5-.1.22-.17.42.1.63 0 .2.07.4.18.6-.06.42-.18.8-.15 1.16-.41.5-.24 1.04-.64 1.65-.8.2-.12.41-.33.62-.14.5.08 1.07-.14 1.54.04.17-.1.35.18.54.14.16.11.32 0 .46.14.1.23.2-.01.31.1.28.14.57.06.88.08.24-.21.48.27.75.1.14-.13.29 0 .43.05.1-.04.19-.06.28 0 .46 0 .93.1 1.4.17.15-.15.31.1.47.02.1-.15.2 0 .29-.05.09-.05.18-.14.27-.07.06-.07.13.1.19-.03.08-.05.2-.17.29-.02.22.25.49.15.7.35.13-.03.24.2.36.12.07-.19.15 0 .22.05.2.14.38 0 .55.24.2-.06.38.3.55.18.19-.03.37.11.56.09.1.1.2.1.29 0 .09-.03.17.07.25-.02.09.22.17.11.25.07.09-.02.17.07.25 0 .08.17.16.05.24.07.1-.3.5.28.7.13.07-.13.13-.12.2-.05.06-.07.12.08.18.02.12.08.23-.31.37-.28.07-.06.13.08.2 0 .08-.18.16.17.24-.04.17.07.36-.05.5.04.14-.05.3.14.44.16.15.18.3.05.46.11.1.14.2-.09.3.04.33-.16.64.1.99-.06.33-.16.68.18.97.13.15.19.3.05.46.2.15.25.3-.06.47.19.1.08.2 0 .3.07.1.2.22.1.33.07.22.27.45-.19.66.08.16.04.32.13.48.07.3-.2.58.28.81.06.4-.12.8.26 1.16.04.19-.03.38.1.57-.09.27-.38.55-.01.87-.22.01-.98.24-2.8-1.23-2.78" opacity=".2" fill="%23000000"></path><g><path d="M35.31.12H.03v1.23l.32-.02c.15.04.3 0 .46.02.16.02.31-.1.47 0 .09-.07.18-.1.27 0a.45.45 0 01.21-.01c.07.04.14-.03.2.03.15-.02.3.05.46.16.16 0 .32.31.48.12.16.17.32.04.48.07.08.02.16-.13.24.02.17.04.34.1.5.05.17.09.34.13.5.1.16.1.33.13.5.13.13.1.27-.01.4.03.14-.16.27-.06.4-.05.08-.04.17 0 .25-.08.08 0 .16-.02.25-.1.08.02.17.07.26 0 .2-.17.41.1.62 0 .2.07.4.18.6-.06.2-.07.4-.17.6-.15.2-.17.38-.07.56-.27.1.07.19-.13.28-.16.07-.04.15-.02.23-.14.17-.05.36-.15.55-.29.2-.05.4-.13.6-.2.2-.12.4-.33.61-.14.2.08.42-.02.63-.04.2.03.42.04.63.03.1-.05.19-.03.28.05.1-.08.18.02.27.06.09.04.18.08.27.08.08.07.17.03.26.08.07-.04.14 0 .2.06.1.23.2-.01.31.1.1-.02.2.15.31.06.09 0 .17.07.25.03.1.03.21-.08.32-.01.11-.1.22-.09.32.02.15.17.29.08.43.09.14-.14.29 0 .43.04.1-.04.18-.06.28 0 .16-.07.31.06.47.02.15.1.3.04.46.07.15.02.3.03.47.08.15-.15.31.1.47.02.1-.15.2 0 .29-.05.09-.05.18-.14.27-.07.06-.08.13.1.19-.03.08-.05.2-.17.29-.02.1.07.22.19.34.2.05.05.11.05.17.05.06-.02.12-.02.18.1.06 0 .12 0 .18.06.06.1.13.08.19.06.07-.2.15 0 .22.05.1.1.18.04.27.08.1-.05.18.09.28.16.09-.04.18.07.27.09.1.11.19.14.28.09.1 0 .19-.02.28.05.1 0 .19.06.28.04.1.1.2.1.29 0 .09-.03.17.07.25-.02.09.22.17.11.25.07.09-.02.17.07.25 0 .08.17.16.05.24.07.09-.16.17-.12.25.01.08.06.16.04.25.08.07.03.14.12.2.04.07-.13.13-.12.2-.05.06-.07.12.08.18.02.06.02.12 0 .19-.15.06-.11.12-.1.18-.13.07-.06.13.08.2 0 .08-.19.16.17.24-.04a.5.5 0 00.26 0c.08.07.16-.06.24.04.07-.03.14 0 .22.06.07.06.14.06.22.1.15.18.3.05.46.11.1.14.2-.09.3.04.17-.14.34-.04.5 0 .16.07.33-.08.49-.06.16-.08.32.01.5-.01.16.04.32.23.47.14.15.19.3.05.46.2.15.25.3-.06.47.19.1.08.2 0 .3.07.1.2.22.1.33.07.1.12.22.09.33.04.1 0 .22-.15.33.04.16.04.32.13.48.07.17-.04.33-.09.49.04.1.06.21.18.32.02.2.03.39-.1.58.06.2-.06.39.2.58-.02.19-.03.38.1.57-.1.18-.32.37-.08.55-.15.1 0 .22-.01.32-.06z" fill="%23000000"></path></g><path d="M.04 0h35.28v.12H.04z" fill="%23000000"></path>',
			],
			'spikes_opacity_1' => [
				'title' => __('Spikes Opacity','mfn-opts'),
				'viewbox' => '0 0 2003.4 89.5',
				'svg' => '<path d="M3 48l12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 21 12-21 12-21 8-14 4-7 8-13 7 13 12 21 12 21 12 21 12-21 12-21 9-14 4-7 5-10 6 10 12 21 12 21 12 21 12-21 12-21h1l12-21 7-13 8 13 12 21 12 21 12 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12 21 12-21 12-21 8-14 4-7 8-13 8 13 12 21 12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 21 12-21 12-21 12-21 7-13 8 13 12 21 12 21 12 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12 21 12-21 12-21 12-21 8-13 9 13 12 21 12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 20 12-20 12-21 12-21 8-13 8 13 12 21 12 21 12 20 12-20 12-21 12-21 6-10 6 10 12 21 12 21 12 21 12-21 12-21 4-7 8-14 8-13 8 13 12 21 12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 21 12-21 12-21 12-21 8-13 7 13 12 21 12 21 12 21 12-21 12-21 8-14 4-7 6-10 6 10 12 21 12 21 12 20 12-20 12-21 4-7 8-14 8-13 8 13 12 21 12 21 12 20 12-20 12-21 12-21 6-10 6 10 12 21 12 21 12 20 12-20 12-21 8-14 4-7 8-13 8 13 12 21 12 21 12 21 12-21 12-21 8-14 4-7 6-10 6 10 12 21 12 21 12 21 12-21 12-21 12-21 7-13 8 13 12 21 12 21 12 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12-21-12-21 4 7 5 9 3 5-12 21 12 21 2-4V6H0v37zm1994-34l-1 2-2 3-1 3 5-9zm-251 34l-8 13 7-13 12-21zm-948 0l-7 13 7-13 12-21zm-343 0l-8 13 8-13 12-21z" opacity=".5"></path><path d="M12 20l12 21 12 20 12 21 12-21 12-20 12-21 6-10 6 10 12 21 12 20 12 21 12-21 12-20 10-16 2-5 8-13 8 13 12 21 12 20 12-20 12-21-12 21-12 20 12 21 12-21 12-20 10-16 2-5 6-10 6 10 12 21 12 20 12 21 12-21 12-20 3-4 9-17 8-13 8 13 12 21 12 20 12 21 12-21 12-20 12-21 6-10 6 10 12 21 12 20 12 21 12-21 12-20 12-21 8-13 8 13 12 21 12 20 12 21 12-21 12-20 2-4 10-17 6-10 6 10 12 21 12 20 12 21 12-21 12-20 12-21 8-13 8 13 12 21 12 20 12 21 12-21 12-20 12-21 6-10 6 10 12 21 12 20 12-20 12-21-12 21-12 20 12 21 12-21 12-20 12-21 8-13 7 13 12 21 13 20 12 21 12-21 12-20 2-5 10-16 6-10 6 10 12 21 12 20 12 21 12-21 12-20 12-21 8-13 7 13 12 21 12 20 12 21 12-21 12-20 10-16 3-5 6-10 6 10 12 21 12 20 12 21 12-21 12-20 2-4 10-17 7-13 8 13 12 21 12 20 12 21 12-21 12-20 3-4 9-17 6-10 6 10 12 21 12 20 13 21 12-21 12-20 9-16 3-5 7-13 8 13 12 21 12 20 12 21 12-21 12-20 10-16 2-5 6-10 6 10 12 21 12 20 12 21 12-21 12-20h1l2-4 9-17 8-13 8 13 12 21 12 20 12 21 12-21 12-20 12-21 6-10 6 10 12 21 12 20 12 21 12-21 12-20 10-16 2-5 8-13 8 13 12 21 12 20 12-20 12-21-12 21-12 20 12 21 12-21 12-20 10-16 2-5 6-10 6 10 12 21 12 20 12 21 12-21 12-20 12-21 8-13 8 13 12 21 12 20 12 21 12-21 12-20 12-21 6-10 6 10 1 3 3 5h1l2 4 4 7 1 2 1 3 3 4V0H0l12 20z" opacity=".75"></path><path d="M4 80l12-21 12-21 12-21 6-10 6 10 12 21 12 21 12 21 13-21 12-21 4-7 8-14 7-13 8 13 12 21 12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 21 12-21 12-21h1l12-21 7-13 8 13 12 21 12 21 12 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12 21 12-21 12-21 4-7 8-14 8-13 8 13 12 21 12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 21 12-21 12-21 8-14 4-7 8-13 8 13 12 21 12 21 12 21 12-21 12-21 8-14 4-7 6-10 6 10 12 21 12 21 12 21 12-21 12-21 12-21 8-13 8 13 12 21 12 21 12 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12 21 12-21 12-21 8-14 4-7 8-13 8 13 12 21 12 21 12-21 12-21-12 21-12 21 12 21 12-21 12-21 8-14 4-7 6-10 6 10 12 21 12 21 12 21 12-21 12-21 12-21 8-13 7 13 12 21 12 21 13 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12-21 12-21-12 21-12 21 12 21 12-21 12-21 8-14 4-7 8-13 7 13 12 21 12 21 12 21 12-21 12-21h1l11-21h1l5-10 6 10 13 21 12 21 12 21 12-21 12-21 12-21 7-13 8 13 12 21 12 21 12 21 12-21 12-21 12-21 6-10 6 10 12 21 12 21 12 21 12-21 13-21 4-7 8-14 7-13 8 13 12 21 12 21 12 21 12-21 12-21 4-7 8-14 6-10 6 10 12 21 12 21 12 21 12-21 12-21 13-21 7-13 8 13 12 21 12 21 12 21 12-21 12-21 8-14 4-7 6-10 6 10 12 21 12 21 12 21 12-21 12-21-9-16v1l5 8 3 5 1 2V0h-2l-1 1 1-1H0v72l4 8z" opacity=".7"></path><path d="M9 41l12-21 6-10 6 10 12 21 12 20 12 21 12-21 12-20 12-21 8-13 7 14 12 20 12 20 12 21 12-21 12-20 12-21 6-10 6 11 12 20 12 20 12-20 12-20-11 20-12 20 12 21 12-21 12-20 12-21 7-13 8 14 12 20 12 20 12 21 12-21 12-20 3-4 9-16 6-11 6 11 13 20 12 20 12 21 12-21 12-20 12-21 7-13 8 13 12 21 12 20 12 21 12-21 12-20 10-16 2-5 6-10 6 10 12 21 12 20 12 21 12-21 12-20 3-4 10-17 7-13 8 13 12 21 12 20 12 21 12-21 12-20 3-5 9-16 6-10 6 10 12 21 12 20 12 21 12-21 12-20 10-16 3-5 7-13 8 13 12 21 12 20 12 21 12-21 12-20 10-16 2-5 6-10 6 11 12 20 12 20 12 21 12-21 12-20 3-4 9-16 8-14 8 14 12 20 12 20 12 21 12-21 12-20 12-21 6-10 6 11 12 20 12 20 12 21 12-21 12-20 10-16 2-5 8-13 8 14 12 20 12 20 12-20 12-20-12 20-12 20 12 21 12-21 12-20 12-21 6-10 6 11 12 20 12 20 12 21 12-21 12-20 3-4 9-16 8-14 8 14 12 20 12 20 12 21 12-21 12-20 12-21 6-10 6 11 12 20 12 20 12 21 12-21 12-20 12-21 7-13 8 14 12 20 12 20 12 21 12-21 12-20 12-21 6-10 6 11 12 20 12 20 12 21 12-21 12-20 12-21 8-13 8 14 12 20 12 20 12 21 12-21 12-20 12-21 6-10 6 11 12 20 12 20 12-20 12-20-12 20-12 20 12 21 12-21 12-20 2-4 10-16 7-14 8 14 12 20 12 20 12 21 12-21 12-20 3-4 9-16 6-11 6 11 12 20 12 20 12 21 12-21 12-20 12-21 2-2 4-7 2-4V0h-20l1 1v1l1-2H9L8 1H0v55l9-15zm1985-23l1 1-1-1zM11 5l10 15z"></path>',
			],
			'split_1' => [
				'title' => __('Split','mfn-opts'),
				'svg' => '<path d="M0,0V3.6H580.08c11,0,19.92,5.09,19.92,13.2,0-8.14,8.88-13.2,19.92-13.2H1200V0Z" class="shape-fill"></path>',
				'invert' => '<path d="M600,16.8c0-8.11-8.88-13.2-19.92-13.2H0V120H1200V3.6H619.92C608.88,3.6,600,8.66,600,16.8Z" class="shape-fill"></path>',
			],
			'tilt_opacity_1' => [
				'title' => __('Tilt Opacity','mfn-opts'),
				'viewbox' => '0 0 381 77.25',
				'svg' => '<path d="M381 8.47L0 42.33V0h381z"></path><path d="M381 33.87L0 59.27V0h381z" opacity=".33"></path><path d="M381 59.27L0 77.25V0h381z" opacity=".33"></path>',
			],
			'tilt_opacity_2' => [
				'title' => __('Tilt Opacity 2','mfn-opts'),
				'viewbox' => '0 0 381 59.27',
				'svg' => '<path d="M381 8.47L0 42.33V0h381z"></path><path d="M381 33.87L0 59.27V0h381z" opacity=".66"></path>',
			],
			'triangle_1' => [
				'title' => __('Triangle','mfn-opts'),
				'svg' => '<path d="M1200 0L0 0 598.97 114.72 1200 0z" class="shape-fill"></path>',
				'invert' => '<path d="M598.97 114.72L0 0 0 120 1200 120 1200 0 598.97 114.72z" class="shape-fill"></path>',
			],
			'triangle_asymmetrical_1' => [
				'title' => __('Triangle Asymmetrical','mfn-opts'),
				'svg' => '<path d="M1200 0L0 0 892.25 114.72 1200 0z" class="shape-fill"></path>',
				'invert' => '<path d="M892.25 114.72L0 0 0 120 1200 120 1200 0 892.25 114.72z" class="shape-fill"></path>',
			],
			'tilt' => [
				'title' => __('Tilt','mfn-opts'),
				'svg' => '<path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>',
			],
			'waves_1' => [
				'title' => __('Waves','mfn-opts'),
				'svg' => '<path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>',
				'invert' => '<path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>',
			],
			'waves_opacity_1' => [
				'title' => __('Waves Opacity','mfn-opts'),
				'svg' => '<path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
					<path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
					<path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>',
			],
			'waves_opacity_2' => [
				'title' => __('Waves Opacity 2','mfn-opts'),
				'viewbox' => '0 0 35.28 2.17',
				'svg' => '<path d="M0 .5c3.07.55 9.27-.42 16.14 0 6.88.4 13.75.57 19.14-.11V0H0z"></path><path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" opacity=".5"></path><path d="M0 1.85c2.56-.83 7.68-.3 11.79-.42 4.1-.12 6.86-.61 9.58-.28 2.73.33 5.61 1.17 8.61 1 3-.19 4.73-.82 5.3-.84V.1H0z" opacity=".5"></path>',
			],
			'waves_opacity_3' => [
				'title' => __('Waves Opacity 3','mfn-opts'),
				'viewbox' => '0 0 2000.4 78.7',
				'svg' => '<path d="M0 59V0h2000v61c-11-1-22-6-32-13-10-6-19-14-30-20a90 90 0 00-91 4c-10 6-18 15-28 21a80 80 0 01-68 8 80 80 0 01-68-8c-10-6-19-15-29-21a90 90 0 00-91-4l-29 20c-10 6-22 12-34 13a33 33 0 01-4-1v1c-12-1-23-6-32-13l-30-20a90 90 0 00-91 4c-10 6-18 15-28 21a80 80 0 01-69 8 80 80 0 01-68-8c-10-6-18-15-28-21a90 90 0 00-91-4c-11 6-20 14-30 20s-21 12-33 13a33 33 0 01-4-1v1c-12-1-23-6-33-13l-29-20a90 90 0 00-92 4c-9 6-18 15-28 21a80 80 0 01-68 8 80 80 0 01-68-8c-10-6-18-15-28-21a89 89 0 00-91-4c-11 6-20 14-30 20l-6 4c-8 5-17 8-27 9a33 33 0 01-5-1v1c-11-1-22-6-32-13-10-6-19-14-30-20l-3-1a87 87 0 00-35-10 90 90 0 00-43 9 81 81 0 00-10 6l-8 6-20 15a80 80 0 01-68 8 80 80 0 01-68-8l-20-15-8-6a82 82 0 00-11-6 90 90 0 00-44-8 87 87 0 00-35 9l-2 1-29 20A79 79 0 010 59z" opacity=".75"></path><path d="M1523 0h454a33 33 0 01-16 20h-2a33 33 0 01-22 2 22 22 0 01-16 15 15 15 0 01-6 5 22 22 0 01-13 3 52 52 0 01-14-4l-11-5-35-17a75 75 0 00-51-2 157 157 0 00-41 27 151 151 0 00-46-28c-15-4-31-2-45 3-13 5-24 11-36 17l-11 5a52 52 0 01-13 4 22 22 0 01-14-3 15 15 0 01-6-5 22 22 0 01-16-15 33 33 0 01-22-2h-1a33 33 0 01-17-20z" opacity=".5"></path><path d="M1496 0h504v13c-6 11-20 16-31 12a37 37 0 01-10-5c-7-5-14-13-24-15-12-3-24 4-34 12-8 6-15 14-24 19a43 43 0 01-7 3c-14 4-29 1-42-5-11-5-21-12-32-18l-5-3c-13-6-27-10-41-7-14-3-28 1-41 7l-5 3c-11 6-21 13-32 18-13 6-28 9-42 5a43 43 0 01-7-4c-9-4-16-12-24-18-10-8-22-15-34-12-10 2-17 10-24 15a37 37 0 01-10 5c-14 5-31-4-34-19l-1-6z"></path><circle cx="1940.6" cy="49.4" r="8.5"></circle><circle cx="1841.1" cy="46.1" r="5.2"></circle><circle cx="1624.5" cy="46.1" r="5.2"></circle><circle cx="1564.4" cy="42" r="7.3"></circle><circle cx="1894" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="1679.1" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="1750" cy="72.9" r="2.8" opacity=".75"></circle><path d="M1019 0h454a33 33 0 01-17 20h-1a33 33 0 01-22 2 22 22 0 01-17 15 15 15 0 01-5 5 22 22 0 01-14 3 52 52 0 01-13-4l-11-5-36-17a75 75 0 00-50-2 157 157 0 00-41 27 151 151 0 00-46-28c-15-4-31-2-46 3l-35 17-11 5a52 52 0 01-14 4 22 22 0 01-13-3 15 15 0 01-6-5 22 22 0 01-17-15 33 33 0 01-22-2h-1a33 33 0 01-16-20z" opacity=".5"></path><path d="M992 0h504v13c-6 11-20 16-32 12a37 37 0 01-9-5c-8-5-15-13-24-15-12-3-25 4-35 12-7 6-15 14-23 19a43 43 0 01-7 3c-14 4-29 1-42-5-11-5-21-12-32-18l-5-3c-13-6-27-10-41-7-14-3-29 1-41 7l-5 3c-11 6-21 13-33 18-13 6-28 9-41 5a43 43 0 01-7-4c-9-4-16-12-24-18-10-8-22-15-35-12-9 2-16 10-24 15a37 37 0 01-9 5c-14 5-31-4-34-19l-1-6z"></path><circle cx="1436.3" cy="49.4" r="8.5"></circle><circle cx="1336.8" cy="46.1" r="5.2"></circle><circle cx="1120.3" cy="46.1" r="5.2"></circle><circle cx="1060.2" cy="42" r="7.3"></circle><circle cx="1389.7" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="1174.8" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="1245.7" cy="72.9" r="2.8" opacity=".75"></circle><path d="M514 0h455a33 33 0 01-17 20h-1a33 33 0 01-22 2 22 22 0 01-17 15 15 15 0 01-6 5 22 22 0 01-13 3 52 52 0 01-13-4l-12-5-35-17a75 75 0 00-50-2 157 157 0 00-41 27 150 150 0 00-46-28c-15-4-31-2-46 3l-36 16-11 5a52 52 0 01-13 4 22 22 0 01-14-2 15 15 0 01-5-5 22 22 0 01-17-15 33 33 0 01-22-2h-1a33 33 0 01-17-20z" opacity=".5"></path><path d="M488 0h504v13c-6 11-20 16-32 12a37 37 0 01-9-5c-8-5-15-13-24-15-12-3-25 4-35 12-8 6-15 14-24 18a43 43 0 01-7 4c-13 4-28 1-41-5l-33-18-4-3c-13-6-28-10-42-7-13-3-28 1-41 7l-4 3-33 18c-13 6-28 9-41 5a43 43 0 01-8-4c-8-4-16-12-23-18-10-8-23-15-35-12-9 2-16 10-24 15a37 37 0 01-9 5c-14 5-31-4-35-19V0z"></path><circle cx="932" cy="49.4" r="8.5"></circle><circle cx="832.6" cy="46.1" r="5.2"></circle><circle cx="616" cy="46.1" r="5.2"></circle><circle cx="555.9" cy="42" r="7.3"></circle><circle cx="885.4" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="670.6" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="741.4" cy="72.9" r="2.8" opacity=".75"></circle><path d="M10 0h454a33 33 0 01-16 20h-2a33 33 0 01-21 2 22 22 0 01-17 15 15 15 0 01-6 5 22 22 0 01-13 3 52 52 0 01-14-4l-11-5-35-17a75 75 0 00-50-2 157 157 0 00-41 27 150 150 0 00-47-28c-14-4-31-2-45 3l-36 16-11 5a52 52 0 01-13 4 22 22 0 01-14-2 15 15 0 01-5-5 22 22 0 01-17-15 33 33 0 01-22-2h-1A33 33 0 0110 0z" opacity=".5"></path><path d="M0 24V0h488v13c-7 11-20 16-32 12a37 37 0 01-10-5c-7-5-14-13-23-15-13-3-25 4-35 12h-1c-7 7-14 14-23 18a43 43 0 01-7 4c-10 3-21 2-31-1a84 84 0 01-10-4c-12-5-22-12-33-18l-5-3c-12-6-27-10-41-7-14-3-28 1-41 7l-5 3c-11 6-21 13-32 18a83 83 0 01-9 4c-11 3-22 4-33 1a43 43 0 01-7-4c-8-4-15-11-23-18h-1C77 9 64 2 52 5c-9 2-16 10-24 15a37 37 0 01-10 5 26 26 0 01-18-1z"></path><circle cx="427.8" cy="49.4" r="8.5"></circle><circle cx="328.3" cy="46.1" r="5.2"></circle><circle cx="111.7" cy="46.1" r="5.2"></circle><circle cx="51.6" cy="42" r="7.3"></circle><circle cx="381.1" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="166.3" cy="72.9" r="5.8" opacity=".5"></circle><circle cx="237.2" cy="72.9" r="2.8" opacity=".75"></circle>',
			],
			'waves_opacity_4' => [
				'title' => __('Waves Opacity 4','mfn-opts'),
				'viewbox' => '0 0 381 76.2',
				'svg' => '<path d="M381 76.2l-12.7-8.47c-12.7-8.46-38.1-25.4-63.5-28.23-25.4-2.72-50.8 8.39-76.2 5.66-25.4-2.83-50.8-19.76-76.2-18.36-25.4 1.51-50.8 21.09-76.2 28.23-25.4 7.15-50.8 1.33-63.5-1.4L0 50.8V0h381z"></path><path d="M381 67.73l-12.7-4.23c-12.7-4.23-38.1-12.7-63.5-12.7s-50.8 8.47-76.2 7.06c-25.4-1.5-50.8-12.62-76.2-11.3-25.4 1.33-50.8 15.62-76.2 21.17-25.4 5.56-50.8 2.91-63.5 1.4L0 67.74V0h381z" opacity=".66"></path>',
			],
		];

		// get single dimensional array with key, value

		if( 'options' == $primary_key ){

			$array = [
				'' => __('None','mfn-opts'),
			];

			foreach( $shape_dividers as $key => $value ){
				$array[$key] = $value['title'];
			}

			return $array;

		}

		// get coma separated list of invert dividers (for conditions)

		if( 'invert' == $primary_key ){

			$array = [];

			foreach( $shape_dividers as $key => $value ){
				if( !empty( $value['invert'] ) ){
					$array[] = $key;
				}
			}

			$string = implode(',',$array);

			return $string;

		}

		if( $primary_key ){

			if( $secondary_key ){
				if( !empty($shape_dividers[$primary_key][$secondary_key]) ){
					return $shape_dividers[$primary_key][$secondary_key];
				}
			} else {
				return $shape_dividers[$primary_key];
			}

			return false;

		}

		return $shape_dividers;

	}

	/**
	 * GET Shape divider html
	 */

	public static function shapedDivider( $name = false, $position = false, $is_inverted = false, $is_flipped = false, $bring_front = false ){

		$viewbox = '0 0 1200 120';

		if( 'empty' == $name ){

			$html = '<div class="mfn-shape-divider mfn-shape-divider-'. esc_attr($position).'" data-bring-front="0" data-flip="0" data-invert="0" data-name="'. esc_attr($position) .'">';
				$html .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="'. esc_attr($viewbox).'" preserveAspectRatio="none"><path></path></svg>';
			$html .= '</div>';

			return $html;
		}

		// viewbox

		if( self::get_shape_divider( $name, 'viewbox' ) ){
			$viewbox = self::get_shape_divider( $name, 'viewbox' );
		}

		// invert

		$key = 'svg';

		if( $is_inverted && self::get_shape_divider( $name, 'invert' ) ){
			$key = 'invert';
		} else {
			$is_inverted = 0;
		}

		$html = '<div class="mfn-shape-divider mfn-shape-divider-'. esc_attr($position).'" data-bring-front="'. $bring_front .'" data-flip="'. $is_flipped .'" data-invert="'. $is_inverted .'" data-name="'. $position .'">';
			$html .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="'. esc_attr($viewbox).'" preserveAspectRatio="none">';

				$html .= self::get_shape_divider( $name, $key );

			$html .= '</svg>';
		$html .= '</div>';

		return $html;
  }


}
