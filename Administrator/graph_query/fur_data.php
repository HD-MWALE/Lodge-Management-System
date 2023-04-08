<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'ngaliya_db');
$sqlQuery = "SELECT `room_id`, `room_name`, `room_type`, `frequncy` FROM `room` WHERE `frequncy` >= 2 ORDER BY `room_id`";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>