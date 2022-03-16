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
</head>
<?php
$invoice=$_GET['invoice'];
include('../connect.php');
$result = $db->prepare("SELECT * FROM sales WHERE invoice_number= :invoice");
$result->bindParam(':invoice', $invoice);
$result->execute();
$sales = $result->fetchAll();
$cname=$sales[0]['sales_custname'];
$invoice=$sales[0]['invoice_number'];
$date=$sales[0]['sales_date'];
$cashier=$sales[0]['cashier'];
$pt=strtolower($sales[0]['sales_payment_method']);
$sales_amount=$sales[0]['sales_amount']; 
$cust_payment=$sales[0]['sales_cust_payment'];
$cust_name=$sales[0]['sales_custname'];
?>

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
	<a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><button class="btn btn-default"><i class="icon-arrow-left"></i> Back to Sales</button></a>

<div class="content" id="content">
<div style="margin: 0 auto; padding: 20px; width: 900px; font-weight: normal;">
	<div style="width: 100%; height: 190px;" >
	<div style="width: 900px; float: left;">
	<center><div style="font:bold 25px 'Aleo';">Sales Receipt</div>
	Vietstar Shipping<br>
	6799 Wilson Blvd #26	<br>
	Falls Church, Va 22044 	<br>  <br>
	</center>
	<div>
	</div>
	</div>
	<div style="width: 136px; float: left; height: 70px;">
	<table cellpadding="2" cellspacing="0" style="font-family: arial; font-size: 12px;text-align:left;width : 100%;">
		<tr>
			<td>Customer:</td>
			<td><?php echo $cust_name ?></td>
		</tr>
		<tr>
			<td>Invoice No: </td>
			<td><?php echo $invoice ?></td>
		</tr>
		<tr>
			<td>Date:</td>
			<td><?php echo $date ?></td>
		</tr>
	</table>
	
	</div>
	<div class="clearfix"></div>
	</div>
	<div style="width: 100%; margin-top:-70px;">
	<table border="1" cellpadding="4" cellspacing="0" style="font-family: arial; font-size: 12px;	text-align:left;" width="100%">
		<thead>
			<tr>
				<th width="90"> UPC </th>
				<th> Product Name </th>
				<th> Quantity </th>
				<th> Unit Price </th>
				<th> Discount </th>
				<th> Amount </th>
			</tr>
		</thead>
		<tbody>
			
				<?php
					$invoice=$_GET['invoice'];
					$result = $db->prepare("SELECT * FROM sales_order so
					JOIN products p ON so.product_id = p.product_id
					WHERE invoice= :invoice");
					$result->bindParam(':invoice', $invoice);
					$result->execute();
					for($i=0; $row = $result->fetch(); $i++){
				?>
				<tr class="record">
				<td><?php echo $row['product_code']; ?></td>
				<td><?php echo $row['product_name']; ?></td>
				<td><?php echo $row['qty_picked']; ?></td>
				<td>
				<?php
				$ppp=$row['unit_price'];
				echo formatMoney($ppp, true);
				?>
				</td>
				<td>
				<?php
				$ddd=$row['discount'];
				echo formatMoney($ddd, true);
				?>
				</td>
				<td>
				<?php
				$dfdf=$row['sales_order_amount'];
				echo formatMoney($dfdf, true);
				?>
				</td>
				</tr>
				<?php
					}
				?>
			
				<tr>
					<td colspan="5" style=" text-align:right;"><strong style="font-size: 12px;">Total: &nbsp;</strong></td>
					<td colspan="2"><strong style="font-size: 12px;">
					<?php
					$sdsd=$_GET['invoice'];
					$resultas = $db->prepare("SELECT sum(sales_order_amount) FROM sales_order WHERE invoice= :a");
					$resultas->bindParam(':a', $sdsd);
					$resultas->execute();
					for($i=0; $rowas = $resultas->fetch(); $i++){
						$fgfg=$rowas['sum(sales_order_amount)'];
					echo formatMoney($fgfg, true);
					}
					?>
					</strong></td>
				</tr>
				<?php if($pt=='cash'){
				?>
				<tr>
					<!--<td colspan="5"style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">Cash Tendered:&nbsp;</strong></td>
					<td colspan="2"><strong style="font-size: 12px; color: #222222;">-->
					<?php
						//echo formatMoney($cust_payment, true);
					?>
					</strong></td>
				</tr>
				<?php
				}
				?>
				<tr>
				<td colspan="5" style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">
						<font style="font-size:12px;">
						<?php
						//if($pt=='cash'){
							echo 'Payment:';
						//}
						/*if($pt=='credit'){
							echo 'Credit:';
						}*/
						?>&nbsp;
						</strong>
				</td>
				<td colspan="2"><strong style="font-size: 12px; color: #222222;">	
					<?php
						echo formatMoney($cust_payment, true);
					?>
			
				</td>

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
					?>
					</strong></td>
				</tr>
			
		</tbody>
	</table>
	
	</div>
	</div>
	</div>
	</div>
<div class="pull-right" style="margin-right:100px;">
		<a href="javascript:Clickheretoprint()" style="font-size:20px;"><button class="btn btn-success btn-large"><i class="icon-print"></i> Print</button></a>
		</div>	
</div>
</div>
<script language="javascript">
function Clickheretoprint()
{ 
  var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,"; 
      disp_setting+="scrollbars=yes,width=800, height=400, left=100, top=25"; 
  var content_vlue = document.getElementById("content").innerHTML; 
  
  var docprint=window.open("","",disp_setting); 
   docprint.document.open(); 
   docprint.document.write('</head><body onLoad="self.print()" style="width: 800px; font-size: 13px; font-family: arial;">');          
   docprint.document.write(content_vlue); 
   docprint.document.close(); 
   docprint.focus(); 
}
</script>
</html>


