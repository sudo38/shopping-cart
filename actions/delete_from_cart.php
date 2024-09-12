<?php
session_start();

if(isset($_POST['i'])){
   unset($_SESSION['cart'][$_POST['i']]);
   unset($_SESSION['checkout'][$_POST['i']]);

   echo json_encode([
      'type' => 'success',
      'message' => 'Product Deleted From Cart',
   ]);
}
