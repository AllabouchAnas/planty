<?php
/**
 *  Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $map_height
 * @var $map_height_lg
 * @var $map_height_md
 * @var $map_height_sm
 * @var $map_height_mb
 * @var $map_zoom
 * @var $scroll_wheel
 * @var $overlay
 * @var $map_style
 * @var $map_style_content
 * @var $markers
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Google_Map
 */
$el_class = $map_height = $map_height_lg = $map_height_md = $map_height_sm = $map_height_mb = $map_zoom = $scroll_wheel = $overlay = $map_style = $map_style_content = $markers =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);

extract($atts);

if (intval($map_zoom) <= 0 || intval($map_zoom) > 22) {
	$map_zoom = 13;
}
$wrapper_classes = array(
	'gsf-google-map',
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$map_class = 'google-map-' . uniqid();
$map_height = str_replace('|', '', $map_height);
$map_height_lg = str_replace('|', '', $map_height_lg);
$map_height_md = str_replace('|', '', $map_height_md);
$map_height_sm = str_replace('|', '', $map_height_sm);
$map_height_mb = str_replace('|', '', $map_height_mb);
$map_css = <<<CSS
    .{$map_class} {
        height: {$map_height};
    }
    @media (max-width: 1199px) {
        .{$map_class} {
            height: {$map_height_lg};
        }    
    }
    @media (max-width: 991px) {
        .{$map_class} {
            height: {$map_height_md};
        }    
    }
    @media (max-width: 767px) {
        .{$map_class} {
            height: {$map_height_sm};
        }    
    }
    @media (max-width: 575px) {
        .{$map_class} {
            height: {$map_height_mb};
        }    
    }
CSS;
GSF()->customCss()->addCss($map_css);
$wrapper_classes[] = $map_class;

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
$googlemap_api_key = G5P()->options()->get_google_map_api_key();

//$protocol = (!empty ($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://maps.google.com/maps/api/js?libraries=places&language=" : "http://maps.google.com/maps/api/js?libraries=places&language=";
//
//wp_enqueue_script('gmap3', G5P()->helper()->getAssetUrl('shortcodes/google-map/assets/js/gmap3/gmap3.min.js'), array('jquery'), G5P()->pluginVer(), true);
//wp_enqueue_script('google-map', $protocol . get_locale() . '&key=' . esc_html($googlemap_api_key), array('jquery'), '1.0', false);
//
//
//wp_enqueue_style(G5P()->assetsHandle('google-map'), G5P()->helper()->getAssetUrl('shortcodes/google-map/assets/scss/google-map.min.css'), array(), G5P()->pluginVer());

$map_style_snippet = '';
switch ($map_style) {
	case 'theme':
		$map_style_snippet = '[{featureType:"all",elementType:"geometry.fill",stylers:[{visibility:"on"},{color:"#f3f2ee"}]},{featureType:"poi.attraction",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.business",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.government",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.medical",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.park",elementType:"geometry.fill",stylers:[{color:"#c9dfb0"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.park",elementType:"labels.text.stroke",stylers:[{color:"#000000"},{visibility:"off"}]},{featureType:"poi.place_of_worship",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.school",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"poi.sports_complex",elementType:"labels.text.fill",stylers:[{color:"#333333"}]},{featureType:"road",elementType:"geometry.fill",stylers:[{color:"#ffffff"},{visibility:"on"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{visibility:"on"},{color:"#e5e5e1"}]},{featureType:"road",elementType:"geometry.fill",stylers:[{color:"#ffffff"},{visibility:"on"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{visibility:"on"},{color:"#e5e5e1"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#141414"}]},{featureType:"road.arterial",elementType:"geometry.fill",stylers:[{color:"#fefd89"}]},{featureType:"water",elementType:"geometry.fill",stylers:[{color:"#a6c0db"}]}]';
		break;
	case 'light':
		$map_style_snippet = '[{featureType:"all",elementType:"geometry.fill",stylers:[{weight:"2.00"}]},{featureType:"all",elementType:"geometry.stroke",stylers:[{color:"#9c9c9c"}]},{featureType:"all",elementType:"labels.text",stylers:[{visibility:"on"}]},{featureType:"landscape",elementType:"all",stylers:[{color:"#f2f2f2"}]},{featureType:"landscape",elementType:"geometry.fill",stylers:[{color:"#ffffff"}]},{featureType:"landscape.man_made",elementType:"geometry.fill",stylers:[{color:"#ffffff"}]},{featureType:"poi",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"all",stylers:[{saturation:-100},{lightness:45}]},{featureType:"road",elementType:"geometry.fill",stylers:[{color:"#f1f0ef"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#7b7b7b"}]},{featureType:"road",elementType:"labels.text.stroke",stylers:[{color:"#ffffff"}]},{featureType:"road.highway",elementType:"all",stylers:[{visibility:"simplified"}]},{featureType:"road.arterial",elementType:"labels.icon",stylers:[{visibility:"off"}]},{featureType:"transit",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"water",elementType:"all",stylers:[{color:"#edf7fb"},{visibility:"on"}]},{featureType:"water",elementType:"geometry.fill",stylers:[{color:"#edf7fb"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#070707"}]},{featureType:"water",elementType:"labels.text.stroke",stylers:[{color:"#ffffff"}]}]';
		break;
	case 'sliver':
		$map_style_snippet = '[{elementType:"geometry",stylers:[{color:"#f5f5f5"}]},{elementType:"labels.icon",stylers:[{visibility:"off"}]},{elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{elementType:"labels.text.stroke",stylers:[{color:"#f5f5f5"}]},{featureType:"administrative.land_parcel",elementType:"labels.text.fill",stylers:[{color:"#bdbdbd"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#e5e5e5"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#ffffff"}]},{featureType:"road.arterial",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#dadada"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{featureType:"road.local",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#e5e5e5"}]},{featureType:"transit.station",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#c9c9c9"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]}]';
		break;
	case 'retro':
		$map_style_snippet = '[{elementType:"geometry",stylers:[{color:"#ebe3cd"}]},{elementType:"labels.text.fill",stylers:[{color:"#523735"}]},{elementType:"labels.text.stroke",stylers:[{color:"#f5f1e6"}]},{featureType:"administrative",elementType:"geometry.stroke",stylers:[{color:"#c9b2a6"}]},{featureType:"administrative.land_parcel",elementType:"geometry.stroke",stylers:[{color:"#dcd2be"}]},{featureType:"administrative.land_parcel",elementType:"labels.text.fill",stylers:[{color:"#ae9e90"}]},{featureType:"landscape.natural",elementType:"geometry",stylers:[{color:"#dfd2ae"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#dfd2ae"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#93817c"}]},{featureType:"poi.park",elementType:"geometry.fill",stylers:[{color:"#a5b076"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#447530"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#f5f1e6"}]},{featureType:"road.arterial",elementType:"geometry",stylers:[{color:"#fdfcf8"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#f8c967"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#e9bc62"}]},{featureType:"road.highway.controlled_access",elementType:"geometry",stylers:[{color:"#e98d58"}]},{featureType:"road.highway.controlled_access",elementType:"geometry.stroke",stylers:[{color:"#db8555"}]},{featureType:"road.local",elementType:"labels.text.fill",stylers:[{color:"#806b63"}]},{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#dfd2ae"}]},{featureType:"transit.line",elementType:"labels.text.fill",stylers:[{color:"#8f7d77"}]},{featureType:"transit.line",elementType:"labels.text.stroke",stylers:[{color:"#ebe3cd"}]},{featureType:"transit.station",elementType:"geometry",stylers:[{color:"#dfd2ae"}]},{featureType:"water",elementType:"geometry.fill",stylers:[{color:"#b9d3c2"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#92998d"}]}]';
		break;
	case 'dark':
		$map_style_snippet = '[{elementType:"geometry",stylers:[{color:"#212121"}]},{elementType:"labels.icon",stylers:[{visibility:"off"}]},{elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{elementType:"labels.text.stroke",stylers:[{color:"#212121"}]},{featureType:"administrative",elementType:"geometry",stylers:[{color:"#757575"}]},{featureType:"administrative.country",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"administrative.land_parcel",stylers:[{visibility:"off"}]},{featureType:"administrative.locality",elementType:"labels.text.fill",stylers:[{color:"#bdbdbd"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#181818"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{featureType:"poi.park",elementType:"labels.text.stroke",stylers:[{color:"#1b1b1b"}]},{featureType:"road",elementType:"geometry.fill",stylers:[{color:"#2c2c2c"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#8a8a8a"}]},{featureType:"road.arterial",elementType:"geometry",stylers:[{color:"#373737"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#3c3c3c"}]},{featureType:"road.highway.controlled_access",elementType:"geometry",stylers:[{color:"#4e4e4e"}]},{featureType:"road.local",elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{featureType:"transit",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#000000"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#3d3d3d"}]}]';
		break;
	case 'night':
		$map_style_snippet = '[{elementType:"geometry",stylers:[{color:"#242f3e"}]},{elementType:"labels.text.fill",stylers:[{color:"#746855"}]},{elementType:"labels.text.stroke",stylers:[{color:"#242f3e"}]},{featureType:"administrative.locality",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#263c3f"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#6b9a76"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#38414e"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{color:"#212a37"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#9ca5b3"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#746855"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#1f2835"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#f3d19c"}]},{featureType:"transit",elementType:"geometry",stylers:[{color:"#2f3948"}]},{featureType:"transit.station",elementType:"labels.text.fill",stylers:[{color:"#d59563"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#17263c"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#515c6d"}]},{featureType:"water",elementType:"labels.text.stroke",stylers:[{color:"#17263c"}]}]';
		break;
	case 'aubergine':
		$map_style_snippet = '[{elementType:"geometry",stylers:[{color:"#1d2c4d"}]},{elementType:"labels.text.fill",stylers:[{color:"#8ec3b9"}]},{elementType:"labels.text.stroke",stylers:[{color:"#1a3646"}]},{featureType:"administrative.country",elementType:"geometry.stroke",stylers:[{color:"#4b6878"}]},{featureType:"administrative.land_parcel",elementType:"labels.text.fill",stylers:[{color:"#64779e"}]},{featureType:"administrative.province",elementType:"geometry.stroke",stylers:[{color:"#4b6878"}]},{featureType:"landscape.man_made",elementType:"geometry.stroke",stylers:[{color:"#334e87"}]},{featureType:"landscape.natural",elementType:"geometry",stylers:[{color:"#023e58"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#283d6a"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#6f9ba5"}]},{featureType:"poi",elementType:"labels.text.stroke",stylers:[{color:"#1d2c4d"}]},{featureType:"poi.park",elementType:"geometry.fill",stylers:[{color:"#023e58"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#3C7680"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#304a7d"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#98a5be"}]},{featureType:"road",elementType:"labels.text.stroke",stylers:[{color:"#1d2c4d"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#2c6675"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#255763"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#b0d5ce"}]},{featureType:"road.highway",elementType:"labels.text.stroke",stylers:[{color:"#023e58"}]},{featureType:"transit",elementType:"labels.text.fill",stylers:[{color:"#98a5be"}]},{featureType:"transit",elementType:"labels.text.stroke",stylers:[{color:"#1d2c4d"}]},{featureType:"transit.line",elementType:"geometry.fill",stylers:[{color:"#283d6a"}]},{featureType:"transit.station",elementType:"geometry",stylers:[{color:"#3a4762"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#0e1626"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#4e6d70"}]}]';
		break;
	case 'custom':
		$map_style_snippet = rawurldecode(base64_decode(strip_tags($map_style_content)));
		break;
	default:
		$map_style_snippet = '';
}

$map_style_snippet = json_encode($map_style_snippet);

$map_id = 'map-' . uniqid();
?>
<div id="<?php echo esc_attr($map_id) ?>"
     class="<?php echo esc_attr($css_class) ?>">
</div>
<?php
$markers = (array)vc_param_group_parse_atts($markers); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var gmMapDiv = $("<?php echo '#' . $map_id; ?>");
        (
            function ($) {
                if (gmMapDiv.length) {
                    gmMapDiv.gmap3({
                        action: "init",
                        marker: {
                            values: [
								<?php
								foreach ($markers as $marker) {
								$address = isset($marker['address']) ? $marker['address'] : '';
								if (empty($address)) {
									continue;
								}


								$description = isset($marker['description']) ? '<div class="gmap-marker-content">' . $marker['description'] . '</div>' : '';
								$title = isset($marker['title']) ? '<h5 class="gmap-marker-title">' . $marker['title'] . '</h5>' : '';
								$icon = isset($marker['icon']) ? $marker['icon'] : '';
								$icon_url = '';
								if ($icon != '') {
									$icon = wp_get_attachment_image_src($icon, 'full');
									if (is_array($icon) && !empty($icon)) {
										$icon_url = $icon[0];
									}
								}

								if (empty($icon_url)) {
									$icon_url = G5P()->pluginUrl('shortcodes/google-map/assets/images/map-point.png');
								}

								$_data = "0";
								if ($title !== '' || $description !== '') {
									$_data = '<div class="gmap-marker-wrap">' . $title . $description . '</div>';
									$_data = json_encode(nl2br($_data));
								}
								?>
                                {
                                    address: "<?php echo esc_js($address); ?>",
                                    data: <?php echo '' . $_data;?>,
                                    options: {
                                        icon: '<?php echo esc_url($icon_url); ?>',
										<?php if('on' === $overlay): ?>
                                        visible: false
										<?php endif; ?>
                                    }
                                },
								<?php } ?>
                            ],
                            events: {
                                click: function (marker, event, context) {
                                    if (context.data == 0) {
                                        return;
                                    }
                                    var map = $(this).gmap3("get");
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                                    if (infowindow) {
                                        infowindow.open(map, marker);
                                        infowindow.setContent(context.data);
                                    } else {
                                        $(this).gmap3({
                                            infowindow: {
                                                anchor: marker,
                                                options: {content: context.data}
                                            }
                                        });
                                    }
                                },
                                callback: function (m) { //m will be the array of markers
                                    var bounds = new google.maps.LatLngBounds();
                                    for (var i = 0; i < m.length; ++i) {
                                        bounds.extend(m[i].getPosition());
                                    }
                                    try {
                                        var map = $(this).gmap3({action: 'get'});
                                        map.fitBounds(bounds);
                                        map.setCenter(bounds.getCenter())
                                    } catch (e) {
                                    }
                                }
                            }
                        },
						<?php if('on' === $overlay): ?>
                        overlay: {
                            values: [
								<?php
								foreach ($markers as $marker) {
								$address = isset($marker['address']) ? $marker['address'] : '';
								$description = isset($marker['description']) ? '<div class="gmap-marker-desc">' . $marker['description'] . '</div>' : '';
								$title = isset($marker['title']) ? '<h5 class="gmap-marker-title">' . $marker['title'] . '</h5>' : '';
								$icon = isset($marker['icon']) ? $marker['icon'] : '';
								$icon_url = '';
								if ($icon != '') {
									$icon = wp_get_attachment_image_src($icon, 'full');
									$icon_url = $icon[0];
								}

								$_data = "0";
								if ($title !== '' || $description !== '') {
									$_data = '<div class="gmap-marker-wrap">' . $title . $description . '</div>';

								}
								$_data = json_encode(nl2br($_data));
								?>
                                {
                                    address: "<?php echo esc_js($address); ?>",
                                    data: <?php echo($_data);?>,
                                    options: {
                                        content: '<div><div class="map-point-animate">' + '<div class="map-point-center<?php echo(!empty($icon_url) ? ' has-icon' : ''); ?>"><?php echo(!empty($icon_url) ? '<img src="' . $icon_url . '">' : ''); ?></div>' + '<div class="map-point-signal"></div>' + '<div class="map-point-signal2"></div>' + '</div></div>',
                                    }
                                },
								<?php } ?>
                            ],
                            events: {
                                click: function (overlay, event, context) {
                                    if (context.data == 0) {
                                        return;
                                    }
                                    var map = $(this).gmap3("get");
                                    infowindow = $(this).gmap3({get: {name: "infowindow"}});
                                    if (infowindow) {
                                        infowindow.open(map, overlay);
                                        infowindow.setContent(context.data);
                                    } else {
                                        $(this).gmap3({
                                            infowindow: {
                                                anchor: overlay,
                                                options: {content: context.data}
                                            }
                                        });
                                    }
                                },
                                callback: function (m) { //m will be the array of markers
                                    var bounds = new google.maps.LatLngBounds();
                                    for (var i = 0; i < m.length; ++i) {
                                        bounds.extend(m[i].getPosition());
                                    }
                                    try {
                                        var map = $(this).gmap3({action: 'get'});
                                        map.fitBounds(bounds);
                                        map.setCenter(bounds.getCenter())
                                    } catch (e) {
                                    }
                                }
                            }
                        },
						<?php endif; ?>
                        map: {
                            options: {
                                zoom: parseInt( <?php echo esc_attr($map_zoom) ?> ),
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                zoomControl: true,
                                mapTypeControl: false,
                                scaleControl: false,
                                scrollwheel: <?php echo($scroll_wheel === 'on' ? 'true' : 'false'); ?>,
                                streetViewControl: false,
                                draggable: true,
								<?php if (!empty($map_style_snippet)): ?>
                                styles: <?php echo json_decode($map_style_snippet) ?>
								<?php endif; ?>
                            }
                        }
                    });
                }
            }
        )(jQuery);
    });
</script>
