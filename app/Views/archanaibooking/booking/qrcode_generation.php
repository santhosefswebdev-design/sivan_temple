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
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="block-header">
        <h2> HALL BOOKING
        </h2>
      </div>
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
