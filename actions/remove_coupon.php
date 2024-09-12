<?php
session_start();
unset($_SESSION['code']);

echo json_encode([
   // 'total' => $total,
   'discount_amount' => 0,
   'discount_HTML' => '',
]);