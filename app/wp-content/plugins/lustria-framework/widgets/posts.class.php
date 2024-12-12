<?php
if (!defined('ABSPATH')) {
    exit;
//	Exit if accessed directly
}
if (!class_exists('G5P_Widget_Posts')) {
    class G5P_Widget_Posts extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'gsf-widget-posts';
            $this->widget_id = 'gsf-posts';
            $this->widget_name = esc_html__('G5Plus: Posts', 'lustria-framework');

            $this->settings = array(
                'fields' => array(
                    array(
                        'id'      => 'title',
                        'title'   => esc_html__('Title:', 'lustria-framework'),
                        'type'    => 'text',
                        'default' => '',
                    ),
                    array(
                        'id'      => 'source',
                        'type'    => 'select',
                        'title'   => esc_html__('Source', 'lustria-framework'),
                        'default' => 'recent',
                        'options' => array(
                            'random'   => esc_html__('Random', 'lustria-framework'),
                            'popular'  => esc_html__('Popular', 'lustria-framework'),
                            'recent'   => esc_html__('Recent', 'lustria-framework'),
                            'oldest'   => esc_html__('Oldest', 'lustria-framework'),
                        )
                    ),
                    array(
                        'id'         => 'posts_per_page',
                        'type'       => 'text',
                        'input_type' => 'number',
                        'title'      => esc_html__('Number of posts to show:', 'lustria-framework'),
                        'default'    => '4',
                    ),
                )
            );
            parent::__construct();
        }

        function widget($args, $instance)
        {
            if (!function_exists('G5Plus_Lustria')) return;
            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            $source = (!empty($instance['source'])) ? $instance['source'] : 'recent';
            $posts_per_page = (!empty($instance['posts_per_page'])) ? absint($instance['posts_per_page']) : 4;

            $query_args = array(
                'posts_per_page'      => $posts_per_page,
                'no_found_rows'       => true,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'post_type'           => 'post',
            );

            $query_order_args = array();
            switch ($source) {
                case 'random' :
                    $query_order_args = array(
                        'orderby' => 'rand',
                        'order'   => 'DESC',
                    );
                    break;
                case 'popular':
                    $query_order_args = array(
                        'orderby' => 'comment_count',
                        'order'   => 'DESC',
                    );
                    break;
                case 'recent':
                    $query_order_args = array(
                        'orderby' => 'post_date',
                        'order'   => 'DESC',
                    );
                    break;
                case 'oldest':
                    $query_order_args = array(
                        'orderby' => 'post_date',
                    );
                    break;
            }

            $query_args = array_merge($query_args, $query_order_args);

            $r = new WP_Query($query_args);
            if ($r->have_posts()) :
                echo wp_kses_post($args['before_widget']);
                if ($title) {
                    echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
                } ?>
                <div class="gf-blog-wrap clearfix">
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                        <article <?php post_class("clearfix post-default post-widget"); ?>>
                            <div class="gf-post-inner clearfix">
                                <?php
                                $post_link = has_post_format('link') ? get_post_meta(get_the_ID(), 'gf_format_link_url', true) : get_the_permalink();
                                G5Plus_Lustria()->helper()->getTemplate('loop/post-title',array('post_link' => $post_link));
                                G5Plus_Lustria()->templates()->post_meta(array(
                                    'date' => true,
                                    'extend_class' => 'layout-2'
                                ));
                                ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php echo wp_kses_post($args['after_widget']); ?>
                <?php
                // Reset the global $the_post as this query will have stomped on it
                wp_reset_postdata();
            endif;
        }
    }
}
