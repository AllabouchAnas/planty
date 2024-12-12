(function ($) {
    "use strict";

    var gsfPrettyTabs = function (element,options) {
        var defaults = {
            elementSelector : 'li:not(.dropdown)',
            menuContainerClass : 'dropdown',
            more_text : '<span class="fa fa-plus"></span>'
        };
        this.$element = $(element);
        this.element = element;
        this.options = $.extend({}, defaults, typeof options === 'object' && options);
        this.options = $.extend({}, this.options, this.$element.data("pretty-tabs-options"));
        this.init();
    };

    gsfPrettyTabs.prototype = {
        init : function () {
            var _that = this;
            _that.processTabs();
            $(window).on('resize',function () {
                _that.processTabs();
            });
        },
        processTabs : function () {
            var _that = this;
                _that.revertElements();
                var totalWidth = _that.getTotalWidth(),
                    elementWidth = _that.getElementsWidth();
            _that.$element.removeClass('gsf-pretty-tabs-initialized');

            if (elementWidth > totalWidth) {
                _that.createMenuContainer();
                var _width = 0,
                $menuContainer = _that.getMenuContainer();
                if ($menuContainer.length > 0) {
                    _width += _that.getElementWidth($menuContainer);
                }
                _that.getElements().each(function () {
                    _width += _that.getElementWidth($(this));
                    if (_width > totalWidth) {
                        $(this).appendTo($menuContainer.find('ul.dropdown-menu'));
                    }
                });
            }
            _that.$element.addClass('gsf-pretty-tabs-initialized');
        },
        createMenuContainer : function () {
            var _that = this,
                $menuContainer = _that.getMenuContainer();
            if ($menuContainer.length === 0) {
                var $container = $('<li class="dropdown">' +
                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'+ _that.options.more_text +'</a>' +
                    '<ul class="dropdown-menu dropdown-menu-right">' +
                    '</ul>' +
                    '</li>');
                _that.$element.append($container);
            }
        },
        revertElements: function () {
            var _that = this,
                $menuContainer = _that.getMenuContainer();
            if ($menuContainer.length > 0) {
                $menuContainer.find('li').each(function () {
                    $(this).appendTo(_that.$element);
                });
                $menuContainer.remove();
            }
        },
        getMenuContainer : function () {
          return this.$element.find('.' + this.options.menuContainerClass);
        },
        getTotalWidth : function () {
            return this.$element.width();
        },
        getElementsWidth : function () {
            var _that = this,
                $menuContainer = _that.getMenuContainer(),
                elementsWidth = 0;
            if ($menuContainer.length > 0) {
                elementsWidth +=  _that.getElementWidth($menuContainer);
            }
            _that.getElements().each(function () {
                elementsWidth += _that.getElementWidth($(this));
            });
            return elementsWidth;
        },
        getElements : function () {
            return this.$element.find(this.options.elementSelector);
        },
        getElementWidth: function ($element) {
            return $element.outerWidth() + parseInt($element.css('margin-left').replace('px', ''), 10) + parseInt($element.css('margin-right').replace('px', ''), 10);
        }
    };

    $.fn.extend({
        gsfPrettyTabs : function(options) {
            return this.each(function () {
                new gsfPrettyTabs(this,options);
            });
        }
    });
    $(document).ready(function () {
        $('.gsf-pretty-tabs').gsfPrettyTabs({
            more_text : g5plus_variable.pretty_tabs_more_text
        });
    });
})(jQuery);