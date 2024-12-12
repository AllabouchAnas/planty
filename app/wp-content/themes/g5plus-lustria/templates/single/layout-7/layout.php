<?php
/**
 * The template for displaying layout-1.php
 *
 */
add_action('g5plus_before_main_content',array(G5Plus_Lustria()->templates(),'post_single_image'),10);
get_header();
while (have_posts()) : the_post();
	G5Plus_Lustria()->helper()->getTemplate('single/layout-7/content');
endwhile;
get_footer();