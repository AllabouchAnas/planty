<?php
/**
 * The template for displaying post-tag.php
 */
$single_tag_enable = G5Plus_Lustria()->options()->get_single_tag_enable();
$single_share_enable = G5Plus_Lustria()->options()->get_single_share_enable();
?>
<?php if ( (('on' === $single_tag_enable) && has_tag()) || (('on' === $single_share_enable) && function_exists('G5P'))): ?>
<div class="gf-post-tag-share">
    <?php if(('on' === $single_tag_enable) && has_tag()): ?>
        <div class="gf-post-meta-tag">
            <?php the_tags( '<span>'. esc_html__( 'Tags:', 'g5plus-lustria' ) . '</span><div class="tagcloud">','','</div>'); ?>
        </div>
    <?php endif; ?>
    <?php if(('on' === $single_share_enable) && function_exists('G5P')) {
        do_action('g5plus_single_post_share');
    } ?>
</div>
<?php endif; ?>