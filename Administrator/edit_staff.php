<?php

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM staff where staff_id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
	include 'new_staff.php';
}
?>