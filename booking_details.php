<?php
if(isset($_GET['action'])):
    include 'Administrator/class/db_connect.php';
    $booking_status = $room_status = "";
    if(isset($_GET['action']) && $_GET['action'] == "cancel"):
        $booking_status = 3;
    elseif(isset($_GET['action']) && $_GET['action'] == "checkout"):
        $booking_status = 0;
    endif;
    $sql = "UPDATE `bookings` SET `status` = ? WHERE booking_id = ?";
        
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $param_status, $param_booking_id);
    
    $param_status = $booking_status;
    $param_booking_id = $_GET['bid'];

    if($stmt->execute()){
        $sql = "UPDATE `room` SET `status` = ? WHERE `room_id` = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $param_status, $param_room_id);
        
        $param_status = 1;
        $param_room_id = $_GET['rid'];
        if($stmt->execute()){
            echo '<script>alert("success");</script>';
        }else{
            echo '<script>alert("22222222");</script>';
        }
    }else{
        echo '<script>alert("11111111");</script>';
    }
endif;
?>
 <div id="about">
    <div class="container">
        <div class="section-header">
            <h2>All Your Bookings</h2>
            <p>
                Here you will find all your booking details.
            </p>
        </div>
        <?php
        include 'Administrator/class/db_connect.php';
        $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
        $query = "SELECT b.`booking_id`, b.`customer_id`, b.`room_id`, b.`date_in`, b.`date_out`, b.`total_amount`, b.`paid_amount`, b.`adult_number`, b.`kids_number`, b.`status`, b.`date_created`, b.`date_updated`, r.`room_type` FROM `bookings` b, `room` r WHERE b.`room_id` = r.`room_id` AND b.`customer_id` = ? ORDER BY `booking_id` DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $param_customer_id);
        $param_customer_id = $_SESSION['login_customer_id'];
        $stmt->execute();
        $stmt->store_result();      
        $stmt->bind_result($booking_id, $customer_id, $room_id, $date_in, $date_out, $total_amount, $paid_amount, $adult_number, $kids_number, $status, $date_created, $date_updated, $room_type);
        while($stmt->fetch()):
        ?>
        <div class="row">
            <div class="col-md-6 content-cols">
                <div class="content-col">
                    <h3><?php echo $roomtype[$room_type]; ?> Room</h3>
                    <p>
                        You checked in on <?php echo $date_in; ?> and checkout on <?php echo $date_out; ?>. 
                    </p>
                    <p>
                        Nam fringilla justo justo. Proin sodales bibendum pharetra. Aliquam blandit sapien eu nisl dictum pretium.
                    </p>
                    <?php if($status == 0):?>
                        <a href="index.php?page=booking_details">Cancelled</a>
                    <?php elseif($status == 1):?>
                        <a href="<?php echo 'index.php?page=booking_details&action=checkout&bid='.$booking_id.'&rid='.$room_id ?>">Check out</a>
                    <?php elseif($status == 2):?>
                        <a href="<?php echo 'index.php?page=booking_details&action=cancel&bid='.$booking_id.'&rid='.$room_id ?>">Cancel</a>
                    <?php elseif($status == 3):?>
                        <a href="<?php echo 'index.php?page=booking&action=rebook&bid='.$booking_id.'&rid='.$room_id ?>">Re-book</a>
                    <?php endif;?>
                </div>
            </div>
        </div>
        
        <hr>
        <?php endwhile ?>
    </div>
</div>
<!-- About Section End -->


								<script>
										$('#manage_checkout<?php echo $booking_id ?>').submit(function(e){
											e.preventDefault()
											$('input').removeClass("border-danger")
											start_load()
											$('#msg').html('')

											$.ajax({
												url:'ajax.php?action=checkout',
												method:'POST',
												data:$(this).serialize(),
												error:err=>{
													console.log(err)
													end_load();

												},
												success:function(resp){
													console.log(resp);
													if(resp == 1){
														alert_toast('Data successfully saved.',"success");
														setTimeout(function(){
															location.replace('index.php?page=booking_details')
														},750)
													}else if(resp == 2){
														alert_toast('Something went wrong, Try later...',"warning");
														end_load()
													}
												}
											})
										})
								</script>