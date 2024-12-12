/**
 * font field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_FontClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_FontClass.prototype = {
		init: function() {
			if (GSF_FontObject.googleFonts != null) {
				this.initFont();
			}
			else {
				GSF_FontObject.fontField.push(this);
			}
		},
		initFont: function() {
			var self = this,
				$fontKind = self.$container.find('.gsf-font-size-kind'),
				$fontSize = self.$container.find('.gsf-font-size-full'),
				$fontSizeValue = self.$container.find('.gsf-font-size-value'),
				$fontSizeUnit = self.$container.find('.gsf-font-size-unit'),
				$fontFamily = self.$container.find('.gsf-font-family > select'),
				$fontWeightStyle = self.$container.find('.gsf-font-weight-style > select'),
				$fontWeight = self.$container.find('.gsf-font-weight'),
				$fontStyle = self.$container.find('.gsf-font-style'),
				$fontSubsetsWrapper = self.$container.find('.gsf-font-subsets'),
				$fontSubsets = self.$container.find('.gsf-font-subsets > select');

			var html = '',
				group, item, i;
			for (var groupKey in GSF_FontObject.googleFonts) {
				group = GSF_FontObject.googleFonts[groupKey];
				html += '<optgroup label="' + group['label'] + '">';
				for (i = 0; i < group['items'].length; i++) {
					item = group['items'][i];
					html += '<option value="' + item['family'] + '">' + item['family_label'] + '</option>';
				}
				html += '</optgroup>';
			}
			$fontFamily.html(html);
			var config = {
					allowEmptyOption: true,
					onChange: function () {
						var font = GSF_FontObject.findFont($fontFamily.val());
						if (font != null) {
							$fontKind.val(font.kind);

							/**
							 * Binder Subset
							 */
							if (font.subsets.length > 0) {
								$fontSubsetsWrapper.show();
								self.binderSubsets(font.subsets);
							}
							else {
								$fontSubsetsWrapper.hide();
								$fontSubsets.val('');
							}

							/**
							 * Binder variants
							 */

							self.binderFontVariants(font.variants);
							$fontWeightStyle.trigger('change');
						}

						/**
						 * Set Init Value
						 */
						if (!self.$container.data('init-done')) {
							$fontWeightStyle.val($fontWeightStyle.data('value'));
							$fontSubsets.val($fontSubsets.data('value'));
							self.$container.data('init-done', true);
						}
					}
				},
				select = $fontFamily.selectize(config),
				currentValue = $fontFamily.data('value');
			select[0].selectize.setValue(currentValue);

			// Change Font Size
			$fontSizeValue.on('change', function() {
				if ($fontSizeValue.val() == '') {
					$fontSize.val('');
				}
				else {
					$fontSize.val($fontSizeValue.val() + $fontSizeUnit.val());
				}

				self.changeField();
			});
			$fontSizeUnit.on('change', function () {
				if ($fontSizeUnit.val() === 'em') {
					$fontSizeValue.attr('step', 0.01);
				}
				else {
					$fontSizeValue.attr('step', 1);
				}
				if ($fontSizeValue.val() == '') {
					$fontSize.val('');
				}
				else {
					$fontSize.val($fontSizeValue.val() + $fontSizeUnit.val());
				}
				self.changeField();
			});

			/**
			 * Change Font Weight & Style
			 */
			$fontWeightStyle.on('change', function () {
				var fontWeightValue = $fontWeightStyle.val(),
					fontWeight = fontWeightValue.replace('italic', ''),
					fontStyle = fontWeightValue.substring(fontWeight.length);
				$fontWeight.val(fontWeight);
				$fontStyle.val(fontStyle);
				self.changeField();
			});
		},
		binderSubsets: function(arr) {
			var html = '',
				i;
			for (i = 0; i< arr.length; i++) {
				html += '<option value="' + arr[i] + '">' + arr[i] + '</option>';
			}
			this.$container.find('.gsf-font-subsets > select').html(html);
		},
		binderFontVariants: function (arr) {
			var html = '',
				i,
				fontWeightValue,
				fontWeight,
				fontStyle;
			for (i = 0; i < arr.length; i++) {
				fontWeightValue = arr[i];
				fontWeight = fontWeightValue.replace('italic', '');
				fontStyle = fontWeightValue.substring(fontWeight.length);
				html += '<option value="' + (fontWeight + fontStyle) + '">' + fontWeight + (fontStyle == '' ? '' : ' ' + fontStyle) + '</option>';
			}
			this.$container.find('.gsf-font-weight-style > select').html(html);
		},

		/**
		 * Change Field
		 */
		changeField: function() {
			this.$container.find('[data-field-control]').first().trigger('gsf_field_control_changed');
		},
		getValue: function() {
			var val = {};
			this.$container.find('[data-field-control]').each(function () {
				var $this = $(this),
					name = $this.attr('name'),
					property = name.replace(/^(.*)(\[)([^\]]*)(\])*$/g,function(m,p1,p2,p3,p4) {return p3;});
				val[property] = $this.val();
			});
			return val;
		}
	};

	/**
	 * Define object field
	 */
	var GSF_FontObject = {
		googleFonts: null,
		fontField: [],
		init: function () {
			$.ajax({
				url: GSF_META_DATA.ajaxUrl,
				data: {
					action: 'gsf_get_fonts'
				},
				success: function (res) {
					GSF_FontObject.googleFonts = JSON.parse(res);
					setTimeout(function () {
						for (var i = 0; i < GSF_FontObject.fontField.length; i++) {
							GSF_FontObject.fontField[i].initFont();
						}
					}, 50);
				}
			});
		},
		findFont: function(value) {
			var groupKey,
				i,
				font = null;
			for (groupKey in GSF_FontObject.googleFonts) {
				for (i = 0; i < GSF_FontObject.googleFonts[groupKey]['items'].length; i++) {
					font = GSF_FontObject.googleFonts[groupKey]['items'][i];
					if (font['family'] == value) {
						return font;
					}
				}
			}
			return null;
		}
	};

	$(document).ready(function() {
		GSF_FontObject.init();
	});
})(jQuery);