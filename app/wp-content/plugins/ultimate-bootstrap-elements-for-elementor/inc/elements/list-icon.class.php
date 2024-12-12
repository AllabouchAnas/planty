<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use Elementor\Repeater;

class UBE_Element_List_Icon extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-list-icon';
	}

	public function get_title() {
		return esc_html__( 'List Icon', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-editor-list-ol';
	}

	public function get_ube_keywords() {
		return array( 'list icon', 'ube' , 'ube list icon' );
	}

	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_list_style();
	}

	private function register_section_content() {

		$this->start_controls_section(
			'list_content_settings',
			[
				'label' => esc_html__( 'Content Settings', 'ube' )
			]
		);


		$this->add_control(
			'list_icon_layout',
			[
				'label' => esc_html__( 'Layout', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'list-column',
				'options' => [
					'list-column' => [
						'title' => esc_html__( 'Column', 'ube' ),
						'icon' => 'eicon-editor-list-ul',
					],
					'list-inline' => [
						'title' => esc_html__( 'Inline', 'ube' ),
						'icon' => 'eicon-ellipsis-h',
					],
				],
			]
		);

		$this->add_control(
			'list_icon_view',
			[
				'label'          => esc_html__( 'Style', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'list-icon-icon',
				'options'        => [
					'list-icon-icon' => esc_html__( 'List Icon', 'ube' ),
					'list-type-icon' => esc_html__( 'List Style', 'ube' ),
				],
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'list_icon_type_icon',
			[
				'label'            => esc_html__( 'Icon', 'ube' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
				'condition'        => [
					'list_icon_view' => 'list-icon-icon',
				],
			]
		);

		$this->add_control(
			'list_icon_type',
			[
				'label'          => esc_html__( 'Type', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'circle',
				'options'        => [
					'square' => esc_html__( 'List Square', 'ube' ),
					'circle' => esc_html__( 'List Circle', 'ube' ),
					'roman'  => esc_html__( 'List Roman', 'ube' ),
					'alpha'  => esc_html__( 'List Alpha', 'ube' ),
					'number' => esc_html__( 'List Number', 'ube' ),
					''            => esc_html__( 'None', 'ube' ),
				],
				'style_transfer' => true,
				'condition'      => [
					'list_icon_view' => 'list-type-icon',
				],
			]
		);

		$this->add_control(
			'list_icon_number',
			[
				'label'      => esc_html__( 'Start auto number', 'ube' ),
				'type'       => Controls_Manager::NUMBER,
				'min'        => 1,
				'max'        => 100,
				'step'       => 1,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'list_icon_type',
							'operator' => 'in',
							'value'    => [
								'roman',
								'alpha',
								'number'
							]
						]
					]
				]
			]
		);

		$this->add_control(
			'list_icon_scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);

		$this->add_control(
			'list_icon_size',
			[
				'label'     => esc_html__( 'Size', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'sm',
				'options'   => [
					'xs' => esc_html__( 'Extra Small', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'md' => esc_html__( 'Medium', 'ube' ),
					'lg' => esc_html__( 'Large', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
			]

		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_icon_title',
			[
				'label'       => esc_html__( 'Text', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'List Item', 'ube' ),
				'default'     => esc_html__( 'List Item', 'ube' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);


		$repeater->add_control(
			'list_icon_link',
			[
				'label'       => esc_html__( 'Link', 'ube' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
			]
		);

		$repeater->add_control(
			'list_icon_selected_icon',
			[
				'label'            => esc_html__( 'Icon', 'ube' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
			]
		);

		$this->add_control(
			'list_icon_repeater',
			[
				'label'   => '',
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'list_icon_title'         => esc_html__( 'List Item #1', 'ube' ),
						'list_icon_selected_icon' => [
							'value'   => '',
							'library' => '',
						],
					],
					[
						'list_icon_title'         => esc_html__( 'List Item #2', 'ube' ),
						'list_icon_selected_icon' => [
							'value'   => '',
							'library' => '',
						],
					],
					[
						'list_icon_title'         => esc_html__( 'List Item #3', 'ube' ),
						'list_icon_selected_icon' => [
							'value'   => '',
							'library' => '',
						],
					],
				],
				'title_field' => '{{{ list_icon_title }}}',
			]
		);
		$this->end_controls_section();
	}

	private function register_section_list_style() {

		$this->start_controls_section(
			'list_icon_style',
			[
				'label' => esc_html__( 'List', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control( 'list_icon_space_between',
			[
				'label'      => esc_html__( 'Space Between', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px','em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em'  => [
						'min' => 1,
						'step' => 0.1,
						'max' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .list-inline .list-inline-item:not(:first-child)'  => 'margin-left: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .list-inline .list-inline-item:not(:last-child)'  => 'margin-right: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .list-inline .list-inline-item:after'            => 'left: calc({{SIZE}}{{UNIT}}/2);',

					'{{WRAPPER}} .list-unstyled .list-icon-item:not(:first-child)'       => 'margin-top: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .list-unstyled .list-icon-item:not(:last-child)'       => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2);',
				],
			]
		);

		$this->add_responsive_control(
			'list_icon_align',
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
				'selectors_dictionary' => [
					'left' => 'flex-start',
					'center' => 'center',
					'right' => 'end',
				],
				'selectors' => [
					'{{WRAPPER}} .list-icon-item' => 'justify-content: {{VALUE}}',
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->start_controls_tabs('tabs_icon_list' );

		$this->start_controls_tab(
			'tab_icon_list_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'list_icon_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography:: get_type(),
			[
				'name'     => 'list_icon_title_typography',
				'selector' => '{{WRAPPER}} li',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_list_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'list_icon_title_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography:: get_type(),
			[
				'name'     => 'list_icon_title_typography_hover',
				'selector' => '{{WRAPPER}} li:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'heading_list_icon',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('tabs_icon_list_icon' );

		$this->start_controls_tab(
			'tab_icon_list__iconnormal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);

		$this->add_control(
			'list_icon_color_icon',
			[
				'label'     => esc_html__( 'Icon Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-list-icon-icon' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} li:before' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_list_icon_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'list_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} li:hover .ube-list-icon-icon' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} li:hover:before' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'list_icon_icon_size',
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
					'{{WRAPPER}} .ube-list-icon li i'      => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-list-icon li svg'      => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} li:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-list-icon-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} li:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'list_icon_divider',
			[
				'label'     => esc_html__( 'Divider', 'ube' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Off', 'ube' ),
				'label_on'  => esc_html__( 'On', 'ube' ),
				'selectors' => [
					'{{WRAPPER}} .ube-list-icon li:after' => 'content: "";',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'list_icon_divider_style',
			[
				'label'     => esc_html__( 'Style', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'solid'  => esc_html__( 'Solid', 'ube' ),
					'double' => esc_html__( 'Double', 'ube' ),
					'dotted' => esc_html__( 'Dotted', 'ube' ),
					'dashed' => esc_html__( 'Dashed', 'ube' ),
				],
				'default'   => 'solid',
				'condition' => [
					'list_icon_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .list-inline .list-inline-item:not(:last-child):after' => 'border-left-style: {{VALUE}};',
					'{{WRAPPER}} .list-unstyled .list-icon-item:not(:last-child):after' => 'border-bottom-style: {{VALUE}};display: block;',
				],
			]
		);


		$this->add_responsive_control(
			'list_icon_divider_weight',
			[
				'label'     => esc_html__( 'Weight', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'list_icon_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-list-icon li:after' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'list_icon_width',
			[
				'label'     => esc_html__( 'Width', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => '%',
				],
				'condition' => [
					'list_icon_divider' => 'yes',
					'list_icon_layout!' => 'list-inline',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-list-icon li:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_icon_divider_height',
			[
				'label'      => esc_html__( 'Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default'    => [
					'unit' => '%',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition'  => [
					'list_icon_divider' => 'yes',
					'list_icon_layout'  => 'list-inline',
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-list-icon li:after' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'list_icon_divider_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-list-icon li:after' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'list_icon_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		ube_get_template( 'elements/list-icon.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/list-icon.php' );
	}

}