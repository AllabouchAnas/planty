(function ($) {
	"use strict";
	var GF_Dashboard_System_Status = function() {
		this.init();
	};
	GF_Dashboard_System_Status.prototype = {
		init: function() {
			this.tooltips();
			this.get_status_report();
			this.copy();
			this.textarea_click();
		},
		tooltips: function() {
			if ($().powerTip) {
				var options = {};
				$('.gsf-tooltip').powerTip(options);
			}
		},
		get_status_report : function() {
			var self = this;
			$('.gsf-debug-report').on('click', function (event) {
				event.preventDefault();
				var $wrap = $(this).closest('.gsf-system-status-info'),
					$parent = $(this).closest('.gsf-system-info'),
					$info = $wrap.find('.gsf-system-report');

				var report = '';
				$('.gsf-box:not(.gsf-copy-system-status)', '.gsf-dashboard-content').each(function () {
					var $heading = $(this).find('.gsf-box-head'),
						$system_status = $(this).find('.gsf-system-status-list');
					report += "\n### " + $.trim($heading.text()) + " ###\n\n";

					$('li', $system_status).each(function () {
						var $label = $(this).find('.gsf-label'),
							$info = $(this).find('.gsf-info'),
							the_name = $.trim($label.text()).replace(/(<([^>]+)>)/ig, ''),
							the_value = $.trim($info.text()).replace(/(<([^>]+)>)/ig, '');

						report += '' + the_name + ': ' + the_value + "\n";

					});

				});
				$('.gsf-system-report textarea[name="system-report"]').val(report);

				$parent.slideUp("slow", function () {
					$info.slideDown('slow',function() {
						self.select_all();
					});
				});
			});
		},
		select_all : function() {
			$('.gsf-system-report textarea[name="system-report"]').focus().select();
		},
		copy : function() {
			var self = this;
			$(".gsf-copy-system-report").on('click', function (e) {
				e.preventDefault();
				self.select_all();
				document.execCommand('copy');
			});
		},
		textarea_click: function () {
			var self = this;
			$('.gsf-system-report textarea[name="system-report"]').on('click',function () {
				self.select_all();
			});
		}

	};

	$(document).ready(function(){
		new GF_Dashboard_System_Status();
	});
})(jQuery);
