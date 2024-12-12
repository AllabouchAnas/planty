<?php
/**
 * The template for displaying comments.php
 *
 */
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="gf-comments-area clearfix">
    <?php if (have_comments()) : ?>
        <div class="comments-list clearfix">
            <h4 class="gf-heading-title comments-title">
                <span><?php comments_number(esc_html__('No Comments', 'g5plus-lustria'), esc_html__('One Comment', 'g5plus-lustria'), esc_html__("Comments(%)", 'g5plus-lustria')) ?></span>
            </h4>
            <ol class="comment-list clearfix">
                <?php wp_list_comments(G5Plus_Lustria()->blog()->get_list_comments_args()); ?>
            </ol>
            <?php if (get_comment_pages_count() > 1): ?>
                <nav class="comment-navigation blog-pagination clearfix mg-top-20">
                    <?php $paginate_comments_args = array(
                        'prev_text' => '<i class="fa fa-angle-double-left"></i>',
                        'next_text' => '<i class="fa fa-angle-double-right"></i>',
                    );
                    paginate_comments_links($paginate_comments_args);
                    ?>
                </nav>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php comment_form(G5Plus_Lustria()->blog()->get_comments_form_args()); ?>
</div>
