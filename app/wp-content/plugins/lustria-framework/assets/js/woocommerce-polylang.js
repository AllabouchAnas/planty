var G5_Woocommerce_Polylang = window.G5_Woocommerce_Polylang || {};
(function ($) {
	"use strict";
	window.G5_Woocommerce_Polylang = G5_Woocommerce_Polylang;


	/* Storage Handling */
	var $supports_html5_storage = true;

	try {
		$supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
		window.sessionStorage.setItem( 'g5', 'test' );
		window.sessionStorage.removeItem( 'g5' );
	} catch( err ) {
		$supports_html5_storage = false;
	}

	G5_Woocommerce_Polylang = {
		init: function () {
			this.removeMiniCartCache();
		},
		removeMiniCartCache: function () {
			if ($supports_html5_storage) {
				var current_lang = sessionStorage.getItem('g5_current_lang');
				if (current_lang !== g5_woocommerce_polylang_var.current_lang) {
					if ( typeof wc_cart_fragments_params !== 'undefined' ) {
						sessionStorage.removeItem(wc_cart_fragments_params.fragment_name);
					}
					sessionStorage.setItem('g5_current_lang', g5_woocommerce_polylang_var.current_lang);
				}
			}
		}
	};

	$(document).ready(function () {
		G5_Woocommerce_Polylang.init();
	});

})(jQuery);
