@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">{{ $society->name }}</h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><i class="fas fa-angle-right"></i></li>
                        <li class="breadcrumb-item">{{ $society->name . " Discussion" }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid pb-3">
            <div class="row mb-5 px-4">
                <div class="col-md-12">
                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user shadow">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-primary" style="padding-bottom: 10rem;">
                            <h3 class="widget-user-username">{{ preg_replace('/\s+society$/i', '', $society->name) }}
                            </h3>
                            <h5 class="widget-user-desc">Society</h5>
                        </div>
                        <div class="widget-user-image"
                            style="transform: translate(-50%, -50%);margin-left: 0px;top: 50%;">
                            <img class="img-circle elevation-2" style="width: 150px;height: 150px;"
                                src="{{ asset('uploads/societies/uploads/' . $society->image_path) }}"
                                alt="User Avatar">
                        </div>
                        <div class="card-footer" style="padding-top: 90px;">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">Convener</h5>
                                        <span class="description-text">{{ $society->convener->full_name }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">President</h5>
                                        <span class="description-text">{{ $society->president->full_name }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">Members</h5>
                                        <span class="description-text">{{ $society->totalMembers }}</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            {{-- <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <a href="#" class="btn btn-primary">Follow</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $society->name . ' Discussion' }}</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="direct-chat-messages" style="height: 400px">
                                        @foreach ($society->discussions as $discussion)
                                            @php
                                                $isMine = $discussion->user_id === auth()->user()->id;
                                                $alignmentClass = $isMine ? 'right' : 'left';
                                                $alignmentClass1 = $isMine ? 'left' : 'right';
                                            @endphp

                                            <div class="direct-chat-msg {{ $alignmentClass }}">
                                                <div class="direct-chat-infos clearfix">
                                                    <span class="direct-chat-name float-{{ $alignmentClass }}">
                                                        {{ $discussion->users->username }}
                                                    </span>
                                                    <span class="direct-chat-timestamp float-{{ $alignmentClass1 }}">
                                                        {{ $discussion->created_at->format('d M h:i a') }}
                                                    </span>
                                                </div>
                                                @php
                                                    if ($discussion->users->role == 'admin' || $discussion->users->role == 'staff') {
                                                        $image_path = isset($discussion->users->staff->image_path) && $discussion->users->staff->image_path ? 'uploads/staff/uploads/' . $discussion->users->staff->image_path : 'images/user-thumb.jpg';
                                                    } else {
                                                        $image_path = isset($discussion->users->student->image_path) && $discussion->users->student->image_path ? 'uploads/students/uploads/' . $discussion->users->student->image_path : 'images/user-thumb.jpg';
                                                    }
                                                @endphp
                                                <img class="direct-chat-img" src="{{ asset($image_path) }}"
                                                    alt="User Image">
                                                <div class="direct-chat-text">
                                                    {{ $discussion->message }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Type Message ..."
                                            class="form-control">
                                        <span class="input-group-append">
                                            <button type="button" id="send_message"
                                                class="btn btn-primary">Send</button>
                                        </span>
                                    </div>
                                </div>
                                <!-- /.card-footer-->
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <input type="hidden" name="societyID" value="{{ $society->id }}">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer', ['module' => 'society'])
