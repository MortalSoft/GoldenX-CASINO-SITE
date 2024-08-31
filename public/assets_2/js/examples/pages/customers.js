$(function () {
    $(document).ready(function () {
        $('#myTable').DataTable({
            'columnDefs': [
                {
                    "orderable": false,
                    "targets": 5
                }
            ]
        });
    });
});
