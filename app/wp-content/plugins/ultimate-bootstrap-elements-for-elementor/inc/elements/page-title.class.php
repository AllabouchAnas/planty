<?php
if (!defined('ABSPATH')) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;

class UBE_Element_Page_Title extends UBE_Abstracts_Elements
{
	public function get_name()
	{
		return 'ube-page-title';
	}

	public function get_title()
	{
		return esc_html__('Page Title', 'ube');
	}

	public function get_ube_icon()
	{
		return 'eicon-site-title';
	}

	public function get_ube_keywords()
	{
		return array('page title','ube' , 'ube page title');
	}

	protected function register_controls()
	{
		$this->register_wrapper_style_section_controls();
		$this->register_page_title_style_section_controls();
		$this->register_page_subtitle_style_section_controls();

	}


	protected function register_wrapper_style_section_controls() {
		$this->start_controls_section(
			'section_wrapper_style',
			[
				'label' => esc_html__( 'Wrapper', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'page_title_align',
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
				'default' => '',
			]
		);

		$this->end_controls_section();

	}

	protected function register_page_title_style_section_controls() {
		$this->start_controls_section(
			'section_page_title_style',
			[
				'label' => esc_html__( 'Page Title', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'page_title_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-main-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'page_title_typography',
				'selector' => '{{WRAPPER}} .page-main-title',
			]
		);

		$this->add_responsive_control(
			'page_title_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .page-main-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function register_page_subtitle_style_section_controls() {
		$this->start_controls_section(
			'section_page_subtitle_style',
			[
				'label' => esc_html__( 'Page Sub Title', 'ube' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sub_page_title_color',
			[
				'label' => esc_html__('Color', 'ube'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_page_title_typography',
				'selector' => '{{WRAPPER}} .page-sub-title',
			]
		);

		$this->add_responsive_control(
			'sub_page_title_margin',
			[
				'label' => esc_html__('Margin', 'ube'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .page-sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	public function get_page_title()
	{
		$page_title = '';
		if (is_home()) {
			$page_title = esc_html__('Blog', 'ube');
		}elseif (is_singular('product')) {
			$page_title = esc_html__('Shop', 'ube');
		} elseif (is_singular('post')) {
			$page_title = esc_html__('Blog', 'ube');
		} elseif (is_404()) {
			$page_title = esc_html__('Page Not Found', 'ube');
		} elseif (is_category() || is_tax()) {
			$page_title = single_term_title('', false);
		} elseif (is_tag()) {
			$page_title = single_tag_title(esc_html__("Tags: ", 'ube'), false);
		} elseif (is_search()) {
			$page_title = sprintf(esc_html__('Search Results For: %s', 'ube'), get_search_query());
		} elseif (is_day()) {
			$page_title = sprintf(esc_html__('Daily Archives: %s', 'ube'), get_the_date());
		} elseif (is_month()) {
			$page_title = sprintf(esc_html__('Monthly Archives: %s', 'ube'), get_the_date(_x('F Y', 'monthly archives date format', 'ube')));
		} elseif (is_year()) {
			$page_title = sprintf(esc_html__('Yearly Archives: %s', 'ube'), get_the_date(_x('Y', 'yearly archives date format', 'ube')));
		} elseif (is_author()) {
			$page_title = sprintf(esc_html__('Author: %s', 'ube'), get_the_author());
		} elseif (is_tax('post_format', 'post-format-aside')) {
			$page_title = esc_html__('Asides', 'ube');
		} elseif (is_tax('post_format', 'post-format-gallery')) {
			$page_title = esc_html__('Galleries', 'ube');
		} elseif (is_tax('post_format', 'post-format-image')) {
			$page_title = esc_html__('Images', 'ube');
		} elseif (is_tax('post_format', 'post-format-video')) {
			$page_title = esc_html__('Videos', 'ube');
		} elseif (is_tax('post_format', 'post-format-quote')) {
			$page_title = esc_html__('Quotes', 'ube');
		} elseif (is_tax('post_format', 'post-format-link')) {
			$page_title = esc_html__('Links', 'ube');
		} elseif (is_tax('post_format', 'post-format-status')) {
			$page_title = esc_html__('Statuses', 'ube');
		} elseif (is_tax('post_format', 'post-format-audio')) {
			$page_title = esc_html__('Audios', 'ube');
		} elseif (is_tax('post_format', 'post-format-chat')) {
			$page_title = esc_html__('Chats', 'ube');
		} elseif (is_singular()) {
			$page_title = get_the_title();
		}
		$page_title = apply_filters('ube_page_title', $page_title);

		return $page_title;
	}

	public function get_page_subtitle() {
		$page_subtitle = '';

		if (is_category() || is_tax()) {
			$term = get_queried_object();
			if ($term && property_exists($term, 'term_id')) {
				$term_description = strip_tags(term_description());
				if (!empty($term_description)) {
					$page_subtitle = $term_description;
				}
			}
		}

		$page_subtitle = apply_filters('ube_page_subtitle', $page_subtitle);
		return $page_subtitle;
	}

	public function render()
	{
		ube_get_template('elements/page-title.php', array(
			'element' => $this
		));
	}
}