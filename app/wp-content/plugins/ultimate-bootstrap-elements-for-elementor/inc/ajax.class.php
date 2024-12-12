<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class UBE_Ajax {
	private static $_instance = null;

	public static function get_instance() {
		return self::$_instance === null ? self::$_instance = new self() : self::$_instance;
	}

	/**
	 * Init Ajax
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'wp_ajax_ube_result_search_box', array( $this, 'get_search_result_callback' ) );
		add_action( 'wp_ajax_nopriv_ube_result_search_box', array( $this, 'get_search_result_callback' ) );

		add_action( 'wp_ajax_ube_load_more', array( $this, 'post_load_more_callback' ) );
		add_action( 'wp_ajax_nopriv_ube_load_more', array( $this, 'post_load_more_callback' ) );

		add_action( 'wp_ajax_ube_control_autocomplete', array( $this, 'control_autocomplete_callback' ) );
		add_action( 'wp_ajax_nopriv_ube_control_autocomplete', array( $this, 'control_autocomplete_callback' ) );
	}

	/**
	 * Ajax data for search box
	 *
	 * @since 1.0.0
	 */
	public function get_search_result_callback() {
		$keyword = isset( $_POST['keyword'] ) ? sanitize_text_field( $_POST['keyword'] ) : '';
		if ( $_POST['keyword'] === '' ) {
			die();
		}

		$args = array(
			's'                   => $keyword,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'orderby'             => sanitize_text_field( $_POST['orderby'] ),
			'order'               => sanitize_text_field( $_POST['order'] ),
			'posts_per_page'      => sanitize_text_field( $_POST['data_post_per_page'] ),
		);

		$result_date = sanitize_text_field( $_POST['result_date'] );
		$the_query   = new WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ): $the_query->the_post(); ?>
                <li class="ube-search-box-item-result d-flex align-items-center">
					<?php $thumb = get_the_post_thumbnail( get_the_ID(), 'thumbnail' ); ?>
					<?php if ( ! empty( $thumb ) ): ?>
                        <div class="ube-search-box-result-thumbnail">
                            <a href="<?php the_permalink() ?>"
                               title="<?php the_title_attribute() ?>"><?php echo get_the_post_thumbnail( get_the_ID(), 'thumbnail' ); ?>
                            </a>
                        </div>
					<?php endif; ?>
                    <div class="ube-search-box-result-content">
                        <a class="ube-search-box-result-title" href="<?php the_permalink() ?>"
                           title="<?php the_title_attribute() ?>"><?php the_title(); ?>
                        </a>
						<?php if ( $result_date === 'yes' ): ?>
                            <div class="ube-search-box-result-meta">
								<?php echo get_the_date( get_option( 'date_format' ) ); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </li>
			<?php endwhile;
			wp_reset_postdata();
		else:
			?>
            <li class="ube-search-box-result-nothing"><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'ube' ); ?></li>
		<?php endif;
		die();
	}

	/**
	 * Ajax data for post load more
	 *
	 * @since 1.0.0
	 */
	public function post_load_more_callback() {
		if ( ! isset( $_REQUEST['nonceField'] )
		     || ! wp_verify_nonce( sanitize_text_field( $_REQUEST['nonceField'] ), 'ube_load_post' ) ) {
			return;
		}

		parse_str( ube_kses_post( $_REQUEST['args'] ), $args );
		parse_str( ( ube_kses_post( $_REQUEST['settings'] ) ), $settings );

		$page = sanitize_text_field( $_REQUEST['page'] );

		$args['offset'] = (int) $args['offset'] + ( ( (int) $page - 1 ) * (int) $args['posts_per_page'] );
		if ( isset( $_REQUEST['taxonomy'] ) ) {
			$taxonomy = ube_recursive_sanitize_text_field( $_REQUEST['taxonomy'] );

			if ( $taxonomy['taxonomy'] != 'all' ) {
				$args['tax_query'] = [
					$taxonomy,
				];
			}


		}
		$handler = ube_recursive_sanitize_text_field( $_REQUEST['handler'] );

		if ( $settings['orderby'] === 'rand' && ! empty( $args['post__not_in'] ) ) {
			$args['post__not_in'] = array_unique( ube_recursive_sanitize_text_field( $_REQUEST['post__not_in'] ) );
		}
		$html        = ube_render_template_post( $args, $settings );
		$pagination  = '';
		$total_page  = intval( sanitize_text_field( $_REQUEST['totalPage'] ) );
		$nonce_field = wp_create_nonce( 'ube_load_post' );
		$paging      = '';
		if ( isset( $settings['paging'] ) && $settings['paging'] != '' ) {
			$paging = $settings['paging'];
			if ( $total_page > intval( $page ) ) {
				ob_start();
				if ( 'load_more' == $settings['paging'] ) {
					ube_get_template( 'post/pagination/load-more.php', array(
						'args'                => $args,
						'settings_array'      => $settings,
						'total_page'          => $total_page,
						'show_load_more_text' => $settings['show_load_more_text'],
						'nonce_field'         => $nonce_field
					) );
				} elseif ( 'pagination' == $settings['paging'] ) {
					ube_get_template( 'post/pagination/pagination.php', array(
						'args'           => $args,
						'settings_array' => $settings,
						'total_page'     => $total_page,
						'nonce_field'    => $nonce_field
					) );
				} elseif ( 'next_prev' == $settings['paging'] ) {
					ube_get_template( 'post/pagination/next-prev.php', array(
						'args'           => $args,
						'settings_array' => $settings,
						'total_page'     => $total_page,
						'nonce_field'    => $nonce_field
					) );
				} elseif ( 'scroll' == $settings['paging'] ) {
					ube_get_template( 'post/pagination/infinitive-scroll.php', array(
						'args'           => $args,
						'settings_array' => $settings,
						'total_page'     => $total_page,
						'nonce_field'    => $nonce_field
					) );
				}
				$pagination = ob_get_clean();
			}
		}


		$data_arr = array(
			'content'      => $html,
			'paging'       => $paging,
			'current_page' => $page,
			'pagination'   => $pagination,
			'target'       => '#ube-post-list-' . $settings['id'],
			'widget_id'    => $settings['id']
		);
		if ( $handler == 'category_filter' ) {
			$data_arr['filter_category'] = 'yes';
			$data_arr['paging']          = '';
		}

		wp_send_json_success( $data_arr );
		die();
	}

	public function control_autocomplete_callback() {
		if ( ! isset( $_REQUEST['ube_autocomplete_nonce'] )
		     || ! wp_verify_nonce( sanitize_text_field( $_REQUEST['ube_autocomplete_nonce'] ), 'ube_autocomplete_action' ) ) {
			return;
		}
		$type          = sanitize_text_field( $_REQUEST['type'] );
		$search        = sanitize_text_field( $_REQUEST['search'] );
		$page          = sanitize_text_field( $_REQUEST['page'] );
		$data_args     = ube_recursive_sanitize_text_field( $_REQUEST['data_args'] );
		$current_value = isset( $_REQUEST['currentValue'] ) ? ube_recursive_sanitize_text_field( $_REQUEST['currentValue'] ) : '';

		$init_control = isset( $_REQUEST['initControl'] );
		if ( ! $init_control ) {
			$current_value = - 1;
		}

		echo json_encode( ube_get_query_data_for_autocomplete( $type, $search, $page, $data_args, $current_value ) );
		die();
	}
}