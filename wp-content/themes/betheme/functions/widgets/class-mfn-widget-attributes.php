<?php

/**
 * Widget Be Woocommerce Attributes
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if (! class_exists('Mfn_Widget_Attributes')) {
	class Mfn_Widget_Attributes extends WP_Widget
	{

		/**
		 * Constructor
		 */

		public function __construct()
		{
			$widget_ops = array(
				'classname' => 'mfn_woo_attributes',
				'description' => __('Shop Attributes.', 'mfn-opts')
			);

			parent::__construct('widget_mfn_woo_attributes', __('Be Shop Attributes', 'mfn-opts'), $widget_ops);

			$this->alt_option_name = 'widget_mfn_woo_attributes';
		}

		/**
		 * Outputs the HTML for this widget.
		 */

		public function widget($args, $instance)
		{

			if( mfn_opts_get('variable-swatches') == 0 || !function_exists('is_woocommerce') ){
				return;
			}

			if (! isset($args['widget_id'])) {
				$args['widget_id'] = null;
			}

			extract($args, EXTR_SKIP);

			echo wp_kses_post($before_widget);

			if( !empty($instance['title']) ){
				$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
	
				echo wp_kses($before_title, array('h3'=>array(),'h4'=>array()));
					echo wp_kses($title, mfn_allowed_html());
				echo wp_kses($after_title, array('h3'=>array(),'h4'=>array()));
			}

			$taxonomies = wc_get_attribute_taxonomies();
			$selects = array();

			if( isset($instance['mfn_attr']) ) $selects = $instance['mfn_attr'];

			if( is_iterable( $taxonomies ) ):
				echo '<form method="GET" action="'.get_the_permalink( get_option( 'woocommerce_shop_page_id' ) ).'" class="mfn_attr_filters '.(isset($instance['button']) && $instance['button'] == 1 ? "button-enabled" : "button-disabled").'">';
				echo '<input type="hidden" name="mfn_attr_filter" value="1">';
				foreach( $taxonomies as $tx ):
					$terms = get_terms( "pa_".$tx->attribute_name, array( 'hide_empty' => false ) );

					if( is_iterable($terms) && count($terms) > 0 ){
					if( is_array($selects) && in_array($tx->attribute_id, $selects)){
						echo '<div class="mfn-vr">';

						echo '<label>'.wc_attribute_label("pa_".$tx->attribute_name).'</label>';
						echo '<ul class="mfn-vr-options mfn-vr-'.$tx->attribute_type.'">';

						foreach($terms as $term){
							$active = 0;
							if(!empty($_GET['mfn_'.$term->taxonomy]) && in_array($term->slug, $_GET['mfn_'.$term->taxonomy])) $active = 1;

							echo '<li data-tooltip="'.$term->name.'" class=" '. ($tx->attribute_type == 'select' ? null : "tooltip") .' '.($active == 1 ? "active" : null).'">';

							if($tx->attribute_type == 'image'){
								$value = $mfn_value = get_term_meta($term->term_id, 'mfn_attr_field', true);
								echo '<span class="label"><span class="mfn_attr_icon" style="background-image: url('.wp_get_attachment_image_src($value, 'thumbnail')[0].');"><input type="checkbox" '.($active == 1 ? "checked" : null).' name="mfn_'.$term->taxonomy.'[]" class="mfn_attr_'.$term->term_id.'" value="'.$term->slug.'"></span></span>';
							}else if($tx->attribute_type == 'color'){
								$value = $mfn_value = get_term_meta($term->term_id, 'mfn_attr_field', true);
								echo '<span class="label"><span class="mfn_attr_icon" style="background-color: '.$value.';"><input type="checkbox" '.($active == 1 ? "checked" : null).' name="mfn_'.$term->taxonomy.'[]" class="mfn_attr_'.$term->term_id.'" value="'.$term->slug.'"></span></span>';
							}else if($tx->attribute_type == 'label'){
								echo '<span class="label"><span><input type="checkbox" '.($active == 1 ? "checked" : null).' name="mfn_'.$term->taxonomy.'[]" class="mfn_attr_'.$term->term_id.'" value="'.$term->slug.'"></span>'.$term->name.'</span>';
							}else{
								echo '<span class="label"><span class="mfn_attr_icon"><input type="checkbox" '.($active == 1 ? "checked" : null).' name="mfn_'.$term->taxonomy.'[]" class="mfn_attr_'.$term->term_id.'" value="'.$term->slug.'"> '.$term->name.'</span></span>';
							}

							echo '</li>';

						}
						echo '</ul>';
						echo '</div>';
					}
				}
				endforeach;
				echo '<button type="submit" class="button mfn-btn">' . esc_html__( 'Filter', 'woocommerce' ) . '</button>';
				echo '</form>';
			endif;

			echo wp_kses_post($after_widget);
		}

		/**
		 * Deals with the settings when they are saved by the admin.
		 */

		public function update($new_instance, $old_instance)
		{
			$instance = $old_instance;

			$instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : '';
			$instance['button'] = isset($new_instance['button']) ? (int) $new_instance['button'] : 0;
			$instance['mfn_attr'] = isset($new_instance['mfn_attr']) ? $new_instance['mfn_attr'] : '';

			return $instance;
		}

		/**
		 * Displays the form for this widget on the Widgets page of the WP Admin area.
		 */

		public function form($instance)
		{
			$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
			$button = isset($instance['button']) ? absint($instance['button']) : 0;
			$list = isset($instance['mfn_attr']) ? $instance['mfn_attr'] : [];

			$taxonomies = wc_get_attribute_taxonomies(); ?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'mfn-opts'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</p>

			<h3 class="wp-block-legacy-widget__edit-form-title"><?php _e('Select attributes to display', 'mfn-opts'); ?></h3>

			<?php
			if( is_iterable( $taxonomies ) ):
				foreach( $taxonomies as $tx ):
					echo '<p><label for="'.esc_attr($this->get_field_id('mfn_attr')).'-'.$tx->attribute_id.'">
						<input id="'.esc_attr($this->get_field_id('mfn_attr')).'-'.$tx->attribute_id.'" name="'.esc_attr($this->get_field_name('mfn_attr')).'[]" '. (isset($list) && is_array($list) && in_array($tx->attribute_id, $list) ? "checked" : null ) .' type="checkbox" value="'.$tx->attribute_id.'"/> '.wc_attribute_label($tx->attribute_name).'
						</label>
					</p>';
				endforeach;
			endif;

			?>

			<h3 class="wp-block-legacy-widget__edit-form-title"><?php _e('Search button', 'mfn-opts'); ?></h3>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('button')); ?>">
				<input id="<?php echo esc_attr($this->get_field_id('button')); ?>" name="<?php echo esc_attr($this->get_field_name('button')); ?>" type="checkbox" <?php if(esc_attr($button) == 1){ echo 'checked';} ?> value="1"/> <?php _e('Display "Search" button at the bottom', 'mfn-opts'); ?>
				</label>
			</p>

			<?php
		}
	}
}
