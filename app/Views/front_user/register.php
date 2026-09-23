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
.error{
  color:red;
}
</style>
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
<div class="container">
	<div class="row justify-content-center" style="align-items: center; height:100vh;">
		<div class="col-md-12 col-lg-12 mb-12 mb-lg-0 back">
			<form action="<?php echo base_url(); ?>/customer_register/save_register" id="frmSignIn" method="post" class="needs-validation">
          <div class="row">
            <div class="col-md-12">
              <p style="color: #fff;text-transform: uppercase;font-size: 21px;font-weight: 700;">Customer Registration</p>
            </div>
          </div>
				<div class="row">
          <div class="col-md-6">
            <div class="form-group col">
              <label class="form-label text-color-dark text-3">Name <span class="text-color-danger">*</span></label>
              <input type="text" name="cust_name" id="cust_name" placeholder="Name" class="form-control text-4" required>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group col">
                <label class="form-label text-color-dark text-3">IC No <span class="text-color-danger">*</span></label>
                <input type="text" name="cust_ic_no" id="cust_ic_no" placeholder="IC No" class="form-control text-4" required>
              </div>
          </div>
				</div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group col">
              <label class="form-label text-color-dark text-3">Email ID <span class="text-color-danger">*</span></label>
              <input type="email" name="cust_email" id="cust_email" placeholder="Email" class="form-control text-4" required>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group col">
                <label class="form-label text-color-dark text-3">User Name<span class="text-color-danger">*</span></label>
                <input type="text" name="cust_username" id="cust_username" placeholder="User Name" class="form-control text-4" required>
              </div>
          </div>
				</div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group col">
              <label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
              <input type="password" name="cust_password" id="cust_password" placeholder="Password" class="form-control text-4" required>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group col">
                <label class="form-label text-color-dark text-3">Confirm Password<span class="text-color-danger">*</span></label>
                <input type="password" name="cust_confirm_password" id="cust_confirm_password" placeholder="Confirm Password" class="form-control text-4" required>
              </div>
          </div>
				</div>

				<div class="row">
          <div class="col-md-12">
            <div class="form-group col">
              <button type="submit" class="btn w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3 button1" >Submit<span></span><span></span></button>

              <p style="margin-top: 10px;color: #ffffff;font-weight: 800;text-align:right;">Please click here to <a href="customer_login" >Login</a></p>
            </div>
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
   <script src="<?php echo base_url(); ?>/assets/jquery.validate.js"></script>

<script>
    $(document).ready(function () {
      $('#frmSignIn').validate({
        rules: {
          cust_name: {
            required: true
          },
          cust_ic_no: {
            required: true
          },
          cust_email: {
            required: true,
            email: true,
            remote: {
              url: "<?php echo base_url(); ?>/customer_register/email_check",
              data: {
                cust_email: $(this).data('cust_email')
              },
              type: "post",
            },
          },
          cust_username: {
            required: true,
            remote: {
              url: "<?php echo base_url(); ?>/customer_register/username_check",
              data: {
                cust_username: $(this).data('cust_username')
              },
              type: "post",
            },
          },
          cust_password: {
            required: true,
            minlength: 6
          },
          cust_confirm_password: {
            required: true,
            equalTo: "#cust_password"
          }
        },
        messages: {
          cust_name: 'Please enter name.',
          cust_ic_no: 'Please enter ic no.',
          cust_email: {
            required: 'Please enter email address.',
            email: 'Please enter a valid email address.',
            remote: "email address already exist.",
          },
          cust_username: {
            required: 'Please enter username.',
            remote: "username already exist.",
          },
          cust_password: {
            required: 'Please enter password.',
            minlength: 'Password must be at least 6 characters long.',
          },
          cust_confirm_password: {
            required: 'Please enter confirm password.',
            equalTo: 'Confirm password do not match with password.',
          }
        },
        submitHandler: function (form) {
          form.submit();
        }
      });
    });
</script>

</body>
</html>
