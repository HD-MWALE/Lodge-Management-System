<?php

ini_set('display_errors', 1);

Class Room_Type_Action {
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

    function update_room_type(){
		extract($_POST);
        $upload_ = '';
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'.../assets/uploads/'. $fname);
			$upload_ = $fname;

		}
        $qry = "UPDATE `roomtype` SET `description`= '$description', `price` = $price, `upload_path` = '.../assets/uploads/1605855720_avatar.jpg' WHERE `room_type` = $room_type";
        $save = $this->db->query($qry);
        //$save = $this->db->query("UPDATE roomtype set $data where room_type = $room_type");

        if($save){
            return 1;
        }else {
            return $qry;
        }
    }
    function select_price(){
        $sql = "SELECT `price` FROM `roomtype` WHERE `room_type` = ?;";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $param_room_type);

        $param_room_type = intval($_GET['roomtype']);
        $stmt->execute();
        $stmt->store_result();      
        $stmt->bind_result($price);
        $stmt->fetch();
        echo 'Price : MWK '.$price;
    }
}