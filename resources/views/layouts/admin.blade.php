<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Companion - Admin</title>

    <!-- Bootstrap core CSS-->
    <link href="{{ asset('adminPage/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Browser Icon -->
    <link href="{{ asset('image/logo.png') }}" rel="shortcut icon">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('adminPage/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ asset('adminPage/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">

  </head>

  <body id="page-top" style="background: linear-gradient(to right, #70e1f5, #ffd194);">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="/bruhtest">Companion - Admin Dashboard</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <!-- <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div> -->
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <!-- <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger">9+</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> -->

        <!-- <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-envelope fa-fw"></i>
            <span class="badge badge-danger">7</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> -->

        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <!-- <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="#">Activity Log</a> -->
            <!-- <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav" style="background:rgba(0,0,0,0.7);">
        <li class="nav-item">
          <a class="nav-link" href="/activities">
            <i class="fas fa-fw fa-signature"></i>
            <span>Activities</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/interests">
            <i class="fas fa-fw fa-italic"></i>
            <span>Interests</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/feelings">
            <i class="fas fa-fw fa-grin-beam"></i>
            <span>Feelings</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/categories">
            <i class="fas fa-fw fa-list-ul"></i>
            <span>Categories</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/quotes">
            <i class="fas fa-fw fa-quote-right"></i>
            <span>Quotes</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/venueDash">
            <i class="fas fa-fw fa-map-marker-alt"></i>
            <span>Venues</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/videos">
            <i class="fas fa-fw fa-video"></i>
            <span>Videos</span>
          </a>  
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/systemConfig">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configuration</span>
          </a>  
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Login Screens:</h6>
            <a class="dropdown-item" href="login.html">Login</a>
            <a class="dropdown-item" href="register.html">Register</a>
            <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="404.html">404 Page</a>
            <a class="dropdown-item" href="blank.html">Blank Page</a>
          </div>
        </li> -->
      </ul>
      <!-- background: linear-gradient(to right, #70e1f5, #ffd194); -->
      <div id="content-wrapper" style="opacity: 1;">

        <div class="container-fluid">

          @yield('content')


        <!-- Sticky Footer -->
        <footer class="sticky-footer" style="background:rgba(0,0,0,0.05);">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Companion | USJ-R | Casptone 2 | 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="/logout">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('adminPage/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminPage/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('adminPage/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('adminPage/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('adminPage/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminPage/vendor/datatables/dataTables.bootstrap4.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>

    <!-- Demo scripts for this page-->
    <!-- <script src="js/demo/datatables-demo.js"></script> -->
    <!-- <script src="js/demo/chart-area-demo.js"></script> -->

  </body>

</html>
