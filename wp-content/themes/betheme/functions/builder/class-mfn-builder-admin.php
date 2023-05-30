<?php
/**
 * Muffin Builder 3.0 | Admin
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if( ! class_exists( 'Mfn_Builder_Admin' ) )
{
  class Mfn_Builder_Admin {

		private $fields;
		private $inline_shortcodes = [];
		private $options = [];
		private $theme_options = [];
		private $preview = true; // items preview

	public $global_sections = [];

    private $sizes = [
      '1/6' => '0.1666',
      '1/5' => '0.2',
      '1/4' => '0.25',
      '1/3' => '0.3333',
      '2/5' => '0.4',
      '1/2' => '0.5',
      '3/5' => '0.6',
      '2/3' => '0.6667',
      '3/4' => '0.75',
      '4/5' => '0.8',
      '5/6' => '0.8333',
      '1/1' => '1',
      'divider' => '1'
    ];

    private $values_postfixes = array(
    	'font-size' => 'px'
    );

    private $additional_styles = array(
    	'font-size' => 'line-height: 1.3em;'
    );
    /**
     * Constructor
     */

    public function __construct( $ajax = false ) {

			// get builder options
			$this->options = Mfn_Builder_Helper::get_options();
			$this->theme_options['style'] = mfn_opts_get('style','');

			// skip other constructor actions for ajax requests
			if( $ajax ){
				return true;
			}

      // first action hooked into the admin scripts actions
      if( empty( $_GET['action'] ) || $_GET['action'] != 'mfn-live-builder' ){
  			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
  		}

			// get inline shortcodes
			$this->inline_shortcodes = Mfn_Builder_Fields::get_inline_shortcode();

    }

		/**
		 * SET builder fields
		 */

		public function set_fields(){

			$this->fields = new Mfn_Builder_Fields( );

		}

    /**
  	 * Enqueue styles and scripts
  	 */

    public function enqueue()
  	{
			// Rank Math plugin support

			if( class_exists('RankMath') ){
				wp_enqueue_script( 'rank-math-integration', get_theme_file_uri( '/functions/builder/assets/rank-math-integration.js' ), [ 'wp-hooks' ], MFN_THEME_VERSION, true );
			}

			// builder scripts

  		wp_enqueue_script( 'mfn-builder', get_theme_file_uri( '/functions/builder/assets/builder.js' ), array( 'jquery' ), MFN_THEME_VERSION, true );

  	}

		/**
		 * GET item type
		 */

		public function get_item_placeholder_type( $item ){

			$return = false;

			$array = [
				'standard' => [
					'blog_news', 'blog_slider', 'blog_teaser', 'clients', 'clients_slider', 'offer', 'offer_thumb',
					'portfolio_grid', 'portfolio_photo', 'portfolio_slider', 'shop', 'shop_slider',
				 	'slider', 'testimonials', 'testimonials_list'
				],
				'variable' => [
					'blog', 'portfolio'
				],
			];

			foreach( $array as $type => $items ){
				if( in_array( $item, $items ) ){
					$return = $type;
					break;
				}
			}

			return $return;

		}

    /**
  	 * PRINT single FIELD
  	 */

    public static function field( $field, $value, $type = 'meta', $item_id = false )
  	{
      if( empty( $field['type'] ) ){
        return;
      }

			if( empty( $field['std'] ) ){
        $field['std'] = '';
      }

			// remove empty deprecated fields

			if( ! empty($field['class']) && strpos($field['class'], 'mfn-deprecated') !== false ){
				if( ! $value || ( $value == $field['std'] ) ){
					return;
				}
			}

			// class

			$class = false;
			$row_class = false;
			$row_id = false;
			$conditions = false;

			// class

			if( ! empty( $field['class'] ) ){
				$class = $field['class'];
				$row_class = $field['class'];
			}

			// if( ! empty( $field['id'] ) ){
			// 	$row_class .= ' '. $field['id'];
			// }

			if( ! empty( $field['row_class'] ) ){
				$row_class .= ' '. $field['row_class'];
			}

			// id

			if( ! empty( $field['attr_id'] ) ){
				$row_id = 'id="'. $field['attr_id'] .'" ';
			}

			// conditions

			if( isset( $field['condition'] ) ){

				if( is_array( $field['condition']['val'] ) ){
					$field['condition']['val'] = implode( ',', $field['condition']['val'] );
				}

				$row_class .= ' activeif activeif-'. $field['condition']['id'];
				$conditions = 'data-conditionid="'. $field['condition']['id'] .'" data-opt="'. $field['condition']['opt'] .'" data-val="'. $field['condition']['val'] .'"';

			}

			// item id for tabs field only

			$field['uid'] = $item_id;

			// output -----

			if( 'info' == $field['type'] ){

				require_once( get_template_directory() .'/muffin-options/fields/info/field_info.php' );

				if ( class_exists( 'MFN_Options_info' ) ) {
					$field_object = new MFN_Options_info( $field, $value );
					$field_object->render( $type );
				}

				return true;
			}

			// return true;

			if( 'no-row' != $class ){

			echo '<div class="mfn-form-row mfn-row '. esc_attr( $row_class ) .'" '. $row_id .' '. $conditions .'>';

        echo '<div class="row-column row-column-2">';
          echo '<label class="form-label">'. esc_html( isset($field['title']) ? $field['title'] : '' ) .'</label>';
					if( ! empty($field['responsive']) ){
						Mfn_Options_field::get_responsive_swither($field['responsive']);
					}
        echo '</div>';

        echo '<div class="row-column row-column-10">';
          echo '<div class="form-content '. esc_attr( $class ) .'">';

			}

			$field_class = 'MFN_Options_'. $field['type'];
			require_once( get_template_directory() .'/muffin-options/fields/'. $field['type'] .'/field_'. $field['type'] .'.php' );

			if ( class_exists( $field_class ) ) {

				$field_object = new $field_class( $field, $value );

				// visual builder

				if( 'vb' == $item_id ){
					$field_object->render( $type, true );
				} else {
					$field_object->render( $type );
				}

			}

			if( 'no-row' != $class ){

					echo '</div>';
        echo '</div>';

      echo '</div>';

			}

  	}

    /**
  	 * PRINT single SECTION
  	 */

    public function section( $section = false, $deprecated = false )
  	{

  		// change section visibility

			$mfn_global_section_id = false;
			$class = [];
			$label = [
				'hide' => __('Hide section', 'mfn-opts'),
				'collapse' => __('Collapse section', 'mfn-opts'),
			];

  		if ( ! empty( $section['attr']['hide'] ) ) {
  			$class[] = 'hide';
  			$label['hide'] = __('Show section', 'mfn-opts');
  		}

  		if ( ! empty( $section['attr']['collapse'] ) ) {
  			$class[] = 'collapse';
				$label['collapse'] = __('Expand section', 'mfn-opts');
			}

			if( empty( $section['wraps'] ) && empty( $section['items'] ) ){
				// FIX | Muffin Builder 2 compatibility | empty( $section['items'] )
				$class[] = 'empty';
			}

			// section styles

			if( ! empty( $section['attr']['style'] ) ){
				if( strpos( $section['attr']['style'], 'full-' ) !== false ){
					$class[] = 'full-width';
				}
			}

			// class

			$class = implode(' ', $class);

  		// attributes

  		if ( ! empty( $section['attr']['title'] ) ) {
  			$title = $section['attr']['title'];
  		} else {
  			$title = '';
  		}

			if ( ! empty( $section['attr']['custom_id'] ) ) {
  			$hash = '#'. $section['attr']['custom_id'];
  		} else if ( ! empty( $section['attr']['section_id'] ) ) {
  			$hash = '#'. $section['attr']['section_id'];
  		} else {
  			$hash = '';
  		}

		  //be sections global pbl
		 if( !empty($section['mfn_global_section_id']) ) {
			$mfn_global_section_id = $section['mfn_global_section_id'];
			$class .= ' mfn-global-section';

			$title .= ' Global section';
		 }



			// uid

			if( ! empty( $section['uid'] ) ){
				$uid = $section['uid'];
			} else {
				$uid = Mfn_Builder_Helper::unique_ID();
			}

  		// output -----

			echo '<div class="mfn-section mfn-element '. esc_attr( $class ) .'" data-type="section" data-title="'. esc_html__('Section', 'mfn-opts') .'">';

				echo '<input type="hidden" class="mfn-section-id mfn-element-data" name="mfn-section-id[]" value="'. esc_attr( $uid ) .'" />';

				// section | global section edit button
				if( !empty($section['mfn_global_section_id']) ) {
					echo '<a href="edit.php?post_type=template&tab=section" target="_blank" data-tooltip="Edit Global Section" class="btn-edit-section" data-position="before">Edit Global Section</a>';
				}

				// section | add new before

        echo '<a href="#" class="btn-section-add mfn-icon-add-light mfn-section-add siblings prev" data-position="before">'. esc_html__('Add section', 'mfn-opts') .'</a>';

				// section | header

        echo '<div class="mfn-header mfn-header-green header-large">';

          echo '<div class="options-group">';

            echo '<a class="mfn-option-btn mfn-option-text mfn-option-green btn-large mfn-wrap-add" title="'. esc_html__('Add wrap', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">'. esc_html__('Wrap', 'mfn-opts') .'</span></a>';
            echo '<a class="mfn-option-btn mfn-option-text mfn-option-green btn-large mfn-divider-add" title="'. esc_html__('Add divider', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">'. esc_html__('Divider', 'mfn-opts') .'</span></a>';

					  echo '<div class="header-label">';
	            echo '<span class="header-label-title">'. esc_html( $title ) .'</span>';
	            echo '<span class="header-label-hashtag">'. esc_html( $hash ) .'</span>';
            echo '</div>';

          echo '</div>';

          echo '<div class="options-group">';

            echo '<div class="mfn-option-dropdown dropdown-large">';

							echo '<a class="mfn-option-btn mfn-option-green  btn-large" title="'. esc_html__('Info', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-information"></span></a>';

							echo '<div class="dropdown-wrapper mfn-section-info">';

								$hide = [
									'style' => 'hide',
									'custom' => 'hide',
									'class' => 'hide',
								];

								$attr = [];

								$keys = [
									'bg_image' => 'style:.mcb-section-mfnuidelement:background-image',
									'bg_color' => 'style:.mcb-section-mfnuidelement:background-color',
									'bg_position' => 'style:.mcb-section-mfnuidelement:background-position',
									'style' => 'style',
									'class' => 'classes',
									'section_id' => 'custom_id',
									'mfn_global_section_id' => '',
								];

								foreach( $keys as $key_old => $key_new ){
									if( ! empty( $section['attr'][$key_old] ) ){
										$attr[$key_old] = trim($section['attr'][$key_old]);
									} elseif( ! empty( $section['attr'][$key_new] ) ) {
										$attr[$key_old] = trim($section['attr'][$key_new]);
									} else {
										$attr[$key_old] = '';
									}
								}

								if( ! empty( $attr['bg_position'] ) ){
									if( 'no-repeat;center top;fixed;;still' == $attr['bg_position'] ){
					          $attr['bg_position'] = 'fixed';
					        } else if( 'no-repeat;center;fixed;cover;still' == $attr['bg_position'] ){
					          $attr['bg_position'] = 'fixed';
					        } else if( 'no-repeat;center top;fixed;cover' == $attr['bg_position'] ){
					          $attr['bg_position'] = 'parallax';
					        } else {
										$attr['bg_position'] = explode(';', $attr['bg_position']);
					          if( ! empty($attr['bg_position'][1]) ){
					          	$attr['bg_position'] = $attr['bg_position'][1];
					          } else {
					          	$attr['bg_position'] = $attr['bg_position'][0];
					          }
					        }
								}

								if( $attr['style'] ){
									$attr['style'] = explode(' ', $attr['style']);
									$hide['style'] = false;
								}

								if( $attr['class'] ){
									$hide['class'] = false;
								}

								if( $attr['class'] || $attr['section_id'] ){
									$hide['custom'] = false;
								}

								echo '<div class="dropdown-group dropdown-group-background">';

									echo '<h6>'. esc_html__('Background', 'mfn-opts') .'</h6>';

									echo '<div class="background-image mfn-info-bg-color-preview">';
										echo '<img class="mfn-info-bg-image" src="'. esc_url( $attr['bg_image'] ) .'" alt="" />';
									echo '</div>';

									echo '<div class="inner-grid background">';

										echo '<div class="column">';
											echo '<p><span class="label">'. esc_html__('Color', 'mfn-opts') .'</span></p>';
											echo '<p><span class="mfn-icon mfn-color-preview mfn-info-bg-color-preview" style="background-color:'. esc_attr( $attr['bg_color'] ) .'"></span><span class="mfn-info-bg-color">'. esc_html( $attr['bg_color'] ) .'</span></p>';
										echo '</div>';

										echo '<div class="column">';
											echo '<p><span class="label">'. esc_html__('Position', 'mfn-opts') .'</span></p>';
											echo '<p class="mfn-info-bg-position">'. esc_html( $attr['bg_position'] ) .'</p>';
										echo '</div>';

									echo '</div>';

								echo '</div>';

								echo '<div class="dropdown-group dropdown-group-style '. esc_attr( $hide['style'] ).'">';

									echo '<h6>'. esc_html__('Style', 'mfn-opts') .'</h6>';

									echo '<ul class="mfn-info-style">';

										if( is_array( $attr['style'] ) ){
											foreach( $attr['style'] as $style ){
												echo '<li>'. esc_html( mfna_section_style( $style ) ) .'</li>';
											}
										}

									echo '</ul>';

								echo '</div>';

								echo '<div class="dropdown-group dropdown-group-custom '. esc_attr( $hide['custom'] ).'">';

									echo '<h6>'. esc_html__('Custom', 'mfn-opts') .'</h6>';

									echo '<p><span class="label">'. esc_html__('Class', 'mfn-opts') .':</span> <span class="mfn-info-custom-class '. esc_attr( $hide['class'] ).'">'. esc_html( $attr['class'] ) .'</span></p>';
									echo '<p><span class="label">'. esc_html__('ID', 'mfn-opts') .':</span> <span class="mfn-info-custom-id">'. esc_html( $attr['section_id'] ) .'</span></p>';

								echo '</div>';

              echo '</div>';

            echo '</div>';

            echo '<a class="mfn-option-btn mfn-option-green btn-large mfn-element-edit" title="'. esc_html__('Edit', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-edit"></span></a>';
            echo '<a class="mfn-option-btn mfn-option-green btn-large mfn-section-clone" title="'. esc_html__('Clone', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-clone"></span></a>';
            echo '<a class="mfn-option-btn mfn-option-green btn-large mfn-element-delete" title="'. esc_html__('Delete', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';

						echo '<div class="mfn-option-dropdown">';

              echo '<a class="mfn-option-btn mfn-option-green btn-large" title="'. esc_html__('More', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-more"></span></a>';

						  echo '<div class="dropdown-wrapper">';

                echo '<h6>'. esc_html__('Actions', 'mfn-opts') .'</h6>';
                echo '<a class="mfn-dropdown-item mfn-section-hide" href="#" data-show="'. esc_html('Show section', 'mfn-opts') .'" data-hide="'. esc_html('Hide section', 'mfn-opts') .'"><span class="mfn-icon mfn-icon-hide"></span><span class="mfn-icon mfn-icon-show"></span><span class="label">'. esc_html( $label['hide'] ) .'</span></a>';
                echo '<a class="mfn-dropdown-item mfn-section-collapse" href="#" data-show="'. esc_html('Expand section', 'mfn-opts') .'" data-hide="'. esc_html('Collapse section', 'mfn-opts') .'"><span class="mfn-icon mfn-icon-arrow-up"></span><span class="mfn-icon mfn-icon-arrow-down"></span><span class="label">'. esc_html( $label['collapse'] ) .'</span></a>';
                echo '<a class="mfn-dropdown-item mfn-section-move-up" href="#"><span class="mfn-icon mfn-icon-move-up"></span> '. esc_html__('Move up', 'mfn-opts') .'</a>';
                echo '<a class="mfn-dropdown-item mfn-section-move-down" href="#"><span class="mfn-icon mfn-icon-move-down"></span> '. esc_html__('Move down', 'mfn-opts') .'</a>';

							  echo '<div class="mfn-dropdown-divider"></div>';

                echo '<h6>'. esc_html__('Copy / Paste', 'mfn-opts') .'</h6>';
                echo '<a class="mfn-dropdown-item mfn-section-copy" href="#"><span class="mfn-icon mfn-icon-export"></span><span class="label">'. esc_html__('Copy section', 'mfn-opts') .'</span></a>';
                echo '<a class="mfn-dropdown-item mfn-section-paste before" href="#"><span class="mfn-icon mfn-icon-import-before"></span><span class="label">'. esc_html__('Paste before', 'mfn-opts') .'</span></a>';
                echo '<a class="mfn-dropdown-item mfn-section-paste after" href="#"><span class="mfn-icon mfn-icon-import-after"></span><span class="label">'. esc_html__('Paste after', 'mfn-opts') .'</span></a>';

							echo '</div>';

            echo '</div>';

          echo '</div>';

        echo '</div>';

				// section | content

        echo '<div class="section-content">';

					// section | sortable

					echo '<div class="mfn-sortable mfn-sortable-section clearfix">';

						// section | new

						echo '<div class="mfn-element mfn-section-new">';

	            echo '<h5>'. esc_html__('Select a wrap layout', 'mfn-opts') .'</h5>';

	            echo '<div class="wrap-layouts">';
	              echo '<div class="wrap-layout wrap-11" data-tooltip="1/1"></div>';
	              echo '<div class="wrap-layout wrap-12" data-tooltip="1/2 | 1/2"><span></span></div>';
	              echo '<div class="wrap-layout wrap-13" data-tooltip="1/3 | 1/3 | 1/3"><span></span><span></span></div>';
	              echo '<div class="wrap-layout wrap-14" data-tooltip="1/4 | 1/4 | 1/4 | 1/4"><span></span><span></span><span></span></div>';
	              echo '<div class="wrap-layout wrap-13-23" data-tooltip="1/3 | 2/3"><span></span></div>';
	              echo '<div class="wrap-layout wrap-23-13" data-tooltip="2/3 | 1/3"><span></span></div>';
	              echo '<div class="wrap-layout wrap-14-12-14" data-tooltip="1/4 | 1/2 | 1/4"><span></span><span></span></div>';
	            echo '</div>';

	            echo '<p>'. esc_html__('or choose from', 'mfn-opts') .'</p>';

	            echo '<a class="mfn-btn mfn-btn-green btn-icon-left mfn-section-pre-built" href="#"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add-light"></span>'. esc_html__('Pre-built sections', 'mfn-opts') .'</span></a>';
	            echo '<a class="mfn-btn mfn-btn-green btn-icon-left mfn-template" href="#"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add-light"></span>'. esc_html__('Templates', 'mfn-opts') .'</span></a>';

						echo '</div>';

						// section | existing content

						if ( $section ){

							//be sections global pbl
							if( $mfn_global_section_id ) {
								$section = get_post_meta($mfn_global_section_id, 'mfn-page-items', true);

								if ( !is_array($section) ) {
									$section = unserialize( call_user_func('base'.'64_decode', $section) );
								}
								$section = $section[0];

								echo '<input type="hidden" class="mfn-section-global mfn-element-data" name="mfn-global-section['. $uid .']" value="'. $mfn_global_section_id  .'" />';
							}


							// FIX | Muffin Builder 2 compatibility
							// there were no wraps inside section in Muffin Builder 2

							if ( ! isset( $section['wraps'] ) && ! empty( $section['items'] ) ) {
								$fix_wrap = array(
									'size' => '1/1',
									'items' => $section['items'],
								);
								$section['wraps'] = array( $fix_wrap );
							}

							// end FIX

							if ( isset( $section['wraps'] ) && is_array( $section['wraps'] ) ) {
								foreach ( $section['wraps'] as $wrap ) {
									$this->wrap( $wrap, $uid );
								}
							}

						}

					echo '</div>';

        echo '</div>';

				// section | meta data

				echo '<div class="mfn-element-meta">';

					// section | meta fields

					$section_fields = $this->fields->get_section();

					foreach ( $section_fields as $field ) {

						if( empty( $field['type'] ) ){

							// row header

							if ( ! isset( $field['class'] ) ) {
								$field['class'] = false;
							}

							Mfn_Post_Type::row_header( $field['title'], $field );

						} elseif( 'html' == $field['type'] ) {

              echo $field['html'];

            } else {

							// field

							// values for existing sections

							if ( isset($field['id']) && isset( $section['attr'][ $field['id'] ] ) ) {
								$value = $section['attr'][ $field['id'] ];
							} else {
								$value = '';
							}

							// default values

							if ( ! isset( $field['std'] ) ) {
								$field['std'] = '';
							}

							if ( ( ! $value ) && ( '0' !== $value ) ) {
								$value = $field['std'];
							}

							// field ID

							if( isset($field['id']) ){
								$field['id'] = 'mfn-section['. $uid .']['. $field['id'] .']';
							}

							// PRINT single FIELD

							$meta = 'filled'; // filled field uses 'name'

							if ( empty( $value ) || ( is_array( $value ) && ! array_filter( $value ) ) ){
								$meta = 'empty'; // 'empty' = field uses 'data-name'
							}

							self::field( $field, $value, $meta );

						}

					}

				echo '</div>';

				// section | add new after

        echo '<a href="#" class="btn-section-add mfn-icon-add-light mfn-section-add siblings next" data-position="after">'. esc_html__('Add section', 'mfn-opts') .'</a>';

			echo '</div>';
  	}

    /**
  	 * PRINT single WRAP
  	 */

  	public function wrap( $wrap = false, $parent_id = false, $deprecated = false )
  	{
			// size

			if( empty( $wrap['size'] ) ){
				$wrap['size'] = '1/1';
			}
			if( empty( $wrap['tablet_size'] ) ){
				$wrap['tablet_size'] = $wrap['size']; // the same as desktop size
			}
			if( empty( $wrap['mobile_size'] ) ){
				$wrap['mobile_size'] = '1/1'; // always 1/1 like in the Muffin Builder 3
			}

  		// wrap ID

			if( ! empty( $wrap['uid'] ) ){
				$uid = $wrap['uid'];
			} else {
				$uid = Mfn_Builder_Helper::unique_ID();
			}

  		// attributes

  		$class = [];

			if( empty( $wrap['items'] ) ){
				$class[] = 'empty';
			}

  		if ( 'divider' == $wrap['size'] ) {
  			$class[] = 'divider';
  		}

		//be sections global pbl

		$is_global_wrap = !empty($wrap['attr']['global_wraps_select']);
		if( $is_global_wrap ) {
			$mfn_global_wrap_id = $wrap['attr']['global_wraps_select'];
			$class[] = 'mfn-global-wrap';
		}

			$class = implode(' ', $class);

  		// output -----

			  echo '<div class="mfn-wrap mfn-element '. esc_attr( $class ) .'" data-size="'. esc_attr( $this->sizes[ $wrap['size'] ] ) .'" data-type="wrap" data-title="'. esc_html__('Wrap', 'mfn-opts') .'" data-title-divider="'. esc_html__('Divider', 'mfn-opts') .'">';

				if( $is_global_wrap ){
					echo '<a href="edit.php?post_type=template&tab=wrap" target="_blank" data-tooltip="Edit Global Wrap" class="btn-edit-wrap" data-position="before">Edit Global Wrap</a>';
				}

				echo '<input type="hidden" class="mfn-wrap-id mfn-element-data" name="mfn-wrap-id[]" value="'. esc_attr( $uid ) .'" />';
				echo '<input type="hidden" class="mfn-wrap-parent mfn-element-data" name="mfn-wrap-parent[]" value="'. esc_attr( $parent_id ) .'" />';
				echo '<input type="hidden" class="mfn-wrap-size mfn-element-size mfn-element-data" name="mfn-wrap-size[]" value="'. esc_attr( $wrap['size'] ) .'" />';
				echo '<input type="hidden" class="mfn-wrap-size mfn-element-size mfn-element-data" name="mfn-wrap-size-tablet[]" value="'. esc_attr( $wrap['tablet_size'] ) .'" />';
				echo '<input type="hidden" class="mfn-element-data" name="mfn-wrap-size-mobile[]" value="'. esc_attr( $wrap['mobile_size'] ) .'" />';

				// wrap | header

				echo '<div class="wrap-header mfn-header mfn-header-grey">';
					echo '<a class="mfn-option-btn mfn-option-grey mfn-size-decrease" title="'. esc_html__('Decrease', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-dec"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-grey mfn-size-increase" title="'. esc_html__('Increase', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-inc"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-text mfn-option-grey mfn-size" title="'. esc_html__('Size', 'mfn-opts') .'"><span class="text mfn-element-size-label">'. esc_attr( $wrap['size'] ) .'</span></a>';
					echo '<a class="mfn-option-btn mfn-option-text btn-icon-left mfn-option-grey mfn-item-add" title="'. esc_html__('Add element', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">'. esc_html__('Element', 'mfn-opts') .'</span></a>';
					echo '<a class="mfn-option-btn mfn-option-grey mfn-element-edit" title="'. esc_html__('Edit', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-edit"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-grey mfn-wrap-clone" title="'. esc_html__('Clone', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-clone"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-grey mfn-element-delete" title="'. esc_html__('Delete', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
				echo '</div>';

				// wrap | content

				echo '<div class="wrap-content clearfix">';

					echo '<div class="mfn-wrap-new">';
						echo '<a href="#" class="mfn-item-add mfn-btn btn-icon-left btn-small mfn-btn-blank2" data-position="before"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add"></span>'. esc_html__('Add element', 'mfn-opts') .'</span></a>';
					echo '</div>';

					// wrap | sortable

					echo '<div class="mfn-sortable mfn-sortable-wrap clearfix">';

						// wrap | existing content

						//be sections global pbl
						if( $is_global_wrap ) {
							$section = get_post_meta($mfn_global_wrap_id, 'mfn-page-items', true);

							if ( !is_array($section) ) {
								$section = unserialize( call_user_func('base'.'64_decode', $section) );
							}

							$wrap['items'] = $section[0]['wraps'][0]['items'];
						}

						if ( isset( $wrap['items'] ) && is_array( $wrap['items'] ) ) {
  						foreach ( $wrap['items'] as $item ) {
  							$this->item( $item['type'], $item, $uid );
  						}
  					}

					echo '</div>';

					echo '<div class="mfn-wrap-new">';
						echo '<a href="#" class="mfn-item-add mfn-btn btn-icon-left btn-small mfn-btn-blank2" data-position="after"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add"></span>'. esc_html__('Add element', 'mfn-opts') .'</span></a>';
					echo '</div>';

				echo '</div>';

				// wrap | meta

				echo '<div class="mfn-element-meta">';

					// wrap | meta fields

					$wrap_fields = $this->fields->get_wrap();

					foreach ( $wrap_fields as $field ) {

						if( empty( $field['type'] ) ){

							// row header

							if ( ! isset( $field['class'] ) ) {
								$field['class'] = false;
							}

							Mfn_Post_Type::row_header( $field['title'], $field );

						} elseif( 'html' == $field['type'] ) {

              echo $field['html'];

						} else {

							// field

							// values for existing wraps

							if ( isset( $field['id'] ) && isset( $wrap['attr'][ $field['id'] ] ) ) {
								$value = $wrap['attr'][ $field['id'] ];
							} else {
								$value = '';
							}

							// default values

							if ( ! isset( $field['std'] ) ) {
								$field['std'] = '';
							}

							if ( ( ! $value ) && ( '0' !== $value ) ) {
								$value = $field['std'];
							}

							// field ID

							if( isset($field['id']) ){
								$field['id'] = 'mfn-wrap['. $uid .']['. $field['id'] .']';
							}

							// PRINT single FIELD

							$meta = 'filled'; // filled field uses 'name'

							if ( empty( $value ) || ( is_array( $value ) && ! array_filter( $value ) ) ){
								$meta = 'empty'; // 'empty' = field uses 'data-name'
							}

							self::field( $field, $value, $meta );

						}

					}

				echo '</div>';

			echo '</div>';
  	}

    /**
  	 * PRINT single ITEM
  	 */

  	public function item( $item_type, $item = false, $parent_id = false, $deprecated = false )
  	{

  		$item_fields = $this->fields->get_item_fields( $item_type );

			// size

			if( empty( $item['size'] ) ){
				$item['size'] = $item_fields['size'];
			}
			if( empty( $item['tablet_size'] ) ){
				$item['tablet_size'] = $item['size']; // the same as desktop size
			}
			if( empty( $item['mobile_size'] ) ){
				$item['mobile_size'] = '1/1'; // always 1/1 like in the Muffin Builder 3
			}

  		// item ID

			if( ! empty( $item['uid'] ) ){
				$uid = $item['uid'];
			} else {
				$uid = Mfn_Builder_Helper::unique_ID();
			}

			// label

			$label = false;

			if( ! empty( $item['fields']['title'] ) ){
				$label = $item['fields']['title'];
			}

			// google fonts used in the inline editor: blockquote, colum, visual

			if( empty($item['used_fonts']) ){
				$item['used_fonts'] = '';
			};

  		// output -----

			echo '<div class="mfn-item mfn-element mfn-item-'. esc_attr( $item_fields['type'] ) .' mfn-cat-'. esc_attr( $item_fields['cat'] ) .' mfn-card mfn-card-small mfn-shadow-1" data-size="'. esc_attr( $this->sizes[$item['size']] ) .'" data-type="'. esc_attr( $item_fields['type'] ) .'" data-title="'. esc_attr( $item_fields['title'] ) .'">';

				echo '<input type="hidden" class="mfn-item-type mfn-element-data" name="mfn-item-type[]" value="'. esc_attr( $item_fields['type'] ) .'">';
				echo '<input type="hidden" class="mfn-item-id mfn-element-data" name="mfn-item-id[]" value="'. esc_attr( $uid ) .'" />';
				echo '<input type="hidden" class="mfn-item-parent mfn-element-data" name="mfn-item-parent[]" value="'. esc_attr( $parent_id ) .'" />';
				echo '<input type="hidden" class="mfn-item-size mfn-element-size mfn-element-data" name="mfn-item-size[]" value="'. esc_attr( $item['size'] ) .'">';
				echo '<input type="hidden" class="mfn-item-size mfn-element-size mfn-element-data" name="mfn-item-size-tablet[]" value="'. esc_attr( $item['tablet_size'] ) .'">';
				echo '<input type="hidden" class="mfn-element-data" name="mfn-item-size-mobile[]" value="'. esc_attr( $item['mobile_size'] ) .'">';
				echo '<input type="hidden" class="mfn-element-data" name="mfn-item-fonts[]" value="'. esc_attr( $item['used_fonts'] ) .'">';

				echo '<div class="item-header mfn-header mfn-header-blue">';
					echo '<a class="mfn-option-btn mfn-option-blue mfn-size-decrease" title="Decrease" href="#"><span class="mfn-icon mfn-icon-dec"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-blue mfn-size-increase" title="Increase" href="#"><span class="mfn-icon mfn-icon-inc"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-text mfn-option-blue mfn-size" title="Size" href="#"><span class="text mfn-element-size-label">'. esc_attr( $item['size'] ) .'</span></a>';
					echo '<a class="mfn-option-btn mfn-option-blue mfn-element-edit" title="Edit" href="#"><span class="mfn-icon mfn-icon-edit"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-blue mfn-item-clone" title="Clone" href="#"><span class="mfn-icon mfn-icon-clone"></span></a>';
					echo '<a class="mfn-option-btn mfn-option-blue mfn-element-delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
				echo '</div>';

				echo '<div class="card-header">';
					echo '<div class="card-title-group">';
						echo '<span class="card-icon"></span>';
						echo '<div class="card-desc">';
							echo '<h5 class="card-title">'. esc_html( $item_fields['title'] ) .'</h5>';
							echo '<p class="card-subtitle mfn-item-label">'. esc_html( $label ) .'</p>';
						echo '</div>';
					echo '</div>';
				echo '</div>';

				// item preview

				if( $this->preview ){

					$preview = [
						'image' => '',
						'title' => '',
						'subtitle' => '',
						'content' => '',
						'style' => '',
						'number' => '',
						'category' => '',
						'category-all' => '',
						'icon' => '',
						'tabs' => '',
						'images' => '',
						'align' => '',
					];

					$preview_empty = [];
					$preview_tabs_primary = 'title';

					foreach ( $item_fields['fields'] as $field ) {
						if ( isset( $field['preview'] ) ){

							$prev_key = $field['preview'];
							$prev_id = $field['id'];

							// existing item or default value

							if( isset( $item['fields'] ) ){

								if( isset( $item['fields'][$prev_id] ) ){
									$preview[$prev_key] = $item['fields'][$prev_id];
								}

								if( 'tabs' === $field['type'] && empty( $item['fields']['tabs'] ) ){
									$preview[$prev_key] = '';
								}

							} elseif( ! empty( $field['std'] ) ){

								$preview[$prev_key] = $field['std'];

								if ( empty( $this->options['pre-completed'] ) ){
									if ( in_array( $field['type'], ['tabs', 'text', 'textarea', 'upload'] ) ){
										$preview[$prev_key] = '';
									}
								}

							}

							// tabs

							if( 'tabs' == $field['preview'] ){
								if( ! empty( $field['primary'] ) ){
									$preview_tabs_primary = $field['primary'];
								}
							}

							// category

							if( 'category' == $field['preview'] ){

								if( $preview['category'] ){

									$cat_obj = get_category_by_slug( $preview['category'] );

									if( is_object( $cat_obj ) ){
										$preview['category'] = $cat_obj->name;
									} else {
										$preview['category'] = 'All';
									}

								} else {
									$preview['category'] = 'All';
								}

							}

						}
					}

					// multiple categories

					if ( $preview['category-all'] ){
						$preview['category'] = $preview['category-all'];
					}

					// icon

					if ( in_array( $item_type, ['counter','icon_box','list'] ) && $preview['image'] ){
						// image replaces icon in some items
						$preview['icon'] = '';
					}

					// SVG placeholder

					if ( in_array( $item_type, ['map','map_basic'] ) ){
						$preview['image'] = get_theme_file_uri( '/muffin-options/svg/placeholders/map.svg' );
					}

					if ( in_array( $item_type, ['code','content','fancy_divider','sidebar_widget','slider_plugin','video'] ) ){
						$preview['image'] = get_theme_file_uri( '/muffin-options/svg/placeholders/'. $item_type .'.svg' );
					}

					// empty

					foreach( $preview as $prev_key => $prev_val ){
						if( $prev_val ){
							$preview_empty[ $prev_key ] = '';
						} else {
							$preview_empty[ $prev_key ] = 'empty';
						}
					}

					// content limit

					if ( $preview['content'] ){

						$excerpt = $preview['content'];

						if ( in_array( $item_type, ['column', 'visual'] ) ){

							// remove unwanted HTML tags
							$excerpt = wp_kses( $excerpt, Mfn_Builder_Helper::allowed_html() );

							// wrap shortcodes into span to highlight
							$excerpt = preg_replace( '/(\[(.*?)?\[\/)((.*?)?\])|(\[(.*?)?\])/', '<span class="item-preview-shortcode">$0</span>', $excerpt);

							// autoclose tags
							$excerpt = force_balance_tags( $excerpt );

						} else {

							$excerpt = strip_shortcodes( strip_tags( $excerpt ) );

							$excerpt = preg_split( '/\b/', $excerpt, 16 * 2 + 1 );

							array_pop( $excerpt );
							$excerpt = implode( $excerpt );

							if( strlen( $excerpt ) < strlen( $preview['content'] ) ){
								$excerpt = $excerpt .'...';
							}

						}

						$preview['content'] = $excerpt;

					}

					echo '<div class="card-content item-preview align-'. esc_attr( $preview['align'] ) .'">';

						echo '<div class="preview-group image '. esc_attr( $preview_empty['image'] ) .'">';
							echo '<img class="item-preview-image" src="'. esc_url( $preview['image'] ) .'" />';
						echo '</div>';

						echo '<div class="preview-group content">';

							echo '<p class="item-preview-title '. esc_attr( $preview_empty['title'] ) .'">'. esc_html( $preview['title'] ) .'</p>';
							echo '<p class="item-preview-subtitle '. esc_attr( $preview_empty['subtitle'] ) .'">'. esc_html( $preview['subtitle'] ) .'</p>';
							echo '<div class="item-preview-content '. esc_attr( $preview_empty['content'] ) .'">'. $preview['content'] .'</div>';

							echo '<p class="item-preview-placeholder-parent">';

								$placeholder_type = $this->get_item_placeholder_type( $item_type );

								if( 'standard' == $placeholder_type ){

									$placeholder = get_theme_file_uri( '/muffin-options/svg/placeholders/'. $item_type .'.svg' );
									echo '<img class="item-preview-placeholder" src="'. esc_url( $placeholder ) .'" />';

								} elseif ( 'variable' == $placeholder_type ) {

									// existing item or default value

									if( isset( $item['fields'] ) ){
										$item_style = str_replace( array( ',', ' ' ), '-', $item['fields']['style'] );
									} else {
										$item_style = 'grid';
									}

									$placeholder_dir = get_theme_file_uri( '/muffin-options/svg/select/'. $item_type .'/' );
									$placeholder = $placeholder_dir . $item_style .'.svg';

									echo '<img class="item-preview-placeholder" src="'. esc_url( $placeholder ) .'" data-dir="'. esc_url( $placeholder_dir ) .'"/>';

								}

								echo '<span class="item-preview-number '. esc_attr( $preview_empty['number'] ) .'">'. esc_html( $preview['number'] ) .'</span>';

							echo '</p>';

							echo '<p class="item-preview-icon '. esc_attr( $preview_empty['icon'] ) .'"><i class="'. esc_attr( $preview['icon'] ) .'"></i></p>';
							echo '<p class="item-preview-category-parent '. esc_attr( $preview_empty['category'] ) .'"><span class="label">'. esc_html__('Category', 'mfn-opts') .':</span><span class="item-preview-category">'. esc_html( $preview['category'] ) .'</span></p>';

							echo '<ul class="item-preview-tabs '. esc_attr( $preview_empty['tabs'] ) .'">';
								if ( $preview['tabs'] ){
									foreach ( $preview['tabs'] as $tab ) {
										echo '<li>'. $tab[$preview_tabs_primary] .'</li>';
									}
								}
							echo '</ul>';

							echo '<ul class="item-preview-images '. esc_attr( $preview_empty['images'] ) .'">';
								if ( $preview['images'] ){
									$preview['images'] = explode( ',', $preview['images'] );
									foreach ( $preview['images'] as $image ){
										echo '<li>'. wp_get_attachment_image( $image, 'thumbnail' ) .'</li>';
									}
								}
							echo '</ul>';

						echo '</div>';

					echo '</div>';

				}

				// item | meta

				echo '<div class="mfn-element-meta">';

					// item | meta fields

					foreach ( $item_fields['fields'] as $field ) {

						if ( ! isset( $field['class'] ) ) {
							$field['class'] = '';
						}

						// hide fields for specified style: simple/classic

						if( isset( $field['themeoptions'] ) ){
							$themeoption = explode(':', $field['themeoptions']);
							if( isset($themeoption[1]) ){
								if( $this->theme_options['style'] != $themeoption[1] ){
									continue;
								}else{
									$field['class'] .= empty( $this->theme_options['style'] ) ? ' theme-classic-style' : ' theme-simple-style';
								}
							}
						}

						if( empty( $field['type'] ) ){

							// row header

							Mfn_Post_Type::row_header( $field['title'], $field );

						} elseif( 'html' == $field['type'] ) {

							echo $field['html'];

						} else {

							$value = '';

							// existing item or default value

							if( isset( $item['fields'] ) ){

								if( isset( $field['id'] ) && isset( $item['fields'][ $field['id'] ] ) ){
									$value = $item['fields'][ $field['id'] ];
								}

								if( 'tabs' === $field['type'] && empty( $item['fields']['tabs'] ) ){
									$value = [];
								}

							} else {

								if ( isset( $field['std'] ) ){
									$value = $field['std'];
								}

								if ( empty( $this->options['pre-completed'] ) ){
									if ( in_array( $field['type'], ['text', 'textarea', 'upload'] ) ){
										$value = '';
									}
									if ( 'tabs' === $field['type'] ){
										$value = [];
									}
								}

							}

							// field ID

							if( isset($field['id']) ){
								$field['id'] = 'mfn-item['. $uid .']['. $field['id'] .']';
							}

							// PRINT single FIELD

							$meta = 'filled'; // filled field uses 'name'

							if ( empty( $value ) || ( is_array( $value ) && ! array_filter( $value ) ) ){
								$meta = 'empty'; // 'empty' = field uses 'data-name'
							}

							self::field( $field, $value, $meta );

						}

					}

				echo '</div>';

			echo '</div>';
  	}

    /**
     * PRINT Muffin Builder
     */

    public function show()
    {
      global $post;

			// disable BeBuilder Blocks for some template types

      if( get_post_type($post->ID) == 'template' && get_post_meta($post->ID, 'mfn_template_type', true) && in_array( get_post_meta($post->ID, 'mfn_template_type', true), array('header', 'footer', 'megamenu') ) ){
      	return;
      }

			// hide builder if current user does not have a specific capability

      if ( $visibility = mfn_opts_get( 'builder-visibility' ) ) {
        if ( $visibility == 'hide' || ( ! current_user_can( $visibility ) ) ) {
          return false;
        }
      }

			// disable BeBuilder Blocks in Theme options

			if( ! mfn_opts_get('builder-blocks') ){
				if( apply_filters('bebuilder_access', false) ){
					echo '<div class="bebuilderblocks-disabled">';
						echo '<a href="post.php?post='. $post->ID .'&amp;action=mfn-live-builder" class="mfn-live-edit-page-button mfn-switch-live-editor">Edit with '. apply_filters('betheme_label', 'Be') .'Builder</a>';
						echo '<p>If you prefer our classic builder, you can enable it in<br/><a target="_blank" href="admin.php?page='. apply_filters('betheme_slug', 'be') .'-options#advanced">Theme Options > Global > Advanced > BeBuilder Blocks</a></p>';
					echo '</div>';
				}
				return;
			}

			$items = $this->fields->get_items(); // default items

			// check if disable items preview

			$theme_disable = mfn_opts_get( 'theme-disable' );

			if( ! empty( $theme_disable['builder-preview'] ) ){
				$this->preview = false;
			}

      // GET items

      $mfn_items = get_post_meta($post->ID, 'mfn-page-items', true);

      // FIX | Muffin Builder 2 compatibility

      if ($mfn_items && ! is_array($mfn_items)) {
        $mfn_items = unserialize(call_user_func('base'.'64_decode', $mfn_items));
      }

      // debug

			// echo '<pre>';
      // print_r( $mfn_items );
			// echo '</pre>';
			// exit;

			// builder classes

			$class = [];

			if( ! is_array( $mfn_items ) ){
				$class[] = 'empty';
			}

			if( is_array( $this->options ) ){
				foreach( $this->options as $option_id => $option_val ){
					if( $option_val ){
						$class[] = $option_id;
					}
				}
			}

			$class = implode( ' ', $class )

      ?>

			<input type="hidden" name="mfn-items-save" value="1"/>

			<div id="mfn-builder" class="mfn-ui mfn-builder <?php echo esc_attr( $class ); ?>" data-label="<?php echo apply_filters('betheme_label', 'Be') ?>" data-slug="<?php echo apply_filters('betheme_slug', 'mfn') ?>" data-tutorial="<?php echo apply_filters('betheme_disable_support', '0') ?>">

				<div class="mfn-menu">
	        <div class="mfn-menu-inner">

            <?php
							$logo = '<div class="mfnb-logo">BeBuilder - Powered by Muffin Group</div>';
							$logo = apply_filters('betheme_logo', $logo);

							echo $logo;
						?>

            <nav id="main-menu">
              <ul>
                <li class="mfn-menu-page"><a data-tooltip="<?php esc_html_e('Single page import', 'mfn-opts'); ?>" data-position="left" href="#"><?php esc_html_e('Single page import', 'mfn-opts'); ?></a></li>
                <li class="mfn-menu-sections"><a data-tooltip="<?php esc_html_e('Pre-built sections', 'mfn-opts'); ?>" data-position="left" href="#"><?php esc_html_e('Pre-built sections', 'mfn-opts'); ?></a></li>
                <li class="mfn-menu-revisions"><a data-tooltip="<?php esc_html_e('History', 'mfn-opts'); ?>" data-position="left" href="#"><?php esc_html_e('History', 'mfn-opts'); ?></a></li>
                <li class="mfn-menu-export"><a data-tooltip="<?php esc_html_e('Export / Import', 'mfn-opts'); ?>" data-position="left" href="#"><?php esc_html_e('Export / Import', 'mfn-opts'); ?></a></li>
              </ul>
            </nav>

            <nav id="settings-menu">
              <ul>
                <li class="mfn-menu-preview"><a data-tooltip="<?php esc_html_e('Preview', 'mfn-opts'); ?>" data-position="left" href="<?php echo get_preview_post_link(); ?>"><?php esc_html_e('Preview', 'mfn-opts'); ?></a></li>
                <li class="mfn-menu-settings"><a data-tooltip="<?php esc_html_e('Settings', 'mfn-opts'); ?>" data-position="left" href="#"><?php esc_html_e('Settings', 'mfn-opts'); ?></a></li>
              </ul>
            </nav>

	        </div>
		    </div>

        <div class="mfn-wrapper">

					<div class="mfn-section-start">
            <img alt="" src="<?php echo get_theme_file_uri( 'muffin-options/svg/welcome.svg' ); ?>" width="120">
            <h2><?php esc_html_e('Welcome to ', 'mfn-opts'); echo apply_filters('betheme_label', 'Be') ?>Builder</h2>
            <a class="mfn-btn mfn-btn-green btn-icon-left btn-large mfn-section-add" href="#"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add-light"></span><?php esc_html_e('Start creating', 'mfn-opts'); ?></span></a>
            <?php if( !apply_filters('betheme_disable_support', false) ): ?>
							<p><a class="view-tutorial" target="_blank" href="https://support.muffingroup.com/video-tutorials/an-overview-of-muffin-builder-3/"><?php esc_html_e('View tutorial', 'mfn-opts'); ?></a></p>
						<?php endif; ?>
					</div>

          <div id="mfn-desk" class="clearfix">

            <?php
              // print_r($mfn_items);

              if (is_array($mfn_items)) {
                foreach ($mfn_items as $section) {
                  $this->section($section);
                }
              }
            ?>

          </div>

        </div>

				<!-- modal: add element -->

				<div class="mfn-modal modal-add-items">
				  <div class="mfn-modalbox mfn-form mfn-shadow-1">

				    <div class="modalbox-header">

				      <div class="options-group">
				        <div class="modalbox-title-group">
				          <span class="modalbox-icon mfn-icon-add-big"></span>
				          <div class="modalbox-desc">
				            <h4 class="modalbox-title"><?php esc_html_e('Add element', 'mfn-opts'); ?></h4>
				          </div>
				        </div>
				      </div>

				      <div class="options-group">
				        <div class="modalbox-search">
				          <div class="form-control">
				            <input class="mfn-form-control mfn-form-input mfn-search" type="text" placeholder="<?php esc_html_e('Search', 'mfn-opts'); ?>">
				          </div>
				        </div>
				      </div>

				      <div class="options-group right">
				        <ul class="modalbox-tabs">
									<li data-filter="*" class="active"><a href="#"><?php esc_html_e('All', 'mfn-opts'); ?></a></li>

									<li data-filter="shop-archive"><a href="#"><?php esc_html_e('Shop', 'mfn-opts'); ?></a></li>
									<li data-filter="single-product"><a href="#"><?php esc_html_e('Product', 'mfn-opts'); ?></a></li>

									<li data-filter="typography"><a href="#"><?php esc_html_e('Typography', 'mfn-opts'); ?></a></li>
									<li data-filter="boxes"><a href="#"><?php esc_html_e('Boxes', 'mfn-opts'); ?></a></li>
									<li data-filter="blocks"><a href="#"><?php esc_html_e('Blocks', 'mfn-opts'); ?></a></li>
									<li data-filter="elements"><a href="#"><?php esc_html_e('Elements', 'mfn-opts'); ?></a></li>
									<li data-filter="loops"><a href="#"><?php esc_html_e('Loops', 'mfn-opts'); ?></a></li>
									<li data-filter="other"><a href="#"><?php esc_html_e('Other', 'mfn-opts'); ?></a></li>
				        </ul>
				      </div>

				      <div class="options-group">
				        <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
				      </div>

				    </div>

				    <div class="modalbox-content">
				      <ul class="modalbox-items mfn-items-list clearfix">

								<?php
									foreach ( $items as $item ) {

										$deprecated = ! empty( $item['deprecated'] ) ? 'data-tooltip="This element is deprecated. Please use '. $item['deprecated'] .' element instead."' : '';

										echo '<li class="mfn-item-'. esc_attr( $item['type'] ) .' category-'. esc_attr( $item['cat'] ) .'" data-type="'. esc_attr( $item['type'] ) .'" '. $deprecated .'>';
											echo '<a href="#">';
												echo '<div class="mfn-icon card-icon"></div>';
												echo '<span class="title">'. esc_html( $item['title'] ) .'</span>';
											echo '</a>';
										echo '</li>';

									}
								?>

				      </ul>
				    </div>

				  </div>
				</div>

				<!-- modal: template display conditions -->

        <div class="mfn-modal has-footer modal-display-conditions">

					<div class="mfn-modalbox mfn-form mfn-form-verical mfn-shadow-1">

						<div class="modalbox-header">

							<div class="options-group">
								<div class="modalbox-title-group">
									<span class="modalbox-icon mfn-icon-shop"></span>
									<div class="modalbox-desc">
										<h4 class="modalbox-title"><?php esc_html_e('Display Conditions', 'mfn-opts'); ?></h4>
									</div>
								</div>
							</div>

							<div class="options-group">
								<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#">
									<span class="mfn-icon mfn-icon-close"></span>
								</a>
							</div>

						</div>

						<div class="modalbox-content">
              <img class="icon" alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/others/display-conditions.svg' ); ?>">
							<h3><?php esc_html_e('Where Do You Want to Display Your Template?', 'mfn-opts'); ?></h3>
							<p><?php esc_html_e('Set the conditions that determine where your Template is used throughout your site.', 'mfn-opts'); ?></p>

							<?php
								$conditions = (array) json_decode( get_post_meta($post->ID, 'mfn_template_conditions', true) );
								// echo '<pre>';
								// print_r($conditions);
								// echo '</pre>';
							?>

							<div class="mfn-dynamic-form mfn-form">

								<?php

								$mfn_tmpl_type = get_post_meta($post->ID, 'mfn_template_type', true);
								$mfn_cond_terms = mfn_get_posttypes('tax');
								$cats = array();
								$tags = array();

								if( get_post_type($post->ID) == 'template' && $mfn_tmpl_type && in_array($mfn_tmpl_type, array('single-product', 'shop-archive')) ):

									if (function_exists('is_woocommerce')) {
										$cats = get_terms( 'product_cat', array( 'hide_empty' => false, ) );
										$tags = get_terms( 'product_tag', array( 'hide_empty' => false, ) );
									} else {
										echo '<p style="color: red;">'. esc_html__('Activate WooCommerce plugin to see category and tags options.', 'mfn-opts') .'</p>';
									}
								?>

								<?php if( isset($conditions) && count($conditions) > 0){ $x = 0; foreach($conditions as $c=>$cond){ ?>
									<div class="mfn-df-row">
									<div class="df-row-inputs">
										<select name="mfn_template_conditions[<?php echo $x; ?>][rule]" class="mfn-form-control df-input df-input-rule <?php if($cond->rule == 'exclude'){ echo 'minus'; } ?>">
											<option <?php if($cond->rule == 'include'){ echo 'selected'; } ?> value="include"><?php esc_html_e('Include', 'mfn-opts'); ?></option>
											<option <?php if($cond->rule == 'exclude'){ echo 'selected'; } ?> value="exclude"><?php esc_html_e('Exclude', 'mfn-opts'); ?></option>
										</select>
										<select name="mfn_template_conditions[<?php echo $x; ?>][var]" class="mfn-form-control df-input df-input-var">
											<option <?php if($cond->var == 'shop'){ echo 'selected'; } ?> value="shop"><?php esc_html_e('Shop', 'mfn-opts'); ?></option>
											<option <?php if($cond->var == 'productcategory'){ echo 'selected'; } ?> value="productcategory"><?php esc_html_e('Product Category', 'mfn-opts'); ?></option>
											<option <?php if($cond->var == 'producttag'){ echo 'selected'; } ?> value="producttag"><?php esc_html_e('Product Tag', 'mfn-opts'); ?></option>
										</select>
										<select name="mfn_template_conditions[<?php echo $x; ?>][productcategory]" class="mfn-form-control df-input df-input-opt df-input-productcategory <?php if($cond->var == 'productcategory') {echo 'show';} ?>">
											<option value="all"><?php esc_html_e('All', 'mfn-opts'); ?></option>
											<?php if(count($cats) > 0): foreach($cats as $cat){ ?>
											<option <?php if($cond->var != 'shop' && $cond->productcategory == $cat->term_id){ echo 'selected'; } ?> value="<?php echo $cat->term_id ?>"><?php echo $cat->name; ?></option>
											<?php } endif; ?>
										</select>
										<select name="mfn_template_conditions[<?php echo $x; ?>][producttag]" class="mfn-form-control df-input df-input-opt df-input-producttag <?php if($cond->var == 'producttag') {echo 'show';} ?>">
											<option value="all"><?php esc_html_e('All', 'mfn-opts'); ?></option>
											<?php if(count($tags) > 0): foreach($tags as $tag){ ?>
											<option <?php if($cond->var != 'shop' && $cond->producttag == $tag->term_id){ echo 'selected'; } ?> value="<?php echo $tag->term_id ?>"><?php echo $tag->name; ?></option>
											<?php } endif; ?>
										</select>
									</div>
									<a class="mfn-option-btn mfn-option-blank btn-large df-remove" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
								</div>
								<?php $x++; }} ?>

							<?php else:


									/*echo '<pre>';
									print_r($mfn_cond_terms);
									echo '</pre>';*/

									if( isset($conditions) && count($conditions) > 0){ $x = 0; foreach($conditions as $c=>$cond){ ?>
										<div class="mfn-df-row">
										<div class="df-row-inputs">
											<select name="mfn_template_conditions[<?php echo $x; ?>][rule]" class="mfn-form-control df-input df-input-rule <?php if($cond->rule == 'exclude'){ echo 'minus'; } ?>">
												<option <?php if($cond->rule == 'include'){ echo 'selected'; } ?> value="include">Include</option>
												<option <?php if($cond->rule == 'exclude'){ echo 'selected'; } ?> value="exclude">Exclude</option>
											</select>
											<select name="mfn_template_conditions[<?php echo $x; ?>][var]" class="mfn-form-control df-input df-input-var">
												<option <?php if($cond->var == 'everywhere'){ echo 'selected'; } ?> value="everywhere">Entire Site</option>
												<option <?php if($cond->var == 'archives'){ echo 'selected'; } ?> value="archives">Archives</option>
												<option <?php if($cond->var == 'singular'){ echo 'selected'; } ?> value="singular">Singular</option>
											</select>
											<select name="mfn_template_conditions[<?php echo $x; ?>][archives]" class="mfn-form-control df-input df-input-opt df-input-archives <?php if($cond->var == 'archives') {echo 'show';} ?>">
												<?php if(count($mfn_cond_terms) > 0): foreach($mfn_cond_terms as $s=>$item){
													if( is_array($item) && $item['items'] ){
														echo '<optgroup label="'.$item['label'].'">';
														echo '<option '.( !empty($cond->archives) && $cond->archives == $s ? "selected" : null ).' value="'.$s.'">All</option>';
														if( is_iterable($item['items']) ){
															foreach($item['items'] as $opt){
																echo '<option '.( !empty($cond->archives) && $cond->archives == $s.':'.$opt->id ? "selected" : null ).' value="'.$s.':'.$opt->id.'">'.$opt->name.'</option>';
															}
														}
														echo '</optgroup>';
													}elseif( !is_array($item) ){
														echo '<option '.( !empty($cond->archives) && $cond->archives == $s ? "selected" : null ).' value="'.$s.'">'.$item.'</option>';
													}
												} endif; ?>
											</select>
											<select name="mfn_template_conditions[<?php echo $x; ?>][singular]" class="mfn-form-control df-input df-input-opt df-input-singular <?php if($cond->var == 'singular') {echo 'show';} ?>">
												<?php
												if(count($mfn_cond_terms) > 0): foreach($mfn_cond_terms as $s=>$item){
													if( is_array($item) ){
														echo '<optgroup label="'.$item['label'].'">';
														echo '<option '.( !empty($cond->singular) && $cond->singular == $s ? "selected" : null ).' value="'.$s.'">All</option>';
														if( $s == 'page' ){
															echo '<option '.( !empty($cond->singular) && $cond->singular == "front-page" ? "selected" : null ).' value="front-page">Front page</option>';
														}
														if( is_array($item) && $item['items'] ){
															if( is_iterable($item['items']) ){
																foreach( $item['items'] as $opt){
																	echo '<option '.( !empty($cond->singular) && $cond->singular == $s.':'.$opt->id ? "selected" : null ).' value="'.$s.':'.$opt->id.'">'.$opt->name.'</option>';
																}
															}

														}
														echo '</optgroup>';
													}else{
														echo '<option '.( !empty($cond->singular) && $cond->singular == $s ? "selected" : null ).' value="'.$s.'">'.$item.'</option>';
													}
												} endif; ?>
											</select>
										</div>
										<a class="mfn-option-btn mfn-option-blank btn-large df-remove" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
									</div>
									<?php $x++; }} ?>

							<?php endif; ?>

								<div class="mfn-df-row clone df-type-woo">
									<div class="df-row-inputs">
										<select data-name="mfn_template_conditions[0][rule]" class="mfn-form-control df-input df-input-rule">
											<option value="include"><?php esc_html_e('Include', 'mfn-opts'); ?></option>
											<option value="exclude"><?php esc_html_e('Exclude', 'mfn-opts'); ?></option>
										</select>
										<select data-name="mfn_template_conditions[0][var]" class="mfn-form-control df-input df-input-var">
											<option value="shop"><?php esc_html_e('Shop', 'mfn-opts'); ?></option>
											<option value="productcategory"><?php esc_html_e('Product Category', 'mfn-opts'); ?></option>
											<option value="producttag"><?php esc_html_e('Product Tag', 'mfn-opts'); ?></option>
										</select>
										<select data-name="mfn_template_conditions[0][productcategory]" class="mfn-form-control df-input df-input-opt df-input-productcategory">
											<option value="all"><?php esc_html_e('All', 'mfn-opts'); ?></option>
											<?php if(count($cats) > 0): foreach($cats as $cat){ ?>
											<option value="<?php echo $cat->term_id ?>"><?php echo $cat->name; ?></option>
											<?php } endif; ?>
										</select>
										<select data-name="mfn_template_conditions[0][producttag]" class="mfn-form-control df-input df-input-opt df-input-producttag">
											<option value="all"><?php esc_html_e('All', 'mfn-opts'); ?></option>
											<?php if(count($tags) > 0): foreach($tags as $tag){ ?>
											<option value="<?php echo $tag->term_id ?>"><?php echo $tag->name; ?></option>
											<?php } endif; ?>
										</select>
									</div>
									<a class="mfn-option-btn mfn-option-blank btn-large df-remove" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
								</div>

								<div class="mfn-df-row clone df-type-header">
									<div class="df-row-inputs">
										<select data-name="mfn_template_conditions[0][rule]" class="mfn-form-control df-input df-input-rule">
											<option value="include">Include</option>
											<option value="exclude">Exclude</option>
										</select>
										<select data-name="mfn_template_conditions[0][var]" class="mfn-form-control df-input df-input-var">
											<option value="everywhere">Entire Site</option>
											<option value="archives">Archives</option>
											<option value="singular">Singular</option>
										</select>
										<select data-name="mfn_template_conditions[0][archives]" class="mfn-form-control df-input df-input-opt df-input-archives">
											<?php if(count($mfn_cond_terms) > 0): foreach($mfn_cond_terms as $s=>$item){
												if( is_array($item) && $item['items'] ){
													echo '<optgroup label="'.$item['label'].'">';
													echo '<option value="'.$s.'">All</option>';
													if( is_iterable($item['items']) ){
														foreach($item['items'] as $opt){
															echo '<option value="'.$s.':'.$opt->id.'">'.$opt->name.'</option>';
														}
													}
													echo '</optgroup>';
												}elseif( !is_array($item) ){
													echo '<option value="'.$s.'">'.$item.'</option>';
												}
											} endif; ?>
										</select>
										<select data-name="mfn_template_conditions[0][singular]" class="mfn-form-control df-input df-input-opt df-input-singular">
											<?php
											if(count($mfn_cond_terms) > 0): foreach($mfn_cond_terms as $s=>$item){
												if( is_array($item) ){
													echo '<optgroup label="'.$item['label'].'">';
													echo '<option value="'.$s.'">All</option>';
													if( $s == 'page' ){
														echo '<option value="front-page">Front page</option>';
													}
													if( is_array($item) && $item['items'] ){
														if( is_iterable($item['items']) ){
															foreach( $item['items'] as $opt){
																echo '<option value="'.$s.':'.$opt->id.'">'.$opt->name.'</option>';
															}
														}

													}
													echo '</optgroup>';
												}else{
													echo '<option value="'.$s.'">'.$item.'</option>';
												}
											} endif; ?>
										</select>
									</div>
									<a class="mfn-option-btn mfn-option-blank btn-large df-remove" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
								</div>

							</div>

							<a class="mfn-btn btn-icon-left  df-add-row" href="#"><span class="btn-wrapper"><span class="mfn-icon mfn-icon-add"></span><?php esc_html_e('Add condition', 'mfn-opts'); ?></span></a>

						</div>

						<div class="modalbox-footer">
							<div class="options-group right">
								<a class="mfn-btn mfn-btn-blue btn-modal-save" href="#"><span class="btn-wrapper"><?php esc_html_e('Save', 'mfn-opts'); ?></span></a>
								<a class="mfn-btn btn-modal-close" href="#"><span class="btn-wrapper"><?php esc_html_e('Cancel', 'mfn-opts'); ?></span></a>
							</div>
						</div>

					</div>

				</div>

				<!-- modal: edit item -->

				<div class="mfn-modal has-footer modal-item-edit device-wrapper" data-device="desktop">
				  <div class="mfn-modalbox mfn-form mfn-shadow-1">

				    <div class="modalbox-header">

							<div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-card"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Text column', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group right">
                <ul class="modalbox-tabs">
                  <li data-card="content" class="active"><a href="#"><?php esc_html_e('Content', 'mfn-opts'); ?></a></li>
                  <li data-card="style"><a href="#"><?php esc_html_e('Style', 'mfn-opts'); ?></a></li>
                  <li data-card="advanced"><a href="#"><?php esc_html_e('Advanced', 'mfn-opts'); ?></a></li>
                </ul>
	            </div>

							<div class="options-group">
				        <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
				      </div>

				    </div>

				    <div class="modalbox-content">
							<!-- element meta -->
				    </div>

						<div class="modalbox-footer">
	            <div class="options-group right">
                <a class="mfn-btn mfn-btn-blue btn-modal-close" href="#"><span class="btn-wrapper"><?php esc_html_e('Save changes', 'mfn-opts'); ?></span></a>
	            </div>
		        </div>

				  </div>
				</div>

				<!-- modal: export import -->

				<div class="mfn-modal has-footer modal-export-import">
			    <div class="mfn-modalbox mfn-form mfn-shadow-1">

		        <div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-export-import"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Export / Import', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group modalbox-tabber">
                <ul class="modalbox-tabs">
                  <li data-card="export" class="active"><a href="#"><?php esc_html_e('Export', 'mfn-opts'); ?></a></li>
                  <li data-card="import"><a href="#"><?php esc_html_e('Import', 'mfn-opts'); ?></a></li>
                  <li data-card="template"><a href="#"><?php esc_html_e('Templates', 'mfn-opts'); ?></a></li>
		  						<li data-card="page"><a href="#"><?php esc_html_e('Single page import', 'mfn-opts'); ?></a></li>
                  <li data-card="seo"><a href="#"><?php esc_html_e('Builder → SEO', 'mfn-opts'); ?></a></li>
                </ul>
	            </div>

							<div class="options-group">
				        <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
				      </div>

		        </div>

		        <div class="modalbox-content">

							<div class="modalbox-card modalbox-card-export active">

		            <div class="mfn-form-row mfn-row">
	                <div class="row-column row-column-12">
	                  <div class="form-content form-content-full-width">
	                    <div class="form-group">
	                      <div class="form-control">
	                        <?php echo '<textarea class="mfn-form-control mfn-form-textarea mfn-items-export" placeholder="'. apply_filters('betheme_label', 'Be') .'Builder data processing..."></textarea>'; ?>
	                      </div>
	                    </div>
	                  </div>
	                </div>
		            </div>

							</div>

							<div class="modalbox-card modalbox-card-import">

								<div class="mfn-form-row mfn-row">
	                <div class="row-column row-column-12">
	                  <div class="form-content form-content-full-width">
	                    <div class="form-group">
	                      <div class="form-control">
	                        <textarea id="mfn-items-import" class="mfn-form-control mfn-form-textarea" placeholder="<?php esc_html_e('Paste import data here', 'mfn-opts'); ?>"></textarea>
	                      </div>
	                    </div>
	                  </div>
	                </div>
		            </div>

							</div>

							<div class="modalbox-card modalbox-card-page<?php if( ! mfn_is_registered() ){ echo ' unregistered'; } ?>">

								<?php if( ! mfn_is_registered() ): ?>

								<div class="mfn-please-register">

									<img alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/others/register-now.svg' ); ?>" width="120">

									<h4>Please register the theme<br >to get access to single page import.</h4>

									<p class="info">This page reload is required after theme registration. Please save your content.</p>

									<a class="mfn-btn mfn-btn-green btn-large" href="admin.php?page=betheme" target="_blank"><span class="btn-wrapper">Register now</span></a>

								</div>

								<?php endif; ?>

								<div class="mfn-form-row mfn-row">
	                <div class="row-column row-column-12">
	                  <div class="form-content form-content-full-width">
	                    <div class="form-group">
												<div class="form-control" style="">

												<img class="icon" alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/others/import-page-big.svg' ); ?>">

													<h3><?php esc_html_e('Single page import', 'mfn-opts'); ?></h3>
													<p>Paste a <code>link</code> from one of <a target="_blank" href="https://muffingroup.com/betheme/websites/">pre-built websites</a></p>

													<input id="mfn-items-import-page" class="mfn-form-control mfn-form-input" placeholder="https://themes.muffingroup.com/betheme/about/" />

													<p class="hint"><?php esc_html_e('Only builder content will be imported. Theme options, sliders and images will not be imported.', 'mfn-opts'); ?></p>

												</div>
	                    </div>
	                  </div>
	                </div>
		            </div>

							</div>

							<div class="modalbox-card modalbox-card-template">

								<div class="mfn-form-row mfn-row">
	                <div class="row-column row-column-12">
                    <div class="templates">
                      <h4><?php esc_html_e('Select a template from the list:', 'mfn-opts'); ?></h4>
                      <ul class="mfn-items-list mfn-items-import-template">

												<?php

													$args = array(
														'post_type' => 'template',
														'posts_per_page'=> -1,
													);

													$templates = get_posts( $args );

													if ( is_array( $templates ) ) {
														foreach ( $templates as $template ) {
															$classes = '';

															$tmpl_type = get_post_meta($template->ID, 'mfn_template_type', true);

															if( (empty($tmpl_type) || $tmpl_type == 'default') && $tmpl_type != 'section' && $tmpl_type != 'wrap' ){
																echo '<li class="'. $classes .'" data-id="'. esc_attr($template->ID) .'"><a href="#"><h5>'. esc_html($template->post_title) .'</h5><p>'. esc_html($template->post_modified) .'</p></a></li>';
															}
														}
													}

												?>

												<input type="hidden" id="mfn-items-import-template" val=""/>

                      </ul>
                    </div>
	                </div>
		            </div>

							</div>

							<div class="modalbox-card modalbox-card-seo">

								<div class="mfn-form-row mfn-row">
	                <div class="row-column row-column-12">
	                  <div class="form-content form-content-full-width">
	                    <div class="form-group">
												<div class="form-control" style="">
													<img class="icon" alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/others/builder-to-seo.svg' ); ?>">
													<h3><?php esc_html_e('Builder → SEO', 'mfn-opts'); ?></h3>
													<p>This option is useful for plugins like Yoast SEO to analyze <?php echo apply_filters('betheme_label', 'Be'); ?>Builder content. It will collect content from BeBuilder and copy it to new Content Block.</p>
													<p>You can hide the content if you set <code>"The content"</code> option to Hide.</p>
	                      </div>
	                    </div>
	                  </div>
	                </div>
		            </div>

							</div>

		        </div>

		        <div class="modalbox-footer">

	            <div class="options-group right">

								<div class="modalbox-card modalbox-card-export active"></div>

								<div class="modalbox-card modalbox-card-import">
									<select id="mfn-import-type" class="mfn-form-control mfn-form-select mfn-import-type">
										<option value="before"><?php esc_html_e('Insert BEFORE current builder content', 'mfn-opts'); ?></option>
										<option value="after"><?php esc_html_e('Insert AFTER current builder content', 'mfn-opts'); ?></option>
										<option value="replace"><?php esc_html_e('REPLACE current builder content', 'mfn-opts'); ?></option>
									</select>
								</div>

								<div class="modalbox-card modalbox-card-page">
									<select id="mfn-import-type-page" class="mfn-form-control mfn-form-select mfn-import-type">
										<option value="before"><?php esc_html_e('Insert BEFORE current builder content', 'mfn-opts'); ?></option>
										<option value="after"><?php esc_html_e('Insert AFTER current builder content', 'mfn-opts'); ?></option>
										<option value="replace"><?php esc_html_e('REPLACE current builder content', 'mfn-opts'); ?></option>
									</select>
								</div>

								<div class="modalbox-card modalbox-card-template">
									<select id="mfn-import-type-template" class="mfn-form-control mfn-form-select mfn-import-type">
										<option value="before"><?php esc_html_e('Insert BEFORE current builder content', 'mfn-opts'); ?></option>
										<option value="after"><?php esc_html_e('Insert AFTER current builder content', 'mfn-opts'); ?></option>
										<option value="replace"><?php esc_html_e('REPLACE current builder content', 'mfn-opts'); ?></option>
									</select>
								</div>

								<div class="modalbox-card modalbox-card-seo"></div>

							</div>

	            <div class="options-group">

								<div class="modalbox-card modalbox-card-export active">
                	<a class="mfn-btn mfn-btn-blue btn-copy-text" href="#"><span class="btn-wrapper"><?php esc_html_e('Copy to clipboard', 'mfn-opts'); ?></span></a>
								</div>

								<div class="modalbox-card modalbox-card-import">
                	<a class="mfn-btn mfn-btn-blue btn-import" href="#"><span class="btn-wrapper"><?php esc_html_e('Import', 'mfn-opts'); ?></span></a>
								</div>

								<div class="modalbox-card modalbox-card-page">
                	<a class="mfn-btn mfn-btn-blue btn-page" href="#"><span class="btn-wrapper"><?php esc_html_e('Import', 'mfn-opts'); ?></span></a>
								</div>

								<div class="modalbox-card modalbox-card-template">
                	<a class="mfn-btn mfn-btn-blue btn-template" href="#"><span class="btn-wrapper"><?php esc_html_e('Import', 'mfn-opts'); ?></span></a>
								</div>

								<div class="modalbox-card modalbox-card-seo">
                	<a class="mfn-btn mfn-btn-blue btn-seo" href="#"><span class="btn-wrapper"><?php esc_html_e('Generate', 'mfn-opts'); ?></span></a>
								</div>

	            </div>

		        </div>

			    </div>
				</div>

				<!-- modal: revisions -->

				<div class="mfn-modal has-footer modal-revisions">
			    <div class="mfn-modalbox mfn-form mfn-shadow-1">

		        <div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-export-import"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('History', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

							<div class="options-group">
				        <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
				      </div>

		        </div>

		        <div class="modalbox-content">
							<div class="mfn-form-row mfn-row">

								<?php
									$revisions = Mfn_Builder_Helper::get_revisions( $post->ID );
								?>

                <div class="row-column row-column-3">

                  <h5><?php esc_html_e('Autosave', 'mfn-opts'); ?>:</h5>
                  <ul class="mfn-revisions-list" data-type="autosave">
										<?php $this->the_revisions_list( $revisions['autosave'] ); ?>
                  </ul>
									<p class="info"><?php esc_html_e('Saved automatically', 'mfn-opts'); ?><br><?php esc_html_e('every 5 minutes', 'mfn-opts'); ?></p>

                </div>

                <div class="row-column row-column-3">

                  <h5><?php esc_html_e('Update', 'mfn-opts'); ?>:</h5>
                  <ul class="mfn-revisions-list" data-type="update">
										<?php $this->the_revisions_list( $revisions['update'] ); ?>
                  </ul>
									<p class="info"><?php esc_html_e('Saved after', 'mfn-opts'); ?><br /><?php esc_html_e('every post update', 'mfn-opts'); ?></p>

                </div>

                <div class="row-column row-column-3">

                  <h5><?php esc_html_e('Revision', 'mfn-opts'); ?>:</h5>
                  <ul class="mfn-revisions-list" data-type="revision">
										<?php $this->the_revisions_list( $revisions['revision'] ); ?>
                  </ul>
									<p class="info"><?php esc_html_e('Saved using', 'mfn-opts'); ?><br /><?php esc_html_e('Save revision button', 'mfn-opts'); ?></p>

                </div>

                <div class="row-column row-column-3">

                  <h5><?php esc_html_e('Backup', 'mfn-opts'); ?>:</h5>
                  <ul class="mfn-revisions-list" data-type="backup">
										<?php $this->the_revisions_list( $revisions['backup'] ); ?>
                  </ul>
									<p class="info"><?php esc_html_e('Backups are being created', 'mfn-opts'); ?><br /><?php esc_html_e('before restoring any revision', 'mfn-opts'); ?></p>

                </div>

	            </div>
		        </div>

		        <div class="modalbox-footer">

	            <div class="options-group right"></div>

	            <div class="options-group">
              	<a class="mfn-btn mfn-btn-blue btn-revision" href="#"><span class="btn-wrapper"><?php esc_html_e('Save revision', 'mfn-opts'); ?></span></a>
	            </div>

		        </div>

			    </div>
				</div>

				<!-- modal: pre-built sections -->

				<div class="mfn-modal modal-sections-library<?php if( ! mfn_is_registered() ){ echo ' unregistered'; } ?>">
			    <div class="mfn-modalbox mfn-form mfn-shadow-1">

						<?php if( ! mfn_is_registered() ): ?>

						<div class="mfn-please-register">

							<img alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/others/register-now.svg' ); ?>" width="120">

							<h4>Please register the theme<br >to get access to pre-built websites.</h4>

							<p class="info">This page reload is required after theme registration. Please save your content.</p>

							<a class="mfn-btn mfn-btn-green btn-large" href="admin.php?page=betheme" target="_blank"><span class="btn-wrapper">Register now</span></a>

						</div>

						<?php endif; ?>

		        <div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-predefined-sections"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Pre-built sections', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group right">
                <ul class="modalbox-tabs">
									<?php

										$categories = Mfn_Pre_Built_Sections::get_categories();

										foreach( $categories as $category_key => $category ){
											echo '<li data-filter="'. esc_attr( $category_key ) .'"><a href="#">'. esc_html( $category ) .'</a></li>';
										}

									?>
                </ul>
	            </div>

	            <div class="options-group">
								<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
	            </div>

		        </div>

		        <div class="modalbox-content">
	            <ul class="modalbox-sections mfn-sections-list">
								<?php

									$sections = Mfn_Pre_Built_Sections::get_sections();

									foreach( $sections as $section_key => $section ){

										if( 'header' == $section['category'] ){
											continue;
										}

										echo '<li class="category-all category-'. esc_attr( $section['category'] ).'" data-id="'. esc_attr( $section_key ).'">';
		                  echo '<div class="photo">';
		                    echo '<img src="'. get_theme_file_uri( '/functions/builder/pre-built/images/'. $section_key .'.png' ) .'" alt="" />';
		                  echo '</div>';
		                  echo '<div class="desc">';
		                    echo '<h6>'. esc_html( $section['title'] ).'</h6>';
		                    echo '<a class="mfn-option-btn mfn-option-text btn-icon-left mfn-option-green mfn-btn-insert" title="'. esc_html__('Insert', 'mfn-opts') .'" data-tooltip="'. esc_html__('Insert section', 'mfn-opts') .'" href="#"><span class="mfn-icon mfn-icon-add"></span><span class="text">'. esc_html__('Insert', 'mfn-opts') .'</span></a>';
		                  echo '</div>';
		                echo '</li>';

									}

								?>
	            </ul>
		        </div>

			    </div>
				</div>

				<!-- modal: delete item -->

				<div class="mfn-modal modal-confirm modal-confirm-element">
					<div class="mfn-modalbox mfn-form mfn-shadow-1">

		        <div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-delete"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Delete element', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group">
                <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
	            </div>

		        </div>

		        <div class="modalbox-content">

	            <img class="icon" alt="" src="<?php echo get_template_directory_uri() .'/muffin-options/svg/warning.svg'; ?>">
	            <h3><?php esc_html_e('Delete element?', 'mfn-opts'); ?></h3>
	            <p><?php esc_html_e('Please confirm. There is no undo.', 'mfn-opts'); ?></p>
	            <a class="mfn-btn mfn-btn-red btn-wide btn-modal-confirm" href="#"><span class="btn-wrapper"><?php esc_html_e('Delete', 'mfn-opts'); ?></span></a>

					 	</div>

			    </div>
		    </div>

				<!-- modal: Globals Section/Wrap -->

				<div class="mfn-modal modal-confirm modal-confirm-globals">
				<div class="mfn-modalbox mfn-form mfn-shadow-1">

				<div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-import-after"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Use Global Element', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group">
                <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
	            </div>

		        </div>

		        <div class="modalbox-content">

	            <img class="icon" alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/warning.svg' ); ?>">
	            <h3><?php esc_html_e('Content of selected container will be removed', 'mfn-opts'); ?></h3>
	            <p><?php esc_html_e('Please confirm. There is no undo.', 'mfn-opts'); ?></p>
	            <a class="mfn-btn mfn-btn-red btn-wide btn-modal-confirm" href="#"><span class="btn-wrapper"><?php esc_html_e('Use anyway', 'mfn-opts'); ?></span></a>

					 	</div>

			    </div>
		    </div>

				<!-- modal: restore revision -->

				<div class="mfn-modal modal-confirm modal-confirm-revision">
					<div class="mfn-modalbox mfn-form mfn-shadow-1">

		        <div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-undo"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Restore revision', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group">
                <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
	            </div>

		        </div>

		        <div class="modalbox-content">

	            <img class="icon" alt="" src="<?php echo get_theme_file_uri( '/muffin-options/svg/warning.svg' ); ?>">
	            <h3><?php esc_html_e('Restore revision?', 'mfn-opts'); ?></h3>
	            <p><?php esc_html_e('Please confirm. There is no undo.', 'mfn-opts'); ?><br /><?php esc_html_e('Backup revision will be created.', 'mfn-opts'); ?></p>
	            <a class="mfn-btn mfn-btn-blue btn-wide btn-modal-confirm-revision" href="#"><span class="btn-wrapper"><?php esc_html_e('Restore', 'mfn-opts'); ?></span></a>

					 	</div>

			    </div>
		    </div>

				<!-- modal: add shortcode / edit shortcode -->

				<div class="mfn-modal has-footer modal-small modal-add-shortcode">

					<div class="mfn-modalbox mfn-form mfn-form-verical mfn-shadow-1 mfn-sc-editor">

						<div class="modalbox-header">

							<div class="options-group">
								<div class="modalbox-title-group">
									<span class="modalbox-icon mfn-icon-add-big"></span>
									<div class="modalbox-desc">
										<h4 class="modalbox-title"><?php esc_html_e('Shortcode', 'mfn-opts'); ?></h4>
									</div>
								</div>
							</div>

							<div class="options-group">
								<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close-sc" title="Close" href="#">
									<span class="mfn-icon mfn-icon-close"></span>
								</a>
							</div>

						</div>

						<div class="modalbox-content">
							<!-- element meta -->
						</div>

						<div class="modalbox-footer">
							<div class="options-group right">
								<a class="mfn-btn mfn-btn-blue btn-modal-close-sc" href="#"><span class="btn-wrapper"><?php esc_html_e('Add Shortcode', 'mfn-opts'); ?></span></a>
							</div>
						</div>

					</div>

					<div class="mfn-element-meta mfn-isc-builder">
						<?php
							foreach ( $this->inline_shortcodes as $shortcode ) {
								echo '<div class="mfn-isc-builder-'. esc_attr( $shortcode['type'] ) .'" data-shortcode="'. esc_attr( $shortcode['type'] ) .'">';
									foreach( $shortcode['fields'] as $sc_field ){

										$sc_placeholder = '';

										if( isset( $sc_field['std'] ) ){
										  $sc_placeholder = $sc_field['std'];
										}

										Mfn_Builder_Admin::field( $sc_field, $sc_placeholder, 'empty' );

									}
								echo '</div>';
							}
						?>
					</div>

				</div>

				<!-- modal: settings -->

				<div class="mfn-modal modal-settings modal-small">
			    <div class="mfn-modalbox mfn-form mfn-shadow-1">

		        <div class="modalbox-header">

	            <div class="options-group">
                <div class="modalbox-title-group">
                  <span class="modalbox-icon mfn-icon-settings"></span>
                  <div class="modalbox-desc">
                    <h4 class="modalbox-title"><?php esc_html_e('Settings', 'mfn-opts'); ?></h4>
                  </div>
                </div>
	            </div>

	            <div class="options-group">
                <a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
	            </div>

		        </div>

		        <div class="modalbox-content">

              <div class="mfn-form-row mfn-row">
                <div class="row-column row-column-12">
                  <div class="form-content form-content-full-width">
                    <div class="form-group segmented-options settings">

                      <span class="mfn-icon mfn-icon-simple-view"></span>

                      <div class="setting-label">
                        <h5><?php esc_html_e('Simple view', 'mfn-opts'); ?></h5>
                        <p><?php esc_html_e('Simplified version of elements', 'mfn-opts'); ?></p>
                      </div>

                      <div class="form-control" data-option="simple-view">
                        <ul>
													<li class="active" data-value="0"><a href="#"><span class="text"><?php esc_html_e('Off', 'mfn-opts'); ?></span></a></li>
                          <li data-value="1"><a href="#"><span class="text"><?php esc_html_e('On', 'mfn-opts'); ?></span></a></li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="mfn-form-row mfn-row">
                <div class="row-column row-column-12">
                  <div class="form-content form-content-full-width">
                    <div class="form-group segmented-options settings">

                      <span class="mfn-icon mfn-icon-hover-effects"></span>

                      <div class="setting-label">
                        <h5><?php esc_html_e('Hover effects', 'mfn-opts'); ?></h5>
                        <p><?php esc_html_e('Builder element bar shows on hover', 'mfn-opts'); ?></p>
                      </div>

                      <div class="form-control" data-option="hover-effects">
                        <ul>
													<li class="active" data-value="0"><a href="#"><span class="text"><?php esc_html_e('Off', 'mfn-opts'); ?></span></a></li>
                          <li data-value="1"><a href="#"><span class="text"><?php esc_html_e('On', 'mfn-opts'); ?></span></a></li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="mfn-form-row mfn-row">
                <div class="row-column row-column-12">
                  <div class="form-content form-content-full-width">
                    <div class="form-group segmented-options settings">

                      <span class="mfn-icon mfn-icon-precompleted-items"></span>

                      <div class="setting-label">
                        <h5><?php esc_html_e('Pre-completed elements', 'mfn-opts'); ?></h5>
                        <p><?php esc_html_e('Sample content in elements', 'mfn-opts'); ?></p>
												<a data-tooltip="A page reload is required for this change. Please save your content." title="Info" class="mfn-option-btn info-changed"><span class="mfn-icon mfn-icon-information"></span></a>
                      </div>

                      <div class="form-control" data-option="pre-completed">
                        <ul>
													<li class="active" data-value="0"><a href="#"><span class="text"><?php esc_html_e('Off', 'mfn-opts'); ?></span></a></li>
                          <li data-value="1"><a href="#"><span class="text"><?php esc_html_e('On', 'mfn-opts'); ?></span></a></li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="mfn-form-row mfn-row">
                <div class="row-column row-column-12">
                  <div class="form-content form-content-full-width">
                    <div class="form-group segmented-options settings">

                      <span class="mfn-icon mfn-icon-column"></span>

                      <div class="setting-label">
                        <h5><?php esc_html_e('Column text editor', 'mfn-opts'); ?></h5>
                        <p><?php esc_html_e('CodeMirror or TinyMCE', 'mfn-opts'); ?></p>
												<a data-tooltip="A page reload is required for this change. Please save your content." title="Info" class="mfn-option-btn info-changed"><span class="mfn-icon mfn-icon-information"></span></a>
                      </div>

                      <div class="form-control" data-option="column-visual">
                        <ul>
													<li class="active" data-value="0"><a href="#"><span class="text"><?php esc_html_e('Code', 'mfn-opts'); ?></span></a></li>
                          <li data-value="1"><a href="#"><span class="text"><?php esc_html_e('Visual', 'mfn-opts'); ?></span></a></li>
                        </ul>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

							<?php if( !apply_filters('betheme_disable_support', '0') ): ?>
              <div class="mfn-form-row mfn-row">
                <div class="row-column row-column-12">
                  <div class="form-content form-content-full-width">
                    <div class="form-group segmented-options settings">

											<span class="mfn-icon mfn-icon-intro-slider"></span>

                      <div class="setting-label">
                        <h5><?php esc_html_e('Introduction guide', 'mfn-opts'); ?></h5>
                        <p>See what's new in <?php echo apply_filters('betheme_label', 'Be'); ?>Builder</p>
                      </div>

                      <div class="form-control">
                        <a href="#" class="introduction-reopen"><?php esc_html_e('Reopen', 'mfn-opts'); ?></a>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
							<?php endif; ?>

		        </div>

			    </div>

				</div>

				<?php

					// modal | icon select
					Mfn_Icons::the_modal();

					// introduction
					$this->introduction();

				?>

				<a id="mfn-go-to-top" href="javascript:void(0);" class="mfn-option-btn btn-large"><span class="mfn-icon mfn-icon-move-up"></span></a>

      </div>

      <?php
    }

    /**
  	 * SAVE Muffin Builder
  	 */

  	public function save( $post_id )
  	{

  		// FIX | Visual Composer Frontend

  		if ( isset( $_POST['vc_inline'] ) ) {
  			return false;
  		}

			// debug

			// echo '<pre>';
			// print_r( $_POST );
			// echo '</pre>';
			// exit;

  		// variables

  		$mfn_items = array();
  		$mfn_wraps = array();

  		// LOOP sections

  		if ( isset( $_POST['mfn-section-id'] ) && is_array( $_POST['mfn-section-id'] ) ) {

  			foreach ( $_POST['mfn-section-id'] as $sectionID_k => $sectionID ) {

					$uid = $_POST['mfn-section-id'][$sectionID_k];

					$section = [
						'uid' => $uid,
						'attr' => [],
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
						'tablet_size' => $_POST['mfn-wrap-size-tablet'][$wrapID_k],
						'mobile_size' => $_POST['mfn-wrap-size-mobile'][$wrapID_k],
						'attr' => [],
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

  			$seo_content = '';
				$skip = [
					'1',
					'default',
					'horizontal',
				]; // seo values to skip

  			foreach ( $_POST['mfn-item-type'] as $type_k => $type ) {

					$uid = $_POST['mfn-item-id'][$type_k];

  				$item = [
						'type' => $type,
						'uid' => $uid,
						'size' => $_POST['mfn-item-size'][$type_k],
						'tablet_size' => $_POST['mfn-item-size-tablet'][$type_k],
						'mobile_size' => $_POST['mfn-item-size-mobile'][$type_k],
						'used_fonts' => $_POST['mfn-item-fonts'][$type_k],
						'fields' => [],
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

										// core.trac.wordpress.org/ticket/34845
										if ( ! mfn_opts_get( 'builder-storage' ) ) {
		  								$value = preg_replace( '~\R~u', "\n", $value );
		  							}

										$tabs[$tab_index][$tab_key] = $value;

										// FIX | Yoast SEO

  									$seo_val = trim( $value );
  									if ( $seo_val && $seo_val !== '1' ) {
  										$seo_content .= $seo_val ."\n";
  									}

									}
								}

								$item['fields']['tabs'] = $tabs;

  						} else {

  							// all other field types

								if( is_string( $value ) ){

									$value = stripslashes( $value );

									// core.trac.wordpress.org/ticket/34845
	  							if ( ! mfn_opts_get( 'builder-storage' ) ) {
	  								$value = preg_replace( '~\R~u', "\n", $value );
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

  							// products per page template
  							if ( $type == 'shop_products' && $attr_k == 'products' && !empty($value) ) {
  								update_post_meta( $post_id, 'mfn_template_perpage', strval($value) );
  							}

  							// product add to cart button template add_to_cart
  							if ( $type == 'product_cart_button' && $attr_k == 'cart_button_text' && !empty($value) ) {
  								update_post_meta( $post_id, 'mfn_cart_button', $value );
  							}

  							// product single image zoom
  							if ( $type == 'product_images' && $attr_k == 'zoom' ) {
  								update_post_meta( $post_id, 'mfn_template_product_image_zoom', $value );
  							}

								$item['fields'][$attr_k] = $value;

  						}
  					}

  					$seo_content .= "\n";
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

  		// debug
  		// print_r($mfn_items);
  		// exit;

  		// prepare data to save

  		if ( $mfn_items ) {

  			if ( 'encode' == mfn_opts_get('builder-storage') ) {
  				$new = call_user_func( 'base'.'64_encode', serialize( $mfn_items ) );
  			} else {
  				// codex.wordpress.org/Function_Reference/update_post_meta
  				$new = wp_slash( $mfn_items );
  			}

  		}

  		/** START template conditions */

  		if ( function_exists('is_woocommerce') && get_post_type( $post_id ) == 'template' ){
  			// conditions
	  		if ( isset( $_POST['mfn_template_conditions'] ) && is_array( $_POST['mfn_template_conditions'] ) && count($_POST['mfn_template_conditions']) > 0 ) {
	  			$tmpl_conditions = $_POST['mfn_template_conditions'];
	  			update_post_meta( $post_id, 'mfn_template_conditions', json_encode( $tmpl_conditions ) );
	  		}else{
	  			delete_post_meta( $post_id, 'mfn_template_conditions' );
	  		}

  			$this->set_woo_templates_conditions();
  		}

  		if ( function_exists('is_woocommerce') && get_post_type( $post_id ) == 'product' ){
  			$this->set_woo_templates_conditions();
  		}

  		/** END template conditions */

  		// SAVE data

  		if ( isset( $_POST['mfn-items-save'] ) ) {

				$meta_key = [
					'items' => 'mfn-page-items',
					'seo' => 'mfn-page-items-seo',
					'fonts' => 'mfn-page-fonts',
					'styles' => 'mfn-page-local-style',
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
					Mfn_Helper::generate_css( $mfn_styles, $post_id );
				} else {
					delete_post_meta( $post_id, $meta_key['styles'] );
				}

				// builder content

  			$old = get_post_meta( $post_id, $meta_key['items'], true );

  			if ( isset( $new ) && $new != $old ) {

  				// update post meta if there is at least one builder section
  				update_post_meta( $post_id, $meta_key['items'], $new );
					update_post_meta( $post_id, $meta_key['seo'], $seo_content );

  			} elseif ( $old && ( ! isset( $new ) || ! $new ) ) {

  				// delete post meta if builder is empty
  				delete_post_meta( $post_id, $meta_key['items'] );
  				delete_post_meta( $post_id, $meta_key['seo'] );

  			}

  		}
  	}

		/**
		 * Introduction slider
		 */

		public function introduction(){

			if( WHITE_LABEL ){
				return false;
			}

			$slides = [
			  '<h1>The new '. apply_filters('betheme_label', 'Be') .'Builder</h1>',
			  '<h2>Instant access<br />to Pre-Built Sections</h2>',
			  '<h2>Builder History<br />with easy backup restoration</h2>',
			  '<h2>Import & Export of content<br />or single sections</h2>',
			  '<h2>New Text Editor with code highlighter<br />and shortcode manager</h2>',
			  '<h2>Improved section<br />with tons of new features</h2>',
			  '<h2>Extremely useful icon select with quick search & Font Awesome included</h2>',
			];

			$max = count( $slides );
			$index = 1;

			echo '<div class="mfn-intro-overlay" style="display:none">';
			  echo '<div class="mfn-intro-container">';
			    echo '<a class="mfn-intro-close close-button mfn-option-btn btn-large" href="#"><span class="mfn-icon mfn-icon-close-light"></span></a>';
			    echo '<ul>';

			      foreach( $slides as $slide ){

			        echo '<li class="step-'. $index .'">
			          <div class="pic"></div>
			          <div class="desc">
			            <p class="slide-number">'. $index .' / '. $max .'</p>
			            '. $slide .'
			            <a class="mfn-intro-close start-now" href="#">Skip</a>
			          </div>
			        </li>';

			        $index++;
			      }

			    echo '</ul>';
			  echo '</div>';
			echo '</div>';

		}

		/**
		 * Print revisions list
		 */

		public function the_revisions_list( $revisions ){

			if( ! empty( $revisions ) ){
				foreach( $revisions as $rev_key => $rev_val ){
					echo '<li data-time="'. esc_attr( $rev_key ) .'">';
				    echo '<span class="revision-icon mfn-icon-clock"></span>';
				    echo '<div class="revision">';
			        echo '<h6>'. esc_attr( $rev_val ) .'</h6>';
			        echo '<a class="mfn-option-btn mfn-option-text mfn-option-blue mfn-btn-restore revision-restore" href="#"><span class="text">'. esc_html__('Restore','mfn-opts') .'</span></a>';
				    echo '</div>';
					echo '</li>';
				}
			}

		}

		/**
		 * Set Shop Templates Conditions
		 */

		public function reset_woo_templates_conditions($lang) {
			global $wpdb;
			$shoppage_id = wc_get_page_id('shop');

			delete_post_meta( $shoppage_id, 'mfn_shop_template'.$lang );

			delete_option( 'mfn_sinle_product_tmpl_entire_shop'.$lang );
			delete_option( 'mfn_sinle_product_tmpl_all_cats'.$lang );
			delete_option( 'mfn_sinle_product_tmpl_all_tags'.$lang );

			$cats = get_terms( 'product_cat', array( 'hide_empty' => false ) );
			$tags = get_terms( 'product_tag', array( 'hide_empty' => false ) );

			if( count($cats) > 0 ){
				foreach($cats as $item){
					delete_term_meta( $item->term_id, 'mfn_shop_template'.$lang );
				}
			}

			if( count($tags) > 0 ){
				foreach($tags as $tag){
					delete_term_meta( $item->term_id, 'mfn_shop_template'.$lang );
				}
			}

			$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'mfn_product_template'.$lang ) );
			$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'mfn_product_cat_template'.$lang ) );
			$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'mfn_product_tag_template'.$lang ) );

			/*$products = get_posts( array( 'post_type'	=> 'product', 'numberposts' => -1 ) );
			if(isset($products) && count($products) > 0){
				foreach ($products as $product) {
					delete_post_meta( $product->ID, 'mfn_product_template'.$lang );
					delete_post_meta( $product->ID, 'mfn_product_cat_template'.$lang );
					delete_post_meta( $product->ID, 'mfn_product_tag_template'.$lang );
				}
			}*/
		}

		public function set_woo_templates_conditions() {

			if( !function_exists('is_woocommerce') ) return false;

			$shoppage_id = wc_get_page_id('shop');
			$mfn_lang = '';

			// reset

			// wpml fix
			if( defined( 'ICL_SITEPRESS_VERSION' ) ){
				$default_lang = apply_filters('wpml_default_language', NULL );
				$languages = apply_filters( 'wpml_active_languages', NULL );
				if( is_iterable($languages) ){
					foreach ($languages as $lang) {
						$mfn_lang = '';
						if( isset($lang['code']) && $lang['code'] != $default_lang ){
							$mfn_lang = '_'.$lang['code'];
							$this->reset_woo_templates_conditions($mfn_lang);
						}
					}
				}
			}

			$this->reset_woo_templates_conditions('');

			// set

			$templates = get_posts(
				array(
					'post_type'	=> 'template',
					'orderby' => 'date',
        	'order' => 'ASC',
        	'numberposts' => -1,
        	'meta_query' => array(
	      		'relation' => 'OR',
		        array(
	            'key'   => 'mfn_template_type',
	            'compare' => '=',
	            'value' => 'shop-archive',
		        ),
		        array(
	            'key'   => 'mfn_template_type',
	            'compare' => '=',
	            'value' => 'single-product',
		        )
			    )
				)
			);

			if( isset($templates) && is_iterable($templates) ){
				foreach($templates as $t=>$tmp){

					$mfn_lang = '';

					$cond_meta_key = 'mfn_shop_template';
					$post_id = $tmp->ID;

					if( get_post_meta($post_id, 'mfn_template_type', true) == 'single-product' ){
						$cond_meta_key = 'mfn_product_template';
					}

					// wpml fix
					if( defined( 'ICL_SITEPRESS_VERSION' ) ){
						$tmpl_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id ) ;
						if( isset($tmpl_lang['language_code']) && $tmpl_lang['language_code'] != $default_lang ){
							$mfn_lang = '_'.$tmpl_lang['language_code'];
						}
						$shoppage_id = apply_filters( 'wpml_object_id', wc_get_page_id('shop'), 'page', null, $tmpl_lang['language_code'] );
					}

					$conditions = (array) json_decode( get_post_meta($post_id, 'mfn_template_conditions', true) );

					if(isset($conditions) && is_array($conditions) && count($conditions) > 0 ){
						foreach($conditions as $con){

							// entire shop
		  				if( $con->var == 'shop' ){
		  					if($cond_meta_key == 'mfn_shop_template'){
		  						if($con->rule == 'include'){
		  							update_post_meta( $shoppage_id, $cond_meta_key.$mfn_lang, $post_id );
		  						}else{
		  							delete_post_meta( $shoppage_id, $cond_meta_key.$mfn_lang );
		  						}
		  					}else{
		  						/*$products = get_posts( array( 'post_type'	=> 'product', 'numberposts' => -1 ) );
		  						if(isset($products) && count($products) > 0){
		  							foreach ($products as $product) {

		  								$product_id = $product->ID;
		  								if( defined( 'ICL_SITEPRESS_VERSION' ) && !empty($tmpl_lang['language_code']) ){
		  									$product_id = apply_filters( 'wpml_object_id', $product->ID, 'product', null, $tmpl_lang['language_code'] );
		  								}

		  								if($con->rule == 'include'){
		  									update_post_meta( $product_id, $cond_meta_key.$mfn_lang, $post_id );
		  								}else{
		  									delete_post_meta( $product_id, $cond_meta_key.$mfn_lang );
		  								}
		  							}
		  						}*/

		  						if($con->rule == 'include'){
		  							update_option( 'mfn_sinle_product_tmpl_entire_shop'.$mfn_lang, $post_id );
  								}else{
  									delete_option( 'mfn_sinle_product_tmpl_entire_shop'.$mfn_lang, $post_id );
  								}

		  					}
		  				}

		  				// all product categories
		  				if( $con->var == 'productcategory' && $con->productcategory == 'all' ){
		  					// set for all categories
		  					if($cond_meta_key == 'mfn_shop_template'){
			  					$cats = get_terms( 'product_cat', array( 'hide_empty' => false ) );
									if( count($cats) > 0 ){
										foreach($cats as $item){
											if($con->rule == 'include'){
												update_term_meta( $item->term_id, $cond_meta_key.$mfn_lang, $post_id);
											}else{
												//delete_term_meta( $item->term_id, $cond_meta_key.$mfn_lang );
												update_term_meta( $item->term_id, $cond_meta_key.$mfn_lang, 'excluded');
											}
										}
									}
								}else{
									/*$products = get_posts( array( 'post_type'	=> 'product', 'numberposts' => -1 ) );
		  						if(isset($products) && count($products) > 0){
		  							foreach ($products as $product) {

		  								$product_id = $product->ID;
		  								if( defined( 'ICL_SITEPRESS_VERSION' ) && !empty($tmpl_lang['language_code']) ){
		  									$product_id = apply_filters( 'wpml_object_id', $product->ID, 'product', null, $tmpl_lang['language_code'] );
		  								}

		  								if($con->rule == 'include'){
		  									update_post_meta( $product_id, 'mfn_product_cat_template'.$mfn_lang, $post_id );
		  								}else{
		  									//delete_post_meta( $product_id, 'mfn_product_cat_template'.$mfn_lang );
		  									update_post_meta( $product_id, 'mfn_product_cat_template'.$mfn_lang, 'excluded' );
		  								}
		  							}
		  						}*/

		  						if($con->rule == 'include'){
		  							update_option( 'mfn_sinle_product_tmpl_all_cats'.$mfn_lang, $post_id );
  								}else{
  									delete_option( 'mfn_sinle_product_tmpl_all_cats'.$mfn_lang, $post_id );
  								}

								}
		  				}

		  				// all product tags
		  				if( $con->var == 'producttag' && $con->producttag == 'all' ){
		  					// set for all tags
		  					$tags = get_terms( 'product_tag', array( 'hide_empty' => false ) );
								if( count($tags) > 0 ){
									foreach($tags as $tag){
			  						if($cond_meta_key == 'mfn_shop_template'){
			  							if($con->rule == 'include'){
			  								update_term_meta( $tag->term_id, $cond_meta_key.$mfn_lang, $post_id);
			  							}else{
			  								//delete_term_meta( $tag->term_id, $cond_meta_key.$mfn_lang);
			  								update_term_meta( $tag->term_id, $cond_meta_key.$mfn_lang, 'excluded');
			  							}
										}else{
											/*$products = get_posts( array( 'post_type'	=> 'product', 'numberposts' => -1, 'tax_query' => array( array( 'taxonomy' => 'product_tag', 'field' => 'term_id', 'terms' => $tag->term_id ) ) ) );
				  						if(isset($products) && count($products) > 0){
				  							foreach ($products as $product) {

				  								$product_id = $product->ID;
				  								if( defined( 'ICL_SITEPRESS_VERSION' ) && !empty($tmpl_lang['language_code']) ){
				  									$product_id = apply_filters( 'wpml_object_id', $product->ID, 'product', null, $tmpl_lang['language_code'] );
				  								}


				  								if($con->rule == 'include'){
				  									update_post_meta( $product_id, 'mfn_product_tag_template'.$mfn_lang, $post_id );
				  								}else{
				  									//delete_post_meta( $product_id, 'mfn_product_tag_template'.$mfn_lang);
				  									update_post_meta( $product_id, 'mfn_product_tag_template'.$mfn_lang, 'excluded' );
				  								}
				  							}
				  						}*/

				  						if($con->rule == 'include'){
				  							update_option( 'mfn_sinle_product_tmpl_all_tags'.$mfn_lang, $post_id );
		  								}else{
		  									delete_option( 'mfn_sinle_product_tmpl_all_tags'.$mfn_lang, $post_id );
		  								}
				  						
										}
									}
								}
		  				}

		  				// specified categories
		  				if( $con->var == 'productcategory' && $con->productcategory != 'all' ){
		  					// set for specified cat
								if( is_numeric($con->productcategory) ){
									if($cond_meta_key == 'mfn_shop_template'){
										if($con->rule == 'include'){
											update_term_meta( $con->productcategory, $cond_meta_key.$mfn_lang, $post_id );
										}else{
											update_term_meta( $con->productcategory, $cond_meta_key.$mfn_lang, 'excluded' );
										}
									}else{
										$products = get_posts( array( 'post_type'	=> 'product', 'numberposts' => -1, 'tax_query' => array( array( 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $con->productcategory ) ) ) );
			  						if(isset($products) && count($products) > 0){
			  							foreach ($products as $product) {

			  								$product_id = $product->ID;
			  								if( defined( 'ICL_SITEPRESS_VERSION' ) && !empty($tmpl_lang['language_code']) ){
			  									$product_id = apply_filters( 'wpml_object_id', $product->ID, 'product', null, $tmpl_lang['language_code'] );
			  								}

			  								if($con->rule == 'include'){
			  									update_post_meta( $product_id, 'mfn_product_cat_template'.$mfn_lang, $post_id );
			  								}else{
			  									//delete_post_meta( $product_id, 'mfn_product_cat_template'.$mfn_lang );
			  									update_post_meta( $product_id, 'mfn_product_cat_template'.$mfn_lang, 'excluded' );
			  								}
			  							}
			  						}
									}
								}
		  				}

		  				// specified tags
		  				if( $con->var == 'producttag' && $con->producttag != 'all' ){
		  					// set for specified tag
								if( is_numeric($con->producttag) ){
									if($cond_meta_key == 'mfn_shop_template'){
										if($con->rule == 'include'){
											update_term_meta( $con->producttag, $cond_meta_key.$mfn_lang, $post_id );
										}else{
											update_term_meta( $con->producttag, $cond_meta_key.$mfn_lang, 'excluded' );
											//delete_term_meta( $con->producttag, $cond_meta_key );
										}
									}else{
										$products = get_posts( array( 'post_type'	=> 'product', 'numberposts' => -1, 'tax_query' => array( array( 'taxonomy' => 'product_tag', 'field' => 'term_id', 'terms' => $con->producttag ) ) ) );
			  						if(isset($products) && count($products) > 0){
			  							foreach ($products as $product) {

			  								$product_id = $product->ID;
			  								if( defined( 'ICL_SITEPRESS_VERSION' ) && !empty($tmpl_lang['language_code']) ){
			  									$product_id = apply_filters( 'wpml_object_id', $product->ID, 'product', null, $tmpl_lang['language_code'] );
			  								}

			  								if($con->rule == 'include'){
			  									update_post_meta( $product_id, 'mfn_product_tag_template'.$mfn_lang, $post_id );
			  								}else{
			  									update_post_meta( $product_id, 'mfn_product_tag_template'.$mfn_lang, 'excluded' );
			  									//delete_post_meta( $product_id, 'mfn_product_tag_template'.$mfn_lang );

			  								}
			  							}
			  						}
									}
								}
		  				}

						}
					}

				}
			}

		}

		public function set_addons_templates_conditions($type) {
			global $wpdb;

			delete_option( 'mfn_'.$type.'_addons_archives' );
			delete_option( 'mfn_'.$type.'_addons_singular' );


			$archives = array();
			$singular = array();

			$templates = get_posts(
				array(
					'post_type'	=> 'template',
					'orderby' => 'date',
        	'order' => 'ASC',
        	'numberposts' => -1,
        	'meta_query' => array(
		        array(
	            'key'   => 'mfn_template_type',
	            'compare' => '=',
	            'value' => $type,
		        )
			    )
				)
			);


			if(isset($templates) && is_array($templates) && count($templates) > 0){
				foreach($templates as $t=>$tmp){

					$tmpl_id = $tmp->ID;
					$t_lang = '';
					$conditions = (array) json_decode( get_post_meta($tmpl_id, 'mfn_template_conditions', true) );

					if(isset($conditions) && is_array($conditions) && count($conditions) > 0 ){
						foreach($conditions as $con){

							if( $con->var == 'everywhere' ){
								if( $con->rule == 'include' ){

									$archives['post']['all'][] = $tmpl_id;
									$archives['product']['all'][] = $tmpl_id;
									$archives['portfolio']['all'][] = $tmpl_id;
									$archives['offer']['all'][] = $tmpl_id;

									$singular['page']['all'][] = $tmpl_id;
									$singular['post']['all'][] = $tmpl_id;
									$singular['product']['all'][] = $tmpl_id;
									$singular['portfolio']['all'][] = $tmpl_id;
									$singular['offer']['all'][] = $tmpl_id;

								}
							}

							if( $con->var == 'archives' ){
								if( $con->rule == 'include' ){
									if( strpos($con->archives, ':' ) !== false ){
										// term id
										$explode = explode(':', $con->archives);

										$term_id = $explode[1];
										$post_type = $explode[0];

										// set term by id
										$archives[$term_id][] = $tmpl_id;

									}elseif( !empty($con->archives) ){

										// all term
										$archives[$con->archives]['all'][] = $tmpl_id;

									}elseif( empty($con->archives) ){

										// all archives 
										$archives['post']['all'][] = $tmpl_id;
										$archives['product']['all'][] = $tmpl_id;
										$archives['portfolio']['all'][] = $tmpl_id;
										$archives['offer']['all'][] = $tmpl_id;

									}
								}elseif( $con->rule == 'exclude' ){
									if( strpos($con->archives, ':' ) !== false ){
										// term id
										$explode = explode(':', $con->archives);

										$term_id = $explode[1];
										$post_type = $explode[0];

										// set term by id

										$archives[$term_id]['exclude'][] = $tmpl_id;

									}elseif( !empty($con->archives) && is_array( $archives[$con->archives]['all'] ) ){
										// all term
										foreach( $archives[$con->archives]['all'] as $t=>$t_id ){
											if( $t_id == $tmpl_id ) unset($archives[$con->archives]['all'][$t]);
										}

									}elseif( empty($con->archives) ){
										if( !empty($archives['post']['all'][$tmpl_id]) ) unset( $archives['post']['all'][$tmpl_id] );
										if( !empty($archives['product']['all'][$tmpl_id]) ) unset( $archives['product']['all'][$tmpl_id] );
										if( !empty($archives['portfolio']['all'][$tmpl_id]) ) unset( $archives['portfolio']['all'][$tmpl_id] );
										if( !empty($archives['offer']['all'][$tmpl_id]) ) unset( $archives['offer']['all'][$tmpl_id] );
									}
								}
							}elseif( $con->var == 'singular' ){

								if( $con->rule == 'include' ){
									if( strpos($con->singular, ':' ) !== false ){
										// term id
										$explode = explode(':', $con->singular);

										$term_id = $explode[1];
										$post_type = $explode[0];

										// set term by id
										$singular[$term_id][] = $tmpl_id;

									}elseif( !empty($con->singular) ){

										// all term
										$singular[$con->singular]['all'][] = $tmpl_id;

									}elseif( empty($con->singular) ){

										// all singular 
										$singular['page']['all'][] = $tmpl_id;
										$singular['post']['all'][] = $tmpl_id;
										$singular['product']['all'][] = $tmpl_id;
										$singular['portfolio']['all'][] = $tmpl_id;
										$singular['offer']['all'][] = $tmpl_id;

									}
								}elseif( $con->rule == 'exclude' ){
									if( strpos($con->singular, ':' ) !== false ){
										// term id
										$explode = explode(':', $con->singular);

										$term_id = $explode[1];
										$post_type = $explode[0];

										// set term by id

										$singular[$term_id]['exclude'][] = $tmpl_id;

									}elseif( !empty($con->singular) && is_array( $singular[$con->singular]['all'] ) ){
										// all term
										
										foreach( $singular[$con->singular]['all'] as $t=>$t_id ){
											if( $t_id == $tmpl_id ) unset($singular[$con->singular]['all'][$t]);
										}
										
									}elseif( empty($con->singular) ){
										if( !empty($singular['page']['all'][$tmpl_id]) ) unset( $singular['page']['all'][$tmpl_id] );
										if( !empty($singular['post']['all'][$tmpl_id]) ) unset( $singular['post']['all'][$tmpl_id] );
										if( !empty($singular['product']['all'][$tmpl_id]) ) unset( $singular['product']['all'][$tmpl_id] );
										if( !empty($singular['portfolio']['all'][$tmpl_id]) ) unset( $singular['portfolio']['all'][$tmpl_id] );
										if( !empty($singular['offer']['all'][$tmpl_id]) ) unset( $singular['offer']['all'][$tmpl_id] );
									}
								}
							}

							update_option( 'mfn_'.$type.'_addons_archives', $archives );
							update_option( 'mfn_'.$type.'_addons_singular', $singular );


						}
					}

				}
			}


		}




		/**
		 * Set Header Templates Conditions
		 */

		public function reset_global_templates_conditions($type) {
			global $wpdb;

			delete_option( 'mfn_'.$type.'_post_single' );
			delete_option( 'mfn_'.$type.'_page_single' );
			delete_option( 'mfn_'.$type.'_product_single' );
			delete_option( 'mfn_'.$type.'_portfolio_single' );
			delete_option( 'mfn_'.$type.'_offer_single' );

			delete_option( 'mfn_'.$type.'_post_single_excluded' );
			delete_option( 'mfn_'.$type.'_page_single_excluded' );
			delete_option( 'mfn_'.$type.'_product_single_excluded' );
			delete_option( 'mfn_'.$type.'_portfolio_single_excluded' );
			delete_option( 'mfn_'.$type.'_offer_single_excluded' );

			delete_option( 'mfn_'.$type.'_post_arch' );
			delete_option( 'mfn_'.$type.'_product_arch' );
			delete_option( 'mfn_'.$type.'_portfolio_arch' );
			delete_option( 'mfn_'.$type.'_offer_arch' );
			delete_option( 'mfn_'.$type.'_page_arch' );

			delete_option( 'mfn_'.$type.'_post_arch_excluded' );
			delete_option( 'mfn_'.$type.'_product_arch_excluded' );
			delete_option( 'mfn_'.$type.'_portfolio_arch_excluded' );
			delete_option( 'mfn_'.$type.'_offer_arch_excluded' );
			delete_option( 'mfn_'.$type.'_page_arch_excluded' );

			$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'mfn_'.$type.'_post' ) );
			$wpdb->delete( $wpdb->prefix . 'termmeta', array( 'meta_key' => 'mfn_'.$type.'_term' ) );

			$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'mfn_'.$type.'_post_excluded' ) );
			$wpdb->delete( $wpdb->prefix . 'termmeta', array( 'meta_key' => 'mfn_'.$type.'_term_excluded' ) );
		}

		public function set_global_templates_conditions($type) {
			global $wpdb;
			// mfn-header-tmpl-post
			// mfn-header-tmpl-term
			// mfn-header-tmpl-{post/product/portfolio/offer}
			// mfn-header-tmpl-entire-site

			// reset

			// wpml fix
			if( defined( 'ICL_SITEPRESS_VERSION' ) ){
				$default_lang = apply_filters('wpml_default_language', NULL );
				$languages = apply_filters( 'wpml_active_languages', NULL );
				if( is_iterable($languages) ){
					foreach ($languages as $lang) {
						if( isset($lang['code']) && $lang['code'] != $default_lang ){
							$this->reset_global_templates_conditions($type.'_'.$lang['code']);
						}
					}
				}
			}

			$this->reset_global_templates_conditions($type);

			// set

			$templates = get_posts(
				array(
					'post_type'	=> 'template',
					'orderby' => 'date',
        	'order' => 'ASC',
        	'numberposts' => -1,
        	'meta_query' => array(
		        array(
	            'key'   => 'mfn_template_type',
	            'compare' => '=',
	            'value' => $type,
		        )
			    )
				)
			);

			if(isset($templates) && is_array($templates) && count($templates) > 0){
				foreach($templates as $t=>$tmp){

					$t_lang = '';
					$tmpl_id = $tmp->ID;
					$conditions = (array) json_decode( get_post_meta($tmpl_id, 'mfn_template_conditions', true) );

					// wpml fix
					if( defined( 'ICL_SITEPRESS_VERSION' ) ){
						$tmpl_lang = apply_filters( 'wpml_post_language_details', NULL, $tmpl_id ) ;
						if( isset($tmpl_lang['language_code']) && $tmpl_lang['language_code'] != $default_lang ){
							$t_lang = '_'.$tmpl_lang['language_code'];
						}
					}

					if(isset($conditions) && is_array($conditions) && count($conditions) > 0 ){
						foreach($conditions as $con){

							$term = 'category';
							if( !empty($con->archives) ){
								if( strpos($con->archives, 'product') !== false ) $term = 'product_cat';
								if( strpos($con->archives, 'offer') !== false ) $term = 'offer_types';
								if(	strpos($con->archives, 'portfolio') !== false ) $term = 'portfolio_types';
							}else if( !empty($con->singular) ){
								if( strpos($con->singular, 'product') !== false ) $term = 'product_cat';
								if( strpos($con->singular, 'offer') !== false ) $term = 'offer_types';
								if( strpos($con->singular, 'portfolio') !== false ) $term = 'portfolio_types';
							}


							// entire site

							if( $con->var == 'everywhere' ){
								if( $con->rule == 'include' ){
									update_option( 'mfn_'.$type.$t_lang.'_post_single', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_product_single', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_portfolio_single', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_offer_single', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_page_single', $tmpl_id );

									update_option( 'mfn_'.$type.$t_lang.'_post_arch', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_product_arch', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_portfolio_arch', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_offer_arch', $tmpl_id );
									update_option( 'mfn_'.$type.$t_lang.'_page_arch', $tmpl_id );
								}
							}

							// terms

							if( $con->var == 'archives' ){
								if( $con->rule == 'include' ){
									if( strpos($con->archives, ':' ) !== false ){
										// term id
										$explode = explode(':', $con->archives);

										$term_id = $explode[1];
										$post_type = $explode[0];

										// set term by id
										update_term_meta( $term_id, 'mfn_'.$type.$t_lang.'_term', $tmpl_id );

									}elseif( !empty($con->archives) ){
										// all term
										update_option( 'mfn_'.$type.$t_lang.'_'.$con->archives.'_arch', $tmpl_id );

									}elseif( empty($con->archives) ){
										update_option( 'mfn_'.$type.$t_lang.'_post_arch', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_product_arch', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_portfolio_arch', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_offer_arch', $tmpl_id );
									}
								}elseif( $con->rule == 'exclude' ){
									if( strpos($con->archives, ':' ) !== false ){
										// term id
										$explode = explode(':', $con->archives);

										$term_id = $explode[1];
										$post_type = $explode[0];

										// set term by id
										update_term_meta( $term_id, 'mfn_'.$type.$t_lang.'_term_excluded', $term_id );

									}elseif( !empty($con->archives) ){
										// all term
										update_option( 'mfn_'.$type.$t_lang.'_'.$con->archives.'_arch_excluded', $tmpl_id );

									}elseif( empty($con->archives) ){
										update_option( 'mfn_'.$type.$t_lang.'_post_arch_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_product_arch_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_portfolio_arch_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_offer_arch_excluded', $tmpl_id );
									}
								}
							}

							// singulars

							if( $con->var == 'singular' ){
								if( $con->rule == 'include' ){
									if( strpos($con->singular, ':' ) !== false ){

										$explode = explode(':', $con->singular);

										$term_id = $explode[1];
										$post_type = $explode[0];

										$posts = get_posts( array('post_type'	=> $post_type, 'numberposts' => -1, 'tax_query' => array(  array( 'taxonomy' => $term, 'field' => 'term_id', 'terms' => $term_id ) ) ) );

										if( is_iterable($posts) ){
											foreach( $posts as $post ){
												update_post_meta( $post->ID, 'mfn_'.$type.$t_lang.'_post', $tmpl_id );
											}
										}

									}elseif( !empty($con->singular) ){

										update_option( 'mfn_'.$type.$t_lang.'_'.$con->singular.'_single', $tmpl_id );

									}elseif( empty($con->singular) ){
										update_option( 'mfn_'.$type.$t_lang.'_post_single', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_product_single', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_portfolio_single', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_offer_single', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_page_single', $tmpl_id );
									}
								}elseif( $con->rule == 'exclude' ){
									if( strpos($con->singular, ':' ) !== false ){

										$explode = explode(':', $con->singular);

										$term_id = $explode[1];
										$post_type = $explode[0];

										$posts = get_posts( array('post_type'	=> $post_type, 'numberposts' => -1, 'tax_query' => array(  array( 'taxonomy' => $term, 'field' => 'term_id', 'terms' => $term_id ) ) ) );

										if( is_iterable($posts) ){
											foreach( $posts as $post ){
												update_post_meta( $post->ID, 'mfn_'.$type.$t_lang.'_post_excluded', $tmpl_id );
											}
										}

									}elseif( !empty($con->singular) ){

										update_option( 'mfn_'.$type.$t_lang.'_'.$con->singular.'_single', $tmpl_id );

									}elseif( empty($con->singular) ){
										update_option( 'mfn_'.$type.$t_lang.'_post_single_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_product_single_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_portfolio_single_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_offer_single_excluded', $tmpl_id );
										update_option( 'mfn_'.$type.$t_lang.'_page_single_excluded', $tmpl_id );
									}
								}
							}



						}
					}

				}
			}


		}

  }
}
