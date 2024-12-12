String.prototype.capitalize = function(){
    return this.replace( /((^|\s)+)(.)/g , function(m,p1,p2,p3){ return p1+p3.toUpperCase();
    } );
};

var GSF = GSF || {};

(function($) {
    "use strict";

    var $document = $(document);

    // Control Helper
    GSF.helper = {
        isCheckBox: function($control) {
            return $control.is(':checkbox');
        },
        isRadio: function($control) {
            return $control.is(':radio');
        },
        isText: function($control) {
            return ($control.is('input') || $control.is('textarea')) && !this.isCheckBox($control) && !this.isRadio($control);
        },
        isSelect: function($control) {
            return $control.is('select');
        },
        changeCloneNameIndex: function ($element, name, isInPanel, isInRepeater, panelIndex, repeaterIndex, cloneIndex, isOwnerClone) {
            var isInWidget = $element.closest('.widget-content').length > 0,
                widgetPrefix = '';

            if (isInWidget) {
                widgetPrefix = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8){ return p1 + p2 + p3 + p4;});
                name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8){ return p6 + p8;});
            }

            if (isInPanel && isInRepeater) {
                if (panelIndex >= 0) {
                    if (repeaterIndex >= 0) {
                        if (isOwnerClone) {
                            name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17){ return p1+p2+panelIndex+p4+p5+p6+p7+p8+repeaterIndex+p10+p11+p12+p13+p14+cloneIndex+p16+p17});
                        }
                        else {
                            name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11){ return p1+p2+panelIndex+p4+p5+p6+p7+p8+repeaterIndex+p10+p11});
                        }
                    }
                    else if (isOwnerClone) {
                        name =  name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14){ return p1+p2+panelIndex+p4+p5+p6+p7+p8+p9+p10+p11+cloneIndex+p13+p14});
                    }
                    else {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5){ return p1+p2+cloneIndex+p4+p5});
                    }

                }
                else if (repeaterIndex >= 0) {
                    if (isOwnerClone) {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14){ return p1+p2+p3+p4+p5+repeaterIndex+p7+p8+p9+p10+p11+cloneIndex+p13+p14});
                    }
                    else {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8){ return p1+p2+p3+p4+p5+cloneIndex+p7+p8});
                    }

                }
                else {
                    name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11){ return p1+p2+p3+p4+p5+p6+p7+p8+cloneIndex+p10+p11});
                }
            }
            else if (isInPanel || isInRepeater) {
                if (panelIndex >= 0) {
                    if (isOwnerClone) {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11){ return p1+p2+panelIndex+p4+p5+p6+p7+p8+cloneIndex+p10+p11});
                    }
                    else {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5){ return p1+p2+cloneIndex+p4+p5});
                    }
                }
                else if (repeaterIndex >= 0) {
                    if (isOwnerClone) {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11){ return p1+p2+repeaterIndex+p4+p5+p6+p7+p8+cloneIndex+p10+p11});
                    }
                    else {
                        name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5){ return p1+p2+cloneIndex+p4+p5});
                    }
                }
                else {
                    name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5,p6,p7,p8){ return p1+p2+p3+p4+p5+cloneIndex+p7+p8});
                }
            }
            else {
                name = name.replace( /^([^\[]+)(\[)([^\]]+)(\])(.*)/g , function(m,p1,p2,p3,p4,p5){ return p1+p2+cloneIndex+p4+p5});
            }
            if (isInWidget) {
                name = widgetPrefix + '[' + name.replace( /^([^\[]+)(\[)(.*)/g , function(m,p1,p2,p3,p4,p5){ return p1 + ']' + p2 + p3});
            }
            return name;
        }
    };

    /**
     * Other Fields
     */
    GSF.fields = {
        createFieldObject: function(fieldType, $container) {
            if ((fieldType == null) || (fieldType == '')) {
                return null;
            }
            //GSF_TextClass
            var classFieldType = 'GSF_' + fieldType.capitalize() + 'Class';
            if (typeof(window[classFieldType ]) === "undefined") {
                return null;
            }
            return new window[classFieldType]($container);
        },

        init: function() {
            this.timeOutFunc(this.addCloneButtonClick);
            this.timeOutFunc(this.removeCloneButtonClick);
            this.timeOutFunc(this.sectionClick);
            this.timeOutFunc(this.sectionTitleClick);
            $(document).trigger('gsf_before_init_fields');
            $('.gsf-meta-box-wrap').each(function() {
                var $container = $(this);
                if (!$container.closest('#widgets-left').length) {
                    GSF.fields.initFields($container);
                }
            });
        },

        timeOutFunc: function (func) {
            setTimeout(func, 1);
        },
        initFields: function($container) {
            GSF.fields.onChangeFieldControl($container);
            $container.each(function () {
                GSF.required.processApplyField(this);
            });
            GSF.required.onChange($container);
            GSF.fields.makeCloneTemplate($container);
            GSF.fields.sortable($container);
            GSF.fields.changePanelTitleEvent($container);
            //GSF.fields.stickySection($container);
            GSF.fields.initFieldsDetails($container);

            $container.find('.gsf-section-container').first().show();
            $container.find('.gsf-sections li').first().addClass('active');
            GSF.fields.initFieldJs($container.find('.gsf-section-container').first());

            $container.find('.gsf-meta-box-wrap-loading').addClass('in');
        },
        initFieldsDetails: function ($container) {
            var isInitNow = ($container.find('.gsf-section-container').length == 0) || ($('.gsf-term-meta-add-new').length != 0);
            $container.find('.gsf-field-content-inner').each(function () {
                var $this = $(this),
                    $field = $this.closest('.gsf-field'),
                    fieldType = $field.data('field-type'),
                    field = GSF.fields.createFieldObject(fieldType, $this);
                if (field != null) {
                    this.fieldJs = field;
                    var _fieldJs = this.fieldJs;
                    if (isInitNow) {
                        setTimeout(function () {
                            _fieldJs.init();
                            _fieldJs.initDone = true;
                        }, 1);

                    }
                }
            });
        },
        initFieldJs: function ($sectionContainer) {
            $sectionContainer.find('.gsf-field-content-inner').each(function () {
                if (this.fieldJs != null) {
                    if (this.fieldJs.initDone == null) {
                        var that = this;
                        setTimeout(function() {
                            that.fieldJs.init();
                            that.fieldJs.initDone = true;
                        }, 1);

                    }
                }
            });
        },

        stickySection: function ($container) {
            var top = 32,
                $optionInner = $('.gsf-theme-options-action-inner');
            if ($optionInner.length) {
                top += $optionInner.outerHeight();
            }
            $container.find('.gsf-sections > ul').hcSticky({top: top});
        },

        changePanelTitleEvent: function ($container) {
            $container.find('.gsf-field-panel-inner').each(function(index) {
                var $inner = $(this),
                    panelTitle = $inner.data('panel-title');
                $inner.data('panel-title-text', $inner.find('.gsf-field-panel-title-text').html());
                if ((panelTitle != null) && (panelTitle !== '')) {
                    $inner.find('#' + panelTitle).find('[data-field-control]').on('change', function () {
                        GSF.fields.changePanelTitle(this);
                    });
                }

                if (index > 0) {
                    $inner.find('.gsf-field-panel-content').hide();
                    $inner.closest('.gsf-field-panel-clone-item').addClass('in');
                }
            });
            GSF.fields.initPanelTitle($container);
        },
        initPanelTitle: function($container) {
            $container.find('.gsf-field-panel-inner').each(function() {
                var $inner = $(this),
                    panelTitle = $inner.data('panel-title');
                if ((panelTitle != null) && (panelTitle !== '')) {
                    $inner.find('#' + panelTitle).find('[data-field-control]').each(function () {
                        GSF.fields.changePanelTitle(this);
                    });
                }
            });
        },
        changePanelTitle: function (control) {
            var $this = $(control),
                $innerParent = $this.closest('.gsf-field-panel-inner');
            if ($this.val() == '') {
                $innerParent.find('.gsf-field-panel-title-text').html($innerParent.data('panel-title-text'));
            }
            else {
                $innerParent.find('.gsf-field-panel-title-text').html($this.val());
            }
        },

        makeCloneTemplate: function ($container) {
            $container.find('.gsf-field-clone-wrapper').each(function() {
                var $this = $(this),
                    $cloneItem = $this.find('> .gsf-field-clone-item').last();
                if ($cloneItem.length > 0) {
                    $this.data('clone-template', $cloneItem[0].outerHTML);
                }
            });
        },
        sectionClick: function() {
            $($document).on('click', '.gsf-sections a', function(event) {
                event.preventDefault();

                var $this = $(this),
                    section = $this.attr('href'),
                    $container = $(event.target).closest('.gsf-meta-box-wrap'),
                    $sectionContainer = $container.find(section);
                $this.closest('ul').find('li').removeClass('active');
                $this.parent().addClass('active');
                $container.find('.gsf-section-container').hide();
                $sectionContainer.show();
                GSF.fields.initFieldJs($sectionContainer);
                $this.trigger('gsf_section_changed');
                $container.find(section).find('.gsf-map-canvas').each(function () {
                    if ((typeof (google) != "undefined") && (typeof (google.maps) != "undefined") && (typeof (google.maps.event) != "undefined") && (typeof (google.maps.event.trigger) != "undefined")) {
                        google.maps.event.trigger(this,'resize');
                    }
                });
            });
        },
        sectionTitleClick: function () {
            $(document).on('click', '.gsf-section-title', function () {
                var $this = $(this);
                $this.toggleClass('in');
                $this.next().slideToggle();
                var $sectionContainer =  $this.closest('.gsf-section-container');
                GSF.fields.initFieldJs($sectionContainer);
            });
        },

        removeCloneButtonClick: function() {
            $document.on('click', '.gsf-clone-button-remove', function() {
                var $this = $(this),
                    $cloneWrapper = $this.closest('.gsf-field-clone-wrapper');
                $this.closest('.gsf-field-clone-item').remove();
                GSF.fields.reIndexCloneField($cloneWrapper);
            });
        },
        addCloneButtonClick: function() {
            $document.on('click', '.gsf-clone-button-add', function() {
                var $this = $(this),
                    $cloneWrapper = $this.parent().find('> .gsf-field-clone-wrapper'),
                    $elementClone = $($cloneWrapper.data('clone-template'));

                GSF.fields.changeNameBeforeClone($elementClone);
                $cloneWrapper.append($elementClone);

                //GSF.fields.clearFieldValue($elementClone);
                GSF.fields.reIndexCloneField($cloneWrapper);

                GSF.fields.restoreNameAfterClone($elementClone);

                GSF.fields.initFields($elementClone);
                GSF.fields.onChangeFieldControl($elementClone);
                GSF.required.onChange($elementClone);

                $elementClone.trigger('gsf_add_clone_field');
                $elementClone.find('.gsf-field').trigger('gsf_check_required');
            });
        },
        changeNameBeforeClone: function ($elementClone) {
            $elementClone.find('[data-field-control]').each(function() {
                var $fieldControl = $(this),
                    name = $fieldControl.attr('name');
                if ((name != null) && (name.indexOf('____') !== 0)) {
                    $fieldControl.attr('name', '____' + name)
                }
            });
        },
        restoreNameAfterClone: function ($elementClone) {
            $elementClone.find('[data-field-control]').each(function() {
                var $fieldControl = $(this),
                    name = $fieldControl.attr('name');
                if ((name != null) && (name.indexOf('____') === 0)) {
                    name = name.substring(4);
                    $fieldControl.attr('name', name);
                }
            });
        },

        onChangeFieldControl: function ($element) {
            $element.find('[data-field-control]').on('change', function() {
                $(this).trigger('gsf_field_control_changed');
            }).on('gsf_field_control_changed', function () {
                var $this = $(this);
                if ($this.data('field-no-change')) {
                    $this.data('field-no-change', false);
                    return;
                }
                if ($this.data('field-set-value')) {
                    return;
                }
                var $field = $this.closest('.gsf-field'),
                    fieldValue = GSF.fields.getValue($field);
                $field.data('field-value', fieldValue);
                $field.trigger('gsf_check_required');
                $field.trigger('gsf_check_preset');
                $field.trigger('gsf_field_change');
            });
        },
        reIndexCloneField: function ($element) {
            $element.find('> .gsf-field-clone-item').each(function(cloneIndex) {
                var $cloneItem = $(this);
                $cloneItem.data('clone-index', cloneIndex);

                $cloneItem.find('[data-field-control]').each(function() {
                    var $this = $(this),
                        name = $this.attr('name');
                    if ((name == null) && (name === '')) {
                        return;
                    }
                    var isOwnerClone = $this.closest('.gsf-field').find('.gsf-field-clone-item').length;

                    var $repeaterClone = $this.closest('.gsf-field-repeater-clone-item'),
                        repeaterIndex = $repeaterClone.data('clone-index');
                    if ((repeaterIndex == null) || (repeaterIndex === '')) {
                        repeaterIndex = -1;
                    }

                    var $panelClone = $this.closest('.gsf-field-panel-clone-item'),
                        panelIndex = $panelClone.data('clone-index');
                    if ((panelIndex == null) || (panelIndex === '')) {
                        panelIndex = -1;
                    }

                    var isInPanel = $this.closest('.gsf-field-panel').length > 0,
                        isInRepeater = $this.closest('.gsf-field-repeater').length > 0;
                    name = GSF.helper.changeCloneNameIndex($this, name, isInPanel, isInRepeater, panelIndex, repeaterIndex, cloneIndex, isOwnerClone);

                    $this.attr('name', name);
                });
            });
        },
        sortable: function($element) {
            $element.find('.gsf-field-clone-wrapper' ).sortable({
                'items': '.gsf-field-clone-item',
                placeholder: "gsf-field-clone-sortable-placeholder",
                handle: '.gsf-sortable-button,.gsf-field-panel-title.gsf-field-panel-title-sortable',
                cancel: '.gsf-clone-button-remove,.gsf-field-panel-title-toggle',
                update: function( event, ui ) {
                    var $wrapper = $(event.target);
                    GSF.fields.reIndexCloneField($wrapper);
                },
                stop: function (event, ui) {
                    var $textarea = ui.item.find('textarea.wp-editor-area');
                    $textarea.each(function(index, element) {
                        var editor, is_active;
                        editor = tinyMCE.EditorManager.get(element.id);
                        is_active = $(this).parents('.tmce-active').length;
                        if (editor && is_active) {
                            $(this).parent().find(' > .mce-container').remove();
                            $('#'+element.id).val(editor.getContent());
                            $('#'+element.id).show();
                            var init = tinyMCEPreInit.mceInit[element.id];
                            tinymce.init(init);
                        }


                    });
                }
            });
        },
        clearFieldValue: function($element) {
            $element.find('[data-field-control]').each(function() {
                var $this = $(this),
                    $field = $this.closest('.gsf-field');
                $field.data('field-value', '');
                if (GSF.helper.isSelect($this)) {
                    $this.prop('selectedIndex', 0);
                }
                else if (GSF.helper.isCheckBox($this) || GSF.helper.isRadio($this)) {
                    $this.prop('checked', false);
                }
                else {
                    $this.val('');
                }
            });
        },
        getValue: function ($field) {
            var fieldValue = '';
            if ($field.find('.gsf-field-clone-item').length > 0) {
                fieldValue = [];
                $field.find('.gsf-field-clone-item').each(function() {
                    var $contentInner = $(this).find('> .gsf-field-content-inner');
                    fieldValue.push($contentInner[0].fieldJs != null ? $contentInner[0].fieldJs.getValue() : '');
                });
            }
            else {
                var $contentInner = $field.find('.gsf-field-content-inner');
                if ($contentInner.length) {
                    if ($contentInner[0].fieldJs != null) {
                        fieldValue = $contentInner[0].fieldJs.getValue();
                    }
                }
            }
            return fieldValue;
        }
    };

    GSF.group = {
        init: function () {
            this.toggleGroup();
        },
        toggleGroup: function () {
            $document.on('click', '.gsf-field-group-title', function(event) {
                var $this = $(event.target),
                    $group = $this.closest('.gsf-field-group');
                $group.toggleClass('in');
                $group.find('> .gsf-field-group-content').slideToggle();
            });
        }
    };
    GSF.panel = {
        init: function () {
            this.togglePanel();
        },
        togglePanel: function () {
            $document.on('click', '.gsf-field-panel-title', function(event) {
                var $this = $(event.target),
                    $panelClone = $this.closest('.gsf-field-panel-clone-item');
                if ($this.closest('.gsf-clone-button-remove').length) {
                    return;
                }
                $this.closest('.gsf-field-panel-clone').find('.gsf-field-panel-clone-item').each(function () {
                    if (($panelClone.length == 0) || (this != $panelClone[0])) {
                        $(this).find('.gsf-field-panel-content').slideUp();
                        $(this).addClass('in');
                    }
                });

                if ($panelClone.length) {
                    $panelClone.toggleClass('in');
                    $panelClone.find('.gsf-field-panel-content').slideToggle();
                }
                else {
                    var $panel = $this.closest('.gsf-field-panel');
                    $panel.toggleClass('in');
                    $panel.find('.gsf-field-panel-content').slideToggle();
                }
            });
        },
        sortable: function() {

        }
    };

    /**
     * Process required field
     */
    GSF.required = {
        processApplyField: function(container) {
            var applyFieldRequired = [];
            $(container).find('.gsf-field[data-required]').each(function() {
                var $this = $(this),
                    required = $this.data('required'),
                    fieldId = $this.attr('id'),
                    i, j, requiredChild, requiredGrandChild,
                    _name, _op, _value;
                if ($.isArray(required[0])) {
                    for (i = 0; i < required.length; i++) {
                        requiredChild = required[i];
                        if ($.isArray(requiredChild[0])) {
                            for (j = 0; j < requiredChild.length; j++) {
                                requiredGrandChild = requiredChild[j];
                                _name = requiredGrandChild[0];
                                _op = requiredGrandChild[1];
                                _value = requiredGrandChild[2];

                                if (_name.indexOf('[') != -1) {
                                    _name = _name.replace(/\[.*/i,'');
                                }

                                if (typeof (applyFieldRequired[_name]) === "undefined") {
                                    applyFieldRequired[_name] = [];
                                }
                                if (applyFieldRequired[_name].indexOf(fieldId) === -1) {
                                    applyFieldRequired[_name].push(fieldId);
                                }

                                if (_op[0] === '&') {
                                    if (typeof (applyFieldRequired[_value]) === "undefined") {
                                        applyFieldRequired[_value] = [];
                                    }
                                    if (applyFieldRequired[_value].indexOf(fieldId) === -1) {
                                        applyFieldRequired[_value].push(fieldId);
                                    }
                                }
                            }
                        }
                        else {
                            _name = requiredChild[0];
                            _op = requiredChild[1];
                            _value = requiredChild[2];

                            if (_name.indexOf('[') != -1) {
                                _name = _name.replace(/\[.*/i,'');
                            }

                            if (typeof (applyFieldRequired[_name]) === "undefined") {
                                applyFieldRequired[_name] = [];
                            }
                            if (applyFieldRequired[_name].indexOf(fieldId) === -1) {
                                applyFieldRequired[_name].push(fieldId);
                            }
                            if (_op[0] === '&') {
                                if (typeof (applyFieldRequired[_value]) === "undefined") {
                                    applyFieldRequired[_value] = [];
                                }
                                if (applyFieldRequired[_value].indexOf(fieldId) === -1) {
                                    applyFieldRequired[_value].push(fieldId);
                                }
                            }
                        }
                    }
                }
                else {
                    _name = required[0];
                    _op = required[1];
                    _value = required[2];

                    if (_name.indexOf('[') != -1) {
                        _name = _name.replace(/\[.*/i,'');
                    }

                    if (typeof (applyFieldRequired[_name]) === "undefined") {
                        applyFieldRequired[_name] = [];
                    }
                    if (applyFieldRequired[_name].indexOf(fieldId) === -1) {
                        applyFieldRequired[_name].push(fieldId);
                    }
                    if (_op[0] === '&') {
                        if (typeof (applyFieldRequired[_value]) === "undefined") {
                            applyFieldRequired[_value] = [];
                        }
                        if (applyFieldRequired[_value].indexOf(fieldId) === -1) {
                            applyFieldRequired[_value].push(fieldId);
                        }
                    }
                }
            });
            container.applyFieldRequired = applyFieldRequired;
        },
        onChange: function($container) {
            $container.find('.gsf-field').on('gsf_check_required', GSF.required.onChangeEvent);
        },
        onChangeEvent: function (event) {
            if (this != event.target) {
                return;
            }
            var $this = $(this),
                $container = $this.closest('.gsf-meta-box-wrap'),
                applyFieldRequired = $container[0].applyFieldRequired,
                fieldId = $this.attr('id'),
                $panelInner = $this.closest('.gsf-field-panel-inner');
            if (applyFieldRequired == null) {
                return;
            }
            if (typeof ($this.data('field-value')) == "undefined") {
                return;
            }
            if (typeof (applyFieldRequired[fieldId]) === "undefined") {
                return;
            }
            for (var i = 0; i < applyFieldRequired[fieldId].length; i++) {
                if ($panelInner.length) {
                    GSF.required.toggleField($panelInner.find('[id="' + applyFieldRequired[fieldId][i] + '"]'), $panelInner, $container);
                }
                else {
                    GSF.required.toggleField($container.find('[id="' + applyFieldRequired[fieldId][i] + '"]'), $panelInner, $container);
                }

            }
        },
        toggleField: function($field, $panelInner, $container) {
            var required = $field.data('required'),
                isVisible = true;
            if (!$.isArray(required[0])) {
                isVisible = GSF.required.processField(required, $panelInner, $container);
            }
            else {
                isVisible = GSF.required.andCondition(required, $panelInner, $container);
            }
            if (isVisible) {
                $field.slideDown();
            }
            else {
                $field.slideUp();
            }
        },
        andCondition: function(required, $panelInner, $container) {
            var requiredChild, i;
            for (i = 0; i < required.length; i++) {
                requiredChild = required[i];
                if (!$.isArray(requiredChild[0])) {
                    if (!GSF.required.processField(requiredChild, $panelInner, $container))
                    {
                        return false;
                    }
                }
                else {
                    if (!GSF.required.orCondition(requiredChild, $panelInner, $container)) {
                        return false;
                    }
                }
            }
            return true;
        },
        orCondition: function(required, $panelInner, $container) {
            var requiredChild, i;
            for (i = 0; i < required.length; i++) {
                requiredChild = required[i];
                if (GSF.required.processField(requiredChild, $panelInner, $container)) {
                    return true;
                }
            }
            return false;
        },
        processField: function(required, $panelInner, $container) {
            var _field = required[0],
                _op = required[1],
                _val = required[2],
                fieldVal,
                _field_key = '';
            if (_field.indexOf('[') != -1) {
                var _field_temp = _field.replace(/\[.*/i,'');
                _field_key = _field.substring(_field_temp.length);
                _field_key = _field_key.substr(1, _field_key.length - 2);
                _field = _field_temp;
            }

            if ($panelInner.length) {
                fieldVal = $panelInner.find('[id="' + _field + '"]').data('field-value');
            }
            else {
                fieldVal = $container.find('[id="' + _field + '"]').data('field-value');
            }


            if ((_field_key !== '') && (typeof (fieldVal[_field_key]) !== "undefined")) {
                fieldVal = fieldVal[_field_key];
            }

            if (_op.substr(0, 1) === '&') {
                if ($panelInner.length) {
                    _val = $panelInner.find('#' + _val).data('field-value');
                }
                else {
                    _val = $('#' + _val).data('field-value');
                }

            }

            // _op: =, !=, in, not in, contain, not contain
            // _op start with "&": reference to field (_val)
            switch (_op) {
                case '=':
                case '&=':
                    return _val == fieldVal;
                case  '!=':
                case  '&!=':
                    return _val != fieldVal;
                case  'in':
                case  '&in':
                    return (_val == fieldVal) || $.isArray(_val) && (_val.indexOf(fieldVal) != -1);
                case  'not in':
                case  '&not in':
                    return (!$.isArray(_val) && (_val != fieldVal)) || (_val.indexOf(fieldVal) == -1);
                case  'contain':
                case  '&contain':
                    return (_val == fieldVal)
                        || ($.isArray(fieldVal) && (fieldVal.indexOf(_val) != -1))
                        || ((typeof(fieldVal) === "object" ) && ((fieldVal != null) && (_val in fieldVal)));
                case  'not contain':
                case  '&not contain':
                    return (!$.isArray(fieldVal) && (fieldVal != _val)) || ((fieldVal== null) || (fieldVal.indexOf(_val) == -1));
            }
            return false;
        }
    };
    GSF.preset = {
        init: function () {
            this.onCheckPreset();
        },
        onCheckPreset: function () {
            $(document).on('gsf_check_preset', '.gsf-field', function(event) {
                if (this != event.target) {
                    return;
                }
                var $this = $(this),
                    $panel = $this.closest('.gsf-field-panel-inner');

                if ($panel.length === 0) {
                    $panel = $('.gsf-meta-box-wrap');
                }

                if (typeof ($this.data('field-value')) == "undefined") {
                    return;
                }
                var dataPreset = $this.data('preset');
                if (typeof (dataPreset) == "undefined") {
                    return;
                }
                var fieldValue = $this.data('field-value'),
                    i, j, _op, _value, _fields;
                for (i = 0; i < dataPreset.length; i++) {
                    _op = dataPreset[i]['op'];
                    _value = dataPreset[i]['value'];
                    _fields = dataPreset[i]['fields'];
                    if (((_op === '=') && (_value == fieldValue))
                        || ((_op === '!=') && (_value != fieldValue))) {
                        for (j = 0; j < _fields.length; j++) {
                            var $field =  $panel.find('#' + _fields[j][0]),
                                $control = $field.find('[data-field-control]');
                            if (($field.length > 0) && ($field[0] != this)) {
                                if (typeof (_fields[j][1]) == 'object') {
                                    for (var obj_field in _fields[j][1]) {
                                        $field.find('[name$="[' + obj_field + ']"]').val(_fields[j][1][obj_field]);
                                    }
                                }
                                else {
                                    if (GSF.helper.isRadio($control) || GSF.helper.isCheckBox($control)) {
                                        $field.find('[data-field-control][value="' + _fields[j][1] + '"]').prop('checked', true);
                                    }
                                    else {
                                        $control.val(_fields[j][1]);
                                    }

                                }
                            }
                            $control.trigger('gsf_preset_change', _fields[j][1]);
                            $control.trigger('change');
                        }
                        break;

                    }
                }
            });
        }
    };

    GSF.onReady = {
        init: function() {
            GSF.fields.init();
            GSF.group.init();
            GSF.panel.init();
            GSF.preset.init();
            $('.gsf-field').trigger('gsf_check_required');
        }
    };
    GSF.onResize = {
        init: function() {
        }
    };
    $document.ready(GSF.onReady.init);
    $(window).resize(GSF.onResize.init);
})(jQuery);