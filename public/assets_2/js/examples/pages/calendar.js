$(function () {
    $(document).on('click', '.app-block .app-content .app-action .action-left input[type="checkbox"]', function () {
        $('.app-lists ul li input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        if ($(this).prop('checked')) {
            $('.app-lists ul li input[type="checkbox"]').closest('li').addClass('active');
        } else {
            $('.app-lists ul li input[type="checkbox"]').closest('li').removeClass('active');
        }
    });

    $(document).on('click', '.app-lists ul li input[type="checkbox"]', function () {
        if ($(this).prop('checked')) {
            $(this).closest('li').addClass('active');
        } else {
            $(this).closest('li').removeClass('active');
        }
    });

    $(document).on('click', '.app-block .app-content .app-content-body .app-lists ul.list-group li.list-group-item', function (e) {
        if (!$(e.target).is('.custom-control, .custom-control *, a, a *')) {
            $('.app-detail').addClass('show').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                $('.app-block .app-content .app-content-body .app-detail .app-detail-article').niceScroll().resize();
            });
        }
    });

    $(document).on('click', 'a.app-detail-close-button', function () {
        $('.app-detail').removeClass('show');
        return false;
    });

    $(document).on('click', '.app-sidebar-menu-button', function () {
        $('.app-block .app-sidebar, .app-content-overlay').addClass('show');
        $.createOverlay();
        return false;
    });

    $(document).on('click', '.overlay', function () {
        $('.app-block .app-sidebar, .app-content-overlay').removeClass('show');
    });
});
