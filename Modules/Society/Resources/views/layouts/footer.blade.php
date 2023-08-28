<!-- Current Module Footer scripts -->
<script>
    var saveDiscussions = '{{ route('admin.save.discussions') }}';
    var fetchDiscussions = '{{ route('admin.fetch.discussions') }}';
    var csrf_token = '{{ csrf_token() }}';
</script>
<script src="{{ asset('modules/societies/js/societies.js') }}"></script>

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

        $("#form_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#form_table_wrapper .col-md-6:eq(0)');

        $("#form_response_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#form_response_table_wrapper .col-md-6:eq(0)');

        $("#members_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#members_table_wrapper .col-md-6:eq(0)');
    });
</script>
