<?php
session_start();
require '../resources/db_connect.php';
 ?>
 <?php
 include '../lib/Session.php';
 Session::init();
 include '../lib/Database.php';
 include '../helpers/Format.php';
 // include 'classes/Product2.php';
 // include 'classes/Cart.php';

 spl_autoload_register(function ($class) {
     include_once "../classes/".$class.".php";
 });
 $db = new Database();
 $fm = new Format();
 $pd = new Product();
 $ct = new Cart();
 $cat = new Category();
 $cmr = new Customer();

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>mySpotmart</title>
    <link rel="icon" type="image/png" href="../img/myspotmart1.png">
    <!-- Font awesome -->
    <link rel="stylesheet" href="../web-fonts-with-css/css/all.css">
	<link rel="stylesheet" href="../web-fonts-with-css/css/brands.css">
	<link rel="stylesheet" href="../web-fonts-with-css/css/fontawesome.css">
	<link rel="stylesheet" href="../web-fonts-with-css/css/svg-with-js.css">
	<link rel="stylesheet" href="../web-fonts-with-css/css/regular.css">
	<link rel="stylesheet" href="../web-fonts-with-css/css/solid.css">
	<link rel="stylesheet" href="../web-fonts-with-css/css/v4-shims.css">
    <!-- Bootstrap -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap45/css/bootstrap.css">
    <link rel="stylesheet" href="../bootstrap45/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap45/css/bootstrap-grid.css">
    <link rel="stylesheet" href="../bootstrap45/css/bootstrap-reboot.css">
    <link rel="stylesheet" href="../bootstrap45/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="../bootstrap45/css/bootstrap-reboot.min.css">

    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="../css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- notifications -->
    <link rel="stylesheet" type="text/css" href="../css/Lobibox.min.css">
    <link rel="stylesheet" type="text/css" href="../css/notifications.css">
    <!-- slick slider -->
	
    <link rel="stylesheet" type="text/css" href="../css/slick.css">
    <!-- animate -->
    <link rel="stylesheet" type="text/css" href="../css/animate.css">
    <!-- Theme color -->
    <link id="switcher" href="../css/theme-color/gradient-theme.css" rel="stylesheet">
    <!-- <link id="switcher" href="css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="../css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">
	
    <!-- Main style sheet -->
    <link href="../css/style.css" rel="stylesheet">
<?php if(isset($page_name)){
echo '<link rel="stylesheet" href="../css/template.css">';
}
?>
      

<style media="screen">

</style>
<script src="../js/jquery/jquery-3.5.1.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>
  <body>
    <?php if (!isset($page_name) && !isset($ckJquery)): ?>
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
                <!-- start language -->
                <div class="aa-language">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-expanded="false">
                      <img src="../img/flag/english.jpg" alt="english flag">ENGLISH

                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <a class="dropdown-item" href="#"><img src="../img/flag/french.jpg" alt="">FRENCH</a>
                      <a class="dropdown-item" href="#"><img src="../img/flag/english.jpg" alt="">ENGLISH</a>
                    </div>
                  </div>
                </div>
                <!-- / language -->

                <!-- start currency -->
                <div class="aa-currency">
                  <div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-expanded="false">
                      <i class="fa fa-usd"></i>USD

                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                      <a class="dropdown-item" href="#"><i class="fa fa-euro"></i>EURO</a>
                      <a class="dropdown-item" href="#"><i class="fa fa-jpy"></i>YEN</a>
                    </div>
                  </div>
                </div>
                <!-- / currency -->
                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p> <a href="tel:08043307959"><span class="fa fa-phone"></span>0804-330-7959</a> </p>
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
				<?php if (isset($vendorPage)) {
					echo '<li><a href="../vendors-signin.php">Sign-In</a></li>';
					}else{
                   if (isset($_SESSION['cuslogin']) && isset($_SESSION['customer']) && $_SESSION['customer'] === true) {
                    require '../resources/fetch.php';
                   ?>
                  <li><a href="../profile.php">My Account</a></li>
                  <?php $cmrId = Session::get("cmrId");
                                          $checkWlist = $pd->getWlistData($cmrId);
                                          if ($checkWlist) {
                                              ?>
                  <li class="hidden-xs"><a href="../wishlist.php">Wishlist</a></li>
                  <?php
                                          } ?>
                                          <?php $cmrId = Session::get("cmrId");
                                                                  $getPd = $pd->getCompareData($cmrId);
                                                                  if ($getPd) {
                                                                      ?>
                  <li class="hidden-xs"><a href="../compare.php">Compare</a> </li>
                                          <?php
                                                                  }?>
                  <li class="hidden-xs"><a href="../cart.php">My Cart</a></li>

                  <li class=""><div class="dropdown">
                    <a class="btn dropdown-toggle" href="#" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" aria-expanded="false">
                      <span><?php echo "$name"; ?></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <a class="dropdown-item" href="../profile.php"><span class="fa fa-user-o"></span> Account</a>
                      <a class="dropdown-item" href="?cid=<?php Session::get('cmrId'); ?>"><span class="fa fa-sign-out"></span> Signout</a>
                    </div>
                  </div> </li>
                <?php }elseif (isset($_SESSION['is-admin-logged']) && isset($_SESSION['admin']) && $_SESSION['admin'] === true) {

                 ?>
                <li><a href="00oakadmin">My Account</a></li>
              <?php }elseif (isset($_SESSION['is-user-logged']) && isset($_SESSION['vendor']) && $_SESSION['vendor'] === true) {

               ?>
              <li><a href="vendors">My Account</a></li>
            <?php }else {
             ?>
            <li><a href="./account.php">My Account</a></li>
            <li><a href="" data-toggle="modal" data-target="#login-modal">Login</a></li>
				<?php }} ?>
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
                  <span class="splogo"><img src="../img/myspotmart1.png" alt="logo img" width="150"></span> <br>
                  <p style="color: #0f1f3d;">mysp<i class="fa fa-map-marker-alt" width="41"></i>t<strong>mart</strong> <span>Your Shopping Partner</span></p>
                </a>
                <!-- img based logo -->
                <!-- <a href="index.php"><img src="img/logo.jpg" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->
               <!-- cart box -->
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="../cart.php">
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
  <section id="menu" style="background: url(../img/1.jpg);background-size:cover;">
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
              <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Products</a>
                <ul class="sub-menu">
                  <?php $category=$conn->query("SELECT * FROM `product_category`"); ?>
                  <?php foreach ($category as $key => $ctgy): ?>
                    <li><a href="../product.php?ctgyId=<?php echo $ctgy['cty_id'] ?>"><?php echo $ctgy['cty_tittle'] ?></a></li>
                  <?php endforeach; ?>
                </ul></li>
              <li class="nav-item"><a class="nav-link" href="../blog-archive.php">Blog</a>
              </li>
              <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
  </section>
  <!-- / menu -->
