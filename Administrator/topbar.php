<link rel="stylesheet" type="text/css"  href="./assets/dist/css/bootstrap.min.css">
<script type="text/javascript" src="./assets/dist/js/jquery.min.js"></script> 
<script type="text/javascript" src="./assets/dist/js/bootstrap.min.js"></script> 
<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <?php if(isset($_SESSION['login_staff_id'])): ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
      </li>
    <?php endif; ?>
      <li>
        <a class="nav-link text-white"  href="./" role="button"> <large><b>Ngaliya Management System</b></large></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
          <span class="label label-pill label-danger count" style="border-radius:10px; font-size:medium;"></span> 
          <i class="fas fa-bell" style="font-size:20px;"></i>
        </a>
        <ul class="dropdown-menu" id="notify"></ul>
      </li>

     <li class="nav-item dropdown">
            <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
              <span>
                <div class="d-felx badge-pill">
                  <span class="fa fa-user mr-2"></span>
                  <img src="" alt="">
                  <span><b><?php echo ucwords($_SESSION['login_fullname']) ?></b></span>
                  <span class="fa fa-angle-down ml-2"></span>
                </div>
              </span>
            </a>
            <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
              <a class="dropdown-item" id="manage_account" data-id="<?php echo $_SESSION['login_staff_id'] ?>" href="javascript:void(0)"><i class="fa fa-cog"></i> Manage Account</a>
              <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
            </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <script>
      $('#manage_account').click(function(){
        uni_modal("<i class='fa fa-id-card'></i> Staff Details","view_staff.php?id="+$(this).attr('data-id'))
      })
      $('.view_booking').click(function(){
        uni_modal("<i class='fa fa-id-card'></i> Booking Details","view_booking.php?booking_id="+$(this).attr('data-id'))
      })
      
      $(document).ready(function(){
        // updating the view with notifications using ajax
        function load_notification(view = ''){
          $.ajax({
              url:"fetch.php",
              method:"POST",
              data:{view:view},
              dataType:"json",
              success:function(data){
                console.log(data);
                $('#notify').html(data.notification);
                if(data.count_notification > 0)
                {
                  $('.count').html(data.count_notification);
                }
              }
          });
        }
        load_notification();
        // load new notifications
        $(document).on('click', '.dropdown-toggle', function(){
            $('.count').html('');
            load_notification('yes');
        });
        setInterval(function(){
            load_notification();
        }, 5000);
    });
  </script>
