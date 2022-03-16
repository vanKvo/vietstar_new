<?php
require_once '../connect.php';
require_once 'model/shipping_data.php';
require_once 'model/inventory_data.php';
require_once('../../auth.php');
$position=$_SESSION['SESS_POSITION'];
$name=$_SESSION['SESS_NAME'];

/** Get action */
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
//echo "action in index.php: " . $action ."<br>";
if (!$action) {
		$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
		if (!$action) {
				$action = ''; // assigning default value if NULL or FALSE
		}
}

	/** Get data inputs */
	$search_input = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_STRING)); 

/** Handle user requests */
switch($action) {
	case "add_shipping_order":
		header("location: view/shipping_form_online.php");
		break;
	case "search_customer":
		//echo "<br>search input: $search_input <br>";
		if(isset($search_input)) {
			//echo"isset($search_input)";
			$customer = search_customer($search_input);
			if ($customer[1] >= 1) {// the number of result row customer[1] may be equal or more than one because one customer can have more than one recipient
				header("location: view/shipping_form_online.php?search_input=$search_input");
			} else {
			  include 'search_form.php';	
			  echo '<div class="text-center">The customer profile does not exist!</div>';
			}	
		}	
		break;
	default:
	  include 'search_form.php';	
}
/** End User handle requests */
  
?>
