<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/lib/bootstrap.css">
  <link rel="stylesheet" href="../css/lib/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
  <link rel="stylesheet" type="text/css" href="../css/navbar.css">
  <link rel="stylesheet" type="text/css" href="../css/shipping_form.css">
  <script src="../js/lib/jquery.min.js"></script>
	<script src="../js/scripts.js"></script>
  <title>Shipping</title>
</head>
<body>
  <?php include 'navfixed.php';?>
	<nav class="navbar-primary">
		<ul class="navbar-primary-menu">
      <li><a class="d-flex align-items-center pl-3 text-white text-decoration-none"><span class="fs-4">Shipping</span></a></li>     
			<li><a href="../index.php" class="nav-link text-white"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
      <li><a href="." class="nav-link text-white active"> Tìm Khách Hàng (Search Customer)</a></li>
      <li><a href="view/shipping_form_online.php" class="nav-link text-white"> Tạo Đơn Gửi Hàng (Shipping Form)</a></li>
      <li><a href="view/online_shipping_order.php" class="nav-link text-white"> Đơn Gửi Hàng Online (Online Shipping Orders)</a></li>
      <li><a href="view/paid_shipping_order.php" class="nav-link text-white"> Đơn Gửi Hàng Đã Thanh Toán (Order has been paid)</a></li>		
    </ul>
	</nav><!--/.navbar-primary-->
	<div class="main-content">
		<div class="container center mt-0.5">
      <div class="row">
        <div class="col-sm-6">
            <h2>Returning Customer</h2>
            <span>Enter phone number or email</span>
          <div class="search-container">
            <form action="." method="post">
              <input type="text" placeholder="Search.." name="search">
              <button type="submit"><i class="fa fa-search"></i></button>
              <input type="hidden" name="action" value="search_customer">
            </form><!--search-form-->
          </div><!--search-container-->
        </div><!--col-sm-6-->
        <div class="col-sm-6">
           <h2>New Shipping Order</h2>
          <label>Create New Shipping Order</label>
          <form action="." method="post">
            <button type="submit" class="btn btn-primary" style="margin-left: 50px;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <input type="hidden" name="action" value="add_shipping_order">
          </form>          
        </div>
      </div><!--row-->  
  </div><!--container-->   
	</div><!--main-content-->

</body>
<script>
  /** Toggle dashboard */
  $(".toggle-navbar-btn").click(function(){
    $(".navbar-primary").toggle();
  });

</script>

</html>