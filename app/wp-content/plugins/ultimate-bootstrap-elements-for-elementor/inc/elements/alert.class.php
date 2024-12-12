<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;

class UBE_Element_Alert extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-alert';
	}

	public function get_title() {
		return esc_html__( 'Alert', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-alert';
	}

	public function get_ube_keywords() {
		return array( 'alert','notice','message' , 'ube' , 'ube alert' );
	}


	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_wrap_style();
		$this->register_section_title_style();
		$this->register_section_description_style();
	}

	private function register_section_content() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Alert','ube')
			]
		);

		$this->add_control(
			'scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(false),
				'default' => 'primary',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'ube' ),
				'default' => esc_html__( 'This is an Alert', 'ube' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'ube' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Enter your description', 'ube' ),
				'default' => esc_html__( 'I am a description. Click the edit button to change this text.', 'ube' ),
				'separator' => 'none',
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);


		$this->add_control(
			'show_dismiss',
			[
				'label' => esc_html__( 'Dismiss Button', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'show',
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h4',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();


	}

	private function register_section_wrap_style() {
		$this->start_controls_section(
			'section_wrap_style',
			[
				'label' => esc_html__( 'Alert', 'ube' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'alert_text_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-alert' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'alert_background',
			[
				'label' => esc_html__( 'Background Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-alert' => 'background-color: {{VALUE}};border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .ube-alert',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .ube-alert' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ube-alert' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_section_title_style() {
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'ube' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alert-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .alert-heading',
			]
		);

		$this->add_responsive_control(
			'title_space',
			[
				'label' => esc_html__( 'Spacing', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .alert-heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	private function register_section_description_style() {
		$this->start_controls_section(
			'section_description_style',
			[
				'label' => esc_html__( 'Description', 'ube' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .alert-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .alert-description',
			]
		);

		$this->end_controls_section();

	}

	public function render() {
		ube_get_template( 'elements/alert.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/alert.php' );
	}
}