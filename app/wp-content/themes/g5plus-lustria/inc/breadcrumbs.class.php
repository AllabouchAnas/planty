<?php
/**
 * Breadcrumb Class
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if (!class_exists('G5Plus_Lustria_Breadcrumbs')) {
	class G5Plus_Lustria_Breadcrumbs
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
		 * Current post object
		 *
		 * @var array|null|WP_Post
		 */
		private $post;


		/**
		 * The Html Markup
		 *
		 * @var string
		 */
		private $html_markup;


		/**
		 * Prefix for breadcrumb
		 *
		 * @var string
		 */
		private $home_prefix;

		/**
		 * Separator between item
		 *
		 * @var string
		 */
		private $separator;


		/**
		 * Show post type archive?
		 *
		 * @var bool
		 */
		private $show_post_type_archive;

		/**
		 * Show term in breadcrumb
		 *
		 * @var bool
		 */
		private $show_terms;

		/**
		 * Label for home link
		 *
		 * @var string
		 */
		private $home_label;


		/**
		 * Prefix For Tag
		 *
		 * @var string
		 */
		private $tag_archive_prefix;

		/**
		 * Prefix for search page
		 *
		 * @var string
		 */
		private $search_prefix;


		/**
		 * Prefix for error page
		 *
		 * @var string
		 */
		private $error_prefix;

		/**
		 * Blog Page Title
		 *
		 * @var string
		 */
		private $blog_label;


		public function init()
		{
			$this->post = get_post(get_queried_object_id());

			$default = array(
				'home_prefix' => '',
				'separator' => '>',
                'show_post_type_archive' => G5Plus_Lustria()->options()->get_breadcrumb_show_post_type_archive() === 'on',
                'show_terms' => G5Plus_Lustria()->options()->get_breadcrumb_show_categories() === 'on',
				'home_label' => esc_html__('Home', 'g5plus-lustria'),
				'blog_label' => esc_html__('Blog', 'g5plus-lustria'),
				'tag_archive_prefix' => esc_html__('Tag:', 'g5plus-lustria'),
				'search_prefix' => esc_html__('Search:', 'g5plus-lustria'),
				'error_prefix' => esc_html__('Page Not Found', 'g5plus-lustria')
			);

			$args = apply_filters('g5plus_breadcrumbs_options', $default);

			$default = wp_parse_args($args, $default);

			$this->home_prefix = isset($default['home_prefix']) ? $default['home_prefix'] : '';
			$this->separator = isset($default['separator']) ? $default['separator'] : '';
			$this->show_post_type_archive = isset($default['show_post_type_archive']) ? $default['show_post_type_archive'] : false;
			$this->show_terms = isset($default['show_terms']) ? $default['show_terms'] : false;
			$this->home_label = isset($default['home_label']) ? $default['home_label'] : esc_html__('Home', 'g5plus-lustria');
			$this->blog_label = isset($default['blog_label']) ? $default['blog_label'] : esc_html__('Blog', 'g5plus-lustria');
			$this->tag_archive_prefix = isset($default['tag_archive_prefix']) ? $default['tag_archive_prefix'] : esc_html__('Tag:', 'g5plus-lustria');
			$this->search_prefix = isset($default['search_prefix']) ? $default['search_prefix'] : esc_html__('Search:', 'g5plus-lustria');
			$this->error_prefix = isset($default['error_prefix']) ? $default['error_prefix'] : esc_html__('Page Not Found', 'g5plus-lustria');

		}

		public function get_breadcrumbs()
		{
		    $breadcrumb_enable = G5Plus_Lustria()->options()->get_breadcrumb_enable();
		    if ($breadcrumb_enable != 'on') return;
			$this->init();
			$options = get_option('wpseo_internallinks');
			if (function_exists('yoast_breadcrumb') && $options && ($options['breadcrumbs-enable'] === true)) {
				ob_start();
				yoast_breadcrumb();
				$this->html_markup = ob_get_clean();
			} else {
				$this->prepare_breadcrumb_html();
			}

			$this->wrap_breadcrumbs();
			$this->output_breadcrumbs_html();
		}

		private function prepare_breadcrumb_html()
		{
			// Add home prefix
			$this->html_markup = $this->get_breadcrumb_prefix();

			// Add home link
			$this->html_markup .= $this->get_breadcrumb_home();

			// Woocommerce path prefix
			if (class_exists('WooCommerce') && ((is_woocommerce() && is_archive() && !is_shop()) || is_cart() || is_checkout() || is_account_page())) {
				$this->html_markup .= $this->get_woocommerce_shop_page();
			}

			// bbPress path prefix
			if (class_exists('bbPress') && is_bbpress() && !bbp_is_forum_archive()) {
				$this->html_markup .= $this->get_bbpress_main_archive_page();
			}

			// single post, page, etc
			if (is_singular()) {
				// display archive link for post type
				if (isset($this->post->post_type) && get_post_type_archive_link($this->post->post_type) && $this->show_post_type_archive) {
					$this->html_markup .= $this->get_post_type_archive();

				}

				// If the post doesn't have parents.
				if (isset($this->post->post_parent) && ($this->post->post_parent === 0)) {
					$this->html_markup .= $this->get_post_terms();
				} // If there are parents; mostly for pages.
				else {
					$this->html_markup .= $this->get_post_ancestors();
				}

				$this->html_markup .= $this->get_breadcrumb_leaf_markup();
			} else {
				// Blog page is a dedicated page.
				if ( is_home() && ! is_front_page() ) {
					$posts_page         = get_option( 'page_for_posts' );
					$posts_page_title   = get_the_title( $posts_page );
					$this->html_markup .= $this->get_single_breadcrumb_markup( $posts_page_title );
				}

				// Custom post types archives.
				if ( is_post_type_archive() ) {
					$this->html_markup .= $this->get_post_type_archive( false );

					// Search on custom post type (e.g. Woocommerce).
					if ( is_search() ) {
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'search' );
					}
				} // Taxonomy Archives.
				elseif ( is_tax() || is_tag() || is_category() ) {
					if ( is_tag() ) { // If we have a tag archive, add the tag prefix.
						$this->html_markup .= $this->tag_archive_prefix;
					}
					$this->html_markup .= $this->get_taxonomies();
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'term' );
				} // Date Archives.
				elseif ( is_date() ) {
					global $wp_locale;
					// Set variables.
					$year = get_the_date('Y');
					// Year Archive, only is a leaf.
					if ( is_year() ) {
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'year' );
					} // Month Archive, needs year link and month leaf.
					elseif ( is_month() ) {
						$this->html_markup .= $this->get_single_breadcrumb_markup( $year, get_year_link( $year ) );
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'month' );
					} // Day Archive, needs year and month link and day leaf.
					elseif ( is_day() ) {
						$month      = get_the_date('m');
						$month_name = $wp_locale->get_month( $month );
						$this->html_markup .= $this->get_single_breadcrumb_markup( $year, get_year_link( $year ) );
						$this->html_markup .= $this->get_single_breadcrumb_markup( $month_name, get_month_link( $year, $month ) );
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'day' );
					}
				} // Author Archives.
				elseif ( is_author() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'author' );
				} // Search Page.
				elseif ( is_search() ) {
					$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'search' );
				} // 404 Page.
				elseif ( is_404() ) {
					// Special treatment for Events Calendar to avoid 404 messages on list view.
					if ( ( function_exists( 'tribe_is_event' ) && tribe_is_event() ) ) {
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'events' );
					} // Default case.
					else {
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( '404' );
					}
				} // bbPress.
				elseif ( class_exists( 'bbPress' ) ) {
					// Search Page.
					if ( bbp_is_search() ) {
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'bbpress_search' );
					} // User page.
					elseif ( bbp_is_single_user() ) {
						$this->html_markup .= $this->get_breadcrumb_leaf_markup( 'bbpress_user' );
					}
				}
			}


		}

		private function wrap_breadcrumbs()
		{
			if ($this->html_markup) {
				$this->html_markup = '<ul class="gf-breadcrumbs">' . $this->html_markup . '</ul>';
			}

		}

		private function output_breadcrumbs_html()
		{
			echo wp_kses_post($this->html_markup);
		}

		private function get_breadcrumb_prefix()
		{
			$output = '';
			if (!is_front_page() && $this->home_prefix) {
				$output = '<li class="breadcrumb-prefix">' . $this->home_prefix . '</li>';
			}
			return $output;
		}


		private function get_breadcrumb_home()
		{
			if (!is_front_page()) {
				$output = $this->get_single_breadcrumb_markup($this->home_label, get_home_url('/'));;
			} else {
				$output = $this->get_single_breadcrumb_markup($this->blog_label);
			}

			return $output;
		}

		private function get_woocommerce_shop_page($linked = true)
		{
			$post_type = 'product';
			$post_type_object = get_post_type_object($post_type);
			$shop_page_markup = '';
			$link = '';
			if (isset($post_type_object) && class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_account_page())) {
				// Get shop page id and then its name.
				$shop_page_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';

				// Use the archive name if no shop page was set.
				if (!$shop_page_name) {
					$shop_page_name = $post_type_object->labels->name;
				}

				// Check if the breadcrumb should be linked.
				if ($linked) {
					$link = get_post_type_archive_link($post_type);
				}

				$shop_page_markup = $this->get_single_breadcrumb_markup($shop_page_name, $link);
			}

			return $shop_page_markup;
		}

		private function get_bbpress_main_archive_page()
		{
			return $this->get_single_breadcrumb_markup(bbp_get_forum_archive_title(), get_post_type_archive_link('forum'));
		}

		private function get_post_type_archive($linked = true)
		{
			global $wp_query;
			$post_type = $wp_query->query_vars['post_type'];
			if (!$post_type) {
				$post_type = get_post_type();
			}

			$post_type_object = get_post_type_object($post_type);
			if (!is_object($post_type_object)) return '';

			// Woocommerce
			if (($post_type === 'product') && class_exists('WooCommerce')) {
				$woocommerce_shop_page = $this->get_woocommerce_shop_page($linked);
				return $woocommerce_shop_page;
			}

			// bbPress
			if (($post_type === 'topic') && class_exists('bbPress')) {
				$archive_title = bbp_get_forum_archive_title();
				if ($linked) {
					$link = get_post_type_archive_link(bbp_get_forum_post_type());
				}

				return $this->get_single_breadcrumb_markup($archive_title, $link);
			}

			$archive_title = $post_type_object->name;
			if (isset($post_type_object->label) && !empty($post_type_object->label)) {
				$archive_title = $post_type_object->label;
			} elseif (isset($post_type_object->labels->menu_name) && !empty($post_type_object->labels->menu_name)) {
				$archive_title = $post_type_object->labels->menu_name;
			}


			$link = '';
			if ($linked) {
				$link = get_post_type_archive_link($post_type);
			}

			return $this->get_single_breadcrumb_markup($archive_title, $link);
		}

		private function get_post_terms()
		{
			$terms_markup = '';

			if (!$this->show_terms) {
				return $terms_markup;
			}

			if ($this->post->post_type === 'post') {
				$taxonomy = 'category';
			} elseif (($this->post->post_type === 'product') && class_exists('WooCommerce') && is_woocommerce()) {
				$taxonomy = 'product_cat';
			} else {
				return $terms_markup;
			}

			$terms = wp_get_object_terms($this->post->ID, $taxonomy);

			if (empty($terms)) {
				return $terms_markup;
			}

			$terms_by_id = array();
			foreach ($terms as $term) {
				$terms_by_id[$term->term_id] = $term;
			}

			// Unset all terms that are parents of some term.
			foreach ($terms as $term) {
				unset($terms_by_id[$term->parent]);
			}

			// If only one term is left, we have a single term tree.
			if (count($terms_by_id) == 1) {
				unset($terms);
				$terms[0] = array_shift($terms_by_id);
			}

			// The post is only in one term.
			if (count($terms) == 1) {
				$term_parent = $terms[0]->parent;

				// If the term has a parent we need its ancestors for a full tree.
				if ($term_parent) {
					// Get space separated string of term tree in slugs.
					$term_tree = get_ancestors($terms[0]->term_id, $taxonomy);
					$term_tree = array_reverse($term_tree);
					$term_tree[] = get_term($terms[0]->term_id, $taxonomy);

					// Loop through the term tree.
					foreach ($term_tree as $term_id) {
						// Get the term object by its slug.
						$term_object = get_term($term_id, $taxonomy);

						// Add it to the term breadcrumb markup string.
						$terms_markup .= $this->get_single_breadcrumb_markup($term_object->name, get_term_link($term_object));
					}
				} else {
					$terms_markup = $this->get_single_breadcrumb_markup($terms[0]->name, get_term_link($terms[0]));
				}
			} // the post has multiple terms
			else {
				// The lexicographically smallest term will be part of the breadcrump rich snippet path.
				$terms_markup = $this->get_single_breadcrumb_markup($terms[0]->name, get_term_link($terms[0]), false);
				// Drop the first index.
				array_shift($terms);

				// Loop through the rest of the terms, and add them to string comma separated.
				$max_index = count($terms);
				$i = 0;
				foreach ($terms as $term) {

					// For the last index also add the separator.
					if (++$i == $max_index) {
						$terms_markup .= ', ' . $this->get_single_breadcrumb_markup($term->name, get_term_link($term), true, false);
					} else {
						$terms_markup .= ', ' . $this->get_single_breadcrumb_markup($term->name, get_term_link($term), false, false);
					}
				}
			}

			return $terms_markup;
		}

		private function get_post_ancestors() {
			$ancestors_markup = '';

			// Get the ancestor id, order needs to be reversed.
			$post_ancestor_ids = array_reverse( get_post_ancestors( $this->post ) );

			// Loop through the ids to get the full tree.
			foreach ( $post_ancestor_ids as $post_ancestor_id ) {
				$post_ancestor     = get_post( $post_ancestor_id );
				$ancestors_markup .= $this->get_single_breadcrumb_markup( $post_ancestor->post_title, get_permalink( $post_ancestor->ID ) );
			}

			return $ancestors_markup;
		}

		private function get_breadcrumb_leaf_markup($object_type = '') {
			global $wp_query, $wp_locale;
			switch ( $object_type ) {
				case 'term':
					$term  = $wp_query->get_queried_object();
					$title = $term->name;
					break;
				case 'year':
					$title = esc_html( get_the_date('Y') );
					break;
				case 'month':
					$title = $wp_locale->get_month( get_the_date('m') );
					break;
				case 'day':
					$title = get_the_date('d');
					break;
				case 'author':
					$user  = $wp_query->get_queried_object();
					$title = $user->display_name;
					break;
				case 'search':
					$title = $this->search_prefix . ' ' . esc_html( get_search_query() );
					break;
				case '404':
					$title = $this->error_prefix;
					break;
				case 'bbpress_search':
					$title = $this->search_prefix . ' ' . urldecode( esc_html( get_query_var( 'bbp_search' ) ) );
					break;
				case 'bbpress_user':
					$current_user_id = bbp_get_user_id( 0, true, false );
					$current_user 	 = get_userdata( $current_user_id );
					$title        	 = $current_user->display_name;
					break;
				case 'events':
					$title = tribe_get_events_title();
					break;
				default:
					$title = get_the_title( $this->post->ID );
					break;
			}

			return '<li class="breadcrumb-leaf">' . $title . '</li>';
		}

		private function get_taxonomies() {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$terms_markup = '';

			// Make sure we have hierarchical taxonomy and parents.
			if ( 0 != $term->parent && is_taxonomy_hierarchical( $term->taxonomy ) ) {
				$term_ancestors = get_ancestors( $term->term_id, $term->taxonomy );
				$term_ancestors = array_reverse( $term_ancestors );
				// Loop through ancestors to get the full tree.
				foreach ( $term_ancestors as $term_ancestor ) {
					$term_object   = get_term( $term_ancestor, $term->taxonomy );
					$terms_markup .= $this->get_single_breadcrumb_markup( $term_object->name, get_term_link( $term_object->term_id, $term->taxonomy ) );
				}
			}

			return $terms_markup;
		}

		private function get_single_breadcrumb_markup($title, $link = '', $separator = true, $micro_data = true)
		{
			$micro_data_item_scope = $micro_data_url = $micro_data_title = $separator_markup = '';
			if ($micro_data) {
				$micro_data_item_scope = 'itemscope itemtype="http://data-vocabulary.org/Breadcrumb"';
				$micro_data_url = 'itemprop="url"';
				$micro_data_title = 'itemprop="title"';
			}

			$breadcrumb_content = '<span ' . $micro_data_title . '>' . $title . '</span>';
			if ($link) {
				$breadcrumb_content = '<a ' . $micro_data_url . ' href="' . esc_url($link) . '">' . $breadcrumb_content . '</a>';
			}

			if ($separator) {
				$separator_markup = '<li class="breadcrumb-sep">' . $this->separator . '</li>';
			}

			$output = '<li ' . $micro_data_item_scope . '>' . $breadcrumb_content . '</li>' . $separator_markup;
			return $output;
		}
	}
}