<!DOCTYPE html>
<html lang="en">
<?php
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
        <div class="input-group mb-3" style="margin-left: auto; margin-right: auto; width: 280px;">
            <h2>Change Password</h2>
        </div>
        <div class="input-group mb-3 bottom_line">
          <input type="password" class="form-control form-control-sm" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3 bottom_line">
          <input type="password" class="form-control form-control-sm" name="cpass" required placeholder="Verify Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <small id="pass_match" data-status=''></small>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Change</button>
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
$('[name="password"],[name="cpass"]').keyup(function(){
    var pass = $('[name="password"]').val()
    var cpass = $('[name="cpass"]').val()
    if(cpass == '' ||pass == ''){
        $('#pass_match').attr('data-status','')
    }else{
        if(cpass == pass){
            $('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
        }else{
            $('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
        }
    }
})
  $(document).ready(function(){
    $('#login-form').submit(function(e){
      e.preventDefault()
      start_load()
      if($(this).find('.alert-danger').length > 0 )
        $(this).find('.alert-danger').remove();
      $.ajax({
        url:'ajax.php?action=change_password',
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
          }else{
            $('#login-form').prepend('<div class="alert alert-danger">Something went wrong, try later.</div>')
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
