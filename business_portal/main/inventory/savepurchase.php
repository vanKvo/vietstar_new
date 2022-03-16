<?php
include('../connect.php');
/*require_once('auth.php');
$user_id=$_SESSION['SESS_MEMBER_ID'];
$position=$_SESSION['SESS_POSITION'];
$name=$_SESSION['SESS_NAME'];
$b = $user_id;*/

$a = $_POST['supplier_id'];
$b = '3';
//$c = '2022-02-03';
$c = date("Y-m-d");
$d = $_POST['Cost_Product'];
$e = $_POST['Quantity_Product'];
$f = $_POST['Product_id'];
echo "supplier_id: $a | quantity purchase:$e ";

// query
$sql = "INSERT INTO `purchase`(`supplier_id`, `user_id`, `purchase_date`, `purchase_cost`, `purchase_qty`, `product_id`) VALUES (:a,:b,:c,:d,:e,:f)";
$q = $db->prepare($sql);
$res = $q->execute(array(':a'=>$a,':b'=>$b,':c'=>$c,':d'=>$d,':e'=>$e,':f'=>$f));

/*if ($res) echo "Success";
else echo "Fail";*/

// Update qty onhand in products
$sql2 = "UPDATE products SET qty_onhand = qty_onhand+? WHERE product_id = ?";
$q = $db->prepare($sql2);
$res2 = $q->execute(array($e,$f));

/*if ($res) echo "Success";
else echo "Fail";*/

header("location: purchase.php");


?>