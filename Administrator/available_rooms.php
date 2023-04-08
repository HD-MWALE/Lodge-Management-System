
 <div class="col-md-12">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Available Rooms</b>
            <div class="card-tools">
            	<button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive" id="printable">
              <table class="table m-0 table-bordered">
                <thead>
					<th>#</th>
					<th>Room Name</th>
					<th>Room Type</th>
					<th>Date Created</th>
					<th>Date Updated</th>
                </thead>
                <tbody>
					<?php
					$i = 1;
                    $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
                    $roomstatus = array('',"Available","Unavailable");
					$query = "SELECT `room_id`, `room_name`, `room_type`, `status`, `date_created`, `date_updated`, `staff_id` FROM `room` WHERE `status` = 1 ORDER BY `room_id` ASC";
					$stmt = $conn->prepare($query);
					$stmt->execute();
					$stmt->store_result();      
					$stmt->bind_result($room_id, $room_name, $room_type, $status, $date_created, $date_updated, $staff_id);
					while($stmt->fetch()):

					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $room_name ?></b></td>
						<td><b><?php echo $roomtype[$room_type] ?></b></td>
						<td><b><?php echo $date_created ?></b></td>
						<td><b><?php echo $date_updated ?></b></td>
					</tr>
					<?php endwhile; ?>	
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
<script>
	$('#print').click(function(){
		start_load()
		var _h = $('head').clone()
		var _p = $('#printable').clone()
		var _d = "<p class='text-center'><b>Available Rooms Report as of (<?php echo date("F d, Y") ?>)</b></p>"
		_p.prepend(_d)
		_p.prepend(_h)
		var nw = window.open("","","width=900,height=600")
		nw.document.write(_p.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)
	})
</script>