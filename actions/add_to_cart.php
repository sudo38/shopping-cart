<?php
session_start();

if(isset($_POST['id'])){
   if(isset($_SESSION['cart'])){
      $productExists = false;
      foreach ($_SESSION['cart'] as $infos) {
         if($_POST['id'] == $infos->id){
            $productExists = true;
         }
      }

      if($productExists){
         $type = 'error';
         $message = $_POST['name'].' Already Added';
      }else{
         $cart = new stdClass();
         $cart->id = $_POST['id'];
         $cart->name = $_POST['name'];
         $cart->price = $_POST['price'];
         $cart->thumbnail = $_POST['thumbnail'];
   
         $_SESSION['cart'][] = $cart;
   
         $type =  'success';
         $message = $_POST['name'].' Added In Cart';
      }
   }else{
      $cart = new stdClass();
      $cart->id = $_POST['id'];
      $cart->name = $_POST['name'];
      $cart->price = $_POST['price'];
      $cart->thumbnail = $_POST['thumbnail'];

      $_SESSION['cart'][] = $cart;

      $type = 'success';
      $message = $_POST['name'].' Added In Cart';
   }

   echo json_encode([
      'type' => $type,
      'message' => $message
   ]);
   

}
?>