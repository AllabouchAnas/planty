<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if (!class_exists('G5P_Elements_Listing_Abstract', false)) {
	G5P()->loadFile(G5P()->pluginDir('inc/abstracts/elementor-listing.class.php'));
}

abstract class G5Shop_Abstracts_Elements_Listing extends G5P_Elements_Listing_Abstract {

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_columns_controls();
		$this->register_columns_gutter_controls();
		$this->register_post_count_control();
		$this->register_offset_controls();
		$this->register_post_paging_controls();
		$this->register_post_animation_controls();
		$this->register_cate_filter_controls();
		$this->end_controls_section();
	}

	protected function register_layout_category_controls() {
		$this->add_control(
			'layout_category',
			[
				'label'   => esc_html__( 'Layout', 'lustria-framework' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style-01',
				'options' => apply_filters('lustria_product_category_style',[
					'style-01' => esc_html__( 'Layout 01', 'lustria-framework' ),
					'style-02' => esc_html__( 'Layout 02', 'lustria-framework' ),
				]) ,
			]
		);
	}

	protected function register_image_category_controls() {
		$this->add_control(
			'category_image',
			[
				'label' => esc_html__('Choose Image', 'lustria-framework'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
	}

	protected function register_hover_effect_controls() {
		$this->add_control('hover_effect', [
			'label' => esc_html__('Hover Effect', 'lustria-framework'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'' => esc_html__('None', 'lustria-framework'),
				'suprema-effect' => 'Suprema',
				'layla-effect' => 'Layla',
				'bubba-effect' => 'Bubba',
				'jazz-effect' => 'Jazz',
				'flash-effect' => 'Flash',
			],
			'default' => '',
		]);
	}

	protected function register_size_mode_controls() {
		$this->add_control('size_mode', [
			'label' => esc_html__('Size Mode', 'lustria-framework'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'original' => esc_html__('Original', 'lustria-framework'),
				'100' => '1:1',
				'133.333333333' => '4:3',
				'75' => '3:4',
				'177.777777778' => '16:9',
				'56.25' => '9:16',
				'custom' => esc_html__('Custom', 'lustria-framework'),
			],
			'default' => 'original',
		]);

		$this->add_responsive_control(
			'size_width',
			[
				'label' => esc_html__('Custom Width', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'size_mode' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .gf-product-category-bg ' => '--ube-banner-custom-width: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'size_height',
			[
				'label' => esc_html__('Custom Height', 'lustrua-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 1,
				'condition' => [
					'size_mode' => 'custom',
				],
				'selectors' => [
					'{{WRAPPER}} .gf-product-category-bg ' => 'padding-bottom:calc(({{VALUE}}/var(--ube-banner-custom-width))*100%)',
				],
			]
		);
	}

	protected function register_columns_controls()
	{
		$this->add_control(
			'columns',
			[
				'type' => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label' => esc_html__('Columns', 'lustria-framework'),
				'data_type' => 'select',
				'options' => $this->get_post_columns(),
				'default' => '4',
			]
		);
	}

	protected function register_offset_controls()
	{
		$this->add_control(
			'offset',
			[
				'label' => esc_html__('Offset', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter offset for products', 'lustria-framework'),
				'default' => '',
			]
		);
	}

	protected function register_is_slider_controls(){
		$this->add_control(
			'is_slider',
			[
				'label' => esc_html__('Is Slider', 'lustria-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'lustria-framework'),
				'label_off' => esc_html__('Disable', 'lustria-framework'),
				'return_value' => 'on',
				'default' => '',
			]
		);
	}

	protected function register_narrow_product_controls() {
		$this->add_control(
			'id',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'data_args' => array(
					'post_type' => 'product'
				),
				'label' => esc_html__('Narrow Product', 'lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Product', 'lustria-framework'),
				'default' => '',
			]
		);
	}

	protected function register_tabs_section_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->register_tabs_cate_filter_controls();

		$this->register_tabs_controls();

		$this->end_controls_section();
	}

	protected function register_tabs_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_columns_controls();
		$this->register_columns_gutter_controls();
		$this->register_post_count_control();

		$this->register_post_paging_controls();
		$this->register_post_animation_controls();

		$this->end_controls_section();
	}

	protected function register_tabs_controls() {

		$product_tabs = new \Elementor\Repeater();

		$product_tabs->add_control(
			'tab_title',
			[
				'label' => esc_html__('Title', 'lustria-framework' ),
				'type' => Controls_Manager::TEXT
			]
		);

		$product_tabs->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'lustria-framework'),
				'options' => [
					'' => esc_html__('All', 'lustria-framework'),
					'sale' => esc_html__('Sale Off', 'lustria-framework'),
					'new-in' => esc_html__('New In', 'lustria-framework'),
					'featured' => esc_html__('Featured', 'lustria-framework'),
					'top-rated' => esc_html__('Top rated', 'lustria-framework'),
					'recent-review' => esc_html__('Recent review', 'lustria-framework'),
					'best-selling' => esc_html__('Best Selling', 'lustria-framework'),
				],
				'default' => '',
				'separator'  => 'before',
			]

		);


		$product_tabs->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category','lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'lustria-framework'),
				'default' => '',
			]
		);

		$product_tabs->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'lustria-framework'),
				'description' => esc_html__('Select how to sort retrieved products.', 'lustria-framework'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'lustria-framework'),
					'price' => esc_html__('Price', 'lustria-framework'),
					'rand' => esc_html__('Random', 'lustria-framework'),
					'sales' => esc_html__('Sales', 'lustria-framework'),
				),
				'default' => 'date',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);

		$product_tabs->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'lustria-framework'),
				'description' => esc_html__('Select sorting order.', 'lustria-framework'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'lustria-framework'),
					'ASC' => esc_html__('Ascending', 'lustria-framework'),
				),
				'default' => 'DESC',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__('Product Tabs', 'lustria-framework'),
				'type'      => Controls_Manager::REPEATER,
				'title_field' => '{{ tab_title }}',
				'default'     => [
					[
						'tab_title' => esc_html__( 'Sale Off', 'lustria-framework' ),
						'show' => 'sale',
						'orderby' => 'sales',
						'order' => 'DESC',
					],
					[
						'tab_title' => esc_html__( 'New In', 'lustria-framework' ),
						'show' => 'new-in',
						'order' => 'DESC',
					],
					[
						'tab_title' => esc_html__( 'Featured', 'lustria-framework' ),
						'show' => 'featured',
						'orderby' => 'date',
						'order' => 'DESC',
					],
				],
				'fields'    => $product_tabs->get_controls(),

			]
		);
	}

	protected function register_tabs_cate_filter_controls() {

		$this->add_control(
			'tabs_align',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Tabs Align','lustria-framework'),
				'options' => [
					'tabs-left' => esc_html__('Left', 'lustria-framework'),
					'tabs-center' => esc_html__('Center', 'lustria-framework'),
					'tabs-right' => esc_html__('Right', 'lustria-framework'),
				],
				'default' => 'tabs-left',
			]
		);
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'lustria-framework'),
				'options' => [
					'' => esc_html__('All', 'lustria-framework'),
					'sale' => esc_html__('Sale Off', 'lustria-framework'),
					'new-in' => esc_html__('New In', 'lustria-framework'),
					'featured' => esc_html__('Featured', 'lustria-framework'),
					'top-rated' => esc_html__('Top rated', 'lustria-framework'),
					'recent-review' => esc_html__('Recent review', 'lustria-framework'),
					'best-selling' => esc_html__('Best Selling', 'lustria-framework'),
					'products' => esc_html__('Narrow Products', 'lustria-framework')
				],
				'default' => ''
			]

		);

		$this->register_cat_controls();
		$this->register_product_ids_controls();
		$this->register_order_by_controls();
		$this->register_order_controls();
		$this->end_controls_section();
	}

	protected function register_cat_controls() {
		$this->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category','lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'lustria-framework'),
				'default' => '',
				'condition' => [
					'show!' => 'products',
				],
			]
		);
	}

	protected function register_product_ids_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'data_args' => array(
					'post_type' => 'product'
				),
				'label' => esc_html__('Narrow Products','lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Products', 'lustria-framework'),
				'default' => '',
				'condition' => [
					'show' => 'products',
				],
			]
		);

	}

	protected function register_order_by_controls() {
		$this->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'lustria-framework'),
				'description' => esc_html__('Select how to sort retrieved products.', 'lustria-framework'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'lustria-framework'),
					'price' => esc_html__('Price', 'lustria-framework'),
					'rand' => esc_html__('Random', 'lustria-framework'),
					'sales' => esc_html__('Sales', 'lustria-framework'),
				),
				'default' => 'date',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);


	}

	protected function register_order_controls() {
		$this->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'lustria-framework'),
				'description' => esc_html__('Select sorting order.', 'lustria-framework'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'lustria-framework'),
					'ASC' => esc_html__('Ascending', 'lustria-framework'),
				),
				'default' => 'DESC',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);
	}

	public function get_query_args($query_args, $atts)
	{
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		$query_args = array(
			'posts_per_page' => intval($atts['posts_per_page']),
			'offset' => intval($atts['offset']),
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
		);

		if(($atts['show'] != 'products')) {
			if (!empty($atts['cat'])) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'terms' =>  $atts['cat'],
					'field' => 'term_id',
					'operator' => 'IN'
				);
			}
		} else {
			$atts['cat'] = array();
			$atts['show_cate_filter'] = '';
		}
		switch($atts['show']) {
			case 'sale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
			case 'new-in':
				$query_args['orderby'] = 'date';
				$query_args['order'] = 'DESC';
				break;
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'top-rated':
				$query_args['meta_key'] = '_wc_average_rating';
				$query_args['orderby'] = 'meta_value_num';
				$query_args['order'] = 'DESC';
				$query_args['meta_query'] = WC()->query->get_meta_query();
				$query_args['tax_query'] = WC()->query->get_tax_query();
				break;
			case 'recent-review':
				add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
				break;
			case 'best-selling' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby'] = 'meta_value_num';
				break;
			case 'products':
				if ( ! empty( $atts['ids'] ) ) {
					$query_args['post__in'] = $atts['ids'];
					$query_args['posts_per_page'] = -1;
					$query_args['orderby'] = 'post__in';
				}
				break;
		}

		if (in_array($atts['show'],array('','sale','featured'))) {
			$query_args['order'] = $atts['order'];
			switch ( $atts['orderby'] ) {
				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					break;
				case 'rand' :
					$query_args['orderby']  = 'rand';
					break;
				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;
				default :
					$query_args['orderby']  = 'date';
			}
		}

		if ($atts['post_paging'] === 'none') {
			$query_args['no_found_rows'] = 1;
		}

		if ( $atts['show'] == 'recent-review' ) {
			remove_filter( 'posts_clauses', array( $this, 'order_by_comment_date_post_clauses' ) );
		}

		return apply_filters('g5_product_listing_query_args', $query_args, $atts);
	}

	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
		$this->register_style_price_section_controls();
		$this->register_style_price_sale_section_controls();
	}

	protected function register_style_title_section_controls() {
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__( 'Title', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .product-title',

			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'lustria-framework' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'title_color_tabs');

		$this->start_controls_tab( 'title_color_normal',
			[
				'label' => esc_html__( 'Normal', 'lustria-framework' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'lustria-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-title a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover',
			[
				'label' => esc_html__( 'Hover', 'lustria-framework' ),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'lustria-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-title a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function register_style_price_section_controls() {
		$this->start_controls_section(
			'section_design_price',
			[
				'label' => esc_html__( 'Price', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_spacing',
			[
				'label' => esc_html__( 'Spacing', 'lustria-framework' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'selector' => '{{WRAPPER}} ins .woocommerce-Price-amount.amount',

			]
		);


		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'lustria-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ins .woocommerce-Price-amount.amount' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_price_sale_section_controls() {
		$this->start_controls_section(
			'section_design_product_price_sale',
			[
				'label' => esc_html__( 'Price Sale', 'lustria-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_price_sale_typography',
				'selector' => '{{WRAPPER}} del .woocommerce-Price-amount.amount',

			]
		);


		$this->add_control(
			'price_sale_color',
			[
				'label' => esc_html__( 'Color', 'lustria-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} del .woocommerce-Price-amount.amount' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();


	}
}
