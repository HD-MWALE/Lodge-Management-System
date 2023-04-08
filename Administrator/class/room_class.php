<?php

ini_set('display_errors', 1);

Class Room_Action {
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

    function save_room(){
        extract($_POST);
        if($selected_id == 1){
            $resp = $this->update_room();
            return $resp;
        }else if($selected_id == 0){ 
            $sql = "INSERT INTO `room` (`room_name`, `room_type`, `staff_id`) VALUES (?, ?, ?)";
                
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sii", $param_room_name, $param_room_type, $param_staff_id);
    
            $param_room_name = $room_name;
            $param_room_type = $room_type;
            $param_staff_id = $staff_id;
    
            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }
    }

    function update_room(){
        extract($_POST);
		$sql = "UPDATE `room` SET `room_name` = ?, `room_type` = ? WHERE `room_id` = ?";
				
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("sii", $param_room_name, $param_room_type, $param_room_id);

        $param_room_name = $room_name;
        $param_room_type = $room_type;
        $param_room_id = $room_id;

		if($stmt->execute()){
			return 1;
		}else{
			return 2;
		}
    }

    function select_room(){
        $sql = "SELECT `room`.`room_id`, `room`.`room_name` FROM `room` WHERE `room`.`room_type` = ? AND `room`.`status` = 1 LIMIT 0, 1;";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $param_room_type);

        $param_room_type = intval($_GET['roomtype']);
        $stmt->execute();
        $stmt->store_result();      
        $stmt->bind_result($room_id, $room_name);
        $stmt->fetch();
        if($room_id == ""){
            echo '<span style="color: red;">Room of that type is unavailable...</span>';
        }else{
            $sql = "SELECT `price` FROM `roomtype` WHERE `room_type` = ? LIMIT 0, 1;";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $param_room_type);

            $param_room_type = intval($_GET['roomtype']);
            $stmt->execute();
            $stmt->store_result();      
            $stmt->bind_result($price);
            $stmt->fetch();
            echo '<input type="hidden" name="room_id" value="'.$room_id.'">'
                .'<input type="hidden" id="price" name="price" value="'.$price.'">'
                .'<span style="color: green;">Room Name : '.$room_name.'</span>';
        }
    }

    function checkout_room(){
        $sql = "UPDATE `room` SET `status` = ? WHERE `room_id` = ?";
            
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $param_status, $param_room_id);
        
        $param_status = 1;
        $param_room_id = intval($_GET['room_id']);
        if($stmt->execute()){
            return 1;
        }else{
            return 2;
        }
    }

    function delete_room(){
        extract($_POST);
        $sql = "DELETE FROM `room` WHERE `room_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $param_room_id);
        $param_room_id = $room_id;
        if($stmt->execute())
            return 1;
    }
}