

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Chat - Log In</title>
    <meta content="" name="description">

    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/images/favicon.png" rel="icon">
    <link href="assets/images/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/landingpage/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/landingpage/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/landingpage/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/landingpage/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/landingpage/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/landingpage/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/landingpage/css/style2.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart - v1.4.0
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center mobile-nav-toggle">

        <div class="container">
            <div class="d-flex flex-column justify-content-center" style="align-items: center;text-align: center;">
                <h1 data-aos="fade-up" data-aos-delay="100">Log In</h1>
                <h2 data-aos="fade-up" data-aos-delay="200">Try Chatting Now</h2>
                <br>
                <form action="function.php" method="post" style="width:40vh;">
                    <input type="hidden" name="command" value="CHECK_USER">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <input type="text" class="form-control" placeholder="Username" id="first-name-icon" name="username" required>
                    </div>
                    <br>
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                        <input type="password" class="form-control" placeholder="Password" id="password-id-icon" name="password" required>
                    </div>
                    <br>
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="500">
                        <button class="btn btn-primary form-control" type="submit" name="password-reset-token">Log In</button>
                    </div>
                </form>
                <br>
                <div data-aos="fade-up" data-aos-delay="600">
                    <p>Don't have an account? <a href="auth-register.php"><b>Sign up</b></a>.</p>
                </div>
                <div class="copyright">
                    <p style="font-size: 12px;margin-top: 10px;">&copy; Copyright <strong><span>Jun</span></strong>. All Rights Reserved</p>
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/landingpage/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/landingpage/vendor/aos/aos.js"></script>
    <script src="assets/landingpage/vendor/php-email-form/validate.js"></script>
    <script src="assets/landingpage/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/landingpage/vendor/purecounter/purecounter.js"></script>
    <script src="assets/landingpage/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/landingpage/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/landingpage/js/main.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</body>

</html>
