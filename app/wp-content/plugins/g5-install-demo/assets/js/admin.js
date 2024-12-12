(function ($) {
	"use strict";
	var GID = {
		_importing: false,
		_tryImportCount: 0,
		_buttonClicked: null,
		_demoData: {},
		_ajaxUrl: '',

		init: function () {
			this.importClick();
		},
		importClick: function() {
			$('.gid-demo-item-import').on('click', function () {
				if (GID._importing) {
					return;
				}
				if (prompt($(this).data('confirm'), '') === 'install'){
					GID._importing = true;
					GID.setWindowOnbeforeunload();
					GID._buttonClicked = this;
					GID.startImport.call(this);
					GID.install();
				}
			});
		},
		install: function () {
			$.ajax({
				url: GID._ajaxUrl,
				data: GID._demoData,
				type: 'POST',
				success: function (res) {
					if (res.success) {
						if (res.data.step !== 'done') {
							GID._tryImportCount = 0;
							var nonce = GID._demoData.nonce;
							GID._demoData = res.data;
							GID._demoData.nonce = nonce;

							GID.installMessage(res.data.message);
							GID.install();
						}
						else {
							GID.finishImport();
							setTimeout(function () {
								alert(res.data.message);
							}, 10);
						}
					}
					else {
						GID.finishImport();
						setTimeout(function () {
							alert(res.data);
						}, 10);
					}
				},
				error: function (res) {
					if (GID._tryImportCount < 3) {
						GID._tryImportCount++;
						GID.install();
					}
					else {
						GID.finishImport();
						alert('Install Fail');
					}
				},
				complete: function (res) {}
			});
		},
		installSetting: function() {
		},
		installMessage: function (text) {
			$(GID._buttonClicked).html('<i class="dashicons dashicons-update gsf-icon-spinner"></i> ' + text + '...');
		},
		startImport: function () {
			var $this = $(GID._buttonClicked),
				$item = $this.closest('.gid-demo-item'),
				$installWrap = $item.closest('.gid-demo-wrapper');

			GID._ajaxUrl = $this.data('ajax');

			GID._demoData = {
				nonce: $installWrap.data('nonce'),
				demo: $item.data('demo'),
				step: 'init'
			};

			$item.find('button').hide();
			$this.show();
			GID.installMessage($this.data('importing'));
		},
		finishImport: function () {
			var $this = $(GID._buttonClicked),
				$itemName = $this.closest('.gid-demo-item-body').find('.gid-demo-item-name');
			GID._importing = false;
			$this.html($this.data('import-done'));
			$itemName.html($itemName.data('name'));
			window.onbeforeunload = null;

		},
		setWindowOnbeforeunload: function () {
			window.onbeforeunload = function(e){
				if(!e) e = window.event;
				e.cancelBubble = true;
				e.returnValue = 'The install demo you made will be lost if you navigate away from this page.';

				if (e.stopPropagation) {
					e.stopPropagation();
					e.preventDefault();
				}
			};
		},
	};
	$(document).ready(function () {
		GID.init();
	});
})(jQuery);