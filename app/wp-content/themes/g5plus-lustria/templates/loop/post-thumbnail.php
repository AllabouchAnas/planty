<?php
/**
 * The template for displaying post-thumbnail-simple.php
 * @var $post_id
 * @var $image_size
 * @var $placeholder_enable
 * @var $first_image_enable,
 * @var $display_permalink
 * @var $image_mode
 * @var $image_ratio
 */
global $hasThumb;
$hasThumb = false;
ob_start();
remove_action('g5plus_before_post_image',array(G5Plus_Lustria()->templates(),'zoom_image_thumbnail'));
?>
<?php if (has_post_thumbnail($post_id)): ?>
    <?php $hasThumb = true; ?>
    <?php G5Plus_Lustria()->blog()->render_post_image_markup(array(
        'post_id' => $post_id,
        'image_id' => get_post_thumbnail_id($post_id),
        'image_size' => $image_size,
        'display_permalink' => $display_permalink,
        'image_mode' => $image_mode,
        'image_ratio' => $image_ratio
    )); ?>
<?php elseif ($first_image_enable === true): ?>
    <?php
    global $post;
    if ( isset( $post->post_content ) ) {
        if ( preg_match( "'<\s*img\s.*?src\s*=\s*
                            ([\"\'])?
                            (?(1) (.*?)\\1 | ([^\s\>]+))'isx", $post->post_content, $matched ) ) {
            $img_src = esc_url( $matched[2] );
            $img_src = preg_replace('/-(\d+)x(\d+)\./i', '.', $img_src);
            if(function_exists('GSF')) {
                $hasThumb = true;
                $img_id = GSF()->helper()->getAttachmentIdByUrl($img_src);;
                G5Plus_Lustria()->blog()->render_post_image_markup(array(
                    'post_id' => $post_id,
                    'image_id' => $img_id,
                    'image_size' => $image_size,
                    'display_permalink' => $display_permalink,
                    'image_mode' => $image_mode,
                    'image_ratio' => $image_ratio
                ));
            }
        }
    }
    ?>
<?php endif; ?>
<?php if (!$hasThumb && $placeholder_enable === true): ?>
    <?php
    $hasThumb = true;
    $default_thumbnail_image = G5Plus_Lustria()->options()->get_default_thumbnail_image();
    if(!empty($default_thumbnail_image) && !empty($default_thumbnail_image['id']) ) {
        G5Plus_Lustria()->blog()->render_post_image_markup(array(
            'post_id' => $post_id,
            'image_id' => $default_thumbnail_image['id'],
            'image_size' => $image_size,
            'display_permalink' => $display_permalink,
            'image_mode' => $image_mode,
            'image_ratio' => $image_ratio
        ));
    } else { ?>
        <div class="entry-thumbnail-overlay thumbnail-size-<?php echo esc_attr($image_size); ?>  thumbnail-size-<?php echo esc_attr($image_ratio) ?> placeholder-image">
        </div>
    <?php } ?>
<?php endif; ?>
<?php $thumbnail_markup = ob_get_clean(); ?>
<?php if ($hasThumb === true): ?>
    <?php
    $wrapper_classes = array(
        'entry-thumb-wrap',
        "entry-thumb-mode-{$image_mode}",
        "entry-thumb-format-" . get_post_format()
    );
    $wrapper_class = implode(' ', $wrapper_classes);
    ?>
    <div class="<?php echo esc_attr($wrapper_class); ?>">
        <?php printf('%s',$thumbnail_markup); ?>
        <?php
        do_action('g5plus_after_post_thumbnail', array('image_size' => $image_size))
        ?>
    </div>
<?php endif;
add_action('g5plus_before_post_image',array(G5Plus_Lustria()->templates(),'zoom_image_thumbnail'));