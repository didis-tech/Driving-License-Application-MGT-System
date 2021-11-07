<?php
$getUnit = $conn->query("SELECT * FROM category where unit_id=1");
$unitRow = $getUnit->fetch_assoc();
$unitcharge = $unitRow['unit_charge'];
?>
<?php if (isset($_SESSION['userId'])) : ?>
    <?php
    $userId = $_SESSION['userId'];
    $getUser = $conn->query("SELECT * FROM user where user_id=$userId");
    $userRow = $getUser->fetch_assoc();
    ?>
    <center>
        <form method="POST" action="Flutterwave-Rave/processPayment.php" id="paymentForm">
            <input type="hidden" name="user_id" value="<?= $userId  ?>" />
            <input type="hidden" name="type_id" value="<?= $_GET['type'] ?>" />
            <input type="hidden" name="amount" value="<?= $unitcharge ?>" /> <!-- Replace the value with your transaction amount -->
            <input type="hidden" name="payment_options" value="card" /> <!-- Can be card, account, ussd, qr, mpesa, mobilemoneyghana  (optional) -->
            <input type="hidden" name="description" value="License fee" /> <!-- Replace the value with your transaction description -->
            <input type="hidden" name="title" value="GetLicensed" /> <!-- Replace the value with your transaction title (optional) -->
            <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
            <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
            <input type="hidden" name="email" value="<?= $userRow['email'] ?>" /> <!-- Replace the value with your customer email -->
            <input type="hidden" name="firstname" value="<?= $userRow['firstname'] ?>" /> <!-- Replace the value with your customer firstname (optional) -->
            <input type="hidden" name="pay_button_text" value="Complete Payment" /> <!-- Replace the value with the payment button text you prefer (optional) -->
            <input type="hidden" name="env" value="staging"> <!--  live or staging -->
            <button class="btn btn-success float-right"> <img src="assets/img/rave.png" alt="" srcset=""> <br> Pay License fee </button>
        </form>
    </center>

<?php endif; ?>