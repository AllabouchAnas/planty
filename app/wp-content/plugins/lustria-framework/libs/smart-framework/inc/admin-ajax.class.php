<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('GSF_Inc_Admin_Ajax')) {
	class GSF_Inc_Admin_Ajax {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function addAjaxAction() {
			add_action('wp_ajax_gsf_get_attachment_id', array($this, 'getAttachmentId'));
			add_action('wp_ajax_gsf_get_posts', array($this, 'getPosts'));
			add_action('wp_ajax_gsf_get_fonts', array($this, 'getFonts'));
			add_action('wp_ajax_gsf_get_font_icons', array($this, 'getFontIcons'));
			add_action('wp_ajax_gsf_get_section_config', array($this, 'getSectionConfig'));
		}

		/**
		 * Get Attachment Id by Url
		 */
		public function getAttachmentId()
		{
			$url = isset($_GET['url']) ? $_GET['url'] : '';
			if (empty($url)) {
				echo 0;
			} else {
				echo GSF()->helper()->getAttachmentIdByUrl($url);
			}
			die();
		}

		/**
		 * Get post
		 */
		public function getPosts()
		{
			add_filter('posts_where', array($this, 'titleLikePostsWhere'), 10, 2);
			$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
			$post_type = isset($_GET['post_type']) ? $_GET['post_type'] : 'post';
			$search_query = array(
				'post_title_like' => $keyword,
				'order'           => 'ASC',
				'orderby'         => 'post_title',
				'post_type'       => $post_type,
				'post_status'     => 'publish',
				'posts_per_page'  => 10,
			);

			$search = new WP_Query($search_query);
			$ret = array();

			foreach ($search->posts as $post) {
				$ret[] = array(
					'value' => $post->ID,
					'label' => $post->post_title
				);
			}
			echo json_encode($ret);
			die();
		}

		public function titleLikePostsWhere($where, &$wp_query)
		{
			global $wpdb;
			if ($search_term = $wp_query->get('post_title_like')) {
				$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\'';
			}

			return $where;
		}

		/**
		 * Get font collection
		 */
		public function getFonts()
		{
			$webfonts = json_decode(GSF()->file()->getContents(GSF()->pluginDir('assets/webfonts.json')), true);
			$standard_fonts = array(
				"Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
				"'Arial Black', Gadget, sans-serif"                    => "Arial Black, Gadget, sans-serif",
				"'Bookman Old Style', serif"                           => "Bookman Old Style, serif",
				"'Comic Sans MS', cursive"                             => "Comic Sans MS, cursive",
				"Courier, monospace"                                   => "Courier, monospace",
				"Garamond, serif"                                      => "Garamond, serif",
				"Georgia, serif"                                       => "Georgia, serif",
				"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
				"'Lucida Console', Monaco, monospace"                  => "Lucida Console, Monaco, monospace",
				"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "Lucida Sans Unicode, 'Lucida Grande', sans-serif",
				"'MS Sans Serif', Geneva, sans-serif"                  => "MS Sans Serif, Geneva, sans-serif",
				"'MS Serif', 'New York', sans-serif"                   => "MS Serif, New York, sans-serif",
				"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "Palatino Linotype, Book Antiqua, Palatino, serif",
				"Tahoma,Geneva, sans-serif"                            => "Tahoma,Geneva, sans-serif",
				"'Times New Roman', Times,serif"                       => "Times New Roman, Times,serif",
				"'Trebuchet MS', Helvetica, sans-serif"                => "Trebuchet MS, Helvetica, sans-serif",
				"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
			);

			$fonts = array(
				'basic'  => array(
					'label' => esc_html__('Standard Fonts', 'lustria-framework'),
				),
				'google' => array(
					'label' => esc_html__('Google Webfonts', 'lustria-framework'),
				),
			);
			foreach ($standard_fonts as $font_name => $font_label) {
				$fonts['basic']['items'][] = array(
					'kind'         => 'basic',
					'family'       => $font_name,
					'family_label' => $font_label,
					'variants'     => array(
						'400',
						'400italic',
						'700',
						'700italic',
					),
					'subsets'      => array(),
				);
			}
			$variants = array();
			$varName = $fontWeight = $fontStyle = '';
			foreach ($webfonts['items'] as $font) {
				$variants = isset($font['variants']) ? $font['variants'] : array();
				foreach ($variants as &$varName) {
					$fontWeight = str_replace('italic', '', $varName);
					$fontStyle = substr($varName, strlen($fontWeight));
					$fontWeight = ($fontWeight === '') || ($fontWeight === 'regular') ? '400' : $fontWeight;
					$varName = $fontWeight . $fontStyle;
				}
				$fonts['google']['items'][] = array(
					'kind'         => 'google',
					'family'       => isset($font['family']) ? "'" . $font['family'] . "'" : '',
					'family_label' => isset($font['family']) ? $font['family'] : '',
					'variants'     => $variants,
					'subsets'      => isset($font['subsets']) ? $font['subsets'] : array(),
				);
			}
			echo json_encode(apply_filters('gsf_font_list', $fonts));
			die();

		}

		public function getFontIcons() {
			$nonce = $_POST['nonce'];
			if (!wp_verify_nonce($nonce, GSF()->helper()->getNonceVerifyKey())) {
				die();
			}
			echo json_encode(GSF()->helper()->getFontIcons());
			die();
		}
	}
}