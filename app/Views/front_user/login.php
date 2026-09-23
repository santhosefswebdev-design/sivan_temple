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


</head>

<body>
<style>
body { background:#333333; }
.back { padding: 35px; background: #262d7812; border-radius: 20px; border:3px solid #00ffffbf;box-shadow: 0px 5px 50px 5px rgba(0,255,255,0.7);   }
.form-control { background-color: #fff0 !important; border: 1px solid #00ffffbf; color: #fff !important; }
label { color: #00ffff; }
:root {
  --clr-bkg: #0e142c;
  --clr-cl:  #01e3ef;
  --clr-bsshw: #00000033;
}
  
*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
button {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: .625em 1.375em;
  border: none;
  /*   outline-color: transparent; */
  background: var(--clr-bkg);
  color: var(--clr-cl);
  font-size: 1.125em;
  font-weight: 500;
  text-transform: capitalize;
  text-shadow: var(--clr-cl) 0.063em 0 0.313em;
  transition: transform 0.2s ease;
  box-shadow: 0 .313em .625em var(--clr-bsshw);
  overflow: hidden;
  cursor: pointer;
  margin-top:20px;
}

.button1 span:nth-child(1) {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 0.125em;
  background: linear-gradient(to right, transparent, var(--clr-cl));
  animation: animate1 1.25s linear infinite;
}
    
@keyframes animate1 {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.button1 span:nth-child(2) {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 100%;
  height:0.125em;
  background: linear-gradient(to left, transparent, var(--clr-cl));
  animation: animate2 1.25s linear infinite;         
}
    
@keyframes animate2 {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}

.button1:hover,
.button1:focus,
.button1:active {
  color: var(--clr-bkg);
  background: var(--clr-cl);
  box-shadow: 0 0 0.625em var(--clr-cl),
              0 0 2.5em var(--clr-cl),
              0 0 5.0em var(--clr-cl);
  transition-delay: .1s;
}

.button1:hover span,
.button1:focus span,
.button1:active span {
  animation-play-state: paused;
}
</style>
<?php if($_SESSION['succ'] != '') { ?>
	<div class="row" style="padding: 0 0%;" id="content_alert">
		<div class="suc-alert" style="color: #fff;margin: 0 auto;">
			<span class="suc-closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
			<p><?php echo $_SESSION['succ']; ?></p> 
		</div>
	</div>
<?php } ?>
 <?php if($_SESSION['fail'] != '') { ?>
	<div class="row" style="padding: 0 0%;" id="content_alert">
		<div class="alert" style="color: #fff;margin: 0 auto;">
			<span class="closebtn" onClick="this.parentElement.style.display='none';">&times;</span> 
			<p><?php echo $_SESSION['fail']; ?></p>
		</div>
	</div>
<?php } ?>
<div class="container">
	<div class="row justify-content-center" style="align-items: center; height:100vh;">
		<div class="col-md-6 col-lg-5 mb-5 mb-lg-0 back">
			<p style="text-align:center;"><img src="<?php echo base_url(); ?>/assets/images/logo_img.png" alt="" style="width:140px; background:#0dcccd73; margin:0 auto;"></p>
			<form action="<?php echo base_url();?>/customer_login/validation" id="frmSignIn" method="post" class="needs-validation">
				<div class="row">
					<div class="form-group col">
						<label class="form-label text-color-dark text-3">User Name <span class="text-color-danger">*</span></label>
						<input type="text" name="username" placeholder="Username" class="form-control text-4" required>
					</div>
				</div>
				<div class="row">
					<div class="form-group col">
						<label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
						<input type="password" name="password" placeholder="Password"  class="form-control text-4" required>
					</div>
				</div>
				<div class="row">
					<div class="form-group col">
						<button type="submit" class="btn w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3 button1" >Login<span></span><span></span></button>
            <p style="margin-top: 10px;color: #ffffff;font-weight: 800;">If you not register. please click here to <a href="customer_register" >Register</a></p>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

 
   <!-- End Footer -->

   <!-- initialize jQuery Library -->
   <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
   <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery-2.0.0.min.js"></script>
   <!-- Popper JS -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/popper.min.js"></script>
   <!-- Bootstrap jQuery -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.min.js"></script>
   <!-- Owl Carousel -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/owl-carousel.2.3.0.min.js"></script>
   <!-- Waypoint -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/waypoints.min.js"></script>
   <!-- Counter Up -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.counterup.min.js"></script>
   <!-- Video Popup -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/jquery.magnific.popup.js"></script>
   <!-- Smooth scroll -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/smoothscroll.js"></script>
   <!-- WoW js -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/wow.min.js"></script>
   <!-- Template Custom -->
   <script src="<?php echo base_url(); ?>/assets/frontend/js/main.js"></script>
</body>
</html>
