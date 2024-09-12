<?php

$host = 'localhost';
$dbname = 'shopping_cart';
$username = 'root';
$password = '';

$database = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;", $username, $password);