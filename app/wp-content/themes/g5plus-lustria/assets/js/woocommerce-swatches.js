var G5_Woocommerce_Swatches = window.G5_Woocommerce_Swatches || {};
(function ($) {
    "use strict";
    window.G5_Woocommerce_Swatches = G5_Woocommerce_Swatches;

    var price_selector = woocommerce_swatches_var.price_selector,
        localization = woocommerce_swatches_var.localization;
    G5_Woocommerce_Swatches = {
        init: function () {
            this.initSwatches();
            this.events();
        },
        events: function () {
            $('body').on('gf_woocommerce_ajax_success gf_quick_view_success', function () {
                setTimeout(function () {
                    G5_Woocommerce_Swatches.initSwatches();
                }, 500);
                setTimeout(function () {
                    G5_Woocommerce_Swatches.initSwatches();
                }, 1000);
            });
        },
        initSwatches: function () {
            $('.gf-swatches-wrap').each( function() {
                var $swatches = $( this ),
                    $term = $swatches.find(
                        '.swatches-item:not(.swatches-disabled)' ),
                    $resetBtn = $swatches.find(
                        '.reset_variations' ),
                    $product = $swatches.closest(
                        '.product-item-wrap' ),
                    variationData = $.parseJSON(
                        $swatches.attr( 'data-product_variations' ) );

                // add class if empty
                if ( !$swatches.find( '.swatches-inner' ).length ) {
                    $swatches.addClass( 'swatches-empty' );
                }
                if($term.length) {
                    $term.unbind('click').on('click', function (e) {
                        var $this = $(this);

                        if ($this.hasClass('swatches-disabled')) {
                            return false;
                        }
                        $product.find( '.swatches-item' ).removeClass( 'swatches-disabled swatches-enabled' );
                        $this.parent().find( '.swatches-item.swatches-selected' ).removeClass( 'swatches-selected' );

                        if ( $this.hasClass( 'swatches-selected' ) ) {
                            $this.parent().removeClass( 'swatches-activated' );
                            $product.removeClass( 'gf-product-swatched' );

                            if ( ! $product.find( '.swatches-selected' ).length ) {
                                $resetBtn.trigger( 'click' );
                            }
                        }
                        else {
                            $this.parent().addClass( 'swatches-activated' );
                            $this.addClass( 'swatches-selected' );

                            $product.addClass( 'gf-product-swatched' );
                            $resetBtn.addClass( 'show' ).show();
                        }
                        G5_Woocommerce_Swatches.execVariable($swatches, variationData, $resetBtn, $this);
                        e.preventDefault();
                    });
                }
                $resetBtn.unbind( 'click' ).on( 'click', function() {

                    $product.removeClass( 'gf-product-swatched' );

                    $swatches.removeAttr( 'data-variation_id' );
                    $swatches.find( '.swatches-inner' ).removeClass( 'swatches-activated' );
                    $swatches.find( '.swatches-item' ).removeClass( 'swatches-enabled swatches-disabled swatches-selected' );

                    $( 'body' ).trigger( 'gf_reset_add_to_cart_button_text' );

                    $product.find( '.add_to_cart_button' ).removeClass(
                        'ajax_add_to_cart swatches-text-changed added loading' ).text( localization.select_options_text );

                    // reset price
                    var $price = $product.find(
                        price_selector ).not( '.price-cloned' ),
                        $price_cloned = $product.find( '.price-cloned' );

                    if ( $price_cloned.length ) {
                        $price.html( $price_cloned.html() );
                        $price_cloned.remove();
                    }

                    // reset image
                    G5_Woocommerce_Swatches.variationsImageUpdate( false, $product );

                    $( this ).removeClass( 'show' ).hide();

                    return false;
                } );
            } );

            $('.gf-swatches-single-wrap').each(function(){
                var $form = $( 'form.gf-swatches.variations_form' ),
                    $term = $form.find( '.swatches-item' ),
                    $activeTerm = $form.find( '.swatches-item:not(.swatches-disabled)' );
                $term.each( function() {
                    var $this = $( this ),
                        term = $this.attr( 'data-term' ),
                        attr = $this.parent().attr( 'data-attribute' ),
                        $selectbox = $form.find( 'select#' + attr ),
                        val = $selectbox.val();

                    if ( val != '' && term == val ) {
                        $( this ).addClass( 'swatches-selected' );
                    }
                } );
                $activeTerm.unbind( 'click' ).on( 'click', function( e ) {

                    var $this = $( this ),
                        term = $this.attr( 'data-term' ),
                        attr = $this.parent().attr( 'data-attribute' ),
                        $selectbox = $form.find( 'select#' + attr );

                    if ( $this.hasClass( 'swatches-disabled' ) ) {
                        return false;
                    }

                    $selectbox.val( term ).trigger( 'change' );

                    $this.parent().find( '.swatches-selected' ).removeClass( 'swatches-selected' );
                    $this.addClass( 'swatches-selected' );

                    e.preventDefault();
                } );

                $form.on( 'woocommerce_update_variation_values', function() {
                    $form.find( 'select' ).each( function() {
                        var $this = $( this );
                        var $swatch = $this.parent().find( '.swatches-inner' );
                        $swatch.find( '.swatches-item' ).removeClass( 'swatches-enabled' ).addClass( 'swatches-disabled' );
                        $this.find( 'option.enabled' ).each( function() {
                            var val = $( this ).val();
                            $swatch.find(
                                '.swatches-item[data-term="' + val + '"]' ).removeClass( 'swatches-disabled' ).addClass( 'swatches-enabled' );
                        });
                    });
                });

                $form.on( 'reset_data', function() {
                    $( this ).parent().find( '.swatches-selected' ).removeClass( 'swatches-selected' );
                } );
            });
        },
        execVariable: function ($swatches, variationData, $resetBtn, $elm) {
            var attributes = G5_Woocommerce_Swatches.getChosenAttributes(
                $swatches ),
                currentAttributes = attributes.data;
            G5_Woocommerce_Swatches.updateAttributes( $swatches, variationData );
            if ( attributes.count === attributes.chosenCount ) {
                var matching_variations = G5_Woocommerce_Swatches.findMatchingVariations(
                    variationData, currentAttributes ),
                    variation = matching_variations.shift();
                if ( variation ) {
                    // Found variation
                    G5_Woocommerce_Swatches.foundVariation( $swatches, variation );
                }
                else {
                    $resetBtn.trigger( 'click' );
                }
            }
        },
        getChosenAttributes: function( $swatches ) {
            var data = {},
                count = 0,
                chosen = 0,
                $swatch = $swatches.find( '.swatches-inner' );

            $swatch.each( function() {

                var attribute_name = 'attribute_' +
                        $( this ).attr( 'data-attribute' ),
                    value = $( this ).find( '.swatches-item.swatches-selected' ).attr( 'data-term' ) || '';
                if ( value.length > 0 ) {
                    chosen ++;
                }

                count ++;
                data[attribute_name] = value;
            } );
            return {
                'count': count,
                'chosenCount': chosen,
                'data': data
            };
        },

        updateAttributes: function( $swatches, variationData ) {

            var attributes = G5_Woocommerce_Swatches.getChosenAttributes( $swatches ),
                currentAttributes = attributes.data,
                available_options_count = 0,
                $swatch = $swatches.find( '.swatches-inner' );

            $swatch.each( function( idx, el ) {
                var current_attr_sw = $( el ),
                    current_attr_name = 'attribute_' + current_attr_sw.attr( 'data-attribute' ),
                    selected_attr_val = current_attr_sw.find( '.swatches-item.swatches-selected' ).attr( 'data-term' ),
                    selected_attr_val_valid = true,
                    checkAttributes = $.extend( true, {},
                        currentAttributes );
                checkAttributes[current_attr_name] = '';
                $(this).find('.swatches-item').removeClass('swatches-enabled');
                var variations = G5_Woocommerce_Swatches.findMatchingVariations(
                    variationData, checkAttributes );
                // Loop through variations.
                for ( var num in variations ) {
                    if ( typeof variations[num] !== 'undefined' ) {
                        var variationAttributes = variations[num].attributes;
                        for ( var attr_name in variationAttributes ) {
                            if ( variationAttributes.hasOwnProperty(
                                    attr_name ) ) {
                                var attr_val = variationAttributes[attr_name],
                                    variation_active = '';

                                if ( attr_name === current_attr_name ) {
                                    if ( variations[num].variation_is_active ) {
                                        variation_active = 'enabled';
                                    }
                                    if ( attr_val ) {
                                        current_attr_sw.find(
                                            '.swatches-item[data-term="' + attr_val + '"]' ).addClass( 'swatches-' + variation_active );
                                    }
                                    else {
                                        current_attr_sw.find( '.swatches-item' ).addClass( 'swatches-' + variation_active );
                                    }
                                }
                            }
                        }
                    }
                }

                available_options_count = current_attr_sw.find(
                    '.swatches-item.swatches-enabled' ).length;

                if ( selected_attr_val && (
                        available_options_count === 0 || current_attr_sw.find(
                            '.swatches-item.swatches-enabled[data-term="' +
                            G5_Woocommerce_Swatches.addSlashes( selected_attr_val ) + '"]' ).length ===
                        0
                    ) ) {
                    selected_attr_val_valid = false;
                }

                current_attr_sw.find( '.swatches-item:not(.swatches-enabled)' ).addClass( 'swatches-disabled' );

                if ( selected_attr_val ) {
                    if ( ! selected_attr_val_valid ) {
                        current_attr_sw.find( '.swatches-item.swatches-selected' ).removeClass( 'swatches-selected' );
                    }
                }
                else {
                    current_attr_sw.find( '.swatches-item.swatches-selected' ).removeClass( 'swatches-selected' );
                }
            } );
        },
        findMatchingVariations: function( variationData, settings ) {
            var matching = [];
            for ( var i = 0; i < variationData.length; i ++ ) {
                var variation = variationData[i];

                if ( G5_Woocommerce_Swatches.isMatch( variation.attributes, settings ) ) {
                    matching.push( variation );
                }
            }
            return matching;
        },

        isMatch: function( variation_attributes, attributes ) {
            var match = true;
            for ( var attr_name in variation_attributes ) {
                if ( variation_attributes.hasOwnProperty( attr_name ) ) {
                    var val1 = variation_attributes[attr_name];
                    var val2 = attributes[attr_name];
                    if ( val1 !== undefined && val2 !== undefined &&
                        val1.length !== 0 && val2.length !== 0 &&
                        val1 !== val2 ) {
                        match = false;
                    }
                }
            }
            return match;
        },
        addSlashes: function( string ) {
            string = string.replace( /'/g, '\\\'' );
            string = string.replace( /"/g, '\\\"' );
            return string;
        },

        foundVariation: function( $swatches, variation ) {
            var $product = $swatches.closest( '.product' ),
                $price = $product.find( price_selector ).not( '.price-cloned' ),
                $price_clone = $price.clone().addClass( 'price-cloned' ).css( 'display', 'none' );

            if ( variation.price_html ) {

                if ( ! $product.find( '.price-cloned' ).length ) {
                    $product.append( $price_clone );
                }

                $price.replaceWith( variation.price_html );
            }
            else {
                if ( $product.find( '.price-cloned' ).length ) {
                    $price.replaceWith( $price_clone.html() );
                    $price_clone.remove();
                }
            }

            // add variation id
            $swatches.attr( 'data-variation_id', variation.variation_id );

            // update image
            G5_Woocommerce_Swatches.variationsImageUpdate( variation, $product );

            // change add to cart button text
            G5_Woocommerce_Swatches.changeAddToCartBtnText( variation, $product );
        },
        variationsImageUpdate: function( variation, $product ) {

            var $product_img = $product.find( '.wp-post-image' );
            if($product.find('.product-thumb-secondary').length) {
                $product_img = $product.find('.product-thumb-secondary').find( '.wp-post-image' );
            }
            if ( variation && variation.image.src ) {
                G5_Woocommerce_Swatches.setVariationAttr( $product_img, 'src',
                    variation.image.thumb_src );
                G5_Woocommerce_Swatches.setVariationAttr( $product_img, 'srcset',
                    variation.image.thumb_srcset );
            } else {
                G5_Woocommerce_Swatches.resetVariationAttr( $product_img, 'src' );
                G5_Woocommerce_Swatches.resetVariationAttr( $product_img, 'srcset' );
            }
        },
        resetVariationAttr: function( $el, attr ) {
            if ( undefined !== $el.attr( 'data-o_' + attr ) ) {
                $el.attr( attr, $el.attr( 'data-o_' + attr ) );
            }
        },
        setVariationAttr: function( $el, attr, value ) {
            if ( undefined === $el.attr( 'data-o_' + attr ) ) {
                $el.attr( 'data-o_' + attr, (
                    ! $el.attr( attr )
                ) ? '' : $el.attr( attr ) );
            }
            if ( false === value ) {
                $el.removeAttr( attr );
            }
            else {
                $el.attr( attr, value );
            }
        },
        changeAddToCartBtnText: function( variation, $product ) {
            var $atcBtn = $product.find( '.add_to_cart_button' ),
                $added_btn = $product.find('.added_to_cart'),
                text = '';
            $product.removeClass('active');
            $atcBtn.removeClass( 'added' );
            if($added_btn.length) {
                $added_btn.remove();
            }
            $atcBtn.data('product_id', variation.variation_id);
            $atcBtn.attr('data-product_id', variation.variation_id);
            if ( variation.is_in_stock === true ) {
                text = localization.add_to_cart_text;
                $atcBtn.addClass( 'ajax_add_to_cart' );
            }
            else {
                text = localization.read_more_text;
                $atcBtn.removeClass( 'ajax_add_to_cart' );
            }
            $atcBtn.addClass( 'swatches-text-changed' ).text( text );

            $( 'body' ).trigger( 'gf_change_add_to_cart_button_text' );
        }
    };

    $(document).ready(function () {
        G5_Woocommerce_Swatches.init();
    });

})(jQuery);
