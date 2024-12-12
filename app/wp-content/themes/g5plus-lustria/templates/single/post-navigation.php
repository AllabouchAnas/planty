<?php
/**
 * The template for displaying post-navigation.php
 */
$single_navigation_enable = G5Plus_Lustria()->options()->get_single_navigation_enable();

if ($single_navigation_enable !== 'on') return;
$prev_post = get_adjacent_post(false, '', true);
$next_post = get_adjacent_post(false, '', false);
if (!is_object($prev_post) && !is_object($next_post)) return;
?>
<nav class="gf-post-navigation">
    <?php
    $prev_post_class = array('post-prev sm-mg-bottom-30');
    if (is_object($prev_post)) {
        $prev_post_img = wp_get_attachment_image_src(get_post_thumbnail_id($prev_post), 'full');
        if (is_array($prev_post_img)) {
            $prev_post_img_src = $prev_post_img[0];
            $prev_post_bg_class = "post-prev-{$prev_post->ID}";
            $prev_post_background = <<<CSS
				.{$prev_post_bg_class} {
					background-image: url('{$prev_post_img_src}');
				}
CSS;
            G5Plus_Lustria()->custom_css()->addCss($prev_post_background);
            $prev_post_class[] = $prev_post_bg_class;
            $prev_post_class[] = 'post-nav-bg';
        }
    }
    $prev_post_class = implode(' ', $prev_post_class);
    ?>
    <div class="<?php echo esc_attr($prev_post_class); ?>">
        <?php if (is_object($prev_post)): ?>
        <a href="<?php the_permalink($prev_post) ?>"
           title="<?php echo esc_attr($prev_post->post_title); ?>"></a>
        <?php endif; ?>
        <div class="gf-navigation-meta">
            <div class="gf-nav-inner">
                <?php if (is_object($prev_post)): ?>
                    <ul class="gf-post-meta gf-inline primary-font disable-color layout-2">
                        <li class="meta-date">
                            <a href="<?php the_permalink($prev_post); ?>" rel="bookmark" title="<?php echo esc_attr($prev_post->post_title); ?>" class="gsf-link"><span><?php echo get_the_date(get_option('date_format'),$prev_post); ?></span></a>
                        </li>
                    </ul>
                    <h4 class="gf-post-title">
                        <a href="<?php the_permalink($prev_post) ?>"
                           title="<?php echo esc_attr($prev_post->post_title); ?>"><?php echo esc_html($prev_post->post_title); ?></a>
                    </h4>
                <?php else: ?>
                    <span class="no-post"><?php esc_html_e('No Newer Articles', 'g5plus-lustria') ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    $post_type = get_post_type(get_the_ID());
    $post_type_object = get_post_type_object($post_type);
    $post_type_archive_label = $post_type_object->labels->name;
    $post_type_archive_link = get_post_type_archive_link($post_type); ?>
    <?php
    $next_post_class = array('post-next');
    if (is_object($next_post)) {
        $next_post_img = wp_get_attachment_image_src(get_post_thumbnail_id($next_post), 'full');
        if (is_array($next_post_img)) {
            $next_post_img_src = $next_post_img[0];
            $next_post_bg_class = "post-next-{$next_post->ID}";
            $next_post_background = <<<CSS
					.{$next_post_bg_class} {
						background-image: url('{$next_post_img_src}');
					}
CSS;
            G5Plus_Lustria()->custom_css()->addCss($next_post_background);
            $next_post_class[] = $next_post_bg_class;
            $next_post_class[] = 'post-nav-bg';
        }
    }
    $next_post_class = implode(' ', $next_post_class);
    ?>
    <div class="<?php echo esc_attr($next_post_class) ?>">
        <?php if (is_object($next_post)): ?>
        <a href="<?php the_permalink($next_post) ?>"
           title="<?php echo esc_attr($next_post->post_title); ?>"></a>
        <?php endif; ?>
        <div class="gf-navigation-meta">
            <div class="gf-nav-inner">
                <?php if (is_object($next_post)): ?>
                    <ul class="gf-post-meta gf-inline primary-font disable-color layout-2">
                        <li class="meta-date">
                            <a href="<?php the_permalink($next_post); ?>" rel="bookmark" title="<?php echo esc_attr($next_post->post_title); ?>" class="gsf-link"><span><?php echo get_the_date(get_option('date_format'),$next_post); ?></span></a>
                        </li>
                    </ul>
                    <h4 class="gf-post-title">
                        <a href="<?php the_permalink($next_post) ?>"
                           title="<?php echo esc_attr($next_post->post_title); ?>"><?php echo esc_html($next_post->post_title); ?>
                        </a>
                    </h4>
                <?php else: ?>
                    <span class="no-post"><?php esc_html_e('No Older Articles', 'g5plus-lustria') ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
