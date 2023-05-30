<?php
/**
 * Theme Options - fields and args
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

require_once(get_theme_file_path('/muffin-options/fonts.php'));
require_once(get_theme_file_path('/muffin-options/icons.php'));
require_once(get_theme_file_path('/muffin-options/options.php'));

/**
 * Options Page | Helper Functions
 */

if( ! function_exists( 'mfna_header_style' ) )
{
	/**
	 * Header Style
	 * @return array
	 */

	function mfna_header_style(){
		return array(
			'classic' => __( 'Classic', 'mfn-opts' ),
			'modern' => __( 'Modern', 'mfn-opts' ),
			'plain' => __( 'Plain', 'mfn-opts' ),
			'stack,left' => __( 'Stack | Left', 'mfn-opts' ),
			'stack,center' => __( 'Stack | Center', 'mfn-opts' ),
			'stack,right' => __( 'Stack | Right', 'mfn-opts' ),
			'stack,magazine' => __( 'Magazine', 'mfn-opts' ),
			'creative' => __( 'Creative', 'mfn-opts' ),
			'creative,rtl' => __( 'Creative | Right', 'mfn-opts' ),
			'creative,open' => __( 'Creative | Open', 'mfn-opts' ),
			'creative,open,rtl' => __( 'Creative | Right + Open', 'mfn-opts' ),
			'fixed' => __( 'Fixed', 'mfn-opts' ),
			'transparent' => __( 'Transparent', 'mfn-opts' ),
			'simple' => __( 'Simple', 'mfn-opts' ),
			'simple,empty' => __( 'Empty', 'mfn-opts' ),
			'below' => __( 'Below slider', 'mfn-opts' ),
			'split' => __( 'Split menu', 'mfn-opts' ),
			'split,semi' => __( 'Split menu | Semitransparent', 'mfn-opts' ),
			'below,split' => __( 'Below slider + Split menu', 'mfn-opts' ),
			'overlay,transparent' => __( 'Overlay | 1 level menu', 'mfn-opts' ),
			'shop' => __( 'Shop', 'mfn-opts' ),
			'shop-split' => __( 'Shop split', 'mfn-opts' ),
		);
	}
}

if( ! function_exists( 'mfna_footer_style' ) )
{
	/**
	 * Footer Style
	 * @return array
	 */

	function mfna_footer_style(){
		return array(
			'' => __( '- Default -', 'mfn-opts' ),
			'5;one-fifth;one-fifth;one-fifth;one-fifth;one-fifth;' => '1/5 1/5 1/5 1/5 1/5',
			'4;one-fourth;one-fourth;one-fourth;one-fourth' => '1/4 1/4 1/4 1/4',

			'3;one-fifth;two-fifth;two-fifth' => '1/5 2/5 2/5',
			'3;two-fifth;one-fifth;two-fifth' => '2/5 1/5 2/5',
			'3;two-fifth;two-fifth;one-fifth' => '2/5 2/5 1/5',

			'3;one-fourth;one-fourth;one-second;' => '1/4 1/4 1/2',
			'3;one-fourth;one-second;one-fourth;' => '1/4 1/2 1/4',
			'3;one-second;one-fourth;one-fourth;' => '1/2 1/4 1/4',
			'3;one-third;one-third;one-third;' => '1/3 1/3 1/3',
			'2;one-third;two-third;;' => '1/3 2/3',
			'2;two-third;one-third;;' => '2/3 1/3',
			'2;one-second;one-second;;' => '1/2 1/2',
			'1;one;;;' => '1/1',
		);
	}
}

if( ! function_exists( 'mfna_pages' ) )
{
	/**
	 * Pages list
	 * @return array
	 */

	function mfna_pages(){

		$array = [
			'' => __( '-- Select --', 'mfn_opts' ),
		];

		$pages = get_pages( 'sort_column=post_title&hierarchical=0' );

		if( ! is_array( $pages ) ){
			return $array;
		}

		foreach( $pages as $page ){
			$array[ $page->ID ] = esc_attr( trim($page->post_title) );
		}

		return $array;
	}
}

if( ! function_exists( 'mfna_templates' ) )
{
	/**
	 * Templates list
	 * @return array
	 */

	function mfna_templates($type) {
		$array = [
			'0' => __( ' - Default - ', 'mfn_opts' ),
		];

		if( $type == 'megamenu' ){
			$array[ 'enabled' ] = __( ' - Automatic Mega Menu - ', 'mfn_opts' );
		}

		$templates = get_posts(
			array(
				'post_type'	=> 'template',
				'meta_key' => 'mfn_template_type',
        'meta_value' => $type,
        'numberposts' => -1
			)
		);

		if( ! is_array( $templates ) ){
			return $array;
		}

		foreach( $templates as $tmp ){
			$array[ $tmp->ID ] = esc_attr( trim($tmp->post_title) );
		}

		return $array;
	}
}

if( ! function_exists( 'mfna_bg_position' ) )
{
	/**
	 * Background Position
	 *
	 * @param string $body
	 * @return array
	 */

	function mfna_bg_position( $element = false ){
		$array = array(
			'' => __( 'Default', 'mfn-opts' ),
			'no-repeat;left top;;' => __( 'Left Top | no-repeat', 'mfn-opts' ),
			'repeat;left top;;' => __( 'Left Top | repeat', 'mfn-opts' ),
			'no-repeat;left center;;' => __( 'Left Center | no-repeat', 'mfn-opts' ),
			'repeat;left center;;' => __( 'Left Center | repeat', 'mfn-opts' ),
			'no-repeat;left bottom;;' => __( 'Left Bottom | no-repeat', 'mfn-opts' ),
			'repeat;left bottom;;' => __( 'Left Bottom | repeat', 'mfn-opts' ),

			'no-repeat;center top;;' => __( 'Center Top | no-repeat', 'mfn-opts' ),
			'repeat;center top;;' => __( 'Center Top | repeat', 'mfn-opts' ),
			'repeat-x;center top;;' => __( 'Center Top | repeat-x', 'mfn-opts' ),
			'repeat-y;center top;;' => __( 'Center Top | repeat-y', 'mfn-opts' ),
			'no-repeat;center;;' => __( 'Center Center | no-repeat', 'mfn-opts' ),
			'repeat;center;;' => __( 'Center Center | repeat', 'mfn-opts' ),
			'no-repeat;center bottom;;' => __( 'Center Bottom | no-repeat', 'mfn-opts' ),
			'repeat;center bottom;;' => __( 'Center Bottom | repeat', 'mfn-opts' ),
			'repeat-x;center bottom;;' => __( 'Center Bottom | repeat-x', 'mfn-opts' ),
			'repeat-y;center bottom;;' => __( 'Center Bottom | repeat-y', 'mfn-opts' ),

			'no-repeat;right top;;' => __( 'Right Top | no-repeat', 'mfn-opts' ),
			'repeat;right top;;' => __( 'Right Top | repeat', 'mfn-opts' ),
			'no-repeat;right center;;' => __( 'Right Center | no-repeat', 'mfn-opts' ),
			'repeat;right center;;' => __( 'Right Center | repeat', 'mfn-opts' ),
			'no-repeat;right bottom;;' => __( 'Right Bottom | no-repeat', 'mfn-opts' ),
			'repeat;right bottom;;' => __( 'Right Bottom | repeat', 'mfn-opts' ),
		);

		if( $element == 'column' ){

			// Column
			// do NOT change: backward compatibility

		} elseif( $element == 'header' ){

			// Header

			$array['fixed'] = __( 'Center | no-repeat | fixed', 'mfn-opts' );
			$array['no-repeat;center;fixed;cover;still'] = __( 'Center | no-repeat | fixed | cover', 'mfn-opts' );
			$array['parallax'] = __( 'Parallax', 'mfn-opts' );

		} elseif( $element ){

			// Site Body | <html> tag

			$array['no-repeat;center top;fixed;;'] = __( 'Center | no-repeat | fixed', 'mfn-opts' );
			$array['no-repeat;center;fixed;cover'] = __( 'Center | no-repeat | fixed | cover', 'mfn-opts' );

		} else {

			// Section / Wrap

			$array['no-repeat;center top;fixed;;still'] = __( 'Center | no-repeat | fixed', 'mfn-opts' );
			$array['no-repeat;center;fixed;cover;still'] = __( 'Center | no-repeat | fixed | cover', 'mfn-opts' );
			$array['no-repeat;center top;fixed;cover'] = __( 'Parallax', 'mfn-opts' );

		}

		return $array;
	}
}

if( ! function_exists( 'mfna_bg_size' ) )
{
	/**
	 * Skin
	 *
	 * @return array
	 */

	function mfna_bg_size(){
		return array(
			'' => __('Default', 'mfn-opts'),
			'auto' => __('Auto', 'mfn-opts'),
			'contain' => __('Contain', 'mfn-opts'),
			'cover' => __('Cover', 'mfn-opts'),
			'cover-ultrawide'	=> __('Cover, on ultrawide screens only > 1920px', 'mfn-opts'),
		);
	}
}

if( ! function_exists( 'mfna_skin' ) )
{
	/**
	 * Skin
	 *
	 * @return array
	 */

	function mfna_skin(){
		return array(
			'custom' => __('- Custom Skin -', 'mfn-opts'),
			'one' => __('- One Color Skin -', 'mfn-opts'),
			'blue' => __('Blue', 'mfn-opts'),
			'brown' => __('Brown', 'mfn-opts'),
			'chocolate'	=> __('Chocolate', 'mfn-opts'),
			'gold' => __('Gold', 'mfn-opts'),
			'green' => __('Green', 'mfn-opts'),
			'olive' => __('Olive', 'mfn-opts'),
			'orange' => __('Orange', 'mfn-opts'),
			'pink' => __('Pink', 'mfn-opts'),
			'red' => __('Red', 'mfn-opts'),
			'sea' => __('Seagreen', 'mfn-opts'),
			'violet' => __('Violet', 'mfn-opts'),
			'yellow' => __('Yellow', 'mfn-opts'),
		);
	}
}

if( ! function_exists( 'mfna_utc' ) )
{
	/**
	 * UTC – Coordinated Universal Time
	 *
	 * @return array
	 */

	function mfna_utc(){
		return array(
			'-12' => '-12:00',
			'-11' => '-11:00 Pago Pago',
			'-10' => '-10:00 Papeete, Honolulu',
			'-9.5' => '-9:30',
			'-9' => '-9:00 Anchorage',
			'-8' => '-8:00 Los Angeles, Vancouver, Tijuana',
			'-7' => '-7:00 Phoenix, Calgary, Ciudad Juárez',
			'-6' => '-6:00 Chicago, Guatemala City, Mexico City, San José, San Salvador, Winnipeg',
			'-5' => '-5:00 New York, Lima, Toronto, Bogotá, Havana, Kingston',
			'-4' => '-4:00 Caracas, Santiago, La Paz, Manaus, Halifax, Santo Domingo',
			'-3.5' => '-3:30 St. John\'s',
			'-3' => '-3:00 Buenos Aires, Montevideo, São Paulo',
			'-2' => '-2:00',
			'-1' => '-1:00 Praia',
			'0' => '±0:00 Accra, Casablanca, Dakar, Dublin, Lisbon, London',
			'+1' => '+1:00 Berlin, Lagos, Madrid, Paris, Rome, Tunis, Vienna, Warsaw',
			'+2' => '+2:00 Athens, Bucharest, Cairo, Helsinki, Jerusalem, Johannesburg, Kiev',
			'+3' => '+3:00 Istanbul, Moscow, Nairobi, Baghdad, Doha, Minsk, Riyadh',
			'+3.5' => '+3:30 Tehran',
			'+4' => '+4:00 Baku, Dubai, Samara, Muscat',
			'+4.5'	=> '+4:30 Kabul',
			'+5' => '+5:00 Karachi, Tashkent, Yekaterinburg',
			'+5.5' => '+5:30 Delhi, Colombo',
			'+5.75'	=> '+5:45 Kathmandu',
			'+6' => '+6:00 Almaty, Dhaka, Omsk',
			'+6.5' => '+6:30 Yangon',
			'+7' => '+7:00 Jakarta, Bangkok, Krasnoyarsk, Ho Chi Minh City',
			'+8' => '+8:00 Beijing, Hong Kong, Taipei, Singapore, Kuala Lumpur, Perth, Manila, Denpasar, Irkutsk',
			'+8.5'	=> '+8:30 Pyongyang',
			'+8.75'	=> '+8:45',
			'+9' => '+9:00 Seoul, Tokyo, Ambon, Yakutsk',
			'+9.5' => '+9:30 Adelaide',
			'+10' => '+10:00 Port Moresby, Brisbane, Vladivostok, Sydney',
			'+10.5'	=> '+10:30',
			'+11' => '+11:00 Nouméa',
			'+12' => '+12:00 Auckland, Suva',
			'+12.75'=> '+12:45',
			'+13' => '+13:00 Apia, Nukuʻalofa',
			'+14' => '+14:00',
		);
	}
}

if( ! function_exists( 'mfna_layout' ) )
{
	/**
	 * Layouts
	 *
	 * @return array
	 */

	function mfna_layout(){
		$layouts = array( 0 => __( '-- Theme Options --', 'mfn-opts' ) );
		$args = array(
			'post_type' => 'layout',
			'posts_per_page'=> -1,
		);
		$lay = get_posts( $args );

		if( is_array( $lay ) ){
			foreach ( $lay as $v ){
				$layouts[$v->ID] = esc_attr( trim($v->post_title) );
			}
		}

		return $layouts;
	}
}

if( ! function_exists( 'mfna_menu' ) )
{
	/**
	 * Menus
	 *
	 * @return array
	 */

	function mfna_menu(){
		$aMenus = array( 0 => __( ' - Select - ', 'mfn-opts' ) );
		$oMenus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		if( is_array( $oMenus ) ){

			foreach( $oMenus as $menu ){
				$aMenus[ $menu->term_id ] = $menu->name;

				$term_trans_id = apply_filters( 'wpml_object_id', $menu->term_id, 'nav_menu', false );
				if( $term_trans_id != $menu->term_id ){
					unset( $aMenus[ $menu->term_id ] );
				}

			}
		}

		return $aMenus;
	}
}

if( ! function_exists( 'mfna_section_style' ) )
{
	/**
	 * Section style
	 *
	 * @return array
	 */

	function mfna_section_style( $key = false ){

		$styles = [
			'no-margin-h'				 => __('Columns | remove horizontal margin', 'mfn-opts'),
			'no-margin-v'	 			 => __('Columns | remove vertical margin', 'mfn-opts'),
			'dark' 							 => __('Dark', 'mfn-opts'),
			'full-width-ex-mobile'	=> __('Full Width | except mobile', 'mfn-opts'),
			'highlight-left' 		 => __('Highlight | left', 'mfn-opts'),
			'highlight-right' 	 => __('Highlight | right<span>in highlight section please use two 1/2 wraps</span>', 'mfn-opts'),

			'full-screen'	 			 => __('Full Screen', 'mfn-opts'),
			'full-width'	 			 => __('Full Width', 'mfn-opts'),
			'equal-height'			 => __('Equal Height | items in wrap', 'mfn-opts'),
			'equal-height-wrap'	 => __('Equal Height | wraps', 'mfn-opts'),
		];

		if( $key ){
			return $styles[$key];
		}

		return $styles;

	}
}

if( ! function_exists( 'mfna_social' ) )
{
	/**
	 * Section style
	 *
	 * @return array
	 */

	function mfna_social( $key = false ){

		$socials = [
      'skype' => [
        'title' => 'Skype',
        'desc' => 'Skype login. You can use callto: or skype: prefix',
        'icon' => 'icon-skype',
      ],
      'whatsapp' => [
        'title' => 'WhatsApp',
        'desc' => 'WhatsApp URL. You can use whatsapp: prefix',
        'icon' => 'icon-whatsapp',
      ],
      'facebook' => [
        'title' => 'Facebook',
        'icon' => 'icon-facebook',
      ],
      'twitter' => [
        'title' => 'Twitter',
        'icon' => 'icon-twitter',
      ],
      'vimeo' => [
        'title' => 'Vimeo',
        'icon' => 'icon-vimeo',
      ],
      'youtube' => [
        'title' => 'YouTube',
        'icon' => 'icon-play',
      ],
      'flickr' => [
        'title' => 'Flickr',
        'icon' => 'icon-flickr',
      ],
      'linkedin' => [
        'title' => 'LinkedIn',
        'icon' => 'icon-linkedin',
      ],
      'pinterest' => [
        'title' => 'Pinterest',
        'icon' => 'icon-pinterest',
      ],
      'dribbble' => [
        'title' => 'Dribbble',
        'icon' => 'icon-dribbble',
      ],
      'instagram' => [
        'title' => 'Instagram',
        'icon' => 'icon-instagram',
      ],
      'snapchat' => [
        'title' => 'Snapchat',
        'icon' => 'icon-snapchat',
      ],
      'behance' => [
        'title' => 'Behance',
        'icon' => 'icon-behance',
      ],
      'tumblr' => [
        'title' => 'Tumblr',
        'icon' => 'icon-tumblr',
      ],
      'tripadvisor' => [
        'title' => 'Tripadvisor',
        'icon' => 'icon-tripadvisor',
      ],
      'vkontakte' => [
        'title' => 'VKontakte',
        'icon' => 'icon-vkontakte',
      ],
      'viadeo' => [
        'title' => 'Viadeo',
        'icon' => 'icon-viadeo',
      ],
      'xing' => [
        'title' => 'Xing',
        'icon' => 'icon-xing',
      ],
			'custom' => true,
			'rss' => true,
    ];

		if( $key ){
			return $socials[$key];
		}

		return $socials;

	}
}

/**
 * Options Page | Main Functions
 */

if( ! function_exists( 'mfn_opts_setup' ) )
{
	/**
	 * Options Page | Fields & Args
	 */

	function mfn_opts_setup(){

		global $MFN_Options;

		$global_sections = array( 'general', 'logo', 'buttons', 'frame', 'sliders', 'navigation' );

		$is_advanced_tab_hidden = apply_filters( 'betheme_disable_advanced', false );
		$is_hooks_tab_hidden = apply_filters( 'betheme_disable_hooks', false );

		if ( ! $is_advanced_tab_hidden ) $global_sections[] = 'advanced';
		if ( ! $is_hooks_tab_hidden ) $global_sections[] = 'hooks';


		// Navigation elements =====

		$menu = array(

			// Global

			'global' => array(
				'title' => __( 'Global', 'mfn-opts' ),
				'sections' => $global_sections,
			),

			// Header & Subheader

			'header-subheader' => array(
				'title' => __( 'Header & Subheader', 'mfn-opts' ),
				'sections' => array( 'header', 'subheader', 'extras' ),
			),

			// Menu & Action Bar

			'mab' => array(
				'title' => __( 'Menu & Action Bar', 'mfn-opts' ),
				'sections' => array( 'menu', 'action-bar' ),
			),

			// Sidebars

			'sidebars' => array(
				'title' => __('Sidebars', 'mfn-opts'),
				'sections' => array( 'sidebars' ),
			),

			// Blog, Portfolio

			'bps' => array(
				'title' => __('Blog & Portfolio', 'mfn-opts'),
				'sections' => array( 'bps-general', 'blog', 'portfolio', 'featured-image' ),
			),

			// Shop

			'shop' => array(
				'title' => __('Shop', 'mfn-opts'),
				'sections' => array( 'shop', 'shop-list', 'shop-single' ),
			),

			// Pages

			'pages' => array(
				'title' => __('Pages', 'mfn-opts'),
				'sections' => array( 'pages-general', 'pages-404', 'pages-under' ),
			),

			// Footer

			'footer' => array(
				'title' => __('Footer', 'mfn-opts'),
				'sections' => array( 'footer' ),
			),

			// Footer

			'search' => array(
				'title' => __('Search', 'mfn-opts'),
				'sections' => array( 'search-form', 'search-page' ),
			),

			// Responsive

			'responsive' => array(
				'title' => __('Responsive', 'mfn-opts'),
				'sections' => array( 'responsive', 'responsive-header' ),
			),

			// SEO

			'seo' => array(
				'title' => __('SEO', 'mfn-opts'),
				'sections' => array( 'seo' ),
			),

			// Social

			'social' => array(
				'title' => __('Social', 'mfn-opts'),
				'sections' => array( 'social' ),
			),

			// Addons, Plugins

			'addons-plugins' => array(
				'title' => __('Addons & Plugins', 'mfn-opts'),
				'sections' => array( 'addons', 'plugins' ),
			),

			// Colors

			'colors' => array(
				'title' => __('Colors', 'mfn-opts'),
				'sections' => array( 'colors-general', 'colors-action', 'colors-header', 'colors-menu',  'content', 'colors-alerts', 'colors-shortcodes', 'colors-forms', 'headings', 'colors-shop', 'colors-footer', 'colors-sliding-top' ),
			),

			// Fonts

			'font' => array(
				'title' => __('Fonts', 'mfn-opts'),
				'sections' => array( 'font-family', 'font-size', 'font-custom' ),
			),

			// Translate

			'translate' => array(
				'title' => __('Translate', 'mfn-opts'),
				'sections'	=> array( 'translate-general', 'translate-blog', 'translate-shop', 'translate-search', 'translate-404', 'translate-wpml' ),
			),

			// GDPR

			'gdpr' => array(
				'title' => __('GDPR & Cookies', 'mfn-opts'),
				'sections' => array( 'gdpr-general', 'gdpr-design' ),
			),

			// Page Speed / Performance

			'performance' => array(
				'title' => __( 'Performance', 'mfn-opts' ),
				'sections' => array( 'performance-general' ),
			),

			// Accessibility

			'accessibility' => array(
				'title' => __( 'Accessibility', 'mfn-opts' ),
				'sections' => array( 'accessibility-general' ),
			),


			// Custom CSS, JS

			'custom' => array(
				'title' => __('Custom CSS & JS', 'mfn-opts'),
				'sections' => array( 'css', 'js' ),
			),

		);

		$sections = array();

		// global | general -----

		$sections['general'] = array(

			'title' => __( 'General', 'mfn-opts' ),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
				),

				array(
					'id' => 'layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'full-width' => __('Full width', 'mfn-opts'),
						'boxed' => __('Boxed', 'mfn-opts'),
					),
					'std' => 'full-width',
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'grid-width',
					'type' => 'sliderbar',
					'title' => __('Site width', 'mfn-opts'),
					'desc' => __('Works only when <a href="admin.php?page=be-options#responsive">Responsive</a> option is enabled', 'mfn-opts'),
					'param' => array(
						'min' => 960,
						'max' => 1920,
					),
					'after'	=> 'px',
					'std' => 1240,
				),

				array(
					'id' => 'style',
					'type' => 'radio_img',
					'title' => __('Style', 'mfn-opts'),
					'options' => array(
						'' => __('Classic', 'mfn-opts'),
						'simple' => __('Simple', 'mfn-opts'),
					),
					'class' => 'form-content-full-width',
					'std' => '',
				),

				// background

				array(
					'title' => __('Background', 'mfn-opts'),
					'sub_desc' => __('Recommended size: <b>1920x1080 px</b>', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' 	 => 'img-page-bg',
					'type' => 'upload',
					'title' => __( 'Image', 'mfn-opts' ),
				),

				array(
					'id' => 'position-page-bg',
					'type' => 'select',
					'title' => __('Position', 'mfn-opts'),
					'desc' => __('iOS does <b>not</b> support fixed position', 'mfn-opts'),
					'options' => mfna_bg_position(1),
					'std' => 'center top no-repeat',
				),

				array(
					'id' => 'size-page-bg',
					'type' => 'select',
					'title' => __('Size', 'mfn-opts'),
					'desc' => __('Does <b>not</b> work with fixed position', 'mfn-opts'),
					'options' => mfna_bg_size(),
				),

				array(
					'id' => 'transparent',
					'type' => 'checkbox',
					'title' => __( 'Transparency', 'mfn-opts' ),
					'options' => array(
						'header'	=> __( 'Header', 'mfn-opts' ),
						'menu' => __( 'Top Bar with menu <span>Does <b>not</b> work with Header Below</span>', 'mfn-opts' ),
						'content'	=> __( 'Content', 'mfn-opts' ),
						'footer'	=> __( 'Footer', 'mfn-opts' ),
					),
				),

				// icon

				array(
					'title' => __('Icon', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id'	 => 'favicon-img',
					'type' => 'upload',
					'title' => __( 'Favicon', 'mfn-opts' ),
					'desc' => __( '<b>.ico</b> 32x32 px', 'mfn-opts' )
				),

				array(
					'id'	 => 'apple-touch-icon',
					'type' => 'upload',
					'title' => __( 'Apple Touch Icon', 'mfn-opts' ),
					'desc' => __( '<b>apple-touch-icon.png</b> 180x180 px', 'mfn-opts' )
				),

			),
		);

		// global | logo -----

		$sections['logo'] = array(

			'title' => __('Logo', 'mfn-opts'),
			'fields' => array(

				// logo

				array(
					'title' => __('Logo', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'logo-img',
					'type' => 'upload',
					'title' => __( 'Logo', 'mfn-opts' ),
				),

				array(
					'id' => 'retina-logo-img',
					'type' => 'upload',
					'title' => __( 'Retina Logo', 'mfn-opts' ),
					'desc' => __('Retina Logo should be twice size as Logo', 'mfn-opts'),
				),

				// sticky

				array(
					'title' => __('Sticky header logo', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id'	 => 'sticky-logo-img',
					'type' => 'upload',
					'title' => __( 'Logo', 'mfn-opts' ),
					'desc' => __( 'This is Tablet Logo for Creative Header', 'mfn-opts' ),
				),

				array(
					'id'	 => 'sticky-retina-logo-img',
					'type' => 'upload',
					'title' => __( 'Retina Logo', 'mfn-opts' ),
					'desc' => __('Retina Logo should be twice size as Logo', 'mfn-opts'),
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'join' => true,
					'class'	=> 'mhb-opt',
				),

				array(
					'id' => 'logo-link',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'link' => __('Link to Homepage', 'mfn-opts'),
						'h1-home' => __('Wrap into H1 tag on homepage', 'mfn-opts'),
						'h1-all' => __('Wrap into H1 tag on inner pages', 'mfn-opts'),
					),
					'std' => array(
						'link' => 'link'
					),
				),

				array(
					'id' => 'logo-text',
					'type' => 'text',
					'title' => __('Text logo', 'mfn-opts'),
					'desc' => __('Use text <b>instead</b> of graphic logo', 'mfn-opts'),
				),

				array(
					'id' => 'logo-width',
					'type' => 'text',
					'title' => __('SVG logo width', 'mfn-opts'),
					'desc' => __('Use only with <b>SVG</b> logo', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="#Top_bar #logo img.svg" data-responsive="desktop" data-style="width" data-unit="px"',
				),

				array(
					'id' => 'logo-width-tablet',
					'type' => 'text',
					'title' => __('SVG logo width', 'mfn-opts'),
					'desc' => __('Use only with <b>SVG</b> logo', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="#Top_bar #logo img.svg" data-responsive="tablet" data-style="width" data-unit="px"',
				),

				array(
					'id' => 'logo-width-mobile',
					'type' => 'text',
					'title' => __('SVG logo width', 'mfn-opts'),
					'desc' => __('Use only with <b>SVG</b> logo', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="#Top_bar #logo img.svg" data-responsive="mobile" data-style="width" data-unit="px"',
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
					'class'	=> 'mhb-opt',
				),

				array(
					'id' => 'logo-height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'desc' => __('Minimum height + padding = 60px', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow to-inline-style',
					'placeholder' => '60',
					'data_attr' => 'data-csspath="#Top_bar #logo, .header-fixed #Top_bar #logo, .header-plain #Top_bar #logo, .header-transparent #Top_bar #logo" data-responsive="desktop" data-style="height" data-std="60" data-unit="px"',
				),

				array(
					'id' => 'logo-vertical-padding',
					'type' => 'text',
					'title' => __('Padding top & bottom', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow',
					'placeholder' => '15',
				),

				array(
					'id' => 'logo-vertical-align',
					'type' => 'select',
					'title' => __( 'Vertical align', 'mfn-opts' ),
					'options' => array(
						'top' => __( 'Top', 'mfn-opts' ),
						'' => __( 'Middle', 'mfn-opts' ),
						'bottom' => __( 'Bottom', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'logo-advanced',
					'type' => 'checkbox',
					'title' => __( 'Advanced', 'mfn-opts' ),
					'options' => array(
						'no-margin' => __( 'Remove Left margin<span>Top margin for Header Creative</span>', 'mfn-opts' ),
						'overflow' => __( 'Overflow Logo<span>For specific header styles only</span>', 'mfn-opts' ),
						'no-sticky-padding' => __( 'Remove max-height & padding for Sticky Logo', 'mfn-opts' ),
						'sticky-width-auto' => __( 'Auto width for Sticky Logo', 'mfn-opts' ),
					),
				),

			),
		);

		// global | buttons -----

		$sections['buttons'] = array(
			'title'	=> __('Buttons', 'mfn-opts'),
			'fields' => array(

				// style

				array(
					'title' => __('Style', 'mfn-opts'),
				),

				array(
					'id' => 'button-style',
					'attr_id' => 'button-style',
					'type' => 'radio_img',
					'title' => __('Style', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'flat' => __('Flat', 'mfn-opts'),
						'round' => __('Round', 'mfn-opts'),
						'stroke' => __('Stroke', 'mfn-opts'),
						'custom' => __('Custom', 'mfn-opts'),
					),
					'alias' => 'button',
					'class' => 'form-content-full-width short condition',
				),

				// old | default

				array(
					'title' => '_'. __('Default', 'mfn-opts'),
					'join' => true,
					'attr' => 'buttons-old',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
				),

				array(
					'id' => 'color-button',
					'type' => 'color',
					'title' => __( 'Color', 'mfn-opts' ),
					'std' => '#747474',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".button-default .button, .button-flat .button, .button-round .button" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-button',
					'type' => 'color',
					'title' => __( 'Background', 'mfn-opts' ),
					'std' => '#f7f7f7',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".button-default .button, .button-flat .button, .button-round .button" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				// old | theme button

				array(
					'title' => '_'. __('Theme', 'mfn-opts'),
					'join' => true,
					'attr' => 'buttons-old',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
				),

				array(
					'id' => 'color-button-theme',
					'type' => 'color',
					'title' => __( 'Color', 'mfn-opts' ),
					'std' => '#ffffff',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
				),

				// old | action button

				array(
					'title' => '_'. __('Action', 'mfn-opts'),
					'join' => true,
					'attr' => 'buttons-old',
					'class'	=> 'mhb-opt',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
				),

				array(
					'id' => 'color-action-button',
					'type' => 'color',
					'title' => __( 'Color', 'mfn-opts' ),
					'std' => '#ffffff',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".action_button, .action_button:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-action-button',
					'type' => 'color',
					'title' => __( 'Background', 'mfn-opts' ),
					'std' => '#0089f7',
					'condition' => array( 'id' => 'button-style', 'opt' => 'isnt', 'val' => 'custom' ),
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".action_button, .action_button:hover" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				// custom

				array(
					'title' => __('Custom', 'mfn-opts'),
					'join' => true,
					'attr' => 'buttons-custom',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
				),

				array(
					'id' => 'button-font-family',
					'type' => 'font_select',
					'title' => __( 'Font family', 'mfn-opts' ),
					'class' => 'preview-font-family custom to-inline-style',
					'std' => 'Roboto',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath=".button-custom.woocommerce .button,.button-custom .button,.button-custom .action_button,.button-custom .footer_button,.button-custom button,.button-custom button.button, .button-custom .woocommerce #respond input#submit,.button-custom .woocommerce a.button,.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'button-font',
					'type' => 'typography',
					'title' => __( 'Font', 'mfn-opts' ),
					'disable' => 'line_height',
					'std' => array(
						'size' => 14,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width preview-font custom to-inline-style',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath=".button-custom.woocommerce .button,.button-custom .button,.button-custom .action_button,.button-custom .footer_button,.button-custom button,.button-custom button.button, .button-custom .woocommerce #respond input#submit,.button-custom .woocommerce a.button,.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop"',
				),

				array(
					'id' => 'button-padding',
					'type' => 'dimensions',
					'title' => __('Padding', 'mfn-opts'),
					'version' => 'separated-fields',
					'class' => 'preview-padding custom',
					'std' => [
						'top' => 12,
						'right' => 20,
						'bottom' => 12,
						'left' => 20,
						'isLinked' => 0,
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath=".button-custom .button, .button-custom #respond input#submit.alt.disabled, .button-custom #respond input#submit.alt.disabled:hover, .button-custom #respond input#submit.alt:disabled, .button-custom #respond input#submit.alt:disabled:hover, .button-custom #respond input#submit.alt:disabled[disabled], .button-custom #respond input#submit.alt:disabled[disabled]:hover, .button-custom a.button.alt.disabled, .button-custom a.button.alt.disabled:hover, .button-custom a.button.alt:disabled, .button-custom a.button.alt:disabled:hover, .button-custom a.button.alt:disabled[disabled], .button-custom a.button.alt:disabled[disabled]:hover, .button-custom button.button.alt.disabled, .button-custom button.button.alt.disabled:hover, .button-custom button.button.alt:disabled, .button-custom button.button.alt:disabled:hover, .button-custom button.button.alt:disabled[disabled], .button-custom button.button.alt:disabled[disabled]:hover, .button-custom input.button.alt.disabled, .button-custom input.button.alt.disabled:hover, .button-custom input.button.alt:disabled, .button-custom input.button.alt:disabled:hover, .button-custom input.button.alt:disabled[disabled], .button-custom input.button.alt:disabled[disabled]:hover, .button-custom #respond input#submit.alt, .button-custom a.button.alt, .button-custom button.button.alt, .button-custom input.button.alt" data-responsive="desktop" data-style="padding" data-unit="px"',
				),

				array(
					'id' => 'button-border-width',
					'type' => 'text',
					'title' => __('Border width', 'mfn-opts'),
					'class' => 'narrow   preview-border-width custom to-inline-style',
					'param' => 'number',
					'after' => 'px',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath=".button-custom.woocommerce .button,.button-custom .button,.button-custom .action_button,.button-custom .footer_button,.button-custom button,.button-custom button.button, .button-custom .woocommerce #respond input#submit,.button-custom .woocommerce a.button,.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop" data-style="border-width" data-unit="px"',
				),

				array(
					'id' => 'button-border-radius',
					'type' => 'text',
					'title' => __('Border radius', 'mfn-opts'),
					'class' => 'narrow    preview-border-radius custom to-inline-style',
					'param' => 'number',
					'after' => 'px',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath=".button-custom.woocommerce .button,.button-custom .button,.button-custom .action_button,.button-custom .footer_button,.button-custom button,.button-custom button.button, .button-custom .woocommerce #respond input#submit,.button-custom .woocommerce a.button,.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop" data-style="border-radius" data-unit="px"',
				),

				// preview

				array(
					'title' => __('Preview', 'mfn-opts'),
					'join' => true,
					'class' => 'mfn-hidden-form-row',
					'attr' => 'buttons-custom',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
				),

				array(
					'id' => 'button-preview',
					'type' => 'preview',
					'title' => __('Preview', 'mfn-opts'),
					'class' => 'form-content-full-width custom mfn-hidden-form-row',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
				),

				// default

				array(
					'title' => __('Default', 'mfn-opts'),
					'join' => true,
					'attr' => 'buttons-custom',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
				),

				array(
					'id' => 'button-color',
					'type' => 'color_multi',
					'title' => __('Color', 'mfn-opts'),
					'class' => 'form-content-full-width preview-color custom to-inline-style',
					'std' => [
						'normal' => '#626262',
						'hover' => '#626262',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="body.button-custom .button" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'button-background',
					'type' => 'color_multi',
					'title' => __('Background', 'mfn-opts'),
					'class' => 'form-content-full-width preview-background custom to-inline-style',
					'alpha' => true,
					'std' => [
						'normal' => '#dbdddf',
						'hover' => '#d3d3d3',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="body.button-custom .button:not(.button_theme)" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'button-border-color',
					'type' => 'color_multi',
					'title' => __('Border color', 'mfn-opts'),
					'class' => 'form-content-full-width preview-border-color custom to-inline-style',
					'std' => [
						'normal' => '',
						'hover' => '',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="body.button-custom .button:not(.button_theme)" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				array(
  				'id' => 'button-box-shadow',
  				'type' => 'box_shadow',
					'class' => 'preview-box-shadow custom',
  				'title' => __('Box shadow', 'mfn-opts'),
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
  			),

				// highlighted

				array(
					'title' => __('Highlighted', 'mfn-opts'),
					'sub_desc' => __('Primary buttons, i.e. shop, contact form', 'mfn-opts'),
					'join' => true,
					'attr' => 'buttons-custom',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
				),

				array(
					'id' => 'button-highlighted-color',
					'type' => 'color_multi',
					'title' => __('Color', 'mfn-opts'),
					'class' => 'form-content-full-width preview-color highlighted custom to-inline-style',
					'std' => [
						'normal' => '#ffffff',
						'hover' => '#ffffff',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="html .button-custom .button_theme,.button-custom button,.button-custom .woocommerce #respond input#submit,body.button-custom.woocommerce a.button:not(.default),.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'button-highlighted-background',
					'type' => 'color_multi',
					'title' => __('Background', 'mfn-opts'),
					'class' => 'form-content-full-width preview-background highlighted custom to-inline-style',
					'alpha' => true,
					'std' => [
						'normal' => '#0095eb',
						'hover' => '#007cc3',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="html .button-custom .button_theme,.button-custom button,.button-custom .woocommerce #respond input#submit,body.button-custom.woocommerce a.button:not(.default),.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'button-highlighted-border-color',
					'type' => 'color_multi',
					'title' => __('Border color', 'mfn-opts'),
					'class' => 'form-content-full-width preview-border-color highlighted custom to-inline-style',
					'std' => [
						'normal' => '',
						'hover' => '',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="html .button-custom .button_theme,.button-custom button,.button-custom .woocommerce #respond input#submit,body.button-custom.woocommerce a.button:not(.default),.button-custom .woocommerce button.button,.button-custom .woocommerce input.button" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				array(
  				'id' => 'button-highlighted-box-shadow',
  				'type' => 'box_shadow',
					'class' => 'preview-box-shadow highlighted custom',
  				'title' => __('Box shadow', 'mfn-opts'),
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
  			),

				// action

				array(
					'title' => __('Action', 'mfn-opts'),
					'sub_desc' => __( 'Button located in header, next to main menu', 'mfn-opts' ),
					'join' => true,
					'attr' => 'buttons-custom',
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
				),

				array(
					'id' => 'button-action-color',
					'type' => 'color_multi',
					'title' => __('Color', 'mfn-opts'),
					'class' => 'form-content-full-width custom to-inline-style',
					'std' => [
						'normal' => '#626262',
						'hover' => '#626262',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="html body.button-custom .action_button" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				array(
					'id' => 'button-action-background',
					'type' => 'color_multi',
					'title' => __('Background', 'mfn-opts'),
					'class' => 'form-content-full-width custom to-inline-style',
					'alpha' => true,
					'std' => [
						'normal' => '#dbdddf',
						'hover' => '#d3d3d3',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="html body.button-custom .action_button" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				array(
					'id' => 'button-action-border-color',
					'type' => 'color_multi',
					'title' => __('Border color', 'mfn-opts'),
					'class' => 'form-content-full-width custom to-inline-style',
					'std' => [
						'normal' => '',
						'hover' => '',
					],
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
					'data_attr' => 'data-csspath="html body.button-custom .action_button" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				array(
  				'id' => 'button-action-box-shadow',
  				'type' => 'box_shadow',
					'class' => 'custom',
  				'title' => __('Box shadow', 'mfn-opts'),
					'condition' => array( 'id' => 'button-style', 'opt' => 'is', 'val' => 'custom' ),
  			),

			),
		);

		// global | general -----

		$sections['frame'] = array(

			'title' => __( 'Image frame', 'mfn-opts' ),
			'fields' => array(

				// image frame

				array(
					'title' => __('Image frame', 'mfn-opts'),
					// 'join' => true,
				),

				array(
					'id' => 'image-frame-style',
					'type' => 'radio_img',
					'title' => __('Style', 'mfn-opts'),
					'options' => array(
						'modern-overlay' => __('Modern overlay', 'mfn-opts'),
						'overlay' => __('Overlay', 'mfn-opts'),
						'' => __('Slide bottom', 'mfn-opts'),
						'zoom' => __('Zoom | without icons', 'mfn-opts'),
						'disable' => __('Disable hover effect', 'mfn-opts'),
					),
					'class' => 'form-content-full-width re_render_to',
					'std' => 'modern-overlay',
					'alias' => 'image-frame',
					're_render_if' => 'div|.image_frame'
				),

				array(
					'id' => 'image-frame-border-width',
					'type' => 'text',
					'title' => __('Border width', 'mfn-opts'),
					'param' => 'number',
					'class' => 'narrow to-inline-style',
					'after' => 'px',
					'std' => '0',
					'data_attr' => 'data-csspath=".image_frame, .wp-caption" data-responsive="desktop" data-style="border-width" data-unit="px"',
				),

				array(
					'id' => 'image-frame-caption',
					'type' => 'switch',
					'title' => __('Caption', 'mfn-opts'),
					'options' => array(
						'' 	 => __( 'Below image', 'mfn-opts' ),
						'on' => __( 'On image', 'mfn-opts' ),
					),
					'std' => '',
				),

				// design

				array(
					'title' => __('Design', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-imageframe-link',
					'type' => 'color_multi',
					'title' => __('Icon backgound', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#ffffff',
						'hover' => '#ffffff',
					],
					'data_attr' => 'data-csspath=".image_frame .image_wrapper .image_links a" data-responsive="desktop" data-style="background" data-unit=""',
				),

				array(
					'id' => 'color-imageframe-link',
					'type' => 'color_multi',
					'title' => __('Icon color', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#161922',
						'hover' => '#0089f7',
					],
					'data_attr' => 'data-csspath=".image_frame .image_wrapper .image_links a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'border-imageframe-link',
					'type' => 'color_multi',
					'title' => __('Icon border', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#ffffff',
						'hover' => '#ffffff',
					],
					'alpha' => true,
					'data_attr' => 'data-csspath=".image_frame .image_wrapper .image_links a" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				array(
					'id' => 'border-imageframe',
					'type' => 'color',
					'title' => __('Image border color', 'mfn-opts'),
					'condition' => array( 'id' => 'image-frame-border-width', 'opt' => 'isnt', 'val' => '0' ),
					'std' => '#f8f8f8',
				),

				array(
					'id' => 'color-imageframe-mask-new',
					'type' => 'color',
					'title' => __('Image hover mask', 'mfn-opts'),
					'desc' => __('Mask shows on hover for styles: Overlay and Slide bottom', 'mfn-opts'),
					'alpha' => true,
					'std' => 'rgba(0,0,0,.15)',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".image_frame .image_wrapper .mask::after" data-responsive="desktop" data-style="background" data-unit=""',
				),

			),
		);

		// global | sliders -----

		$sections['sliders'] = array(
			'title' => __('Sliders', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// sliders

				array(
					'title' => __('Sliders', 'mfn-opts'),
					'sub_desc' => __('Set <b>0</b> to disable auto slide, 1000ms = 1s', 'mfn-opts'),
				),

				array(
					'id' => 'slider-blog-timeout',
					'type' => 'text',
					'title' => __('Blog', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

				array(
					'id' => 'slider-clients-timeout',
					'type' => 'text',
					'title' => __('Clients', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

				array(
					'id' => 'slider-offer-timeout',
					'type' => 'text',
					'title' => __('Offer', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

				array(
					'id' => 'slider-portfolio-timeout',
					'type' => 'text',
					'title' => __('Portfolio', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

				array(
					'id' => 'slider-shop-timeout',
					'type' => 'text',
					'title' => __('Shop', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

				array(
					'id' => 'slider-slider-timeout',
					'type' => 'text',
					'title' => __('Slider', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

				array(
					'id' => 'slider-testimonials-timeout',
					'type' => 'text',
					'title' => __('Testimonials', 'mfn-opts'),
					'after' => 'ms',
					'param' => 'number',
					'std' => '0',
				),

			),
		);

		// global | navigation share -----

		$sections['navigation'] = array(
			'title' => __('Navigation & share', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				array(
					'id' => 'info-navigation',
					'type' => 'info',
					'title' => __('Navigation and Share box show in Blog, Portfolio and Shop', 'mfn-opts'),
				),

				// navigation

				array(
					'title' => __('Navigation', 'mfn-opts'),
					'sub_desc' => __('', 'mfn-opts'),
				),

				array(
					'id' => 'prev-next-nav',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'hide-header'	=> __('Header arrows', 'mfn-opts'),
						'hide-sticky'	=> __('Sticky arrows', 'mfn-opts'),
						'in-same-term'	=> __('Show all posts<span>Disable to navigate only in the same category (excluding Shop)</span>', 'mfn-opts'),
					),
					'invert' => true, // !!!
					'class' => 're_render_to',
					're_render_if' => 'div|.single #Wrapper'
				),

				array(
					'id' => 'prev-next-style',
					'type' => 'switch',
					'title' => __('Header arrows', 'mfn-opts'),
					'options' => array(
						'' => __('Classic', 'mfn-opts'),
						'minimal'	=> __('Simple', 'mfn-opts'),
					),
					'std' => 'minimal',
					'class' => 're_render_to',
					're_render_if' => 'div|.single #Wrapper'
				),

				array(
					'id' => 'prev-next-sticky-style',
					'attr_id' => 'prev-next-sticky-style',
					'type' => 'switch',
					'title' => __( 'Sticky arrows', 'mfn-opts' ),
					'options' => array(
						'' => __( 'Default', 'mfn-opts' ),
						'images' => __( 'Images only', 'mfn-opts' ),
						'arrows' => __( 'Arrows only', 'mfn-opts' ),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|.single #Wrapper'
				),

				array(
					'id' => 'prev-next-date',
					'type' => 'switch',
					'title' => __('Date', 'mfn-opts'),
					'condition' => array( 'id' => 'prev-next-sticky-style', 'opt' => 'is', 'val' => '' ),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1'	=> __('Show', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.single #Wrapper'
				),

				// share

				array(
					'title' => __('Share', 'mfn-opts'),
					'sub_desc' => __('', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'share',
					'type' => 'switch',
					'title' => __( 'Share Box', 'mfn-opts' ),
					'options' => array(
						'0' => __( 'Hide', 'mfn-opts' ),
						'hide-mobile' => __( 'Hide on mobile', 'mfn-opts' ),
						'1' => __( 'Show', 'mfn-opts' ),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.single #Wrapper'
				),

				array(
					'id' => 'share-style',
					'type' => 'switch',
					'title' => __( 'Style', 'mfn-opts' ),
					'options' => array(
						'' => __( 'Classic', 'mfn-opts' ),
						'simple' => __( 'Simple', 'mfn-opts' ),
					),
					'std' => 'simple',
					'class' => 're_render_to',
					're_render_if' => 'div|.single #Wrapper'
				),


			),
		);

		// global | advanced -----

		$sections['advanced'] = array(
			'title' => __('Advanced', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
				),

				array(
					'id' => 'layout-boxed-padding',
					'type' => 'text',
					'title' => __('Side padding for Boxed Layout', 'mfn-opts'),
					'desc' => __('Use <b>px</b> or <b>%</b>', 'mfn-opts'),
					'placeholder' => '20px',
				),

				array(
					'id' => 'builder-visibility',
					'type' => 'select',
					'title' => __( 'BeBuilder visibility', 'mfn-opts' ),
					'options' => array(
						'' => __( '-- Everyone --', 'mfn-opts' ),
						'publish_posts' => __( 'Author', 'mfn-opts' ),
						'edit_pages' => __( 'Editor', 'mfn-opts' ),
						'edit_theme_options' => __( 'Administrator', 'mfn-opts' ),
						'hide' => __( 'HIDE for Everyone', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'builder-blocks',
					'type' => 'switch',
					'title' => __( 'BeBuilder Blocks', 'mfn-opts' ),
					'options' => array(
						0 => __( 'Disable', 'mfn-opts' ),
						1 => __( 'Enable', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'display-order',
					'type' => 'select',
					'title' => __( 'Content display order', 'mfn-opts' ),
					'options' => array(
						0 => __( 'BeBuilder - WordPress Editor', 'mfn-opts' ),
						1 => __( 'WordPress Editor - BeBuilder', 'mfn-opts' ),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Wrapper'
				),

				array(
					'id' => 'content-remove-padding',
					'type' => 'switch',
					'title' => __('Content top padding', 'mfn-opts'),
					'desc' => __('30px by default', 'mfn-opts'),
					'options' => array(
						'1' => __('Hide', 'mfn-opts'),
						'0' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'no-hover',
					'type' => 'select',
					'title' => __('Hover Effects', 'mfn-opts'),
					'options' => array(
						'' => __('Enable', 'mfn-opts'),
						'tablet' => __('Enable on desktop only', 'mfn-opts'),
						'all' => __('Disable', 'mfn-opts'),
					),
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'google-maps-api-key',
					'type' => 'text',
					'title' => __( 'Google Maps API key', 'mfn-opts' ),
					'desc' => __( '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Google Maps API key</a> is required for <i>Map Basic Embed</i> or <i>Map Advanced</i>.', 'mfn-opts'),
					'placeholder' => 'AIzaZyAYx-LiNW48x71E9dZ32hAp9MKnHnOIFeI',
					're_render_if' => 'div|.google-map',
					'class' => 're_render_to',
				),

				array(
					'id' => 'table-hover',
					'type' => 'select',
					'title' => __('HTML table', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'hover' => __('Rows Hover', 'mfn-opts'),
						'responsive' => __('Auto Responsive', 'mfn-opts'),
					),
					're_render_if' => 'div|table',
					'class' => 're_render_to',
				),

				array(
					'id' => 'math-animations-disable',
					'type' => 'switch',
					'title' => __('Animate digits', 'mfn-opts'),
					'desc' => __('Animations for <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#counter" target="_blank">Counter</a> & <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#quickfact" target="_blank">Quick fact</a> items', 'mfn-opts'),
					'options' => array(
						'1' => __('Disable', 'mfn-opts'),
						'0' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

				array(
					'id' => 'layout-options',
					'type' => 'checkbox',
					'title' => __('Other', 'mfn-opts'),
					'options' => array(
						'no-shadows' => __('Shadows<span>Boxed Layout, Creative Header, Sticky Header, Subheader, etc.</span>', 'mfn-opts'),
						'boxed-no-margin' => __('Boxed Layout margin<span>Top and bottom margin for Layout: Boxed</span>', 'mfn-opts'),
					),
					'invert' => true, // !!!
				),

				// theme function

				array(
					'title' => __('Theme functions', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'post-type-disable',
					'type' => 'checkbox',
					'title' => __('Custom post types', 'mfn-opts'),
					'desc' => __('If you do not want to use any of these Post Types, you can disable them individually', 'mfn-opts'),
					'options' => array(
						'client' => __('Clients', 'mfn-opts'),
						'layout' => __('Layouts', 'mfn-opts'),
						'offer' => __('Offer', 'mfn-opts'),
						'portfolio' => __('Portfolio', 'mfn-opts'),
						'slide' => __('Slides', 'mfn-opts'),
						'template' => __('Templates', 'mfn-opts'),
						'testimonial' => __('Testimonials', 'mfn-opts'),
					),
					'invert' => true, // !!!
				),

				array(
					'id' => 'theme-disable',
					'type' => 'checkbox',
					'title' => __('Theme functions', 'mfn-opts'),
					'desc' => __('If you do not want to use any of these features or use external plugins instead, you can disable them individually', 'mfn-opts'),
					'options' => array(
						'categories-sidebars' => __('Categories sidebars<span>This option affects existing sidebars. Please use before adding widgets</span>', 'mfn-opts'),
						'custom-icons' => __('Custom icons', 'mfn-opts'),
						'mega-menu' => __('Mega Menu', 'mfn-opts'),
						'builder-preview' => __('BeBuilder items preview', 'mfn-opts'),
						'demo-data' => __('Pre-built websites & Setup Wizard', 'mfn-opts'),
						'svg-allow' => __('SVG files upload<span>Allowing upload of SVG files is a potential security risk</span>', 'mfn-opts'),
						'json-allow' => __('JSON files upload<span>Allowing upload of JSON files is required for LOTTIE</span>', 'mfn-opts')
					),
					'std' => array(
						'svg-allow' => 'svg-allow',
					),
					'invert' => true, // !!!
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'static-css',
					'type' => 'switch',
					'title' => __('Static CSS', 'mfn-opts'),
					'desc' => __('Some changes in Theme Options are saved as CSS and inserted into the head of your site. You can enable this option and make them a separate file that will create itself, update, and minify each time you save Theme Options.', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

				array(
					'id' => 'builder-autosave',
					'type' => 'switch',
					'title' => __('BeBuilder autosave', 'mfn-opts'),
					'desc' => __('An option that disable/enable autosave for the BeBuilder. Please note that when this option is disabled, any changes made in the BeBuilder will not be automatically saved.', 'mfn-opts'),
					'options' => array(
						'1' => __('Disable', 'mfn-opts'),
						'' => __('Enable', 'mfn-opts'),
					),
					'std' => ''
				),

				array(
					'id' => 'builder-storage',
					'type' => 'select',
					'title' => __('BeBuilder data storage', 'mfn-opts'),
					'desc' => __('This option will <b>not</b> affect existing pages, only newly created or updated', 'mfn-opts'),
					'options' => array(
						'' => __('Serialized | Readable format, required by some plugins', 'mfn-opts'),
						'non-utf-8' => __('Serialized (safe mode) | Readable format, for non-UTF-8 server, etc.', 'mfn-opts'),
						'encode' => __('Encoded | Less data stored, compatible with WordPress Importer', 'mfn-opts'),
					),
				),

				array(
					'id' => 'slider-shortcode',
					'type' => 'text',
					'title' => __('Slider shortcode', 'mfn-opts'),
					'desc' => __('This option can <b>not</b> be overwritten and it is usefull for those who already have many pages and want to standardize their appearance.', 'mfn-opts'),
					'placeholder' => '[rev_slider alias="slider"]',
				),

				array(
					'id' => 'table_prefix',
					'type' => 'select',
					'title' => __('Table Prefix', 'mfn-opts'),
					'desc' => __('For some <b>multisite</b> installations it is necessary to change table prefix to get Sliders List in Page Options. Please do <b>not</b> change if everything works.', 'mfn-opts'),
					'options' => array(
						'base_prefix' => 'base_prefix',
						'prefix' => 'prefix',
					),
				),

				array(
					'id' => 'hide_editor',
					'type' => 'switch',
					'title' => __('WordPress Editor', 'mfn-opts'),
					'desc' => __('If you use only BeBuilder and do not want WordPress Editor to distract you, you can hide it.', 'mfn-opts'),
					'options' => array(
						'1' => __('Hide', 'mfn-opts'),
						'0' => __('Show', 'mfn-opts'),
					),
					'std' => '0'
				),

				array(
					'id' => 'automatic-updates',
					'type' => 'switch',
					'title' => __('Automatic theme updates', 'mfn-opts'),
					'desc' => __('Toggle the option for built-in WordPress automatic updates.<br/>Works only for registered theme with default theme directory name.<br/>Use this option <b>only if your server makes regular backups.</b>', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

			),
		);

		// global | hooks -----

		$sections['hooks'] = array(
			'title' => __('Hooks', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// hooks

				array(
					'title' => __('Hooks', 'mfn-opts'),
				),

				array(
					'id' => 'hook-top',
					'type' => 'textarea',
					'title' => __('Top', 'mfn-opts'),
					'desc' => __('Executes <b>after</b> the opening <b>&lt;body&gt;</b> tag', 'mfn-opts'),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'hook-content-before',
					'type' => 'textarea',
					'title' => __('Content before', 'mfn-opts'),
					'desc' => __('Executes <b>before</b> the opening <b>&lt;#Content&gt;</b> tag', 'mfn-opts'),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'hook-content-after',
					'type' => 'textarea',
					'title' => __('Content after', 'mfn-opts'),
					'desc' => __('Executes <b>after</b> the closing <b>&lt;/#Content&gt;</b> tag', 'mfn-opts'),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'hook-bottom',
					'type' => 'textarea',
					'title' => __('Bottom', 'mfn-opts'),
					'desc' => __('Executes <b>before</b> the closing <b>&lt;/body&gt;</b> tag', 'mfn-opts'),
					'class' => 'form-content-full-width',
				),

			),
		);

		// header & subheader | header -----

		$sections['header'] = array(
			'title' => __('Header', 'mfn-opts'),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'class'	=> 'mhb-opt',
				),

				array(
					'id' => 'header-style',
					'type' => 'radio_img',
					'title' => __( 'Style', 'mfn-opts' ),
					'options' => mfna_header_style(),
					'alias' => 'header',
					'class' => 'form-content-full-width re_render_to',
					're_render_if' => 'div|#Header_wrapper',
					'std' => 'classic',
				),

				array(
					'id' => 'header-fw',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'full-width' => __('Full Width<span>Full Width layout</span>', 'mfn-opts'),
						'header-boxed' => __('Boxed Sticky Header<span>Boxed layout<span>', 'mfn-opts'),
					),
				),

				array(
					'id' => 'header-height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow to-inline-style',
					'std' => 250,
					'placeholder' => 250,
					'data_attr' => 'data-csspath="body:not(.template-slider) #Header" data-responsive="desktop" data-style="min-height" data-unit="px"',
				),

				// background

				array(
					'title' => __('Background', 'mfn-opts'),
					'sub_desc' => __('Recommended image width: <b>1920px</b>', 'mfn-opts'),
					'join' => true,
					'class'	=> 'mhb-opt',
				),

				array(
					'id' => 'img-subheader-bg',
					'type' => 'upload',
					'title' => __( 'Image', 'mfn-opts' ),
					'desc' => __( 'For pages without slider. Background may be overwritten for single page.', 'mfn-opts' ),
				),

				array(
					'id' => 'img-subheader-attachment',
					'type' => 'select',
					'title' => __( 'Position', 'mfn-opts' ),
					'desc' => __( 'iOS does <b>not</b> support fixed position', 'mfn-opts' ),
					'options' => mfna_bg_position( 'header' ),
				),

				array(
					'id' => 'size-subheader-bg',
					'type' => 'select',
					'title' => __('Size', 'mfn-opts'),
					'desc' => __('Does <b>not</b> work with fixed position', 'mfn-opts'),
					'options' => mfna_bg_size(),
				),

				// top bar

				array(
					'title' => __('Top bar background', 'mfn-opts'),
					'sub_desc' => __('& Header Creative background', 'mfn-opts'),
					'join' => true,
					'class'	=> 'mhb-opt',
				),

				array(
					'id' => 'top-bar-bg-img',
					'type' => 'upload',
					'title' => __( 'Image', 'mfn-opts' ),
				),

				array(
					'id' => 'top-bar-bg-position',
					'type' => 'select',
					'title' => __( 'Position', 'mfn-opts' ),
					'desc' => __( 'iOS does <b>not</b> support fixed position', 'mfn-opts' ),
					'options'	=> mfna_bg_position(),
				),

				// sticky header

				array(
					'title' => __('Sticky header', 'mfn-opts'),
					'join' => true,
					'class'	=> 'mhb-opt',
				),

				array(
					'id' => 'sticky-header',
					'type' => 'switch',
					'title' => __( 'Sticky', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'sticky-header-style',
					'type' => 'select',
					'title' => __( 'Style', 'mfn-opts' ),
					'options'	=> array(
						'tb-color' => __( 'The same as Top Bar Left background', 'mfn-opts' ),
						'white' => __( 'White', 'mfn-opts' ),
						'dark' => __( 'Dark', 'mfn-opts' ),
					),
				),

			),
		);

		// header & subheader | subheader -----

		$sections['subheader'] = array(
			'title' => __('Subheader', 'mfn-opts'),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
				),

				array(
					'id' => 'subheader-style',
					'type' => 'select',
					'title' => __('Style', 'mfn-opts'),
					'options'	=> array(
						'both-center' => __('Title & Breadcrumbs Centered', 'mfn-opts'),
						'both-left' => __('Title & Breadcrumbs on the Left', 'mfn-opts'),
						'both-right' => __('Title & Breadcrumbs on the Right', 'mfn-opts'),
						'' => __('Title on the Left', 'mfn-opts'),
						'title-right' => __('Title on the Right', 'mfn-opts'),
					),
					'std' => 'both-center',
				),

				array(
					'id' => 'subheader',
					'type' => 'checkbox',
					'title' => __('Hide', 'mfn-opts'),
					'options' => array(
						'hide-breadcrumbs'	=> __('Breadcrumbs', 'mfn-opts'),
						'hide-title' => __('Page Title', 'mfn-opts'),
						'hide-subheader'	=> __('Subheader', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'subheader-padding',
					'type' => 'text',
					'title' => __('Padding', 'mfn-opts'),
					'desc' => __('Use <b>px</b> or <b>em</b>', 'mfn-opts'),
					'placeholder'=> '30px 0',
				),

				array(
					'id' => 'subheader-title-tag',
					'type' => 'select',
					'title' => __('Title tag', 'mfn-opts'),
					'options' => array(
						'h1'	=> 'H1',
						'h2'	=> 'H2',
						'h3'	=> 'H3',
						'h4'	=> 'H4',
						'h5'	=> 'H5',
						'h6'	=> 'H6',
						'span'	=> 'span',
					),
				),

				// background

				array(
					'title' => __('Background', 'mfn-opts'),
					'sub_desc' => __('Recommended image width: <b>1920px</b>', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'subheader-image',
					'type' => 'upload',
					'title' => __( 'Image', 'mfn-opts' ),
				),

				array(
					'id' => 'subheader-position',
					'type' => 'select',
					'title' => __('Position', 'mfn-opts'),
					'desc' => __('iOS does <b>not</b> support fixed position', 'mfn-opts'),
					'options' => mfna_bg_position(1),
					'std' => 'center top no-repeat',
				),

				array(
					'id' => 'subheader-size',
					'type' => 'select',
					'title' => __('Size', 'mfn-opts'),
					'desc' => __('Does <b>not</b> work with fixed position', 'mfn-opts'),
					'options' => mfna_bg_size(),
				),

				array(
					'id' => 'subheader-transparent',
					'type' => 'sliderbar',
					'title' => __('Transparency (alpha)', 'mfn-opts'),
					'desc' => __('for Custom or One Color <a href="admin.php?page=be-options#colors-general">Theme Skin</a> only', 'mfn-opts'),
					'param' => array(
						'min' => 0,
						'max' => 100,
					),
					'std' => '100',
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'subheader-advanced',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'breadcrumbs-link'	=> __('Last item in <b>Breadcrumbs</b> is link<span>does <b>not</b> work with <a href="https://support.muffingroup.com/documentation/shop-creation/" target="_blank">Shop</a> related pages</span>', 'mfn-opts'),
						'slider-show' => __('Show subheader on pages with Slider', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

			),
		);

		// header & subheader | extras -----

		$sections['extras'] = array(
			'title' => __( 'Extras', 'mfn-opts' ),
			'fields' => array(

				// top bar right

				array(
					'title' => __('Top bar right', 'mfn-opts'),
					'sub_desc' => __('Container next to the menu for: <i>Action Button</i>, <i>Cart</i>, <i>Search</i> & <i>Language switcher</i>', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'top-bar-right-hide',
					'type' => 'switch',
					'title' => __( 'Top bar right', 'mfn-opts' ),
					'options'	=> array(
						'1' => __( 'Hide', 'mfn-opts' ),
						'0' => __( 'Show', 'mfn-opts' ),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				// action button

				array(
					'title' => __('Action button', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'header-action-title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
				),

				array(
					'id' => 'header-action-link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
				),

				array(
					'id' => 'header-action-target',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'target' => __('Open in new window', 'mfn-opts'),
						'scroll' => __('Scroll to section (use <b>#SectionID</b> as Link)', 'mfn-opts'),
					),
				),

				// wpml

				array(
					'title' => __('WPML', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'header-wpml',
					'type' => 'select',
					'title' => __('Custom switcher', 'mfn-opts'),
					'desc' => __('Custom language switcher is independent of WPML switcher options', 'mfn-opts'),
					'options'	=> array(
						'' => __('Dropdown | Flags', 'mfn-opts'),
						'dropdown-name' => __('Dropdown | Language Name (native)', 'mfn-opts'),
						'horizontal' => __('Horizontal | Flags', 'mfn-opts'),
						'horizontal-code'	=> __('Horizontal | Language Code', 'mfn-opts'),
						'hide' => __('Hide', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'header-wpml-options',
					'type' => 'checkbox',
					'title' => __('Custom switcher options', 'mfn-opts'),
					'options' => array(
						'link-to-home'	=> __('Link to home of language for missing translations<span>Disable this option to skip languages with missing translation</span>', 'mfn-opts'),
					),
				),

				// other

				array(
					'title' => __('Other', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'header-banner',
					'type' => 'textarea',
					'title' => __( 'Banner', 'mfn-opts' ),
					'desc' => 'In this field, you can use raw HTML to put the content or banner to the right of the Logo when using Magazine header style. For Creative header, the content would appear below the logo na menu. For more details about this feature, please <a href="https://support.muffingroup.com/how-to/how-to-put-extra-content-or-banner-next-to-the-logo/" target="_blank">read this article</a><br /><br />ex. code for banner: <b>&lt;a href="#" target="_blank"&gt;&lt;img src="" /&gt;&lt;/a&gt;</b>',
					'class' => 'form-content-full-width',
				),

				// sliding top

				array(
					'title' => __('Sliding Top', 'mfn-opts'),
					'sub_desc' => __('Widgetized area falling from the top on click. For more details, please <a href="https://support.muffingroup.com/how-to/how-to-configure-sliding-top/" target="_blank">read this article</a>', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'sliding-top',
					'type' => 'select',
					'title' => __( 'Sliding Top', 'mfn-opts' ),
					'desc' => __( 'Sliding Top Icon position', 'mfn-opts' ),
					'options'	=> array(
						'1' => __( 'Right', 'mfn-opts' ),
						'center' => __( 'Center', 'mfn-opts' ),
						'left' => __( 'Left', 'mfn-opts' ),
						'0' => __( 'Hide', 'mfn-opts' ),
					),
					'std' => '0',
				),

				array(
					'id' => 'sliding-top-icon',
					'type' => 'icon',
					'title' => __( 'Icon', 'mfn-opts' ),
					'std' => 'icon-down-open-mini',
				),

			),
		);

		// menu & action bar | menu -----

		$sections['menu'] = array(
			'title' => __('Menu', 'mfn-opts'),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'menu-style',
					'type' => 'select',
					'title' => __('Style', 'mfn-opts'),
					'desc' => __('For some header styles only', 'mfn-opts'),
					'options'	=> array(
						'link-color' => __('Link color only', 'mfn-opts'),
						'' => __('Line above Menu', 'mfn-opts'),
						'line-below' => __('Line below Menu', 'mfn-opts'),
						'line-below-80' => __('Line below Link (80% width)', 'mfn-opts'),
						'line-below-80-1'	=> __('Line below Link (80% width, 1px height)', 'mfn-opts'),
						'arrow-top' => __('Arrow Top', 'mfn-opts'),
						'arrow-bottom' => __('Arrow Bottom', 'mfn-opts'),
						'highlight' => __('Highlight', 'mfn-opts'),
						'hide' => __('HIDE Menu', 'mfn-opts'),
					),
					'std' => 'link-color',
				),

				array(
					'id' => 'menu-options',
					'type' => 'checkbox',
					'title' => __( 'Options', 'mfn-opts' ),
					'options' => array(
						'align-right' => __( 'Align Right', 'mfn-opts' ),
						'menu-arrows' => __( 'Arrows for Items with Submenu', 'mfn-opts' ),
						'hide-borders' => __( 'Hide Border between Items', 'mfn-opts' ),
						'submenu-active' => __( 'Submenu | Add active', 'mfn-opts' ),
						'last' => __( 'Submenu | Fold last 2 to the left<span>for Header Creative: fold to top</span>', 'mfn-opts' ),
					),
					'std' => array(
						'align-right' => 'align-right',
					),
				),

				// creative

				array(
					'title' => __('Header creative', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'menu-creative-options',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'scroll' => __('Scrollable <span>for menu with large amount of items <b>without submenus</b></span>', 'mfn-opts'),
						'dropdown' => __('Dropdown submenu <span>use <b>with</b> scrollable option</span>', 'mfn-opts'),
					),
				),

				// mega menu

				array(
					'title' => __('Mega menu', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'menu-mega-style',
					'type' => 'select',
					'title' => __('Style', 'mfn-opts'),
					'options'	=> array(
						''	 => __('Default', 'mfn-opts'),
						'vertical'	=> __('Vertical Lines', 'mfn-opts'),
					),
				),

			),
		);

		// menu & action bar | action bar -----

		$sections['action-bar'] = array(
			'title' => __('Action Bar', 'mfn-opts'),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'sub_desc' => __('Container located at the very top of the site', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'action-bar',
					'type' => 'checkbox',
					'title' => __('Action Bar', 'mfn-opts'),
					'options' => array(
						'show' => __('<b>Show</b> above the header<span>for most header styles</span>', 'mfn-opts'),
						'creative' => __('Creative Header <span>show at the bottom</span>', 'mfn-opts'),
						'side-slide' => __('Side Slide responsive menu <span>show at the bottom</span>', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper',
				),

				array(
					'id' => 'header-slogan',
					'type' => 'text',
					'title' => __('Slogan', 'mfn-opts'),
				),

				array(
					'id' => 'header-phone',
					'type' => 'text',
					'title' => __('Phone', 'mfn-opts'),
				),

				array(
					'id' => 'header-phone-2',
					'type' => 'text',
					'title' => __('2nd Phone', 'mfn-opts'),
				),

				array(
					'id' => 'header-email',
					'type' => 'text',
					'title' => __('Email', 'mfn-opts'),
				),

			),
		);

		// sidebars | general -----

		$sections['sidebars'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// sidebars

				array(
					'title' => __('Sidebars', 'mfn-opts'),
				),

				array(
					'id' => 'sidebars',
					'type' => 'multi_text',
					'title' => __('Sidebars', 'mfn-opts'),
					'desc' => __('Do <b>not</b> use <b> special characters</b> or the following names: <em>buddy, events, forum, shop</em>', 'mfn-opts'),
				),

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'sidebar-width',
					'type' => 'sliderbar',
					'title' => __('Width', 'mfn-opts'),
					'desc' => __('Recommended value: <b>20 - 30</b>. Too small or too large value may crash the layout', 'mfn-opts'),
					'param' => array(
						'min' => 10,
						'max' => 50,
					),
					'after' => '%',
					'std' => '23',
				),

				array(
					'id' => 'sidebar-style',
					'type' => 'switch',
					'title' => __('Style', 'mfn-opts'),
					'desc' => __('Classic sidebar has border and background', 'mfn-opts'),
					'options' => array(
						'classic' => __('Classic', 'mfn-opts'),
						'simple' => __('Simple', 'mfn-opts'),
					),
					'std' => 'simple',
				),

				array(
					'id' => 'sidebar-lines',
					'type' => 'switch',
					'title' => __('Lines', 'mfn-opts'),
					'options' => array(
						'lines-hidden' => __('Hide', 'mfn-opts'),
						'lines-boxed' => __('Show', 'mfn-opts'),
						'' => __('Full width', 'mfn-opts'),
					),
					'std' => 'lines-hidden',
				),

				array(
					'id' => 'sidebar-sticky',
					'type' => 'switch',
					'title' => __('Sticky', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				array(
					'id' => 'ofcs-global-icon',
					'type' => 'icon',
					'title' => __('Off-canvas sidebar icon', 'mfn-opts'),
					'std' => 'fas fa-indent'
				),

				// pages

				array(
					'title' => __('Pages', 'mfn-opts'),
					'sub_desc' => __('Force sidebar for <b>all pages</b>. This option can <b>not</b> be overwritten.', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'single-page-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'' => __('Use page options', 'mfn-opts'),
						'no-sidebar' => __('Full width', 'mfn-opts'),
						'left-sidebar' => __('Left sidebar', 'mfn-opts'),
						'right-sidebar' => __('Right sidebar', 'mfn-opts'),
						'both-sidebars' => __('Both sidebars', 'mfn-opts'),
						'offcanvas-sidebar' => __('Off-canvas sidebar', 'mfn-opts'),
					),
					'alias' => 'sidebar',
					'class' => 'form-content-full-width small re_render_to',
					're_render_if' => 'div|.page .sidebar',
				),

				array(
					'id' => 'single-page-sidebar',
					'type' => 'text',
					'title' => __('Sidebar', 'mfn-opts'),
					'desc' => __('Type the name of one of the sidebars added in the "Sidebars" section.', 'mfn-opts'),
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				array(
					'id' => 'single-page-sidebar2',
					'type' => 'text',
					'title' => __('Sidebar 2', 'mfn-opts'),
					'desc' => __('Type the name of one of the sidebars added in the "Sidebars" section.', 'mfn-opts'),
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				// posts

				array(
					'title' => __('Single posts', 'mfn-opts'),
					'sub_desc' => __('Force sidebar for <b>all posts</b>. This option can <b>not</b> be overwritten.', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'single-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'' => __('Use post options', 'mfn-opts'),
						'no-sidebar' => __('Full width', 'mfn-opts'),
						'left-sidebar' => __('Left sidebar', 'mfn-opts'),
						'right-sidebar' => __('Right sidebar', 'mfn-opts'),
						'both-sidebars' => __('Both sidebars', 'mfn-opts'),
						'offcanvas-sidebar' => __('Off-canvas sidebar', 'mfn-opts'),
					),
					'alias' => 'sidebar',
					'class' => 'form-content-full-width small re_render_to',
					're_render_if' => 'div|.single-post .sidebar',
				),

				array(
					'id' => 'single-sidebar',
					'type' => 'text',
					'title' => __('Sidebar', 'mfn-opts'),
					'desc' => __('Type the name of one of the sidebars added in the "Sidebars" section.', 'mfn-opts'),
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				array(
					'id' => 'single-sidebar2',
					'type' => 'text',
					'title' => __('Sidebar 2', 'mfn-opts'),
					'desc' => __('Type the name of one of the sidebars added in the "Sidebars" section.', 'mfn-opts'),
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				// single portfolio

				array(
					'title' => __('Single portfolio projects', 'mfn-opts'),
					'sub_desc' => __('Force sidebar for <b>all portfolio projects</b>. This option can <b>not</b> be overwritten.', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'single-portfolio-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'' => __('Use post options', 'mfn-opts'),
						'no-sidebar' => __('Full width', 'mfn-opts'),
						'left-sidebar' => __('Left sidebar', 'mfn-opts'),
						'right-sidebar' => __('Right sidebar', 'mfn-opts'),
						'both-sidebars' => __('Both sidebars', 'mfn-opts'),
						'offcanvas-sidebar' => __('Off-canvas sidebar', 'mfn-opts'),
					),
					'alias' => 'sidebar',
					'class' => 'form-content-full-width small re_render_to',
					're_render_if' => 'div|.single-portfolio .sidebar',
				),

				array(
					'id' => 'single-portfolio-sidebar',
					'type' => 'text',
					'title' => __('Sidebar', 'mfn-opts'),
					'desc' => __('Type the name of one of the sidebars added in the "Sidebars" section.', 'mfn-opts'),
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				array(
					'id' => 'single-portfolio-sidebar2',
					'type' => 'text',
					'title' => __('Sidebar 2', 'mfn-opts'),
					'desc' => __('Type the name of one of the sidebars added in the "Sidebars" section.', 'mfn-opts'),
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar',
				),

				// search

				array(
					'title' => __('Search page', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'search-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'no-sidebar' => __('Full width', 'mfn-opts'),
						'left-sidebar' => __('Left sidebar', 'mfn-opts'),
						'right-sidebar' => __('Right sidebar', 'mfn-opts'),
						'offcanvas-sidebar' => __('Off-canvas sidebar', 'mfn-opts'),
					),
					'alias' => 'sidebar',
					'class' => 'form-content-full-width small re_render_to',
					're_render_if' => 'div|.search-results .sidebar',
					'std' => 'no-sidebar',
				),

				array(
					'id' => 'search-sidebar-inherited-woo',
					'type' => 'switch',
					'title' => __('Inherited from shop', 'mfn-opts'),
					'desc' => __('For an online store, inherit the search page sidebar from the store', 'mfn-opts'),
					'options' => array(
						'' => __('Disabled', 'mfn-opts'),
						'1' => __('Enabled', 'mfn-opts'),
					),
					'std' => '',
				),

			),
		);

		// blog portfolio shop | general -----

		$sections['bps-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// blog & portfolio

				array(
					'title' => __('Blog & Portfolio', 'mfn-opts'),
				),

				array(
					'id' => 'pagination-show-all',
					'type' => 'switch',
					'title' => __('Pagination type', 'mfn-opts'),
					'options' => array(
						'0' => __('Shortened list', 'mfn-opts'),
						'1' => __('All pages', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.blog .pager .pages',
				),

				array(
					'id' => 'love',
					'type' => 'switch',
					'title' => __('Love Box', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.post-item',
				),

				// single post & single portfolio

				array(
					'title' => __('Single post & Single portfolio', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'featured-image-caption',
					'type' => 'switch',
					'title' => __('Featured Image caption', 'mfn-opts'),
					'desc' => __('Caption for <i>Featured Image</i> can be set in <a href="https://wordpress.org/support/article/media-library-screen/" target="_blank">Media Library</a>', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'hide-mobile' => __('Hide on Mobile', 'mfn-opts'),
						'' => __('Show', 'mfn-opts'),
					),
					'std' => '',
					'class' => 're_render_to',
					're_render_if' => 'div|.single-photo-wrapper',
				),

				array(
					'id' => 'related-style',
					'type' => 'switch',
					'title' => __('Related style', 'mfn-opts'),
					'options' => array(
						'' => __('Classic', 'mfn-opts'),
						'simple' => __('Simple', 'mfn-opts'),
					),
					'std' => 'simple',
				),

				array(
					'id' => 'title-heading',
					'type' => 'switch',
					'title' => __('Title tag', 'mfn-opts'),
					'options' => array(
						'1' => 'H1',
						'2' => 'H2',
						'3' => 'H3',
						'4' => 'H4',
						'5' => 'H5',
						'6' => 'H6',
					),
					'std' => '1'
				),

			),
		);

		// blog portfolio shop | blog -----

		$sections['blog'] = array(
			'title' => __('Blog', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'sub_desc' => __('<b>Images Sizes</b> used for specific <i>Layouts</i>, are listed under: <a href="#featured-image" target="_blank">Blog, Portfolio & Shop > Featured Image</a>', 'mfn-opts'),
				),

				array(
					'id' => 'blog-posts',
					'type' => 'text',
					'title' => __('Posts per page', 'mfn-opts'),
					'desc' => __('This is also the amount of posts on <i>Search</i> page', 'mfn-opts'),
					'after' => 'posts',
					'param' => 'number',
					'class' => 'narrow re_render_to',
					'std' => 9,
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'grid' => __('Grid<span>2-4 columns</span>', 'mfn-opts'),
						'classic' => __('Classic<span>1 column</span>', 'mfn-opts'),
						'masonry' => __('Masonry blog<span>2-4 columns</span>', 'mfn-opts'),
						'masonry tiles' => __('Masonry tiles<span>2-4 columns</span>', 'mfn-opts'),
						'photo' => __('Photo<span>1 column</span>', 'mfn-opts'),
						'photo2' => __('Photo 2<span>1-3 columns</span>', 'mfn-opts'),
						'timeline' => __('Timeline<span>1 column</span>', 'mfn-opts'),
					),
					'alias' => 'blog',
					'class' => 'form-content-full-width re_render_to',
					'std' => 'grid',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-columns',
					'type' => 'sliderbar',
					'title' => __('Columns', 'mfn-opts'),
					'desc' => __('for Layout: Grid, Masonry & Photo 2', 'mfn-opts'),
					'param' => array(
						'min' => 1,
						'max' => 6,
					),
					'std' => 3,
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-title-tag',
					'type' => 'select',
					'title' => __('Title tag', 'mfn-opts'),
					'options' => array(
						'2' => 'H2',
						'3' => 'H3',
						'4' => 'H4',
						'5' => 'H5',
						'6' => 'H6',
					),
					'std' => '4'
				),

				array(
					'id' => 'blog-images',
					'type' => 'select',
					'title' => __('Post image', 'mfn-opts'),
					'desc' => __('for all Layouts <b>except</b>: Masonry tiles & Photo 2', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'images-only' => __('Featured Images only (replace sliders and videos with featured image)', 'mfn-opts'),
					),
				),

				array(
					'id' => 'blog-full-width',
					'type' => 'switch',
					'title' => __('Full width', 'mfn-opts'),
					'desc' => __('for Layout: Masonry blog & Masonry tiles', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'blog-page',
					'type' => 'select',
					'title' => __('Blog page', 'mfn-opts'),
					'desc' => __('for <b>Front page displays: Your latest posts</b> being set in <a href="options-reading.php" target="_blank">Settings > Reading</a>', 'mfn-opts'),
					'options' => mfna_pages(),
					'js_options' => 'pages',
				),

				array(
					'id' => 'blog-orderby',
					'type' => 'select',
					'title' => __( 'Order by', 'mfn-opts' ),
					'desc' => __( 'Do <b>not</b> use <i>Random</i> order with <b>Pagination</b> & <b>Load more</b>', 'mfn-opts' ),
					'options' => array(
						'date'	 => __( 'Date', 'mfn-opts' ),
						'title'	 => __( 'Title', 'mfn-opts' ),
						'rand'	 => __( 'Random', 'mfn-opts' ),
					),
					'std' => 'date',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-order',
					'type' => 'select',
					'title' => __( 'Order', 'mfn-opts' ),
					'options' => array(
						'ASC' => __( 'Ascending', 'mfn-opts' ),
						'DESC'	=> __( 'Descending', 'mfn-opts' ),
					),
					'std' => 'DESC',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'exclude-category',
					'type' => 'text',
					'title' => __('Exclude category', 'mfn-opts'),
					'desc' => __('Category <b>slug</b>', 'mfn-opts'),
					'placeholder' => 'category-1, category-2',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'excerpt-length',
					'type' => 'text',
					'title' => __('Excerpt length', 'mfn-opts'),
					'after' => 'words',
					'param' => 'number',
					'class' => 'narrow re_render_to',
					're_render_if' => 'div|.posts_group',
					'std' => '26',
				),

				array(
					'id' => 'blog-meta',
					'type' => 'checkbox',
					'title' => __( 'Meta', 'mfn-opts' ),
					'options' => array(
						'author' => __( 'Author', 'mfn-opts' ),
						'date'	 => __( 'Date', 'mfn-opts' ),
						'categories'	=> __( 'Categories & Tags<span>for some Blog styles only</span>', 'mfn-opts' ),
					),
					'std' => array(
						'author' => 'author',
						'date' 	 => 'date',
						'categories' => 'categories',
					),
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-load-more',
					'type' => 'switch',
					'title' => __( 'Load more', 'mfn-opts' ),
					'desc' => __( '<b>Sliders</b> will be replaced with featured images on the list<br />Does <b>not</b> work with <i>jQuery filtering</i>', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-infinite-scroll',
					'type' => 'switch',
					'title' => __( 'Infinite scroll', 'mfn-opts' ),
					'desc' => __( 'Load posts from next page, when reach end of the page.<br />Does <b>not</b> work with <i>Load More button and jQuery Filtering.</i> <br />For best results, set <b>Posts per page</b> as a multiple of <b>Columns</b>.', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-filters',
					'type' => 'select',
					'title' => __( 'Filters', 'mfn-opts' ),
					'options' => array(
						'1' => __( 'Show', 'mfn-opts' ),
						'only-categories' => __( 'Show only Categories', 'mfn-opts' ),
						'only-tags' => __( 'Show only Tags', 'mfn-opts' ),
						'only-authors' => __( 'Show only Authors', 'mfn-opts' ),
						'0' => __( 'Hide', 'mfn-opts' ),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.posts_group',
				),

				array(
					'id' => 'blog-isotope',
					'type' => 'switch',
					'title' => __( 'jQuery filtering', 'mfn-opts' ),
					'desc' => __( 'Works best with all posts on single site, so please set <b>Posts per page</b> as large as possible.<br />Does <b>not</b> work with <i>Load More button</i>', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				// single post

				array(
					'title' => __('Single post', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'blog-title',
					'type' => 'switch',
					'title' => __('Title', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std'	=> '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-author',
					'type' => 'switch',
					'title' => __('Author box', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-comments',
					'type' => 'switch',
					'title' => __('Comments', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-featured-image-hide',
					'type' => 'switch',
					'title' => __('Featured image', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'' => __('Show', 'mfn-opts'),
					),
					'std' => '',
					'class' => 're_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-single-zoom',
					'type' => 'switch',
					'title' => __('Featured image click', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Open in lightbox', 'mfn-opts'),
					),
					'std' => '1',
				),

				array(
					'id' => 'blog-single-layout',
					'type' => 'text',
					'title' => __('Layout ID', 'mfn-opts'),
					'desc' => __('Custom layout for <b>all</b> single posts. For more details, please <a href="https://support.muffingroup.com/how-to/how-to-use-layouts/" target="_blank">read this article</a>', 'mfn-opts'),
					'class' => 'narrow re_render_to',
					'before' => 'ID',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-single-menu',
					'type' => 'select',
					'title' => __('Menu', 'mfn-opts'),
					'desc' => __('Does <b>not</b> work with Header <b>Split Menu</b>', 'mfn-opts'),
					'options'	=> mfna_menu(),
				),


				// related posts

				array(
					'title' => __('Related posts', 'mfn-opts'),
					'sub_desc' => __('at the bottom on Single posts', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'blog-related',
					'type' => 'text',
					'title' => __('Count', 'mfn-opts'),
					'desc' => __('Value defined in amount of posts<br />Type <b>0</b> <strong>to disable</strong> related posts', 'mfn-opts'),
					'std' => 3,
					'after' => 'posts',
					'class' => 'narrow re_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-related-columns',
					'type' => 'sliderbar',
					'title' => __('Columns', 'mfn-opts'),
					'desc' => __('Recommended: <b>2-4</b>. Too large value may crash the layout', 'mfn-opts'),
					'param' => array(
						'min' => 2,
						'max' => 6,
					),
					'std' => 3,
					'class' => 're_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				array(
					'id' => 'blog-related-images',
					'type' => 'select',
					'title' => __('Post image', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'images-only' => __('Featured Images only (replace sliders and videos with featured image)', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|.post.type-post',
				),

				// single advanced

				array(
					'title' => __('Intro header', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'single-intro-padding',
					'type' => 'text',
					'title' => __('Padding', 'mfn-opts'),
					'desc' => __('Use value with <b>px</b> or <b>em</b>', 'mfn-opts'),
					'placeholder' => '250px 10%',
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'blog-love-rand',
					'type' => 'ajax',
					'title' => __('Love count', 'mfn-opts'),
					'desc' => __('This option generate random amount of loves for posts', 'mfn-opts'),
					'action' => 'mfn_love_randomize',
				),

			),
		);

		// blog portfolio shop | portfolio -----

		$sections['portfolio'] = array(
			'title' => __('Portfolio', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'sub_desc' => __('<b>Images Sizes</b> used for specific <i>Layouts</i>, are listed under: <a href="#featured-image" target="_blank">Blog, Portfolio & Shop > Featured Image</a>', 'mfn-opts'),
				),

				array(
					'id' => 'portfolio-posts',
					'type' => 'text',
					'title' => __('Posts per page', 'mfn-opts'),
					'after' => 'posts',
					'param' => 'number',
					'class' => 'narrow re_render_to',
					're_render_if' => 'div|.portfolio_group',
					'std' => 9,
				),

				array(
					'id' => 'portfolio-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'grid' => __('Grid', 'mfn-opts'),
						'flat'=> __('Flat', 'mfn-opts'),
						'masonry'	=> __('Masonry blog style', 'mfn-opts'),
						'masonry-hover' => __('Masonry hover details', 'mfn-opts'),
						'masonry-minimal'	=> __('Masonry minimal', 'mfn-opts'),
						'masonry-flat' => __('Masonry flat<span>4 columns</span>', 'mfn-opts'),
						'list' => __('List<span>1 column</span>', 'mfn-opts'),
						'exposure' => __('Exposure<span>1 column</span>', 'mfn-opts'),
					),
					'alias' => 'portfolio',
					'class' => 'form-content-full-width re_render_to',
					're_render_if' => 'div|.portfolio_group',
					'std' => 'grid',
				),

				array(
					'id' => 'portfolio-columns',
					'type' => 'sliderbar',
					'title' => __('Columns', 'mfn-opts'),
					'desc' => __('for Layouts: <b>Flat</b>, <b>Grid</b>, <b>Masonry blog style</b> & <b>Masonry hover details</b>', 'mfn-opts'),
					'param' => array(
						'min' => 2,
						'max' => 6,
					),
					'std' => 3,
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-full-width',
					'type' => 'switch',
					'title' => __('Full width', 'mfn-opts'),
					'desc' => __('for Layouts: <b>Flat</b>, <b>Grid</b> & <b>Masonry</b>', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'portfolio-page',
					'type' => 'select',
					'title' => __('Portfolio page', 'mfn-opts'),
					'options' => mfna_pages(),
					'js_options' => 'pages',
				),

				array(
					'id' => 'portfolio-orderby',
					'type' => 'select',
					'title' => __( 'Order by', 'mfn-opts' ),
					'desc' => __( 'Do <b>not</b> use <i>Random</i> order with <b>Pagination</b> & <b>Load more</b>', 'mfn-opts' ),
					'options' => array(
						'date'	 => __( 'Date', 'mfn-opts' ),
						'menu_order' => __( 'Menu order', 'mfn-opts' ),
						'title'	 => __( 'Title', 'mfn-opts' ),
						'rand'	 => __( 'Random', 'mfn-opts' ),
					),
					'std' => 'date',
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-order',
					'type' => 'select',
					'title' => __( 'Order', 'mfn-opts' ),
					'options' => array(
						'ASC' => __( 'Ascending', 'mfn-opts' ),
						'DESC'	=> __( 'Descending', 'mfn-opts' ),
					),
					'std' => 'DESC',
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-external',
					'type' => 'select',
					'title' => __('Project link', 'mfn-opts'),
					'options' => array(
						''	 => __('Details', 'mfn-opts'),
						'popup' => __('Popup Image', 'mfn-opts'),
						'disable'	=> __('Disable Details | Only Popup Image', 'mfn-opts'),
						'_self' => __('Project Website | Open in the same window', 'mfn-opts'),
						'_blank'	=> __('Project Website | Open in new window', 'mfn-opts'),
					)
				),

				array(
					'id' => 'portfolio-hover-title',
					'type' => 'switch',
					'title' => __('Hover title', 'mfn-opts'),
					'desc' => __('For short post titles only. Does <b>not</b> work with <a href="admin.php?page=be-options#general">Image Frame style: Zoom</a>', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'portfolio-meta',
					'type' => 'checkbox',
					'title' => __( 'Meta', 'mfn-opts' ),
					'desc' => __( 'Most of these options affects single portfolio project only', 'mfn-opts' ),
					'options' => array(
						'author' => __( 'Author', 'mfn-opts' ),
						'date' => __( 'Date', 'mfn-opts' ),
						'categories' => __( 'Categories', 'mfn-opts' ),
					),
					'std' => array(
						'author' => 'author',
						'date' => 'date',
						'categories' => 'categories',
					),
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-load-more',
					'type' => 'switch',
					'title' => __( 'Load more', 'mfn-opts' ),
					'desc' => __( 'Display button instead of pagination<br />Does <b>not</b> work with <i>jQuery filtering</i>', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-infinite-scroll',
					'type' => 'switch',
					'title' => __( 'Infinite scroll', 'mfn-opts' ),
					'desc' => __( 'Load posts from next page, when reach end of the page.<br />Does <b>not</b> work with <i>Load More button and jQuery Filtering.</i> <br />For best results, set <b>Posts per page</b> as a multiple of <b>Columns</b>.', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-filters',
					'type' => 'select',
					'title' => __( 'Filters', 'mfn-opts' ),
					'options' => array(
							'1' 		 => __( 'Show', 'mfn-opts' ),
							'only-categories' => __( 'Show only Categories', 'mfn-opts' ),
							'0' 		 => __( 'Hide', 'mfn-opts' ),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|.portfolio_group',
				),

				array(
					'id' => 'portfolio-isotope',
					'type' => 'switch',
					'title' => __( 'jQuery filtering', 'mfn-opts' ),
					'desc' => __( 'Works best with all projects on single site, so please set <b>Posts per page</b> as large as possible<br />Does <b>not</b> work with <i>Load More button</i>', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1',
				),

				// single project

				array(
					'title' => __('Single portfolio project', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'portfolio-single-title',
					'type' => 'switch',
					'title' => __('Title', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
				),



				array(
					'id' => 'portfolio-featured-image-hide',
					'type' => 'switch',
					'title' => __('Featured image', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'' => __('Show', 'mfn-opts'),
					),
					'std' => '',
					'class' => 're_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
				),

				array(
					'id' => 'portfolio-related',
					'type' => 'text',
					'title' => __('Related projects count', 'mfn-opts'),
					'desc' => __('Type <b>0</b> <strong>to disable</strong> related portfolio projects', 'mfn-opts'),
					'after' => 'projects',
					'param' => 'number',
					'class' => 'narrow re_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
					'std' => 3,
				),

				array(
					'id' => 'portfolio-related-columns',
					'type' => 'sliderbar',
					'title' => __('Related projects columns', 'mfn-opts'),
					'param' => array(
						'min' => 2,
						'max' => 6,
					),
					'std' => 3,
					'class' => 're_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
				),

				array(
					'id' => 'portfolio-comments',
					'type' => 'switch',
					'title' => __('Comments', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
				),

				array(
					'id' => 'portfolio-single-layout',
					'type' => 'text',
					'title' => __('Layout ID', 'mfn-opts'),
					'desc' => __('Custom layout for <b>all</b> single portfolio projects. For more details, please <a href="https://support.muffingroup.com/how-to/how-to-use-layouts/" target="_blank">read this article</a>', 'mfn-opts'),
					'before' => 'ID',
					'class' => 'narrow re_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
				),

				array(
					'id' => 'portfolio-single-menu',
					'type' => 'select',
					'title' => __('Menu', 'mfn-opts'),
					'desc' => __('Does <b>not</b> work with Header <b>Split Menu</b>', 'mfn-opts'),
					'options'	=> mfna_menu(),
					'class' => 're_render_to',
					're_render_if' => 'div|.single-portfolio .portfolio.type-portfolio',
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'portfolio-love-rand',
					'type' => 'ajax',
					'title' => __('Love count', 'mfn-opts'),
					'desc' => __('This option generate random amount of loves for single portfolio projects', 'mfn-opts'),
					'action' => 'mfn_love_randomize',
					'param'	 => 'portfolio',
				),

				array(
					'id' => 'portfolio-slug',
					'type' => 'text',
					'title' => __('Single project slug', 'mfn-opts'),
					'desc' => __('Must be different from the Portfolio site title chosen above, eg. <b>portfolio-item</b>. After change go to <b><a href="options-permalink.php" target="_blank">Settings > Permalinks</a></b> and click <b>Save changes</b> to refresh permalinks.<br />Do <b>not</b> use characters prohibited for links', 'mfn-opts'),
					'std' => 'portfolio-item',
				),

				array(
					'id' => 'portfolio-tax',
					'type' => 'text',
					'title' => __('Category slug', 'mfn-opts'),
					'desc' => __('Must be different from the Portfolio site title chosen above, eg. <b>portfolio-types</b>. After change go to <b><a href="options-permalink.php" target="_blank">Settings > Permalinks</a></b> and click <b>Save changes</b> to refresh permalinks.<br />Do <b>not</b> use characters prohibited for links', 'mfn-opts'),
					'std' => 'portfolio-types',
				),

			),
		);

		// blog portfolio shop | featured image -----

		$sections['featured-image'] = array(
			'title' => __('Featured Image', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// responsive

				array(
					'title' => __('Responsive', 'mfn-opts'),
				),

				array(
					'id' => 'srcset-featured-image',
					'attr_id' => 'srcset-featured-image',
					'type' => 'switch',
					'title' => __('Srcset', 'mfn-opts'),
					'desc' => __('Add a srcset to images instead of using the sizes given below.<br />This option does not work with portfolio styles Flat & Masonry Flat.', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

				// force regenerate thumbnails -----

				array(
					'id' => 'info-force-regenerate',
					'type' => 'info',
					'title' => __('After making changes on this page please use <b>Force Regenerate Thumbnails</b> plugin.', 'mfn-opts'),
					'label' => __('Install plugin', 'mfn-opts'),
					'link' => 'admin.php?page=be-plugins',
					'condition' => array( 'id' => 'srcset-featured-image', 'opt' => 'is', 'val' => '0' ),
					'join' => true,
				),

				// archives

				array(
					'title' => __('Archives', 'mfn-opts'),
					'sub_desc' => __('Blog & Portfolio', 'mfn-opts'),
					'condition' => array( 'id' => 'srcset-featured-image', 'opt' => 'is', 'val' => '0' ),
				),

				array(
					'id' => 'featured-blog-portfolio-width',
					'type' => 'text',
					'title' => __('Width', 'mfn-opts'),
					'after' => 'px',
					'std' => '960',
				),

				array(
					'id' => 'featured-blog-portfolio-height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'after' => 'px',
					'std' => '750',
				),

				array(
					'id' => 'featured-blog-portfolio-crop',
					'type' => 'select',
					'title' => __('Crop', 'mfn-opts'),
					'options' => array(
						'crop' => __('Resize & Crop', 'mfn-opts'),
						'resize' => __('Resize', 'mfn-opts'),
					),
				),

				array(
					'id' => 'featured-desc-list',
					'type' => 'custom',
					'title' => 'Description',
					'desc' => '<ul><li><b>This size is being used for:</b></li><li>Blog: style Classic</li><li>Blog: style Grid</li><li>Blog: style Masonry</li><li>Blog: style Timeline</li><li>Blog: Related Posts</li><li>Portfolio: style Flat</li><li>Portfolio: style Grid</li><li>Portfolio: style Masonry Blog Style</li><li>Portfolio: Related Projects</li></ul><ul><li><b>Original images:</b></li><li>Blog: style Masonry Tiles</li><li>Post format: Vertical Image in all blog styles</li><li>Portfolio: style Exposure</li><li>Portfolio: style Masonry Hover Details</li><li>Portfolio: style Masonry Minimal</li></ul><ul><li><b>Different sizes:</b></li><li>Blog: style Photo - the same size as Single Post</li><li>Portfolio: style List - size: 1920x750</li><li>Portfolio: style Masonry Flat - default, big: 1280x1000, wide: 1280x500, tall: 768x1200</li></ul>',
					'action' => 'description',
					'class' => 'form-content-full-width',
				),

				// single

				array(
					'title' => __('Single', 'mfn-opts'),
					'sub_desc' => __('Blog & Portfolio', 'mfn-opts'),
					'condition' => array( 'id' => 'srcset-featured-image', 'opt' => 'is', 'val' => '0' ),
					'join' => true,
				),

				array(
					'id' => 'featured-single-width',
					'type' => 'text',
					'title' => __('Width', 'mfn-opts'),
					'after' => 'px',
					'std' => '1200',
				),

				array(
					'id' => 'featured-single-height',
					'type' => 'text',
					'title' => __('Height', 'mfn-opts'),
					'after' => 'px',
					'std' => '480',
				),

				array(
					'id' => 'featured-single-crop',
					'type' => 'select',
					'title' => __('Crop', 'mfn-opts'),
					'options' => array(
						'crop' => __('Resize & Crop', 'mfn-opts'),
						'resize' => __('Resize', 'mfn-opts'),
					),
				),

				array(
					'id' => 'featured-desc-single',
					'type' => 'custom',
					'title' => 'Description',
					'desc' => '<ul><li><b>This size is being used for:</b></li><li>Blog: single Post</li><li>Blog: style Photo</li><li>Portfolio: single Project</li></ul><ul><li><b>Original images:</b></li><li>Post format: Vertical Image</li><li>Template: Intro Header</li></ul>',
					'action' => 'description',
					'class' => 'form-content-full-width',
				),

			),
		);

		// shop | general -----

		$sections['shop'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				array(
					'id' => 'info-shop',
					'type' => 'info',
					'title' => __('Shop requires free <b>WooCommerce</b> plugin.', 'mfn-opts'),
					'label' => __('Install plugin', 'mfn-opts'),
					'link' => 'plugin-install.php?s=WooCommerce&tab=search&type=term',
					'php' => [
						'function' => 'is_woocommerce',
					],
				),

				// general

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'shop-sidebar',
					'type' => 'select',
					'title' => __('Sidebar', 'mfn-opts'),
					'options' => array(
						'' => __('All (Shop, Categories, Products)', 'mfn-opts'),
						'shop' => __('Shop & Categories', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-slider',
					'type' => 'select',
					'title' => __('Slider', 'mfn-opts'),
					'options' => array(
						'' => __('Main Shop Page', 'mfn-opts'),
						'all' => __('All (Shop, Categories, Products)', 'mfn-opts'),
					),
				),

				array(
					'id' => 'shop-catalogue',
					'type' => 'switch',
					'title' => __('Catalogue mode', 'mfn-opts'),
					'desc' => __('Removes all <b>Add to cart</b> buttons', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'variable-swatches',
					'type' => 'switch',
					'title' => __('Custom Variation Swatches', 'mfn-opts'),
					'desc' => __('Select, color, image & label', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-sidecart',
					'type' => 'switch',
					'title' => __('Side cart', 'mfn-opts'),
					'desc' => __('Display side cart module.', 'mfn-opts'),
					'options' => array(
						'' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '',
				),

				// badges

				array(
					'title' => __('Badges', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'product-badge-new',
					'attr_id' => 'product-badge-new',
					'type' => 'switch',
					'title' => __('New badge', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'product-badge-new-days',
					'type' => 'text',
					'condition' => array( 'id' => 'product-badge-new', 'opt' => 'is', 'val' => '1' ),
					'title' => __('New badge time limit', 'mfn-opts'),
					'std' => __('14', 'mfn-opts'),
					'after' => 'days',
					'param' => 'number',
					'class' => 'narrow',
				),

				array(
					'id' => 'product-badge-new-text',
					'type' => 'text',
					'condition' => array( 'id' => 'product-badge-new', 'opt' => 'is', 'val' => '1' ),
					'title' => __('New badge text', 'mfn-opts'),
					'std' => __('NEW', 'mfn-opts'),
					'class' => 'narrow',
				),

				array(
					'id' => 'sale-badge-style',
					'type' => 'switch',
					'title' => __('Sale badge style', 'mfn-opts'),
					'options' => array(
						'label' => __('Label', 'mfn-opts'),
						'percent' => __('Percent', 'mfn-opts'),
					),
					'std' => 'label',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-soldout',
					'type' => 'text',
					'title' => __('Sold out text', 'mfn-opts'),
					'std' => __('Sold out', 'mfn-opts'),
					'class' => 'narrow',
				),

				// header

				array(
					'title' => __('Header icons', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-icons-hide',
					'type' => 'checkbox',
					'title' => __('Show icons', 'mfn-opts'),
					'options' => array(
						'user' => __('User', 'mfn-opts'),
						'wishlist' => __('Wishlist', 'mfn-opts'),
						'cart' => __('Cart', 'mfn-opts'),
					),
					'invert' => true, // !!!
					'class' => 're_render_to',
					're_render_if' => 'div|div#Header_wrapper',
				),

				array(
					'id' => 'shop-user',
					'type' => 'icon',
					'title' => __('User icon', 'mfn-opts'),
					'desc' => __('For logged out user only. Logged in user uses Gravatar if available.', 'mfn-opts'),
				),

				array(
					'id' => 'shop-icon-wishlist',
					'type' => 'icon',
					'title' => __('Wishlist icon', 'mfn-opts'),
				),

				array(
					'id' => 'shop-cart',
					'type' => 'icon',
					'title' => __('Cart icon', 'mfn-opts'),
				),

				array(
					'id' => 'shop-cart-total-hide',
					'type' => 'checkbox',
					'title' => __('Cart total', 'mfn-opts'),
					'desc' => __('Show cart total next to cart icon', 'mfn-opts'),
					'options' => array(
						'desktop' => __('Desktop', 'mfn-opts'),
						'tablet' => __('Tablet', 'mfn-opts'),
						'mobile' => __('Mobile', 'mfn-opts'),
					),
					'invert' => true, // !!!
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-icon-count-if-zero',
					'type' => 'switch',
					'title' => __('Icon count if zero', 'mfn-opts'),
					'desc' => __('Show circle with count for wishlist and cart even if it`s zero', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				// wishlist

				array(
					'title' => __('Wishlist', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-wishlist',
					'attr_id' => 'shop-wishlist',
					'type' => 'switch',
					'title' => __('Wishlist', 'mfn-opts'),
					'desc' => __('Enable the wishlist option on Product and Shop pages.', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper',
				),

				array(
					'id' => 'shop-wishlist-page',
					'condition' => array( 'id' => 'shop-wishlist', 'opt' => 'is', 'val' => '1' ),
					'type' => 'select',
					'title' => __('Wishlist page', 'mfn-opts'),
					'desc' => __('Choose page to display wishlist products list. The page should have a default page template.', 'mfn-opts'),
					'options' => mfna_pages(),
					'js_options' => 'pages',
				),

				array(
					'id' => 'shop-wishlist-position',
					'condition' => array( 'id' => 'shop-wishlist', 'opt' => 'is', 'val' => '1' ),
					'type' => 'checkbox',
					'title' => __('Wishlist button', 'mfn-opts'),
					'options' => array(
						'0' => __('Next to cart button', 'mfn-opts'),
						'1' => __('On product image', 'mfn-opts'),
						'2' => __('In image frame', 'mfn-opts'),
					),
					'std' => array(
						'2' => '2',
					),
					'class' => 're_render_to',
					're_render_if' => 'div|div#Wrapper',
				),

				// mobile

				array(
					'title' => __('Mobile', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'sticky-shop-menu',
					'type' => 'switch',
					'title' => __('Sticky shop menu', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

			),
		);

		// shop | products list -----

		$sections['shop-list'] = array(
			'title' => __('Products list', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
				),

				array(
					'id' => 'shop-products',
					'type' => 'text',
					'title' => __('Products per page', 'mfn-opts'),
					'after' => 'products',
					'param' => 'number',
					'class' => 'narrow re_render_to',
					'std' => '12',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-layout',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'grid' => __('Grid<span>3 columns</span>', 'mfn-opts'),
						'grid col-4' => __('Grid<span>4 columns</span>', 'mfn-opts'),
						'masonry' => __('Masonry<span>3 columns</span>', 'mfn-opts'),
						'list' => __('List', 'mfn-opts'),
						'custom_tmpl' => __('Build your<br> own layout', 'mfn-opts'),
					),
					'alias' => 'shop',
					'class' => 'form-content-full-width shop-layout-visual-choose re_render_to',
					'std' => 'grid',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'mobile-products-row',
					'type' => 'switch',
					'title' => __('Mobile layout', 'mfn-opts'),
					'desc' => __('Number of columns per row', 'mfn-opts'),
					'options' => array(
						'1' => __('1', 'mfn-opts'),
						'2' => __('2', 'mfn-opts'),
					),
					'std' => '2',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-template',
					'type' => 'select',
					'title' => __( 'Template', 'mfn-opts' ),
					'desc' => __('Overrides style option', 'mfn-opts'),
					'options' => mfna_templates('shop-archive'),
				),

				// image

				array(
					'title' => __('Image', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-images',
					'type' => 'select',
					'title' => __( 'Images', 'mfn-opts' ),
					'options' => array(
						'' 	 => __( '- Default -', 'mfn-opts' ),
						'secondary'	=> __( 'Show secondary image on hover', 'mfn-opts' ),
						'plugin'	=> __( 'Use external plugin for featured images', 'mfn-opts' ),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-image-width',
					'type' => 'select',
					'title' => __( 'Image width', 'mfn-opts' ),
					'options' => [
						'800' => 'Default - 800px',
						'600' => 'Old - 600px',
					],
					'desc' => __('This option allows you to return to the old width of images.<br />Recommended if you have a lot of smaller-sized photos in your store.', 'mfn-opts'),
				),

				// content

				array(
					'title' => __('Content', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-align',
					'type' => 'switch',
					'title' => __('Alignment', 'mfn-opts'),
					'options' => array(
						'left' => __('Left', 'mfn-opts'),
						'' => __('Center', 'mfn-opts'),
						'right' => __('Right', 'mfn-opts'),
					),
				),

				array(
					'id' => 'shop-title-tag',
					'type' => 'switch',
					'title' => __('Title tag', 'mfn-opts'),
					'options' => [
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					],
					'std' => '',
				),

				array(
					'id' => 'shop-excerpt',
					'type' => 'switch',
					'title' => __('Description', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
						'list' => __('List layout only', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-button',
					'type' => 'switch',
					'title' => __('Add to cart button', 'mfn-opts'),
					'desc' => __('Required for some plugins', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
						'list' => __('List layout only', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-infinite-load',
					'type' => 'switch',
					'title' => __('Infinite Load', 'mfn-opts'),
					'options' => array(
						0 => __('Disabled', 'mfn-opts'),
						1 => __('Enabled', 'mfn-opts'),
					),
					'std' => 0,
				),

				array(
					'id' => 'shop-quick-view',
					'type' => 'switch',
					'title' => __('Quick view', 'mfn-opts'),
					'desc' => __('Product quick view popup', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				// filters

				array(
					'title' => __('Filters', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-list-active-filters',
					'type' => 'switch',
					'title' => __('Active filters', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-list-perpage',
					'type' => 'switch',
					'title' => __('Products per page', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-list-layout',
					'type' => 'switch',
					'title' => __('Layout switch', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-list-sorting',
					'type' => 'switch',
					'title' => __('List sorting', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

				array(
					'id' => 'shop-list-results-count',
					'type' => 'switch',
					'title' => __('Results count', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|div.default-woo-loop',
				),

			),
		);

		// shop | single -----

		$sections['shop-single'] = array(
			'title' => __('Single product', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
				),

				array(
					'id' => 'shop-product-style',
					'type' => 'radio_img',
					'title' => __('Style', 'mfn-opts'),
					'desc' => __('* Do not use with builder in product content', 'mfn-opts'),
					'options' => array(
						'default' => __('Default', 'mfn-opts'),
						'modern'	=> __('Modern<span>image width 1200px</span>', 'mfn-opts'),
						'wide' => __('Accordion<span>Below image</span>', 'mfn-opts'),
						'wide tabs'	=> __('Tabs<span>Below image</span>', 'mfn-opts'),
						'' => __('Accordion<span>Next to image *</span>', 'mfn-opts'),
						'tabs' => __('Tabs<span>Next to image *</span>', 'mfn-opts'),
						'custom_tmpl' => __('Built your <br>own layout', 'mfn-opts'),
					),
					'alias' => 'product',
					'class' => 'form-content-full-width product-layout-visual-choose re_render_to',
					're_render_if' => 'div|div.product.type-product',
					'std' => 'default'
				),

				array(
					'id' => 'shop-product-template',
					'type' => 'select',
					'title' => __('Template', 'mfn-opts'),
					'desc' => __('Overrides style option', 'mfn-opts'),
					'options' => mfna_templates('single-product'),
				),

				// image

				array(
					'title' => __('Image', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-single-image',
					'type' => 'switch',
					'title' => __('Main image', 'mfn-opts'),
					'desc' => __('Default style comes from <a href="admin.php?page=be-options#frame">Global > Image Frame</a>', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'disable-zoom' => __('Disable zoom effect', 'mfn-opts'),
					),
					're_render_if' => 'div|.woocommerce-product-gallery',
					'class' => 're_render_to',
					'std' => '',
				),

				array(
					'id' => 'shop-product-gallery',
					'attr_id' => 'shop-product-gallery',
					'type' => 'select',
					'title' => __('Gallery', 'mfn-opts'),
					'options' => array(
						'' => __('- Default -', 'mfn-opts'),
						'mfn-thumbnails-bottom mfn-bottom-left' => __('Thumbnails: Bottom Left', 'mfn-opts'),
						'mfn-thumbnails-bottom mfn-bottom-center' => __('Thumbnails: Bottom Center', 'mfn-opts'),
						'mfn-thumbnails-bottom mfn-bottom-right' => __('Thumbnails: Bottom Right', 'mfn-opts'),
						'mfn-thumbnails-left mfn-left-top' => __('Thumbnails: Left Top', 'mfn-opts'),
						'mfn-thumbnails-left mfn-left-center' => __('Thumbnails: Left Center', 'mfn-opts'),
						'mfn-thumbnails-left mfn-left-bottom' => __('Thumbnails: Left Bottom', 'mfn-opts'),
						'mfn-thumbnails-right mfn-right-top' => __('Thumbnails: Right Top', 'mfn-opts'),
						'mfn-thumbnails-right mfn-right-center' => __('Thumbnails: Right Center', 'mfn-opts'),
						'mfn-thumbnails-right mfn-right-bottom' => __('Thumbnails: Right Bottom', 'mfn-opts'),
						'mfn-gallery-grid' => __('Gallery grid', 'mfn-opts'),
					),
					're_render_if' => 'div|div.product.type-product',
					'class' => 're_render_to'
				),

				array(
					'id' => 'shop-product-gallery-overlay',
					'type' => 'switch',
					'condition' => array( 'id' => 'shop-product-gallery', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
					'title' => __('Thumbnails position', 'mfn-opts'),
					'options' => array(
						'mfn-thumbnails-outside' => __('Outside', 'mfn-opts'),
						'mfn-thumbnails-overlay' => __('Overlay', 'mfn-opts'),
					),
					'std' => 'mfn-thumbnails-outside',
					're_render_if' => 'div|div.product.type-product',
					'class' => 're_render_to'
				),

				array(
					'id' => 'shop-product-main-image-margin',
					'type' => 'select',
					'condition' => array( 'id' => 'shop-product-gallery', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
					'title' => __('Main image margin', 'mfn-opts'),
					'options' => array(
						'mfn-mim-0' => '0',
						'mfn-mim-2' => '2px',
						'mfn-mim-5' => '5px',
						'mfn-mim-10' => '10px',
						'mfn-mim-15' => '15px',
						'mfn-mim-20' => '20px',
						'mfn-mim-25' => '25px',
						'mfn-mim-30' => '30px',
					),
					'std' => 'mfn-mim-0',
					're_render_if' => 'div|div.product.type-product',
					'class' => 're_render_to'
				),

				array(
					'id' => 'shop-product-thumbnails-margin',
					'type' => 'text',
					'condition' => array( 'id' => 'shop-product-gallery', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
					'title' => __('Thumbnails margin', 'mfn-opts'),
					'param' => 'number',
					'after' => 'px',
					'class' => 'narrow',
					're_render_if' => 'div|div.product.type-product',
					'class' => 're_render_to'
				),

				array(
					'title' => __('Lightbox', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'product-lightbox-bg',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'alpha' => 'true',
				),

				array(
					'id' => 'product-lightbox-caption',
					'type' => 'switch',
					'title' => __('Caption', 'mfn-opts'),
					'options' => array(
						'off' => __('Disable', 'mfn-opts'),
						'' => __('Enable', 'mfn-opts'),
					),
					'std' => '',
				),

				// content

				array(
					'title' => __('Content', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'shop-product-title',
					'type' => 'switch',
					'title' => __('Show title in', 'mfn-opts'),
					'options' => array(
						'' => __('Content', 'mfn-opts'),
						'content-sub'	=> __('Content & Subheader', 'mfn-opts'),
						'sub'	 => __('Subheader', 'mfn-opts'),
					),
					'std' => '',
					'class' => 're_render_to',
					're_render_if' => 'div|div.product.type-product',
				),

				array(
					'id' => 'shop-hide-content',
					'type' => 'switch',
					'title' => __('The content', 'mfn-opts'),
					'desc' => __('The content from the WordPress editor', 'mfn-opts'),
					'options' => array(
						'1'	=> __('Hide', 'mfn-opts'),
						'' => __('Show', 'mfn-opts'),
					),
					'std' => '',
				),

				array(
					'id' => 'shop-product-cart-button-extra',
					'type' => 'switch',
					'title' => __('Cart button extra options', 'mfn-opts'),
					'desc' => __('Enable if you use any WooCommerce plugin which changes "Add to cart" button area', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1'	 => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'shop-related',
					'type' => 'text',
					'title' => __('Related products count', 'mfn-opts'),
					'desc' => __('Type <b>0</b> to disable related products', 'mfn-opts'),
					'after' => 'products',
					'param' => 'number',
					'class' => 'narrow re_render_to',
					'std' => 3,
					're_render_if' => 'div|div.product.type-product',
				),

			),
		);

		// pages | general -----

		$sections['pages-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// general

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'page-comments',
					'type' => 'switch',
					'title' => __('Page comments', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
				),

			),
		);

		// pages | 404 -----

		$sections['pages-404'] = array(
			'title' => __('Error 404', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// 404

				array(
					'title' => __('Error 404', 'mfn-opts'),
				),

				array(
					'id' => 'error404-icon',
					'type' => 'icon',
					'title' => __('Icon', 'mfn-opts'),
					'desc' => __('Icon on <i>Error 404 page</i>', 'mfn-opts'),
					'std' => 'icon-traffic-cone',
				),

				array(
					'id' => 'error404-page',
					'type' => 'select',
					'title' => __('Custom page', 'mfn-opts'),
					'desc' => __('Leave this field <b>blank</b> if you want to use default page.<br /><br /><b>Notice: </b>Page Options, header & footer are disabled. Plugins like <i>WPBakery Page Builder</i>, <i>Elementor</i> & <i>Gravity Forms</i> do <b>not</b> work with custom page.', 'mfn-opts'),
					'options' => mfna_pages(),
					'js_options' => 'pages',
				),

			),
		);

		// pages | under construction -----

		$sections['pages-under'] = array(
			'title' => __('Under Construction', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// under construction

				array(
					'title' => __('Under Construction', 'mfn-opts'),
				),

				array(
					'id' => 'construction',
					'type' => 'switch',
					'title' => __('Under Construction', 'mfn-opts'),
					'desc' => __('This page will be visible for <b>not logged</b> users', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

				array(
					'id' => 'construction-title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'std' => 'Coming Soon',
				),

				array(
					'id' => 'construction-text',
					'type' => 'textarea',
					'title' => __('Text', 'mfn-opts'),
				),

				array(
					'id' => 'construction-date',
					'type' => 'text',
					'title' => __('Launch date', 'mfn-opts'),
					'desc' => __('Format: <b>12/30/2018 12:00:00</b> [month/day/year hour:minute:second]<br />Leave this field <b>empty to hide</b> the counter', 'mfn-opts'),
					'std' => '12/30/2018 12:00:00',
				),

				array(
					'id' => 'construction-offset',
					'type' => 'select',
					'title' => __('UTC timezone', 'mfn-opts'),
					'options' => mfna_utc(),
					'std' => '0',
				),

				array(
					'id' => 'construction-contact',
					'type' => 'text',
					'title' => __('Contact Form shortcode', 'mfn-opts'),
					'desc' => __('<a href="https://contactform7.com/getting-started-with-contact-form-7/" target="_blank">Getting started with Contact Form 7</a>', 'mfn-opts'),
					'placeholder' => '[contact-form-7 id="000" title="Form"]',
				),

				array(
					'id' => 'construction-page',
					'type' => 'select',
					'title' => __('Custom page', 'mfn-opts'),
					'desc' => __('Leave this field <b>blank</b> if you want to use default page.<br /><br /><b>Notice: </b>Page Options, header & footer are disabled. Plugins like <i>WPBakery Page Builder</i>, <i>Elementor</i> & <i>Gravity Forms</i> do <b>not</b> work with custom page.', 'mfn-opts'),
					'options' => mfna_pages(),
					'js_options' => 'pages',
				),

			),
		);

		// footer | general -----

		$sections['footer'] = array(
			'title' => __('General', 'mfn-opts'),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
				),

				array(
					'id' => 'footer-layout',
					'type' => 'radio_img',
					'title' => __( 'Layout', 'mfn-opts' ),
					'options' => mfna_footer_style(),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'footer-style',
					'type' => 'select',
					'title' => __( 'Style', 'mfn-opts' ),
					'desc' => __( '<i>Sliding</i> style does <b>not</b> work with transparent content', 'mfn-opts' ),
					'options'	=> array(
						'' => __( '- Default -', 'mfn-opts' ),
						'fixed' => __( 'Fixed (covers content)', 'mfn-opts' ),
						'sliding' => __( 'Sliding (under content)', 'mfn-opts' ),
						'stick' => __( 'Stick to bottom if content is too short', 'mfn-opts' ),
						'hide' => __( 'HIDE Footer', 'mfn-opts' ),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Footer',
				),

				array(
					'id' => 'footer-padding',
					'type' => 'text',
					'title' => __('Padding', 'mfn-opts'),
					'desc' => __('Use value with <b>px</b> or <b>em</b>', 'mfn-opts'),
					'std' => '70px 0',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer .widgets_wrapper" data-responsive="desktop" data-style="padding" data-unit=""',
				),

				array(
					'id' => 'footer-options',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'full-width' => __('Full width<span>for Layout: Full width</span>', 'mfn-opts'),
					),
				),

				// background

				array(
					'title' => __('Background', 'mfn-opts'),
					'sub_desc' => __('Recommended image width: <b>1920px</b>', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' 	 => 'footer-bg-img',
					'type' => 'upload',
					'title' => __( 'Image', 'mfn-opts' ),
				),

				array(
					'id' => 'footer-bg-img-position',
					'type' => 'select',
					'title' => __('Position', 'mfn-opts'),
					'desc' => __('iOS does <b>not</b> support fixed position', 'mfn-opts'),
					'options' => mfna_bg_position(1),
					'std' => 'center top no-repeat',
				),

				array(
					'id' => 'footer-bg-img-size',
					'type' => 'select',
					'title' => __('Size', 'mfn-opts'),
					'desc' => __('Does <b>not</b> work with fixed position.', 'mfn-opts'),
					'options' => mfna_bg_size(),
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'footer-call-to-action',
					'type' => 'textarea',
					'title' => __( 'Call to action', 'mfn-opts' ),
					'desc' => __( 'This field accepts HTML & plain text. Content will display above the copyright & widgets.', 'mfn-opts' ),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'footer-copy',
					'type' => 'textarea',
					'title' => __( 'Copyright', 'mfn-opts' ),
					'desc' => __( 'This field accepts HTML & plain text. Leave this field empty to display default copyright.<br />Use <b>[year]</b> shortcode to show current year.', 'mfn-opts' ),
				),

				array(
					'id' => 'footer-hide',
					'type' => 'select',
					'title' => __('Copyright & Social bar', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'center' => __('Center', 'mfn-opts'),
						'1' => __('Hide Copyright & Social Bar', 'mfn-opts')
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Footer',
				),

				// extras

				array(
					'title' => __('Extras', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'back-top-top',
					'type' => 'select',
					'title' => __('Back to top', 'mfn-opts'),
					'desc' => __('Choose position for the Back to Top button', 'mfn-opts'),
					'options'	=> array(
						'' => __('Default | in Copyright area', 'mfn-opts'),
						'sticky' => __('Sticky', 'mfn-opts'),
						'sticky scroll'	=> __('Sticky show on scroll', 'mfn-opts'),
						'hide' => __('Hide', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Footer',
				),

				array(
					'id' => 'popup-contact-form',
					'type' => 'text',
					'title' => __('Popup Contact Form shortcode', 'mfn-opts'),
					'desc' => __('<a href="https://contactform7.com/getting-started-with-contact-form-7/" target="_blank">Getting started with Contact Form 7</a><br />Does <b>not</b> display on mobile devices < 768px', 'mfn-opts'),
					'placeholder' => '[contact-form-7 id="000" title="Form"]',
					'class' => 're_render_to',
					're_render_if' => 'div|#Footer',
				),

				array(
					'id' => 'popup-contact-form-icon',
					'type' => 'icon',
					'title' => __('Popup Contact Form icon', 'mfn-opts'),
					'std' => 'icon-mail-line',
				),

			),
		);

		// search -----

		$sections['search-form'] = array(
			'title' => __('Form', 'mfn-opts'),
			'fields' => array(

				// general

				array(
					'title' => __('Icon', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'header-search',
					'attr_id' => 'header-search',
					'type' => 'select',
					'title' => __('Search', 'mfn-opts'),
					'options' => array(
						'1' => __('Icon | Default', 'mfn-opts'),
						'shop' => __('Icon | Search Shop Products only', 'mfn-opts'),
						'input' => __('Search Field', 'mfn-opts'),
						'0' => __('Hide', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header',
				),

				array(
					'id' => 'header-search-input-width',
					'type' => 'text',
					'condition' => array( 'id' => 'header-search', 'opt' => 'is', 'val' => 'input' ), // is or isnt and value
					'title' => __('Input field width', 'mfn-opts'),
					'std' => '200',
					'param' => 'number',
					'class' => 'narrow',
					'after' => __('px', 'mfn-opts'),
				),

				// live search

				array(
					'title' => __('Live search', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'header-search-live',
					'attr_id' => 'header-search-live',
					'type' => 'switch',
					'title' => __('Live Search', 'mfn-opts'),
					'desc' => 'Does not work with <b>Creative</b> header',
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'header-search-live-min-characters',
					'type' => 'text',
					'condition' => array( 'id' => 'header-search-live', 'opt' => 'isnt', 'val' => '0' ), // is or isnt and value
					'title' => __('Minimal characters', 'mfn-opts'),
					'desc' => __('Minimal amount of characters in input to load posts', 'mfn-opts'),
					'std' => '3',
					'param' => 'number',
					'class' => 'narrow',
					'after' => __('characters', 'mfn-opts'),
				),

				array(
					'id' => 'header-search-live-load-posts',
					'type' => 'text',
					'condition' => array( 'id' => 'header-search-live', 'opt' => 'isnt', 'val' => '0' ), // is or isnt and value
					'title' => __('Number of posts', 'mfn-opts'),
					'desc' => __('Maximal amount of posts displayed in box', 'mfn-opts'),
					'std' => '10',
					'param' => 'number',
					'class' => 'narrow',
					'after' => __('posts', 'mfn-opts'),
				),

				array(
					'id' => 'header-search-live-container-height',
					'type' => 'text',
					'condition' => array( 'id' => 'header-search-live', 'opt' => 'isnt', 'val' => '0' ), // is or isnt and value
					'title' => __('Search results container height', 'mfn-opts'),
					'std' => '300',
					'param' => 'number',
					'class' => 'narrow',
					'after' => __('px', 'mfn-opts'),
				),

				array(
					'id' => 'header-search-live-featured_image',
					'type' => 'switch',
					'condition' => array( 'id' => 'header-search-live', 'opt' => 'isnt', 'val' => '0' ), // is or isnt and value
					'title' => __('Featured image', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				array(
					'id' => 'header-search-live-wpml_search_in_language',
					'type' => 'switch',
					'condition' => array( 'id' => 'header-search-live', 'opt' => 'isnt', 'val' => '0' ), // is or isnt and value
					'title' => __('Search in language', 'mfn-opts'),
					'options' => array(
						'0' => __('Main', 'mfn-opts'),
						'1' => __('Current', 'mfn-opts'),
					),
					'std' => '1',
				),

			),
		);

		// search | page

		$sections['search-page'] = array(
			'title' => __('Page', 'mfn-opts'),
			'fields' => array(

				array(
					'title' => __('Image', 'mfn-opts'),
				),

				array(
					'id' => 'search-page-featured',
					'attr_id' => 'search-page-featured',
					'type' => 'switch',
					'title' => __('Image', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				array(
					'id' => 'search-page-featured-position',
					'type' => 'switch',
					'title' => __('Position', 'mfn-opts'),
					'condition' => array( 'id' => 'search-page-featured', 'opt' => 'is', 'val' => '1' ), // is or isnt and value
					'options' => array(
						'left' => __('Left', 'mfn-opts'),
						'right' => __('Right', 'mfn-opts'),
					),
					'std' => 'left',
				),

				// content

				array(
					'title' => __('Content', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'search-page-author',
					'type' => 'switch',
					'title' => __('Author', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				array(
					'id' => 'search-page-date',
					'type' => 'switch',
					'title' => __('Publish date', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				array(
					'id' => 'search-page-excerpt',
					'type' => 'switch',
					'title' => __('Excerpt', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				// read more

				array(
					'title' => __('Read more', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'search-page-readmore',
					'attr_id' => 'search-page-readmore',
					'type' => 'switch',
					'title' => __('Read more', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '1',
				),

				array(
					'id' => 'search-page-readmore-aligment',
					'type' => 'switch',
					'title' => __('Aligment', 'mfn-opts'),
					'condition' => array( 'id' => 'search-page-readmore', 'opt' => 'is', 'val' => '1' ), // is or isnt and value
					'options' => array(
						'left' => __('Left', 'mfn-opts'),
						'center' => __('Center', 'mfn-opts'),
						'right' => __('Right', 'mfn-opts'),
					),
					'std' => 'right',
				),

				array(
					'id' => 'search-page-readmore-style',
					'type' => 'switch',
					'title' => __('Style', 'mfn-opts'),
					'condition' => array( 'id' => 'search-page-readmore', 'opt' => 'is', 'val' => '1' ), // is or isnt and value
					'options' => array(
						'button' => __('Button', 'mfn-opts'),
						'link' => __('Simple link', 'mfn-opts'),
					),
					'std' => 'link',
				),

				array(
					'id' => 'search-page-readmore-icon',
					'type' => 'icon',
					'title' => __('Icon', 'mfn-opts'),
					'condition' => array( 'id' => 'search-page-readmore', 'opt' => 'is', 'val' => '1' ), // is or isnt and value
				),
			),
		);

		// responsive | general -----

		$sections['responsive'] = array(
			'title' => __('General', 'mfn-opts'),
			'fields' => array(

				// general

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'responsive',
					'type' => 'switch',
					'title' => __('Responsive', 'mfn-opts'),
					'desc' => __('Responsive works with WordPress custom menu only, please add one in <a href="nav-menus.php" target="_blank">Appearance > Menus</a>.<br />Read more: <a href="https://codex.wordpress.org/WordPress_Menu_User_Guide" target="_blank">WordPress Menu User Guide</a>', 'mfn-opts'),
						'options' => array(
							'0' => __('Disable', 'mfn-opts'),
							'1' => __('Enable', 'mfn-opts'),
						),
					'std' => '1',
					'class' => 're_render_to',
					're_render_if' => 'div|#Wrapper'
				),

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'mobile-grid-width',
					'type' => 'sliderbar',
					'title' => __('Mobile site width', 'mfn-opts'),
					'desc' => __('for mobile with screen <b>< 768px</b>', 'mfn-opts'),
					'param' => array(
						'min' => 480,
						'max' => 700,
					),
					'after'	=> 'px',
					'std' => 480,
				),

				array(
					'id' => 'responsive-zoom',
					'type' => 'switch',
					'title' => __('Pinch to zoom', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'responsive-boxed2fw',
					'type' => 'switch',
					'title' => __('Layout', 'mfn-opts'),
					'desc' => __('for mobile with screen <b>< 768px</b>', 'mfn-opts'),
					'options' => array(
						'0' => __('Default', 'mfn-opts'),
						'1' => __('Force full width', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'no-section-bg',
					'type' => 'select',
					'class' => 'mfn-deprecated',
					'title' => __( 'Section background image', 'mfn-opts' ),
					'desc' => __('By default, backgrounds displays across all devices', 'mfn-opts'),
					'options' => array(
						'' => __( '- Default -', 'mfn-opts' ),
						'tablet' => __( 'Show on Desktop only', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'responsive-parallax',
					'type' => 'select',
					'class' => 'mfn-deprecated',
					'title' => __( 'Section parallax', 'mfn-opts' ),
					'desc' => __( 'Compatible with <a href="admin.php?page=be-options#addons&parallax">Translate3d</a> parallax only.<br />May run slowly on older devices', 'mfn-opts' ),
					'options' => array(
						0 => __( 'Disable on mobile', 'mfn-opts' ),
						1	=> __( 'Enable on mobile', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'responsive-video',
					'type' => 'select',
					'class' => 'mfn-deprecated',
					'title' => __( 'Section video', 'mfn-opts' ),
					'options' => array(
						0	=> __( 'Enable on mobile', 'mfn-opts' ),
						1 => __( 'Show on Desktop only', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'builder-section-padding',
					'type' => 'select',
					'class' => 'mfn-deprecated',
					'title' => __( 'Section horizontal padding', 'mfn-opts' ),
					'desc' => __( 'Choose where you want to have horizontal padding between <a href="https://support.muffingroup.com/documentation/sections/#sections" target="_blank">sections</a>', 'mfn-opts' ),
					'options' => array(
						'' => __( '- Default -', 'mfn-opts' ),
						'no-tablet' => __( 'Disable on tablet and mobile < 960px', 'mfn-opts' ),
						'no-mobile' => __( 'Disable on mobile < 768px', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'builder-wrap-moveup',
					'type' => 'select',
					'class' => 'mfn-deprecated',
					'title' => __( 'Wrap move up', 'mfn-opts' ),
					'desc' => __( 'Choose if you want to move up <a href="https://support.muffingroup.com/documentation/sections/#wraps" target="_blank">wraps</a> on mobile devices', 'mfn-opts' ),
					'options' => array(
						'' => __( '- Default -', 'mfn-opts' ),
						'no-tablet' => __( 'Disable on tablet and mobile < 960px', 'mfn-opts' ),
						'no-move' => __( 'Disable on mobile < 768px', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'footer-align',
					'type' => 'select',
					'title' => __( 'Footer text alignment', 'mfn-opts' ),
					'options' => array(
						'' => __( '- Default -', 'mfn-opts' ),
						'center' => __( 'Center', 'mfn-opts' ),
					),
				),

				array(
					'id' => 'mobile-sidebar',
					'type' => 'switch',
					'title' => __( 'Mobile sidebar', 'mfn-opts' ),
					'options' => array(
						'0' => __( 'Below content', 'mfn-opts' ),
						'1' => __( 'Off-canvas', 'mfn-opts' ),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|.sidebar'
				),

				// logo

				array(
					'title' => __('Logo', 'mfn-opts'),
					'sub_desc' => __('Displays on mobile devices with screen size <b>< 768px</b>', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'responsive-logo-img',
					'type' => 'upload',
					'title' => __( 'Logo', 'mfn-opts' ),
					'desc' => __( 'Use if you want different logo on mobile only', 'mfn-opts' ),
				),

				array(
					'id' => 'responsive-retina-logo-img',
					'type' => 'upload',
					'title' => __( 'Retina Logo', 'mfn-opts' ),
					'desc' => __( 'Retina Logo should be twice size as Logo', 'mfn-opts' ),
				),

				// sticky header logo

				array(
					'title' => __('Sticky header logo', 'mfn-opts'),
					'sub_desc' => __('Displays on mobile devices with screen size <b>< 768px</b>', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'responsive-sticky-logo-img',
					'type' => 'upload',
					'title' => __(' Logo', 'mfn-opts' ),
					'desc' => __( 'Use if you want different logo for Sticky Header on mobile only', 'mfn-opts' ),
				),

				array(
					'id' => 'responsive-sticky-retina-logo-img',
					'type' => 'upload',
					'title' => __( 'Retina Logo', 'mfn-opts' ),
					'desc' => __( 'Retina Logo should be twice size as Logo', 'mfn-opts' ),
				),

				// safari bar

				array(
					'title' => __('Safari bar', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'safari-bar-light-scheme',
					'type' => 'color',
					'title' => __( 'Light scheme background', 'mfn-opts' ),
					'std' => '#ffffff',
				),

				array(
					'id' => 'safari-bar-dark-scheme',
					'type' => 'color',
					'title' => __( 'Dark scheme background', 'mfn-opts' ),
					'std' => '#ffffff',
				),

			),
		);

		// responsive | header -----

		$sections['responsive-header'] = array(
			'title' => __( 'Header', 'mfn-opts' ),
			'fields' => array(

				// layout

				array(
					'title' => __('Layout', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
				  'id' => 'mobile-header-height',
				  'type' => 'text',
				  'title' => __('Header height', 'mfn-opts'),
					'sub_desc' => __('<b>< 768px</b>', 'mfn-opts'),
				  'desc' => __('Use if you want different height on mobile. This option does <b>not</b> work when Slider Revolution is active on page.', 'mfn-opts'),
				  'param' => 'number',
				  'after' => 'px',
				  'class' => 'narrow mhb-opt',
				),

				array(
				  'id' => 'mobile-subheader-padding',
				  'type' => 'text',
				  'title' => __('Subheader padding', 'mfn-opts'),
					'sub_desc' => __('<b>< 768px</b>', 'mfn-opts'),
				  'desc' => __('Use if you want different padding on mobile', 'mfn-opts'),
					'param' => 'number',
				  'after' => 'px',
					'class' => 'narrow',
				),

				// menu

				array(
					'title' => __('Menu', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'mobile-menu-initial',
					'type' => 'sliderbar',
					'title' => __( 'Menu breakpoint', 'mfn-opts' ),
					'desc' => __( 'Values <b>< 1240px</b> are for menu with a small amount of items. Values <b>< 950px</b> are not suitable for <i>Header Creative with Mega Menu</i>', 'mfn-opts' ),
					'param' => array(
						'min' => 768,
						'max' => 1240,
					),
					'std' => 1240,
					'after' => 'px',
				),

				array(
					'id' => 'responsive-mobile-menu',
					'attr_id' => 'responsive-mobile-menu',
					'type' => 'select',
					'title' => __( 'Style', 'mfn-opts' ),
					'desc' => __( '<b>Affects</b> <i>Header Simple</i> & <i>Empty</i> on desktop', 'mfn-opts' ),
					'options' => array(
						'side-slide' => __( 'Side slide', 'mfn-opts' ),
						'' => __( 'Classic', 'mfn-opts' ),
					),
					'std' => 'side-slide',
				),

				array(
					'id' => 'responsive-side-slide-width',
					'type' => 'sliderbar',
					'title' => __( 'Side slide width', 'mfn-opts' ),
					'condition' => array( 'id' => 'responsive-mobile-menu', 'opt' => 'is', 'val' => 'side-slide' ), // is or isnt and value
					'param' => array(
						'min' => 150,
						'max' => 500,
					),
					'std' => 250,
					'after' => 'px',
				),

				array(
					'id' => 'responsive-side-slide',
					'type' => 'checkbox',
					'title' => __('Side slide options', 'mfn-opts'),
					'condition' => array( 'id' => 'responsive-mobile-menu', 'opt' => 'is', 'val' => 'side-slide' ), // is or isnt and value
					'options' => array(
						'social' => __('Social icons', 'mfn-opts'),
					),
					'invert' => true, // !!!
				),

				array(
					'id' => 'header-menu-text',
					'type' => 'text',
					'title' => __('Menu button text', 'mfn-opts'),
					'desc' => __('This text will be used instead of the menu icon', 'mfn-opts'),
					'class' => 'narrow',
				),

				array(
					'id' => 'mobile-menu',
					'type' => 'select',
					'title' => __( 'Custom menu', 'mfn-opts' ),
					'desc' => __( 'Overrides all other menu select options', 'mfn-opts' ),
					'options'	=> mfna_menu(),
				),



				// mobile

				array(
					'title' => __('Mobile', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'responsive-header-minimal',
					'attr_id' => 'responsive-header-minimal',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'' => __('Default', 'mfn-opts'),
						'mr-ll' => __('Logo left | Menu right', 'mfn-opts'),
						'mr-lc' => __('Logo center | Menu right', 'mfn-opts'),
						'mr-lr' => __('Logo right | Menu right', 'mfn-opts'),
						'ml-ll' => __('Logo left | Menu left', 'mfn-opts'),
						'ml-lc' => __('Logo center | Menu left', 'mfn-opts'),
						'ml-lr' => __('Logo right | Menu left', 'mfn-opts'),
					),
					'alias' => 'responsive',
					'class' => 'form-content-full-width short re_render_to',
					'std' => '',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'responsive-top-bar',
					'type' => 'switch',
					'title' => __('Icons alignment', 'mfn-opts'),
					'condition' => array( 'id' => 'responsive-header-minimal', 'opt' => 'is', 'val' => '' ), // is or isnt and value
					'options' => array(
						'left' => __('Left', 'mfn-opts'),
						'center' => __('Center', 'mfn-opts'),
						'right' => __('Right', 'mfn-opts'),
					),
					'std' => 'center'
				),

				array(
					'id' => 'responsive-header-mobile',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'sticky' => __('Sticky<span>works with <b>Sticky Header</b> only</span>', 'mfn-opts'),
						'transparent'	=> __('Transparent', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'header-menu-mobile-sticky',
					'type' => 'switch',
					'title' => __( 'Sticky menu button', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				// mobile icons

				array(
					'title' => __('Mobile icons', 'mfn-opts'),
					'sub_desc' => __('Header icons position on mobile', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'mobile-icon-user',
					'type' => 'switch',
					'title' => __('User', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'tb' => __('Top bar', 'mfn-opts'),
						'ss' => __('Side slide', 'mfn-opts'),
						'' => __('Both', 'mfn-opts'),
					),
					'std' => 'ss',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'mobile-icon-wishlist',
					'type' => 'switch',
					'title' => __('Wishlist', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'tb' => __('Top bar', 'mfn-opts'),
						'ss' => __('Side slide', 'mfn-opts'),
						'' => __('Both', 'mfn-opts'),
					),
					'std' => 'ss',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'mobile-icon-cart',
					'type' => 'switch',
					'title' => __('Cart', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'tb' => __('Top bar', 'mfn-opts'),
						'ss' => __('Side slide', 'mfn-opts'),
						'' => __('Both', 'mfn-opts'),
					),
					'std' => '',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'mobile-icon-search',
					'type' => 'switch',
					'title' => __('Search', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'tb' => __('Top bar', 'mfn-opts'),
						'ss' => __('Side slide', 'mfn-opts'),
						'' => __('Both', 'mfn-opts'),
					),
					'std' => 'ss',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'mobile-icon-wpml',
					'type' => 'switch',
					'title' => __('WPML', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'tb' => __('Top bar', 'mfn-opts'),
						'ss' => __('Side slide', 'mfn-opts'),
						'' => __('Both', 'mfn-opts'),
					),
					'std' => 'ss',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				array(
					'id' => 'mobile-icon-action',
					'type' => 'switch',
					'title' => __('Action button', 'mfn-opts'),
					'desc' => __('Action button in Top bar is available only in Mobile layout: Default', 'mfn-opts'),
					'options' => array(
						'hide' => __('Hide', 'mfn-opts'),
						'tb' => __('Top bar', 'mfn-opts'),
						'ss' => __('Side slide', 'mfn-opts'),
						'' => __('Both', 'mfn-opts'),
					),
					'std' => 'ss',
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

				// tablet

				array(
					'title' => __('Tablet', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'responsive-header-tablet',
					'type' => 'checkbox',
					'title' => __('Options', 'mfn-opts'),
					'options' => array(
						'sticky' => __('Sticky', 'mfn-opts'),
					),
					'class' => 're_render_to',
					're_render_if' => 'div|#Header_wrapper'
				),

			),
		);

		// SEO | general -----

		$sections['seo'] = array(
			'title' => __( 'General', 'mfn-opts' ),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// google

				array(
					'title' => __('Google', 'mfn-opts'),
				),

				array(
					'id' => 'google-analytics',
					'type' => 'textarea',
					'title' => __( 'Google Analytics', 'mfn-opts' ),
					'desc' => __( 'Code will be included <b>before</b> the closing <b>&lt;/head&gt;</b> tag<br /><a href="https://support.muffingroup.com/faq/google-analytics-code-does-not-work/" target="_blank">Google Analytics code does not work?</a>', 'mfn-opts' ),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'facebook-pixel',
					'type' => 'textarea',
					'title' => __( 'Facebook Pixel', 'mfn-opts' ),
					'desc' => __( 'Code will be included <b>before</b> the closing <b>&lt;/head&gt;</b> tag<br /><a href="https://www.facebook.com/business/help/952192354843755?id=1205376682832142" target="_blank">Create and install a Facebook Pixel</a>', 'mfn-opts' ),
					'class' => 'form-content-full-width',
				),

				array(
					'id' => 'google-remarketing',
					'type' => 'textarea',
					'title' => __( 'Google Remarketing Tag', 'mfn-opts' ),
					'desc' => __( 'Code will be included <b>before</b> the closing <b>&lt;/body&gt;</b> tag<br /><a href="https://support.google.com/google-ads/answer/2476688?hl=en" target="_blank">Tag for your website for remarketing</a>', 'mfn-opts' ),
					'class' => 'form-content-full-width',
				),

				// seo fields

				array(
					'title' => __('SEO fields', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'mfn-seo',
					'type' => 'switch',
					'title' => __( 'Use built-in fields', 'mfn-opts' ),
					'desc' => __( '<b>Disable</b> if you want to use external SEO plugin like YOAST', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1'
				),

				array(
					'id' => 'meta-description',
					'type' => 'text',
					'title' => __( 'Meta description', 'mfn-opts' ),
					'std' => get_bloginfo( 'description' ),
				),

				array(
					'id' => 'meta-keywords',
					'type' => 'text',
					'title' => __( 'Meta keywords', 'mfn-opts' ),
				),

				array(
					'id' => 'mfn-seo-og-image',
					'type' => 'upload',
					'title' => __( 'Open Graph image', 'mfn-opts' ),
					'desc' => __( 'Facebook share image', 'mfn-opts' ),
				),

				array(
					'id' => 'seo-fb-app-id',
					'type' => 'text',
					'title' => __( 'Facebook App ID', 'mfn-opts' ),
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'mfn-seo-schema-type',
					'type' => 'switch',
					'title' => __( 'Schema Type', 'mfn-opts' ),
					'desc' => __( 'Add Schema Type to &lt;html&gt; tag', 'mfn-opts' ),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1'
				),

			),
		);

		// social | general -----

		$sections['social'] = array(
			'title' => __( 'General', 'mfn-opts' ),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// general

				array(
					'title' => __('General', 'mfn-opts'),
					'sub_desc' => __('Use absolute paths only, each link should start with <b>HTTPS</b> or <b>HTTP</b>', 'mfn-opts'),
				),

				array(
					'id' => 'social-attr',
					'type' => 'checkbox',
					'title' => __( 'Link attributes', 'mfn-opts' ),
					'options' => array(
						'blank'	=> 'target="_blank"',
						'nofollow' => 'rel="nofollow"',
					),
				),

				array(
					'id' => 'social-link',
					'type' => 'social',
					'title' => __('Social icons', 'mfn-opts'),
					'desc' => __('Drag & drop to change order', 'mfn-opts'),
					'class' => 'form-content-full-width re_render_to',
					're_render_if' => 'div|#Footer',
				),

				// custom

				array(
					'title' => __('Custom', 'mfn-opts'),
					'sub_desc' => __('To display <b>Custom Social Icon</b>, select <i>Icon</i> and type <i>Link</i> to the profile page', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'social-custom-icon',
					'type' => 'icon',
					'title' => __('Icon', 'mfn-opts'),
				),

				array(
					'id' => 'social-custom-link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
				),

				array(
					'id' => 'social-custom-title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'sub_desc' => __('Custom social icon title', 'mfn-opts'),
				),

				// create custom icon

				array(
					'title' => __('New icon', 'mfn-opts'),
					'join' => true,
					'sub_desc' => '<a href="#" class="custom-icon-add">+ Add new custom icon</a>',
					'class' => 'custom-icon-card',
				),

				array( // hidden field
					'id' => 'custom-icon-count',
					'title' => 'New fields amount',
					'desc' => 'Decides how many fields are displayed above',
					'type' => 'text',
				),

				// rss

				array(
					'title' => __('RSS', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'social-rss',
					'type' => 'switch',
					'title' => __('RSS', 'mfn-opts'),
					'desc' => __('Show the RSS icon', 'mfn-opts'),
					'options' => array(
						'0' => __('Hide', 'mfn-opts'),
						'1' => __('Show', 'mfn-opts'),
					),
					'std' => '0',
				),

			),
		);

		// addons plugins | addons

		$sections['addons'] = array(
			'title' => __('Addons', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields'	=> array(

				// contact form 7

				array(
					'title' => __('Contact Form 7', 'mfn-opts'),
				),

				array(
					'id' => 'cf7-error',
					'type' => 'select',
					'title' => __('Contact Form 7 form error', 'mfn-opts'),
					'options' => array(
						'' => __('Simple X icon', 'mfn-opts'),
						'message' => __('Full error message below field', 'mfn-opts'),
					),
				),

				// parallax

				array(
					'title' => __('Parallax', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'parallax',
					'type' => 'select',
					'title' => __('Parallax plugin', 'mfn-opts'),
					'options' => array(
						'translate3d' => __('Translate3d', 'mfn-opts'),
						'translate3d no-safari' => __('Translate3d | Enllax in Safari (in some cases may run smoother)', 'mfn-opts'),
						'enllax' => __('Enllax', 'mfn-opts'),
						'stellar' => __('Stellar | old', 'mfn-opts'),
					),
				),

				// lightbox

				array(
					'title' => __('Lightbox', 'mfn-opts'),
					'join' => true,
				),

				/**
				 * @since 17.8.3
				 * Option name 'prettyphoto-options' left only for backward compatibility
				 */
				array(
					'id' => 'prettyphoto-options',
					'type' => 'checkbox',
					'title' => __( 'Options', 'mfn-opts' ),
					'options' => array(
						'disable' => __( 'Disable<span>Disable Magnific Popup if you prefer to use external plugin</span>', 'mfn-opts' ),
						'disable-mobile' => __( 'Disable on mobile only', 'mfn-opts' ),
						'title' => __( 'Display image <b>alt</b> text as caption for lightbox image', 'mfn-opts' ),
					),
				),

				// addons

				array(
					'title' => __('Addons', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'sc-gallery-disable',
					'type' => 'switch',
					'title' => __('Gallery shortcode', 'mfn-opts'),
					'desc' => __('<b>Disable</b> if you want to use external gallery plugin or Jetpack', 'mfn-opts'),
					'options' => array(
						'1' => __('Disable', 'mfn-opts'),
						'0' => __('Enable', 'mfn-opts'),
					),
					'std' => '0'
				),

			),
		);

		// addons plugins | plugins

		$sections['plugins'] = array(
			'title' => __('Premium plugins', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				array(
					'id' => 'info-plugins',
					'type' => 'info',
					'title' => __('If you <b>purchased an extra license</b> from plugin author, you can <b>disable the bundled</b> option for plugins you have purchased to get <b>support from the plugin author</b> and <b>premium features</b>.', 'mfn-opts'),
				),

				// premium plugins

				array(
					'title' => __('Premium plugins', 'mfn-opts'),
				),

				array(
					'id' => 'plugin-rev',
					'type' => 'select',
					'title' => __('Slider Revolution', 'mfn-opts'),
					'options' => array(
						''	 => __('Bundled with the theme', 'mfn-opts'),
						'disable'	=> __('I purchased a licence to unlock premium features', 'mfn-opts'),
					),
				),

				array(
					'id' => 'plugin-visual',
					'type' => 'select',
					'title' => __('WPBakery Page Builder', 'mfn-opts'),
					'options' => array(
						''	 => __('Bundled with the theme', 'mfn-opts'),
						'disable'	=> __('I purchased a licence to unlock premium features', 'mfn-opts'),
					),
				),

				array(
					'id' => 'plugin-layer',
					'type' => 'select',
					'title' => __('Layer Slider', 'mfn-opts'),
					'options' => array(
						''	 => __('Bundled with the theme', 'mfn-opts'),
						'disable'	=> __('I purchased a licence to unlock premium features', 'mfn-opts'),
					),
				),

			),
		);

		// colors | general ----

		$sections['colors-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// skin

				array(
					'title' => __('Skin', 'mfn-opts'),
				),

				array(
					'id' => 'skin',
					'type' => 'select',
					'title' => __('Theme skin', 'mfn-opts'),
					'desc' => __('Custom colors can be used  with the <b>Custom Skin</b> only', 'mfn-opts'),
					'options' => mfna_skin(),
					'std' => 'custom',
					'class' => 're_render_to',
					're_render_if' => 'div|#Wrapper'
				),

				array(
					'id' => 'color-one',
					'type' => 'color',
					'title' => __('One Color', 'mfn-opts'),
					'desc' => __('for <b>One Color Skin</b> only', 'mfn-opts'),
					'std' => '#0095eb',
					'class' => 're_render_to',
					're_render_if' => 'div|#Wrapper'
				),

				// background

				array(
					'title' => __('Background', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-html',
					'type' => 'color',
					'title' => __('Body background', 'mfn-opts'),
					'desc' => __('for <b>Boxed Layout</b> only', 'mfn-opts'),
					'std' => '#FCFCFC',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="html" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'background-body',
					'type' => 'color',
					'title' => __('Content background', 'mfn-opts'),
					'std' => '#FCFCFC',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Wrapper,#Content, .mfn-popup .mfn-popup-content,.mfn-off-canvas-sidebar .mfn-off-canvas-content-wrapper,.mfn-cart-holder,.mfn-header-login, #Top_bar .search_wrapper, #Top_bar .top_bar_right .mfn-live-search-box, .column_livesearch .mfn-live-search-wrapper, .column_livesearch .mfn-live-search-box" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				// archives

				array(
					'title' => __('Archives', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-archives-post',
					'type' => 'color',
					'title' => __('Post background', 'mfn-opts'),
					'std' => '',
					'alpha' => 'true',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".grid .post-item, .masonry:not(.tiles) .post-item, .photo2 .post .post-desc-wrapper" data-std="transparent" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'background-archives-portfolio',
					'type' => 'color',
					'title' => __('Portfolio background', 'mfn-opts'),
					'std' => '',
					'alpha' => 'true',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".portfolio_group .portfolio-item .desc" data-std="transparent" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'background-archives-product',
					'type' => 'color',
					'title' => __('Product background', 'mfn-opts'),
					'std' => '',
					'alpha' => 'true',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".woocommerce ul.products li.product, .shop_slider .shop_slider_ul li .item_wrapper .desc" data-std="transparent" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

			),
		);

		// color | header -----

		$sections['colors-header'] = array(
			'title' => __( 'Header', 'mfn-opts' ),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// header

				array(
					'title' => __('Header', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'background-header',
					'type' => 'color',
					'title' => __( 'Header background', 'mfn-opts' ),
					'std' => '#13162f',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Header_wrapper, #Intro" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				// top bar

				array(
					'title' => __('Top bar', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'background-top-left',
					'type' => 'color',
					'title' => __('Top Bar Left background', 'mfn-opts'),
					'desc' => __('Additionally: <b>Mobile Header</b> & <b>Top Bar Background</b> for some Header Styles', 'mfn-opts'),
					'std' => '#ffffff',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Header .top_bar_left, .header-classic #Top_bar, .header-plain #Top_bar, .header-stack #Top_bar, .header-split #Top_bar, .header-shop #Top_bar, .header-shop-split #Top_bar, .header-fixed #Top_bar, .header-below #Top_bar, #Header_creative, #Top_bar #menu, .sticky-tb-color #Top_bar.is-sticky" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'background-top-middle',
					'type' => 'color',
					'title' => __('Top Bar Middle background', 'mfn-opts'),
					'desc' => __('for <b>Header Modern</b> only', 'mfn-opts'),
					'std' => '#e3e3e3',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Top_bar .top_bar_right:before" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'background-top-right',
					'type' => 'color',
					'title' => __('Top Bar Right background', 'mfn-opts'),
					'std' => '#f5f5f5',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Header .top_bar_right" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-top-right-a',
					'type' => 'color',
					'title' => __('Top Bar Right icon color', 'mfn-opts'),
					'std' => '#333333',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Top_bar .top_bar_right .top-bar-right-icon" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'border-top-bar',
					'type' => 'color',
					'title' => __('Top Bar border bottom', 'mfn-opts'),
					'std' => '',
					'alpha' => true,
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Top_bar" data-responsive="desktop" data-style="border-bottom-color" data-unit=""',
				),

				// subheader

				array(
					'title' => __('Subheader', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-subheader',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#f7f7f7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Subheader" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-subheader',
					'type' => 'color',
					'title' => __('Title color', 'mfn-opts'),
					'std' => '#161922',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Subheader, #Subheader .title, #Subheader ul.breadcrumbs li, #Subheader ul.breadcrumbs li a" data-responsive="desktop" data-style="color" data-unit=""',
				),

			),
		);

		// colors | menu -----

		$sections['colors-menu'] = array(
			'title' => __('Menu', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// menu

				array(
					'title' => __('Menu', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'color-menu-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#2a2b39',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Top_bar .menu > li > a, #Top_bar #menu ul li.submenu .menu-toggle" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-menu-a-active',
					'type' => 'color',
					'title' => __('Active Link color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Active Link border</b>', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Top_bar .menu > li.current-menu-item > a, #Top_bar .menu > li.current_page_item > a, #Top_bar .menu > li.current-menu-parent > a, #Top_bar .menu > li.current-page-parent > a, #Top_bar .menu > li.current-menu-ancestor > a, #Top_bar .menu > li.current-page-ancestor > a, #Top_bar .menu > li.current_page_ancestor > a, #Top_bar .menu > li.hover > a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-menu-a-active',
					'type' => 'color',
					'title' => __('Active Link background', 'mfn-opts'),
					'desc' => __('Additionally: <b>Header plain</b> style & <b>Highlight menu</b> style', 'mfn-opts'),
					'std' => '#F2F2F2',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".menu-highlight #Top_bar #menu > ul > li.current-menu-item > a, .menu-highlight #Top_bar #menu > ul > li.current_page_item > a, .menu-highlight #Top_bar #menu > ul > li.current-menu-parent > a, .menu-highlight #Top_bar #menu > ul > li.current-page-parent > a, .menu-highlight #Top_bar #menu > ul > li.current-menu-ancestor > a, .menu-highlight #Top_bar #menu > ul > li.current-page-ancestor > a, .menu-highlight #Top_bar #menu > ul > li.current_page_ancestor > a, .menu-highlight #Top_bar #menu > ul > li.hover > a" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				// submenu

				array(
					'title' => __('Submenu', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'background-submenu',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#F2F2F2',
				),

				array(
					'id' => 'color-submenu-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#5f5f5f',
				),

				array(
					'id' => 'color-submenu-a-hover',
					'type' => 'color',
					'title' => __('Hover Link color', 'mfn-opts'),
					'std' => '#2e2e2e',
				),

				// menu icon

				array(
					'title' => __('Menu icon', 'mfn-opts'),
					'sub_desc' => __('for Responsive & following Header styles: Creative, Simple & Empty', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'color-menu-responsive-icon',
					'type' => 'color',
					'title' => __('Icon color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".overlay-menu-toggle" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-menu-responsive-icon',
					'type' => 'color',
					'title' => __( 'Icon background', 'mfn-opts' ),
					'std' => '',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".overlay-menu-toggle" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				// style

				array(
					'title' => __('Style', 'mfn-opts'),
					'sub_desc' => __('for specific header styles only', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'background-overlay-menu',
					'type' => 'color',
					'title' => __('Overlay Menu<br />Menu background', 'mfn-opts'),
					'std' => '#0089F7',
				),

				array(
					'id' => 'background-overlay-menu-a',
					'type' => 'color',
					'title' => __('Overlay Menu<br />Link color', 'mfn-opts'),
					'std' => '#FFFFFF',
				),

				array(
					'id' => 'background-overlay-menu-a-active',
					'type' => 'color',
					'title' => __('Overlay Menu<br />Active Link color', 'mfn-opts'),
					'std' => '#B1DCFB',
				),

				array(
					'id' => 'border-menu-plain',
					'type' => 'color',
					'title' => __('Plain<br />Border color', 'mfn-opts'),
					'std' => '#F2F2F2',
					'alpha' => true,
				),

				// side slide

				array(
					'title' => __('Side slide', 'mfn-opts'),
					'sub_desc' => __('for Responsive menu style only', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'background-side-menu',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#191919',
				),

				array(
					'id' => 'color-side-menu-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#A6A6A6',
				),

				array(
					'id' => 'color-side-menu-a-hover',
					'type' => 'color',
					'title' => __( 'Active Link color', 'mfn-opts' ),
					'std' => '#FFFFFF',
				),

			),
		);

		// colors | action bar -----

		$sections['colors-action'] = array(
			'title' => __('Action Bar', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// desktop tablet

				array(
					'title' => __('Desktop & Tablet', 'mfn-opts'),
					'sub_desc' => __('for devices with screen width <b>> 768px</b>', 'mfn-opts'),
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'background-action-bar',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'desc' => __('for some Header Styles only', 'mfn-opts'),
					'std' => '#101015',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".header-classic #Action_bar, .header-fixed #Action_bar, .header-plain #Action_bar, .header-split #Action_bar, .header-shop #Action_bar, .header-shop-split #Action_bar, .header-stack #Action_bar" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-action-bar',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#bbbbbb',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .contact_details" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-action-bar-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#006edf',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .contact_details a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-action-bar-a-hover',
					'type' => 'color',
					'title' => __('Link hover color', 'mfn-opts'),
					'std' => '#0089f7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .contact_details a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-action-bar-social',
					'type' => 'color',
					'title' => __('Social Icon color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Social Menu link</b> color', 'mfn-opts'),
					'std' => '#bbbbbb',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .social li a, #Header_creative .social li a, #Action_bar:not(.creative) .social-menu a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-action-bar-social-hover',
					'type' => 'color',
					'title' => __('Social Icon hover color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Social Menu link</b> hover color', 'mfn-opts'),
					'std' => '#FFFFFF',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .social li a:hover, #Header_creative .social li a:hover, #Action_bar:not(.creative) .social-menu a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				// mobile

				array(
					'title' => __('Mobile', 'mfn-opts'),
					'sub_desc' => __('for devices with screen width <b>< 768px</b>', 'mfn-opts'),
					'join' => true,
					'class' => 'mhb-opt',
				),

				array(
					'id' => 'mobile-background-action-bar',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#FFFFFF',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar" data-responsive="mobile" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'mobile-color-action-bar',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#222222',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .contact_details" data-responsive="mobile" data-style="color" data-unit=""',
				),

				array(
					'id' => 'mobile-color-action-bar-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#006edf',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .contact_details a" data-responsive="mobile" data-style="color" data-unit=""',
				),

				array(
					'id' => 'mobile-color-action-bar-a-hover',
					'type' => 'color',
					'title' => __('Link hover color', 'mfn-opts'),
					'std' => '#0089f7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .contact_details a:hover" data-responsive="mobile" data-style="color" data-unit=""',
				),

				array(
					'id' => 'mobile-color-action-bar-social',
					'type' => 'color',
					'title' => __('Social Icon color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Social Menu link</b> color', 'mfn-opts'),
					'std' => '#bbbbbb',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .social li a, #Action_bar .social-menu a" data-responsive="mobile" data-style="color" data-unit=""',
				),

				array(
					'id' => 'mobile-color-action-bar-social-hover',
					'type' => 'color',
					'title' => __('Social Icon hover color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Social Menu link</b> hover color', 'mfn-opts'),
					'std' => '#777777',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Action_bar .social li a:hover, #Action_bar .social-menu a:hover" data-responsive="mobile" data-style="color" data-unit=""',
				),

			),
		);

		// colors | content -----

		$sections['content'] = array(
			'title' => __('Content', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// content

				array(
					'title' => __('Content', 'mfn-opts'),
				),

				array(
					'id' => 'color-theme',
					'type' => 'color',
					'title' => __('Theme color', 'mfn-opts'),
					'desc' => __('Highlighted button background, some icons and other small elements. To apply this color in content, use <b>.themecolor</b> or <b>.themebg</b> classes.', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 're_render_to',
					're_render_if' => 'div|#Content'
				),

				array(
					'id' => 'color-text',
					'type' => 'color',
					'title' => __( 'Text color', 'mfn-opts' ),
					'std' => '#626262',
					'class' => 're_render_to',
					're_render_if' => 'div|#Content'
				),

				array(
					'id' => 'color-selection',
					'type' => 'color',
					'title' => __( 'Selection color', 'mfn-opts' ),
					'std' => '#0089F7',
					'class' => 're_render_to',
					're_render_if' => 'div|#Content'
				),

				// link

				array(
					'title' => __('Link', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'color-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#006edf',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-a-hover',
					'type' => 'color',
					'title' => __('Link hover color', 'mfn-opts'),
					'std' => '#0089f7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-fancy-link',
					'type' => 'color',
					'title' => __('Fancy Link color', 'mfn-opts'),
					'desc' => __('for some link styles only', 'mfn-opts'),
					'std' => '#656B6F',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body a.mfn-link" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-fancy-link',
					'type' => 'color',
					'title' => __('Fancy Link background', 'mfn-opts'),
					'desc' => __('for some link styles only', 'mfn-opts'),
					'std' => '#006edf',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="a.mfn-link-2 span, a:hover.mfn-link-2 span:before, a.hover.mfn-link-2 span:before, a.mfn-link-5 span, a.mfn-link-8:after, a.mfn-link-8:before" data-responsive="desktop" data-style="background" data-unit=""',
				),

				array(
					'id' => 'color-fancy-link-hover',
					'type' => 'color',
					'title' => __('Fancy Link hover color', 'mfn-opts'),
					'desc' => __('for some link styles only', 'mfn-opts'),
					'std' => '#006edf',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body a:hover.mfn-link" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-fancy-link-hover',
					'type' => 'color',
					'title' => __('Fancy Link hover background', 'mfn-opts'),
					'desc' => __('for some link styles only', 'mfn-opts'),
					'std' => '#0089f7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="a.mfn-link-2 span:before, a:hover.mfn-link-4:before, a:hover.mfn-link-4:after, a.hover.mfn-link-4:before, a.hover.mfn-link-4:after, a.mfn-link-5:before, a.mfn-link-7:after, a.mfn-link-7:before" data-responsive="desktop" data-style="background" data-unit=""',
				),

				// inline shortcodes

				array(
					'title' => __('Inline shortcodes', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-highlight',
					'type' => 'color',
					'title' => __('Dropcap & Highlight background', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".highlight-left:after, .highlight-right:after" data-responsive="desktop" data-style="background" data-unit=""',
				),

				array(
					'id' => 'color-hr',
					'type' => 'color',
					'title' => __('Hr color', 'mfn-opts'),
					'desc' => __('Dots, ZigZag & Theme Color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 're_render_to',
					're_render_if' => 'div|hr'
				),

				array(
					'id' => 'color-list',
					'type' => 'color',
					'title' => __('List color', 'mfn-opts'),
					'desc' => __('Ordered, Unordered & Bullets List', 'mfn-opts'),
					'std' => '#737E86',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".column_column ul, .column_column ol" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-note',
					'type' => 'color',
					'title' => __('Note color', 'mfn-opts'),
					'desc' => __('eg. Blog meta, Filters, Widgets meta', 'mfn-opts'),
					'std' => '#a8a8a8',
					'class' => 're_render_to',
					're_render_if' => 'div|#Content'
				),

				// section

				array(
					'title' => __('Section', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-highlight-section',
					'type' => 'color',
					'title' => __('Highlight Section background', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".highlight-left:after, .highlight-right:after" data-responsive="desktop" data-style="background" data-unit=""',
				),

			),
		);

		// colors | shop -----

		$sections['colors-shop'] = array(
			'title' => __('Shop', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI .'img/icons/sub.png',
			'fields' => array(

				// single product

				array(
					'title' => __('Single product', 'mfn-opts'),
				),

				array(
					'id' => 'background-shop-single-image-icon',
					'type' => 'color_multi',
					'title' => __('Image icon background', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#ffffff',
						'hover' => '#ffffff',
					],
					'data_attr' => 'data-csspath=".woocommerce div.product div.images .woocommerce-product-gallery__trigger, .woocommerce div.product div.images .mfn-wish-button, .woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger, .woocommerce .mfn-product-gallery-grid .mfn-wish-button" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-shop-single-image-icon',
					'type' => 'color_multi',
					'title' => __('Image icon color', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#161922',
						'hover' => '#0089f7',
					],
					'data_attr' => 'data-csspath=".woocommerce div.product div.images .woocommerce-product-gallery__trigger:before,.woocommerce .mfn-product-gallery-grid .woocommerce-product-gallery__trigger:before" data-responsive="desktop" data-style="border-color" data-unit=""',
				),

				// wishlist

				array(
					'title' => __('Wishlist', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'color-wishlist',
					'type' => 'color_multi',
					'title' => __('Add to wishlist icon color', 'mfn-opts'),
					'class' => 'form-content-full-width re_render_to',
					'alpha' => true,
					'std' => [
						'normal' => 'rgba(0,0,0,.15)',
						'hover' => 'rgba(0,0,0,.3)',
					],
					're_render_if' => 'div|div.product div.images'
				),

			),
		);

		// colors | footer -----

		$sections['colors-footer'] = array(
			'title' => __('Footer', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI .'img/icons/sub.png',
			'fields' => array(

				// footer

				array(
					'title' => __('Footer', 'mfn-opts'),
				),

				array(
					'id' => 'color-footer-theme',
					'type' => 'color',
					'title' => __('Theme color', 'mfn-opts'),
					'desc' => __('Used for icons and other small elements.<br />To apply this color in footer content, use <b>.themecolor</b> or <b>.themebg</b> classes.', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer .themecolor, #Footer .widget_meta ul, #Footer .widget_pages ul, #Footer .widget_rss ul, #Footer .widget_mfn_recent_comments ul li:after, #Footer .widget_archive ul, #Footer .widget_recent_comments ul li:after, #Footer .widget_nav_menu ul, #Footer .widget_price_filter .price_label .from, #Footer .widget_price_filter .price_label .to, #Footer .star-rating span" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-footer',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#101015',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-footer',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#bababa',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer, #Footer .widget_recent_entries ul li a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-footer-heading',
					'type' => 'color',
					'title' => __('Heading color', 'mfn-opts'),
					'std' => '#ffffff',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer h1, #Footer h1 a, #Footer h1 a:hover, #Footer h2, #Footer h2 a, #Footer h2 a:hover, #Footer h3, #Footer h3 a, #Footer h3 a:hover, #Footer h4, #Footer h4 a, #Footer h4 a:hover, #Footer h5, #Footer h5 a, #Footer h5 a:hover, #Footer h6, #Footer h6 a, #Footer h6 a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-footer-note',
					'type' => 'color',
					'title' => __('Note color', 'mfn-opts'),
					'desc' => __('eg. Widget meta', 'mfn-opts'),
					'std' => '#a8a8a8',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer .Recent_posts ul li a .desc .date, #Footer .widget_recent_entries ul li .post-date, #Footer .tp_recent_tweets .twitter_time, #Footer .widget_price_filter .price_label, #Footer .shop-filters .woocommerce-result-count, #Footer ul.product_list_widget li .quantity, #Footer .widget_shopping_cart ul.product_list_widget li dl" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'border-copyright',
					'type' => 'color',
					'title' => __('Copyright border', 'mfn-opts'),
					'std' => 'rgba(255,255,255,0.1)',
					'alpha' => true,
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer .footer_copy" data-responsive="desktop" data-style="border-top-color" data-unit=""',
				),

				// link

				array(
					'title' => __('Link', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'color-footer-a',
					'type' => 'color',
					'title' => __('Link color', 'mfn-opts'),
					'std' => '#d1d1d1',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer a:not(.button):not(.icon_bar)" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-footer-a-hover',
					'type' => 'color',
					'title' => __('Link hover color', 'mfn-opts'),
					'std' => '#0089f7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer a:not(.button):not(.icon_bar):hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				// social

				array(
					'title' => __('Social', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'color-footer-social',
					'type' => 'color',
					'title' => __('Social Icon color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Social menu bottom</b> link color', 'mfn-opts'),
					'std' => '#65666C',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer .footer_copy .social li a, #Footer .footer_copy .social-menu a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-footer-social-hover',
					'type' => 'color',
					'title' => __('Social Icon hover color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Social menu bottom</b> link hover color', 'mfn-opts'),
					'std' => '#FFFFFF',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Footer .footer_copy .social li a:hover, #Footer .footer_copy .social-menu a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				// back to top

				array(
					'title' => __('Back to top', 'mfn-opts'),
					'sub_desc' => __('& popup contact form', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'color-footer-backtotop',
					'type' => 'color',
					'title' => __( 'Icon color', 'mfn-opts' ),
					'std' => '#65666C',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".footer_button" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-footer-backtotop',
					'type' => 'color',
					'title' => __( 'Icon background', 'mfn-opts' ),
					'std' => '',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".footer_button" data-responsive="desktop" data-style="background" data-unit=""',
				),

			),
		);

		// colors | sliding top -----

		$sections['colors-sliding-top'] = array(
			'title' => __('Sliding Top', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// sliding top

				array(
					'title' => __('Sliding top', 'mfn-opts'),
				),

				array(
					'id' => 'color-sliding-top-theme',
					'type' => 'color',
					'title' => __('Sliding Top Theme color', 'mfn-opts'),
					'desc' => __('Used for icons and other small elements.<br />To apply this color in Sliding Top content, use <b>.themecolor</b> or <b>.themebg</b> classes', 'mfn-opts'),
					'std' => '#0089F7'
				),

				array(
					'id' => 'background-sliding-top',
					'type' => 'color',
					'title' => __('Sliding Top background', 'mfn-opts'),
					'std' => '#545454',
				),

				array(
					'id' => 'color-sliding-top',
					'type' => 'color',
					'title' => __('Sliding Top Text color', 'mfn-opts'),
					'std' => '#cccccc',
				),

				array(
					'id' => 'color-sliding-top-a',
					'type' => 'color',
					'title' => __('Sliding Top Link color', 'mfn-opts'),
					'std' => '#006edf',
				),

				array(
					'id' => 'color-sliding-top-a-hover',
					'type' => 'color',
					'title' => __('Sliding Top Hover Link color', 'mfn-opts'),
					'std' => '#0089f7',
				),

				array(
					'id' => 'color-sliding-top-heading',
					'type' => 'color',
					'title' => __('Sliding Top Heading color', 'mfn-opts'),
					'std' => '#ffffff',
				),

				array(
					'id' => 'color-sliding-top-note',
					'type' => 'color',
					'title' => __('Sliding Top Note color', 'mfn-opts'),
					'desc' => __('eg. Widget meta', 'mfn-opts'),
					'std' => '#a8a8a8',
				),

			),
		);

		// colors | heading -----

		$sections['headings'] = array(
			'title' => __('Headings', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// heading

				array(
					'title' => __('Heading', 'mfn-opts'),
				),

				array(
					'id' => 'color-h1',
					'type' => 'color',
					'title' => __('Heading H1 color', 'mfn-opts'),
					'std' => '#161922',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h1, h1 a, h1 a:hover, .text-logo #logo" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-h2',
					'type' => 'color',
					'title' => __('Heading H2 color', 'mfn-opts'),
					'std' => '#161922',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h2, h2 a, h2 a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-h3',
					'type' => 'color',
					'title' => __('Heading H3 color', 'mfn-opts'),
					'std' => '#161922',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h3, h3 a, h3 a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-h4',
					'type' => 'color',
					'title' => __('Heading H4 color', 'mfn-opts'),
					'std' => '#161922',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h4, h4 a, h4 a:hover, .style-simple .sliding_box .desc_wrapper h4" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-h5',
					'type' => 'color',
					'title' => __('Heading H5 color', 'mfn-opts'),
					'std' => '#5f6271',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h5, h5 a, h5 a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-h6',
					'type' => 'color',
					'title' => __('Heading H6 color', 'mfn-opts'),
					'std' => '#161922',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h6, h6 a, h6 a:hover,a.content_link .title" data-responsive="desktop" data-style="color" data-unit=""'
				),

			),
		);

		// colors | shortcodes -----

		$sections['colors-shortcodes'] = array(
			'title' => __('Elements', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// shortcodes

				array(
					'title' => __('Elements', 'mfn-opts'),
				),

				array(
					'id' => 'color-tab',
					'type' => 'color',
					'title' => __('Accordion & Tabs Title color', 'mfn-opts'),
					'std' => '#444444',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".ui-tabs .ui-tabs-nav li a,.accordion .question > .title,.faq .question > .title,table th, .fake-tabs > ul li a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-tab-title',
					'type' => 'color',
					'title' => __('Accordion & Tabs Title active color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".ui-tabs .ui-tabs-nav li.ui-state-active a, .accordion .question.active > .title > .acc-icon-plus, .accordion .question.active > .title > .acc-icon-minus, .accordion .question.active > .title, .faq .question.active > .title > .acc-icon-plus, .faq .question.active > .title, .fake-tabs > ul li.active a" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-blockquote',
					'type' => 'color',
					'title' => __('Blockquote color', 'mfn-opts'),
					'std' => '#444444',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="blockquote, blockquote a, blockquote a:hover" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-getintouch',
					'type' => 'color',
					'title' => __('Contact Box background', 'mfn-opts'),
					'desc' => __('Additionally: <b>Infobox</b> background color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".mcb-item-contact_box-inner, .mcb-item-info_box-inner, .column_column .get_in_touch, .google-map-contact-wrapper" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-contentlink',
					'type' => 'color',
					'title' => __('Content Link Icon color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Content Link</b> hover border color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="a.content_link, a:hover.content_link" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-counter',
					'type' => 'color',
					'title' => __('Counter Icon color', 'mfn-opts'),
					'desc' => __('Additionally: <b>Chart Progress</b> color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".counter .icon_wrapper i" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-iconbar',
					'type' => 'color',
					'title' => __('Icon Bar Hover Icon color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="a:hover.icon_bar" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-iconbox',
					'type' => 'color',
					'title' => __('Icon Box Icon color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".icon_box .icon_wrapper, .icon_box a .icon_wrapper, .style-simple .icon_box:hover .icon_wrapper" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-list-icon',
					'type' => 'color',
					'title' => __('List & Feature List Icon color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".list_item.lists_1 .list_left, .list_item .list_left, .feature_list ul li .icon i" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'color-pricing-price',
					'type' => 'color',
					'title' => __('Pricing Box Price color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".pricing-box .plan-header .price sup.currency, .pricing-box .plan-header .price > span" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-pricing-featured',
					'type' => 'color',
					'title' => __('Pricing Box Featured background', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".pricing-box-box.pricing-box-featured" data-responsive="desktop" data-style="background" data-unit=""',
				),

				array(
					'id' => 'background-progressbar',
					'type' => 'color',
					'title' => __('Progress Bar background', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".progress_bars .bars_list li .bar .progress" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'color-quickfact-number',
					'type' => 'color',
					'title' => __('Quick Fact Number color', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".quick_fact .number-wrapper .number" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'background-slidingbox-title',
					'type' => 'color',
					'title' => __('Sliding Box Title background', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 're_render_to',
					're_render_if' => 'div|.column_sliding_box'
				),

				array(
					'id' => 'background-trailer-subtitle',
					'type' => 'color',
					'title' => __('Trailer Box Subtitle background', 'mfn-opts'),
					'std' => '#0089F7',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".trailer_box .desc .subtitle, .trailer_box.plain .desc .line" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

			),
		);

		// colors | alerts -----

		$sections['colors-alerts'] = array(
			'title' => __('Alerts', 'mfn-opts'),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// warning

				array(
					'title' => __('Warning', 'mfn-opts'),
				),

				array(
					'id' => 'background-alert-warning',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#fef8ea',
				),

				array(
					'id' => 'color-alert-warning',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#8a5b20',
				),

				// error

				array(
					'title' => __('Error', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-alert-error',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#fae9e8',
				),

				array(
					'id' => 'color-alert-error',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#962317',
				),

				// info

				array(
					'title' => __('Info', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-alert-info',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#efefef',
				),

				array(
					'id' => 'color-alert-info',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#57575b',
				),

				// success

				array(
					'title' => __('Success', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'background-alert-success',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#eaf8ef',
				),

				array(
					'id' => 'color-alert-success',
					'type' => 'color',
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#3a8b5b',
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'alert-border-radius',
					'type' => 'text',
					'title' => __('Border radius', 'mfn-opts'),
					'class' => 'narrow',
					'param' => 'number',
					'after' => 'px',
					'std' => '',
				),

			),
		);

		// color | forms -----

		$sections['colors-forms'] = array(
			'title' => __( 'Forms', 'mfn-opts' ),
			'icon' => MFN_OPTIONS_URI. 'img/icons/sub.png',
			'fields' => array(

				// input select textarea

				array(
					'title' => __('Input, select & textarea', 'mfn-opts'),
				),

				array(
					'id' => 'color-form',
					'type' => 'color',
					'title' => __( 'Text color', 'mfn-opts' ),
					'std' => '#626262',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

				array(
					'id' => 'background-form',
					'type' => 'color',
					'title' => __( 'Background', 'mfn-opts' ),
					'std' => '#FFFFFF',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

				array(
					'id' => 'border-form',
					'type' => 'color',
					'title' => __( 'Border color', 'mfn-opts' ),
					'std' => '#EBEBEB',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

				array(
					'id' => 'color-form-placeholder',
					'type' => 'color',
					'title' => __( 'Placeholder color', 'mfn-opts' ),
					'desc' => __( 'compatible with modern browsers only', 'mfn-opts' ),
					'std' => '#929292',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

				// focus

				array(
					'title' => __('Focus', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'color-form-focus',
					'type' => 'color',
					'title' => __( 'Text color', 'mfn-opts' ),
					'std' => '#0089F7',
				),

				array(
					'id' => 'background-form-focus',
					'type' => 'color',
					'title' => __( 'Background', 'mfn-opts' ),
					'std' => '#e9f5fc',
				),

				array(
					'id' => 'border-form-focus',
					'type' => 'color',
					'title' => __( 'Border color', 'mfn-opts' ),
					'std' => '#d5e5ee',
				),

				array(
					'id' => 'color-form-placeholder-focus',
					'type' => 'color',
					'title' => __( 'Placeholder color', 'mfn-opts' ),
					'desc' => __( 'compatible with modern browsers only', 'mfn-opts' ),
					'std' => '#929292',
				),

				// advanced

				array(
					'title' => __('Advanced', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'form-border-width',
					'type' => 'text',
					'title' => __( 'Border width', 'mfn-opts' ),
					'desc' => __( 'value in <b>px</b> only', 'mfn-opts' ),
					'placeholder' => '1px 1px 2px 1px',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

				array(
					'id' => 'form-border-radius',
					'type' => 'text',
					'title' => __( 'Border radius', 'mfn-opts' ),
					'desc' => __( 'value in <b>px</b> only', 'mfn-opts' ),
					'placeholder' => '20px',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

				array(
					'id' => 'form-transparent',
					'type' => 'sliderbar',
					'title' => __( 'Background transparency (alpha)', 'mfn-opts' ),
					'desc' => __( 'control background transparency from 1 to 100<br /><b>0</b> = transparent, <b>100</b> = solid', 'mfn-opts' ),
					'param' => array(
						'min' => 0,
						'max' => 100,
					),
					'std' => '100',
					'class' => 're_render_to',
					're_render_if' => 'div|div form'
				),

			),
		);

		// fonts | family -----

		$sections['font-family'] = array(
			'title' => __( 'Family', 'mfn-opts' ),
			'fields' => array(

				array(
					'id' => 'info-font-family-local',
					'type' => 'info',
					'title' => __('You chose to <b>Cache fonts local</b> in Performance tab.<br>Please <b>Regenerate fonts</b> every time you change anything in this tab.', 'mfn-opts'),
					'label' => __('Regenerate fonts', 'mfn-opts'),
					'condition' => array( 'id' => 'google-font-mode', 'opt' => 'is', 'val' => 'local' ), // is or isnt and value
					'link' => 'admin.php?page=be-tools',
				),

				// font family

				array(
					'title' => __('Font family', 'mfn-opts'),
				),

				array(
					'id' => 'font-content',
					'type' => 'font_select',
					'title' => __( 'Content', 'mfn-opts' ),
					'std' => 'Poppins',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body, button, span.date_label, .timeline_items li h3 span, textarea, select, .offer_li .title h3" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'font-menu',
					'type' => 'font_select',
					'title' => __( 'Main Menu', 'mfn-opts' ),
					'std' => 'Poppins',
					'class' => 'mhb-opt to-inline-style',
					'data_attr' => 'data-csspath="#menu > ul > li > a, a.action_button, #overlay-menu ul li a" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'font-title',
					'type' => 'font_select',
					'title' => __('Page Title', 'mfn-opts'),
					'std' => 'Poppins',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#Subheader .title" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'font-headings',
					'type' => 'font_select',
					'title' => __('Big Headings', 'mfn-opts'),
					'desc' => 'H1, H2, H3, H4',
					'std' => 'Poppins',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h1, h2, h3, h4, .text-logo #logo" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'font-headings-small',
					'type' => 'font_select',
					'title' => __('Small Headings', 'mfn-opts'),
					'desc' => 'H5, H6',
					'std' => 'Poppins',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="h5, h6" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'font-blockquote',
					'type' => 'font_select',
					'title' => __('Blockquote', 'mfn-opts'),
					'std' => 'Poppins',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body blockquote" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				array(
					'id' => 'font-decorative',
					'type' => 'font_select',
					'title' => __('Decorative', 'mfn-opts'),
					'desc' => __('Digits in some items, e.g. <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#chart" target="_blank">Chart</a>, <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#counter" target="_blank">Counter</a>, <a href="https://themes.muffingroup.com/be/theme/shortcodes/content-elements/#howitworks" target="_blank">How it Works</a>, <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#quickfact" target="_blank">Quick Fact</a>, <a href="https://themes.muffingroup.com/be/theme/product/flying-ninja/" target="_blank">Single Product Price</a>', 'mfn-opts'),
					'std' => 'Poppins',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath=".chart_box .chart .num, .counter .desc_wrapper .number-wrapper, .how_it_works .image .number, .pricing-box .plan-header .price, .quick_fact .number-wrapper, .woocommerce .product div.entry-summary .price" data-responsive="desktop" data-style="font-family" data-unit=""',
				),

				// google

				array(
					'title' => __('Google fonts', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'font-weight',
					'type' => 'checkbox',
					'title' => __('Weight & Style', 'mfn-opts'),
					'desc' => __('Some fonts in the Google Fonts Directory support multiple styles. For a complete list of available font subsets, please check <a href="https://www.google.com/webfonts" target="_blank">Google Web Fonts</a><br /><br /><b>Important!</b> The more styles you check, the slower site may load.', 'mfn-opts'),
					'options' => array(
						'100' => __( '100 Thin', 'mfn-opts' ),
						'100italic'	=> __( '100 Thin Italic', 'mfn-opts' ),
						'200' => __( '200 Extra-Light', 'mfn-opts' ),
						'200italic'	=> __( '200 Extra-Light Italic', 'mfn-opts' ),
						'300' => __( '300 Light', 'mfn-opts' ),
						'300italic'	=> __( '300 Light Italic', 'mfn-opts' ),
						'400' => __( '400 Regular', 'mfn-opts' ),
						'400italic'	=> __( '400 Regular Italic', 'mfn-opts' ),
						'500' => __( '500 Medium', 'mfn-opts' ),
						'500italic'	=> __( '500 Medium Italic', 'mfn-opts' ),
						'600' => __( '600 Semi-Bold', 'mfn-opts' ),
						'600italic'	=> __( '600 Semi-Bold Italic', 'mfn-opts' ),
						'700' => __( '700 Bold', 'mfn-opts' ),
						'700italic'	=> __( '700 Bold Italic', 'mfn-opts' ),
						'800' => __( '800 Extra-Bold', 'mfn-opts' ),
						'800italic'	=> __( '800 Extra-Bold Italic', 'mfn-opts' ),
						'900' => __( '900 Black', 'mfn-opts' ),
						'900italic'	=> __( '900 Black Italic', 'mfn-opts' ),
					),
					'class' => 'float-left',
					'std' => array(
						'300' => '300',
						'400' => '400',
						'400italic' => '400italic',
						'500' => '500',
						'600' => '600',
						'700' => '700',
						'700italic' => '700italic',
					),
				),

				array(
					'id' => 'font-subset',
					'type' => 'checkbox',
					'title' => __('Subset', 'mfn-opts'),
					'desc' => __('This option is used only for local fonts set in <a href="admin.php?page=be-options#performance-general&google-fonts">Performance tab</a>', 'mfn-opts'),
					'options' => array(
						'cyrylic' => __( 'Cyrylic', 'mfn-opts' ),
						'cyrylic-ext' => __( 'Cyrylic Extended', 'mfn-opts' ),
						'greek' => __( 'Greek', 'mfn-opts' ),
						'greek-ext' => __( 'Greek Extended', 'mfn-opts' ),
						'latin' => __( 'Latin', 'mfn-opts' ),
						'latin-ext' => __( 'Latin Extended', 'mfn-opts' ),
						'vietnamese' => __( 'Vietnamese', 'mfn-opts' ),
						'vietnamese-ext' => __( 'Vietnamese Extended', 'mfn-opts' ),
					),
					'std' => array(
						'latin' => 'latin',
						'latin-ext' => 'latin-ext',
					),
				),

			),
		);

		// font | size style -----

		$sections['font-size'] = array(
			'title' => __('Size & Style', 'mfn-opts'),
			'fields' => array(

				// google fonts -----

				array(
					'id' => 'info-force-regenerate',
					'type' => 'info',
					'title' => __('Some Google Fonts support multiple weights & styles. Include them in <a href="admin.php?page=be-options#font-family&google-fonts">Fonts > Family > Google Fonts Weight & Style</a>', 'mfn-opts'),
				),

				// general

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'font-size-responsive',
					'type' => 'switch',
					'title' => __('Auto font size', 'mfn-opts'),
					'desc' => __('Automatically decrease font size on mobile devices.<br />Disable to get access to advanced configuration', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1',
				),

				// content

				array(
					'title' => __('Content', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'font-size-content',
					'type' => 'typography',
					'title' => __( 'Content', 'mfn-opts' ),
					'std' => array(
						'size' => 15,
						'line_height' => 28,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="html body" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-content-tablet',
					'type' => 'typography',
					'title' => __( 'Content', 'mfn-opts' ),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="html body" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-content-mobile',
					'type' => 'typography',
					'title' => __( 'Content', 'mfn-opts' ),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="html body" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-big',
					'type' => 'typography',
					'title' => __('p.big', 'mfn-opts'),
					'std' => array(
						'size' => 17,
						'line_height' => 30,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body .big" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-big-tablet',
					'type' => 'typography',
					'title' => __('p.big', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body .big" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-big-mobile',
					'type' => 'typography',
					'title' => __('p.big', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body .big" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-menu',
					'type' => 'typography',
					'title' => __( 'Main menu', 'mfn-opts' ),
					'desc' => __( 'First level of main menu', 'mfn-opts' ),
					'disable' => 'line_height',
					'std' => array(
						'size' => 15,
						'line_height' => 0,
						'weight_style' => '500',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mhb-opt mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body #menu > ul > li > a, a.action_button, body #overlay-menu ul li a" data-responsive="desktop"',
				),


				array(
					'id' => 'font-size-menu-tablet',
					'type' => 'typography',
					'title' => __( 'Main menu', 'mfn-opts' ),
					'desc' => __( 'First level of main menu', 'mfn-opts' ),
					'disable' => 'line_height',
					'class' => 'form-content-full-width mhb-opt mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body #menu > ul > li > a, a.action_button, body #overlay-menu ul li a" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-menu-mobile',
					'type' => 'typography',
					'title' => __( 'Main menu', 'mfn-opts' ),
					'desc' => __( 'First level of main menu', 'mfn-opts' ),
					'disable' => 'line_height',
					'class' => 'form-content-full-width mhb-opt mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body #menu > ul > li > a, a.action_button, body #overlay-menu ul li a" data-responsive="mobile"',
				),

				// page title

				array(
					'title' => __('Page title', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'font-size-title',
					'type' => 'typography',
					'title' => __('Page title', 'mfn-opts'),
					'std' => array(
						'size' => 50,
						'line_height' => 60,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="#Subheader .title" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-title-tablet',
					'type' => 'typography',
					'title' => __('Page title', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="#Subheader .title" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-title-mobile',
					'type' => 'typography',
					'title' => __('Page title', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="#Subheader .title" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-single-intro',
					'type' => 'typography',
					'title' => __('Intro header', 'mfn-opts'),
					'std' => array(
						'size' => 70,
						'line_height' => 70,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="#Intro .intro-title" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-single-intro-tablet',
					'type' => 'typography',
					'title' => __('Intro header', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="#Intro .intro-title" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-single-intro-mobile',
					'type' => 'typography',
					'title' => __('Intro header', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="#Intro .intro-title" data-responsive="mobile"',
				),

				// heading

				array(
					'title' => __('Heading', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'font-size-h1',
					'type' => 'typography',
					'title' => __('H1', 'mfn-opts'),
					'std' => array(
						'size' => 50,
						'line_height' => 60,
						'weight_style' => '500',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body h1" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-h1-tablet',
					'type' => 'typography',
					'title' => __('H1', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body h1" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-h1-mobile',
					'type' => 'typography',
					'title' => __('H1', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body h1" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-h2',
					'type' => 'typography',
					'title' => __('H2', 'mfn-opts'),
					'std' => array(
						'size' => 40,
						'line_height' => 50,
						'weight_style' => '500',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body h2" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-h2-tablet',
					'type' => 'typography',
					'title' => __('H2', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body h2" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-h2-mobile',
					'type' => 'typography',
					'title' => __('H2', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body h2" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-h3',
					'type' => 'typography',
					'title' => __('H3', 'mfn-opts'),
					'std' => array(
						'size' => 30,
						'line_height' => 40,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body h3" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-h3-tablet',
					'type' => 'typography',
					'title' => __('H3', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body h3" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-h3-mobile',
					'type' => 'typography',
					'title' => __('H3', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body h3" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-h4',
					'type' => 'typography',
					'title' => __('H4', 'mfn-opts'),
					'std' => array(
						'size' => 20,
						'line_height' => 30,
						'weight_style' => '600',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body h4" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-h4-tablet',
					'type' => 'typography',
					'title' => __('H4', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body h4" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-h4-mobile',
					'type' => 'typography',
					'title' => __('H4', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body h4" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-h5',
					'type' => 'typography',
					'title' => __('H5', 'mfn-opts'),
					'std' => array(
						'size' => 18,
						'line_height' => 30,
						'weight_style' => '400',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body h5" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-h5-tablet',
					'type' => 'typography',
					'title' => __('H5', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body h5" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-h5-mobile',
					'type' => 'typography',
					'title' => __('H5', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body h5" data-responsive="mobile"',
				),

				array(
					'id' => 'font-size-h6',
					'type' => 'typography',
					'title' => __('H6', 'mfn-opts'),
					'std' => array(
						'size' => 15,
						'line_height' => 26,
						'weight_style' => '700',
						'letter_spacing' => 0,
					),
					'class' => 'form-content-full-width mfn_field_desktop to-inline-style',
					'responsive' => 'desktop',
					'data_attr' => 'data-csspath="body h6" data-responsive="desktop"',
				),

				array(
					'id' => 'font-size-h6-tablet',
					'type' => 'typography',
					'title' => __('H6', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_tablet to-inline-style',
					'responsive' => 'tablet',
					'data_attr' => 'data-csspath="body h6" data-responsive="tablet"',
				),

				array(
					'id' => 'font-size-h6-mobile',
					'type' => 'typography',
					'title' => __('H6', 'mfn-opts'),
					'class' => 'form-content-full-width mfn_field_mobile to-inline-style',
					'responsive' => 'mobile',
					'data_attr' => 'data-csspath="body h6" data-responsive="mobile"',
				),
			),
		);

		// fonts | custom -----

		$sections['font-custom'] = array(
			'title' => __( 'Custom', 'mfn-opts' ),
			'fields' => array(

				array(
					'id' => 'info-fonts',
					'type' => 'info',
					'title' => __( 'Use below fields if you want to use webfonts directly from your server.', 'mfn-opts' ),
					'label' => __( 'More info', 'mfn-opts' ),
					'link' => 'https://support.muffingroup.com/how-to/how-to-add-custom-fonts/',
				),

				// font 1

				array(
					'title' => __('Font 1', 'mfn-opts'),
				),

				array(
					'id' => 'font-custom',
					'type' => 'text',
					'title'	=> __( 'Name', 'mfn-opts' ),
					'desc' => __( 'Name for Custom Font uploaded below.<br />Font will show on fonts list after <b>click the Save Changes</b> button.' , 'mfn-opts' ),
				),

				array(
					'id' => 'font-custom-woff',
					'type' => 'upload',
					'title' => __( '.woff', 'mfn-opts'),
					'desc' => __( 'WordPress 5.0 blocks .woff upload. Please use <a target="_blank" href="plugin-install.php?s=Disable+Real+MIME+Check&tab=search&type=term">Disable Real MIME Check</a> plugin.', 'mfn-opts' ),
					'data' => 'font',
				),

				array(
					'id' => 'font-custom-ttf',
					'type' => 'upload',
					'title' => __( '.ttf', 'mfn-opts' ),
					'desc' => __( 'WordPress 5.0 blocks .ttf upload. Please use <a target="_blank" href="plugin-install.php?s=Disable+Real+MIME+Check&tab=search&type=term">Disable Real MIME Check</a> plugin.', 'mfn-opts' ),
					'data' => 'font',
				),

				// font 2

				array(
					'title' => __('Font 2', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'font-custom2',
					'type' => 'text',
					'title' => __('Name', 'mfn-opts'),
					'desc' => __( 'Name for Custom Font uploaded below.<br />Font will show on fonts list after <b>click the Save Changes</b> button.' , 'mfn-opts' ),
				),

				array(
					'id' => 'font-custom2-woff',
					'type' => 'upload',
					'title' => __('.woff', 'mfn-opts'),
					'desc' => __( 'WordPress 5.0 blocks .woff upload. Please use <a target="_blank" href="plugin-install.php?s=Disable+Real+MIME+Check&tab=search&type=term">Disable Real MIME Check</a> plugin.', 'mfn-opts' ),
					'data' => 'font',
				),

				array(
					'id' => 'font-custom2-ttf',
					'type' => 'upload',
					'title' => __( '.ttf', 'mfn-opts' ),
					'desc' => __( 'WordPress 5.0 blocks .ttf upload. Please use <a target="_blank" href="plugin-install.php?s=Disable+Real+MIME+Check&tab=search&type=term">Disable Real MIME Check</a> plugin.', 'mfn-opts' ),
					'data' => 'font',
				),

				// create font

				array(
					'title' => __('New font', 'mfn-opts'),
					'join' => true,
					'sub_desc' => '<a href="#">+ Add new font</a>',
					'class' => 'mfn_new_font',
				),

				array( // hidden field
					'id' => 'font-custom-fields',
					'title' => 'New fields amount',
					'desc' => 'Decides how many fields are displayed above',
					'type' => 'text',
				),

			),
		);

		// translate | general -----

		$sections['translate-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'fields' => array(

				array(
					'id' => 'info-translate',
					'type' => 'info',
					'title' => __('The fields below, must be <b>filled out</b> if you are using <b>WPML String Translation</b>.<br />If you already use <b>English</b> language, you can use this tab to <b>change some texts</b></span>.', 'mfn-opts'),
				),

				// General

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'translate',
					'type' => 'switch',
					'title' => __('Translate', 'mfn-opts'),
					'desc' => __('<b>Disable</b> if you want to use <b><a href="https://wplang.org/translate-theme-plugin/" target="_blank">.mo / .po files</a></b> for more complex translation', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '1'
				),

				array(
					'id' => 'translate-home',
					'type' => 'text',
					'title' => __('Home', 'mfn-opts'),
					'desc' => __('Breadcrumbs', 'mfn-opts'),
					'std' => 'Home',
				),

				array(
					'id' => 'translate-prev',
					'type' => 'text',
					'title' => __('Prev page', 'mfn-opts'),
					'desc' => __('Pagination', 'mfn-opts'),
					'std' => 'Prev page',
				),

				array(
					'id' => 'translate-next',
					'type' => 'text',
					'title' => __('Next page', 'mfn-opts'),
					'desc' => __('Pagination', 'mfn-opts'),
					'std' => 'Next page',
				),

				array(
					'id' => 'translate-load-more',
					'type' => 'text',
					'title' => __('Load more', 'mfn-opts'),
					'desc' => __('Pagination', 'mfn-opts'),
					'std' => 'Load more',
				),

				array(
					'id' => 'translate-wpml-no',
					'type' => 'text',
					'title' => __('No translations available for this page', 'mfn-opts'),
					'desc' => __('WPML Languages Menu', 'mfn-opts'),
					'std' => 'No translations available for this page',
				),

				array(
					'id' => 'translate-share',
					'type' => 'text',
					'title' => __( 'Share', 'mfn-opts' ),
					'desc' => __( 'Share', 'mfn-opts' ),
					'std' => 'Share',
				),

				// Items

				array(
					'title' => __('Items', 'mfn-opts'),
					'sub_desc' => __('Builder items & shortcodes: <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#beforeafter" target="_blank">Before After</a>, <a href="https://themes.muffingroup.com/be/theme/shortcodes/boxes-infographics/#countdown" target="_blank">Countdown</a>', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'translate-before',
					'type' => 'text',
					'title' => __('Before', 'mfn-opts'),
					'desc' => __('Before After', 'mfn-opts'),
					'std' => 'Before',
				),

				array(
					'id' => 'translate-after',
					'type' => 'text',
					'title' => __('After', 'mfn-opts'),
					'desc' => __('Before After', 'mfn-opts'),
					'std' => 'After',
				),

				array(
					'id' => 'translate-days',
					'type' => 'text',
					'title' => __('Days', 'mfn-opts'),
					'desc' => __('Countdown', 'mfn-opts'),
					'std' => 'days',
				),

				array(
					'id' => 'translate-hours',
					'type' => 'text',
					'title' => __('Hours', 'mfn-opts'),
					'desc' => __('Countdown', 'mfn-opts'),
					'std' => 'hours',
				),

				array(
					'id' => 'translate-minutes',
					'type' => 'text',
					'title' => __('Minutes', 'mfn-opts'),
					'desc' => __('Countdown', 'mfn-opts'),
					'std' => 'minutes',
				),

				array(
					'id' => 'translate-seconds',
					'type' => 'text',
					'title' => __('Seconds', 'mfn-opts'),
					'desc' => __('Countdown', 'mfn-opts'),
					'std' => 'seconds',
				),

			),
		);

		// translate | blog portfolio  -----

		$sections['translate-blog'] = array(
			'title' => __('Blog & Portfolio', 'mfn-opts'),
			'fields' => array(

				// blog portfolio

				array(
					'title' => __('Blog & Portfolio', 'mfn-opts'),
				),

				array(
					'id' => 'translate-filter',
					'type' => 'text',
					'title' => __('Filter by', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'Filter by',
				),

				array(
					'id' => 'translate-authors',
					'type' => 'text',
					'title' => __('Authors', 'mfn-opts'),
					'desc' => __('Blog', 'mfn-opts'),
					'std' => 'Authors',
				),

				array(
					'id' => 'translate-all',
					'type' => 'text',
					'title' => __('Show all', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'Show all',
				),

				array(
					'id' => 'translate-item-all',
					'type' => 'text',
					'title' => __('All', 'mfn-opts'),
					'desc' => __('Blog Item, Portfolio Item', 'mfn-opts'),
					'std' => 'All',
				),

				array(
					'id' => 'translate-published',
					'type' => 'text',
					'title' => __('Published by', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'Published by',
				),

				array(
					'id'	 => 'translate-at',
					'type' => 'text',
					'title' => __('on', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'on',
				),

				array(
					'id' => 'translate-categories',
					'type' => 'text',
					'title' => __('Categories', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'Categories',
				),

				array(
					'id' => 'translate-tags',
					'type' => 'text',
					'title' => __('Tags', 'mfn-opts'),
					'desc' => __('Blog', 'mfn-opts'),
					'std' => 'Tags',
				),

				array(
					'id' => 'translate-readmore',
					'type' => 'text',
					'title' => __('Read more', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'Read more',
				),

				array(
					'id' => 'translate-like',
					'type' => 'text',
					'title' => __('Do you like it?', 'mfn-opts'),
					'desc' => __('Blog', 'mfn-opts'),
					'std' => 'Do you like it?',
				),

				array(
					'id' => 'translate-related',
					'type' => 'text',
					'title' => __('Related posts', 'mfn-opts'),
					'desc' => __('Blog, Portfolio', 'mfn-opts'),
					'std' => 'Related posts',
				),

				array(
					'id' => 'translate-client',
					'type' => 'text',
					'title' => __('Client', 'mfn-opts'),
					'desc' => __('Portfolio', 'mfn-opts'),
					'std' => 'Client',
				),

				array(
					'id' => 'translate-date',
					'type' => 'text',
					'title' => __('Date', 'mfn-opts'),
					'desc' => __('Portfolio', 'mfn-opts'),
					'std' => 'Date',
				),

				array(
					'id' => 'translate-website',
					'type' => 'text',
					'title' => __('Website', 'mfn-opts'),
					'desc' => __('Portfolio', 'mfn-opts'),
					'std' => 'Website',
				),

				array(
					'id' => 'translate-view',
					'type' => 'text',
					'title' => __('View website', 'mfn-opts'),
					'desc' => __('Portfolio', 'mfn-opts'),
					'std' => 'View website',
				),

				array(
					'id' => 'translate-task',
					'type' => 'text',
					'title' => __('Task', 'mfn-opts'),
					'desc' => __('Portfolio', 'mfn-opts'),
					'std' => 'Task',
				),

				array(
					'id' => 'translate-commented-on',
					'type' => 'text',
					'title' => __( 'Commented on', 'mfn-opts' ),
					'desc' => __( 'Be Recent Comments widget', 'mfn-opts' ),
					'std' => 'commented on',
				),
			),
		);

		// translate | blog portfolio  -----

		$sections['translate-shop'] = array(
			'title' => __('Shop', 'mfn-opts'),
			'fields' => array(

				// general

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'translate-shop-filters',
					'type' => 'text',
					'title' => __('Filters', 'mfn-opts'),
					'std' => 'Filters',
				),

				array(
					'id' => 'translate-empty-wishlist',
					'type' => 'text',
					'title' => __('Your wishlist is empty', 'mfn-opts'),
					'std' => 'Your wishlist is empty',
				),

				// image frame

				array(
					'title' => __('Image frame', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'translate-add-to-cart',
					'type' => 'text',
					'title' => __('Add to cart', 'mfn-opts'),
					'std' => 'Add to cart',
				),

				array(
					'id' => 'translate-view-product',
					'type' => 'text',
					'title' => __('View product', 'mfn-opts'),
					'std' => 'View product',
				),

				array(
					'id' => 'translate-add-to-wishlist',
					'type' => 'text',
					'title' => __('Add to wishlist', 'mfn-opts'),
					'std' => 'Add to wishlist',
				),

				array(
					'id' => 'translate-if-preview',
					'type' => 'text',
					'title' => __('Preview', 'mfn-opts'),
					'std' => 'Preview',
				),

				// Side cart

				array(
					'title' => __('Side cart', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'translate-side-cart-shipping-free',
					'type' => 'text',
					'title' => __('Free shipping', 'mfn-opts'),
					'desc' => __('Free!', 'mfn-opts'),
					'std' => 'Free!',
				),

			),
		);

		// translate | search -----

		$sections['translate-search'] = array(
			'title' => __('Search', 'mfn-opts'),
			'fields' => array(

				// form

				array(
					'title' => __('Form', 'mfn-opts'),
				),

				array(
					'id' => 'translate-search-placeholder',
					'type' => 'text',
					'title' => __('Input placeholder', 'mfn-opts'),
					'std' => 'Enter your search',
				),

				// search

				array(
					'title' => __('Page', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'translate-search-results',
					'type' => 'text',
					'title' => __('Page title with number of results', 'mfn-opts'),
					'desc' => __('results found for:', 'mfn-opts'),
					'std' => 'results found for:',
				),

				array(
					'id' => 'translate-search-title',
					'type' => 'text',
					'title' => __('Not found | Title', 'mfn-opts'),
					'desc' => __('Ooops...', 'mfn-opts'),
					'std' => 'Ooops...',
				),

				array(
					'id' => 'translate-search-subtitle',
					'type' => 'text',
					'title' => __('Not found | Text', 'mfn-opts'),
					'desc' => __('No results found for:', 'mfn-opts'),
					'std' => 'No results found for:',
				),

				array(
					'title' => __('Live search', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'translate-livesearch-categories',
					'type' => 'text',
					'title' => __('Categories', 'mfn-opts'),
					'std' => 'Categories',
				),

				array(
					'id' => 'translate-livesearch-pages',
					'type' => 'text',
					'title' => __('Pages', 'mfn-opts'),
					'std' => 'Pages',
				),

				array(
					'id' => 'translate-livesearch-portfolio',
					'type' => 'text',
					'title' => __('Portfolio', 'mfn-opts'),
					'std' => 'Portfolio',
				),

				array(
					'id' => 'translate-livesearch-posts',
					'type' => 'text',
					'title' => __('Posts', 'mfn-opts'),
					'std' => 'Posts',
				),

				array(
					'id' => 'translate-livesearch-products',
					'type' => 'text',
					'title' => __('Products', 'mfn-opts'),
					'std' => 'Products',
				),

				array(
					'id' => 'translate-livesearch-noresults',
					'type' => 'text',
					'title' => __('Not found text', 'mfn-opts'),
					'desc' => __('No results', 'mfn-opts'),
					'std' => 'No results',
				),

				array(
					'id' => 'translate-livesearch-button',
					'type' => 'text',
					'title' => __('See all button', 'mfn-opts'),
					'desc' => __('See all results', 'mfn-opts'),
					'std' => 'See all results',
				),

			),
		);

		// translate | error 404 -----

		$sections['translate-404'] = array(
			'title' => __('Error 404', 'mfn-opts'),
			'fields' => array(

				// error 404

				array(
					'title' => __('Error 404', 'mfn-opts'),
				),

				array(
					'id' => 'translate-404-title',
					'type' => 'text',
					'title' => __('Title', 'mfn-opts'),
					'desc' => __('Ooops... Error 404', 'mfn-opts'),
					'std' => 'Ooops... Error 404',
				),

				array(
					'id' => 'translate-404-subtitle',
					'type' => 'text',
					'title' => __('Subtitle', 'mfn-opts'),
					'desc' => __('We are sorry, but the page you are looking for does not exist.', 'mfn-opts'),
					'std' => 'We are sorry, but the page you are looking for does not exist.',
				),

				array(
					'id' => 'translate-404-text',
					'type' => 'text',
					'title' => __('Text', 'mfn-opts'),
					'desc' => __('Please check entered address and try again or', 'mfn-opts'),
					'std' => 'Please check entered address and try again or ',
				),

				array(
					'id' => 'translate-404-btn',
					'type' => 'text',
					'title' => __('Button', 'mfn-opts'),
					'desc' => __('go to homepage', 'mfn-opts'),
					'std' => 'go to homepage',
				),

			),
		);

		// translate | WPML -----

		$sections['translate-wpml'] = array(
			'title' => __('WPML Installer', 'mfn-opts'),
			'fields' => array(

				array(
					'id' => 'info-wpml',
					'type' => 'info',
					'title' => __('<b>WPML</b> is an optional premium plugin and it is <b>not</b> included into the theme', 'mfn-opts'),
					'label' => __('Buy plugin', 'mfn-opts'),
					'link' => 'https://wpml.org/purchase/?aid=29349&affiliate_key=aCEsSE0ka33p',
				),

				// wpml

				array(
					'title' => __('WPML', 'mfn-opts'),
				),

				array(
					'id' => 'translate-wpml-installer',
					'type' => 'custom',
					'title' => __('WPML Installer', 'mfn-opts'),
					'action' => 'wpml',
					'class' => 'form-content-full-width',
				),

			),
		);

		// gdpr | general

		$sections['gdpr-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'fields' => array(

				// layout

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'gdpr',
					'attr_id' => 'gdpr',
					'type' => 'switch',
					'title' => __('Privacy bar', 'mfn-opts'),
						'options' => array(
							'' => __('Hide', 'mfn-opts'),
							'1' => __('Show', 'mfn-opts'),
						),
					'std' => '',
				),

				// options

				array(
					'title' => __('Options', 'mfn-opts'),
					'prefix' => 'gdpr',
					'join' => true,
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-settings-position',
					'type' => 'radio_img',
					'title' => __('Layout', 'mfn-opts'),
					'options' => array(
						'top' => __('Top', 'mfn-opts'),
						'bottom' => __('Bottom', 'mfn-opts'),
						'left' => __('Left', 'mfn-opts'),
						'right' => __('Right', 'mfn-opts'),
					),
					'alias' => 'gdpr',
					'class' => 'form-content-full-width',
					'std' => 'left',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-settings-animation',
					'type' => 'switch',
					'title' => __('Animation', 'mfn-opts'),
					'options' => array(
						'' => __('None', 'mfn-opts'),
						'fade' => __('Fade', 'mfn-opts'),
						'slide' => __('Slide', 'mfn-opts'),
					),
					'desc' => __('Animation after acceptance', 'mfn-opts'),
					'std' => 'slide',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-settings-cookie_expire',
					'type' => 'text',
					'title' => __('Cookie expiration', 'mfn-opts'),
					'std' => '365',
					'param' => 'number',
					'after' => __('days', 'mfn-opts'),
					'class' => 'narrow',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				// content

				array(
					'title' => __('Content', 'mfn-opts'),
					'prefix' => 'gdpr',
					'join' => true,
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-content',
					'type' => 'textarea',
					'title' => __('Message', 'mfn-opts'),
					'desc' => __('In this field, you can use raw HTML to put the content of GDPR Compliance', 'mfn-opts'),
					'class' => 'form-content-full-width',
					'std' => 'This website uses cookies to improve your experience. By using this website you agree to our <a href="#">Data Protection Policy</a>.',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-content-image',
					'type' => 'upload',
					'title' => __('Image', 'mfn-opts'),
					'desc' => __('Type <b>#</b> to use default image, leave empty to hide image', 'mfn-opts'),
					'std' => '#',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-content-button_text',
					'type' => 'text',
					'title' => __('Button text', 'mfn-opts'),
					'std' => 'Accept all',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				// more info

				array(
					'title' => __('More info', 'mfn-opts'),
					'prefix' => 'gdpr',
					'join' => true,
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-content-more_info_text',
					'type' => 'text',
					'title' => __('Text', 'mfn-opts'),
					'desc' => __('Leave empty to hide link', 'mfn-opts'),
					'std' => 'Read more',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-content-more_info_link',
					'type' => 'text',
					'title' => __('Link', 'mfn-opts'),
					'std' => '#',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-content-more_info_page',
					'type' => 'select',
					'title' => __('Page', 'mfn-opts'),
					'options' => mfna_pages(),
					'js_options' => 'pages',
					'desc' => 'If selected, link from option above will be overwritten by this page',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-settings-link_target',
					'type' => 'switch',
					'title' => __('Link target', 'mfn-opts'),
					'options' => array(
						'_self'	=> __('Default', 'mfn-opts'),
						'_blank' => __('New tab', 'mfn-opts'),
					),
					'std' => '_blank',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

			),
		);

		// gdpr | design

		$sections['gdpr-design'] = array(
			'title' => __('Design', 'mfn-opts'),
			'fields' => array(

				array(
					'id' => 'info-shop2',
					'type' => 'info',
					'title' => __('Please show <b>Privacy bar</b> to get access to this tab.', 'mfn-opts'),
					'label' => __('Privacy Bar', 'mfn-opts'),
					'link' => 'admin.php?page=be-options#gdpr-general&general',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'is', 'val' => '' ), // is or isnt and value
				),

				// layout

				array(
					'title' => __('Container', 'mfn-opts'),
					'prefix' => 'gdpr',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-container-background',
					'type' => 'color',
					'title' => __('Background', 'mfn-opts'),
					'std' => '#eef2f5',
					'alpha' => true,
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body #mfn-gdpr" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'gdpr-container-font_color',
					'type' => 'color',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'title' => __('Text color', 'mfn-opts'),
					'std' => '#626262',
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="#mfn-gdpr .mfn-gdpr-content, #mfn-gdpr .mfn-gdpr-content h1, #mfn-gdpr .mfn-gdpr-content h2, #mfn-gdpr .mfn-gdpr-content h3, #mfn-gdpr .mfn-gdpr-content h4, #mfn-gdpr .mfn-gdpr-content h5, #mfn-gdpr .mfn-gdpr-content h6, #mfn-gdpr .mfn-gdpr-content ol, #mfn-gdpr .mfn-gdpr-content ul" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'gdpr-container-border-radius',
					'type' => 'text',
					'title' => __('Border radius', 'mfn-opts'),
					'desc' => __('for Layout: Left or Right', 'mfn-opts'),
					'class' => 'narrow to-inline-style',
					'param' => 'number',
					'after' => 'px',
					'std' => '5',
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'data_attr' => 'data-csspath="body #mfn-gdpr" data-responsive="desktop" data-style="border-radius" data-unit="px"',
				),

				array(
					'id' => 'gdpr-container-box_shadow',
					'type' => 'boxshadow',
					'title' => __('Box shadow', 'mfn-opts'),
					'class' => 'to-inline-style',
					'data_attr' => 'data-csspath="body #mfn-gdpr" data-responsive="desktop" data-style="box-shadow" data-unit=""',
					'std' => [
						'x' => '0',
						'y' => '15',
						'blur' => '30',
						'spread' => '0',
						'color' => 'rgba(1,7,39,.13)',
						'inset' => 0
					],
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
				),

				// button

				array(
					'title' => __('Button', 'mfn-opts'),
					'prefix' => 'gdpr',
					'join' => true,
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),

				array(
					'id' => 'gdpr-button-background',
					'type' => 'color_multi',
					'title' => __('Background', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#006edf',
						'hover' => '#0089f7',
					],
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'data_attr' => 'data-csspath="body #mfn-gdpr .mfn-gdpr-button" data-responsive="desktop" data-style="background-color" data-unit=""',
				),

				array(
					'id' => 'gdpr-button-font_color',
					'type' => 'color_multi',
					'title' => __('Text color', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#ffffff',
						'hover' => '#ffffff',
					],
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'data_attr' => 'data-csspath="body #mfn-gdpr .mfn-gdpr-button" data-responsive="desktop" data-style="color" data-unit=""',
				),

				array(
					'id' => 'gdpr-button-border_color',
					'type' => 'color_multi',
					'title' => __('Border color', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '',
						'hover' => '',
					],
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'data_attr' => 'data-csspath="body #mfn-gdpr .mfn-gdpr-button" data-responsive="desktop" data-style="border-color" data-unit=""',
				),


				// more info

				array(
					'title' => __('More info', 'mfn-opts'),
					'prefix' => 'gdpr',
					'join' => true,
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ), // is or isnt and value
				),


				array(
					'id' => 'gdpr-more-info-font_color',
					'type' => 'color_multi',
					'title' => __('Text color', 'mfn-opts'),
					'class' => 'form-content-full-width to-inline-style',
					'std' => [
						'normal' => '#161922',
						'hover' => '#0089f7',
					],
					'condition' => array( 'id' => 'gdpr', 'opt' => 'isnt', 'val' => '' ),
					'data_attr' => 'data-csspath="#mfn-gdpr .mfn-gdpr-content a, #mfn-gdpr a.mfn-gdpr-readmore" data-responsive="desktop" data-style="color" data-unit=""',
				),

			),
		);

		// performance | general

		$sections['performance-general'] = array(
			'title' => __('General', 'mfn-opts'),
			'fields' => array(

				array(
					'id' => 'info-performance',
					'type' => 'info',
					'title' => __('After making changes on this page, please click <b>Save changes</b> button to make changes.', 'mfn-opts'),
				),

				// google fonts

				array(
					'title' => __('Google Fonts', 'mfn-opts'),
				),

				array(
					'id' => 'google-font-mode',
					'attr_id' => 'google-font-mode',
					'type' => 'switch',
					'title' => __('Google Fonts', 'mfn-opts'),
					'options' => array(
						'' => __('Load from Google', 'mfn-opts'),
						'local' => __('Cache fonts local', 'mfn-opts'),
						'disabled' => __('Disable', 'mfn-opts'),
					),
					'std' => '',
				),

				array(
					'id' => 'google-font-mode-regenerate',
					'type' => 'ajax',
					'title' => __('Cache fonts', 'mfn-opts'),
					'desc' => __('Please use this option to dowload selected fonts from Google and save them on your FTP', 'mfn-opts'),
					'condition' => array( 'id' => 'google-font-mode', 'opt' => 'is', 'val' => 'local' ), // is or isnt and value
					'action' => 'mfn_regenerate_fonts',
					'button' => __('Download files', 'mfn-opts'),
				),

				// images

				array(
					'title' => __('Images', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'lazy-load',
					'type' => 'switch',
					'title' => __('Lazy load', 'mfn-opts'),
					'options' => array(
						'' => __('Disable', 'mfn-opts'),
						'lazy' => __('Enable', 'mfn-opts'),
					),
					'std' => '',
				),

				// assets

				array(
					'title' => __('Assets', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'performance-assets-disable',
					'type' => 'checkbox',
					'title' => __('Theme assets', 'mfn-opts'),
					'options' => array(
						'entrance-animations' => __('Entrance animations', 'mfn-opts'),
						'font-awesome' => __('Font Awesome', 'mfn-opts'),
						'html5-player' => __('HTML5 video player', 'mfn-opts'),
					),
					'invert' => true, // !!!
				),

				array(
					'id' => 'performance-wp-disable',
					'type' => 'checkbox',
					'title' => __('WordPress assets', 'mfn-opts'),
					'options' => array(
						'wp-block-library' => __('Block library<span>Disable only if you do not use Block Editor</span>', 'mfn-opts'),
						'dashicons' => __('Dashicons<span>Admin bar requires Dashicons so this affects logged out users only</span>', 'mfn-opts'),
						'emoji' => __('Emoji', 'mfn-opts'),
					),
					'invert' => true, // !!!
				),

				// files location

				array(
					'title' => __('Files location', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'jquery-location',
					'type' => 'switch',
					'title' => __('jQuery location', 'mfn-opts'),
					'desc' => __('WordPress loads jQuery in Header so Footer location may crash some plugins which load scripts in header too', 'mfn-opts'),
					'options' => array(
						'' => __('Header', 'mfn-opts'),
						'footer' => __('Footer', 'mfn-opts'),
					),
					'std' => '',
				),

				array(
					'id' => 'css-location',
					'type' => 'switch',
					'title' => __('CSS location', 'mfn-opts'),
					'desc' => __('Moving CSS to Footer may change the weight of some CSS declarations and may require some adjustment in your custom CSS code', 'mfn-opts'),
					'options' => array(
						'' => __('Header', 'mfn-opts'),
						'footer' => __('Footer', 'mfn-opts'),
					),
					'std' => '',
				),

				array(
					'id' => 'local-styles-location',
					'type' => 'switch',
					'title' => __('Builder local styles', 'mfn-opts'),
					'desc' => __('By default theme uses external CSS files, use inline option to prevent CLS', 'mfn-opts'),
					'options' => array(
						'' => __('External file', 'mfn-opts'),
						'inline' => __('Inline in header', 'mfn-opts'),
					),
					'std' => '',
				),

/*
				array(
					'id' => 'lazy-load',
					'type' => 'switch',
					'title' => __('Lazy Load', 'mfn-opts'),
					'desc' => __('All of the images will be lazdy loaded', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),
*/

				// minify

				array(
					'title' => __('Minify', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'minify-css',
					'type' => 'switch',
					'title' => __('CSS', 'mfn-opts'),
					'desc' => __('Use minified version of all theme CSS files', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'minify-js',
					'type' => 'switch',
					'title' => __('JS', 'mfn-opts'),
					'desc' => __('Use minified version of all theme JS files', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),

					),
					'std' => '0',
				),

				// caching

				array(
					'title' => __('Cache', 'mfn-opts'),
					'join' => true,
				),

				array(
					'id' => 'hold-cache',
					'attr_id' => 'hold-cache',
					'type' => 'switch',
					'title' => __('Cache assets', 'mfn-opts'),
					'desc' => __('Set expiration dates for assets according to PageSpeed Insights guidelines.<br /><b>Notice:</b> Before use, contact with your administrator, as in some cases the use of this option can cause issues. Please backup your .htaccess file before enabling.', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'old_value' => true,
					'std' => '0',
				),

				array(
					'id' => 'hold-cache-regenerate',
					'type' => 'ajax',
					'title' => __('Refresh cache', 'mfn-opts'),
					'desc' => __('Please use this option to refresh your cache', 'mfn-opts'),
					'condition' => array( 'id' => 'hold-cache', 'opt' => 'is', 'val' => '1' ), // is or isnt and value
					'action' => 'mfn_refresh_cache',
					'button' => __('Refresh', 'mfn-opts'),
				),

			),
		);

		$sections['accessibility-general'] = array(
			'title' => __('Accessibility', 'mfn-opts'),
			'fields' => array(

				array(
					'id' => 'skip-links',
					'type' => 'info',
					'title' => __('To show <b>Skip Navigation Links</b> add custom menu to Accessibility Skip Links Menu location', 'mfn-opts'),
					'label' => __('Appearance > Menus', 'mfn-opts'),
					'link' => 'nav-menus.php',
				),

				array(
					'title' => __('General', 'mfn-opts'),
				),

				array(
					'id' => 'keyboard-support',
					'type' => 'switch',
					'title' => __('Keyboard support', 'mfn-opts'),
					'desc' => __('Improves core navigation functionalities for non-mouse users.<br />Some browsers requires configuration change, ie. <a target="_blank" href="https://support.mozilla.org/en-US/questions/1278793">Firefox</a>', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'underline-links',
					'type' => 'switch',
					'title' => __('Underline links in text block', 'mfn-opts'),
					'desc' => __('Make content links more distinguishable by adding underline for links in WordPress Content, BeBuilder Columns and Text Widgets', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'repetitive-links',
					'type' => 'switch',
					'title' => __('Repetitive link text', 'mfn-opts'),
					'desc' => __('Use post title in addition to the "Read more" text on screen readers', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

				array(
					'id' => 'warning-open-links',
					'type' => 'switch',
					'title' => __('Warning on links', 'mfn-opts'),
					'desc' => __('If link opens new window or tab, warn the user using browser alert', 'mfn-opts'),
					'options' => array(
						'0' => __('Disable', 'mfn-opts'),
						'1' => __('Enable', 'mfn-opts'),
					),
					'std' => '0',
				),

			),
		);

		// custom | css -----

		$sections['css'] = array(
			'title' => __('CSS', 'mfn-opts'),
			'fields' => array(

				// csutom css

				array(
					'title' => __('Custom CSS', 'mfn-opts'),
				),

				array(
					'id' => 'custom-css',
					'type' => 'textarea',
					'title' => __('Custom CSS', 'mfn-opts'),
					'class' => 'custom-css form-content-full-width',
					'cm' => 'css',
				),

			),
		);

		// custom | js -----

		$sections['js'] = array(
			'title' => __('JS', 'mfn-opts'),
			'fields' => array(

				// csutom js

				array(
					'title' => __('Custom JS', 'mfn-opts'),
				),

				array(
					'id' => 'info-custom-js',
					'type' => 'info',
					'class' => 'hide-theme-options',
					'title' => __('Custom JS filed is available only in Theme Options', 'mfn-opts'),
					'label' => __('Theme Options', 'mfn-opts'),
					'link' => 'admin.php?page=be-options#js',
				),

				array(
					'id' => 'custom-js',
					'type' => 'textarea',
					'title' => __('Custom JS', 'mfn-opts'),
					'desc' => __('To use jQuery code wrap it into <b>jQuery(function($){ ... });</b>', 'mfn-opts'),
					'class' => 'custom-javascript form-content-full-width',
					'cm' => 'javascript',
				),

			),
		);

		$sections = apply_filters('mfn-theme-options-sections', $sections);

		$MFN_Options = new MFN_Options( $menu, $sections );
	}
}
mfn_opts_setup();

if( ! function_exists( 'mfn_opts_get' ) )
{
	/**
	 * This is used to return option value from the options array
	 */

	function mfn_opts_get( $opt_name, $default = null, $attr = [] ){

		global $MFN_Options;

		extract( shortcode_atts( array(
			'implode' => false,
			'key' => false,
			'not_empty' => false,
			'unit' => false,
		), $attr ) );

		$value = $MFN_Options->get( $opt_name, $default );

		if ( is_array( $value ) ) {

			unset( $value['isLinked'] ); // dimensions field hidden input

			if ( $unit ) {
				foreach ( $value as $k => $val ) {
					if ( is_numeric( $val ) && $val ) {
						$value[$k] .= $unit;
					}
				}
			}

			if ( $implode ) {
				$value = implode( $implode, $value );
			}

			if ( $key ) {
				$value = $value[ $key ];
			}

		} else {

			if ( $unit ) {
				if ( is_numeric( $value ) ) {
					$value .= $unit;
				}
			}

		}

		// force not to return empty value

		if ( $not_empty && ! $value ) {
			return $default;
		}

		// return

		return $value;
	}
}

if( ! function_exists( 'mfn_upload_mimes' ) )
{
	/**
	 * Add new mimes for custom font upload
	 */

	function mfn_upload_mimes( $mimes = array() ){

		$mimes['svg'] = 'font/svg';
		$mimes['woff'] = 'font/woff';
		$mimes['ttf'] = 'font/ttf';

		return $mimes;
	}
}
add_filter( 'upload_mimes', 'mfn_upload_mimes' );
