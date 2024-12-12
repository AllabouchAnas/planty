(function ($) {
	'use strict';

	var UbeGoogleMapHandler = function ($scope, $) {
		var $map_class = $scope.find('.ube-google-map');
		var id = $map_class.data('id');
		var googlemap_elem = $scope.find('#ube-google-map-' + id).eq(0);
		if (googlemap_elem.length > 0) {
			var mapsettings = googlemap_elem.data('mapmarkers');
			var mapsoptions = googlemap_elem.data('mapoptions');
			var mapstyles = googlemap_elem.data('mapstyle');
			var myMarkers = {
				"markers": mapsettings,
			};
			googlemap_elem.mapmarker({
				mapTypeControl: mapsoptions.mapTypeControl,
				mapTypeId: mapsoptions.mapTypeId,
				zoomControl: mapsoptions.zoomControl,
				streetViewControl: mapsoptions.streetViewControl,
				fullscreenControl: mapsoptions.fullscreenControl,
				draggable: mapsoptions.draggable,
				scaleControl: mapsoptions.scaleControl,
				zoom: mapsoptions.zoom,
				center: mapsoptions.center,
				styles: mapstyles,
				markers: myMarkers,
			});
		}

	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/ube-google-map.default', UbeGoogleMapHandler);
	});

})(jQuery);