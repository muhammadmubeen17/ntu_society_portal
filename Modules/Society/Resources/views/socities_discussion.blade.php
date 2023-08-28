@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Societies</h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item">Discussions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid pb-3">
            <div class="row mb-5 px-3">
                @foreach ($societies as $society)
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="card" style="width: 18rem;">
                            <img src="{{ asset('uploads/societies/uploads/' . $society->image_path) }}"
                                class="card-img-top" style="height: 200px" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-bold">{{ $society->name }}</h5>
                                <p class="card-text">
                                    Convener: {{ $society->convener->full_name ?? 'N/A' }}
                                    <br>
                                    President: {{ $society->president->full_name ?? 'N/A' }}
                                    <br>
                                    Members: {{ $society->totalMembers }}
                                </p>
                                <a href="{{ route('society.discussions', ['sid' => $society->id]) }}"
                                    class="btn btn-primary">View Society</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer', ['module' => 'society'])
