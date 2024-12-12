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
var GSF_TypographyClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_TypographyClass.prototype = {
		init: function() {
			this.fontSizeChange();
			this.fontFamilyChange();
			this.variantChange();
		},
		fontSizeChange: function () {
			var that = this;
			this.$container.find('.gsf-typography-size-value,.gsf-typography-size-unit').on('change', function () {
				var $sizeValue = that.$container.find('.gsf-typography-size-value'),
					$sizeUnit = that.$container.find('.gsf-typography-size-unit'),
					$fontSize = that.$container.find('.gsf-typography-size');
				if ($sizeValue.val() != '') {
					$fontSize.val($sizeValue.val() + '' + $sizeUnit.val());
				}
				that.changeField();
			});
		},
		fontFamilyChange: function () {
			var that = this;
			this.$container.find('.gsf-typography-font-family').on('change', function () {
				that.bindFontVariants();
				that.$container.find('.gsf-typography-variants').trigger('change');
			});
		},
		variantChange: function () {
			var that = this;
			this.$container.find('.gsf-typography-variants').on('change', function () {
				var variant = $(this).val();
				if (variant.indexOf('italic') != -1) {
					that.$container.find('.gsf-typography-style').val('italic');
				}
				else {
					that.$container.find('.gsf-typography-style').val('');
				}
				variant = variant.replace('italic', '');
				that.$container.find('.gsf-typography-weight').val(variant);
				that.changeField();
			});
		},
		bindFontVariants: function () {
			var $this = this.$container.find('.gsf-typography-font-family'),
				familyName = $this.val(),
				font = {},
				i;
			for (i in GSF_TYPOGRAPHY_META_DATA.activeFonts) {
				if (GSF_TYPOGRAPHY_META_DATA.activeFonts[i].family == familyName) {
					font = GSF_TYPOGRAPHY_META_DATA.activeFonts[i];
					break;
				}
			}
			var html = '';
			if (font.variants != null) {
				for (i in font.variants) {
					html += '<option value="' + font.variants[i] + '">' + font.variants[i] + '</option>';
				}
			}
			this.$container.find('.gsf-typography-variants').html(html);
		},

		changeField: function () {
			this.$container.find('.gsf-typography-font-family').trigger('gsf_field_control_changed');
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
})(jQuery);