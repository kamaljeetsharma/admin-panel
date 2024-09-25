@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('lang.update_user')}}</h1>  
            </div>
            <div class="col-sm-6">

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/users" style="text-decoration: none;">{{__('lang.User List')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('lang.update_user')}}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-md-12">
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


                         <!-- Display current image in the middle and circular -->
                         @if($user->image)
                         <div class="form-group text-center">
                             <label for="currentImage">{{__('lang.profile_picture')}}</label>
                             <br>
                             <img id="currentImage" src="{{ asset('storage/' . $user->image) }}" alt="Current Image" class="img-circle elevation-2" style="width: 100px; height: 100px; object-fit: cover;">
                         </div>
                     @endif

                        <form id="updateprofile" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">

                            <div id="response-message" class="alert" style="display:none;"></div>

                            <div class="form-group">
                                <label for="inputName">{{__('lang.Name')}}</label>
                                <input type="text" id="inputName" name="name" class="form-control" value="{{ $user->name }}">
                                <span id="name-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">{{__('lang.Email')}}</label>
                                <input type="email" id="inputEmail" name="email" class="form-control" readonly value="{{ $user->email }}">
                                <span id="email-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="inputMobile">{{__('lang.Mobile Number')}}</label>
                                <input type="text" id="inputMobile" name="mobile_number" class="form-control" value="{{ $user->mobile_number }}">
                                <span id="mobile_number-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="inputGender">{{__('lang.Gender')}}</label>
                                <select id="inputGender" name="gender" class="form-control custom-select">
                                    <option disabled>Select one</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>{{__('lang.Male')}}</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>{{__('lang.Female')}}</option>
                                    <option value="others" {{ $user->gender == 'others' ? 'selected' : '' }}>{{__('lang.Other')}}</option>
                                </select>
                                <span id="gender-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="inputAddress">{{__('lang.Address')}}</label>
                                <textarea id="inputAddress" name="address" class="form-control" rows="4">{{ $user->address }}</textarea>
                                <span id="address-error" class="text-danger"></span>
                            </div>

                           

                            <div class="form-group">
                                <label for="image">{{__('lang.change_profile_picture')}}</label>
                                <input type="file" id="image" class="form-control" name="image" accept="image/*">
                                <span id="image-error" class="text-danger"></span>
                            </div>

                            <button type="submit" class="btn btn-primary">
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
<!-- /.content -->

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include AdminLTE JS -->
<script src="{{ asset('path/to/adminlte.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Set up CSRF token in AJAX request headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#updateprofile').on('submit', function(event) {
        event.preventDefault();

        let isValid = true;

        // Validate all fields
        isValid &= validateName();
        isValid &= validateEmailField();
        isValid &= validateMobileNumberField();
        isValid &= validateGender();
        isValid &= validateAddress();
        isValid &= validateImage(); // Ensure image validation is included

        if (!isValid) {
            return;
        }

        $('#response-message').hide();
        $('.spinner-border').show();

        var formData = new FormData(this);

        $.ajax({
            url: '{{ route('admin.user.update', $user->id) }}',
            method:'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('.spinner-border').hide();
                showAlert($('#response-message'), response.message || 'Profile updated successfully!', 'success');
                setTimeout(function() {
                    window.location.href = '{{ route('users') }}'; // Adjust route if necessary
                }, 1000);
            },
            error: function(xhr) {
                $('.spinner-border').hide();
                const errors = xhr.responseJSON?.errors || {};
                const generalMessage = xhr.responseJSON?.message || 'An error occurred';

                if (xhr.status === 422) {
                    $('#name-error').text(errors.name?.[0] || '');
                    $('#email-error').text(errors.email?.[0] || '');
                    $('#mobile_number-error').text(errors.mobile_number?.[0] || '');
                    $('#gender-error').text(errors.gender?.[0] || '');
                    $('#address-error').text(errors.address?.[0] || '');
                    $('#image-error').text(errors.image?.[0] || ''); // Display image validation errors
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
</script>
@endsection
