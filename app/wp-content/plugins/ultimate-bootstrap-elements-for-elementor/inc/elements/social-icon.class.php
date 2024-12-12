<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use Elementor\Repeater;

class UBE_Element_Social_Icon extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-social-icon';
	}

	public function get_title()
	{
		return esc_html__('Social Icon', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-social-icons';
	}

	public function get_ube_keywords() {
		return array( 'social icon', 'ube',  'ube social icon', 'social' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-social-icon' );
	}

	protected function register_controls()
	{
		$this->register_section_content();
		$this->register_section_icon();
	}


	private function register_section_content()
	{
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Social Icon', 'ube')
			]
		);

		$this->add_control(
			'social_icon_shape',
			[
				'label' => esc_html__('Shape', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'square',
				'options' => [
					'classic' => esc_html__('Classic', 'ube'),
					'text' => esc_html__('Text', 'ube'),
					'rounded' => esc_html__('Rounded', 'ube'),
					'square' => esc_html__('Square', 'ube'),
					'circle' => esc_html__('Circle', 'ube'),
				],
			]
		);

		$this->add_control(
			'social_icon_outline',
			[
				'label' => esc_html__('Use Outline', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ube'),
				'label_off' => esc_html__('Hide', 'ube'),
				'return_value' => 'yes',
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							]
						]
					]
				]
			]
		);

		$this->add_control(
			'social_item_text_scheme',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);

		$this->add_control(
			'social_item_background_scheme',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_icon_outline',
							'operator' => '!=',
							'value' => 'yes',

						]
					]
				]
			]
		);

		$this->add_control(
			'social_size',
			[
				'label' => esc_html__('Size', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => array(
					'xs' => esc_html__('Extra Small', 'ube'),
					'sm' => esc_html__('Small', 'ube'),
					'md' => esc_html__('Medium', 'ube'),
					'lg' => esc_html__('Large', 'ube'),
					'xl' => esc_html__('Extra Large', 'ube'),
				),
			]
		);

		$this->add_control(
			'social_switcher_tooltip',
			[
				'label'        => esc_html__( 'Use Tooltip', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'social_position',
			[
				'label' => esc_html__('Position', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top' => esc_html__('Top', 'ube'),
					'bottom' => esc_html__('Bottom', 'ube'),
					'left' => esc_html__('Left', 'ube'),
					'right' => esc_html__('Right', 'ube'),
				),
				'condition' => [
					'social_switcher_tooltip' => 'yes'
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_icon',
			[
				'label' => esc_html__('Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'label_block' => true,
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
			]
		);

		$repeater->add_control(
			'social_icon_link',
			[
				'label' => esc_html__('Link', 'ube'),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
					'is_external' => 'true',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('your-link', 'ube'),
			]
		);

		$repeater->add_control( 'social_title', [
			'label'       => esc_html__( 'Custom Text', 'ube' ),
			'placeholder' => esc_html__( 'Title Social', 'ube' ),
			'default'     => '',
			'type'        => Controls_Manager::TEXT,
			'dynamic'     => [
				'active' => true,
			],
			'label_block' => true,
		] );

		$repeater->add_control(
			'social_icon_switcher',
			[
				'label' => esc_html__('Custom Color', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ube'),
				'label_off' => esc_html__('Hide', 'ube'),
				'return_value' => 'yes',
				'default' => '',
				'description' => esc_html__('Please enable if you want to customize color', 'ube'),
			]
		);

		$repeater->add_control(
			'social_icon_item_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}} !important'
				],
				'condition' => [
					'social_icon_switcher' => 'yes'
				],
			]
		);

		$repeater->add_control(
			'social_icon_item_background_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.ube-social-outline)' => 'background-color: {{VALUE}}!important'
				],
				'condition' => [
					'social_icon_switcher' => 'yes'
				],
			]
		);

		$this->add_control(
			'social_icon_list',
			[
				'label' => esc_html__('Social Icons', 'ube'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-linkedin',
							'library' => 'fa-brands',
						],
					],
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social_title, true )}}}',
			]
		);

		$this->add_responsive_control(
			'social_icon_align',
			[
				'label' => esc_html__('Alignment', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->end_controls_section();
	}

	private function register_section_icon()
	{
		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__('Icon', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'social_icon_size',
			[
				'label' => esc_html__('Size', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__('Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'size_units' => ['px', 'em'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							]
						]
					]
				]
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__('Spacing', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li + li' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_spacing',
			[
				'label' => esc_html__('Spacing Text', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-text-social' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['social_icon_shape' => 'text']
			]
		);

		$this->add_responsive_control(
			'border_outline_width',
			[
				'label' => esc_html__('Border Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['social_icon_outline' => 'yes']
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							]
						]
					]
				]
			]
		);

		$this->start_controls_tabs('tabs_icon_social',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'tab_icon_social_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);
		$this->add_control(
			'social_icon_style_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->add_control(
			'social_icon_style_bg_color',
			[
				'label' => esc_html__('BackGround Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li' => 'background-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_icon_outline',
							'operator' => '==',
							'value' => '',
						]
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .ube-social-icons li',
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							]
						],
						[
							'name' => 'social_icon_outline',
							'operator' => '==',
							'value' => '',
						]
					]
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_social_hover',
			[
				'label' => esc_html__('Hover', 'ube'),
			]
		);

		$this->add_control(
			'social_style_color_hover',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li:hover' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'social_icon_outline' => ''
				],
			]
		);


		$this->add_control(
			'social_style_bg_color_hover',
			[
				'label' => esc_html__('BackGround Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li:hover' => 'background-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_icon_outline',
							'operator' => '==',
							'value' => '',
						]
					]
				]
			]
		);

		$this->add_control(
			'social_icon_border_hover',
			[
				'label' => esc_html__('Border Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li:hover' => 'border-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_icon_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
							]
						],
						[
							'name' => 'social_icon_outline',
							'operator' => '==',
							'value' => '',
						]
					]
				]
			]
		);

		$this->add_control(
			'socail_icon_filter',
			[
				'label' => esc_html__( 'Filter', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.8,
						'max' => 1.5,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-social-icons li:hover' => '-webkit-filter:brightness({{SIZE}});filter: brightness({{SIZE}});'
				]
			]
		);

		$this->add_control(
			'social_hover_animation',
			[
				'label' => esc_html__('Hover Animation', 'ube'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tab();

		$this->end_controls_section();
	}

	public function render()
	{
		ube_get_template('elements/social-icon.php', array(
			'element' => $this
		));
	}

	protected function content_template()
	{
		ube_get_template('elements-view/social-icon.php');
	}

}