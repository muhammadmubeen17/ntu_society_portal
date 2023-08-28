@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">Registration Forms</h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('societies.view') }}">Societies</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item">Registration Forms</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <h5 class="mb-2 mt-3">Registration Forms</h5>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registration Forms (Total: {{ $society_forms_count }})
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="form_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Society ID</th>
                                        <th>Society Name</th>
                                        <th>Form title</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($society_forms as $form)
                                        <tr>
                                            <td>{{ $index }}</td>
                                            <td>{{ $form->society_id }}</td>
                                            <td>{{ $form->society->name }}</td>
                                            <td>{{ $form['form_title'] }}</td>
                                            <td>
                                                <form class="form-active-status" action="{{ route('society.form.active', [$form->society_id, $form->id]) }}" method="post">
                                                    @csrf
                                                    <input id="form_active_btn" type="checkbox" name="form_active_checkbox" form-active-switch data-off-color="danger" data-on-color="success" {{ $form->active == true ? 'checked' : '' }}>
                                                </form>
                                            </td>
                                            <td align="center">
                                                <div class="d-flex flex-row justify-content-around">
                                                    <a href="{{ route('view.society.form', [$form->society_id, $form->id]) }}"
                                                        title="View Form">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('destroy.society.form', [$form->society_id, $form->id]) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        <a href="javascript::void(0)"
                                                            onclick="confirm_form_delete(this)" class="del_btn"
                                                            title="Delete Form">
                                                            <i class="fas fa-user-minus text-danger"></i>
                                                        </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $index++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer', ['module' => 'society'])