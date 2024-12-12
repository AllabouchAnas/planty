<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $wp_registered_sidebars;
if (!woocommerce_products_will_display()) return;
$woocommerce_customize = G5Plus_Lustria()->options()->get_woocommerce_customize();
$woocommerce_customize_mobile = G5Plus_Lustria()->options()->get_woocommerce_customize_mobile();
$woocommerce_customize_full_width = G5Plus_Lustria()->options()->get_woocommerce_customize_full_width();
?>
<div class="gsf-catalog-filter<?php echo ('on' === $woocommerce_customize_full_width ? ' gsf-catalog-full-width' : ''); ?>" hidden="hidden">
    <div class="woocommerce-custom-wrap">
        <div class="container d-flex align-items-center">
            <div class="woocommerce-customize-left">
                <?php if(isset($woocommerce_customize['Left'])): ?>
                    <ul class="gf-inline">
                        <?php foreach ($woocommerce_customize['Left'] as $key => $value): ?>
                            <li class="gsf-catalog-filter-<?php echo esc_attr($key)?>">
                                <?php G5Plus_Lustria()->helper()->getTemplate("woocommerce/loop/catalog-item/{$key}"); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="woocommerce-customize-right">
                <?php if(isset($woocommerce_customize['Right'])): ?>
                    <ul class="gf-inline">
                        <?php foreach ($woocommerce_customize['Right'] as $key => $value): ?>
                            <li class="gsf-catalog-filter-<?php echo esc_attr($key)?>">
                                <?php G5Plus_Lustria()->helper()->getTemplate("woocommerce/loop/catalog-item/{$key}"); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="woocommerce-custom-wrap woocommerce-custom-wrap-mobile">
        <div class="container d-flex align-items-center">
            <div class="woocommerce-customize-left">
                <?php if(isset($woocommerce_customize_mobile['Left'])): ?>
                    <ul class="gf-inline">
                        <?php foreach ($woocommerce_customize_mobile['Left'] as $key => $value): ?>
                            <li class="gsf-catalog-filter-<?php echo esc_attr($key)?>">
                                <?php G5Plus_Lustria()->helper()->getTemplate("woocommerce/loop/catalog-item/{$key}"); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="woocommerce-customize-right">
                <?php if(isset($woocommerce_customize_mobile['Right'])): ?>
                    <ul class="gf-inline">
                        <?php foreach ($woocommerce_customize_mobile['Right'] as $key => $value): ?>
                            <li class="gsf-catalog-filter-<?php echo esc_attr($key)?>">
                                <?php G5Plus_Lustria()->helper()->getTemplate("woocommerce/loop/catalog-item/{$key}"); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if(((isset($woocommerce_customize['Right']) && array_key_exists('filter', $woocommerce_customize['Right']))
        || (isset($woocommerce_customize['Left']) && array_key_exists('filter', $woocommerce_customize['Left'])))
            || ((isset($woocommerce_customize_mobile['Right']) && array_key_exists('filter', $woocommerce_customize_mobile['Right']))
        || (isset($woocommerce_customize_mobile['Left']) && array_key_exists('filter', $woocommerce_customize_mobile['Left'])))):?>
        <div id="gf-filter-content">
            <div class="container">
                <?php if (is_active_sidebar('woocommerce-filter')): ?>
                <div class="row">
                    <?php dynamic_sidebar('woocommerce-filter') ?>
                </div>
                <?php elseif (isset($wp_registered_sidebars['woocommerce-filter'])): ?>
                    <div class="no-widget-content"> <?php printf(wp_kses_post(__('Please insert widget into sidebar <b>%s</b> in Appearance > <a class="text-color-accent" title="manage widgets" href="%s">Widgets</a> ','g5plus-lustria')),$wp_registered_sidebars['woocommerce-filter']['name'],admin_url( 'widgets.php' )); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
        global $wp;
        $link = home_url($wp->request);
        $filter_arr = array();
        $queried_object = get_queried_object();

        if ( isset( $_GET['min_price'] ) ) {
            $filter_arr['min_price'] = array(
                'active' => true,
                'title' => esc_html__('Min: ', 'g5plus-lustria'),
                'value' => wc_price($_GET['min_price']),
                'url' => ''
            );
            $link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
        }

        if ( isset( $_GET['max_price'] ) ) {
            $filter_arr['max_price'] = array(
                'active' => true,
                'title' => esc_html__('Max: ', 'g5plus-lustria'),
                'value' => wc_price($_GET['max_price']),
                'url' => ''
            );
            $link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
        }

        if ( isset( $_GET['orderby'] ) ) {
            $link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
        }

        if ( isset( $_GET['product_tag'] ) ) {
            $link = add_query_arg( 'product_tag', urlencode( $_GET['product_tag'] ), $link );
        }

        elseif( is_product_tag() && $queried_object ){
            $link = add_query_arg( array( 'product_tag' => $queried_object->slug ), $link );
        }

        if ( get_search_query() ) {
            $link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
        }

        if ( isset( $_GET['post_type'] ) ) {
            $link = add_query_arg( 'post_type', wc_clean( $_GET['post_type'] ), $link );
        }

        // Min Rating Arg
        if ( isset( $_GET['rating_filter'] ) ) {
            $link = add_query_arg( 'rating_filter', wc_clean( $_GET['rating_filter'] ), $link );
        }
        $chosen_terms = array();
        if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
            foreach ( $_chosen_attributes as $name => $data ) {
                $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
                if ( 'or' == $data['query_type'] ) {
                    $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                }
                if ( ! empty( $data['terms'] )  && is_array($data['terms'])) {
                    $chosen_terms[$filter_name] = $data['terms'];
                    $link = add_query_arg( 'filter_' . $filter_name, join(',', $data['terms']), $link );
                }
            }
            foreach ( $_chosen_attributes as $name => $data ) {
                $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
                if ( ! empty( $data['terms'] )  && is_array($data['terms'])) {
                    foreach ($data['terms'] as $term) {
                        $name = $filter_name . '_' . $term;
                        $filter_arr[$name]['url'] = remove_query_arg('filter_' . $name, $link);
                    }
                }
            }
        }
        if(isset($filter_arr['min_price'])) {
            $filter_arr['min_price']['url'] = remove_query_arg('min_price', $link);
        }
        if(isset($filter_arr['max_price'])) {
            $filter_arr['max_price']['url'] = remove_query_arg('max_price', $link);
        }
        if(!empty($filter_arr)):?>
            <div class="clear-filter-wrap">
                <div class="container">
                    <?php foreach ($filter_arr as $key => $value):
                        if(isset($value['active']) && $value['active']):
                            $url = str_replace('%2C', ',', $value['url']);?>
                            <a class="clear-filter-<?php echo esc_attr($key) ?> gsf-link transition03 no-animation" href="<?php echo esc_url($url); ?>"><?php echo esc_attr($value['title']) . wp_kses_post($value['value']); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if(!empty($chosen_terms)):
                        foreach($chosen_terms as $name => $terms):
                            $term_link = remove_query_arg('filter_' . $name, $link);
                            $temp = $terms;
                            foreach ($terms as $k => $term):
                                unset($temp[$k]);
                                if(!empty($temp)) {
                                    $term_link = add_query_arg( 'filter_' . $name, join(',', $temp), $term_link );
                                }
                                $term_link = str_replace('%2C', ',', $term_link);
                            ?>
                                <a class="clear-filter-<?php echo esc_attr($name) ?> gsf-link transition03 no-animation" href="<?php echo esc_url($term_link); ?>"><?php echo wp_kses_post($term); ?></a>
                            <?php
                                $temp = $terms;
                            endforeach;
                        endforeach;
                    endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif;?>
</div>