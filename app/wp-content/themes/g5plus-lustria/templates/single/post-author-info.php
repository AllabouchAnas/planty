<?php
/**
 * The template for displaying post-author-info.php
 */
$single_author_info_enable = G5Plus_Lustria()->options()->get_single_author_info_enable();
$author_description = get_the_author_meta('description');
if (($single_author_info_enable !== 'on') || empty($author_description)) return;

?>
<div class="gf-author-info-wrap">
    <div class="gf-author-info">
        <div class="gf-author-avatar">
            <?php
            /**
             * Filter the Arvo author bio avatar size.
             *
             * @since Arvo 1.0
             *
             * @param int $size The avatar height and width size in pixels.
             */
            $author_bio_avatar_size = apply_filters('g5plus_author_bio_avatar_size', 90);
            echo get_avatar(get_the_author_meta('user_email'), $author_bio_avatar_size);
            ?>
        </div>
        <div class="gf-author-content">
            <div class="gf-author-meta">
                <h2 class="gf-author-name"><?php the_author_posts_link(); ?></h2>
                <?php G5Plus_Lustria()->templates()->userSocialNetworks(get_the_author_meta('ID'),'classic'); ?>
            </div>
            <?php if (!empty($author_description)): ?>
                <div class="gf-author-description"><?php echo wp_kses_post($author_description); ?></div>
            <?php endif; ?>
        </div>
    </div>

</div>
