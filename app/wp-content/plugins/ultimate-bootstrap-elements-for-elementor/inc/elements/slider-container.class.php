<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Plugin;

class UBE_Element_Slider_Container extends UBE_Abstracts_Elements_Slider {

	public function get_name() {
		return 'ube-slider-container';
	}

	public function get_title() {
		return esc_html__( 'Slider Container', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-slider-push';
	}

	public function get_ube_keywords() {
		return array( 'slider', 'container', 'slider container',  'ube',  'ube slider container' );
	}

	protected function register_controls() {

		add_action( "elementor/element/{$this->get_name()}/section_slider/after_section_start", array($this,'register_content_controls'),10,2);


		parent::register_slider_section_controls();

		$this->update_control('section_slider',[
			'label' => esc_html__( 'General', 'ube' ),
		]);

		$this->update_control('section_slider_advanced',[
			'tab'       => Controls_Manager::TAB_CONTENT,
			'label' => esc_html__( 'Advanced', 'ube' ),
		]);

		$this->remove_control('slider_content_position');
		$this->remove_control('slider_content_alignment');

	}

	public function register_content_controls($element, $args) {
		if ( ! empty( $element->get_controls( 'slider_content_template' ) ) ) {
			return;
		}

		$element->add_control(
			'slider_content_template',
			[
				'label'       => esc_html__( 'Choose Template', 'ube' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => ube_get_page_templates(),
			]
		);
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->print_slider( $settings,'ube-slider-container' );

	}

	protected function print_slider_items(array $settings) {
		if ( ! empty( $settings['slider_content_template'] ) ) {
			foreach ( $settings['slider_content_template'] as $template ) {
				?>
				<div class="ube-slider-item">
					<?php echo ube_get_builder_content_for_display( $template ); ?>
				</div>
				<?php
			}
		}
	}
}