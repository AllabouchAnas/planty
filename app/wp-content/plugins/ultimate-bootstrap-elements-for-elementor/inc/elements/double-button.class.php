<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Core\Schemes;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Double_Button extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-double-button';
	}

	public function get_title()
	{
		return esc_html__('Double Button', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-dual-button';
	}

	public function get_ube_keywords()
	{
		return array('double button' , 'ube' , 'button' , 'ube double button');
	}

	protected function register_controls()
	{
		$this->register_section_content();
		$this->register_section_button_one();
		$this->register_section_button_two();
		$this->register_section_button_area();
		$this->register_section_button_one_style();
		$this->register_section_button_two_style();
		$this->register_section_middle_text_style();
	}

	private function register_section_content(){

		$this->start_controls_section('double-button_settings_section', [
			'label' => esc_html__('Double Button', 'ube'),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'double_button_shape',
			[
				'label' => esc_html__( 'Shape', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'btn-classic',
				'options' => [
					'btn-classic' => esc_html__( 'Default', 'ube' ),
					'btn-rounded' => esc_html__( 'Rounded', 'ube' ),
					'btn-square' => esc_html__( 'Square', 'ube' ),
					'btn-round' => esc_html__( 'Round', 'ube' ),
				],
				'condition' => [
					'double_button_before_bg' => '',
				]
			]
		);

		$this->add_control(
			'double_button_size',
			[
				'label'   => esc_html__( 'Size', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => esc_html__( 'Extra Small', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'md' => esc_html__( 'Medium', 'ube' ),
					'lg' => esc_html__( 'Large', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
			]
		);

		$this->add_control(
			'show_button_middle_text',
			[
				'label' => esc_html__( 'Middle Text', 'ube' ),
				'type'  => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'button_middle_text',
			[
				'label' => esc_html__( 'Middle Text', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Or', 'ube' ),
				'condition'   => [
					'show_button_middle_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'double_button_before_bg',
			[
				'label' => esc_html__( 'Skew Background', 'ube' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	private function register_section_button_one(){

		$this->start_controls_section('settings_section_button_one', [
			'label' => esc_html__('Button One', 'ube'),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'button_one_text',
			[
				'label' => esc_html__( 'Text', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Button', 'ube' ),
			]
		);

		$this->add_control(
			'button_one_link',
			[
				'label' => esc_html__( 'Link', 'ube' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'button_one_icon',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'icon_one_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'ube' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 150,
					],
				],
				'condition' => [
					'button_one_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one i'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-btn-one svg'  => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();
	}

	private function register_section_button_two(){

		$this->start_controls_section('settings_section_button_two', [
			'label' => esc_html__('Button Two', 'ube'),
			'tab'   => Controls_Manager::TAB_CONTENT,
		]);


		$this->add_control(
			'button_two_text',
			[
				'label' => esc_html__( 'Text', 'ube' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Button', 'ube' ),
			]
		);


		$this->add_control(
			'button_two_link',
			[
				'label' => esc_html__( 'Link', 'ube' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'button_two_icon',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'icon_two_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'ube' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 150,
					],
				],
				'condition' => [
					'button_one_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two i'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-btn-two svg'  => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->end_controls_section();
	}

	private function register_section_button_area(){

		$this->start_controls_section('settings_section_button_area', [
			'label' => esc_html__('Button Area', 'ube'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'double_button_width',
			[
				'label' => esc_html__( 'Width', 'ube' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'max' => 100,
						'min' => 0,
					],
					'px' => [
						'max' => 1000,
						'min' => 300,
					],
				],
				'size_units' => ['%', 'px'],
				'selectors' => [
					'{{WRAPPER}} .ube-double-button'  => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'double_button_height',
			[
				'label' => esc_html__( 'Height', 'ube' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'max' => 100,
						'min' => 0,
					],
					'px' => [
						'max' => 300,
						'min' => 0,
					],
				],
				'size_units' => ['%', 'px'],
				'selectors' => [
					'{{WRAPPER}} .ube-double-button .btn'  => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'double_button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-double-button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'double_button_before_bg!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'double_button_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-double-button',
				'condition' => [
					'double_button_before_bg!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'double_button_align',
			[
				'label' => esc_html__( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors_dictionary' => [
					'left' => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right' => 'margin-left: auto',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-double-button' => '{{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

	}

	private function register_section_button_one_style(){

		$this->start_controls_section('settings_section_button_one_style', [
			'label' => esc_html__('Button One', 'ube'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'double_button_one_align',
			[
				'label' => esc_html__( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'double_button_one_typography',
				'label' => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-one',
			]
		);

		$this->add_responsive_control(
			'double_button_one_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('double_button_one_style_tabs');

		$this->start_controls_tab(
			'double_button_one_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'double_button_one_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'double_button_one_background',
				'label' => esc_html__( 'Background', 'ube' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-btn-one,{{WRAPPER}} .before_bg .ube-btn-one::before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'double_button_one_border',
				'label' => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-one',
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->add_responsive_control(
			'double_button_one_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'double_button_one_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-one',
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->end_controls_tab(); // Button One Normal style End

		// Button One Hover style start
		$this->start_controls_tab(
			'double_button_one_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'double_button_one_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'double_button_one_hover_background',
				'label' => esc_html__( 'Background', 'ube' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-btn-one:hover, {{WRAPPER}} .before_bg .ube-btn-one:hover::before',
			]
		);

		$this->add_control(
			'double_button_one_color_border',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-one:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'double_button_one_hover_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-one:hover',
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function register_section_button_two_style(){

		$this->start_controls_section('settings_section_button_two_style', [
			'label' => esc_html__('Button Two', 'ube'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'double_button_two_align',
			[
				'label' => esc_html__( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'double_button_two_typography',
				'label' => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-two',
			]
		);

		$this->add_responsive_control(
			'double_button_two_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('double_button_two_style_tabs');

		$this->start_controls_tab(
			'double_button_two_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'double_button_two_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'double_button_two_background',
				'label' => esc_html__( 'Background', 'ube' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-btn-two,{{WRAPPER}} .before_bg .ube-btn-two::before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'double_button_two_border',
				'label' => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-two',
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->add_responsive_control(
			'double_button_two_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'double_button_two_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-two',
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->end_controls_tab();

		// Button two Hover style start
		$this->start_controls_tab(
			'double_button_two_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'double_button_two_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'double_button_two_hover_background',
				'label' => esc_html__( 'Background', 'ube' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-btn-two:hover, {{WRAPPER}} .before_bg .ube-btn-two:hover::before',
			]
		);

		$this->add_control(
			'double_button_two_color_border',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-btn-two:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'double_button_two_hover_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-btn-two:hover',
				'condition' => [
					'double_button_before_bg' => '',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	private function register_section_middle_text_style() {

		$this->start_controls_section( 'settings_section_middle_text_style', [
			'label' => esc_html__( 'Middle Text', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control(
			'double_button_middletext_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'em' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-middle-text' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'double_button_middletext_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   =>'',
				'selectors' => [
					'{{WRAPPER}} .ube-middle-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'double_button_middletext_background',
				'label' => esc_html__( 'Background', 'ube' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-middle-text',

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'double_button_middletext_typography',
				'label' => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-middle-text',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'double_button_middletext_border',
				'label' => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-middle-text',
			]
		);

		$this->add_responsive_control(
			'double_button_middletext_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-middle-text' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'double_button_middletext_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-middle-text',
			]
		);

		$this->end_controls_section();
	}
	public function render()
	{
		ube_get_template('elements/double-button.php', array(
			'element' => $this
		));
	}
	protected function content_template() {
		ube_get_template( 'elements-view/double-button.php' );
	}
}