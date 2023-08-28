{{ view('student.layouts.header') }}

<div class="container-fluid">
    <div class="row my-5 px-3">
        @foreach ($societies as $society)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('uploads/societies/uploads/' . $society->image_path) }}" class="card-img-top" style="height: 200px" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-bold">{{ $society->name }}</h5>
                        <p class="card-text">
                            Convener: {{ $society->convener->full_name ?? 'N/A' }}
                            <br>
                            President: {{ $society->president->full_name ?? 'N/A' }}
                            <br>
                            Members: {{ $society->totalMembers }}
                        </p>
                        <a href="{{ route('student.view.society', ['id' => $society->id]) }}" class="btn btn-primary">View Society</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{ view('student.layouts.footer') }}
