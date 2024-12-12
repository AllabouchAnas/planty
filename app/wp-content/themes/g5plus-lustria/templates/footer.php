<?php
/**
 * The template for displaying footer
 */
$footer_enable = G5Plus_Lustria()->options()->get_footer_enable();
if ($footer_enable !== 'on') return;
$footer_fixed_enable = G5Plus_Lustria()->options()->get_footer_fixed_enable();
$wrapper_classes = array(
	'main-footer-wrapper'
);

if ($footer_fixed_enable === 'on') {
	$wrapper_classes[] = 'footer-fixed';
}
$content_block = G5Plus_Lustria()->options()->get_footer_content_block();
if (empty($content_block)) return;
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<footer class="<?php echo esc_attr($wrapper_class); ?>">
    <?php echo G5Plus_Lustria()->helper()->content_block( $content_block ); ?>
</footer>
