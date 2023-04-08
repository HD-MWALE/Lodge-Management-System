<?php
?>
<div class="col-lg-12">
	<div class="card" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-body">
			<form action="" id="manage_customer">
				<input type="hidden" name="id" value="<?php echo isset($customer_id) ? $customer_id : 0 ?>">
				<?php
				$selected_id = '';
				if(isset($customer_id)){
                    $selected_id = 1;
                    $_SESSION['customer_id'] = $customer_id;
                }else{ 
                    $selected_id = 0;
                }?>
				<input type="hidden" name="selected_id" value="<?php echo isset($room_id) ? $selected_id : '' ?>">
				
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">First Name</label>
							<input type="text" name="firstname" class="form-control form-control-sm bottom_line" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Last Name</label>
							<input type="text" name="lastname" class="form-control form-control-sm bottom_line" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
						</div>
                        <div class="form-group">
							<label for="" class="control-label">Gender</label>
							<select name="gender" id="type" class="custom-select custom-select-sm bottom_line">
								<option value="1" <?php echo isset($gender) && $gender == 1 ? 'selected' : '' ?>>Male</option>
								<option value="2" <?php echo isset($gender) && $gender == 2 ? 'selected' : '' ?>>Female</option>
								<option value="3" <?php echo isset($gender) && $gender == 3 ? 'selected' : '' ?>>Others</option>
							</select>
						</div>
                        <div class="form-group">
							<label for="" class="control-label">National/Passport ID</label>
							<input type="text" name="national_id" class="form-control form-control-sm bottom_line" required value="<?php echo isset($national_id) ? $national_id : '' ?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">E-mail</label>
							<input type="email" class="form-control form-control-sm bottom_line" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>
                        <div class="form-group">
							<label class="control-label">Contact</label>
							<input type="text" class="form-control form-control-sm bottom_line" name="contact" required value="<?php echo isset($contact) ? $contact : '' ?>">
						</div>
                        <div class="form-group">
							<label class="control-label">Address</label>
                            <textarea name="address" class="form-control form-control-sm bottom_line" cols="30" rows="2" required><?php echo isset($address) ? $address : '' ?></textarea>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2"><?php echo isset($customer_id) ? 'Update' : 'Save' ?></button>
					<button class="btn btn-danger" type="button" onclick="location.href = 'index.php?page=customer_details'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	.bottom_line{
		border-bottom: 2px solid rgb(14, 111, 255);
	}
</style>
<script>
	$('#manage_customer').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		
		$.ajax({
			url:'ajax.php?action=save_customer',
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
						location.replace('index.php?page=customer_details')
					},750)
				}else if(resp == 2){
					alert_toast('Something went wrong, Try later...',"warning");
					end_load()
				}else if(resp == 3){
					alert_toast('Data successfully updated.',"success");
					setTimeout(function(){
						location.replace('index.php?page=customer_details')
					},750)
                }
			}
		})
	})
</script>