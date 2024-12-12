<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use Elementor\Repeater;


class UBE_Element_Social_Share extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-social-share';
	}

	public function get_title() {
		return esc_html__( 'Social Share', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-share';
	}

	public function get_ube_keywords() {
		return array( 'social share' , 'ube', 'social', 'share', 'ube social share' );
	}
	public function get_script_depends() {
		return array( 'share','ube-widget-social-icon' );
	}


	protected function register_controls() {
		$this->register_section_content();
		$this->register_section_icon();
	}

	private function register_section_content() {

		$this->start_controls_section(
			'social_share_section_content',
			[
				'label' => esc_html__( 'Content', 'ube' )
			]
		);

		$this->add_control(
			'social_share_shape',
			[
				'label'   => esc_html__( 'Shape', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'square',
				'options' => [
					'classic'         => esc_html__( 'Classic', 'ube' ),
					'text'            => esc_html__( 'Text', 'ube' ),
					'text-background' => esc_html__( 'Text Background', 'ube' ),
					'rounded'         => esc_html__( 'Rounded', 'ube' ),
					'square'          => esc_html__( 'Square', 'ube' ),
					'circle'          => esc_html__( 'Circle', 'ube' ),
				],
			]
		);

		$this->add_control(
			'social_share_outline',
			[
				'label'        => esc_html__( 'Use Outline', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'social_share_shape',
							'operator' => 'in',
							'value'    => [
								'rounded',
								'square',
								'circle',
								'text-background',
							]
						]
					]
				]
			]
		);

		$this->add_control(
			'social_item_text_scheme',
			[
				'label'   => esc_html__( 'Text Color', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(),
				'default' => '',
			]
		);

		$this->add_control(
			'social_item_background_scheme',
			[
				'label'      => esc_html__( 'Background Color', 'ube' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => ube_get_color_schemes(),
				'default'    => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_share_shape',
							'operator' => 'in',
							'value' => [
								'rounded',
								'square',
								'circle',
								'text-background',
							],
						],
						[
							'name' => 'social_share_outline',
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
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'md',
				'options'        => array(
					'xs' => esc_html__( 'Extra Small', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'md' => esc_html__( 'Medium', 'ube' ),
					'lg' => esc_html__( 'Large', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
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
			'social_share_media',
			[
				'label'   => esc_html__( 'Social Media', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'facebook'      => esc_html__( 'Facebook', 'ube' ),
					'twitter'       => esc_html__( 'Twitter', 'ube' ),
					'pinterest'     => esc_html__( 'Pinterest', 'ube' ),
					'linkedin'      => esc_html__( 'Linkedin', 'ube' ),
					'tumblr'        => esc_html__( 'tumblr', 'ube' ),
					'vkontakte'     => esc_html__( 'Vkontakte', 'ube' ),
					'odnoklassniki' => esc_html__( 'Odnoklassniki', 'ube' ),
					'moimir'        => esc_html__( 'Moimir', 'ube' ),
					'livejournal'   => esc_html__( 'Live journal', 'ube' ),
					'blogger'       => esc_html__( 'Blogger', 'ube' ),
					'digg'          => esc_html__( 'Digg', 'ube' ),
					'evernote'      => esc_html__( 'Evernote', 'ube' ),
					'reddit'        => esc_html__( 'Reddit', 'ube' ),
					'delicious'     => esc_html__( 'Delicious', 'ube' ),
					'stumbleupon'   => esc_html__( 'Stumbleupon', 'ube' ),
					'pocket'        => esc_html__( 'Pocket', 'ube' ),
					'surfingbird'   => esc_html__( 'Surfingbird', 'ube' ),
					'liveinternet'  => esc_html__( 'Liveinternet', 'ube' ),
					'buffer'        => esc_html__( 'Buffer', 'ube' ),
					'instapaper'    => esc_html__( 'Instapaper', 'ube' ),
					'xing'          => esc_html__( 'Xing', 'ube' ),
					'wordpress'     => esc_html__( 'WordPress', 'ube' ),
					'baidu'         => esc_html__( 'Baidu', 'ube' ),
					'renren'        => esc_html__( 'Renren', 'ube' ),
					'weibo'         => esc_html__( 'Weibo', 'ube' ),
					'skype'         => esc_html__( 'Skype', 'ube' ),
					'telegram'      => esc_html__( 'Telegram', 'ube' ),
					'viber'         => esc_html__( 'Viber', 'ube' ),
					'whatsapp'      => esc_html__( 'Whatsapp', 'ube' ),
					'line'          => esc_html__( 'Line', 'ube' ),
				],
			]
		);

		$repeater->add_control(
			'social_share_label',
			[
				'label'   => esc_html__( 'Label', 'ube' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'facebook', 'ube' ),
			]
		);

		$repeater->add_control(
			'social_icon',
			[
				'label'            => esc_html__( 'Icon', 'ube' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'label_block'      => true,
			]
		);

		$repeater->add_control(
			'social_share_switcher',
			[
				'label'        => esc_html__( 'Custom Color', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  =>  esc_html__( 'Please enable if you want to customize color', 'ube' ),
			]
		);

		$repeater->add_control(
			'social_share_item_color',
			[
				'label'     => esc_html__( 'Text Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}} !important'
				],
				'condition' => [
					'social_share_switcher' => 'yes'
				],
			]
		);

		$repeater->add_control(
			'social_share_item_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.ube-social-outline)' => 'background-color: {{VALUE}} !important'
				],
				'condition' => [
					'social_share_switcher' => 'yes'
				],
			]
		);

		$this->add_control(
			'social_share_list',
			[
				'label'       => esc_html__( 'Social Icons', 'ube' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'social_share_media' => 'facebook',
						'social_share_label' => esc_html__( 'facebook', 'ube' ),
						'social_icon'        => [
							'value'   => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_share_media' => 'twitter',
						'social_share_label' => esc_html__( 'twitter', 'ube' ),
						'social_icon'        => [
							'value'   => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_share_media' => 'linkedin',
						'social_share_label' => esc_html__( 'linkedin', 'ube' ),
						'social_icon'        => [
							'value'   => 'fab fa-linkedin',
							'library' => 'fa-brands',
						],
					],
				],
				'title_field' => '{{{ social_share_label }}}',
			]
		);


		$this->add_responsive_control(
			'social_share_align',
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

	private function register_section_icon() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'social_share_size',
			[
				'label'     => esc_html__( 'Size', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-social-share li' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'          => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .ube-social-share li' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'social_share_shape',
							'operator' => 'in',
							'value'    => [
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
			'icon_spacing_text',
			[
				'label'     => esc_html__( 'Spacing Text', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-text-social'=> 'padding-left: {{SIZE}}{{UNIT}};',

				],
				'condition' => [
					'social_share_shape' => 'text',
				]
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
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
					'{{WRAPPER}} .ube-social-share li + li' => 'margin-left: {{SIZE}}{{UNIT}};',

				],
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
					'{{WRAPPER}} .ube-social-share li' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => ['social_share_outline' => 'yes']
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-social-share li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name'     => 'social_share_shape',
							'operator' => 'in',
							'value'    => [
								'text-background',
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
			'social_share_icon_margin',
			[
				'label' => esc_html__('Icon Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-social-share.ube-social-text-background li i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-social-share.ube-social-text-background li svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'social_share_shape' => 'text-background',
				]
			]
		);

		$this->add_responsive_control(
			'social_share_text_padding',
			[
				'label' => esc_html__('Text Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-social-share.ube-social-text-background li .ube-text-social' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'social_share_shape' => 'text-background',
				]
			]
		);

		$this->start_controls_tabs('tabs_icon_soclia_share',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'tab_icon_social_share_normal',
			[
				'label' => esc_html__('Normal', 'ube'),
			]
		);
		$this->add_control(
			'social_icon_share_style_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-social-share li' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .ube-social-share li' => 'background-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_share_shape',
							'operator' => 'in',
							'value' => [
								'text-background',
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_share_outline',
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
				'name' => 'social_share_border',
				'selector' => '{{WRAPPER}} .ube-social-share li',
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_share_shape',
							'operator' => 'in',
							'value' => [
								'text-background',
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_share_outline',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-social-share li:hover' => 'color: {{VALUE}} !important;',
				],
				'condition' => [
					'social_share_outline' => ''
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
					'{{WRAPPER}} .ube-social-share li:hover' => 'background-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_share_shape',
							'operator' => 'in',
							'value' => [
								'text-background',
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_share_outline',
							'operator' => '==',
							'value' => '',
						]
					]
				]
			]
		);

		$this->add_control(
			'social_share_border_hover',
			[
				'label' => esc_html__('Border Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-social-share li:hover' => 'border-color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'social_share_shape',
							'operator' => 'in',
							'value' => [
								'text-background',
								'rounded',
								'square',
								'circle',
							],
						],
						[
							'name' => 'social_share_outline',
							'operator' => '==',
							'value' => '',
						]
					]
				]
			]
		);

		$this->add_control(
			'socail_share_filter',
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
					'{{WRAPPER}} .ube-social-share li:hover' => '-webkit-filter:brightness({{SIZE}});filter: brightness({{SIZE}});'
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

	public function render() {
		ube_get_template( 'elements/social-share.php', array(
			'element' => $this
		) );
	}

	protected function content_template() {
		ube_get_template( 'elements-view/social-share.php' );
	}

}