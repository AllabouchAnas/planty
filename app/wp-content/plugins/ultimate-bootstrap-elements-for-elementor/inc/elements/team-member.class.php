<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use Elementor\Utils;

class UBE_Element_Team_MemBer extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-team-member';
	}

	public function get_title() {
		return esc_html__( 'Team Member', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-person';
	}

	public function get_ube_keywords() {
		return array( 'team','member','ube' , 'team member', 'ube team member');
	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_style_section_controls();

	}

	private function register_content_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content','ube')
			]
		);

		$this->add_control(
			'team_member_style',
			[
				'label'   => esc_html__( 'Layout', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-01',
				'options' => ube_get_team_member_style(),
			]
		);


		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'ube' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image_size',
				'default'   => 'full',
				'separator' => 'none',
				'condition' => [
					'image[url]!' => '',
				]
			]
		);

		$this->add_control(
			'team_member_name',
			[
				'label'       => esc_html__( 'Name', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => esc_html__('John Doe', 'ube'),
			]
		);

		$this->add_control(
			'team_member_job_title',
			[
				'label'       => esc_html__( 'Position', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default' => esc_html__('Designer', 'ube'),
			]
		);

		$this->add_control(
			'team_member_link',
			[
				'label'       => esc_html__( 'Link', 'ube' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
			]
		);

		$this->add_control(
			'team_member_description',
			[
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ube'),
				'rows'        => 10,
				'condition'   => [
					'team_member_style!' => 'style-03',
				],
			]
		);


		$this->add_control(
			'social_icon_switcher',
			[
				'label'        => esc_html__( 'Use Social Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$repeater = new Repeater();
		$this->register_social_controls($repeater);
		$this->add_control(
			'team_member_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'social_icon' => [
							'value'   => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value'   => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value'   => 'fab fa-youtube',
							'library' => 'fa-brands',
						],
					],
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
				'condition'   => [
					'social_icon_switcher' => 'yes',
				]
			]
		);
		$this->end_controls_section();
	}

	private function register_social_controls( Repeater $repeater ) {
		$repeater->add_control(
			'social_icon',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$repeater->add_control(
			'social_link',
			[
				'label'       => esc_html__( 'Link', 'ube' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),

			]
		);
	}

	private function register_style_section_controls() {
		$this->register_style_content_section_controls();
		$this->register_style_image_section_controls();
		$this->register_style_name_section_controls();
		$this->register_style_position_section_controls();
		$this->register_style_description_section_controls();
		$this->register_style_social_section_controls();
	}

	private function register_style_content_section_controls() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content','ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'team_member_text_align',
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
				'prefix_class' => 'elementor%s-align-',
				'selectors_dictionary' => [
					'left'  => 'flex-start',
					'right' => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .ube-tm-classic' => 'align-items: {{VALUE}}',
					'{{WRAPPER}} .ube-tm-style-02' => 'justify-content: {{VALUE}}',
					'{{WRAPPER}} .ube-tm-style-03' => 'justify-content: {{VALUE}}',

				],
				'render_type'          => 'template',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-team-member .card-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'team_member_style!' => 'style-03',
				],
			]
		);


		$this->add_control(
			'team_member_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .card-body' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'team_member_content_background',
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .ube-team-member .card-body',
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'content_border',
				'selector'  => '{{WRAPPER}} .ube-team-member .card-body',
				'condition' => [
					'team_member_style!' => 'style-03',
				],
			]
		);
		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-team-member .card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};;',
				],
				'separator'  => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'team_member_image_hover_style',
							'operator' => '=',
							'value'    => 'default'
						],
						[
							'name'     => 'team_member_style',
							'operator' => '!=',
							'value'    => 'style-03'
						]
					]
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-team-member .card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'team_member_image_hover_style',
							'operator' => '=',
							'value'    => 'default'
						],
						[
							'name'     => 'team_member_style',
							'operator' => '!=',
							'value'    => 'style-03'
						]
					]
				],
			]
		);



		$this->end_controls_section();
	}

	private function register_style_image_section_controls() {
		$this->start_controls_section('section_style_image', [
			'label' => esc_html__('Image', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-team-member .ube-tm-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'team_member_style!' => 'style-03',
				]
			]
		);

		$this->add_responsive_control(
			'border_radius_image',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-team-member .card-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
					'team_member_style!' => 'style-03',
				]
			]
		);

		$this->add_responsive_control('team_member_image_width', [
			'label' => esc_html__('Image Width', 'ube'),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 1000,
				],
				'%'  => [
					'min' => 0,
					'max' => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .ube-tm-classic .ube-tm-image' => 'max-width:{{SIZE}}{{UNIT}}',
				'{{WRAPPER}} .ube-tm-style-02 .ube-tm-inner' => 'max-width:{{SIZE}}{{UNIT}}',
				'{{WRAPPER}} .ube-tm-style-03 .ube-tm-inner' => 'max-width:{{SIZE}}{{UNIT}}',
			],
			'condition' => [
				'image[url]!' => '',
			],
		]);

		$this->add_control(
			'team_member_image_hover_style',
			[
				'label'     => esc_html__( 'Hover Effect', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => [
					'default' => esc_html__( 'Default', 'ube' ),
					'left'    => esc_html__( 'Left', 'ube' ),
					'right'   => esc_html__( 'Right', 'ube' ),
					'top'     => esc_html__( 'Top', 'ube' ),
					'bottom'  => esc_html__( 'Bottom', 'ube' ),
				],
				'condition' => [
					'image[url]!' => '',
					'team_member_style' => 'style-03',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Hover Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_hover_effect(),
				'condition' => [
					'image[url]!' => '',
					'team_member_style!' => 'style-03',
				],
			]
		);
		$this->add_control(
			'hover_image_animation',
			[
				'label'   => esc_html__( 'Hover Image Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_image_effect(),
				'condition' => [
					'image[url]!' => '',
					'team_member_style!' => 'style-03',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_style_name_section_controls() {
		$this->start_controls_section(
			'section_style_name',
			[
				'label' => esc_html__('Name','ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->start_controls_tabs( 'team_name_colors');

		$this->start_controls_tab( 'team_name_tab_normal', [
			'label' => esc_html__( 'Normal', 'ube' ),
		]);

		$this->add_control(
			'team_name_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-tm-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'team_name_tab_hover', [
			'label' => esc_html__( 'Hover', 'ube' ),
		]);
		$this->add_control(
			'team_name_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-tm-name:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'team_name_typography',
				'selector' => '{{WRAPPER}} .ube-tm-name',
			]
		);

		$this->add_control('team_name_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
		]);

		$this->add_responsive_control(
			'team_name_margin_spacing',
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
					'{{WRAPPER}} .ube-tm-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	private function register_style_position_section_controls() {
		$this->start_controls_section('section_style_position', [
			'label' => esc_html__('Position', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);


		$this->add_control(
			'team_job_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-tm-pos' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'team_job_title_typography',
				'selector' => '{{WRAPPER}} .ube-tm-pos',
			]
		);

		$this->add_control('team_job_title_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
		]);


		$this->add_responsive_control(
			'team_job_title_margin_spacing',
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
					'{{WRAPPER}} .ube-tm-pos' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

	}

	private function register_style_description_section_controls() {
		$this->start_controls_section('section_style_description', [
			'label' => esc_html__('Description', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'team_member_style!' => 'style-03',
			]
		]);

		$this->add_control(
			'team_description_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-tm-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'team_description_typography',
				'selector' => '{{WRAPPER}} .ube-tm-desc',
			]
		);

		$this->add_control('team_desc_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => '',
		]);

		$this->add_responsive_control(
			'team_description_margin_spacing',
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
					'{{WRAPPER}} .ube-tm-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	private function register_style_social_section_controls() {
		$this->start_controls_section('section_style_social', [
			'label' => esc_html__('Social', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
				'social_icon_switcher' => 'yes',
			]
		]);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'ube' ),
					'stacked' => esc_html__( 'Stacked', 'ube' ),
					'framed' => esc_html__( 'Framed', 'ube' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => esc_html__( 'Shape', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'ube' ),
					'square' => esc_html__( 'Square', 'ube' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);


		$this->add_responsive_control(
			'team_social_border_width',
			[
				'label'      => esc_html__( 'Border Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					],
				],
				'condition' => [
					'view' => 'framed',
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'team_member_social_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'team_member_social_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}  .elementor-icon' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'team_member_social_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}  .elementor-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'stacked',
				],
			]
		);


		$this->add_control(
			'team_member_social_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}  .elementor-icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_control(
			'team_member_social_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}  .elementor-icon:hover' => 'color: {{VALUE}};fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'team_member_social_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'team_member_social_border_color_hover',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}  .elementor-icon:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'team_social_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);



		$this->add_responsive_control(
			'team_social_font_size',
			[
				'label'      => esc_html__( 'Font Size', 'ube' ),
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
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'team_social_margin',
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
					'{{WRAPPER}} .elementor-icon + .elementor-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'team_social_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		$settings          = $this->get_settings_for_display();
		$style = isset($settings['team_member_style']) ? $settings['team_member_style'] : 'style-01';
		$image_hover_style = isset($settings['team_member_image_hover_style']) ? $settings['team_member_image_hover_style'] : 'default';
		$hover_animation = isset($settings['hover_animation']) ? $settings['hover_animation'] : '';
		$hover_image_animation = isset($settings['hover_image_animation']) ? $settings['hover_image_animation'] : '';
		$team_member_link = isset($settings['team_member_link']) ? $settings['team_member_link'] : array();

		$image_html = '';
		$image_src = '';
		if (isset($settings['image'])) {
			$image_html =  Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size', 'image' );
			$image_src = $this->get_attachment_image_src($settings,'image_size','image');
		}

		$social_html = '';
		$social_icon_switcher = isset($settings['social_icon_switcher']) ? $settings['social_icon_switcher'] : 'yes';
		$name = isset($settings['team_member_name']) ? $settings['team_member_name'] : '';
		$name_class = isset($settings['team_name_class']) ? $settings['team_name_class'] : '';
		$position = isset($settings['team_member_job_title']) ? $settings['team_member_job_title'] : '';
		$position_class = isset($settings['team_job_title_class']) ? $settings['team_job_title_class'] : '';
		$description = isset($settings['team_member_description']) ? $settings['team_member_description'] : '';
		$desc_class = isset($settings['team_desc_class']) ? $settings['team_desc_class'] : '';
		if ($social_icon_switcher === 'yes') {
			$team_member_list = isset($settings['team_member_list']) ? $settings['team_member_list'] : array();
			$social_html = $this->get_social_markup_html($team_member_list);
		}


		ube_get_template('elements/team-member.php', array(
			'element' => $this,
			'style' => $style,
			'image_hover_style' => $image_hover_style,
			'hover_animation' => $hover_animation,
			'hover_image_animation' => $hover_image_animation,
			'team_member_link' => $team_member_link,
			'image_html' => $image_html,
			'image_src' => $image_src,
			'social_html' => $social_html,
			'name' => $name,
			'name_class' => $name_class,
			'position' => $position,
			'position_class' => $position_class,
			'description' => $description,
			'desc_class' => $desc_class
		));
	}

	private function get_social_markup_html($socials = array()) {
		if (empty($socials)) {
			return '';
		}
		ob_start();
		ube_get_template('elements/team-member/social.php',array(
				'socials' => $socials,
				'element' => $this
			));
		return ob_get_clean();
	}

}