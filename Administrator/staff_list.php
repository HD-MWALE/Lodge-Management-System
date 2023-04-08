<?php //include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-header">
		<?php if($_SESSION['login_position'] == 1): ?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_staff"><i class="fa fa-plus"></i> Add New Staff</a>
			</div>
		<?php endif; ?>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$type = array('',"Manager","Receptionist");
					$query = "SELECT `staff_id`, `firstname`, `lastname`, `email`, `contact`, `username`, `password`, `avatar`, `last_login`, `position`, `date_added`, `date_updated`, concat(firstname,' ',lastname) as fullname FROM staff order by concat(firstname,' ',lastname) asc";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$stmt->store_result();      
					$stmt->bind_result($staff_id, $firstname, $lastname, $email, $contact, $username, $password, $avatar, $last_login, $position, $date_added, $date_updated, $fullname);
					while($stmt->fetch()):

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $fullname ?></b></td>
						<td><b><?php echo $email ?></b></td>
						<td><b><?php echo $type[$position] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu">
		                      <a class="dropdown-item view_staff" href="javascript:void(0)" data-id="<?php echo $staff_id ?>">View</a>
							  <?php if($_SESSION['login_staff_id'] == $staff_id): ?>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_staff&id=<?php echo $staff_id ?>">Edit</a>
							  <?php elseif($_SESSION['login_position'] == 1): ?>
								<div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_staff&id=<?php echo $staff_id ?>">Edit</a>
							  <?php endif; ?>
							  <?php if($_SESSION['login_position'] == 1): ?>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_staff" href="javascript:void(0)" data-id="<?php echo $staff_id ?>">Delete</a>
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
		$('.view_staff').click(function(){
			uni_modal("<i class='fa fa-id-card'></i> Staff Details","view_staff.php?id="+$(this).attr('data-id'))
		})
		$('.delete_staff').click(function(){
			_conf("Are you sure to delete this <?php echo $type[$position] ?>?","delete_staff",[$(this).attr('data-id')])
		})
	})
	function delete_staff($staff_id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_staff',
			method:'POST',
			data:{staff_id:$staff_id},
			success:function(resp){
				console.log(resp);
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