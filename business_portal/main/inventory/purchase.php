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
<script src="js/jquery.js"></script>
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
					<li class="active"><a href="purchase.php"><i class="icon-group icon-2x"></i> Purchase </a> </li>     
					<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Sales </a></li>             
					<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a></li> 
				</ul>              
		</div><!--/.well -->
	</div><!--/span-->
	<div class="span10">
	<div class="contentheader">
			<i class="icon-group"></i> Purchase
			</div>
			<ul class="breadcrumb">
			<li><a href="../index.php">Dashboard</a></li> /
			<li class="active">Purchase</li>
			</ul>

<div style="margin-top: -19px; margin-bottom: 21px;">
			<?php 
				$result = $db->prepare("SELECT * FROM purchase");
				$result->execute();
				$rowcount = $result->rowcount();
			?>
			<div style="text-align:center;">
			Total Number of Purchase: <font color="green" style="font:bold 22px 'Aleo';"><?php echo $rowcount;?></font>
			</div>
</div>
<input type="text" name="filter" style="padding:15px;" id="filter" placeholder="Search Purchase..." autocomplete="off" />
<a href="addpurchase.php"><Button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Purchase</button></a><br><br>

<table class="table table-bordered" id="resultTable" data-responsive="table" style="text-align: left;">
	<thead>
		<tr>
			<th width="14%"> UPC </th>
			<th width="14%"> Product Name </th>
			<th width="14%"> Supplier's Name</th>
			<th width="14%"> Unit Cost</th>
			<th width="14%"> Quantity</th>
			<th width="14%"> Arrival Date</th>
			<th width="14%"> Action </th>
			<div id="ac">
		</tr>
	</thead>
	<tbody>
		
			<?php
				include('../connect.php');
				$result = $db->prepare("SELECT * FROM purchase 
				JOIN supliers ON purchase.supplier_id = supliers.suplier_id
				JOIN products ON purchase.product_id = products.product_id
				ORDER BY purchase_id DESC");
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
			<td><?php echo $row['product_id']; ?></td>
			<td><?php echo $row['product_name']; ?></td>
			<td><?php echo $row['suplier_name']; ?></td>
			<td><?php echo $row['purchase_cost']; ?></td>
			<td><?php echo $row['purchase_qty']; ?></td>
			<td><?php echo $row['purchase_date']; ?></td>

			<td><a  title="Click To Edit Purchase" rel="facebox" href="editpurchase.php?id=<?php echo $row['purchase_id']; ?>"><button class="btn btn-warning btn-mini"><i class="icon-edit"></i> Edit </button></a> 
			<a href="#" id="<?php echo $row['purchase_id']; ?>" class="delbutton" title="Click To Delete"><button class="btn btn-danger btn-mini"><i class="icon-trash"></i> Delete</button></a></td>
			</tr>
			<?php
				}
			?>
		
	</tbody>
</table>
<div class="clearfix"></div>

</div>
</div>
</div>
</body>
<script type="text/javascript">
$(document).ready(function() {
	$(".delbutton").click(function(){
		//Save the link in a variable called element
		var element = $(this);

		//Find the id of the link that was clicked
		var del_id = element.attr("id");

		//Built a url to send
		var info = 'id=' + del_id;
		console.log("Info: " + info);
		if(confirm("Are you sure want to delete? There is NO undo!"))
					{

		$.ajax({
			type: "GET",
			url: "deletepurchase.php",
			data: info,
			success: function(){
			
			}
		});
						$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
				.animate({ opacity: "hide" }, "slow");

		}
		return false;
	});

</script>
<?php include('footer.php');?>

</html>