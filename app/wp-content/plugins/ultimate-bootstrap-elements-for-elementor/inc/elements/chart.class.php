<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

class UBE_Element_Chart extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-chart';
	}

	public function get_title() {
		return esc_html__( 'Chart', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-skill-bar';
	}

	public function get_ube_keywords() {
		return array( 'chart' , 'ube' , 'ube chart' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-chart' );
	}

	protected function register_controls() {
		$this->section_data();
		$this->section_chart_setting();
		$this->section_chart_style();
		$this->section_common_style();
		$this->section_point_style();
		$this->section_content_style();
		$this->section_animation();
	}

	public function section_data() {
		$this->start_controls_section(
			'chart_data_section', [
				'label' => esc_html__( 'Chart ', 'ube' ),
			]
		);
		// chart style
		$this->add_control(
			'chart_style',
			[
				'label'   => esc_html__( 'Chart Styles', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bar',
				'options' => [
					'bar'           => esc_html__( 'Bar (Vertical)', 'ube' ),
					'horizontalBar' => esc_html__( 'Bar (Horizontal)', 'ube' ),
					'line'          => esc_html__( 'Line', 'ube' ),
					'radar'         => esc_html__( 'Radar', 'ube' ),
					'doughnut'      => esc_html__( 'Doughnut', 'ube' ),
					'pie'           => esc_html__( 'Pie', 'ube' ),
					'polarArea'     => esc_html__( 'Polar Area', 'ube' ),
				],

			]
		);

		// start repeter for lavel

		$chartRepeterCate = new Repeater();
		$chartRepeterCate->add_control(
			'chart_label', [
				'label'       => esc_html__( 'Name', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'January', 'ube' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'charts_labels_data',
			[
				'label'       => esc_html__( 'Categories', 'ube' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => [
					[ 'chart_label' => esc_html__( 'January', 'ube' ) ],
					[ 'chart_label' => esc_html__( 'February', 'ube' ) ],
					[ 'chart_label' => esc_html__( 'March', 'ube' ) ],

				],
				'fields'      => $chartRepeterCate->get_controls(),
				'title_field' => '{{{ chart_label }}}',
				'condition'   => [ 'chart_style' => [ 'bar', 'horizontalBar', 'line', 'radar' ] ],
			]
		);

		// repeter 1
		$chartRepeter = new Repeater();
		$chartRepeter->add_control(
			'chart_data_label', [
				'label'       => esc_html__( 'Legend', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Legend #1', 'ube' ),
				'label_block' => true,
			]
		);
		$chartRepeter->add_control(
			'chart_data_set', [
				'label'       => esc_html__( 'Data', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'Enter data values by "," separated(1). Example: 2,4,8,16,32 etc', 'ube' ),
			]
		);


		// start tabs section
		$chartRepeter->start_controls_tabs(
			'chart_data_bar_back_tab'
		);
		// start normal sections
		$chartRepeter->start_controls_tab(
			'chart_data_bar_back_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$chartRepeter->add_control(
			'chart_data_bar_back_color', [
				'label'       => esc_html__( 'Background Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(242,41,91,0.48)',
				'label_block' => true,
			]
		);

		$chartRepeter->add_control(
			'chart_data_bar_border_color', [
				'label'       => esc_html__( 'Border Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(242,41,91,0.48)',
				'label_block' => true,
			]
		);

		$chartRepeter->end_controls_tab();
		// end normal sections
		// start hover sections
		$chartRepeter->start_controls_tab(
			'chart_data_bar_back_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$chartRepeter->add_control(
			'chart_data_bar_back_color_hover', [
				'label'       => esc_html__( 'Background Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
			]
		);

		$chartRepeter->add_control(
			'chart_data_bar_border_color_hover', [
				'label'       => esc_html__( 'Border Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
			]
		);
		$chartRepeter->end_controls_tab();
		// end hover sections
		$chartRepeter->end_controls_tabs();
		// end tabs section

		$chartRepeter->add_control(
			'chart_fill',
			[
				'label'        => esc_html__( 'Fill', 'ube' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$chartRepeter->add_control(
			'chart_data_bar_border_width', [
				'label'       => esc_html__( 'Border Width', 'ube' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '1',
				'label_block' => true,
			]
		);

		$this->add_control(
			'charts_data_set',
			[
				'label'   => esc_html__( 'Chart Data', 'ube' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'chart_data_label'            => esc_html__( 'Label #1', 'ube' ),
						'chart_data_set'              => '13,20,15',
						'chart_data_bar_back_color'   => 'rgba(242,41,91,0.48)',
						'chart_data_bar_border_color' => 'rgba(242,41,91,0.48)',
						'chart_data_bar_border_width' => 1
					],
					[
						'chart_data_label'            => esc_html__( 'Label #2', 'ube' ),
						'chart_data_set'              => '20,10,33',
						'chart_data_bar_back_color'   => 'rgba(69,53,244,0.48)',
						'chart_data_bar_border_color' => 'rgba(69,53,244,0.48)',
						'chart_data_bar_border_width' => 1
					],
					[
						'chart_data_label'            => esc_html__( 'Label #3', 'ube' ),
						'chart_data_set'              => '10,3,23',
						'chart_data_bar_back_color'   => 'rgba(239,239,40,0.57)',
						'chart_data_bar_border_color' => 'rgba(239,239,40,0.57)',
						'chart_data_bar_border_width' => 1
					],

				],

				'fields'      => $chartRepeter->get_controls(),
				'title_field' => '{{{ chart_data_label }}}',
				'condition'   => [ 'chart_style' => [ 'bar', 'horizontalBar', 'line', 'radar' ] ],
			]
		);


		// repeter 2
		$chartRepeter2 = new Repeater();
		$chartRepeter2->add_control(
			'chart_data_label', [
				'label'       => esc_html__( 'Label', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Label #1', 'ube' ),
				'label_block' => true,
			]
		);

		$chartRepeter2->add_control(
			'chart_data_set2', [
				'label'       => esc_html__( 'Data', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '10',
				'label_block' => true,

			]
		);

		// start tabs section
		$chartRepeter2->start_controls_tabs(
			'chart_data_bar_back_tab'
		);
		// start normal sections
		$chartRepeter2->start_controls_tab(
			'chart_data_bar_back_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$chartRepeter2->add_control(
			'chart_data_bar_back_color', [
				'label'       => esc_html__( 'Background Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(242,41,91,0.48)',
				'label_block' => true,
			]
		);

		$chartRepeter2->add_control(
			'chart_data_bar_border_color', [
				'label'       => esc_html__( 'Border Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => 'rgba(242,41,91,0.48)',
				'label_block' => true,
			]
		);

		$chartRepeter2->end_controls_tab();
		// end normal sections
		// start hover sections
		$chartRepeter2->start_controls_tab(
			'chart_data_bar_back_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$chartRepeter2->add_control(
			'chart_data_bar_back_color_hover', [
				'label'       => esc_html__( 'Background Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
			]
		);

		$chartRepeter2->add_control(
			'chart_data_bar_border_color_hover', [
				'label'       => esc_html__( 'Border Color', 'ube' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => true,
			]
		);
		$chartRepeter2->end_controls_tab();
		// end hover sections
		$chartRepeter2->end_controls_tabs();
		// end tabs section

		$chartRepeter2->add_control(
			'chart_data_bar_border_width', [
				'label'       => esc_html__( 'Border Width', 'ube' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => '1',
				'label_block' => true,
			]
		);

		$this->add_control(
			'charts_data_set2',
			[
				'label'   => esc_html__( 'Chart Data', 'ube' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'chart_data_label'            => esc_html__( 'Label #1', 'ube' ),
						'chart_data_set2'             => '13',
						'chart_data_bar_back_color'   => 'rgba(242,41,91,0.48)',
						'chart_data_bar_border_color' => 'rgba(242,41,91,0.48)',
						'chart_data_bar_border_width' => 1
					],
					[
						'chart_data_label'            => esc_html__( 'Label #2', 'ube' ),
						'chart_data_set2'             => '20',
						'chart_data_bar_back_color'   => 'rgba(69,53,244,0.48)',
						'chart_data_bar_border_color' => 'rgba(69,53,244,0.48)',
						'chart_data_bar_border_width' => 1
					],
					[
						'chart_data_label'            => esc_html__( 'Label #3', 'ube' ),
						'chart_data_set2'             => '10',
						'chart_data_bar_back_color'   => 'rgba(239,239,40,0.57)',
						'chart_data_bar_border_color' => 'rgba(239,239,40,0.57)',
						'chart_data_bar_border_width' => 1
					],

				],

				'fields'      => $chartRepeter->get_controls(),
				'title_field' => '{{{ chart_data_label }}}',
				'condition'   => [ 'chart_style' => [ 'doughnut', 'pie', 'polarArea' ] ],
			]
		);


		$this->end_controls_section();

	}

	public function section_chart_setting() {
		$this->start_controls_section(
			'chart_settings', [
				'label' => esc_html__( 'Settings ', 'ube' ),
			]
		);
		$this->add_control(
			'chart_cutout_percent',
			[
				'label'      => esc_html__( 'Cutout Percent', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition'  => [ 'chart_style' => [ 'doughnut' ] ],
			]
		);


		// gridline options
		$this->add_control(
			'charts_grid_lines',
			[
				'label'     => esc_html__( 'Grid Lines', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'chart_style!' => [ 'doughnut', 'pie', 'polarArea', 'radar' ] ],
			]
		);
		$this->add_control(
			'chart_grid_draw_border',
			[
				'label'     => esc_html__( 'Draw Border', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'chart_style!'       => [ 'doughnut', 'pie', 'polarArea', 'radar' ],
					'charts_grid_lines!' => 'yes'
				],

			]
		);
		$this->add_control(
			'charts_grid_color',
			[
				'label'      => esc_html__( 'Grid Color', 'ube' ),
				'type'       => Controls_Manager::COLOR,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'chart_style',
							'operator' => '!in',
							'value'    => [ 'doughnut', 'pie', 'polarArea' ]
						],
						[
							'relation' => 'or',
							'terms'    => [
								[
									'name'     => 'charts_grid_lines',
									'operator' => '==',
									'value'    => 'yes'
								],
								[
									'name'     => 'chart_grid_draw_border',
									'operator' => '==',
									'value'    => 'yes'
								]
							]
						]
					]
				]
			]
		);

		// lavel options
		$this->add_control(
			'charts_show_label',
			[
				'label'     => esc_html__( 'Enable Label', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
				'condition' => [ 'chart_style!' => [ 'doughnut', 'pie', 'polarArea', 'radar' ] ],
			]
		);

		// legend options
		$this->add_control(
			'charts_show_legend',
			[
				'label'   => esc_html__( 'Enable Legends', 'ube' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		// tooltips options
		$this->add_control(
			'charts_show_tooltips',
			[
				'label'     => esc_html__( 'Show Tooltip', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	public function section_chart_style() {
		//Title Style Section

		$this->start_controls_section(
			'chart_section_style_chart', [
				'label' => esc_html__( 'Chart', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'chart_height',
			[
				'label'      => esc_html__( 'Height', 'ube' ),
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

			]
		);

		// line chart
		$this->add_control(
			'chart_section_style_line_chart_stepped',
			[
				'label'     => esc_html__( 'Stepped Line', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
				'condition' => [ 'chart_style' => 'line' ]
			]
		);
		$this->add_control(
			'chart_section_style_line_chart_tension',
			[
				'label'     => esc_html__( 'Tension', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.1,
				'condition' => [ 'chart_style' => 'line', 'chart_section_style_line_chart_stepped!' => 'yes' ]
			]
		);

		$this->add_control(
			'chart_section_style_pie_chart_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'condition' => [ 'chart_style' => 'pie' ]
			]
		);
		$this->end_controls_section();
	}

	public function section_common_style() {
		//Title Grid Section

		// start legend style
		$this->start_controls_section(
			'chart_section_style_legend', [
				'label'     => esc_html__( 'Legend', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'charts_show_legend' => 'yes' ]
			]
		);
		$this->add_control(
			'charts_legend_font_color',
			[
				'label' => esc_html__( 'Font Color', 'ube' ),
				'type'  => Controls_Manager::COLOR,

			]
		);
		$this->add_control(
			'charts_legend_font_size',
			[
				'label' => esc_html__( 'Font Size', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,


			]
		);
		$this->add_control(
			'charts_legend_font_style',
			[
				'label'   => esc_html__( 'Font Weight', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__( 'Choose Font Style', 'ube' ),
					'normal' => esc_html__( 'Normal', 'ube' ),
					'bold'   => esc_html__( 'Bold', 'ube' ),
				],

			]
		);
		$this->add_control(
			'charts_legend_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 300,
				'step'  => 1,

			]
		);

		$this->add_control(
			'charts_legend_point_style',
			[
				'label'        => esc_html__( 'Point Style', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'charts_legend_box_width',
			[
				'label'     => esc_html__( 'Box Width', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 300,
				'step'      => 1,
				'condition' => [ 'charts_legend_point_style!' => 'yes' ]

			]
		);
		$this->add_control(
			'charts_legend_align',
			[
				'label'   => esc_html__( 'Position', 'ube' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'fa fa-long-arrow-left',
					],
					'top'    => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon'  => 'fa fa-long-arrow-up',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon'  => 'fa fa-long-arrow-down',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'fa fa-long-arrow-right',
					],
				],

			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'chart_section_style_grid', [
				'label'      => esc_html__( 'Grid', 'ube' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'chart_style',
							'operator' => '!in',
							'value'    => [ 'doughnut', 'pie', 'polarArea', 'radar' ]
						],
						[
							'name'     => 'charts_grid_lines',
							'operator' => '==',
							'value'    => 'yes'
						]
					]
				]
			]
		);


		$this->add_control(
			'chart_grid_line_width',
			[
				'label' => esc_html__( 'Line Width', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
			]
		);
		$this->add_control(
			'chart_grid_draw_tick',
			[
				'label'   => esc_html__( 'Draw Tick', 'ube' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);
		$this->add_control(
			'chart_grid_tick_mark_length',
			[
				'label'     => esc_html__( 'Tick Mark Length', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'condition' => [ 'chart_grid_draw_tick' => 'yes' ],
			]
		);
		$this->end_controls_section();
	}


	public function section_point_style() {
		//Title Style Section

		$this->start_controls_section(
			'chart_section_style_point', [
				'label'     => esc_html__( 'Point', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'chart_style' => [ 'line', 'radar' ] ],
			]
		);
		$this->add_control(
			'chart_section_style_chart_point_style',
			[
				'label'     => esc_html__( 'Point Style', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''            => esc_html__( 'Choose Point Style', 'ube' ),
					'circle'      => esc_html__( 'Circle', 'ube' ),
					'cross'       => esc_html__( 'Cross', 'ube' ),
					'crossRot'    => esc_html__( 'Cross Rot', 'ube' ),
					'star'        => esc_html__( 'Star', 'ube' ),
					'triangle'    => esc_html__( 'Triangle', 'ube' ),
					'line'        => esc_html__( 'Line', 'ube' ),
					'dash'        => esc_html__( 'Dash', 'ube' ),
					'rect'        => esc_html__( 'Rectangle', 'ube' ),
					'rectRounded' => esc_html__( 'Rectangle Rounded', 'ube' ),
					'rectRot'     => esc_html__( 'Rectangle Rot', 'ube' ),
				],
				'condition' => [ 'chart_style' => [ 'line', 'radar', 'bubble' ] ]
			]
		);
		$this->add_control(
			'chart_point_rotation',
			[
				'label' => esc_html__( 'Rotation', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => - 360,
			]
		);
		$this->start_controls_tabs( 'chart_point' );
		$this->start_controls_tab(
			'chart_point_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'chart_point_radius',
			[
				'label' => esc_html__( 'Radius', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'chart_point_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'chart_point_radius_hover',
			[
				'label' => esc_html__( 'Radius', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function section_content_style() {
		//Content Style Section
		$this->start_controls_section(
			'chart_section_style_label', [
				'label'      => esc_html__( 'Labels', 'ube' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'chart_style',
							'operator' => '!in',
							'value'    => [ 'doughnut', 'pie', 'polarArea', 'radar' ]
						],
						[
							'name'     => 'charts_show_label',
							'operator' => '==',
							'value'    => 'yes'
						]
					]
				]
			]
		);
		$this->add_control(
			'charts_label_font_color',
			[
				'label' => esc_html__( 'Font Color', 'ube' ),
				'type'  => Controls_Manager::COLOR,

			]
		);
		$this->add_control(
			'charts_label_font_size',
			[
				'label' => esc_html__( 'Font Size', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,


			]
		);
		$this->add_control(
			'charts_label_font_style',
			[
				'label'   => esc_html__( 'Font Style', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__( 'Choose Font Style', 'ube' ),
					'bold'   => esc_html__( 'Bold', 'ube' ),
					'normal' => esc_html__( 'Normal', 'ube' ),
				],

			]
		);
		$this->add_control(
			'charts_label_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 60,
				'step'  => 1,

			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'chart_section_style_tooltip', [
				'label'     => esc_html__( 'Tooltip', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'charts_show_tooltips' => 'yes' ]
			]
		);
		$this->add_control(
			'charts_tooltips_back_color',
			[
				'label' => esc_html__( 'Background Color', 'ube' ),
				'type'  => Controls_Manager::COLOR,

			]
		);
		// title
		$this->add_control(
			'charts_tooltips_title_font_color',
			[
				'label' => esc_html__( 'Title Font Color', 'ube' ),
				'type'  => Controls_Manager::COLOR,

			]
		);
		$this->add_control(
			'charts_tooltips_title_font_size',
			[
				'label' => esc_html__( 'Title Font Size', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,


			]
		);
		$this->add_control(
			'charts_tooltips_title_font_style',
			[
				'label'   => esc_html__( 'Title Font Style', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__( 'Choose Font Style', 'ube' ),
					'bold'   => esc_html__( 'Bold', 'ube' ),
					'normal' => esc_html__( 'Normal', 'ube' ),
				],

			]
		);
		// bodyFontColor
		$this->add_control(
			'charts_tooltips_body_font_color',
			[
				'label' => esc_html__( 'Body Font Color', 'ube' ),
				'type'  => Controls_Manager::COLOR,

			]
		);
		$this->add_control(
			'charts_tooltips_body_font_size',
			[
				'label' => esc_html__( 'Body Font Size', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,

			]
		);
		$this->add_control(
			'charts_tooltips_body_font_style',
			[
				'label'   => esc_html__( 'Body Font Weight', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__( 'Choose Font Style', 'ube' ),
					'bold'   => esc_html__( 'Bold', 'ube' ),
					'normal' => esc_html__( 'Normal', 'ube' ),
				],

			]
		);

		$this->end_controls_section();


	}

	public function section_animation() {
		//Icon Style Section
		$this->start_controls_section(
			'chart_section_style_animation', [
				'label' => esc_html__( 'Animation', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'chart_section_style_animation_duration',
			[
				'label' => esc_html__( 'Duration', 'ube' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1000,
				'max'   => 10000,
				'step'  => 100,


			]
		);
		$this->add_control(
			'chart_section_style_animation_style',
			[
				'label'       => esc_html__( 'Style', 'ube' ),
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'label_block' => true,
				'options'     => [
					''                 => esc_html__( 'Choose Animation', 'ube' ),
					'linear'           => esc_html__( 'Linear', 'ube' ),
					'easeInQuad'       => esc_html__( 'easeInQuad', 'ube' ),
					'easeOutQuad'      => esc_html__( 'easeOutQuad', 'ube' ),
					'easeInOutQuad'    => esc_html__( 'easeInOutQuad', 'ube' ),
					'easeInCubic'      => esc_html__( 'easeInCubic', 'ube' ),
					'easeOutCubic'     => esc_html__( 'easeOutCubic', 'ube' ),
					'easeInOutCubic'   => esc_html__( 'easeInOutCubic', 'ube' ),
					'easeInQuart'      => esc_html__( 'easeInQuart', 'ube' ),
					'easeOutQuart'     => esc_html__( 'easeOutQuart', 'ube' ),
					'easeInOutQuart'   => esc_html__( 'easeInOutQuart', 'ube' ),
					'easeInQuint'      => esc_html__( 'easeInQuint', 'ube' ),
					'easeOutQuint'     => esc_html__( 'easeOutQuint', 'ube' ),
					'easeInOutQuint'   => esc_html__( 'easeInOutQuint', 'ube' ),
					'easeInSine'       => esc_html__( 'easeInSine', 'ube' ),
					'easeOutSine'      => esc_html__( 'easeOutSine', 'ube' ),
					'easeInOutSine'    => esc_html__( 'easeInOutSine', 'ube' ),
					'easeInExpo'       => esc_html__( 'easeInExpo', 'ube' ),
					'easeOutExpo'      => esc_html__( 'easeOutExpo', 'ube' ),
					'easeInOutExpo'    => esc_html__( 'easeInOutExpo', 'ube' ),
					'easeInCirc'       => esc_html__( 'easeInCirc', 'ube' ),
					'easeOutCirc'      => esc_html__( 'easeOutCirc', 'ube' ),
					'easeInOutCirc'    => esc_html__( 'easeInOutCirc', 'ube' ),
					'easeInElastic'    => esc_html__( 'easeInElastic', 'ube' ),
					'easeOutElastic'   => esc_html__( 'easeOutElastic', 'ube' ),
					'easeInOutElastic' => esc_html__( 'easeInOutElastic', 'ube' ),
					'easeInBack'       => esc_html__( 'easeInBack', 'ube' ),
					'easeOutBack'      => esc_html__( 'easeOutBack', 'ube' ),
					'easeInOutBack'    => esc_html__( 'easeInOutBack', 'ube' ),
					'easeInBounce'     => esc_html__( 'easeInBounce', 'ube' ),
					'easeOutBounce'    => esc_html__( 'easeOutBounce', 'ube' ),
					'easeInOutBounce'  => esc_html__( 'easeInOutBounce', 'ube' ),
				],
			]
		);
		$this->end_controls_section();
		// end animation style
	}

	protected function render() {

		ube_get_template( 'elements/chart.php', array(
			'element' => $this
		) );

	}
}