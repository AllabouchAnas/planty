/**
 * checkbox_list field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_Checkbox_listClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_Checkbox_listClass.prototype = {
		init: function() {
		},
		getValue: function() {
			var val = [];
			this.$container.find('[data-field-control]').each(function () {
				var $this = $(this);
				if ($this.prop('checked')) {
					val.push($this.val());
				}
			});
			return val;
		}
	};
})(jQuery);