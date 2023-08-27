// username validation
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

// Form Validation
$(function() {
    $('#user_creation_form').validate({
        rules: {
            firstname: {
                required: true,
                minlength: 3,
            },
            username: {
                required: true,
                minlength: 8,
            },
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8,
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

$("#create_new_user").click(function (e) { 
    e.preventDefault();
    $("#user_creation_form").submit();
});