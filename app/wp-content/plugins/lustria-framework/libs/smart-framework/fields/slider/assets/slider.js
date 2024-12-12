/**
 * slider field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_SliderClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_SliderClass.prototype = {
		init: function() {
			var self = this,
				$slider = self.$container.find('.gsf-slider-place'),
				slider = $slider[0],
				$input = self.$container.find('input'),
				options = $slider.data('options'),
				config = {
					step: options['step'],
					range: {
						'min': options['min'],
						'max': options['max']
					}
				};


			if ($input.length == 1) {
				config.start = $input.val();
				config.connect = [true, false];
			}
			else {
				config.start = [$input[0].value, $input[1].value];
				config.connect = [false, true, false];
			}
			noUiSlider.create(slider, config);

			slider.noUiSlider.on('update', function( values, handle ) {
				$input[handle].value = self.getSlideValue(values[handle], parseFloat(options['step']));

			});
			slider.noUiSlider.on('change', function(){
				self.$container.find('[data-field-control]').first().trigger('gsf_field_control_changed');
			});
			$input.on('change', function () {
				if ($input.length == 1) {
					slider.noUiSlider.set(this.value);
				}
				else {
					slider.noUiSlider.set([$input[0].value, $input[1].value]);
				}

			});
		},
		getSlideValue: function(value, step) {
			if (Math.round(step) == step) {
				return Math.round(value);
			}
			if (Math.round(step*10) == step * 10) {
				return Math.round(value*10)/10;
			}
			return value;
		},
		getValue: function() {
			if (this.$container.find('.gsf-field-slider-range').length) {
				var val = {};
				this.$container.find('[data-field-control]').each(function () {
					var $this = $(this),
						name = $this.attr('name'),
						property = name.replace(/^(.*)(\[)([^\]]*)(\])*$/g,function(m,p1,p2,p3,p4) {return p3;});
					val[property] = $this.val();
				});
				return val;
			}
			return this.$container.find('[data-field-control]').val();
		}
	};
})(jQuery);