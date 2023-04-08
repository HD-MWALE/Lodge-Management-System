<?php

ini_set('display_errors', 1);

Class Bookings_Action {
    private $db;
    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }
    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function check_in(){
        extract($_POST);
        $sql = "INSERT INTO `bookings` (`customer_id`, `room_id`, `date_in`, `date_out`, `total_amount`, `paid_amount`, `adult_number`, `kids_number`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iissddii", $param_customer_id, $param_room_id, $param_date_in, $param_date_out, $param_total_amount, $param_paid_amount, $param_adult_number, $param_kids_number);
        
        $param_customer_id = $customer_id;
        $param_room_id = $room_id;   
        $param_date_in = $date_in;
        $param_date_out = $date_out;
        $param_total_amount = $total_amount;
        $param_paid_amount = $total_amount;
        $param_adult_number = $adult_number;
        $param_kids_number = $kids_number;

        if($stmt->execute()){
            $query = "SELECT `frequncy` FROM `room` WHERE `room_id` = ?";
        
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $param_room_id);
            $param_room_id = $room_id;
            $stmt->execute();
            $stmt->store_result();      
            $stmt->bind_result($frequncy);
            $stmt->fetch();

            $sql = "UPDATE `room` SET `status` = 2, `frequncy` = ? WHERE `room_id` = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $param_frequncy, $param_room_id);
            
            $param_frequncy = $frequncy + 1;
            $param_room_id = $room_id;
            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }
    function checkout(){
        extract($_POST);
        $sql = "UPDATE `bookings` SET `status` = ? WHERE booking_id = ?";
            
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $param_status, $param_booking_id);
        
        $param_status = "0";
        $param_booking_id = $booking_id;

        if($stmt->execute()){
            $sql = "UPDATE `room` SET `status` = ? WHERE `room_id` = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $param_status, $param_room_id);
            
            $param_status = 1;
            $param_room_id = $room_id;
            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }
}