var GSF_Media = function () {};
(function($) {
	"use strict";
	GSF_Media.prototype = {
		selectImage: function(button, args, callback) {
			this.button = button;
			this.callback = callback;
			var self = this;
			$(self.button).on('click', function(event) {
				event.preventDefault();
				// If the media frame already exists, reopen it.
				self.clickedButton = this;
				if ( self.frame ) {
					self.frame.open();
					return;
				}
				var options = {
					title: 'Select Images',
					button: {
						text: 'Use these images'
					},
					multiple: false
				};
				if ((typeof (args) != "undefined") && (args != null)) {
					if ((typeof (args.title) != "undefined") && (args.title != null) && (args.title != '')) {
						options.title = args.title;
					}
					if ((typeof (args.button) != "undefined") && (args.button != null) && (args.button != '')) {
						options.button.text = args.button;
					}
					if ((typeof (args.filter) != "undefined") && (args.filter != null) && (args.filter != '')) {
						options.library = { type: args.filter };
					}
				}
				// Create a new media frame
				self.frame = wp.media(options);

				self.frame.on( 'select', function() {
					var attachments = self.frame.state().get('selection');
					var attachment = null;
					if (attachments.length) {
						attachment = attachments.first().toJSON();
					}
					self.callback(attachment);
				});
				self.frame.open();
			});
		},
		selectGallery: function(button, args, callback) {
			this.button = button;
			this.callback = callback;
			var self = this;
			$(self.button).on('click', function(event) {
				event.preventDefault();
				// If the media frame already exists, reopen it.
				self.clickedButton = this;
				if ( self.frame ) {
					self.frame.open();
					return;
				}
				var options = {
					title: 'Select Images',
					button: {
						text: 'Use these images'
					},
					multiple: true
				};
				if ((typeof (args) != "undefined") && (args != null)) {
					if ((typeof (args.title) != "undefined") && (args.title != null) && (args.title != '')) {
						options.title = args.title;
					}
					if ((typeof (args.button) != "undefined") && (args.button != null) && (args.button != '')) {
						options.button.text = args.button;
					}
					if ((typeof (args.filter) != "undefined") && (args.filter != null) && (args.filter != '')) {
						options.library = { type: args.filter };
					}
				}
				// Create a new media frame
				self.frame = wp.media(options);

				self.frame.on( 'select', function() {
					var attachments = self.frame.state().get('selection');
					self.callback(attachments);
				});
				self.frame.open();
			});
		}
	}
})(jQuery);