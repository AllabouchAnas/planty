<?php
/**
 * The template for displaying content-grid.php
 *
 * @var $image_size
 * @var $image_ratio
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder_enable
 * @var $first_image_enable
 * @var $post_attributes
 * @var $post_inner_attributes
 * @var $post_link
 */
?>
<article <?php echo implode(' ', $post_attributes); ?> <?php post_class($post_class) ?>>
    <div <?php echo implode(' ', $post_inner_attributes); ?> class="<?php echo esc_attr($post_inner_class); ?>">
        <?php G5Plus_Lustria()->blog()->render_post_thumbnail_markup(array(
            'image_size' => $image_size,
            'placeholder_enable' => $placeholder_enable,
            'first_image_enable' => $first_image_enable,
            'image_ratio' => $image_ratio,
            'image_mode'         => 'image'
        )); ?>
        <div class="gf-post-content">
            <?php G5Plus_Lustria()->helper()->getTemplate('loop/post-title', array('post_link' => $post_link)) ?>
            <?php G5Plus_Lustria()->templates()->post_meta(array(
                'cat' => true,
                'author' => true,
                'date' => true,
                'comment' => true,
                'edit' => true,
                'view' => true,
                'like' => true
            )); ?>
            <div class="gf-post-excerpt">
                <?php the_excerpt(); ?>
            </div>
        </div>
    </div>
</article>