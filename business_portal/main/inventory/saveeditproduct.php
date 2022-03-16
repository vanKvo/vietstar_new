<?php
// configuration
include('../connect.php');

// new data
$product_id = $_POST['product_id'];
$v1 = $_POST['product_code'];
$v2 = $_POST['product_category'];
$v3 = $_POST['product_name'];
$v5 = $_POST['unit_price'];
$v6 = $_POST['supplier'];
$v7 = $_POST['qty_onhand'];
$v12 = $_POST['product_location'];
echo "<br>$v1,$v2,$v3,$v5,$v6,$v7,$v12, $product_id<br>";
// query
$sql = 'UPDATE products 
        SET product_code=:v1, product_category=:v2, product_name=:v3, unit_price=:v5, supplier=:v6, qty_onhand=:v7, product_location=:v12
		WHERE product_id=:product_id';
$stmt = $db->prepare($sql);
$res = $stmt->execute(array(
    ':v1' => $v1,
    ':v2' => $v2,
    ':v3' => $v3,
    ':v5' => $v5,
    ':v6' => $v6,
    ':v7' => $v7,
    ':v12' => $v12,
    ':product_id' => $product_id
   ));
if ($res) {
    echo "<br>Success<br>";
} else echo "<br>Fail<br>";

header("location: products.php");

?>