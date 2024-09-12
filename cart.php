<?php
session_start();
// echo "<pre>";
// print_r($_SESSION['cart']);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/plugins/bootstrap/v5.3/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/plugins/font-awesome/v6.5/css/all.min.css">
      <link rel="stylesheet" href="assets/css/cart.css">
      <title>Cart</title>
   </head>
   <body>
      <div class="container breadcrumb d-flex justify-content-between pt-3">
         <div>
            <a href="shop.php">Shop</a> > Cart
         </div>
         <div>
            <a href="cart.php" class="ml-3 d-flex pt-2">
               <i class="fas fa-shopping-cart"></i>
               <span id="cartCount">0<span>
            </a>
         </div>
      </div>
      <main>
         <div class="container pt-5"><?php
            $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            if($cart_items): ?>
               <form action="checkout.php" method="POST" name="cartForm" id="cartForm">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="table-responsive">
                           <table class="table table-bordered">
                              <thead>
                                 <tr class="table-dark text-center">
                                    <th>Item</th>
                                    <th>Price (USD)</th>
                                    <th width="220">Quantity</th>
                                    <th>Cost (USD)</th>
                                    <th width="100">Remove</th>
                                 </tr>
                              </thead>
                              <form id="deleteForm<?= $cart_items[0]->id ?>"></form>
                                 <tbody><?php
                                    $subtotal = 0;
                                    foreach($_SESSION['cart'] as $i => $item): ?>
                                       <tr>
                                          <td>
                                             <img src="assets/imgs/thumbnails<?= $item->thumbnail ?>" width="70">
                                          </td>
                                          <td><?= $item->price ?></td>
                                          <td>
                                          <div class="input-group">
                                             <input type="number" name="<?= $i ?>" min="1" class="border border-opacity-50 rounded-0 fw-bold qty" data-price="<?= $item->price ?>" value="1">
                                          </div>
                                          </td>
                                          <td class="cost"><?= $item->price ?></td>
                                          <td>
                                             <form id="deleteForm<?= $item->id ?>">
                                                <button type="submit" onclick="deleteForm(<?= $item->id ?>, <?= $i ?>)" class="btn btn-sm btn-danger">
                                                   <i class='fa fa-times'></i>
                                                </button>
                                             </form>
                                          </td>
                                       </tr><?php
                                       $checkout = new stdClass();
                                       $checkout->id = $item->id;
                                       $checkout->name = $item->name;
                                       $checkout->price = $item->price;
                                       $checkout->thumbnail = $item->thumbnail;
                                       $_SESSION['checkout'][$i] = $checkout;

                                       $subtotal += $item->price;
                                    endforeach?>
                                 </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="card rounded-0">
                           <div class="card-body">
                              <div class="sub-title">
                                 <h2 class="bg-white mb-3">Cart Summery</h3>
                              </div> 
                              <div class="d-flex justify-content-between pb-2">
                                 <div class="h5 mt-3 mb-3">Sub Total:</div>
                                 <span class="h5 mt-3 mb-3" id="subtotal"><?= $subtotal ?> $</span>
                              </div>
                              <div class="pt-2 text-center">
                                 <button type="submit" class="btn btn-dark border rounded-0 px-3 py-3" onclick="cartFrom()">Proceed to Checkout</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            <?php else: ?>
               <div class="text-center mt-5 fs-2">Cart Empty</div>
            <?php endif ?>
         </div>
      </main>
      <script src="assets/plugins/bootstrap/v5.3/js/bootstrap.bundle.min.js"></script>
      <script src="assets/plugins/jquery/v3.7/jquery.min.js"></script>
      <script src="assets/plugins/font-awesome/v6.5/js/all.min.js"></script>
      <script src="assets/plugins/sweet-alert/sweetalert.all.js"></script>
      <script>
            function cartForm(){
               document.querySelector('#cartForm').submit();
            }

            function deleteForm(id, i) {
               $('#deleteForm' + id).submit(function(e){
                  e.preventDefault();
                  var element = $(this);

                  $.ajax({
                     url: 'actions/delete_from_cart.php',
                     type: 'POST',
                     data: {i:i},
                     dataType: 'json',
                     success: function(data, status, jqXHR){
                        Swal.fire({
                           toast: true,
                           icon: data.type,
                           title: data.message,
                           position: 'top',
                           timer: 2000,
                           showConfirmButton: false,
                           showCloseButton: true,
                           timerProgressBar: false,
                        }).then(() => {
                           window.location.href = 'cart.php';
                        });
                     },
                     error: function(jqXHR){
                        console.log(jqXHR);
                     },
                  });
               });
            }

            function cart_count() {
               const cartCountElement = document.getElementById('cartCount');
               cartCountElement.textContent = <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>;
            }
            cart_count()

            $('.qty').change(function(){
               let qty = $(this).val();
               let price = $(this).data('price');
               let cost = qty * price;

               $(this).closest('tr').find('.cost').text(cost);

               let subtotal = 0;
               $('.cost').each(function(){
                  subtotal += parseFloat($(this).text());
               });
               $('#subtotal').text(subtotal+' $');
            });
      </script>
   </body>
</html>