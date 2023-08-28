@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Edit Society</h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('society.list') }}">Societies list</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item">Edit Society</li>
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
                            <h3 class="card-title">Edit Society</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update.society', $society->id) }}" method="post"
                                id="society_edit_form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="fw-bold">Society Name</label>
                                            <input type="text" class="form-control" placeholder="Society Name"
                                                name="name" id="name" value="{{ $society->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="convener" class="fw-bold">Convener</label>
                                            <select class="form-control select2" id="convener" name="convener">
                                                <option value="">Select Convener</option>
                                                @foreach ($staffMembers as $staff)
                                                    <option value="{{ $staff->id }}"
                                                        {{ $society->convener_id == $staff->id ? 'selected' : '' }}>
                                                        {{ $staff->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="president" class="fw-bold">President</label>
                                            <select class="form-control select2" id="president" name="president">
                                                <option value="">Select President</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}"
                                                        {{ $society->president_id == $student->id ? 'selected' : '' }}>
                                                        {{ $student->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="border_color" class="fw-bold">Border Color</label>
                                            <select class="form-control select2" id="border_color" name="border_color">
                                                <option value="">Select border color</option>
                                                @php
                                                    $bootstrapColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
                                                @endphp
                                                @foreach ($bootstrapColors as $color)
                                                    <option value="{{ $color }}"
                                                        {{ $society->border_color == $color ? 'selected' : '' }}>
                                                        {{ ucfirst($color) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="society_picture text-center">
                                            <input type="file" name="image_path"
                                                accept="image/png, image/jpeg, image/jpg"
                                                onchange="display_image(this);" class="d-none upload-box-image">
                                            <img class="box-image-preview img-fluid elevation-2"
                                                src="{{ $society->image_path ? asset('uploads/societies/uploads/' . $society->image_path) : asset('images/default-image.jpg') }}"
                                                alt="Society picture"
                                                onclick="$(this).closest('.society_picture').find('input').click();">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-primary btn-flat">
                                                Update <i class="fas fa-save"></i>
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

@include('footer', ['module' => 'society'])