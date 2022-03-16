<?php 
//echo "<br>Hello inventory_data.php<br>";

function get_products() {
  //echo "Start get_products() <br>";
  global $db;
  $query = 'SELECT * FROM products';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $products = $stmt->fetchAll();
  $stmt->closeCursor(); 
  //echo "End get_products() <br>";
  return $products;
}

function get_product($product_id) {
  global $db;
  $query = 'SELECT * FROM products WHERE product_id = :product_id';
  $stmt = $db->prepare($query);
  $stmt->bindParam(':product_id', $product_id);
  $stmt->execute();
  $product = $stmt->fetch();
  $stmt->closeCursor(); 
  return $product;
}

function decrease_supply($qty_picked,$product_id) {
  echo " <br>Begin decrease_supply(): Prod_id: $product_id; Picked Qty - $qty_picked<br>";
  global $db; 
  $product = get_product($product_id);
  $qty_onhand = $product['qty_onhand'];
  if ($qty_onhand > 0 && $qty_picked <= $qty_onhand) {
    $sql = "UPDATE products 
    SET qty_onhand = qty_onhand-?
    WHERE product_id = ?";
    $q = $db->prepare($sql);
    $res = $q->execute(array($qty_picked,$product_id));
    if ($res) echo "<br>Success<br>";
    else echo "<br>Fail<br>";
  } else {
    echo "This product is out of stock OR not enough the stock quantity required";
  }
  echo " <br>End decrease_supply() <br>";
}

function add_sales($v1,$v2,$v3,$v4,$v5,$v6) {
  global $db;
  echo " <br>Start add_sales() <br>";
  $v7 = getLastSalesInvoice() + 1; // next invoice number
  $query = 'INSERT INTO `sales`( `sales_payment_method`, `sales_custname`,  `sales_date`, `sales_amount`, `mst`, `user_id`, `invoice_number`) VALUES (:v1,:v2,:v3,:v4,:v5,:v6,:v7)';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
     ':v1' => $v1,
     ':v2' => $v2,
     ':v3' => $v3,
     ':v4' => $v4,
     ':v5' => $v5,
     ':v6' => $v6,
     ':v7' => $v7
  ));
  if ($res) echo "<br>Success<br>";
  else echo "<br>Fail<br>";
  $stmt->closeCursor(); 
  echo " <br>End add_sales() <br>";
}

function add_sales_order($v1,$v2,$v3,$v5,$mst) {
  global $db;
  echo " <br>Start add_sales_order() <br>";
  $product = get_product($v2); 
  $sales = get_sales($mst);
  $v4 = $product['unit_price']; // get current unit price of the product
  $v6 = $sales['invoice_number'];
  //echo $v2;
  $query = 'INSERT INTO `sales_order`(`qty_picked`,`product_id`, `sales_id`, `sales_unit_price`, `sales_order_amount`, `invoice`) VALUES (:v1,:v2,:v3,:v4,:v5,:v6)';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
     ':v1' => $v1,
     ':v2' => $v2,
     ':v3' => $v3,
     ':v4' => $v4,
     ':v5' => $v5,
     ':v6' => $v6
  ));
  if ($res) echo "<br>Success<br>";
  else echo "<br>Fail<br>";
  $stmt->closeCursor(); 
  echo " <br>End add_sales_order() <br>";
}

function get_sales($mst) {
  global $db;
  echo " <br>Start get_sales <br>";
  $query = 'SELECT * FROM sales WHERE mst = :mst';
  $stmt = $db->prepare($query);
  $stmt->bindParam(':mst', $mst);
  $res = $stmt->execute();
  $sales = $stmt->fetch();
  if ($res) echo "<br>Success<br>";
  else echo "<br>Fail<br>";
  $stmt->closeCursor(); 
  echo " <br>End get_sales <br>";
  return $sales;
}

function getLastSalesInvoice() {
	global $db;
  $query= 'SELECT * FROM sales WHERE sales_id = (SELECT MAX(sales_id) FROM sales)';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $sales = $stmt->fetch();
  $last_invoice_number = $sales['invoice_number'];
  $stmt->closeCursor(); 
  return $last_invoice_number;
}

function get_sales_order($sales_id) {
  global $db;
  //echo " <br>Start get_sales_order <br>";
  $query = 'SELECT * FROM sales_order so
  JOIN products p ON so.product_id = p.product_id
  WHERE sales_id = :sales_id';
  $stmt = $db->prepare($query);
  $stmt->bindParam(':sales_id', $sales_id);
  $res = $stmt->execute();
  $sales_orders = $stmt->fetchAll();
 /* if ($res) echo "<br>Success<br>";
  else echo "<br>Fail<br>";*/
  $stmt->closeCursor(); 
  //echo " <br>End get_sales_order <br>";
  return $sales_orders;
}


?>