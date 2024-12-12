/**
 * radio field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_SwitchClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_SwitchClass.prototype = {
		init: function() {},
		getValue: function() {
			var $check = this.$container.find('[data-field-control]');
			if ($check.prop('checked')) {
				return $check.val();
			}
			return '';
		}
	};

})(jQuery);