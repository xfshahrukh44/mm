<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <!-- Google Fonts -->
  <link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <!-- MDB -->
  <link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet"/>
  <title></title>
  <style>
      /* About Us and main page*/
    .has-search .form-control {
      padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
      position: absolute;
      z-index: 2;
      display: block;
      width: 2.375rem;
      height: 2.375rem;
      line-height: 2.375rem;
      text-align: center;
      pointer-events: none;
      color: #aaa;
    }
    .card-img-top{
      width: 60%;
      position: relative;
      left: 17%;
    }
    .button_orange{
      font-size: 10px;
      background: #f76707;
      margin-right: 3%;
      /* color: white; */
      padding: 12px;
    }
    .card{
      -webkit-box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.75);
      -moz-box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.75);
      box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.75);
      border-radius: 10px;
      margin-top: 10%;
    }
    .modal_header{
      background: #f76707;
      text-align: center!important;
    }
    .navbar-orange{
      background: #f76707;
    }
    .navbar-orange a {
      color: white;    
    }
    .navbar-orange ul li  a {
        color: white;
    }
    .dropdown:hover>.dropdown-menu {
      display: block;
    }
    /* order history */
    .quantity {
    float: left;
    margin-right: 15px;
    background-color: #eee;
    position: relative;
    width: 80px;
    overflow: hidden
  }

  .quantity input {
    margin: 0;
    text-align: center;
    width: 15px;
    height: 15px;
    padding: 0;
    float: right;
    color: #000;
    font-size: 20px;
    border: 0;
    outline: 0;
    background-color: #F6F6F6
  }

  .quantity input.qty {
    position: relative;
    border: 0;
    width: 100%;
    height: 40px;
    padding: 10px 25px 10px 10px;
    text-align: center;
    font-weight: 400;
    font-size: 15px;
    border-radius: 0;
    background-clip: padding-box
  }

  .quantity .minus, .quantity .plus {
    line-height: 0;
    background-clip: padding-box;
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    /* -webkit-background-size: 6px 30px;
    -moz-background-size: 6px 30px; */
    color: #bbb;
    font-size: 20px;
    position: absolute;
    height: 50%;
    border: 0;
    right: 0;
    padding: 0;
    width: 25px;
    z-index: 3;
  }

  .quantity .minus:hover, .quantity .plus:hover {
    background-color: #dad8da
  }

  .quantity .minus {
    bottom: 0
  }
  .shopping-cart {
    z-index: 1;
    position: fixed;
    margin-left: 61%;
    margin-top: 27%;
    width: 29%;
    display: none;
  }
  .produts_scroll{
    max-height: 163px;
    overflow-y: auto;
  }
  .Toggle_btn{
    margin-left: 82%;
  }
  #show_cart, #Toggle{
    cursor: pointer;
  }
  /* product page */
  .dropdown:hover>.dropdown-menu {
      display: block;
    }
    .rate {
      float: left;
      height: 46px;
      /*padding: 0 10px;*/
    }
    .rate:not(:checked) > input {
      position:absolute;
      top:-9999px;
    }
    .rate:not(:checked) > label {
      float:right;
      width:1em;
      overflow:hidden;
      white-space:nowrap;
      cursor:pointer;
      font-size:20px;
      color:#ccc;
    }
    .rate:not(:checked) > label:before {
      content: '★ ';
    }
    .rate > input:checked ~ label {
      color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
      color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
      color: #c59b08;
    }
  </style>
</head>
<body>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
  -->


  <!-- navbar starts -->
  <nav class="navbar navbar-expand-lg navbar-orange">
    <div class="container">
      <a class="navbar-brand text-white" href="#">Master Materials</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
        <i class="fa fa-bars text-white"></i>
      </button>


      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('main')}}"><i class="fas fa-boxes"></i> Our Products</a>
          </li>
          @if(auth()->user() && auth()->user()->type == "customer")
            <li class="nav-item">
              <a class="nav-link active" aria-current="page"  type="button" href="{{route('order_history')}}" ><i class="fas fa-coins"></i> Order History </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active cart_btn_nav" aria-current="page" href="#"><i class="fas fa-cart-plus"></i>Cart</a>
            </li>
          @endif
          <li class="nav-item">
            <a class="nav-link active" aria-current="page"  type="button" href="{{route('about_us')}}" ><i class="fas fa-info-circle"></i> About Us </a>
          </li>

          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-th"></i> Category
            </a>
            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">

              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                  d
                </div>
                
              </div>
            </ul>
          </li> -->

        </ul>
        <form action="{{route('main')}}">
          @csrf
          <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search" name="query">
          </div>

        </form>
      </div>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                                  <!-- <li class="nav-item">
                                      <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                  </li> -->
                  @endif
              @else
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link active dropdown-toggle" aria-current="page" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          {{ Auth::user()->name }} <span class="caret"></span>
                      </a>

                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}" style="color: inherit;"
                              onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
    </div>
  </nav>



    <!-- content to be injected -->
    <div class="container">
        @yield('content')
    </div>

    <!-- cart modal -->
    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cartModalLabel">  <i class="fa fa-cart-plus"></i>Tokri</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" ></button>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table ">
                <thead>
                  <tr>
                    <th class="text-nowrap" scope="col">Image</th>
                    <th class="text-nowrap" scope="col">Product name</th>
                    <th class="text-nowrap" scope="col">price</th>
                    <th class="text-nowrap" scope="col">quantity</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row"><img src="{{asset('img/sdpl4.png')}}" class="img-fluid pull-xs-left" alt="..." style="width:40%"></th>
                    <td> <b> Sui dhaga<b/></td>
                    <td class="text-nowrap">  <b>100 Rs<b/></td>
                    <td> <b> 5<b/></td>
                  </tr>
                  <tr>
                    <th scope="row"><img src="{{asset('img/sdpl4.png')}}" class="img-fluid pull-xs-left" alt="..." style="width:40%"></th>
                    <td> <b> Sui dhaga<b/></td>
                    <td class="text-nowrap">  <b>100 Rs <b/></td>
                    <td> <b> 5<b/></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>



    <footer class="page-footer font-small mdb-color navbar-orange mt-5 lighten-3 pt-4">
            <!-- Copyright -->
            <div class="footer-copyright text-center text-capitalize text-sm py-3  text-white">
                <img class="img-fluid" src="{{asset('img/images/QrCode.png')}}" style="width: 200px;">
            </div>
            
            <div class="footer-copyright text-center text-capitalize text-sm py-3  text-white">
                <img class="img-fluid" src="{{asset('img/gold.jpg')}}" style="width: 70px;">
                <img class="img-fluid" src="{{asset('img/master.jpg')}}" style="width: 70px;">
                <p>Plot 247, sector 16b, Malik Anwar goth, Gabool town North karachi</p>
            </div>

            <!-- Copyright -->
            <div class="footer-copyright text-center text-capitalize py-3 text-white">powered by sui dhaga 
                <img class="img-fluid" src="{{asset('img/sdpl4.png')}}" style="width: 50px;">
            <span> by master materials</span>
        </div>
    </footer>



      <!-- cart quantity value -->
      <script>
        function addTheValue(secondValue) {
          var fValue = document.getElementById("firstValue");
          if((parseInt(fValue.innerHTML) + parseInt(secondValue)) >= 0){
            firstValue.innerHTML = parseInt(fValue.innerHTML) + parseInt(secondValue);
          }
        }
      </script>

      <!-- jQuery -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <!-- document ready -->
      <script>
        $(document).ready(function(){
          // on cart_btn_nav click
          $('.cart_btn_nav').on('click', function(){
            $('#cartModal').modal('show');
          });
        });
      </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.6/dist/sweetalert2.all.min.js"></script>
</body>
</html>