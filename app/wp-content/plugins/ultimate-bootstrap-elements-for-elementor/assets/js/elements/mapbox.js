var UBE_MAP_BOX = UBE_MAP_BOX || {};
(function ($) {
	'use strict';
	UBE_MAP_BOX = {
		options: {
			locations: [],
			zoom: 12,
			minZoom: 0,
			skin: 'skin1',
			gestureHandling: 'cooperative',// "greedy",
			draggable: true,
			scrollwheel: true,
			navigationControl: true,
			mapTypeControl: false,
			streetViewControl: false,
		},
		skins: [],
		getSkin: function (skin) {
			return UBE_MAP_BOX.skins[skin] ? UBE_MAP_BOX.skins[skin] : UBE_MAP_BOX.skins.skin1
		},
		addListener: function (el, e, t) {
			el.on(e, function (e) {
				t(e);
			});
		}
	};

	UBE_MAP_BOX.skins = {
		skin1: "mapbox://styles/mapbox/streets-v10",
		skin2: "mapbox://styles/mapbox/outdoors-v10",
		skin3: "mapbox://styles/mapbox/light-v9",
		skin4: "mapbox://styles/mapbox/dark-v9",
		skin6: "mapbox://styles/mapbox/satellite-streets-v10",
		skin7: "mapbox://styles/mapbox/navigation-preview-day-v4",
		skin8: "mapbox://styles/mapbox/navigation-preview-night-v4",
		skin9: "mapbox://styles/mapbox/navigation-guidance-day-v4",
		skin10: "mapbox://styles/mapbox/navigation-guidance-night-v4",
		skin12: ""
	};



	UBE_MAP_BOX.LatLng = function (latitude, longitude) {
		this.init(latitude, longitude);
	};

	UBE_MAP_BOX.LatLng.prototype.init = function (latitude, longitude) {
		this.latitude = latitude;
		this.longitude = longitude;
		this.latlng = new mapboxgl.LngLat(longitude, latitude);
	};

	UBE_MAP_BOX.LatLng.prototype.getLatitude = function () {
		return this.latlng.lat;
	};


	UBE_MAP_BOX.LatLng.prototype.getLongitude = function () {
		return this.latlng.lng;
	};

	UBE_MAP_BOX.LatLng.prototype.toGeocoderFormat = function () {
		return [this.getLongitude(), this.getLatitude()].join(",");
	};

	UBE_MAP_BOX.LatLng.prototype.getSourceObject = function () {
		return this.latlng;
	};


	UBE_MAP_BOX.LatLngBounds = function (southwest, northeast) {
		this.init(southwest, northeast)
	};

	UBE_MAP_BOX.LatLngBounds.prototype.init = function (southwest, northeast) {
		this.southwest = southwest;
		this.northeast = northeast;
		this.bounds = new mapboxgl.LngLatBounds(southwest, northeast);
	};

	UBE_MAP_BOX.LatLngBounds.prototype.extend = function (e) {
		this.bounds.extend(e.getSourceObject());
	};

	UBE_MAP_BOX.LatLngBounds.prototype.getSourceObject = function () {
		return this.bounds;
	};


	UBE_MAP_BOX.Marker = function (e) {
		this.options = $.extend(true, {
				position: false,
				map: false,
				popup: false,
				animation: false, // 'Drop' | 'Bounce' | 'Wobble'
				draggable: false,
				marker_image : '',
			}
			, e);
		this.init(e);
	};

	UBE_MAP_BOX.Marker.prototype.init = function () {
		var marker_height = 70;
		if (this.options.marker_image !== '') {
			var el = document.createElement('div');
			el.className = "gel-map-box-marker-container";
			$(el).append(this.options.marker_image);
			this.marker = new mapboxgl.Marker({
				element: el,
				draggable: this.options.draggable
			});
			var $image = $(el).find('img');
			marker_height = $image.attr('height');
		} else {
			this.marker = new mapboxgl.Marker({
				draggable: this.options.draggable
			});

		}

		if (this.options.position) {
			this.setPosition(this.options.position);
		}

		if (this.options.map) {
			this.setMap(this.options.map);
		}

		if (this.options.popup) {
			var popup = new mapboxgl.Popup({ offset: [0,-(marker_height / 2)]}).setHTML(
				this.options.popup
			);
			this.marker.setPopup(popup);
		}
	};

	UBE_MAP_BOX.Marker.prototype.getPosition = function () {
		return this.options.position;
	};

	UBE_MAP_BOX.Marker.prototype.setPosition = function (e) {
		this.marker.setLngLat(e.getSourceObject());
		return  this;
	};

	UBE_MAP_BOX.Marker.prototype.setMap = function (e) {
		this.marker.addTo(e.getSourceObject());
		return this;
	};

	UBE_MAP_BOX.Marker.prototype.remove = function () {
		if (this.options.popup) {
			this.options.popup.remove();
		}
		this.marker.remove();
		return this;
	};

	UBE_MAP_BOX.Marker.prototype.getSourceObject = function () {
		return this.marker;
	};

	UBE_MAP_BOX.MAP = function (element) {
		this.$element = $(element);
		this.element = element;
		this.init();
	};

	UBE_MAP_BOX.MAP.prototype.init = function () {
		this.options = $.extend({}, UBE_MAP_BOX.options, this.$element.data('options'));
		this.markers = [];
		this.bounds = new UBE_MAP_BOX.LatLngBounds;
		this.events = {
			zoom_changed: "zoomstart",
			bounds_changed: "moveend"
		};
		this.map = new mapboxgl.Map({
			container: this.options.container ? this.options.container : this.element,
			zoom: parseInt(this.options.zoom, 10),
			minZoom: this.options.minZoom,
			interactive: this.options.draggable,
			style: UBE_MAP_BOX.getSkin(this.options.skin),
			scrollZoom: this.options.scrollwheel
		});

		if (this.options.navigationControl) {
			this.map.addControl(new mapboxgl.NavigationControl({
				showCompass: false
			}));
			this.map.addControl(new mapboxgl.FullscreenControl);
		}

		this.setCenter(new UBE_MAP_BOX.LatLng(0, 0));
		this.maybeAddMarkers();
	};

	UBE_MAP_BOX.MAP.prototype.setZoom = function (e) {
		this.map.setZoom(e);
	};

	UBE_MAP_BOX.MAP.prototype.resetZoom = function (e) {
		this.setZoom(this.options.zoom);
	};

	UBE_MAP_BOX.MAP.prototype.getZoom = function () {
		return Math.floor(this.map.getZoom());
	};

	UBE_MAP_BOX.MAP.prototype.setCenter = function (e) {
		this.map.setCenter(e.getSourceObject());
	};

	UBE_MAP_BOX.MAP.prototype.getSourceObject = function () {
		return this.map;
	};

	UBE_MAP_BOX.MAP.prototype.fitBounds = function (e) {
		if (!e.getSourceObject().isEmpty()) {
			this.map.fitBounds(e.getSourceObject(), {
				padding: 85,
				animate: !1
			});
		}
	};

	UBE_MAP_BOX.MAP.prototype.getBounds = function () {
		return this.map.getBounds();
	};

	UBE_MAP_BOX.MAP.prototype.getSourceObject = function () {
		return this.map;
	};

	UBE_MAP_BOX.MAP.prototype.addListener = function (e, t) {
		this.map.on(this.getSourceEvent(e), function (e) {
			t(e);
		});
	};

	UBE_MAP_BOX.MAP.prototype.getSourceEvent = function (e) {
		return void 0 !== this.events[e] ? this.events[e] : e;
	};

	UBE_MAP_BOX.MAP.prototype.trigger = function (e) {
		this.map.fire(this.getSourceEvent(e));
	};

	UBE_MAP_BOX.MAP.prototype.maybeAddMarkers = function() {
		var markers = this.$element.data('markers'),
			self = this;
		if (markers) {
			$.each(markers, function (index, item) {
				if (item.position) {
					var position = new UBE_MAP_BOX.LatLng(item.position.lat, item.position.lng);
					var marker_option = {
						position: position,
						map: self,
						marker_image: item.marker
					};

					if (item.popup !== '') {
						marker_option.popup = item.popup;
					}


					var marker = new UBE_MAP_BOX.Marker(marker_option);
					self.markers.push(marker);
					self.bounds.extend(marker.getPosition());
				}
			});

			if (self.markers.length < 1) {
				self.setZoom(2);
				self.setCenter(new UBE_MAP_BOX.LatLng(33.9, 27.8));
			}

			if (self.markers.length === 1) {
				self.setCenter(self.markers[0].getPosition());
			}

			if (self.markers.length > 1) {
				self.fitBounds(self.bounds);
			}
		}
	};




	var UbeMapboxHandler = function ($scope, $) {
		var $map_box = $scope.find('.ube-map-box');
		new UBE_MAP_BOX.MAP($map_box[0]);
	};
	 window.addEventListener( 'elementor/frontend/init', () => {
		if (typeof (ube_map_box_config) !== 'undefined' && ube_map_box_config.accessToken !== '') {
			mapboxgl.accessToken = ube_map_box_config.accessToken;
			elementorFrontend.hooks.addAction('frontend/element_ready/ube-mapbox.default', UbeMapboxHandler);
		}
	});
})(jQuery);