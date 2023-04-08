
<?php
    $qry = $conn->query("SELECT *, concat(firstname,' ',lastname) as fullname FROM `customer`")->fetch_array();
    foreach($qry as $k => $v){
        $$k = $v;
    }
    $search_here = $national_id;
?>
<div class="col-lg-12">
	<div class="card" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-body">
			<form action="" id="manage_customer">
				<input type="hidden" name="id" value="<?php echo isset($customer_id) ? $customer_id : 0 ?>">
				<div class="row">
					<div class="col-md-6 border-right">
                    <h2>
                        <span>Search</span>
                        <input type="text" id="search_here" name="search_here" title="Search here by Full Name, National/Passport ID, E-mail or Contact" class="form-control form-control-sm bottom_line" required value="<?php echo isset($search_here) ? $search_here : '' ?>">
                    </h2>
						<div class="form-group">
							<p class="control-label">Full Name</p>
                            <span><?php echo $fullname ?></span>
							<p class="control-label">National/Passport ID</p>
                            <span><?php echo $national_id ?></span>
							<p class="control-label">E-mail</p>
                            <span><?php echo $email ?></span>
							<p class="control-label">Contact</p>
                            <span><?php echo $contact ?></span>
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
					<button class="btn btn-primary mr-2">Check-in</button>
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
	$('#search_here').keypress(function(){	
        start_load()
		$.ajax({
			url:'ajax.php?action=search_customer',
			method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                end_load();

            },
			success:function(resp){
                console.log(resp);
				if(resp==1){
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
    })

	$('#manage_customer').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		
		$.ajax({
			url:'ajax.php?action=save_customer&customer_id=<?php echo isset($customer_id) ? $customer_id : 0 ?>',
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