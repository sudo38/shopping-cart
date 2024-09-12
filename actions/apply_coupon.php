<?php
session_start();

if(isset($_POST['coupon_code'])){
   $coupon_code = $_POST['coupon_code'];
   $subtotal = $_POST['subtotal'];

   include "../config/connect.php";

   $discount_coupon = $database->prepare('SELECT * FROM discount_coupons WHERE code = :code');
   $discount_coupon->bindParam('code', $coupon_code);
   $discount_coupon->execute();
   if ($discount_coupon->rowCount() == 0){

   }
   $discount_coupon = $discount_coupon->fetch(PDO::FETCH_OBJ);

   if ($discount_coupon->type == 'percent') {
      $discount_amount = ($discount_coupon->amount * $subtotal)/100;
   } else {
      $discount_amount = $discount_coupon->amount;
   }

   $total = $subtotal - $discount_amount;

   $discount_HTML = '
      <div class="mt-4">
         <strong>'.$coupon_code.'</strong>
         <a class="btn btn-sm btn-danger" id="removeCoupon">
            <i class="fa fa-times"></i>
         </a>
      </div>
   ';


   echo json_encode([
      'total' => $total,
      'discount_amount' => $discount_amount,
      'discount_HTML' => $discount_HTML,
   ]);
}