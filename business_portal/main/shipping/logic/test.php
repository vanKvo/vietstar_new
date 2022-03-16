<?php
require_once '../../connect.php';
require_once '../model/shipping_data.php';
echo 'logic/test.php';
  $cust_name = 'Alex Han';
  $cust_phone = '7035556666';
  $cust_email = 'ahan@gmail.com';
  $cust_address = '99 Horizontal Light';
  $cust_city = 'Chantilly';
  $cust_state = 'VA';
  $cust_zip= '22055';
//if (valid_customer('Alice', '7034429953'));//
  // (`cust_name`, `cust_address`, `cust_city`, `cust_state`, `cust_zipcode`, `cust_email`, `cust_phone`)
  //add_customer($cust_name, $cust_address , $cust_city, $cust_state, $cust_zip, $cust_email, $cust_phone);
//}
$customer = get_customer($cust_name, $cust_phone);
echo "Cust_id: " .$customer[0]['customer_id'];

?>