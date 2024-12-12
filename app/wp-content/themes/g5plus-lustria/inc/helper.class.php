<?php

use Elementor\Plugin;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('G5Plus_Lustria_Helper')) {
	class G5Plus_Lustria_Helper
	{
		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Get template
		 * @param $slug
		 * @param $args
		 */
		public function getTemplate($slug, $args = array())
		{
			$template_name = "templates/{$slug}.php";
			$located = trailingslashit(get_stylesheet_directory()) . $template_name;

			if (!file_exists($located)) {
				$located = trailingslashit(get_template_directory()) . $template_name;
			}

			$action_args = array(
				'located'       => $located,
			);

			if (!file_exists($action_args['located'])) {
				_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $template_name), '1.0');
				return;
			}

			if ( ! empty( $args ) && is_array( $args ) ) {
				if ( isset( $args['action_args'] ) ) {
					unset( $args['action_args'] );
				}
				extract( $args ); // @codingStandardsIgnoreLine
			}
			include($action_args['located']);
		}

		/**
		 * Get plugin assets url
		 * @param $file
		 * @return string
		 */
		public function getAssetUrl($file)
		{
			if (!file_exists(G5Plus_Lustria()->themeDir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
				$ext = explode('.', $file);
				$ext = end($ext);
				$normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
				if ($normal_file != $file) {
					$normal_file = untrailingslashit($normal_file) . ".{$ext}";
					if (file_exists(G5Plus_Lustria()->themeDir($normal_file))) {
						return G5Plus_Lustria()->themeUrl(untrailingslashit($normal_file));
					}
				}
			}
			return G5Plus_Lustria()->themeUrl(untrailingslashit($file));
		}

		public function assetsHandle($handle = '')
		{
			return apply_filters('gsf_assets_prefix', 'gsf_') . $handle;
		}


		/**
		 * Truncate Text
		 *
		 * @param $text
		 * @param $length
		 * @return mixed|string
		 */
		public function truncateText($text, $length)
		{
			$text = strip_tags($text, '<img />');
			$length = abs((int)$length);
			if (strlen($text) > $length) {
				$text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
			}
			return $text;
		}

		/**
		 * Get Social Networks Config
		 *
		 * @return array
		 */
		public function &get_social_networks()
		{
			$social_networks = G5Plus_Lustria()->options()->get_social_networks();
			$configs = array();
			if (is_array($social_networks)) {
				foreach ($social_networks as $social_network) {
					$configs[$social_network['social_id']] = $social_network;
				}
			}
			return $configs;
		}

		public function getSkinClass($skin_id, $echo = false)
		{
			if (empty($skin_id)) return array();
			$classes = array(
				'gf-skin',
				$skin_id
			);

			// Enqueue style.css
			if ($echo) {
				wp_enqueue_style(G5Plus_Lustria()->helper()->assetsHandle("skin-{$skin_id}"));
			}
			return $classes;
		}

		/**
		 * Get Page Title
		 *
		 * @return string|void
		 */
		public function get_page_title()
		{
			$page_title = '';
			if (is_home()) {
				$page_title = esc_html__('Blog', 'g5plus-lustria');
			} elseif (is_singular('product')) {
				$page_title = esc_html__('Shop', 'g5plus-lustria');
			} elseif (is_singular('post')) {
				$page_title = esc_html__('Blog', 'g5plus-lustria');
				/*global $show_post_title;
				$show_post_title = true;
				$page_title = get_the_title();*/
			} elseif (is_404()) {
				$page_title = esc_html__('Page Not Found', 'g5plus-lustria');
			} elseif (is_category() || is_tax()) {
				$page_title = single_term_title('', false);
			} elseif (is_tag()) {
				$page_title = single_tag_title(esc_html__("Tags: ", 'g5plus-lustria'), false);
			} elseif (is_search()) {
				$page_title = sprintf(esc_html__('Search Results For: %s', 'g5plus-lustria'), get_search_query());
			} elseif (is_day()) {
				$page_title = sprintf(esc_html__('Daily Archives: %s', 'g5plus-lustria'), get_the_date());
			} elseif (is_month()) {
				$page_title = sprintf(esc_html__('Monthly Archives: %s', 'g5plus-lustria'), get_the_date(_x('F Y', 'monthly archives date format', 'g5plus-lustria')));
			} elseif (is_year()) {
				$page_title = sprintf(esc_html__('Yearly Archives: %s', 'g5plus-lustria'), get_the_date(_x('Y', 'yearly archives date format', 'g5plus-lustria')));
			} elseif (is_author()) {
				$page_title = sprintf(esc_html__('Author: %s', 'g5plus-lustria'), get_the_author());
			} elseif (is_tax('post_format', 'post-format-aside')) {
				$page_title = esc_html__('Asides', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-gallery')) {
				$page_title = esc_html__('Galleries', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-image')) {
				$page_title = esc_html__('Images', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-video')) {
				$page_title = esc_html__('Videos', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-quote')) {
				$page_title = esc_html__('Quotes', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-link')) {
				$page_title = esc_html__('Links', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-status')) {
				$page_title = esc_html__('Statuses', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-audio')) {
				$page_title = esc_html__('Audios', 'g5plus-lustria');
			} elseif (is_tax('post_format', 'post-format-chat')) {
				$page_title = esc_html__('Chats', 'g5plus-lustria');
			} elseif (is_singular()) {
				$page_title = get_the_title();
			}

			if (is_category() || is_tax()) {
				$term = get_queried_object();
				if ($term && property_exists($term, 'term_id')) {
					$term_id = $term->term_id;
					$page_title_content = G5Plus_Lustria()->termMeta()->get_page_title_content($term_id);
					if ($page_title_content !== '') {
						$page_title = $page_title_content;
					}
				}

			}

			if (is_singular()) {
				$page_title_content = G5Plus_Lustria()->metaBox()->get_page_title_content();
				if ($page_title_content !== '') {
					$page_title = $page_title_content;
				}
			}
			$page_title = apply_filters('g5plus_page_title', $page_title);
			return $page_title;
		}

		/**
		 * Get Responsive Bootstrap columns
		 *
		 * @param $columns
		 * @return string
		 */
		public function get_bootstrap_columns($columns = array())
		{
			$default = array(
				'xl' => 2,
				'lg' => 2,
				'md' => 1,
				'sm' => 1,
				'' => 1,
			);
			$columns = wp_parse_args($columns, $default);
			$classes = array();
			foreach ($columns as $key => $value) {
				if ($key === 0) {
					$key = '';
				}
				if ($key !== '') {
					$key = "-{$key}";
				}
				if ($value > 0) {
					if ($value == 5) {
						$classes[$key] = "col{$key}-12-5";
					} else {
						$classes[$key] = "col{$key}-" . (12 / $value);
					}
				}
			}
			return implode(' ', array_filter($classes));
		}

		public function getCSSAnimation($css_animation)
		{
			$output = '';
			if ('' !== $css_animation && 'none' !== $css_animation) {
				$output = ' gf_animate_when_almost_visible ' . $css_animation;
			}

			return $output;
		}


		public function elementor_before_get_builder_content($document)
		{
			$data = $document->get_elements_data();
			if ( !empty( $data ) ) {
				Elementor\Plugin::$instance->frontend->start_excerpt_flag('');
			}
		}

		public function elementor_after_get_builder_content()
		{
			Elementor\Plugin::$instance->frontend->end_excerpt_flag('');
		}

		public function elementor_get_builder_content_for_display($id)
		{
			if (!class_exists('Elementor\Plugin')) {
				return false;
			}
			$document = Elementor\Plugin::$instance->documents->get_doc_for_frontend($id);

			if (!$document || !$document->is_built_with_elementor()) {
				return false;
			}

			add_action('elementor/frontend/before_get_builder_content', array($this, 'elementor_before_get_builder_content'));
			add_action('elementor/frontend/get_builder_content', array($this, 'elementor_after_get_builder_content'));

			$content = Elementor\Plugin::$instance->frontend->get_builder_content_for_display($id, false);

			remove_action('elementor/frontend/before_get_builder_content', array($this, 'elementor_before_get_builder_content'));
			remove_action('elementor/frontend/get_builder_content', array($this, 'elementor_after_get_builder_content'));

			return $content;
		}

		/**
		 * Display Content Block
		 *
		 * @param $id
		 * @return mixed|string|void
		 */

		public function content_block($id, $post_type = null)
		{
			if (empty($id)) return '';
			if ($post_type === null) {
				$post_type = 'gsf_content';
			}

			if (function_exists('icl_object_id')) {
				$icl_object_id = icl_object_id($id, $post_type, false);
				if ($icl_object_id !== false) {
					$id = $icl_object_id;
				}
			}

			$content = $this->elementor_get_builder_content_for_display($id);
			if ($content === false) {
				$content = get_post_field('post_content', $id);
				if ((function_exists('vc_is_page_editable') && vc_is_page_editable()) || (class_exists('Elementor\Plugin') && Elementor\Plugin::$instance->preview->is_preview_mode())) {
					$content = do_shortcode($content);
				} else {
					if (class_exists('Elementor\Plugin')) {
						Elementor\Plugin::$instance->frontend->remove_content_filter();
					}
					$content = apply_filters('the_content', $content);
					if (class_exists('Elementor\Plugin')) {
						Elementor\Plugin::$instance->frontend->add_content_filter();
					}
				}
				$content = str_replace(']]>', ']]&gt;', $content);
			}
			return $content;
		}

		public function shortCodeContent($content, $echo = true)
		{
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			if (!$echo) {
				return $content;
			}
			printf('%s', $content);
		}

		public function getCurrentPreset()
		{
			if (function_exists('G5P')) {
				return G5P()->helper()->getCurrentPreset();
			}
			return '';
		}

		/**
		 * Body Class
		 *
		 * @param $classes
		 * @return array
		 */
		public function body_class($classes)
		{
			global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
			if ($is_lynx) $classes[] = 'lynx';
			elseif ($is_gecko) $classes[] = 'gecko';
			elseif ($is_opera) $classes[] = 'opera';
			elseif ($is_NS4) $classes[] = 'ns4';
			elseif ($is_safari) $classes[] = 'safari';
			elseif ($is_chrome) $classes[] = 'chrome';
			elseif ($is_IE) $classes[] = 'ie';
			else $classes[] = 'unknown';
			if ($is_iphone) $classes[] = 'iphone';

			/**
			 * Page Transitions
			 */
			$action = isset($_GET['action']) ? $_GET['action'] : '';
			$page_transition = G5Plus_Lustria()->options()->get_page_transition();
			if (($page_transition === 'on') && ($action != 'yith-woocompare-view-table')) {
				$classes[] = 'page-transitions';
			}

			if ($action === 'yith-woocompare-view-table') {
				$classes[] = 'woocommerce-compare-page';
			}

			/**
			 * Page Loading
			 */
			$loading_animation = G5Plus_Lustria()->options()->get_loading_animation();
			if (!empty($loading_animation)) {
				$classes[] = 'page-loading';
			}

			/**
			 * Main Layout
			 */
			$main_layout = G5Plus_Lustria()->options()->get_main_layout();
			if ($main_layout !== 'wide') {
				$classes[] = $main_layout;
			}

			$header_enable = G5Plus_Lustria()->options()->get_header_enable();
			$header_layout = G5Plus_Lustria()->options()->get_header_layout();

			if ($header_enable === 'on') {
				if (in_array($header_layout, array('header-8', 'header-9', 'header-11', 'header-12'))) {
					if (in_array($header_layout, array('header-11', 'header-12'))) {
						$pre_class = 'header-menu-';
						$classes[] = 'header-menu-vertical';
					} else {
						$pre_class = 'header-';
					}
					$classes[] = 'header-vertical';
					if (in_array($header_layout, array('header-9', 'header-12'))) {
						$classes[] = $pre_class . 'left';
					} elseif (in_array($header_layout, array('header-8', 'header-11'))) {
						$classes[] = $pre_class . 'right';
					}
				}
			}


			/**
			 * RTL Mode
			 */
			$rtl_enable = G5Plus_Lustria()->options()->get_rtl_enable();
			if ($rtl_enable === 'on' || isset($_GET['RTL']) || is_rtl()) {
				$classes[] = 'rtl';
			}

			/**
			 * Single layout
			 */
			if (is_singular('post')) {
				$single_post_layout = G5Plus_Lustria()->options()->get_single_post_layout();
				$classes[] = "single-post-{$single_post_layout}";
			}
			if (is_singular()) {
				$custom_page_css_class = G5Plus_Lustria()->metaBox()->get_css_class();
				if (!empty($custom_page_css_class)) {
					$classes[] = $custom_page_css_class;
				}

				$has_sidebar = G5Plus_Lustria()->options()->get_sidebar_layout();
				$sidebar = G5Plus_Lustria()->cache()->get_sidebar();
				if ($has_sidebar === 'none' || !is_active_sidebar($sidebar)) {
					$classes[] = 'no-sidebar';
				} else {
					$classes[] = 'has-sidebar';
				}

				$used_vc = $this->page_used_vc();
				if ($used_vc) {
					$classes[] = 'used-vc';
				}
			}
			return $classes;
		}

		/**
		 * Excerpt
		 *
		 * @param $excerpt
		 * @return string
		 */
		public function excerpt($excerpt)
		{
			return wp_strip_all_tags($excerpt);
		}

		/**
		 * Extra Class
		 *
		 * @return array
		 */
		public function extra_class()
		{
			$extra_class = array(
				'heading-color',
				'disable-color',
				'border-color',
				'body-font',
				'primary-font',
				'bg-transparent',
				'gf-sticky'
			);
			/*for ($i = 0; $i <= 20;$i ++) {
				$spacing = $i * 5;
				$extra_class[] = "pd-top-$spacing";
				$extra_class[] = "sm-pd-top-$spacing";
				$extra_class[] = "xs-pd-top-$spacing";
				$extra_class[] = "pd-bottom-$spacing";
				$extra_class[] = "sm-pd-bottom-$spacing";
				$extra_class[] = "xs-pd-bottom-$spacing";
				$extra_class[] = "mg-top-$spacing";
				$extra_class[] = "sm-mg-top-$spacing";
				$extra_class[] = "xs-mg-top-$spacing";
				$extra_class[] = "mg-bottom-$spacing";
				$extra_class[] = "sm-mg-bottom-$spacing";
				$extra_class[] = "xs-mg-bottom-$spacing";
			}*/
			return $extra_class;
		}

		/**
		 * Move cat_count into tag A
		 *
		 * @param $links
		 * @param $args
		 * @return mixed
		 */
		public function cat_count_span($links, $args)
		{
			if (!isset($args['taxonomy'])) {
				$links = str_replace('(', '<span class="count">(', $links);
				$links = str_replace(')', ')</span>', $links);
			}
			return $links;
		}

		/**
		 * Move archive_count into tag A
		 *
		 * @param $links
		 * @return mixed
		 */
		public function archive_count_span($links)
		{
			$links = str_replace('&nbsp;(', '<span class="count">(', $links);
			$links = str_replace(')', ')</span>', $links);
			return $links;
		}

		/**
		 * Set Onepage menu
		 * *******************************************************
		 */
		public function main_menu_one_page($args)
		{
			if (isset($args['theme_location']) && !in_array($args['theme_location'], apply_filters('xmenu_location_apply', array('primary', 'mobile')))) {
				return $args;
			}
			$is_one_page = G5Plus_Lustria()->metaBox()->get_is_one_page();
			if ($is_one_page === 'on') {
				$args['menu_class'] .= ' menu-one-page';
			}
			return $args;
		}

		public function post_thumbnail_lazyLoad($html, $post_id, $post_image_id)
		{
			$html = preg_replace('/src=/', 'data-original=', $html);
			$html = preg_replace('/srcset=/', 'data-original-set=', $html);
			return $html;
		}

		public function content_lazyLoad($content)
		{
			return preg_replace_callback('/<\s*img[^>]+[^>]+>/i', array($this, 'content_lazyLoad_callback'), $content);
		}

		public function content_lazyLoad_callback($img_match)
		{
			$img_replace = preg_replace('/src=/', 'src="#" data-original=', $img_match[0]);
			$img_replace = preg_replace('/srcset=/', 'data-original-set=', $img_replace);
			$img_replace = preg_replace('/class\s*=\s*"/i', 'class="gf-lazy ', $img_replace);
			return $img_replace;

		}


		function the_post_thumbnail($size = 'post-thumbnail', $attr = '')
		{
			the_post_thumbnail($size, $attr);
		}

		public function get_metro_image_size($image_size_base = '300x300', $layout_ratio = '1x1', $columns_gutter = 0)
		{
			global $_wp_additional_image_sizes;
			$image_width = 0;
			$image_height = 0;
			$layout_ratio_width = 1;
			$layout_ratio_height = 1;
			$columns_gutter = intval($columns_gutter);
			$width = 0;
			$height = 0;

			$image_size_base_dimension = $this->get_image_dimension($image_size_base);
			if ($image_size_base_dimension) {
				$image_width = $image_size_base_dimension['width'];
				$image_height = $image_size_base_dimension['height'];
			}

			if (preg_match('/x/', $layout_ratio)) {
				$layout_ratio = preg_split('/x/', $layout_ratio);
				$layout_ratio_width = isset($layout_ratio[0]) ? floatval($layout_ratio[0]) : 0;
				$layout_ratio_height = isset($layout_ratio[1]) ? floatval($layout_ratio[1]) : 0;
			}

			if (($image_width > 0) && ($image_height > 0)) {
				$width = ($layout_ratio_width - 1) * $columns_gutter + $image_width * $layout_ratio_width;
				$height = ($layout_ratio_height - 1) * $columns_gutter + $image_height * $layout_ratio_height;
			}

			if (($width > 0) && ($height > 0)) {
				return "{$width}x{$height}";
			}

			return $image_size_base;
		}

		public function get_metro_image_ratio($image_ratio_base = '1x1', $layout_ratio = '1x1')
		{
			$layout_ratio_width = 1;
			$layout_ratio_height = 1;

			$image_ratio_base_width = 1;
			$image_ratio_base_height = 1;


			if (preg_match('/x/', $layout_ratio)) {
				$layout_ratio = preg_split('/x/', $layout_ratio);
				$layout_ratio_width = isset($layout_ratio[0]) ? floatval($layout_ratio[0]) : 0;
				$layout_ratio_height = isset($layout_ratio[1]) ? floatval($layout_ratio[1]) : 0;
			}

			if (preg_match('/x/', $image_ratio_base)) {
				$image_ratio_base = preg_split('/x/', $image_ratio_base);
				$image_ratio_base_width = isset($image_ratio_base[0]) ? floatval($image_ratio_base[0]) : 0;
				$image_ratio_base_height = isset($image_ratio_base[1]) ? floatval($image_ratio_base[1]) : 0;
			}

			if (($layout_ratio_width > 0)
				&& ($layout_ratio_height > 0)
				&& ($image_ratio_base_width > 0)
				&& ($image_ratio_base_height > 0)) {
				$image_ratio_width = $image_ratio_base_width * $layout_ratio_width;
				$image_ratio_height = $image_ratio_base_height * $layout_ratio_height;
				return "{$image_ratio_width}x{$image_ratio_height}";
			}
			return $image_ratio_base;
		}

		public function get_image_dimension($image_size = 'thumbnail')
		{
			global $_wp_additional_image_sizes;
			$width = '';
			$height = '';
			if (preg_match('/x/', $image_size)) {
				$image_size = preg_split('/x/', $image_size);
				$width = $image_size[0];
				$height = $image_size[1];
			} elseif (in_array($image_size, array('thumbnail', 'medium', 'large'))) {
				$width = intval(get_option($image_size . '_size_w'));
				$height = intval(get_option($image_size . '_size_h'));
			} elseif (isset($_wp_additional_image_sizes[$image_size])) {
				$width = intval($_wp_additional_image_sizes[$image_size]['width']);
				$height = intval($_wp_additional_image_sizes[$image_size]['height']);
			}

			if ($width !== '' && $height !== '') {
				return array(
					'width' => $width,
					'height' => $height
				);
			}
			return false;
		}

		public function get_theme_options_url()
		{
			$url = '#';
			if (function_exists('G5P')) {
				$url = admin_url('admin.php?page=gsf_options');
			}
			return $url;
		}

		public function has_request_pagination_ajax()
		{
			return isset($_REQUEST['action']) && $_REQUEST['action'] === 'pagination_ajax';
		}

		public function get_header($name = null)
		{
			if (!$this->has_request_pagination_ajax()) {
				get_header($name);
			} else {
				get_header('ajax');
			}
		}

		public function get_footer($name = null)
		{
			if (!$this->has_request_pagination_ajax()) {
				get_footer($name);
			} else {
				get_footer('ajax');
			}
		}

		public function page_used_vc($post_id = null)
		{
			if (is_null($post_id)) {
				global $post;
			} elseif (intval($post_id)) {
				$post = get_post($post_id);
			} else {
				return false;
			}

			if (!$post || is_null($post) || is_wp_error($post)) {
				return false;
			}

			$result = false;
			if (class_exists('Vc_Manager')) {

				preg_match_all('/' . get_shortcode_regex() . '/s', $post->post_content, $matches, PREG_SET_ORDER);
				if (!empty($matches)) {

					foreach ($matches as $shortcode) {
						if (in_array($shortcode[2],array('vc_row','vc_section'))) {
							$result = true;
							break;
						}
					}
				}
			}
			return $result;
		}

		public function page_used_elementor($post_id = null)
		{
			if (!class_exists('Elementor\Plugin')) {
				return false;
			}
			if (is_null($post_id)) {
				$post_id = get_the_ID();
			}
			$document = Elementor\Plugin::$instance->documents->get($post_id);
			return ($document && $document->is_built_with_elementor());
		}

		public function get_content_block_ids()
		{
			$content_block_ids = array();

			$content_blocks = array(
				'page_title_content_block',
				'footer_content_block',
				'top_bar_content_block',
				'mobile_top_bar_content_block',
				'top_drawer_content_block'
			);

			if (is_404()) {
				$content_blocks[] = '404_content_block';
			}

			foreach ($content_blocks as $content_block) {
				$contentBlockId = G5Plus_Lustria()->options()->getOptions($content_block);
				if ($contentBlockId !== '') {
					if (function_exists('icl_object_id')) {
						$icl_object_id = icl_object_id($contentBlockId, 'gsf_content', false);
						if ($icl_object_id !== false) {
							$contentBlockId = $icl_object_id;
						}
					}
					$content_block_ids[] = $contentBlockId;
				}
			}


			$locations = get_nav_menu_locations();

			$page_menu = '';
			if (is_singular()) {
				$page_menu = G5Plus_Lustria()->metaBox()->get_page_menu();
			}

			if (!empty($page_menu)) {
				$locations[] = $page_menu;
			}

			foreach ($locations as $location) {
				$menu = wp_get_nav_menu_object($location);
				if (is_object($menu)) {
					$nav_items = wp_get_nav_menu_items($menu->term_id);
					foreach ((array)$nav_items as $nav_item) {
						if ('xmenu_mega' == $nav_item->object) {
							$object_id = $nav_item->object_id;
							if (function_exists('icl_object_id')) {
								$icl_object_id = icl_object_id($object_id, 'xmenu_mega', false);
								if ($icl_object_id !== false) {
									$object_id = $icl_object_id;
								}
							}
							$content_block_ids[] = $object_id;
						}
					}
				}
			}

			return array_unique($content_block_ids);
		}

	}
}