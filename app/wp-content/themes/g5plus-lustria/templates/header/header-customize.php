<?php
/**
 * The template for displaying header-customize
 *
 * @var $customize_location
 * @var $canvas_position
 */
$header_customize = G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}");
unset($header_customize['sort_order']);
//if (sizeof($header_customize) == 0) return;
$wrap_classes = array(
	'header-customize',
	"header-customize-{$customize_location}",
	'gf-inline',
    'd-flex align-items-center'
);

$custom_css = G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}_custom_css");
if (!empty($custom_css)) {
	$wrap_classes[] = $custom_css;
}

$customize_item_separator = G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}_separator");
$header_layout = G5Plus_Lustria()->options()->get_header_layout();
if(in_array($header_layout, array('header-8', 'header-9','header-11', 'header-12'))) {
    $customize_item_separator = '';
}
$separator_class = '';
if('on' === $customize_item_separator) {
    $separator_bg_color = G5Plus_Lustria()->options()->getOptions("header_customize_{$customize_location}_separator_bg_color");
    $separator_class = 'separator-' . uniqid();
    $separator_css = <<<CSS
	.{$separator_class} .header-customize-separator {
		background-color: {$separator_bg_color};
	}
CSS;
    GSF()->customCss()->addCss($separator_css);
}
$wrap_class = implode(' ', array_filter($wrap_classes));
$index = 0;
?>
<?php if (!empty($header_customize)): ?>
<ul class="<?php echo esc_attr($wrap_class); ?>">
	<?php if (is_array($header_customize)) : ?>
		<?php foreach ($header_customize as $item): ?>
            <?php if($index != 0 && 'on' === $customize_item_separator): ?>
                <li class="customize-separator <?php echo esc_attr($separator_class); ?>">
                    <?php G5Plus_Lustria()->helper()->getTemplate("header/customize-item/separator"); ?>
                </li>
            <?php endif; ?>
			<li class="customize-<?php echo esc_attr($item); ?>">
				<?php G5Plus_Lustria()->helper()->getTemplate("header/customize-item/{$item}", array('customize_location' => $customize_location, 'canvas_position' => $canvas_position)); ?>
			</li>
            <?php $index++; ?>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
<?php endif; ?>
