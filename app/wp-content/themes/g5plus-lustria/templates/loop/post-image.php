<?php
/**
 * The template for displaying post-image.php
 * @var $post_id
 * @var $image_id
 * @var $image_size
 * @var $image_ratio
 * @var $gallery_id
 * @var $display_permalink
 * @var $image_mode
 * @var $class
 */
$image_sizes =  G5Plus_Lustria()->blog()->get_image_sizes();
$image_attributes = array();
$lazy_load_images = G5Plus_Lustria()->options()->get_lazy_load_images();
$post_link = has_post_format('link', $post_id) ? get_post_meta($post_id, 'gf_format_link_url', true) : get_the_permalink($post_id);
?>
<div class="<?php echo esc_attr($class) ?>">
    <?php
    /**
     * @hooked - zoom_image_thumbnail - 10
     **/
    do_action('g5plus_before_post_image', array(
        'post_id'    => $post_id,
        'image_id'   => $image_id,
        'image_size' => $image_size,
        'gallery_id' => $gallery_id
    ));
    ?>
    <?php if (array_key_exists($image_size, $image_sizes)) {
        $sizes = preg_split('/x/', $image_sizes[$image_size]);
        $image = G5Plus_Lustria()->image_resize()->resize(array(
            'image_id' => $image_id,
            'width'    => $sizes[0],
            'height'   => $sizes[1]
        ));
        if ($sizes[1] === '0') {
            $image_mode = 'image';
        }

    } elseif (preg_match('/x/',$image_size)) {
        $sizes = preg_split('/x/', $image_size);
        $image_width = isset($sizes[0]) ? intval($sizes[0]) : 0;
        $image_height = isset($sizes[1]) ? intval($sizes[1]) : 0;
        $image =  G5Plus_Lustria()->image_resize()->resize(array(
            'image_id' => $image_id,
            'width' => $image_width,
            'height' => $image_height
        ));
        if ($image_height === 0) {
            $image_mode = 'image';
        }
    } else {
        $imageArr = wp_get_attachment_image_src($image_id, $image_size);
        $image = array(
            'url'    => isset($imageArr[0]) ? $imageArr[0] : '',
            'width'  => isset($imageArr[1]) ? $imageArr[1] : '',
            'height' => isset($imageArr[2]) ? $imageArr[2] : '',
        );

        if ($image['height'] === '') {
            $image_mode = 'image';
        }
    } ?>

    <?php
    if ($lazy_load_images === 'on' && isset($image['width']) && !empty($image['width']) && isset($image['height']) && !empty($image['height'])) {
        $image_lazy_width = 20;
        $image_lazy_height = ($image['height']  / $image['width']) * $image_lazy_width;
        $image_lazy = G5Plus_Lustria()->image_resize()->resize(array(
            'image_id' => $image_id,
            'width'    => $image_lazy_width,
            'height'   => $image_lazy_height
        ));
    }
    ?>
    <?php if ($image_mode === 'background'): ?>
        <?php
        $image_classes = array(
            'entry-thumbnail-overlay',
            'placeholder-image'
        );
        if (empty($image_ratio)) {
            if (preg_match('/x/',$image_size)) {
                if (($image['width'] > 0) && ($image['height'] > 0)) {
                    $ratio = ($image['height']/$image['width']) * 100;
                    $custom_css = <<<CSS
                .thumbnail-size-{$image_size}:before{
                    padding-top: {$ratio}%;
                }
CSS;
                    G5Plus_Lustria()->custom_css()->addCss($custom_css,"thumbnail-size-{$image_size}");
                }
            }
            $image_classes[] = "thumbnail-size-{$image_size}";
        } else {
            $image_classes[] = "thumbnail-size-{$image_ratio}";
            if (!in_array($image_ratio,array('1x1','3x4','4x3','16x9','9x16'))) {
                $image_ratio_sizes = preg_split('/x/', $image_ratio);
                $image_ratio_width = isset($image_ratio_sizes[0]) ? intval($image_ratio_sizes[0]) : 0;
                $image_ratio_height = isset($image_ratio_sizes[1]) ? intval($image_ratio_sizes[1]) : 0;

                if (($image_ratio_width > 0) && ($image_ratio_height > 0)) {
                    $ratio = ($image_ratio_height/$image_ratio_width) * 100;
                    $custom_css = <<<CSS
                /*.thumbnail-size-{$image_ratio}:before{
                    padding-top: {$ratio}%;
                }*/
                .placeholder-image{
                 --g5-image-ratio :{$ratio}%;
                 }
CSS;
                    G5Plus_Lustria()->custom_css()->addCss($custom_css,"thumbnail-size-{$image_ratio}");
                }
            }
        }

	    if (isset($image['url']) && ($image['url'] !== '')) {
		    $image_style = array();
		    if ($lazy_load_images === 'on') {
			    $image_style[] = 'background-image: url(' . esc_url($image_lazy['url']) . ') ';

			    $image_attributes[] = 'data-original="' . esc_url($image['url']) . '"';
			    $image_classes[] = 'gf-lazy';
			    //$image_attributes[] = 'style="background-image: url(' . esc_url($image_lazy['url']) . '); "';
		    } else {
			    $image_style[] = 'background-image: url(' . esc_url($image['url']) . ')';
			    //$image_attributes[] = 'style="background-image: url(' . esc_url($image['url']) . ');"';
		    }
		    if (isset($ratio)) {
			    $image_style[] = sprintf('--g5-image-ratio : %s', $ratio . '%');
		    }
		    $image_attributes[]= sprintf('style="%s"', join(';', $image_style));
	    }
        $image_class = implode(' ', array_filter($image_classes));
        ?>
        <?php if ($display_permalink) : ?>
            <a <?php echo implode(' ', $image_attributes); ?> class="<?php echo esc_attr($image_class)?>" href="<?php echo esc_url($post_link)?>" title="<?php the_title_attribute(array('post' => $post_id)) ?>"></a>
        <?php else: ?>
            <div <?php echo implode(' ', $image_attributes); ?> class="<?php echo esc_attr($image_class)?>" title="<?php the_title_attribute(array('post' => $post_id)) ?>"></div>
        <?php endif; ?>
    <?php else: ?>
        <?php
        $image_classes = array(
            'img-responsive',
            'wp-post-image'
        );

        if (isset($image['width']) && ($image['width'] !== '')) {
            $image_attributes[] = 'width="'. esc_attr($image['width']) .'"';
            if ($lazy_load_images === 'on') {
                $image_attributes[] = 'style="width:'. esc_attr($image['width']) .'px"';
            }
        }

        if (isset($image['height']) && ($image['height'] !== '')) {
            $image_attributes[] = 'height="'. esc_attr($image['height']) .'"';
        }

        if (isset($image['url']) && ($image['url'] !== '')) {

            if ($lazy_load_images === 'on') {
                $image_attributes[] = 'data-original="' . esc_url($image['url']) . '"';
                $image_attributes[] = 'src="' . esc_url($image_lazy['url']) . '"';
                $image_classes[] = 'gf-lazy';

            } else {
                $image_attributes[] = 'src="' . esc_url($image['url']) . '"';
            }
        }
        $image_class = implode(' ', array_filter($image_classes));
        ?>

        <?php if ($display_permalink) : ?>
            <a class="entry-thumbnail-overlay" href="<?php echo esc_url($post_link)?>" title="<?php the_title_attribute(array('post' => $post_id)) ?>">
                <img <?php echo implode(' ', $image_attributes); ?> class="<?php echo esc_attr($image_class)?>" alt="<?php the_title_attribute(array('post' => $image_id )) ?>">
            </a>
        <?php else: ?>
            <div class="entry-thumbnail-overlay" title="<?php the_title_attribute(array('post' => $post_id)) ?>">
                <img <?php echo implode(' ', $image_attributes); ?> class="<?php echo esc_attr($image_class)?>" alt="<?php the_title_attribute(array('post' => $image_id )) ?>">
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>


