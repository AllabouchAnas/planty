/**
 * select_ajax field script
 *
 * @package field
 * @version 1.0
 * @author  g5plus
 */

/**
 * Define class field
 */
var GSF_Select_ajaxClass = function($container) {
    this.$container = $container;
};

(function($) {
    "use strict";

    /**
     * Define class field prototype
     */
    GSF_Select_ajaxClass.prototype = {
        init: function() {
            var self = this,
                $selectField = self.$container.find('.gsf-select-ajax'),
                postType = $selectField.data('source');
            var config = {
                plugins: ['remove_button'],
                valueField: 'value',
                labelField: 'label',
                searchField: 'label',
                sortField: 'label',
                options: [],
                create: false,
                onChange: function() {
                },
                load: function(query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: GSF_META_DATA.ajaxUrl,
                        data: {
                            keyword: query,
                            post_type: postType,
                            action: 'gsf_get_posts'
                        },
                        type: 'GET',
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback($.parseJSON(res));
                        }
                    });
                }
            };
            if ($selectField.attr('multiple')) {
                if ($selectField.data('drag')) {
                    config.plugins[1] = 'drag_drop';
                }
            }

            $selectField.find('option.empty-select').remove();

            var $select = $selectField.selectize(config);
            var control = $select[0].selectize;
            var val = $selectField.data('value');
            if (typeof (val) !== "undefined") {
                control.setValue(val);
            }
            $selectField.data('field-no-change', false);
            $selectField.data('field-set-value', false);
        },
        getValue: function() {
            return this.$container.find('[data-field-control]').val();
        }
    };
})(jQuery);