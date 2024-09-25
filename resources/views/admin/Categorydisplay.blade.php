@extends('admin.layouts.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('lang.category')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/new-page" style="text-decoration: none;">{{__('lang.Home')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{__('lang.category_list')}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Categories Table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('lang.category')}}</h3>
                        <div class="card-tools" style="float: right;">
                            <a href="/category" class="btn btn-primary">
                                <i class="fas fa-plus"></i> <!-- Font Awesome Plus Icon -->
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($categories->isEmpty())
                            <p>No categories found.</p>
                        @else
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{__('lang.S.No')}}</th>
                                        <th>{{__('lang.Name')}}</th>
                                        <th>{{__('lang.slug')}}</th>
                                        <th>{{__('lang.description')}}</th>
                                        <th>{{__('lang.Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>
                                                <!-- Edit button with AdminLTE 3 icon and gray background, no border -->
                                                <a href="{{ url('categories/' . $category->id) }}" class="btn btn-sm" style="background-color: gray; border: none; color: white;">
                                                    <i class="fas fa-edit"></i> <!-- AdminLTE 3 edit icon -->
                                                </a>
                                            
                                                <!-- Delete button with AdminLTE 3 icon and gray background, no border -->
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return {{__('lang.Confirm delete')}}('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm" style="background-color: gray; border: none; color: white;">
                                                        <i class="fas fa-trash"></i> <!-- AdminLTE 3 delete icon -->
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>

                            <!-- Pagination -->
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-end">
                                {{ $categories->links('pagination::bootstrap-4') }}
                              </ul>
                            </nav>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
