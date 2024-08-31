$(function () {
    $('.basic-repeater').repeater({
        show: function () {
            $(this).slideDown();
        }
    });

    $('.alert-repeater').repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this element?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $(this).slideUp(deleteElement);
                    }
                })
        }
    });
});
