<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sree Selva Vinayagar Temple</title>
    <!--<link rel="icon" href="favicon.ico" type="image/x-icon">-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/css/themes/all-themes.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/assets/checkbox.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
</head>
<style>
.btn:not(.btn-link):not(.btn-circle) i{
    font-size: 16px !important;
}
.btn-rad{
    border-radius: 50% !important;
}
.alert {
  padding: 8px;
  background-color: #f44336;
  color: white;
}

.suc-alert{
    padding: 8px;
    background-color: #368e00;
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

.closebtn:hover, .suc-closebtn:hover {
  color: black;
}
.suc-closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.show-tick { padding: 2px 0 !important; }
.table { width:100% !important; }
.table tr th { background:#a1a09f !important; color:#FFFFFF !important;}
.table tr th:first-child { width:5%; }
.btn-lg, .btn-group-lg > .btn { padding: 10px 15px !important; }
footer { background:#FFFFFF; padding:10px; text-align:center; margin-top: 20px; }
.ls-closed .navbar-brand { margin-left: 5px; }
.modal-content { width:100% !important; }
.btn { padding: 8px 12px !important;  }
@media (max-width: 767px) {
.navbar > .container .navbar-brand, .navbar > .container-fluid .navbar-brand {
    margin-left: 5px;
    width: 100%;
}
.navbar-brand {
    padding: 15px 0px;
}
}
</style>
<script>
$(document).ready(function(){
   setTimeout(function(){
        $("#content_alert").css("display", "none");
   },5000);
});
</script>
<body class="theme-red">

    <!--<nav class="navbar">
        <div class="container-fluid">
        <div class="col-md-4 col-sm-3"></div>
        
        <div class="col-md-4 col-sm-6">
        	<div class="row" style="display: flex; align-items: center; flex-wrap: nowrap;">
            	<div class="col-md-2 col-xs-3 col-sm-2" style="padding:0">
                	<a href="<?php echo base_url(); ?>/dashboard"> <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" class="img-responsive" style="background:#FFFFFF;"> </a>
                </div>
                <div class="col-md-10 col-xs-9 col-sm-10 navbar-header" style="padding:0; padding-left:15px;">
                	<a href="<?php echo base_url(); ?>/dashboard" style="color:#FFFFFF;width:100%; font-size:18px; text-transform:uppercase;text-decoration:none; text-align:center;"> <?php echo $_SESSION['site_title']; ?> </a>
                </div>
        	</div>
        </div>
        
        <div class="col-md-4 col-sm-3"></div>
        
            
        </div>
    </nav>-->
    
    
    <nav class="navbar">
        <div class="container-fluid">
        <div class="col-md-3"></div>
        
        <div class="col-md-6 col-sm-6">
        	<div class="row" style="display: flex; align-items: center; flex-wrap: nowrap;">
            	<div class="col-md-2 det"></div>
                <div class="col-md-1 col-xs-2 col-sm-2" style="padding:0">
                	<a href="<?php echo base_url(); ?>/dashboard"> <img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" class="img-responsive" style="background:#FFFFFF;max-height: 60px;"> </a>
                </div>
                <div class="col-md-7 col-xs-10 col-sm-10 navbar-header" style="padding:0; padding-left:15px;">
                	<a href="<?php echo base_url(); ?>/dashboard" style="color:#FFFFFF;width:100%; font-size:18px; text-transform:uppercase;text-decoration:none; text-align:center;"> <?php echo $_SESSION['site_title']; ?> </a>
                </div>
                <div class="col-md-2 det"></div>
        	</div>
        </div>
        
        <div class="col-md-3"></div>            
        </div>
    </nav>
    <section class="top_content hidden-xs">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-8 col-md-offset-2 top_nav">
            <!--<ul class="top_menu"><li><img src="<?php echo base_url(); ?>/assets/images/archanai.png" class="img-responsive" style="width:50px;"> Archanai</li>
            <li><img src="<?php echo base_url(); ?>/assets/images/booking.png" class="img-responsive" style="width:50px;"> Booking</li>
            <li><img src="<?php echo base_url(); ?>/assets/images/donation.png" class="img-responsive" style="width:50px;"> Donation</li>
            <li><img src="<?php echo base_url(); ?>/assets/images/archanai.png" class="img-responsive" style="width:50px;"> Ubayam</li>
            </ul>-->
            <div><img src="<?php echo base_url(); ?>/assets/images/archanai.png" class="img-responsive" style="width:50px;"> Archanai 
            <ul class="dropdown">
                <li><a href="#">Archanai Setting</a></li>
                <li><a href="#">Entry</a></li>
                <li><a href="#">Report</a></li>
            </ul>
            </div>
            <div><img src="<?php echo base_url(); ?>/assets/images/booking.png" class="img-responsive" style="width:50px;"> Booking
            <ul class="dropdown">
                <li><a href="#">Hall Booking</a></li>
                <li><a href="#">Report</a></li>
            </ul>
            </div>
            <div><img src="<?php echo base_url(); ?>/assets/images/donation.png" class="img-responsive" style="width:50px;"> Donation
            <ul class="dropdown">
                <li><a href="#">Cash Donation</a></li>
                <li><a href="#">Product Donation</a></li>
                <li><a href="#">Cash Donation Report</a></li>
                <li><a href="#">Product Donation Report</a></li>
            </ul>
            </div>
            <div><img src="<?php echo base_url(); ?>/assets/images/archanai.png" class="img-responsive" style="width:50px;"> Ubayam</div>
            <div><img src="<?php echo base_url(); ?>/assets/images/donation.png" class="img-responsive" style="width:50px;"> Inventory</div>
            <div><img src="<?php echo base_url(); ?>/assets/images/account.png" class="img-responsive" style="width:50px;"> Account</div>
            <div><img src="<?php echo base_url(); ?>/assets/images/finance.png" class="img-responsive" style="width:50px;"> Finance</div>
            </div>
            </div>
        </div>
    </section>
    
 <style>
.navbar-brand {
    float: left;
    height: 35px;
    padding: 15px 15px;
    font-size: 18px;
    line-height: 6px;
}
section.content {
    margin: 15px auto 15px !important;
}
.sidebar { top:50px !important; height: calc(100vh - 50px); }
footer { margin-top: 20px; width:100%; position:fixed; bottom:0; }
/*.card { margin-bottom: 45px !important; }*/
.bootstrap-select > .dropdown-toggle { padding-left: 0 !important; }
.top_content { margin-top:50px; background:#FFFFFF; padding-top:15px; box-shadow: 0 1px 5px rgb(0 0 0 / 30%); }
.top_menu li { list-style:none; display:inline-block; margin:0 20px; }
.top_nav { display:flex; align-content: center; justify-content: space-between; }

ul.dropdown {
	min-width: 200px; /* Set width of the dropdown */
	background: #f2f2f2;
	display: none;
	position: absolute;
	z-index: 999;
	left: 0;
	padding:10px 15px;
}
ul.dropdown li { line-height:2em; list-style:none; }
ul.dropdown li a { color:#000000; text-decoration:none; }
.top_nav div:hover ul.dropdown {
	display: block; /* Display the dropdown */
}
.top_nav div ul.dropdown li {
	display: block;
}

</style>     
