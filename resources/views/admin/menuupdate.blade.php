@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('lang.update_menu_item')}}</h1>
            </div>
            <div class="col-sm-6">


                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/Menudisplay" style="text-decoration: none;">{{__('lang.menu_list')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('lang.update_menu_item')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header" style="background-color: #ffffff; color: #000000;">
                        <h3 class="card-title">{{__('lang.update_menu_item')}}</h3>
                    </div>
                    <div class="card-body">
                        <div id="response-message" class="alert" style="display:none; position: absolute; top: 0; width: 100%; z-index: 9999;"></div>
                        <form id="update-menu-form" enctype="multipart/form-data">
                            @csrf
                            @method('post') <!-- Correct method for update -->
                            <input type="hidden" name="id" id="menu-id" value="{{ $menuItem->id }}">

                            <div class="form-group">
                                <label for="name">{{__('lang.name')}}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $menuItem->name }}" required>
                                <span id="name-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="description">{{__('lang.description')}}</label>
                                <textarea id="description" class="form-control" name="description">{{ $menuItem->description }}</textarea>
                                <span id="description-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="price">{{__('lang.price')}}</label>
                                <input type="number" id="price" class="form-control" name="price" value="{{ $menuItem->price }}" required>
                                <span id="price-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="category_id">{{__('lang.category_id')}}</label>
                                <input type="text" id="category_id" class="form-control" name="category_id" value="{{ $menuItem->category_id }}">
                                <span id="category-error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="image">{{__('lang.image')}}</label>
                                <input type="file" id="image" class="form-control" name="image" accept="image/*">
                                <span id="image-error" class="text-danger"></span>
                                @if ($menuItem->image)
                                    <img src="{{ asset('storage/' . $menuItem->image) }}" alt="Current Image" style="max-width: 200px; margin-top: 10px;">
                                @endif
                            </div>

                            <button type="submit" formnovalidate   class="btn btn-primary">
                                <i class="fas fa-sync-alt"></i>{{__('lang.update')}}
                            </button>
                        </form>
                        <div id="spinner" class="spinner-border text-primary" style="display:none;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function validateField(field, errorSpan) {
            const value = $(field).val();
            let error = '';

            if ($(field).attr('required') && !value) {
                error = 'This field is required.';
            }

            // Add more validation rules as needed

            $(errorSpan).text(error);
        }

        $('#update-menu-form').on('input', function(event) {
            event.preventDefault();

            // Real-time validation
            validateField('#name', '#name-error');
            validateField('#description', '#description-error');
            validateField('#price', '#price-error');
            validateField('#category_id', '#category-error');
            validateField('#image', '#image-error');
        });

        $('#update-menu-form').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $('#response-message').hide();
            $('#spinner').show();

            $.ajax({
                url: "{{ route('menu.update', $menuItem->id) }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#spinner').hide();
                    showAlert($('#response-message'), response.message || 'Product updated successfully!', 'success');
                    setTimeout(function() {
                        window.location.href = "{{ route('Menudisplay') }}";
                    }, 1000);
                },
                error: function(xhr) {
                    $('#spinner').hide();
                    const errors = xhr.responseJSON?.errors || {};
                    const generalMessage = xhr.responseJSON?.message || 'An error occurred';

                    $('#name-error').text(errors.name ? errors.name[0] : '');
                    $('#description-error').text(errors.description ? errors.description[0] : '');
                    $('#price-error').text(errors.price ? errors.price[0] : '');
                    $('#category-error').text(errors.category_id ? errors.category_id[0] : '');
                    $('#image-error').text(errors.image ? errors.image[0] : '');

                    if (!errors.name && !errors.description && !errors.price && !errors.category_id && !errors.image) {
                        showAlert($('#response-message'), generalMessage, 'danger');
                    }
                }
            });
        });

        function showAlert(element, message, type) {
            element.removeClass('alert-success alert-danger').addClass(`alert-${type}`);
            element.text(message).show();
            setTimeout(() => element.fadeOut(), 10000);
        }
    });
</script>
@endsection
