<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Post_Views_Counter_Widgets class.
 *
 * @class Post_Views_Counter_Widgets
 */
class Post_Views_Counter_Widgets {

	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		// actions
		add_action( 'widgets_init', [ $this, 'register_widgets' ] );
	}

	/**
	 * Register widgets.
	 *
	 * @return void
	 */
	public function register_widgets() {
		register_widget( 'Post_Views_Counter_List_Widget' );
	}
}

/**
 * Post_Views_Counter_List_Widget class.
 *
 * @class Post_Views_Counter_List_Widget
 */
class Post_Views_Counter_List_Widget extends WP_Widget {

	private $pvc_defaults;
	private $pvc_order_types;
	public $pvc_periods;
	private $pvc_list_types;
	private $pvc_image_sizes;

	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		// call parent
		parent::__construct(
			'Post_Views_Counter_List_Widget',
			__( 'Most Viewed Posts', 'post-views-counter' ),
			[
				'description' => __( 'Displays a list of the most viewed posts', 'post-views-counter' )
			]
		);

		// default settings
		$this->pvc_defaults = [
			'title'					=> __( 'Most Viewed Posts', 'post-views-counter' ),
			'number_of_posts'		=> 5,
			'period'				=> 'total',
			'thumbnail_size'		=> 'thumbnail',
			'post_type'				=> [],
			'order'					=> 'desc',
			'list_type'				=> 'unordered',
			'show_post_views'		=> true,
			'show_post_thumbnail'	=> false,
			'show_post_excerpt'		=> false,
			'show_post_author'		=> false,
			'no_posts_message'		=> __( 'No most viewed posts found', 'post-views-counter' )
		];

		// order types
		$this->pvc_order_types = [
			'asc'	 => __( 'Ascending', 'post-views-counter' ),
			'desc'	 => __( 'Descending', 'post-views-counter' )
		];

		// periods
		$this->pvc_periods = [
			'total' => __( 'Total Views', 'post-views-counter' )
		];

		// list types
		$this->pvc_list_types = [
			'unordered'	 => __( 'Unordered list', 'post-views-counter' ),
			'ordered'	 => __( 'Ordered list', 'post-views-counter' )
		];

		// image sizes
		$this->pvc_image_sizes = array_merge( [ 'full' ], get_intermediate_image_sizes() );

		// sort image sizes by name, ascending
		sort( $this->pvc_image_sizes, SORT_STRING );
	}

	/**
	 * Display widget.
	 *
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		// empty title?
		if ( empty( $instance['title'] ) )
			$instance['title'] = $this->pvc_defaults['title'];

		// filter title
		$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$html = $args['before_widget'] . ( ! empty( $instance['title'] ) ? $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'] : '' );
		$html .= pvc_most_viewed_posts( $instance, false );
		$html .= $args['after_widget'];

		echo $html;
	}

	/** Render widget form.
	 *
	 * @param array $instance
	 * @return void
	 */
	public function form( $instance ) {
		$html = '
		<p>
			<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title', 'post-views-counter' ) . ':</label>
			<input id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" class="widefat" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( isset( $instance['title'] ) ? $instance['title'] : $this->pvc_defaults['title'] ) . '" />
		</p>
		<p>
			<label>' . esc_html__( 'Post Types', 'post-views-counter' ) . ':</label><br />';

		// post types
		foreach ( Post_Views_Counter()->functions->get_post_types() as $post_type => $post_type_name ) {
			$html .= '
			<input id="' . esc_attr( $this->get_field_id( 'post_type' ) . '-' . $post_type ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'post_type' ) ) . '[]" value="' . esc_attr( $post_type ) . '" ' . checked( ( ! isset( $instance['post_type'] ) ? true : in_array( $post_type, $instance['post_type'], true ) ), true, false ) . '><label for="' . esc_attr( $this->get_field_id( 'post_type' ) . '-' . $post_type ) . '">' . esc_html( $post_type_name ) . '</label>';
		}

		$html .= '
		</p>
		<p>
			<label for="' . esc_attr( $this->get_field_id( 'period' ) ) . '">' . esc_html__( 'Views Period', 'post-views-counter' ) . ':</label>
			<select id="' . esc_attr( $this->get_field_id( 'period' ) ) . '" name="' . esc_attr( $this->get_field_name( 'period' ) ) . '">';

		// periods
		foreach ( $this->pvc_periods as $period => $label ) {
			$html .= '
				<option value="' . esc_attr( $period ) . '" ' . selected( $period, ( isset( $instance['period'] ) ? $instance['period'] : $this->pvc_defaults['period'] ), false ) . '>' . esc_html( $label ) . '</option>';
		}

		$show_post_thumbnail = isset( $instance['show_post_thumbnail'] ) ? $instance['show_post_thumbnail'] : $this->pvc_defaults['show_post_thumbnail'];

		$html .= '
			</select>
		</p>
		<p>
			<label for="' . esc_attr( $this->get_field_id( 'number_of_posts' ) ) . '">' . esc_html__( 'Number of posts to show', 'post-views-counter' ) . ':</label>
			<input id="' . esc_attr( $this->get_field_id( 'number_of_posts' ) ) . '" name="' . esc_attr( $this->get_field_name( 'number_of_posts' ) ) . '" type="number" size="3" min="0" max="100" value="' . esc_attr( isset( $instance['number_of_posts'] ) ? $instance['number_of_posts'] : $this->pvc_defaults['number_of_posts'] ) . '" />
		</p>
		<p>
			<label for="' . esc_attr( $this->get_field_id( 'no_posts_message' ) ) . '">' . esc_html__( 'No posts message', 'post-views-counter' ) . ':</label>
			<input id="' . esc_attr( $this->get_field_id( 'no_posts_message' ) ) . '" class="widefat" type="text" name="' . esc_attr( $this->get_field_name( 'no_posts_message' ) ) . '" value="' . esc_attr( isset( $instance['no_posts_message'] ) ? $instance['no_posts_message'] : $this->pvc_defaults['no_posts_message'] ) . '" />
		</p>
		<p>
			<label for="' . esc_attr( $this->get_field_id( 'order' ) ) . '">' . esc_html__( 'Order', 'post-views-counter' ) . ':</label>
			<select id="' . esc_attr( $this->get_field_id( 'order' ) ) . '" name="' . esc_attr( $this->get_field_name( 'order' ) ) . '">';

		// order types
		foreach ( $this->pvc_order_types as $id => $order ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, ( isset( $instance['order'] ) ? $instance['order'] : $this->pvc_defaults['order'] ), false ) . '>' . esc_html( $order ) . '</option>';
		}

		$html .= '
			</select>
		</p>
		<p>
			<label for="' . esc_attr( $this->get_field_id( 'list_type' ) ) . '">' . esc_html__( 'Display Style', 'post-views-counter' ) . ':</label>
			<select id="' . esc_attr( $this->get_field_id( 'list_type' ) ) . '" name="' . esc_attr( $this->get_field_name( 'list_type' ) ) . '">';

		// list types
		foreach ( $this->pvc_list_types as $id => $list_type ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, ( isset( $instance['list_type'] ) ? $instance['list_type'] : $this->pvc_defaults['list_type'] ), false ) . '>' . esc_html( $list_type ) . '</option>';
		}

		$html .= '
			</select>
		</p>
		<p>
			<input id="' . esc_attr( $this->get_field_id( 'show_post_views' ) ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'show_post_views' ) ) . '" value="show_post_views" ' . checked( true, ( isset( $instance['show_post_views'] ) ? $instance['show_post_views'] : $this->pvc_defaults['show_post_views'] ), false ) . ' /> <label for="' . esc_attr( $this->get_field_id( 'show_post_views' ) ) . '">' . esc_html__( 'Display post views?', 'post-views-counter' ) . '</label>
			<br />
			<input id="' . esc_attr( $this->get_field_id( 'show_post_excerpt' ) ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'show_post_excerpt' ) ) . '" value="show_post_excerpt" ' . checked( true, ( isset( $instance['show_post_excerpt'] ) ? $instance['show_post_excerpt'] : $this->pvc_defaults['show_post_excerpt'] ), false ) . ' /> <label for="' . esc_attr( $this->get_field_id( 'show_post_excerpt' ) ) . '">' . esc_html__( 'Display post excerpt?', 'post-views-counter' ) . '</label>
			<br />
			<input id="' . esc_attr( $this->get_field_id( 'show_post_author' ) ) . '" type="checkbox" name="' . esc_attr( $this->get_field_name( 'show_post_author' ) ) . '" value="show_post_author" ' . checked( true, ( isset( $instance['show_post_author'] ) ? $instance['show_post_author'] : $this->pvc_defaults['show_post_author'] ), false ) . ' /> <label for="' . esc_attr( $this->get_field_id( 'show_post_author' ) ) . '">' . esc_html__( 'Display post author?', 'post-views-counter' ) . '</label>
			<br />
			<input id="' . esc_attr( $this->get_field_id( 'show_post_thumbnail' ) ) . '" class="pvc-show-post-thumbnail" type="checkbox" name="' . esc_attr( $this->get_field_name( 'show_post_thumbnail' ) ) . '" value="show_post_thumbnail" ' . checked( true, $show_post_thumbnail, false ) . ' /> <label for="' . esc_attr( $this->get_field_id( 'show_post_thumbnail' ) ) . '">' . esc_html__( 'Display post thumbnail?', 'post-views-counter' ) . '</label>
		</p>
		<p class="pvc-post-thumbnail-size"' . ( $show_post_thumbnail ? '' : ' style="display: none;"' ) . '>
			<label for="' . esc_attr( $this->get_field_id( 'thumbnail_size' ) ) . '">' . esc_html__( 'Thumbnail size', 'post-views-counter' ) . ':</label>
			<select id="' . esc_attr( $this->get_field_id( 'thumbnail_size' ) ) . '" name="' . esc_attr( $this->get_field_name( 'thumbnail_size' ) ) . '">';

		$size_type = isset( $instance['thumbnail_size'] ) ? $instance['thumbnail_size'] : $this->pvc_defaults['thumbnail_size'];

		// image sizes
		foreach ( $this->pvc_image_sizes as $size ) {
			$html .= '
				<option value="' . esc_attr( $size ) . '" ' . selected( $size, $size_type, false ) . '>' . esc_html( $size ) . '</option>';
		}

		$html .= '
			</select>
		</p>';

		echo $html;
	}

	/**
	 * Save widget form.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// number of posts
		$old_instance['number_of_posts'] = (int) (isset( $new_instance['number_of_posts'] ) ? $new_instance['number_of_posts'] : $this->pvc_defaults['number_of_posts']);

		// order
		$old_instance['order'] = isset( $new_instance['order'] ) && in_array( $new_instance['order'], array_keys( $this->pvc_order_types ), true ) ? $new_instance['order'] : $this->pvc_defaults['order'];

		// period
		$old_instance['period'] = isset( $new_instance['period'] ) && in_array( $new_instance['period'], array_keys( $this->pvc_periods ), true ) ? $new_instance['period'] : $this->pvc_defaults['period'];

		// list type
		$old_instance['list_type'] = isset( $new_instance['list_type'] ) && in_array( $new_instance['list_type'], array_keys( $this->pvc_list_types ), true ) ? $new_instance['list_type'] : $this->pvc_defaults['list_type'];

		// thumbnail size
		$old_instance['thumbnail_size'] = isset( $new_instance['thumbnail_size'] ) && in_array( $new_instance['thumbnail_size'], $this->pvc_image_sizes, true ) ? $new_instance['thumbnail_size'] : $this->pvc_defaults['thumbnail_size'];

		// booleans
		$old_instance['show_post_views'] = ! empty( $new_instance['show_post_views'] );
		$old_instance['show_post_thumbnail'] = ! empty( $new_instance['show_post_thumbnail'] );
		$old_instance['show_post_excerpt'] = ! empty( $new_instance['show_post_excerpt'] );
		$old_instance['show_post_author'] = ! empty( $new_instance['show_post_author'] );

		// texts
		$old_instance['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : $this->pvc_defaults['title'] );
		$old_instance['no_posts_message'] = sanitize_text_field( isset( $new_instance['no_posts_message'] ) ? $new_instance['no_posts_message'] : $this->pvc_defaults['no_posts_message'] );

		// post types
		if ( isset( $new_instance['post_type'] ) ) {
			$post_types = [];

			// get post types
			$_post_types = Post_Views_Counter()->functions->get_post_types();

			foreach ( $new_instance['post_type'] as $post_type ) {
				if ( isset( $_post_types[$post_type] ) )
					$post_types[] = $post_type;
			}

			$old_instance['post_type'] = array_unique( $post_types );
		} else
			$old_instance['post_type'] = [ 'post' ];

		return $old_instance;
	}
}
