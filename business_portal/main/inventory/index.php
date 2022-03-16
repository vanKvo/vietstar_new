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
					<li class="active"><a href="products.php"><i class="icon-list-alt icon-2x"></i> Inventory</a></li>    
					<li><a href="purchase.php"><i class="icon-group icon-2x"></i> Purchase </a> </li>     
					<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Sales </a></li>             
					<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a></li> 
				</ul>             
          </div><!--/.well -->
  </div><!--/span-->
	<div class="span10">
	<div class="contentheader">
			<i class="icon-table"></i> Products
	</div>
	<ul class="breadcrumb">
	<li><a href="../index.php">Dashboard</a></li> /
	<li class="active">Products</li>
	</ul>


<div style="margin-top: -19px; margin-bottom: 21px;">
			<?php 
				$result = $db->prepare("SELECT * FROM products");
				$result->execute();
				$rowcount = $result->rowcount();
			?>
			
			<?php 
				$result = $db->prepare("SELECT * FROM products where qty_onhand < 10 ORDER BY product_id DESC");
				$result->execute();

				$rowcount123 = $result->rowcount();
			?>
				<div style="text-align:center;">
			Total Number of Products:  <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $rowcount;?>]</font>
			</div>
			
			<div style="text-align:center;">
			<font style="color:rgb(255, 95, 66);; font:bold 22px 'Aleo';">[<?php echo $rowcount123;?>]</font> Products are below QTY of 10 
			</div>
</div>


<input type="text" style="padding:15px;" name="filter" value="" id="filter" placeholder="Search Product..." autocomplete="off" />
<a rel="facebox" href="addproduct.php"><Button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Product</button></a><br><br>
<table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
	<thead>
		<tr>
			<th width="15%"> UPC </th>
			<th width="14%"> Product Name </th>
			<th width="13%"> Category / Description </th>
			<th width="12%"> Position</th>
			<th width="7%"> Supplier </th>
			<th width="6%"> Unit Price </th>
			<th width="6%">Quantity Onhand </th>
			<th width="8%"> Total Price</th>
			<th width="10%"> Action </th>
		</tr>
	</thead>
	<tbody>
		
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
				include('../connect.php');
				$result = $db->prepare("SELECT *, unit_price * qty_onhand as total_price FROM products ORDER BY product_id DESC");
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
				$total=$row['total_price'];
				$availableqty=$row['qty_onhand'];
				if ($availableqty < 10) {
					echo '<tr class="alert alert-warning record" style="color: #fff; background:rgb(255, 95, 66);">';
				}
				else {
					echo '<tr class="record">';
				}
			?>
			<td><?php echo $row['product_code']; ?></td>
			<td><?php echo $row['product_name']; ?></td>
			<td><?php echo $row['product_category']; ?></td>
			<td><?php echo $row['product_location']; ?></td>
			<td><?php echo $row['supplier']; ?></td>
			<td><?php
			$pprice=$row['unit_price'];
			echo formatMoney($pprice, true);
			?></td>
			<td><?php echo $row['qty_onhand']; ?></td>
			<td>
			<?php
			$total=$row['total_price'];
			echo formatMoney($total, true);
			?>
			</td>			<td><a rel="facebox" title="Click to edit the product" href="editproduct.php?product_id=<?php echo $row['product_id']; ?>"><button class="btn btn-warning btn-mini"><i class="icon-edit"></i> Edit </button></a>
			<a href="#" id="<?php echo $row['product_id']; ?>" class="delbutton" title="Click to Delete the product"><button class="btn btn-danger btn-mini"><i class="icon-trash"></i> Delete</button></a>
		</td>
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

<script src="js/jquery.js"></script>
<script type="text/javascript">
$(function() {

$(".delbutton").click(function(){
//Save the link in a variable called element
var element = $(this);
//Find the id of the link that was clicked
var del_id = element.attr("id");
//Built a url to send
var info = 'id=' + del_id;
 if(confirm("Sure you want to delete this Product? There is NO undo!"))
		  {
 $.ajax({
   type: "GET",
   url: "deleteproduct.php",
   data: info,
   success: function(){
   
   }
 });
         $(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		.animate({ opacity: "hide" }, "slow");
 }
return false;
});

});
</script>
</body>
<?php include('footer.php');?>

</html>