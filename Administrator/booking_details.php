<?php //include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=customer_details"><i class="fa fa-plus"></i> Check-in Customer</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Full Name</th>
						<th>Room Name</th>
						<th>Date In</th>
						<th>Date Out</th>
						<th>Paid Amount</th>
						<th>Total Amount</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$bookstatus = array("Checked-out","Checked-in","Booking","Cancelled");
					$query = "SELECT `customer`.`firstname`, `customer`.`lastname`, `room`.`room_id`, `room`.`room_name`, `bookings`.`booking_id`, `bookings`.`date_in`, `bookings`.`date_out`, `bookings`.`total_amount`, `bookings`.`paid_amount`, `bookings`.`adult_number`, `bookings`.`kids_number`, `bookings`.`status` FROM `customer` , `bookings` , `room` WHERE `customer`.`customer_id` = `bookings`.`customer_id` AND `room`.`room_id` = `bookings`.`room_id`;";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$stmt->store_result();      
					$stmt->bind_result($firstname, $lastname, $room_id, $room_name, $booking_id, $date_in, $date_out, $total_amount, $paid_amount, $adult_number, $kids_number, $status);
					while($stmt->fetch()):

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $firstname.' '.$lastname ?></b></td>
						<td><b><?php echo $room_name ?></b></td>
						<td><b><?php echo $date_in ?></b></td>
						<td><b><?php echo $date_out ?></b></td>
						<td><b><?php echo $paid_amount ?></b></td>
						<td><b><?php echo $total_amount ?></b></td>
						<td><b>
							<?php
								if($bookstatus[$status] == 'Checked-out'){
									echo "<span class='badge badge-danger'>{$bookstatus[$status]}</span>";
								}elseif($bookstatus[$status] == 'Checked-in'){
									echo "<span class='badge badge-success'>{$bookstatus[$status]}</span>";
								}elseif($bookstatus[$status] == 'Booking'){
									echo "<span class='badge badge-primary'>{$bookstatus[$status]}</span>";
								}elseif($bookstatus[$status] == 'Cancelled'){
									echo "<span class='badge badge-primary'>{$bookstatus[$status]}</span>";
								}
							?>
						</b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
							Action
							</button>
							<div class="dropdown-menu">
								<?php if($bookstatus[$status] != 'Cancelled'): ?>
								<form action="" id="manage_checkout<?php echo $booking_id ?>">
									<input type="hidden" id="room_id" name="room_id" value="<?php echo $room_id ?>">
									<input type="hidden" id="booking_id" name="booking_id" value="<?php echo $booking_id ?>">
									<button class="btn btn-primary mr-2 dropdown-item">Check-out</button> 
								</form>
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
								<?php endif; ?>
								<?php if($bookstatus[$status] == 'Cancelled'): ?>
									<h3 class="btn btn-primary mr-2 dropdown-item">Cancelled</h3> 
								<?php endif; ?>
								<div class="dropdown-divider"></div>
							</div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.check-in_customer').click(function(){
			uni_modal("<i class='fa fa-id-card'></i> Check-in Customer","check-in_customer.php?customer_id="+$(this).attr('data-id'))
		})
		$('.view_customer').click(function(){
			uni_modal("<i class='fa fa-id-card'></i> Customer Details","view_customer.php?customer_id="+$(this).attr('data-id'))
		})
		$('.delete_customer').click(function(){
			_conf("Are you sure to delete <?php echo $fullname ?>?","delete_customer",[$(this).attr('data-id')])
		})
	})

	function delete_customer($customer_id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_customer',
			method:'POST',
			data:{customer_id:$customer_id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>