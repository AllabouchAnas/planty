<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Repeater;

class UBE_Element_Progress extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-progress';
	}

	public function get_title() {
		return esc_html__( 'Progress', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-skill-bar';
	}

	public function get_ube_keywords() {
		return array( 'progress' , 'ube' , 'ube progress' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-progress' );
	}

	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_progess();
		$this->register_section_fill();
	}

	private function register_section_content() {

		$this->start_controls_section( 'progress_settings_section', [
			'label' => esc_html__( 'Progress', 'ube' ),
		] );

		$this->add_control(
			'progress_style',
			[
				'label'     => esc_html__( 'Style', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '01',
				'options'   => [
					'01' => esc_html__( 'Style 01', 'ube' ),
					'02' => esc_html__( 'Style 02', 'ube' ),
					'03' => esc_html__( 'Style 03', 'ube' ),
					'04' => esc_html__( 'Style 04', 'ube' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'progress_text_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'  => 'flex-start',
					'center' => 'center',
					'right' => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .progress-bar' => 'justify-content: {{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'progress_style',
							'operator' => 'in',
							'value'    => [
								'02',
								'04'
							]
						]
					]
				],
			]
		);

		$this->add_control(
			'progress_type',
			[
				'label'   => esc_html__( 'Type', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''                     => esc_html__( 'Default', 'ube' ),
					'progress-bar-striped' => esc_html__( 'Striped', 'ube' ),
				],
			]
		);

		$this->add_control(
			'progress_mode_animated',
			[
				'label'        => esc_html__( 'Use Mode Animated', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'progress_type' => 'progress-bar-striped'
				],
			]
		);

		$this->add_control(
			'progress_bg_color_scheme',
			[
				'label'   => esc_html__( 'Color', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);

		$this->add_control(
			'progress_display_value',
			[
				'label'        => esc_html__( 'Display Value', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'progress_label',
			[
				'label'       => esc_html__( 'Label', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
				'placeholder' => esc_html__( 'UI/UX', 'ube' ),
				'default'     => esc_html__( 'UI/UX', 'ube' ),
			]
		);


		$repeater->add_control(
			'progress_multiple_bar_value',
			[
				'label' => esc_html__( 'Value', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 100,
				'step'  => 5,
			]
		);

		$repeater->add_control( 'progressbar_speed',
			[
				'label' => esc_html__( 'Speed (milliseconds)', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
			]
		);


		$repeater->add_control(
			'progress_lable_switcher',
			[
				'label'        => esc_html__( 'Custom Color', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  => esc_html__( 'Please enable if you want to customize color', 'ube' ),
				'separator'    => 'before',
			]
		);


		$repeater->add_control(
			'progress_value_item_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-progress-value' => 'color: {{VALUE}} !important'
				],
				'condition' => [
					'progress_lable_switcher' => 'yes'
				],
			]
		);

		$repeater->add_control(
			'progress_value_item__bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-progress-value' => 'background-color: {{VALUE}} !important'
				],
				'condition' => [
					'progress_lable_switcher' => 'yes'
				],
			]
		);

		$repeater->add_control(
			'progress_fill_item_bg_color',
			[
				'label'     => esc_html__( 'Fill Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}} !important'
				],
				'condition' => [
					'progress_lable_switcher' => 'yes'
				],
			]
		);

		$repeater->add_control(
			'value_arrow_item_color',
			[
				'label'     => esc_html__( 'Arrows Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-progress-value:after' => 'border-top-color: {{VALUE}};border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'progress_lable_switcher' => 'yes'
				],
			]
		);


		$this->add_control( 'progress_bar_multiple',
			[
				'label'   => esc_html__( 'Label', 'ube' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'progress_lable_color'        => '#6ec1e4',
						'progress_multiple_bar_value' => 70,
						'progress_label'              => esc_html__( 'WordPress', 'ube' ),
						'progressbar_speed'           => '1000',
					],
					[
						'progress_label'              => esc_html__( 'Joomla', 'ube' ),
						'progress_multiple_bar_value' => 80,
						'progress_lable_color'        => '#28a745',
						'progressbar_speed'           => '1500',
					],
					[
						'progress_multiple_bar_value' => 90,
						'progress_label'              => esc_html__( 'Photoshop', 'ube' ),
						'progress_lable_color'        => '#17a2b8',
						'progressbar_speed'           => '2000',
					]
				],
				'fields'  => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
	}

	private function register_section_progess() {
		$this->start_controls_section(
			'section_progress_progress-style',
			[
				'label' => esc_html__( 'Progress', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'progress_align_content',
			[
				'label'        => esc_html__( 'Alignment', 'ube' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
				'condition' => [
					'progress_style!' => '02'
				],
			]
		);

		$this->add_responsive_control(
			'progress_bar_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-progress-content + .ube-progress-content' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'progress_bar_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .progress' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'progress_bar_height',
			[
				'label'     => esc_html__( 'Height', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .progress' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'progress_bar_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .progress' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	private function register_section_fill() {

		$this->start_controls_section(
			'progress_fill_progress-style',
			[
				'label' => esc_html__( 'Fill', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'progres_fill_padding',
			[
				'name'       => 'progressbar_single_items_padding',
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .progress-bar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'progress_style',
							'operator' => 'in',
							'value'    => [
								'02',
								'04'
							]
						]
					]
				],
			]
		);

		$this->add_control(
			'fill_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .progress .progress-bar' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'progress_bar_indicator',
			[
				'label'        => esc_html__( 'Progress Indicator', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
				'selectors'    => [
					'{{WRAPPER}} .progress-bar::after' => 'content:"";',
				],
			]
		);


		$this->add_control(
			'indicatordimention',
			[
				'label'      => esc_html__( 'Indicator Size', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors'  => [
					'{{WRAPPER}} .progress-bar::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'progress_bar_indicator' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'indicatorbackground',
				'label'     => esc_html__( 'Indicator Background', 'ube' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .progress-bar::after',
				'condition' => [
					'progress_bar_indicator' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'progressbar_indicator_border',
				'label'     => esc_html__( 'Border', 'ube' ),
				'selector'  => '{{WRAPPER}} .progress-bar::after',
				'condition' => [
					'progress_bar_indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'progressbar_indicator_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .progress-bar::after' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'condition' => [
					'progress_bar_indicator' => 'yes',
				],
			]
		);

		$this->add_control(
			'lable_heading',
			[
				'label'     => esc_html__( 'Label', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'progress_label_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-progress-style-01 .ube-progress-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-progress-style-02 .ube-progress-label' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-progress-style-04 .ube-progress-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-progress-style-03 .ube-progress-label' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'progress_label_typography',
				'selector' => '{{WRAPPER}} .ube-progress-label',
			]
		);

		$this->add_control(
			'progress_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-progress-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'value_heading',
			[
				'label'     => esc_html__( 'Value', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->add_control(
			'value_arrow_switcher',
			[
				'label'        => esc_html__( 'Value Arrows', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'selectors'    => [
					'{{WRAPPER}} .ube-progress-value::after' => 'content:"";',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'progress_style',
							'operator' => 'in',
							'value'    => [
								'01',
								'03'
							]
						],
						[
							'name'     => 'progress_display_value',
							'operator' => 'in',
							'value'    => [
								'yes',
							]
						]
					]
				],
			]
		);

		$this->add_control(
			'value_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-progress-style-01 .ube-progress-value:after' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .ube-progress-style-03 .ube-progress-value:after' => 'border-bottom-color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'value_arrow_switcher',
							'operator' => '=',
							'value'    => 'yes'
						],
						[
							'name'     => 'progress_display_value',
							'operator' => '==',
							'value'    => 'yes'
						]
					]
				],
			]
		);

		$this->add_responsive_control(
			'value_arrow_size',
			[
				'label'      => esc_html__( 'Size', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-progress-value:after' => 'border-left-width: {{SIZE}}{{UNIT}};border-right-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-progress-style-01 .ube-progress-value:after' => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ube-progress-style-03 .ube-progress-value:after' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'separator'    => 'after',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'value_arrow_switcher',
							'operator' => '=',
							'value'    => 'yes'
						],
						[
							'name'     => 'progress_display_value',
							'operator' => '==',
							'value'    => 'yes'
						]
					]
				],
			]
		);

		$this->add_responsive_control(
			'progress_bar_value_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-progress-style-01 .ube-progress-value' => 'top: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-progress-style-03 .ube-progress-value' => 'bottom: -{{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'progress_style',
							'operator' => 'in',
							'value'    => [
								'01',
								'03'
							]
						],
						[
							'name'     => 'progress_display_value',
							'operator' => 'in',
							'value'    => [
								'yes',
							]
						]
					]
				],
			]
		);

		$this->add_responsive_control(
			'progress_value_size',
			[
				'label'     => esc_html__( 'Icon Size', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => '',
				],
				'range'     => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-progress-value' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->add_control(
			'progress_value_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-progress-value' => 'color: {{VALUE}};',
				],
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->add_control(
			'progress_background_value_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-progress-value' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'progress_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-progress-value' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'progress_value_padding',
			[
				'name'       => 'progressbar_single_items_padding',
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-progress-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'progress_value_margin',
			[
				'name'       => 'progressbar_single_items_margin',
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-progress-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'progress_display_value' => 'yes'
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		ube_get_template( 'elements/progress.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/progress.php' );
	}
}