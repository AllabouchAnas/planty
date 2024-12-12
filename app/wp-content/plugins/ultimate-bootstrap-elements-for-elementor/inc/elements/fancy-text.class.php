<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Repeater;

class UBE_Element_Fancy_Text extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-fancy-text';
	}

	public function get_title()
	{
		return esc_html__('Fancy Text', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-animated-headline';
	}

	public function get_ube_keywords()
	{
		return array('fancy text', 'heading' , 'ube' , 'ube fancy text');
	}

	public function get_script_depends()
	{
		return array('ube-widget-fancy-text');
	}

	protected function register_controls()
	{
		$this->start_controls_section('fancy_text_settings_section', [
			'label' => esc_html__('Fancy Text', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control('fancy_text_tag', [
			'label' => esc_html__('HTML Tag', 'ube'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'h1' => esc_html__('H1', 'ube'),
				'h2' => esc_html__('H2', 'ube'),
				'h3' => esc_html__('H3', 'ube'),
				'h4' => esc_html__('H4', 'ube'),
				'h5' => esc_html__('H5', 'ube'),
				'h6' => esc_html__('H6', 'ube'),
				'div' => esc_html__('div', 'ube'),
				'span' => esc_html__('span', 'ube'),
				'p' => esc_html__('p', 'ube'),
			],
			'default' => 'h2',
		]);


		$this->add_control('fancy_text_prefix', [
			'label' => esc_html__('Prefix', 'ube'),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__('This page is', 'ube'),
			'description' => esc_html__('Text before Fancy text', 'ube'),
			'separator' => 'before',
			'label_block' => true,
			'dynamic' => [
				'active' => true,
			],
		]);

		$repeater = new Repeater();

		$repeater->add_control(
			'fancy_text_field_animated',
			[
				'label' => esc_html__('Text', 'ube'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Better', 'ube'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'fancy_text_animated_text',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'label' => esc_html__('Animated Text', 'ube'),
				'label_block' => true,
				'separator' => 'before',
				'default' => [
					['fancy_text_field_animated' => esc_html__('Better', 'ube')],
					['fancy_text_field_animated' => esc_html__('Bigger', 'ube')],
					['fancy_text_field_animated' => esc_html__('Faster', 'ube')],
				],
				'title_field' => '{{{ fancy_text_field_animated }}}',
			]
		);

		$this->add_control(
			'fancy_text_suffix',
			[
				'label' => esc_html__('Suffix', 'ube'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'separator' => 'before',
				'dynamic' => [
					'active' => true,
				],
				'description' => esc_html__('Text after Fancy text', 'ube'),
			]
		);

		$this->add_responsive_control(
			'fancy_text_align',
			[
				'label' => esc_html__('Alignment', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('fancy_text_additional_settings_section', [
			'label' => esc_html__('Additional Settings', 'ube'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'fancy_text_animation_type',
			[
				'label' => esc_html__('Animation Type', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'typing' => esc_html__('Typing', 'ube'),
					'loading' => esc_html__('Loading Bar', 'ube'),
					'zoom-in' => esc_html__('Zoom In', 'ube'),
					'zoom-out' => esc_html__('Zoom Out', 'ube'),
					'slider-right' => esc_html__('Slider Right', 'ube'),
					'slider-left' => esc_html__('Slider Left', 'ube'),
					'slider-top' => esc_html__('Slider Top', 'ube'),
					'slider-bottom' => esc_html__('Slider Bottom', 'ube'),
					'rotate' => esc_html__('Rotate Style', 'ube'),
				],
				'default' => 'typing',
			]
		);

		$this->add_control(
			'fancy_text_slide_up_pause_time',
			array(
				'label' => esc_html__('Pause Time (Milliseconds)', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('How long should the word/string stay visible? Set a value in milliseconds.', 'ube'),
				'condition' => [
					'fancy_text_animation_type!' => 'typing',
				],
			)
		);

		$this->add_control(
			'fancy_text_typing_speed',
			array(
				'label' => esc_html__('Typing Speed', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'fancy_text_animation_type' => 'typing',
				],
			)
		);
		$this->add_control(
			'fancy_text_typing_delay',
			array(
				'label' => esc_html__('Delay on Change', 'ube'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [
					'fancy_text_animation_type' => 'typing',
				],
			)
		);

		$this->add_control(
			'fancy_text_typing_loop',
			[
				'label' => esc_html__('Loop the Typing', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'ube'),
				'label_off' => esc_html__('No', 'ube'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'fancy_text_animation_type' => 'typing',
				],
			]
		);

		$this->add_control(
				'fancy_text_typing_cursor',
			[
				'label' => esc_html__('Display Type Cursor', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Yes', 'ube'),
				'label_off' => esc_html__('No', 'ube'),
				'return_value' => 'yes',
				'condition' => [
					'fancy_text_animation_type' => 'typing',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section('fancy_text_wrapper_style_section', [
			'tab' => Controls_Manager::TAB_STYLE,
			'label' => esc_html__('Wrapper', 'ube'),
		]);

		$this->add_responsive_control('fancy_text_max_width', [
			'label' => esc_html__('Max Width', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'default' => [
				'unit' => 'px',
			],
			'tablet_default' => [
				'unit' => 'px',
			],
			'mobile_default' => [
				'unit' => 'px',
			],
			'size_units' => ['px', '%'],
			'range' => [
				'%' => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 2000,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-fancy-text' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_responsive_control('fancy_text_alignment', [
			'label' => esc_html__('Alignment', 'ube'),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__('Left', 'ube'),
					'icon' => 'eicon-h-align-left',
				],
				'center' => [
					'title' => esc_html__('Center', 'ube'),
					'icon' => 'eicon-h-align-center',
				],
				'flex-end' => [
					'title' => esc_html__('Right', 'ube'),
					'icon' => 'eicon-h-align-right',
				],
			],
			'condition' => [
				'fancy_text_max_width[size]!' => '',
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
			],
		]);

		$this->add_control('fancy_text_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_section();

		$this->start_controls_section('fancy_text_animated_style_section', [
			'label' => esc_html__('Animated Text', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'fancy_text_animated_text_color',
			'selector' => '{{WRAPPER}} .ube-fancy-text-animated b,{{WRAPPER}} .ube-fancy-text-typing .ube-fancy-text-animated ,{{WRAPPER}} .ube-fancy-text-typing .typed-cursor',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name' => 'fancy_text_animated_typography',
			'selector' => '{{WRAPPER}} .ube-fancy-text-animated b,{{WRAPPER}} .ube-fancy-text-typing .ube-fancy-text-animated',
		]);

		$this->add_control('fancy_text_animated_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);



		$this->add_control(
			'fancy_text_animated_background',
			[
				'label' => esc_html__('Background', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'ube'),
				'label_off' => esc_html__('No', 'ube'),
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fancy_text_background',
				'label' => esc_html__('Background', 'ube'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ube-fancy-text-animated',
				'condition' => [
					'fancy_text_animated_background' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'fancy_text_animated_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-fancy-text-animated b,{{WRAPPER}} .ube-fancy-text-typing .ube-fancy-text-animated',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'fancy_text_animated_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-fancy-text-animated b,{{WRAPPER}} .ube-fancy-text-typing .ube-fancy-text-animated' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'fancy_text_animated_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-fancy-text-animated b,{{WRAPPER}} .ube-fancy-text-typing .ube-fancy-text-animated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'fancy_text_animated_label_border',
			[
				'label' => esc_html__('Border Bar Waiting', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'fancy_text_animation_type' => 'loading',
				],
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'fancy_text_animated_background_border',
			'selector' => '{{WRAPPER}} .ube-fancy-text-animated:after',
			'condition' => [
				'fancy_text_animation_type' => 'loading',
			],
		]);




		$this->end_controls_section();

		$this->start_controls_section('fancy_text_prefix_suffix_style_section', [
			'label' => esc_html__('Prefix & Suffix', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'fancy_text_prefix!' => '',
			],
		]);

		$this->add_group_control(UBE_Controls_Manager::TEXT_GRADIENT, [
			'name' => 'fancy_text_prefix_suffix_color',
			'selector' => '{{WRAPPER}} .ube-fancy-text-before,{{WRAPPER}} .ube-fancy-text-after',
		]);

		$this->add_group_control(Group_Control_Typography::get_type(), [
			'name' => 'fancy_text_prefix_suffix_typography',
			'selector' => '{{WRAPPER}} .ube-fancy-text-before , {{WRAPPER}} .ube-fancy-text-after',
		]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'fancy_text_prefix_suffix_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-fancy-text-before , {{WRAPPER}} .ube-fancy-text-after',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'fancy_text_prefix_suffix_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-fancy-text-before , {{WRAPPER}} .ube-fancy-text-after' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'fancy_text_prefix_suffix_box_shadow',
				'label' => esc_html__('Box Shadow', 'ube'),
				'selector' => '{{WRAPPER}} .ube-fancy-text-before , {{WRAPPER}} .ube-fancy-text-after',
			]
		);

		$this->add_responsive_control(
			'fancy_text_prefix_padding',
			[
				'label' => esc_html__('Padding Prefix', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-fancy-text-before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'fancy_text_suffix_padding',
			[
				'label' => esc_html__('Padding Suffix', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ube-fancy-text-after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	public function data_animation_text($settings)
	{
		if (isset($settings['fancy_text_animated_text'])) {
			foreach ($settings['fancy_text_animated_text'] as $item) {
				if (!empty($item['fancy_text_field_animated'])) {
					$fancy_text[] = $item['fancy_text_field_animated'];
				}
			}
			return $fancy_text;
		}
	}

	public function render()
	{
		ube_get_template('elements/fancy-text.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{
		ube_get_template('elements-view/fancy-text.php');
	}
}