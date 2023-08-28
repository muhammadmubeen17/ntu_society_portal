@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">View all Societies</h1>
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
            <h3 class="mb-4">Societies</h3>
            <div class="row">
                @php
                    if (empty($societies)) {
                        echo "<div class='text-center mx-auto'>No records Found</div>";
                    }   
                @endphp
                @foreach ($societies as $society)
                    <div class="col-md-4 col-sm-6 col-12">
                        <a href="{{ route('society.view', $society->id) }}" class="text-decoration-none text-dark">
                            <div class="info-box border border-{{ $society->border_color }}">
                                <span class="info-box-icon info-box-icon-bg"
                                    style="background-image: url('{{ asset('uploads/societies/uploads/' . $society->image_path) }}')"></span>

                                <div class="info-box-content">
                                    <h4 class="info-box-text">{{ $society->name }}</h4>
                                    <span class="info-box-number font-weight-normal" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                        <span class="font-weight-bold">Convener:</span>
                                        {{ $society->convener->full_name ?? 'N/A' }}
                                    </span>
                                    <span class="info-box-number font-weight-normal" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                        <span class="font-weight-bold">President:</span>
                                        {{ $society->president->full_name ?? 'N/A' }}
                                    </span>
                                    <span class="info-box-number font-weight-normal" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                        <span class="font-weight-bold">Members:</span>
                                        {{ $society->totalMembers }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer', ['module' => 'society'])
