<?php
function getLastSalesinvoice() {
    global $db;
    $result = $db->prepare("SELECT * FROM sales WHERE sales_id = (SELECT MAX(sales_id) FROM sales)");
	$res = $result->execute();
    $row = $result->fetch();
    $invoice_no = $row['invoice_number'];
    return $invoice_no;
}

function createRandomPassword() {
	$current_invoice = getLastSalesinvoice();
	$next_invoice = $current_invoice +1; 
	return $next_invoice;
}

?>