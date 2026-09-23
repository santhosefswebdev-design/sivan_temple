<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Temple</title>
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
body { background:#FFFFFF; }
.block-header {
    /*background: #252628;*/
    padding: 15px;
    width: 100%;
}
.card {  box-shadow: none !important; border: none !important; margin-bottom:0; }
.block-header h2 { /*color: #fff !important;*/ }
section.content { margin: 0px auto 0; }
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
.table tr th { background:#000 !important; color:#FFFFFF !important;}
.table tr th:first-child { width:5%; }
.btn-lg, .btn-group-lg > .btn { padding: 10px 15px !important; }
footer { background:#000; padding:10px; text-align:center; margin-top: 20px; }
.ls-closed .navbar-brand { margin-left: 5px; }
.modal-content { width:100% !important; }
.btn { padding: 8px 12px !important;  }
.table-responsive{
	overflow-x: hidden !important;
}
@media (max-width: 767px) {
.navbar > .container .navbar-brand, .navbar > .container-fluid .navbar-brand {
    margin-left: 5px;
    width: 100%;
}
.navbar-brand {
    padding: 15px 0px;
}
section.content {
    margin: 65px auto 65px !important;
}
table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td {
    white-space: nowrap;
}
.table tr th, .table tr td {
    white-space: nowrap;
}
.form-group .form-line {
    margin-bottom: 15px;
}
.table-responsive{
	overflow-x: auto !important;
}
}
.top { padding:10px; }
.ptop { text-align:right; color:#FFFFFF; }
.ptop i { color:#FFFFFF; padding:2px 10px; font-size:11px; }
</style>
<script>
$(document).ready(function(){
   setTimeout(function(){
        $("#content_alert").css("display", "none");
   },5000);
});
</script>
<link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css'>
<body class="theme-red">
<div class="ptop bg-dark" style="padding:5px;">
    <div class="container-fluid"><div class="row">
        <div class="col-md-12">
            <i class="material-icons">call</i> 99999 99999
        </div>
    </div></div>
</div>
<div class="top">
    <div class="container-fluid"><div class="row">
    	<div class="col-md-3"></div>
        <div class="col-md-1"><img src="<?php echo base_url();?>/assets/images/logo_image.png" style="width:110px;" align="middle"></div>
        <div class="col-md-5"><h3 style="text-align:center; line-height:1.5em; color: #242b77;">ARULMIGU SREE GANESHER TEMPLE<br>
        <span style="color:#d41083;">அருள்மிகு ஸ்ரீ கணேசர் ஆலயம்</span></h3></div>
        <div class="col-md-3"></div>
    </div></div>
</div>
<img src="<?php echo base_url(); ?>/assets/images/hall_booking.jpg" class="img-responsive" style="width:100%;"> 
<nav class="navbar navbar-default bg-dark">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li> <a class="nav-link" href="<?php echo base_url(); ?>/booking">Hall Booking <span class="sr-only">(current)</span></a> </li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/kavadi">Kavadi registration</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/memberreg">Member registration</a></li>
        <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>/cemeteryreg">cemetery registration</a></li>
      </ul>
    </div>
  </div>
</nav>
<style>
.navbar {
     margin-bottom: 0px;
	 top:auto;
	 position:sticky;
}
.theme-red .navbar {
    background-color: #000;
}
.navbar-nav { float:right; }
.navbar-nav > li > a {
    padding: 0px;
    margin: 15px;
    color: white;
    text-transform: uppercase;
    font-size: 16px;
}
.navbar-default .navbar-nav > li > a {
    color: #fff !important;
}
.navbar-nav > li {
	border-right:1px solid #666666;
	line-height:3.5em;
	list-style:none;
}
.navbar-nav > li:last-child {
	border-right:none;
}
.fa-bars {
  color: #007bff;
  font-size: 30px;
}
.form-group {
    width: 100%;
    margin-bottom: 10px;
	height: calc(3rem + 2px) !important;
}
.form-group .form-line .form-label {
    top: 0px !important;
}
.form-inline {
    display: block !important;
}
.form-group .form-line.focused .form-label {
    top: -16px !important;
}
.form-control {
    font-size: 14px !important;
	height: calc(3rem + 2px) !important;
}
.dropdown-toggle::after {
    display:none !important;
}
.bootstrap-select > .dropdown-toggle {
    padding: 5px !important;
}
.dropdown-toggle {
    border: 1px solid #ced4da !important;
}
.bg-dark {
    background-color: #343a40!important;
}
.w-100 {
    width: 100%!important;
}
.justify-content-end {
    -ms-flex-pack: end!important;
    justify-content: flex-end!important;
}
.navbar .navbar-toggle:before {
	display:none;
}
@media (max-width: 767px) {
section.content { margin: 0px auto 25px !important; }
}
</style>
