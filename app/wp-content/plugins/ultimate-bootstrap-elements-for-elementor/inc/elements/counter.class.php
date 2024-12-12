<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class UBE_Element_Counter extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-counter';
	}

	public function get_ube_keywords() {
		return array( 'counter', 'ube', 'ube counter' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-counter' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_number_style();
		$this->section_title_style();
		$this->section_icon_style();
		$this->section_icon_title_style();
	}

	public function section_content() {
		$this->start_controls_section(
			'counter_content',
			[
				'label' => esc_html__( 'Counter', 'ube' ),
			]
		);
		$this->add_control(
			'starting_number',
			[
				'label'   => esc_html__( 'Starting Number', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'ending_number',
			[
				'label'   => esc_html__( 'Ending Number', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 100,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'duration',
			[
				'label'   => esc_html__( 'Animation Duration', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'step'    => 1,
			]
		);

		$this->add_control(
			'thousand_separator_char',
			[
				'label'   => esc_html__( 'Thousand Separator', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''  => esc_html__( 'Default', 'ube' ),
					'.' => esc_html__( 'Dot', 'ube' ),
					',' => esc_html__( 'Comma', 'ube' ),
					' ' => esc_html__( 'Space', 'ube' ),
				],
			]
		);

		$this->add_control(
			'ending_decimals',
			[
				'label'   => esc_html__( 'Ending Decimals', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'step'    => 1,
			]
		);

		$this->add_control(
			'data_decimal',
			[
				'label'       => esc_html__( 'Decimal', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( ',', 'ube' ),
				'default'     => ',',
			]
		);

		$this->add_control(
			'counter_number_prefix',
			[
				'label'       => esc_html__( 'Number Prefix', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Example: $', 'ube' ),
			]
		);

		$this->add_control(
			'counter_number_suffix',
			[
				'label'       => esc_html__( 'Number Suffix', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Example: +', 'ube' ),
			]
		);
		$this->add_control(
			'counter_number_position',
			[
				'label'   => esc_html__( 'Number Position', 'ube' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => ' eicon-v-align-bottom',
					],
					'top'    => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],

				],
				'default' => 'top',
			]
		);

		$this->add_control(
			'counter_icon_type',
			[
				'label'       => esc_html__( 'Media Type', 'ube' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'separator'   => 'before',
				'options'     => [
					'none'  => [
						'title' => esc_html__( 'None', 'ube' ),
						'icon'  => 'fa fa-ban',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'ube' ),
						'icon'  => 'fa fa-picture-o',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'ube' ),
						'icon'  => 'fa fa-info-circle',
					],
				],
				'default'     => 'none',
			]
		);

		$this->add_control(
			'counter_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'counter_icon_type' => 'icon',
				],
			]
		);
		$this->add_control(
			'counter_icon_view',
			[
				'label'     => esc_html__( 'View', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'counter_icon_type' => 'icon',
				],
				'options'   => [
					''        => esc_html__( 'Default', 'ube' ),
					'stacked' => esc_html__( 'Stacked', 'ube' ),
					'framed'  => esc_html__( 'Framed', 'ube' ),
				],
			]
		);
		$this->add_control(
			'counter_icon_shape',
			[
				'label'     => esc_html__( 'View', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'condition' => [
					'counter_icon_view!' => '',
					'counter_icon_type'  => 'icon',
				],
				'default'   => 'circle',
				'options'   => [
					'square' => esc_html__( 'Square', 'ube' ),
					'circle' => esc_html__( 'Circle', 'ube' ),
				],
			]
		);

		$this->add_control(
			'counter_image',
			[
				'label'     => esc_html__( 'Image', 'ube' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'counter_icon_type' => 'image',
				],
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'counter_icon_position',
			[
				'label'     => esc_html__( 'Media Position', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],

				],
				'default'   => 'top',
				'condition' => [
					'counter_icon_type!' => 'none',
				]
			]
		);

		$this->add_responsive_control(
			'counter_media_vertical_alignment',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'top',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center'     => [
						'title' => esc_html__( 'Middle', 'ube' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'counter_icon_type!' => 'none'
				],
				'selectors' => [
					'{{WRAPPER}} .ube-counter-media-left .card'  => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .ube-counter-media-right .card' => 'align-items: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'counter_media_horizontal_alignment',
			[
				'label'     => esc_html__( 'Horizontal Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-counter .card'      => 'align-items: {{VALUE}};',
					'{{WRAPPER}} .ube-counter .card-body' => 'align-items: {{VALUE}};',
				],
				'condition' => [
					'counter_icon_type' => 'none'
				],
			]
		);


		$this->add_control(
			'counter_title',
			[
				'label'       => esc_html__( 'Counter Title', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Happy Clients', 'ube' ),
				'placeholder' => esc_html__( 'Type your title here', 'ube' ),
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'counter_scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);


		$this->end_controls_section();

	}


	public function section_title_style() {
		// Style Title tab section
		$this->start_controls_section(
			'counter_title_style_section',
			[
				'label'     => esc_html__( 'Title', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'counter_title!' => '',
				]
			]
		);
		$this->add_control(
			'counter_title_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-counter .card-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_title_typography',
				'selector' => '{{WRAPPER}} .ube-counter .card-text',
			]
		);

		$this->add_control( 'counter_title_class', [
			'label'   => esc_html__( 'Custom Class', 'ube' ),
			'type'    => Controls_Manager::TEXT,
			'default' => ''
		] );

		$this->end_controls_section();
	}

	public function section_number_style() {
		// Style Number tab section
		$this->start_controls_section(
			'counter_number_style_section',
			[
				'label' => esc_html__( 'Number', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'counter_number_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-counter .card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_number_typography',
				'selector' => '{{WRAPPER}} .ube-counter .ube-counter-number,{{WRAPPER}} .ube-counter .ube-counter-icon-prefix,{{WRAPPER}} .ube-counter .ube-counter-icon-suffix',
			]
		);

		$this->add_responsive_control(
			'counter_number_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-counter-number-top .card-title'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-counter-number-bottom .card-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control( 'counter_number_class', [
			'label'   => esc_html__( 'Custom Class', 'ube' ),
			'type'    => Controls_Manager::TEXT,
			'default' => ''
		] );

		$this->end_controls_section();

	}

	public function section_icon_style() {
		// Style Icon tab section
		$this->start_controls_section(
			'counter_icon_style_section',
			[
				'label'     => esc_html__( 'Media', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'counter_icon_type!' => 'none'
				]
			]
		);
		$this->add_control(
			'counter_icon_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'counter_icon!'     => '',
					'counter_icon_type' => 'icon'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'      => 'counter_icon_background',
				'label'     => esc_html__( 'Background', 'ube' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .ube-counter .ube-counter-icon',
				'condition' => [
					'counter_icon!'      => '',
					'counter_icon_type'  => 'icon',
					'counter_icon_view!' => ''
				]
			]
		);
		$this->add_control(
			'counter_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'counter_icon!'     => '',
					'counter_icon_type' => 'icon',
					'counter_icon_view' => 'framed'
				]
			]
		);
		$this->add_responsive_control(
			'counter_image_size',
			[
				'label'      => esc_html__( 'Max Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-counter .card-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'counter_icon!'     => '',
					'counter_icon_type' => 'image'
				]
			]
		);

		$this->add_responsive_control(
			'counter_icon_size',
			[
				'label'      => esc_html__( 'Size', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'counter_icon!'     => '',
					'counter_icon_type' => 'icon'
				]
			]
		);

		$this->add_responsive_control(
			'counter_icon_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-counter-media-left .card-image'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-counter-media-top .card-image'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-counter-media-right .card-image' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'counter_icon_type!' => 'none'
				]
			]
		);

		$this->add_responsive_control(
			'counter_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => [
					'counter_icon!'     => '',
					'counter_icon_type' => 'icon'
				]
			]
		);
		$this->add_responsive_control(
			'counter_icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'counter_icon!'     => '',
					'counter_icon_type' => 'icon'
				]
			]
		);
		$this->end_controls_section();
	}

	public function section_icon_title_style() {
		$this->start_controls_section(
			'counter_title_icon_style_section',
			[
				'label'      => esc_html__( 'Suffix and Prefix', 'ube' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'counter_number_suffix',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'counter_number_prefix',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);
		$this->add_control(
			'counter_prefix_style',
			[
				'label'     => esc_html__( 'Prefix', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'counter_number_prefix!' => '',
				],
			]
		);
		$this->add_control(
			'counter_prefix_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon-prefix' => 'color: {{VALUE}};',
				],
				'condition' => [
					'counter_number_prefix!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'counter_prefix_typography',
				'selector'  => '{{WRAPPER}} .ube-counter .ube-counter-icon-prefix',
				'condition' => [
					'counter_number_prefix!' => '',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'counter_suffix_style',
			[
				'label'     => esc_html__( 'Suffix', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'counter_number_suffix!' => '',
				],
			]
		);
		$this->add_control(
			'counter_suffix_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-counter .ube-counter-icon-suffix' => 'color: {{VALUE}};',
				],
				'condition' => [
					'counter_number_suffix!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'counter_suffix_typography',
				'selector'  => '{{WRAPPER}} .ube-counter .ube-counter-icon-suffix',
				'condition' => [
					'counter_number_suffix!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		ube_get_template( 'elements/counter.php', array(
			'element' => $this
		) );

	}
}