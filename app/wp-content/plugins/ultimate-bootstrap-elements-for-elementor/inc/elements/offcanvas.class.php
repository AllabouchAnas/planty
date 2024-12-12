<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;

class UBE_Element_Offcanvas extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-offcanvas';
	}

	public function get_title() {
		return esc_html__( 'Off Canvas', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-menu-bar';
	}

	public function get_ube_keywords() {
		return array( 'off canvas' , 'ube' , 'ube off canvas' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-offcanvas' );
	}

	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_button();
		$this->register_section_content_style();
		$this->register_section_button_style();
	}

	private function ube_sidebar_options() {
		global $wp_registered_sidebars;
		$sidebar_options = array();

		if ( ! $wp_registered_sidebars ) {
			$sidebar_options['0'] = __( 'No sidebars were found', 'ube' );
		} else {
			$sidebar_options['0'] = __( 'Select Sidebar', 'ube' );
			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$sidebar_options[ $sidebar_id ] = $sidebar['name'];
			}
		}

		return $sidebar_options;
	}

	private function ube_elementor_template() {
		$templates = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
		$types     = array();
		if ( empty( $templates ) ) {
			$template_lists = [ '0' => esc_html__( 'Do not saved templates.', 'ube' ) ];
		} else {
			$template_lists = [ '0' => esc_html__( 'Select Template', 'ube' ) ];
			foreach ( $templates as $template ) {
				$template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
			}
		}

		return $template_lists;
	}

	private function register_section_content() {

		$this->start_controls_section( 'offcanvas_settings_section', [
			'label' => esc_html__( 'Content', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_responsive_control(
			'offcanvas_align_content',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-offcanvas' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_source',
			[
				'label'       => esc_html__( 'Select Source', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => 'true',
				'default'     => 'sidebar',
				'options'     => [
					'sidebar'   => esc_html__( 'Sidebar', 'ube' ),
					'elementor' => esc_html__( 'Elementor Template', 'ube' ),
				],
			]
		);

		$this->add_control(
			'template_id',
			[
				'label'       => esc_html__( 'Select Template', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => 'true',
				'default'     => '0',
				'options'     => $this->ube_elementor_template(),
				'condition'   => [
					'content_source' => "elementor"
				],
			]
		);

		$this->add_control(
			'sidebars_id',
			[
				'label'       => esc_html__( 'Select Sidebar', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => $this->ube_sidebar_options(),
				'label_block' => 'true',
				'condition'   => [
					'content_source' => 'sidebar'
				],
			]
		);

		$this->add_control(
			'offcanvas_position',
			[
				'label'       => esc_html__( 'Offcanvas Position', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => 'true',
				'default'     => 'left',
				'options'     => [
					'left'   => esc_html__( 'Left', 'ube' ),
					'right'  => esc_html__( 'Right', 'ube' ),
					'top'    => esc_html__( 'Top', 'ube' ),
					'bottom' => esc_html__( 'Bottom', 'ube' ),
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_section_button() {

		$this->start_controls_section( 'offcanvas_settings_button', [
			'label' => esc_html__( 'Button', 'ube' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'ube' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Offcanvas', 'ube' ),
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'ube' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'button_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => esc_html__( 'Left', 'ube' ),
					'right' => esc_html__( 'Right', 'ube' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				]
			]
		);

		$this->add_control(
			'button_icon_space',
			[
				'label'     => esc_html__( 'Icon Spacing', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 5,
				],
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-offcanvas.align-icon-right .btn-canvas i'   => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-offcanvas.align-icon-right .btn-canvas svg' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-offcanvas.align-icon-left .btn-canvas i'    => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-offcanvas.align-icon-left .btn-canvas svg'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function register_section_content_style() {

		$this->start_controls_section( 'offcanvas_content_style', [
			'label' => esc_html__( 'Content', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'offcanvas_max_width', [
			'label'      => esc_html__( 'Width', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .ube-offcanvas .offcanvas-menu'                                   => 'width: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .ube-offcanvas .offcanvas-menu.align-left-active:not(.show-nav)'  => 'left: -{{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .ube-offcanvas .offcanvas-menu.align-right-active:not(.show-nav)' => 'right: -{{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'offcanvas_max_height', [
			'label'      => esc_html__( 'Height', 'ube' ),
			'type'       => Controls_Manager::SLIDER,
			'default'    => [
				'unit' => 'px',
			],
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'%'  => [
					'min' => 1,
					'max' => 100,
				],
				'px' => [
					'min' => 1,
					'max' => 1600,
				],
			],
			'selectors'  => [
				'{{WRAPPER}} .ube-offcanvas .offcanvas-menu'                                    => 'height: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .ube-offcanvas .offcanvas-menu.align-top-active:not(.show-nav)'    => 'top: -{{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .ube-offcanvas .offcanvas-menu.align-bottom-active:not(.show-nav)' => 'bottom: -{{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control(
			'offcanvas_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offcanvas-menu *' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offcanvas-menu a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'offcanvas_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .offcanvas-menu a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'offcanvas_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .offcanvas-menu',
			]
		);


		$this->add_responsive_control(
			'offcanvas_padding_content',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .offcanvas-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function register_section_button_style() {

		$this->start_controls_section( 'offcanvas_button_style', [
			'label' => esc_html__( 'Button', 'ube' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'offcanvas_button_typography',
				'selector' => '{{WRAPPER}} .btn-canvas',
			]
		);

		$this->add_responsive_control(
			'offcanvas_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .btn-canvas' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'offcanvas_button_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .btn-canvas' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->start_controls_tabs( 'offcanvas_button_style_tabs' );

		// Normal Style
		$this->start_controls_tab(
			'offcanvas_button_style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'offcanvas_button_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-canvas' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'offcanvas_button_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .btn-canvas',
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'offcanvas_button_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .btn-canvas',
			]
		);

		$this->end_controls_tab(); // Button Normal style end

		// Button Hover style
		$this->start_controls_tab(
			'offcanvas_button_style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'offcanvas_button_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .btn-canvas:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'offcanvas_button_hover_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .btn-canvas:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'offcanvas_button_hover_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .btn-canvas:hover',
			]
		);

		$this->end_controls_tab(); // Button Hover end

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public function render() {
		ube_get_template( 'elements/offcanvas.php', array(
			'element' => $this
		) );
	}
}