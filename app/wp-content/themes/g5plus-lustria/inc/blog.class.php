<?php
/**
 * Class Blog
 *
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Lustria_Blog')) {
	class G5Plus_Lustria_Blog
	{

		public $key_post_layout_settings = 'gf_post_layout_settings';

		private static $_instance;

		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}


		public function render_post_thumbnail_markup($args = array())
		{
			$defaults = array(
                'post_id'            => get_the_ID(),
                'image_size'         => 'full',
                'image_ratio'        => '',
                'placeholder_enable' => false,
                'first_image_enable' => false,
                'display_permalink'  => true,
                'image_mode'         => 'background',

			);
			$defaults = wp_parse_args($args, $defaults);
			G5Plus_Lustria()->helper()->getTemplate('loop/post-thumbnail', $defaults);
		}

		public function render_post_image_markup($args = array())
		{
            $defaults = array(
                'post_id'           => get_the_ID(),
                'image_id'          => '',
                'image_size'        => 'full',
                'image_ratio'       => '',
                'gallery_id'        => '',
                'is_single'         => false,
                'display_permalink' => true,
                'image_mode'        => 'background',
                'class'             => 'entry-thumbnail'
            );
			$defaults = wp_parse_args($args, $defaults);
			G5Plus_Lustria()->helper()->getTemplate('loop/post-image', $defaults);
		}

		public function get_image_sizes()
		{
			$image_sizes = array(
                'blog-widget'     => '100x100',
                'blog-large' => '840x470',
                'blog-large-full' => '1170x620',
			);
			return apply_filters('g5plus_image_sizes', $image_sizes);
		}

        public function pagination_markup() {
            $settings      = &$this->get_layout_settings();
            $post_paging   = $settings['post_paging'];
            $max_num_pages = G5Plus_Lustria()->query()->get_max_num_pages();
            $settingId = isset($settings['settingId']) ? $settings['settingId'] : mt_rand();
            $settings['settingId'] = $settingId;

            if (( ! isset( $_REQUEST['action'] ) || empty( $_REQUEST['action'] ) ) ) {
                G5Plus_Lustria()->custom_js()->addJsVariable(array(
                    'settings' => $settings,
                    'query'    => G5Plus_Lustria()->query()->get_ajax_query_vars()
                ), "gf_ajax_paginate_{$settingId}");
            }
            $post_paging_allow = array('pagination');
            if (function_exists('G5P')) {
                $post_paging_allow = array_keys(G5P()->settings()->get_post_paging_mode());
            }

            if ( ( $max_num_pages > 1 ) && ( $post_paging !== '' ) && ( $post_paging !== 'none' ) && in_array($post_paging,$post_paging_allow) ) {
                G5Plus_Lustria()->helper()->getTemplate("paging/{$post_paging}", array('settingId' => $settingId, 'isMainQuery' => isset($settings['isMainQuery'])));
            }
        }

		public function category_filter_markup()
		{
			$settings = &$this->get_layout_settings();
            $settingId = isset($settings['settingId']) ? $settings['settingId'] : mt_rand();
            $settings['settingId'] = $settingId;

            $pagenum_link = isset($settings['pagenum_link']) ? $settings['pagenum_link'] : html_entity_decode(get_pagenum_link());
            $settings['pagenum_link'] = $pagenum_link;

			if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
				G5Plus_Lustria()->custom_js()->addJsVariable(array(
					'settings' => $settings,
					'query'    => G5Plus_Lustria()->query()->get_ajax_query_vars()
				), "gf_ajax_paginate_{$settingId}");
			}
			G5Plus_Lustria()->helper()->getTemplate("loop/cat-filter", array(
			    'settingId' => $settingId,
                'pagenum_link' => $pagenum_link,
                'post_type' => $settings['post_type'],
                'taxonomy' => isset($settings['taxonomy']) ? $settings['taxonomy'] : 'category',
                'category_filter' => isset($settings['cat']) ? $settings['cat'] : '',
                'current_cat' => isset($settings['current_cat']) ? $settings['current_cat'] : -1,
                'filter_vertical' => isset($settings['category_filter_vertical']) ? $settings['category_filter_vertical'] : false,
            ));
		}

		public function tabs_markup() {
			$settings = &$this->get_layout_settings();
			$tabs = isset($settings['tabs']) ? $settings['tabs'] : array();
			unset($settings['tabs']);
			if (!isset($_REQUEST['action']) || empty($_REQUEST['action'])) {
				$index = 1;
				foreach ($tabs as &$tab) {
					$settingId = mt_rand();
					$query_args = $tab['query_args'];
					$tab['settingId'] = $settingId;
					if ($index === 1) {
						$settings['settingId'] = $settingId;
					}
					G5Plus_Lustria()->custom_js()->addJsVariable(array(
						'settings' => $settings,
						'query'    => G5Plus_Lustria()->query()->get_ajax_query_vars($query_args)
					), "gf_ajax_paginate_{$settingId}");
					$index++;
				}
			}
			G5Plus_Lustria()->helper()->getTemplate("loop/tabs", array('tabs' => $tabs));
		}


		/**
		 * Get Post Layout Settings
		 *
		 * @return mixed
		 */
		public function &get_layout_settings()
		{
			if (isset($GLOBALS[$this->key_post_layout_settings]) && is_array($GLOBALS[$this->key_post_layout_settings])) {
				return $GLOBALS[$this->key_post_layout_settings];
			}

			$GLOBALS[$this->key_post_layout_settings] = array(
				'post_layout'            => G5Plus_Lustria()->options()->get_post_layout(),
				'post_columns'           => array(
					'xl' => intval(G5Plus_Lustria()->options()->get_post_columns()),
					'lg' => intval(G5Plus_Lustria()->options()->get_post_columns_md()),
					'md' => intval(G5Plus_Lustria()->options()->get_post_columns_sm()),
					'sm' => intval(G5Plus_Lustria()->options()->get_post_columns_xs()),
                    '' => intval(G5Plus_Lustria()->options()->get_post_columns_mb()),
				),
				'post_columns_gutter'    => intval(G5Plus_Lustria()->options()->get_post_columns_gutter()),
				'image_size'        => G5Plus_Lustria()->options()->get_post_image_size(),
				'post_paging'            => G5Plus_Lustria()->options()->get_post_paging(),
				'post_animation'         => G5Plus_Lustria()->options()->get_post_animation(),
				'itemSelector'           => 'article',
				'category_filter_enable' => false,
                'post_type' => 'post'
			);
			return $GLOBALS[$this->key_post_layout_settings];
		}

		public function unset_layout_settings()
		{
			unset($GLOBALS[$this->key_post_layout_settings]);
		}

		/**
		 * Set Post Layout Settings
		 *
		 * @param $args
		 */
		public function set_layout_settings($args)
		{
			$post_settings = &$this->get_layout_settings();
			$post_settings = wp_parse_args($args, $post_settings);
		}

		public function archive_markup($query_args = null, $settings = null)
		{
            if (isset($_REQUEST['settings']) && !isset($query_args)) {
                $settings = wp_parse_args($_REQUEST['settings'],$settings);
            }

		    if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

			if (!isset($query_args)) {
				$settings['isMainQuery'] = true;
			}

			if (isset($settings) && (sizeof($settings) > 0)) {
				$this->set_layout_settings($settings);
			}

			G5Plus_Lustria()->query()->query_posts($query_args);


			if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
				add_action('g5plus_before_archive_wrapper', array($this, 'category_filter_markup'));
			}

			if (isset($settings['tabs'])) {
				add_action('g5plus_before_archive_wrapper', array($this, 'tabs_markup'));
			}

			G5Plus_Lustria()->helper()->getTemplate('archive');

			if (isset($settings['tabs'])) {
				remove_action('g5plus_before_archive_wrapper', array($this, 'tabs_markup'));
			}

			if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
				remove_action('g5plus_before_archive_wrapper', array($this, 'category_filter_markup'));
			}

			if (isset($settings) && (sizeof($settings) > 0)) {
				$this->unset_layout_settings();
			}

			G5Plus_Lustria()->query()->reset_query();

		}

		public function cat_badge_markup($args = array())
		{
			$default = array(
				'highlight' => false
			);
			$args = wp_parse_args($args, $default);
			G5Plus_Lustria()->helper()->getTemplate('loop/cat-badge', $args);
		}


		public function archive_ads_markup($args)
		{
			G5Plus_Lustria()->helper()->getTemplate('loop/ads', $args);
		}

		public function get_layout_matrix($layout = 'large-image')
		{
			$post_settings = &G5Plus_Lustria()->blog()->get_layout_settings();
			$post_type = isset($post_settings['post_type']) ? $post_settings['post_type'] : 'post';
			$columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
				'xl' => 2,
				'lg' => 2,
				'md' => 1,
				'sm' => 1,
                '' => 1
			);
			$image_size = isset($post_settings['image_size']) ? $post_settings['image_size'] : 'medium';
            $placeholder_enable = 'on' === G5Plus_Lustria()->options()->get_default_thumbnail_placeholder_enable() ? true : false;
            $first_image_enable = 'on' === G5Plus_Lustria()->options()->get_first_image_as_post_thumbnail() ? true : false;
            $has_col_5 = in_array(5, $columns);
			$columns_class = G5Plus_Lustria()->helper()->get_bootstrap_columns($columns);
			$columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 30);
			$matrix = apply_filters('g5plus_post_layout_matrix',array(
			    'post' => array(
                    'large-image'    => array(
                        'placeholder_enable' => $placeholder_enable,
                        'first_image_enable' => $first_image_enable,
                        'layout'             => array(
                            array('columns' => 'col-12','template' => 'large-image')
                        ),
						'image_size' => $image_size
                    ),
                    'grid'           => array(
                        'placeholder_enable' => $placeholder_enable,
                        'first_image_enable' => $first_image_enable,
                        'columns_gutter' => $columns_gutter,
                        'layout'         => array(
                            array('columns' => $columns_class, 'template' => 'grid')
                        ),
						'image_size' => $image_size,
                    ),
                    'medium-image'           => array(
                        'placeholder_enable' => $placeholder_enable,
                        'first_image_enable' => $first_image_enable,
                        'layout'             => array(
                            array('columns' => 'col-12','template' => 'medium-image' ),
                        ),
                        'image_size' => $image_size,
                    ),
                    'masonry'        => array(
                        'columns_gutter' => $columns_gutter,
                        'first_image_enable' => $first_image_enable,
                        'isotope'        => array(
                            'itemSelector' => 'article',
                            'layoutMode'   => 'masonry',
                        ),
                        'layout'         => array(
                            array('columns' => $columns_class, 'template' => 'grid'),
                        )
                    ),
                )
			),$columns_class,$columns_gutter,$columns);
            if($has_col_5) {
                unset($matrix['post']['grid']['isotope']);
                unset($matrix['post']['masonry']['isotope']);
            }
            if (!isset($matrix[$post_type][$layout])) return $matrix['post']['large-image'];
			return $matrix[$post_type][$layout];
		}
		public function get_list_comments_args($args = array())
		{
			// Default arguments for listing comments.
			$defaults = array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 100,
				'callback'    => 'g5plus_comments_callback'
			);
			// Filter default arguments to enable developers to change it. also return it.
			return apply_filters('g5plus_list_comments_args', wp_parse_args($args, $defaults));
		}

		public function get_comments_form_args($args = array())
		{
			$commenter = wp_get_current_commenter();
			$req = get_option('require_name_email');
			$aria_req = ($req ? " aria-required='true'" : '');
			$html_req = ($req ? " required='required'" : '');
			$html5 = true;
			$fields = array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__('Full Name', 'g5plus-lustria') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input placeholder="' . esc_attr__('Full Name', 'g5plus-lustria') . '" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('Email Address', 'g5plus-lustria') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input placeholder="' . esc_attr__('Email Address', 'g5plus-lustria') . '" id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req . ' /></p>',
			);


			$defaults = array(
				'fields'             => $fields,
				'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'g5plus-lustria') . '</label> <textarea placeholder="' . esc_attr__('Comment', 'g5plus-lustria') . '" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
				'title_reply_before' => '<h4 class="gf-heading-title comments-title" id="reply-title"><span>',
				'title_reply_after'  => '</span></h4>',
				'class_submit'       => 'btn btn-lg btn-black'
			);

			// Filter default arguments to enable developers to change it. also return it.
			return apply_filters('g5plus_comments_form_args', wp_parse_args($args, $defaults));
		}

		public function link_pages() {
            wp_link_pages(array(
                'before' => '<div class="gsf-page-links"><span class="gsf-page-links-title">' . esc_html__('Pages', 'g5plus-lustria') . '</span>',
                'after' => '</div>',
                'link_before' => '<span class="gsf-page-link">',
                'link_after' => '</span>',
            ));
        }
	}
}