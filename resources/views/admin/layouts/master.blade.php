<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{env('APP_NAME')}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="#" type="image/x-icon">

  <!-- jquery ui css-->
  <!-- <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.min.css')}}"> -->
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui/jquery-ui.css')}}">
  <!-- <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet"> -->
  
  <!-- jquery -->
  <!-- <script src="{{asset('js/jquery-3.5.1.slim.min.js')}}"></script> -->
  <!-- <script src="{{asset('plugins/jquery/jquery.js')}}"></script> -->
  <script type="text/javascript" src="{{asset('plugins/jquery/jquery.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.js')}}"></script>
  <!-- <script src="{{asset('plugins/jquery-ui/external/jquery/jquery.js')}}"></script> -->
  <!-- <script src = "https://code.jquery.com/jquery-1.10.2.js"></script> -->
  
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom-style.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.dataTables.min.css')}}">

  <!-- fancy box -->
  <link rel="stylesheet" href="{{asset('fancybox/source/jquery.fancybox.css?v=2.1.7')}}" type="text/css" media="screen" />

  <!-- jquery ui js -->

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Fontawesome -->
  <!-- <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}"/> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image" width="20px"><span class="caret"></span> {{ucfirst(Auth::user()->name)}}
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <!-- <a class="dropdown-item" href="#">
              Profile
            </a> -->
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link" id="topSidebar">
      <img src="{{ asset('img/logo.png') }}" alt="LaraStart Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
      <span class="brand-text font-weight-light">Master Materials</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucfirst(Auth::user()->name)}}</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

          <!-- Dashboard -->
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt "></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- Customer Database -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customer Database
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('customer.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('area.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Areas and Markets</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Stock Management -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-truck"></i>
              <p>
                Stock Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('product.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('category.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('brand.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Brands</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('unit.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Units</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Accouting -->
          <li class="nav-item">
            <a href="{{route('customer.index')}}" class="nav-link">
              <i class="nav-icon fa fa-credit-card"></i>
              <p>
                Accouting
              </p>
            </a>
          </li>

          <!-- Order Management -->
          <li class="nav-item">
            <a href="{{route('customer.index')}}" class="nav-link">
              <i class="nav-icon fa fa-clipboard"></i>
              <p>
                Order Management
              </p>
            </a>
          </li>

          <!-- Marketing Plan -->
          <li class="nav-item">
            <a href="{{route('customer.index')}}" class="nav-link">
              <i class="nav-icon fa fa-cart-arrow-down"></i>
              <p>
                Marketing Plan
              </p>
            </a>
          </li>

          <!-- user management -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user "></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('user.index')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Staff</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('rider')}}" class="nav-link">
                  <i class="fas fa-circle nav-icon"></i>
                  <p>Riders</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content_header')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content_body')
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">

  </footer>
</div>

<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>

<!-- fancybox -->
<script type="text/javascript" src="{{asset('fancybox/source/jquery.fancybox.pack.js?v=2.1.7')}}"></script>

<!-- jquery ui js-->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->

</body>
</html>