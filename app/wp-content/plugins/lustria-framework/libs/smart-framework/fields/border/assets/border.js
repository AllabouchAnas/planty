/**
 * border field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_BorderClass = function($container) {
	this.$container = $container;
};
(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_BorderClass.prototype = {
		init: function() {
			var self = this,
				$colorField = self.$container.find('.gsf-border-color');
			/**
			 * Init Color
			 */
			var data = $.extend(
				{
					change: function () {
						var $this = $(this);
						setTimeout(function() {
							self.changeField();
						}, 50);
					},
					clear: function () {
						setTimeout(function() {
							self.changeField();
						}, 50);
					}
				},
				$colorField.data('options')
			);
			$colorField.wpColorPicker(data);
		},
		getValue: function() {
			var val = {};
			this.$container.find('[data-field-control]').each(function () {
				var $this = $(this),
					name = $this.attr('name'),
					property = name.replace(/^(.*)(\[)([^\]]*)(\])*$/g,function(m,p1,p2,p3,p4) {return p3;});
				val[property] = $(this).val();
			});
			return val;
		},
		changeField: function () {
			this.$container.find('.gsf-border-color').trigger('gsf_field_control_changed');
			this.$container.find('.gsf-border-color').trigger('change');
		}
	};
})(jQuery);