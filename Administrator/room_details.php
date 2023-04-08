<?php //include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary add_room" href="javascript:void(0)"><i class="fa fa-plus"></i> Add Room</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Room Name</th>
						<th>Room Type</th>
						<th>Price (MWK)</th>
						<th>Status</th>
						<th>Date Created</th>
						<th>Date Updated</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
                    $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
                    $roomstatus = array('',"Available","Unavailable");
					$query = "SELECT r.`room_id`, r.`room_name`, r.`status`, r.`date_created`, r.`date_updated`, rt.`room_type`, rt.`price` FROM `room` r, `roomtype` rt WHERE r.`room_type` = rt.`room_type` ORDER BY r.`date_created` desc;";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$stmt->store_result();      
					$stmt->bind_result($room_id, $room_name, $status, $date_created, $date_updated, $room_type, $price);
					while($stmt->fetch()):

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $room_name ?></b></td>
						<td><b><?php echo $roomtype[$room_type] ?></b></td>
						<td><b><?php echo $price ?></b></td>
						<td class="text-center">
                            <?php
							  if($roomstatus[$status] == 'Available'){
							  	echo "<span class='badge badge-success'>{$roomstatus[$status]}</span>";
							  }elseif($roomstatus[$status] == 'Unavailable'){
							  	echo "<span class='badge badge-info'>{$roomstatus[$status]}</span>";
							  }
							?>
                        </td>
						<td><b><?php echo $date_created ?></b></td>
						<td><b><?php echo $date_updated ?></b></td>
						<td class="text-center">
                            <button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu">
		                      <a class="dropdown-item view_room" href="javascript:void(0)" data-id="<?php echo $room_id ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item edit_room" href="javascript:void(0)" data-id="<?php echo $room_id ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_room" href="javascript:void(0)" data-id="<?php echo $room_id ?>">Delete</a>
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
        $('.view_room').click(function(){
			uni_modal("<i class='fa fa-id-card'></i> Room Details","view_room.php?room_id="+$(this).attr('data-id'))
		})
		$('.edit_room').click(function(){
			  uni_modal("<i class='fa fa-id-card'></i> Add Room","edit_room.php?room_id="+$(this).attr('data-id'))
		  })
        $('.delete_room').click(function(){
			_conf("Are you sure to delete <?php echo $room_name ?> room?","delete_room",[$(this).attr('data-id')])
		})
	})
	function delete_room($room_id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_room',
			method:'POST',
			data:{room_id:$room_id},
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