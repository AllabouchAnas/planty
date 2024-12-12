(function ($) {
	$.fn.mapmarker = function (options) {
		var opts = $.extend({}, $.fn.mapmarker.defaults, options);

		return this.each(function () {
			// Apply plugin functionality to each element
			var map_element = this;
			addMapMarker(map_element, opts.mapTypeId, opts.zoomControl, opts.streetViewControl, opts.fullscreenControl, opts.draggable, opts.scaleControl, opts.zoom, opts.styles, opts.center, opts.markers, opts.mapTypeControl);
		});
	};

	// Set up default values
	var defaultMarkers = {
		"markers": []
	};

	$.fn.mapmarker.defaults = {
		zoom: 8,
		center: 'Americal',
		markers: defaultMarkers
	};

	function addMapMarker(map_element, mapTypeId, zoomControl, streetViewControl, fullscreenControl, draggable, scaleControl, zoom, styles, center, markers, mapTypeControl) {
		//Set center of the Map
		var myOptions = {
			mapTypeControl: mapTypeControl,
			zoomControl: zoomControl,
			streetViewControl: streetViewControl,
			fullscreenControl: fullscreenControl,
			draggable: draggable,
			scaleControl: scaleControl,
			zoom: zoom,
			styles: styles,
			mapTypeId: mapTypeId,
		};
		var map = new google.maps.Map(map_element, myOptions);
		var geocoder = new google.maps.Geocoder();
		var infowindow = null;

		geocoder.geocode({'address': center}, function (results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				//In this case it creates a marker, but you can get the lat and lng from the location.LatLng
				map.setCenter(results[0].geometry.location);
			} else {
				console.log("Geocode was not successful for the following reason: " + status);
			}
		});

		//run the marker JSON loop here
		$.each(markers.markers, function (i, the_marker) {
			latitude = the_marker.latitude;
			longitude = the_marker.longitude;
			icon = the_marker.icon;
			var baloon_text = the_marker.baloon_text;

			if (latitude !== "" && longitude !== "") {
				var marker = new google.maps.Marker({
					map: map,
					position: new google.maps.LatLng(latitude, longitude),
					animation: google.maps.Animation.DROP,
					icon: icon
				});

				// Set up markers with info windows
				if (baloon_text !== '') {
					google.maps.event.addListener(marker, 'click', function () {
						// Close all open infowindows
						if (infowindow) {
							infowindow.close();
						}

						infowindow = new google.maps.InfoWindow({
							content: baloon_text
						});

						infowindow.open(map, marker);
					});
				}
			}
		});
	}

})(jQuery);
