@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">{{ $society['name'] }}</h1>
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
                        <li class="breadcrumb-item">{{ $society['name'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <h5 class="mb-2">Basic Information</h5>
            <div class="row">
                <div class="col-md-12">
                    <!-- Society Information -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-fluid" style="height: 50vh"
                                    src="{{ $society->image_path ? asset('uploads/societies/uploads/' . $society->image_path) : asset('images/no-image.jpg') }}"
                                    alt="User profile picture">
                            </div>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Convener</b> <a
                                        class="float-right">{{ $society->convener->full_name ?? 'N/A' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>President</b> <a
                                        class="float-right">{{ $society->president->full_name ?? 'N/A' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Members</b> <a class="float-right">{{ $society->totalMembers }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <h5 class="mb-2 mt-3">Registration Form</h5>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fa-brands fa-wpforms"></i>
                        </span>

                        <a class="info-box-content text-decoration-none text-dark"
                            href="{{ route('society.createform', $society->id) }}">
                            <span class="info-box-text">Create Form</span>
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registration Forms (Total: {{ $society['society_forms_count'] }})
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="form_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Form title</th>
                                        <th>Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($society['society_forms'] as $form)
                                        <tr>
                                            <td>{{ $index }}</td>
                                            <td>{{ $form['form_title'] }}</td>
                                            <td>
                                                <form class="form-active-status" action="{{ route('society.form.active', [$society->id, $form->id]) }}" method="post">
                                                    @csrf
                                                    <input id="form_active_btn" type="checkbox" name="form_active_checkbox" form-active-switch data-off-color="danger" data-on-color="success" {{ $form->active == true ? 'checked' : '' }}>
                                                </form>
                                            </td>
                                            <td align="center">
                                                <div class="d-flex flex-row justify-content-around">
                                                    <a href="{{ route('view.society.form', [$society->id, $form->id]) }}"
                                                        title="View Form">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('destroy.society.form', [$society->id, $form->id]) }}"
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

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registration Form Responses (Total: {{ $society['society_form_responses_count'] }})
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="form_response_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Form title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($society['society_form_responses'] as $form)
                                        <tr>
                                            <td>{{ $index }}</td>
                                            <td>{{ $form['users']['student_id'] }}</td>
                                            <td>{{ $form['users']['student']['full_name'] }}</td>
                                            <td>{{ $form['form_title'] }}</td>
                                            <td>{{ $form['status'] }}</td>
                                            <td align="center">
                                                <div class="d-flex flex-row justify-content-around">
                                                    <a href="{{ route('view.society.form.response', [$society->id, $form->id]) }}"
                                                        title="View Form">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('destroy.society.form.response', [$society->id, $form->id]) }}"
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

            <h5 class="mb-2 mt-3">Members Detail</h5>
            <div class="row">
                <div class="col-md-12">
                    <!-- Society Members -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Society Members (Total: {{ $society['totalMembers'] }})</h3>
                        </div>
                        <div class="card-body">
                            <table id="members_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Registration No.</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($society['members'] as $member)
                                        <tr>
                                            <td>{{ $member['id'] }}</td>
                                            <td>{{ $member['user']['student']['full_name'] }}</td>
                                            <td>{{ $member['user']['student']['reg_number'] }}</td>
                                            <td>{{ $member['user']['student']['email'] }}</td>
                                            <td align="center">
                                                <div class="d-flex flex-row justify-content-around">
                                                    <form
                                                        action="{{ route('destroy.society.member', [$society->id, $member->id]) }}"
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
