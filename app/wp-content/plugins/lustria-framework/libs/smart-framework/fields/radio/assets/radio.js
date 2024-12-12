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
var GSF_RadioClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_RadioClass.prototype = {
		init: function() {},
		getValue: function() {
			var val = '';
			this.$container.find('[data-field-control]').each(function () {
				var $this = $(this);
				if ($this.prop('checked')) {
					val = $this.val();
				}
			});
			return val;
		}
	};

})(jQuery);