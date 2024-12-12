<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $image_size
 * @var $image_ratio
 * @var $image_ratio_custom_width
 * @var $image_ratio_custom_height
 * @var $image_masonry_width
 * @var $images
 * @var $hover_effect
 * @var $columns_gutter
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_style
 * @var $center
 * @var $loop
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Gallery
 */

$layout_style = $image_size = $image_ratio = $image_ratio_custom_width = $image_ratio_custom_height = $image_masonry_width = $images =
$hover_effect = $columns_gutter = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb =
$dots = $nav = $nav_position = $nav_style = $center = $loop = $autoplay = $autoplay_timeout = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

if (empty($images) || !function_exists('G5Plus_Lustria')) return;
$images = explode(',', $images);

$wrapper_classes = array(
	'gf-gallery',
	'clearfix',
	'text-center',
	'gallery-layout-' . $layout_style,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}
$columns = intval($columns);
$columns_gutter = intval($columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$item_class = array('gf-gallery-item');
$gallery_inner_class = array('gallery_inner');
$gallery_inner_class[] = 'thumbnail' === $layout_style ? '' : $layout_style;
$owl_attributes = $isotope_attributes = $metro_layout = array();
switch ($layout_style) {
	case 'carousel':
		$gallery_inner_class[] = 'owl-carousel owl-theme';
		if ($nav) {
			$gallery_inner_class[] = $nav_position;
			$gallery_inner_class[] = $nav_style;
		}
		$owl_attributes = array(
			'items' => $columns,
			'margin' => $columns == 1 ? 0 : $columns_gutter,
			'slideBy' => $columns,
			'autoHeight' => true,
			'dots' => $dots ? true : false,
			'nav' => $nav ? true : false,
			'autoplay' => ($autoplay === 'on') ? true : false,
			'autoplayTimeout' => intval($autoplay_timeout),
			'center' => ('on' === $center) ? true : false,
			'loop' => ('on' === $loop) ? true : false,
			'responsive' => array(
				'1200' => array(
					'items' => $columns,
					'margin' => $columns == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns,
				),
				'992' => array(
					'items' => $columns_md,
					'margin' => $columns_md == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_md,
				),
				'768' => array(
					'items' => $columns_sm,
					'margin' => $columns_sm == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_sm,
				),
				'600' => array(
					'items' => $columns_xs,
					'margin' => $columns_xs == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_xs,
				),
				'0' => array(
					'items' => $columns_mb,
					'margin' => $columns_mb == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_mb,
				)
			)
		);
		if ($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
			$owl_attributes['navText'] = array('<i class="fal fa-angle-left"></i> <span>' . esc_html__('Prev', 'lustria-framework') . '</span>', '<span>' . esc_html__('Next', 'lustria-framework') . '</span> <i class="fal fa-angle-right"></i>');
		}
		break;
	case 'thumbnail':
		$gallery_inner_class[] = 'owl-carousel owl-theme manual gallery-main';
		$gallery_inner_class[] = 'mg-bottom-' . $columns_gutter;
		break;
	case 'carousel-3d':
		$gallery_inner_class[] = 'owl-carousel owl-theme';
		if ($nav) {
			$gallery_inner_class[] = $nav_position;
			$gallery_inner_class[] = $nav_style;
		}
		$owl_attributes = array(
			'autoHeight' => true,
			'dots' => $dots ? true : false,
			'nav' => $nav ? true : false,
			'autoplay' => ($autoplay === 'on') ? true : false,
			'autoplayTimeout' => intval($autoplay_timeout),
			'center' => true,
			'loop' => ('on' === $loop) ? true : false,
			'responsive' => array(
				'992' => array(
					'items' => 2
				),
				'0' => array(
					'items' => 1
				)
			)
		);
		if ($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
			$owl_attributes['navText'] = array('<i class="fal fa-angle-left"></i> <span>' . esc_html__('Prev', 'lustria-framework') . '</span>', '<span>' . esc_html__('Next', 'lustria-framework') . '</span> <i class="fal fa-angle-right"></i>');
		}
		break;
	case 'grid':
	case 'masonry':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => ('grid' === $layout_style) ? 'fitRows' : 'masonry'
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'gf-blog-inner';
		$gallery_inner_class[] = ('masonry' === $layout_style) ? 'isotope' : '';
		$item_class[] = 'grid-item';
		$columns = array(
			'xl' => $columns,
			'lg' => $columns_md,
			'md' => $columns_sm,
			'sm' => $columns_xs,
			'' => $columns_mb
		);
		$item_class[] = G5Plus_Lustria()->helper()->get_bootstrap_columns($columns);
		break;
	case 'metro-01':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => 'masonry',
			'percentPosition' => true,
			'masonry' => array(
				'columnWidth' => '.gsf-col-base',
			),
			'metro' => true
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'isotope gf-blog-inner';
		$item_class[] = 'grid-item';
		$metro_layout = array(
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 1.5, 'lg' => 1.5, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 1.5, 'lg' => 1.5, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
		);
		break;
	case 'metro-02':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => 'masonry',
			'percentPosition' => true,
			'masonry' => array(
				'columnWidth' => '.gsf-col-base',
			),
			'metro' => true
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'isotope gf-blog-inner';
		$item_class[] = 'grid-item';
		$metro_layout = array(
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),

		);
		break;
	case 'metro-03':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => 'masonry',
			'percentPosition' => true,
			'masonry' => array(
				'columnWidth' => '.gsf-col-base',
			),
			'metro' => true
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'isotope gf-blog-inner';
		$item_class[] = 'grid-item';
		$metro_layout = array(
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),

		);
		break;
	case 'metro-04':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => 'masonry',
			'percentPosition' => true,
			'masonry' => array(
				'columnWidth' => '.gsf-col-base',
			),
			'metro' => true
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'isotope gf-blog-inner';
		$item_class[] = 'grid-item';
		$metro_layout = array(
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
		);
		break;
	case 'metro-05':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => 'masonry',
			'percentPosition' => true,
			'masonry' => array(
				'columnWidth' => '.gsf-col-base',
			),
			'metro' => true
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'isotope gf-blog-inner';
		$item_class[] = 'grid-item';
		$metro_layout = array(
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x1'),
		);
		break;
	case 'metro-06':
		$isotope_attributes = array(
			'itemSelector' => '.gf-gallery-item',
			'layoutMode' => 'masonry',
			'percentPosition' => true,
			'masonry' => array(
				'columnWidth' => '.gsf-col-base',
			),
			'metro' => true
		);
		$gallery_inner_class[] = 'gf-gutter-' . $columns_gutter;
		$gallery_inner_class[] = 'isotope gf-blog-inner';
		$item_class[] = 'grid-item';
		$metro_layout = array(
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '1x2'),
			array('columns' => G5Plus_Lustria()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'layout_ratio' => '2x1')
		);
		break;
	default:
		break;
}
$image_size_base = $image_size;
if (!in_array($layout_style, array('masonry'))) {
	if (($image_size === 'full')) {
		if (empty($image_ratio)) {
			$image_ratio = '1x1';
		}

		if ($image_ratio === 'custom') {
			$image_ratio_custom = !(empty($image_ratio_custom_width) || empty($image_ratio_custom_height)) ? array('width' => $image_ratio_custom_width, 'height' => $image_ratio_custom_height) : array('width' => '600', 'height' => '600');
			if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
				$image_ratio_custom_width = intval($image_ratio_custom['width']);
				$image_ratio_custom_height = intval($image_ratio_custom['height']);
				if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
					$image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
				}
			} elseif (preg_match('/x/', $image_ratio_custom)) {
				$image_ratio = $image_ratio_custom;
			}
		}

		if ($image_ratio === 'custom') {
			$image_ratio = '1x1';
		}
	} else {
		$image_ratio = '';
	}
}

$image_ratio_base = $image_ratio;

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

$gallery_id = rand();
$args = array('galleryId' => $gallery_id);
?>
<div class="<?php echo esc_attr($css_class); ?>" data-isotope-wrapper="true">
    <div class="<?php echo implode(' ', $gallery_inner_class) ?>"<?php if (!empty($owl_attributes)): ?> data-owl-options='<?php echo json_encode($owl_attributes); ?>'<?php endif; ?><?php if (!empty($isotope_attributes)): ?> data-isotope-options='<?php echo json_encode($isotope_attributes); ?>'<?php endif; ?>>
		<?php
		$index = 0;
		foreach ($images as $image):
			$item_classes = $item_class;
			$item_inner_attr = array();
			if (in_array($layout_style, array('metro-01', 'metro-02', 'metro-03', 'metro-04', 'metro-05', 'metro-06'))) {
				$current_layout = $metro_layout[$index];
				if (isset($current_layout['layout_ratio'])) {
					$layout_ratio = !empty($current_layout['layout_ratio']) ? $current_layout['layout_ratio'] : '1x1';
					if ($image_size_base !== 'full') {
						$image_size = G5Plus_Lustria()->helper()->get_metro_image_size($image_size_base, $layout_ratio, $columns_gutter);
					} else {
						$image_ratio = G5Plus_Lustria()->helper()->get_metro_image_ratio($image_ratio_base, $layout_ratio);
					}
					$item_inner_attr[] = 'data-ratio="' . $layout_ratio . '"';
				}
				$item_classes[] = $current_layout['columns'];
			}
			if ($layout_style === 'masonry') {
				if (!empty($image_masonry_width)) {
					$image_width = intval($image_masonry_width);
				} else {
					$image_width = 400;
				}

				if ($image_width <= 0) {
					$image_width = 400;
				}
				$image_size = "{$image_width}x0";
				$image_ratio = '';
			} ?>
            <div class="<?php echo join(' ', $item_classes); ?>" data-index="<?php echo esc_attr($index); ?>">
                <div class="gf-gallery-inner <?php echo esc_attr($hover_effect) ?> entry-thumbnail"<?php echo join(' ', $item_inner_attr); ?>>
					<?php G5Plus_Lustria()->blog()->render_post_image_markup(array(
						'image_id' => $image,
						'image_size' => $image_size,
						'display_permalink' => false,
						'image_mode' => 'background',
						'image_ratio' => $image_ratio,
						'gallery_id' => $gallery_id,
						'class' => 'effect-content'
					)); ?>
                </div>
            </div>
			<?php $index++;
			if ($index == count($metro_layout) && 'thumbnail' != $layout_style) {
				$index = 0;
			} ?>
		<?php endforeach; ?>
    </div>
	<?php if ('thumbnail' === $layout_style): ?>
		<?php
		$thumb_args = array(
			'items' => $columns,
			'margin' => $columns == 1 ? 0 : $columns_gutter,
			'slideBy' => $columns,
			'autoHeight' => true,
			'responsive' => array(
				'1200' => array(
					'items' => $columns,
					'margin' => $columns == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns,
				),
				'992' => array(
					'items' => $columns_md,
					'margin' => $columns_md == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_md,
				),
				'768' => array(
					'items' => $columns_sm,
					'margin' => $columns_sm == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_sm,
				),
				'600' => array(
					'items' => $columns_xs,
					'margin' => $columns_xs == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_xs,
				),
				'0' => array(
					'items' => $columns_mb,
					'margin' => $columns_mb == 1 ? 0 : $columns_gutter,
					'slideBy' => $columns_mb,
				)
			)
		);
		?>
        <div class="owl-carousel owl-theme manual gallery-thumb"
             data-owl-options='<?php echo json_encode($thumb_args); ?>'>
			<?php $index = 0;
			foreach ($images as $image): ?>
                <div class="<?php echo join(' ', $item_class); ?>" data-index="<?php echo esc_attr($index); ?>">
					<?php
					G5Plus_Lustria()->blog()->render_post_image_markup(array(
						'image_id' => $image,
						'image_size' => '400x300',
						'display_permalink' => false,
						'image_mode' => 'background',
						'image_ratio' => $image_ratio,
						'gallery_id' => $gallery_id
					));
					?>
                </div>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
</div>