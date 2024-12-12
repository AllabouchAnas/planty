<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 19/07/2018
 * Time: 9:32 SA
 */
$video = G5Plus_Lustria()->metaBoxProduct()->get_product_single_video();
if(empty($video)) return;
$magnific_options = array(
    'type' =>  'iframe',
);
?>
<a hidden="hidden" class="product-gallery__video" data-magnific data-magnific-options="<?php echo esc_attr(json_encode($magnific_options))?>" href="<?php echo esc_url($video) ?>"><i class="far fa-play"></i></a>
