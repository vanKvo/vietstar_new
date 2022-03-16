<?php 
require_once '../../connect.php';
require_once '../model/shipping_data.php';

$recipient_name = clean_input($_REQUEST['recipient_name']);
$recipient_phone = clean_input($_REQUEST['recipient_phone']);
$recipient_address = clean_input($_REQUEST['recipient_address']);
$cust_id = clean_input($_REQUEST['cust_id']);
echo "$recipient_name - $recipient_phone - $recipient_address - $cust_id";
/*$name = 'Phuong Dang';
$phone = '7036668900';
$cust_id = '1';*/

valid_recipient($cust_id, $recipient_name);
 
// Add new recipient if applicable
if (isset($cust_id) && isset($recipient_name) && isset($recipient_address) && isset($recipient_phone) && valid_recipient($cust_id, $recipient_name)) { // New recipient info is added
  echo "ADD Recipient";
  //add_recipient($recipient_name, $recipient_address, $recipient_phone, $cust_id);
}
?>