<?php
/**
 * The template for displaying top-drawer
 */
$top_drawer_mode = G5Plus_Lustria()->options()->get_top_drawer_mode();
if ($top_drawer_mode === 'hide') return;
$content_full_width = G5Plus_Lustria()->options()->get_top_drawer_content_full_width();
$content_block = G5Plus_Lustria()->options()->get_top_drawer_content_block();
$mobile_top_drawer_enable = G5Plus_Lustria()->options()->get_mobile_top_drawer_enable();
$skin = G5Plus_Lustria()->options()->get_top_drawer_skin();
$border = G5Plus_Lustria()->options()->get_top_drawer_border();

$wrapper_classes = array(
	'top-drawer-wrap',
	"top-drawer-mode-{$top_drawer_mode}"
);
$inner_classes = array(
	'top-drawer-inner'
);

$skin_classes = G5Plus_Lustria()->helper()->getSkinClass($skin);
$wrapper_classes = array_merge($wrapper_classes,$skin_classes);


if ($border === 'full') {
	$wrapper_classes[] = 'gf-border-bottom';
}
if ($border === 'container') {
	$inner_classes[] = 'gf-border-bottom';
	$inner_classes[] = 'border-color';
}

if ($mobile_top_drawer_enable !== 'on') {
	$wrapper_classes[] = 'gf-hidden-mobile';
}

$wrapper_class = implode(' ', array_filter($wrapper_classes));
$inner_class = implode(' ', array_filter($inner_classes));

?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
	<?php if ($content_full_width !== 'on'): ?>
		<div class="container">
	<?php endif; ?>
		<div class="<?php echo esc_attr($inner_class) ?>">
            <div class="top-drawer-content">
                <?php if (!empty($content_block)) {
                    echo G5Plus_Lustria()->helper()->content_block($content_block);
                }?>
            </div>
		</div>
	<?php if ($content_full_width !== 'on'): ?>
		</div>
	<?php endif; ?>
	<?php if ($top_drawer_mode === 'toggle'): ?>
		<div class="top-drawer-toggle"><a href="#"><i class="fa fa-plus"></i></a></div>
	<?php endif; ?>
</div>
