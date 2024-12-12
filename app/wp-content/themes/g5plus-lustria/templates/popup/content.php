<?php
/**
 * The template for displaying content.php
 *
 * @package WordPress
 */
$excerpt = get_the_excerpt();
$excerpt = G5Plus_Lustria()->helper()->truncateText($excerpt,300);
?>
<li class="clearfix">
    <?php $thumb = get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>
    <?php if(!empty($thumb)): ?>
        <div class="sa-post-thumbnail">
            <a class="sa-post-thumbnail" href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?></a>
        </div>
    <?php endif; ?>
    <div class="sa-post-content">
        <a class="sa-post-title gsf-link" href="<?php the_permalink() ?>" title="<?php the_title_attribute() ?>"><?php the_title(); ?></a>
        <?php $post_type = get_post_type(get_the_ID());
        if($post_type === 'product'):?>
            <?php $product = wc_get_product( get_the_ID() ); ?>
            <div class="sa-product-price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
        <?php else: ?>
            <div class="sa-post-meta"><i class="fa fa-calendar"></i> <?php echo  get_the_date(get_option('date_format'));?></div>
        <?php endif; ?>
    </div>
</li>
