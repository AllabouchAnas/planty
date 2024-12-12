<?php
/**
 * The template for displaying class-g5plus-query.php
 */
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Lustria_Query')) {
	class G5Plus_Lustria_Query {

		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

        public function get_query() {
            global $gsf_query;
            if ( ! is_a( $gsf_query, 'WP_Query' ) ) {
                global $wp_query;
                $gsf_query = &$wp_query;
            }
            return $gsf_query;
        }

        public function is_main_query(){
            return $this->get_query()->is_main_query();
        }


		public function get_main_query_vars($query_args = array()) {
            $settings =  G5Plus_Lustria()->blog()->get_layout_settings();
			if (!isset($query_args)) {
				global $wp_query;
				$query_args = $wp_query->query_vars;
			} else {
				if ((in_array($settings['post_paging'],array('pagination-ajax','pagination'))) && !isset($query_args['paged'])) {
					$query_args['paged']   =  get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : (get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1);
				}
			}


			// remove empty vars
			foreach ( $query_args as $_a => $_v ) {
				if ( is_array( $_v ) ) {
					if ( count( $_v ) === 0 ) {
						unset( $query_args[ $_a ] );
					}
				} else {
					if ( empty( $_v ) || $_v === 0 ) {
						unset( $query_args[ $_a ] );
					}
				}
			}


            if (!isset($query_args['post_status'])) {
                $query_args['post_status'] = 'publish';
            }

			if (isset($query_args['tag__in'])) {
				unset($query_args['tag_id']);
			}

			if (isset($settings['category_filter']) && is_array($settings['category_filter'])&& !isset($query_args['gf_cat'])) {
				unset($query_args['cat']);
				unset($query_args['category_name']);
                unset($query_args['term']);
                unset($query_args['taxonomy']);
			}

			// Remove extra vars
			unset( $query_args['suppress_filters'] );
			unset( $query_args['cache_results'] );
			unset( $query_args['update_post_term_cache'] );
			unset( $query_args['update_post_meta_cache'] );
			unset( $query_args['comments_per_page'] );
			unset( $query_args['no_found_rows'] );
			unset( $query_args['search_orderby_title'] );
			unset($query_args['lazy_load_term_meta']);
			return $query_args;
		}

		public function get_ajax_query_vars($query_args = null) {
            if (!isset($query_args)) {
                $query_args = $this->get_query()->query_vars;
            }


			// remove empty vars
			foreach ($query_args as $_a => $_v ) {
				if ( is_array( $_v ) ) {
					if ( count( $_v ) === 0 ) {
						unset( $query_args[ $_a ] );
					}
				} else {
					if ( empty( $_v ) || $_v === 0 ) {
						unset( $query_args[ $_a ] );
					}
				}
			}


			if (!isset($query_args['paged'])) {
				$query_args['paged']   =  get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : (get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1);
			}

			if (isset($query_args['tag__in'])) {
				unset($query_args['tag_id']);
			}

            if (isset($query_args['category__in'])) {
                unset($query_args['cat']);
                unset($query_args['category_name']);
                unset($query_args['term']);
                unset($query_args['taxonomy']);
            }

            if (isset($query_args['author__in'])) {
                unset($query_args['author']);
            }


			// Remove extra vars
			unset( $query_args['suppress_filters'] );
			unset( $query_args['cache_results'] );
			unset( $query_args['update_post_term_cache'] );
			unset( $query_args['update_post_meta_cache'] );
			unset( $query_args['comments_per_page'] );
			unset( $query_args['no_found_rows'] );
			unset( $query_args['search_orderby_title'] );
			unset($query_args['lazy_load_term_meta']);
			return $query_args;
		}

		public function parse_ajax_query($query = array()) {

			if (!isset($query['post_status'])) {
				$query['post_status'] = 'publish';
			}

			if (!isset($query['paged'])) {
				$query['paged'] = 1;
			}

			global $paged;
			$paged = $query['paged'];

			return $query;

		}


        public function query_posts($query = null){
            if (isset($query) && (!isset($GLOBALS['gsf_query']))) {
                $GLOBALS['gsf_query'] = new WP_Query();
                $GLOBALS['gsf_query']->query($query);
            }
        }

        public function reset_query(){
	        unset($GLOBALS['gsf_query']);
	        wp_reset_postdata();
        }


        public function have_posts() {
		    return $this->get_query()->have_posts();
        }

        public function the_post() {
		    $this->get_query()->the_post();
        }

        public function reset_postdata() {
            $this->get_query()->reset_postdata();
        }

        public function query_var_paged() {
            return $this->get_query()->get( 'page' ) ? intval( $this->get_query()->get( 'page' ) ) : ($this->get_query()->get( 'paged' ) ? intval( $this->get_query()->get( 'paged' ) ) : 1);
        }

        public function get_max_num_pages(){
		    $original_offset = $this->get_query()->get('original_offset');
            $offset = !empty($original_offset) ? $original_offset : $this->get_query()->get('offset') ;
            if (!empty($offset)) {
                return ceil( ( $this->get_query()->found_posts - intval($offset)  ) / intval($this->get_query()->get('posts_per_page')));
            }

            return $this->get_query()->max_num_pages;
        }

        public function pre_get_posts($query) {
			if ( ! is_admin() && $query->is_main_query() ) {
				if ($query->is_search() && $query->get('post_type') !== 'product') {
					$search_post_type = G5Plus_Lustria()->options()->get_search_post_type();
					$query->set('post_type',$search_post_type);
				}

				$offset = $query->get('offset');
                if (!empty($offset)) {
                    $paged = $this->query_var_paged();
                    $posts_per_page = intval($query->get('posts_per_page'));

                    $original_offset = $query->get('original_offset');
                    $offset = !empty($original_offset) ? $original_offset : $query->get('offset') ;
                    $query->set('original_offset',$offset);
                    if ($paged > 1) {
                        $query->set('offset',intval( $offset ) + ( ( $paged - 1 ) * $posts_per_page )) ;
                    }
                }
			}
		}
	}
}