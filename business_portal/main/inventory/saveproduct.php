<?php
session_start();
include('../connect.php');
$v1 = $_POST['product_code'];
$v2 = $_POST['product_category'];
$v3 = $_POST['product_name'];
$v4 = $_POST['unit_price'];
$v5 = $_POST['supplier'];
$v6 = $_POST['qty_onhand'];
$v7 = $_POST['product_location'];

// query
$sql = "INSERT INTO `products`(`product_code`, `product_category`, `product_name`, `unit_price`, `supplier`, `qty_onhand`, `product_location`) VALUES (:v1,:v2,:v3,:v4,:v5,:v6,:v7)";
$q = $db->prepare($sql);
$res=$q->execute(array(':v1'=>$v1,':v2'=>$v2,':v3'=>$v3,':v4'=>$v4,':v5'=>$v5,':v6'=>$v6,':v7'=>$v7));
header("location: products.php");
if ($q) {
  echo'Success';
} else {
  echo 'Fails';
}

?>