<!-- Login Section Start -->
<div id="login">
    <div class="container">
        <div class="section-header">
            <h2>Login</h2>
            <div class="button">Don't have an account.<a href="index.php?page=register"> Click here to Create.</a></button></div>
        </div>
        <div class="row" style="width: 400px; margin-left: auto; margin-right: auto;">
            <div class="col-md-6">
                <div class="login-form" style="width: 400px; margin-left: auto; margin-right: auto;">
                    <form id="login-form" method="POST">
                        <div class="form-row" style="width: 400px; margin-left: auto; margin-right: auto;">
                            <div class="control-group col-sm-6">
                                <label>Your Email</label>
                                <input type="email" name="email" class="form-control" required="required" />
                            </div>
                            <div class="control-group col-sm-6">
                                <label>Your Password</label>
                                <input type="password" name="password" class="form-control" required="required" />
                            </div>
                        </div>
                        <div class="button"><button style="width: 400px;" name="login" type="submit">Login</button></div>
                        <div class="button"><a href="index.php?page=forgot-password">Forgot password.</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Section End -->
<?php
include 'Administrator/class/db_connect.php';
$email = $password = "";
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT `customer_id`, `firstname`, `lastname`, `national_id`, `email`, `contact`, `address`, `gender`, `password`, `last_login`, `date_added`, `date_updated`, concat(firstname,' ',lastname) AS fullname FROM `customer` WHERE email = ?";
                
    $stmt = $conn->prepare($sql);
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
                echo "<script>alert('3Something went wrong.');</script>";
            }
        }else{
            echo "<script>alert('2Something went wrong.');</script>";
        }
    }else{
        echo "<script>alert('1Something went wrong.');</script>";
    }
}
?>