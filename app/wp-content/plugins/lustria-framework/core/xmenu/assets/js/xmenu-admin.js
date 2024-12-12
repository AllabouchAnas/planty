(function ($) {
    var XMENU = {
        menuFields: [
            'menu-item-url', 'menu-item-title', 'menu-item-attr-title', 'menu-item-target',
            'menu-item-classes', 'menu-item-xfn', 'menu-item-description',
            'menu-item-featured-style', 'menu-item-featured-text', 'menu-item-icon', 'menu-submenu-width',
            'menu-submenu-custom-width', 'menu-submenu-position', 'menu-submenu-transition'
        ],
        menuSelectFieldDefault: {
            'menu-item-featured-style': '',
            'menu-submenu-width': 'auto',
            'menu-submenu-position': 'left',
            'menu-submenu-transition': ''
        },
        isSavingMenu: false,

        init: function() {
            this.initXMenuData();
            this.loadTemplates();
        },
        initXMenuData: function() {
            var i, menuItem, menuId;
            for (menuId in xmenu_meta.data) {
                xmenu_meta.data[menuId]['is_changed'] = false;
                for (i = 0; i < XMENU.menuFields.length; i++) {
                    menuItem = XMENU.menuFields[i];
                    if (typeof (xmenu_meta.data[menuId][menuItem]) == 'undefined') {
                        if (menuItem in XMENU.menuSelectFieldDefault) {
                            xmenu_meta.data[menuId][menuItem] = XMENU.menuSelectFieldDefault[menuItem];
                        }
                        else {
                            xmenu_meta.data[menuId][menuItem] = '';
                        }
                    }
                }
            }
        },
        loadTemplates: function() {
            $.ajax({
                url: xmenu_meta.ajax_url,
                data: {
                    action: 'xmenu_get_xmenu_panel'
                },
                success: function($data) {
                    if ($('#xmenu_panel').length == 0) {
                        $('body').append('<div id="xmenu_panel"></div>');
                    }
                    $('#xmenu_panel').html($data);
                    XMENU.installListener();
                    XMENU.initXMenuButton();
                }
            });
        },
        installListener: function() {
            var that = this,
                $wrapper = $('.xmenu-panel-wrapper'),
                $closePanel = $wrapper.find('.xmenu-button-close'),
                $section = $wrapper.find('.xmenu-sections'),
                $tabs = $wrapper.find('.xmenu-tabs li'),
                $featuredStyle = $wrapper.find('[name="menu-item-featured-style"]'),
                $featuredText = $wrapper.find('[name="menu-item-featured-text"]'),
                $subMenuWidth = $wrapper.find('#xmenu_submenu_width'),
                $subMenuWidthCustom = $wrapper.find('#xmenu_submenu_custom_width'),
                $iconWrapper = $wrapper.find('.xmenu-icon-wrapper'),
                $removeIconField = $wrapper.find('.xmenu-icon-remove'),
                $xmenuButtons = $wrapper.find('.xmenu-buttons'),
                i, menuItem;
            /**
             * Scroll bar for xmenu-sections
             */
            $section.perfectScrollbar({
                wheelSpeed: 0.5,
                suppressScrollX: true
            });

            /**
             * Click section tab
             */
            $tabs.on('click', function() {
                var currentID = $(this).data('section');
                $tabs.removeClass('active');
                $(this).addClass('active');
                $section.find('.xmenu-section-item').removeClass('active');
                $section.find('#' + currentID).addClass('active');
                $section.perfectScrollbar('update');
            });

            $featuredStyle.on('change', function() {
                var value = $(this).val();
                if (value != '') {
                    $featuredText.parent().show();
                }
                else {
                    $featuredText.parent().hide();
                }
            });

            $subMenuWidth.on('change', function () {
                var value = $(this).val();
                if (value === 'custom') {
                    $subMenuWidthCustom.parent().show();
                }
                else {
                    $subMenuWidthCustom.parent().hide();
                }
            });

            /**
             * Show icon popup
             */
            $iconWrapper.on('click', function(event) {
                if ($(event.target).closest('.xmenu-icon-remove').length > 0) {
                    return;
                }
                var $iconField = $iconWrapper.find('[name="menu-item-icon"]');

                GSF_ICON_POPUP.open($iconField.val(), function(icon) {
                    that.setIcon(icon);
                    $iconField.trigger('change');
                });
            });

            /**
             * Remove Icon
             */
            $removeIconField.on('click', function() {
                XMENU.setIcon('');
            });

            /**
             * Close panel
             */
            $closePanel.on('click', function() {
                $wrapper.removeClass('in');
            });

            /**
             * Process close panel when ESC key press
             */
            this.windowKeyUp();
            this.saveMenu();
            this.saveAllMenu();
            this.eventChangedForXmenuField();
        },

        saveMenu: function() {
            var $wrapper = $('.xmenu-panel-wrapper'),
                $xmenuButtons = $wrapper.find('.xmenu-buttons');

            $xmenuButtons.find('.xmenu-button-save').on('click', function() {
                var currentMenuId = $('.xmenu-panel-wrapper').data('menu-id');
                if (typeof (currentMenuId) === "undefined" || currentMenuId === null) {
                    return;
                }
                XMENU.saveMenuItems([currentMenuId]);
            });
        },

        /**
         * Show save all changed
         */
        saveAllMenu: function() {
            var $wrapper = $('.xmenu-panel-wrapper'),
                $xmenuButtons = $wrapper.find('.xmenu-buttons');

            $xmenuButtons.find(' > span').on('click', function() {
                $xmenuButtons.find('.xmenu-save-all').fadeToggle();
            });

            /**
             * Close Icon Popup when body clicked
             */
            $('body').on('click', function (event) {
                if (($(event.target).closest('.xmenu-buttons > span').length)) {
                    return;
                }
                $('.xmenu-save-all').fadeOut();
            });

            $xmenuButtons.find('.xmenu-save-all').on('click', function() {
                var menuIdsChanged = [],
                    menuIdName,
                    menuIndex = 0;

                for (menuIdName in xmenu_meta.data) {
                    if (xmenu_meta.data[menuIdName].is_changed) {
                        menuIdsChanged[menuIndex++] = parseInt(menuIdName.replace('menu_', ''), 10);
                    }
                }

                XMENU.saveMenuItems(menuIdsChanged);
            });

        },

        eventChangedForXmenuField: function() {
            var $wrapper = $('.xmenu-panel-wrapper'),
                i, menuItem;

            /**
             * Setup event changed for xmenu field
             */
            for (i = 0; i < XMENU.menuFields.length; i++) {
                menuItem = XMENU.menuFields[i];
                $wrapper.find('[name="' + menuItem + '"]').on('change', function() {
                    var $this = $(this),
                        menuIdCurrent = $wrapper.data('menu-id'),
                        menuName = $this.attr('name');

                    xmenu_meta.data['menu_' + menuIdCurrent]['is_changed'] = true;
                    $('#menu-item-' + menuIdCurrent).find('.xmenu-item-config').addClass('is-changed');
                    if (menuName === 'menu-item-target') {
                        if ($this.prop('checked')) {
                            xmenu_meta.data['menu_' + menuIdCurrent][menuName] = $this.val();
                        }
                        else {
                            xmenu_meta.data['menu_' + menuIdCurrent][menuName] = '';
                        }
                    }
                    else {
                        xmenu_meta.data['menu_' + menuIdCurrent][menuName] = $this.val();
                    }

                    /**
                     * Change WordPress menu field
                     */
                    var $wpItem = $('#menu-item-' + menuIdCurrent).find('[name="' + menuName + '[' + menuIdCurrent + ']"]');
                    if (menuName === 'menu-item-target') {
                        $wpItem.prop('checked', $this.prop('checked'));
                    }
                    else {
                        $wpItem.val($this.val());
                    }
                    $wpItem.trigger('change');
                });
            }
        },
        initXMenuButton: function() {
            $('ul.menu > li.menu-item').each(function(){
                var menuId = parseInt($(this).attr('id').replace('menu-item-',''), 10);
                $('> .menu-item-bar > .menu-item-handle > .item-title', this).append('<span class="xmenu-item-config" data-id="' + menuId + '"><i class="fa fa-cogs"></i> XMENU <i class="fa fa-warning"></i></span>');
            });
            $('ul.menu > li.menu-item .xmenu-item-config').on('click',function(){
                var menuId = parseInt($(this).attr('data-id'), 10);
                XMENU.openXMenuPanel(menuId);
            });
        },
        openXMenuPanel: function(menuId) {
            var $panel = $('.xmenu-panel-wrapper');
            if ($panel.hasClass('.xmenu-is-saving')) {
                return;
            }

            $panel.data('menu-id', menuId);
            $panel.addClass('in');
            var $wrapper = $('.xmenu-panel-wrapper'),
                $iconWrapper = $wrapper.find('.xmenu-icon-wrapper'),
                $iconInfoField = $iconWrapper.find('.xmenu-icon > div > i'),
                $urlField = $wrapper.find('#xmenu_item_url'),
                $featuredStyle = $wrapper.find('[name="menu-item-featured-style"]'),
                $featuredText = $wrapper.find('[name="menu-item-featured-text"]'),
                $xmenuTitle = $wrapper.find('.xmenu-title'),
                $subMenuWidth = $wrapper.find('#xmenu_submenu_width'),
                $item,
                menuItem,
                i;

            $xmenuTitle.text(xmenu_meta.data['menu_' + menuId]['menu-item-title']);
            if (xmenu_meta.data['menu_' + menuId]['type'] === 'custom') {
                $urlField.removeAttr('readonly');
            }
            else {
                $urlField.attr('readonly', 'readonly');
            }
            for (i = 0; i < XMENU.menuFields.length; i++) {
                menuItem = XMENU.menuFields[i];
                $item = $wrapper.find('[name="' + menuItem + '"]');
                if (menuItem === 'menu-item-target') {
                    $item.prop('checked', xmenu_meta.data['menu_' + menuId][menuItem] === '_blank');
                }
                else {
                    $item.val(xmenu_meta.data['menu_' + menuId][menuItem]);
                }
                if (menuItem === 'menu-item-icon') {
                    $iconInfoField.attr('class', xmenu_meta.data['menu_' + menuId][menuItem]);
                    if (xmenu_meta.data['menu_' + menuId][menuItem] !== '') {
                        $iconWrapper.addClass('has-icon');
                    }
                    else {
                        $iconWrapper.removeClass('has-icon');
                    }
                }
            }

            if ($featuredStyle.val() !== '') {
                $featuredText.parent().show();
            }
            else {
                $featuredText.parent().hide();
            }
            $subMenuWidth.trigger('change');
        },
        setIcon: function(iconValue) {
            var $iconWrapper = $('.xmenu-icon-wrapper'),
                $iconField = $iconWrapper.find('[name="menu-item-icon"]'),
                $iconInfoField = $iconWrapper.find('.xmenu-icon > div > i');
            $iconField.val(iconValue);
            $iconInfoField.attr('class', iconValue);
            if (iconValue == '') {
                $iconWrapper.removeClass('has-icon');
            }
            else {
                $iconWrapper.addClass('has-icon');
            }
            $iconField.trigger('change');
        },
        windowKeyUp: function() {
            $(window).on('keyup',function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 27) {
                    var $panel = $('.xmenu-panel-wrapper');
                    if ($panel.hasClass('in')) {
                        $panel.removeClass('in');
                    }
                    else {
                        var menuId = $panel.data('menu-id');
                        if (typeof (menuId) != "undefined") {
                            $panel.addClass('in');
                        }
                    }
                    $('.xmenu-icon-popup').fadeOut();
                    $('.xmenu-save-all').fadeOut();
                }
            });
        },

        /**
         * Save Menu Items
         * @param menuIds Array menu ID save
         */
        saveMenuItems: function(menuIds) {
            if (XMENU.isSavingMenu) {
                return;
            }
            XMENU.isSavingMenu = true;

            var $saveButton = $('.xmenu-button-save'),
                data = [],
                countMenuIds = menuIds.length,
                i;

            $saveButton.find('span').text($saveButton.data('saving'));
            $saveButton.find('i').addClass('fa-spin fa-spinner');

            for (i = 0; i < countMenuIds; i++) {
                data[i] = {
                    menu_id: menuIds[i],
                    data: xmenu_meta.data['menu_' + menuIds[i]]
                };
            }
            $.ajax({
                url: xmenu_meta.ajax_url,
                type   : 'POST',
                data: {
                    action: 'xmenu_save_menu',
                    data: data,
                    nonce: $('#xmenu_nonce').val()
                },
                success: function() {
                    XMENU.isSavingMenu = false;
                    $saveButton.find('span').text($saveButton.data('save'));
                    $saveButton.find('i').removeClass('fa-spin fa-spinner');
                    for (i = 0; i < countMenuIds; i++) {
                        xmenu_meta.data['menu_' + menuIds[i]].is_changed = false;
                        $('#menu-item-' + menuIds[i]).find('.xmenu-item-config').removeClass('is-changed');
                    }
                },
                error: function() {
                    XMENU.isSavingMenu = false;
                    $saveButton.find('span').text($saveButton.data('save'));
                    $saveButton.find('i').removeClass('fa-spin fa-spinner');
                }
            });
        }
    };
    $(document).ready(function() {
        XMENU.init();
    });
})(jQuery);