<?php

ini_set('display_errors', 1);

Class Staff_Action {
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

	function notify_staff(){
		extract($_POST);

		//$query = "SELECT * FROM comments ORDER BY comment_id DESC LIMIT 5";
		$query = "SELECT `customer`.`firstname`, `customer`.`lastname`, `room`.`room_name`, `room`.`room_type`, `bookings`.`date_in`
					FROM `customer`, `room`, `bookings` 
					WHERE `customer`.`customer_id` = `bookings`.`customer_id` 
					AND `room`.`room_id` = `bookings`.`room_id`
					ORDER BY `booking_id` DESC LIMIT 5";
		$result = mysqli_query($this->db, $query);
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
		$result_query = mysqli_query($this->db, $status_query);
		$count = mysqli_num_rows($result_query);
		$data = array(
			'notification' => $output,
			'unseen_notification'  => $count
		);
		echo json_encode($data);
	}

	function login(){
		extract($_POST);
		$sql = "SELECT `staff_id`, `contact`, `username`, `password`, `avatar`, `last_login`, `position`, `date_added`, `date_updated`, concat(firstname,' ',lastname) as fullname FROM staff where email = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("s", $param_email);
		$param_email = $email;
		if($stmt->execute()){
			$stmt->store_result();
			if($stmt->num_rows == 1){      
				$stmt->bind_result($staff_id, $contact, $username, $hashed_password, $avatar, $last_login, $position, $date_added, $date_updated, $fullname);
				$stmt->fetch();
				if(password_verify($password, $hashed_password)){
					$_SESSION['login_staff_id'] = $staff_id;
					$_SESSION['login_fullname'] = $fullname;
					$_SESSION['login_contact'] = $contact;
					$_SESSION['login_username'] = $username;
					$_SESSION['login_avatar'] = $avatar;
					$_SESSION['login_last_login'] = $last_login;
					$_SESSION['login_position'] = $position;

					//$qry = $this->db->query("UPDATE `staff` SET  `last_login` = current_timestamp() WHERE `staff_id` = ".$staff_id)->fetch_array();
					
					if($last_login != ''){
						$sql = "UPDATE `staff` SET  `last_login` = ? WHERE staff_id = ?";
				
						$stmt = $this->db->prepare($sql);
						$stmt->bind_param("si", $param_last_login, $param_staff_id);
						
						$param_last_login = date('Y-m-d h:i:s');
						$param_staff_id = $staff_id;

						if($stmt->execute()){
							return 1;
						}else{
							return 2;
						}
					}else{
						return 3;
					}
				}else{
					return 2;
				}
			}else{
				return 2;
			}
		}
	}

	function change_password_staff(){
		extract($_POST);
		$sql = "UPDATE `staff` SET  `password` = ?, `last_login` = ? WHERE staff_id = ?";
					
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ssi", $param_password, $param_last_login, $param_staff_id);
		
		$param_password = password_hash($password, PASSWORD_DEFAULT);
		$param_last_login = date('Y-m-d h:i:s');
		$param_staff_id = $_SESSION['login_staff_id'];

		if($stmt->execute()){
			return 1;
		}else{
			return 2;
		}
	}

	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location: login.php");
	}

    function save_staff(){
		extract($_POST);
		$sql = "SELECT `staff_id` FROM `staff` WHERE `email` = ? OR `contact` = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ss", $param_email, $param_contact);
		$param_email = $email;
		$param_contact = $contact;
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows == 0){   
			$stmt->bind_result($staff_id);
			$stmt->fetch();
			$sql = "INSERT INTO `staff` (`firstname`, `lastname`, `gender`, `email`, `contact`, `address`, `username`, `password`, `avatar`, `position`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				
			$stmt = $this->db->prepare($sql);
			$stmt->bind_param("ssissssssi", $param_firstname, $param_lastname, $param_gender, $param_email, $param_contact, $param_address, $param_username, $param_password, $param_avatar, $param_position);
			
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/uploads/'. $fname);
				$avatar = $fname;
			}
			$param_firstname = $firstname;
			$param_lastname = $lastname;
			$param_gender = $gender;
			$param_email = $email;
			$param_contact = $contact;
			$param_address = $address;
			$param_username = $username; 
			$param_password = password_hash($password, PASSWORD_DEFAULT); 
			$param_avatar = $avatar;
			$param_position = $position;

			if($stmt->execute()){
				return 1;
			}else{
				return 2;
			}
		}else{
			$resp = $this->update_staff();
			return $resp;
		}
    }

    function update_staff(){
		extract($_POST);

		$sql = "UPDATE `staff` SET `firstname` = ?, `lastname` = ?, `gender` = ?, `email` = ?, `contact` = ?, `address` = ?, `username` = ?, `password` = ?, `avatar` = ?, `position` = ? WHERE `staff_id` = ?";
				
		$stmt = $this->db->prepare($sql);
		$stmt->bind_param("ssissssssii", $param_firstname, $param_lastname, $param_gender, $param_email, $param_contact, $param_address, $param_username, $param_password, $param_avatar, $param_position, $param_staff_id);
		
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/uploads/'. $fname);
			$param_avatar = $fname;
		}
		$param_staff_id = $staff_id;
		$param_firstname = $firstname;
		$param_lastname = $lastname;
		$param_gender = $gender;
		$param_email = $email;
		$param_contact = $contact;
		$param_address = $address;
		$param_username = $username; 
		$param_password = password_hash($password, PASSWORD_DEFAULT); 
		$param_position = $position;

		if($stmt->execute()){
			return 1;
		}else{
			return 2;
		}
    }

    function delete_staff(){
        extract($_POST);
        $sql = "DELETE FROM `staff` WHERE `staff_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $param_staff_id);
        $param_staff_id = $staff_id;
        if($stmt->execute())
            return 1;
    }
}