/**
 * icon field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_IconClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_IconClass.prototype = {
		init: function() {
			var self = this,
				$iconField = this.$container.find('[data-field-control]'),
				$iconInfo = self.$container.find('.gsf-field-icon-item-info');

			/**
			 * Show icon popup when click icon info
			 */
			$iconInfo.on('click', function() {
				GSF_ICON_POPUP.open(self.getValue(), function(iconValue) {
					$iconField.val(iconValue);
					$iconInfo.find('> span ').attr('class', iconValue);
					$iconField.trigger('gsf_field_control_changed');
					$iconField.trigger('change');
				});
			});
		},
		getValue: function () {
			return this.$container.find('[data-field-control]').val();
		}
	};
})(jQuery);