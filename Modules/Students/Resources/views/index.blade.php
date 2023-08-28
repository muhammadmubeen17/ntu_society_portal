@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">Manage Students</h1>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('create.student') }}" class="add-btn">
                        <i class="fa fa-user-plus"></i>
                        <br> Add New
                    </a>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        </li>
                        <li class="breadcrumb-item">Students</li>
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
                            <h3 class="card-title">Students List</h3>
                        </div>
                        <div class="card-body">
                            <table id="user_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Name</th>
                                        <th>Registration No.</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        {{-- <th>Role</th> --}}
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($users_data as $user)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->reg_number }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone_number }}</td>
                                            {{-- <td>{{ ucwords(str_replace('_', ' ', $user->role)) }}</td> --}}

                                            <td align="center">
                                                @if ($user->is_active == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td align="center">
                                                <div class="d-flex flex-row justify-content-around">
                                                    <a class="edit_btn" href="{{ route('edit.student', $user->id) }}"
                                                        title="Edit user">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('destroy.student', $user->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        <a href="javascript::void(0)"
                                                            onclick="confirm_form_delete(this)" class="del_btn"
                                                            title="Delete user">
                                                            <i class="fas fa-user-minus text-danger"></i>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Name</th>
                                        <th>Registration No.</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        {{-- <th>Role</th> --}}
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
