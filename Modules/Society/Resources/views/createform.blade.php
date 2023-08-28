@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">Create "{{ $society['name'] }}" Form</h1>
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
                        <li class="breadcrumb-item"><a
                                href="{{ route('society.view', $society->id) }}">{{ $society->name }}</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item">Create Form</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="form_title" id="form_title" placeholder="Enter Form Title Here">
                        </div>
                        <div class="col-lg-4 text-right">
                            <button class="btn btn-primary" id="addInput">Add Input</button>
                            <button class="btn btn-success" id="submitForm">Submit Form</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="formdata_wrapper">
                            {{-- append fields here --}}
                        </div>
                        <input type="text" name="society_id" value="{{ $society->id }}" hidden>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<script>
    var storeformdata_route = '{{ route("society.storeformdata") }}'
</script>

@include('footer', ['module' => 'society'])
