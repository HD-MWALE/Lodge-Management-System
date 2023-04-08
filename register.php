<div id="login">
    <div class="container">
        <div class="section-header">
            <h2>Registration</h2>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="login-form" >
                    <form action="" method="POST">
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <label>Your Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="E.g. John Banda" required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group col-sm-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="E.g. email@example.com" required="required" data-validation-required-message="Please enter your email" />
                                <p id="email_err" class="help-block text-danger"><?php echo isset($_SESSION['email_exist']) && $_SESSION['email_exist'] == 1 ? 'Email already exist' : '' ?></p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <label>Your Passport/National ID</label>
                                <input type="text" class="form-control" name="national_id" id="nationalid" placeholder="E.g. 00JFS3XC" required="required" data-validation-required-message="Please enter your Passport/National ID" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group col-sm-6">
                                <label>Contact</label>
                                <input type="text" class="form-control" name="contact" id="phone" placeholder="E.g. 265993979170" required="required" data-validation-required-message="Please enter your Contact" />
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <label>Your Password</label>
                                <input type="password" name="password" class="form-control" required="required" data-validation-required-message="Please enter your Password"/>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group col-sm-6">
                            <label>Repeat Your Password</label>
                                <input type="password" name="cpass" class="form-control" required="required" data-validation-required-message="Please re-enter your Password"/>
                                <p class="help-block text-danger"></p>
                                <small id="pass_match" data-status=''></small>
                            </div>
                        </div>
                        <div class="button"><button type="submit" name="register">Register</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>/*
    $('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})
          */
</script>
<?php 
include 'Administrator/class/db_connect.php';
if(isset($_POST['register'])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = new mysqli('localhost', 'root', '', 'ngaliya_db');
        $name = $fullname = $email = $national_id = $contact = $password = $cpass = "";
        function split_name($name) {
            $name = trim($name);
            $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
            return array($first_name, $last_name);
        }
        $name = $_POST['name'];
        $email = $_POST['email'];
        $national_id = $_POST['national_id'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $cpass = $_POST['cpass'];
        $fullname = split_name($name);
        $sql = "SELECT `customer_id` FROM `customer` WHERE email = ?";
            
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $param_email);
        $param_email = $email;
        if($stmt->execute()){
            $stmt->store_result();
            if($stmt->num_rows == 0){ 
                $sql = "INSERT INTO `customer` (`firstname`, `lastname`, `national_id`, `email`, `contact`, `password`) VALUES (?, ?, ?, ?, ?, ?)";
            
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $param_firstname, $param_lastname, $param_national_id, $param_email, $param_contact, $param_password);
                
                $param_firstname = $fullname[0];
                $param_lastname = $fullname[1];
                $param_national_id = $national_id;
                $param_email = $email;
                $param_contact = $contact;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
        
                if($stmt->execute()){
                    $sql = "SELECT `customer_id` FROM `customer` WHERE email = ?";
            
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $param_email);
                    $param_email = $email;
                    $stmt->execute();
                    $stmt->store_result();      
					$stmt->bind_result($customer_id);
					$stmt->fetch();

                    $_SESSION['login_customer_id'] = $customer_id;
                    $_SESSION['login_customer_name'] = $firstname.' '.$lastname; 
                    $_SESSION['login_customer_national_id'] = $national_id; 
                    $_SESSION['login_customer_email'] = $email;

                    $sql = "UPDATE `customer` SET  `last_login` = ? WHERE customer_id = ?";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $param_last_login, $param_customer_id);
                    
                    $param_last_login = date('Y-m-d h:i:s');
                    $param_customer_id = $customer_id;

                    $stmt->execute();
                    
                    echo "<script>
                            setTimeout(function(){
                                location.replace('index.php?page=home')
                            },750)
                        </script>";
                }else{
                    echo "<script>alert('Something went wrong.');</script>";
                }
            }else{
                echo "<script>
                        document.getElementById('email_err').innerHTML = 'Email already exist';
                    </script>";
            }
        }else{
            echo "<script>alert('Something went wrong.');</script>";
        }
    }
}
?>