<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>RAJA MARI AMMAN TEMPLE</title>

   <!-- CSS
   ==================================================== -->
   <!--Font Awesome -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/font-awesome.min.css" />

   <!-- Animate CSS -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/animate.css">

   <!-- Iconic Fonts -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/icofonts.css" />

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/bootstrap.min.css">

   <!-- Owl Carousel -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/owlcarousel.min.css" />

   <!-- Video Popup -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/magnific-popup.css" />

   <!--Style CSS -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/style.css">

   <!--Responsive CSS -->
   <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/frontend/css/responsive.css">
   <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery-2.0.0.min.js"></script>
<style>
.card { border:none; padding:0; }
.hide {
   display: none;
}
.alert {
  padding: 8px;
  background-color: #f44336;
  color: white;
}
.suc-alert{
    padding: 8px;
    background-color: #8BC34A;
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
</style>
<script>
$(document).ready(function(){
   setTimeout(function(){
        $("#content_alert").css("display", "none");
   },5000);
});
</script>
</head>

<body>
   <?php echo view('frontend/layout/loader'); ?>
   <?php
   $uri = new \CodeIgniter\HTTP\URI(current_url());
   $uri_one = '';
    if($uri->getTotalSegments() > 0 && $uri->getSegment(1))
        $uri_one = $uri->getSegment(1);
    if($uri->getTotalSegments() > 1 && $uri->getSegment(2))
	    $uri_two = $uri->getSegment(2);
   ?>

   <!--div class="tw-top-bar">
      <div class="container">
         <div class="row">
            <div class="col-md-6 text-left">
               <div class="top-contact-info">
                  <span><i class="icon icon-envelope"></i><a href="" class="__cf_email__" data-cfemail="d5bcbbb3ba95b0adb4b8a5b9b0fbb6bab8">[email&#160;protected]</a></span>
                  <span><i class="icon icon-map-marker2"></i>009-215-5596</span>
               </div>
            </div>
            <div class="col-md-6 ml-auto text-right">
               <div class="top-social-links">
                  <span>Follow us:</span>
                  <a href="#"><i class="fa fa-facebook"></i></a>
                  <a href="#"><i class="fa fa-twitter"></i></a>
                  <a href="#"><i class="fa fa-google-plus"></i></a>
                  <a href="#"><i class="fa fa-instagram"></i></a>
                  <?php
					if($_SESSION['log_id_frend'] != "" ){
					?>
						<a href="<?php echo base_url(); ?>/member_login/logout" style="color:#FFFFFF;">
                        <i class="fa fa-power-off"></i>[<?php echo $_SESSION['username_frend']; ?>]</a>
					<?php
					}
					else
					{
					?>
						<a href="<?php echo base_url(); ?>/member_login/" style="color:#FFFFFF;">Login</a>
					<?php
					}
					?>
               </div>
            </div>
         </div>
      </div>
   </div-->
   <!-- Top Bar end -->
   <!-- header======================-->
   <header>
      <div class="tw-head">
         <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
               <a class="navbar-brand tw-nav-brand" href="<?php echo base_url(); ?>/home/">
                  <img src="<?php echo base_url(); ?>/uploads/main/1697189976_WhatsApp Image 2023-10-13 at 17.30.20.jpeg" style="width:50px" alt="">
               </a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                  aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                  <ul class="navbar-nav">
                     <?php
                     if($_SESSION['role'] == 99)
                     {
                     ?>
                     <li class="nav-item <?php if($uri_one == "cemeteryreg") { echo 'active'; } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/cemeteryreg/list">CEMETERY REGISTRATION</a></li>
                     <?php
                     }
                     else
                     {
                     ?>
                     <li class="nav-item <?php if($uri_one == "archanai_booking_cust") { echo 'active'; } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/archanai_booking_cust">ARCHANAI BOOKING</a></li>
                     <li class="nav-item <?php if($uri_one == "booking_cust") { echo 'active'; } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/booking_cust">HALL BOOKING</a></li>
                     <li class="nav-item <?php if($uri_one == "ubayam_online_cust") { echo 'active'; } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/ubayam_online_cust">UBAYAM </a></li>
                     <li class="nav-item <?php if($uri_one == "prasadam_online_cust") { echo 'active'; } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/prasadam_online_cust">PRASADAM </a></li>
                     <li class="nav-item <?php if($uri_one == "donation_online_cust" && $uri_two == "add") { echo 'active'; } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/donation_online_cust/add">CASH DONATION</a></li>
                     <li class="nav-item hide <?php if($uri_one == "kavadi") { echo 'active'; } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/kavadi">KAVADI REGISTRATION</a></li>
                     <li class="nav-item hide <?php if($uri_one == "memberreg") { echo 'active'; } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/memberreg">MEMBER REGISTRATION</a></li>
                     <li class="nav-item hide <?php if($uri_one == "Dailyclosing_online") { echo 'active'; } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/Dailyclosing_online">DAILY CLOSING</a></li>

                     <li class="nav-item <?php if($uri_one == "customer_mybooking" && $uri_two == "") { echo 'active'; } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/customer_mybooking">MY BOOKING</a></li>

                     <?php
                     }
                     ?>
                     <?php
                     if($_SESSION['log_id_frend'] != "" ){
                     ?>
                        <li class="nav-item"> <a style="text-transform: uppercase;" class="nav-link" href="<?php echo base_url(); ?>/customer_login/logout"><i class="fa fa-power-off"></i>[<?php echo $_SESSION['username_frend']; ?>]</a></li>
                     <?php
                     }
                     else
                     {
                     ?>
                        <li class="nav-item"> <a style="text-transform: uppercase;" class="nav-link" href="<?php echo base_url(); ?>/member_login">Login</a></li>
                     <?php
                     }
                     ?>
                  </ul>
               </div>
            </nav>
         </div>
      </div>
   </header>
   <?php if($_SESSION['succ'] != '') { ?>
	  <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
		  <div class="suc-alert" style="width: 100%;">
			  <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
			  <p><?php echo $_SESSION['succ']; ?></p> 
		  </div>
	  </div>
  <?php } ?>
	<?php if($_SESSION['fail'] != '') { ?>
	  <div class="row" style="padding: 0 30%;margin: 0px 0 15px 0;" id="content_alert">
		  <div class="alert" style="width: 100%;">
			  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
			  <p><?php echo $_SESSION['fail']; ?></p>
		  </div>
	  </div>
  <?php } ?>
   
   
