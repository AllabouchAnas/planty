<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class UBE_Element_Advanced_Team_Member extends UBE_Abstracts_Elements_Grid {

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 1.4.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'ube-advanced-team-member';
	}

	public function get_title() {
		return esc_html__( 'Advanced Team Member', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-person';
	}

	public function get_ube_keywords() {
		return array( 'team', 'member','ube', 'advanced','advanced team member' , 'ube advanced team member');
	}

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'ube' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_group_control(
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

		$repeater->add_control(
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

		$repeater->add_control(
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

		$repeater->add_control(
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

		$repeater->add_control(
			'team_member_description',
			[
				'label'       => esc_html__( 'Description', 'ube' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ube'),
				'rows'        => 10,
				/*'condition'   => [
					'team_member_style!' => 'style-03',
				],*/
			]
		);

		$repeater->add_control( 'team_member_list', [
			'label'       => esc_html__( 'Socials', 'ube' ),
			'description' => esc_html__( 'One social per line. Icon class & url separator with |. For eg: fab fa-facebook|https://facebook.com', 'ube' ),
			'type'        => Controls_Manager::TEXTAREA,
		] );


	}

	protected function get_repeater_defaults() {
		$placeholder_image_src = Utils::get_placeholder_image_src();
		return [
			[
				'team_member_name' => esc_html__( 'John Doe', 'ube' ),
				'team_member_job_title' => esc_html__( 'CEO', 'ube' ),
				'image' => [
					'url' => $placeholder_image_src,
				],
			],
			[
				'team_member_name' => esc_html__( 'John Doe', 'ube' ),
				'team_member_job_title' => esc_html__( 'CEO', 'ube' ),
				'image' => [
					'url' => $placeholder_image_src,
				],
			],
			[
				'team_member_name' => esc_html__( 'John Doe', 'ube' ),
				'team_member_job_title' => esc_html__( 'CEO', 'ube' ),
				'image' => [
					'url' => $placeholder_image_src,
				],
			],
		];
	}

	protected function print_grid_item() {
		$settings          = $this->get_settings_for_display();
		$style = isset($settings['team_member_style']) ? $settings['team_member_style'] : 'style-01';
		$image_hover_style = isset($settings['team_member_image_hover_style']) ? $settings['team_member_image_hover_style'] : 'default';
		$hover_animation = isset($settings['hover_animation']) ? $settings['hover_animation'] : '';
		$hover_image_animation = isset($settings['hover_image_animation']) ? $settings['hover_image_animation'] : '';


		$item          = $this->get_current_item();
		$item_key      =    $this->get_current_item_key();
		$team_member_link = isset($item['team_member_link']) ? $item['team_member_link'] : array();

		$image_html = '';
		$image_src = '';

		if (isset($item['image'])) {
			$image_html =  Group_Control_Image_Size::get_attachment_image_html( $item, 'image_size', 'image' );
			$image_src = $this->get_attachment_image_src($item,'image_size','image');
		}

		$social_html = '';
		$name = isset($item['team_member_name']) ? $item['team_member_name'] : '';
		$name_class = isset($settings['team_name_class']) ? $settings['team_name_class'] : '';
		$position = isset($item['team_member_job_title']) ? $item['team_member_job_title'] : '';
		$position_class = isset($settings['team_job_title_class']) ? $settings['team_job_title_class'] : '';
		$description = isset($item['team_member_description']) ? $item['team_member_description'] : '';
		$desc_class = isset($settings['team_desc_class']) ? $settings['team_desc_class'] : '';

		$team_member_list = isset($item['team_member_list']) ? $item['team_member_list'] : '';
		if ($team_member_list !== '') {
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
			'desc_class' => $desc_class,
			'item_key' =>  $item_key
		));

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$wrapper_class = 'ube-team-member-wrap';
		$slider_enable = isset($settings['slider_enable']) ? $settings['slider_enable'] : '';
		if ($slider_enable === 'on') {
			$this->print_slider( $settings,$wrapper_class );
		}  else {
			$this->print_grid( $settings,$wrapper_class );
		}
	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_items_section_controls();
		$this->register_style_section_controls();
		$this->register_grid_section_controls(['slider_enable!' => 'on']);
		$this->register_slider_section_controls([
			'name'     => 'slider_enable',
			'operator' => '=',
			'value'    => 'on'
		]);
	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Layout','ube')
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
			'slider_enable',
			[
				'label'        => esc_html__( 'Slider', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->end_controls_section();
	}

	protected function register_slider_section_controls($condition = []) {
		parent::register_slider_section_controls($condition);
		parent::register_slider_item_style_section_controls($condition);
		$this->remove_control('slider_type');
		$this->update_control('fade_enabled',[
			'conditions'   => [
				'terms' => [
					[
						'name'     => 'slides_to_show',
						'operator' => '==',
						'value'    => '1',
					],
				],
			],
		]);

		$this->remove_control('slider_content_position');
		$this->remove_control('slider_content_alignment');
	}

	protected function register_grid_section_controls($condition = []) {
		parent::register_grid_section_controls($condition);
		parent::register_grid_item_style_section_controls($condition);
		$this->remove_control('grid_content_position');
		$this->remove_control('grid_content_alignment');
	}

	protected function register_items_section_controls() {
		parent::register_items_section_controls();
		$this->update_control('items',['title_field' => '{{team_member_name}}']);
	}

	protected function register_style_section_controls() {
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

	private function get_social_markup_html($socials) {
		$socials = explode( "\n", str_replace( "\r", "", $socials ) );
		ob_start();
		?>
		<div class="ube-tm-social">
			<?php foreach ($socials as $social): ?>
				<?php
					$item = explode( '|', $social );
					if ( empty( $item ) || count( $item ) < 2 ) {
						continue;
					}
					$icon_class = $item[0];
					$url        = $item[1];
				?>
				<a class="elementor-icon" href="<?php echo esc_url($url)?>"><i class="<?php echo esc_attr($icon_class)?>"></i></a>
			<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}

}