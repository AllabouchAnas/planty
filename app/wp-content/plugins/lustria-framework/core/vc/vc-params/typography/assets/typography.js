(function ($) {
	"use strict";
	vc.atts.gsf_typography = {
		init: function (param, $field) {
			var $inputField = $field.find('.gsf_typography_field');
			$field.find('select').on('change',function(){
				var font_family = $field.find('[name="font_family"]').val(),
					font_variant = $field.find('[name="font_variant"]').val(),
					preview = $field.find('.typography-preview p'),
					font_weight = '',
					font_style = '';
                if($(this).attr('name') == 'font_family') {
					var variants = $('option[value="' + font_family + '"]',$(this)).attr('data-font-variants');
                    var field_variants = $field.find('[name="font_variant"]').html('');
                    variants = variants.split('|');
                    $.each(variants, function ($index, $variant) {
                        field_variants.append( $("<option>").val($variant).html($variant));
                    });
                    font_variant = field_variants.val();
                }
                if(font_variant.indexOf('i') != -1) {
                    font_style = 'italic';
                    font_weight = font_variant.substring(0, font_variant.indexOf('i'));
                    if(!font_weight || '' == font_weight) {
                        font_weight = '400';
                    }
                } else {
                    font_style = 'normal';
                    if(font_variant == 'regular') {
                        font_weight = '400';
					} else {
                        font_weight = font_variant;
                    }
                }
                preview.css({
                	'font-family': font_family,
					'font-weight': font_weight,
					'font-style': font_style
				});

                var value = font_family + '|' + font_variant + '|' + font_weight + '|' + font_style;
				$inputField.val(value);
				$inputField.trigger('change');
			});
		}
	}
})(jQuery);
