<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Search_Box extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-search-box';
	}

	public function get_title() {
		return esc_html__( 'Search Box', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-search';
	}

	public function get_ube_keywords() {
		return array( 'search', 'search box', 'ube', 'ube search box' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-search-box' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'search_content_section', [
			'label' => esc_html__( 'Search', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'search_style',
			[
				'label'   => esc_html__( 'Style', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'01' => esc_html__( 'Style 01', 'ube' ),
					'02' => esc_html__( 'Style 02', 'ube' ),
					'03' => esc_html__( 'Style 03', 'ube' ),
				],
				'default' => '01',
			]
		);

		$this->add_control( 'search-placeholder', [
			'label'   => esc_html__( 'Placeholder Text', 'ube' ),
			'type'    => Controls_Manager::TEXT,
			'default' => esc_html__( 'Search...', 'ube' ),
			'dynamic' => [
				'active' => true,
			],
		] );

		$this->add_control(
			'search_box_height',
			[
				'label'      => esc_html__( 'Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 400,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box .value-search' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-search-box-submit'        => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_btn_type',
			[
				'label'   => esc_html__( 'Button Type', 'ube' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'text' => [
						'title' => esc_html__( 'Text', 'ube' ),
						'icon'  => 'fa fa-font',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'ube' ),
						'icon'  => 'fa fa-info',
					]
				],
				'default' => 'icon',
			]
		);

		$this->add_control( 'search_btn_text', [
			'label'     => esc_html__( 'Search Button Text', 'ube' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => esc_html__( 'Search', 'ube' ),
			'separator' => 'before',
			'condition' => [
				'search_btn_type' => 'text',
			]
		] );

		$this->add_control(
			'search_button_icon',
			[
				'label'     => esc_html__( 'Icon', 'ube' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-search',
					'library' => 'solid',
				],
				'condition' => [
					'search_btn_type' => 'icon',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'search_ajax_content_section', [
			'label' => esc_html__( 'Ajax Search', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'search_enable_ajax',
			[
				'label'        => esc_html__( 'Enable Search Ajax', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'search_ajax_enable_date',
			[
				'label'        => esc_html__( 'Enable Result Date', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition'    => [
					'search_enable_ajax' => 'yes',
				]
			]
		);

		$this->add_control(
			'search_posts_per_page',
			[
				'label'     => esc_html__( 'Amount Of Search Result', 'ube' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'step'      => 1,
				'min'       => 1,
				'max'       => 15,
				'default'   => 6,
				'condition' => [
					'search_enable_ajax' => 'yes',
				]
			]
		);

		$this->add_control(
			'search_order_by',
			[
				'label'     => esc_html__( 'Order by', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'ID'     => esc_html__( 'ID', 'ube' ),
					'author' => esc_html__( 'Author', 'ube' ),
					'title'  => esc_html__( 'Title', 'ube' ),
					'name'   => esc_html__( 'Name', 'ube' ),
					'date'   => esc_html__( 'Date', 'ube' ),
				],
				'default'   => 'date',
				'condition' => [
					'search_enable_ajax' => 'yes',
				]

			]
		);

		$this->add_control(
			'search_order',
			[
				'label'     => esc_html__( 'Order', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'DESC' => esc_html__( 'DESC', 'ube' ),
					'ASC'  => esc_html__( 'ASC', 'ube' ),
				],
				'default'   => 'DESC',
				'condition' => [
					'search_enable_ajax' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'wrapper_style_section', [
			'label'     => esc_html__( 'Wrapper', 'ube' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'search_style' => '03',
			],
		] );

		$this->add_responsive_control(
			'double_button_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
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
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'display: -webkit-box; display: -ms-flexbox ; display: flex; -webkit-box-pack:{{VALUE}};-ms-flex-pack:{{VALUE}};justify-content:{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'input_style_section', [
			'label' => esc_html__( 'Input', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			'search_input_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box .value-search' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'search_input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box .value-search::placeholder'           => 'color: {{VALUE}};',
					'{{WRAPPER}} .ube-search-box .value-search:-ms-input-placeholder'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .ube-search-box .value-search::-ms-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'search_input_typography',
				'selector' => '{{WRAPPER}} .ube-search-box .value-search',
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'search_input_background',
			'selector' => '{{WRAPPER}} .ube-search-box .value-search',
		] );

		$this->add_responsive_control(
			'search_input_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-layout-01 .value-search' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-search-box-layout-02'               => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'search_style!' => '03',
				],
			]
		);

		$this->add_control(
			'search_input_align',
			[
				'label'                => esc_html__( 'Align', 'ube' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'center',
				'options'              => [
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
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'selectors'            => [
					'{{WRAPPER}} .ube-search-box-layout-02' => '{{VALUE}}',
				],
				'label_block'          => false,
				'condition'            => [
					'search_style' => '02',
				],
			]
		);

		$this->add_responsive_control(
			'search_input_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box .value-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'search_input_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box .value-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'      => 'search_input_border',
				'selector'  => '{{WRAPPER}} .ube-search-box .value-search',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box .value-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section( 'submit_style_section', [
			'label' => esc_html__( 'Submit Button', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'search_submit_tab_normal_typography',
				'selector' => '{{WRAPPER}} .ube-search-box-submit',
			]
		);

		$this->start_controls_tabs( 'search_submit_tab' );

		$this->start_controls_tab(
			'search_submit_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'search_submit_tab_normal_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box-submit' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'search_submit_tab_normal_background',
			'selector' => '{{WRAPPER}} .ube-search-box-submit',
		] );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'search_submit_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'search_submit_tab_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'search_submit_tab_hover_background',
			'selector' => '{{WRAPPER}} .ube-search-box-submit:hover',
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'search_submit_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'search_submit_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_submit_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-submit' => 'width  : {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'search_style' => '01',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'      => 'search_submit_border',
				'selector'  => '{{WRAPPER}} .ube-search-box-submit',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_submit_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'popup_btn_style_section', [
			'label'     => esc_html__( 'Popup Button', 'ube' ),
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [
				'search_style' => '03',
			],
		] );

		$this->add_responsive_control(
			'search_popup_align',
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
			]
		);

		$this->add_control(
			'search_popup_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box-show-modal' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'search_popup_typography',
				'selector' => '{{WRAPPER}} .ube-search-box-show-modal',
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'search_popup_background',
			'selector' => '{{WRAPPER}} .ube-search-box-show-modal',
		] );

		$this->add_responsive_control(
			'search_popup_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-show-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'search_popup_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-show-modal' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'search_result_ajax',
			[
				'label'     => esc_html__( 'Result Ajax', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'search_enable_ajax' => 'yes',
				],
			]
		);

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'search_result_background',
			'selector' => '{{WRAPPER}} .ube-search-box-ajax-result',
		] );

		$this->add_responsive_control(
			'search_result_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-ajax-result' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'search_result_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-ajax-result' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_control(
			'search_result_image',
			[
				'label'     => esc_html__( 'Image', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'search_result_image_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-result-thumbnail' => 'width  : {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'search_result_image_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-search-box-result-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_result_label_title',
			[
				'label'     => esc_html__( 'Title', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_result_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box .ube-search-box-result-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'search_result_title_typography',
				'selector' => '{{WRAPPER}} .ube-search-box .ube-search-box-result-title',
			]
		);

		$this->add_control(
			'search_result_label_date',
			[
				'label'     => esc_html__( 'Date', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'search_ajax_enable_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_result_date_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-search-box .ube-search-box-result-meta' => 'color: {{VALUE}};',
				],
				'condition' => [
					'search_ajax_enable_date' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'search_result_date_typography',
				'selector'  => '{{WRAPPER}} .ube-search-box .ube-search-box-result-meta',
				'condition' => [
					'search_ajax_enable_date' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		ube_get_template( 'elements/search-box.php', array(
			'element' => $this
		) );
	}
}