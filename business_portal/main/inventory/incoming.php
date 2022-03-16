<?php
require_once('auth.php');
$position=$_SESSION['SESS_POSITION'];
$name=$_SESSION['SESS_NAME'];

include('../connect.php');

$invoice = $_POST['invoice'];
$product_id = $_POST['product_id'];
$qty_picked = $_POST['qty_picked'];
$payment_method = $_POST['id'];
$date = $_POST['date'];
$discount = $_POST['discount'];

// Get info of a product from products table
$result = $db->prepare("SELECT * FROM products WHERE product_id = :product_id");
$result->bindParam(':product_id', $product_id);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
    $unit_profit = $row['profit'];
    $unit_price = $row['unit_price'];
}

// Update qty onhand in products
$sql = "UPDATE products 
        SET qty_onhand = qty_onhand-?
		WHERE product_id = ?";
$q = $db->prepare($sql);
$q->execute(array($qty_picked,$product_id));

// Insert a sales order of a product
$sales_order_amount = $qty_picked * $unit_price;
$total_profit = $qty_picked * $unit_profit;
// query
$sql = "INSERT INTO sales_order (invoice,product_id,qty_picked,sales_order_amount,sales_unit_price) VALUES (:v1,:v2,:v3,:v4,:v5)";
$q = $db->prepare($sql);
$res = $q->execute(array(':v1'=>$invoice,':v2'=>$product_id,':v3'=>$qty_picked,':v4'=>$sales_order_amount,':v5'=>$unit_price));
if ($res) echo 'Success';
else echo 'Fail';
header("location: sales.php?id=$payment_method&invoice=$invoice");


?>