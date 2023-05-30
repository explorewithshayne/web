<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mfn_Elementor_Widget_Lottie extends \Elementor\Widget_Base {

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
		return 'mfn_lottie';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return __( 'Be • Lottie', 'mfn-opts' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-lottie';
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
			'file',
			[
				'label' => __( 'Lottie File', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'application/json',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_section',
			[
				'label' => __( 'Settings', 'mfn-opts' ),
			]
		);

		$this->add_control(
			'trigger',
			[
				'label' => __( 'Trigger', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
          'default' => __('Default', 'mfn-opts'),
          'hover' => __('On hover', 'mfn-opts'),
          'click' => __('On click', 'mfn-opts'),
          'scroll' => __('On scroll', 'mfn-opts'),
          'viewport' => __('Viewport', 'mfn-opts'),
				),
				'default' => 'default',
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
        'condition' => [
					'trigger!' => 'scroll',
				],
				'options'	=> array(
          "0" => __('No', 'mfn-opts'),
          "1" => __('Yes', 'mfn-opts'),
				),
				'default' => '0',
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Speed', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0.1,
				'max' => 5,
				'step' => 0.1,
				'default' => 1,
			]
		);

		$this->add_control(
			'viewport',
			[
				'label' => __( 'Viewport bottom offset', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
        'condition' => [
					'trigger' => ['scroll','viewport'],
				],
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'frame_start',
			[
				'label' => __( 'Start point', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'frame_end',
			[
				'label' => __( 'End point', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 100,
			]
		);

    $this->add_control(
			'direction',
			[
				'label' => __( 'Direction', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
        'condition' => [
					'trigger!' => 'scroll',
				],
				'options'	=> array(
          '1' => __('Forward', 'mfn-opts'),
          '-1' => __('Backward', 'mfn-opts'),
				),
				'default' => '1',
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

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

		$settings['file'] = $settings['file']['url'];

		echo sc_lottie( $settings );

	}

}
