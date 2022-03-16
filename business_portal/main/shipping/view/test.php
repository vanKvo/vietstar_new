<?php
echo "view/test.php";
require_once '../../connect.php';
require_once '../model/shipping_data.php';
require_once '../model/inventory_data.php';
//$shipord = get_last_shipord() ;
//$mst = $shipord['mst'];
//$product = get_products();
//add_sales(`sales_payment_method`, `sales_custname`, `sales_date`, `sales_amount`, `mst`, `user_id`, `invoice_number`)
//add_sales('cash','Ana','2022-02-15','80','44','1','5');
//add_sales_order(`qty_picked`,`product_id`, `sales_id`)
//add_sales_order('2','64','214');
//$sales_orders = get_sales_order('224');
//print_r($sales_orders);
add_sales_order('10','59', '9', '100', '14006'); // add a new sales order

?>
