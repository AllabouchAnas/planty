<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use Elementor\Repeater;

class UBE_Element_Timeline extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-timeline';
	}

	public function get_title() {
		return esc_html__( 'TimeLine', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-time-line';
	}

	public function get_ube_keywords() {
		return array( 'timeline' , 'ube' , 'ube time line' , 'time line' );
	}

	protected function register_controls() {
		$this->start_controls_section( 'timeline_settings_section', [
			'label' => esc_html__( 'Content', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'timeline_style',
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

		$repeater = new Repeater();

		$repeater->add_control(
			'timeline_time',
			[
				'label'   => esc_html__( 'Time', 'ube' ),
				'type'    => Controls_Manager::TEXT,
				'default' => wp_kses_post(__( 'June<br/>2020', 'ube' )),
			]
		);

		$repeater->add_control(
			'timeline_title',
			[
				'label' => esc_html__( 'Title', 'ube' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'timeline_content',
			[
				'label'   => esc_html__( 'Content', 'ube' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ube' ),
			]
		);

		$repeater->add_control(
			'timeline_active',
			[
				'label'        => esc_html__( 'Active', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
			]
		);

		$repeater->add_control(
			'timeline_active_color',
			[
				'label'     => esc_html__( 'Color Item Active', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-timeline-item.item-active'                     => '--color: {{VALUE}};',
					'{{WRAPPER}} .ube-timeline-item.item-active .ube-timeline-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'timeline_active' => 'yes',
				]
			]
		);

		$this->add_control(
			'timeline_content_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'timeline_time'    => wp_kses_post(__( 'April<br/>2020', 'ube' )),
						'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ube' ),
					],
					[
						'timeline_time' => wp_kses_post(__( 'May<br/>2020', 'ube' )),
						'content_text'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ube' ),
					],
					[
						'timeline_time'    => wp_kses_post(__( 'June<br/>2020', 'ube' )),
						'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipis icing elit, sed do eiusmod tempor incid ut labore et dolore magna aliqua Ut enim ad min.', 'ube' ),
					]

				],
				'title_field' => '{{{ timeline_time }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'wrapper_section_style', [
			'label' => esc_html__( 'Wrapper', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control(
			'timeline_size_time_box',
			[
				'label'     => esc_html__( 'Size Time Box', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
					],
				],
				'condition' => [
					'timeline_style!' => '01',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-timeline-item' => '--size-time: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'timeline_title_color_feature',
			[
				'label'     => esc_html__( 'Color Feature', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-timeline-item' => '--color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'title_section_style', [
			'label' => esc_html__( 'Title', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			'timeline_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-timeline-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'timeline_title_typography',
				'selector' => '{{WRAPPER}} .ube-timeline-title',
			]
		);

		$this->add_responsive_control(
			'timeline_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-timeline-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'date_section_style', [
			'label' => esc_html__( 'Time', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			'timeline_time_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-timeline-time > span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'timeline_time_typography',
				'selector' => '{{WRAPPER}} .ube-timeline-time > span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section( 'content_section_style', [
			'label' => esc_html__( 'Content', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control(
			'timeline_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-timeline-content .content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'timeline_content_typography',
				'selector' => '{{WRAPPER}} .ube-timeline-content .content',
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		ube_get_template( 'elements/timeline.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/timeline.php' );
	}
}