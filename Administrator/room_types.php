<?php //include 'db_connect.php' ?>
<style>
.Img {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
  width:100%;
  max-width:100px;
}

.Img:hover {opacity: 0.7;}
</style>



<div class="col-lg-12">
	<div class="card card-outline" style="border-top: 3px solid rgb(14, 111, 255);">
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Image</th>
						<th>Room Type</th>
						<th>Price (MWK)</th>
						<th>Date Created</th>
						<th>Date Updated</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
                    $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
					$query = "SELECT `room_type`, `price`, `upload_path`, `date_created`, `date_updated` FROM `roomtype` order by date_created desc";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$stmt->store_result();      
					$stmt->bind_result($room_type, $price, $upload_path, $date_created, $date_updated);
					while($stmt->fetch()):

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<th><?php echo $upload_path ?>
							<a href="../assets/uploads/<?php echo $upload_path ?>"><img class="Img" src="<?php echo $upload_path ?>" alt="<?php echo $roomtype[$room_type] ?>" /></a>
						</th>
						<td><b><?php echo $roomtype[$room_type] ?></b></td>
						<td><b><?php echo $price ?></b></td>
						<td><b><?php echo $date_created ?></b></td>
						<td><b><?php echo $date_updated ?></b></td>
						<td class="text-center">
                            <a href="javascript:void(0)" data-id="<?php echo $room_type ?>" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info edit_room_type">
                                Edit
                            </a>
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
		$('.edit_room_type').click(function(){
			uni_modal("<i class='fa fa-id-card'></i> Room Type Details","edit_room_type.php?room_type="+$(this).attr('data-id'))
		})
	})
</script>