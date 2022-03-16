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
      <li><a href="online_shipping_order.php" class="nav-link text-white "> Đơn Gửi Hàng Online (Online Shipping Orders)</a></li>
			<li><a href="paid_shipping_order.php" class="nav-link text-white active"> Đơn Gửi Hàng Đã Thanh Toán (Paid Shipping Orders)</a></li>		
    </div>
	</nav><!--/.navbar-primary-->
	<div class="main-content mt-10">
    <div class="container" id="searchApp">
			<br />
			<h3 class="center">Paid Shipping Orders</h3>
			<br />
      <div class="center strong">
           From : <input type="date"  v-model="date1" class="tcal"/> To: <input type="date" v-model="date2" class="tcal"/>
         <button class="btn btn-info"  type="submit" @click="fetchData(date1, date2)"><i class="icon icon-search icon-large"></i> Search</button>
      </div>
      <button onclick="exportTableToExcel('tblData')"><i class="fa fa-table" aria-hidden="true"></i> Export To Excel</button>
			<div class="panel panel-default mb-3">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">
						</div>
						<div class="col-md-3" class="right mb-3">
							<input type="text" class="form-control input-sm" placeholder="Search Data" v-model="query" @keyup="fetchData()" />
						</div>
					</div>
				</div><!--panel-heading-->
				<div class="panel-body mt-3">
          <div class="table-responsive">
						<table class="table table-bordered table-striped" id="tblData">
							<tr>
								<th>Invoice (MST)</th>
                <th>Pkg Tracking No</th>       
								<th>Sender</th> 
                <th>Sender Address</th> 
                <th>Sender Phone No.</th> 
                <th>Receiver</th> 
                <th>Receiver Address</th> 
                <th>Receiver Phone No.</th> 
                <th>Total weight (lbs.)</th>
                <th>No. packages</th>
                <th>Send Date</th>
                <th>Pkg Description</th>
							</tr>
							<tr v-for="row in allData">
								<td><a v-bind:href="'shipping_invoice.php?mst='+row.mst">{{ row.mst}}</a></td>
                <td>MST {{ row.mst}}-{{ row.pkg_tracking_no}}</td>
								<td>{{ row.cust_name}}</td>
                <td>{{ row.cust_address}}, {{ row.cust_city}}, {{ row.cust_state}}, {{ row.cust_zipcode}}</td>
                <td>{{ row.cust_phone}}</td>
                <td>{{ row.recipient_name}}</td>
                <td>{{ row.recipient_address}}</td>
                <td>{{ row.recipient_phone}}</td>
                <td>{{ row.total_weight}}</td>
                <td>{{ row.num_of_packages}}</td> 
                <td>{{ row.send_date}}</td>
                <td>{{ row.package_desc}}</td>
               <!-- <td><button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchShippingOrd(row.shipping_order_id)">Edit</button></td>-->
              
                <!-- <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(row.id)">Delete</button></td>-->
							</tr>
							<tr v-if="nodata">
								<td colspan="2" align="center">No Data Found</td>
							</tr>
						</table>
					</div>
				</div><!--panel-body-->
			</div>
      <div v-if="myModel">
        <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" @click="myModel=false"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ dynamicTitle }}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>MST</label>
                  <input type="text" class="form-control" v-model="mst" disabled/>
                </div>
                <div class="form-group">
                  <label>Sender</label>
                  <input type="text" class="form-control" v-model="cust_name" />
                </div>
                <div class="form-group">
                  <label>Recipient</label>
                  <input type="text" class="form-control" v-model="recipient_name" />
                </div>
                <div class="form-group">
                  <label>Send Date</label>
                  <input type="date" class="form-control" v-model="send_date" />
                </div>
                <div class="form-group">
                  <label>Departure Date</label>
                  <input type="date" class="form-control" v-model="airport_date" />
                </div>
                <div class="form-group">
                  <label>Total weight</label>
                  <input type="text" class="form-control" v-model="total_wt" />
                </div>
                <div class="form-group">
                  <label>Total payment</label>
                  <input type="text" class="form-control" v-model="total_pmt" />
                </div>
                <br />
                <div align="center">
                <input type="hidden" v-model="hiddenId" />
                <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitData" />
                </div>
              </div>
              </div>
            </div>
          </div><!--modal-wrapper-->
        </div><!--modal-mask-->
        </transition>
      </div><!--myModel-->
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
    date2: new Date().toJSON().slice(0,10), // current date
    myModel: false,
    actionButton:'Insert',
    dynamicTitle:'Add Data',

	},
	methods: {
		fetchData:function(){
			axios.post('../logic/get_paid_shipping_orders.php', {
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
    fetchShippingOrd:function(shipping_order_id){
      axios.post('../logic/action.php', {
        action:'fetchShippingOrd',
        id:shipping_order_id
      }).then(function(response){
        //application.allData = response.data;
        //console.log(application.allData);
        application.mst = response.data[0].mst;
        application.cust_name = response.data[0].cust_name;
        application.recipient_name = response.data[0].recipient_name;
        application.send_date = response.data[0].send_date;
        application.total_wt = response.data[0].total_weight;
        application.total_pmt = response.data[0].total_pmt;
        application.hiddenId = response.data[0].shipping_order_id;
        application.myModel = true;
        application.actionButton = 'Update';
        application.dynamicTitle = 'Edit Data';
      });
    },
    submitData:function(){
      if(application.mst = '')
      {
        if(application.actionButton == 'Insert')
        {
        axios.post('action.php', {
          action:'insert',
          firstName:application.first_name, 
          lastName:application.last_name
        }).then(function(response){
          application.myModel = false;
          application.fetchAllData();
          application.first_name = '';
          application.last_name = '';
          alert(response.data.message);
        });
        }
        if(application.actionButton == 'Update')
        {
        axios.post('../logic/action.php', {
          action:'update',
          firstName : application.first_name,
          lastName : application.last_name,
          hiddenId : application.hiddenId
        }).then(function(response){
          application.myModel = false;
          application.fetchAllData();
          application.first_name = '';
          application.last_name = '';
          application.hiddenId = '';
          alert(response.data.message);
        });
        }
      }
      else
      {
        alert("Fill All Field");
      }
    } 
	},
	created:function(){
		this.fetchData();
	}
});

function exportTableToExcel(tableID, filename = ''){
  var downloadLink;
  var dataType = 'application/vnd.ms-excel';
  var tableSelect = document.getElementById(tableID);
  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
  
  // Specify file name
  filename = filename?filename+'.xls':'excel_data.xls';
  
  // Create download link element
  downloadLink = document.createElement("a");
  
  document.body.appendChild(downloadLink);
  
  if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
  }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
  
      // Setting the file name
      downloadLink.download = filename;
      
      //triggering the function
      downloadLink.click();
  }
}
</script>