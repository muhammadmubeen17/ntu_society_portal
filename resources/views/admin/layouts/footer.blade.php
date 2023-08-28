<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 </strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

{{-- jQuery  --}}
{{-- <script src="{{ asset('admin-lte/plugins/jquery/jquery.min.js') }}"></script> --}}
{{-- Bootstrap 4  --}}
{{-- <script src="{{ asset('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
{{-- AdminLTE App --}}
{{-- <script src="{{ asset('admin-lte/dist/js/adminlte.min.js') }}"></script> --}}
{{-- Sweet Alert  --}}
{{-- <script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script> --}}
<!-- AdminLTE App -->
{{-- <script src="{{ asset('admin-lte/dist/js/adminlte.js') }}"></script> --}}


<!-- jQuery -->
<script src="{{ asset('admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admin-lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('admin-lte/plugins/chart.js/Chart.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('admin-lte/plugins/sparklines/sparkline.js') }}"></script>

<!-- JQVMap -->
<script src="{{ asset('admin-lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

<!-- jQuery Knob Chart -->
<script src="{{ asset('admin-lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

{{-- jquery-validation  --}}
<script src="{{ asset('admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

{{-- Sweet Alert  --}}
<script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

{{-- Bootstrap Switch --}}
<script src="{{ asset('admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

<!-- Summernote -->
<script src="{{ asset('admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin-lte/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('admin-lte/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admin-lte/dist/js/pages/dashboard3.js') }}"></script>
<?php

/**
 *  Alert
 */
$message = '';
$icon = '';

if (!empty($errors->all())) {
    $icon = 'error';
    $message = $errors->first();
} elseif (session()->has('success')) {
    $icon = 'success';
    $message = session()->get('success');
} elseif (session()->has('error')) {
    $icon = 'error';
    $message = session()->get('error');
} elseif (!empty($success)) {
    $icon = 'success';
    $message = $success;
}

?>

<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 5000
    });
    var message = '{{ $message }}';
    var icon = '{{ $icon }}';
    if (message.length > 0) {
        Toast.fire({
            icon: icon,
            title: message
        });
    }
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        // Switch
        // $("input[data-bootstrap-switch]").each(function() {
        //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
        // })

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })
    })
</script>
<script>
    // Delete Confirmation
    function confirm_form_delete(element) {
        var form = $(element).closest("form");

        Swal.fire({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            customClass: {
                cancelButton: 'btn btn-danger'
            },
            showCancelButton: true,
            cancelButtonText: 'No',
            cancelButtonColor: '#ce4242',
            confirmButtonColor: '#004A99',
            confirmButtonText: `Yes`,
            closeOnConfirm: false
        }).then((result) => {

            if (!result.isConfirmed) return;

            jQuery(form).submit();

        });
    }
</script>

@if (isset($dates) || isset($userCounts))
    <script>
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true
        var dates = {!! json_encode($dates) !!};
        var userCounts = {!! json_encode($userCounts) !!};
        console.log(dates)
        console.log(userCounts)
        var $visitorsChart = $('#visitors-chart')
        // eslint-disable-next-line no-unused-vars
        var visitorsChart = new Chart($visitorsChart, {
            data: {
                labels: dates,
                datasets: [{
                    type: 'line',
                    data: userCounts,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    pointBorderColor: '#007bff',
                    pointBackgroundColor: '#007bff',
                    fill: false
                    // pointHoverBackgroundColor: '#007bff',
                    // pointHoverBorderColor    : '#007bff'
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display: true,
                            lineWidth: '4px',
                            color: 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks: $.extend({
                            beginAtZero: true,
                            suggestedMax: 200
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                    }]
                }
            }
        })
    </script>
@endif;
</body>

</html>
