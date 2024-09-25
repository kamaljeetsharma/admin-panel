@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('lang.add_menu_item')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/Menudisplay" style="text-decoration: none;">{{__('lang.menu_list')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('lang.add_menu_item')}}</li>
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
                        <h3 class="card-title">{{__('lang.add_menu_item')}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="response-message" class="alert" style="display:none; position: absolute; top: 0; width: 100%; z-index: 9999;"></div>
                        <form id="menu-form" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{__('lang.name')}}</label>
                                <input type="text" id="name" class="form-control" name="name" required>
                                <span id="name-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="description">{{__('lang.description')}}</label>
                                <textarea id="description" class="form-control" name="description"></textarea>
                                <span id="description-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="price">{{__('lang.price')}}</label>
                                <input type="number" id="price" class="form-control" name="price" required>
                                <span id="price-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{__('lang.category')}}</label>
                                <select id="category_id" class="form-control" name="category_id" required>
                                    <option value="">Select Category</option>
                                    
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span id="category-id-error" class="text-danger"></span>
                            </div>
                            
                            <!--<div class="form-group">
                                <label for="category_id">Category ID</label>
                                <input type="number" id="category_id" class="form-control" name="category_id">
                                <span id="category-id-error" class="text-danger"></span>
                            </div>-->

                            <!-- Image Input Field -->
                            <div class="form-group">
                                <label for="image"></label>{{__('lang.image')}}
                                <input type="file" id="image" class="form-control" name="image" accept="image/*">
                                <span id="image-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit"   formnovalidate class="btn btn-primary float-left">
                                    <i class="bi bi-box-seam"></i> {{__('lang.submit')}}
                                </button>
                            </div>
                            
                        </form>
                        <div class="spinner-border text-primary" style="display:none;" role="status">
                            <span class="sr-only">Loading...</span>
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
        // Real-time validation functions
        $('#name').on('input', validateName);
        $('#description').on('input', validateDescription);
        $('#price').on('input', validatePrice);
        $('#category_id').on('input', validateCategoryId);
        $('#image').on('change', validateImage);

        // Form submission handler
        $('#menu-form').on('submit', function(event) {
            event.preventDefault();
            let isValid = validateForm();

            if (!isValid) {
                return; // Stop form submission if validation fails
            }

            $('#response-message').hide();
            $('.spinner-border').show();

            let formData = new FormData();
            formData.append('_token', $('input[name="_token"]').val());
            formData.append('name', $('#name').val());
            formData.append('description', $('#description').val());
            formData.append('price', $('#price').val());
            formData.append('category_id', $('#category_id').val());
            formData.append('image', $('#image')[0].files[0]);

            $.ajax({
                url: "/Store",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.spinner-border').hide();
                    showAlert($('#response-message'), response.message || 'Product added successfully!', 'success');
                    setTimeout(function() {
                        window.location.href = "/Menudisplay";
                    }, 1000);
                },
                error: function(xhr) {
                    $('.spinner-border').hide();
                    const errors = xhr.responseJSON?.errors || {};
                    const generalMessage = xhr.responseJSON?.message || 'An error occurred';

                    handleErrors(errors);
                    if (!Object.keys(errors).length) {
                        showAlert($('#response-message'), generalMessage, 'error');
                    }
                }
            });
        });

        // Form validation functions
        function validateForm() {
            return validateName() && validateDescription() && validatePrice() && validateCategoryId() && validateImage();
        }

        function validateName() {
            const name = $('#name').val();
            const nameError = $('#name-error');
            if (!name) {
                nameError.text('Product Name is required');
                return false;
            } else {
                nameError.text('');
                return true;
            }
        }

        function validateDescription() {
            const description = $('#description').val();
            const descriptionError = $('#description-error');
            if (!description) {
                descriptionError.text('Description is required');
                return false;
            } else {
                descriptionError.text('');
                return true;
            }
        }

        function validatePrice() {
            const price = $('#price').val();
            const priceError = $('#price-error');
            if (!price) {
                priceError.text('Price is required');
                return false;
            } else {
                priceError.text('');
                return true;
            }
        }

        function validateCategoryId() {
            const categoryId = $('#category_id').val();
            const categoryIdError = $('#category-id-error');
            if (!categoryId) {
                categoryIdError.text('Category ID is required');
                return false;
            } else if (!/^\d+$/.test(categoryId)) {
                categoryIdError.text('Category ID must be a valid integer');
                return false;
            } else {
                categoryIdError.text('');
                return true;
            }
        }

        function validateImage() {
            const image = $('#image')[0].files[0];
            const imageError = $('#image-error');
            if (image && !image.type.match('image.*')) {
                imageError.text('Please select a valid image file');
                return false;
            } else if (!image) {
                imageError.text('Image is required');
                return false;
            } else {
                imageError.text('');
                return true;
            }
        }

        function showAlert(element, message, type) {
            const alertType = type === 'success' ? 'alert-success' : 'alert-danger';
            element.removeClass('alert-success alert-danger').addClass(alertType).text(message).fadeIn().delay(10000).fadeOut();
        }

        function handleErrors(errors) {
            $('#name-error').text(errors.name ? errors.name[0] : '');
            $('#description-error').text(errors.description ? errors.description[0] : '');
            $('#price-error').text(errors.price ? errors.price[0] : '');
            $('#category-id-error').text(errors.category_id ? errors.category_id[0] : '');
            $('#image-error').text(errors.image ? errors.image[0] : '');
        }
    });
</script>
@endsection