<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Mfn_Elementor_Widget_Table_Of_Contents extends \Elementor\Widget_Base {

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
		return 'mfn_table_of_contents';
	}

	/**
	 * Get widget title
	 */

	public function get_title() {
		return __( 'Be • Table of contents', 'mfn-opts' );
	}

	/**
	 * Get widget icon
	 */

	public function get_icon() {
		return 'fas fa-list';
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
			'title',
			[
				'label' => __( 'Title', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'This is the heading', 'mfn-opts' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
        'label' => __( 'Title tag', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
          'h1' => 'H1',
          'h2' => 'H2',
          'h3' => 'H3',
          'h4' => 'H4',
          'h5' => 'H5',
          'h6' => 'H6',
				),
				'default' => 'h4',
			]
		);

		$this->add_control(
			'tags_anchors',
			[
        'label' => __( 'Anchor by HTML tags)', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
        'label_block' => true,
				'options'	=> array(
          'H1' => 'H1',
          'H2' => 'H2',
          'H3' => 'H3',
          'H4' => 'H4',
          'H5' => 'H5',
          'H6' => 'H6',
				),
				'multiple' => 'true',
        'default' => array(
          'H1' => 'H1',
          'H2' => 'H2',
          'H3' => 'H3',
				),
			]
		);

    $this->add_control(
			'marker_view',
			[
        'label' => __( 'Marker view', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
          'numbers' => 'Numbers',
          'bullets' => 'Bullets'
				),
				'default' => 'numbers',
			]
		);

    $this->add_control(
 			'icon',
 			[
 				'label' => __( 'Icon', 'mfn-opts' ),
 				'type' => \Elementor\Controls_Manager::ICONS,
 			]
 		);

		$this->add_control(
			'url_format',
			[
        'label' => __( 'Link format', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
					'' => __('SEO friendly', 'mfn-opts'),
					'simple' => __('Simple', 'mfn-opts'),
				),
				'default' => '',
			]
		);

		$this->add_control(
			'allow_hide',
			[
				'label' => __( 'Toggle the Visibility', 'mfn-opts' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options'	=> array(
					'' => __('Disable', 'mfn-opts'),
					'enable' => __('Enable', 'mfn-opts'),
					'hide' => __('Enable and hide initially', 'mfn-opts'),
				),
				'default' => '',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend
	 */

	protected function render() {

		$settings = $this->get_settings_for_display();

    // this field is space separated string, ie. 'h1 h2'
    if( ! empty($settings['tags_anchors']) ){
      $settings['tags_anchors'] = implode(' ', $settings['tags_anchors']);
    }

    $settings['icon'] = $settings['icon']['value'];

		echo sc_table_of_contents( $settings );

	}

}
