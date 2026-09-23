<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['site_title']; ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" >
<style>
body { background:#E6F2FF; }
.form { width:100%; margin:15px auto; background:#FFFFFF; padding:30px; border-radius:10px; }
.form-group { margin:20px 0; }
label { font-weight:500; display:block; }
</style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-12 col-xl-6">
            <form method="post" class="form">
            <p style="text-align:center;"><img src="<?php echo base_url(); ?>/assets/images/form_logo.png" class="img-fluid" style="width:300px; margin:0 auto;"></p>
            <h3 style="text-align:center;">VISITOR'S REGISTRATION</h3>
              <div class="form-group">
                <label>Name </label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="form-group">
                <label>Citizen </label>
                <input type="radio" name="citizen" value="MALAYSIAN"> MALAYSIAN
                <input type="radio" name="citizen" value="FOREIGNER"> FOREIGNER
              </div>
              <div class="form-group">
                <label>Choose one </label>
                <input type="radio" name="type" value="INDIVIDUAL"> INDIVIDUAL
                <input type="radio" name="type" value="GROUP"> GROUP
              </div>
              <div class="form-group">
                <label>If group, how many pax? </label>
                <input type="text" name="pax" class="form-control">
              </div>
              <div class="form-group">
                <label>Comments </label>
                <textarea rows="3" class="form-control" style="width:100%;" name="comments"></textarea>
              </div>
              <div class="form-group">
              	<input class="btn btn-success" type="submit" id="submit" value="SUBMIT" style="float:right;">
                <input class="btn btn-info" type="reset" checked="CLEAR">
              </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<script src="<?php echo base_url(); ?>/assets/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#submit').click(function() {
        //$(this).prop('disabled', true); 
        $.ajax({
            url: "<?php echo base_url();?>/form/save",
            type: "post",
            data: $("form").serialize(),
            beforeSend: function() {
				$('#submit').attr('disabled', true);
		    },
		    success:function(data){
                console.log(data);
                obj = jQuery.parseJSON(data);
                if(obj.err != ''){
                    alert('Registered Successfully!...');
                    window.location.reload(true);
                }else{					
                    alert('Please enter required fields.');
                }
                $('#submit').attr('disabled',false);
            }
        });
    });
});
</script>
</body>
</html>
