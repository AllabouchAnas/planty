<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class UBE_Element_Post_Slider extends UBE_Abstracts_Elements {

	public function get_name() {
		return 'ube-post-slider';
	}

	public function get_title() {
		return esc_html__( 'Post Slider', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-post-slider';
	}

	public function get_style_depends() {
		return array( 'slick' );
	}

	public function get_ube_keywords() {
		return array(
			'post',
			'slider',
			'blog post',
			'article',
			'custom posts',
			'content views',
			'blog view',
			'content marketing',
			'blogger',
			'ube'
		);
	}

	public function get_script_depends() {
		return array( 'ube-widget-post', 'ube-widget-slider' );
	}

	protected function register_controls() {
		$this->section_query();
		$this->section_layout();
		$this->slide_options();
		$this->section_term_setting();
		$this->section_meta_setting();
		$this->section_wrapper_style();
		$this->section_navigation_style();
		$this->section_content_style();
		$this->section_feature_image_style();
		$this->section_term_style();
		$this->section_meta_style();
		$this->section_title_style();
		$this->section_excerpt_style();
		$this->section_category_filter_style();
		$this->section_read_more_style();
		$this->section_advanced_options();

	}

	public function section_query() {
		$post_types = ube_get_post_types();
		$taxonomies = get_taxonomies( [], 'objects' );

		$this->start_controls_section(
			'section_post__filters',
			[
				'label' => esc_html__( 'Query', 'ube' ),
			]
		);
		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Source', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'post'  => esc_html__( 'Posts', 'ube' ),
					'by_id' => esc_html__( 'Manual Selection', 'ube' ),
				],
				'default' => 'post',
			]
		);

		$this->add_control(
			'posts_ids',
			[
				'label'       => esc_html__( 'Search & Select', 'ube' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => ube_get_all_types_post(),
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [
					'post_type' => 'by_id',
				],
			]
		);

		$this->add_control(
			'authors', [
				'label'       => esc_html__( 'Author', 'ube' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => ube_get_authors(),
				'condition'   => [
					'post_type!' => 'by_id',
				],
			]
		);
		foreach ( $taxonomies as $taxonomy => $object ) {
			if ( ! isset( $object->object_type[0] ) || ! in_array( $object->object_type[0], array_keys( $post_types ) ) ) {
				continue;
			}

			$this->add_control(
				$taxonomy . '_ids',
				[
					'label'       => $object->label,
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple'    => true,
					'object_type' => $taxonomy,
					'options'     => wp_list_pluck( get_terms( $taxonomy ), 'name', 'term_id' ),
					'condition'   => [
						'post_type' => $object->object_type,
					],
				]
			);
		}

		$this->add_control(
			'post__not_in',
			[
				'label'       => esc_html__( 'Exclude', 'ube' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => ube_get_all_types_post(),
				'label_block' => true,
				'post_type'   => '',
				'multiple'    => true,
				'condition'   => [
					'post_type!' => 'by_id',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Posts Per Page', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Offset', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '0',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_post_orderby_options(),
				'default' => 'date',

			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'ube' ),
					'desc' => esc_html__( 'Descending', 'ube' ),
				],
				'default' => 'desc',

			]
		);
		$this->end_controls_section();

	}

	public function section_layout() {
		$this->start_controls_section(
			'section_post_list_layout',
			[
				'label' => esc_html__( 'Layout Settings', 'ube' ),
			]
		);
		$this->add_control(
			'post_layout',
			[
				'label'   => esc_html__( 'Post Layout', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'post-grid-layout-01',
				'options' => ube_get_post_grid_layout(),
			]
		);


		$this->add_control(
			'show_load_more_text',
			[
				'label'       => esc_html__( 'Label Text', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Load More', 'ube' ),
				'condition'   => [
					'paging' => 'load_more',
				],
			]
		);
		$this->add_control(
			'show_filter_category',
			[
				'label'        => esc_html__( 'Show Filter Category', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'        => esc_html__( 'Show Image', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before'
			]
		);
		$this->add_control( 'image_size_mode', [
			'label'     => esc_html__( 'Size Mode', 'ube' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				'original'      => esc_html__( 'Original', 'ube' ),
				'100'           => '1:1',
				'133.333333333' => '4:3',
				'75'            => '3:4',
				'177.777777778' => '16:9',
				'56.25'         => '9:16',
				'custom'        => esc_html__( 'Custom', 'ube' ),
			],
			'default'   => '75',
			'condition' => [
				'show_image' => 'yes',
			],
		] );
		$this->add_control(
			'image_size_width',
			[
				'label'     => esc_html__( 'Custom Width', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'condition' => [
					'image_size_mode' => 'custom',
				],
			]
		);

		$this->add_control(
			'image_size_height',
			[
				'label'     => esc_html__( 'Custom Height', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'condition' => [
					'image_size_mode' => 'custom',
				],
			]
		);
		$this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Show Title', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before'
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'        => esc_html__( 'Show excerpt', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Words', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '10',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_expansion_indicator',
			[
				'label'       => esc_html__( 'Expansion Indicator', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( '...', 'ube' ),
				'condition'   => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_read_more_button',
			[
				'label'        => esc_html__( 'Show Read More Button', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
				'condition'    => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'read_more_button_text',
			[
				'label'     => esc_html__( 'Button Text', 'ube' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'ube' ),
				'condition' => [
					'show_read_more_button' => 'yes',
					'show_excerpt'          => 'yes',
				],
			]
		);
		$this->add_control(
			'read_more_button_text_suffix',
			[
				'label'     => esc_html__( 'Suffix Icon', 'ube' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'condition' => [
					'show_read_more_button' => 'yes',
					'show_excerpt'          => 'yes',
				],
			]
		);

		$this->add_control(
			'show_read_more_button_prefix_style',
			[
				'label'        => esc_html__( 'Show Read More Button Prefix Style', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'show_read_more_button' => 'yes',
					'show_excerpt'          => 'yes',
				],
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label'        => esc_html__( 'Show Meta', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->end_controls_section();


	}

	public function slide_options() {
		$this->start_controls_section(
			'section_slider_option', [
				'label' => esc_html__( 'Slider Option', 'ube' ),
			]
		);
		$this->add_control(
			'slider_type',
			[
				'label'   => esc_html__( 'Slider Type', 'ube' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'ube' ),
						'icon'  => 'eicon-h-align-stretch',
					],
					'vertical'   => [
						'title' => esc_html__( 'Vertical', 'ube' ),
						'icon'  => ' eicon-v-align-stretch',
					],

				],
			]
		);
		$this->add_responsive_control( 'slides_to_show', [
			'label'   => esc_html__( 'Slides To Show', 'ube' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 12,
			'step'    => 1,
			'default' => 3,
		] );

		$this->add_responsive_control(
			'navigation_arrow',
			[
				'label'   => esc_html__( 'Navigation Arrow', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'off' => esc_html__( 'Hide', 'ube' ),
					'on'  => esc_html__( 'Show', 'ube' ),

				],
				'default' => 'off',
			]
		);

		$this->add_responsive_control(
			'navigation_dots',
			[
				'label'   => esc_html__( 'Navigation Dots', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'off' => esc_html__( 'Hide', 'ube' ),
					'on'  => esc_html__( 'Show', 'ube' ),

				],
				'default' => 'on',
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label'        => esc_html__( 'Center Mode', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'center_padding',
			[
				'label'       => esc_html__( 'Center Padding', 'ube' ),
				'description' => esc_html__( 'Side padding when in center mode (px/%)', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '50px',
				'condition'   => [
					'center_mode' => 'on'
				]
			]
		);

		$this->add_control(
			'autoplay_enable',
			[
				'label'        => esc_html__( 'Autoplay Slides', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 500,
				'default'   => 5000,
				'condition' => [
					'autoplay_enable' => 'on'
				]
			]
		);

		$this->add_control(
			'infinite_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label'   => esc_html__( 'Transition Speed', 'ube' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 300,
			]
		);

		$this->add_responsive_control( 'slider_space_between_items', [
			'label'     => esc_html__( 'Space Between Items', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 0,
			'max'       => 200,
			'step'      => 1,
			'default'   => 30,
			'selectors' => [
				'{{WRAPPER}} .slick-slider' => '--ube-slider-gap: {{VALUE}}px;',
			],
		] );

		$this->end_controls_section();
	}

	public function section_advanced_options() {
		$this->start_controls_section(
			'slider_slides_advanced_option', [
				'label' => esc_html__( 'Slider Advanced Options', 'ube' ),
				'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);
		$this->add_control(
			'adaptive_height',
			[
				'label'        => esc_html__( 'Adaptive Height', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause Autoplay On Hover', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
				'condition'    => [
					'autoplay_enable' => 'on'
				]
			]
		);

		$this->add_control(
			'single_slide_scroll',
			[
				'label'        => esc_html__( 'Single Slide Scroll', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'fade_enabled',
			[
				'label'        => esc_html__( 'Fade Animation', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
				'conditions'   => [
					'terms' => [
						[
							'name'     => 'slides_to_show',
							'operator' => '==',
							'value'    => '1',
						],
						[
							'name'     => 'slider_type',
							'operator' => '==',
							'value'    => 'horizontal',
						],
					],
				],
			]
		);


		$this->add_control(
			'slider_syncing',
			[
				'label'        => esc_html__( 'Slider Syncing', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'slider_syncing_element',
			[
				'label'       => esc_html__( 'ID or Class Of Slider To Syncing', 'ube' ),
				'description' => esc_html__( 'Set the slider to be the navigation of other slider (Class or ID Name)', 'ube' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'slider_syncing' => 'on'
				]
			]
		);

		$this->add_control(
			'focus_on_select',
			[
				'label'        => esc_html__( 'Enable Focus On Select Element', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_control(
			'grid_mode',
			[
				'label'        => esc_html__( 'Enabled Grid Mode', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'slide_rows',
			[
				'label'     => esc_html__( 'Slide Rows', 'ube' ),
				'type'      => Controls_Manager::NUMBER,
				'condition' => [
					'grid_mode' => 'on'
				],
				'default'   => 2
			]
		);

		$this->add_responsive_control( 'slides_per_row', [
			'label'     => esc_html__( 'Slides Per Row', 'ube' ),
			'type'      => Controls_Manager::NUMBER,
			'min'       => 1,
			'max'       => 12,
			'step'      => 1,
			'default'   => 1,
			'condition' => [
				'grid_mode' => 'on'
			]
		] );


		$this->add_control(
			'rtl_mode',
			[
				'label'        => esc_html__( 'RTL Mode', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Enable', 'ube' ),
				'label_off'    => esc_html__( 'Disable', 'ube' ),
				'return_value' => 'on',
				'default'      => '',
			]
		);
		$this->end_controls_section();
	}

	public function section_term_setting() {
		$this->start_controls_section(
			'section_post_list_term',
			[
				'label' => esc_html__( 'Term Settings', 'ube' ),
			]
		);
		$this->add_control(
			'show_category',
			[
				'label'        => esc_html__( 'Show Category', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'category_length',
			[
				'label'     => esc_html__( 'Number Of Category', 'ube' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 10,
				'step'      => 1,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);
		$this->add_control(
			'category_separate_style',
			[
				'label'     => esc_html__( 'Separation Style', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'coma',
				'options'   => [
					'coma'  => esc_html__( 'Coma', 'ube' ),
					'slash' => esc_html__( 'Slash', 'ube' ),
				],
				'condition' => [
					'show_category' => 'yes',
				],

			]
		);
		$this->add_control(
			'show_category_icon',
			[
				'label'        => esc_html__( 'Show Category Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_category' => 'yes',
				]
			]
		);
		$this->end_controls_section();
	}

	public function section_meta_setting() {
		$this->start_controls_section(
			'section_post_list_meta',
			[
				'label'     => esc_html__( 'Meta Settings', 'ube' ),
				'condition' => [
					'show_meta' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'        => esc_html__( 'Show Author Name', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);
		$this->add_control(
			'show_author_icon',
			[
				'label'        => esc_html__( 'Show Author Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'conditions'   => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				]
			]
		);
		$this->add_control(
			'show_avatar',
			[
				'label'        => esc_html__( 'Show Avatar', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'conditions'   => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author',
							'operator' => '==',
							'value'    => 'yes'
						],
						[
							'name'     => 'show_author_icon',
							'operator' => '!=',
							'value'    => 'yes'
						],
					]
				]
			]
		);
		$this->add_control(
			'author_text_prefix',
			[
				'label'      => esc_html__( 'Author Text Prefix', 'ube' ),
				'type'       => Controls_Manager::TEXT,
				'default'    => esc_html__( 'Post By', 'ube' ),
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				]
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Show Date', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before'
			]
		);

		$this->add_control(
			'show_date_icon',
			[
				'label'        => esc_html__( 'Show Date Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'conditions'   => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_date',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				]
			]
		);
		$this->add_control(
			'date_text_prefix',
			[
				'label'      => esc_html__( 'Date Text Prefix', 'ube' ),
				'type'       => Controls_Manager::TEXT,
				'default'    => esc_html__( 'Post On', 'ube' ),
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_date',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				]

			]
		);
		$this->add_control(
			'show_comment_count',
			[
				'label'        => esc_html__( 'Show Comment Count', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',


			]
		);
		$this->add_control(
			'show_comment_icon',
			[
				'label'        => esc_html__( 'Show Comment Count Icon', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_comment_count' => 'yes',
				]
			]
		);
		$this->add_control(
			'comment_text_suffix',
			[
				'label'     => esc_html__( 'Comment Count Text Suffix', 'ube' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'comments', 'ube' ),
				'condition' => [
					'show_comment_count' => 'yes',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'show_meta_separate',
			[
				'label'        => esc_html__( 'Show Separator', 'ube' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'ube' ),
				'label_off'    => esc_html__( 'Hide', 'ube' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);


		$this->end_controls_section();
	}

	public function section_wrapper_style() {

		$this->start_controls_section(
			'section_post_style',
			[
				'label' => esc_html__( 'Post Style', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'post_bg_color',
			[
				'label'     => esc_html__( 'Post Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .card' => 'background-color: {{VALUE}}',
				],

			]
		);
		$this->add_responsive_control(
			'post_margin',
			[
				'label'      => esc_html__( 'Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'post_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'post_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-posts .ube-post-item',
			]
		);

		$this->add_control(
			'post_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .card-img-top'     => 'border-radius: {{TOP}}px {{RIGHT}}px 0 0;',
					'{{WRAPPER}} .ube-posts .card-body'        => 'border-radius: 0 0 {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .ube-posts .card-img'         => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .ube-posts .card'             => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'post_list_shadow',
				'selector' => '{{WRAPPER}} .ube-posts .card',
			]
		);

		$this->end_controls_section();

	}

	public function section_navigation_style() {
		$this->start_controls_section(
			'slider_navigation_arrows_style', [
				'label'     => esc_html__( 'Navigation Arrows', 'ube' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation_arrow' => 'on'
				]
			]
		);
		$this->add_responsive_control( 'slider_arrows_position', [
			'label'     => esc_html__( 'Arrow Position', 'ube' ),
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'default',
			'options'   => [
				'default'    => [
					'title' => esc_html__( 'Default', 'ube' ),
					'icon'  => 'eicon-v-align-bottom',
				],
				'vertical'   => [
					'title' => esc_html__( 'Vertical Center', 'ube' ),
					'icon'  => 'eicon-v-align-stretch',
				],
				'horizontal' => [
					'title' => esc_html__( 'Horizontal Center', 'ube' ),
					'icon'  => 'eicon-h-align-stretch',
				],
			],
			'condition' => [
				'navigation_arrow' => 'on'
			]
		] );

		$this->start_controls_tabs(
			'slider_arrows_tabs',
			[
				'condition' => [
					'navigation_arrow' => 'on'
				]
			]
		);
		$this->start_controls_tab(
			'slider_arrows_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);
		$this->add_control(
			'slider_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .slick-arrow' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'slider_arrow_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .slick-arrow',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_arrow_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}}  .slick-arrow'
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_arrows_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'slider_arrow_hover_background',
				'label'    => esc_html__( 'Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .slick-arrow:hover',

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'slider_arrow_border_hover',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}}  .slick-arrow:hover'
			]
		);
		$this->add_control(
			'slider_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .slick-arrow:hover' => 'color: {{VALUE}}',
				],

			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'slider_arrows_type',
			[
				'label'     => esc_html__( 'Type', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'separator' => 'before',
				'options'   => [
					''        => esc_html__( 'Default', 'ube' ),
					'outline' => esc_html__( 'Outline', 'ube' ),
					'classic' => esc_html__( 'Classic', 'ube' ),
				],
			]
		);

		$this->add_control(
			'slider_arrows_size',
			[
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => [
					''   => esc_html__( 'Default', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'lg' => esc_html__( 'Larger', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
				'style_transfer' => true,
			]
		);
		$this->add_control(
			'slider_arrows_shape',
			[
				'label'     => esc_html__( 'Shape', 'ube' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'round',
				'options'   => [
					'round'   => esc_html__( 'Round', 'ube' ),
					'square'  => esc_html__( 'Square', 'ube' ),
					'rounded' => esc_html__( 'Rounded', 'ube' ),
				],
				'condition' => [
					'slider_arrows_type!' => ''
				],

			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'slider_navigation_dots_style', [
				'label'      => esc_html__( 'Navigation Dots', 'ube' ),
				'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => [
					'terms' => [
						[
							'name'     => 'navigation_dots',
							'operator' => '=',
							'value'    => 'on'
						]
					]
				]
			]
		);
		$this->add_responsive_control(
			'dots_position',
			[
				'label'       => esc_html__( 'Dots Position', 'ube' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'default'     => 'outset',
				'options'     => [
					'outset' => esc_html__( 'Outset', 'ube' ),
					'inset'  => esc_html__( 'Inset', 'ube' ),

				],
			]
		);
		$this->add_control(
			'slider_dots_size',
			[
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => [
					''   => esc_html__( 'Default', 'ube' ),
					'sm' => esc_html__( 'Small', 'ube' ),
					'lg' => esc_html__( 'Larger', 'ube' ),
					'xl' => esc_html__( 'Extra Large', 'ube' ),
				],
				'style_transfer' => true,
			]
		);
		$this->add_control(
			'slider_dots_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .slick-dots>ul li' => 'color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_section();

	}

	public function section_content_style() {

		$this->start_controls_section(
			'section_post_content_style',
			[
				'label' => esc_html__( 'Content Style', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'post_content_align',
			[
				'label'     => esc_html__( 'Text Align', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .card-body'        => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .card-body'        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'post_content_margin',
			[
				'label'      => esc_html__( 'Content Margin', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .card-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'post_content_width',
			[
				'label'      => esc_html__( 'Content Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'%' => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .card-body' => 'width:{{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'post_content_background',
				'label'    => esc_html__( 'Content Background', 'ube' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ube-posts .ube-post-grid-item .card-body',
			]
		);
		$this->end_controls_section();

	}

	public function section_feature_image_style() {
		$this->start_controls_section(
			'section_post_feature_image_style',
			[
				'label' => esc_html__( 'Feature Image Style', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'post_image_max_height',
			[
				'label'      => esc_html__( 'Image Max Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-entry-post-thumb' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'hover_animation',
			[
				'label'   => esc_html__( 'Hover Animation', 'ube' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''              => esc_html__( 'Choose Animation', 'ube' ),
					'gray-scale'    => esc_html__( 'Gray Scale', 'ube' ),
					'white-opacity' => esc_html__( 'White Opacity', 'ube' ),
					'black-opacity' => esc_html__( 'Black Opacity', 'ube' ),
					'shine'         => esc_html__( 'Shine', 'ube' ),
					'circle'        => esc_html__( 'Circle', 'ube' ),
					'flash'         => esc_html__( 'Flash', 'ube' ),
				],
			]
		);
		$this->end_controls_section();
	}

	public function section_term_style() {

		$this->start_controls_section(
			'section_term_style',
			[
				'label'     => esc_html__( 'Term', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_category' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'section_term_tabs' );

		$this->start_controls_tab(
			'section_term_style_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'post_term_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-terms' => 'color: {{VALUE}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'section_term_style_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_control(
			'post_term_color_hover',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-terms a:hover' => 'color: {{VALUE}}!important;',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'term_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_term_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-posts .ube-post-terms .list-inline-item',

			]
		);
		$this->add_responsive_control(
			'post_term_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-item:not(.ube-post-grid-layout-03) .ube-post-terms' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'post_layout!' => 'post-grid-layout-03',
				],
			]
		);

		$this->end_controls_section();
	}

	public function section_meta_style() {

		$this->start_controls_section(
			'section_meta_style',
			[
				'label'     => esc_html__( 'Meta', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_meta' => 'yes'
				]
			]
		);
		$this->start_controls_tabs( 'section_meta_tabs' );

		$this->start_controls_tab(
			'section_meta_style_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'post_meta_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'post_meta_author_color',
			[
				'label'     => esc_html__( 'Author Name Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-posted-by .value' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_author' => 'yes'
				]

			]
		);
		$this->add_control(
			'post_meta_date_color',
			[
				'label'     => esc_html__( 'Date Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-posted-on .value' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_date' => 'yes',
				],

			]
		);
		$this->add_control(
			'post_meta_comment_color',
			[
				'label'      => esc_html__( 'Comment Color', 'ube' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-comments-count .value' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_comment_count',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				]

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'section_meta_style_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_control(
			'post_meta_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta a:hover' => 'color: {{VALUE}}!important;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->add_control(
			'post_meta_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta .list-inline-item .ube-icon' => 'color: {{VALUE}};',
				],
				'separator' => 'before',

			]
		);

		$this->add_control(
			'meta_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_meta_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-posts .ube-entry-meta .list-inline-item',

			]
		);
		$this->add_responsive_control(
			'post_meta_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-item:not(.ube-post-grid-layout-02) .ube-entry-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'post_layout!' => 'post-grid-layout-02',
				],
			]
		);
		$this->add_responsive_control(
			'post_meta_item_spacing',
			[
				'label'      => esc_html__( 'Item Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-post-grid-item .ube-entry-meta .list-inline-item:not(:last-child)'        => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ube-post-grid-item .ube-entry-meta .list-inline-item:not(:last-child)::after' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'author_avatar_width',
			[
				'label'      => esc_html__( 'Author Image Width', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta .author-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author_icon',
							'operator' => '!=',
							'value'    => 'yes'
						],
						[
							'name'     => 'show_avatar',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				],
				'separator'  => 'before'
			]
		);
		$this->add_responsive_control(
			'author_avatar_height',
			[
				'label'      => esc_html__( 'Author Image Height', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta .author-image img' => 'height: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author_icon',
							'operator' => '!=',
							'value'    => 'yes'
						],
						[
							'name'     => 'show_avatar',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				],
			]
		);
		$this->add_control(
			'author_avatar_radius',
			[
				'label'      => esc_html__( 'Author Image Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta .author-image img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author_icon',
							'operator' => '!=',
							'value'    => 'yes'
						],
						[
							'name'     => 'show_avatar',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				],
			]
		);
		$this->add_responsive_control(
			'author_avatar_spacing',
			[
				'label'      => esc_html__( 'Author Image Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-entry-meta .author-image' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms'    => [
						[
							'name'     => 'show_author_icon',
							'operator' => '!=',
							'value'    => 'yes'
						],
						[
							'name'     => 'show_avatar',
							'operator' => '==',
							'value'    => 'yes'
						],
					]
				],
			]
		);

		$this->end_controls_section();
	}

	public function section_title_style() {

		$this->start_controls_section(
			'section_title',
			[
				'label'     => esc_html__( 'Title', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'section_title_tabs' );

		$this->start_controls_tab(
			'section_title_style_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'post_title_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-entry-title' => 'color: {{VALUE}};',
				],

			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'section_title_style_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_control(
			'post_title_color_hover',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-link:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'title_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_title_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-posts .ube-post-link',
			]
		);
		$this->add_responsive_control(
			'post_title_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function section_excerpt_style() {


		$this->start_controls_section(
			'section_excerpt_style',
			[
				'label'     => esc_html__( 'Excerpt', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);


		$this->add_control(
			'post_excerpt_color',
			[
				'label'     => esc_html__( 'Excerpt Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ube-post-excerpt p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_excerpt_typography',
				'label'    => esc_html__( 'Excerpt Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-post-excerpt p',
			]
		);
		$this->add_responsive_control(
			'post_excerpt_spacing',
			[
				'label'      => esc_html__( 'Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	public function section_category_filter_style() {
		//Content Style Section
		$this->start_controls_section(
			'section_category_style',
			[
				'label'     => esc_html__( 'Category Filter', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter_category' => 'yes'
				]
			]
		);
		$this->add_control(
			'post_category_filter_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
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
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post' => 'justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'post_category_filter_margin',
			[
				'label'     => esc_html__( 'Margin', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_category_filter_typography',
				'label'    => esc_html__( 'Typography', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-nav-post .nav-link',
			]
		);

		$this->add_responsive_control(
			'post_category_item_spacing',
			[
				'label'      => esc_html__( 'Item Spacing', 'ube' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [ 'max' => 300 ],
					'%'  => [ 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .ube-nav-post .nav-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'post_category_filter_item_padding',
			[
				'label'     => esc_html__( 'Item Padding', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-link' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		$this->start_controls_tabs( 'section_category_tabs' );

		$this->start_controls_tab(
			'section_category_style_normal',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);

		$this->add_control(
			'post_category_filter_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-link' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'post_category_filter_bg',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-link' => 'background-color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'post_category_filter_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-nav-post .nav-link',
			]
		);


		$this->end_controls_tab();
		$this->start_controls_tab(
			'section_category_style_hover',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_control(
			'post_category_filter_color_hover',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-link:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'post_category_filter_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-link:hover' => 'background-color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'post_category_filter_border_hover',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-nav-post .nav-link:hover',
			]
		);


		$this->end_controls_tab();
		$this->start_controls_tab(
			'section_category_style_active',
			[
				'label' => esc_html__( 'Active', 'ube' ),
			]
		);
		$this->add_control(
			'post_category_filter_color_active',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-item.active .nav-link' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'post_category_filter_bg_active',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-item.active .nav-link' => 'background-color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'post_category_filter_border_active',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-nav-post .nav-item.active .nav-link',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'category_filter_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		$this->add_control(
			'post_category_filter_border_radius',
			[
				'label'     => esc_html__( 'Border Radius', 'ube' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .ube-nav-post .nav-link' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'post_category_filter_shadow',
				'selector' => '{{WRAPPER}} .ube-nav-post .nav-link',
			]
		);

		$this->end_controls_section();

	}

	public function section_read_more_style() {


		$this->start_controls_section(
			'section_read_more',
			[
				'label'     => esc_html__( 'Read More Button', 'ube' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more_button' => 'yes',
					'post_layout!'          => 'post-grid-layout-02',
				],
			]
		);
		$this->add_control(
			'read_more_button_type',
			[
				'label'     => esc_html__( 'Type', 'ube' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'separator' => 'before',
				'options'   => ube_get_button_styles(),
			]
		);

		$this->add_control(
			'read_more_button_scheme',
			[
				'label'   => esc_html__( 'Scheme', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'options' => ube_get_color_schemes( false ),
				'default' => 'primary',
				'condition' => [
					'read_more_button_type[value]!' => 'link',
				],
			]
		);

		$this->add_control(
			'read_more_button_shape',
			[
				'label'   => esc_html__( 'Shape', 'ube' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => ube_get_button_shape(),
				'condition' => [
					'read_more_button_type[value]!' => 'link',
				],
			]
		);


		$this->add_control(
			'read_more_button_size',
			[
				'label'          => esc_html__( 'Size', 'ube' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'md',
				'options'        => ube_get_button_sizes(),
				'style_transfer' => true,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(), [
				'name'     => 'read_more_typography',
				'selector' => '{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn',
			]
		);
		$this->add_control(
			'read_more_align',
			[
				'label'     => esc_html__( 'Alignment', 'ube' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ube' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ube' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ube' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .read-more-button-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'prefix_style_color',
			[
				'label'     => esc_html__( 'Style Prefix Color', 'ube' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn::before' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_read_more_button_prefix_style' => 'yes',
					'show_read_more_button'              => 'yes',
				]

			]
		);


		$this->start_controls_tabs(
			'read_more_button_tabs'
		);
		$this->start_controls_tab(
			'read_more_button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ube' ),
			]
		);
		$this->add_control(
			'read_more_button_normal_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'read_more_button_border',
				'label'    => esc_html__( 'Border', 'ube' ),
				'selector' => '{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn',
			]
		);

		$this->add_control(
			'read_more_button_normal_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'read_more_button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ube' ),
			]
		);
		$this->add_control(
			'read_more_button_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn:hover'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn:hover::before' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'read_more_button_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'read_more_button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'ube' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'read_more_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'read_more_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'read_more_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'ube' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ube-posts .ube-post-grid-item .ube-post-read-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		ube_get_template( 'elements/post-slider.php', array(
			'element' => $this
		) );

	}

}