@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{__('lang.update_category')}}</h1>
            </div>
            <div class="col-sm-6">

                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/categorydisplay" style="text-decoration: none;">{{__('lang.category_list')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('lang.update_category')}}</li>
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
                        <h3 class="card-title">{{__('lang.update_category')}}</h3>
                    </div>
                    <div class="card-body">
                        <div id="response-message" class="alert" style="display:none; position: absolute; top: 0; width: 100%; z-index: 9999;"></div>
                        <form id="update-category-form" action="{{ route('updateCategory', $category->id) }}" method="POST">
                            @csrf
                            @method('Post') <!-- Corrected to PUT method -->

                            <div class="form-group">
                                <label for="name">{{__('lang.Name')}}</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $category->name) }}" required>
                                <span id="name-error" class="text-danger"></span>
                            </div>
                             <!--
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" class="form-control" name="slug" value="{ old('slug', $category->slug) }}" required>
                                <span id="slug-error" class="text-danger"></span>
                            </div>
                        -->
                            <div class="form-group">
                                <label for="description"></label>
                                <textarea id="description" class="form-control" name="description">{{ old('description', $category->description) }}</textarea>
                                <span id="description-error" class="text-danger"></span>
                            </div>

                            <button type="submit" formnovalidate class="btn btn-primary">
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

            $(errorSpan).text(error);
        }

        $('#update-category-form').on('input', function() {
            validateField('#name', '#name-error');
            //validateField('#slug', '#slug-error');
            validateField('#description', '#description-error');
        });

        $('#update-category-form').on('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            $('#response-message').hide();
            $('#spinner').show();

            $.ajax({
                url:'{{route('updateCategory',$category->id)}}',
                type: 'POST', // Uses POST method with _method field for PUT
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#spinner').hide();
                    showAlert($('#response-message'), response.message || 'Category updated successfully!', 'success');
                    setTimeout(function() {
                        window.location.href = "categorydisplay";
                    }, 1000);
                },
                error: function(xhr) {
                    $('#spinner').hide();
                    const errors = xhr.responseJSON?.errors || {};
                    const generalMessage = xhr.responseJSON?.message || 'An error occurred';

                    $('#name-error').text(errors.name ? errors.name[0] : '');
                    //$('#slug-error').text(errors.slug ? errors.slug[0] : '');
                    $('#description-error').text(errors.description ? errors.description[0] : '');

                    if (!errors.name && !errors.slug && !errors.description) {
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
