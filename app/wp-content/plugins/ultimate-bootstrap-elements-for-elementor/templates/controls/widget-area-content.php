<?php

use Elementor\Core\Files\CSS\Post as Post_CSS;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $widget_name
 * @var $widget_content
 * @var $widget_key
 * @var $index
 */
$widget_classes='widgetarea_warper';
if(Plugin::instance()->editor->is_edit_mode()){
	$widget_classes='widgetarea_warper widgetarea_warper_editable';
}
$dynamic_content_id = isset($widget_content['ube_dynamic_content_id']) ? $widget_content['ube_dynamic_content_id'] : '';
?>
<div class="<?php echo esc_attr($widget_classes)?>">
	<?php if(Plugin::instance()->editor->is_edit_mode()):?>
    <div class="widgetarea_warper_edit"
         data-content="<?php echo esc_attr($dynamic_content_id) ?>"
         data-setting-name="<?php echo esc_attr($widget_name) ?>"
         data-widget-key="<?php echo esc_attr($widget_key) ?>"
         data-widget-index="<?php echo esc_attr($index) ?>">
        <i class="eicon-plus" aria-hidden="true"></i>
        <span class="elementor-screen-only"><?php esc_html_e( 'Edit', 'ube' ); ?></span>
    </div>
	<?php endif;?>
    <div class="elementor-widget-container">
        <?php
        $current_id = 0;
        if ($dynamic_content_id) {
        	$current_id = intval($dynamic_content_id);
        }
        else {
	        $builder_post_title = 'dynamic-content-widget-' . $widget_key . '-' . $index;
	        $builder_post       = get_page_by_title( $builder_post_title, OBJECT, 'ube_content' );
	        if (isset( $builder_post->ID )) {
	        	$current_id = $builder_post->ID;
	        }
        }
        if ( $current_id && ($current_id !== get_the_ID()) ) {
	        echo ube_get_builder_content_for_display( $current_id );
        } else {
	        esc_html_e( 'no content added yet', 'ube' );
        }
        ?>
    </div>
</div>
