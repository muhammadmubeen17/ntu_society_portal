@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Create Student</h1>
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
                        <li class="breadcrumb-item">Create User</li>
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
                            <h3 class="card-title">Create Student</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store.student') }}" method="post" id="user_creation_form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullname" class="fw-bold">Full Name</label>
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="fullname" id="fullname" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="registrationNumber" class="fw-bold">Registration
                                                Number</label>
                                            <input type="text" class="form-control"
                                                placeholder="Registration Number" name="registration_number"
                                                id="registrationNumber">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="fw-bold">Email</label>
                                            <input type="email" class="form-control" placeholder="Email"
                                                name="email" id="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="fw-bold">Phone</label>
                                            <input type="number" class="form-control" placeholder="Phone"
                                                name="phone" id="phone" minlength="11" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username" class="fw-bold">Username</label>
                                            <input type="text" class="form-control" placeholder="Username"
                                                name="username" id="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="fw-bold">Password</label>
                                            <input type="password" class="form-control" placeholder="Password"
                                                name="password" id="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex flex-column">
                                        <div class="card card-widget widget-user-2 shadow-md mb-0">
                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                            <div class="d-flex flex-column justify-content-center align-items-center widget-user-header">
                                                <div class="profile_picture">
                                                    <input type="file" name="image_path"
                                                        accept="image/png, image/jpeg, image/jpg"
                                                        onchange="display_image(this);" class="d-none upload-box-image">
                                                    <img class="box-image-preview img-fluid img-circle elevation-2"
                                                        src="{{ asset('images/user-thumb.jpg') }}" alt="Profile picture"
                                                        onclick="$(this).closest('.profile_picture').find('input').click();"
                                                        style="height:150px; width:150px;">
                                                </div>
                                                <!-- /.widget-user-image -->
                                                <div class="user_activation mt-3">
                                                    <label for="user_active" class="mr-2">Active</label>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" name="is_active" id="user_active"
                                                            value="1">
                                                        <label for="user_active"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="card-body p-0">
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
                                                                        id="president" value="president" />
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
                                                                        id="member" value="member" />
                                                                    <label for="member"></label>
                                                                </div>
                                                            </span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="button" id="create_new_user"
                                                class="btn btn-block btn-primary btn-flat">
                                                Create <i class="fas fa-external-link-square-alt"></i>
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

@include('footer', ['module' => 'users'])
