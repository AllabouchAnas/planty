<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $element UBE_Element_Timeline
 */

$settings = $element->get_settings_for_display();

$tl_classes = array(
	'ube-timeline',
	"ube-timeline-style-{$settings['timeline_style']}",
);

$element->add_render_attribute( 'timeline_attr', 'class', $tl_classes );

?>
<div <?php echo $element->get_render_attribute_string( 'timeline_attr' ) ?>>
	<?php if ( isset( $settings['timeline_content_list'] ) ): ?>
		<?php foreach ( $settings['timeline_content_list'] as $i => $items ): ?>
			<?php
			$items_class = array(
				'ube-timeline-item',
				'd-flex',
				'justify-content-between'
			);
			if ( $i % 2 !== 0 ) {
				$items_class[] = 'item-reverse';
			}
			if ( $items['timeline_active'] === 'yes' ) {
				$items_class[] = 'item-active';
			}
			$item_setting_key = $element->get_repeater_setting_key( 'time_line_item', 'timeline_content_list', $i );
			$element->add_render_attribute( $item_setting_key, 'class', $items_class )
			?>
            <div <?php echo $element->get_render_attribute_string( $item_setting_key ); ?>>
				<?php if ( ! empty( $items['timeline_time'] ) ): ?>
                    <div class="ube-timeline-time">
                        <span><?php echo wp_kses_post( $items['timeline_time'] ) ?></span>
                    </div>
				<?php endif; ?>
				<?php if ( ! empty( $items['timeline_content'] ) || ! empty( $items['timeline_title'] ) ): ?>
                    <div class="ube-timeline-content">
						<?php
						if ( ! empty( $items['timeline_title'] ) ) :?>
                            <h6 class="ube-timeline-title"> <?php echo esc_html( $items['timeline_title'] ) ?></h6>
						<?php endif; ?>
                        <div class="content"><?php echo wp_kses_post( $items['timeline_content'] ) ?></div>
                    </div>
				<?php endif; ?>
            </div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
