<?php
$page_name="receipt";
if (!$_GET['orderID']) {
  if (isset($_SESSION['store'])) {
      echo "<script>window.location = 'online-store.php';</script>";
  }else {
    echo "<script>alert('product.php');</script>";
  }
}else {

  if (!isset($_SESSION['store']))  {
	  $theStore="mySpotmart";
	  $storeImg="img/myspotmart1.png";
      require 'header.php';
  }else {
	  $theStore=$storeName;
	  $storeImg=$venddp;
    require 'store-header.php';
  }
}

  ?>

<?php
if (isset($_GET['delpro'])) {
    $delProId = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['delpro']);
    $delProduct = $ct->delProductByCart($delProId);
}
 ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartId = $_POST['cartId'];
    $quantity = $_POST['quantity'];
    $updateCart = $ct->updateCartQuantity($cartId, $quantity);
    if ($quantity <= 0) {
        $delProduct = $ct->delProductByCart($cartId);
    }
}

 ?>

  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <img src="../img/page-faq-ordering.webp" alt="fashion img">
    <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Checkout Page</h2>
        <ol class="breadcrumb">
          <li><a href="../index.html">Home</a></li>
          <li class="active">Checkout</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->
 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">
            <div class="row">
			<div class="col-md-2"></div>
              <div class="col-md-8">
                <div class="checkout-left">
                        
                            <div class="text-center">
							<div class="invoice-body">
         <section id="items">

           <table cellpadding="0" cellspacing="0">

             <tr>
               <th></th> <!-- Dummy cell for the row number and row commands -->
               <th>ITEM</th>
               <th>quantity</th>
               <th>price</th>
               <th>tax</th>
               <th>line_total</th>
             </tr>
             <?php
               $orderCode = $_GET['orderID'];
			   $_SESSION['orderCode'] = $_GET['orderID'];
               $order= $ct->payableAmount($orderCode);
               if ($order) {
                 $i=0;
                   $sum = 0;
                   while ($result = $order->fetch_assoc()) {
					   
                       $price = $result['price'];
                       $productName = $result['productName'];
                       $productImg = $result['image'];
                       $orderDate = $result['date'];
                       $orderStatus = $result['status'];
                       $quantity = $result['quantity'];
                       $sum = $sum + $price;
                   $i++;
               ?>
             <tr data-iterate="item">
               <td><?php echo $i ?></td> <!-- Don't remove this column as it's needed for the row commands -->
               <td> <div class="row">
                 <span class="col-sm-6"><img src="../img/products/<?php echo $productImg; ?>" alt="img" width="50%"></span>
                  <span class="col-sm-6" style="top:0;"><?php echo $productName ?></span>
               </div> </td>
               <td><?php echo $quantity ?></td>
               <td>&#8358;<?php echo $price/$quantity ?></td>
               <td>&#8358;<?php echo "0.00" ?></td>
               <td>&#8358;<?php $total =  $price;
                           echo number_format($total).".00"; ?></td>
             </tr>
 <?php }
 } ?>
           </table>

         </section>

         <section id="sums">

           <table cellpadding="0" cellspacing="0">
             <tr>
               <th>Subtotal:</th>
               <td>&#8358;<?php echo number_format($sum).".00"; ?></td>
               <td></td>
             </tr>

             <tr data-iterate="tax">
               <th>Tax:</th>
               <td><?php

                               $vat = $sum * 0;
               echo "&#8358;".number_format($vat).".00";
                            ?></td>
               <td></td>
             </tr>

             <tr class="amount-total">
               <th>Total:</th>
               <td>&#8358;<?php
                          $gTotal = $sum+$vat;
                      Session::set("gTotal", $gTotal);
                      echo number_format($gTotal).".00"; ?></td>
               <td>
                 <div class="currency">
                   <span>currency:</span> <span>&#8358;</span>
                 </div>
               </td>
             </tr>

             <!-- You can use attribute data-hide-on-quote="true" to hide specific information on quotes.
                  For example Invoicebus doesn't need amount paid and amount due on quotes  -->
             <tr data-hide-on-quote="true">
               <th>Order Status</th>
               <td><?php echo $orderStatus ?></td>
               <td></td>
             </tr>

             <tr data-hide-on-quote="true">
               <th>Amount due:</th>
               <td>&#8358;<?php
                          $gTotal = $sum+$vat;
                      Session::set("gTotal", $gTotal);
                      echo number_format($gTotal).".00"; ?></td>
               <td></td>
             </tr>

           </table>

         </section>

         <div class="clearfix"></div>


       </div>
        <form method="POST" action="processPayment.php" id="paymentForm">
            <input type="hidden" name="amount" value="<?=$gTotal?>" /> <!-- Replace the value with your transaction amount -->
            <input type="hidden" name="payment_options" value="card" /> <!-- Can be card, account, ussd, qr, mpesa, mobilemoneyghana  (optional) -->
            <input type="hidden" name="description" value="Item purchase" /> <!-- Replace the value with your transaction description -->
            <input type="hidden" name="logo" value="<?php echo $actual_link.$storeImg;?>" /> <!-- Replace the value with your logo url (optional) -->
            <input type="hidden" name="title" value="<?=$theStore?>" /> <!-- Replace the value with your transaction title (optional) -->
            <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
            <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
            <input type="hidden" name="email" value="<?=$email?>" /> <!-- Replace the value with your customer email -->
            <input type="hidden" name="firstname" value="<?=$name?>" /> <!-- Replace the value with your customer firstname (optional) -->
            <!--input type="hidden" name="lastname"value="<?=$name?>" /> <!-- Replace the value with your customer lastname (optional) -->
            <input type="hidden" name="phonenumber" value="<?php echo trimphoneno($phone)?>" /> <!-- Replace the value with your customer phonenumber (optional if email is passes) -->
            <input type="hidden" name="pay_button_text" value="Complete Payment" /> <!-- Replace the value with the payment button text you prefer (optional) -->
            <!input type="hidden" name="ref" value="MY_NAME_5a22a7f270abc8879" /> <!-- Replace the value with your transaction reference. It must be unique per transaction. You can delete this line if you want one to be generated for you. -->
            <input type="hidden" name="env" value="staging"> <!--  live or staging -->
            <input type="hidden" name="successurl" value="<?php echo $actual_link."paymentResponse.php?cmrId=$id";?>"> <!-- Put your success url here -->
            <input type="hidden" name="failureurl" value="<?php echo $actual_link."paymentResponse.php?cmrId=$id";?>"> <!-- Put your failure url here -->
            <input type="submit" class="btn btn-success float-right" value="Proceed" />
        </form>
		</div><br>
                </div>
              </div>
            </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->

		<script src="../js/jquery/popper.min.js"></script>
  <!-- Custom js -->
  <?php if(!isset($ckJquery)):?>
  <script src="../js/jquery/1.11.3/jquery.min.js"></script>
  <?php endif;?>
  <script src="../js/jquery/custom.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Bootstrap JavaScript -->
  <script src="../bootstrap45/js/bootstrap.bundle.min.js"></script>
<script src="../bootstrap45/js/bootstrap.js"></script>
<script src="../bootstrap45/js/bootstrap.min.js"></script>

    <script src="..//js/jQuery.print.js"></script>
<!-- To Slider JS -->
<script src="../js/sequence.js"></script>
<script src="../js/sequence-theme.modern-slide-in.js"></script>
<!-- notification -->
<script type="text/javascript" src="../js/Lobibox.js"></script>
<script type="text/javascript" src="../js/notification-active.js"></script>
<!-- slick slider -->
<script type="text/javascript" src="../js/slick.js"></script>
<!-- bootstrap notify -->
<script type="text/javascript" src="../js/bootstrap-notify.js"></script>

    <script src="../vendors/assets/plugins/light-gallery/js/lightgallery-all.min.js"></script>
    </body>
</html>