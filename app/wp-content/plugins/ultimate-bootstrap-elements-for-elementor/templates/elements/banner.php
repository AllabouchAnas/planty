<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Badge
 */

$settings = $element->get_settings_for_display();

$banner_classes = array(
	'ube-banner',
	'ube-banner-' . $settings['banner_layout'],
);

if ($settings['banner_layout_hover_effect'] !== '') {
	$banner_classes[] = 'ube-banner-has-effect';
	$banner_classes[] = 'ube-banner-effect-' . $settings['banner_layout_hover_effect'];
}

if ($settings['banner_always_show'] == 'yes') {
	$banner_classes[] = 'ube-banner-show-all';
}
if ($settings['banner_button_fixed'] == 'yes') {
	$banner_classes[] = 'ube-banner-btn-fixed';
}

if ($settings['banner_layout_hover_img'] !== '') {
	$banner_classes[] = 'ube-banner-effect-img-' . $settings['banner_layout_hover_img'];
}

$element->add_render_attribute('banner_attr', 'class', $banner_classes);
if (empty($settings['banner_link']['url'])) {
	$settings['banner_link']['url'] = '#';
}
$element->add_link_attributes('banner_link_attr', $settings['banner_link']);
$element->add_link_attributes('btn_attr', $settings['banner_link']);

$btn_class = array(
	'btn',
	'ube-banner-btn',
	"btn-{$settings['banner_button_size']}",
	"btn-{$settings['banner_button_shape']}",
);

if ($settings['banner_button_type'] === '' || $settings['banner_button_type'] === '3d') {
	$btn_class[] = "btn-{$settings['banner_button_scheme']}";
}

if ($settings['banner_button_type'] === 'outline') {
	$btn_class[] = "btn-outline-{$settings['banner_button_scheme']}";
}

if ($settings['banner_button_type'] !== '') {
	$btn_class[] = "btn-{$settings['banner_button_type']}";
}

if ($settings['banner_button_icon_align'] !== '' && !empty($settings['banner_button_icon']['value'])) {
	$btn_class[] = "icon-{$settings['banner_button_icon_align']}";
}

$element->add_render_attribute('btn_attr', 'class', $btn_class);

$banner_title_classes = array('ube-banner-title');

if (isset($settings['banner_title_class']) && !empty($settings['banner_title_class'])) {
	$banner_title_classes[] = $settings['banner_title_class'];
}

$element->add_render_attribute('banner_title_attr', 'class', $banner_title_classes);

$tag_title_html = Elementor\Utils::validate_html_tag(isset($settings['banner_title_tag']) ? $settings['banner_title_tag'] : 'h4');

if ($settings['banner_image']['url'] !== '') {
	$bg_style = array();
	$pd_bottom = 66.6666666;

	if ($settings['banner_image']['id'] !== '') {
		$media_image = wp_get_attachment_image_src($settings['banner_image']['id'], 'full');
        if (is_array($media_image)) {
            $pd_bottom = ($media_image[2] / $media_image[1]) * 100;
        }
	}

	if ($settings['banner_size_mode'] !== 'custom' && $settings['banner_size_mode'] !== 'original') {
		$pd_bottom = $settings['banner_size_mode'];
	}

	if ($settings['banner_size_mode'] !== 'custom-height' && $settings['banner_size_mode'] !== 'custom') {
		$bg_style[] = "padding-bottom:{$pd_bottom}%";
	}

	$bg_style[] = "background-image : url({$settings['banner_image']['url']})";

	$element->add_render_attribute('bg_attr', array(
		'class' => 'ube-banner-bg',
		'style' => join(";", $bg_style),
	));
}

$banner_desc_classes = array('ube-banner-description');
if (isset($settings['banner_desc_class']) && !empty($settings['banner_desc_class'])) {
	$banner_desc_classes[] = $settings['banner_desc_class'];
}

$element->add_render_attribute('banner_desc_attr','class', $banner_desc_classes);


?>
<?php if ($settings['banner_image']['url'] !== ''): ?>
    <div <?php echo $element->get_render_attribute_string('banner_attr') ?>>
        <div class="ube-banner-image">
			<?php if ($settings['banner_title'] === '' && $settings['banner_link']['url'] !== '' && $settings['banner_enable_button'] === ''): ?>
                <a <?php echo $element->get_render_attribute_string('banner_link_attr') ?>>
                </a>
			<?php endif; ?>
            <div <?php echo $element->get_render_attribute_string('bg_attr') ?>>
            </div>
        </div>
        <div class="ube-banner-content">
			<?php if ($settings['banner_layout'] == 'layout-02' && $settings['banner_button_fixed'] == 'yes') {
				echo ' <div class="ube-banner-top-box">';
			}
			?>
			<?php if ($settings['banner_title'] !== ''):
				printf('<%1$s %2$s>', $tag_title_html, $element->get_render_attribute_string('banner_title_attr'));
				if ($settings['banner_link']['url'] !== ''): ?>
                    <a <?php echo $element->get_render_attribute_string('banner_link_attr') ?>>
						<?php echo wp_kses_post($settings['banner_title']); ?>
                    </a>
				<?php else: echo wp_kses_post($settings['banner_title']);
				endif;
				printf('</%1$s>', $tag_title_html);
			endif; ?>
			<?php if ($settings['banner_layout'] == 'layout-06' || $settings['banner_layout'] == 'layout-04' || $settings['banner_layout'] == 'layout-07') {
				echo ' <div class="ube-banner-bottom-box">';
			}
			?>
			<?php if ($settings['banner_description'] !== ''): ?>
                <div <?php $element->print_render_attribute_string('banner_desc_attr') ?>>
					<?php echo wp_kses_post($settings['banner_description']); ?>
                </div>
			<?php endif; ?>
			<?php if ($settings['banner_layout'] == 'layout-02' && $settings['banner_button_fixed'] == 'yes') {
				echo ' </div>';
			}
			?>
			<?php if ($settings['banner_enable_button'] === 'yes'): ?>
				<?php if (!empty($settings['banner_button_icon']['value']) || $settings['banner_text_button'] !== ''): ?>
                    <a <?php echo $element->get_render_attribute_string('btn_attr') ?>>
						<?php if (!empty($settings['banner_button_icon']) && !empty($settings['banner_button_icon']['value']) && ($settings['banner_button_icon_align'] === 'before')): ?>
							<?php Icons_Manager::render_icon($settings['banner_button_icon'], ['aria-hidden' => 'true']); ?>
						<?php endif; ?>
						<?php echo esc_html($settings['banner_text_button']) ?>
						<?php if (!empty($settings['banner_button_icon']) && !empty($settings['banner_button_icon']['value']) && ($settings['banner_button_icon_align'] === 'after')): ?>
							<?php Icons_Manager::render_icon($settings['banner_button_icon'], ['aria-hidden' => 'true']); ?>
						<?php endif; ?>
                    </a>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($settings['banner_layout'] == 'layout-06' || $settings['banner_layout'] == 'layout-04' || $settings['banner_layout'] == 'layout-07') {
				echo ' </div>';
			}
			?>
        </div>
    </div>
<?php endif; ?>