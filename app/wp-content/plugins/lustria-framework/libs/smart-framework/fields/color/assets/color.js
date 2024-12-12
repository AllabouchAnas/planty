/**
 * color field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_ColorClass = function($container) {
	this.$container = $container;
};
(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_ColorClass.prototype = {
		init: function() {
			var self = this;
			var data = $.extend(
				{
					change: function () {
						setTimeout(function() {
							self.changeField();
						}, 50);
					},
					clear: function () {
						setTimeout(function() {
							self.changeField();
						}, 50);
					}
				}
			);
			this.$container.find('[data-field-control]').wpColorPicker(data);
		},
		getValue: function() {
			return this.$container.find('[data-field-control]').val();
		},
		changeField: function () {
			this.$container.find('[data-field-control]').trigger('gsf_field_control_changed');
		}
	};
})(jQuery);