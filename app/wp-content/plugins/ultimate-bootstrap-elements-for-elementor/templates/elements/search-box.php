<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

/**
 * @var $element UBE_Element_Search_Box
 */
$settings = $element->get_settings_for_display();

$search_classes = array(
	'ube-search-box',
	"ube-search-box-layout-{$settings['search_style']}",
	'position-relative',
);

if ( $settings['search_style'] === '01' ) {
	$search_classes[] = 'd-flex';
	$search_classes[] = 'flex-wrap';
}

$data_search_options = array();

if ( $settings['search_enable_ajax'] === 'yes' ) {
	$data_search_options = array(
		'PostsPerPage' => $settings['search_posts_per_page'],
		'AjaxUrl'      => admin_url( 'admin-ajax.php' ),
		'orderby'      => $settings['search_order_by'],
		'order'        => $settings['search_order'],
		'ResultDate'   => 'no'
	);
	$search_classes[]    = 'has_ajax_search';
}

if ( $settings['search_ajax_enable_date'] === 'yes' && $settings['search_enable_ajax'] === 'yes' ) {
	$data_search_options['ResultDate'] = 'yes';
}

$element->add_render_attribute(
	'search-box-attr', [
		'class'               => $search_classes,
		'data-search-options' => json_encode( $data_search_options ),
		'action'              => home_url(),
		'method'              => 'get',
		'role'                => 'search',
	]
);

$input_class = array(
	'form-control',
	'value-search',
);

$element->add_render_attribute(
	'input_attr', [
		'placeholder' => $settings['search-placeholder'],
		'type'        => 'text',
		'class'       => $input_class,
		'name'        => 's',
		'title'       => esc_html__( 'Search', 'ube' ),
		'value'       => get_search_query(),
	]
);

$element->add_render_attribute(
	'show_modal_attr', [
		'class' => 'ube-search-box-show-modal',
		'href'  => '#',
	]
);

?>
<?php if ( $settings['search_style'] === '03' ) : ?>
    <button class="btn ube-search-box-show-modal"><i class="fa fa-search"></i></button>
    <div class="ube-search-box-modal" id="ube-modal-<?php echo esc_attr( $element->get_id() ) ?>">
    <div class="ube-search-box-modal-content">
<?php endif; ?>
    <form <?php echo $element->get_render_attribute_string( 'search-box-attr' ) ?>>
        <input <?php echo $element->get_render_attribute_string( 'input_attr' ) ?>>
        <button class="ube-search-box-submit d-flex align-items-center justify-content-center" type="submit"
                aria-label="<?php esc_attr_e( 'Search', 'ube' ); ?>">
			<?php
			if ( $settings['search_btn_type'] === 'icon' && ! empty( $settings['search_button_icon']['value'] ) ) {
				Icons_Manager::render_icon( $settings['search_button_icon'], [ 'aria-hidden' => 'true' ] );
			} else {
				if ( $settings['search_btn_text'] !== '' ) {
					echo esc_html( $settings['search_btn_text'] );
				}
			}
			?>
        </button>
		<?php if ( $settings['search_enable_ajax'] === 'yes' ): ?>
            <ul class="ube-search-box-ajax-result"></ul>
		<?php endif; ?>
    </form>
<?php if ( $settings['search_style'] === '03' ) : ?>
    </div>
    <button type="button" class="ube-search-box-modal-close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
<?php endif; ?>