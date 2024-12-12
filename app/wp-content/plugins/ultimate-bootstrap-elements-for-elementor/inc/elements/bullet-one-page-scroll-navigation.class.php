<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;

class UBE_Element_Bullet_One_Page_Scroll_Navigation extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-bullet-one-page-scroll-navigation';
	}

	public function get_title() {
		return esc_html__( 'Bullet One Page Scroll Navigation', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-scroll';
	}

	public function get_ube_keywords() {
		return array(
			'scroll',
			'bullet one page scroll navigation',
			'bullet',
			'ube',
			'ube bullet one page scroll navigation'
		);
	}

	public function get_script_depends() {
		return array( 'ube-widget-bullet-one-page-scroll-navigation' );
	}


	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_style();

	}

	private function register_section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ube' )
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'section_id', [
				'label'       => esc_html__( 'Section ID', 'ube' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'section_title', [
				'label'       => esc_html__( 'Section Title', 'ube' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'dots_skin',
			[
				'label'       => esc_html__( 'Dots Skin', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'dark',
				'label_block' => false,
				'options'     => [
					'dark'  => esc_html__( 'Dark', 'ube' ),
					'light' => esc_html__( 'Light', 'ube' ),
				],
			]
		);
		$repeater->add_control(
			'dots_dark_color',
			[
				'label'     => esc_html__( 'Dots Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav' => '--ube-bullet-nav-color: {{VALUE}};',
				],
				'condition' => [
					'dots_skin' => 'dark'
				]
			]
		);
		$repeater->add_control(
			'dots_light_color',
			[
				'label'     => esc_html__( 'Dots Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav.nav-light' => '--ube-bullet-nav-color: {{VALUE}};',
				],
				'condition' => [
					'dots_skin' => 'light'
				]
			]
		);

		$this->add_control(
			'scrollspy_items',
			[
				'label'       => esc_html__( 'Scrollspy', 'ube' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'separator'   => 'before',
				'title_field' => '{{ section_title }}',
				'fields'      => $repeater->get_controls(),
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'     => esc_html__( 'Dots Position', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'right',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();


	}

	private function register_section_style() {
		$this->start_controls_section(
			'section_dots_style',
			[
				'label' => esc_html__( 'Dots Style', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dots_spacing',
			[
				'label'     => esc_html__( 'Nav Spacing', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => - 300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-nav' => '--ube-dots-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'dot_spacing',
			[
				'label'     => esc_html__( 'Dot Spacing', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-nav .nav-link:nth-child(n+2)' => '--ube-dot-spacing: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	public function render() {
		ube_get_template( 'elements/bullet-one-page-scroll-navigation.php', array(
			'element' => $this
		) );
	}
}