<?php
include './class/db_connect.php';
$qry = $conn->query("SELECT * FROM `room` WHERE `room_id` = ".$_GET['room_id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'add_room.php';
?>