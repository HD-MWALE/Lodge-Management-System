<!-- Room Section Start -->
<div id="rooms">
    <div class="container">
        <div class="section-header">
            <h2>Our Rooms</h2>
            <p>
                These are all the room types we have at Ngaliya Lodge.
            </p>
        </div>
        <?php 
            include 'Administrator/class/db_connect.php';
            $desc = array('','','','');
            $pri = array('','','','');
            $roomt = array('','','','');
            $roomtype = array('',"Superior","Standard","Twin Bed","Single Bed");
            $query = "SELECT `room_type`, `description`, `price` FROM `roomtype`";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->store_result();      
            $stmt->bind_result($room_type, $description, $price);
            $i = 0;
            while($stmt->fetch()):
                $pri[$i] = $price;
                $desc[$i] = $description;
                $roomt[$i] = $roomtype[$room_type];
                $i++;
            endwhile;
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="room-img">
                            <div class="box12">
                                <img src="assets/img/room/room-1.jpg">
                                <div class="box-content">
                                    <h3 class="title"><?php echo $roomt[3] ?></h3>
                                    <ul class="icon">
                                        <li><a href="#" data-toggle="modal" data-target="#modal-id"><i class="fa fa-link"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="room-des">
                            <h3><a href="#" data-toggle="modal" data-target="#modal-id"><?php echo $roomt[3] ?></a></h3>
                            <p>Find you comfort.</p>
                            <p><?php echo $desc[3] ?>.</p>
                            <ul class="room-size">
                                <li><i class="fa fa-arrow-right"></i>Bed: Single </li>
                            </ul>
                            <ul class="room-icon">
                                <li class="icon-1"></li>
                                <li class="icon-4"></li>
                                <li class="icon-5"></li>
                                <li class="icon-6"></li>
                                <li class="icon-7"></li>
                                <li class="icon-8"></li>
                                <li class="icon-9"></li>
                                <li class="icon-10"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="room-rate">
                            <h3>From</h3>
                            <h1>MWK<br/><?php echo $pri[3] ?></h1>
                            <a href="<?php echo isset($_SESSION['login_customer_id']) ? 'index.php?page=booking' : 'index.php?page=login' ?>">Book Now</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="room-img">
                            <div class="box12">
                                <img src="assets/img/room/room-2.jpg">
                                <div class="box-content">
                                    <h3 class="title"><?php echo $roomt[2] ?></h3>
                                    <ul class="icon">
                                        <li><a href="#" data-toggle="modal" data-target="#modal-id"><i class="fa fa-link"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="room-des">
                            <h3><a href="#" data-toggle="modal" data-target="#modal-id"><?php echo $roomt[2] ?></a></h3>
                            <p>travelling is fan.</p>
                            <p><?php echo $desc[2] ?>.</p>
                            <ul class="room-size">
                                <li><i class="fa fa-arrow-right"></i>Beds: Twin </li>
                            </ul>
                            <ul class="room-icon">
                                <li class="icon-1"></li>
                                <li class="icon-4"></li>
                                <li class="icon-5"></li>
                                <li class="icon-6"></li>
                                <li class="icon-7"></li>
                                <li class="icon-8"></li>
                                <li class="icon-9"></li>
                                <li class="icon-10"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="room-rate">
                            <h3>From</h3>
                            <h1>MWK<br/><?php echo $pri[2] ?></h1>
                            <a href="<?php echo isset($_SESSION['login_customer_id']) ? 'index.php?page=booking' : 'index.php?page=login' ?>">Book Now</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="room-img">
                            <div class="box12">
                                <img src="assets/img/room/room-3.jpg">
                                <div class="box-content">
                                    <h3 class="title"><?php echo $roomt[1] ?></h3>
                                    <ul class="icon">
                                        <li><a href="#" data-toggle="modal" data-target="#modal-id"><i class="fa fa-link"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="room-des">
                            <h3><a href="#" data-toggle="modal" data-target="#modal-id"><?php echo $roomt[1] ?></a></h3>
                            <p>Bringing you peaceful sleep.</p>
                            <p><?php echo $desc[1] ?>.</p>
                            <ul class="room-size">
                                <li><i class="fa fa-arrow-right"></i>Bed: Medium</li>
                            </ul>
                            <ul class="room-icon">
                                <li class="icon-1"></li>
                                <li class="icon-2"></li>
                                <li class="icon-4"></li>
                                <li class="icon-5"></li>
                                <li class="icon-6"></li>
                                <li class="icon-7"></li>
                                <li class="icon-8"></li>
                                <li class="icon-9"></li>
                                <li class="icon-10"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="room-rate">
                            <h3>From</h3>
                            <h1>MWK<br/><?php echo $pri[1] ?></h1>
                            <a href="<?php echo isset($_SESSION['login_customer_id']) ? 'index.php?page=booking' : 'index.php?page=login' ?>">Book Now</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="room-img">
                            <div class="box12">
                                <img src="assets/img/room/room-4.jpg">
                                <div class="box-content">
                                    <h3 class="title"><?php echo $roomt[0] ?></h3>
                                    <ul class="icon">
                                        <li><a href="#" data-toggle="modal" data-target="#modal-id"><i class="fa fa-link"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="room-des">
                            <h3><a href="#" data-toggle="modal" data-target="#modal-id"><?php echo $roomt[0] ?></a></h3>
                            <p>Comfortable room with Air Conditioner.</p>
                            <p><?php echo $desc[0] ?>.</p>
                            <ul class="room-size">
                                <li><i class="fa fa-arrow-right"></i>Bed: King Size </li>
                                <li><i class="fa fa-arrow-right"></i>Min-room: Double Bed </li>
                            </ul>
                            <ul class="room-icon">
                                <li class="icon-1"></li>
                                <li class="icon-2"></li>
                                <li class="icon-3"></li>
                                <li class="icon-4"></li>
                                <li class="icon-5"></li>
                                <li class="icon-6"></li>
                                <li class="icon-7"></li>
                                <li class="icon-8"></li>
                                <li class="icon-9"></li>
                                <li class="icon-10"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="room-rate">
                            <h3>From</h3>
                            <h1>MWK<br/><?php echo $pri[0] ?></h1>
                            <a href="<?php echo isset($_SESSION['login_customer_id']) ? 'index.php?page=booking' : 'index.php?page=login' ?>">Book Now</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
<!-- Room Section End -->
        