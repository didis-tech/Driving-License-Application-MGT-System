<?php
session_start();
require 'resources/db_connect.php';
 ?>
 <?php
 include 'lib/Session.php';
 Session::init();
 include 'lib/Database.php';
 include 'helpers/Format.php';
 // include 'classes/Product2.php';
 // include 'classes/Cart.php';

 spl_autoload_register(function ($class) {
     include_once "classes/".$class.".php";
 });
 $db = new Database();
 $fm = new Format();
 $pd = new Product();
 $ct = new Cart();
 $cat = new Category();
 $cmr = new Customer();

  ?>
  <?php if (!isset($_SESSION['store'])) {
      echo "<script>window.location = 'index.php';</script>";
  }else {
    $store=$_SESSION['store'];
    $sql = "SELECT * FROM category INNER JOIN vendors ON category.ctgy_id=vendors.cat where vendors.storeName = '$store'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
      while($row = $result->fetch_assoc()) {
      $vendId = $row['ven_id'];
      $vendName = $row['ven_username'];
      $vendEmail = $row['ven_email'];
      $vendphone = $row['ven_tel'];
      $vendphone2 = $row['ven_tel2'];
      $vendaddress = $row['ven_address'];
      $vendcamp = $row['ven_school'];
	  $vendbio = $row['bio'];
      $vendgender = $row['gender'];
      $vendstatus = $row['status'];
      $vendstate = $row['state'];
      $vendlga = $row['lga'];
      $storeName = $row['storeName'];
      $vendadp = $row['ven_pic'];
      $venddp = "assets/img/profiles/$vendadp";
      $logged = $row['ven_logged'];
      $company = $row['company_name'];
      $ctgy = $row['cat'];
      $ctgy_name = $row['ctgy_name'];
      $ctgy_duration = $row['ctgy_duration'];
      $ctgy_slug = $row['ctgy_slug'];
    $date = $row['ven_created_at'];
    }}
  }
  if (isset($_GET['pageno'])) {
$pageno = $_GET['pageno'];
}else {
$pageno = 1;
}
$no_of_records_per_page = 12;
$offset = ($pageno-1) * $no_of_records_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM tbl_product where vendor ='".$vendId."'";
$tp_result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($tp_result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$count = 1;
$salequery=$conn->query("SELECT * FROM tbl_product where vendor ='".$vendId."' order by product_date desc LIMIT $offset, $no_of_records_per_page");?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $company ?> on mySpotmart</title>
    <link rel="icon" type="image/png" href="img/myspotmart1.png">
    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap45/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap45/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap45/css/bootstrap-grid.css">
    <link rel="stylesheet" href="bootstrap45/css/bootstrap-reboot.css">
    <link rel="stylesheet" href="bootstrap45/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="bootstrap45/css/bootstrap-reboot.min.css">

    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- notifications -->
    <link rel="stylesheet" type="text/css" href="css/Lobibox.min.css">
    <link rel="stylesheet" type="text/css" href="css/notifications.css">
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- animate -->
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/gradient-theme.css" rel="stylesheet">
    <!-- <link id="switcher" href="css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">

<style media="screen">
@import url(web-fonts-with-css/css/brands.css);
@import url(web-fonts-with-css/css/fontawesome.css);
@import url(web-fonts-with-css/css/fontawesome-all.css);
@import url(web-fonts-with-css/css/regular.css);
@import url(web-fonts-with-css/css/solid.css);
@import url(web-fonts-with-css/css/v4-shims.css);
/*Metro Background color class*/
.bg_lb{ background:#27a9e3;}
.bg_db{ background:#2295c9;}
.bg_lg{ background:#28b779;}
.bg_dg{ background:#28b779;}
.bg_ly{ background:#ffb848;}
.bg_dy{ background:#da9628;}
.bg_ls{ background:#2255a4;}
.bg_lo{ background:#da542e;}
.bg_lr{ background:#f74d4d;}
.bg_lv{ background:#603bbc;}
.bg_lh{ background:#b6b3b3;}
.splogo{
  animation: bounce2 2s, 2s bouncer 4.2s infinite;}

.pin-effect {
    animation: pulsate 2400ms ease-out infinite;

}
.pin{
  width: 30px;
  position: absolute;
  left: 50%;
  top: 50%;
  animation-name: bounce;
  animation-fill-mode: both;
  animation-duration: 0.5s;
  height: 30px;
  border-radius: 50% 50% 50% 0;
  background: #89849b;
  transform: rotate(-45deg);
margin: -20px 0 0 -20px;}
  &:after{
    content: '';
    width: 14px;
    height: 14px;
    margin: 8px 0 0 8px;
    background: #2F2F2F;
    position: absolute;
    border-radius: 50%;
  }
.pulse{
  background: rgba(0,0,0,0.2);
  border-radius: 50%;
  height: 14px;
  width: 14px;
  position: absolute;
  left: 50%;
  top: 50%;
  margin: 11px 0px 0px -12px;
  transform: rotateX(55deg);
   z-index: -2;}
  .pulse:after{
    content: "";
    border-radius: 50%;
    height: 40px;
    width: 40px;
    position: absolute;
    margin: -13px 0 0 -13px;
    animation: pulsate 1s ease-out;
    animation-iteration-count: infinite;
    opacity: 0.0;
    box-shadow: 0 0 1px 2px #89849b;
    animation-delay: 0.6s;
}

@keyframes bouncer{
  0%,
  25%,
  50%,
  70%,
  100%{
  transform: translateY(0);}
  40%{
  transform: translateY(-20px);}
  60%{
  transform: translateY(-12px);}}
  @keyframes bounce{
  0%{
    opacity: 0;
  transform: translateY(-2000px) rotate(-45deg);}
  60%{
    opacity: 1;
  transform: translateY(30px) rotate(-45deg);}
  80%{
  transform: translateY(-10px) rotate(-45deg);}
  100%{
    transform: translateY(0) rotate(-45deg);
  }}
@keyframes bounce2{
  0%{
    opacity: 0;
  transform: translateY(-2000px);}
  60%{
    opacity: 1;
  transform: translateY(30px);}
  80%{
  transform: translateY(-10px);}
  100%{
    transform: translateY(0);
    animation-name: bouncer;
    animation-iteration-count: infinite;
  }}

  @keyframes pulsate {
      0% {
      transform: scale(0.1);
      opacity: 0;
      }
      50% {
      opacity: 1;
      }
      100% {
      transform: scale(1.2);
      opacity: 0;
      }
  }
.fade.in {
opacity: 1;
}
@media (max-width: 767px) {
  .hidden-xs {
    display: none !important;
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  .hidden-sm {
    display: none !important;
  }
}
@media (min-width: 992px) and (max-width: 1199px) {
  .hidden-md {
    display: none !important;
  }
}
@media (min-width: 1200px) {
  .hidden-lg {
    display: none !important;
  }
}
.watermark{
  width:100%;
  height: 100%;
  background: url(img/msmwatermark.png) center center no-repeat;
}
</style>
<script src="js/jquery-3.3.1.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>
  <body>
    <?php if (!isset($page_name)): ?>
      <!-- wpf loader Two -->
       <div class="container-fluid2"  id="wpf-loader-two">
         <div class='pin'>
     </div>
       <div class='pulse'></div>

       </div>
       <!-- / wpf loader Two -->
    <?php endif; ?>

  <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->


  <!-- Start header section -->
  <header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
              <!-- start header top left -->
              <div class="aa-header-top-left">



                <!-- / currency -->
                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p> <a href="tel:<?php echo $vendphone ?>"><span class="fa fa-phone"></span><?php echo $vendphone ?></a> </p>
                </div>
                <!-- / cellphone -->
              </div>
              <?php
                    if (isset($_GET['cid'])) {
                        $cmrId = Session::get("cmrId");
                        $delData = $ct->delCustomerCart();
                        $delComp = $pd->delCompareDara($cmrId);
                        Session::destroy();
                    }
                     ?>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                  <?php if (isset($_SESSION['cuslogin']) && isset($_SESSION['customer']) && $_SESSION['customer'] === true) {
                    require 'resources/fetch.php';
                   ?>
                  <li><a href="profile.php">My Account</a></li>
                  <?php $cmrId = Session::get("cmrId");
                                          $checkWlist = $pd->getWlistData($cmrId);
                                          if ($checkWlist) {
                                              ?>
                  <li class="hidden-xs"><a href="wishlist.php">Wishlist</a></li>
                  <?php
                                          } ?>
                                          <?php $cmrId = Session::get("cmrId");
                                                                  $getPd = $pd->getCompareData($cmrId);
                                                                  if ($getPd) {
                                                                      ?>
                  <li class="hidden-xs"><a href="compare.php">Compare</a> </li>
                                          <?php
                                                                  }?>
                  <li class="hidden-xs"><a href="cart.php">My Cart</a></li>

                  <li class=""><div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-expanded="false">
                      <span><?php echo "$name"; ?></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <a class="dropdown-item" href="#"><span class="fa fa-user-o"></span> Account</a>
                      <a class="dropdown-item" href="?cid=<?php Session::get('cmrId'); ?>"><span class="fa fa-sign-out"></span> Signout</a>
                    </div>
                  </div> </li>
                <?php }elseif (isset($_SESSION['admin-login']) && isset($_SESSION['admin']) && $_SESSION['admin'] === true) {

                 ?>
                <li><a href="00oakadmin">My Account</a></li>
              <?php }elseif (isset($_SESSION['is-user-logged']) && isset($_SESSION['vendor']) && $_SESSION['vendor'] === true) {

               ?>
              <li><a href="vendors">My Account</a></li>
            <?php }else {
             ?>
            <li><a href="./account.php">My Account</a></li>
            <li><a href="" data-toggle="modal" data-target="#login-modal">Login</a></li>
          <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
                <a href="#">
                  <span class="splogo"><img src="vendors/<?php echo $venddp ?>" alt="logo img" width="150"></span> <br>
                  <p style="color: #0f1f3d;"><?php echo $company ?> <span>Your Shopping Partner</span></p>
                </a>
                <!-- img based logo -->
                <!-- <a href="index.php"><img src="img/logo.jpg" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->
               <!-- cart box -->
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="cart.php">
                  <span class="fa fa-shopping-cart"></span>
                  <span class="aa-cart-title">SHOPPING CART</span>
                  <span class="aa-cart-notify"><?php
                                        $getData = $ct->checkCartItem();
                                        if ($getData) {
                                            $sum = Session::get("gTotal");
                                            $qty = Session::get("qty");
                                            echo $qty;
                                        } else {
                                            echo '0';
                                        }

                                         ?></span>
                </a>  <?php if (isset($_SESSION['cuslogin']) && isset($_SESSION['customer']) && $_SESSION['customer'] === true) {

                   ?>
                <div class="aa-cartbox-summary">
                  <ul>
                    <?php
                                      $getPro = $ct->getCartProduct();
                                      if ($getPro) {
                                          $i=0;
                                          $sum = 0;
                                          $qty = 0;
                                          while ($result = $getPro->fetch_assoc()) {
                                              $i++; ?>
                    <li>
                      <a class="aa-cartbox-img" href="#"><img src="img/products/<?php echo $result['image']; ?>" alt="img"></a>
                      <div class="aa-cartbox-info">
                        <h4><a href="#"><?php echo $result['productName']; ?></a></h4>
                        <p><?php echo $result['quantity']; ?> x &#8358;<?php echo $result['price']; ?></p>
                      </div>
                      <a class="aa-remove-product" onclick="Lobibox.confirm({title:'Delete Product from Cart',msg: 'Are you sure to delete?',callback: function($this, type, ev){ if(type == 'yes'){ window.location = 'cart.php?delpro=<?php echo $result['cartId']; ?>';}}});" href="javascript:void(0);"><span class="fa fa-times"></span></a>
                    </li>


                    <li>
                      <span class="aa-cartbox-total-title">
                        Total
                      </span>
                      <span class="aa-cartbox-total-price">
                        &#8358;<?php $total =  $result['price'] * $result['quantity'];
                                    echo number_format($total).".00"; ?>
                      </span>
                    </li>
                    <?php
                                      }
                                  } ?>
                  </ul>
                  <a class="aa-cartbox-checkout aa-primary-btn" href="checkout.php">Checkout</a>
                </div><?php } ?>
              </div>
              <!-- / cart box -->
              <!-- search box -->
              <div class="aa-search-box">
                <form action="">
                  <input type="text" name="" id="" placeholder="Search here ex. 'man' ">
                  <button type="submit"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->
   <!-- menu -->
  <section id="menu" style="background: url(img/1.jpg);background-size:cover;">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default navbar-expand-lg" role="navigation" >
          <div class="navbar-header">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse"aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="fa fa-bars"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse main-menu">
            <!-- Left nav -->
            <ul class="nav navbar-nav mr-auto">
              <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
              <?php if ($ctgy_slug == 'products_services') {
echo '<li class="nav-item"><a class="nav-link" href="service-page.php?serviceID='.$vendId.'">Gallery</a></li>
<li class="nav-item"><a class="nav-link" href="shopping.php?store='.$storeName.'">Store</a></li>';
}?>
              <li class="nav-item"><a class="nav-link" href="exit-store.php">Checkout other products</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  </section>
  <!-- / menu -->
