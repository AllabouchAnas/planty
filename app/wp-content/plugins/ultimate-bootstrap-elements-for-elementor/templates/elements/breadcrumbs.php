<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $element UBE_Element_Breadcrumbs
 */

use Elementor\Icons_Manager;

$settings = $element->get_settings_for_display();

?>
<nav aria-label="breadcrumb">
	<?php if( !empty($settings['breadcrumb_icon']['value'])) :?>
		<span class="breadcrumb-icon"><?php Icons_Manager::render_icon( $settings['breadcrumb_icon']);?></span>
	<?php endif;?>
	<?php $element->ube_the_breadcrumbs(); ?>
</nav>