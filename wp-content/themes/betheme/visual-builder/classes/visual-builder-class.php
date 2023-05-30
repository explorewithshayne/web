<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

class MfnVisualBuilder {

	public $post_type = false;
	public $template_type = false;
	public $page_options = false;
	public $theme_options = false;
	public $options = array();
	public $widgets = array();
	public $scripts = array();
	public $styles = array();
	public $post_id = false;
	public $view = 'demo';

	public function __construct() {
	global $post;

	if( !isset($post->ID) && apply_filters('is_bebuilder_demo', false) ){
		$this->post_id = get_the_ID();
	}else if( isset($post->ID) ){
		$this->post_id = $post->ID;
		$this->view = 'admin';
	}

	if( $this->post_id ){

		$this->post_type = get_post_type($this->post_id);

	    if($this->post_type == 'template') $this->template_type = get_post_meta($post->ID, 'mfn_template_type', true);

		if($this->post_type == 'post'){
		  $po_class = new Mfn_Post_Type_Post();
		}elseif($this->post_type == 'portfolio'){
		  $po_class = new Mfn_Post_Type_Portfolio();
		}elseif($this->post_type == 'template'){
		  $po_class = new Mfn_Post_Type_Template();
		}elseif($this->post_type == 'product'){
		  $po_class = new Mfn_Post_Type_Product();
		}else{
		  $po_class = new Mfn_Post_Type_Page();
		}

		if( $this->template_type == 'header' ){
			$this->page_options = $po_class->set_header_fields();
		}elseif( $this->template_type == 'footer' ){
			$this->page_options = $po_class->set_footer_fields();
		}elseif( $this->template_type == 'megamenu' ){
			$this->page_options = $po_class->set_megamenu_fields();
		}elseif( $this->template_type == 'popup' ){
			$this->page_options = $po_class->set_popup_fields();
		}else{
			$this->page_options = $po_class->set_fields();
		}
    }

  }

  public function mfn_add_admin_beglobalsections_class($classes){
	return $classes.' mfn-template-section';
  }

  public function mfn_add_admin_beglobalwraps_class($classes){
    return $classes.' mfn-template-wrap';
  }

  public function mfn_add_admin_beheader_class($classes){
  	return $classes.' mfn-preview-mode mfn-be-header-builder';
  }

  public function mfn_add_admin_bemegamenu_class($classes){
  	return $classes.' mfn-preview-mode mfn-be-megamenu-builder';
  }

  public function mfn_add_admin_befooter_class($classes){
  	return $classes.' mfn-preview-mode mfn-be-megamenu-builder';
  }
  
  public function mfn_add_admin_bepopup_class($classes){
  	return $classes.'mfn-be-popup-builder';
  }

  	public function mfn_required_scripts(){
  		$this->scripts = array(
	  		'wp-auth-check',
	  		'heartbeat',
	  		'jquery',
	  		'jquery-core',
	  		'jquery-migrate',
	  		'jquery-ui-core',
	  		'jquery-ui-tabs',
	  		'mediaelement',
	  		'mediaelement-core',
	  		'mediaelement-migrate',
	  		'mediaelement-vimeo',
	  		'wp-mediaelement',
	  		//'media-upload',
	  		'media-models',
	  		'media-views',
	  		'media-editor',
	  		'media-audiovideo',
	  		'media-widgets',
	  		'media-audio-widget',
	  		'media-image-widget',
	  		'media-gallery-widget',
	  		'media-video-widget',
	  		'media-grid',
	  		'media',
	  		'media-gallery',
	  		'wp-media-utils'
		);
  	}

	public function mfn_required_styles(){
		$this->styles = array(
			'colors',
			'common',
			'forms',
			'admin-menu',
			'dashboard',
			'list-tables',
			'edit',
			'revisions',
			'media',
			'themes',
			'about',
			'nav-menus',
			'widgets',
			'site-icon',
			'l10n',
			'code-editor',
			'site-health',
			'wp-admin',
			'login',
			'tabs',
			'install',
			'wp-color-picker',
			'customize-controls',
			'customize-widgets',
			'customize-nav-menus',
			'buttons',
			'dashicons',
			'admin-bar',
			'wp-auth-check',
			'editor-buttons',
			'media-views',
			'wp-pointer',
			'customize-preview',
			'wp-embed-template-ie',
			'imgareaselect',
			'wp-jquery-ui-dialog',
			'mediaelement',
			'wp-mediaelement',
		);
	}


	public function mfn_append_vb_styles() {
		global $wp_scripts;
		global $wp_styles;

		if( wp_script_is( 'mfn-vbscripts', 'enqueued') ){
 			return; // prevent localize script more than once
 		}

		$create_bebuilder_fields = true;

	    foreach( $wp_scripts->registered as $script ) {
        if( $this->scripts && !in_array($script->handle, $this->scripts) ) {
        	wp_dequeue_script( $script->handle );
        	// wp_deregister_script( $script->handle );
        }
	    }

	    foreach( $wp_styles->registered as $style ) {
        if( !in_array($style->handle, $this->styles) ) {
        	wp_dequeue_style( $style->handle );
					if( 'mfn-dynamic' == $style->handle ){
						wp_deregister_style( $style->handle );
					}
        }
	    }

	    wp_enqueue_style('mfn-vbstyle', get_theme_file_uri('/visual-builder/assets/css/style.css'), false, time(), false);

	    $mfn_beform_ver = get_option('betheme_form_uid') ? get_option('betheme_form_uid') : MFN_THEME_VERSION;

	    $bebuilder_items_file = '/visual-builder/assets/js/forms/bebuilder-'.MFN_THEME_VERSION.'.js';
	    $bebuilder_items_path = get_template_directory().$bebuilder_items_file;

	    if( is_admin() && (!file_exists( $bebuilder_items_path ) || ( defined('MFN_DEBUG') && MFN_DEBUG == 1 ) ) ) {
	    	$create_bebuilder_fields = Mfn_Helper::generate_bebuilder_items( $bebuilder_items_path, $this->fieldsToJS() );
	    	$mfn_beform_ver = time();
	    }

	    if( $create_bebuilder_fields ) {
	    	wp_enqueue_script( 'mfn-bebuilder-fields', get_template_directory_uri() . $bebuilder_items_file, false, $mfn_beform_ver, true );
	    	wp_add_inline_script( 'mfn-bebuilder-fields', $this->getDbLists(), 'before' );
	    }else{
	    	echo '<script id="mfn-vb-dblists">'.$this->getDbLists().'</script>';
	    	echo '<script id="mfn-bebuilder-fields-live">'.$this->fieldsToJS().'</script>';
	    }

		//wp_enqueue_script( 'mfn-opts-plugins',get_template_directory_uri() .'/muffin-options/js/plugins.js', array('jquery'), MFN_THEME_VERSION, true );
		wp_enqueue_script('mfn-plugins', get_theme_file_uri('/js/plugins.js'), array('jquery'), MFN_THEME_VERSION, true);

		wp_enqueue_style('mfn-vbreset', get_theme_file_uri('/visual-builder/assets/css/reset.css'), false, MFN_THEME_VERSION, 'all');

		wp_enqueue_script('wp-theme-plugin-editor');
		wp_enqueue_style('wp-codemirror');

		wp_enqueue_script( 'jquery-ui-resizable' );
		wp_enqueue_script( 'jquery-ui-sortable'  );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-progressbar' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-slider' );

	  // Add the color picker

	  wp_enqueue_style( 'wp-color-picker' );
	  wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
		wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );

		// webfont

		if( ! mfn_opts_get('google-font-mode') ) {
			wp_enqueue_script( 'mfn-webfont', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', array( 'jquery' ), false, true );
		}

		wp_enqueue_media();
		wp_enqueue_editor();

		wp_enqueue_script('mfn-rangy', get_theme_file_uri('/visual-builder/assets/js/rangy-core.js'), false, MFN_THEME_VERSION, true);
		wp_enqueue_script('mfn-rangy-classapplier', get_theme_file_uri('/visual-builder/assets/js/rangy-classapplier.js'), false, MFN_THEME_VERSION, true);

		// icons
		wp_enqueue_style('mfn-icons', get_theme_file_uri('/fonts/mfn/icons.css'), false, time());
		wp_enqueue_style('mfn-font-awesome', get_theme_file_uri('/fonts/fontawesome/fontawesome.css'), false, time());

		// VB styles & scripts
		wp_enqueue_style('mfn-vbcolorpickerstyle', get_theme_file_uri('/visual-builder/assets/css/nano.min.css'), false, time(), false);
		wp_enqueue_style('mfn-vbstyle', get_theme_file_uri('/visual-builder/assets/css/style.css'), false, time(), false);

		wp_enqueue_script('mfn-vbcolorpickerjs', get_theme_file_uri('/visual-builder/assets/js/pickr.min.js'), false, time(), true);
		wp_enqueue_script('mfn-inline-editor-js', get_theme_file_uri('/visual-builder/assets/js/medium-editor.min.js'), false, time(), true);
		wp_enqueue_script('mfn-vblistjs', get_theme_file_uri('/visual-builder/assets/js/list.min.js'), false, time(), true);
		wp_enqueue_script('mfn-vbscripts', get_theme_file_uri('/visual-builder/assets/js/scripts.js'), false, time(), true);

		$localize_visual = array(
			'mfnsc' => get_theme_file_uri( '/functions/tinymce/plugin.js' ),
		);
		$google_fonts = mfn_fonts('all');

		wp_enqueue_script( 'mfn-opts-field-visual-vb', get_theme_file_uri('/muffin-options/fields/visual/field_visual_vb.js'), array( 'jquery' ), MFN_THEME_VERSION, true );
		wp_localize_script( 'mfn-opts-field-visual-vb', 'fieldVisualJS_vb', $localize_visual);

		wp_add_inline_script( 'mfn-vbscripts', 'var ajaxurl = "'. admin_url( 'admin-ajax.php' ) . '";' );

		$permalink = get_preview_post_link($this->post_id).'&visual=iframe';

		if( get_post_status($this->post_id) == 'publish' ){
			$permalink = get_permalink( $this->post_id );
			if( strpos($permalink, '?') !== false){
				$permalink .= '&visual=iframe';
			}else{
				$permalink .= '?visual=iframe';
			}
			if( ! is_admin() ){
				$permalink .= '&demo';
			}
		}

		// override if template shop archive
		if( function_exists('is_woocommerce') ){

			if( $this->post_type == 'template' && $this->template_type == 'shop-archive' && wc_get_page_id( 'shop' ) ){
				$permalink = get_permalink( wc_get_page_id( 'shop' ) ).'?mfn-template-id='.$this->post_id.'&visual=iframe';
			}else if( $this->post_type == 'template' && $this->template_type == 'single-product' ){

				$sample = Mfn_Builder_Woo_Helper::sample_item('product');
				$product = wc_get_product($sample);
				$permalink = get_permalink( $product->get_id() ).'?mfn-template-id='.$this->post_id.'&visual=iframe';

	 			$gallery_overlay = mfn_opts_get('shop-product-gallery-overlay');
	 			$thumbnails_margin = mfn_opts_get( 'shop-product-thumbnails-margin', 0, ['unit'=>'px'] );
				$main_margin = mfn_opts_get( 'shop-product-main-image-margin', 'mfn-mim-0' );

	 			wp_localize_script( 'mfn-vbscripts', 'mfnwoovars',
			      	array(
			      		'productthumbsover' => $gallery_overlay,
				        'productthumbs' => $thumbnails_margin,
				        'mainimgmargin' => $main_margin
			      	)
	    		);
	 		}
		}

		if( $this->post_type == 'template' && $this->template_type == 'megamenu' ) {
			$permalink .= '&mfn-h=classic';
		}

		wp_localize_script( 'mfn-vbscripts', 'mfnvbvars',
	      array(
	        'ajaxurl' => admin_url( 'admin-ajax.php' ),
	        'pageid' => $this->post_id,
	        'wpnonce' => wp_create_nonce( 'mfn-builder-nonce' ),
	        'rev_slider_id' => get_post_meta($this->post_id, 'mfn-post-slider', true),
	        'adminurl' => admin_url(),
	        'themepath' => get_template_directory_uri('/'),
	        'autosave' => mfn_opts_get('builder-autosave'),
	        'rooturl' => get_site_url(),
	        'view' => is_admin() ? 'admin' : 'demo',
	        'permalink' => $permalink,
	        'post_type' => get_post_type($this->post_id),
	        'pagedata' => $this->loadElementsArr($this->post_id),
	        'elements' => $this->loadElementsObjects($this->post_id),
	        'mfn_google_fonts' => $google_fonts,
	        'presets' => $this->getPresets(true),
	        'builder_type' => $this->template_type ? $this->template_type : 'standard',
	        'shape_dividers' => Mfn_Builder_Helper::get_shape_divider(false, false, 'mfn-uid-'),
	        'be_slug' => apply_filters('betheme_slug', 'be'),
	      )
	    );

	  	$cm_args = wp_enqueue_code_editor(array(
			'autoRefresh' => true,
			'lint' => true,
			'indentUnit' => 2,
			'tabSize' => 2,
			'lineNumbers' => false
		));

	    $codemirror['css']['codeEditor'] = wp_enqueue_code_editor(array(
			'type' => 'text/css', // required for lint
			'codemirror' => $cm_args,
		));

		$codemirror['html']['codeEditor'] = wp_enqueue_code_editor(array(
			'type' => 'text/html', // required for lint
			'codemirror' => $cm_args,
		));

		$codemirror['javascript']['codeEditor'] = wp_enqueue_code_editor(array(
			'type' => 'javascript', // required for lint
			'codemirror' => $cm_args,
		));

		wp_localize_script('mfn-vbscripts', 'mfn_cm', $cm_args);
		wp_enqueue_style('mfn-codemirror-dark', get_theme_file_uri('/visual-builder/assets/css/codemirror-dark.css'), false, MFN_THEME_VERSION, 'all');

		$lightboxOptions = mfn_opts_get('prettyphoto-options');
		$is_translation_on = mfn_opts_get('translate');

		$config = array(
			'mobileInit' => mfn_opts_get('mobile-menu-initial', 1240),
			'themecolor' => mfn_opts_get('color-theme'),
			'parallax' => mfn_parallax_plugin(),
			'responsive' => intval(mfn_opts_get('responsive', 0)),
			'sidebarSticky' => mfn_opts_get('sidebar-sticky') ? true : false,
			'lightbox' => array(
				'disable' => isset($lightboxOptions['disable']) ? true : false,
				'disableMobile' => isset($lightboxOptions['disable-mobile']) ? true : false,
				'title' => isset($lightboxOptions['title']) ? true : false,
			),
			'slider' => array(
				'blog' => intval(mfn_opts_get('slider-blog-timeout', 0)),
				'clients' => intval(mfn_opts_get('slider-clients-timeout', 0)),
				'offer' => intval(mfn_opts_get('slider-offer-timeout', 0)),
				'portfolio' => intval(mfn_opts_get('slider-portfolio-timeout', 0)),
				'shop' => intval(mfn_opts_get('slider-shop-timeout', 0)),
				'slider' => intval(mfn_opts_get('slider-slider-timeout', 0)),
				'testimonials' => intval(mfn_opts_get('slider-testimonials-timeout', 0)),
			),
			'livesearch' => array(
				'minChar' => intval(mfn_opts_get('header-search-live-min-characters', 3)),
				'loadPosts' => intval(mfn_opts_get('header-search-live-load-posts', 10)),
				'translation' => array(
					'pages' => 		$is_translation_on ? mfn_opts_get('translate-livesearch-pages', 'Pages') : __('Pages','betheme'),
					'categories' => $is_translation_on ? mfn_opts_get('translate-livesearch-categories', 'Categories') : __('Categories','betheme'),
					'portfolio' =>  $is_translation_on ? mfn_opts_get('translate-livesearch-portfolio', 'Portfolio') : __('Portfolio','betheme'),
					'post' => $is_translation_on ? mfn_opts_get('translate-livesearch-posts', 'Posts') : __('Posts','betheme'),
					'products' => $is_translation_on ? mfn_opts_get('translate-livesearch-products', 'Products') : __('Products','betheme'),
				),
			),
			'site_url' => get_site_url(),
			'accessibility' => array(
				'translation' => array(
					'headerContainer' => __('Header container', 'betheme'),
					'toggleSubmenu' => __('Toggle submenu', 'betheme'),
				)
			),
		);

		wp_localize_script( 'mfn-vbscripts', 'mfn', $config );

	}

	public function fieldsToJS(){
		// forms html
		$output = 'var renderMfnFields = {';
			$output .= $this->getSectionForm();
			$output .= $this->getWrapForm();
			$output .= $this->getItemsForm();
			$output .= $this->getItemsAdvancedForm();
			$output .= $this->getThomeOptionsForm();
		$output .= '}';
		return $output;
	}

	public function getDbLists(){

		if($this->post_type == 'post'){
		  $po_class = new Mfn_Post_Type_Post();
		}elseif($this->post_type == 'portfolio'){
		  $po_class = new Mfn_Post_Type_Portfolio();
		}elseif($this->post_type == 'template'){
		  $po_class = new Mfn_Post_Type_Template();
		  $this->template_type = get_post_meta($this->post_id, 'mfn_template_type', true);
		}else{
		  $po_class = new Mfn_Post_Type_Page();
		}

		$sidebars = mfn_opts_get('sidebars') ? mfn_opts_get('sidebars') : array();

		$output = 'var mfnDbLists = {'."\n";;
			$output .= 'blog_tags:'.json_encode( mfn_hierarchical_taxonomy('post_tag') ).",\n";
			$output .= 'blog_categories:'.json_encode( mfn_hierarchical_taxonomy('category') ).",\n";
			$output .= 'offer_types:'.json_encode( mfn_hierarchical_taxonomy('offer-types') ).",\n";
			$output .= 'portfolio_types:'.json_encode( mfn_hierarchical_taxonomy('portfolio-types') ).",\n";
			if( function_exists('is_woocommerce') ){
				$output .= 'product_cat:'.json_encode( mfn_hierarchical_taxonomy('product_cat') ).",\n";
			}else{
				$output .= 'product_cat:'.json_encode( array() ).",\n";
			}
			$output .= 'slide_types:'.json_encode( mfn_hierarchical_taxonomy('slide-types') ).",\n";
			$output .= 'testimonial_types:'.json_encode( mfn_hierarchical_taxonomy('testimonial-types') ).",\n";
			$output .= 'client_types:'.json_encode( mfn_hierarchical_taxonomy('client-types') ).",\n";
			$output .= 'rev_slider:'.json_encode( Mfn_Builder_Helper::get_sliders('rev') ).",\n";
			$output .= 'layer_slider:'.json_encode( Mfn_Builder_Helper::get_sliders('layer') ).",\n";
			$output .= 'sidebars:'.json_encode( is_array($sidebars) && !is_null($sidebars) ? array_merge(array('' => __('Default', 'mfn-opts')), $sidebars) : null ).",\n";
			$output .= 'layouts:'.json_encode( $po_class->get_layouts() ).",\n";
			$output .= 'menus:'.json_encode( mfna_menu() ).",\n";
			$output .= 'headers:'.json_encode( mfna_templates('header') ).",\n";
			$output .= 'popups:'.json_encode( mfna_templates('popup') ).",\n";
			$output .= 'footers:'.json_encode( mfna_templates('footer') ).",\n";
			$output .= 'singleproducts:'.json_encode( mfna_templates('single-product') ).",\n";
			$output .= 'pages:'.json_encode( mfna_pages() ).",\n";
			$output .= 'themeoptions:'.$this->getThomeOptionsObject().",\n";
			$output .= 'pageoptions:'.$this->getPageOptionsForm();
			$output .= 'global_sections:'.json_encode( mfna_templates('section') ).',';
			$output .= 'global_wraps:'.json_encode( mfna_templates('wrap') ).',';
			$output .= 'media_sizes:'.json_encode( array('full' => __('Full size', 'mfn-opts'),'large' => __('Large', 'mfn-opts') .' | '. mfn_get_image_sizes('large', 1),'medium' => __('Medium', 'mfn-opts') .' | '. mfn_get_image_sizes('medium', 1),'thumbnail' => __('Thumbnail', 'mfn-opts') .' | '. mfn_get_image_sizes('thumbnail', 1),),).',';
		$output .= '}';
		return $output;
	}

	public function getThomeOptionsObject() {
		$themeoptions = get_option('betheme');

		if( !empty($themeoptions['gdpr-content']) ){
			$themeoptions['gdpr-content'] = htmlspecialchars($themeoptions['gdpr-content']);
		}

		return json_encode( $themeoptions );
	}

	public function getPageOptionsForm(){
		$output = 'function() { return \'';
		$output .= '<div class="page-options-form-wrapper">';

		if( isset($this->page_options) && is_iterable($this->page_options) ){
			ob_start();
			foreach( $this->page_options as $f=>$field ) {
				if( is_array($field) ){
					foreach ($field as $a => $attr) {
						$this->mfn_JsformElement($attr, 'option', 'fields');
					}
				}
			}
			$output .= ob_get_contents();
			ob_end_clean();
		}
		$output .= '</div>\';},';

		return $output;
	}

	public function getThomeOptionsForm() {
		global $MFN_Options;
		$gdpr = new Mfn_Gdpr();
		$output = 'themeoptions: function() { return \'<div class="vb-themeoptions theme-options-tabs">';
		foreach( $MFN_Options->menu as $vb_o=>$vb_opt ) {

			if( $vb_o == 'translate' ) continue;

			$output .='<div class="vb-to vb-to-'.$vb_o.'">';
				$output .='<div class="vb-to-header"><ul class="vb-to-ul"><li><a class="vb-themeoptions-link-expander" href="#themeoptions-'.htmlspecialchars($vb_o, ENT_QUOTES ).'"><span class="mfn-icon"></span>'.htmlspecialchars($vb_opt['title'], ENT_QUOTES ).'</a><ul class="vb-to-ul vb-to-subul">';
				foreach( $vb_opt['sections'] as $vb_submenu ) {
					$output .='<li class="vb-to-subli vb-to-subli-'.htmlspecialchars($vb_submenu, ENT_QUOTES ).'"><a class="vb-themeoptions-form-link" href="#themeoptions-'.htmlspecialchars($vb_submenu, ENT_QUOTES ).'"><span class="mfn-icon"></span>'.htmlspecialchars($MFN_Options->sections[$vb_submenu]['title'], ENT_QUOTES ).'</a></li>';
				}
				$output .='</ul></li></ul></div>';

				foreach ($vb_opt['sections'] as $vb_sec) {
					$output .='<div class="vb-to-content" id="themeoptions-'.htmlspecialchars($vb_sec, ENT_QUOTES ).'">';

					foreach ($MFN_Options->sections[$vb_sec]['fields'] as $vb_sec_field) {
						ob_start();
						$this->mfn_JsformElement($vb_sec_field, 'themeoption');
						$output .= ob_get_contents();
						ob_end_clean();
					}

					$output .='</div>';
				}

			$output .='</div>';
		}
		$output .= '</div>\';},';

		// GDPR cookies
		if( !mfn_opts_get('gdpr') ){
			$output .= 'gdpr: function() { return \'';
			// $output .= $gdpr->render(true);
			$output .= '\';}';
		}
		return $output;
	}

	public function getSectionForm(){
		$mfn_fields = new Mfn_Builder_Fields();
		$output = 'section: function() { return \'';
		$output .= '<div class="mfn-element-fields-wrapper" data-element="mcb-section-\'+edited_item.uid+\'"><ul class="mfn-vb-formrow sidebar-panel-content-tabs"><li data-tab="content" class="spct-li-content active">Settings</li><li data-tab="style" class="spct-li-style">Style</li><li data-tab="advanced" class="spct-li-advanced">Advanced</li></ul>';
		$items = $mfn_fields->get_section();

		ob_start();
		foreach( $items as $f=>$field ) $this->mfn_JsformElement($field, 'section', 'attr');
		$output .= ob_get_contents();
		ob_end_clean();
		$output .= '</div>\';},'."\r\n";

		return $output;
	}

	public function getWrapForm(){
		$mfn_fields = new Mfn_Builder_Fields();
		$output = 'wrap: function() { return \'';
		$output .= '<div class="mfn-element-fields-wrapper" data-element="mcb-wrap-\'+edited_item.uid+\'"><ul class="mfn-vb-formrow sidebar-panel-content-tabs"><li data-tab="content" class="spct-li-content active">Settings</li><li data-tab="style" class="spct-li-style">Style</li><li data-tab="advanced" class="spct-li-advanced">Advanced</li></ul>';
		$items = $mfn_fields->get_wrap();

		ob_start();
		foreach($items as $i=>$j) $this->mfn_JsformElement($j, 'wrap', 'attr');
		$output .= ob_get_contents();
		ob_end_clean();
		$output .= '</div>\';},'."\r\n";

		return $output;
	}

	public function getItemsAdvancedForm(){
		$mfn_fields = new Mfn_Builder_Fields( true );
		$output = 'advanced: function() { return \'';
		$items = $mfn_fields->get_advanced(true);

		ob_start();
		foreach( $items as $f=>$field ) $this->mfn_JsformElement($field, '\'+edited_item.jsclass+\'', 'fields');
		$output .= ob_get_contents();
		ob_end_clean();
		$output .= '\';},'."\r\n";

		return $output;
	}

	public function getItemsForm(){
		$mfn_fields = new Mfn_Builder_Fields(true);
		$output = '';
		$items = $mfn_fields->get_items();

		foreach($items as $w=>$widget){
			$output .= $widget['type'].': function() { return \'';
			$output .= '<div class="mfn-element-fields-wrapper" data-element="mcb-item-\'+edited_item.uid+\'" data-group="mfn-vb-\'+edited_item.uid+\'" data-item="\'+edited_item.jsclass+\'"><ul class="mfn-vb-formrow sidebar-panel-content-tabs"><li data-tab="content" class="spct-li-content active">Content</li><li data-tab="style" class="spct-li-style">Style</li><li data-tab="advanced" class="spct-li-advanced">Advanced</li></ul>';

			ob_start();
			foreach ($widget as $f => $field) {
				if( is_array($field) ){
					foreach ($field as $a => $attr) {
						$this->mfn_JsformElement($attr, $widget['type'], 'fields');
					}
				}
			}
			$output .= ob_get_contents();
			ob_end_clean();

			$output .= '</div>\';},'."\r\n";
		}

		return $output;
	}

	public function loadElementsObjects($p){
		$return = array();

		$mfn_fields = new Mfn_Builder_Fields();
		$elements = $mfn_fields->get_items();
		$section = $mfn_fields->get_section();
		$wrap = $mfn_fields->get_wrap();

		// section

		$return['section']['icon'] = "section";
		$return['section']['jsclass'] = "section";
		$return['section']['title'] = "Section";
		$return['section']['uid'] = "";
		foreach ($section as $s => $sec) {
			if( !empty($sec['std']) ){
				$return['section']['attr'][$sec['id']] = $sec['std'];
			}
		}

		if($this->post_type == 'template' && $this->template_type == 'header'){
			$return['section']['attr']['style:.mcb-section-mfnuidelement .section_wrapper:align-items'] = 'center';
			$return['section']['attr']['style:.mcb-section-mfnuidelement .section_wrapper:align-items_tablet'] = 'center';
			$return['section']['attr']['style:.mcb-section-mfnuidelement .section_wrapper:align-items_mobile'] = 'center';
		}

		if($this->post_type == 'template' && $this->template_type == 'megamenu'){
			$return['section']['attr']['style:.mcb-section-mfnuidelement:background-color'] = '#ffffff';
			$return['section']['attr']['style:.mcb-section-mfnuidelement .section_wrapper:align-items'] = 'flex-start';
		}

		// wrap

		$return['wrap']['icon'] = "wrap";
		$return['wrap']['size'] = "1/1";
		$return['wrap']['tablet_size'] = "1/1";
		$return['wrap']['mobile_size'] = "1/1";
		$return['wrap']['jsclass'] = "wrap";
		if($this->post_type == 'template' && $this->template_type == 'header'){
			$return['wrap']['title'] = "Container";
		}else{
			$return['wrap']['title'] = "Wrap";
		}
		$return['wrap']['uid'] = "";
		$return['wrap']['attr']['sticky'] = '0';
		$return['wrap']['attr']['tablet_sticky'] = '0';
		$return['wrap']['attr']['mobile_sticky'] = '0';
		foreach ($wrap as $w => $wra) {
			if( !empty($wra['std']) ){
				$return['wrap']['attr'][$wra['id']] = $wra['std'];
			}
		}

		if($this->post_type == 'template' && $this->template_type == 'header'){
			$return['wrap']['attr']['style:.mcb-section .mcb-wrap-mfnuidelement:flex-grow'] = '1';
			$return['wrap']['attr']['style:.mcb-section .mcb-wrap-mfnuidelement:flex-grow_tablet'] = '1';
			$return['wrap']['attr']['style:.mcb-section .mcb-wrap-mfnuidelement:flex-grow_mobile'] = '1';

			$return['wrap']['attr']['style:.mcb-section .mcb-wrap-mfnuidelement .mcb-wrap-inner:align-items'] = 'center';
			$return['wrap']['attr']['style:.mcb-section .mcb-wrap-mfnuidelement .mcb-wrap-inner:align-items_tablet'] = 'center';
			$return['wrap']['attr']['style:.mcb-section .mcb-wrap-mfnuidelement .mcb-wrap-inner:align-items_mobile'] = 'center';
		}

		// elements

		foreach( $elements as $e=>$element ){

			// in header only headers elements
			if( $this->template_type && $this->template_type == 'header' && $element['cat'] != 'header' && !in_array($e, array('column', 'button', 'heading', 'payment_methods', 'image', 'plain_text')) ) continue;

			// exclude non template elements
			if( !$this->template_type && in_array($element['cat'], array('shop-archive', 'single-product', 'header', 'megamenu', 'footer', 'popup')) ) continue;

			$classes = '';
			$params = array();
			$params_content = '';
			$return[$e]['type'] = $element['type'];
			$return[$e]['jsclass'] = $element['type'];
			$return[$e]['title'] = $element['title'];
			$return[$e]['icon'] = str_replace('_', '-', $element['type']);

			//if( $element['type'] == 'map' || $element['type'] == 'lottie' ){
				$params['vb'] = true;
			//}

			if( isset($element['fields']) ){
				foreach ($element['fields'] as $field) {

					if( !empty($field['std']) ){
						$return[$e]['fields'][$field['id']] = $field['std'];
						if($field['id'] == 'content' || $field['id'] == 'plain_text'){
							$params_content = $field['std'];
						}else{
							$params[$field['id']] = $field['std'];
						}
					}else if( !empty($field['vbstd']) ){
						$return[$e]['fields'][$field['id']] = $field['vbstd'];
						if($field['id'] == 'content'){
							$params_content = $field['vbstd'];
						}else{
							$params[$field['id']] = $field['vbstd'];
						}
					}

				}

				if($this->post_type == 'template' && $this->template_type == 'header' && $element['type'] != 'header_logo' ){
					$return[$e]['fields']['width_switcher'] = 'inline';
					$classes = 'mfn-item-inline';
				}

				if($this->post_type == 'template' && $this->template_type == 'header' && $element['type'] == 'column' ){
					$return[$e]['fields']['content'] = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>';
				}

				if( $element['type'] == 'header_logo' || ($this->post_type == 'template' && $this->template_type == 'header' && $element['type'] == 'image') ){
					$return[$e]['fields']['width_switcher'] = 'custom';
					$return[$e]['fields']['style:.mcb-section .mcb-wrap .mcb-item-mfnuidelement:flex'] = '250px';
				}

				if( $element['type'] == 'header_search' ){
					$return[$e]['fields']['width_switcher'] = 'custom';
					$return[$e]['fields']['style:.mcb-section .mcb-wrap .mcb-item-mfnuidelement:flex'] = '300px';
				}

				if( $element['type'] == 'header_icon' ){
					$return[$e]['fields']['style:.mcb-section .mcb-wrap .mcb-item-mfnuidelement .mfn-icon-box .icon-wrapper .header-cart-count,.mcb-section .mcb-wrap .mcb-item-mfnuidelement .mfn-icon-box .icon-wrapper .header-wishlist-count:top'] = '-9px';
					$return[$e]['fields']['style:.mcb-section .mcb-wrap .mcb-item-mfnuidelement .mfn-icon-box .icon-wrapper .header-cart-count,.mcb-section .mcb-wrap .mcb-item-mfnuidelement .mfn-icon-box .icon-wrapper .header-wishlist-count:right'] = '-11px';
				}

			}

			$params['pageid'] = $p;

			$return[$e]['html'] = '<div data-uid="uidhere" data-desktop-size="1/1" data-tablet-size="1/1" data-mobile-size="1/1" class="blink column mcb-column mfn-new-item vb-item vb-item-widget mcb-item-uidhere column_'.$element['type'].' one tablet-one mobile-one '.$classes.'">';

			// Transforms UI --- visible only when transformed an item
			$return[$e]['html'] .= '<div class="mfn-header-transform">';
				$return[$e]['html'] .= Mfn_Builder_Helper::itemTools('1/1');
			$return[$e]['html'] .= '</div>';

			$return[$e]['html'] .= '<div class="mcb-column-inner mcb-column-inner-uidhere mcb-item-'.$element['type'].'-inner">';

			$return[$e]['html'] .= Mfn_Builder_Helper::itemTools('1/1');
			$fun_name = 'sc_'.$element['type'];

			if($element['type'] == 'placeholder'){
				$return[$e]['html'] .= '<div class="placeholder"></div>';
			}elseif($element['type'] == 'shop_products'){
				$return[$e]['html'] .= $fun_name($params, 'sample');
			}elseif($element['type'] == 'content'){
				$return[$e]['html'] .= '<div class="content-wp">'.get_post_field( 'post_content', $p ).'</div>';
			}elseif($element['type'] == 'divider'){
				$return[$e]['html'] .= '<hr />';
			}elseif($element['type'] == 'slider_plugin'){
				$return[$e]['html'] .= '<div class="mfn-widget-placeholder mfn-wp-revolution"><img class="item-preview-image" src="'.get_theme_file_uri('/muffin-options/svg/placeholders/slider_plugin.svg').'"></div>';
			}elseif($element['type'] == 'visual'){
				$return[$e]['html'] .= '<div class="mfn-visualeditor-content mfn-inline-editor clearfix">'.$params_content.'</div>';
			}elseif($element['type'] == 'table_of_contents'){
				$return[$e]['html'] .= $fun_name($params);
			}elseif($element['type'] == 'sidebar_widget'){
				$return[$e]['html'] .= '<img src="'.get_theme_file_uri( '/muffin-options/svg/placeholders/sidebar_widget.svg' ).'" alt="">';
			}elseif($element['type'] == 'column'){
				$return[$e]['html'] .= '<div class="column_attr mfn-inline-editor clearfix">'.$params_content.'</div>';
			}elseif($element['type'] == 'plain_text'){
				$return[$e]['html'] .= '<div class="desc">'.$params_content.'</div>';
			}elseif($element['type'] == 'image_gallery'){
				$params['id'] = null;
				$return[$e]['html'] .= sc_gallery($params);
			}elseif($element['type'] == 'shop' && class_exists( 'WC_Shortcode_Products' )){
				$params['post'] = 0;
				$shortcode = new WC_Shortcode_Products( $params, 'products' );
				$return[$e]['html'] .= $shortcode->get_content();
			}elseif(!empty($params_content)){
				$return[$e]['html'] .= $fun_name($params, $params_content);
			}elseif(function_exists( 'sc_'.$element['type'] )){
				$output = $fun_name($params);
				if(is_array($output)){
					$return[$e]['html'] .= $output[0];
					$return[$e]['script'] = $output[1];
				}else{
					$return[$e]['html'] .= $output;
				}
			}
			$return[$e]['html'] .= '</div></div>';
		}

		return $return;

	}

	public function loadElementsArr($mfn_page_items){
		$return = array();
		$p_id = false;
		$detect_old_builder = false;

		// load page objects

		if( is_numeric($mfn_page_items) ){
			$p_id = $mfn_page_items;
			$mfn_page_items = get_post_meta($p_id, 'mfn-page-items', true);
		}

		if($mfn_page_items && ! is_array($mfn_page_items)) {
			$mfn_items = unserialize(call_user_func('base'.'64_decode', $mfn_page_items));
		}else{
			$mfn_items = $mfn_page_items;
		}

		if( $mfn_items && count($mfn_items) > 0 ){
			foreach ($mfn_items as $s=>$section) {

				if( empty($section['uid']) ) {
					$sec_uid = Mfn_Builder_Helper::unique_ID();
					$section['uid'] = $sec_uid;
					$mfn_items[$s]['uid'] = $sec_uid;
					$detect_old_builder = true;
				}


				// Builder without wraps | Old version
				if( ! isset( $section['wraps'] ) && ! empty( $section['items'] ) ){

					$fix_wrap = array(
						'size' => '1/1',
						'uid' => Mfn_Builder_Helper::unique_ID(),
						'items'	=> $section['items'],
						'jsclass' => 'wrap',
						'title' => 'Wrap',
						'icon' => 'wrap',
					);

					$section['wraps'] = array( $fix_wrap );

					$mfn_items[$s]['wraps'] = array( $fix_wrap );
					unset( $mfn_items[$s]['items'] );

					$detect_old_builder = true;

				}

				if( isset($section['wraps']) && is_iterable( $section['wraps'] ) ){
					foreach ( $section['wraps'] as $w=>$wrap ) {

						if( is_array($wrap) && empty($wrap['uid']) ) {
							$wra_uid = Mfn_Builder_Helper::unique_ID();
							$wrap['uid'] = $wra_uid;
							$mfn_items[$s]['wraps'][$w]['uid'] = $wra_uid;
							$detect_old_builder = true;
						}

						if( isset($wrap['items']) && is_iterable( $wrap['items'] ) ){
							foreach ( $wrap['items'] as $i=>$item ) {

								if( is_array($item) && empty($item['uid']) ) {

									$ite_uid = Mfn_Builder_Helper::unique_ID();
									$mfn_items[$s]['wraps'][$w]['items'][$i]['uid'] = $ite_uid;
									$item['uid'] = $ite_uid;
									$detect_old_builder = true;

								}

								if( isset($item['tabs']) && is_iterable( $item['tabs'] ) ){
									$item['tabs'] = $item['tabs'];
								}

								if( is_array($item) ){
									$item['jsclass'] = $item['type'];
									$item['title'] = isset( $item['title'] ) ? $item['title'] : ucfirst(str_replace('_', ' ', $item['type']));
									$item['icon'] = str_replace('_', '-', $item['type']);
								}
								$return[] = $item;
							}
						}

						// Global Section/Wraps -> On first render it's empty string, we have to exclude it
						if( !is_string($wrap) ){
							unset( $wrap['items'] );
						}

						if( is_array($wrap) ){
							$wrap['jsclass'] = 'wrap';
							$wrap['title'] = 'Wrap';
							$wrap['icon'] = 'wrap';
							if( empty($wrap['attr']['sticky']) ){
								$wrap['attr']['sticky'] = '0';
								$wrap['attr']['sticky_tablet'] = '0';
								$wrap['attr']['sticky_mobile'] = '0';
							}
						}
						$return[] = $wrap;
					}
					unset( $section['wraps'] );
				}

				$section['jsclass'] = 'section';
				$section['title'] = 'Section';
				$section['icon'] = 'section';
				$return[] = $section;
			}
		}


		// add uids for iframe

		if( $detect_old_builder ){

			if ( 'encode' == mfn_opts_get('builder-storage') ) {
				$new = call_user_func('base'.'64_encode', serialize($mfn_items));
			}else{
				$new = $mfn_items;
			}

			update_post_meta($p_id, 'mfn-page-items', $new);

		}

		// options
		if( $p_id && is_iterable($this->page_options)){
			$options = array();
			foreach( $this->page_options as $o=>$opt ) {
				$options['uid'] = 'pageoptions';
				if( is_array($opt) ){
					foreach ($opt as $t => $tval) {
						if( isset($tval['id']) ){
							$opt_value = get_post_meta( $p_id, $tval['id'], true );
							if( $opt_value ){
								$options['fields'][$tval['id']] = $opt_value;
							}elseif( isset($tval['std']) ){
								$options['fields'][$tval['id']] = $tval['std'];
							}else{
								$options['fields'][$tval['id']] = '';
							}
						}
					}
				}
			}
			$return[] = $options;
		}

		return $return;
	}

	public function sizes($size){
		$classes = array(
  			'divider' => 'divider',
  			'1/6' => 'one-sixth',
  			'1/5' => 'one-fifth',
  			'1/4' => 'one-fourth',
  			'1/3' => 'one-third',
  			'2/5' => 'two-fifth',
  			'1/2' => 'one-second',
  			'3/5' => 'three-fifth',
  			'2/3' => 'two-third',
  			'3/4' => 'three-fourth',
  			'4/5' => 'four-fifth',
  			'5/6' => 'five-sixth',
  			'1/1' => 'one'
  		);

  		return $classes[$size];
	}

	public function mfn_load_sidebar(){

		global $wpdb;

		if( !empty( get_post_meta($this->post_id, '_elementor_edit_mode', true) ) ){
			delete_post_meta($this->post_id, '_elementor_edit_mode');
		}

		$this->mfn_required_scripts();
		$this->mfn_required_styles();

		$mfn_helper = new Mfn_Builder_Helper();
		$this->options = $mfn_helper->get_options();

		$builder_class = array();
		$builder_class[] = 'mfn-vb-'.$this->post_type;

		if($this->post_type == 'template' && !empty($this->template_type)){
			$builder_class[] = 'mfn-vb-tmpl-'.$this->template_type;

			if($this->template_type == 'header') {
				add_filter( 'admin_body_class', array( $this, 'mfn_add_admin_beheader_class') );
			}else if($this->template_type == 'megamenu') {
				add_filter( 'admin_body_class', array( $this, 'mfn_add_admin_bemegamenu_class') );
			}else if($this->template_type == 'footer') {
				add_filter( 'admin_body_class', array( $this, 'mfn_add_admin_befooter_class') );
			}else if($this->template_type == 'popup') {
				add_filter( 'admin_body_class', array( $this, 'mfn_add_admin_bepopup_class') );
			}else if( $this->template_type === 'section' ){
				add_filter( 'admin_body_class', array( $this, 'mfn_add_admin_beglobalsections_class') );
			}else if( $this->template_type === 'wrap' ){
				add_filter( 'admin_body_class', array( $this, 'mfn_add_admin_beglobalwraps_class') );
			}
		}

		if( is_admin() ){
			require_once(get_theme_file_path('/visual-builder/visual-builder-header.php'));
		}else{
			require_once(get_theme_file_path('/visual-builder/bebuilder-demo-header.php'));
		}

		$widgetsClass =  new Mfn_Builder_Fields();

		$widgets = $widgetsClass->get_items();

		$inline_shortcodes = $widgetsClass->get_inline_shortcode();

		if( is_array( $this->options ) ){
			foreach( $this->options as $option_id => $option_val ){
				if( $option_val == "1" ){
					$builder_class[] = $option_id;
				}elseif( $option_val != "0" ){
					$builder_class[] = $option_val;
				}
			}
		}

		$detectUiTheme = false;

		if( in_array( 'mfn-ui-auto', $builder_class) || ( !in_array( 'mfn-ui-auto', $builder_class) && !in_array( 'mfn-ui-dark', $builder_class) && !in_array( 'mfn-ui-light', $builder_class) ) ) {
			$builder_class[] = 'mfn-ui-auto';
			$detectUiTheme = true;
		}

		$builder_class[] = 'mfn-bebuilder-'.( is_admin() ? 'admin' : 'demo' );

		if( function_exists('is_woocommerce') ){
			$builder_class[] = 'woocommerce-active';
		}

		$builder_class = implode( ' ', $builder_class );

		echo '<div class="frameOverlay"></div><div id="mfn-visualbuilder" class="mfn-ui mfn-visualbuilder '.esc_attr( $builder_class ).'" data-tutorial="'. apply_filters('betheme_disable_support', '0') .'">';

		$oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		if( $detectUiTheme ) echo "<script>var mfnuicont = document.getElementById('mfn-visualbuilder'); if( mfnuicont.classList.contains('mfn-ui-auto') && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ){mfnuicont.classList.add('mfn-ui-dark');}</script>";

		require_once(get_theme_file_path('/visual-builder/partials/preloader.php'));

		echo '<div class="mfn-contextmenu mfn-items-list-contextmenu"><ul><li><a href="#" data-action="love-it"><span class="mfn-icon mfn-icon-star"></span><span class="label">Add to favourites</span></a></li></ul></div>';

		require_once(get_theme_file_path('/visual-builder/partials/navigator.php'));

		echo '<div style="position: fixed; z-index: 9999;" class="mfn-contextmenu mfn-builder-area-contextmenu"><h6 class="mfn-context-header">Section</h6><ul><li><a href="#" data-action="edit"><span class="mfn-icon mfn-icon-edit"></span><span class="label">Edit</span></a></li><li><a href="#" class="mfn-context-copy" data-action="copy"><span class="mfn-icon mfn-icon-copy"></span><span class="label">Copy</span></a></li><li><a href="#" class="mfn-context-paste" data-action="paste"><span class="mfn-icon mfn-icon-paste"></span><span class="label">Paste</span></a></li><li class="mfn-contextmenu-delete"><a href="#" data-action="delete"><span class="mfn-icon mfn-icon-delete-red"></span><span class="label">Delete</span></a></li></ul></div>';

		if( is_admin() ) {

			$edit_lock = wp_check_post_lock($this->post_id);


			if( $edit_lock && $edit_lock != get_current_user_id() ){
				require_once(get_theme_file_path('/visual-builder/partials/locker.php'));
			}else{
				wp_set_post_lock($this->post_id);
			}

		}

		// start sidebar
	    echo '<div class="sidebar-wrapper" id="mfn-vb-sidebar">';

	    echo '<div id="mfn-sidebar-resizer"></div>';
	    echo '<div id="mfn-sidebar-switcher"></div>';

	  // sidebar left
	  require_once(get_theme_file_path('/visual-builder/partials/sidebar-menu.php'));

	  // end sidebar left

	  // start sidebar panel
	    echo '<div class="sidebar-panel">';

	    // start sidebar header

	  require_once(get_theme_file_path('/visual-builder/partials/sidebar-header.php'));

	  // end sidebar header

	  // items panel
	    echo '<div class="sidebar-panel-content">';

	    // start items panel
	    require_once(get_theme_file_path('/visual-builder/partials/sidebar-widgets.php'));

	    // end items panel

	   	// start pre build
	   	require_once(get_theme_file_path('/visual-builder/partials/sidebar-prebuilds.php'));
	   	// end pre build

		// start globals panel
		require_once(get_theme_file_path('/visual-builder/partials/sidebar-globals.php'));
		// end global panel

	   	if( is_admin() ){
		    // start revision
		    require_once(get_theme_file_path('/visual-builder/partials/sidebar-revisions.php'));
		    // end revisions
		}

	    if( is_admin() ){
		    // start export/import
		    require_once(get_theme_file_path('/visual-builder/partials/sidebar-export-import.php'));
		    // end export/import
		}

	    // start settings
	   	require_once(get_theme_file_path('/visual-builder/partials/sidebar-settings.php'));
	   	// end settings

	   	// start options
	   	require_once(get_theme_file_path('/visual-builder/partials/sidebar-options.php'));
	   	// end options

	   	// start themeoptions
	   	require_once(get_theme_file_path('/visual-builder/partials/sidebar-themeoptions.php'));
	   	// end themeoptions

	   // start edit form

	   echo '<div class="panel panel-edit-item" style="display: none;"><div class="mfn-form"></div></div>';
       // end edit form

        echo '</div>';
        // start footer
        require_once(get_theme_file_path('/visual-builder/partials/sidebar-footer.php'));

        // end panel
        echo '</div>';
        // end sidebar
        echo '</div>';

        // iframe

        echo '<div id="mfn-preview-wrapper-holder" class="preview-wrapper">';
        // preview toolbar
        require_once(get_theme_file_path('/visual-builder/partials/preview-toolbar.php'));
        //echo '<pre style="line-height: 1.6em; display:none;">';print_r($mfn_items);echo '</pre>';
        echo '<div id="mfn-preview-wrapper"></div>';

		echo '</div>';

		// introduction
    require_once(get_theme_file_path('/visual-builder/partials/introduction.php'));

    // shortcuts
    require_once(get_theme_file_path('/visual-builder/partials/shortcuts.php'));

		// dynamic data info
	  require_once(get_theme_file_path('/visual-builder/partials/dynamic-data.php'));

    // modal icons
		require_once(get_theme_file_path('/visual-builder/partials/modal-icons.php'));

		// modal shortcodes
		require_once(get_theme_file_path('/visual-builder/partials/modal-shortcodes.php'));

		// modal dynamic data
		require_once(get_theme_file_path('/visual-builder/partials/modal-dynamic-data.php'));

		if( $this->post_type == 'template' ) require_once(get_theme_file_path('/visual-builder/partials/modal-conditions.php'));

	    echo '</div>';

	    if( is_admin() ){
	    	require_once(get_theme_file_path('/visual-builder/visual-builder-footer.php'));
	    }else{
			require_once(get_theme_file_path('/visual-builder/bebuilder-demo-footer.php'));
		}
	}

	public function mfn_JsformElement($field, $n, $prefix = false){

		// $field - input name
		// $value - input value
		// $uid - uid
		// $meta - name attr
		// $t - type
		// $n - widget name optional

		$field_name = '';
		$fid = '';
		$classes = '';

		if( !is_array($field) && !isset($field['id']) ){
			//echo $field.'<br>';
			echo '<input class="'.$field.'input item-hidden-inputs mfn-form-control mfn-form-input" type="hidden" value="'.$n.'">';
			return;
		}

		if( isset( $field['themeoptions'] ) ){
			$themeoption = explode(':', $field['themeoptions']);
			if( isset($themeoption[0]) && isset($themeoption[1]) ){
				if( (!empty(mfn_opts_get($themeoption[0])) && mfn_opts_get($themeoption[0]) != $themeoption[1]) || (empty(mfn_opts_get($themeoption[0])) && !empty($themeoption[1])) ){
					return;
				}else{
					$classes .= !empty( mfn_opts_get('style') ) ? ' theme-'.mfn_opts_get('style').'-style' : ' theme-classic-style';
				}
			}
		}

		$dataname = false;
		$style_prefix = false;
		$csspath = false;
		$conditions = false;
		$rerenderif = false;
		$dataAttrs = false;
		$dynamicData = false;
		$id = false;

		if(isset($field['edit_tag'])){
			$classes .= ' content-txt-edit';
		}

		if(isset($field['class'])){
			$classes .= ' '.$field['class'];
		}

		if(isset($field['settings'])){
			$classes .= ' toggle_fields';
		}

		if(isset($field['style_prefix'])){
			$style_prefix = 'data-style-prefix="'.$field['style_prefix'].'"';
		}

		if(isset($field['type']) && $field['type'] == 'sliderbar' && isset($field['units'])) {
			$classes .= ' sliderbar-units';
		}

		if( isset($field['dynamic_data']) ){
			$classes .= ' is_dynamic_data';
			$dynamicData = 'data-dynamic="'.$field['dynamic_data'].'"';
		}

		if(isset($field['id'])){
			$fid = $field['id'];
			$tmppreview = explode(':', $field['id']);
			$field_name = end($tmppreview);
			$field_name = str_replace(array(']', 'typography[', 'filter[', 'transform['), '', $field_name);

			$dataname = 'data-id="'.$field['id'].'" data-name="'.( $field_name == 'gradient' ? 'background-image' : str_replace(array('_mobile', '_tablet'), '', $field_name ) ).'"';

			if( $prefix ){
				$dataname .= ' data-prefix="'.$prefix.'"';
			}

			if( strpos($field['id'], 'style:') !== false ){
				if( isset($tmppreview[1]) ){
					$csspath = 'data-csspath="'.str_replace('mfnuidelement', '\'+edited_item.uid+\'', $tmppreview[1]).'"';
					$csspath = str_replace('postid', $this->post_id, $csspath);
					$classes .= ' inline-style-input';
				}
			}

			if( strpos($field['id'], 'margin') !== false || strpos($field['id'], 'padding') !== false || strpos($field['id'], 'border-radius') !== false || strpos($field['id'], 'border-width') !== false ){
				$classes .= ' mfn-slider-input';
			}

		}

		if( strpos($fid, '|hover') !== false ){
			$classes .= ' mfn-hover-input';
		}

		if( !empty($field['data_attr']) ){
			$dataAttrs = $field['data_attr'];
			if( strpos($dataAttrs, 'data-std') === false && !empty($field['std']) && !is_array($field['std']) ) $dataAttrs .= ' data-std="'.$field['std'].'"';
		}

		$n == 'button' ? $n = 'widget-button' : null;
		$n == 'chart' ? $n = 'widget-chart' : null;
		$n == 'code' ? $n = 'widget-code' : null;
		$n == 'sliderbar' ? $n = 'widget-sliderbar' : null;
		$n ? $classes .= ' '.$n : null;

		if( !empty($field_name) ){
			$classes .= ' '.$field_name;
		}

		if(empty($meta) && isset($field['title'])){
			$classes .= ' row-header';
		}

		if(isset($field['re_render']) && $field['re_render']){
			$classes .= ' re_render';
		}

		if(isset($field['type']) && $field['type'] == 'html'){

			echo str_replace('postid', $this->post_id, $field['html']);

			if(isset($field['title'])){
				echo '<label>'.$field['title'];
				if(isset($field['label_after'])){
						echo $field['label_after'];
					}
				echo '</label>';
			}

		}elseif(isset($field['type']) && in_array($field['type'], array('info', 'helper')) ){

			echo '<div class="mfn-form-row mfn-vb-formrow ' .(isset($field['class']) ? $field['class'] : null).'">';

			$field_class = 'MFN_Options_'. $field['type'];

			require_once( get_template_directory() .'/muffin-options/fields/'. $field['type'] .'/field_'. $field['type'] .'.php' );

			if ( class_exists( $field_class ) ) {
				$field_object = new $field_class( $field, '' );
				$field_object->render();
			}

			echo '</div>';

		}else{

			if( !empty($field['condition']) ){
				$classes .= ' activeif activeif-'.$field['condition']['id'];
				$conditions = 'data-conditionid="'. $field['condition']['id'] .'" data-opt="'. $field['condition']['opt'] .'" data-val="'. (is_array($field['condition']['val']) ? implode(',', $field['condition']['val']) : $field['condition']['val'] ) .'"';
			}

			if( isset($field['attr_id']) ){
				$id = 'id="'.$field['attr_id'].'"';
				//$classes .= ' '.$field['attr_id'];
			}

			if( isset($field['re_render_if']) ){
				$ex_re = explode('|', $field['re_render_if']);
				if( !empty($ex_re[0]) && !empty($ex_re[1]) ){
					$rerenderif = 'data-retype="'.$ex_re[0].'"';
					$rerenderif .= 'data-reelement="'.$ex_re[1].'"';
				}
				$classes .= ' re_render_if';
			}

			echo '<div '.$id.' class="mfn-form-row mfn-vb-formrow'.$classes.'" '.$rerenderif.' '.$dataname.' '.$csspath.' '.$conditions.' '.(isset($field['edit_tagchild']) ? 'data-edittagchild="'.$field['edit_tagchild'].'"' : null).' '.(isset($field['edit_tag']) ? 'data-edittag="'.$field['edit_tag'].'"' : null).' '.(isset($field['edit_position']) ? 'data-tagposition="'.$field['edit_position'].'"' : null ).' '.(isset($field['edit_tag_var']) ? 'data-edittagvar="'.$field['edit_tag_var'].'"' : null ).' '.$style_prefix.' '.$dataAttrs.' '.$dynamicData.'>';

			if(!empty($field['type'])){
				$field['preview'] = $field_name.'input';

				if(isset($field['title'])){
					$label_class = 'form-label';

					if( isset($field['responsive']) || isset($field['iconinfo']) || isset($field['desc']) ){
						$label_class .= ' form-label-wrapper';
					}

					echo '<label class="'.$label_class.'">'.htmlspecialchars( $field['title'], ENT_QUOTES );
					if(isset($field['label_after'])){
						echo $field['label_after'];
					}

					if(isset($field['responsive'])) Mfn_Options_field::get_responsive_swither($field['responsive']);
					if(isset($field['iconinfo'])) Mfn_Options_field::get_icon_info($field['iconinfo']);
					if(isset($field['desc'])) Mfn_Options_field::get_icon_desc($field['desc']);

					echo '</label>';

					if ( ! empty( $field['desc'] ) ) {
						echo '<div class="desc-group">';
							echo '<span class="description">'. esc_attr($field['desc']) .'</span>';
						echo '</div>';
					}
				}

				$form_content_class = 'form-content';

				if( isset($field['dynamic_data']) && ( empty($field['editor']) && (empty($field['type']) || $field['type'] != 'visual' ) ) ) $form_content_class .= ' has-icon has-icon-right';

				if($field['type'] != 'typography_vb') echo '<div class="'.$form_content_class.'">';


	      $field_class = 'MFN_Options_'. $field['type'];

	      if( strpos($field['id'], 'typography') !== false || strpos($field['id'], ':filter') !== false ){
	      	$typo_exclude = array('[font-size]', '[font-size_tablet]', '[font-size_mobile]', '[line-height]', '[line-height_tablet]', '[line-height_mobile]', '[font-weight]', '[letter-spacing]', '[letter-spacing_tablet]', '[letter-spacing_mobile]', '[text-transform]', '[font-family]', '[font-style]', '[text-decoration]', '[blur]', '[brightness]', '[saturate]', '[contrast]', '[hue-rotate]');
	      	$jsfield = 'edited_item.'.$prefix.'["'.str_replace($typo_exclude, '', $field['id']).'"]["'.$field_name.'"]';
	      }else{
	      	if( $prefix ){
	      		$jsfield = 'edited_item.'.$prefix.'["'.$field['id'].'"]';
	      	}else{
	      		$jsfield = 'edited_item["'.$field['id'].'"]';
	      	}

	      }


	      //echo $field['type'];

				require_once( get_template_directory() .'/muffin-options/fields/'. $field['type'] .'/field_'. $field['type'] .'.php' );

				if ( class_exists( $field_class ) ) {
					$field_object = new $field_class( $field, '' );
					$field_object->render( $field['id'], true, $jsfield );
				}

				if($field['type'] != 'typography_vb') echo '</div>';

			}elseif( !empty($field['title']) ){
				$field['title'] = str_replace('_', '', $field['title']);
				echo '<h5 class="row-header-title">'. esc_attr($field['title']) .'</h5>';
			}

			echo '</div>';

		}

	}

	public function getPresets( $both = false ){

		$return = array();

		if( $both ){
			$local = array();
			$jsonfile = get_theme_file_path('/visual-builder/assets/presets.json');
			if( file_exists($jsonfile) ){
				$local = file_get_contents( $jsonfile );
				if( !empty($local) ) $return = json_decode($local);
			}
		}

		$get_opt = get_option('mfn-presets');
		if( $get_opt ) {
			if( count($return) > 0 ){
				$return = array_merge( $return, json_decode( $get_opt ) );
			}else{
				$return = json_decode( $get_opt );
			}

		}

		return $return;
	}

	public function wrapHtml($item_id, $size, $order, $sizeclass){
		$mfn_helper = new Mfn_Builder_Helper();
		$html = '<div data-title="Wrap" data-icon="mfn-icon-wrap" data-order="'.$order.'" data-uid="'.$item_id.'" data-desktop-size="'.$size.'" data-tablet-size="'.$size.'" data-mobile-size="1/1" class="blink wrap mcb-wrap mcb-wrap-new vb-item vb-item-wrap mcb-wrap-'.$item_id.' '.$sizeclass.' tablet-'.$sizeclass.' mobile-one clearfix"><div class="mcb-wrap-inner empty">'.$mfn_helper->wrapTools($size).'<div class="mfn-drag-helper placeholder-wrap"></div><div class="mfn-wrap-new"><a href="#" class="mfn-item-add mfn-btn btn-icon-left btn-small mfn-btn-blank2"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add"></span>Add element</span></a></div></div></div>';

		return $html;
	}

	public static function getNavigatorTree($mfn_items){
		if( is_numeric($mfn_items) ){
			$mfn_items = get_post_meta($mfn_items, 'mfn-page-items', true);
			if($mfn_items && !is_array($mfn_items)) {
				$mfn_items = unserialize(call_user_func('base'.'64_decode', $mfn_items));
			}
		}
		$nav = '';
		if(isset($mfn_items) && is_array($mfn_items) && is_iterable($mfn_items)){
			foreach ($mfn_items as $section) {
			if( !empty($section["uid"]) ){

				// Global Section
				$is_global = '';

				$is_global = isset($section['mfn_global_section_id']) && !empty($section['mfn_global_section_id']);
				$classess = 'nav-'.$section["uid"].'';
				$is_global ? $classess .= ' toggle-disabled' : '';

				$nav .= '<li class="navigator-section '.$classess.'"><a data-uid="'.$section['uid'].'" href="#">'.($is_global ? 'Global ': '').'Section '.( !empty($section['attr']['custom_id']) ? '<span class="navigator-section-id">#'.$section['attr']['custom_id'].'</span>' : null ).'</a> '.($is_global ? '': '<span class="navigator-arrow"><i class="icon-down-open-big"></i></span>').'';
					if(isset($section['wraps']) && is_iterable($section['wraps'])){
						$nav .= '<ul class="mfn-sub-nav">';
							foreach ($section['wraps'] as $wrap) {
								if( !empty($wrap['uid']) && !empty($wrap['size']) ){

								// Global Wraps
								$is_global = '';
								$is_global = !empty($wrap['attr']['global_wraps_select']);
								$classess = 'nav-'.$wrap["uid"].'';
								$is_global ? $classess .= ' toggle-disabled' : '';

								$nav .= '<li class="navigator-wrap '.$classess.'"><a data-uid="'.$wrap['uid'].'" href="#">'.($is_global ? 'Global ': '').'Wrap <span class="navigator-size-label">'.$wrap['size'].'</span>'.($is_global ? '':'<span class="navigator-add-item back-to-widgets"></a> <span class="navigator-arrow"><i class="icon-down-open-big"></i></span>').'';
									if(isset($wrap['items']) && is_iterable($wrap['items'])){
									$nav .= '<ul class="mfn-sub-nav">';
										foreach ($wrap['items'] as $i=>$item) {
											if( !empty($item['type']) ){
											$nav .= '<li data-name="'.$item['type'].'" class="navigator-item nav-'.$item['uid'].' navitemtype"><a data-uid="'.$item['uid'].'" href="#"><span class="mfn-icon mfn-icon-'.str_replace('_', '-', $item['type']).'"></span>'.( !empty($item['title']) ? $item['title'] : str_replace('_', ' ', ucfirst($item['type'])) ).'</a></li>';
											}
										}
									$nav .= '</ul>';
									}
								$nav .= '</li>';
							}
							}
						$nav .= '</ul>';
					}
				$nav .= '</li>';
			}
			}
		}

		return $nav;
	}

}
