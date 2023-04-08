

<?php include './class/db_connect.php' ?>
<?php
    $qry = $conn->query("SELECT `room_type`, `price`, `upload_path` FROM `roomtype` where `room_type` = ".$_GET['room_type'])->fetch_array();
    foreach($qry as $k => $v){
        $$k = $v;
    }
    $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
?>
<div class="container-fluid">
    <form action="" id="manage_room_type">
        <div class="card card-widget widget-user shadow">
            <div class="widget-user-header bg-dark">
                <h3 class="widget-user-username"><?php echo $roomtype[$room_type] ?> Room Type</h3>
                <h5 class="widget-user-desc">Current Price : MWK <?php echo $price ?></h5>
            </div>
            <div class="widget-user-image">

                <input type="hidden" name="room_type" value="<?php echo isset($room_type) ? $room_type : 0 ?>">


            </div>
            <div class="card-footer">
                <div class="container-fluid">
                    <dl style="text-align: center;"> 
                        <dt>                
                                <div class="form-group">
                                    <label for="" class="control-label">Description</label>
                                    <input type="text" style="text-align:right;" name="description" style="width: 60px;" class="form-control form-control-sm bottom_line" required value="<?php echo isset($description) ? $description : '' ?>">
                                </div>
                        </dt>
                        <dt>                
                                <div class="form-group">
                                    <label for="" class="control-label">Price</label>
                                    <input type="text" style="text-align:right;" name="price" style="width: 60px;" class="form-control form-control-sm bottom_line" required value="<?php echo isset($price) ? $price : '' ?>">
                                </div>
                        </dt>
                        <dt>
                            <div class="form-group">
                                <label for="" class="control-label">Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
                                    <label class="custom-file-label bottom_line" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </dt>
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($upload_path) ? '../assets/uploads/'.$upload_path :'' ?>" alt="Image" id="cimg" class="img-fluid img-thumbnail ">
						</div>
                    </dl>
                </div>
            </div>
        <div class="modal-footer display p-0 m-0">
            <div class="container-fluid">
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2">Update</button> 
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
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_room_type').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=update_room_type&room_type=<?php echo isset($room_type) ? $room_type : 0 ?>',
			method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                end_load();

            },
			success:function(resp){
                console.log(resp);
				if(resp == 1){
					alert_toast('Data successfully updated.',"success");
					setTimeout(function(){
						location.replace('index.php?page=room_types')
					},750)
				}else if(resp == 2){
					alert_toast('Something went wrong, Try later...',"warning");
					end_load()
				}
			}
		})
	})
</script>