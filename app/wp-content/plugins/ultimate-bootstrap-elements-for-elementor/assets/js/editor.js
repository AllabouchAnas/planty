(function ($) {
    "use strict";
    var UBE_SiteSettings = {
        init: function () {
            this.processColorsEvent();
        },
        processColorsEvent: function () {
            $(window).on('click', function (event) {
                if ($(event.target).closest('.elementor-control.elementor-control-system_colors .pcr-button').length === 0) {
                    return;
                }
                if (!window.elementorFrontend) {
                    return;
                }
                var system_colors = elementorFrontend.getPageSettings('system_colors');
                if (system_colors === undefined) {
                    return;
                }
                if (system_colors.isInitColorEvent) {
                    return;
                }

                system_colors.isInitColorEvent = true;
                for (var i in system_colors.models) {
                    system_colors.models[i].on('change', UBE_SiteSettings.globalColorChanged);
                }
            });
        },
        globalColorChanged: function (e) {
            var system_colors = elementorFrontend.getPageSettings('system_colors');
            if (system_colors === undefined) {
                return;
            }
            UBE_SiteSettings.isInitColorEvent = true;
            var cssVariables = '',
                colorForeground,
                colorHover,
                colorBorder,
                colorActive,
                colorDarken15,
                colorDarken25,
                colorDarken35,
                themeLevelText,
                themeLevelBg,
                themeLevelBorder,
                themeLevelTableBorder,
                themeLevelTextDarken,
                themeLevelBorderDarken;
            for (var i in system_colors.models) {
                var currentColor = system_colors.models[i].attributes.color;
                colorForeground = UBE_Color.colorContrast(currentColor, '#fff', '#212121');
                colorHover = UBE_Color.colorAdjustBrightness(currentColor, '7.5%');
                colorBorder = UBE_Color.colorAdjustBrightness(currentColor, '10%');
                colorActive = UBE_Color.colorAdjustBrightness(currentColor, '12.5%');

                colorDarken15 = UBE_Color.colorAdjustBrightness(currentColor, '15%');
                colorDarken25 = UBE_Color.colorAdjustBrightness(currentColor, '25%');
                colorDarken35 = UBE_Color.colorAdjustBrightness(currentColor, '35%');


                cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-foreground: ' + colorForeground + ';';
                cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-hover: ' + colorHover + ';';
                cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-border: ' + colorBorder + ';';
                cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-active: ' + colorActive + ';';
                cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-darken-15: ' + colorDarken15 + ';';

                if (system_colors.models[i].attributes._id === 'accent') {
                    cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-darken-25: ' + colorDarken25 + ';';
                    cssVariables += '--e-global-color-' + system_colors.models[i].attributes._id + '-darken-35: ' + colorDarken35 + ';';
                }

                // Alert variables
                themeLevelText = UBE_Color.themeColorLevel(currentColor, 6);
                themeLevelBg = UBE_Color.themeColorLevel(currentColor, -10);
                themeLevelBorder = UBE_Color.themeColorLevel(currentColor, -9);
                themeLevelTableBorder = UBE_Color.themeColorLevel(currentColor, -6);
                themeLevelTextDarken = UBE_Color.colorDarken(themeLevelText, '10%');
                themeLevelBorderDarken = UBE_Color.colorDarken(themeLevelBorder, '5%');

                cssVariables += '--ube-theme-level-color-' + system_colors.models[i].attributes._id + '-text: ' + themeLevelText + ';';
                cssVariables += '--ube-theme-level-color-' + system_colors.models[i].attributes._id + '-bg: ' + themeLevelBg + ';';
                cssVariables += '--ube-theme-level-color-' + system_colors.models[i].attributes._id + '-border: ' + themeLevelBorder + ';';
                cssVariables += '--ube-theme-level-color-' + system_colors.models[i].attributes._id + '-table-border: ' + themeLevelTableBorder + ';';
                cssVariables += '--ube-theme-level-color-' + system_colors.models[i].attributes._id + '-text-darken: ' + themeLevelTextDarken + ';';
                cssVariables += '--ube-theme-level-color-' + system_colors.models[i].attributes._id + '-border-darken: ' + themeLevelBorderDarken + ';';
            }
            $('#elementor-preview-iframe').contents().find('#ube-global-variable').html(':root{' + cssVariables + '}');
        }
    };

    // Widget_Area Control
    //--------------------------------------------------------
    var UBE_Widget_Area_Control = {
        init: function () {
            $(window).on('elementor:init', function () {
                $(document).on('click', '.ube-dynamic-content-modal .eicon-close', function () {
                    var $modal = $("#ube_widget_area_modal");
                    $modal.remove();
                });

                var ControlWidgetAreaItemView = elementor.modules.controls.BaseData.extend({
                    onReady: function () {
                        var currentValue = this.getControlValue(),
                            eid = typeof (currentValue['ube_dynamic_content_id']) !== "undefined" ? currentValue['ube_dynamic_content_id'] : '';
                        this.ui.input.val(eid);


                    },
                    onInputChange: function () {
                        var currentValue = {
                                etype: 'ube_element',
                                ube_dynamic_content_id: ''
                            };
                        currentValue['ube_dynamic_content_id'] = this.ui.input.length ? this.ui.input.val() : '';
                        this.setValue(currentValue);
                    }
                });
                elementor.addControlView('widgetarea', ControlWidgetAreaItemView);
            });

            $(document).ready(function () {
                elementor.on("preview:loaded", function () {
                    jQuery(elementor.$previewContents[0].body).on('click', '.widgetarea_warper_edit', function () {
                        $('body').append($('#tmpl-ube-widget-area-modal').html());

                        var $modal = $('#ube_widget_area_modal'),
                            content = $(this).data('content'),
                            setting_name = $(this).data('setting-name'),
                            widget_key = $(this).data('widget-key'),
                            widget_index = $(this).data('widget-index');

                        var key = widget_key + '-' + widget_index;
                        var url = window.ubeEditorData.dynamic_url + '&ube_content_id=' + content + '&key=' + key;

                        var $iframe = $modal.find('#widgetarea_control_iframe');

                        $iframe.attr('src', url);
                        $iframe.on('load', function () {
                            $modal.find('.dialog-loading').hide();

                            var $iframe = $(this);
                            this.contentWindow.elementor.saver.on('after:save:publish', function (event, data) {
                                var indexWidget = $iframe.data('widget-index'),
                                    nameWidget = $iframe.data('widget-setting-name');

                                var $inputs = $('.ube-widget-area-input[data-setting="' + nameWidget  + '"]');
                                for (var index in $inputs) {
                                    if (index === indexWidget) {
                                        if (event.config.document.revisions.current_id) {
                                            $inputs[index].value = event.config.document.revisions.current_id;
                                        }
                                        $($inputs[index]).trigger('input');
                                        break;
                                    }
                                }
                            });
                        });

                        var listWidgetEdit = $(this).closest('.elementor-widget-container').find('[data-setting-name="' + setting_name + '"]');

                        var currentIndex = 0;
                        for (var elIndex in listWidgetEdit) {
                            if (listWidgetEdit[elIndex] === this) {
                                currentIndex = elIndex;
                                break;
                            }
                        }

                        $iframe.data('widget-index', currentIndex);
                        $iframe.data('widget-setting-name', setting_name);
                    });
                });

            });
        }
    };

    // Autocomplete Control
    //--------------------------------------------------------
    var UBE_AutoComplete_Control = {
        init: function () {
            $(window).on("elementor:init", function () {
                var ControlAutocompleteItemView = elementor.modules.controls.BaseData.extend({
                    onReady: function () {
                        var select2options = this.model.get('select2options'),
                            data_args = this.model.get('data_args'),
                            selectType = this.model.get('select_type'),
                            placeholder = this.model.get('placeholder'),
                            ajaxUrl = this.model.get('ajax_url'),
                            multiple = this.model.get('multiple'),
                            control = this,
                            currentValue = control.getControlValue();

                        var request_data = {
                            search: '',
                            page: 1,
                            multiple: multiple,
                            type: selectType,
                            data_args: data_args,
                            currentValue: currentValue,
                            initControl: true
                        };

                        $.ajax({
                            url: ajaxUrl,
                            type: 'post',
                            data: request_data,
                            dataType: 'json',
                            success: function (data) {
                                if (data.results) {
                                    for (var i = 0; i < data.results.length; i++) {
                                        var selectOption = new Option(data.results[i].text, data.results[i].id, true, true)
                                        control.ui.select.append(selectOption);
                                    }
                                }

                                var defaultOptions = {
                                    allowClear: true,
                                    placeholder: placeholder,
                                    minimumInputLength: 1,
                                    ajax: {
                                        url: ajaxUrl,
                                        dataType: 'json',
                                        data: function (params) {
                                            var query = {
                                                search: params.term,
                                                page: params.page || 1,
                                                type: selectType,
                                                multiple: multiple,
                                                data_args: data_args
                                            };

                                            return query;
                                        }
                                    }
                                };

                                if (select2options === undefined) {
                                    select2options = {};
                                }

                                select2options = $.extend(defaultOptions, select2options);
                                control.ui.select.select2(select2options);

                                control.ui.select.on('select2:unselect', function (e) {
                                    var selectedValue = $(e.currentTarget).val();
                                    if (selectedValue != null) {
                                        $(e.currentTarget).find('option').each(function () {
                                            if (selectedValue.indexOf($(this).attr('value')) === -1) {
                                                $(this).remove();
                                            }
                                        });
                                    }

                                })
                            }
                        });
                    },
                    onBeforeDestroy: function () {
                        this.ui.select.select2('destroy');
                    }
                });
                elementor.addControlView('autocomplete', ControlAutocompleteItemView);
            });
        }
    };

    var UBE_BootstrapResponsive_Control = {
        init: function () {
            $(window).on("elementor:init", function () {
                var ControlBootstrapResponsiveItemView = elementor.modules.controls.BaseData.extend({
                    _currentDevice: 'xl',
                    _currentValue: {},
                    onReady: function () {
                        var self = this,
                            data_type = this.model.get('data_type'),
                            mobile_breakpoint = this.model.get('mobile_breakpoint');

                        if (mobile_breakpoint !== undefined) {
                            self.$el.find('.ube-elementor-responsive-switcher-xs').data('width', mobile_breakpoint);
                        }

                        self._currentValue = self.getControlValue();

                        if (typeof (self._currentValue) !== "object") {
                            self._currentValue = {
                                xl: self._currentValue,
                                lg: '',
                                md: '',
                                sm: '',
                                xs: ''
                            };

                            this.setValue(self._currentValue);
                        }

                        var inputValue = typeof (self._currentValue['xl']) !== "undefined" ? self._currentValue['xl'] : '';

                        if (data_type === 'select') {
                            self.ui.select.val(inputValue);
                        }
                        else {
                            self.ui.input.val(inputValue);
                        }

                        self.currentBreakpoint = 'xl';

                        self.$el.find('.ube-elementor-responsive-switcher:first').addClass('active');

                        self.$el.find('.ube-elementor-responsive-switcher').on('click', function () {
                            var $this = $(this),
                                elIndex = $this.data('index'),
                                currentValue = self._currentValue;

                            self._currentDevice = self.getBreakpoints()[elIndex];

                            var inputValue = typeof (currentValue[self._currentDevice]) === "undefined" ? '' : currentValue[self._currentDevice];

                            $this.closest('.ube-elementor-control-responsive-switchers')
                                .toggleClass('ube-elementor-responsive-switchers-open')
                                .css('--selected-option', elIndex);
                            $this.closest('.ube-elementor-control-responsive-switchers')
                                .find('.ube-elementor-responsive-switcher').removeClass('active');

                            $this.addClass('active');

                            if (data_type === 'select') {
                                self.ui.select.val(inputValue);
                            }
                            else {
                                self.ui.input.val(inputValue);
                            }

                            if (self._currentDevice === 'xl') {
                                if (elementor.isDeviceModeActive()) {
                                    elementor.changeDeviceMode('desktop');
                                }
                            }
                            else {
                                if (!elementor.isDeviceModeActive()) {
                                    elementor.changeDeviceMode('tablet');
                                }
                                elementor.$previewResponsiveWrapper.css('--e-editor-preview-width', $this.data('width') + 'px');
                            }
                        });

                        self.$el.find('.ube-elementor-control-responsive-switchers').on('ube/responsive/switcher/changed', function (event, windowWidth) {
                            var currentDeviceIndex = 0;
                            var $this = $(this),
                                $el;

                            if (!elementor.isDeviceModeActive()) {
                                currentDeviceIndex = 0;
                            }
                            else {
                                $this.find('.ube-elementor-responsive-switcher').each(function (index) {
                                    if ($(this).data('width') >= windowWidth) {
                                        currentDeviceIndex = index;
                                    }
                                });
                            }

                            $el = $this.find('a[data-index="' + currentDeviceIndex + '"]');

                            var currentValue = self._currentValue;

                            self._currentDevice = self.getBreakpoints()[currentDeviceIndex];

                            var inputValue = typeof (currentValue[self._currentDevice]) === "undefined" ? '' : currentValue[self._currentDevice];

                            $this.css('--selected-option', currentDeviceIndex);

                            $this.find('.ube-elementor-responsive-switcher').removeClass('active');
                            $el.addClass('active');

                            if (data_type === 'select') {
                                self.ui.select.val(inputValue);
                            }
                            else {
                                self.ui.input.val(inputValue);
                            }
                        });

                        $(document).on('click', function (event) {
                            if ($(event.target).closest('.ube-elementor-control-responsive-switchers').length === 0) {
                                self.$el.find('.ube-elementor-control-responsive-switchers').removeClass('ube-elementor-responsive-switchers-open');
                            }
                        })
                    },
                    onInputChange: function () {
                        var currentValue = JSON.parse(JSON.stringify(this._currentValue)),
                            data_type = this.model.get('data_type');

                        if (data_type === 'select') {
                            currentValue[this._currentDevice] = this.ui.select.length ? this.ui.select.val() : '';
                        }
                        else {
                            currentValue[this._currentDevice] = this.ui.input.length ? this.ui.input.val() : '';
                        }

                        this._currentValue = currentValue;

                        this.setValue(currentValue);
                    },
                    getBreakpoints: function () {
                        return ['xl', 'lg', 'md', 'sm', 'xs'];
                    }
                });
                elementor.addControlView('bootstrap_responsive', ControlBootstrapResponsiveItemView);

                $(elementor.$previewResponsiveWrapper.find('#elementor-preview-iframe')[0].contentWindow).on('resize', function () {
                    if (window.ubePreviewResizeTimeout) {
                        clearTimeout(window.ubePreviewResizeTimeout);
                    }
                    var windowWidth = this.innerWidth;
                    window.ubePreviewResizeTimeout = setTimeout(function () {
                        $('.ube-elementor-control-responsive-switchers').trigger('ube/responsive/switcher/changed', windowWidth);
                    }, 100);

                });
            });
        }
    };

    var UBE_Editor_Templates = {
        init: function () {
            this.renderTemplateButton();
        },
        renderTemplateButton: function () {
            if (typeof (elementorCommon) !== 'undefined') {
                var add_section_tmpl = $("#tmpl-elementor-add-section");

                if (add_section_tmpl.length > 0) {
                    var action_for_add_section = add_section_tmpl.text();
                    action_for_add_section = action_for_add_section.replace('<div class="elementor-add-section-drag-title', '<div class="elementor-add-section-area-button elementor-add-ube-template" title="UBE Templates"> <i class="eicon-folder"></i> </div><div class="elementor-add-section-drag-title');
                    add_section_tmpl.text(action_for_add_section);

                    elementor.on("preview:loaded", function () {
                        UBE_Editor_Templates.templateModal();
                    });
                }
            }
        },
        templateModal: function () {
            $(elementor.$previewContents[0].body).on('click', '.elementor-add-ube-template', function () {
                $('body').append($('#tmpl-ube-template-modal').html());

                $.ajax({
                    type: 'GET',
                    url: ubeEditorData.ajax_url,
                    data: {
                        action: 'ube_get_prebuilt_templates',
                        _ajax_nonce: ubeEditorData.template_nonce
                    }
                }).done(function (res) {
                    if (res.success) {
                        var template = wp.template('ube-template-modal-content'),
                            $modal = $('.ube-templates-modal');

                        $modal.find('.dialog-lightbox-content').append(template(res.data));
                        $modal.find('.dialog-loading').hide();
                    }
                });
            });

            $(document).on('click', '.ube-templates-modal .eicon-close', function () {
                $('.ube-templates-modal').remove();
            });

            $(document).on('click', '.ube-templates-modal .ube-template-item-insert', function () {
                var $this = $(this),
                    $modal = $('.ube-templates-modal'),
                    templateID = $this.data('id');

                $modal.find('.dialog-content').hide();
                $modal.find('.dialog-loading').show();

                $.ajax({
                    type: 'GET',
                    url: ubeEditorData.ajax_url,
                    data: {
                        action: 'ube_get_prebuilt_template_content',
                        _ajax_nonce: ubeEditorData.template_content_nonce,
                        id: templateID
                    }
                }).done(function (res) {
                    if (res.success) {

                        var sectionCount = elementor.getPreviewView().$el.find('.elementor-section-wrap > section ').length;
                        var title = { rendered: 'New Templates ' + sectionCount };

                        var templateModel = new Backbone.Model({
                            getTitle() {
                                return title;
                            },
                        });

                        if (undefined != $e && 'undefined' != typeof $e.internal) {
                            elementor.channels.data.trigger('document/import', templateModel);
                            elementor.getPreviewView().addChildModel(res.data, { at: sectionCount } || {});
                            elementor.channels.data.trigger('template:after:insert', {});
                            $e.internal('document/save/set-is-modified', { status: true })
                        } else {
                            elementor.channels.data.trigger('document/import', templateModel);
                            elementor.getPreviewView().addChildModel(res.data, { at: sectionCount } || {});
                            elementor.channels.data.trigger('template:after:insert', {});
                            elementor.saver.setFlagEditorChange(true);
                        }
                        $modal.remove();
                    }
                    else {
                        $modal.find('.dialog-content').show();
                        $modal.find('.dialog-loading').hide();
                        alert(res.data);
                    }
                });
            });

            $(document).on('keyup input', '.ube-templates-modal .ube-modal-search-template', function () {
                var $this = $(this),
                    search = $this.val().toLowerCase(),
                    $modal = $this.closest('.ube-templates-modal'),
                    $items = $modal.find('.ube-template-item'),
                    count = 0;

                $items.each(function () {
                    if ($(this).data('name').toLowerCase().indexOf(search) !== -1) {
                        $(this).show();
                        count++;
                    }
                    else {
                        $(this).hide();
                    }
                });

                if (count === 0) {
                    $modal.find('.ube-modal-content').addClass('no-items');
                }
                else {
                    $modal.find('.ube-modal-content').removeClass('no-items');
                }

                $modal.find('.ube-modal-sidebar li').removeClass('active');
                $modal.find('.ube-modal-sidebar li:first').addClass('active');
            });
            $(document).on('click', '.ube-modal-sidebar li', function () {
                var $this = $(this),
                    search = $this.data('category'),
                    $modal = $this.closest('.ube-templates-modal'),
                    $items = $modal.find('.ube-template-item'),
                    count = 0;


                $items.each(function () {
                    if ((search === '') || ($(this).data('category').indexOf('|' + search + '|') !== -1)) {
                        $(this).show();
                        count++;
                    }
                    else {
                        $(this).hide();
                    }
                });

                if (count === 0) {
                    $modal.find('.ube-modal-content').addClass('no-items');
                }
                else {
                    $modal.find('.ube-modal-content').removeClass('no-items');
                }

                $(this).parent().find('li').removeClass('active');
                $(this).addClass('active');

                $modal.find('.ube-modal-search-template').val('');
            });
        }
    };

    UBE_Widget_Area_Control.init();
    UBE_AutoComplete_Control.init();
    UBE_BootstrapResponsive_Control.init();

    $(document).ready(function () {
        UBE_SiteSettings.init();
        UBE_Editor_Templates.init();
    });

    $(window).on("elementor:init", function () {
        elementor.on("preview:loaded", function () {
            elementor.$previewContents.on('click', function () {
                $('.ube-elementor-control-responsive-switchers').removeClass('ube-elementor-responsive-switchers-open');
            });
        });
    });
})(jQuery);