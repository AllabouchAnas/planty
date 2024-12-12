<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;

/**
 * @var $element Elementor\Widget_Base
 * @var $item_key
 * @var $layout
 * @var $enable_quote
 * @var $enable_background
 * @var $rating
 * @var $client_say
 * @var $author_name
 * @var $author_job
 * @var $image_html
 * @var $client_say_class
 * @var $author_name_class
 * @var $author_job_class
 */

if (!isset($item_key)) {
	$item_key = '';
}
$layout_allow = array_keys(ube_get_testimonials_style());
if (!in_array($layout, $layout_allow)) {
	$layout = 'layout-01';
}
$wrapper_classes = array(
	'ube-testimonial',
	"ube-testimonial-{$layout}",
);

if ($layout === 'layout-07') {
	$wrapper_classes[] = 'd-flex';
}

$element->add_render_attribute("wrapper{$item_key}", 'class', $wrapper_classes);

$content_classes = array(
	'ube-testimonial-content'
);

if ($enable_quote === 'yes') {
	$content_classes[] = 'ube-testimonial-is-quote';
}
if ($enable_background === 'yes') {
	$content_classes[] = 'ube-testimonial-content-has-background';
}

$element->add_render_attribute("content_attr{$item_key}", 'class', $content_classes);

$html_rating = array();
if ($rating !== '') {
	$rating = absint($rating);
	for ($i = 1; $i <= 5; $i++) {
		$html_rating[] = ($i <= $rating) ? UBE_Icon::get_instance()->get_svg('star-solid') : UBE_Icon::get_instance()->get_svg('star-regular');
	}
}


$client_say_classes = array('ube-testimonial-client-say');
if (isset($client_say_class) && !empty($client_say_class)) {
	$client_say_classes[] = $client_say_class;
}
$element->add_render_attribute("client_say_attr{$item_key}", 'class', $client_say_classes);

$author_name_classes = array('ube-testimonial-author-name');
if (isset($author_name_class) && !empty($author_name_class)) {
	$author_name_classes[] = $author_name_class;
}
$element->add_render_attribute("author_name_attr{$item_key}", 'class', $author_name_classes);

$author_job_classes = array('ube-testimonial-author-job');
if (isset($author_job_class) && !empty($author_job_class)) {
	$author_job_classes[] = $author_job_class;
}
$element->add_render_attribute("author_job_attr{$item_key}", 'class', $author_job_classes);
?>
<div <?php echo $element->get_render_attribute_string("wrapper{$item_key}") ?>>
	<?php ube_get_template("elements/testimonial/{$layout}.php", array(
		'element' => $element,
		'html_rating' => $html_rating,
		'client_say' => $client_say,
		'author_name' => $author_name,
		'author_job' => $author_job,
		'image_html' => $image_html,
		'item_key' => $item_key
	)); ?>
</div>