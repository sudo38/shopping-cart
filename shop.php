<?php
session_start();
// unset($_SESSION['cart']);
// unset($_SESSION['checkout']);

// echo '<pre>';
// print_r($_SESSION['checkout']);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/plugins/bootstrap/v5.3/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/plugins/font-awesome/v6.5/css/all.min.css">
      <link rel="stylesheet" href="assets/css/shop.css">
      <title>Shop</title>
   </head>
   <body>
      <div class="container breadcrumb d-flex justify-content-between pt-3">
         <div><a href="shop.php">Shop</a></div>
         <div>
            <a href="cart.php" class="ml-3 d-flex pt-2">
               <i class="fas fa-shopping-cart"></i>
               <span id="cartCount">0<span>
            </a>
         </div>
      </div>
      <main>
         <div class="container pt-5">
            <div class="row">
               <div class="col-md-12">
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                           <tr class="table-dark text-center">
                              <th width="70">#</th>
                              <th>Thumbnail</th>
                              <th>Product</th>
                              <th>Price (USD)</th>
                              <th width="100">Action</th>
                           </tr>
                        </thead><?php
                        include "config/connect.php";
         
                        $products = $database->prepare('SELECT * FROM products');
                        $products->execute();
                        $products = $products->fetchAll(PDO::FETCH_OBJ);
         
                        foreach($products as $i => $product): ?>
                           <tbody>
                              <tr>
                                 <td class="fw-bold"><?= $i+1 ?></td>
                                 <td>
                                    <img src="assets/imgs/thumbnails/<?= $product->thumbnail ?>" width="70">
                                 </td>
                                 <td>
                                    <div class="h6 mx-3"><?= $product->name ?></div>
                                 </td>
                                 <td class="fw-bold"><?= $product->price ?></td>
                                 <td>
                                    <form class="add_to_cart">
                                       <input type="hidden" name="id" value="<?= $product->id ?>">
                                       <input type="hidden" name="name" value="<?= $product->name ?>">
                                       <input type="hidden" name="price" value="<?= $product->price ?>">
                                       <input type="hidden" name="thumbnail" value="<?= $product->thumbnail ?>">
                                       <button type="submit" class="btn btn-sm btn-primary">
                                          <i class='fa fa-plus'></i>
                                       </button>
                                    </form>
                                 </td>
                              </tr>
                           </tbody><?php
                        endforeach ?>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </main>
      <script src="assets/plugins/bootstrap/v5.3/js/bootstrap.bundle.min.js"></script>
      <script src="assets/plugins/font-awesome/v6.5/js/all.min.js"></script>
      <script src="assets/plugins/jquery/v3.7/jquery.min.js"></script>
      <script src="assets/plugins/sweet-alert/sweetalert.all.js"></script>
      <script>
         $(document).ready(function(){
            function cart_count() {
               const cartCountElement = document.getElementById('cartCount');
               cartCountElement.textContent = <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>;
            }
            cart_count()

            $(".add_to_cart").submit(function(e){
               e.preventDefault();
               $("button[type=submit]").prop('disabled', true);
               var element = $(this);

               $.ajax({
                  url: 'actions/add_to_cart.php',
                  type: 'POST',
                  data: element.serializeArray(),
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
                        window.location.href = 'shop.php';
                     });
                  },
                  error: function(jqXHR){
                     console.log(jqXHR);
                  },
               });
            });
         });
      </script>
   </body>
</html>