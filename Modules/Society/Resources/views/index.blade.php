@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">Manage Society</h1>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('create.society') }}" class="add-btn">
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
                        <li class="breadcrumb-item">Societies</li>
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
                            <h3 class="card-title">Societies List</h3>
                        </div>
                        <div class="card-body">
                            <table id="user_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Name</th>
                                        <th>Convener</th>
                                        <th>President</th>
                                        <th>Members</th>
                                        <th>Border Color</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach ($societies as $society)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $society->name }}</td>
                                            <td>{{ $society->convener->full_name ?? 'N/A' }}</td>
                                            <td>{{ $society->president->full_name ?? 'N/A' }}</td>
                                            <td>{{ $society->totalMembers }}</td>
                                            <td>{{ ucfirst($society->border_color) }}</td>
                                            <td align="center">
                                                <div class="d-flex flex-row justify-content-around">
                                                    <a class="edit_btn" href="{{ route('edit.society', $society->id) }}"
                                                        title="Edit user">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('destroy.society', $society->id) }}"
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
                                        <th>Convener</th>
                                        <th>President</th>
                                        <th>Members</th>
                                        <th>Border Color</th>
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

@include('footer', ['module' => 'society'])
