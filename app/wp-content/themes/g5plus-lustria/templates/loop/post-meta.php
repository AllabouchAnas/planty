<?php
/**
 * The template for displaying post-meta
 *
 * @var $cat
 * @var $author
 * @var $date
 * @var $comment
 * @var $edit
 * @var $view
 * @var $like
 * @var $extend_class
 */
$wrapper_classes = array(
    'gf-post-meta',
    'gf-inline',
    'primary-font',
    'disable-color',
    $extend_class
);
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<ul class="<?php echo esc_attr($wrapper_class)?>">
    <?php if ($author): ?>
        <li class="gf-post-author-meta">
            <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )) ; ?>" title="<?php esc_attr_e('Browse Author Articles','g5plus-lustria') ?>">
                <i class="far fa-user"></i> <span><?php the_author(); ?></span>
            </a>
        </li>
    <?php endif; ?>
    <?php if ($date): ?>
        <li class="meta-date">
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="gsf-link"><i class="far fa-calendar"></i><span><?php echo get_the_date(get_option('date_format')); ?></span></a>
        </li>
    <?php endif; ?>
    <?php if ($comment && (comments_open() || get_comments_number())) : ?>
        <li class="meta-comment">
            <?php comments_popup_link('<i class="far fa-comment"></i>' . '<span>' . esc_html__( '0 Comments', 'g5plus-lustria' ). '</span>',
                '<i class="far fa-comment"></i>' . '<span>' . esc_html__( '1 Comment', 'g5plus-lustria' ). '</span>',
                '<i class="far fa-comments"></i><span>% '. esc_html__( 'Comments', 'g5plus-lustria' ) .'</span>'); ?>
        </li>
    <?php endif; ?>
    <?php if ($cat) : ?>
        <li class="gf-post-cat-meta">
            <i class="far fa-folder-open"></i>
            <?php echo get_the_category_list(' / '); ?>
        </li>
    <?php endif; ?>
    <?php if ($view) {G5Plus_Lustria()->templates()->post_view();}  ?>
    <?php if ($like) {G5Plus_Lustria()->templates()->post_like();}  ?>
    <?php if ($edit) {edit_post_link(esc_html__('Edit', 'g5plus-lustria'), '<li class="edit-link"><i class="far fa-pencil"></i>', '</li>');}?>
</ul>