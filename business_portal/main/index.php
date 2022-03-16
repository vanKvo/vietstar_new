<?php
require_once('../auth.php');
$position=$_SESSION['SESS_POSITION'];
$name=$_SESSION['SESS_NAME'];

?>
<!DOCTYPE>
<html>
<head>
<title>Dashboard</title>
<meta name ="viewport" content ="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/lib/bootstrap.css">
<link rel="stylesheet" href="css/lib/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="css/maindashboard.css">
<link rel="stylesheet" type="text/css" href="css/navbar.css">
<script src="js/scripts.js"></script>
<style>
	.sticky {
		position: fixed;
		top: 53 px;
	}

	.top-sticky {
		position: fixed;
		top: 0;
		width: 100%;
}

.navbar-header {
  padding-bottom: 15px;
  font-size: 12px;
}

</style>	
</head>
<body>
  <?php include 'navfixed.php';?>
	<?php if ((strcmp(strtolower($position), 'admin') == 0) || (strcmp(strtolower($position), 'owner') == 0)) { ?>
		<nav class="navbar-primary sticky">
			<a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
			<ul class="navbar-primary-menu">
				<li> <a class="d-flex align-items-center pl-3 text-white text-decoration-none"><span class="fs-4">Dashboard</span></a></li>
				<li class="active"><a href="#" class="nav-link text-white"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li>             
				<li><a href="shipping/index.php" class="nav-link text-white"><i class="icon-truck icon-2x icon-2x"></i> Shipping</a></li>
				<li><a href="inventory/products.php" class="nav-link text-white"><i class="icon-list-alt icon-2x"></i> Inventory</a></li>
				<li><a href="#" class="nav-link text-white"><i class="icon-group icon-2x"></i>Customers</a></li>
				<li><a href="#" class="nav-link text-white"><i class="icon-bar-chart icon-2x"></i> Sales Report</a></li>		
			</ul>
		</nav><!--/.navbar-primary-->
		<div class="main-content">
			<div class="center" style=" font:bold 44px 'Aleo'; text-shadow:1px 1px 25px #000; color:white;">Vietstar Shipping</div>
			<div id="maindashboard">             
				<a href="shipping/index.php"><i class="icon-truck icon-2x"></i><br> Shipping</a>      
				<a href="inventory/products.php"><i class="icon-list-alt icon-2x"></i><br> Inventory</a>       
				<a href="#"><i class="icon-bar-chart icon-2x"></i><br> Sales Report</a>
				<a href="#"><i class="icon-group icon-2x"></i><br> Customers</a>   
				<a href="../logout.php"><i class="icon-off icon-2x"></i><br> Logout</a> 
			</div><!--maindashboard--> 
		</div>
<?php } else { ?>	 
   <nav class="navbar-primary sticky">
			<a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
			<ul class="navbar-primary-menu">
				<li> <a class="d-flex align-items-center pl-3 text-white text-decoration-none"><span class="fs-4">Dashboard</span></a></li>
				<li class="active"><a href="#" class="nav-link text-white"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li>             
				<li><a href="shipping/index.php" class="nav-link text-white"><i class="icon-truck icon-2x icon-2x"></i> Shipping</a></li>
				<li><a href="inventory/products.php" class="nav-link text-white"><i class="icon-list-alt icon-2x"></i> Inventory</a></li>
				<li><a href="#" class="nav-link text-white"><i class="icon-group icon-2x"></i>Customers</a></li>
			</ul>
		</nav><!--/.navbar-primary-->
		<div class="main-content">
			<div class="center" style=" font:bold 44px 'Aleo'; text-shadow:1px 1px 25px #000; color:white;">Vietstar Shipping</div>
			<div id="maindashboard">             
				<a href="shipping/index.php"><i class="icon-truck icon-2x"></i><br> Shipping</a>      
				<a href="inventory/products.php"><i class="icon-list-alt icon-2x"></i><br> Inventory</a>       
				<a href="#"><i class="icon-group icon-2x"></i><br> Customers</a>   
				<a href="../logout.php"><i class="icon-off icon-2x"></i><br> Logout</a> 
			</div><!--maindashboard-->
		</div>
<?php } ?>

</body>
</html>