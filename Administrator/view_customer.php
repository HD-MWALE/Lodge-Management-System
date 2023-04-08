<?php include './class/db_connect.php' ?>
<?php
if(isset($_GET['customer_id'])){
    $gendertype = array('',"Male","Female","Others");
	$query = "SELECT `firstname`, `lastname`, `national_id`, `gender`, `email`, `contact`, `address`, `username`, `avatar`, `last_login`, `date_added`, `date_updated`, concat(firstname,' ',lastname) AS fullname FROM customer where customer_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $param_customer_id);
	$param_customer_id = $_GET['customer_id'];
	$stmt->execute();
	$stmt->store_result();      
	$stmt->bind_result($firstname, $lastname, $national_id, $gender, $email, $contact, $address, $username, $avatar, $last_login, $date_added, $date_updated, $fullname);
	$stmt->fetch();
}
?>
<div class="container-fluid">
	<div class="card card-widget widget-user shadow">
      <div class="widget-user-header bg-dark">
        <h3 class="widget-user-username"><?php echo $fullname ?></h3>
        <h5 class="widget-user-desc"><?php echo $email ?></h5>
      </div>
      <div class="widget-user-image">
      	<?php if(empty($avatar) || (!empty($avatar) && !is_file('assets/uploads/'.$avatar))): ?>
      	<span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px"><h4><?php echo strtoupper(substr($firstname, 0,1).substr($lastname, 0,1)) ?></h4></span>
      	<?php else: ?>
        <img class="img-circle elevation-2" src="assets/uploads/<?php echo $avatar ?>" alt="User Avatar"  style="width: 90px;height:90px;object-fit: cover">
      	<?php endif ?>
      </div>
      <div class="card-footer">
        <div class="container-fluid">
        	<dl style="float: left; border-right: 2px solid rgb(14, 111, 255); padding-right: 55px;"> 
        		<dt>National/<br>Passport ID</dt>
        		<dd><?php echo $national_id ?></dd>
        		<dt>Gender</dt>
        		<dd><?php echo $gendertype[$gender] ?></dd>
                <dt>Date Added</dt>
        		<dd><?php echo $date_added ?></dd>
        	</dl>
            <dl style="float: right;"> 
        		<dt>Contact</dt>
        		<dd><?php echo $contact ?></dd>
        		<dt>Address</dt>
        		<dd><?php echo $address ?></dd>
                <dt>Date Updated</dt>
        		<dd><?php echo $date_updated ?></dd>
        	</dl>
        </div>
    </div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>