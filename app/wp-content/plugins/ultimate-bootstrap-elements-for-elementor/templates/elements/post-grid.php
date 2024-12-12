<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $element UBE_Element_Post_Grid
 */

$settings = $element->get_settings();
$args     = ube_get_query_args( $settings );

if ( ! empty( $settings['load_more_button_scheme'] ) ) {
	$scheme = $settings['load_more_button_scheme'];
}
$nonce_field = wp_create_nonce( 'ube_load_post' );

$button_classes = 'btn ube-load-more-button';
if ( ! empty( $settings['load_more_button_size'] ) ) {
	$button_classes .= ' btn-' . $settings['load_more_button_size'];
}
if ( ! empty( $settings['load_more_button_shape'] ) ) {
	$button_classes .= ' btn-' . $settings['load_more_button_shape'];
}
if ( ! empty( $settings['load_more_button_type'] ) && $settings['load_more_button_type'] != 'outline' ) {
	$button_classes .= ' btn-' . $settings['load_more_button_type'];
}
if ( ! empty( $scheme ) ) {

	if ( empty( $settings['load_more_button_type'] ) || $settings['load_more_button_type'] == '3d' ) {
		$button_classes_scheme = ' btn-' . $scheme;
	}
	if ( $settings['load_more_button_type'] == 'outline' ) {
		$button_classes_scheme = ' btn-outline-' . $scheme;
	}
	$button_classes .= $button_classes_scheme;
}


$class = $button_classes;

$column_classes   = array();
$column_classes[] = 'ube-post-grid-item';

if ( ! empty( $settings['number_column_mobile'] ) ) {
	if ( $settings['number_column_mobile'] != '5' ) {
		$grid_mb          = 12 / intval( $settings['number_column_mobile'] );
		$column_classes[] = 'col-' . $grid_mb;
	} elseif ( $settings['number_column_mobile'] == '5' ) {
		$column_classes[] = 'ube-col-custom-5';
	}
}else{
	$column_classes[]='col-auto';
}
if ( ! empty( $settings['number_column_tablet'] ) ) {
	if ( $settings['number_column_tablet'] != '5' ) {
		$grid_tb          = 12 / intval( $settings['number_column_tablet'] );
		$column_classes[] = 'col-md-' . $grid_tb;
	} elseif ( $settings['number_column_tablet'] == '5' ) {
		$column_classes[] = 'ube-col-md-custom-5';
	}
}else{
	$column_classes[]='col-md-auto';
}

if ( ! empty( $settings['number_column'] ) ) {
	if ( $settings['number_column'] != '5' ) {
		$grid             = 12 / intval( $settings['number_column'] );
		$column_classes[] = 'col-lg-' . $grid;
	} elseif ( $settings['number_column'] == '5' ) {
		$column_classes[] = 'ube-col-lg-custom-5';
	}
}else{
	$column_classes[]='col-lg-auto';
}
$btn_class = array(
	'btn',
	"btn-{$settings['read_more_button_size']}",
	"btn-{$settings['read_more_button_shape']}",
);

if ( $settings['read_more_button_type'] === '' || $settings['read_more_button_type'] === '3d' ) {
	$btn_class[] = "btn-{$settings['read_more_button_scheme']}";
}

if ( $settings['read_more_button_type'] === 'outline' ) {
	$btn_class[] = "btn-outline-{$settings['read_more_button_scheme']}";
}

if ( $settings['read_more_button_type'] !== '' ) {
	$btn_class[] = "btn-{$settings['read_more_button_type']}";
}

$post_layout_allow = array_keys(ube_get_post_grid_layout());
$post_layout = isset($settings['post_layout']) ? $settings['post_layout'] : 'post-grid-layout-01';
if (!in_array($post_layout,$post_layout_allow)) {
    $post_layout = 'post-grid-layout-01';
}

$settings_array = [
	'id'                                 => $element->get_id(),
	'show_image'                         => $settings['show_image'],
	'show_title'                         => $settings['show_title'],
	'show_excerpt'                       => $settings['show_excerpt'],
	'show_meta'                          => $settings['show_meta'],
	'excerpt_length'                     => intval( $settings['excerpt_length'], 10 ),
	'show_read_more_button'              => $settings['show_read_more_button'],
	'read_more_button_text'              => $settings['read_more_button_text'],
	'show_read_more_button_prefix_style' => $settings['show_read_more_button_prefix_style'],
	'read_more_button_text_suffix'       => $settings['read_more_button_text_suffix'],
	'show_load_more_text'                => $settings['show_load_more_text'],
	'excerpt_expansion_indicator'        => $settings['excerpt_expansion_indicator'],
	'orderby'                            => $settings['orderby'],
	'show_category'                      => $settings['show_category'],
	'category_length'                    => $settings['category_length'],
	'show_category_icon'                 => $settings['show_category_icon'],
	'show_author'                        => $settings['show_author'],
	'show_author_icon'                   => $settings['show_author_icon'],
	'show_avatar'                        => $settings['show_avatar'],
	'author_text_prefix'                 => $settings['author_text_prefix'],
	'show_date'                          => $settings['show_date'],
	'show_date_icon'                     => $settings['show_date_icon'],
	'date_text_prefix'                   => $settings['date_text_prefix'],
	'show_comment_count'                 => $settings['show_comment_count'],
	'show_comment_icon'                  => $settings['show_comment_icon'],
	'comment_text_suffix'                => $settings['comment_text_suffix'],
	'paging'                             => $settings['paging'],
	'show_filter_category'               => $settings['show_filter_category'],
	'post_layout'                        => $post_layout,
	'load_more_button_type'              => $settings['load_more_button_type'],
	'load_more_button_shape'             => $settings['load_more_button_shape'],
	'load_more_button_size'              => $settings['load_more_button_size'],
	'load_more_button_scheme'            => $settings['load_more_button_scheme'],
	'button_class'                       => $class,
	'next_text'                          => $settings['next_text'],
	'next_icon'                          => $settings['next_icon'],
	'prev_text'                          => $settings['prev_text'],
	'prev_icon'                          => $settings['prev_icon'],
	'column_class'                       => implode( " ", $column_classes ),
	'image_size_mode'                    => $settings['image_size_mode'],
	'image_size_width'                   => $settings['image_size_width'],
	'image_size_height'                  => $settings['image_size_height'],
	'read_more_class'                    => implode( " ", $btn_class ),
];

$wrapper_classes[] = 'ube-posts ube-post-grid ube-post-appender row';

$category_separate_style = '';
if ( $settings['show_category'] == 'yes' ) {
	$wrapper_classes[] = 'ube-post-list-category-separate-' . $settings['category_separate_style'];
}
if ( $settings['show_meta_separate'] == 'yes' ) {
	$wrapper_classes[] = 'ube-post-list-meta-separate';
}
if ( ! empty( $settings['hover_animation'] ) ) {
	$wrapper_classes[] = 'ube-post-image-hover-' . $settings['hover_animation'];
}
if ( $settings['paging'] == 'scroll' && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
	$wrapper_classes[] = 'ube-post-list-scroll';
}
$element->add_render_attribute(
	'post_list_wrapper',
	[
		'id'    => 'ube-post-list-' . esc_attr( $element->get_id() ),
		'class' => $wrapper_classes,
	]
);
$total_page    = 1;
$post_per_page = $args['posts_per_page'];

if ( $post_per_page != 0 && $post_per_page != '' ) {
	$new_arg                   = $args;
	$new_arg['posts_per_page'] = - 1;
	$query                     = new \WP_Query( $new_arg );
	$post_count                = $query->post_count;
	$total_page                = ceil( $post_count / intval( $post_per_page ) );
	$paging_post_count         = $post_count;
}

?>
<?php if ( $settings['show_filter_category'] == 'yes' ) {
	ube_get_template( 'post/pagination/categories.php', array(
		'settings'       => $settings,
		'settings_array' => $settings_array,
		'nonce_field'    => $nonce_field,
		'posts_per_page' => $post_per_page
	) );
} ?>


<div <?php echo $element->get_render_attribute_string( 'post_list_wrapper' ) ?>>
	<?php echo ube_render_template_post( $args, $settings_array ) ?>
</div>

<div class="ube-post-list-paging <?php if ( $settings['hide_disable_next_previous'] == 'yes' && $settings['paging'] == 'pagination' ) {
	echo 'ube-post-list-hide-disable-button';
} ?>">
	<?php
	if ( intval( $settings['posts_per_page'] ) > 0 && $settings['paging'] != '' && $args['posts_per_page'] < $paging_post_count ) :
		?>

		<?php
		if ( 'load_more' == $settings['paging'] ) {

			ube_get_template( 'post/pagination/load-more.php', array(
				'args'                => $args,
				'settings_array'      => $settings_array,
				'total_page'          => $total_page,
				'show_load_more_text' => $settings['show_load_more_text'],
				'class'               => $class,
				'nonce_field'         => $nonce_field
			) );
		} elseif ( 'pagination' == $settings['paging'] ) {
			ube_get_template( 'post/pagination/pagination.php', array(
				'args'           => $args,
				'settings_array' => $settings_array,
				'total_page'     => $total_page,
				'nonce_field'    => $nonce_field
			) );
		} elseif ( 'next_prev' == $settings['paging'] ) {
			ube_get_template( 'post/pagination/next-prev.php', array(
				'args'           => $args,
				'settings_array' => $settings_array,
				'total_page'     => $total_page,
				'nonce_field'    => $nonce_field
			) );
		} elseif ( $settings['paging'] == 'scroll' ) {
			ube_get_template( 'post/pagination/infinitive-scroll.php', array(
				'args'           => $args,
				'settings_array' => $settings_array,
				'total_page'     => $total_page,
				'nonce_field'    => $nonce_field
			) );
		}
		?>
	<?php endif; ?>
</div>
