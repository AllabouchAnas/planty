<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
if (!class_exists('G5P_Vc_Auto_Complete')) {
	class G5P_Vc_Auto_Complete {
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
			add_action( 'vc_after_mapping', array($this,'define_filter') );
		}

		public function define_filter(){
			//Filters For autocomplete param:
			add_filter( 'vc_autocomplete_gsf_posts_ids_callback', array(&$this,'post_search',), 10, 1 ); // Get suggestion(find). Must return an array
			add_filter( 'vc_autocomplete_gsf_posts_ids_render', array(&$this,'post_render',), 10, 1 ); // Render exact product. Must return an array (label,value)

            add_filter( 'vc_autocomplete_gsf_products_product_ids_callback', array(&$this,'product_search',), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_gsf_products_product_ids_render', array(&$this,'post_render',), 10, 1 ); // Render exact product. Must return an array (label,value)

            add_filter( 'vc_autocomplete_gsf_product_singular_product_id_callback', array(&$this,'product_search',), 10, 1 ); // Get suggestion(find). Must return an array
            add_filter( 'vc_autocomplete_gsf_product_singular_product_id_render', array(&$this,'post_render',), 10, 1 ); // Render exact product. Must return an array (label,value)

		}

		public function post_search( $search_string ) {
			$query = $search_string;
			$data = array();
			$args = array(
				's' => $query,
				'post_type' => 'post',
			);
			$args['vc_search_by_title_only'] = true;
			$args['numberposts'] = - 1;
			if ( 0 === strlen( $args['s'] ) ) {
				unset( $args['s'] );
			}
			add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
			$posts = get_posts( $args );
			if ( is_array( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$data[] = array(
						'value' => $post->ID,
						'label' => $post->post_title,
						'group' => $post->post_type,
					);
				}
			}

			return $data;
		}

        public function product_search( $search_string ) {
            $query = $search_string;
            $data = array();
            $args = array(
                's' => $query,
                'post_type' => 'product',
            );
            $args['vc_search_by_title_only'] = true;
            $args['numberposts'] = - 1;
            if ( 0 === strlen( $args['s'] ) ) {
                unset( $args['s'] );
            }
            add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
            $posts = get_posts( $args );
            if ( is_array( $posts ) && ! empty( $posts ) ) {
                foreach ( $posts as $post ) {
                    $data[] = array(
                        'value' => $post->ID,
                        'label' => $post->post_title,
                        'group' => $post->post_type,
                    );
                }
            }

            return $data;
        }


		function post_render( $value ) {
			$post = get_post( $value['value'] );

			return is_null( $post ) ? false : array(
				'label' => $post->post_title,
				'value' => $post->ID
			);
		}


	}
}