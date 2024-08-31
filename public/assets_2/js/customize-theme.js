'use strict';

(function ($) {

    $(window).on('load', function () {
        setTimeout(function () {
            $('.layout-builder-wrapper').removeClass('show');
        }, 1000);
    });

    $('body').append(`
    <div class="layout-builder-wrapper show">
        <div class="layout-builder-buttons">
            <a href="#" title="Purchase Theme">
                <i class="ti-shopping-cart"></i>
            </a>
            <a href="#" class="layout-builder-toggle" title="Customize Theme">
                <i class="ti-settings"></i>
            </a>
            <a href="http://bifor.laborasyon.com/" title="Other Demos">
                <i class="ti-layers-alt"></i>
            </a>
        </div>
        <div class="card layout-builder">
            <div class="card-body layout-builder-body">
                <h5 class="card-title mb-3">Customize Theme</h5>
                <p class="text-muted">You can change the header, navigation, and general page layout.</p>
                <p>
                    <strong>Theme Colors</strong>
                </p>
                <div class="theme-color-palette mb-3">
                    <a href="#" data-color-name="default" class="active" style="background: #ff7043"></a>
                    <a href="#" data-color-name="green" style="background: #66bb6a"></a>
                    <a href="#" data-color-name="blue" style="background: #42a5f5"></a>
                    <a href="#" data-color-name="purple" style="background: #ab47bc"></a>
                </div>
                <p class="mb-1">
                    <strong>Layouts</strong>
                </p>
                <p class="text-muted">Change overall design</p>
                <div class="switches">
                    <div class="mb-3">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" data-url="http://bifor.laborasyon.com/default" id="vertical-navigation">
                            <label class="custom-control-label" for="vertical-navigation">Vertical</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" data-url="http://bifor.laborasyon.com/horizontal" id="horizontal-navigation">
                            <label class="custom-control-label" for="horizontal-navigation">Horizontal</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" data-url="http://bifor.laborasyon.com/dark" id="dark">
                            <label class="custom-control-label" for="dark">Dark</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="boxed-layout">
                            <label class="custom-control-label" for="boxed-layout">Boxed Layout</label>
                        </div>
                    </div>
                    <p class="mb-1">
                        <strong>Header</strong>
                    </p>
                    <p class="text-muted">Change header view</p>
                    <div class="mb-3">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="light-header">
                            <label class="custom-control-label" for="light-header">Light</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="dark-header">
                            <label class="custom-control-label" for="dark-header">Dark</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="colorful-header">
                            <label class="custom-control-label" for="colorful-header">Colorful</label>
                        </div>
                    </div>
                    <p class="mb-1">
                        <strong>Navigation</strong>
                    </p>
                    <p class="text-muted">Change navigation view</p>            
                    <div class="mb-3">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="compact-navigation">
                            <label class="custom-control-label" for="compact-navigation">Compact</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="small-navigation">
                            <label class="custom-control-label" for="small-navigation">Small</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="right-navigation">
                            <label class="custom-control-label" for="right-navigation">Right</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="dark-navigation">
                            <label class="custom-control-label" for="dark-navigation">Dark</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="colorful-navigation">
                            <label class="custom-control-label" for="colorful-navigation">Colored</label>
                        </div>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="hidden-navigation">
                            <label class="custom-control-label" for="hidden-navigation">Hidden</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>`);

    var a = {
        'horizontal-navigation': [
            'compact-navigation',
            'small-navigation',
            'right-navigation',
            'hidden-navigation',
        ],
        'compact-navigation': [
            'small-navigation',
            'horizontal-navigation',
        ],
        'small-navigation': [
            'compact-navigation',
            'horizontal-navigation',
            'hidden-navigation',
        ],
        'right-navigation': [
            'horizontal-navigation',
        ],
        'hidden-navigation': [
            'small-navigation',
            'horizontal-navigation',
        ],
        'light-header': [
            'dark-header',
            'colorful-header',
        ],
        'dark-header': [
            'light-header',
            'colorful-header',
        ],
        'colorful-header': [
            'light-header',
            'dark-header',
        ],
        'dark-navigation': [
            'colorful-navigation'
        ],
        'colorful-navigation': [
            'dark-navigation'
        ]
    };

    var firstLoadBodyClassList = document.querySelector('body').classList;
    $.each(firstLoadBodyClassList, function (i, className) {
        $('.layout-builder .switches input[type="checkbox"][id="' + className + '"]').prop('checked', true);
    });

    $(document).on('click', 'a.layout-builder-toggle', function () {
        $('.layout-builder-wrapper').toggleClass('show');
        return false;
    });

    $(document).on('click', '.layout-builder .switches input[type="checkbox"]', function () {
        var id = $(this).attr('id');

        if (id == 'vertical-navigation') {
            window.location.href = $(this).data('url');
        } else if (id == 'horizontal-navigation') {
            window.location.href = $(this).data('url');
        } else if (id == 'dark') {
            window.location.href = $(this).data('url');
        }

        $.each(a[id], function (i, className) {
            $('body').removeClass(className);
            $('.layout-builder .switches input[type="checkbox"][id="' + className + '"]').prop('checked', false);
        });
        if ($(this).prop('checked')) {
            $('body').addClass(id);
        } else {
            $('body').removeClass(id);
        }

        if ($(this).prop('checked') && id == 'horizontal-navigation') {
            $('.navigation .navigation-menu-body').getNiceScroll().remove();
            $('.navigation .navigation-menu-body').removeAttr('style');
        } else if (!$(this).prop('checked') && id == 'horizontal-navigation') {
            $('.navigation .navigation-menu-body').niceScroll();
            $('.navigation .navigation-menu-body').getNiceScroll().resize();
        } else {
            $('.navigation .navigation-menu-body').niceScroll();
            $('.navigation .navigation-menu-body').getNiceScroll().resize();
        }
        $('.app-block .app-content .app-lists').niceScroll();
        $('.app-block .app-content .app-lists').getNiceScroll().resize();
        $('.app-block .app-sidebar .app-sidebar-menu').niceScroll();
        $('.app-block .app-sidebar .app-sidebar-menu').getNiceScroll().resize();
        $('.chat-block .chat-sidebar .chat-sidebar-content').niceScroll();
        $('.chat-block .chat-sidebar .chat-sidebar-content').getNiceScroll().resize();
        $('.chat-block .chat-content .messages').niceScroll();
        $('.chat-block .chat-content .messages').getNiceScroll().resize();
        $('.card-scroll').niceScroll();
        $('.card-scroll').getNiceScroll().resize();
        $('.dropdown-scroll').niceScroll();
        $('.dropdown-scroll').getNiceScroll().resize();
        $('.table-responsive').niceScroll();
        $('.table-responsive').getNiceScroll().resize();

        $('.layout-builder-wrapper').removeClass('show');
    });
    $(document).on('click', '.layout-builder .theme-color-palette a', function () {
        var colorName = $(this).attr('data-color-name');
        $('.layout-builder .theme-color-palette a').removeClass('active');
        $(this).addClass('active');
        if (colorName == 'default') {
            $('[data-theme-customize]').attr('href', $('[data-theme-customize]').data('theme-customize') + '/app.min.css');
        } else {
            $('[data-theme-customize]').attr('href', $('[data-theme-customize]').data('theme-customize') + '/app-' + colorName + '.min.css');
        }
        $('.layout-builder-wrapper').removeClass('show');
        return false;
    });

    $('.layout-builder-wrapper .layout-builder').niceScroll();

})(jQuery);
