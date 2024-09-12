<?php
session_start();

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

if(isset($_POST['total'])){
   include "../config/connect.php";

   $order = $database->prepare('INSERT INTO orders (subtotal, shipping_charge, discount_amount, total, coupon_code, first_name, last_name, email, mobile, wilaya, address, notes)
   
   VALUES(:subtotal, :shipping_charge, :discount_amount, :total, :coupon_code, :first_name, :last_name, :email, :mobile, :wilaya, :address, :notes)');

   $order->bindParam('subtotal', str_replace(' $', '', $_POST['subtotal']));
   $order->bindParam('shipping_charge', str_replace(' $', '', $_POST['shipping_charge']));
   $order->bindParam('discount_amount', str_replace(' $', '', $_POST['discount_amount']));
   $order->bindParam('total', str_replace(' $', '', $_POST['total']));
   $order->bindParam('coupon_code', $_POST['coupon_code']);
   $order->bindParam('first_name', $_POST['first_name']);
   $order->bindParam('last_name', $_POST['last_name']);
   $order->bindParam('email', $_POST['email']);
   $order->bindParam('mobile', $_POST['mobile']);
   $order->bindParam('wilaya', $_POST['wilaya']);
   $order->bindParam('address', $_POST['address']);
   $order->bindParam('notes', $_POST['notes']);
   if($order->execute()){
         $order_items_id = [];
         $qtys = [];
         $prices = [];
         $order_id = $database->lastInsertId();
      
         foreach($_SESSION['checkout'] as $product){
            $order_items_id[] = $product['id'];
            $qtys[$product['id']] = $product['qty'];
            $prices[$product['id']] = $product['price'];
         }

         foreach($order_items_id as $order_item_id){
            $params = [
               'order_id' => $order_id,
               'product_id' => $order_item_id,
               'qty' => $qtys[$order_item_id],
               'cost' => $qtys[$order_item_id] * $prices[$order_item_id],
            ];

            $order_item = $database->prepare("INSERT INTO order_items (order_id, product_id, qty, cost) VALUES(:order_id, :product_id, :qty, :cost)");
   
            foreach($params as $param => $arg){
               $order_item->bindValue($param, $arg);
            }
            $order_item->execute();
         }
         $_SESSION['order_id'] = $order_id;
         unset($_SESSION['cart']);
         unset($_SESSION['checkout']);
         header('Location: ../order.php?id='.$order_id);
      }
}
?>