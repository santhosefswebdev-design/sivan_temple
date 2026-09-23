<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login</title>
    <!--<link rel="icon" href="<?php echo base_url(); ?>assets/favicon.ico" type="image/x-icon">-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
</head>
<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

.card {
    background: #5c5a5a52 !important;
    min-height: 50px;
    position: relative;
    margin-bottom: 30px;
    -webkit-border-radius: 17px;
    -moz-border-radius: 17px;
    -ms-border-radius: 17px;
    border-radius: 17px;
}
.form-control {
    color: #000;
    background-color: transparent;
}
.login-page { 
	max-width: 500px;
	margin: 5% auto; 
	background:url(<?php echo base_url();?>/assets/images/login_bcgnd.jpg) center; 
	background-attachment: fixed; 
	background-size: 100% 100%; 
}
.form-control::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color:#272727;
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #272727;
}

::-ms-input-placeholder { /* Microsoft Edge */
  color: #272727;
}
.input-group .input-group-addon .material-icons {
    font-size: 22px;
    color: #272727;
}
</style>
<body class="login-page">
	<?php if($_SESSION['succ'] != '') { ?>
        <div class="row" style="padding: 0 0%;" id="content_alert">
            <div class="suc-alert">
                <span class="suc-closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
                <p><?php echo $_SESSION['succ']; ?></p> 
            </div>
        </div>
    <?php } ?>
     <?php if($_SESSION['fail'] != '') { ?>
        <div class="row" style="padding: 0 0%;" id="content_alert">
            <div class="alert">
                <span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
                <p><?php echo $_SESSION['fail']; ?></p>
            </div>
        </div>
    <?php } ?>
    <div class="login-box">
        <div class="logo" style="text-align:center;">
            <img src="<?php echo base_url();?>/assets/images/logo_img.png" style="width:170px;" align="middle">
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" action="<?php echo base_url();?>/login/validation" method="POST">
                    <div class="msg">Login</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3 p-t-5">
                        </div>
                        <div class="col-xs-6" align="center">
                            <button class="btn bg-indigo waves-effect" type="submit">SIGN IN</button>
                            <button class="btn bg-indigo waves-effect" type="button">CLEAR</button>
                        </div>
                        <div class="col-xs-3">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.js"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/pages/examples/sign-in.js"></script>
</body>
</html>
