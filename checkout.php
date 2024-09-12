<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header('Location: cart.php');
   exit();
}

if(isset($_SESSION['checkout'])){
   foreach ($_POST as $key => $value) {
      foreach ($_SESSION['checkout'] as $index => $infos) {
         if ($key == $index){
            $_SESSION['checkout'][$index]->qty = $value;
         }
      }
   }
}
// echo '<pre>';
// print_r($_SESSION['checkout']);
// echo '</pre>';

include "config/connect.php";

$shipping_charges = $database->prepare('SELECT * FROM shipping_charges');
$shipping_charges->execute();
$shipping_charges = $shipping_charges->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/plugins/bootstrap/v5.3/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/plugins/font-awesome/v6.5/css/all.min.css">
      <link rel="stylesheet" href="assets/css/checkout.css">
      <title>Checkout</title>
   </head>
   <body>
      <div class="container breadcrumb d-flex justify-content-between pt-3">
         <div>
            <a href="shop.php">Shop</a> > Checkout
         </div>
         <div>
            <a href="cart.php" class="ml-3 d-flex pt-2">
               <i class="fas fa-shopping-cart"></i>
               <span id="cartCount">0<span>
            </a>
         </div>
      </div>
      <main>
         <div class="container pt-5">
            <form method="POST" action="actions/save_order.php" name="orderForm" id="orderForm">
               <div class="row">
                  <div class="col-md-8">
                     <div class="sub-title">
                        <h2>Shipping Address</h2>
                     </div>
                     <div class="card shipping-address shadow-lg border-0">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" autocomplete="off" >
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" autocomplete="off" >
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off" >
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." autocomplete="off" >
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <select name="shipping_amount" id="shipping_amount" class="form-control shipping_amount" >
                                       <option value="0">Select a wilaya</option><?php
                                       foreach ($shipping_charges as $shipping_charge):
                                          echo
                                          '<option value="'.$shipping_charge->amount.'" data-wilaya="'.$shipping_charge->wilaya.'">
                                             '.$shipping_charge->code.
                                             ' - '
                                             .$shipping_charge->wilaya.
                                          '</option>';
                                       endforeach?>
                                    </select>
                                    <input type="hidden" name="wilaya" id="wilaya" value="">
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control" ></textarea>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="mb-3">
                                    <textarea name="notes" id="notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="sub-title">
                        <h2>Order Summery</h3>
                     </div>
                     <div class="card order-summery">
                        <div class="card-body"><?php
                           $subtotal = 0;
                           $shipping_charge = 0;
                           $discount_amount = 0;
                           foreach($_SESSION['checkout'] as $item): ?>
                              <div class="d-flex justify-content-between pb-2">
                                 <div class="h6"><?= $item->name ?>  X <?= $item->qty ?></div>
                                 <div class="h6"><?= $item->price * $item->qty ?> $</div>
                              </div><?php
                              $subtotal += $item->price * $item->qty;
                           endforeach;
                           $total = $subtotal + $shipping_charge - $discount_amount; ?>
                           <div class="d-flex justify-content-between summery-subtotal">
                              <div class="h6 fw-bold">Subtotal</div>
                              <input type="text" name="subtotal" id="subtotal" value="<?= $subtotal ?> $" class="h6 fw-bold" readonly>
                           </div>
                           <div class="d-flex justify-content-between mt-2 summery-shipping">
                              <div class="h6 fw-bold">Shipping</div>
                              <input type="text" name="shipping_charge" id="shipping_charge" value="<?= $shipping_charge ?> $" class="h6 fw-bold" readonly>
                           </div>
                           <div class="d-flex justify-content-between mt-2 summery-discount">
                              <div class="h6 fw-bold">Discount</div>
                              <input type="text" name="discount_amount" id="discount_amount" value="<?= $discount_amount ?> $" class="h6 fw-bold" readonly>
                           </div>
                           <div class="d-flex justify-content-between mt-2 summery-total">
                              <div class="h5 fw-bold">Total</div>
                              <input type="text" name="total" id="total" value="<?= $total ?> $" class="h5 fw-bold" readonly>
                           </div>
                        </div>
                     </div>
                     <div class="input-group apply-coupon mt-3">
                        <input type="text" name="coupon_code" id="coupon_code" placeholder="Coupon Code" class="form-control" autocomplete="off">
                        <button class="btn btn-dark" type="button" id="applyCoupon">Apply Coupon</button>
                     </div>
                     <small>* Try (PROMO50) or (PROMO100)</small>
                     <div id="discount_HTML"></div>
                     <div class="card payment-method mt-3 p-3">
                        <h3 class="card-title h5 mb-3">Payment Method</h3>
                        <div>
                           <input type="radio" name="payment_method" id="method_one" value="cod" checked>
                           <label for="method_one" class="form-check-label">COD</label>
                        </div>
                     </div>
                     <div class="my-3">
                        <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </main>
      <script src="assets/plugins/bootstrap/v5.3/js/bootstrap.bundle.min.js"></script>
      <script src="assets/plugins/jquery/v3.7/jquery.min.js"></script>
      <script src="assets/plugins/font-awesome/v6.5/js/all.min.js"></script>
      <script src="assets/plugins/sweet-alert/sweetalert.all.js"></script>
      <script>
         function cart_count() {
            const cartCountElement = document.getElementById('cartCount');
            cartCountElement.textContent = <?= isset($_SESSION['checkout']) ? count($_SESSION['checkout']) : 0 ?>;
         }
         cart_count()

         $("#applyCoupon").click(function(){
            var element = $(this);

            $.ajax({
               url: 'actions/apply_coupon.php',
               type: 'POST',
               data: {coupon_code: $('#coupon_code').val(), subtotal: <?= $subtotal ?>},
               dataType: 'json',
               success: function(response){
                  let shipping_amount_value = $('.shipping_amount').val();
                  let shipping_amount = shipping_amount_value.replace(' $', '');
                  $('#discount_amount').val(response.discount_amount+' $');
                  $('#discount_HTML').html(response.discount_HTML);

                  let total = parseInt(response.total) + parseInt(shipping_amount);
                  $('#total').val(total+' $');
               }
            });
         });

         $('body').on('click', '#removeCoupon', function(){
            $.ajax({
               url: 'actions/remove_coupon.php',
               type: 'POST',
               data: {},
               dataType: 'json',
               success: function(response){
                  $('#coupon_code').val('');
                  $('#discount_amount').val(response.discount_amount+' $');
                  $('#discount_HTML').html(response.discount_HTML);

                  let subtotal = <?= $subtotal ?>;
                  let shipping_amount = $('.shipping_amount').val();
                  let total = parseInt(subtotal) + parseInt(shipping_amount);
                  $('#total').val(total+' $');
               }
            });
         });

         $('.shipping_amount').change(function(){
            $("#applyCoupon").click(function(){
               var element = $(this);

               $.ajax({
                  url: 'actions/apply_coupon.php',
                  type: 'POST',
                  data: {coupon_code: $('#coupon_code').val(), subtotal: <?= $subtotal ?>},
                  dataType: 'json',
                  success: function(response){
                     $('#discount_amount').val(response.discount_amount+' $');
                     $('#discount_HTML').html(response.discount_HTML);

                  }
               });
            });

            let shipping_amount = $(this).val();
            let selected_option = $(this).find('option:selected');
            let discount_amount = $('#discount_amount').val();
            let wilaya = selected_option.data('wilaya');
            let subtotal = <?= $subtotal ?>;

            let total = parseInt(subtotal) + parseInt(shipping_amount) - parseInt(discount_amount)
            
            $('#wilaya').val(wilaya);
            $('#subtotal').val(subtotal+' $');
            $('#shipping_charge').val(shipping_amount+' $');
            $('#discount_amount').val(discount_amount);
            $('#total').val(total+' $');
         });
      </script>
   </body>
</html>