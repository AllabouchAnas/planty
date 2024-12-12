<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

abstract class G5P_Elements_Listing_Abstract extends UBE_Abstracts_Elements
{

	public $_atts = array();

	public $_query_args = array();

	public $_settings = array();

	public function prepare_display($atts = array(), $query_args = array(), $settings = array())
	{
		if ($atts['post_columns_gutter'] === null) {
			unset($atts['post_columns_gutter']);
		}

		$this->_atts = wp_parse_args($atts, array(
			'posts_per_page' => 6,
			'post_columns_gutter' => 30,
			'post_layout' => '',
			'post_paging' => 'none',
			'post_animation' => '',
			'cat' => '',
			'tag' => '',
			'ids' => '',
			'columns' => array(
				'xl' => 3,
				'lg' => '',
				'md' => '',
				'sm' => '',
				'xs' => '',
			),
			'show_cate_filter' => '',
			'category_filter_vertical' => false,

			'is_slider' => false,
			'slider_rows' => 1,
			'items' => 3,
			'slideBy' => 3,
			'autoplay' => false,
		));

		if(!empty($this->_atts['image_size']) && $this->_atts['image_size'] === 'full'){
			$this->_atts['image_ratio'] ='custom';
		}

		$this->_atts['posts_per_page'] = absint($this->_atts['posts_per_page']) ? absint($this->_atts['posts_per_page']) : 6;
		$this->_atts['post_columns_gutter'] = absint($this->_atts['post_columns_gutter']);

		if (!is_array($this->_atts['columns'])) {
			$this->_atts['columns'] = array(
				'xl' => $this->_atts['columns'],
				'lg' => '',
				'md' => '',
				'sm' => '',
				'xs' => ''
			);
		}

		$this->_atts['columns_xl'] = absint($this->_atts['columns']['xl']);
		$this->_atts['columns_lg'] = $this->_atts['columns']['lg'] == '' ? $this->_atts['columns_xl'] : absint($this->_atts['columns']['lg']);
		$this->_atts['columns_md'] = $this->_atts['columns']['md'] == '' ? $this->_atts['columns_lg'] : absint($this->_atts['columns']['md']);
		$this->_atts['columns_sm'] = $this->_atts['columns']['sm'] == '' ? $this->_atts['columns_md'] : absint($this->_atts['columns']['sm']);
		$this->_atts['columns'] = $this->_atts['columns']['xs'] == '' ? $this->_atts['columns_sm'] : absint($this->_atts['columns']['xs']);

		if (in_array($this->_atts['post_layout'], array('large-image', 'medium-image')) && $this->_atts['is_slider'] === false) {
			$this->_atts['columns_xl'] = $this->_atts['columns_lg'] = $this->_atts['columns_md'] = $this->_atts['columns_sm'] = $this->_atts['columns'] = 1;
		}

		$this->_atts['slider_rows'] = absint($this->_atts['slider_rows']) ? absint($this->_atts['slider_rows']) : 1;

		$this->prepare_settings($settings);

		if (!empty($this->_atts['tabs'])) {
			$this->prepare_tabs($query_args,$this->_atts);
		} else {
			$this->_query_args = $this->get_query_args($query_args,$this->_atts);
		}
	}

	public function get_query_args($query_args, $atts)
	{
		$query_args = wp_parse_args($query_args, array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page' => $this->_atts['posts_per_page'],

			'order' => isset($atts['order']) ? $atts['order'] : 'desc',
			'orderby' => isset($atts['orderby']) ? $atts['orderby'] : 'date',
			'meta_key' => ('meta_value' == $atts['orderby'] || 'meta_value_num' == $atts['orderby']) ? $atts['meta_key'] : ''
		));

		switch ( $atts['orderby'] ) {
			case 'menu_order':
				$query_args['orderby'] = 'menu_order title';
				break;
			case 'date':
				$query_args['orderby'] = 'date ID';
				break;
		}

		if ($atts['post_paging'] === 'none') {
			$query_args['no_found_rows'] = 1;
		}


		if (!empty($atts['cat'])) {
			$query_args['category__in'] = array_map('absint',$atts['cat']);
		}

		if (!empty($atts['tag'])) {
			$query_args['tag__in'] = array_map('absint',$atts['tag']);
		}

		if ( $atts['time_filter'] !== 'none' ) {
			$query_args['date_query'] = $this ->get_time_filter_query( $atts['time_filter'] );
		}

		if ( ! empty( $atts['ids']) ) {
			$query_args['post__in'] = array_map('absint',$atts['ids']);
		}

		return apply_filters('g5p_element_listing_query_args', $query_args, $atts);
	}

	public function prepare_settings($settings)
	{
		$this->_settings = wp_parse_args($settings, array(
			'post_columns_gutter' => $this->_atts['post_columns_gutter'],
			'post_layout' => $this->_atts['post_layout'],
			'post_paging' => $this->_atts['post_paging'],
			'post_columns' => array(
				'xl' => $this->_atts['columns_xl'],
				'lg' => $this->_atts['columns_lg'],
				'md' => $this->_atts['columns_md'],
				'sm' => $this->_atts['columns_sm'],
				'' => $this->_atts['columns'],
			),
			'post_animation' => $this->_atts['post_animation'],
		));

		$this->_settings['image_ratio'] = isset($this->_atts['image_ratio']) ? $this->_atts['image_ratio'] : '';



		if ('on' === $this->_atts['show_cate_filter']) {
			$this->_settings['category_filter_enable'] = true;
			$this->_settings['category_filter_vertical'] = false;
		}

		if($this->_atts['post_layout'] == 'list') {
			$this->_atts['columns_xl'] = $this->_atts['columns_lg'] = $this->_atts['columns_md'] = $this->_atts['columns_sm'] = $this->_atts['columns'] = 1;
		}

		if ($this->_atts['is_slider']) {
			$this->_settings['post_paging'] = 'none';
			$carousel_class = 'gsf-slider-container item-gutter-' . $this->_atts['post_columns_gutter'];
			if ($this->_atts['slider_rows'] == 1) {
				$owl_args = array(
					'items' => $this->_atts['columns_xl'],
					'margin' => 0,
					'slideBy' => $this->_atts['columns_xl'],
					'dots' => ($this->_atts['dots'] === 'on') ? true : false,
					'nav' => ($this->_atts['nav'] === 'on') ? true : false,
					'responsive' => array(
						'1200' => array(
							'items' => $this->_atts['columns_xl'],
							'slideBy' => $this->_atts['columns_xl'],
						),
						'992' => array(
							'items' => $this->_atts['columns_lg'],
							'slideBy' => $this->_atts['columns_lg'],
						),
						'768' => array(
							'items' => $this->_atts['columns_md'],
							'slideBy' => $this->_atts['columns_md'],
						),
						'576' => array(
							'items' => $this->_atts['columns_sm'],
							'slideBy' => $this->_atts['columns_sm'],
						),
						'0' => array(
							'items' => $this->_atts['columns'],
							'slideBy' => $this->_atts['columns'],
						)
					),
					'autoHeight' => true,
					'autoplay' => ($this->_atts['autoplay'] === 'on') ? true : false,
					'autoplayTimeout' => intval($this->_atts['autoplay_timeout']),
				);
			} else {
				$this->_settings['itemSelector'] = '.owl-item-inner';
				$owl_args = array(
					'items' => 1,
					'margin' => 0,
					'slideBy' => 1,
					'dots' => ($this->_atts['dots'] === 'on') ? true : false,
					'nav' => ($this->_atts['nav'] === 'on') ? true : false,
					'autoHeight' => true,
					'autoplay' => ($this->_atts['autoplay'] === 'on') ? true : false,
					'autoplayTimeout' => intval($this->_atts['autoplay_timeout']),
				);
				$this->_settings['carousel_rows'] = array(
					'rows' => intval($this->_atts['slider_rows']),
					'items_show' => intval($this->_atts['slider_rows']) * ($this->_atts['columns_xl']),
				);
			}

			if ($this->_atts['nav'] === 'on') {
				$carousel_class .= ' ' . $this->_atts['nav_position'] . ' ' . $this->_atts['nav_style'] . ' ' . $this->_atts['nav_size'] . ' ' . $this->_atts['nav_hover_scheme'] . ' ' . $this->_atts['nav_hover_style'];
			}
			if (!empty($carousel_class)) {
				$this->_settings['carousel_class'] = $carousel_class;
			}
			$this->_settings['carousel'] = $owl_args;
		}
	}

	public function prepare_tabs($query_args,$atts) {
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();
		if (!empty($this->_atts['tabs'])) {
			$tabs = (array)$this->_atts['tabs'];
			$tabs_args = array();
			foreach ($tabs as $tab) {
				$tab_args = array(
					'posts_per_page' => $atts['posts_per_page'],
					'no_found_rows' => true,
					'post_status' => 'publish',
					'post_type' => 'product',
					'tax_query'      => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'term_taxonomy_id',
							'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
							'operator' => 'NOT IN',
						)
					),
					'post_parent'  => 0
				);
				if (!empty($tab['cat'])) {
					$tab_args['tax_query'][] = array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=>  $tab['cat'],
						'field' 		=> 'term_id',
						'operator' 		=> 'IN'
					);
				}
				switch($tab['show']) {
					case 'sale':
						$product_ids_on_sale    = wc_get_product_ids_on_sale();
						$product_ids_on_sale[]  = 0;
						$tab_args['post__in'] = $product_ids_on_sale;
						break;
					case 'new-in':
						$tab_args['orderby'] = 'date';
						$tab_args['order'] = 'DESC';
						break;
					case 'featured':
						$tab_args['tax_query'][] = array(
							'taxonomy' => 'product_visibility',
							'field'    => 'term_taxonomy_id',
							'terms'    => $product_visibility_term_ids['featured'],
						);
						break;
					case 'top-rated':
						$tab_args['meta_key'] = '_wc_average_rating';
						$tab_args['orderby'] = 'meta_value_num';
						$tab_args['order'] = 'DESC';
						$tab_args['meta_query'] = WC()->query->get_meta_query();
						$tab_args['tax_query'] = WC()->query->get_tax_query();
						break;
					case 'recent-review':
						add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
						break;
					case 'best-selling' :
						$tab_args['meta_key'] = 'total_sales';
						$tab_args['orderby'] = 'meta_value_num';
						break;
				}
				if (in_array($tab['show'],array('','sale','featured'))) {
					$tab_args['order'] = $tab['order'];
					switch ( $tab['orderby'] ) {
						case 'price' :
							$tab_args['meta_key'] = '_price';
							$tab_args['orderby']  = 'meta_value_num';
							break;
						case 'rand' :
							$tab_args['orderby']  = 'rand';
							break;
						case 'sales' :
							$tab_args['meta_key'] = 'total_sales';
							$tab_args['orderby']  = 'meta_value_num';
							break;
						default :
							$tab_args['orderby']  = 'date';
					}
				}

				if($tab['show'] =='recent-review' ){
					remove_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' )  );
				}
				$tab_args = array(
					'title' => $tab['tab_title'],
					'query_args' => $tab_args
				);
				$tabs_args[] = $tab_args;
			}
			$this->_settings['tabs'] = $tabs_args;
		}
	}


	protected function register_slider_section_controls()
	{
		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__('Slider Options', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control('slider_rows', [
			'label' => esc_html__('Slide Rows', 'lustria-framework'),
			'type' => Controls_Manager::NUMBER,
			'default' => 1,
		]);

		$this->add_control(
			'dots',
			[
				'label' => esc_html__('Show Pagination', 'lustria-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'lustria-framework'),
				'label_off' => esc_html__('Hide', 'lustria-framework'),
				'return_value' => 'on',
				'default' => 'on',
			]
		);


		$this->add_control(
			'nav',
			[
				'label' => esc_html__('Show Navigation', 'lustria-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'lustria-framework'),
				'label_off' => esc_html__('Hide', 'lustria-framework'),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'nav_position',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Navigation Position', 'lustria-framework'),
				'options' => array(
					'nav-center' => esc_html__('Center', 'lustria-framework'),
					'nav-bottom-center' => esc_html__('Bottom Center', 'lustria-framework'),
				),
				'default' => 'nav-top-right',
				'condition' => [
					'nav' => 'on',
				],
			]
		);

		$this->add_control(
			'nav_style',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Navigation Style', 'lustria-framework'),
				'options' => array(
					'nav-style-01' => esc_html__('Style 01', 'lustria-framework'),
					'nav-style-02' => esc_html__('Style 02', 'lustria-framework'),
					'nav-style-03' => esc_html__('Style 03', 'lustria-framework'),
				),
				'default' => 'nav-style-02',
				'condition' => [
					'nav' => 'on',
				],
			]
		);

		$this->add_control(
			'nav_size',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Navigation Size', 'lustria-framework'),
				'options' => array(
					'nav-small' => esc_html__('Small', 'lustria-framework'),
					'nav-normal' => esc_html__('Normal', 'lustria-framework'),
					'nav-large' => esc_html__('Large', 'lustria-framework'),
				),
				'default' => 'nav-normal',
				'condition' => [
					'nav' => 'on',
				],
			]
		);

		$this->add_control(
			'nav_hover_style',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Navigation Hover Style', 'lustria-framework'),
				'options' => array(
					'nav-hover-outline' => esc_html__('Style 01', 'lustria-framework'),
					'nav-hover-bg' => esc_html__('Style 02', 'lustria-framework'),
				),
				'default' => 'nav-hover-outline',
				'condition' => [
					'nav' => 'on',
				],
			]
		);

		$this->add_control(
			'nav_hover_scheme',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Navigation Hover Scheme', 'lustria-framework'),
				'options' => array(
					'hover-dark' => esc_html__('Dark', 'lustria-framework'),
					'hover-light' => esc_html__('Light', 'lustria-framework'),
					'hover-accent' => esc_html__('Accent', 'lustria-framework'),
				),
				'default' => 'hover-dark',
				'condition' => [
					'nav' => 'on',
				],
			]
		);


		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__('Autoplay Enable', 'lustria-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'lustria-framework'),
				'label_off' => esc_html__('Disable', 'lustria-framework'),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'autoplay_timeout',
			[
				'label' => esc_html__('Autoplay Timeout', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'autoplay' => 'on',
				],
			]);

		$this->end_controls_section();
	}

	protected function register_image_size_section_controls()
	{
		$this->start_controls_section(
			'section_image_size',
			[
				'label' => esc_html__('Image Size', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__('Image size', 'lustria-framework'),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 300x400).', 'lustria-framework'),
				'default' => 'medium',
				'condition' => [
					'post_layout!' => ['masonry'],
				],
			]
		);


		$this->add_control(
			'post_image_ratio_width',
			[
				'label' => esc_html__('Image Ratio Width', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'post_layout',
							'operator' => '!=',
							'value' => 'masonry'
						],
						[
							'name' => 'image_size',
							'operator' => '=',
							'value' => 'full'
						]
					]
				],
			]
		);

		$this->add_control(
			'post_image_ratio_height',
			[
				'label' => esc_html__('Image Ratio Height', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'post_layout',
							'operator' => '!=',
							'value' => 'masonry'
						],
						[
							'name' => 'image_size',
							'operator' => '=',
							'value' => 'full'
						]
					]
				],
			]
		);

		$this->add_control(
			'post_image_width',
			[
				'label' => esc_html__('Image Width', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '400',
				'condition' => [
					'post_layout' => ['masonry'],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_post_count_control()
	{
		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__('Posts Per Page', 'lustria-framework'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter number of posts per page you want to display. Default 10', 'lustria-framework'),
				'default' => '',
			]
		);
	}

	protected function register_cat_controls()
	{
		$this->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'label' => esc_html__('Narrow Category', 'lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'lustria-framework'),
				'default' => '',
			]
		);

	}

	protected function register_tag_controls()
	{
		$this->add_control(
			'tag',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'post_tag'
				),
				'label' => esc_html__('Narrow Tag', 'lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter tags by names to narrow output.', 'lustria-framework'),
				'default' => '',
			]
		);
	}

	protected function register_post_ids_controls()
	{
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'label' => esc_html__('Narrow Post', 'lustria-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Posts', 'lustria-framework'),
				'default' => '',
			]
		);
	}

	protected function register_order_by_controls()
	{
		$this->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'lustria-framework'),
				'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'lustria-framework'),
				'options' => array(
					'date' => esc_html__('Date', 'lustria-framework'),
					'ID' => esc_html__('Order by post ID', 'lustria-framework'),
					'author' => esc_html__('Author', 'lustria-framework'),
					'title' => esc_html__('Title', 'lustria-framework'),
					'modified' => esc_html__('Last modified date', 'lustria-framework'),
					'parent' => esc_html__('Post/page parent ID', 'lustria-framework'),
					'comment_count' => esc_html__('Number of comments', 'lustria-framework'),
					'menu_order' => esc_html__('Menu order/Page Order', 'lustria-framework'),
					'meta_value' => esc_html__('Meta value', 'lustria-framework'),
					'meta_value_num' => esc_html__('Meta value number', 'lustria-framework'),
					'rand' => esc_html__('Random order', 'lustria-framework'),
				),
				'default' => 'date',
			]
		);
	}

	protected function register_time_filter_controls()
	{
		$this->add_control(
			'time_filter',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Time Filter', 'lustria-framework'),
				'options' => array(
					'none' => esc_html__('No Filter', 'lustria-framework'),
					'today' => esc_html__('Today Posts', 'lustria-framework'),
					'yesterday' => esc_html__('Today + Yesterday Posts', 'lustria-framework'),
					'week' => esc_html__('This Week Posts', 'lustria-framework'),
					'month' => esc_html__('This Month Posts', 'lustria-framework'),
					'year' => esc_html__('This Year Posts', 'lustria-framework')
				),
				'default' => 'none',
			]
		);
	}

	protected function register_meta_key_controls()
	{
		$this->add_control(
			'meta_key',
			[
				'label' => esc_html__('Meta key', 'lustria-framework'),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__('Input meta key for grid ordering', 'lustria-framework'),
				'default' => '',
				'condition' => [
					'orderby' => ['meta_value', 'meta_value_num'],
				],
			]
		);
	}

	protected function register_cate_filter_controls()
	{
		$this->add_control(
			'show_cate_filter',
			[
				'label' => esc_html__('Category Filter', 'lustria-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'lustria-framework'),
				'label_off' => esc_html__('Hide', 'lustria-framework'),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'cate_filter_align',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Category Filter Align', 'lustria-framework'),
				'options' => $this->get_category_filter_align(),
				'default' => 'cate-filter-left',
				'condition' => [
					'show_cate_filter' => 'on',
				],
			]
		);
	}

	protected function register_columns_responsive_section_controls($condition = array())
	{
		$this->start_controls_section(
			'section_responsive',
			[
				'label' => esc_html__('Responsive', 'lustria-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => $condition,
			]
		);
		$this->add_control(
			'columns',
			[
				'type' => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label' => esc_html__('Columns', 'lustria-framework'),
				'data_type' => 'select',
				'options' => $this->get_post_columns(),
				'default' => '3',
				'condition' => $condition,
			]
		);

		$this->end_controls_section();
	}

	protected function register_post_animation_controls()
	{
		$this->add_control(
			'post_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Animation', 'lustria-framework'),
				'description' => esc_html__('Specify your post animation', 'lustria-framework'),
				'options' => $this->get_post_animation(),
				'default' => 'none',
			]
		);
	}

	protected function register_post_paging_controls()
	{
		$this->add_control(
			'post_paging',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Post Paging', 'lustria-framework'),
				'description' => esc_html__('Specify your post paging mode.', 'lustria-framework'),
				'options' => $this->get_post_paging(),
				'default' => 'none',
			]
		);
	}

	public function get_post_columns($inherit = false)
	{

		$config = apply_filters('g5p_options_post_columns', array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6'
		));

		if ($inherit) {
			$config = array(
					'' => esc_html__('Inherit', 'lustria-framework')
				) + $config;
		}

		return $config;
	}

	public function get_category_filter_align()
	{
		return apply_filters('g5core_category_filter_align', array(
			'cate-filter-left' => esc_html__('Left', 'lustria-framework'),
			'cate-filter-center' => esc_html__('Center', 'lustria-framework'),
			'cate-filter-right' => esc_html__('Right', 'lustria-framework'),
		));
	}

	public function get_post_paging()
	{
		$config = apply_filters('g5p_elementor_post_paging', array(
			'none' => array(
				'label' => esc_html__('No Pagination', 'lustria-framework'),
			),
			'pagination-ajax' => array(
				'label' => esc_html__('Ajax - Pagination', 'lustria-framework'),
			),
			'next-prev' => array(
				'label' => esc_html__('Ajax - Next Prev', 'lustria-framework'),
			),
			'load-more' => array(
				'label' => esc_html__('Ajax - Load More', 'lustria-framework'),
			),
			'infinite-scroll' => array(
				'label' => esc_html__('Ajax - Infinite Scroll', 'lustria-framework'),
			),
		));


		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;

	}

	public function get_post_animation()
	{
		$config = apply_filters('g5p_elementor_post_animation', array(
			'none' => esc_html__('None', 'lustria-framework'),
			'top-to-bottom' => esc_html__('Top to bottom', 'lustria-framework'),
			'bottom-to-top' => esc_html__('Bottom to top', 'lustria-framework'),
			'left-to-right' => esc_html__('Left to right', 'lustria-framework'),
			'right-to-left' => esc_html__('Right to left', 'lustria-framework'),
			'appear' => esc_html__('Appear from center', 'lustria-framework')
		));

		return $config;

	}

	protected function register_layout_controls()
	{
		$this->add_control(
			'post_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Post Layout', 'lustria-framework'),
				'description' => esc_html__('Specify your layout', 'lustria-framework'),
				'options' => $this->get_config_post_layout(),
				'default' => 'grid',
			]
		);
	}

	protected function register_columns_gutter_controls($condition = array())
	{
		$this->add_control(
			'post_columns_gutter',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Columns Gutter', 'lustria-framework'),
				'description' => esc_html__('Specify your horizontal space between item.', 'lustria-framework'),
				'options' => $this->get_post_columns_gutter(),
				'default' => '30',
				'condition' => $condition,
			]
		);
	}

	protected function register_order_controls()
	{
		$this->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'lustria-framework'),
				'description' => esc_html__('Select sorting order.', 'lustria-framework'),
				'options' => array(
					'DESC' => esc_html__('Descending', 'lustria-framework'),
					'ASC' => esc_html__('Ascending', 'lustria-framework'),
				),
				'default' => 'DESC',
			]
		);
	}

	public function get_post_columns_gutter()
	{
		$config = apply_filters('gsf_options_post_columns_gutter', array(
			'none' => esc_html__('None', 'lustria-framework'),
			'10' => '10px',
			'20' => '20px',
			'30' => '30px',
			'40' => '40px',
			'50' => '50px',
			'60' => '60px',
			'70' => '70px'
		));

		return $config;
	}

	public function get_time_filter_query($time_filter = null)
	{
		$date_query = array();

		switch ($time_filter) {
			// Today posts
			case 'today':
				$date_query = array(
					array(
						'after' => '1 day ago', // should not escaped because will be passed to WP_Query
					),
				);
				break;
			// Today + Yesterday posts
			case 'yesterday':
				$date_query = array(
					array(
						'after' => '2 day ago', // should not escaped because will be passed to WP_Query
					),
				);
				break;
			// Week posts
			case 'week':
				$date_query = array(
					array(
						'after' => '1 week ago', // should not escaped because will be passed to WP_Query
					),
				);
				break;
			// Month posts
			case 'month':
				$date_query = array(
					array(
						'after' => '1 month ago', // should not escaped because will be passed to WP_Query
					),
				);
				break;
			// Year posts
			case 'year':
				$date_query = array(
					array(
						'after' => '1 year ago', // should not escaped because will be passed to WP_Query
					),
				);
				break;
		}
		return $date_query;
	}
}
