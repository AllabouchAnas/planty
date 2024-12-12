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
var GSF_SortableClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_SortableClass.prototype = {
		init: function() {
			this.$container.sortable({
				placeholder: 'gsf-sortable-sortable-placeholder',
				items: '.gsf-field-sortable-item',
				handle: '.dashicons-menu',
				update: function (event, ui) {
					var $wrapper = $(event.target);

					var sortValue = '';
					$wrapper.find('input[type="checkbox"]').each(function() {
						var $this = $(this);
						if (sortValue === '') {
							sortValue += $this.val();
						}
						else {
							sortValue += '|' + $this.val();
						}
					});

					$wrapper.find('.gsf-field-sortable-sort').val(sortValue);
					$wrapper.find('.gsf-field-sortable-sort').trigger('gsf_field_control_changed');
					$wrapper.find('.gsf-field-sortable-sort').trigger('change');
				}
			});
		},
		getValue: function() {
			var val = {};
			this.$container.find('[data-field-control]').each(function () {
				var $this = $(this),
					name = $this.attr('name'),
					property = name.replace(/^(.*)(\[)([^\]]*)(\])*$/g,function(m,p1,p2,p3,p4) {return p3;});
				if (GSF.helper.isCheckBox($this)) {
					if ($this.prop('checked')) {
						val[property] = $this.val();
					}
				}
				else {
					val[property] = $this.val();
				}

			});
			return val;
		}
	};
})(jQuery);