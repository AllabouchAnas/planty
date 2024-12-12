<?php
/**
 * The template for displaying content-page
 */
?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('page gf-entry-content clearfix'); ?>>

        <?php
        the_content();
        G5Plus_Lustria()->blog()->link_pages();
        ?>
    </div>
<?php
/**
 * @hooked - post_single_comment - 5
 *
 **/
do_action('g5plus_after_single_page');
