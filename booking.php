<!-- Booking Section Start -->
<div id="booking">
            <div class="container">
                <div class="section-header">
                    <h2>Room Booking</h2>
                    <p>
                        Fill in the booking details to book for a room.
                    </p>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="booking-form">
                            <div id="success"></div>
                            <form name="bookingForm" id="bookingForm" method="POST" novalidate="novalidate">
                                <div class="form-row">
                                    <div class="control-group col-sm-6">
                                        <label>Total Amount : </label>
                                        <label id="total_amount_label">Total Amount</label>
                                        <input type="text" id="total_amount" hidden name="total_amount">
                                    </div>
                                    <div class="control-group col-sm-6">
                                        <label for="">Room Type</label>
                                        <select name="room_type" onchange="allocate_room(this.value)" id="type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1" <?php echo isset($room_type) && $room_type == 1 ? 'selected' : '' ?>>Superior</option>
                                            <option value="2" <?php echo isset($room_type) && $room_type == 2 ? 'selected' : '' ?>>Standard</option>
                                            <option value="3" <?php echo isset($room_type) && $room_type == 3 ? 'selected' : '' ?>>Twin Bed</option>
                                            <option value="4" <?php echo isset($room_type) && $room_type == 4 ? 'selected' : '' ?>>Single Bed</option>
                                        </select>
                                        <span class="form-group" id="txtroomtype"></span>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="control-group col-sm-6">
                                        <label>Check-In</label>
                                        <input type="date" name="date_in" class="form-control" onchange="date_()" id="date_in" required="required" min=
                                        <?php 
                                            $todays_date=date('Y-m-d'); 
                                            echo $todays_date;
                                        ?> 
                                        max=
                                        <?php 
                                            $max_date=date_create(date('Y-m-d'));
                                            date_add($max_date,date_interval_create_from_date_string("14 days")); 
                                            echo date_format($max_date,"Y-m-d");
                                        ?>
                                        required value="<?php echo isset($date_in) ? $date_in : '' ?>"/>
                                            <input type="time" hidden name="currentTime" id="currentTime">
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="control-group col-sm-6">
                                        <label>Check-Out</label>
                                        <input type="date" name="date_out" onchange="days()" class="form-control" id="date_out" required="required"
                                        max=
                                        <?php 
                                            $max_date=date_create(date('Y-m-d'));
                                            date_add($max_date,date_interval_create_from_date_string("90 days")); 
                                            echo date_format($max_date,"Y-m-d");
                                        ?>
                                        required value="<?php echo isset($date_out) ? $date_out : '' ?>"/>
                                        <p id="txt" class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="control-group col-sm-6">
                                        <label for="">Adult Number</label>
                                        <select name="adult_number" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                    <div class="control-group col-sm-6">
                                        <label for="">Kids Number</label>
                                        <select name="kids_number" class="form-control">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        <p class="help-block text-danger"></p>
                                    </div>
                                </div>
                                <div class="button"><button name="booking" type="submit">Book Now</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking Section End -->
<script>
function date_(){
    document.getElementById('date_out').min = document.getElementById('date_in').value;
}
function days(){
    var date1 = document.getElementById('date_in').value;
    var date2 = document.getElementById('date_out').value;
    var price = document.getElementById('price').value;

    // First we split the values to arrays date1[0] is the year, [1] the month and [2] the day
    date1 = date1.split('-');
    date2 = date2.split('-');

    // Now we convert the array to a Date object, which has several helpful methods
    date1 = new Date(date1[0], date1[1], date1[2]);
    date2 = new Date(date2[0], date2[1], date2[2]);

    // We use the getTime() method and get the unixtime (in milliseconds, but we want seconds, therefore we divide it through 1000)
    date1_unixtime = parseInt(date1.getTime() / 1000);
    date2_unixtime = parseInt(date2.getTime() / 1000);

    // This is the calculated difference in seconds
    var timeDifference = date2_unixtime - date1_unixtime;

    // in Hours
    var timeDifferenceInHours = timeDifference / 60 / 60;

    // and finaly, in days :)
    var days = timeDifferenceInHours  / 24;

    document.getElementById('txt').innerHTML = days;
    document.getElementById('total_amount').value = days * price;
    document.getElementById('total_amount_label').innerText = days * price;
}

function allocate_room(roomtype) {
    var message = '<span style="color: white;">select room type</span>';
    if (roomtype == "") {
        document.getElementById("txtroomtype").innerHTML = message;
        return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtroomtype").innerHTML = this.responseText;
            
        }
    }
    xmlhttp.open("GET","./Administrator/ajax.php?action=getroom&roomtype="+roomtype,true);
    xmlhttp.send();
}
const getTwoDigits = (value) => value < 10 ? `0${value}` : value;

const formatDate = (date) => {
  const day = getTwoDigits(date.getDate());
  const month = getTwoDigits(date.getMonth() + 1); // add 1 since getMonth returns 0-11 for the months
  const year = date.getFullYear();

  return `${year}-${month}-${day}`;
}

const formatTime = (date) => {
  const hours = getTwoDigits(date.getHours());
  const mins = getTwoDigits(date.getMinutes());

  return `${hours}:${mins}`;
}

const date = new Date();
document.getElementById('currentTime').value = formatTime(date);
</script>

<?php
date_default_timezone_set("Africa/Harare");
if(isset($_POST['booking'])){
    include 'Administrator/class/db_connect.php';
    $room_id = $date_in = $date_out = $total_amount = $adult_number = $kids_number = "";
    $room_id = $_POST['room_id'];
    $date_in = $_POST['date_in'].' '.$_POST['currentTime'];
    $date_out = $_POST['date_out'].' '.$_POST['currentTime'];
    $total_amount = $_POST['total_amount'];
    $adult_number = $_POST['adult_number'];
    $kids_number = $_POST['kids_number'];

    $sql = "INSERT INTO `bookings` (`customer_id`, `room_id`, `date_in`, `date_out`, `total_amount`, `adult_number`, `kids_number`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissiiii", $param_customer_id, $param_room_id, $param_date_in, $param_date_out, $param_total_amount, $param_adult_number, $param_kids_number, $param_status);

    $param_customer_id = $_SESSION['login_customer_id'];
    $param_room_id = $room_id;
    $param_date_in = $date_in;
    $param_date_out = $date_out;
    $param_total_amount = $total_amount;
    $param_adult_number = $adult_number;
    $param_kids_number = $kids_number;
    $param_status = 2;

    if($stmt->execute()){
        $sql = "UPDATE `room` SET `status` = ? WHERE `room_id` = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $param_status, $param_room_id);
        
        $param_status = 2;
        $param_room_id = $room_id;
        if($stmt->execute()){
            echo "<script>
                    setTimeout(function(){
                        location.replace('index.php?page=booking_details')
                    },750)
                </script>";
        }else{
            echo "<script>
                alert('2Something Went Wrong');
            </script>";
        }
    }else{
        echo "<script>
                alert('".$_SESSION['login_customer_id']."Something Went Wrong');
            </script>";
    }
}
?>