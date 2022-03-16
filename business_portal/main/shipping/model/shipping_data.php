<?php 

/** Customers */
function get_customers() {
  //echo "Start get_customers() <br>";
  global $db;
  $query = 'SELECT * FROM customer';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $customers = $stmt->fetchAll();
  $stmt->closeCursor(); 
  //echo "End get_customers() <br>";
  return $customers;
}

function add_customer($v1,$v2,$v3,$v4,$v5,$v6,$v7) {
  echo "<br>Start Add Customer<br>"; 
  global $db;
  $query = 'INSERT INTO `customer`(`cust_name`, `cust_address`, `cust_city`, `cust_state`, `cust_zipcode`, `cust_email`, `cust_phone`) VALUES (:v1,:v2,:v3,:v4,:v5,:v6,:v7)';
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
  if ($res) echo '<br>Success<br>';
  else echo '<br>Fail<br>';
  $stmt->closeCursor();
  echo "<br>End Add Customer<br>"; 
}

function get_customer($v1, $v2) {
  echo "<br>Start Get Customer<br>";
  global $db;
  $query = 'SELECT * FROM `customer` WHERE cust_name = :v1 AND cust_phone = :v2';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
    ':v1' => $v1,
    ':v2' => $v2
  ));
  $customer = $stmt->fetchAll();
  if ($res) echo '<br>Success<br>';
  else echo '<br>Fail<br>';
  $stmt->closeCursor(); 
  echo "<br>End Get Customer<br>";
  return $customer;
}

function search_customer($search_input) {
  //echo "<br> Start search_customer() <br> $search_input";
  global $db;
  if (valid_phone($search_input)) {
   // echo "<br>Do st with valid phone<br>";
    $phone_number = preg_replace('/[^0-9]/', '', $search_input); // keep numbers only
    //$email = '%';
    //$cust_id = '%';
  } else if (valid_email($search_input)) {
    //echo "<br>Do st with valid email<br>";
    $email = strtolower(trim($search_input));
    //$phone = '%';
  }
  
  $query = 'SELECT * FROM customer c LEFT JOIN recipient r
  ON c.customer_id = r.customer_id
  WHERE cust_phone = :phone_number OR LOWER(cust_email) = :email';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
    ':phone_number' => $phone_number,
    ':email' => $email
   ));
  $customer = $stmt->fetchAll();
  $count =  $stmt->rowCount(); // number of row may be equal or more than one because one customer can more than one recipients
  array_push($customer, $count); 
  $stmt->closeCursor;
  //print_r($customer);
  //echo "End search_customer() <br>";
  return $customer;
}

/** Recipient */
function add_recipient($a, $b, $c, $d) {
  echo "<br>Start Add recipient<br>";
  global $db;
  $query = 'INSERT INTO `recipient`(`recipient_name`, `recipient_address`, `recipient_phone`, `customer_id`) VALUES (:a,:b,:c,:d)';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
    ':a' => $a,
    ':b' => $b,
    ':c' => $c,
    ':d' => $d
   ));
   echo "<br>EndAdd recipient<br>";
}
function get_recipient($v1, $v2, $v3) {
  echo "<br>Start Get Recipient<br>";
  global $db;
  $query = 'SELECT * FROM `recipient` WHERE customer_id = :v1 AND recipient_name = :v2 AND recipient_phone = :v3';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
    ':v1' => $v1,
    ':v2' => $v2,
    ':v3' => $v3
  ));
  $recipient = $stmt->fetchAll();
  $stmt->closeCursor(); 
  echo "<br>End Get Recipient<br>";
  return $recipient;
}

/** Shipping  */
function get_location() {
  global $db;
  $query= 'SELECT * FROM shipping_location';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $locations = $stmt->fetchAll();
  $stmt->closeCursor(); 
  return $locations;
}

function add_shipping_order($v1,$v2,$v3,$v4,$v5,$v6,$v7,$v8,$v9,$v10,$v11,$v12,$v13,$v14,$v15,$v16,$v17) {
  echo "mst: $v1, senddt: $v2, airportdt: $v3, total wt:  $v4, no_packages:$v5, value: $v6, custom fee:  $v7, insurance: $v8,  payment_method: $v9, user_id`: $v10, location: $v11, customer_id:  $v12,recipient_id: $v13, price_per_lb: $v14, amount: $v15, custom_fee_taxed_item: $v16, sales_id: $v17";
  echo "<br>Start Add Ship ORd<br>"; 
  global $db;
  $query = 'INSERT INTO `shipping_order`(`mst`, `send_date`, `airport_delivery_date`, `total_weight`, `num_of_packages`, `package_value`, `custom_fee`, `insurance`, `payment_method`, `user_id`, `location`, `customer_id`, `recipient_id`, `price_per_lb`,`amount`, `custom_fee_taxed_item`,`sales_id`) VALUES (:v1,:v2,:v3,:v4,:v5,:v6,:v7,:v8,:v9,:v10,:v11,:v12,:v13,:v14,:v15,:v16,:v17)'; 
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
     ':v1' => $v1,
     ':v2' => $v2,
     ':v3' => $v3,
     ':v4' => $v4,
     ':v5' => $v5,
     ':v6' => $v6,
     ':v7' => $v7,
     ':v8' => $v8,
     ':v9' => $v9,
     ':v10' => $v10,
     ':v11' => $v11,
     ':v12' => $v12,
     ':v13' => $v13,
     ':v14' => $v14,
     ':v15' => $v15,
     ':v16' => $v16,
     ':v17' => $v17
    ));
    if ($res) echo '<br>Success<br>';
    else echo '<br>Fail<br>';
  $stmt->closeCursor();
  echo "<br>End Add Ship ORd<br>"; 
}

function add_package($shipping_ord_id, $packages) {
 echo "<br>Start Add package<br>"; 
echo "shiporderid: $shipping_ord_id<br>";
  //print_r($packages);
  global $db;
  for ($i = 0; $i < count($packages); $i++) {
    $query = 'INSERT INTO `package`(`shipping_order_id`, `package_desc`, `package_weight`, `mst`,`pkg_tracking_no`) VALUES (:v1,:v2,:v3,:v4,:v5);';
    $stmt = $db->prepare($query);
    $res = $stmt->execute(array(
      ':v1' => $shipping_ord_id,
      ':v2' => $packages[$i]['pkg_desc'],
      ':v3' => $packages[$i]['pkg_wt'], 
      ':v4' => $packages[$i]['mst'],
      ':v5' => $packages[$i]['pkg_tracking_no'],
    ));
    if ($res) echo '<br>Success<br>';
    else echo '<br>Fail<br>';
      
  } 
  echo "<br>End Add package<br>"; 
}

function get_shipping_order($mst) {
  global $db;
  $query = 'SELECT * FROM shipping_order WHERE mst = :mst';
  $stmt = $db->prepare($query);
  $stmt ->bindValue(':mst', $mst);
  $stmt->execute();
  $shipping_order = $stmt->fetchAll();
  $stmt->closeCursor(); 
  return $shipping_order;
}

function get_shipping_invoice_info($mst) {
  global $db;
  $query = 'SELECT * FROM shipping_order so
  JOIN customer c ON so.customer_id = c.customer_id
  JOIN recipient r ON so.recipient_id = r.recipient_id
  JOIN package p ON so.shipping_order_id = p.shipping_order_id
  WHERE so.mst = :mst';
  $stmt = $db->prepare($query);
  $stmt ->bindValue(':mst', $mst);
  $stmt->execute();
  $shipping_order = $stmt->fetchAll();
  $stmt->closeCursor(); 
  return $shipping_order;
}

function get_temp_shipping_order($shipping_order_id) {
  global $db;
  $query = 'SELECT * FROM temp_shipping_order
  WHERE shipping_order_id =  :shipping_order_id';
  $stmt = $db->prepare($query);
  $stmt ->bindValue(':shipping_order_id', $shipping_order_id);
  $stmt->execute();
  $shipping_order = $stmt->fetchAll();
  $stmt->closeCursor(); 
  return $shipping_order;
}

function get_temp_shipping_order_temp_package($shipping_order_id) {
  global $db;
  $query = 'SELECT * FROM temp_shipping_order tso
  JOIN temp_package tp ON tso.shipping_order_id =  tp.shipping_order_id
  WHERE tso.shipping_order_id =  :shipping_order_id';
  $stmt = $db->prepare($query);
  $stmt ->bindValue(':shipping_order_id', $shipping_order_id);
  $stmt->execute();
  $shipping_order = $stmt->fetchAll();
  $stmt->closeCursor(); 
  return $shipping_order;
}

function get_last_shipord() {
  //echo "<br>Start get_last_shipord()<br>"; 
  global $db;
  $query = 'SELECT * FROM shipping_order WHERE shipping_order_id = (SELECT MAX(shipping_order_id) FROM shipping_order)';
  $stmt = $db->prepare($query);
  $stmt->execute();
  $shipping_order = $stmt->fetch();
  //print_r($shipping_order);
  $stmt->closeCursor(); 
  //echo "<br>End get_last_shipord()<br>"; 
  return $shipping_order;
}

/** Validations */

function valid_email($input) {
  //echo "Valid email function <br>";
  $email = clean_input($input);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //Invalid email format
    return false;
  }
  return true;
}

function valid_phone($input) {
  //echo "Valid phone function <br>";
  // Filter out the character data
  $phone = preg_replace('/[^0-9]/', '', $input);
  if(strlen($phone) !== 10) {
    //Phone is 10 characters in length (###) ###-####
    return false;
  }
  return true;
}

function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function valid_recipient($cust_id, $name) {
  echo "<br>Start valid recipient<br>"; 
  global $db;
  // Check if the email is registered
  $query = 'SELECT COUNT(*) AS num FROM recipient WHERE recipient_name = :name AND customer_id = :cust_id';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
    ':cust_id' => $cust_id,
    ':name' => $name
   ));
  //Fetch the row that MySQL returned.
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo $row['num'];
  if ($row['num'] == 0) {
    echo '<br>Customer data does not exist<br>'; 
    return true;
  } else {
     echo '<br>Customer data exists in DB<br>'; 
    return false;
  }
  $stmt-->closeCursor();
  echo "<br>End valid recipient<br>"; 
}

function valid_shipping_ord($mst) {
  //echo "<br>Star valid Ship Ord<br> ====$mst"; 
  global $db;
  $query= 'SELECT COUNT(*) AS num FROM shipping_order WHERE mst=:mst';
  $stmt = $db->prepare($query);
  $stmt->bindValue(':mst', $mst);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //The $row array will contain "num" 
  echo "<br>Row:". $row['num']."<br>";
  if ($row['num'] == 0) {
    echo '<br>Valid shipping order<br>'; 
    return true;
  } else {
    echo '<br>InValid shipping order - mst exists<br>'; 
    return false;
  }
  $stmt->closeCursor(); 
 // echo "<br>End valid Ship ORd<br>"; 
}

function valid_customer($cust_name, $cust_phone) {
  echo "<br>Start valid customer<br>"; 
  global $db;
  // Check if the email is registered
  $query = 'SELECT COUNT(*) AS num FROM customer WHERE cust_name = :cust_name AND cust_phone = :cust_phone';
  $stmt = $db->prepare($query);
  $res = $stmt->execute(array(
    ':cust_name' => $cust_name,
    ':cust_phone' => $cust_phone
   ));
  //Fetch the row that MySQL returned.
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo $row['num'];
  if ($row['num'] == 0) {
    echo '<br>Customer data does not exist<br>'; 
    return true;
  } else {
    echo '<br>Customer data exists in DB<br>'; 
    return false;
  }
  $stmt-->closeCursor();
  echo "<br>End valid customer<br>"; 
}
  

?>