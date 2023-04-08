<?php
session_start();
ini_set('display_errors', 1);

Class Customer_Action {
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

    function login_customer(){
        extract($_POST);
        $sql = "SELECT `customer_id`, `firstname`, `lastname`, `national_id`, `email`, `contact`, `address`, `gender`, `password`, `last_login`, `date_added`, `date_updated`, concat(firstname,' ',lastname) AS fullname FROM `customer` WHERE email = ?";
            
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        if($stmt->execute()){
            $stmt->store_result();
			if($stmt->num_rows == 1){      
				$stmt->bind_result($customer_id, $firstname, $lastname, $national_id, $email, $contact, $address, $gender, $hashed_password, $last_login, $date_added, $date_updated, $fullname);
				$stmt->fetch();
				if(password_verify($password, $hashed_password)){
					$_SESSION['login_customer_id'] = $customer_id;
                    $_SESSION['login_customer_national_id'] = $national_id; 
                    $_SESSION['login_customer_email'] = $email; 
                    $_SESSION['login_customer_fullname'] = $fullname;

                    if($last_login != ''){

                        $sql = "UPDATE `customer` SET  `last_login` = ? WHERE customer_id = ?";
                        
                        $stmt = $this->db->prepare($sql);
                        $stmt->bind_param("si", $param_last_login, $param_customer_id);
                        
                        $param_last_login = date('Y-m-d h:i:s');
                        $param_customer_id = $customer_id;

                        if($stmt->execute()){
                            return 1;
                        }else{
                            return 2;
                        }
                    }else{
                        return 2;
                    }
                }else{
                    return 2;
                }
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }

    function logout_customer(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location: home.php");
	}

    function save_customer(){
        extract($_POST);
        if($selected_id == 1){
            $resp = $this->update_customer();
            return $resp;
        }else if($selected_id == 0){ 
            $sql = "INSERT INTO `customer` (`firstname`, `lastname`, `national_id`, `email`, `contact`, `address`, `gender`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssssss", $param_firstname, $param_lastname, $param_national_id, $param_email, $param_contact, $param_address, $param_gender);
            
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_national_id = $national_id;
            $param_email = $email;
            $param_contact = $contact;
            $param_address = $address;
            $param_gender = $gender;

            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }
    }

    function register_customer(){
        extract($_POST);
        $sql = "SELECT `customer_id` FROM `customer` WHERE email = ?";
            
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        if($stmt->execute()){
            $stmt->store_result();
            if($stmt->num_rows > 1){ 
                $sql = "INSERT INTO `customer` (`firstname`, `lastname`, `national_id`, `email`, `contact`, `password`) VALUES (?, ?, ?, ?, ?, ?)";
            
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("ssssssss", $param_firstname, $param_lastname, $param_national_id, $param_email, $param_contact, $param_password);
                
                $param_firstname = $firstname;
                $param_lastname = $lastname;
                $param_national_id = $national_id;
                $param_email = $email;
                $param_contact = $contact;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
        
                if($stmt->execute()){
                    $_SESSION['login_customer_id'] = $customer_id;
                    $_SESSION['login_customer_name'] = $firstname.' '.$lastname; 
                    $_SESSION['login_customer_national_id'] = $national_id; 
                    $_SESSION['login_customer_email'] = $email;
                    return 1; 
                }else{
                    return 2;
                }
            }
        }
    }

    function book(){
        $sql = "INSERT INTO `bookings` (`customer_id`, `room_id`, `date_in`, `date_out`, `total_amount`, `adult_number`, `kids_number`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iissiiii", $param_customer_id, $param_room_id, $param_date_in, $param_date_out, $param_total_amount, $param_adult_number, $param_kids_number, $param_status);
        
        $_SESSION['book_total_amount'] = 100;

        $param_customer_id = $_SESSION['login_customer_id'];
        $param_room_id = $_SESSION['book_room_id'];
        $param_date_in = $_SESSION['book_date_in'];
        $param_date_out = $_SESSION['book_date_out'];
        $param_total_amount = $_SESSION['book_total_amount'];
        $param_adult_number = $_SESSION['book_adult_number'];
        $param_kids_number = $_SESSION['book_kids_number'];
        $param_status = 2;

        if($stmt->execute()){
            $sql = "UPDATE `room` SET `status` = ? WHERE `room_id` = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ii", $param_status, $param_room_id);
            
            $param_status = 2;
            $param_room_id = $_SESSION['book_room_id'];
            if($stmt->execute()){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }

    function update_customer(){
        extract($_POST);
        $sql = "UPDATE `customer` SET `firstname` = ?, `lastname`= ?, `national_id`= ?, `email`= ?, `contact`= ?, `address`= ?, `gender`= ? WHERE customer_id = ?";
            
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssii", $param_firstname, $param_lastname, $param_national_id, $param_email, $param_contact, $param_address, $param_gender, $param_customer_id);
        
        $param_customer_id = $customer_id;
        $param_firstname = $firstname;
        $param_lastname = $lastname;
        $param_national_id = $national_id;
        $param_email = $email;
        $param_contact = $contact;
        $param_address = $address;
        $param_gender = $gender;

        if($stmt->execute()){
            return 3;
        }else{
            return 2;
        }
    }

    function delete_customer(){
        extract($_POST);
        $sql = "DELETE FROM `customer` WHERE `customer_id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $param_customer_id);
        $param_customer_id = $customer_id;
        if($stmt->execute())
            return 1;
    }

    function search_customer(){
        extract($_POST);
        $select = "SELECT `customer_id`, `firstname`, `lastname`, `national_id`, `email`, `contact`, `address`, `gender`, `username`, `password`, `avatar`, `last_login`, `date_added`, `date_updated`, concat(firstname,' ',lastname) AS fullname FROM `customer` WHERE concat(firstname,' ',lastname) = '%$search_here%' OR concat(firstname,' ',lastname) = '%$search_here' OR concat(firstname,' ',lastname) = '$search_here%'";
        $qry = $this->db->query($select)->fetch_array();
        
        foreach($qry as $k => $v){
            $$k = $v;
        }
        if($qry)
            return 1;
    }
}