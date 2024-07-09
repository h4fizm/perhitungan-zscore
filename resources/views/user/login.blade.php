<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('style/assets/img/Favicon.png') }}">
  <title>
    Antromaps Login Page
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('style/assets/css/nucleo-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('style/assets/css/nucleo-svg.css') }}" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('style/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('style/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
</head>

<body class="">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
    <div class="container">
      <a class="navbar-brand  ms-lg-0 ms-3" href="">
        <h5 class='font-weight-bolder text-white'>ANTROMAPS</h5>
      </a>
      <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
    </div>
  </nav>
  <!-- End Navbar -->
  <main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-8 pb-11 m-3 border-radius-lg" style="background-image: url('https://getwallpapers.com/wallpaper/full/d/7/8/302180.jpg'); background-position: center;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">ANTROMAPS</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header pb-0 text-start">
              <h4 class="font-weight-bolder">Log In</h4>
              <p class="mb-0">Masukkan Email dan Password untuk Login</p>
            </div>
            <div class="card-body">
              @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <form method="POST" action="{{ route('login.authenticate') }}">
                @csrf
                <div class="mb-3">
                  <input type="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email" name="email">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password" value="">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Log in</button>
                </div>
              </form>
            </div>
            {{-- REGISTER SECTION --}}
          </div>
        </div>
      </div>
    </div>
  </main>
   <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="text-center text-sm text-muted">
          © <script>
            document.write(new Date().getFullYear())
          </script>,
          made with <i class="fa fa-heart"></i> and thanks to
          <a class="font-weight-bold" target="_blank">Creative Tim</a>
          to share this cool web design.
        </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="{{ asset('style/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('style/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('style/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('style/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <!-- Kanban scripts -->
  <script src="{{ asset('style/assets/js/plugins/dragula/dragula.min.js') }}"></script>
  <script src="{{ asset('style/assets/js/plugins/jkanban/jkanban.js') }}"></script>
  <script src="{{ asset('style/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
