<?php
    $sql = "UPDATE `bookings` SET `status` = 1 WHERE `booking_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $param_booking_id);
    
    $param_booking_id = $_GET['booking_id'];

    if($stmt->execute()){

        $query = "SELECT b.`date_in`, b.`date_out`, c.`firstname`, c.`lastname`, r.`room_name` FROM `bookings` b, `customer` c, `room` r WHERE r.`room_id` = b.`room_id` AND c.`customer_id` = b.`customer_id` AND b.`booking_id` = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $param_booking_id);
        $param_booking_id = $_GET['booking_id'];
        $stmt->execute();
        $stmt->store_result();      
        $stmt->bind_result($date_in, $date_out, $firstname, $lastname, $room_name);
        $stmt->fetch();
        /*
        $qry = $conn->query("SELECT * FROM `bookings` where `booking_id` = ".$_GET['booking_id'])->fetch_array();
        foreach($qry as $k => $v){
            $$k = $v;
        }*/
        include 'view_booking.php';
    }
?>