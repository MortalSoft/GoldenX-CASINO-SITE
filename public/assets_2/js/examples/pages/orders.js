$(function () {
    var table = $('#orders').DataTable({
        'columnDefs': [
            {
                'targets': 0,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<div class="custom-control custom-checkbox">' +
                        '<input type="checkbox" class="custom-control-input" id="customCheck' + meta.row + '">' +
                        '<label class="custom-control-label" for="customCheck' + meta.row + '"></label>' +
                        '</div>';
                }
            },
            {
                "orderable": false,
                "targets": [0, 7]
            }
        ],
        'order': [1, 'asc']
    });

    $('#orders-select-all').on('click', function () {
        // Check/uncheck all checkboxes in the table
        var rows = table.rows({'search': 'applied'}).nodes();
        $('input[type="checkbox"]', rows)
            .prop('checked', this.checked);
        if (this.checked) {
            $('input[type="checkbox"]', rows).closest('tr').addClass('tr-selected');
        } else {
            $('input[type="checkbox"]', rows).closest('tr').removeClass('tr-selected');
        }
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#orders tbody').on('change', 'input[type="checkbox"]', function () {
        // If checkbox is not checked
        if (!this.checked) {
            var el = $('#orders-select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if (el && el.checked && ('indeterminate' in el)) {
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    $('.custom-control-input').click(function () {
        if ($(this).prop('checked')) {
            $(this).closest('td').closest('tr').addClass('tr-selected');
        } else {
            $(this).closest('td').closest('tr').removeClass('tr-selected');
        }
    });
});
