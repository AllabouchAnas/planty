<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

class UBE_Element_Advanced_Image_Box extends UBE_Abstracts_Elements_Grid {

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
		return 'ube-advanced-image-box';
	}

	public function get_title() {
		return esc_html__( 'Advanced Image Box', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-image-box';
	}

	public function get_ube_keywords() {
		return array( 'image box', 'image','ube', 'advanced' , 'advanced image box', 'ube advanced image box' );
	}

	protected function add_repeater_controls( \Elementor\Repeater $repeater ) {
		$repeater->add_control(
			'image',
			[
				'label'     => esc_html__( 'Choose Image', 'ube' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'image_switcher',
			[
				'label'        => esc_html__( 'Use Hover Image', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'image_hover',
			[
				'label'     => esc_html__( 'Choose Image', 'ube' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'image_switcher' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'full',
				'separator' => 'none',
			]
		);

		$repeater->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}  .ube-image-box .ube-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$repeater->add_control(
			'image_box_title',
			[
				'label'       => esc_html__( 'Title & Description', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'This is the heading', 'ube' ),
				'placeholder' => esc_html__( 'Enter your title', 'ube' ),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'image_box_description',
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


		$repeater->add_control(
			'image_box_link',
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


		parent::register_item_custom_css_control($repeater);
	}

	protected function get_repeater_defaults() {
		return [
			[
				'image' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'image_box_title' => esc_html__( 'This is the heading', 'ube' ),
				'image_box_description' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ube' )
			]
		];
	}

	protected function print_grid_item() {
		$settings          = $this->get_settings_for_display();
		$item          = $this->get_current_item();
		$item_key      =    $this->get_current_item_key();
		$image_box_link = isset($item['image_box_link']) ? $item['image_box_link'] : array();
		$image_switcher = isset($item['image_switcher']) ? $item['image_switcher'] : '';
		$title = isset($item['image_box_title']) ? $item['image_box_title'] : '';
		$title_tag = Elementor\Utils::validate_html_tag(isset($settings['image_box_title_tag']) ? $settings['image_box_title_tag'] : 'h3');
		$title_class = isset($settings['title_class']) ? $settings['title_class'] : '';
		$description = isset($item['image_box_description']) ? $item['image_box_description'] : '';
		$description_pos = isset($settings['description_position']) ? $settings['description_position'] : 'inset';
		$description_class = isset($settings['description_class']) ? $settings['description_class'] : '';

		$image_html = '';
		if (isset($item['image'])) {
			$image_html =  Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'image' );
		}
		$image_hover =  '';

		if (isset($item['image_hover'])) {
			$image_hover =  Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'image_hover' );
		}
		$hover_animation = isset($settings['hover_animation']) ? $settings['hover_animation'] : '';
		$hover_image_animation = isset($settings['hover_image_animation']) ? $settings['hover_image_animation'] : '';

		ube_get_template('elements/image-box.php', array(
			'element' => $this,
			'item_key' => $item_key,
			'image_box_link' => $image_box_link,
			'image_html' => $image_html,
			'image_hover' => $image_hover,
			'title' => $title,
			'title_class' => $title_class,
			'title_tag' => $title_tag,
			'image_switcher' => $image_switcher,
			'description' => $description,
			'description_pos' => $description_pos,
			'description_class' => $description_class,
			'hover_animation' => $hover_animation,
			'hover_image_animation' => $hover_image_animation
		));
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$wrapper_class  = 'ube-advanced-image-box';
		$slider_enable = isset($settings['slider_enable']) ? $settings['slider_enable'] : '';
		if ($slider_enable === 'on') {
			$this->print_slider( $settings,$wrapper_class );
		}  else {
			$this->print_grid( $settings, $wrapper_class );
		}
	}

	protected function register_controls() {
		$this->register_content_section_controls();
		$this->register_style_section_controls();
		$this->register_items_section_controls();
		$this->register_grid_section_controls(['slider_enable!' => 'on']);
		$this->register_slider_section_controls([
			'name'     => 'slider_enable',
			'operator' => '=',
			'value'    => 'on'
		]);
	}

	protected function register_items_section_controls() {
		parent::register_items_section_controls();
		$this->update_control('items',[
			'title_field' => '{{ image_box_title }}'
		]);
	}

	protected function register_grid_section_controls($condition = [] ) {
		parent::register_grid_section_controls($condition);
		parent::register_grid_item_style_section_controls($condition);
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
	}

	protected function register_content_section_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Image Box','ube')
			]
		);

		$this->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Image Position', 'ube' ),
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
			'image_box_title_tag',
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

	protected function register_style_section_controls(){
		$this->register_image_style_section_controls();
		$this->register_content_style_section_controls();
	}

	protected function register_image_style_section_controls() {
		$this->start_controls_section('section_style_image', [
			'label' => esc_html__('Image', 'ube'),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_responsive_control(
			'image_space',
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
				//'separator'        => 'before',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-image-box .ube-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .card-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			]
		);
		$this->add_control(
			'hover_image_animation',
			[
				'label'   => esc_html__( 'Hover Image Effect', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => ube_get_image_effect(),
			]
		);



		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .ube-image img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_hover_transition_opacity',
			[
				'label'     => esc_html__( 'Transition Duration', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0.3,
				],
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-image img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .ube-icon-box-wrapper:hover .ube-image img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label'     => esc_html__( 'Opacity', 'ube' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ube-icon-box-wrapper:hover .ube-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
}