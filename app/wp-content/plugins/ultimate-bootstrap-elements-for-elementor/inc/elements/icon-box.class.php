<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Icons_Manager;

class UBE_Element_Icon_Box extends UBE_Abstracts_Elements {
	public function get_name() {
		return 'ube-icon-box';
	}

	public function get_title() {
		return esc_html__( 'Icon Box', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-icon-box';
	}

	public function get_ube_keywords() {
		return array( 'icon box', 'icon','ube' , 'ube icon box' );
	}

	public function get_script_depends() {
		return array( 'ube-widget-icon-box' );
	}


	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_svg_animate_section_controls();
		$this->register_style_section_controls();
	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content','ube')
			]
		);

		$this->add_control(
			'icon_box_icon',
			[
				'label'            => esc_html__( 'Icon', 'ube' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'separator'        => 'before',
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

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


		$this->add_control(
			'icon_box_title',
			[
				'label'       => esc_html__( 'Title & Description', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'This is the heading', 'ube' ),
				'placeholder' => esc_html__( 'Enter your title', 'ube' ),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'icon_box_description',
			[
				'label'       => '',
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ube' ),
				'placeholder' => esc_html__( 'Enter your description', 'ube' ),
				'rows'        => 10,
				'separator'   => 'none',
				'show_label'  => false,
			]
		);

		$this->add_control(
			'icon_box_link',
			[
				'label'       => esc_html__( 'Link', 'ube' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'ube' ),
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Icon Position', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'ube' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'ube%s-position-',
				'toggle' => false,
			]
		);

		$this->add_control(
			'description_position',
			[
				'label' => esc_html__( 'Description Position', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'default' => 'inset',
				'options'     => [
					'outset' => esc_html__( 'Outset', 'ube' ),
					'inset'  => esc_html__( 'Inset', 'ube' ),

				],
			]
		);


		$this->add_control(
			'icon_box_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);



		$this->end_controls_section();

	}

	protected function register_svg_animate_section_controls() {
		$this->start_controls_section('section_svg_animate',[
			'label' => esc_html__('SVG Animate','ube'),
			'condition'       => [
				'icon_box_icon[library]' => 'svg',
			],
		]);

		$this->add_control( 'icon_svg_animate_alert', [
			'type'            => Controls_Manager::RAW_HTML,
			'content_classes' => 'elementor-control-field-description',
			'raw'             => esc_html__( 'Note: Animate works only with Stroke SVG Icon.', 'ube' ),
		] );

		$this->add_control( 'icon_svg_animate', [
			'label'     => esc_html__( 'SVG Animate', 'ube' ),
			'type'      => Controls_Manager::SWITCHER,
		] );

		$this->add_control( 'icon_svg_animate_play_on_hover', [
			'label'     => esc_html__( 'Play on hover', 'ube' ),
			'type'      => Controls_Manager::SWITCHER,
			'condition' => [
				'icon_svg_animate'       => 'yes',
			],
		] );

		$this->add_control( 'icon_svg_animate_type', [
			'label'     => esc_html__( 'Type', 'ube' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'delayed'  => esc_html__( 'Delayed', 'ube' ),
				'sync'     => esc_html__( 'Sync', 'ube' ),
				'oneByOne' => esc_html__( 'One By One', 'ube' ),
			],
			'default'   => 'delayed',
			'condition' => [
				'icon_svg_animate'       => 'yes',
			],
		] );

		$this->add_control( 'icon_svg_animate_duration', [
			'label'     => esc_html__( 'Transition Duration', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 120,
			'condition' => [
				'icon_svg_animate'       => 'yes',
			],
		] );

		$this->end_controls_section();
	}

	protected function register_style_section_controls() {
		$this->register_icon_style_section_controls();
		$this->register_content_style_section_controls();
	}

	protected function register_icon_style_section_controls() {
		$this->start_controls_section('icon_style_section',[
			'label' => esc_html__('Icon','ube'),
			'tab' =>Controls_Manager::TAB_STYLE
		]);


		$this->start_controls_tabs('tabs_icon_colors');

		$this->start_controls_tab('tabs_icon_color_normal',[
				'label' => esc_html__('Normal','ube')
		]);


		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper' => '--ube-ib-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper' => '--ube-ib-color-foreground: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab('tabs_icon_color_hover',[
			'label' => esc_html__('Hover','ube')
		]);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper:hover' => '--ube-ib-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper:hover' => '--ube-ib-color-foreground: {{VALUE}};',
				],
			]
		);
		$this->add_control('icon_box_animation',[
				'label' => esc_html__( 'Animation', 'ube' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();


		$this->end_controls_tabs();



		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Spacing', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper' => '--ube-ib-spacing: {{SIZE}}{{UNIT}};'
				],
				'separator'        => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper' => '--ube-ib-border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => __( 'Rotate', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'ube' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon,{{WRAPPER}} .elementor-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function register_content_style_section_controls() {
		$this->start_controls_section('content_style_section',[
			'label' => esc_html__('Content','ube'),
			'tab' =>Controls_Manager::TAB_STYLE
		]);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'ube' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'ube' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'ube' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => esc_html__( 'Top', 'ube' ),
					'middle' => esc_html__( 'Middle', 'ube' ),
					'bottom' => esc_html__( 'Bottom', 'ube' ),
				],
				'default' => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'ube' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);



		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-ib-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => esc_html__( 'Color Hover', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-ib-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ube-ib-title',
			]
		);

		$this->add_control('title_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->add_control(
			'heading_description',
			[
				'label' => esc_html__( 'Description', 'ube' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'description_space',
			[
				'label' => esc_html__( 'Spacing', 'ube' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-ib-desc' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Color', 'ube' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ube-ib-desc' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .ube-ib-desc',
			]
		);

		$this->add_control('description_class',[
			'label' => esc_html__('Custom Class','ube'),
			'type' => Controls_Manager::TEXT,
			'default' => ''
		]);

		$this->end_controls_section();
	}

	public function get_icon_markup($icon,$attributes = []) {
		$is_svg = isset( $icon['library'] ) && 'svg' === $icon['library'];
		ob_start();
		Icons_Manager::render_icon($icon, $attributes);
		$html = ob_get_clean();
		if ($is_svg) {
			$html = ube_icon_svg_markup( $html );
		}

		return $html;
	}


	public function render() {
		$settings          = $this->get_settings_for_display();
		$icon_box_link = isset($settings['icon_box_link']) ? $settings['icon_box_link'] : array();
		$hover_animation = isset($settings['icon_box_animation']) ? $settings['icon_box_animation'] : '';
		$icon = isset($settings['icon_box_icon']) ? $settings['icon_box_icon'] : array();
		$title = isset($settings['icon_box_title']) ? $settings['icon_box_title'] : '';
		$title_tag = Elementor\Utils::validate_html_tag(isset($settings['icon_box_title_tag']) ? $settings['icon_box_title_tag'] : 'h3');
		$title_class = isset($settings['title_class']) ? $settings['title_class'] : '';
		$description = isset($settings['icon_box_description']) ? $settings['icon_box_description'] : '';
		$description_class = isset($settings['description_class']) ? $settings['description_class'] : '';
		$description_pos = isset($settings['description_position']) ? $settings['description_position'] : 'inset';
		$icon_svg_animate = isset($settings['icon_svg_animate']) ? $settings['icon_svg_animate'] : '';
		$svg_animate = array();
		$is_svg = isset( $icon['library'] ) && 'svg' === $icon['library'] ? true : false;

		if ($is_svg && ($icon_svg_animate === 'yes')) {
			$icon_svg_animate_type = isset($settings['icon_svg_animate_type']) ? $settings['icon_svg_animate_type'] : 'delayed';
			$icon_svg_animate_duration = isset($settings['icon_svg_animate_duration']) ? $settings['icon_svg_animate_duration'] : 120;
			$icon_svg_animate_play_on_hover = isset($settings['icon_svg_animate_play_on_hover']) ? $settings['icon_svg_animate_play_on_hover'] : '';
			$svg_animate = array(
				'type' => 	$icon_svg_animate_type,
				'duration' => $icon_svg_animate_duration,
				'play_on_hover' => $icon_svg_animate_play_on_hover
			);
		}



		$icon_html = '';
		if (!empty($icon['value'])) {
			$icon_html = $this->get_icon_markup($icon,[ 'aria-hidden' => 'true' ]);
		}


		ube_get_template('elements/icon-box.php', array(
			'element' => $this,
			'icon_box_link' => $icon_box_link,
			'icon_html' => $icon_html,
			'hover_animation' => $hover_animation,
			'title' => $title,
			'title_tag' => $title_tag,
			'title_class' => $title_class,
			'description' => $description,
			'description_pos' => $description_pos,
			'description_class' => $description_class,
			'svg_animate' => $svg_animate
		));


	}
}