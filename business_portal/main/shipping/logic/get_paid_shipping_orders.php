<?php
require_once '../../connect.php';
require_once '../model/shipping_data.php';

//$connect = new PDO("mysql:host=localhost;dbname=vietstar_shipping", "root", "root");

global $db;

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
	$query = "
	SELECT * FROM shipping_order so
  JOIN customer c ON so.customer_id = c.customer_id
	JOIN recipient r ON so.recipient_id = r.recipient_id
	JOIN package p ON so.shipping_order_id = p.shipping_order_id
	WHERE send_date BETWEEN '".$received_data->date1."' AND '".$received_data->date2."'
	AND (so.mst LIKE '%".$received_data->query."%' 
	OR cust_name LIKE '%".$received_data->query."%' 
	OR cust_phone LIKE '%".$received_data->query."%') 
	ORDER BY so.mst DESC
	";
}
else
{
	$query = "
  SELECT * FROM shipping_order so
  JOIN customer c ON so.customer_id = c.customer_id
	JOIN recipient r ON so.recipient_id = r.recipient_id
	JOIN package p ON so.shipping_order_id = p.shipping_order_id
	WHERE send_date BETWEEN '".$received_data->date1."' AND '".$received_data->date2."'
	ORDER BY so.mst DESC
	";
}

$statement = $db->prepare($query);

$statement->execute();
/*if ($res) echo '<br>Success<br>';
else echo '<br>Fail<br>';*/
$statement->execute();
while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>