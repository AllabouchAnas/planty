<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * @var $element UBE_Element_Subscribe_News_Letter
 */

$settings = $element->get_settings_for_display();

if (is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php') === false) {
	return;
}

$snl_classes = array(
	'ube-subscribe-news-letter',
);

$element->add_render_attribute('snl_attr', 'class', $snl_classes);

?>
<div <?php echo $element->get_render_attribute_string('snl_attr'); ?> >
	<?php echo do_shortcode('[mc4wp_form  id="' . $settings['snl_id'] . '"]'); ?>
</div>