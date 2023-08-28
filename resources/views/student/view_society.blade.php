{{ view('student.layouts.header') }}

<div class="container-fluid">
    <div class="row my-5 px-4">
        <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user shadow">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-primary" style="padding-bottom: 10rem;">
                    <h3 class="widget-user-username">{{ preg_replace('/\s+society$/i', '', $society->name) }}</h3>
                    <h5 class="widget-user-desc">Society</h5>
                </div>
                <div class="widget-user-image" style="transform: translate(-50%, -50%);margin-left: 0px;top: 50%;">
                    <img class="img-circle elevation-2" style="width: 150px;height: 150px;"
                        src="{{ asset('uploads/societies/uploads/' . $society->image_path) }}" alt="User Avatar">
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
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-tab" data-toggle="pill"
                                href="#custom-tabs-one" role="tab" aria-controls="custom-tabs-one"
                                aria-selected="true">Registration Form</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-two-tab" data-toggle="pill" href="#custom-tabs-two"
                                role="tab" aria-controls="custom-tabs-two" aria-selected="false">Discussion</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-one" role="tabpanel"
                            aria-labelledby="custom-tabs-one-tab">
                            <div class="row mb-3">
                                <div class="col-lg-12" id="form_title">
                                    {{ $society->society_form->form_title ?? 'No Form Yet' }}
                                </div>
                                <input type="hidden" name="societyID" value="{{ $society->id }}">
                            </div>
                            @if (!empty($society->society_form))
                                @if (!$society->hasSubmittedResponse)
                                    <div class="row">
                                        <div class="col-12" id="formdata_wrapper">
                                            @csrf
                                            @foreach ($society->society_form->form_data as $field)
                                                @if ($field->type === 'text' || $field->type === 'email' || $field->type === 'number')
                                                    <div class="form-group">
                                                        <label>{{ $field->label }}</label>
                                                        <input type="{{ $field->type }}" name="{{ $field->name }}"
                                                            placeholder="{{ $field->placeholder }}"
                                                            class="form-control"
                                                            {{ $field->required ? 'required' : '' }}>
                                                    </div>
                                                @elseif ($field->type === 'radio')
                                                    <div class="form-group">
                                                        <label>{{ $field->label }}</label><br>
                                                        @foreach ($field->options as $option)
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="{{ $option->name }}"
                                                                    id="{{ $option->id }}"
                                                                    value="{{ $option->value }}"
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
                                                                    id="{{ $option->id }}"
                                                                    value="{{ $option->value }}"
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
                                                                <option value="{{ $option->value }}">
                                                                    {{ $option->label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            @endforeach

                                            <button type="button" id="submitFormResponse"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                        <input type="text" name="society_id" value="{{ $society->id }}" hidden>
                                        <input type="text" name="form_id"
                                            value="{{ $society->society_form->id }}" hidden>
                                        <input type="text" name="form_active"
                                            value="{{ $society->society_form->active }}" hidden>
                                    </div>
                                @else
                                    <div class="card card-outline card-danger">
                                        <div class="card-body">
                                            <h3 class="card-title mb-3" style="font-size: 28px;">You've already
                                                responded.
                                            </h3>
                                            <p class="card-text">Your response has been recorded.</p>
                                            <p class="card-text">You can fill out this form only once.</p>
                                            <p class="card-text">Try contacting the owner if you think this is a
                                                mistake.
                                            </p>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two" role="tabpanel"
                            aria-labelledby="custom-tabs-two-tab">
                            @if ($society->hasAcceptedResponse == 'accept')
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
                                                        <span
                                                            class="direct-chat-timestamp float-{{ $alignmentClass1 }}">
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
                            @else
                                <div class="card card-outline card-danger">
                                    <div class="card-body">
                                        <h3 class="card-title mb-3" style="font-size: 28px;">
                                            You are not a member yet.
                                        </h3>
                                        <p class="card-text">Wait for admin to accpet your request.</p>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>

{{ view('student.layouts.footer') }}
