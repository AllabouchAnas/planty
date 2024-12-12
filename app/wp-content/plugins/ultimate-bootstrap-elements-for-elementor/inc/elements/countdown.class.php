<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

class UBE_Element_Countdown extends UBE_Abstracts_Elements {
	private $_default_countdown_labels;

	public function get_name() {
		return 'ube-countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-countdown';
	}

	public function get_ube_keywords() {
		return array( 'countdown', 'ube', 'ube countdown' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-countdown' );
	}

	protected function register_controls() {
		$this->section_content();
		$this->section_wrapper_style();
		$this->section_content_style();
		$this->item_content_style();
	}

	public function section_content() {
		$this->start_controls_section(
			'section_countdown',
			[
				'label' => esc_html__( 'Countdown', 'ube' ),
			]
		);
		$this->add_control(
			'due_date',
			[
				'label'       => esc_html__( 'Due Date', 'ube' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => gmdate( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				/* translators: %s: Time zone. */
				'description' => sprintf( esc_html__( 'Date set according to your timezone: %s.', 'ube' ), Utils::get_timezone_string() ),
			]
		);

		$this->add_control(
			'label_display',
			[
				'label'   => esc_html__( 'View', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'block'  => esc_html__( 'Block', 'ube' ),
					'inline' => esc_html__( 'Inline', 'ube' ),
				],
				'default' => 'block',
			]
		);
		$this->add_control(
			'enable_background',
			[
				'label'     => esc_html__( 'Enable Background', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => '',
			]
		);
		$this->add_control(
			'countdown_scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
				'condition' => [
					'enable_background' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_separate',
			[
				'label'     => esc_html__( 'Show separate', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_days',
			[
				'label'     => esc_html__( 'Days', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label'     => esc_html__( 'Hours', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[
				'label'     => esc_html__( 'Minutes', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_seconds',
			[
				'label'     => esc_html__( 'Seconds', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'     => esc_html__( 'Show Label', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'show_separate_digits',
			[
				'label'     => esc_html__( 'Show Timer Separate', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'ube' ),
				'label_off' => esc_html__( 'Hide', 'ube' ),
				'default'   => 'no',
				'condition' => [
					'label_display' => 'block',
				],
			]
		);

		$this->add_control(
			'custom_labels',
			[
				'label'     => esc_html__( 'Custom Label', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'label_days',
			[
				'label'       => esc_html__( 'Days', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Days', 'ube' ),
				'placeholder' => esc_html__( 'Days', 'ube' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				],
			]
		);

		$this->add_control(
			'label_hours',
			[
				'label'       => esc_html__( 'Hours', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Hours', 'ube' ),
				'placeholder' => esc_html__( 'Hours', 'ube' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_hours'     => 'yes',
				],
			]
		);

		$this->add_control(
			'label_minutes',
			[
				'label'       => esc_html__( 'Minutes', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Minutes', 'ube' ),
				'placeholder' => esc_html__( 'Minutes', 'ube' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_minutes'   => 'yes',
				],
			]
		);

		$this->add_control(
			'label_seconds',
			[
				'label'       => esc_html__( 'Seconds', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Seconds', 'ube' ),
				'placeholder' => esc_html__( 'Seconds', 'ube' ),
				'condition'   => [
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_seconds'   => 'yes',
				],
			]
		);

		$this->add_control(
			'expire_actions',
			[
				'label'       => esc_html__( 'Actions After Expire', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					''         => esc_html__( 'None', 'ube' ),
					'redirect' => esc_html__( 'Redirect', 'ube' ),
					'hide'     => esc_html__( 'Hide', 'ube' ),
					'message'  => esc_html__( 'Show Message', 'ube' ),
					'loop'     => esc_html__( 'Loop', 'ube' ),
				],
				'label_block' => true,
				'separator'   => 'before',
				'render_type' => 'none',
			]
		);

		$this->add_control(
			'message_after_expire',
			[
				'label'       => esc_html__( 'Message', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'separator'   => 'before',
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'expire_actions' => 'message',
				],
			]
		);

		$this->add_control(
			'expire_redirect_url',
			[
				'label'         => esc_html__( 'Redirect URL', 'ube' ),
				'type'          => Controls_Manager::URL,
				'label_block'   => true,
				'separator'     => 'before',
				'show_external' => false,
				'dynamic'       => [
					'active' => true,
				],
				'condition'     => [
					'expire_actions' => 'redirect',
				],
			]
		);
		$this->add_control(
			'loop_hours',
			[
				'label'       => esc_html__( 'Hours', 'ube' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 47,
				'placeholder' => esc_html__( 'Hours', 'ube' ),
				'condition'   => [
					'expire_actions' => 'loop',
				],
			]
		);

		$this->add_control(
			'loop_minutes',
			[
				'label'       => esc_html__( 'Minutes', 'ube' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 59,
				'placeholder' => esc_html__( 'Minutes', 'ube' ),
				'condition'   => [
					'expire_actions' => 'loop',
				],
			]
		);

		$this->end_controls_section();
	}

	public function section_wrapper_style() {
		$this->start_controls_section(
			'section_box_style',
			[
				'label' => esc_html__( 'Boxes', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'container_horizontal_alignment',
			[
				'label'     => esc_html__( 'Horizontal Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} .ube-countdown'  => 'justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'container_align',
			[
				'label' => __( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ube' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ube' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ube' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card-body' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'label_display' => 'block',
				],
			]
		);
		$this->add_responsive_control(
			'container_vertical_align',
			[
				'label' => esc_html__( 'Vertical Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'ube' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => true,
				'condition' => [
					'label_display' => 'inline'
				],
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card-body' => 'align-items: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_width',
			[
				'label'      => esc_html__( 'Item Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-countdown .card' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'enable_background' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'box_height',
			[
				'label'      => esc_html__( 'Item Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-countdown .card' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'enable_background' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card' => 'background-color: {{VALUE}}!important;',
				],
				'condition' => [
					'enable_background' => 'yes',
				],
			]
		);

		$this->add_control(
			'box_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card-body'              => 'color: {{VALUE}}!important;',
					'{{WRAPPER}} .ube-countdown .ube-countdown-separate' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'counter_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-countdown .card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'box_border',
				'selector'  => '{{WRAPPER}} .ube-countdown .card',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-countdown .card'                   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-countdown-label-block .card-title' => 'border-top-left-radius: {{TOP}}{{UNIT}};border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .ube-countdown-label-block .card-text'  => 'border-bottom-left-radius: {{LEFT}}{{UNIT}};border-bottom-right-radius: {{BOTTOM}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'box_spacing',
			[
				'label'     => esc_html__( 'Space Between', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-countdown-item' => 'padding-left: calc( {{SIZE}}{{UNIT}}/2 );padding-right: calc( {{SIZE}}{{UNIT}}/2 ); margin-bottom:{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .ube-countdown' => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2 );margin-right: calc(-{{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-countdown .card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	public function section_content_style() {
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_digits',
			[
				'label' => esc_html__( 'Digits', 'ube' ),
				'type'  => Controls_Manager::HEADING,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'digits_typography',
				'selector' => '{{WRAPPER}} .ube-countdown .card-title',
			]
		);
		$this->add_control(
			'digits_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'digits_spacing',
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
					'{{WRAPPER}} .ube-countdown-label-block .card-title'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-countdown-label-inline .card-title' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'digits_separate_color',
			[
				'label'     => esc_html__( 'Separate Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card-title::after' => 'background-color: {{VALUE}};background-image:none;width: 50%;',
				],
				'condition' => [
					'show_separate_digits' => 'yes',
					'label_display'        => 'block',
				],
			]
		);
		$this->add_responsive_control(
			'digits_separate_width',
			[
				'label'      => esc_html__( 'Separate Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-countdown .card-title::after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_separate_digits' => 'yes',
					'label_display'        => 'block',
				],
			]
		);

		$this->add_control(
			'heading_label',
			[
				'label'     => esc_html__( 'Label', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .ube-countdown .card-text',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .card-text' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();
	}

	public function item_content_style() {
		$this->start_controls_section(
			'section_item_style',
			[
				'label' => esc_html__( 'Item style', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'days_style',
			[
				'label'     => esc_html__( 'Days', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_days' => 'yes',
				],
			]
		);
		$this->add_control(
			'days_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-days' => 'background-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_days' => 'yes',
					'enable_background' => 'yes'
				],
			]
		);

		$this->add_control(
			'days_color',
			[
				'label'     => esc_html__( 'Digits Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-days .card-title' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_days' => 'yes',
				],
			]
		);
		$this->add_control(
			'days_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-days .card-text' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_days' => 'yes',
				],
			]
		);
		$this->add_control(
			'days_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-days' => 'border-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_days' => 'yes',
				],
			]
		);

		$this->add_control(
			'hours_style',
			[
				'label'     => esc_html__( 'Hours', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_hours' => 'yes',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'hours_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-hours' => 'background-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_hours' => 'yes',
					'enable_background' => 'yes'
				],
			]
		);

		$this->add_control(
			'hours_color',
			[
				'label'     => esc_html__( 'Digits Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-hours .card-title' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_hours' => 'yes',
				],
			]
		);
		$this->add_control(
			'hours_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-hours .card-text' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_hours' => 'yes',
				],
			]
		);
		$this->add_control(
			'hours_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-hours' => 'border-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_hours' => 'yes',
				],
			]
		);


		$this->add_control(
			'minutes_style',
			[
				'label'     => esc_html__( 'Minutes', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_minutes' => 'yes',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'minutes_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-minutes' => 'background-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_minutes' => 'yes',
					'enable_background' => 'yes'
				],
			]
		);

		$this->add_control(
			'minutes_color',
			[
				'label'     => esc_html__( 'Digits Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-minutes .card-title' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_minutes' => 'yes',
				],
			]
		);
		$this->add_control(
			'minutes_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-minutes .card-text' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_minutes' => 'yes',
				],
			]
		);

		$this->add_control(
			'minutes_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-minutes' => 'border-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_minutes' => 'yes',
				],
			]
		);
		$this->add_control(
			'seconds_style',
			[
				'label'     => esc_html__( 'Seconds', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_seconds' => 'yes',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'seconds_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-seconds' => 'background-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_seconds' => 'yes',
					'enable_background' => 'yes'
				],
			]
		);

		$this->add_control(
			'seconds_color',
			[
				'label'     => esc_html__( 'Digit Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-seconds .card-title' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_seconds' => 'yes',
				],
			]
		);
		$this->add_control(
			'seconds_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-seconds .card-text' => 'color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_seconds' => 'yes',
				],
			]
		);
		$this->add_control(
			'seconds_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-card-seconds' => 'border-color: {{VALUE}}!important;',
				],
				'condition' => [
					'show_seconds' => 'yes',
				],
			]
		);
		$this->add_control(
			'separate_style',
			[
				'label'     => esc_html__( 'Separate', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_separate' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'separate_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-countdown .ube-countdown-separate' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_separate' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'separate_typography',
				'selector'  => '{{WRAPPER}} .ube-countdown .ube-countdown-separate',
				'condition' => [
					'show_separate' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_style',
			[
				'label'     => esc_html__( 'Message', 'ube' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'expire_actions' => 'message',
				],
				'separator' => 'before',

			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'       => esc_html__( 'Alignment', 'ube' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
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
				'selectors'   => [
					'{{WRAPPER}} .ube-countdown-expire-message' => 'text-align: {{VALUE}};',
				],
				'condition'   => [
					'expire_actions' => 'message',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-countdown-expire-message' => 'color: {{VALUE}};',
				],
				'condition' => [
					'expire_actions' => 'message',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'typography',
				'selector'  => '{{WRAPPER}} .ube-countdown-expire-message',
				'condition' => [
					'expire_actions' => 'message',
				],
			]
		);

		$this->add_responsive_control(
			'message_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-countdown-expire-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'expire_actions' => 'message',
				],
			]
		);

		$this->end_controls_section();

	}

	public function get_strftime( $settings, $scheme ) {
		$string = '';
		if ( $settings['show_days'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_days', 'days', $scheme );
			if ( $settings['show_separate'] == 'yes' && ( $settings['show_hours'] || $settings['show_minutes'] || $settings['show_seconds'] ) ) {
				$string .= '<div class="ube-countdown-separate">&#8282;</div>';
			}
		}
		if ( $settings['show_hours'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_hours', 'hours', $scheme );
			if ( $settings['show_separate'] == 'yes' && ($settings['show_minutes']||$settings['show_seconds']) ) {
				$string .= '<div class="ube-countdown-separate">&#8282;</div>';
			}
		}
		if ( $settings['show_minutes'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_minutes', 'minutes', $scheme );
			if ( $settings['show_separate'] == 'yes' && $settings['show_seconds'] ) {
				$string .= '<div class="ube-countdown-separate">&#8282;</div>';
			}
		}
		if ( $settings['show_seconds'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_seconds', 'seconds', $scheme );
		}

		return $string;
	}

	private function init_default_countdown_labels() {
		$this->_default_countdown_labels = [
			'label_months'  => esc_html__( 'Months', 'ube' ),
			'label_weeks'   => esc_html__( 'Weeks', 'ube' ),
			'label_days'    => esc_html__( 'Days', 'ube' ),
			'label_hours'   => esc_html__( 'Hours', 'ube' ),
			'label_minutes' => esc_html__( 'Minutes', 'ube' ),
			'label_seconds' => esc_html__( 'Seconds', 'ube' ),
		];
	}

	public function get_default_countdown_labels() {
		if ( ! $this->_default_countdown_labels ) {
			$this->init_default_countdown_labels();
		}

		return $this->_default_countdown_labels;
	}

	public function render_countdown_item( $settings, $label, $part_class, $scheme ) {
		$string = '<div class="ube-countdown-item"><div class="card ube-card-' . esc_attr( $part_class ) . ' ' . esc_attr( $scheme ) . '"><div class="card-body"><p class="card-title ube-countdown-' . esc_attr( $part_class ) . '"></p>';
		if ( $settings['show_labels'] ) {
			$default_labels = $this->get_default_countdown_labels();
			$label          = ( $settings['custom_labels'] ) ? $settings[ $label ] : $default_labels[ $label ];
			$string         .= ' <p class="card-text">' . esc_html( $label ) . '</p>';
		}

		$string .= '</div></div></div>';

		return $string;
	}

	public function get_evergreen_interval( $hours_setting, $minutes_setting ) {
		$hours              = empty( $hours_setting ) ? 0 : ( $hours_setting * HOUR_IN_SECONDS );
		$minutes            = empty( $minutes_setting ) ? 0 : ( $minutes_setting * MINUTE_IN_SECONDS );
		$evergreen_interval = $hours + $minutes;

		return $evergreen_interval;
	}

	public function get_actions( $settings ) {
		if ( empty( $settings['expire_actions'] ) ) {
			return false;
		}

		$action        = $settings['expire_actions'];
		$action_to_run = array( 'type' => $action );
		if ( 'redirect' === $action ) {
			if ( ! empty( $settings['expire_redirect_url']['url'] ) ) {
				$action_to_run['redirect_url'] = $settings['expire_redirect_url']['url'];
			}
		}

		return $action_to_run;
	}

	protected function render() {

		ube_get_template( 'elements/countdown.php', array(
			'element' => $this
		) );

	}
}