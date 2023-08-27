$(document).ready(function () {
    // Use the .removeAttr() method to remove the style attribute
    $('.select2-container').removeAttr('style');

    // User Create Form Validation
    $(function () {
        $('#society_creation_form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
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

    // Submit society form after validation
    $("#create_new_society").click(function (e) {
        e.preventDefault();
        $("#society_creation_form").submit();
    });


    var numberOfFormGroups = $('#formdata_wrapper .form-group').length;
    var fieldCount = 0;
    if (numberOfFormGroups == 0) {
        fieldCount = 0;
    } else {
        fieldCount = numberOfFormGroups
    }
    console.log(fieldCount)
    $('#addInput').click(function () {
        var inputType = parseInt(prompt("Select input type:\n1. Text\n2. Number\n3. Email\n4. Radio\n5. Checkbox\n6. Select"));

        if (![1, 2, 3, 4, 5, 6].includes(inputType)) {
            alert("Invalid input type selected. Please select a valid option.");
            return;
        }

        fieldCount++;

        var label = prompt("Enter label for the input:");
        var inputHtml = '';

        if (inputType === 1) {

            inputHtml = `<input type="text" name="field${fieldCount}" placeholder="${label}" class="form-control">`;
        } else if (inputType === 2) {

            inputHtml = `<input type="number" name="field${fieldCount}" placeholder="${label}" class="form-control">`;
        } else if (inputType === 3) {

            inputHtml = `<input type="email" name="field${fieldCount}" placeholder="${label}" class="form-control">`;
        } else if (inputType === 4) {

            var options = prompt("Enter options separated by comma (Option 1, Option 2, ...):");
            var optionList = options.split(',').map(option => option.trim());
            var optionsHtml = optionList.map((option, index) => `
                    <div class="icheck-primary d-inline">
                        <input type="radio" name="field${fieldCount}" id="radio${fieldCount}${index}" value="${option}" />
                        <label for="radio${fieldCount}${index}">${option}</label>
                    </div>
                `).join('<br>');
            inputHtml = optionsHtml;
        } else if (inputType === 5) {

            var options = prompt("Enter options separated by comma (Option 1, Option 2, ...):");
            var optionList = options.split(',').map(option => option.trim());
            var optionsHtml = optionList.map((option, index) => `
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" name="field${fieldCount}${index}" id="checkbox${fieldCount}${index}" value="${option}" />
                        <label for="checkbox${fieldCount}${index}" attr-options="options">${option}</label>
                    </div>
                `).join('<br>');
            inputHtml = optionsHtml;
        } else if (inputType === 6) {

            var options = prompt("Enter options separated by comma (Option 1, Option 2, ...):");
            var optionList = options.split(',').map(option => option.trim());
            var optionsHtml = optionList.map(option => `<option value="${option}">${option}</option>`).join('');
            inputHtml = `<select name="field${fieldCount}" class="form-control select2">${optionsHtml}</select>`;
        }

        // Add delete button
        var deleteButton = `<button type="button" class="btn btn-danger btn-sm delete-field">Delete</button>`;

        $('#formdata_wrapper').append(`
        <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
                <label contenteditable="true" class="w-100">${label}</label>
                ${deleteButton}
            </div>
            ${inputHtml}
        </div>
    `);

        // Trigger Select2 on the added select element
        $('#formdata_wrapper select').select2();

        // Attach delete button handler
        $('.delete-field').click(function () {
            $(this).closest('.form-group').remove();
        });
    });



    $('#submitForm').click(function () {
        var formFields = [];

        $('#formdata_wrapper .form-group').each(function (index) {
            console.log(index);
            var label = $(this).find('label:first').text();
            var fieldType = $(this).find('input[type="radio"]').length > 0 ? 'radio' :
                $(this).find('input[type="checkbox"]').length > 0 ? 'checkbox' :
                    $(this).find('input[type="email"]').length > 0 ? 'email' :
                        $(this).find('input[type="number"]').length > 0 ? 'number' :
                            $(this).find('select').length > 0 ? 'select' : 'text';
            var required = true; // Modify this based on your logic

            if (fieldType === 'text' || fieldType === 'email') {
                var name = $(this).find('input:first').attr('name');
            }

            var fieldData = {
                name: name ? name : null,
                label: label,
                type: fieldType,
                required: required,
            };

            if (fieldType === 'radio' || fieldType === 'checkbox') {
                var options = [];
                $(this).find('input[type="' + fieldType + '"]').each(function () {
                    options.push({
                        label: $(this).next('label').text(),
                        name: $(this).attr('name'),
                        id: $(this).attr('id'),
                        value: $(this).val(),
                    });
                });
                fieldData.options = options;
            } else if (fieldType === 'select') {
                var options = [];
                $(this).find('select option').each(function () {
                    options.push({
                        label: $(this).text(),
                        value: $(this).val(),
                    });
                });
                fieldData.options = options;
            }

            formFields.push(fieldData);
        });

        // Send the form data to the controller using AJAX
        $.ajax({
            url: storeformdata_route, // Change this to the actual route name
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                formData: JSON.stringify(formFields),
                societyId: $('input[name="society_id"]').val(),
                form_title: $('input[name="form_title"]').val(),
            },
            success: function (response) {
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Form created successfully.'
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Form is empty.'
                    });
                }
            },
            error: function (error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong.'
                });
            }
        });
    });

    // Initialize Bootstrap Switch
    $("input[form-active-switch]").bootstrapSwitch();

    // Listen for switch change event
    $("input[form-active-switch]").on('switchChange.bootstrapSwitch', function (event, state) {
        $(this).closest(".form-active-status").submit();
    });

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