@extends('admin.layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('lang.menu_list')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">        
                      <a href="/new-page" style="text-decoration: none;">{{__('lang.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active"> {{__('lang.menu_list')}}</li>
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

                <!-- Menu Items Table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('lang.menu_items')}}</h3>
                        <div class="card-tools" style="float: right;">
                            <a href="/Menu/add" class="btn btn-primary">
                                <i class="fas fa-plus"></i> <!-- Font Awesome Plus Icon -->
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($menuItems->isEmpty())
                            <p>No menu items found.</p>
                        @else
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{__('lang.S.No')}}</th>
                                        <th>{{__('lang.item_name')}}</th>
                                        <th>{{__('lang.price')}}</th>
                                        <th>{{__('lang.description')}}</th>
                                        <th>{{__('lang.action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menuItems as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->description }}</td>
                                        <!--<td>
                                            <a href="{{ url('edit-menu-item', ['id' => $item->id]) }}" class="btn btn-warning btn-sm">Update</a>
                                            <form action="{{ route('deleteMenuItem', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>-->
                                        <td>
                                            <!-- Update button with AdminLTE 3 icon and gray background, no border -->
                                            <a href="{{ url('edit-menu-item', ['id' => $item->id]) }}" class="btn btn-sm" style="background-color: gray; border: none; color: white;">
                                                <i class="fas fa-edit"></i> <!-- AdminLTE 3 edit icon -->
                                            </a>
                                        
                                            <!-- Delete button with AdminLTE 3 icon and gray background, no border -->
                                            <form action="{{ route('deleteMenuItem', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
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
                                {{ $menuItems->links('pagination::bootstrap-4') }}
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
