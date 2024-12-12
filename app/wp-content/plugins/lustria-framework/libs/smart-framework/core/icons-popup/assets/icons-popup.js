/**
 * ICON POPUP AddOns
 *
 * @type {GSF_ICON_POPUP|*|{}}
 */
var GSF_ICON_POPUP = GSF_ICON_POPUP || {};

(function ($) {
	"use strict";

	GSF_ICON_POPUP = {
		_$popup: [],
		_callback: function () {},
		_currentFontId: 0,
		_timeOutSearch: null,

		init: function () {
			var that = this;
			that._$popup = $('#gsf-popup-icon-wrapper');

			if (that._$popup.length === 0) {
				$.ajax({
					url: GSF_POPUP_DATA.ajaxUrl,
					type: 'post',
					data: {
						action: 'gsf_get_font_icons',
						nonce: GSF_POPUP_DATA.nonce
					},
					success: function (res) {
						var data = JSON.parse(res),
							template = wp.template('gsf-icons-popup'),
							fontName,
							groupIndex,
							groupLength,
							iconsIndex,
							iconsLength,
							iconKey;
						if ($('#tmpl-gsf-icons-popup').length == 0) {
							return;
						}

						for (fontName in data) {
							if (that._currentFontId === 0) {
								that._currentFontId = fontName;
							}
							data[fontName]['icons'] = [];

							groupLength = data[fontName].iconGroup.length;
							for (groupIndex = 0; groupIndex < groupLength; groupIndex++) {

								iconsLength = data[fontName].iconGroup[groupIndex].icons.length;

								for (iconsIndex = 0; iconsIndex < iconsLength; iconsIndex++) {
									iconKey = data[fontName].iconGroup[groupIndex].icons[iconsIndex];

									if (iconKey in data[fontName]['icons']) {
										data[fontName]['icons'][iconKey] += data[fontName].iconGroup[groupIndex].id + '|';
									}
									else {
										data[fontName]['icons'][iconKey] = '|' + data[fontName].iconGroup[groupIndex].id + '|';
									}
								}
							}
						}

						var html = template(data);

						$('body').append(html);

						that._$popup = $('#gsf-popup-icon-wrapper');

						that.settingPopup();
						that.popupListener();
					}
				});
			}
		},
		settingPopup: function() {
			var $fontLinkInner = this._$popup.find('.gsf-popup-icon-font-link-inner'),
				$groupLink = $fontLinkInner.find('.gsf-popup-icon-group-link'),
				$sectionGroup = this._$popup.find('.gsf-popup-icon-group-section'),
				$iconsListing = this._$popup.find('.gsf-popup-icon-listing');

			$fontLinkInner.perfectScrollbar({
				wheelSpeed: 0.5,
				suppressScrollX: true
			});

			$iconsListing.perfectScrollbar({
				wheelSpeed: 0.5,
				suppressScrollX: true
			});

			$groupLink.css('display', 'none');
			$groupLink.first().css('display', 'block');

			$sectionGroup.css('display', 'none');
			$sectionGroup.first().css('display', 'block');

		},
		popupListener: function() {
			var that = this,
				$searchField = that._$popup.find('.gsf-popup-icon-search > input'),
				$sectionLinkItem = that._$popup.find('.gsf-popup-icon-group-link a'),
				$groupTitle = that._$popup.find('.gsf-popup-icon-group-title'),
				$selectFontField = that._$popup.find('.gsf-popup-icon-font > select');


			/**
			 * Search icon
			 */
			$searchField.on('keyup', function () {

				clearTimeout(that._timeOutSearch);

				that._timeOutSearch = setTimeout(function () {
                    var filter = $searchField.val(),
                        $currentFont = that._$popup.find('.gsf-popup-icon-group-section[data-font-id="' + that._currentFontId + '"]'),
                        $icons = $currentFont.find('li');

                    if (filter === '') {
                        $groupTitle.text($groupTitle.data('msg-all'));
                    } else {
                        $groupTitle.text($groupTitle.data('msg-search').replace('{0}', filter));
                    }

                    $icons.each(function(){
                        var $this = $(this);

                        if ($this.attr('title').search(new RegExp(filter, "i")) < 0) {
                            $this.hide();
                        } else {
                            $this.show();
                        }
                    });

                    /**
                     * Update Scroll Bar
                     */
                    that.updateListingScroll();
                },300);

			});

			/**
			 * Filter icon by group
			 */
			$sectionLinkItem.on('click', function() {
				var $currentFont = that._$popup.find('.gsf-popup-icon-group-section[data-font-id="' + that._currentFontId + '"]'),
					$icons = $currentFont.find('li'),
					$this = $(this),
					idSection = $this.data('id');

				$groupTitle.text($this.text());
				$searchField.val('');

				if (idSection === '') {
					/**
					 * Select All
					 */
					$currentFont.find('.gsf-popup-icon-group-section').show();
					$icons.show();

				} else {
					/**
					 * Select Group
					 */
					$icons.hide();
					$icons.each(function() {
						var $this = $(this);
						if ($this.data('group').search(new RegExp('\\|' + idSection + '\\|', "i")) > -1) {
							$this.show();
						} else {
							$this.hide();
						}
					});
				}

				/**
				 * Update Scroll Bar
				 */
				that.updateListingScroll();
			});

			/**
			 * Select an Icon
			 */
			this._$popup.find('.gsf-popup-icon-group-section i').on('click', function() {
				that._$popup.find('.mfp-close').trigger('click');
				that._callback($(this).attr('class'));
			});

			/**
			 * Change font icon
			 */
			$selectFontField.on('change', function() {
				var $fontLinkInner = that._$popup.find('.gsf-popup-icon-font-link-inner'),
					$groupLink = $fontLinkInner.find('.gsf-popup-icon-group-link'),
					$sectionGroup = that._$popup.find('.gsf-popup-icon-group-section'),
					$searchField = that._$popup.find('.gsf-popup-icon-search > input');

				that._currentFontId = $(this).val();
				$groupLink.fadeOut();
				$sectionGroup.fadeOut();

				$groupLink.each(function() {
					var $this = $(this);
					if ($this.data('font-id') === that._currentFontId) {
						$this.fadeIn(function() {
							that.updateLinkScroll();
						});
						return;
					}
				});

				$sectionGroup.each(function() {
					var $this = $(this);
					if ($this.data('font-id') === that._currentFontId) {
						$this.fadeIn(function() {
							that.updateListingScroll();
						});
						return;
					}
				});

				$searchField.val('');
				$searchField.trigger('keyup');
			});

		},
		updateLinkScroll: function() {
			$('.gsf-popup-icon-font-link-inner').perfectScrollbar('update');
		},
		updateListingScroll: function() {
			$('.gsf-popup-icon-listing').perfectScrollbar('update');
		},
		open: function (icon, callback) {
			var that = this,
				$searchField = that._$popup.find('.gsf-popup-icon-search > input');

			$searchField.val('');
			$searchField.trigger('keyup');


			if (typeof (callback) === "function") {
				that._callback = callback;
			}

			$.magnificPopup.open({
				items: {
					src: '#gsf-popup-icon-wrapper',
					type: 'inline'
				},
				mainClass: 'mfp-move-horizontal',
				callbacks: {
					open: function() {
						if ((icon != null) && (icon !== '')) {
							var $currentIcon = that._$popup.find('.gsf-popup-icon-group-section li[title="' + icon + '"]');

							that._$popup.find('.gsf-popup-icon-group-section li').removeClass('active');

							if ($currentIcon.length) {
								$currentIcon.addClass('active');

								var $groupSection = $currentIcon.closest('.gsf-popup-icon-group-section'),
									$selectFontField = that._$popup.find('.gsf-popup-icon-font > select'),
									fontId = $groupSection.data('font-id');
								$selectFontField.val(fontId);

								$selectFontField.trigger('change');

								$('.gsf-popup-icon-listing').scrollTop($currentIcon.position().top);
							}
						}
						that.updateLinkScroll();
						that.updateListingScroll();
					}
				},
				openDelay: 0,
				removalDelay: 100,
				midClick: true
			});
		},
		close: function() {

		}
	}
	$(document).ready(function () {
		GSF_ICON_POPUP.init();
	});
})(jQuery);