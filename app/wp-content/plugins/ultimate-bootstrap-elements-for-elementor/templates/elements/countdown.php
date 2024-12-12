<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Plugin;

/**
 * @var $element UBE_Element_Countdown
 */

$settings = $element->get_settings_for_display();
$due_date = $settings['due_date'];
$scheme   = '';
if ( ! empty( $settings['countdown_scheme'] ) ) {
	$colors     = ube_color_schemes_configs();
	$text_color = ube_color_contrast( $colors[ $settings['countdown_scheme'] ]['color'], 'white', 'dark' );
	$scheme     = 'bg-' . $settings['countdown_scheme'] . ' text-' . $text_color;
}
$string     = $element->get_strftime( $settings, $scheme );
$now        = date( "Y-m-d H:i:s" );
$gmt        = get_gmt_from_date( $due_date . ':00' );

$start_date_gmt = get_gmt_from_date( $now );
$start_date     = strtotime( $start_date_gmt );
$due_date       = strtotime( $gmt );

$remind_time = $due_date - $start_date;

$second_loop = 0;

if ( ( $settings['expire_actions']==='loop' ) ) {
	$second_loop = $element->get_evergreen_interval( $settings['loop_hours'], $settings['loop_minutes'] );
	if ( $remind_time < 0 ) {
		$count_loop = ceil( ( $start_date - $due_date ) / $second_loop );
		$remind_time += $second_loop * $count_loop;
	}

	$element->add_render_attribute( 'div', 'data-loop', $second_loop );
}

$remind_time = $remind_time < 0 ? 0 : $remind_time;


$actions = false;

if ( ! Plugin::instance()->editor->is_edit_mode() ) {
	$actions = $element->get_actions( $settings );
}

$actions = $element->get_actions( $settings );


if ( $actions ) {
	$element->add_render_attribute( 'div', 'data-expire-actions', json_encode( $actions ) );
}

$show_box            = array(
	'show_days'    => $settings['show_days'],
	'show_hours'   => $settings['show_hours'],
	'show_minutes' => $settings['show_minutes']
);
$countdown_classes[] = 'ube-countdown';
$countdown_classes[] = 'ube-countdown-label-' . $settings['label_display'];
if ( $settings['show_separate_digits'] == 'yes' ) {
	$countdown_classes[] = 'ube-countdown-timer-separate';
}
if ( $settings['show_separate'] == 'yes' ) {
	$countdown_classes[] = 'ube-countdown-show-separate';
}
if($settings['enable_background']=='yes'){
	$countdown_classes[] = 'ube-countdown-background';
}

$element->add_render_attribute( 'div', [
	'class'             => $countdown_classes,
	'data-date'         => $remind_time,
	'data-show-setting' => json_encode( $show_box ),
	'data-id'           => $element->get_id()
] );

?>
    <div <?php echo $element->get_render_attribute_string( 'div' ); ?>>
		<?php echo wp_kses_post( $string );
		?>
    </div>
<?php
if ( $actions && is_array( $actions ) ) {
	if ( 'message' == $actions['type'] && ! empty( $settings['message_after_expire'] ) ) {
		echo '<div class="ube-countdown-expire-message">' . esc_html( $settings['message_after_expire'] ) . '</div>';
	}

}