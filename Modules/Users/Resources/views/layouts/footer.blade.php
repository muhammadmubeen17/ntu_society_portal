<!-- Current Module Footer scripts -->
<script src="{{ asset('modules/users/js/users.js') }}"></script>

<script>
    $(function() {
        // $("#user_table").DataTable({
        //     lengthMenu: [
        //         [10, 25, 50, -1],
        //         [10, 25, 50, 'All'],
        //     ],
        // });
        $("#user_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#user_table_wrapper .col-md-6:eq(0)');
    });
</script>
