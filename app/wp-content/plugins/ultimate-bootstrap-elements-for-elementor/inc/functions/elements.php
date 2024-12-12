<?php
/**
 * Function helper for elements
 *
 * @version 1.0.0
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get color schemes for element
 *
 * @param bool $allow_default
 *
 * @return array
 * @since 1.0.0
 */
function ube_get_color_schemes( $allow_default = true ) {
	$schemes = array();
	if ( $allow_default ) {
		$schemes[''] = esc_html__( 'Default', 'ube' );
	}

	foreach ( ube_color_schemes_configs() as $k => $v ) {
		$schemes[ $k ] = $v['label'];
	}

	return $schemes;
}

function ube_get_animation_name() {
	$animations = \Elementor\Control_Animation::get_animations();
	$names      = array();
	$names['']  = esc_html__( 'Default', 'ube' );
	foreach ( $animations as $animations_group_name => $animations_group ) {
		foreach ( $animations_group as $animation_name => $animation_title ) {
			$names[ $animation_name ] = $animation_title;
		}
	}

	return $names;
}

function ube_get_post_types() {
	$post_types = get_post_types( [ 'public' => true, 'show_in_nav_menus' => true ], 'objects' );
	$post_types = wp_list_pluck( $post_types, 'label', 'name' );

	return array_diff_key( $post_types, [ 'elementor_library', 'attachment' ] );
}

function ube_get_all_types_post() {
	$posts = get_posts( [
		'post_type'      => 'post',
		'post_style'     => 'all_types',
		'post_status'    => 'publish',
		'posts_per_page' => '-1',
	] );

	if ( ! empty( $posts ) ) {
		return wp_list_pluck( $posts, 'post_title', 'ID' );
	}

	return [];
}

function ube_get_authors() {
	$users = get_users( [
		'who'                 => 'authors',
		'has_published_posts' => true,
		'fields'              => [
			'ID',
			'display_name',
		],
	] );

	if ( ! empty( $users ) ) {
		return wp_list_pluck( $users, 'display_name', 'ID' );
	}

	return [];
}

function ube_get_post_orderby_options() {
	$orderby = array(
		'ID'            => esc_html__( 'Post ID', 'ube' ),
		'author'        => esc_html__( 'Post Author', 'ube' ),
		'title'         => esc_html__( 'Title', 'ube' ),
		'date'          => esc_html__( 'Date', 'ube' ),
		'modified'      => esc_html__( 'Last Modified Date', 'ube' ),
		'parent'        => esc_html__( 'Parent Id', 'ube' ),
		'rand'          => esc_html__( 'Random', 'ube' ),
		'comment_count' => esc_html__( 'Comment Count', 'ube' ),
		'menu_order'    => esc_html__( 'Menu Order', 'ube' ),
	);

	return $orderby;
}

function ube_get_terms_as_list( $term_type = 'category', $length = 10, $id = false ) {
	if ( $term_type === 'category' ) {
		$terms = get_the_category( $id );
	}

	if ( $term_type === 'tags' ) {
		$terms = get_the_tags( $id );
	}

	if ( empty( $terms ) ) {
		return '';
	}

	$html  = '<ul class="ube-term-list list-inline">';
	$count = 0;
	foreach ( $terms as $term ) {
		if ( $count === $length ) {
			break;
		}
		$link = ( $term_type === 'category' ) ? get_category_link( $term->term_id ) : get_tag_link( $term->term_id );
		$html .= '<li class="list-inline-item">';
		$html .= '<a href="' . esc_url( $link ) . '">';
		$html .= $term->name;
		$html .= '</a>';
		$html .= '</li>';
		$count ++;
	}
	$html .= '</ul>';

	return $html;
}

function ube_get_query_args( $settings = [] ) {
	$settings = wp_parse_args( $settings, [
		'post_type'      => 'post',
		'posts_ids'      => [],
		'orderby'        => 'date',
		'order'          => 'desc',
		'posts_per_page' => 3,
		'offset'         => 0,
		'post__not_in'   => [],
	] );

	$args = [
		'orderby'             => $settings['orderby'],
		'order'               => $settings['order'],
		'ignore_sticky_posts' => 1,
		'post_status'         => 'publish',
		'posts_per_page'      => $settings['posts_per_page'] != '' ? $settings['posts_per_page'] : - 1,
		'offset'              => $settings['offset'],
	];

	if ( 'by_id' === $settings['post_type'] ) {
		$args['post_type'] = 'any';
		$args['post__in']  = empty( $settings['posts_ids'] ) ? [ 0 ] : $settings['posts_ids'];
	} else {
		$args['post_type'] = $settings['post_type'];

		if ( $args['post_type'] !== 'page' ) {
			$args['tax_query'] = [];
			$taxonomies        = get_object_taxonomies( $settings['post_type'], 'objects' );

			foreach ( $taxonomies as $object ) {
				$setting_key = $object->name . '_ids';

				if ( ! empty( $settings[ $setting_key ] ) ) {
					$args['tax_query'][] = [
						'taxonomy' => $object->name,
						'field'    => 'term_id',
						'terms'    => $settings[ $setting_key ],
					];
				}
			}

			if ( ! empty( $args['tax_query'] ) ) {
				$args['tax_query']['relation'] = 'AND';
			}
		}
	}

	if ( ! empty( $settings['authors'] ) ) {
		$args['author__in'] = $settings['authors'];
	}

	if ( ! empty( $settings['post__not_in'] ) ) {
		$args['post__not_in'] = $settings['post__not_in'];
	}

	return $args;
}

function ube_render_template_post( $args, $settings ) {

	$query      = new \WP_Query( $args );
	$i          = 0;
	$grid_items = array();
	if ( isset( $settings['post_grid_items'] ) ) {
		$grid_items = $settings['post_grid_items'];
	}
	ob_start();
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ):
			$query->the_post();
			if ( $settings['show_image'] == 'yes' ) {
				if ( isset( $settings['image_size_mode'] ) ) {
					$pd_top      = 66.6666666;
					$media_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
					if ( $media_image && ($media_image[1] != 0) ) {
						$pd_top = ( $media_image[2] / $media_image[1] ) * 100;
					}

					if ( isset( $settings['image_size_mode'] ) && $settings['image_size_mode'] !== 'custom' && $settings['image_size_mode'] !== 'original' ) {
						$pd_top = $settings['image_size_mode'];
					}

					if ( isset( $settings['image_size_mode'] ) && $settings['image_size_mode'] === 'custom' ) {
						$img_width  = isset( $settings['image_size_width'] ) ? intval( $settings['image_size_width'] ) : 0;
						$img_height = isset( $settings['image_size_height'] ) ? intval( $settings['image_size_height'] ) : 0;
						if ( $img_width > 0 && $img_height > 0 ) {
							$pd_top = ( $img_height / $img_width ) * 100;
						}
					}
					$settings['ratio'] = $pd_top . '%';
				}

			}
			if ( isset( $settings['post_style'] ) && $settings['post_style'] == 'metro' ) {
				$ratio      = $settings['ratio'];
				$ratio_show = array(
					' --ube-post-ratio: ' . $ratio . '%;',
					'--ube-post-ratio-md:' . $ratio . '%;',
					'--ube-post-ratio-sm:' . $ratio . '%'
				);
				$grid_class = array( 'ube-grid-item' );
				if ( ! empty( $grid_items ) ) {
					$item_col    = 1;
					$item_row    = 1;
					$item_col    = 1;
					$item_row    = 1;
					$item_row_md = $item_row;
					$item_row_sm = $item_row_md;
					$item_col_md = $item_col;
					$item_col_sm = $item_col_md;
					if ( $grid_items ) {
						$grid_count = count( $grid_items );
						$grid_index = $settings['post_loop_layout'] !== 'yes' ? $i : $i % $grid_count;

						if ( $grid_index < $grid_count ) {
							if ( isset( $grid_items[ $grid_index ]['number_column_mobile'] ) && $grid_items[ $grid_index ]['number_column_mobile'] !== '' ) {
								$item_col_sm  = $grid_items[ $grid_index ]['number_column_mobile'];
								$grid_class[] = 'gc-sm-' . $item_col_sm;
							}
							if ( isset( $grid_items[ $grid_index ]['number_column_tablet'] ) && $grid_items[ $grid_index ]['number_column_tablet'] !== '' ) {
								$item_col_md  = $grid_items[ $grid_index ]['number_column_tablet'];
								$grid_class[] = 'gc-md-' . $item_col_md;
							}
							if ( isset( $grid_items[ $grid_index ]['number_column'] ) && $grid_items[ $grid_index ]['number_column'] !== '' ) {
								$item_col     = $grid_items[ $grid_index ]['number_column'];
								$grid_class[] = 'gc-' . $item_col;
							}
							if ( isset( $grid_items[ $grid_index ]['number_row_mobile'] ) && $grid_items[ $grid_index ]['number_row_mobile'] !== '' ) {
								$item_row_sm  = $grid_items[ $grid_index ]['number_row_mobile'];
								$grid_class[] = 'gr-sm-' . $item_row_sm;
							}
							if ( isset( $grid_items[ $grid_index ]['number_row_tablet'] ) && $grid_items[ $grid_index ]['number_row_tablet'] !== '' ) {
								$item_row_md  = $grid_items[ $grid_index ]['number_row_tablet'];
								$grid_class[] = 'gr-md-' . $item_row_md;
							}
							if ( isset( $grid_items[ $grid_index ]['number_row'] ) && $grid_items[ $grid_index ]['number_row'] !== '' ) {
								$item_row     = $grid_items[ $grid_index ]['number_row'];
								$grid_class[] = 'gr-' . $item_row;
							}
						}
					}
					$item_ratio    = $ratio * $item_row / $item_col;
					$item_ratio_md = $ratio * $item_row_md / $item_col_md;
					$item_ratio_sm = $ratio * $item_row_sm / $item_col_sm;
					$ratio_show    = array(
						' --ube-post-ratio: ' . $item_ratio . '%;',
						'--ube-post-ratio-md:' . $item_ratio_md . '%;',
						'--ube-post-ratio-sm:' . $item_ratio_sm . '%'
					);

				}
				$settings['style']        = implode( ";", $ratio_show );
				$settings['column_class'] = implode( " ", $grid_class );
			}


			ube_get_template( 'post/post-list/' . $settings['post_layout'] . '.php', array(
				'settings'        => $settings,
				'category_length' => $settings['category_length'] != '' ? intval( $settings['category_length'] ) : 10
			) );
			?>

			<?php
			$i ++;
		endwhile;
	else:
		?>
        <p class="no-posts-found"><?php esc_html_e( 'No posts found!', 'ube' ) ?></p>
	<?php endif;
	wp_reset_postdata();

	return ob_get_clean();
}


/**
 * Get element config
 *
 * @return array
 * @since 1.0.0
 */
function ube_get_setting_elements() {
	return get_option( UBE_SETTING_ELEMENT, array() );
}

/**
 * Update elements config
 *
 * @param $data
 *
 * @since 1.0.0
 */
function ube_update_setting_elements( $data ) {
	update_option( UBE_SETTING_ELEMENT, $data );
}

/**
 * Get integrated API setting
 *
 * @param string $id
 *
 * @return array|string
 * @since 1.0.0
 */
function ube_get_setting_integrated_api( $id = '' ) {
	$api = get_option( UBE_SETTING_INTEGRATED_API, array() );
	if ( $id === '' ) {
		return $api;
	}

	return isset( $api[ $id ] ) ? $api[ $id ] : '';
}

/**
 * Update integrated api setting
 *
 * @param $data
 *
 * @since 1.0.0
 */
function ube_update_setting_integrated_api( $data ) {
	update_option( UBE_SETTING_INTEGRATED_API, $data );
}

function ube_get_elements_available() {
	$els = array();
	foreach ( ube_get_element_configs() as $group ) {
		$els = array_merge( $els, array_keys( $group['items'] ) );
	}

	return $els;
}

function ube_get_elements_enabled() {
	$ube_elements = ube_get_setting_elements();
	$all_elements = ube_get_elements_available();

	$available_elements = array();

	foreach ( $all_elements as $el ) {
		if ( ! isset( $ube_elements[ $el ] ) || ( $ube_elements[ $el ] === '1' ) ) {
			array_push( $available_elements, $el );
		}
	}

	return $available_elements;
}

