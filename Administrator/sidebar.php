  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
   	<a id="view_account" data-id="<?php echo $_SESSION['login_staff_id'] ?>" href="javascript:void(0)" class="brand-link">
        <?php if($_SESSION['login_avatar'] != ""): ?>
          <h3 class="text-center p-0 m-0"><b>
          <?php $avatar_path = "../assets/uploads/".$_SESSION['login_avatar'] ?>
          <img style="height:40px;width:40px;margin-top:-10px;border:2px solid #fff;border-radius: 50%;" src="<?php echo $avatar_path ?>" alt="">
          </b></h3>
        <?php else: ?>
          <?php if($_SESSION['login_position'] == 1): ?>
          <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
          <?php else: ?>
          <h3 class="text-center p-0 m-0"><b>USER</b></h3>
          <?php endif; ?>
        <?php endif; ?>

    </a>
      
    </div>
    <div class="sidebar pb-4 mb-4">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>  

           <li class="nav-item">
             <a href="#" class="nav-link nav-reports">
               <i class="fas fa-user-plus nav-icon"></i>
               <p>
                 Customer
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="./index.php?page=add_customer" class="nav-link nav-add_customer tree-item">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Add Customer</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="./index.php?page=customer_details" class="nav-link nav-customer_details tree-item">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Customer Details</p>
                 </a>
               </li> 
             </ul>
           </li>
           
           <li class="nav-item">
             <a href="#" class="nav-link nav-reports">
               <i class="fas fa-tasks nav-icon"></i>
               <p>
                 Bookings
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview"><!--
               <li class="nav-item">
                 <a href="./index.php?page=check-in_customer" class="nav-link nav-check-in_customer tree-item">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Check-in Customer</p>
                 </a>
               </li>-->
               <li class="nav-item">
                 <a href="./index.php?page=booking_details" class="nav-link nav-booking_details tree-item">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Bookings Details</p>
                 </a>
               </li> 
             </ul>
           </li>

           <li class="nav-item">
             <a href="#" class="nav-link nav-reports">
               <i class="fas fa-bed nav-icon"></i>
               <p>
                 Room
                 <i class="right fas fa-angle-left"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="javascript:void(0)" class="nav-link nav-add_room tree-item add_room">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Add Room</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="./index.php?page=room_details" class="nav-link nav-room_details tree-item">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Room Details</p>
                 </a>
               </li>  
               
               <?php if($_SESSION['login_position'] != 2): ?>

               <li class="nav-item">
                 <a href="./index.php?page=room_types" class="nav-link nav-room_types tree-item">
                   <i class="fas fa-angle-right nav-icon"></i>
                   <p>Room Types</p>
                 </a>
               </li>

               <?php endif; ?>

             </ul>
           </li>

          <?php if($_SESSION['login_position'] != 2): ?>
           
          <li class="nav-item">
            <a href="#" class="nav-link nav-reports">
              <i class="fas fa-th-list nav-icon"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=statistical_graph" class="nav-link nav-statistical_graph tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Statistical Graph</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=available_rooms" class="nav-link nav-available_rooms tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Available Rooms</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="./index.php?page=frequently_used_rooms" class="nav-link nav-frequently_used_rooms tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Frequently Used Rooms</p>
                </a>
              </li>
            </ul>
          </li>
          
          <?php endif; ?>

          
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Staff
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <?php if($_SESSION['login_position'] == 1): ?>
              <li class="nav-item">
                <a href="./index.php?page=new_staff" class="nav-link nav-new_staff tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=staff_list" class="nav-link nav-staff_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
        

        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
      $('.add_room').click(function(){
			  uni_modal("<i class='fa fa-id-card'></i> Add Room","add_room.php")
		  })
      $('#view_account').click(function(){
        uni_modal("<i class='fa fa-id-card'></i> Staff Details","view_staff.php?id="+$(this).attr('data-id'))
      })
  	})
  </script>