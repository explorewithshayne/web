<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mfn_Elementor_Widget_Live_Search extends \Elementor\Widget_Base {

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
		return 'mfn_live_search';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return __( 'Be • Live search', 'mfn-opts' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'eicon-search';
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
			'min_characters',
			[
				'label' => __( 'Minimal characters', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 3,
			]
		);

		$this->add_control(
			'container_height',
			[
				'label' => __( 'Search results container height', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 1000,
				'step' => 10,
				'default' => 300,
			]
		);

    $this->add_control(
			'featured_image',
			[
				'label' => __( 'Featured image', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
          "0" => __('Hide', 'mfn-opts'),
          "1" => __('Show', 'mfn-opts'),
				),
				'default' => '1',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

    $settings['elementor'] = 1;

		echo sc_livesearch( $settings );

	}

}
