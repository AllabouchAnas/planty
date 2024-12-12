<?php
/**
 * The template for displaying category.php
 */
G5Plus_Lustria()->helper()->get_header();
$blog_cate_filter = G5Plus_Lustria()->options()->get_blog_cate_filter();
$query_args = $settings = null;
$current_cat = get_category( get_query_var( 'cat' ) );
if('' !== $blog_cate_filter) {
    $settings['category_filter_enable'] = true;
    $settings['current_cat'] = $current_cat->term_id;
}
G5Plus_Lustria()->blog()->archive_markup($query_args,$settings);
G5Plus_Lustria()->helper()->get_footer();