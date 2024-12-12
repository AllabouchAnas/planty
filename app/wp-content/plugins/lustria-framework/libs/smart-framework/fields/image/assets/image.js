/**
 * image field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_ImageClass = function($container) {
	this.$container = $container;
};

(function($) {
	"use strict";

	/**
	 * Define class field prototype
	 */
	GSF_ImageClass.prototype = {
		init: function() {
			this.selectMedia();
		},
		selectMedia: function() {
			var self = this,
				$idField = self.$container.find('.gsf-image-id'),
				$urlField = self.$container.find('.gsf-image-url'),
				$chooseImage = self.$container.find('.gsf-image-choose-image'),
				$removeButton = self.$container.find('.gsf-image-remove'),
				$preview = self.$container.find('.gsf-image-preview img');

			/**
			 * Init Media
			 */
			var _media = new GSF_Media();
			_media.selectImage($chooseImage, {filter: 'image'}, function(attachment) {
				if (attachment) {
					var thumb_url = '';
					if (attachment.sizes === undefined) {
						thumb_url = attachment.url;
					}
					else if (attachment.sizes.thumbnail == undefined) {
						thumb_url = attachment.sizes.full.url;
					}
					else {
						thumb_url = attachment.sizes.thumbnail.url;
					}
					$preview.attr('src', thumb_url);
					$preview.show();
					$idField.val(attachment.id);
					$urlField.val(attachment.url);

					self.changeField();
				}
			});

			/**
			 * Remove Image
			 */
			$removeButton.on('click', function() {
				$preview.attr('src', '');
				$preview.hide();
				$idField.val('');
				$urlField.val('');

				self.changeField();
			});

			$urlField.on('change', function() {
				$.ajax({
					url: GSF_META_DATA.ajaxUrl + '?action=gsf_get_attachment_id',
					data: {
						url: $urlField.val()
					},
					type: 'GET',
					error: function() {
						$idField.val('0');
						self.changeField();
					},
					success: function(res) {
						$idField.val(res);
						self.changeField();
					}
				});
				if ($urlField.val() == '') {
					$preview.attr('src', '');
					$preview.hide();
				}
				else {
					$preview.attr('src', $urlField.val());
					$preview.show();
				}
			});
		},
		changeField: function() {
			this.$container.find('.gsf-image-id').trigger('gsf_field_control_changed');
            this.$container.find('.gsf-image-id').trigger('change');
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