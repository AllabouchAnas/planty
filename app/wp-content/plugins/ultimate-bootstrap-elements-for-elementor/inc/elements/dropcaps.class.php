<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Dropcaps extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-dropcaps';
	}

	public function get_title()
	{
		return esc_html__('Dropcaps', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-editor-paragraph';
	}

	public function get_ube_keywords()
	{
		return array('dropcaps' , 'ube', 'ube dropcaps');
	}

	protected function register_controls()
	{
		$this->register_section_content();
		$this->register_section_content_style();
		$this->register_section_content_first_letter_style();

	}

	private function register_section_content(){

		$this->start_controls_section('dropcaps_settings_section', [
			'label' => esc_html__('Content', 'ube'),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'classic' => esc_html__( 'Classic', 'ube' ),
					'sharp' => esc_html__( 'Sharp', 'ube' ),
					'outline' => esc_html__( 'Outline', 'ube' ),
				],
				'default' => 'classic',
			]
		);

		$this->add_control(
			'sharp',
			[
				'label' => esc_html__( 'Sharp', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'ube' ),
					'square' => esc_html__( 'Square', 'ube' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'classic',
				],
			]
		);

		$this->add_control(
			'dropcaps_text',
			[
				'label'         => esc_html__( 'Content', 'ube' ),
				'type'          => Controls_Manager::TEXTAREA,
				'rows' => 15,
				'default'       => esc_html__( 'Lorem ipsum dolor sit amet, consec adipisicing elit, sed do eiusmod tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip exl Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incidid ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 'ube' ),
				'placeholder'   => esc_html__( 'Enter Your Dropcaps Content.', 'ube' ),
				'separator'=>'before',
			]
		);

		$this->end_controls_section();
	}

	private function register_section_content_style(){

		$this->start_controls_section('dropcaps_settings_section_style', [
			'label' => esc_html__('Content', 'ube'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);
		$this->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Text Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'separator' =>'before',
				'selectors' => [
					'{{WRAPPER}} .ube-dropcaps p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ube-dropcaps p',
			]
		);

		$this->end_controls_section();
	}

	private function register_section_content_first_letter_style(){

		$this->start_controls_section('dropcaps_settings_first_letter_style', [
			'label' => esc_html__('First Letter', 'ube'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control(
			'content_dropcaps_color',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_dropcaps_typography',
				'selector' => '{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_dropcaps_background',
				'label' => esc_html__( 'Background', 'ube' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter',
				'condition' => [
					'view' => 'sharp',
				],
			]
		);

		$this->add_responsive_control(
			'content_dropcaps_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' =>'before',
			]
		);

		$this->add_responsive_control(
			'content_dropcaps_margin',
			[
				'label' => esc_html__( 'Margin', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_dropcaps_border',
				'label' => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter',
				'condition' => [
					'view!' => 'classic',
				],
			]
		);

		$this->add_responsive_control(
			'content_dropcaps_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-dropcaps p:first-of-type:first-letter' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'view!' => 'classic',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/dropcaps.php', array(
			'element' => $this
		));
	}

	protected function content_template() {
		ube_get_template('elements-view/dropcaps.php');
	}
}