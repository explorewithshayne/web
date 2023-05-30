<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mfn_Elementor_Widget_Hover_Box extends \Elementor\Widget_Base {

	/**
	 * Widget base constructor
	 */

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
	}

	/**
	 * Get widget name
	 */

	public function get_name() {
		return 'mfn_hover_box';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return __( 'Be • Hover box', 'mfn-opts' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'far fa-images';
	}

	/**
	 * Get widget categories
	 */

	public function get_categories() {
		return [ 'mfn_builder' ];
	}

	/**
	 * Register widget controls
	 */

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'mfn-opts' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image_hover',
			[
				'label' => __( 'Image hover', 'mfn-opts' ),
				'label' => __( 'Both images must have the same size', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'link_section',
			[
				'label' => __( 'Link', 'mfn-opts' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'target',
			[
				'label' => __( 'Target', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
					0 => __('_self', 'mfn-opts'),
					1 => __('_blank', 'mfn-opts'),
				),
				'default' => 0,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	 protected function render() {

 		$settings = $this->get_settings_for_display();

 		$wpml_translated_images = [];

 		foreach ( ['image', 'image_hover'] as $key ) {
 			if ( ! empty($settings[$key]['id'] ) && 'library' === $settings[$key]['source'] ) {
 				// If we replace array with image ID, it is handled in mfn_vc_image()
 				$wpml_translated_images[$key] = apply_filters( 'wpml_object_id', $settings[$key]['id'], 'attachment', true );
 			}
 		}

 		$settings['image'] = $settings['image']['url'];
 		$settings['image_hover'] = $settings['image_hover']['url'];

 		$settings = ! empty($wpml_translated_images) ? array_merge( $settings, $wpml_translated_images ) : $settings;

 		echo sc_hover_box( $settings );

 	}

}
