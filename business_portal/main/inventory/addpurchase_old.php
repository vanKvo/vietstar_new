<?php 
		include('../connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<form action="savepurchase.php" method="post">
<center><h4><i class="icon-plus-sign icon-large"></i> Add Purchase</h4></center>
<hr>
<div id="ac">
<label>Scan UPC </label>
<select name="Product_id" style="width:650px;" class="chzn-select" required>
	<option></option>
		<?php
			$result = $db->prepare("SELECT * FROM products");
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
		?>
			<option value="<?php echo $row['product_id'];?>"><?php echo $row['product_code']; ?> | <?php echo $row['product_name']; ?> | Qty Onhand: <?php echo $row['qty_onhand']; ?></option>
		<?php
					}
		?>
</select>
<label>Suppliers Name</label>
<select name="supplier_id" style="width:650px;" class="chzn-select" required>
	<option></option>
		<?php
		$result = $db->prepare("SELECT * FROM supliers");
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
		?>
			<option value="<?php echo $row['suplier_id'];?>"><?php echo $row['suplier_name']; ?> </option>
		<?php
					}
		?>
</select>
<span>Cost of Product ($): </span><input type="text" style="width:265px; height:30px;" name="Cost_Product" placeholder="0.00"/><br>
<span>Quantity of Product: </span><input type="text" style="width:265px; height:30px;" name="Quantity_Product" placeholder="0"/><br>
<div style="float:right; margin-right:10px;">
<button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Save</button>
</div>
</div>
</form>
<script src="js/jquery.js"></script>
<script>
$(document).ready(function(){
 /* $(".chzn-select").chosen().change(function() { // this function allows we can type text in select tag
      alert($(this).val());
  });*/
});
</script>
</html>