{{ view('admin.layouts.header') }}

{{ view('admin.sidebar') }}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">View "{{ $society['name'] }}" Form</h1>
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
                        <li class="breadcrumb-item">View Form</li>
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
                        <div class="col-lg-12" id="form_title">
                            {{ $society->society_form->form_title }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="formdata_wrapper">
                            <form action="" method="post">
                                @csrf
                                @foreach ($society->society_form->form_data as $field)
                                    @if ($field->type === 'text' || $field->type === 'email' || $field->type === 'number')
                                        <div class="form-group">
                                            <label>{{ $field->label }}</label>
                                            <input type="{{ $field->type }}" name="{{ $field->name }}"
                                                class="form-control" {{ $field->required ? 'required' : '' }}>
                                        </div>
                                    @elseif ($field->type === 'radio')
                                        <div class="form-group">
                                            <label>{{ $field->label }}</label><br>
                                            @foreach ($field->options as $option)
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" name="{{ $option->name }}"
                                                        id="{{ $option->id }}" value="{{ $option->value }}"
                                                        class="form-check-input">
                                                    <label for="{{ $option->id }}"
                                                        class="form-check-label">{{ $option->label }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif ($field->type === 'checkbox')
                                        <div class="form-group">
                                            <label>{{ $field->label }}</label><br>
                                            @foreach ($field->options as $option)
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="{{ $option->name }}"
                                                        id="{{ $option->id }}" value="{{ $option->value }}"
                                                        class="form-check-input">
                                                    <label for="{{ $option->id }}"
                                                        class="form-check-label">{{ $option->label }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif ($field->type === 'select')
                                        <div class="form-group">
                                            <label>{{ $field->label }}</label>
                                            <select name="{{ $field->name }}" class="form-control select2"
                                                {{ $field->required ? 'required' : '' }}>
                                                @foreach ($field->options as $option)
                                                    <option value="{{ $option->value }}">{{ $option->label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @endforeach

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
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

{{ view('admin.control-sidebar') }}

<script>
    var storeformdata_route = '{{ route('society.storeformdata') }}'
</script>
{{ view('admin.layouts.footer') }}
{{ view('society::layouts.footer') }}
