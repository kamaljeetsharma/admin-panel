<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!--<a href="index3.html" class="brand-link">
    <img src="admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>-->

  
  
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <ul class="nav nav-treeview">

            <a href="{{ url('/') }}" class="brand-link" style="text-decoration: none;">
              <img src="{{ asset('storage/images/image.png') }}" alt="Goto Order Logo" class="brand-image img-circle elevation-3" style="opacity:.9">
              <span class="brand-text font-weight-light">{{__('lang.got_order')}}</span>
          </a>
            <div class="sidebar">
              <!-- Sidebar user panel (optional) -->
              <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <!-- Image Section -->
                <div class="image">
                    <img src="{{ asset('storage/'.Auth::user()->image) }}"class="img-circle elevation-2"alt="User Image"style="width: 30px; height: 30px;">
                </div>
                <!-- Info Section -->
                <div class="info ml-0">
                    <a href="admin-page"class="d-block" style="text-decoration: none;">{{ Auth::user()->name }}</a>
                </div>
            </div>

          <li class="nav-item">
            <a href="new-page" class="nav-link {{ Request::is('new-page') ? 'active' :''}}">
              <i class="nav-icon fas fa-home"></i>
              <p>{{__('lang.Home')}}</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/Menudisplay" class="nav-link {{ Request::is('Menudisplay') ? 'active' : '' }}">
              <i class="fas fa-bars"></i>
              <p>{{__('lang.menu')}}</p>
            </a>
          </li>

            <li class="nav-item">
              <a href="/users"class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <p>{{__('lang.users')}}</p>
              </a>
            </li>
           
            <li class="nav-item">
              <a href="/categorydisplay"class="nav-link {{ Request::is('categorydisplay') ? 'active' : '' }}">
                <i class="fas fa-bars"></i>
                <p>{{__('lang.category')}}</p>
              </a>
            </li>
           
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

