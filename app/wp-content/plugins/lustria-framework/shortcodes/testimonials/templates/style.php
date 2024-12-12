<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/11/2016
 * Time: 10:25 AM
 * @var $name
 * @var $job
 * @var $bio
 * @var $image_src
 * @var $url
 * @var $quote_image
 * @var $user_rating
 */

$bq_image_src = '';
if (!empty($quote_image)) {
    $bq_image_src = wp_get_attachment_image_src($quote_image, 'full');
    if ($bq_image_src && !empty($bq_image_src[0])) {
        $bq_image_src = $bq_image_src[0];
    }
}
?>
<div class="testimonial-item">
    <?php if(!empty($bq_image_src)): ?>
        <img class="testimonials-before" src="<?php echo esc_url($bq_image_src); ?>" alt="<?php echo esc_attr($name); ?>">
    <?php endif; ?>
    <div class="testimonials-content">
        <?php if (!empty($bio)): ?>
            <p><?php echo wp_kses_post($bio); ?></p>
        <?php endif; ?>
    </div>
    <?php if (!empty($name) || !empty($job) || !empty($image_src)): ?>
        <div class="author-info d-flex flex-wrap align-items-center justify-content-left clearfix<?php echo empty($image_src) ? '' : ' author-has-thumb' ?>">
            <?php if (!empty($image_src)): ?>
                <div class="author-avatar">
                    <img src="<?php echo esc_url($image_src); ?>" title="<?php echo esc_attr($name); ?>"
                         alt="<?php echo esc_attr($name); ?>">
                </div>
            <?php endif; ?>
            <div class="author-attr">
                <?php if (!empty($name)): ?>
                    <h6 class="author-name">
                        <?php if (!empty($url)): ?>
                        <a href="<?php echo esc_url($url) ?>">
                            <?php endif;
                            echo esc_attr($name);
                            if (!empty($url)): ?>
                        </a>
                    <?php endif; ?>
                    </h6>
                <?php endif; ?>
                <?php if (!empty($job)): ?>
                    <span class="author-job">/ <?php echo esc_html($job); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>