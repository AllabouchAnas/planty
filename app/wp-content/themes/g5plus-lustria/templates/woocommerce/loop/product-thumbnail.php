<?php
/**
 * @var $post_id
 * @var $image_size
 * @var $image_ratio
 * @var $placeholder_enable
 * @var $image_mode
 * @var $display_permalink
 */
global $product;

remove_action('g5plus_before_post_image',array(G5Plus_Lustria()->templates(),'zoom_image_thumbnail'));
?>
<?php if (has_post_thumbnail($post_id)): ?>
    <?php
    $image_id = get_post_thumbnail_id($post_id);
    $product_image_hover_effect = G5Plus_Lustria()->options()->get_product_image_hover_effect();
    $secondary_image_id = '';
    if ($product_image_hover_effect !== 'none') {
        $attachment_ids = $product->get_gallery_image_ids();
        if ($attachment_ids) {
            $secondary_image_id = $attachment_ids[0];
        }
    }
    ?>
    <?php if ($secondary_image_id === ''): ?>
        <div class="product-thumb-one">
            <?php G5Plus_Lustria()->blog()->render_post_image_markup(array(
                'post_id'           => $post_id,
                'image_id'          => $image_id,
                'image_size'        => $image_size,
                'image_ratio'       => $image_ratio,
                'display_permalink' => $display_permalink,
                'image_mode'        => $image_mode,
            ));
            ?>
        </div>
    <?php else: ?>
        <?php $gallery_id = rand(); ?>
        <div class="product-images-hover <?php echo esc_attr($product_image_hover_effect); ?>">
            <div class="product-thumb-primary">
                <?php G5Plus_Lustria()->blog()->render_post_image_markup(array(
                    'post_id'           => $post_id,
                    'image_id'          => $image_id,
                    'image_size'        => $image_size,
                    'image_ratio'       => $image_ratio,
                    'display_permalink' => $display_permalink,
                    'image_mode'        => $image_mode,
                    'gallery_id' => $gallery_id
                ));
                ?>
            </div>
            <div class="product-thumb-secondary">
                <?php G5Plus_Lustria()->blog()->render_post_image_markup(array(
                    'post_id'           => $post_id,
                    'image_id'          => $secondary_image_id,
                    'image_size'        => $image_size,
                    'image_ratio'       => $image_ratio,
                    'display_permalink' => $display_permalink,
                    'image_mode'        => $image_mode,
                    'gallery_id' => $gallery_id
                ));
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php elseif ($placeholder_enable === true): ?>
    <div class="entry-thumbnail">
        <div class="entry-thumbnail-overlay thumbnail-size-<?php echo esc_attr($image_size); ?> placeholder-image">
        </div>
    </div>
<?php endif; ?>
<?php add_action('g5plus_before_post_image',array(G5Plus_Lustria()->templates(),'zoom_image_thumbnail')); ?>
