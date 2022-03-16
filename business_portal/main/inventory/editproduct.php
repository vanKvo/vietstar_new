<?php
	include('../connect.php');
	//$id=$_GET['id'];
	$product_id=$_GET['product_id'];
	$result = $db->prepare("SELECT * FROM products WHERE product_id= :product_id");
	$result->bindParam(':product_id', $product_id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditproduct.php" method="post">
<center><h4><i class="icon-edit icon-large"></i> Edit Product</h4></center>
<hr>
<div id="ac">
<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
<span>Product Code: </span><input type="text" style="width:265px; height:30px;"  name="product_code" value="<?php echo $row['product_code']; ?>" Required/><br>
<span>Product Name: </span><input type="text" style="width:265px; height:30px;"  name="product_name" value="<?php echo $row['product_name']; ?>" /><br>
<span>Category / Description: </span><input type="text" style="width:265px; height:30px;"  name="product_category" value="<?php echo $row['product_category']; ?>" /><br>
<span>Position: </span><input type="text" style="width:265px; height:30px;"  name="product_location" value="<?php echo $row['product_location']; ?>" /><br>
<span>Unit Price : </span><input type="text" style="width:265px; height:30px;" id="txt1" name="unit_price" value="<?php echo $row['unit_price']; ?>" onkeyup="sum();" Required/><br>
<span>Supplier : </span>
<select name="supplier" style="width:265px; height:30px; margin-left:-5px;" >
	<option><?php echo $row['supplier']; ?></option>
	<?php
	$results = $db->prepare("SELECT * FROM supliers");
		$results->bindParam(':userid', $res);
		$results->execute();
		for($i=0; $rows = $results->fetch(); $i++){
	?>
		<option><?php echo $rows['suplier_name']; ?></option>
	<?php
	}
	?>
</select><br>
<span>Quantity Onhand: </span><input type="number" style="width:265px; height:30px;" min="0" name="qty_onhand" value="<?php echo $row['qty_onhand']; ?>" /><br>

<div style="float:right; margin-right:10px;">

<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Save Changes</button>
</div>
</div>
</form>
<?php
}
?>