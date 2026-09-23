<style>
  table tr th {
    padding: 10px;
    background: #000000;
    color: #FFFFFF;
  }

  .form-group {
    width: 100%;
    margin: 5px auto;
    height: calc(3rem + 2px);
  }
</style>
<section class="page-header page-header-modern bg-color-light-scale-1 page-header-lg">
	<div class="container">
		<div class="row">
			<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
				<h1 class="text-color-dark font-weight-bold">Hall Booking</h1>
			</div>
			<div class="col-md-4 order-1 order-md-2 align-self-center">
				<ul class="breadcrumb d-flex justify-content-md-end text-3-5">
					<li><a href="<?php echo base_url(); ?>/home" class="text-color-default text-color-hover-primary text-decoration-none">HOME</a></li>
					<li class="active">New Hall Booking</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="content">
  <div class="container my-5">
    <div class="row">
      <!-- Basic Examples -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
			<div class="header">
				<div class="row">
				  <div class="col-md-12" align="center">
					<h2>HALL BOOKING</h2>
				  </div>
				</div>
			</div>
            <div class="body">
				<?php if($_SESSION['succ'] != '') { ?>
					<div class="row" style="padding: 0 30%;" id="content_alert">
						<div class="suc-alert">
							<span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
							<p><?php echo $_SESSION['succ']; ?></p> 
						</div>
					</div>
				<?php } ?>
				 <?php if($_SESSION['fail'] != '') { ?>
					<div class="row" style="padding: 0 30%;" id="content_alert">
						<div class="alert">
							<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
							<p><?php echo $_SESSION['fail']; ?></p>
						</div>
					</div>
				<?php } ?>
				<div class="container-fluid">
					
					<div class="row clearfix">
						<div class="col-md-12">
							<img src="<?php echo $qr_image; ?>" style="display:block;margin:0 auto;" />
							<p style="margin-top:20px;text-align:center;">
								<i>You can pay the amount to this <b>QR</b></i>
							</p>
						</div>
					</div>
				</div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
