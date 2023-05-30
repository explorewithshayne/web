<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

/*error_reporting(E_ALL);
ini_set("display_errors", 1);*/

class Mfn_Vb_Header_Tmpl extends Walker_Nav_Menu {

	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$menu_item = $data_object;

		// vb args
		$menu_item_icon = get_post_meta( $menu_item->ID, 'mfn_menu_item_icon', true );
		$menu_item_icon_img = get_post_meta( $menu_item->ID, 'mfn_menu_item_icon_img', true );
		$menu_item_megamenu = get_post_meta( $menu_item->ID, 'mfn_menu_item_megamenu', true );
		$menu_item_megamenu_display = get_post_meta( $menu_item->ID, 'mfn_menu_item_megamenu_display', true );

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		if( isset($args->mega_menu) && $args->mega_menu && $depth <= 1 && $menu_item_megamenu && is_numeric($menu_item_megamenu) && get_post_status($menu_item_megamenu) == 'publish' ){
			$classes[] = 'mfn-menu-item-has-megamenu';
		}

		if( !empty($menu_item_megamenu_display) && $menu_item_megamenu_display == '1' ) $classes[] = 'mfn-menu-item-megamenu-always-on-home';
		if( !empty($menu_item_megamenu_display) && $menu_item_megamenu_display == '2' ) $classes[] = 'mfn-menu-item-megamenu-always-on';

		// for builder only
		if( isset( $args->mega_menu_simulate ) && $args->mega_menu_simulate && $depth <= 1 && $menu_item_megamenu && is_numeric($menu_item_megamenu) && get_post_status($menu_item_megamenu) == 'publish'  ){
			$classes[] = 'mfn-menu-item-has-megamenu';
		}

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param WP_Post  $menu_item Menu item data object.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */


		if( isset($args->mfn_classes) && $args->mfn_classes ){
			$classes[] = 'mfn-menu-li';
		}

		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id   The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

		//print_r($args);
		if( $id && !empty( $args->li_id_prefix ) ){
			$id = ' id="'.$args->li_id_prefix. esc_attr( $id ) . '"';
		}else{
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		}

		$output .= $indent . '<li' . $id . $class_names . '>';

		/*if( $depth == 0 ){
			$output .= '<span class="menu-item-hover"></span>';
		}*/

		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}
		$atts['href']         = ! empty( $menu_item->url ) ? $menu_item->url : '';
		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		if( isset($args->mfn_classes) && $args->mfn_classes ){
			$atts['class'] = 'mfn-menu-link';
		}

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title     The menu item's title.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

		$item_output = '';

		if( isset($args->before) ) $item_output .= $args->before;
		$item_output .= '<a' . $attributes . '>';

		if( !isset($args->hide_helper) || !$args->hide_helper ){

			if( isset($args->mfn_classes) && $args->mfn_classes ){
				$item_output .= '<span class="menu-item-helper mfn-menu-item-helper"></span>';
			}else{
				$item_output .= '<span class="menu-item-helper"></span>';
			}

		}


		if( $menu_item_icon || $menu_item_icon_img ){
			if( isset($args->mfn_classes) && $args->mfn_classes ){
				$item_output .= '<span class="menu-icon mfn-menu-item-icon">';
			}else{
				$item_output .= '<span class="menu-icon">';
			}

			if( $menu_item_icon ){
				$item_output .= '<i class="'.$menu_item_icon.'"></i>';
			}elseif( $menu_item_icon_img ){

				$width = mfn_get_attachment_data( $menu_item_icon_img, 'width' );
				$height = mfn_get_attachment_data( $menu_item_icon_img, 'height' );

				if( ! $width ){
					$width = 25;
					$height = 25;
				}

				$item_output .= '<img src="'. esc_url( $menu_item_icon_img ) .'" alt="'. esc_attr( mfn_get_attachment_data( $menu_item_icon_img, 'alt' ) ) .'" width="'. esc_attr( $width ) .'" height="'. esc_attr( $height ) .'">';
			}
			
			$item_output .= '</span>';
		}

		if( isset($args->mfn_classes) && $args->mfn_classes ){
			$item_output .= '<span class="label-wrapper mfn-menu-label-wrapper"><span class="menu-label">';
		}else{
			$item_output .= '<span class="label-wrapper"><span class="menu-label">';
		}

		if( isset($args->link_before) ) $item_output .= $args->link_before;

		$item_output .= $title;

		$item_output .= '</span>';

		if ( $depth == 0 && !empty( $menu_item->description ) ) {

			if( isset($args->mfn_classes) && $args->mfn_classes ){
	        	$item_output .= '<span class="menu-desc mfn-menu-desc">' . $menu_item->description . '</span>';
	    	}else{
	    		$item_output .= '<span class="menu-desc">' . $menu_item->description . '</span>';
	    	}
	    }

		$item_output .= '</span>';

		if( $depth == 0 && !empty( $args->custom_icon ) ){
			if( isset($args->mfn_classes) && $args->mfn_classes ){
				$item_output .= '<span class="menu-sub mfn-menu-subicon">'.$args->custom_icon.'</span>';
			}else{
				$item_output .= '<span class="menu-sub">'.$args->custom_icon.'</span>';
			}

		}

		if( $depth > 0 && !empty( $args->custom_subicon ) ){
			if( isset($args->mfn_classes) && $args->mfn_classes ){
				$item_output .= '<span class="menu-sub mfn-menu-sub-subicon">'.$args->custom_subicon.'</span>';
			}else{
				$item_output .= '<span class="menu-sub">'.$args->custom_subicon.'</span>';
			}
		}

		if( !empty( $args->submenu_icon ) ){
			$item_output .= '<span class="menu-sub">'.$args->submenu_icon.'</span>';
		}

		if( isset($args->link_after) ) $item_output .= $args->link_after;

		$item_output .= '</a>';
		if( isset($args->after) ) $item_output .= $args->after;

		if( isset($args->mega_menu) && $args->mega_menu && $depth <= 1 && $menu_item_megamenu && is_numeric($menu_item_megamenu) && get_post_status($menu_item_megamenu) == 'publish' ){
			require_once(get_theme_file_path('/functions/modules/class-mfn-megamenu.php'));
			ob_start();
			$mfnMM = new MfnMegaMenu($menu_item_megamenu);
			$mfnMM->render();
			//get_template_part( 'includes/header', 'megamenu', array('id' => $menu_item_megamenu) );
			$item_output .= ob_get_clean();
		}

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $menu_item   Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'sub-menu' );

		if( isset($args->mfn_classes) && $args->mfn_classes ){
			$classes[] = 'mfn-submenu';
		}

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
	}


}
