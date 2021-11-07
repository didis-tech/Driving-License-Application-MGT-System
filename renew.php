<?php
session_start();
require './resources/db_connect.php';
$getRenewal = $conn->query("SELECT * FROM `category` where unit_name='renewal'");
$r_row = $getRenewal->fetch_assoc();
$unitcharge = $r_row['unit_charge'];
$types = $conn->query("SELECT * FROM license_type");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Diving License Renewal</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="jquery-confirm-v3.3.4/demo/libs/bundled.css">
    <script src="jquery-confirm-v3.3.4/demo/libs/bundled.js"></script>


    <link rel="stylesheet" href="jquery-confirm-v3.3.4/demo/demo.css">
    <!-- <script src="assets/js/jquery-3.2.1.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="jquery-confirm-v3.3.4/css/jquery-confirm.css" />
    <script type="text/javascript" src="jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>
</head>

<body>

    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@GetLicensed.com">contact@GetLicensed.com</a></i>
                <i class="bi bi-phone d-flex align-items-center ms-4"><span>+234 813 000 0000</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
            </div>
        </div>
    </section>

    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="index.html">GetLicensed<span>.</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt=""></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto " href="./#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="./#about">About</a></li>
                    <li><a class="nav-link scrollto" href="./#services">Services</a></li>
                    <li><a class="nav-link  active" href="renew.php">Renew License</a></li>
                    <li class="dropdown"><a href="#"><span>Apply for new licence</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <?php foreach ($types as $key => $type) : ?>
                                <li><a href="javascript:void(0)" onclick="verify('<?php echo $type['type_id'] ?>')"><?php echo $type['type_name'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="./#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    <script type="text/javascript">
        function verify(params) {
            const type = params;
            $.confirm({
                title: 'Confirm!',
                columnClass: 'col-md-12',
                content: 'Do you have an existing license?',
                icon: 'fa fa-question-circle-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    yes: {
                        text: 'Yes, I have an existing license.',
                        btnClass: 'btn-red',
                        keys: [
                            'enter',
                            'shift'
                        ],
                        action: function() {
                            this.$content // reference to the content
                            window.location = `find-license.php?type=${type}`;
                        }
                    },
                    no: {
                        text: 'No, I don`t have any existing license',
                        btnClass: 'btn-blue',
                        keys: [
                            'enter',
                            'shift'
                        ],
                        action: function() {
                            this.$content // reference to the content
                            window.location = `apply.php?type=${type}`;
                        }
                    }
                }
            });
        }
        $('document').ready(function() {
            $('#payment').hide();
            <?php if (!isset($_SESSION['level'])) {
                echo "$('#nav-step1-tab').click();";
            } else {
                echo "$('#nav-tab a').removeClass('active');
        $('#nav-step3-tab').addClass('active');
        $('#nav-step3-tab').click();";
            }
            ?>

        })
    </script>
    <main id="main" data-aos="fade-up">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">

                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li>Application</li>
                    </ol>
                </div>


            </div>
        </section><!-- End Breadcrumbs -->

        <section id="licenseId" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" class="php-email-form" id="step1-form">
                            <div class="row">
                                <div class=" form-group">
                                    <input type="text" name="license" class="form-control" id="license" placeholder="Your license number" required>
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Apply</button><button type="reset" style="display:none" id="resetForm">reset</button></div>
                        </form>
                        <center id="payment">
                            <span id="details-span"></span>
                            <form method="POST" action="Flutterwave-Rave/processPayment.php" id="paymentForm">
                                <input type="hidden" name="license_id" id="license_id" required />
                                <input type="hidden" name="amount" value="<?= $unitcharge ?>" /> <!-- Replace the value with your transaction amount -->
                                <input type="hidden" name="payment_options" value="card" /> <!-- Can be card, account, ussd, qr, mpesa, mobilemoneyghana  (optional) -->
                                <input type="hidden" name="description" value="License renewal fee" /> <!-- Replace the value with your transaction description -->
                                <input type="hidden" name="title" value="GetLicensed" /> <!-- Replace the value with your transaction title (optional) -->
                                <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                                <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
                                <input type="hidden" name="email" value="info@getlicense.com" /> <!-- Replace the value with your customer email -->
                                <input type="hidden" name="env" value="staging"> <!--  live or staging -->
                                <button class="btn btn-success float-right"> <img src="assets/img/rave.png" alt="" srcset=""> <br> Pay License fee </button>
                            </form>
                        </center>
                    </div>
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <img src="assets/img/about.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <script type="text/javascript">
        $('#step1-form').submit(function(event) {

            // stop the form refreshing the page
            event.preventDefault();

            $('.form-group').removeClass('has-error'); // remove the error class
            $('.help-block').remove(); // remove the error text

            $.ajax({
                url: 'resources/checkLicense.php',
                data: $(this).serialize(),
                type: "POST",
                dataType: "json",
                success: function(data) {
                    $("#resetForm").click();
                    $.alert({
                        title: data.title,
                        icon: `fa ${data.icon}`,
                        type: data.type,
                        content: data.message,
                    });
                    if (data.expired) {
                        $('#details-span').html('Name: ' + data.name);
                        $('#step1-form').hide();
                        $('#payment').show();
                    }

                }
            });
        });
    </script>
    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h4>Join Our Newsletter</h4>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>GetLicensed<span>.</span></h3>
                        <p>
                            University of Nigeria <br>
                            Nsukka<br>
                            Nigeria<br><br>
                            <strong>Phone:</strong> +234 813 000 0000<br>
                            <strong>Email:</strong> info@getlicensed.com<br>
                        </p>
                    </div>

                    <div class="col-lg-6 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Social Networks</h4>
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

    </footer><!-- End Footer -->


    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>