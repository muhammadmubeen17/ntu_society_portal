@include('header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h1 class="m-0">{{ $society_form->society->name }}</h1>
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
                                href="{{ route('society.view', $society_form->society_id) }}">{{ $society_form->society->name }}</a>
                        </li>
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
        <div class="container-fluid pb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8" id="form_title">
                            "{{ $society_form->form_title }}" Submitted by
                            "{{ $society_form->users->student->full_name }}"
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="accepted" {{ $society_form->status == 'accept' ? 'checked' : '' }}>
                                <label for="accepted">
                                    Accept
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="formdata_wrapper">
                            @csrf
                            @foreach ($society_form->form_data as $field)
                                @if ($field->type === 'text' || $field->type === 'email' || $field->type === 'number')
                                    <div class="form-group">
                                        <label>{{ $field->label }}</label>
                                        <input type="{{ $field->type }}" value="{{ $field->value }}"
                                            name="{{ $field->name }}" placeholder="{{ $field->placeholder }}"
                                            class="form-control" readonly>
                                    </div>
                                @elseif ($field->type === 'radio')
                                    <div class="form-group">
                                        <label>{{ $field->label }}</label><br>
                                        @foreach ($field->options as $option)
                                            <div class="form-check form-check-inline">
                                                <input type="radio" name="{{ $option->name }}"
                                                    {{ $option->checked ? 'checked' : '' }} id="{{ $option->id }}"
                                                    value="{{ $option->value }}" class="form-check-input" readonly>
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
                                                    {{ $option->checked ? 'checked' : '' }} class="form-check-input"
                                                    readonly>
                                                <label for="{{ $option->id }}"
                                                    class="form-check-label">{{ $option->label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($field->type === 'select')
                                    <div class="form-group">
                                        <label>{{ $field->label }}</label>
                                        <select name="{{ $field->name }}" class="form-control select2"
                                            aria-readonly="true" readonly>
                                            @foreach ($field->options as $option)
                                                <option value="{{ $option->value }}"
                                                    {{ $field->value == $option->value ? 'selected' : '' }}>
                                                    {{ $option->label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <input type="text" name="society_id" value="{{ $society_form->society_id }}" hidden>
                        <input type="text" name="form_id" value="{{ $society_form->id }}" hidden>
                        <input type="text" name="user_id" value="{{ $society_form->user_id }}" hidden>
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
    var form_status_update = '{{ route('society.add.member') }}'
</script>

@include('footer', ['module' => 'society'])
