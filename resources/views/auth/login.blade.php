<!doctype html>
<html lang="en">

<head>
    <title><?php echo config('app.name'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="icon" type="image/x-icon" href="<?php //echo asset('/images/ktdev-mini.png'); ?>"> --}}
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-1">
                    <?php if( session()->has('message') ) : ?>
                    <span class="text-danger"><span class="text-danger font-weight-bold">*
                        </span><?php echo session()->get('message'); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                        <h3 class="text-center mb-4">Have an account?</h3>
                        <form action="<?php echo route('login'); ?>" class="login-form" method="POST">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control rounded-left"
                                    placeholder="Username" required>
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" name="password" class="form-control rounded-left"
                                    placeholder="Password" required>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#">Forgot Password</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <button type="submit" class="btn btn-primary rounded submit p-3 px-5">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Jquery --}}
    <script src="{{ asset('admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    {{-- jquery-validation  --}}
    <script src="{{ asset('admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    {{-- Sweet Alert  --}}
    <script src="{{ asset('admin-lte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <?php
    
    /**
     *  Alert
     */
    $message = '';
    $icon = '';
    
    if (!empty($errors->all())) {
        $icon = 'error';
        $message = $errors->first();
    } elseif (session()->has('success')) {
        $icon = 'success';
        $message = session()->get('success');
    } elseif (session()->has('error')) {
        $icon = 'error';
        $message = session()->get('error');
    } elseif (!empty($success)) {
        $icon = 'success';
        $message = $success;
    }
    
    ?>

    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 4000
        });
        var message = '{{ $message }}';
        var icon = '{{ $icon }}';
        if (message.length > 0) {
            Toast.fire({
                icon: icon,
                title: message
            });
        }
    </script>
    <script>
        $('#username').keyup(function() {
            // $('#username').val(this.value.replace(/\s/g, ''));

            var index = this.selectionStart,
                reg = /[^a-z0-9@.]/gi,
                inputvalue = $(this).val();
            if (reg.test(inputvalue)) {
                $(this).val(inputvalue.replace(reg, ''));
                index--;
            }
            this.setSelectionRange(index, index);
        });

        $(function() {
            $('#loginForm').validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    username: {
                        required: "Please enter a username"
                    },
                    password: {
                        required: "Please provide a password"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

</body>

</html>
