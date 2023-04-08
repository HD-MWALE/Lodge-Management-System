<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
if(isset($_SESSION['login_staff_id']))
  header("location:index.php?page=home");

include 'header.php' 
?>

<body class="hold-transition login-page" style="background-image: url('../assets/img/bed.jpeg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
<div class="login-box">
  <div class="login-logo" style="background-color: rgb(255, 255, 255);">
    <a href="#" class="text-white"><b style="color: #723d19;"><strong>Ngaliya Lodge</strong> Management System</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" id="login-form">
        <div class="input-group mb-3" style="margin-left: auto; margin-right: auto; width: 100px;">
            <h2>Log in</h2>
        </div>
        <div class="input-group mb-3 bottom_line">
          <input type="email" class="form-control" name="email" required placeholder="E-mail">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3 bottom_line">
          <input type="password" class="form-control" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<style>
	.bottom_line{
		border-bottom: 2px solid rgb(14, 111, 255);
	}
</style>

<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
      e.preventDefault()
      start_load()
      if($(this).find('.alert-danger').length > 0 )
        $(this).find('.alert-danger').remove();
      $.ajax({
        url:'ajax.php?action=login',
        method:'POST',
        data:$(this).serialize(),
        error:err=>{
          console.log(err)
          end_load();

        },
        success:function(resp){
          console.log(resp);//shows response in the developer tools
          if(resp == 1){
            location.href ='index.php?page=home';
          }else if(resp == 3){
            location.href ='change_password.php';
          }else{
            $('#login-form').prepend('<div class="alert alert-danger">Incorrect Username or password.</div>')
            end_load();
          }
        }
      })
    })
  })
</script>
<?php include 'footer.php' ?>

</body>
</html>
