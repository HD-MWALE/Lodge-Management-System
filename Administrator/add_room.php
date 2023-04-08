<?php session_start() ?>
<div class="container-fluid">
    <form action="" id="manage_room">
		<input type="hidden" name="room_id" value="<?php echo isset($room_id) ? $room_id : '' ?>">
		<?php 
		$selected_id = '';
		if(isset($room_id)){
			$selected_id = 1;
			$_SESSION['room_id'] = $room_id;
			$staff_id = $_SESSION['login_staff_id'];
		}else{ 
			$selected_id = 0;
		}?>
		<input type="hidden" name="staff_id" value="<?php echo isset($room_id) ? $staff_id : '' ?>">
		<input type="hidden" name="selected_id" value="<?php echo isset($room_id) ? $selected_id : '' ?>">
				
        <div class="card card-widget widget-user shadow">
            
            <div class="card-footer">
                <div class="container-fluid">
                    <dl style="text-align: center;"> 
                        <dt>                
							<div class="form-group">
								<label for="" class="control-label">Room Name</label>
								<input type="text" name="room_name" class="form-control form-control-sm bottom_line" required value="<?php echo isset($room_name) ? $room_name : '' ?>">
							</div>
                        </dt>
                        <dt>       
							<div class="form-group">         
								<label for="" class="control-label">Room Type</label>
								<select name="room_type" onchange="select_price(this.value)" id="type" class="custom-select custom-select-sm bottom_line">
									<option value="">---select room type---</option>
									<option value="1" <?php echo isset($room_type) && $room_type == 1 ? 'selected' : '' ?>>Superior</option>
									<option value="2" <?php echo isset($room_type) && $room_type == 2 ? 'selected' : '' ?>>Standard</option>
									<option value="3" <?php echo isset($room_type) && $room_type == 3 ? 'selected' : '' ?>>Twin Bed</option>
									<option value="4" <?php echo isset($room_type) && $room_type == 4 ? 'selected' : '' ?>>Single Bed</option>
								</select>
								<label for="" id="txtprice" class="control-label"></label>
							</div>
						</dt>
                    </dl>
                </div>
            </div>
        <div class="modal-footer display p-0 m-0">
            <div class="container-fluid">
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2"><?php echo isset($room_id) ? 'Update' : 'Save' ?></button> 
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
	img#cimg{
		height: 15vh;
		width: 30vh;
		object-fit: cover;
	}
	.bottom_line{
		border-bottom: 2px solid rgb(14, 111, 255);
	}
</style>
<script>
	function select_price(roomtype) {
        if (roomtype == "") {
            document.getElementById("txtprice").innerHTML="select room type";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange=function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtprice").innerHTML=this.responseText;
            }
        }
        xmlhttp.open("GET","ajax.php?action=getprice&roomtype="+roomtype,true);
        xmlhttp.send();
    }
    $('#manage_room').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		
		$.ajax({
            url:'ajax.php?action=save_room',
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
						location.replace('index.php?page=room_details')
					},750)
				}else if(resp == 2){
					alert_toast('Something went wrong, Try later...',"warning");
					end_load()
				}
			}
		})
	})
</script>