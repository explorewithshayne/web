<?php
/**
 * Mega Menu classes.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Custom Frontend Main Menu Walker
 */

class Walker_Nav_Menu_Mfn extends Walker_Nav_Menu
{

	// columns

	public $columns	= 0;
	public $max_columns	= 0;

	// rows

	public $rows = 1;
	public $aRows	= array();

	// mega menu
	public $has_megamenu = 0;
	public $bg_megamenu	= '';

	/**
	 * @see Walker::start_lvl()
	 */

	public function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu{tag_ul_class}\"{tag_ul_style}>\n";
	}

	/**
	 * @see Walker::end_lvl()
	 */

	public function end_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";

		if ($depth === 0) {
			if ($this->has_megamenu) {

				// mega menu background image
				if ($this->bg_megamenu) {
					$class	= ' mfn-megamenu-bg';
					$style	= ' style="background-image:url('. $this->bg_megamenu .');"';

					$output	= str_replace("{tag_ul_class}", " mfn-megamenu mfn-megamenu-". esc_attr($this->max_columns) . esc_attr($class), $output);
					$output	= str_replace("{tag_ul_style}", $style, $output);
				} else {
					$output = str_replace("{tag_ul_class}", " mfn-megamenu mfn-megamenu-". esc_attr($this->max_columns), $output);
					$output = str_replace("{tag_ul_style}", "", $output);
				}

				foreach ($this->aRows as $row => $columns) {
					$output = str_replace("{tag_li_class_".$row."}", "mfn-megamenu-cols-". esc_attr($columns), $output);
				}

				$this->columns = 0;
				$this->max_columns = 0;
				$this->aRows = array();

			} else {

				$output = str_replace("{tag_ul_class}", "", $output);
				$output = str_replace("{tag_ul_style}", "", $output);

			}
		}
	}

	/**
	 * @see Walker::start_el()
	 */

	public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{
		global $wp_query;

		$item_output = $li_text_block_class = $column_class = "";

		$menu_item_megamenu = get_post_meta( $item->ID, 'mfn_menu_item_megamenu', true );

		if ($depth === 0) {

			// 1st level

			$this->has_megamenu	= get_post_meta($item->ID, 'menu-item-mfn-megamenu', true);
			$this->bg_megamenu = get_post_meta($item->ID, 'menu-item-mfn-bg', true);
		}

		if ($depth === 1 && $this->has_megamenu) {

			 // 2nd level Mega Menu

			$this->columns ++;
			$this->aRows[$this->rows] = $this->columns;

			if ($this->max_columns < $this->columns) {
				$this->max_columns = $this->columns;
			}

			if ($item->title != "-") {
				$title = apply_filters('the_title', $item->title, $item->ID);

				$attributes  = ! empty($item->attr_title) ? ' title="'. esc_attr($item->attr_title) .'"' : '';
				$attributes .= ! empty($item->target) ? ' target="'. esc_attr($item->target) .'"' : '';
				$attributes .= ! empty($item->xfn) ? ' rel="'. esc_attr($item->xfn) .'"' : '';
				$attributes .= ! empty($item->url) ? ' href="'. esc_attr($item->url) .'"' : '';

				$item_output .= $args->before;
				$item_output .= '<a class="mfn-megamenu-title"'. $attributes .'>';
				$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
				$item_output .= '</a>';
				$item_output .= $args->after;
			}

			$column_class = ' {tag_li_class_'.$this->rows.'}';

		} else {

			// 1-3 level, except Mega Menu 2nd level ----------------

			$attributes  = ! empty($item->attr_title) ? ' title="'. esc_attr($item->attr_title) .'"' : '';
			$attributes .= ! empty($item->target) ? ' target="'. esc_attr($item->target) .'"' : '';
			$attributes .= ! empty($item->xfn) ? ' rel="'. esc_attr($item->xfn) .'"' : '';
			$attributes .= ! empty($item->url) ? ' href="'. esc_attr($item->url) .'"' : '';

			$item_output .= $args->before;
			$item_output .= '<a'. $attributes .'>';
			$description =  trim($item->description) ? '<span class="description">'. $item->description .'</span>' : false;
			$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $description . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;
		}

		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;

		if( $depth == 0 && isset($args->mega_menu) && $args->mega_menu && $menu_item_megamenu && is_numeric($menu_item_megamenu) && get_post_status($menu_item_megamenu) == 'publish' ){
			$classes[] = 'mfn-theme-options-menu mfn-menu-item-has-megamenu';
		}

		// active for post type parent

		// active: blog

		if (get_post_type(get_the_ID()) == 'post') {
			if ($item->object_id == get_option('page_for_posts')) {
				$classes[] = 'current-menu-item';
			}
		}

		// active: portfolio

		if (get_post_type(get_the_ID()) == 'portfolio') {
			if ($item->object_id == mfn_opts_get('portfolio-page')) {
				$classes[] = 'current-menu-item';
			}
		}

		// active: shop

		if (get_post_type(get_the_ID()) == 'product') {
			if (function_exists('is_woocommerce') && is_woocommerce()) {
				if (version_compare(WC_VERSION, '2.7', '<')) {
					$shop_page_id = woocommerce_get_page_id('shop');
				} else {
					$shop_page_id = wc_get_page_id('shop');
				}
				if ($item->object_id == $shop_page_id) {
					$classes[] = 'current-menu-item';
				}
			}
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'. esc_attr($li_text_block_class . $class_names . $column_class) .'"';

		$output .= $indent .'<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

		if( $depth == 0 && isset($args->mega_menu) && $args->mega_menu && $menu_item_megamenu && is_numeric($menu_item_megamenu) && get_post_status($menu_item_megamenu) == 'publish' ){
			ob_start();
			get_template_part( 'includes/header', 'megamenu', array('id' => $menu_item_megamenu) );
			$output .= ob_get_clean();

		}
	}
}

// allow html tags in main menu description
remove_filter('nav_menu_description', 'strip_tags');
