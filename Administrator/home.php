<?php include('./class/db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['login_position'] != 1)
  $twhere = "  ";
?>
<!-- Info boxes -->
 <div class="col-12">
          <div class="card" style="border-top: 3px solid rgb(14, 111, 255);">
            <div class="card-body">
              Welcome <?php echo $_SESSION['login_fullname'] ?>!
            </div>
          </div>
  </div>
  <hr>
  <?php 
/*
    $where = "";
    if($_SESSION['login_position'] == 1){
      $where = " where manager_id = '{$_SESSION['login_staff_id']}' ";
    }elseif($_SESSION['login_position'] == 2){
      $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_staff_id']}]%' ";
    }
     $where2 = "";
    if($_SESSION['login_position'] == 1){
      $where2 = " where p.manager_id = '{$_SESSION['login_staff_id']}' ";
    }elseif($_SESSION['login_position'] == 2){
      $where2 = " where concat('[',REPLACE(p.user_ids,',','],['),']') LIKE '%[{$_SESSION['login_staff_id']}]%' ";
    }*/
    ?>
        
      <div class="row">
        <div class="col-md-8">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0 table-hover">
                <colgroup>
                  <col width="5%">
                  <col width="30%">
                  <col width="35%">
                  <col width="15%">
                  <col width="15%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Project</th>
                  <th>Progress</th>
                  <th>Status</th>
                  <th></th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $stat = array("Pending","Started","On-Progress","On-Hold","Over Due","Done");
                $qry = $conn->query("SELECT * FROM `room` order by `room_id` asc");
                while($row= $qry->fetch_assoc()):
                  $prog= 0;
                $g = $conn->query("SELECT `frequncy`, MAX(`frequncy`) FROM `room`");
                $data = $g->fetch_assoc();
                $tprog = $data['frequncy'];
                $g2 = $conn->query("SELECT `frequncy` FROM `room` where `room_id` = {$row['room_id']}");
                $data = $g2->fetch_assoc();
                $cprog = $data['frequncy'];

                $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                $prod = $conn->query("SELECT * FROM `roomtype` where `room_type` = {$row['room_type']}")->num_rows;
                if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['date_created'])):
                  if($prod  > 0  || $cprog > 0)
                    $row['status'] = 2;
                  else
                    $row['status'] = 1;
                elseif($row['status'] == 2 && strtotime(date('Y-m-d')) > strtotime($row['date_updated'])):
                  $row['status'] = 2;
                endif;
                  ?>
                  <tr>
                      <td>
                         <?php echo $i++ ?>
                      </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['room_name']) ?>
                          </a>
                          <br>
                          <small>
                              <!--Due: --><?php //echo date("Y-m-d",strtotime($row['date_updated'])) ?>
                          </small>
                      </td>
                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                              </div>
                          </div>
                          <small>
                              <?php echo $prog ?> Frequncy
                          </small>
                      </td>
                      <td class="project-state">
                          <?php /*
                            if($stat[$row['status']] =='Pending'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Started'){
                              echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='On-Progress'){
                              echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='On-Hold'){
                              echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Over Due'){
                              echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                            }elseif($stat[$row['status']] =='Done'){
                              echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                            }*/
                          ?>
                      </td>
                      <td>
                        <a class="btn btn-primary btn-sm" href="./index.php?page=view_project&id=<?php echo $row['room_id'] ?>">
                              <i class="fas fa-folder">
                              </i>
                              View
                        </a>
                      </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM `roomtype`")->num_rows; ?></h3>
                  <p>Total Room Types</p>
                </div>
                <div class="icon">
                  <i class="fa fa-layer-group"></i>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM `room`")->num_rows; ?></h3>
                  <p>Total Rooms</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks"></i>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM `room` WHERE `room_type` = 1")->num_rows; ?></h3>
                  <p>Total Superior Rooms</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks"></i>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM `room` WHERE `room_type` = 2")->num_rows; ?></h3>
                  <p>Total Standard Rooms</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks"></i>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM `room` WHERE `room_type` = 3")->num_rows; ?></h3>
                  <p>Total TWin Bed Rooms</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks"></i>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
              <div class="small-box bg-light shadow-sm border">
                <div class="inner">
                  <h3><?php echo $conn->query("SELECT * FROM `room` WHERE `room_type` = 4")->num_rows; ?></h3>
                  <p>Total Single Rooms</p>
                </div>
                <div class="icon">
                  <i class="fa fa-tasks"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
