<?php
/**
 * The template for displaying post-image.php
 *
 */
global $hasThumb;
$hasThumb = false;
ob_start();
$single_post_layout = G5Plus_Lustria()->options()->get_single_post_layout();
$image_size = 'blog-large-full';
$sidebar_layout = G5Plus_Lustria()->options()->get_sidebar_layout();
$sidebar = G5Plus_Lustria()->cache()->get_sidebar();
if ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)) {
    $image_size = 'blog-large';
}

$image_mode = 'image';
if (in_array($single_post_layout, array('layout-6', 'layout-7'))) {
    $image_mode = 'background';
    $image_size = 'full';
}
$gallery_id = '';
$post_id = get_the_ID();
if (has_post_format('gallery')): ?>
    <?php $gallery_images = get_post_meta($post_id, 'gf_format_gallery_images', true); ?>
    <?php if ($gallery_images !== ''): ?>
        <?php $gallery_images = preg_split('/\|/', $gallery_images);
        $owl_args = array(
            'items' => 1,
            'loop' => false,
            'autoHeight' => true,
            'nav' => true
        );
        $gallery_id = rand();
        $hasThumb = true;
        ?>
        <div class="owl-carousel owl-theme nav-small nav-abs-top-right" data-owl-options='<?php echo json_encode($owl_args); ?>'>
            <?php foreach ($gallery_images as $image_id) : ?>
                <?php G5Plus_Lustria()->blog()->render_post_image_markup(array(
                    'post_id' => $post_id,
                    'image_id' => $image_id,
                    'image_size' => $image_size,
                    'gallery_id' => $gallery_id,
                    'display_permalink' => false,
                    'image_mode' => $image_mode
                )); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php elseif (has_post_format('video')): ?>
    <?php $video_embed = get_post_meta($post_id, 'gf_format_video_embed', true); ?>
    <?php if ($video_embed !== ''): ?>
        <?php if (wp_oembed_get($video_embed) !== false): ?>
            <?php $hasThumb = true; ?>
            <div class="embed-responsive embed-responsive-16by9 thumbnail-size-<?php echo esc_attr($image_size); ?>">
                <?php echo wp_oembed_get($video_embed, array('wmode' => 'transparent')); ?>
        </div>
        <?php else: ?>
            <?php $hasThumb = true; ?>
            <div class="entry-thumbnail embed-responsive embed-responsive-16by9 thumbnail-size-<?php echo esc_attr($image_size); ?>">
                <?php echo wp_kses_post($video_embed); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php elseif (has_post_format('audio')): ?>
    <?php $audio_embed = get_post_meta($post_id, 'gf_format_audio_embed', true); ?>
    <?php if ($audio_embed !== ''): ?>
        <?php $hasThumb = true; ?>
        <div class="embed-responsive thumbnail-size-<?php echo esc_attr($image_size); ?>">
            <?php if (wp_oembed_get($audio_embed)) : ?>
                <?php echo wp_oembed_get($audio_embed); ?>
            <?php else : ?>
                <?php echo wp_kses_post($audio_embed); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif;?>

<?php
    if ($hasThumb == false && has_post_thumbnail($post_id)) {
        $hasThumb = true;
        G5Plus_Lustria()->blog()->render_post_image_markup(array(
            'post_id' => $post_id,
            'image_id' => get_post_thumbnail_id($post_id),
            'image_size' => 'full',
            'gallery_id' => $gallery_id,
            'display_permalink' => false,
            'image_mode' => $image_mode
        ));
    }
$thumbnail_markup = ob_get_clean(); ?>
<?php if ($hasThumb): ?>
    <?php
    $wrapper_classes = array(
        'entry-thumb-wrap',
        'entry-thumb-single',
        "entry-thumb-mode-{$image_mode}",
        "entry-thumb-format-" . get_post_format()
    );
    $wrapper_class = implode(' ', $wrapper_classes);
    ?>
    <div class="<?php echo esc_attr($wrapper_class); ?>">
        <?php printf('%s',$thumbnail_markup); ?>
    </div>
<?php endif;
