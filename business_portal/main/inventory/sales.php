<?php 
include('../connect.php');
include('function.php');
require_once('auth.php');
$position=$_SESSION['SESS_POSITION'];
$name=$_SESSION['SESS_NAME'];
$finalcode=createRandomPassword();
?>
<html>
<head>
<title>Vietstar_Shipping</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/navbar.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
.well li {
	line-height: 20px;
	list-style: none;
	padding-bottom: 10px;
}
</style>
<!--sa poip up-->
<script src="jeffartagame.js" type="text/javascript" charset="utf-8"></script>
<script src="js/application.js" type="text/javascript" charset="utf-8"></script>
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    })
  })
</script>
</head>

<script>
function sum() {
            var txtFirstNumberValue = document.getElementById('txt1').value;
            var txtSecondNumberValue = document.getElementById('txt2').value;
            var result = parseInt(txtFirstNumberValue) - parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt3').value = result;
				
            }
			
			 var txtFirstNumberValue = document.getElementById('txt11').value;
            var result = parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt22').value = result;				
            }
			
			 var txtFirstNumberValue = document.getElementById('txt11').value;
            var txtSecondNumberValue = document.getElementById('txt33').value;
            var result = parseInt(txtFirstNumberValue) + parseInt(txtSecondNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt55').value = result;
				
            }
			
			 var txtFirstNumberValue = document.getElementById('txt4').value;
			 var result = parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('txt5').value = result;
				}
			
        }
</script>

<body>
<?php include('navfixed.php');?>
<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
	<div class="well sidebar-nav">
				<ul class="nav nav-list">
					<h4>Inventory</span></h4>  
					<hr>
					<li><a href="../index.php"><i class="icon-dashboard icon-2x"></i> Dashboard  </a></li> 
					<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Inventory</a></li>    
					<li><a href="purchase.php"><i class="icon-group icon-2x"></i> Purchase </a> </li>     
					<li class="active"><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Sales </a></li>             
					<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a></li> 
				</ul>             
			</div><!--/.well -->
		</div><!--/span-->
	<div class="span10">
	<div class="contentheader">
			<i class="icon-table"></i> Sales
			</div>
			<ul class="breadcrumb">
			<li><a href="../index.php">Dashboard</a></li> /
			<li class="active">Sales</li>
			</ul>
			
<form action="incoming.php" method="post" >								
	<input type="hidden" name="pmt_method" value="<?php echo $_GET['pmt_method']; ?>" />
	<input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />
	<select name="product_id" style="width:650px;" class="chzn-select" required>
	<option></option>
		<?php
		include('../connect.php');
		$result = $db->prepare("SELECT * FROM products");
			$result->bindParam(':invoice_id', $res);
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
		?>
			<option value="<?php echo $row['product_id'];?>"><?php echo $row['product_code']; ?> | <?php echo $row['product_name']; ?> | Quantity Onhand: <?php echo $row['qty_onhand']; ?></option>
		<?php
					}
		?>
	</select>
	<input type="number" name="qty_picked" value="1" min="1" placeholder="Qty" autocomplete="off" style="width: 68px; height:30px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" required>
	<input type="hidden" name="discount" value="" autocomplete="off" style="width: 68px; height:30px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" />
	<input type="hidden" name="date" value="<?php echo date("m/d/y"); ?>" />
	<button type="submit" class="btn btn-info" style="width: 123px; height:35px; margin-top:-5px;"><i class="icon-plus-sign icon-large"></i> Add</button>
</form>

<table class="table table-bordered" id="resultTable" data-responsive="table">
	<thead>
		<tr>
			<th> Product Code </th>
			<th> Product Name </th>
			<th> Category / Description </th>
			<th> Unit Price </th>
			<th> Quantity </th>
			<th> Amount </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		
			<?php
				$id=$_GET['invoice'];
				include('../connect.php');
				$query = "SELECT * FROM sales_order so JOIN products p 
				ON so.product_id = p.product_id
				WHERE invoice = :invoice_id";
				$result = $db->prepare($query);
				$result->bindParam(':invoice_id', $id);
				$result->execute();
				for($i=1; $row = $result->fetch(); $i++){
					?>
					<tr class="record">
					<td hidden><?php echo $row['product_id']; ?></td>
					<td><?php echo $row['product_code']; ?></td>
					<td><?php echo $row['product_name']; ?></td>
					<td><?php echo $row['product_category']; ?></td>
					<td>
					<?php
					$ppp=$row['unit_price'];
					echo formatMoney($ppp, true);
					?>
					</td>
					<td><?php echo $row['qty_picked']; ?></td>
					<td>
					<?php
					$sales_order_amount=$row['sales_order_amount'];
					echo formatMoney($sales_order_amount, true);
					?>
					</td>
					<td width="90"><a href="delete.php?sales_order_id=<?php echo $row['sales_order_id']; ?>&invoice=<?php echo $_GET['invoice']; ?>&pmt_method=<?php echo $_GET['pmt_method']; ?>&qty_picked=<?php echo $row['qty_picked'];?>&product_id=<?php echo $row['product_id'];?>"><button class="btn btn-mini btn-warning"><i class="icon icon-remove"></i> Cancel </button></a></td>
					</tr>
			<?php
				}
			?>
			<tr>
			<th> </th>
			<th>  </th>
			<th>  </th>
			<th>  </th>
			<th>  </th>
			<td> Total Amount: </td>
			<th>  </th>
		</tr>
			<tr>
				<th colspan="5"><strong style="font-size: 12px; color: #222222;">Total:</strong></th>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
				<?php
				function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}
				$invoice=$_GET['invoice'];
				$resultas = $db->prepare("SELECT sum(sales_order_amount) FROM sales_order WHERE invoice= :a");
				$resultas->bindParam(':a', $invoice);
				$resultas->execute();
				for($i=0; $rowas = $resultas->fetch(); $i++){
				$total_amount=$rowas['sum(sales_order_amount)'];
				echo formatMoney($total_amount, true);
				}
				?>
				</strong></td>
				<th></th>
			</tr>
		
	</tbody>
</table>
<br>
<a rel="facebox" href="checkout.php?payment_method=<?php echo $_GET['pmt_method']?>&invoice=<?php echo $_GET['invoice']?>&total_amount=<?php echo $total_amount ?>&total_profit=<?php echo $total_profit ?>&cashier=<?php echo $_SESSION['SESS_FIRST_NAME']?>"><button class="btn btn-success btn-large btn-block">SUBMIT</button></a>

<div class="clearfix"></div>
</div>
</div>
</div>
</body>
<?php include('footer.php');?>

</html>