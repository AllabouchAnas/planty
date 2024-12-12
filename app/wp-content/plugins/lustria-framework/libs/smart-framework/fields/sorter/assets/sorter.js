/**
 * sorter field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_SorterClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_SorterClass.prototype = {
		init: function() {
			var self = this,
				$items = this.$container.find('.gsf-field-sorter-group');
			$items.sortable({
				placeholder: 'gsf-sorter-sortable-placeholder',
				items: '.gsf-field-sorter-item',
				connectWith: $('.gsf-field-sorter-group', this.$container),
				update: function (event, ui) {
					var $group = $(event.target),
						groupName = $group.data('group');

					/**
					 * Update input name
					 */
					$group.find('[data-field-control]').each(function () {
						var $this = $(this),
							name = $this.attr('name');
						name = name.replace(/^(.*)(\[)([^\]]*)(\])(\[)([^\]]*)(\])*$/g,function(m,p1,p2,p3,p4,p5,p6,p7) {return p1 + p2 + groupName + p4 + p5 + p6 + p7;});;
						$this.prop('name', name);
					});
					self.$container.find('[data-field-control]').first().trigger('gsf_field_control_changed');
					self.$container.find('[data-field-control]').first().trigger('change');
				}
			});
		},
		getValue: function () {
			var val = {};
			this.$container.find('.gsf-field-sorter-group').each(function () {
				var $group = $(this),
					groupName = $group.data('group');
				val[groupName] = {};
				$group.find('[data-field-control]').each(function () {
					var $this = $(this),
						name = $this.attr('name'),
						property = name.replace(/^(.*)(\[)([^\]]*)(\])*$/g,function(m,p1,p2,p3,p4) {return p3;});
					val[groupName][property] = $this.val();
				});
			});
			return val;
		}
	};
})(jQuery);