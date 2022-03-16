<?php 
require_once '../../connect.php';
require_once '../model/shipping_data.php';
require_once '../model/inventory_data.php';
require_once('../../../auth.php');

// User
$user_id = $_SESSION['SESS_MEMBER_ID']; 

// Sender
$cust_name = clean_input($_GET['cust_name']);
$cust_phone = clean_input($_GET['cust_phone']);
$cust_email = clean_input($_GET['cust_email']);
$cust_address = clean_input($_GET['cust_address']);
$cust_city = clean_input($_GET['cust_city']);
$cust_state = clean_input($_GET['cust_state']);
$cust_zip= clean_input($_GET['cust_zip']);
// Recipient
$recipient_id = clean_input($_GET['recipient_id']);
$recipient_name = clean_input($_GET['recipient_name']);
$recipient_address = clean_input($_GET['recipient_address']);
$recipient_phone = clean_input($_GET['recipient_phone']);

// Payment
$custom_fee_taxed_item = clean_input($_GET['custom_fee_taxed_item']);
$custom_fee = clean_input($_GET['custom_fee']);
$insurance = clean_input($_GET['insurance']);
$instore_sales = clean_input($_GET['instore']);
$pmt_method= clean_input($_GET['pmt']);

// Package
$pkg_val = clean_input($_GET['pkg_val']);
$pkg_weight = clean_input($_GET['total_weight']); //total package weight
$send_dt = clean_input($_GET['send_dt']);
$airport_dt = clean_input($_GET['airport_dt']);
$num_pkg = clean_input($_GET['num_pkg']);
$price_per_lb = clean_input($_GET['price_per_lb']);
$location = clean_input($_GET['location']);
$mst = clean_input($_GET['mst']);
$amount = clean_input($_GET['amount']);

// In-store items
$num_of_items = clean_input($_GET['num_of_items']);
$sales_amount = clean_input($_GET['instore']);

// If some optional values are not set
if (empty($custom_fee)) $custom_fee = 0;
if (empty($insurance)) $insurance = 0;
if (empty($sales_amount)) $sales_amount = 0;
if (empty($pkg_val)) $pkg_val = 0;
if (empty($airport_dt)) $airport_dt = $send_dt;
if (empty($amount)) $amount = 0;
if (empty($custom_fee_taxed_item)) $custom_fee_taxed_item = 'NA';

/** Sender */
// The form is populated with existing customer info (Search Form)
if (!empty(clean_input($_GET['cust_id']))) {
  $cust_id = clean_input($_GET['cust_id']);
  echo "Cust id is not empty<br>";
  echo "Customer id: $cust_id<br>";
} 
else  { // Check if customer info exists or not(Blank or Online Shipping Form)
  if (valid_customer($cust_name, $cust_phone)) { // new customer does not exist, add the new cust info into database
    add_customer($cust_name, $cust_address , $cust_city, $cust_state, $cust_zip, $cust_email, $cust_phone);
    echo "New customer";
  } // otherwise, get existing cust info from database
  $customer = get_customer($cust_name, $cust_phone); 
  $cust_id = $customer[0]['customer_id']; // get new customer id 
  echo "Customer id: $cust_id";
}

/** Recipient */
if (!empty($recipient_id) && empty($recipient_name) && empty($recipient_address)) { // select an existing recipient
// if (!empty($recipient_id) && empty($recipient_name) && empty($recipient_address)) {
  $recipient_id = clean_input($_GET['recipient_id']);
  echo "Recipient id is not empty<br>";
  echo "Recipient id: $recipient_id<br>";
} 
else { // Check if recipient info exists or not(Blank or Online Shipping Form)
  if (valid_recipient($cust_id, $recipient_name)) { // customer does not exist, add the new cust info into database
    add_recipient($recipient_name, $recipient_address, $recipient_phone, $cust_id);   
    echo "New recipient";
  } // otherwise, get existing recipient info from database
  $recipient = get_recipient($cust_id, $recipient_name, $recipient_phone);  
  $recipient_id = $recipient[0]['recipient_id']; // get new recipient id 
  echo "Recipient id: $recipient_id";
}

/** Get packages info */
echo '<br>No Packages:'.$num_pkg.'<br>';
for ($i=0; $i < $num_pkg; $i++) {
  $packages[$i]['pkg_desc'] = clean_input($_GET['pkg_desc'.($i)]); // $packages[0][] is empty, 1st element starts from $packages[1][]
  $packages[$i]['pkg_wt'] = clean_input($_GET['pkg_wt'.($i)]);
  $packages[$i]['mst'] = $mst;
  $packages[$i]['pkg_tracking_no'] = $i+1;
}

/** Get in-store items if applicable */
echo '<br>Num of ITEMS:'. ($num_of_items+1);
if ($num_of_items != -1) {  // Some instore items are purchased
  add_sales($pmt_method, $cust_name, $send_dt, $sales_amount, $mst, $user_id);
  $sales = get_sales($mst);
  $sales_id = $sales['sales_id'];
  echo "<br>Some in-store items are purchased<br>";
  for ($j=0; $j <= $num_of_items; $j++) {
    $items[$j]['product_id'] = clean_input($_GET['item'.$j]);
    echo "<br>PROD_ID: ". $items[$j]['product_id']. "<br>";
    $items[$j]['picked_qty'] = clean_input($_GET['picked_qty'.$j]);
    echo "PICKED_QTY: ". $items[$j]['picked_qty']. "<br>";
    if (empty($items[$j]['product_id']) || empty($items[$j]['picked_qty'])) { // skip if prod id or picked qty is blank
      continue; 
    }
    $product = get_product($items[$j]['product_id']);
    $unit_price = $product['unit_price'];
    $sales_amount = $unit_price *  $items[$j]['picked_qty'];
    echo "TEST ADD SALES ORD: sales amount: $$sales_amount, sales id: $sales_id,  mst: $mst";
    add_sales_order($items[$j]['picked_qty'],$items[$j]['product_id'], $sales_id, $sales_amount, $mst); // add a new sales order
    decrease_supply($items[$j]['picked_qty'],  $items[$j]['product_id']); // decrease onhand qty of the product in inventory
  }
} 

echo "Items PURHCHASED: ";
print_r($items);

// Add new shipping ord to the db
if (valid_shipping_ord($mst)) {
  echo "Get inside";
  add_shipping_order($mst, $send_dt, $airport_dt, $pkg_weight, $num_pkg, $pkg_val, $custom_fee, $insurance, $pmt_method, $user_id, $location, $cust_id, $recipient_id, $price_per_lb, $amount, $custom_fee_taxed_item, $sales_id); 
  $shipping_order = get_shipping_order($mst);
  $shipping_order_id =  $shipping_order[0]['shipping_order_id']; // Get shipping order id of an mst package
  add_package($shipping_order_id, $packages);
}
header('location:../view/shipping_form_online.php');
?>
<!--<a href="../view/shipping_form_online.php">Back</a>-->
