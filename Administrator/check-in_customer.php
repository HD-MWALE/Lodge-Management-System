
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
    $customer_id = $_GET['customer_id'];
}
?>
<div class="container-fluid">
    <form action="" id="manage_checkin">
        <div class="card card-widget widget-user shadow">
            <div class="widget-user-header bg-dark">
                <h3 class="widget-user-username" style="font-size: 24px;"><strong>Customer</strong></h3>
                <h5 class="widget-user-desc">Full Name : <?php echo $fullname.'<br/>E-mail : '.$email.'<br/>National ID : '.$national_id ?></h5>
            </div>

            <div class="card-footer">
                <div class="container-fluid">
                    <div class="form-group">
                        <input type="hidden" name="customer_id" value="<?php echo isset($customer_id) ? $customer_id : 0 ?>">
                        <input type="hidden" name="total_amount" value="<?php echo isset($total_amount) ? $total_amount : 0 ?>">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Room Type</label>
                        <select name="room_type" onchange="allocate_room(this.value)" id="type" class="custom-select custom-select-sm bottom_line">
                            <option value="" selected>---select---</option>
                            <option value="1" <?php echo isset($room_type) && $room_type == 1 ? 'selected' : '' ?>>Superior</option>
                            <option value="2" <?php echo isset($room_type) && $room_type == 2 ? 'selected' : '' ?>>Standard</option>
                            <option value="3" <?php echo isset($room_type) && $room_type == 3 ? 'selected' : '' ?>>Twin Bed</option>
                            <option value="4" <?php echo isset($room_type) && $room_type == 4 ? 'selected' : '' ?>>Single Bed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" id="txtroomtype" class="control-label">select room type</label>

                    </div>
                    <div class="form-group">
                        <label class="control-label">Date in</label>
                        <input type="date" id="date_in" class="form-control form-control-sm bottom_line" name="date_in" min=
						<?php 
							$todays_date=date('Y-m-d'); 
							echo $todays_date;
						?> 
						max=
						<?php 
							$max_date=date_create(date('Y-m-d'));
							date_add($max_date,date_interval_create_from_date_string("14 days")); 
							echo date_format($max_date,"Y-m-d");
						?>
                        required value="<?php echo isset($date_in) ? $date_in : '' ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Date Out</label>
                        <input type="date" id="date_out" class="form-control form-control-sm bottom_line" onchange="date_out(this.value)" name="date_out" min=
						<?php 
                            $todays_date=date_create(date('Y-m-d'));
							date_add($todays_date,date_interval_create_from_date_string("1 days")); 
							echo date_format($todays_date,"Y-m-d");
						?> 
						max=
						<?php 
							$max_date=date_create(date('Y-m-d'));
							date_add($max_date,date_interval_create_from_date_string("90 days")); 
							echo date_format($max_date,"Y-m-d");
						?>
                        required value="<?php echo isset($date_out) ? $date_out : '' ?>">
                        <label id="date_inout" class="control-label"></label>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Adult Number</label>
                        <select name="adult_number" id="adult_number" class="custom-select custom-select-sm bottom_line">
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Kids Number</label>
                        <select name="kids_number" id="kids_number" class="custom-select custom-select-sm bottom_line">
                            <option value="0" >0</option>
                            <option value="1" >1</option>
                            <option value="2" >2</option>       
                        </select>
                    </div>    
                </div>
            </div>
        <div class="modal-footer display p-0 m-0">
            <div class="container-fluid">
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2">Check-in</button> 
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
	.bottom_line{
		border-bottom: 2px solid rgb(14, 111, 255);
	}
    .centered{
        max-width: 300px; 
        margin-left: auto;
        margin-right: auto;
    }
    .form-group{
        text-align: center;
    }
</style>
<script>
    function date_out(date_out){
        var date_in = document.getElementById("date_in").value;
        if(date_out == date_in){
            document.getElementById("date_inout").innerHTML = "Date in and out cannot be the same!";
            document.getElementById("date_in").value = "";
        }
    }
    function allocate_room(roomtype) {
        if (roomtype == "") {
            document.getElementById("txtroomtype").innerHTML="select room type";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtroomtype").innerHTML=this.responseText;
            }
        }
        xmlhttp.open("GET","ajax.php?action=getroom&roomtype="+roomtype,true);
        xmlhttp.send();
    }
	$('#manage_checkin').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		$.ajax({
			url:'ajax.php?action=save_checkin',
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