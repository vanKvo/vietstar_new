<?php
	include('../connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("DELETE FROM purchase WHERE purchase_id= :memid");
	$result->bindParam(':memid', $id);
	$result->execute();
?>