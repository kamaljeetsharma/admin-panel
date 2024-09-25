@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('lang.add_category') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/categorydisplay" style="text-decoration: none;">{{ __('lang.category_list') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('lang.add_category') }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header" style="background-color: #ffffff; color: #000000;">
                        <h3 class="card-title">{{ __('lang.add_category') }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="{{ __('lang.collapse') }}">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="response-message" class="alert" style="display:none; position: absolute; top: 0; width: 100%; z-index: 9999;"></div>
                        <form id="category-form">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('lang.category_name') }}</label>
                                <input type="text" id="name" class="form-control" name="name" required>
                                <span id="name-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="slug">{{ __('lang.slug') }}</label>
                                <input type="text" id="slug" class="form-control" name="slug" required>
                                <span id="slug-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('lang.description') }}</label>
                                <textarea id="description" class="form-control" name="description"></textarea>
                                <span id="description-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{ __('lang.category_id') }}</label>
                                <input type="text" id="category_id" class="form-control" name="category_id">
                                <span id="category_id-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" formnovalidate class="btn btn-primary float-left">
                                    <i class="bi bi-box-seam"></i> {{ __('lang.add_category') }}
                                </button>
                            </div>
                        </form>
                        <div class="spinner-border text-primary" style="display:none;" role="status">
                            <span class="sr-only">{{ __('lang.loading') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Real-time validation for name
        $('#name').on('input', function() {
            validateName();
        });
    
        // Real-time validation for slug
        $('#slug').on('input', function() {
            validateSlug();
        });
    
        // Real-time validation for description
        $('#description').on('input', function() {
            validateDescription();
        });

        // Real-time validation for category_id
        $('#category_id').on('input', function() {
            validateCategoryId();
        });

        // Form submission handler
        $('#category-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
    
            let isValid = true;
    
            // Validate all fields
            if (!validateName()) isValid = false;
            if (!validateSlug()) isValid = false;
            // Description is not required; no need to validate
            // if (!validateDescription()) isValid = false;
            if (!validateCategoryId()) isValid = false;
    
            if (!isValid) {
                return; // Prevent form submission if validation fails
            }
    
            // Clear previous messages and show spinner
            $('#response-message').hide();
            $('.spinner-border').show();
    
            // Create FormData object
            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val()); // Laravel CSRF token
            formData.append('name', $('#name').val());
            formData.append('slug', $('#slug').val());
            formData.append('description', $('#description').val());
            formData.append('category_id', $('#category_id').val());
    
            $.ajax({
                url: "/additem", // Update with your route
                type: 'POST',
                data: formData,
                contentType: false, // Important for file upload
                processData: false, // Important for file upload
                success: function(response) {
                    $('.spinner-border').hide(); // Hide spinner on success
                    showAlert($('#response-message'), response.success || '{{ __('lang.category_added_success') }}', 'success');
                    setTimeout(function() {
                        window.location.href = "categorydisplay"; // Redirect to category list page
                    }, 1000);
                },
                error: function(xhr) {
                    $('.spinner-border').hide(); // Hide spinner on error
                    const errors = xhr.responseJSON?.errors || {};
                    const generalMessage = xhr.responseJSON?.message || '{{ __('lang.error_occurred') }}';
    
                    // Handle specific field errors
                    if (errors.name) {
                        $('#name-error').text(errors.name[0]);
                    }
                    if (errors.slug) {
                        $('#slug-error').text(errors.slug[0]);
                    }
                    if (errors.description) {
                        $('#description-error').text(errors.description[0]);
                    }
                    if (errors.category_id) {
                        $('#category_id-error').text(errors.category_id[0]);
                    }
    
                    // Show general error message if no specific field errors
                    if (!errors.name && !errors.slug && !errors.description && !errors.category_id) {
                        showAlert($('#response-message'), generalMessage, 'error');
                    }
                }
            });
        });
    
        function validateName() {
            const name = $('#name').val();
            const nameError = $('#name-error');
            if (!name) {
                nameError.text('{{ __('lang.category_name_required') }}');
                return false;
            } else {
                nameError.text('');
                return true;
            }
        }
    
        function validateSlug() {
            const slug = $('#slug').val();
            const slugError = $('#slug-error');
            if (!slug) {
                slugError.text('{{ __('lang.slug_required') }}');
                return false;
            } else {
                slugError.text('');
                return true;
            }
        }
    
        function validateDescription() {
            // Description is not required; no validation required
            return true;
        }

        function validateCategoryId() {
            const categoryId = $('#category_id').val();
            const categoryIdError = $('#category_id-error');
            // Assuming category_id is optional, adjust if needed
            if (categoryId && isNaN(categoryId)) {
                categoryIdError.text('{{ __('lang.category_id_number') }}');
                return false;
            } else {
                categoryIdError.text('');
                return true;
            }
        }
    
        function showAlert(element, message, type) {
            element.removeClass('alert-success alert-error').addClass(`alert alert-${type}`);
            element.html(`<span>${message}</span><span class="alert-close" onclick="hideAlert('${element.attr('id')}')">×</span>`);
            element.show();
    
            // Automatically hide alert after 10 seconds
            setTimeout(function() {
                hideAlert(element.attr('id'));
            }, 10000);
        }
    
        function hideAlert(id) {
            $(`#${id}`).fadeOut();
        }
    });
</script>

@endsection
