<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Web | Klinik</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ URL::to('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::to('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::to('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ URL::to('vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="icon" href="images/login-icon.png" type="image/x-icon">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  </header><!-- End Header -->

  <body>

    <!-- Uncomment below if you prefer to use an image logo -->
    <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-container">
              <div class="carousel-content container">
                <div  data-aos="fade-up" data-aos-delay="200">
                <h1 class="animate__animated animate__fadeInDown" style="text-align: center;color:rgb(255, 255, 255)">Selamat Datang di <span>Master Klinik</span></h1>
                <h4 class="animate__animated animate__fadeInUp" style="text-align: center;color:rgb(255, 255, 255)"> <br>Login Sesuai Role Anda</h4>
                  <div class="d-flex justify-content-center">
                    <div class="container" style="text-align: center;margin-top: 10px">
                      <br>
                      @include('layouts.alert')
                      <a data-toggle="modal" href='#modal-resepsionist'><img src="images/resepsionist.png" height="130px" width="130px;"></a>
                      <a data-toggle="modal" href='#modal-dokter'><img src="images/dokter.png" height="130px" width="130px;"></a>
                      <a data-toggle="modal" href='#modal-loket'><img src="images/loket.png" height="130px" width="130px;"></a>
                      <a data-toggle="modal" href='#modal-admin'><img src="images/admin.png" height="130px" width="130px;"></a>
                </div>
                  </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->
  <main id="main">


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <div  data-aos="fade-up" data-aos-delay="200">
            <h3>Master Klinik</h3>
            <p>
              Nganjuk, Jawa Timur <br>
            </p>
          </div>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <div  data-aos="fade-up" data-aos-delay="200">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a  data-toggle="modal" href="#modal-resepsionist">Resepsionist</a></li>
              <li><i class="bx bx-chevron-right"></i> <a data-toggle="modal" href="#modal-dokter">Dokter</a></li>
              <li><i class="bx bx-chevron-right"></i> <a data-toggle="modal" href="#modal-loket">Loket</a></li>
              <li><i class="bx bx-chevron-right"></i> <a data-toggle="modal" href="#modal-admin">Admin</a></li>
            </ul>
          </div>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <div  data-aos="fade-up" data-aos-delay="200">
            <h4>Social Networks</h4>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>Master Klinik</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    {{-- Modal resepsionist --}}
    <div class="modal fade" id="modal-resepsionist">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Login Resepsionist</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('login') }}" method="post">
              {{ csrf_field() }}
              {{-- <div style="text-align: center">
                <h5><strong>Demo</strong></h5>
                <p>Username: resepsionist | Password: resepsionist</p>
              </div> --}}
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="" class="form-control">
                <input type="hidden" name="level" id="" class="form-control" value="resepsionist">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- Modal dokter --}}
    <div class="modal fade" id="modal-dokter">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Login Dokter</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('login') }}" method="post">
              {{ csrf_field() }}
              {{-- <div style="text-align: center">
                <h5><strong>Demo</strong></h5>
                <p>Username: dokter | Password: dokter</p>
              </div> --}}
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="" class="form-control">
                <input type="hidden" name="level" id="" class="form-control" value="dokter">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
     {{-- Modal loket --}}
     <div class="modal fade" id="modal-loket">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Login Loket</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('login') }}" method="post">
              {{ csrf_field() }}
              {{-- <div style="text-align: center">
                <h5><strong>Demo</strong></h5>
                <p>Username: loket | Password: loket</p>
              </div> --}}
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="" class="form-control">
                <input type="hidden" name="level" id="" class="form-control" value="loket">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- Modal Admin --}}
    <div class="modal fade" id="modal-admin">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Login Admin</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('login') }}" method="post">
              {{ csrf_field() }}
              {{-- <div style="text-align: center">
                <h5><strong>Demo</strong></h5>
                <p>Username: admin | Password: admin</p>
              </div> --}}
              <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="" class="form-control">
                <input type="hidden" name="level" id="" class="form-control" value="admin">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    <script src="{{ URL::to('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::to('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
      <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  </body>
</html>