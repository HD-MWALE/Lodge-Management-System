<?php include './class/db_connect.php' ?>
<?php
if(isset($_GET['room_id'])){
    $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
    $roomstatus = array('',"Available","Unavailable");
    $query = "SELECT r.`room_name`, rt.`description`, r.`status`, r.`date_created`, r.`date_updated`, r.`room_type` FROM `room` r, `roomtype` rt WHERE r.`room_type` = rt.`room_type` AND room_id = ?";
    
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $param_room_id);
	$param_room_id = $_GET['room_id'];
	$stmt->execute();
	$stmt->store_result();      
	$stmt->bind_result($room_name, $description, $status, $date_created, $date_updated, $room_type);
	$stmt->fetch();
}
?>
<div class="container-fluid">
	<div class="card card-widget widget-user shadow">
      <div class="widget-user-header bg-dark">
        <h3 class="widget-user-username"><?php echo $room_name ?></h3>
        <h5 class="widget-user-desc"><?php echo $roomtype[$room_type] ?></h5>
        <h5 class="widget-user-desc">
            <?php
                if($roomstatus[$status] == 'Available'){
                echo "<span class='badge badge-success'>{$roomstatus[$status]}</span>";
                }elseif($roomstatus[$status] == 'Unavailable'){
                echo "<span class='badge badge-info'>{$roomstatus[$status]}</span>";
                }
            ?>
        </h5>
      </div>
      <div class="widget-user-image">

      </div>
      <div class="card-footer">
        <div class="container-fluid">
        	<dl style="float: left;">
        		<dt>Price</dt>
        		<dd><?php 
                if($room_type){
                    $query = "SELECT `price`, `upload_path` FROM `roomtype` WHERE room_type = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $param_room_type);
                    $param_room_type = $room_type;
                    $stmt->execute();
                    $stmt->store_result();      
                    $stmt->bind_result($price, $upload_path);
                    $stmt->fetch();
                    echo $price;
                }
                ?></dd>
                <dt>Discription</dt>
        		<dd><?php echo $description ?></dd>
        	</dl>
            <dl style="float: right; border-left: 2px solid rgb(14, 111, 255); padding-left: 50px;"> 
                <dt>Date Added</dt>
        		<dd><?php echo $date_created ?></dd>
                <dt>Date Updated</dt>
        		<dd><?php echo $date_updated ?></dd>
        	</dl>
        </div>
    </div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>