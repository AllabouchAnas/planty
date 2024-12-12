<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * @var $element UBE_Element_Page_Title
 */

$settings = $element->get_settings_for_display();

$wrap_class = array(
	'ube-page-title',
);

$element->add_render_attribute('page_title_attr', 'class', $wrap_class);

$page_title = $element->get_page_title();
$page_subtitle = $element->get_page_subtitle();
if ($page_title == "") {
	return;
}
?>
<div <?php echo $element->get_render_attribute_string('page_title_attr') ?>>
	<div class="page-title-wrap">
		<div class="page-title-content">
			<?php if (!is_singular()): ?>
				<h1 class="page-main-title"><?php echo esc_html($page_title); ?></h1>
			<?php else: ?>
				<p class="page-main-title"><?php echo esc_html($page_title); ?></p>
			<?php endif; ?>
			<?php if (!empty($page_subtitle)): ?>
				<p class="page-sub-title"><?php echo esc_html($page_subtitle); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>