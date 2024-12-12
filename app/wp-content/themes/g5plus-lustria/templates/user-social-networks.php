<?php
/**
 * The template for displaying user-profile.php
 * @var $userId
 * @var $layout
 */

$social_networks = G5Plus_Lustria()->userMeta()->get_social_networks($userId);
if (!is_array($social_networks)) return;
$wrapper_classes = array(
	'gf-social-icon',
	'gf-inline',
    'disable-color'
);

if (isset($layout) && !empty($layout) && ($layout !== 'classic')) {
	$wrapper_classes[] = "social-icon-{$layout}";
}

$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<ul class="<?php echo esc_attr($wrapper_class)?>">
	<?php foreach ($social_networks as $social_network): ?>
		<?php if (!empty($social_network['social_link'])): ?>
			<?php
			$social_id = $social_network['social_id'];
			$social_name = $social_network['social_name'];
			$social_link = !empty($social_network['social_link']) ? $social_network['social_link'] : '#' ;
			$social_icon = $social_network['social_icon'];
			$social_class = '';
			?>
			<li class="<?php echo esc_attr($social_id)?>">
				<?php if ($social_id === 'social-email'): ?>
					<a class="gsf-link <?php echo esc_attr($social_class)?>" target="_blank" data-toggle="tooltip" title="<?php echo esc_attr($social_name)?>" href="mailto:<?php echo esc_attr($social_link) ?>"><i class="<?php echo esc_attr($social_icon)?>"></i></a>
				<?php else: ?>
					<a class="gsf-link <?php echo esc_attr($social_class)?>" data-toggle="tooltip"  title="<?php echo esc_attr($social_name)?>" href="<?php echo esc_url($social_link)?>"><i class="<?php echo esc_attr($social_icon)?>"></i></a>
				<?php endif; ?>

			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>
