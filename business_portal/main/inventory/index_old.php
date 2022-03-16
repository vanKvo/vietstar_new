<?php 
include('../connect.php');
include('function.php');
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

.navbar-header {
  padding-top: 15px;
  padding-bottom: 15px;
  font-size: 18px;
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
<script language="javascript" type="text/javascript">
/* Visit http://www.yaldex.com/ for full source code
and get more free JavaScript, CSS and DHTML scripts! */
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;
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
			<i class="icon-dashboard"></i> Dashboard
			</div>
			<ul class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li> 
			</ul>


<div style="margin-top: -19px; margin-bottom: 21px;">	
	<a  href="../index.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon icon-circle-arrow-left icon-large"></i> Back</button></a>
</div><br><br><br>

<div id="mainmain">
<a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i><br> Sales</a>               
<a href="products.php"><i class="icon-list-alt icon-2x"></i><br> Inventory</a>  
<a href="supplier.php"><i class="icon-group icon-2x"></i><br> Suppliers</a>     
<a href="purchase.php"><i class="icon-group icon-2x"></i><br> Purchase</a>         
<a href="../index.php"><i class="icon-off icon-2x"></i><br> Logout</a> 

<div class="clearfix"></div>
</div>

<div class="clearfix"></div>
</div>
</div>
</div>
</body>
<?php include('footer.php');?>

</html>