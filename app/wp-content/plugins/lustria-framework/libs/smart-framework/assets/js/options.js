var GSF_THEME_OPTION;
(function($) {
	"use strict";

	GSF_THEME_OPTION = {
		_isSavingData: false,
		init: function() {
			this.headerSize();
			this.affixHeader();
			this.backupListener();
			this.checkFieldChange();
			this.saveOptions();
			this.resetOptions();
			this.resetSection();
			this.windowResize();
			this.sectionClickedEvent();
			this.presetProcess();
			this.optionMessage();
			this.deletePreset();
		},
		optionMessage: function () {
			var $warningMsg = $('<div class="gsf-theme-options-message gsf-warning">' + GSF_META_DATA.msgSaveWarning  + '</div>'),
				$successMsg = $('<div class="gsf-theme-options-message gsf-success">' + GSF_META_DATA.msgSaveSuccess  + '</div>');;
			if ($('.gsf-theme-options-preset').length == 0) {
				$('.gsf-theme-options-action-inner').prepend($warningMsg).prepend($successMsg);
			}
			else {
				$('.gsf-meta-box-fields').prepend($warningMsg).prepend($successMsg);
			}

		},
		headerSize: function () {
			var $wrapper = $('.gsf-theme-options-action-wrapper'),
				$header = $wrapper.find('.gsf-theme-options-action-inner');
			$header.outerWidth($wrapper.width());
		},
		affixHeader: function() {
			$(window).scroll(function () {
				var $wrapper = $('.gsf-theme-options-action-wrapper'),
					scrollTop = $(window).scrollTop(),
					wrapperTop = $wrapper.offset().top;
				if (scrollTop > wrapperTop - 32) {
					$wrapper.addClass('gsf-affix');
				}
				else {
					$wrapper.removeClass('gsf-affix');
				}
			});
		},
		windowResize: function() {
			$(window).resize(function() {
				GSF_THEME_OPTION.affixHeader();
				GSF_THEME_OPTION.headerSize();
			});
		},
		sectionClickedEvent: function () {
			$(document).on('gsf_section_changed', function () {
				GSF_THEME_OPTION.affixHeader();
				GSF_THEME_OPTION.headerSize();
			});
		},


		backupListener: function() {
			$(document).on('click','.gsf-theme-options-import', function () {
				var _current_page = $('#_current_page').val(),
					_current_preset = $('#_current_preset').val();

				$.magnificPopup.open({
					items: {
						src: GSF_META_DATA.ajaxUrl + '?action=gsf_import_popup&_current_page=' + _current_page + '&_current_preset=' + _current_preset,
						type: 'ajax'
					},
					mainClass: 'mfp-move-horizontal',
					callbacks: {
						ajaxContentAdded: function() {
							GSF_THEME_OPTION.importData(this.content);
							GSF_THEME_OPTION.exportData(this.content);
						}
					},
					openDelay: 0,
					removalDelay: 200,
					midClick: true
				});
			});
		},

		importData: function ($container) {
			$container.find('.gsf-theme-options-backup-import button').on('click', function () {
				var $this = $(this),
					dataImport = $this.parent().find('textarea').val();

				if (dataImport == '') {
					return;
				}
				if (!confirm(GSF_META_DATA.msgConfirmImportData)) {
					return;
				}
				if ($this.data('importing')) {
					return;
				}

				var $wpnonce = $('#_wpnonce'),
					wpnonce = $wpnonce.val(),
					_current_page = $('#_current_page').val(),
					_current_preset = $('#_current_preset').val();
				$this.data('importing', true);
				$this.html('<i class="fa fa-spin fa-spinner"></i> ' + $this.data('importing-text'));

				$.ajax({
					url: GSF_META_DATA.ajaxUrl,
					data: {
						_wpnonce: wpnonce,
						_current_page: _current_page,
						_current_preset: _current_preset,
						action: 'gsf_import_theme_options',
						backup_data: dataImport
					},
					type: 'post',
					success: function(res) {
						$this.data('importing', false);
						$this.html($this.data('import-text'));
						if (res == 1) {
							alert(GSF_META_DATA.msgImportDone);
							window.location.reload();
						}
						else {
							alert(GSF_META_DATA.msgImportError);
						}
					}
				});
			});
		},
		exportData: function ($container) {
			$container.find('.gsf-theme-options-backup-export button').on('click', function () {
				var $wpnonce = $('#_wpnonce'),
					wpnonce = $wpnonce.val(),
					_current_page = $('#_current_page').val(),
					_current_preset = $('#_current_preset').val();
				window.open(GSF_META_DATA.ajaxUrl + '?action=gsf_export_theme_options&_wpnonce=' + wpnonce+'&_current_page=' + _current_page + '&_current_preset=' + _current_preset,'_blank');
			});
		},

		checkFieldChange: function () {
			$(document).on('gsf_field_change', '.gsf-field', function() {
				var $warningMsg = $('.gsf-theme-options-message.gsf-warning'),
					$successMsg = $('.gsf-theme-options-message.gsf-success');
				if ($successMsg.is(":visible")) {
					$successMsg.slideUp(function() {
						if (!$warningMsg.is(":visible")) {
							$warningMsg.slideDown();
						}
					});
				}
				else {
					if (!$warningMsg.is(":visible")) {
						$warningMsg.slideDown();
					}
				}

				window.onbeforeunload = GSF_THEME_OPTION.confirmWhenPageExit;
			});
		},
		confirmWhenPageExit: function(event) {
			if(!event) event = window.event;
			event.cancelBubble = true;
			event.returnValue = '';

			if (event.stopPropagation) {
				event.stopPropagation();
				event.preventDefault();
			}
		},

		/**
		 * Reset theme options in section
		 *
		 * Done: reload page
		 * Error: message error
		 */
		resetSection: function () {
			$(document).on('click', '.gsf-theme-options-reset-section', function() {
				if (GSF_THEME_OPTION._isSavingData) {
					return;
				}
				if (!confirm(GSF_META_DATA.msgConfirmResetSection)) {
					return;
				}
				var $this = $(this),
					$wpnonce = $('#_wpnonce'),
					wpnonce = $wpnonce.val(),
					_current_page = $('#_current_page').val(),
					_current_preset = $('#_current_preset').val(),
					currentSection = $('.gsf-sections').find('li.active').data('id');
				GSF_THEME_OPTION.showLoading('reset_section');
				$.ajax({
					url: GSF_META_DATA.ajaxUrl,
					data: {
						_wpnonce: wpnonce,
						_current_page: _current_page,
						_current_preset: _current_preset,
						action: 'gsf_reset_section_options',
						section: currentSection
					},
					type: 'post',
					success: function(res) {
						GSF_THEME_OPTION.hideLoading('reset_section');
						if (res == 1) {
							alert(GSF_META_DATA.msgResetSectionDone);
							window.location.reload();
						}
						else {
							alert(GSF_META_DATA.msgResetSectionError);
						}
					}
				});
			});
		},

		/**
		 * Reset theme options
		 *
		 * Done: reload page
		 * Error: message error
		 */
		resetOptions: function () {
			$(document).on('click', '.gsf-theme-options-reset-options', function() {
				if (GSF_THEME_OPTION._isSavingData) {
					return;
				}
				if (!confirm(GSF_META_DATA.msgConfirmResetOptions)) {
					return;
				}
				var $this = $(this),
					$wpnonce = $('#_wpnonce'),
					wpnonce = $wpnonce.val(),
					_current_page = $('#_current_page').val(),
					_current_preset = $('#_current_preset').val();

				GSF_THEME_OPTION.showLoading('reset_option');
				$.ajax({
					url: GSF_META_DATA.ajaxUrl,
					data: {
						_wpnonce: wpnonce,
						_current_page: _current_page,
						_current_preset: _current_preset,
						action: 'gsf_reset_theme_options'
					},
					type: 'post',
					success: function(res) {
						GSF_THEME_OPTION.hideLoading('reset_option');
						if (res == 1) {
							alert(GSF_META_DATA.msgResetOptionsDone);
							window.location.reload();
						}
						else {
							alert(GSF_META_DATA.msgResetOptionsError);
						}
					}
				});
			});
		},
		saveOptions: function () {

			$(window).bind('keydown', function(event) {
				if (event.ctrlKey || event.metaKey) {
					if('s' === String.fromCharCode(event.which).toLowerCase()) {
						event.preventDefault();
						$('.gsf-theme-options-save-options', '.gsf-theme-options-page').trigger('click');
						return false;
					}
				}
			});

			$('.gsf-theme-options-form').ajaxForm({
				beforeSubmit: function() {
					if (GSF_THEME_OPTION._isSavingData) {
						return false;
					}
					GSF_THEME_OPTION.showLoading('save');
				},
				success: function (res) {
					window.onbeforeunload = null;
					GSF_THEME_OPTION.hideLoading('save');
					if (res.success) {
						var $warningMsg = $('.gsf-theme-options-message.gsf-warning'),
							$successMsg = $('.gsf-theme-options-message.gsf-success');
						if ($warningMsg.is(":visible")) {
							$warningMsg.slideUp(function() {
								$successMsg.slideDown();
							});
						}
						else {
							$successMsg.slideDown();
						}

					}
				}
			});
		},
		deletePreset: function () {
			$(document).on('click', '.gsf-preset-action-delete', function() {
				if (GSF_THEME_OPTION._isSavingData) {
					return;
				}
				if (!confirm(GSF_META_DATA.msgConfirmDeletePreset)) {
					return;
				}
				var $this = $(this),
					$wpnonce = $('#_wpnonce'),
					wpnonce = $wpnonce.val(),
					_current_page = $('#_current_page').val(),
					_current_preset = $('#_current_preset').val();

				GSF_THEME_OPTION.showLoading('delete_preset');
				$.ajax({
					url: GSF_META_DATA.ajaxUrl,
					data: {
						_wpnonce: wpnonce,
						_current_page: _current_page,
						_current_preset: _current_preset,
						action: 'gsf_delete_preset'
					},
					type: 'post',
					success: function(res) {
						GSF_THEME_OPTION.hideLoading('delete_preset');
						if (res == 1) {
							$('.gsf-theme-options-preset-select li').first().trigger('click');
						}
						else {
							alert(GSF_META_DATA.msgDeletePresetError);
						}
					}
				});
			});
		},
		showLoading: function(type) {
			var $wrap = $('.gsf-meta-box-wrap'),
				$button;
			$wrap.addClass('in');
			GSF_THEME_OPTION._isSavingData = true;

			switch (type) {
				case 'save': {
					$button = $('.gsf-theme-options-save-options');
					$button.data('button-text', $button.html());
					$button.html('<i class="fa fa-spin fa-spinner"></i> ' + GSF_META_DATA.msgSavingOptions);
					break;
				}
				case 'reset_option': {
					$button = $('.gsf-theme-options-reset-options');
					$button.data('button-text', $button.html());
					$button.html('<i class="fa fa-spin fa-spinner"></i> ' + GSF_META_DATA.msgResettingOptions);
					break;
				}
				case 'reset_section': {
					$button = $('.gsf-theme-options-reset-section');
					$button.data('button-text', $button.html());
					$button.html('<i class="fa fa-spin fa-spinner"></i> ' + GSF_META_DATA.msgResettingSection);
					break;
				}
				case 'delete_preset': {
					$button = $('.gsf-preset-action-delete');
					$button.data('button-text', $button.html());
					$button.html('<i class="fa fa-spin fa-spinner"></i> ' + GSF_META_DATA.msgDeletingPreset);
					break;
				}
			}
		},
		hideLoading: function (type) {
			var $wrap = $('.gsf-meta-box-wrap'),
				$button;
			$wrap.removeClass('in');

			GSF_THEME_OPTION._isSavingData = false;

			switch (type) {
				case 'save': {
					$button = $('.gsf-theme-options-save-options');
					$button.html($button.data('button-text'));
					break;
				}
				case 'reset_option': {
					$button = $('.gsf-theme-options-reset-options');
					$button.html($button.data('button-text'));
					break;
				}
				case 'reset_section': {
					$button = $('.gsf-theme-options-reset-section');
					$button.html($button.data('button-text'));
					break;
				}
				case 'reset_section': {
					$button = $('.gsf-preset-action-delete');
					$button.html($button.data('button-text'));
					break;
				}
			}
		},
		presetProcess: function () {
			$(document).on('click', function(event) {
				if ($(event.target).closest('.gsf-theme-options-preset-select').length == 0) {
					$('.gsf-theme-options-preset-select').removeClass('in');
				}
			});
			$(document).on('click', '.gsf-theme-options-preset-create', function () {
				$.magnificPopup.open({
					items: {
						src: '#gsf_options_preset_popup',
						type: 'inline'
					},
					mainClass: 'mfp-move-horizontal',
					callbacks: {
						open: function() {
							var $inputPreset = $('.gsf-theme-options-preset-popup-content input');
							$inputPreset.val('');
							setTimeout(function() {
								$inputPreset.focus();
							}, 200);

						}
					},
					openDelay: 0,
					removalDelay: 100,
					midClick: true
				});
			});
			$(document).on('click', '.gsf-theme-options-preset-select', function () {
				$(this).toggleClass('in');
			});
			$('.gsf-theme-options-preset-popup-content button').on('click', function () {
				var _preset_title = $('.gsf-theme-options-preset-popup-content input').val()
				if (_preset_title != '') {
					var $this = $(this);
					if ($this.hasClass('gsf-preset-creating')) {
						return;
					}
					$this.addClass('gsf-preset-creating');

					var $wpnonce = $('#_wpnonce'),
						wpnonce = $wpnonce.val(),
						_current_page = $('#_current_page').val(),
						_current_preset = $('#_current_preset').val();

					$('.gsf-theme-options-preset-popup-content button i').addClass('fa-spin fa-spinner');

					$.ajax({
						url: GSF_META_DATA.ajaxUrl,
						data: {
							_wpnonce: wpnonce,
							_current_page: _current_page,
							_current_preset: _current_preset,
							_preset_title: _preset_title,
							action: 'gsf_create_preset_options'
						},
						type: 'post',
						success: function(res) {
							$('.gsf-theme-options-preset-popup-content button i').removeClass('fa-spin fa-spinner');
							$this.removeClass('gsf-preset-creating');
							$('.gsf-theme-options-preset-popup').find('.mfp-close').trigger('click')

							var $wrapperRes = $(res);
							$('.gsf-theme-options-page').html($wrapperRes);

							$wrapperRes.find('.gsf-meta-box-wrap').each(function() {
								GSF.fields.initFields($(this));
							});
							GSF_THEME_OPTION.saveOptions();
							GSF_THEME_OPTION.headerSize();
							GSF_THEME_OPTION.optionMessage();
							$(document).trigger('gsf_section_changed');
							$('.gsf-field').trigger('gsf_check_required');
							$('.gsf-field').trigger('gsf_check_preset');
							_current_preset = $('#_current_preset').val();
							GSF_THEME_OPTION.changeLocation(_current_preset);
						},
						error: function () {
							$('.gsf-theme-options-preset-popup-content button i').removeClass('fa-spin fa-spinner');
							$this.removeClass('gsf-preset-creating');
						}
					});
				}
			});

			$(document).on('click', '.gsf-theme-options-preset-select li', function () {
				if ($('.gsf-theme-options-message.gsf-warning').is(':visible')) {
					if (!confirm(GSF_META_DATA.msgPreventChangeData)) {
						return;
					}
				}
				var $this = $(this);
				if ($this.hasClass('gsf-preset-creating')) {
					return;
				}

				var _current_preset = $('#_current_preset').val(),
					_view_preset = $this.data('preset');
				if (_current_preset != _view_preset) {
					$this.addClass('gsf-preset-creating');
					$('.gsf-theme-options-page').addClass('in');
					GSF_THEME_OPTION.getPresetOptions(_view_preset, $this);
				}
			});
		},
		getPresetOptions: function (_current_preset, $this) {
			var _current_page = $('#_current_page').val();
			$.ajax({
				url: GSF_META_DATA.ajaxUrl,
				data: {
					_current_page: _current_page,
					_current_preset: _current_preset,
					action: 'gsf_ajax_theme_options'
				},
				type: 'post',
				success: function(res) {
					window.onbeforeunload = null;
					if ($this != null) {
						$this.removeClass('gsf-preset-creating');
					}
					$('.gsf-theme-options-page').removeClass('in');
					$('.gsf-theme-options-preset-popup').find('.mfp-close').trigger('click')

					var $wrapperRes = $(res);
					$('.gsf-theme-options-page').html($wrapperRes);


					$wrapperRes.find('.gsf-meta-box-wrap').each(function() {
						GSF.fields.initFields($(this));
					});
					GSF_THEME_OPTION.headerSize();
					GSF_THEME_OPTION.saveOptions();
					GSF_THEME_OPTION.optionMessage();
					$(document).trigger('gsf_section_changed');

					$('.gsf-field').trigger('gsf_check_required');
					//$('.gsf-field').trigger('gsf_check_preset');
					GSF_THEME_OPTION.changeLocation(_current_preset);
				},
				error: function () {
					if ($this != null) {
						$this.removeClass('gsf-preset-creating');
					}
					$('.gsf-theme-options-page').removeClass('in');
				}
			});
		},
		changeLocation: function (presetName) {
			var currentUrl = window.location.href;
			if (presetName == '') {
				currentUrl = currentUrl.replace(/(&_gsf_preset=)([^&]*)/g, function(m, p1, p2) {return ''});
			}
			else {
				if (currentUrl.match(/(&_gsf_preset=)([^&]*)/g)) {
					currentUrl = currentUrl.replace(/(&_gsf_preset=)([^&]*)/g, function(m, p1, p2) {return p1+presetName});
				}
				else {
					currentUrl += '&_gsf_preset=' + presetName;
				}
			}
			window.history.pushState('','',currentUrl);
		}
	}
	$(document).ready(function() {
		GSF_THEME_OPTION.init();
	});
})(jQuery);