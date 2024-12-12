<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Embed;
use Elementor\Icons_Manager;
use Elementor\Plugin;

/**
 * @var $element UBE_Element_Video_Popup
 */

$settings = $element->get_settings_for_display();

$video_url = $settings[$settings['video_type'] . '_url'];

if (empty($video_url)) {
	return;
}

if ('hosted' === $settings['video_type']) {
	$lightbox_url = $element->get_hosted_video_url();
} else {
	$embed_params = $element->get_embed_params();
	$embed_options = $element->get_embed_options();
	$lightbox_url = Embed::get_embed_url($video_url, $embed_params, $embed_options);
}

$lightbox_options = [
	'type' => 'video',
	'videoType' => $settings['video_type'],
	'url' => $lightbox_url,
	'modalOptions' => [
		'id' => 'elementor-lightbox-' . $element->get_id(),
	],
];

if ('hosted' === $settings['video_type']) {
	$lightbox_options['videoParams'] = $element->get_hosted_params();
}

$element->add_render_attribute('btn_attr', [
	'data-elementor-open-lightbox' => 'yes',
	'data-elementor-lightbox' => wp_json_encode($lightbox_options),
]);

if (Plugin::$instance->editor->is_edit_mode()) {
	$element->add_render_attribute('btn_attr', [
		'class' => 'elementor-clickable',
	]);
}

$btn_class = array(
	'btn',
	'ube-video-btn',
	'elementor-custom-embed-image-overlay',
	"btn-{$settings['video_button_size']}",
	"btn-{$settings['video_button_shape']}",
);

if ($settings['video_button_type'] === '' || $settings['video_button_type'] === '3d') {
	$btn_class[] = "btn-{$settings['video_button_scheme']}";
}

if ($settings['video_button_type'] === 'outline') {
	$btn_class[] = "btn-outline-{$settings['video_button_scheme']}";
	$btn_class[] = "btn-{$settings['video_button_scheme']}";
}

if ($settings['video_button_type'] !== '') {
	$btn_class[] = "btn-{$settings['video_button_type']}";
}

if ($settings['video_button_icon_align'] !== '' && !empty($settings['video_button_icon']['value'])) {
	$btn_class[] = "icon-{$settings['video_button_icon_align']}";
}

$element->add_render_attribute('btn_attr', 'class', $btn_class);

?>
<div class="ube-popup-video">
	<?php if (!empty($settings['video_button_icon']['value']) || $settings['video_text_button'] !== ''): ?>
        <button <?php echo $element->get_render_attribute_string('btn_attr') ?>>
			<?php if (!empty($settings['video_button_icon']) && !empty($settings['video_button_icon']['value']) && ($settings['video_button_icon_align'] === 'before')): ?>
				<?php Icons_Manager::render_icon($settings['video_button_icon'], ['aria-hidden' => 'true']); ?>
			<?php endif; ?>
			<?php echo esc_html($settings['video_text_button']) ?>
			<?php if (!empty($settings['video_button_icon']) && !empty($settings['video_button_icon']['value']) && ($settings['video_button_icon_align'] === 'after')): ?>
				<?php Icons_Manager::render_icon($settings['video_button_icon'], ['aria-hidden' => 'true']); ?>
			<?php endif; ?>
        </button>
	<?php endif; ?>
</div>
