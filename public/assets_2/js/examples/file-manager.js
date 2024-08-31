$(function () {
    $(document).on('click', '.file-upload-btn', function () {
        $('form#file-upload input[type="file"]').trigger('click');
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
