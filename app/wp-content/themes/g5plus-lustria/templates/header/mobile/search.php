<?php
/**
 * The template for displaying search.php
 *
 * @var $header_border
 */
$mobile_header_search_enable = G5Plus_Lustria()->options()->get_mobile_header_search_enable();
if ($mobile_header_search_enable !== 'on') return;

$wrapper_classes = array(
        'mobile-header-search',
    'border-color'
);


if ($header_border != 'none') {
    $wrapper_classes[] = 'gf-border-bottom';
} else {
    $wrapper_classes[] = 'gf-border-top';
}
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class);?>">
	<div class="container">
		<?php get_search_form(); ?>
	</div>
</div>
