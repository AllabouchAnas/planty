<?php
/**
 * The template for displaying content-single.php
 *
 */
?>
<div class="gf-single-wrap clearfix">
    <article id="post-<?php the_ID(); ?>" <?php post_class('post-single clearfix'); ?>>
        <?php G5Plus_Lustria()->templates()->post_single_image(); ?>
        <div class="gf-post-meta-top">
            <?php G5Plus_Lustria()->helper()->getTemplate('single/post-title') ?>
            <?php G5Plus_Lustria()->templates()->post_meta(array(
                'cat' => true,
                'author' => true,
                'date' => true,
                'comment' => true,
                'edit' => true,
                'view' => true,
                'like' => true
            )); ?>
        </div>
        <div class="gf-entry-content clearfix">
            <?php
            the_content();
            G5Plus_Lustria()->blog()->link_pages();
            ?>
        </div>
        <?php
        /**
         * @hooked - post_single_tag_share
         *
         **/
        do_action('g5plus_single_post_tag_share')
        ?>
    </article>
    <?php
    /**
     * @hooked - post_single_navigation - 15
     * @hooked - post_single_author_info - 20
     * @hooked - post_single_related - 25
     * @hooked - post_single_comment - 30
     *
     **/
    do_action('g5plus_after_single_post')
    ?>
</div>
