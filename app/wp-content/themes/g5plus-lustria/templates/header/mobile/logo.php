<?php
/**
 * The template for displaying logo.php
 *
 */

$logo = G5Plus_Lustria()->options()->get_mobile_logo();
$logo_retina = G5Plus_Lustria()->options()->get_mobile_logo_retina();
$sticky_logo = G5Plus_Lustria()->options()->get_mobile_sticky_logo();
$sticky_logo_retina = G5Plus_Lustria()->options()->get_mobile_sticky_logo_retina();
if (!$logo || !isset($logo['url']) || empty($logo['url'])) {
    $logo = G5Plus_Lustria()->options()->get_logo();
    $logo_retina = G5Plus_Lustria()->options()->get_logo_retina();
    $sticky_logo = G5Plus_Lustria()->options()->get_sticky_logo();
    $sticky_logo_retina = G5Plus_Lustria()->options()->get_sticky_logo_retina();
}
$logo_id =  absint(isset($logo['id']) ? $logo['id'] : 0);
$logo_url = isset($logo['url']) ? $logo['url'] : '';


$logo_retina_url = isset($logo_retina['url']) ? $logo_retina['url'] : '';


$sticky_logo_id = absint(isset($sticky_logo['id']) ? $sticky_logo['id'] : 0);
$sticky_logo_url = isset($sticky_logo['url']) ? $sticky_logo['url'] : '';


$sticky_logo_retina_url = isset($sticky_logo_retina['url']) ? $sticky_logo_retina['url'] : '';

$mobile_logo_classes = array(
    'mobile-logo-header',
    'align-items-center d-flex'
);

if ($sticky_logo_url) {
    $mobile_logo_classes[] = 'has-logo-sticky';
}

$logo_title = esc_attr(get_bloginfo('name', 'display')) . '-' . get_bloginfo('description', 'display');
$logo_text = get_bloginfo('name', 'display');

$logo_attributes = array();
if ($logo_retina_url && ($logo_retina_url != $logo_url)) {
    $logo_attributes[] = 'data-retina="' . esc_url($logo_retina_url) . '"';
}

$logo_sticky_attributes = array();
if ($sticky_logo_retina_url && ($sticky_logo_retina_url != $sticky_logo_url)) {
    $logo_sticky_attributes[] = 'data-retina="' . esc_url($sticky_logo_retina_url) . '"';
}
$mobile_logo_class = implode(' ', array_filter($mobile_logo_classes));




if (!empty($logo_id)) {
    $logo_attr = wp_get_attachment_image_src($logo_id, 'full');
    if ($logo_attr) {
        $logo_width = isset($logo_attr[1]) ? $logo_attr[1] : '';
        $logo_height = isset($logo_attr[2]) ? $logo_attr[2] : '';

        if (!empty($logo_width)) {
            $logo_attributes[] = sprintf('width="%s"',esc_attr($logo_width));
        }

        if (!empty($logo_height)) {
            $logo_attributes[] = sprintf('height="%s"',esc_attr($logo_height));
        }
    }
}

if (!empty($sticky_logo_id)) {
    $sticky_logo_attr = wp_get_attachment_image_src($sticky_logo_id, 'full');
    if ($sticky_logo_attr) {
        $sticky_logo_width = isset($sticky_logo_attr[1]) ? $sticky_logo_attr[1] : '';
        $sticky_logo_height = isset($sticky_logo_attr[2]) ? $sticky_logo_attr[2] : '';

        if (!empty($sticky_logo_width)) {
            $logo_sticky_attributes[] = sprintf('width="%s"',esc_attr($sticky_logo_width));
        }

        if (!empty($sticky_logo_height)) {
            $logo_sticky_attributes[] = sprintf('height="%s"',esc_attr($sticky_logo_height));
        }
    }
}

?>
<div class="<?php echo esc_attr($mobile_logo_class) ?>">
	<a class="gsf-link main-logo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
		<?php if (!empty($logo_url)): ?>
			<img <?php echo implode(' ', $logo_attributes); ?> src="<?php echo esc_url($logo_url) ?>" alt="<?php echo esc_attr($logo_title) ?>">
		<?php else: ?>
			<h2 class="logo-text"><?php echo esc_html($logo_text); ?></h2>
		<?php endif; ?>
	</a>
    <?php if ($sticky_logo_url): ?>
        <a class="sticky-logo" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
            <img <?php echo implode(' ', $logo_sticky_attributes); ?> src="<?php echo esc_url($sticky_logo_url) ?>" alt="<?php echo esc_attr($logo_title) ?>">
        </a>
    <?php endif; ?>
</div>


