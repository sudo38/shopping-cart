<?php
session_start();
include "config/connect.php";

$order_id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$order_id || !isset($_SESSION['order_id']) || $_SESSION['order_id'] != $order_id) {
   header('Location: shop.php');
   exit();
}

// unset($_SESSION['order_id']);

$order = $database->prepare('SELECT orders.*, products.*, order_items.* FROM orders JOIN order_items ON order_items.order_id = orders.id JOIN products ON order_items.product_id = products.id WHERE orders.id = :order_id');
$order->bindParam(':order_id', $order_id);
$order->execute();
$order = $order->fetchAll(PDO::FETCH_OBJ);
$order_infos = $order[0];

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="assets/plugins/bootstrap/v5.3/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/plugins/font-awesome/v6.5/css/all.min.css">
      <link rel="stylesheet" href="assets/css/order.css">
      <title>Order</title>
   </head>
   <body>
   <main>
      <div class="container">
         <h2 class="text-center pb-3">Order n°: GH5J7</h2>
         <address class="fst-italic pb-3">
            <div class="h5"><?= $order_infos->first_name . ' ' . $order_infos->last_name ?></div>
            <div class="h6"><?= $order_infos->address.', '.$order_infos->wilaya ?></div>
            <div class="h6">Phone: <?= $order_infos->mobile ?></div>
            <div class="h6">Email: <?= $order_infos->email ?></div>
         </address>
         <div class="table-responsive">
            <table class="table table-bordered mb-3">
               <thead>
               <tr class="table-dark">
                  <th class="text-center">Product</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Cost</th>
               </tr>
               </thead>
               <tbody>
               <?php foreach ($order as $order_item): ?>
                  <tr>
                     <td><?= $order_item->name ?></td>
                     <td>$ <?= $order_item->price ?></td>
                     <td><?= $order_item->qty ?></td>
                     <td>$ <?= $order_item->cost ?></td>
                  </tr>
               <?php endforeach; ?>
               </tbody>
            </table>
         </div>
         <div class="table-responsive">
            <table class="table table-bordered mb-0">
               <tr>
                  <th class="px-4">Subtotal:</th>
                  <td width="15%">$ <?= $order_infos->subtotal ?></td>
               </tr>
               <tr>
                  <th class="px-4">Shipping:</th>
                  <td>$ <?= $order_infos->shipping_charge ?></td>
               </tr>
               <tr>
                  <th class="px-4">
                     Discount: <?= !empty($order_infos->coupon_code) ? '(' . $order_infos->coupon_code . ')' : '' ?>
                  </th>
                  <td>$ <?= $order_infos->discount_amount ?></td>
               </tr>
               <tr>
                  <th class="px-4">Total:</th>
                  <td>$ <?= $order_infos->total ?></td>
               </tr>
            </table>
         </div>
      </div>
   </main>
   <script src="assets/plugins/bootstrap/v5.3/js/bootstrap.bundle.min.js"></script>
   <script src="assets/plugins/jquery/v3.7/jquery.min.js"></script>
   <script src="assets/plugins/font-awesome/v6.5/js/all.min.js"></script>
   <script src="assets/plugins/sweet-alert/sweetalert.all.js"></script>
   </body>
</html>