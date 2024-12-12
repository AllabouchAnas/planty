<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

class UBE_Element_Image_Comparison extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-comparison';
	}

	public function get_title() {
		return esc_html__( 'Image Comparison', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-image-before-after';
	}

	public function get_ube_keywords() {
		return array( 'image', 'comparison', 'image comparison', 'ube', 'ube image comparison' );
	}

	public function get_style_depends() {
		return array( 'twentytwenty' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-image-comparison' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_style();
		$this->section_title_style();
		$this->section_handler_style();
	}

	public function section_content() {
		$this->start_controls_section(
			'image_comparison_content',
			[
				'label' => esc_html__( 'Image Comparison', 'ube' ),
			]
		);

		$this->add_control(
			'before_image',
			[
				'label'   => esc_html__( 'Before Image', 'ube' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'before_image_size',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'after_image',
			[
				'label'   => esc_html__( 'After Image', 'ube' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'after_image_size',
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'image_comparison_direction',
			[
				'label'   => esc_html__( 'Direction', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'ube' ),
					'vertical'   => esc_html__( 'Vertical', 'ube' ),
				],
			]
		);

		$this->end_controls_section();

		// Addition Option
		$this->start_controls_section(
			'image_comparison_addition',
			[
				'label' => esc_html__( 'Additional Setting', 'ube' ),
			]
		);


		$this->add_control(
			'start_amount',
			[
				'label'   => esc_html__( 'Before Start Amount', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 1,
				'step'    => 0.1,
				'default' => 0.5,
			]
		);


		$this->add_control(
			'hover_effect',
			[
				'label'        => esc_html__( 'Hover Animation', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'before_title',
			[
				'label'       => esc_html__( 'Before Label', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Before', 'ube' ),
				'condition'   => [
					'hover_effect' => 'yes',
				],
			]
		);

		$this->add_control(
			'after_title',
			[
				'label'       => esc_html__( 'After Label', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'After', 'ube' ),
				'condition'   => [
					'hover_effect' => 'yes',
				],
			]
		);

		$this->add_control(
			'image_comparison_label_pos',
			[
				'label'      => esc_html__( 'Label Position', 'ube' ),
				'type'       => \Elementor\Controls_Manager::CHOOSE,
				'options'    => [
					'top'    => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'toggle'     => false,
				'default'    => 'center',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'terms' => [
								[
									'name'     => 'image_comparison_direction',
									'operator' => '==',
									'value'    => 'horizontal'
								],
							]
						],
						[
							'terms' => [
								[
									'name'     => 'hover_effect',
									'operator' => '==',
									'value'    => 'yes'
								],
							]
						]
					]
				]
			]
		);
		$this->add_control(
			'image_comparison_label_pos_ver',
			[
				'label'      => esc_html__( 'Label Position', 'ube' ),
				'type'       => \Elementor\Controls_Manager::CHOOSE,
				'options'    => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'     => false,
				'default'    => 'left',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'terms' => [
								[
									'name'     => 'image_comparison_direction',
									'operator' => '==',
									'value'    => 'vertical'
								],
							]
						],
						[
							'terms' => [
								[
									'name'     => 'hover_effect',
									'operator' => '==',
									'value'    => 'yes'
								],
							]
						]
					]
				]
			]
		);
		$this->add_control(
			'show_title_on_hover',
			[
				'label'        => esc_html__( 'Only Show Label On Hover', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'hover_effect' => 'yes',
				],
			]
		);
		$this->add_control(
			'image_comparison_handler_move',
			[
				'label'   => esc_html__( 'Action Move', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'handle',
				'options' => [
					'hover'  => esc_html__( 'Hover', 'ube' ),
					'handle' => esc_html__( 'Handle Only', 'ube' ),
					'click'  => esc_html__( 'Click', 'ube' ),
				],
			]
		);

		$this->end_controls_section();

	}

	public function section_wrapper_style() {
		$this->start_controls_section(
			'wrapper_style_section',
			[
				'label' => esc_html__( 'Wrapper', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'wrapper_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-image-comparison',
			]
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-image-comparison' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'background_overlay_color',
			[
				'label'     => esc_html__( 'Overlay Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .twentytwenty-overlay:hover' => 'background: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
	}

	public function section_title_style() {

		$this->start_controls_section(
			'label_style_section',
			[
				'label'      => esc_html__( 'Label', 'ube' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);
		$this->add_control(
			'title_color',
			[
				'label'      => esc_html__( 'Color', 'ube' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .twentytwenty-before-label::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-after-label::before'  => 'color: {{VALUE}};',
				],
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'       => 'title_typography',
				'label'      => esc_html__( 'Typography', 'ube' ),
				'selector'   => '{{WRAPPER}} .twentytwenty-before-label::before,{{WRAPPER}} .twentytwenty-after-label::before',
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);
		$this->add_control(
			'title_gap',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-before-label::before' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-after-label::before'  => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-before-label::before'   => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-after-label::before'    => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'       => 'title_border',
				'label'      => esc_html__( 'Border', 'ube' ),
				'selector'   => '{{WRAPPER}} .twentytwenty-before-label::before,{{WRAPPER}} .twentytwenty-after-label::before',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);

		$this->add_responsive_control(
			'title_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .twentytwenty-before-label::before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .twentytwenty-after-label::before'  => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator'  => 'after',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'       => 'title_background',
				'label'      => esc_html__( 'Background', 'ube' ),
				'types'      => [ 'classic', 'gradient' ],
				'selector'   => '{{WRAPPER}} .twentytwenty-before-label::before,{{WRAPPER}} .twentytwenty-after-label::before',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .twentytwenty-before-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-after-label::before'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'after_title',
							'operator' => '!=',
							'value'    => ''
						],
						[
							'name'     => 'before_title',
							'operator' => '!=',
							'value'    => ''
						]
					]
				]
			]
		);


		$this->add_control(
			'label_before_style',
			[
				'label'     => esc_html__( 'Before Label', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'after_title!' => '',
				],
			]
		);


		$this->add_control(
			'before_title_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-image-comparison .twentytwenty-before-label::before' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'after_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'before_title_typography',
				'label'     => esc_html__( 'Typography', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-image-comparison .twentytwenty-before-label::before',
				'separator' => 'before',
				'condition' => [
					'after_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'before_title_border',
				'label'     => esc_html__( 'Border', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-image-comparison .twentytwenty-before-label::before',
				'condition' => [
					'after_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'before_title_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-image-comparison .twentytwenty-before-label::before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator' => 'after',
				'condition' => [
					'after_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'before_background',
				'label'     => esc_html__( 'Background', 'ube' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .ube-image-comparison .twentytwenty-before-label::before',
				'condition' => [
					'after_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'before_title_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-image-comparison .twentytwenty-before-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
				'condition'  => [
					'after_title!' => '',
				],
			]
		);

		$this->add_control(
			'label_after_style',
			[
				'label'     => esc_html__( 'After Label', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'before_title!' => '',
				],
			]
		);

		$this->add_control(
			'after_title_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-image-comparison .twentytwenty-after-label::before' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'before_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'after_title_typography',
				'label'     => esc_html__( 'Typography', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-image-comparison .twentytwenty-after-label::before',
				'separator' => 'before',
				'condition' => [
					'before_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'after_title_border',
				'label'     => esc_html__( 'Border', 'ube' ),
				'selector'  => '{{WRAPPER}} .ube-image-comparison .twentytwenty-after-label::before',
				'condition' => [
					'before_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'after_title_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-image-comparison .twentytwenty-after-label::before' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator' => 'after',
				'condition' => [
					'before_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'after_background',
				'label'     => esc_html__( 'Background', 'ube' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .ube-image-comparison .twentytwenty-after-label::before',
				'condition' => [
					'before_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'after_title_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-image-comparison .twentytwenty-after-label::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'before_title!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	public function section_handler_style() {

		// Style handler tab section
		$this->start_controls_section(
			'handler_style_section',
			[
				'label' => esc_html__( 'Handler', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'separator_style',
			[
				'label' => esc_html__( 'Separator Style', 'ube' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			]
		);
		$this->add_control(
			'separator_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .twentytwenty-handle::before' => 'background: {{VALUE}};box-shadow:0 3px 0 {{VALUE}}, 0px 0px 12px rgb(51 51 51 / 50%);-webkit-box-shadow:0 3px 0 {{VALUE}}, 0px 0px 12px rgb(51 51 51 / 50%);',
					'{{WRAPPER}} .twentytwenty-handle::after'  => 'background: {{VALUE}};box-shadow:0 3px 0 {{VALUE}}, 0px 0px 12px rgb(51 51 51 / 50%);-webkit-box-shadow:0 3px 0 {{VALUE}}, 0px 0px 12px rgb(51 51 51 / 50%);',
				],
			]
		);

		$this->add_control(
			'handler_style',
			[
				'label'     => esc_html__( 'Handle Style', 'ube' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'handler_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .twentytwenty-handle .twentytwenty-left-arrow'  => 'border-right-color: {{VALUE}};',
					'{{WRAPPER}} .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'handler_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .twentytwenty-handle' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'handler_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .twentytwenty-handle' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'handler_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .twentytwenty-handle',
			]
		);

		$this->end_controls_section();
	}


	protected function render() {

		ube_get_template( 'elements/image-comparison.php', array(
			'element' => $this
		) );

	}

}