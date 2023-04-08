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
        <script src="../vendor/jquery/jquery.min.js"></script>
<script src="../assets/plugins/chart.js/Chart.min.js"></script>
      <div class="row">
        <div class="col-md-8">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Project Progress</b>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
            <div id="chart-container">
                <canvas id="graphCanvas"></canvas>
            </div>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-4">
          <div class="row">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
             
              </div>
              <div class="icon">
                <i class="fa fa-layer-group"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-12">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php //echo $conn->query("SELECT t.*,p.name as pname,p.start_date,p.status as pstatus, p.end_date,p.id as pid FROM task_list t inner join project_list p on p.id = t.project_id $where2")->num_rows; ?></h3>
                <p>Total Tasks</p>
              </div>
              <div class="icon">
                <i class="fa fa-tasks"></i>
              </div>
            </div>
          </div>
      </div>
        </div>
      </div>
      <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("graph_query/fur_data.php",
                function (data)
                {
                    console.log(data);
                     var room_name = [];
                     var room_type = [];
                     var frequncy = [];

                    for (var i in data) {
                        room_name.push(data[i].room_name);
                        room_type.push(data[i].room_type);
                        frequncy.push(data[i].frequncy);
                    }

                    var chartdata = {
                        labels: room_name,
                        datasets: [
                            {
                                label: 'Frequntly Used Rooms',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: frequncy
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
        </script>