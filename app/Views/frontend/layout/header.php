<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>
      <?php echo $_SESSION['site_title']; ?>
   </title>

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
      body:fullscreen {
         overflow: scroll !important;
      }

      body:-ms-fullscreen {
         overflow: scroll !important;
      }

      body:-webkit-full-screen {
         overflow: scroll !important;
      }

      body:-moz-full-screen {
         overflow: scroll !important;
      }

      .card {
         border: none;
         padding: 0;
      }

      .hide {
         display: none;
      }

      .alert {
         padding: 8px;
         background-color: #f44336;
         color: white;
      }

      .suc-alert {
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

      .closebtn:hover,
      .suc-closebtn:hover {
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
      .btn { z-index: 1; }
      .dialog { z-index: 1 !important; }
   </style>
   <script>
      $(document).ready(function () {
         setTimeout(function () {
            $("#content_alert").css("display", "none");
         }, 5000);
         setInterval(function () {
            $.ajax({
               type: "POST",
               url: "<?php echo base_url(); ?>/member_login/log_check",
               data: $("form").serialize(),
               dataType: 'json',
               success: function (data) {
                  console.log(data);
                  if (data.login == false) {
                     window.location.href = '<?php echo base_url(); ?>/member_login';
                  }
               },
               error: function (err) {
                  console.log('err');
                  console.log(err);
                  window.location.href = '<?php echo base_url(); ?>/member_login';
               }
            });
         }, 600000);
      });
   </script>
</head>

<body id="element">
   <?php echo view('frontend/layout/loader'); ?>
   <?php
   $uri = new \CodeIgniter\HTTP\URI(current_url());
   $uri_one = '';
   if ($uri->getTotalSegments() > 0 && $uri->getSegment(1))
      $uri_one = $uri->getSegment(1);
   if ($uri->getTotalSegments() > 1 && $uri->getSegment(2))
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
                  if ($_SESSION['log_id_frend'] != "") {
                     ?>
                  <a href="<?php echo base_url(); ?>/member_login/logout" style="color:#FFFFFF;">
                        <i class="fa fa-power-off"></i>[<?php echo $_SESSION['username_frend']; ?>]</a>
               <?php
                  } else {
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
                  <img
                     src="<?php echo base_url(); ?>/uploads/main/1697189976_WhatsApp Image 2023-10-13 at 17.30.20.jpeg"
                     style="width:50px" alt="">
               </a>
               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                  <ul class="navbar-nav">
                     <?php
                     if ($_SESSION['role'] == 99) {
                        ?>
                        <li class="nav-item <?php if ($uri_one == "agent_dashboard") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/agent_dashboard">DASHBOARD</a></li>
                        <li class="nav-item <?php if ($uri_two == "add") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/cemeteryreg/add">CEMETERY
                              REGISTRATION</a></li>
                        <li class="nav-item <?php if ($uri_two == "list") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/cemeteryreg/list">CEMETERY LIST</a>
                        </li>
                        <li class="nav-item <?php if ($uri_two == "draft_list") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/cemeteryreg/draft_list">DRAFT
                              LIST</a></li>
                        <li class="nav-item <?php if ($uri_one == "cemetery_report") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/cemetery_report">REPORT</a></li>
                        <li class="nav-item <?php if ($uri_one == "agent_profile") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/agent_profile">PROFILE</a></li>
                        <?php
                     } else {
                        ?>
                        <li class="nav-item <?php if ($uri_one == "archanai_booking") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/archanai_booking">SALES</a></li>
                        <li class="nav-item <?php if ($uri_one == "offering_online") {
							   echo 'active';
							   } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/offering_online">OFFERING
								  </a></li>
                        <li class="nav-item <?php if ($uri_one == "booking") {
                           echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/hallbooking_online/hall">TEMPLE BOOKING</a></li>
                        <li class="nav-item <?php if ($uri_one == "ubayam_online") {
                           echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/templeubayam_online/ubayam">UBAYAM </a></li>
                        <li class="nav-item <?php if ($uri_one == "prasadam_online") {
                           echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/prasadam_online">PRASADAM </a></li>
                        <li class="nav-item <?php if ($uri_one == "donation_online" && $uri_two == "add") {
                           echo 'active';
                        } ?>">
                           <a class="nav-link" href="<?php echo base_url(); ?>/donation_online/add">CASH DONATION</a>
                        </li>
                        <li class="nav-item <?php if ($uri_one == "annathanam_counter") {
                           echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo base_url(); ?>/annathanam_counter">ANNATHANAM</a>
                        </li>
                        <li class="nav-item hide <?php if ($uri_one == "kavadi") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/kavadi">KAVADI REGISTRATION</a></li>
                       <li class="nav-item <?php if ($uri_one == "memberreg") {
                           echo 'active';
                        } ?>"> <a class="nav-link"
                              href="<?php echo base_url(); ?>/memberreg">MEMBER REGISTRATION</a></li> 
                        <li class="nav-item <?php if ($uri_one == "Dailyclosing_online") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/Dailyclosing_online">DAILY
                              CLOSING</a></li>
                        <li class="nav-item <?php if ($uri_one == "payment_voucher") {
                           echo 'active';
                        } ?>"> <a class="nav-link" href="<?php echo base_url(); ?>/payment_voucher">EXPENSES</a>
                        </li>
                        <?php
                     }
                     ?>
                     <li class="dropdown nav-item <?php if ($uri_one == "Dailyclosing_online") {
                           echo 'active';
                        } ?>"> 
                        <a class="nav-link" href="#" data-toggle="dropdown">REPORT <span class="tw-indicator"><i class="fa fa-angle-down"></i></span></a>
                           <ul class="dropdown-menu tw-dropdown-menu">
							<?php 
								if(!empty($_SESSION['role'])){
									if($_SESSION['role'] == 92){
								?>
									 <li class="active"><a href="<?php echo base_url(); ?>/report_online/archanai_report">Archanai Report</a></li> 
								<?php 
									}else{
								?>
								  <li><a href="<?php echo base_url(); ?>/report_online/archanai_report">Archanai Report</a></li>
								  <li><a href="<?php echo base_url(); ?>/report_online/annathanam_report">Annathanam Report</a></li>
								  <li><a href="<?php echo base_url(); ?>/report_online/hall_booking_report">Hall Booking Report</a></li>
								  <li><a href="<?php echo base_url(); ?>/report_online/ubayam_report">Ubayam Report</a></li>
								  <li><a href="<?php echo base_url(); ?>/report_online/prasadam_rep_view">Prasadam Report</a></li>
								  <li><a href="<?php echo base_url(); ?>/report_online/donation_report">Donation Report</a></li>
                          <li><a href="<?php echo base_url(); ?>/report_online/offering_report">Offering Report</a></li>
                          <li><a href="<?php echo base_url(); ?>/report_online/log">Logs</a></li>
                          <!-- <li><a href="<?php echo base_url(); ?>/report_online/log">Logs</a></li> -->
								  <?php
									}
								}
							?>
                           </ul>      
                     </li>
                     <?php //echo $_SESSION['username_frend'];    ?>
                     <?php
                     if ($_SESSION['log_id_frend'] != "") {
                        ?>
                        <li class="nav-item"> <a style="text-transform: uppercase;" class="nav-link"
                              href="<?php echo base_url(); ?>/member_login/logout">LOGOUT</a></li>
                        <?php
                     } else {
                        ?>
                        <li class="nav-item"> <a style="text-transform: uppercase;" class="nav-link"
                              href="<?php echo base_url(); ?>/member_login">Login</a></li>
                        <?php
                     }
                     ?>
                  </ul>
               </div>
            </nav>
         </div>
      </div>
   </header>
   <style>
      #go-button {
         position: fixed;
         padding: 5px;
         border-radius: 50%;
         width: 60px;
         height: 60px;
         bottom: 50px;
         z-index:5;
      }

      #go-button i {
         font-size: 32px;
         color: #FFF;
         line-height: 1.5;
      }
   </style>
   <a id="go-button" class="btn btn-success"><i id="go-btn" class="mdi mdi-fullscreen"></i></a>

   <script>

      /* Get into full screen */
      function GoInFullscreen(element) {
         if (element.requestFullscreen)
            element.requestFullscreen();
         else if (element.mozRequestFullScreen)
            element.mozRequestFullScreen();
         else if (element.webkitRequestFullscreen)
            element.webkitRequestFullscreen();
         else if (element.msRequestFullscreen)
            element.msRequestFullscreen();
      }

      /* Get out of full screen */
      function GoOutFullscreen() {
         if (document.exitFullscreen)
            document.exitFullscreen();
         else if (document.mozCancelFullScreen)
            document.mozCancelFullScreen();
         else if (document.webkitExitFullscreen)
            document.webkitExitFullscreen();
         else if (document.msExitFullscreen)
            document.msExitFullscreen();
      }

      /* Is currently in full screen or not */
      function IsFullScreenCurrently() {
         var full_screen_element = document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement || null;

         // If no element is in full-screen
         if (full_screen_element === null)
            return false;
         else
            return true;
      }

      $("#go-button").on('click', function () {
         if (IsFullScreenCurrently())
            GoOutFullscreen();
         else
            GoInFullscreen($("#element").get(0));
      });

      $(document).on('fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange', function () {
         if (IsFullScreenCurrently()) {
            $("#go-btn").removeClass('mdi-fullscreen').addClass('mdi-fullscreen-exit');
         }
         else {
            $("#go-btn").removeClass('mdi-fullscreen-exit').addClass('mdi-fullscreen');
         }
      });

   </script>