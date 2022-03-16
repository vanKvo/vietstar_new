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
	SELECT * FROM temp_shipping_order 
	WHERE submitted_date BETWEEN '".$received_data->date1."' AND '".$received_data->date2."'
	AND (cust_name LIKE '%".$received_data->query."%' 
	OR cust_phone LIKE '%".$received_data->query."%')
	ORDER BY submitted_date DESC
	";
}
else
{
	$query = "
  SELECT * FROM temp_shipping_order
	WHERE submitted_date BETWEEN '".$received_data->date1."' AND '".$received_data->date2."'
	ORDER BY submitted_date DESC
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