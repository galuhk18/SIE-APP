<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-bms.png') }}" type="image/x-icon">


    @yield('title')

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">



</head>

<body>
    @include('sweetalert::alert')

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/img/logo-bms.png') }}" style="width: 2.5rem;" alt="">
             | <span>{{ env('APP_NAME') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#fullPageModal">Tentang</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" data-display="static" aria-expanded="false">Login</a>
                    <div class="dropdown-menu dropdown-menu-lg-right">
                      <a class="dropdown-item" href="{{ route('auth.admin.login') }}">Login Admin</a>
                      <a class="dropdown-item" href="{{ route('auth.executive.login') }}">Login Executive</a>
                    </div>
                </li>
                
            </ul>
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>

    <footer class="footer" style="background-color: #222;">
        <div class="container-fluid p-5">
            <p class="text-left text-white">
              <i class="fa fa-copyright"></i> Made with&nbsp;&nbsp;<i class="fa fa-heart text-danger"></i>&nbsp;&nbsp;{{ env('APP_NAME') }}
               
        </div>
    </footer>

    <div class="modal fade" id="fullPageModal" tabindex="-1" role="dialog" aria-labelledby="fullPageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-full" role="document">
            <div class="modal-content bg-info modal-full">
                <div class="modal-header">
                    <div class="text-left">

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" class="btn btn-dark rounded-circle"><i class="fa fa-arrow-left"></i></span>
                      </button>
                    </div>
                </div>
                <div class="modal-body">
                  <div class="content-about p-5">

                    <h3 class="font-weight-bolder text-white mb-3" id="fullPageModalLabel">Tentang
                      {{ env('APP_NAME') }} ?</h3>
                      <h4 class="text-white text-justify">Sistem informasi eksekutif desa Kebasen merupakan sistem informasi yang
                          digunakan untuk melaporkan statistik data penduduk Desa Kebasen kepada kepala desa. Sistem
                          informasi eksekutif dapat menginputkan data penduduk secara online yang dilakukan oleh admin
                          desa.</h4>
                  </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.miden.js') }}"></script>
    <script src="{{ asset('assets/js/demo/custom.js') }}"></script>



</body>

</html>
