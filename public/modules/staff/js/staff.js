// username validation
$('#username').keyup(function () {
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

// User Create Form Validation
$(function () {
    $('#user_creation_form').validate({
        rules: {
            firstname: {
                required: true,
                minlength: 2,
            },
            username: {
                required: true,
                minlength: 8,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
                minlength: 11,
            },
            password: {
                required: true,
                minlength: 8,
            },
            registration_number: {
                required: true,
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});

// User Update Form Validation
$(function () {
    $('#user_edit_form').validate({
        rules: {
            firstname: {
                required: true,
                minlength: 2,
            },
            username: {
                required: true,
                minlength: 8,
            },
            email: {
                required: true,
                email: true,
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});

// Submit user form after validation
$("#create_new_user").click(function (e) {
    e.preventDefault();
    $("#user_creation_form").submit();
});

/**
 *  Display Image 
 */
function display_image(input) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();
        reader.onload = function (e) {

            $(input).closest('div').find('.box-image-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }

}

// Submit user form after validation
$("#save_edit_user").click(function (e) {
    e.preventDefault();
    $("#user_edit_form").submit();
});
