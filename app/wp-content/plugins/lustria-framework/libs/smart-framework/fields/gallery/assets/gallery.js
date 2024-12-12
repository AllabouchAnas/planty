/**
 * Define class field
 */
var GSF_GalleryClass = function($container) {
    this.$container = $container;
};
(function ($) {
    "use strict";
    /**
     * Define class field prototype
     */
    GSF_GalleryClass.prototype = {
        init: function() {
            this.select();
            this.remove();
            this.sortable();
            this.changeField();
        },
        select: function () {
            var _media = new GSF_Media(),
                $addButton = this.$container.find('.gsf-gallery-add');
            _media.selectGallery($addButton, {filter: 'image'}, function(attachments) {
                if (attachments.length) {
                    var $this = $(_media.clickedButton);
                    var $parent = $this.parent();
                    var $input = $parent.find('input[type="hidden"]');
                    var valInput = $input.val();
                    var arrInput = valInput.split('|');
                    var imgHtml = '';
                    attachments.each(function(attachment) {
                        attachment = attachment.toJSON();

                        if (arrInput.indexOf('' + attachment.id) != -1) {
                            return;
                        }
                        if (valInput != '') {
                            valInput += '|' + attachment.id;
                        }
                        else {
                            valInput = '' + attachment.id;
                        }
                        arrInput.push('' + attachment.id);

                        var url = '';
                        if (attachment.sizes.thumbnail == null) {
                            url = attachment.sizes.full.url;
                        } else {
                            url = attachment.sizes.thumbnail.url;
                        }

                        imgHtml += '<div class="gsf-gallery-image-preview" data-id="' + attachment.id + '">';
                        imgHtml +='<div class="centered">';
                        imgHtml += '<img src="' + url + '" alt=""/>';
                        imgHtml += '</div>';
                        imgHtml += '<span class="gsf-gallery-remove dashicons dashicons dashicons-no-alt"></span>';
                        imgHtml += '</div>';
                    });
                    $input.val(valInput);
                    $input.trigger('change');
                    $this.before(imgHtml);
                    $this.trigger('gsf-gallery-selected');
                }
            });
        },
        remove: function() {
            this.$container.on('click', '.gsf-gallery-remove', function() {
                var $this = $(this).parent();
                var $parent = $this.parent();
                var $input = $parent.find('input[type="hidden"]');
                $this.remove();
                var valInput = '';
                $('.gsf-gallery-image-preview', $parent).each(function() {
                    if (valInput != '') {
                        valInput += '|' + $(this).data('id');
                    }
                    else {
                        valInput = '' + $(this).data('id');
                    }
                });
                $input.val(valInput);
                $input.trigger('change');
                $parent.trigger('gsf-gallery-removed');
            });
        },
        sortable: function () {
            this.$container.sortable({
                placeholder: "gsf-gallery-sortable-placeholder",
                items: '.gsf-gallery-image-preview',
                update: function( event, ui ) {
                    var $wrapper = $(event.target);
                    var valInput = '';
                    $('.gsf-gallery-image-preview', $wrapper).each(function() {
                        if (valInput != '') {
                            valInput += '|' + $(this).data('id');
                        }
                        else {
                            valInput = '' + $(this).data('id');
                        }
                    });
                    var $input = $wrapper.find('input[type="hidden"]');
                    $input.val(valInput);
                    $input.trigger('change');
                    $wrapper.trigger('gsf-gallery-sortable-updated');
                }
            });
        },
        changeField: function () {
            var self = this;
            this.$container.on('gsf-gallery-selected gsf-gallery-removed gsf-gallery-sortable-updated ',function(event){
                self.$container.find('[data-field-control]').trigger('gsf_field_control_changed');
            });
        },
        getValue: function() {
            return this.$container.find('[data-field-control]').val();
        }
    };
})(jQuery);
