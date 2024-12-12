<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 * @var $element UBE_Element_Business_Hours
 */
$settings = $element->get_settings_for_display();

$bh_classes = array(
	'ube-business-hours',
	"ube-business-hours-layout-{$settings['bh_layout']}",
);

if ($settings['bh_divider_position'] !== '') {
	$bh_classes[] = 'ube-business-hours-divider-position-' . $settings['bh_divider_position'];
}

$element->add_render_attribute('business_attr', 'class', $bh_classes);
?>

<div <?php echo $element->get_render_attribute_string('business_attr') ?>>
    <ul class="ube-business-hours-inner">
		<?php foreach ($settings['bh_list'] as $i => $item):
			$item_setting_key = $element->get_repeater_setting_key('business_hours_item', 'bh_list', $i);
			$item_classes = array('ube-business-hours-item', 'elementor-repeater-item-' . $item['_id']);
			if ($item['bh_this_day'] == 'yes') {
				$item_classes[] = 'ube-business-hours-hight-ligh';
			}
			$element->add_render_attribute($item_setting_key,
				'class', $item_classes);
			?>
            <li <?php echo $element->get_render_attribute_string($item_setting_key); ?>>
				<?php
				if (!empty($item['bh_day'])) :?>
                    <span class="ube-business-day"><?php echo esc_html($item['bh_day']) ?></span>
				<?php endif;
				if ($settings['bh_layout'] === '04') :?>
                    <span class="ube-business-divider"></span>
				<?php endif;
				if (!empty($item['bh_time'])) :?>
                    <span class="ube-business-time"><?php echo esc_html($item['bh_time']) ?> </span>
				<?php endif;
				?>
            </li>
		<?php endforeach; ?>
    </ul>
</div>