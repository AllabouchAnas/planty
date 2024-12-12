<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class UBE_Element_Advanced_Slider extends UBE_Abstracts_Elements_Slider {

	public function get_name() {
		return 'ube-advanced-slider';
	}

	public function get_title() {
		return esc_html__( 'Advanced Slider', 'ube' );
	}

	public function get_ube_icon() {
		return 'eicon-slider-push';
	}

	public function get_ube_keywords() {
		return array( 'slider', 'advanced', 'ube' , 'advanced slider' , 'ube advanced slider' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->print_slider( $settings,'ube-advanced-slider', true );
	}

	protected function print_slider_items(array $settings) {
		echo UBE_Module_Dynamic_Content::get_instance()->parse_widget_content( 'slider_content', $settings['slider_content'], $this->get_id() );
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

	public function register_content_controls( $element, $args ) {
		if ( ! empty( $element->get_controls( 'slider_content' ) ) ) {
			return;
		}



		$element->add_control(
			'slider_content', [
				'label'       => esc_html__( 'Slider Content', 'ube' ),
				'type'        => UBE_Controls_Manager::WIDGETAREA,
				'label_block' => true,
			]
		);
	}
}