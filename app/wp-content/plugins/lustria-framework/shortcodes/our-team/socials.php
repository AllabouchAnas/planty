<?php
/**
 * Created by PhpStorm.
 * User: Kaga
 * Date: 18/2/2017
 * Time: 2:08 PM
 * @var $socials
 */
foreach ($socials as $data) {
	$icon_font = isset($data['icon_font']) ? $data['icon_font'] : '';
	$s_link = isset($data['social_link']) ? $data['social_link'] : '';
	$s_link = ($s_link == '||') ? '' : $s_link;
	$s_link_arr = vc_build_link($s_link);
	$s_title = '';
	$s_target = '_self';
	$s_href = '#';
	if (strlen($s_link_arr['url']) > 0) {
		$s_href = $s_link_arr['url'];
		$s_title = $s_link_arr['title'];
		$s_target = strlen($s_link_arr['target']) > 0 ? $s_link_arr['target'] : '_self';
	}
	?>
	<a class="gsf-link" target="<?php echo esc_attr($s_target) ?>"
	   href="<?php echo esc_url($s_href); ?>" title="<?php echo esc_attr($s_title); ?>">
        <?php if(!empty($icon_font)): ?>
		    <i class="<?php echo esc_attr($icon_font) ?>"></i>
        <?php endif; ?>
        <?php if(!empty($s_title)): ?>
            <span class="social-title"><?php echo esc_attr($s_title); ?></span>
        <?php endif; ?>
	</a>
<?php
}
?>