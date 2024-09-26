@extends('admin.layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/new-page" style="text-decoration: none;">{{__('lang.Home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('lang.my_profile')}}</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <!-- Profile Update Form -->
            <div class="col-md-7">
                <div class="card card-primary">
                    <div class="card-header" style="background-color: #ffffff; color: #000000;">
                        <h3 class="card-title">{{__('lang.update_user_details')}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                       
                         <!--Display current image in the middle and circular
                         if($user->image)
                         <div class="form-group text-center">
                         <label for="currentImage">Profile Picture</label>
                         <br>
                         <img id="currentImage" src="{ asset('storage/' . $user->image) }}" alt="Current Image" class="img-circle elevation-2" style="width: 100px; height: 100px; object-fit: cover;">
                         </div>
                         endif     -->  

                        <form id="updateprofile" method="POST">
                            @csrf
                            <div id="response-message" class="alert" style="display:none;"></div>
        
                            <div class="form-group">
                                <label for="inputName">{{__('lang.Name')}}</label>
                                <input type="text" id="inputName" name="name" class="form-control" value="">
                                <span id="name-error" class="text-danger"></span>
                            </div>
        
                            <div class="form-group">
                                <label for="inputEmail">{{__('lang.Email')}}</label>
                                <input type="Email" id="inputEmail" name="Email" class="form-control" readonly>
                                <span id="email-error" class="text-danger"></span>
                            </div>
        
                            <div class="form-group">
                                <label for="inputMobile">{{__('lang.Mobile Number')}}</label>
                                <input type="text" id="inputMobile" name="mobile_number" class="form-control" value="">
                                <span id="mobile_number-error" class="text-danger"></span>
                            </div>
        
                            <div class="form-group">
                                <label for="inputGender">{{__('lang.Gender')}}</label>
                                <select id="inputGender" name="gender" class="form-control custom-select">
                                    <option disabled selected>{{__('lang.Select Gender')}}</option>
                                    <option value="male">{{__('lang.Male')}}</option>
                                    <option value="female">{{__('lang.Female')}}</option>
                                    <option value="others">{{__('lang.Other')}}</option>
                                </select>
                                <span id="gender-error" class="text-danger"></span>
                            </div>
        
                            <div class="form-group">
                                <label for="inputAddress">{{__('lang.Address')}}</label>
                                <textarea id="inputAddress" name="address" class="form-control" rows="4"></textarea>
                                <span id="address-error" class="text-danger"></span>
                            </div>
        
                            <div class="form-group">
                                <label for="image">{{__('lang.profile_picture')}}</label>
                                <input type="file" id="image" class="form-control" name="image" accept="image/*">
                                <span id="image-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" formnovalidate id="updateProfileButton" class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i>{{__('lang.update')}}
                                </button>
                                <div id="profile-spinner" class="spinner-border text-primary" style="display:none;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Change Password Form -->
            <div class="col-md-5">
                <div class="card">
                    <div id="password-response-message" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <span id="password-response-text"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            
                    <div class="card-header">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-body">
                        <form id="changePasswordForm" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="old_password">{{__('lang.old_password')}}</label>
                                <input type="password" class="form-control" id="old_password" name="old_password" required>
                                <span class="text-danger" id="old_password-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="new_password">{{__('lang.new_password')}}</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <span class="text-danger" id="new_password-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{__('lang.confirm_password')}}</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <span class="text-danger" id="password_confirmation-error"></span>
                            </div>
                            <button type="submit" formnovalidate id="changePasswordButton" class="btn btn-primary">
                                <i class="fas fa-sync-alt"></i>{{__('lang.update')}}
                            </button>
                            <div id="password-spinner" class="spinner-border text-primary" style="display:none;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- jQuery and AdminLTE Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    // Set up AJAX with CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Fetch user data and populate the profile update form
    $.ajax({
        url: '/details',
        method: 'GET',
        success: function(response) {
            if (response.status) {
                $('#inputName').val(response.name);
                $('#inputEmail').val(response.email);
                $('#inputMobile').val(response.mobile_number);
                $('#inputGender').val(response.gender);
                $('#inputAddress').val(response.address);
                $('#inputImage').val(response.Image);
            } else {
                alert(response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while fetching user data.');
        }
    });

    // Profile update form submission
    $('#updateprofile').on('submit', function(event) {
        event.preventDefault();

        let isValid = true;

        isValid &= validateName();
        isValid &= validateEmailField();
        isValid &= validateMobileNumberField();
        isValid &= validateGender();
        isValid &= validateAddress();
        isValid &= validateImage();

        if (!isValid) {
            return;
        }

        $('#response-message').hide();
        $('#profile-spinner').show();

        var formData = new FormData(this);

        $.ajax({
            url: '/update',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#profile-spinner').hide();
                showAlert($('#response-message'), response.message || 'Profile updated successfully!', 'success');
                setTimeout(function() {
                    window.location.href = '/admin-page';
                }, 1000);
            },
            error: function(xhr) {
                $('#profile-spinner').hide();
                const errors = xhr.responseJSON?.errors || {};
                const generalMessage = xhr.responseJSON?.message || 'An error occurred';

                if (xhr.status === 422) {
                    $('#name-error').text(errors.name?.[0] || '');
                    $('#email-error').text(errors.email?.[0] || '');
                    $('#mobile_number-error').text(errors.mobile_number?.[0] || '');
                    $('#gender-error').text(errors.gender?.[0] || '');
                    $('#address-error').text(errors.address?.[0] || '');
                    $('#image-error').text(errors.image?.[0]||  '');
                } else {
                    showAlert($('#response-message'), generalMessage, 'danger');
                }
            }
        });
    });

    function showAlert(element, message, type) {
        element.removeClass('alert-success alert-danger');
        element.addClass('alert-' + type);
        element.text(message).show();
        setTimeout(function() {
            element.hide();
        }, 10000);
    }

    function validateName() {
        const name = $('#inputName').val();
        if (name.trim() === '') {
            $('#name-error').text('Name is required.');
            return false;
        } else {
            $('#name-error').text('');
            return true;
        }
    }

    function validateEmailField() {
        const email = $('#inputEmail').val();
        if (email.trim() === '') {
            $('#email-error').text('Email is required.');
            return false;
        } else {
            $('#email-error').text('');
            return true;
        }
    }

    function validateMobileNumberField() {
        const mobileNumber = $('#inputMobile').val();
        if (mobileNumber.trim() === '' || !/^\d{10,15}$/.test(mobileNumber)) {
            $('#mobile_number-error').text('Invalid mobile number.');
            return false;
        } else {
            $('#mobile_number-error').text('');
            return true;
        }
    }

    function validateGender() {
        const gender = $('#inputGender').val();
        if (gender === null) {
            $('#gender-error').text('Gender is required.');
            return false;
        } else {
            $('#gender-error').text('');
            return true;
        }
    }

    function validateAddress() {
        const address = $('#inputAddress').val();
        if (address.trim() === '') {
            $('#address-error').text('Address is required.');
            return false;
        } else {
            $('#address-error').text('');
            return true;
        }
    }

    function validateImage() {
        const imageInput = $('#image').get(0);
        if (imageInput.files.length > 0) {
            const file = imageInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                $('#image-error').text('Invalid image type. Only JPEG, PNG, JPG, and GIF are allowed.');
                return false;
            }
            if (file.size > 2048 * 1024) { // 2MB
                $('#image-error').text('Image size exceeds 2MB.');
                return false;
            }
            $('#image-error').text('');
            return true;
        }
        $('#image-error').text('');
        return true;
    }

    

});

$(document).ready(function() {
    // Change password form submission
    $('#changePasswordForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Validate password fields
        let isValid = validatePasswordFields();

        if (!isValid) {
            return; // Prevent form submission if validation fails
        }

        // Clear previous messages and show spinner
        $('#password-response-message').hide();
        $('#password-spinner').show();

        // Prepare form data
        const formData = {
            old_password: $('#old_password').val(),
            new_password: $('#new_password').val(),
            new_password_confirmation: $('#password_confirmation').val(),
        };

        $.ajax({
            url: '/change', // Ensure this URL is correct
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'json', // Expect JSON response
            success: function(response) {
                // Display success message
                showAlert('#password-response-message', response.message || 'Password changed successfully!', 'success');
                $('#password-spinner').hide(); // Hide spinner on success
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors || {};
                const generalMessage = xhr.responseJSON?.message || 'An error occurred';

                // Handle specific field errors
                if (errors.old_password) {
                    $('#old_password-error').text(errors.old_password[0]);
                }
                if (errors.new_password) {
                    $('#new_password-error').text(errors.new_password[0]);
                }
                if (errors.password_confirmation) {
                    $('#password_confirmation-error').text(errors.password_confirmation[0]);
                }

                // Show general error message if no specific field errors
                if (!errors.old_password && !errors.new_password && !errors.password_confirmation) {
                    showAlert('#password-response-message', generalMessage, 'danger');
                }

                $('#password-spinner').hide(); // Hide spinner on error
            }
        });
    });

    // Validation function for the change password form
    function validatePasswordFields() {
        const newPassword = $('#new_password').val();
        const passwordError = $('#new_password-error');
        const passwordConfirmation = $('#password_confirmation').val();
        const passwordConfirmationError = $('#password_confirmation-error');
        let isValid = true;

        // Regex for validation
        const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

        // New password validation
        if (!newPassword) {
            passwordError.text('New password is required');
            isValid = false;
        } else if (!regex.test(newPassword)) {
            passwordError.text('Password must be at least 8 characters, include 1 uppercase letter, 1 number, and 1 special character');
            isValid = false;
        } else {
            passwordError.text('');
        }

        // Password confirmation validation
        if (!passwordConfirmation) {
            passwordConfirmationError.text('Password confirmation is required');
            isValid = false;
        } else if (newPassword !== passwordConfirmation) {
            passwordConfirmationError.text('Passwords do not match');
            isValid = false;
        } else {
            passwordConfirmationError.text('');
        }

        return isValid;
    }

    // Function to show alerts
    function showAlert(elementSelector, message, type) {
        const element = $(elementSelector);
        element.removeClass('alert-success alert-danger').addClass(`alert alert-${type}`);
        element.html(`<span>${message}</span><span class="alert-close" onclick="hideAlert('${element.attr('id')}')">×</span>`);
        element.show();
    }

    // Function to hide alerts
    window.hideAlert = function(alertId) {
        const alertElement = $(`#${alertId}`);
        alertElement.hide();
    };

    // Auto-hide alert after 10 seconds
    setInterval(function() {
        hideAlert('response-message');
        hideAlert('password-response-message');
    }, 10000);
});

</script>
@endsection