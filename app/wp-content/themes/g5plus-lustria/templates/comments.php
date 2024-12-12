<?php
/**
 * The template for displaying comments.php
 * @var $comment
 * @var $args
 * @var $depth
 */
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
        <?php echo get_avatar($comment, $args['avatar_size']); ?>
        <div class="comment-text gf-entry-content">
            <h4 class="author-name"><?php echo get_comment_author_link() ?></h4>
            <div class="gf-entry-content">
                <?php comment_text() ?>
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php esc_html_e('Your comment is awaiting moderation.', 'g5plus-lustria'); ?></em>
                <?php endif; ?>
            </div>
            <ul class="comment-meta-footer d-flex list-inline flex-wrap align-items-center">
                <li class="comment-meta-date">
                    <?php echo (get_comment_date(get_option('date_format'))) ; ?>
                </li>
                <?php comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'        => '<li>',
                    'after'         => '</li>',
                ))) ?>
                <?php edit_comment_link(esc_html__('Edit','g5plus-lustria'),'<li>','</li>'); ?>
            </ul>
        </div>
    </div>
