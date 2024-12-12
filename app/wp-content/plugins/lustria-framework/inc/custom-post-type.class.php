<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Inc_Custom_Post_Type')) {
	class G5P_Inc_Custom_Post_Type
	{

		/**
		 * Content Block Post type
		 *
		 * @var string
		 */
		private $content_block_post_type = 'gsf_content';

		/**
		 * Content Block Taxonomy
		 *
		 * @var string
		 */
		private $content_block_taxonomy = 'gsf_content_cat';

		/**
		 * Template Post type
		 *
		 * @var string
		 */
		private $template_post_type = 'gsf_template';

		/**
		 * Template Taxonomy
		 *
		 * @var string
		 */
		private $template_taxonomy = 'gsf_template_cat';


		/**
		 * Mega Menu Post type
		 *
		 * @var string
		 */
		private $xmenu_post_type = 'xmenu_mega';

		/*
		 * loader instances
		 */
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init()
		{
			// register post-type
			add_filter('gsf_register_post_type', array($this, 'register_post_type'));
			// register taxonomy
			add_filter('gsf_register_taxonomy', array($this, 'register_taxonomy'));

			// add filter category
			add_action('restrict_manage_posts', array($this, 'add_category_filter'));
			add_filter('parse_query', array($this, 'add_category_filter_query'));

			add_filter('single_template', array($this, 'single_template'));

			add_action( 'template_redirect', array( $this, 'change_page_setting' ) );

			add_filter('g5dev_template_post_type',array($this,'change_template_post_type'));

			add_filter('g5dev_template_category',array($this,'change_template_category'));

		}

		public function change_template_post_type() {
			return $this->get_template_post_type();
		}

		public function change_template_category() {
			return $this->get_template_taxonomy();
		}

		/**
		 * Get Content Block Post Type
		 *
		 * @return string
		 */
		public function get_content_block_post_type()
		{
			return $this->content_block_post_type;
		}

		/**
		 * Get Content Block Taxonomy
		 *
		 * @return string
		 */
		public function get_content_block_taxonomy()
		{
			return $this->content_block_taxonomy;
		}

		/**
		 * Get Template Post Type
		 *
		 * @return string
		 */
		public function get_template_post_type()
		{
			return $this->template_post_type;
		}

		/**
		 * Get Template Taxonomy
		 *
		 * @return string
		 */
		public function get_template_taxonomy()
		{
			return $this->template_taxonomy;
		}

		public function get_xmenu_post_type()
		{
			return $this->xmenu_post_type;
		}


		/**
		 * Register Post Type
		 *
		 * @param $post_types
		 * @return mixed
		 */
		public function register_post_type($post_types)
		{
			// Post type Content Block
			$post_types [$this->content_block_post_type] = array(
				'label' => esc_html__('Content Block', 'lustria-framework'),
				'menu_icon' => 'dashicons-editor-table',
				'menu_position' => 35,
				'public' => is_user_logged_in() ? true : false,
				'publicly_queryable' => is_user_logged_in() ? true : false,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'supports' => array(
					'title',
					'editor',
					'author',
					'revisions'
				)
			);
			return $post_types;
		}

		/**
		 * Register Taxonomies
		 *
		 * @param $taxonomies
		 * @return mixed
		 */
		public function register_taxonomy($taxonomies)
		{
			// content block
			$taxonomies[$this->content_block_taxonomy] = array(
				'post_type' => $this->content_block_post_type,
				'label' => esc_html__('Categories', 'lustria-framework'),
				'name' => esc_html__('Content Block Categories', 'lustria-framework'),
				'singular_name' => esc_html__('Category', 'lustria-framework'),
				'public' => false,
				'show_ui' => true,
				'show_admin_column' => true,
				'show_in_nav_menus' => false,
			);

			return $taxonomies;
		}

		public function add_category_filter()
		{
			global $typenow;
			$categories = $this->get_filter_categories();
			foreach ($categories as $category) {
				$post_type = $category['post_type'];
				$taxonomy = $category['taxonomy'];
				if ($typenow === $post_type) {
					$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
					$info_taxonomy = get_taxonomy($taxonomy);
					wp_dropdown_categories(array(
						'show_option_all' => sprintf(esc_html__('Show All %s', 'lustria-framework'), $info_taxonomy->label),
						'taxonomy' => $taxonomy,
						'name' => $taxonomy,
						'orderby' => 'name',
						'selected' => $selected,
						'show_count' => true,
						'hide_empty' => true,
						'hide_if_empty' => true
					));
				}
			}
		}

		public function add_category_filter_query($query)
		{
			global $pagenow;
			$categories = $this->get_filter_categories();
			$q_vars = &$query->query_vars;
			foreach ($categories as $category) {
				$post_type = $category['post_type'];
				$taxonomy = $category['taxonomy'];

				if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
					$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
					$q_vars[$taxonomy] = $term->slug;
				}
			}
		}

		private function get_filter_categories()
		{
			$args = array(
				array(
					'post_type' => $this->content_block_post_type,
					'taxonomy' => $this->content_block_taxonomy
				)
			);
			return $args;
		}

		public function single_template($single_template)
		{
			global $post;
			if (in_array($post->post_type, array($this->content_block_post_type, $this->template_post_type))) {
				$single_template = G5P()->pluginDir("/inc/templates/single-{$post->post_type}.php");
			}
			return $single_template;
		}

		public function change_page_setting() {
			global $post;
			if (isset($post->post_type) && in_array($post->post_type,array($this->content_block_post_type,$this->template_post_type,$this->xmenu_post_type,'elementor_library'))) {
				$options = &GSF()->adminThemeOption()->getOptions(G5P()->getOptionName());
				$options['sidebar_layout'] = 'none';
				$options['content_padding'] = array('left' => '', 'right' => '', 'top' => '50', 'bottom' => '50');
				$options['content_full_width'] = 'on';
			}

		}
	}
}