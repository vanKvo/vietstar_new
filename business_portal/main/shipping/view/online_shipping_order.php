<?php
require_once '../../connect.php';
require_once '../model/shipping_data.php';
require_once('../../../auth.php');
$position=$_SESSION['SESS_POSITION'];
$name=$_SESSION['SESS_NAME'];
$search_input = trim(filter_input(INPUT_GET, 'search_input', FILTER_SANITIZE_STRING));
$customer = search_customer($search_input);
//print_r($customer);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../css/lib/bootstrap.css">
  <link rel="stylesheet" href="../../css/lib/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../../css/styles.css">
  <link rel="stylesheet" type="text/css" href="../../css/navbar.css">
  <script src="../../js/lib/jquery.min.js"></script>
	<script src="../../js/scripts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<title>Paid Shipping Orders</title>
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
 
   .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   }


   @media only screen and (max-width: 991px) {
  .navbar-primary {
    background: #505251;
  }
  
}
  </style>
</head>

<body>
<?php include 'navfixed.php';?>
	<nav class="navbar-primary sticky">
		<a href="#" class="btn-expand-collapse"><span class="glyphicon glyphicon-menu-left"></span></a>
		<div class="navbar-primary-menu" id="myTopnav"> 
      <li><a class="d-flex align-items-center pl-3 text-white text-decoration-none"><span class="fs-4">Shipping</span></a></li>          
			<li><a href="../../index.php" class="nav-link text-white"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
      <li><a href="../index.php" class="nav-link text-white"> Tìm Khách Hàng (Search Customer)</a></li>
      <li><a href="shipping_form_online.php" class="nav-link text-white"> Tạo Đơn Gửi Hàng (Shipping Form)</a></li>
      <li><a href="online_shipping_order.php" class="nav-link text-white active"> Đơn Gửi Hàng Online (Online Shipping Orders)</a></li>
			<li><a href="paid_shipping_order.php" class="nav-link text-white"> Đơn Gửi Hàng Đã Thanh Toán (Paid Shipping Orders)</a></li>		
    </div>
	</nav><!--/.navbar-primary-->
	<div class="main-content mt-10">
    <div class="container" id="searchApp">
			<br />
			<h3 class="center">Online Shipping Orders</h3>
			<br />
        <div class="center strong">
           From : <input type="date"  v-model="date1" class="tcal"/> To: <input type="date" v-model="date2" class="tcal"/>
         <button class="btn btn-info"  type="submit" @click="fetchData(date1, date2)"><i class="icon icon-search icon-large"></i> Search</button>
      </div>
			<div class="panel panel-default mt-3">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">
						</div>
						<div class="col-md-3 right">
							<input type="text" class="form-control input-sm" placeholder="Search Data" v-model="query" @keyup="fetchData(date1, date2)" />
						</div>
					</div>
				</div><!--panel-heading-->
				<div class="panel-body mt-3">
          <div class="table-responsive">         
						<table class="table table-bordered table-striped">
							<tr>
                <th></th>
								<th>Phone Number</th>
                <th>Sender</th>
                <th>Sender's address</th>
								<th>Receiver</th> 
                <th>No. packages</th>
                <th>Order Submitted</th>
							</tr>
							<tr v-for="row in allData">
                <td>
                  <form action="shipping_form_online.php" method="post">
                    <input type="hidden" name="shipping_order_id" v-model="row.shipping_order_id"/>
                    <button type="submit" name="edit" class="btn btn-primary btn-xs edit">Edit</button>
                  </form>
                </td>
								<td>{{ row.cust_phone}}</td>
                <td>{{ row.cust_name}}</td>
								<td>{{ row.cust_address}}, {{ row.cust_city}}, {{ row.cust_state}}, {{ row.cust_zip}}</td>
                <td>{{ row.recipient_name}}</td>
                <td>{{ row.num_of_package}}</td>
                <td>{{ row.submitted_date}}</td>
                
               <!-- <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(row.id)">Delete</button></td>-->
							</tr>
							<tr v-if="nodata">
								<td class="col-2 center">No Data Found</td>
							</tr>
						</table>
					</div>
				</div><!--panel-body-->
			</div>
		</div><!--searchApp-->
  <!--</div>-->
	</div><!--main-content-->  
</body>
</html>

<script>
  /** Toggle dashboard */
  $(".toggle-navbar-btn").click(function(){
    $(".navbar-primary").toggle();
  });

var application = new Vue({
	el:'#searchApp',
	data:{
		allData:'',
		query:'',
		nodata:false,
    date1: new Date((new Date()).valueOf() - 1000*60*60*720).toJSON().slice(0,10), // 30 days before the current date
    date2: new Date().toJSON().slice(0,10) // current date
	},
	methods: {
		fetchData:function(){
			axios.post('../logic/get_online_shipping_orders_new.php', {
				query:this.query,
        date1: this.date1,
        date2: this.date2
			}).then(function(response){
				if(response.data.length > 0)
				{
					application.allData = response.data;
          console.log(application.allData);
					application.nodata = false;
				}
				else
				{
					application.allData = '';
					application.nodata = true;
				}
			});
		},
    getPackage:function(shipping_order_id, num_pkg) {
      console.log(shipping_order_id);
      console.log(num_pkg);
    }
	},
	created:function(){
		this.fetchData();
	}
});

</script>