<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $element UBE_Element_Chart
 */

$settings = $element->get_settings_for_display();

$chart_id = 'ube-chart-' . $element->get_id();
// data chart

$data_chart_array = [];

// set labels
if ( is_array( $settings['charts_labels_data'] ) && sizeof( $settings['charts_labels_data'] ) ) {
	foreach ( $settings['charts_labels_data'] as $labelsData ) {
		$data_chart_array['labels'][] = $labelsData['chart_label'];
	}
}


// set data
if ( in_array( $settings['chart_style'], array( 'pie', 'doughnut', 'polarArea' ) ) ) {
	$background_color       = [];
	$background_color_hover = [];
	$border_color           = [];
	$border_color_hover     = [];
	$data_chart             = [];
	$chart_label            = [];
	if ( is_array( $settings['charts_data_set2'] ) && sizeof( $settings['charts_data_set2'] ) ) {
		foreach ( $settings['charts_data_set2'] as $item ) {

			$background_color[]       = $item['chart_data_bar_back_color'];
			$background_color_hover[] = strlen( $item['chart_data_bar_back_color_hover'] ) > 0 ? $item['chart_data_bar_back_color_hover'] : $item['chart_data_bar_back_color'];
			$border_color[]           = $item['chart_data_bar_border_color'];

			$border_color_hover[] = strlen( $item['chart_data_bar_border_color_hover'] ) > 0 ? $item['chart_data_bar_border_color_hover'] : $item['chart_data_bar_border_color'];
			$dataArray            = array_map( 'intval', explode( ',', trim( $item['chart_data_set2'], ',' ) ) );
			$data_chart []        = $dataArray[0];
			$chart_label[]        = $item['chart_data_label'];

		}
	}
	$data_chart_array['datasets'][] = [
		'data'                 => $data_chart,
		'backgroundColor'      => $background_color,
		'hoverBackgroundColor' => $background_color_hover,
		'borderColor'          => $border_color,
		'hoverBorderColor'     => $border_color_hover,
	];
	$data_chart_array['labels']     = $chart_label;
} else {
	$fill = true;
	if ( is_array( $settings['charts_data_set'] ) && sizeof( $settings['charts_data_set'] ) ) {
		foreach ( $settings['charts_data_set'] as $data_chart ) {
			if ( $data_chart['chart_fill'] == 'yes' ) {
				$fill = true;
			} else {
				$fill = false;
			}
			$background_color       = $data_chart['chart_data_bar_back_color'];
			$background_color_hover = $data_chart['chart_data_bar_back_color_hover'];
			$border_color           = $data_chart['chart_data_bar_border_color'];
			$border_color_hover     = $data_chart['chart_data_bar_border_color_hover'];
			$border_width           = $data_chart['chart_data_bar_border_width'];

			$background_color_hover = strlen( $background_color_hover ) > 0 ? $background_color_hover : $background_color;
			$border_color_hover     = strlen( $border_color_hover ) > 0 ? $border_color_hover : $border_color;

			$data_chart_array['datasets'][] = [
				'label'                => $data_chart['chart_data_label'],
				'data'                 => array_map( 'intval', explode( ',', trim( $data_chart['chart_data_set'], ',' ) ) ),
				'backgroundColor'      => $background_color,
				'hoverBackgroundColor' => $background_color_hover,
				'borderColor'          => $border_color,
				'hoverBorderColor'     => $border_color_hover,
				'borderWidth'          => $border_width,
				'fill'                 => $fill,
			];
		}
	}
}

$data_labels_json = wp_json_encode( array_filter( $data_chart_array['labels'] ) );
$data_json        = wp_json_encode( array_filter( $data_chart_array['datasets'] ) );

// start options
$options = [];

// animations options
if ( ! empty( $settings['chart_section_style_animation_duration'] ) ) {
	$options['animation']['duration']   = $settings['chart_section_style_animation_duration'];
	$options['animation']['onComplete'] = 'function() {window.setTimeout(function() { progress.value = 0;}, ' . $settings['chart_section_style_animation_duration'] . ');';
}
if ( ! empty( $settings['chart_section_style_animation_style'] ) ) {
	$options['animation']['easing'] = $settings['chart_section_style_animation_style'];
}
// tooltip options options
if ( $settings['charts_show_tooltips'] == 'yes' ) {
	if ( ! empty( $settings['charts_tooltips_back_color'] ) ) {
		$options['plugins']['tooltip']['backgroundColor'] = $settings['charts_tooltips_back_color'];
	}
	if ( ! empty( $settings['charts_tooltips_title_font_size'] ) ) {
		$options['plugins']['tooltip']['titleFont']['size'] = $settings['charts_tooltips_title_font_size'];
	}
	if ( ! empty( $settings['charts_tooltips_title_font_color'] ) ) {
		$options['plugins']['tooltip']['titleColor'] = $settings['charts_tooltips_title_font_color'];
	}
	if ( ! empty( $settings['charts_tooltips_title_font_style'] ) ) {
		$options['plugins']['tooltip']['titleFont']['weight'] = $settings['charts_tooltips_title_font_style'];
	}
	if ( ! empty( $settings['charts_tooltips_body_font_size'] ) ) {
		$options['plugins']['tooltip']['bodyFont']['size'] = $settings['charts_tooltips_body_font_size'];
	}
	if ( ! empty( $settings['charts_tooltips_body_font_color'] ) ) {
		$options['plugins']['tooltip']['bodyColor'] = $settings['charts_tooltips_body_font_color'];
	}
	if ( ! empty( $settings['charts_tooltips_body_font_style'] ) ) {
		$options['plugins']['tooltip']['bodyFont']['weight'] = $settings['charts_tooltips_body_font_style'];
	}
} else {
	$options['plugins']['tooltip']['enabled'] = false;
}

//Elements optins
if ( in_array( $settings['chart_style'], array( 'line', 'radar', 'bubble' ) ) ) {
	if ( ! empty( $settings['chart_section_style_chart_point_style'] ) ) {
		$options['elements']['point']['pointStyle'] = $settings['chart_section_style_chart_point_style'];
	}

	if ( ! empty( $settings['chart_point_radius'] ) ) {
		$options['elements']['point']['radius'] = $settings['chart_point_radius'];
	}
	if ( ! empty( $settings['chart_point_radius_hover'] ) ) {
		$options['elements']['point']['hoverRadius'] = $settings['chart_point_radius_hover'];
	}
	if ( ! empty( $settings['chart_point_rotation'] ) ) {
		$options['elements']['point']['rotation'] = $settings['chart_point_rotation'];
	}
}
if ( in_array( $settings['chart_style'], array( 'line' ) ) ) {
	if ( ! empty( $settings['chart_section_style_line_chart_tension'] ) ) {
		$options['elements']['line'] ['tension'] = $settings['chart_section_style_line_chart_tension'];
	}
	if ( $settings['chart_section_style_line_chart_stepped'] == 'yes' ) {
		$options['elements']['line'] ['stepped'] = true;
	}
}

if ( in_array( $settings['chart_style'], array( 'pie' ) ) ) {
	if ( ! empty( $settings['chart_section_style_pie_chart_border_width'] ) ) {
		$options['elements']['arc']['borderWidth'] = $settings['chart_section_style_pie_chart_border_width'];
	}
}
if ( in_array( $settings['chart_style'], array( 'bar', 'horizontalBar' ) ) ) {
	if ( ! empty( $settings['charts_bar_border_skip'] ) ) {
		$options['elements']['rectangle']['borderSkipped'] = $settings['charts_bar_border_skip'];
	}
}

// legend options
if ( $settings['charts_show_legend'] == 'yes' ) {
	if ( $settings['charts_legend_align'] ) {
		$options['plugins']['legend']['position'] = $settings['charts_legend_align'];
	}
	if ( ! empty( $settings['charts_legend_box_width'] ) ) {
		$options['plugins']['legend']['labels']['boxWidth'] = $settings['charts_legend_box_width'];
	}
	if ( ! empty( $settings['charts_legend_font_color'] ) ) {
		$options['plugins']['legend']['labels']['color'] = $settings['charts_legend_font_color'];
	}
	if ( ! empty( $settings['charts_legend_font_size'] ) ) {
		$options['plugins']['legend']['labels']['font']['size'] = $settings['charts_legend_font_size'];
	}
	if ( ! empty( $settings['charts_legend_font_style'] ) ) {
		$options['plugins']['legend']['labels']['font']['weight'] = $settings['charts_legend_font_style'];
	}
	if ( ! empty( $settings['charts_legend_padding'] ) ) {
		$options['plugins']['legend']['labels']['padding'] = $settings['charts_legend_padding'];
	}
	if ( $settings['charts_legend_point_style'] == 'yes' ) {
		$options['plugins']['legend']['labels']['usePointStyle'] = true;
	}
} else {
	$options['plugins']['legend']['display'] = false;
}

// gridline options
if ( ! in_array( $settings['chart_style'], array( 'doughnut', 'pie', 'polarArea', 'radar' ) ) ) {
	if ( $settings['charts_show_label'] ) {
		$ticksArray['display'] = true;
	} else {
		$ticksArray['display'] = false;
	}
	if ( ! empty( $settings['charts_label_font_color'] ) ) {
		$ticksArray['color'] = $settings['charts_label_font_color'];
	}
	if ( ! empty( $settings['charts_label_font_size'] ) ) {
		$ticksArray['font']['size'] = $settings['charts_label_font_size'];
	}
	if ( ! empty( $settings['charts_label_font_style'] ) ) {
		$ticksArray['font']['weight'] = $settings['charts_label_font_style'];
	}
	if ( ! empty( $settings['charts_label_padding'] ) ) {
		$ticksArray['padding'] = $settings['charts_label_padding'];
	}
	$settings['charts_grid_lines'] == 'yes' ? $grid_line_array['display'] = true : $grid_line_array['display'] = false;
	if ( ! empty( $settings['charts_grid_color'] ) ) {
		$grid_line_array['color'] = $settings['charts_grid_color'];
	}
	$settings['chart_grid_draw_border'] == 'yes' ? $grid_line_array['drawBorder'] = true : $grid_line_array['drawBorder'] = false;
	$settings['chart_grid_draw_tick'] == 'yes' ? $grid_line_array['drawTicks'] = true : $grid_line_array['drawTicks'] = false;

	if ( ! empty( $settings['chart_grid_line_width'] ) ) {
		$grid_line_array['lineWidth'] = $settings['chart_grid_line_width'];
	}
	if (!empty($settings['chart_grid_tick_mark_length']) && $settings['chart_grid_tick_mark_length'] >= 0 ) {
		$grid_line_array['tickLength'] = $settings['chart_grid_tick_mark_length'];
	}
} else {
	$ticksArray['display']      = false;
	$grid_line_array['display'] = false;
}
$options['scales']['y'] = array(
	'ticks' => $ticksArray,
	'grid'  => $grid_line_array
);
$options['scales']['x'] = array(
	'ticks' => $ticksArray,
	'grid'  => $grid_line_array
);

if ( in_array( $settings['chart_style'], array( 'doughnut' ) ) ) {
	$options['cutoutPercentage'] = 50;
	if ( ! empty( $settings['chart_cutout_percent']['size'] ) ) {
		$options['cutoutPercentage'] = $settings['chart_cutout_percent']['size'];
	}

}
if ( in_array( $settings['chart_style'], array( 'pie' ) ) ) {
	$options['cutoutPercentage'] = 0;
}
if ( in_array( $settings['chart_style'], array( 'bar', 'horizontalBar' ) ) ) {
	if ( $settings['chart_style'] == 'horizontalBar' ) {
		$options['indexAxis'] = 'y';
	}
	$settings['chart_style'] = 'bar';

}

$options_json = wp_json_encode( $options );

$additional_settings           = array();
$additional_settings['chatId'] = $chart_id;

$element->add_render_attribute( 'canvas_attr', array(
	'id'                            => $chart_id,
	'class'                         => 'ube-chart',
	'data-chart-type'               => $settings['chart_style'],
	'data-chart-labels'             => $data_labels_json,
	'data-chart-options'            => $options_json,
	'data-chart-datasets'           => $data_json,
	'data-chart-additional-options' => json_encode( $additional_settings )

) );

if ( ! empty( $settings['chart_height']['size'] ) ) {
	$element->add_render_attribute( 'canvas_attr', 'height', $settings['chart_height']['size'] );
} else {
	$element->add_render_attribute( 'canvas_attr', 'height', '500' );
}

?>
<div <?php echo $element->get_render_attribute_string( 'chart_attr' ); ?> >
    <canvas <?php echo $element->get_render_attribute_string( 'canvas_attr' ); ?>></canvas>
</div>