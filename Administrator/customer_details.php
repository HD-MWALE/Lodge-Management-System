<?php //include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=add_customer"><i class="fa fa-plus"></i> Add Customer</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table table-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>National/Passport ID</th>
						<th>Full Name</th>
						<th>Gender</th>
						<th>E-mail</th>
						<th>Contact</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
                    $gendertype = array('',"Male","Female","Others");
					$query = "SELECT `customer_id`, `firstname`, `lastname`, `national_id`, `gender`, `email`, `contact`, `address`, `last_login`, `date_added`, `date_updated`, concat(firstname,' ',lastname) AS fullname FROM `customer` order by concat(firstname,' ',lastname) asc";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$stmt->store_result();      
					$stmt->bind_result($customer_id, $firstname, $lastname, $national_id, $gender, $email, $contact, $address, $last_login, $date_added, $date_updated, $fullname);
					while($stmt->fetch()):

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $national_id ?></b></td>
						<td><b><?php echo $fullname ?></b></td>
						<td><b><?php echo $gendertype[$gender] ?></b></td>
						<td><b><?php echo $email ?></b></td>
						<td><b><?php echo $contact ?></b></td>
						<td><b><?php echo $address ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu">
                                <a class="dropdown-item check-in_customer" href="javascript:void(0)" data-id="<?php echo $customer_id ?>">Check-in</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item view_customer" href="javascript:void(0)" data-id="<?php echo $customer_id ?>">View</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./index.php?page=edit_customer&customer_id=<?php echo $customer_id ?>">Edit</a>
                                <?php if($_SESSION['login_position'] == 1): ?>
                                <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_customer" href="javascript:void(0)" data-id="<?php echo $customer_id ?>">Delete</a>
                                <?php endif; ?>
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