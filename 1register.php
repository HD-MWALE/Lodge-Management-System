
<div id="login">
    <div class="container">
        <div class="section-header">
            <h2>Registration</h2>
        </div>
        <div class="row" >
            <div class="col-md-12">
                <div class="login-form" >
                    <form id="customer_register">
                        <div class="form-row" >
                            <div class="control-group col-sm-6">
                                <label>Your first Name</label>
                                <input type="text" name="firstname" class="form-control" required="required" />
                            </div>
                            <div class="control-group col-sm-6">
                                <label>Your Last Name</label>
                                <input type="text" name="lastname" class="form-control" required="required" />
                            </div>
                            <div class="control-group col-sm-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required="required" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="control-group col-sm-6">
                                <label>Your Password</label>
                                <input type="password" name="password" class="form-control" required="required" />
                            </div>
                            <div class="control-group col-sm-6">
                                <label>Repeat Your Password</label>
                                <input type="password" name="cpass" class="form-control" required="required" />
                                <small id="pass_match" data-status=''></small>
                            </div>
                        </div>
                        <div class="button"><button type="submit">Registration</button></div>
                        <div class="button"><a href="index.php?page=login">Already have an account.</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
    $('#customer_register').submit(function(e){
    e.preventDefault()
    $('input').removeClass("border-danger")
    $('#msg').html('')
    
    $.ajax({
        url:'./Administrator/ajax.php?action=register_customer',
        method:'POST',
        data:$(this).serialize(),
        error:err=>{
            console.log(err)
            end_load();

        },
        success:function(resp){
            console.log(resp);
            if(resp == 1){
                setTimeout(function(){
                    location.replace('index.php?page=booking')
                },750)
            }else{
                end_load()
            }
        }
    })
})
</script>
        