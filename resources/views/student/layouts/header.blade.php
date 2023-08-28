<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NTU Society Managment</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/fontawesome-free/css/all.min.css') }}">

    {{-- Ionicons  --}}
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    {{-- Theme style --}}
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/adminlte.min.css') }}">

    {{-- Tempusdominus Bootstrap 4  --}}
    <link rel="stylesheet"
        href="{{ asset('admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    {{-- Sweet Alert --}}
    <link href="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('admin-lte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

    {{-- DataTables  --}}
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    {{-- Sweet Alert --}}
    <link href="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    {{-- Custom css --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-left: 0px">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.dashboard') }}" role="button">
                        <img src="{{ asset('images/favicon.png') }}" style="width: 30px; height: auto" alt="NTU Society Portal">
                        NTU Society Portal
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo asset('images/avatar.png'); ?>" class="user-image img-rounded-sm" alt="User Image">
                        <span
                            class="d-none d-md-inline">{{ !empty(Auth::user()->username) ? Auth::user()->username : '' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="<?php echo asset('images/avatar.png'); ?>" class="img-circle" alt="User Image">
                            <p>
                                {{ !empty(Auth::user()->username) ? Auth::user()->username : '' }}
                                <small>Member since
                                    {{ !empty(Auth::user()->created_at) ? Auth::user()->created_at->format('M. Y') : '' }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-info btn-flat">Profile</a>
                            <a href="#" class="btn btn-warning btn-flat float-right"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </a>
                            <form id="logout-form" action="<?php echo route('signout'); ?>" method="POST" class="d-none">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
