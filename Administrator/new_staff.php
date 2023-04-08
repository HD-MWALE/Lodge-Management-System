<?php
?>
<div class="col-lg-12">
	<div class="card" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-body">
			<form action="" id="manage_staff">
				<input type="hidden" name="staff_id" value="<?php echo isset($staff_id) ? $staff_id : '' ?>">
				
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
							<select name="gender" id="gender" class="custom-select custom-select-sm bottom_line">
								<option value="1" <?php echo isset($gender) && $gender == 1 ? 'selected' : '' ?>>Male</option>
								<option value="2" <?php echo isset($gender) && $gender == 2 ? 'selected' : '' ?>>Female</option>
								<option value="3" <?php echo isset($gender) && $gender == 3 ? 'selected' : '' ?>>Others</option>
							</select>
						</div>
						<?php if($_SESSION['login_position'] == 1): ?>
						<div class="form-group">
							<label for="" class="control-label">Staff Role</label>
							<select name="position" id="position" class="custom-select custom-select-sm bottom_line">
								<option value="2" <?php echo isset($position) && $position == 2 ? 'selected' : '' ?>>Receptionist</option>
								<option value="1" <?php echo isset($position) && $position == 1 ? 'selected' : '' ?>>Manager</option>
							</select>
						</div>
						<?php else: ?>
							<input type="hidden" name="position" value="2">
						<?php endif; ?>
						<div class="form-group">
							<label for="" class="control-label">Avatar</label>
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label bottom_line" for="customFile">Choose file</label>
		                    </div>
						</div>
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($avatar) ? 'assets/uploads/'.$avatar :'' ?>" alt="Avatar" id="cimg" class="img-fluid img-thumbnail ">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Username</label>
							<input type="text" class="form-control form-control-sm bottom_line" name="username" required value="<?php echo isset($username) ? $username : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">E-mail</label>
							<input type="email" class="form-control form-control-sm bottom_line" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>						
                        <div class="form-group">
							<label class="control-label">Contact</label>
							<input type="text" class="form-control form-control-sm bottom_line" name="contact" required value="<?php echo isset($contact) ? $contact : '' ?>">
							<small id="#msg"></small>
						</div>
                        <div class="form-group">
							<label class="control-label">Address</label>
                            <textarea name="address" class="form-control form-control-sm bottom_line" cols="30" rows="2" required><?php echo isset($address) ? $address : '' ?></textarea>
							<small id="#msg"></small>
						</div>
						<?php isset($staff_id) ? '' : $staff_id = 0 ?>
						<?php if(isset($staff_id) && $_SESSION['login_staff_id'] == $staff_id): ?>
							<div class="form-group">
								<label class="control-label">Password</label>
								<input type="password" class="form-control form-control-sm bottom_line" name="password" <?php echo !isset($staff_id) ? "required":'' ?>>
								<small style="color:rgb(14, 111, 255);"><i><?php echo isset($staff_id) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
							</div>
							<div class="form-group">
								<label class="label control-label">Confirm Password</label>
								<input type="password" class="form-control form-control-sm bottom_line" name="cpass" <?php echo !isset($staff_id) ? 'required' : '' ?>>
								<small id="pass_match" data-status=''></small>
							</div>
						<?php elseif($staff_id == 0 && $_SESSION['login_position'] == 1 && $_SESSION['login_staff_id'] != $staff_id): ?>
							<?php 
								function generate_text($length){ 
									$str_result = '01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
									return substr(str_shuffle($str_result), 0, $length);
								}
								function generate_number($length){ 
									$random = '';
									for($i = 0; $i < $length; $i++){
										$random .= chr(rand(ord('0'), ord('9')));
									}
									return $random;
								}
								do{
									$number = generate_number(3);
								}
								while($number < 3);

								$text = generate_text(3);
								$password = $text.''.$number;
							?>
							<div class="form-group">
								<label class="control-label">Password : <?php echo $password ?></label><br/>
								<small style="color:rgb(14, 111, 255)">One-time Password</small>
								<input type="hidden" value="<?php echo $password ?>" class="form-control form-control-sm bottom_line" name="password" <?php echo !isset($staff_id) ? "required":'' ?>>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2"><?php echo isset($staff_id) && $staff_id != 0 ? 'Update' : 'Save' ?></button>
					<button class="btn btn-danger" type="button" onclick="location.href = 'index.php?page=staff_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
	.bottom_line{
		border-bottom: 2px solid rgb(14, 111, 255);
	}
</style>
<script>
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
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_staff').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		$.ajax({
			url:'ajax.php?action=save_staff',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				console.log(resp);
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=staff_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>