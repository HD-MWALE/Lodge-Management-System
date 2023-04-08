<?php

$qry = $conn->query("SELECT * FROM `customer` where `customer_id` = ".$_GET['customer_id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'add_customer.php';
?>