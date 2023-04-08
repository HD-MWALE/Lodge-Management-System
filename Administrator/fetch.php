<?php 
 include './class/db_connect.php';
/*/$query = "SELECT * FROM comments ORDER BY comment_id DESC LIMIT 5";
if(isset($_POST['view'])){
    // $con = mysqli_connect("localhost", "root", "", "notif");
    if($_POST["view"] != ''){
       $update_query = "UPDATE comments SET comment_status = 1 WHERE comment_status=0";
       mysqli_query($con, $update_query);
    }
		$query = "SELECT `customer`.`firstname`, `customer`.`lastname`, `room`.`room_name`, `room`.`room_type`, `bookings`.`date_in`
					FROM `customer`, `room`, `bookings` 
					WHERE `customer`.`customer_id` = `bookings`.`customer_id` 
					AND `room`.`room_id` = `bookings`.`room_id`
					ORDER BY `booking_id` DESC LIMIT 5";
		$result = mysqli_query($conn, $query);
		$output = '';
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				$output .= '
				<li>
				<a href="#">
				<strong>'.$row["`customer`.`firstname`"].' '.$row["`customer`.`lastname`"].'</strong><br />
				<small><em>'.$row["`room`.`room_name`"].' ('.$row["`room`.`room_type`"].')</em></small>
				</a>
				</li>
				';
			}
		}else{
			$output .= '<li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
		}
		$status_query = "SELECT `customer`.`firstname`, `customer`.`lastname`, `room`.`room_name`, `room`.`room_type`, `bookings`.`date_in`
					FROM `customer`, `room`, `bookings` 
					WHERE `customer`.`customer_id` = `bookings`.`customer_id` 
					AND `room`.`room_id` = `bookings`.`room_id`
					AND `bookings`.`status` = 1";
		$result_query = mysqli_query($conn, $status_query);
		$count = mysqli_num_rows($result_query);
		$data = array(
			'notification' => $output,
			'unseen_notification'  => $count
		);
		echo json_encode($data);
    }
*/
if(isset($_POST['view'])){
    $con = mysqli_connect("localhost", "root", "", "ngaliya_db");

	if($_POST["view"] != ''){
		//$update_query = "UPDATE `booking_id` SET `status` = 2 WHERE `status` = 1";
		//$sql = "UPDATE `bookings` SET `status` = 1 WHERE `booking_id` = ?";
		//mysqli_query($con, $update_query);
	}

	$query = "SELECT `booking_id`, `customer_id`, `room_id`, `date_in`, `date_out`, `total_amount`, `paid_amount`, `adult_number`, `kids_number`, `status`, `date_created`,  `date_updated` FROM `bookings` WHERE `status` = 2 ORDER BY `booking_id` DESC LIMIT 5";
	$result = mysqli_query($con, $query);

	$output = '';
	if(mysqli_num_rows($result) > 0){
		while($data = mysqli_fetch_array($result)){
			$query1 = "SELECT `firstname`, `lastname`, `national_id`, `email`, `contact`, `address`, `gender` FROM `customer` WHERE `customer_id` = ".$data["customer_id"];
			$result1 = mysqli_query($con, $query1);
			$row = mysqli_fetch_array($result1);
			$timeStamp = date( "m/d/Y H:i:s", strtotime($data["date_created"]));
			$dt = date('Y-m-dTH:i:s', strtotime('-2 hours', strtotime($data["date_created"])));
			$ago = time_elapsed_string($dt, true);
			$output .= '<li style="display: inline;"><a class="dropdown-item d-flex align-items-center" href="./index.php?page=edit_booking&booking_id='.$data['booking_id'].'">
				<div class="mr-3">
					<div class=""><i class="fa fa-bed"></i></div>
				</div>
				<div><span class="small text-gray-500"><strong>'.$row["firstname"].' '.$row["lastname"].'</strong></span><br />
					<p>Booked a room.<br /><small>'.$ago.'</small></p>
				</div>
				</a></li>';

		}
	}else{
		$output .= '<li style="display: inline;">
					<div style="float:left;"><span class="small text-bold text-italic text-gray-500"><strong>No Notifications Found.</strong></span>
					</div></li>';
	}

	$status_query = "SELECT `booking_id`, `customer_id`, `room_id`, `date_in`, `date_out`, `total_amount`, `paid_amount`, `adult_number`, `kids_number`, `status` FROM `bookings` WHERE `status` = 2";
	//$status_query = "SELECT * FROM comments WHERE comment_status=0";
	$result_query = mysqli_query($con, $status_query);
	$count = mysqli_num_rows($result_query);
	$data = array(
	'notification' => $output,
	'count_notification'  => $count
	);
	echo json_encode($data);
}
date_default_timezone_set("Africa/Blantyre");
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>