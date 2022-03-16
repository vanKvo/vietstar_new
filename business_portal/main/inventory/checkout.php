<html>
<head>
<title>Checkout</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<style>
#result {
	height:20px;
	font-size:16px;
	font-family:Arial, Helvetica, sans-serif;
	color:#333;
	padding:5px;
	margin-bottom:10px;
	background-color:#FFFF99;
}
#country{
	border: 1px solid #999;
	background: #EEEEEE;
	padding: 5px 10px;
	box-shadow:0 1px 2px #ddd;
    -moz-box-shadow:0 1px 2px #ddd;
    -webkit-box-shadow:0 1px 2px #ddd;
}
.suggestionsBox {
	position: absolute;
	left: 10px;
	margin: 0;
	width: 268px;
	top: 40px;
	padding:0px;
	background-color: #000;
	color: #fff;
}
.suggestionList {
	margin: 0px;
	padding: 0px;
}
.suggestionList ul li {
	list-style:none;
	margin: 0px;
	padding: 6px;
	border-bottom:1px dotted #666;
	cursor: pointer;
}
.suggestionList ul li:hover {
	background-color: #FC3;
	color:#000;
}
ul {
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#FFF;
	padding:0;
	margin:0;
}

.load{
background-image:url(loader.gif);
background-position:right;
background-repeat:no-repeat;
}

#suggest {
	position:relative;
}
.combopopup{
	padding:3px;
	width:268px;
	border:1px #CCC solid;
}

</style>	
</head>
<body onLoad="document.getElementById('country').focus();">
<form action="savesales.php" method="post">
<div id="ac">
<center><h4><i class="icon icon-money icon-large"></i> Payment</h4></center><hr>
<input type="hidden" name="date" value="<?php echo date("y-m-d"); ?>" />
<input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />
<input type="hidden" name="amount" id="amount" value="<?php echo $_GET['total_amount']; ?>" />
<input type="hidden" name="ptype" value="<?php echo $_GET['pmt_method']; ?>" />
<input type="hidden" name="cashier" value="<?php echo $_GET['cashier']; ?>" />
<input type="hidden" name="profit" value="<?php echo $_GET['total_profit']; ?>" />
<center>
	<label> Enter Customer Name </label>
<input type="text" size="25" value="" name="cname" onkeyup="suggest(this.value);" onblur="fill();" class="" autocomplete="off" placeholder="Name" style="width: 268px; height:30px;" />
      <div class="suggestionsBox" id="suggestions" style="display: none;">
        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
      </div>	
	  <label> Payment method </label>
<input type="text" size="25" value="" name="ptype" class="greybox" onblur="fill();" class="" autocomplete="off" placeholder="cash or credit" style="width: 268px; height:30px;" required/>
<label> Customer payment ($)</label>
<input type="text" size="25" value="<?php echo $_GET['total_amount']; ?>" name="cust_payment" id="cust_payment" onblur="fill();" placeholder="0.00" style="width: 268px; height:30px;"/>
<button class="btn btn-success btn-block btn-large" style="width:267px;">Submit</button>
</center>
</div>
</form>
<script>
function suggest(inputString){
		if(inputString.length == 0) {
			$('#suggestions').fadeOut();
		} else {
		$('#country').addClass('load');
			$.post("autosuggestname.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').fadeIn();
					$('#suggestionsList').html(data);
					$('#country').removeClass('load');
				}
			});
		}
	}

	function fill(thisValue) {
		$('.greybox').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 600);
	}

	$( "#cust_given_amount" ).keyup(function() {
		var $amount = parseFloat($("#amount").val());
		var $cust_given_amount = parseFloat($(this).val());
		var $discount = parseFloat($("#discount").val());
		$("#total_payment").val($amount - $discount);
		var $change = $cust_given_amount - $amount - $discount;
		if ($change < 0) $change = 0;
		$("#change").val($change.toFixed(2));
	});

	$( "#discount" ).keyup(function() {
		var $amount = parseFloat($("#amount").val());
		var $discount = parseFloat($("#discount").val());
		$("#cust_payment").val($amount - $discount);
	});
</script>
</body>
</html>