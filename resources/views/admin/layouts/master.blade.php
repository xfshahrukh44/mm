<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{env('APP_NAME')}}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="#" type="image/x-icon">

  <!-- jquery ui css-->
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui/jquery-ui.css')}}">
  <!-- toastr css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  
  <!-- jquery js -->
  <script type="text/javascript" src="{{asset('plugins/jquery/jquery.js')}}"></script>
  <!-- jquery ui js -->
  <script type="text/javascript" src="{{asset('plugins/jquery-ui/jquery-ui.js')}}"></script>
  <!-- toastr js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


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

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Dashboard -->
          @can('can_dashboard')
            <li class="nav-item">
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt "></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
          @endcan

          <!-- Client Database -->
          @can('can_client_database')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Client Database
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <!-- Customers -->
                @can('can_customers')
                  <li class="nav-item">
                    <a href="{{route('customer.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <small>Customers</small>
                    </a>
                  </li>
                @endcan
                <!-- Customer Schedule -->
                @can('can_customer_schedule')
                  <li class="nav-item">
                    <a href="{{route('customer_schedule')}}" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <small>Customer Schedule</small>
                    </a>
                  </li>
                @endcan
                <!-- Vendors -->
                @can('can_vendors')
                  <li class="nav-item">
                    <a href="{{route('vendor.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <small>Vendors</small>
                    </a>
                  </li>
                @endcan
                <!-- Areas and Markets -->
                @can('can_areas_and_markets')
                  <li class="nav-item">
                    <a href="{{route('area.index')}}" class="nav-link">
                      <i class="nav-icon  fas fa-map-marked-alt"></i>
                      <small>Areas and Markets</small>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>
          @endcan

          <!-- Stock Management -->
          @can('can_stock_management')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-truck"></i>
                <p>
                  Stock Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <!-- Products -->
                @can('can_products')
                  <li class="nav-item">
                    <a href="{{route('product.index')}}" class="nav-link">
                      <i class="nav-icon fab fa-product-hunt"></i>
                      <small>Products</small>
                    </a>
                  </li>
                @endcan
                <!-- Stock In -->
                @can('can_stock_in')
                  <li class="nav-item">
                    <a href="{{route('stock_in.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-sign-in-alt"></i>
                      <small>Stock In</small>
                    </a>
                  </li>
                @endcan
                <!-- Stock Out -->
                @can('can_stock_out')
                  <li class="nav-item">
                    <a href="{{route('stock_out.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-sign-out-alt"></i>
                      <small>Stock Out</small>
                    </a>
                  </li>
                @endcan
                <!-- Special Discounts -->
                @can('can_special_discounts')
                  <li class="nav-item">
                    <a href="{{route('special_discounts')}}" class="nav-link">
                      <i class="nav-icon fas fa-percentage"></i>
                      <small>Special Discounts</small>
                    </a>
                  </li>
                @endcan
                <!-- Categories -->
                @can('can_categories')
                  <li class="nav-item">
                    <a href="{{route('category.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-copyright"></i>
                      <small>Categories</small>
                    </a>
                  </li>
                @endcan
                <!-- Brands -->
                @can('can_brands')
                  <li class="nav-item">
                    <a href="{{route('brand.index')}}" class="nav-link">
                      <i class="nav-icon fab fa-bootstrap"></i>
                      <small>Brands</small>
                    </a>
                  </li>
                @endcan
                <!-- Units -->
                @can('can_units')
                  <li class="nav-item">
                    <a href="{{route('unit.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-balance-scale-left"></i>
                      <small>Units</small>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>
          @endcan

          <!-- Accounting -->
          @can('can_accounting')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  Accounting
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <!-- Customer Ledgers -->
                @can('can_customer_ledgers')
                  <li class="nav-item">
                    <a href="{{route('get_customer_ledgers')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Customer Ledgers</small>
                    </a>
                  </li>
                @endcan
                <!-- Vendor Ledgers -->
                @can('can_vendor_ledgers')
                  <li class="nav-item">
                    <a href="{{route('get_vendor_ledgers')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Vendor Ledgers</small>
                    </a>
                  </li>
                @endcan
                <!-- Sales Ledgers -->
                @can('can_sales_ledgers')
                  <li class="nav-item">
                    <a href="{{route('sales_ledgers')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Sales Ledgers</small>
                    </a>
                  </li>
                @endcan
                <!-- Receipts -->
                @can('can_receipts')
                  <li class="nav-item">
                    <a href="{{route('receiving.index')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Receipts</small>
                    </a>
                  </li>
                @endcan
                <!-- Receipt Logs -->
                @can('can_receipt_logs')
                  <li class="nav-item">
                    <a href="{{route('receiving_logs')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Receipt Logs</small>
                    </a>
                  </li>
                @endcan
                <!-- Payments -->
                @can('can_payments')
                  <li class="nav-item">
                    <a href="{{route('payment.index')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Payments</small>
                    </a>
                  </li>
                @endcan
                <!-- Expenses -->
                @can('can_expenses')
                  <li class="nav-item">
                    <a href="{{route('expense.index')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Expenses</small>
                    </a>
                  </li>
                @endcan
                <!-- Expense Ledgers -->
                @can('can_expense_ledgers')
                  <li class="nav-item">
                    <a href="{{route('expenses')}}" class="nav-link">
                      <i class="fas fa-book nav-icon"></i>
                      <small>Expense Ledgers</small>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>
          @endcan

          <!-- Order Management -->
          @can('can_order_management')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-clipboard"></i>
                <p>
                  Order Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <!-- orders -->
                @can('can_orders')
                  <li class="nav-item">
                    <a href="{{route('order.index')}}" class="nav-link">
                      <i class="nav-icon fa fa-clipboard"></i>
                      <small>Orders</small>
                    </a>
                  </li>
                @endcan
                <!-- invoices -->
                @can('can_invoices')
                  <li class="nav-item">
                    <a href="{{route('invoice.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-file-invoice-dollar"></i>
                      <small>Invoices</small>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>
          @endcan

          <!-- Marketing Plan -->
          @can('can_marketing_plan')
            <li class="nav-item">
              <a href="{{route('search_marketing')}}" class="nav-link">
                <i class="nav-icon fa fa-cart-arrow-down"></i>
                <p>
                  Marketing Plan
                </p>
              </a>
            </li>
          @endcan

          <!-- Your Marketing Tasks -->
          @can('can_marketing_tasks')
            <li class="nav-item">
              <a href="{{route('search_marketing_tasks')}}" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Your Marketing Tasks
                </p>
              </a>
            </li>
          @endcan

          <!-- Security Shell -->
          @can('isSuperAdmin')
            <li class="nav-item">
              <a href="{{route('shell')}}" class="nav-link">
                <i class="nav-icon fas fa-shield-alt"></i>
                <p>
                  Security Shell
                </p>
              </a>
            </li>
          @endcan

          <!-- user management -->
          @can('can_user_management')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user "></i>
                <p>
                  User Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <!-- Staff -->
                @can('can_staff')
                  <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link">
                      <i class="nav-icon fas fa-users"></i>
                      <small>Staff</small>
                    </a>
                  </li>
                @endcan
                <!-- Riders -->
                @can('can_riders')
                  <li class="nav-item">
                    <a href="{{route('rider')}}" class="nav-link">
                      <i class="fas fa-motorcycle nav-icon"></i>
                      <small>Riders</small>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>
          @endcan

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

<!-- pusher work -->

<!-- pusher -->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<!-- pusher event binder -->
<script>
  // Enable pusher logging - don't include this in production
  // Pusher.logToConsole = true;

  var pusher = new Pusher('c568a790f53b416b3823', {
      cluster: 'ap2'
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('threshold_reached', function(data) {

      toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "showDuration": "0",
      "hideDuration": "0",
      "timeOut": "0",
      "extendedTimeOut": "0",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
      }

      toastr["error"](data.message, "Threshold reached.");
  });
</script>

</body>
</html>