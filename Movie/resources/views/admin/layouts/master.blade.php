<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{asset('images/icon.png')}}" rel="icon">
  <title>Admin - A Movies</title>
  <link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin/css/ruang-admin.min.css')}}" rel="stylesheet">
  <link href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon">
          <img src="{{asset('images/icon.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span class="font-weight-bold">Thống kê</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('movie')}}">
          <i class='fab fa-youtube'></i>
          <span class="font-weight-bold">Phim</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('banner')}}">
          <i class='fas fa-clone'></i>
          <span class="font-weight-bold">Banner</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Phân loại
      </div>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin-category')}}">
          <i class='fas fa-database'></i>
          <span class="font-weight-bold">Loại phim</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin-genre')}}">
          <i class='fas fa-database'></i>
          <span class="font-weight-bold">Thể loại phim</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin-country')}}">
          <i class='fas fa-database'></i>
          <span class="font-weight-bold">Quốc gia</span>
        </a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Người dùng
      </div>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin-user')}}">
          <i class='fas fa-user-alt'></i>
          <span class="font-weight-bold">Người dùng</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin-level')}}">
          <i class="fas fa-user-cog"></i>
          <span class="font-weight-bold">Cấp bậc</span>
        </a>
      </li>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{asset('images/'.Auth::user()->image)}}" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{Auth::user()->name}}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('logoutAdmin')}}"  data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->
        <!-- Container Fluid-->
        @yield('content')
        <!---Container Fluid-->
      </div>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('admin/js/ruang-admin.min.js')}}"></script>
  <script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#myTable').DataTable();
    });
  </script>
</body>

</html>