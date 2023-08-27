{{ view('admin.layouts.header') }}

{{ view('admin.sidebar') }}

@php

$user = $page_data;

@endphp

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Edit Student</h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('students.list') }}">Students list</a>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        </li>
                        <li class="breadcrumb-item">Edit Student</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Student</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update.student', $user->id) }}" method="post" id="user_edit_form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullname" class="fw-bold">Full Name</label>
                                            <input type="text" class="form-control" placeholder="Full Name"
                                                name="fullname" id="fullname" value="{{ $user->full_name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="registrationNumber" class="fw-bold">Registration
                                                Number</label>
                                            <input type="text" class="form-control"
                                                placeholder="Registration Number" name="registration_number"
                                                id="registrationNumber" value="{{ $user->reg_number }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="fw-bold">Email</label>
                                            <input type="email" class="form-control" placeholder="Email"
                                                name="email" id="email" value="{{ $user->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="fw-bold">Phone</label>
                                            <input type="number" class="form-control" placeholder="Phone"
                                                name="phone" id="phone" minlength="11" value="{{ $user->phone_number }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="fw-bold">Username</label>
                                            <input type="text" class="form-control" placeholder="Username"
                                                name="username" id="username" value="{{ $user->username }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="fw-bold">Password</label>
                                            <input type="password" class="form-control" placeholder="Password"
                                                name="password" id="password" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex flex-column justify-content-center">
                                        @php
                                            if (!empty($user->image_path)) {
                                                $image_path = asset('uploads/students/uploads/' . $user->image_path);
                                            } else {
                                                $image_path = asset('images/user-thumb.jpg');
                                            }
                                        @endphp
                                        <div class="card card-widget widget-user-2 shadow-md mb-0">
                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                            <div class="row widget-user-header">
                                                <div class="col-lg-6 text-center">
                                                    <div class="profile_picture">
                                                        <input type="file" name="image_path"
                                                            accept="image/png, image/jpeg, image/jpg"
                                                            onchange="display_image(this);"
                                                            class="d-none upload-box-image">
                                                        <img class="box-image-preview img-fluid img-circle elevation-2"
                                                            src="{{ $image_path }}" alt="Profile picture"
                                                            onclick="$(this).closest('.profile_picture').find('input').click();"
                                                            style="height:150px; width:150px;">
                                                    </div>
                                                </div>
                                                <!-- /.widget-user-image -->
                                                <div class="col-lg-6 d-flex flex-column justify-content-center">
                                                    <h3 class="font-weight-bold">
                                                        {{ $user->full_name }}
                                                    </h3>
                                                    <h5 class="">
                                                        {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                                    </h5>
                                                    <div class="user_activation">
                                                        <label for="user_active" class="mr-2">Active</label>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" name="is_active" id="user_active"
                                                                value="1"
                                                                {{ $user->is_active == 1 ? 'checked' : '' }}>
                                                            <label for="user_active"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item py-2">
                                                        <span class="nav-link text-dark font-weight-bold">
                                                            Select Student Role:
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="nav-link">
                                                            <label for="president" class="font-weight-normal">
                                                                President
                                                            </label>
                                                            <span class="float-right badge">
                                                                <div class="icheck-success d-inline">
                                                                    <input type="radio" name="user_role"
                                                                        id="president" value="president" {{ $user->role == 'president' ? 'checked' : '' }} />
                                                                    <label for="president"></label>
                                                                </div>
                                                            </span>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="nav-link">
                                                            <label for="member" class="font-weight-normal">
                                                                Member
                                                            </label>
                                                            <span class="float-right badge">
                                                                <div class="icheck-success d-inline">
                                                                    <input type="radio" name="user_role"
                                                                        id="member" value="member" {{ $user->role == 'member' ? 'checked' : '' }} />
                                                                    <label for="member"></label>
                                                                </div>
                                                            </span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="button" id="save_edit_user"
                                                class="btn btn-block btn-success btn-flat">
                                                Save <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

{{ view('admin.control-sidebar') }}

{{ view('admin.layouts.footer') }}
{{ view('users::layouts.footer') }}
