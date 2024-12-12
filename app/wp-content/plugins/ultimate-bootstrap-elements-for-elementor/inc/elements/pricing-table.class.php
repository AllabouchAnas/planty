<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class UBE_Element_Pricing_Table extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-pricing-table';
	}

	public function get_title()
	{
		return esc_html__('Pricing Table', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-price-table';
	}

	public function get_ube_keywords()
	{
		return array('pricing table', 'ube', 'ube pricing table');
	}

	protected function register_controls()
	{
		$this->setting_section_content();
		$this->price_section_content();
		$this->feature_section_content();
		$this->button_section_content();
		$this->ribbon_section_content();
		$this->wrapper_section_style();
		$this->title_section_style();
		$this->pricing_section_style();
		$this->feature_list_section_style();
		$this->ribbon_section_style();
		$this->icon_section_style();
		$this->image_section_style();
		$this->button_section_style();
	}

	private function setting_section_content()
	{
		$this->start_controls_section(
			'section_pricing_table_settings',
			[
				'label' => esc_html__('Settings', 'ube'),
			]
		);

		$this->add_control(
			'pricing_table_style',
			[
				'label' => esc_html__('Pricing Style', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'label_block' => false,
				'options' => ube_get_pricing_table_style(),
			]
		);

		$this->add_control(
			'pricing_table_icon_enabled',
			[
				'label' => esc_html__('List Icon', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'show',
				'default' => 'show',
			]
		);

		$this->add_control(
			'pricing_table_title',
			[
				'label' => esc_html__('Title', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => false,
				'default' => esc_html__('Startup', 'ube'),
			]
		);


		$this->add_control(
			'pricing_table_sub_title',
			[
				'label' => esc_html__('Sub Title', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => false,
				'default' => esc_html__('A tagline here.', 'ube'),
			]
		);

		$this->add_control(
			'pricing_table_icon_type',
			[
				'label' => esc_html__('Icon Type', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'label_block' => false,
				'options' => [
					'icon' => esc_html__('icon', 'ube'),
					'image' => esc_html__('image', 'ube'),
				],
				'condition' => [
					'pricing_table_style' => ['style-2', 'style-1', 'style-3'],
				],
			]
		);

		$this->add_control(
			'pricing_table_icon',
			[
				'label' => esc_html__('Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'pricing_table_style',
							'operator' => 'in',
							'value' => ['style-2', 'style-1', 'style-3'],
						],
						[
							'name' => 'pricing_table_icon_type',
							'operator' => 'in',
							'value' => ['icon']
						],
					]
				]
			]
		);

		$this->add_control(
			'pricing_table_image',
			[
				'label' => esc_html__('Choose Image', 'ube'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'pricing_table_style',
							'operator' => 'in',
							'value' => ['style-2', 'style-1', 'style-3'],
						],
						[
							'name' => 'pricing_table_icon_type',
							'operator' => 'in',
							'value' => ['image']
						],
					]
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'pricing_table_image_size',
				'include' => [],
				'default' => 'full',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'pricing_table_style',
							'operator' => 'in',
							'value' => ['style-2', 'style-1', 'style-3'],
						],
						[
							'name' => 'pricing_table_icon_type',
							'operator' => 'in',
							'value' => ['image']
						],
					]
				]
			]
		);

		$this->end_controls_section();
	}

	private function price_section_content()
	{

		$this->start_controls_section(
			'section_pricing_table_price',
			[
				'label' => esc_html__('Price', 'ube'),
			]
		);

		$this->add_control(
			'pricing_table_price',
			[
				'label' => esc_html__('Price', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => false,
				'default' => esc_html__('99', 'ube'),
			]
		);

		$this->add_control(
			'enable_pricing_table_onsale',
			[
				'label' => esc_html__('On Sale?', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__('Yes', 'ube'),
				'label_off' => esc_html__('No', 'ube'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'pricing_table_onsale_price',
			[
				'label' => esc_html__('Sale Price', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => false,
				'default' => esc_html__('89', 'ube'),
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
				],
			]
		);
		$this->add_control(
			'pricing_table_price_cur',
			[
				'label' => esc_html__('Price Currency', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'label_block' => false,
				'default' => esc_html__('$', 'ube'),
			]
		);

		$this->add_control(
			'pricing_table_price_cur_placement',
			[
				'label' => esc_html__('Currency Placement', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'label_block' => false,
				'options' => [
					'left' => esc_html__('Left', 'ube'),
					'right' => esc_html__('Right', 'ube'),
				],
			]
		);

		$this->add_control(
			'pricing_table_price_period',
			[
				'label' => esc_html__('Price Period (per)', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'label_block' => false,
				'default' => esc_html__('month', 'ube'),
			]
		);

		$this->add_control(
			'pricing_table_period_separator',
			[
				'label' => esc_html__('Period Separator', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'label_block' => false,
				'default' => esc_html__('/', 'ube'),
			]
		);

		$this->add_control('pricing_table_price_position', [
			'label' => esc_html__('Pricing Position', 'ube'),
			'type' => Controls_Manager::SELECT,
			'default' => 'bottom',
			'label_block' => false,
			'options' => [
				'top' => esc_html__('On Top', 'ube'),
				'bottom' => esc_html__('At Bottom', 'ube'),
			],
			'condition' => [
				'pricing_table_style' => 'style-3',
			],
		]);

		$this->add_control('pricing_table_price_background', [
			'label' => esc_html__('Background Image', 'ube'),
			'type' => Controls_Manager::MEDIA,
			'seperator' => 'before',
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
			'selectors' => [
				'{{WRAPPER}} .ube-pricing-bg' => 'background-image: url({{URL}});',
			],
			'condition' => [
				'pricing_table_style' => 'style-4',
			],
		]);

		$this->end_controls_section();

	}

	private function feature_section_content()
	{

		$this->start_controls_section(
			'section_pricing_table_feature',
			[
				'label' => esc_html__('Feature', 'ube'),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'pricing_table_item',
			[
				'label' => esc_html__('List Item', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'label_block' => true,
				'default' => esc_html__('Pricing table list item', 'ube'),
			]
		);

		$repeater->add_control(
			'pricing_table_list_icon',
			[
				'label' => esc_html__('List Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'repeater_pricing_table_icon_color',
			[
				'label' => esc_html__('Icon Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-pricing-feature-item-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'repeater_pricing_table_item_color',
			[
				'label' => esc_html__('Item Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .ube-pricing-feature-item-info' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'pricing_table_icon_mood',
			[
				'label' => esc_html__('Item Active?', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pricing_table_items',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					['pricing_table_item' => 'Unlimited calls'],
					['pricing_table_item' => 'Free hosting'],
					['pricing_table_item' => '24/7 support'],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{pricing_table_item}}',
			]
		);

		$this->end_controls_section();

	}

	private function button_section_content()
	{
		$this->start_controls_section(
			'section_pricing_table_button',
			[
				'label' => esc_html__('Button', 'ube'),
			]
		);

		$this->add_control(
			'pricing_table_button_show',
			[
				'label' => esc_html__('Display Button', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'ube'),
				'label_off' => esc_html__('Hide', 'ube'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'pricing_table_button_icon',
			[
				'label' => esc_html__('Button Icon', 'ube'),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'pricing_table_button_icon_alignment',
			[
				'label' => esc_html__('Icon Position', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__('Before', 'ube'),
					'right' => esc_html__('After', 'ube'),
				],
				'condition' => [
					'pricing_table_button_icon!' => '',
					'pricing_table_button_show' => 'yes',
					'pricing_table_button_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_button_icon_indent',
			[
				'label' => esc_html__('Icon Spacing', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'pricing_table_button_icon!' => '',
					'pricing_table_button_show' => 'yes',
					'pricing_table_button_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-button.icon-left i' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .ube-pricing-button.icon-right i' => 'margin-left: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'pricing_table_btn',
			[
				'label' => esc_html__('Button Text', 'ube'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => ['active' => true],
				'default' => esc_html__('Choose Plan', 'ube'),
				'condition' => [
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'pricing_table_btn_link',
			[
				'label' => esc_html__('Button Link', 'ube'),
				'type' => Controls_Manager::URL,
				'dynamic' => ['active' => true],
				'label_block' => true,
				'default' => [
					'url' => '#',
					'is_external' => '',
				],
				'show_external' => true,
				'condition' => [
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'btn_type',
			[
				'label' => esc_html__( 'Type', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator'     => 'before',
				'options' => ube_get_button_styles(),
				'condition' => [
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'btn_scheme',
			[
				'label'   => esc_html__('Scheme', 'ube'),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes(false),
				'default' => 'accent',
				'condition' => [
					'btn_type[value]!' => 'link',
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'btn_shape',
			[
				'label' => esc_html__( 'Shape', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => ube_get_button_shape(),
				'condition' => [
					'btn_type[value]!' => 'link',
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'btn_size',
			[
				'label' => esc_html__( 'Size', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => ube_get_button_sizes(),
				'style_transfer' => true,
				'condition' => [
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	private function ribbon_section_content()
	{

		$this->start_controls_section(
			'section_pricing_table_featured',
			[
				'label' => esc_html__('Ribbon', 'ube'),
			]
		);

		$this->add_control(
			'enable_pricing_table_featured',
			[
				'label' => esc_html__('Featured?', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'pricing_table_featured_styles',
			[
				'label' => esc_html__('Ribbon Style', 'ube'),
				'type' => Controls_Manager::SELECT,
				'default' => 'ribbon-1',
				'options' => [
					'ribbon-1' => esc_html__('Style 1', 'ube'),
					'ribbon-2' => esc_html__('Style 2', 'ube'),
					'ribbon-3' => esc_html__('Style 3', 'ube'),
					'ribbon-4' => esc_html__('Style 4', 'ube'),
					'ribbon-5' => esc_html__('Style 5', 'ube'),
				],
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
				],
			]
		);

		$this->add_control(
			'pricing_table_featured_tag_text',
			[
				'label' => esc_html__('Featured Tag Text', 'ube'),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'label_block' => false,
				'default' => esc_html__('Featured', 'ube'),
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-featured:before' => 'content: "{{VALUE}}";',
				],
				'condition' => [
					'pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3', 'ribbon-4'],
					'enable_pricing_table_featured' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	private function wrapper_section_style()
	{
		$this->start_controls_section(
			'wrapper_style_settings_tab_style',
			[
				'label' => esc_html__('Wrapper', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pricing_table_bg_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_container_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pricing_table_border',
				'label' => esc_html__('Border Type', 'ube'),
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-inner',
			]
		);

		$this->add_control(
			'pricing_table_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-inner' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pricing_table_shadow',
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-inner',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_content_alignment',
			[
				'label' => esc_html__('Content Alignment', 'ube'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'ube'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'ube'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'ube'),
						'icon' => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->end_controls_section();

	}

	private function title_section_style()
	{
		$this->start_controls_section(
			'title_style_settings_tab_style',
			[
				'label' => esc_html__('Title', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'pricing_table_sub_title',
							'operator' => '!in',
							'value' => ['']
						],
						[
							'name' => 'pricing_table_title',
							'operator' => '!in',
							'value' => ['']
						],
					]
				]
			]
		);

		$this->add_control(
			'pricing_table_title_heading',
			[
				'label' => esc_html__('Title Style', 'ube'),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pricing_table_title!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_title_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_title_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-title',
				'condition' => [
					'pricing_table_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_title_padding',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pricing_table_title!' => '',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'pricing_table_subtitle_heading',
			[
				'label' => esc_html__('Subtitle Style', 'ube'),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pricing_table_sub_title!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_subtitle_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-subtitle' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_sub_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_subtitle_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-subtitle',
				'condition' => [
					'pricing_table_sub_title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_subtitle_padding',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pricing_table_sub_title!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_subtitle_wrapper_heading',
			[
				'label' => esc_html__('Wrapper', 'ube'),
				'separator' => 'before',
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'pricing_table_title_bg_color',
			'selector' => '{{WRAPPER}} .ube-pricing-style-2 .ube-pricing-header,{{WRAPPER}} .ube-pricing-style-4 .ube-pricing-header',
			'condition' => [
				'pricing_table_title!' => '',
				'pricing_table_style' => ['style-2', 'style-4'],
			],
		]);

		$this->add_control(
			'pricing_table_title_line_color',
			[
				'label' => esc_html__('Line Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-style-3 .ube-pricing-header:after' => 'background: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_title!' => '',
					'pricing_table_style' => ['style-3'],
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_title_wrapper_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-style-2 .ube-pricing-header,{{WRAPPER}} .ube-pricing-style-4 .ube-pricing-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pricing_table_style' => ['style-2', 'style-4'],
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_title_wrapper_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function pricing_section_style()
	{
		$this->start_controls_section(
			'pricing_style_settings_tab_style',
			[
				'label' => esc_html__('Pricing', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pricing_table_price_tag_onsale_heading',
			[
				'label' => esc_html__('Original Price', 'ube'),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pricing_table_price!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_pricing_onsale_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-original-price, {{WRAPPER}} .ube-pricing-original-price .ube-pricing-price-currency' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_price!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_price_tag_onsale_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-price',
				'condition' => [
					'pricing_table_price!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_original_price_currency_heading',
			[
				'label' => esc_html__('Original Price Currency', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_original_price_currency_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-original-price .ube-pricing-price-currency' => 'color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_original_price_currency_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-original-price .ube-pricing-price-currency',
				'condition' => [
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_original_price_currency_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-original-price .ube-pricing-price-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_price_tag_heading',
			[
				'label' => esc_html__('Sale Price', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_pricing_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-inner .ube-pricing-tag .ube-pricing-price-tag .sale-price, {{WRAPPER}} .ube-pricing-inner .ube-pricing-tag .ube-pricing-price-tag .sale-price .ube-pricing-price-currency' => 'color: {{VALUE}};',
				],
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_price_tag_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-inner .ube-pricing-tag .ube-pricing-price-tag .sale-price',
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_price_currency_heading',
			[
				'label' => esc_html__('Sale Price Currency', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_pricing_curr_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-tag .ube-pricing-price-tag .sale-price .ube-pricing-price-currency' => 'color: {{VALUE}};',
				],
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_price_cur_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-tag .ube-pricing-price-tag .sale-price .ube-pricing-price-currency',
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_price_cur_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-tag .ube-pricing-price-tag .sale-price .ube-pricing-price-currency' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'enable_pricing_table_onsale' => 'yes',
					'pricing_table_onsale_price!' => '',
					'pricing_table_price_cur!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_pricing_period_heading',
			[
				'label' => esc_html__('Pricing Period', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'pricing_table_price_period',
							'operator' => '!in',
							'value' => ['']
						],
						[
							'name' => 'pricing_table_period_separator',
							'operator' => '!in',
							'value' => ['']
						],
					]
				]
			]
		);

		$this->add_control(
			'pricing_table_pricing_period_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-price-period' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'pricing_table_price_period',
							'operator' => '!in',
							'value' => ['']
						],
						[
							'name' => 'pricing_table_period_separator',
							'operator' => '!in',
							'value' => ['']
						],
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_price_preiod_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-price-period',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'pricing_table_price_period',
							'operator' => '!in',
							'value' => ['']
						],
						[
							'name' => 'pricing_table_period_separator',
							'operator' => '!in',
							'value' => ['']
						],
					]
				]
			]
		);


		$this->add_control(
			'pricing_table_price_overlay_heading',
			[
				'label' => esc_html__('Overlay', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pricing_table_style' => 'style-4',
				],
			]
		);


		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'pricing_table_header_bg_image_overlay',
			'label' => esc_html__('Overlay', 'ube'),
			'selector' => '{{WRAPPER}} .ube-pricing-style-4 .ube-pricing-bg:after',
			'types' => ['classic', 'gradient'],
			'condition' => [
				'pricing_table_style' => 'style-4',
			],
		]);

		$this->add_control(
			'pricing_table_price_tag',
			[
				'label' => esc_html__('Wrapper', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'pricing_table_price_tag_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing:not(.ube-pricing-style-4) .ube-pricing-tag' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-bg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control('pricing_table_style_five_price_style_padding', [
			'label' => esc_html__('Padding', 'ube'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [
				'px',
				'%',
				'em',
			],
			'selectors' => [
				'{{WRAPPER}} .ube-pricing .ube-pricing-bg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'condition' => [
				'pricing_table_style' => ['style-4'],
			],
		]);

		$this->end_controls_section();
	}

	private function feature_list_section_style()
	{
		$this->start_controls_section(
			'featured_list_style_settings_tab_style',
			[
				'label' => esc_html__('Feature List', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pricing_table_pricing_featured_wrapper_heading',
			[
				'label' => esc_html__('Wrapper', 'ube'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'pricing_table_feature_items_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_pricing_featured_item_heading',
			[
				'label' => esc_html__('Items Featured', 'ube'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pricing_table_list_item_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-feature-item .ube-pricing-feature-item-info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_list_item_color_icon',
			[
				'label' => esc_html__('Color Icon', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-feature-item-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_list_disable_item_color',
			[
				'label' => esc_html__('Disable item color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-disable-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_list_disable_item_color_icon',
			[
				'label' => esc_html__('Disable Item Color Icon', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-feature-item-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_list_item_icon_size',
			[
				'label' => esc_html__('Icon Size', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-feature-item-icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-pricing-feature-item-icon img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-pricing-feature-item-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_list_item_typography',
				'selector' => '{{WRAPPER}} .ube-pricing-feature-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pricing_table_border_feature_item',
				'label' => esc_html__('Border Type', 'ube'),
				'selector' => '{{WRAPPER}} .ube-pricing-feature-item',
			]
		);

		$this->add_responsive_control(
			'pricing_table_feature_item_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-feature-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function ribbon_section_style()
	{
		$this->start_controls_section(
			'ribbon_style_tab_style',
			[
				'label' => esc_html__('Ribbon', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_pricing_table_featured' => 'yes'
				],
			]
		);

		$this->add_control(
			'pricing_table_style_line_color',
			[
				'label' => esc_html__('Line Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-1:before' => 'background: {{VALUE}};',
				],
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
					'pricing_table_featured_styles' => 'ribbon-1',
				],
			]
		);

		$this->add_control(
			'pricing_table_style_1_featured_bar_height',
			[
				'label' => esc_html__('Line Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-ribbon-1:before' => 'height: {{SIZE}}px;',
				],
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
					'pricing_table_featured_styles' => 'ribbon-1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_featured_tag_typography',
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-2:before, {{WRAPPER}} .ube-pricing .ube-pricing-ribbon-3:before, {{WRAPPER}} .ube-pricing .ube-pricing-ribbon-4:before',
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
					'pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3', 'ribbon-4'],
				],
			]
		);

		$this->add_control(
			'pricing_table_featured_tag_text_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-2:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-3:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-4:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
					'pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3', 'ribbon-4'],
				],
			]
		);

		$this->add_control(
			'pricing_table_featured_tag_bg_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-2:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-2:after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-3:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-4:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-ribbon-5:before' => 'border-right-color: {{VALUE}}; border-left-color: {{VALUE}};border-top-color: {{VALUE}}',
				],
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
					'pricing_table_featured_styles' => ['ribbon-2', 'ribbon-3', 'ribbon-4', 'ribbon-5'],
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pricing_table_featured_tag_bg_shadow',
				'label' => esc_html__('Shadow', 'ube'),
				'selector' => '{{WRAPPER}} .ube-pricing-ribbon-4:before',
				'condition' => [
					'enable_pricing_table_featured' => 'yes',
					'pricing_table_featured_styles' => ['ribbon-4'],
				],
			]
		);

		$this->end_controls_section();
	}

	private function icon_section_style()
	{
		$this->start_controls_section(
			'icon_settings_tab_style',
			[
				'label' => esc_html__('Icon Settings', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'pricing_table_style',
							'operator' => 'in',
							'value' => ['style-2', 'style-1', 'style-3'],
						],
						[
							'name' => 'pricing_table_icon_type',
							'operator' => 'in',
							'value' => ['icon']
						],
						[
							'name' => 'pricing_table_icon',
							'operator' => '!=',
							'value' => [''],
						],
					]
				]
			]
		);

		$this->add_control(
			'pricing_table_icon_bg_show',
			[
				'label' => esc_html__('Show Background', 'ube'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__('Show', 'ube'),
				'label_off' => esc_html__('Hide', 'ube'),
				'return_value' => 'yes',
			]
		);
		$this->start_controls_tabs('banner_button_tabs');

		$this->start_controls_tab('banner_button_normal_tab', [
			'label' => esc_html__('Normal', 'ube'),
		]);

		$this->add_control(
			'pricing_table_icon_color',
			[
				'label' => esc_html__('Icon Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-inner .ube-pricing-icon .ube-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_icon_bg_color',
			[
				'label' => esc_html__('Background Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-icon .ube-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_icon_bg_show' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('pricing_table_button_hover_tab', [
			'label' => esc_html__('Hover', 'ube'),
		]);

		$this->add_control(
			'pricing_table_icon_hover_color',
			[
				'label' => esc_html__('Icon Hover Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-inner:hover .ube-pricing-icon .ube-icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_icon_bg_hover_color',
			[
				'label' => esc_html__('Background Hover Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-inner:hover .ube-pricing-icon .ube-icon' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_icon_bg_show' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pricing_table_icon_size',
			[
				'label' => esc_html__('Icon Size', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-icon .ube-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-pricing-icon .ube-icon img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'pricing_table_icon_area_width',
			[
				'label' => esc_html__('Icon Area Width', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-icon .ube-icon' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_icon_area_height',
			[
				'label' => esc_html__('Icon Area Height', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-icon .ube-icon' => 'height: {{SIZE}}px;',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pricing_table_icon_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-pricing-icon .ube-icon',
			]
		);

		$this->add_control(
			'pricing_table_icon_border_hover_color',
			[
				'label' => esc_html__('Hover Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-inner:hover .ube-pricing-icon .ube-icon' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'pricing_table_icon_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'pricing_table_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-icon .ube-icon' => 'border-radius: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_feature_icon_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function image_section_style()
	{
		$this->start_controls_section(
			'image__style_tab_style',
			[
				'label' => esc_html__('Image Settings', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'pricing_table_style',
							'operator' => 'in',
							'value' => ['style-2', 'style-1', 'style-3'],
						],
						[
							'name' => 'pricing_table_icon_type',
							'operator' => 'in',
							'value' => ['image']
						],
					]
				]
			]
		);

		$this->add_responsive_control(
			'pricing_table_feature_image_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	private function button_section_style()
	{
		$this->start_controls_section(
			'btn_settings_tab_style',
			[
				'label' => esc_html__('Button', 'ube'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pricing_table_button_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_btn_padding',
			[
				'label' => esc_html__('Padding', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_table_btn_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pricing_table_btn_icon_size',
			[
				'label' => esc_html__('Icon Size', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-button img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-pricing .ube-pricing-button i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'pricing_table_button_icon[value]!' => '',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pricing_table_btn_typography',
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button',
			]
		);

		$this->add_control(
			'pricing_table_btn_border_radius',
			[
				'label' => esc_html__('Border Radius', 'ube'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-button' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->start_controls_tabs('pricing_table_button_tabs');

		$this->start_controls_tab('pricing_table_btn_normal', ['label' => esc_html__('Normal', 'ube')]);

		$this->add_control(
			'pricing_table_btn_normal_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'pricing_table_btn_normal_bg_color',
			'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button',
		]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pricing_table_btn_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pricing_table_button_shadow',
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('pricing_table_btn_hover', ['label' => esc_html__('Hover', 'ube')]);

		$this->add_control(
			'pricing_table_btn_hover_text_color',
			[
				'label' => esc_html__('Text Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-pricing .ube-pricing-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(Group_Control_Background::get_type(), [
			'name' => 'pricing_table_btn_hover_bg_color',
			'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button:hover',
		]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'pricing_table_btn_hover_border',
				'label' => esc_html__('Border', 'ube'),
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pricing_table_button_hover_shadow',
				'selector' => '{{WRAPPER}} .ube-pricing .ube-pricing-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public function render_feature_list($settings)
	{
		if (empty($settings['pricing_table_items'])) {
			return;
		}
		$counter = 0;
		?>
        <ul class="ube-pricing-feature-items">
			<?php
			foreach ($settings['pricing_table_items'] as $item) :
				$items_class = array(
					'ube-pricing-feature-item',
					'elementor-repeater-item-' . $item['_id'],
				);
				if ($item['pricing_table_icon_mood'] !== 'yes') {
					$items_class[] = 'ube-pricing-disable-item';
				}
				$this->add_render_attribute('pricing_feature_item' . $counter, 'class', $items_class);
				?>
                <li <?php echo $this->get_render_attribute_string('pricing_feature_item' . $counter); ?>>
					<?php if ($settings['pricing_table_icon_enabled'] === 'show') : ?>
                        <span class="ube-pricing-feature-item-icon">
                             <?php if (!empty($item['pricing_table_list_icon']) && !empty($item['pricing_table_list_icon']['value'])): ?>
	                             <?php Icons_Manager::render_icon($item['pricing_table_list_icon'], ['aria-hidden' => 'true']); ?>
                             <?php endif; ?>
                        </span>
					<?php endif; ?>
					<?php if ($item['pricing_table_item'] !== ''): ?>
                        <span class="ube-pricing-feature-item-info">
                            <?php echo esc_html($item['pricing_table_item']); ?>
                        </span>
					<?php endif; ?>
                </li>
				<?php
				$counter++;
			endforeach;
			?>
        </ul>
		<?php
	}

	public function render_btn($settings, $attr)
	{
		?>
        <a <?php echo $attr ?>>
			<?php if (!empty($settings['pricing_table_button_icon']) && !empty($settings['pricing_table_button_icon']['value']) && ($settings['pricing_table_button_icon_alignment'] === 'left')): ?>
				<?php Icons_Manager::render_icon($settings['pricing_table_button_icon'], ['aria-hidden' => 'true']); ?>
			<?php endif; ?>
			<?php if ($settings['pricing_table_btn'] !== ''): ?>
				<?php echo esc_html($settings['pricing_table_btn']) ?>
			<?php endif; ?>
			<?php if (!empty($settings['pricing_table_button_icon']) && !empty($settings['pricing_table_button_icon']['value']) && ($settings['pricing_table_button_icon_alignment'] === 'right')): ?>
				<?php Icons_Manager::render_icon($settings['pricing_table_button_icon'], ['aria-hidden' => 'true']); ?>
			<?php endif; ?>
        </a>
		<?php
	}

	public function render_pricing($settings)
	{
		if ($settings['enable_pricing_table_onsale'] === 'yes') {
			if ($settings['pricing_table_price_cur_placement'] === 'left') {
				?>
                <del class="ube-pricing-original-price has-sale">
					<?php if ($settings['pricing_table_price_cur'] !== ''): ?>
                        <span class="ube-pricing-price-currency"><?php echo esc_html($settings['pricing_table_price_cur']) ?></span>
					<?php endif; ?>
					<?php if ($settings['pricing_table_price'] !== ''): ?>
                        <span class="ube-pricing-price"><?php echo esc_html($settings['pricing_table_price']) ?></span>
					<?php endif; ?>
                </del>
                <span class="sale-price">
                    <?php if ($settings['pricing_table_price_cur'] !== ''): ?>
                        <span class="ube-pricing-price-currency"><?php echo esc_html($settings['pricing_table_price_cur']) ?></span>
                    <?php endif; ?>
					<?php if ($settings['pricing_table_onsale_price'] !== ''): ?>
                        <span class="ube-pricing-price"><?php echo esc_html($settings['pricing_table_onsale_price']) ?></span>
					<?php endif; ?>
				</span>
				<?php
			} else if ($settings['pricing_table_price_cur_placement'] == 'right') {
				?>
                <del class="ube-pricing-original-price has-sale">
					<?php if ($settings['pricing_table_price'] !== ''): ?>
                        <span class="ube-pricing-price"><?php echo esc_html($settings['pricing_table_price']) ?></span>
					<?php endif; ?>
					<?php if ($settings['pricing_table_price_cur'] !== ''): ?>
                        <span class="ube-pricing-price-currency"><?php echo esc_html($settings['pricing_table_price_cur']) ?></span>
					<?php endif; ?>
                </del>
                <span class="sale-price">
                    <?php if ($settings['pricing_table_onsale_price'] !== ''): ?>
                        <span class="ube-pricing-price"><?php echo esc_html($settings['pricing_table_onsale_price']) ?></span>
                    <?php endif; ?>
					<?php if ($settings['pricing_table_price_cur'] !== ''): ?>
                        <span class="ube-pricing-price-currency"><?php echo esc_html($settings['pricing_table_price_cur']) ?></span>
					<?php endif; ?>
				</span>
				<?php
			}
		} else {
			if ($settings['pricing_table_price_cur_placement'] == 'left') {
				?>
                <span class="ube-pricing-original-price">
                    <?php if ($settings['pricing_table_price_cur'] !== ''): ?>
                        <span class="ube-pricing-price-currency"><?php echo esc_html($settings['pricing_table_price_cur']) ?></span>
                    <?php endif; ?>
					<?php if ($settings['pricing_table_price'] !== ''): ?>
                        <span class="ube-pricing-price"><?php echo esc_html($settings['pricing_table_price']) ?></span>
					<?php endif; ?>
				</span>
				<?php
			} else if ($settings['pricing_table_price_cur_placement'] == 'right') {
				?>
                <span class="ube-pricing-original-price">
                    <?php if ($settings['pricing_table_price'] !== ''): ?>
                        <span class="ube-pricing-price"><?php echo esc_html($settings['pricing_table_price']) ?></span>
                    <?php endif; ?>
					<?php if ($settings['pricing_table_price_cur'] !== ''): ?>
                        <span class="ube-pricing-price-currency"><?php echo esc_html($settings['pricing_table_price_cur']) ?></span>
					<?php endif; ?>
				</span>
				<?php
			}
		}
	}

	public function render()
	{
		ube_get_template('elements/pricing-table.php', array(
			'element' => $this
		));
	}


}