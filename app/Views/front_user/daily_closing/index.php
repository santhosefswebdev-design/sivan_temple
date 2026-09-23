<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/archanai/style.css">
  <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/archanai/images/favicon.png" />
  <style>
body { height:100vh; width:100%; }
.prod::-webkit-scrollbar {
  width: 3px;
}
.prod::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.prod::-webkit-scrollbar-thumb {
  background: #d4aa00; 
}
.prod::-webkit-scrollbar-thumb:hover {
  background: #e91e63; 
}
a { text-decoration:none !important; }
.table tr th {
    border: 1px solid #f7e086;
    font-size: 14px;
    background: #f7ebbb;
    color: #333232;
}
.pack, .pay {
    margin-bottom: 15px;
}
.form-label {
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 1px;
    color:#333333;
    text-align: left;
    width: 100%;
}
.input { width:100%; text-align:left; }
select.input { color:#000; }

.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title { display:block !important; font-size:11px; color:#FFFFFF; }
.sidebar .nav .nav-item.active > .nav-link i.menu-icon {
    background: #edc10f;
    padding: 1px; list-style:outside;
    border-radius: 5px;
    box-shadow: 2px 5px 15px #00000017;
}
.sidebar-icon-only .sidebar .nav .nav-item .nav-link {
    display: block;
    padding-left: 0.25rem;
    padding-right: 0.25rem;
    text-align: center;
    position: static;
}
.sidebar-icon-only .sidebar .nav .nav-item .nav-link[aria-expanded] .menu-title {
    padding-top: 7px;
}
.sidebar-icon-only .main-panel {
    width: calc(100% - 0px);
}
.back { 
	background: #00000087;
    padding: 15px;
    color: white;
	min-height:120px;
 }
.back h5 { min-height:80px; font-size:15px; font-weight:bold; color:#FFFFFF; }
.greensubmit{
    background: #ab8a04!important;
    font-weight: bold!important;
    color: #ffffff!important;
    box-shadow: -1px 10px 20px #ab8a04;
    background: #ab8a04!important;
    background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
    background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
    background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%)!important;
}
.ar_btn {
    background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
    border-radius: 15px;
    font-weight: bold;
    height: 2.75em;
    margin: 10px;
}
</style>
<body class="sidebar-icon-only">
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      	<div class="main-panel">
			<div class="content-wrapper">
			<div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					<div class="header">
                        <div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-4" align="right">
								<a href="<?php echo base_url(); ?>/dailyclosing_online/print" target="_blank"><button type="button" class="btn btn-info btn-lg ar_btn">Print</button></a>
							</div>
						</div>
                    </div>
                    <div class="body">
						<div class="col-md-12"><h3>Archanai Selling Details</h3></div>
                        <div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
							<table class="table table-bordered table-striped table-hover">
								<thead style="background: #3F51B5;color: #fff;">
									<tr>
										<th style="padding: 5px 10px!important;">#</th>
										<th style="padding: 5px 10px!important;">Archanai</th>
										<th style="padding: 5px 10px!important;">Quantity</th>
										<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$archanai_total = 0;
									$ar_i = 1;
									if(count($archanai_details) > 0)
									{
										foreach($archanai_details as $archanai_detail)
										{
											$archanai_total = $archanai_total + $archanai_detail['amount'];
									?>
									<tr>
										<td style="padding: 5px 10px!important;"><?php echo $ar_i; ?></td>
										<td style="padding: 5px 10px!important;">
											<?php 
												echo $archanai_detail['name_in_english']." / ".$archanai_detail['name_in_tamil'];
											?>
										</td>
										<td style="padding: 5px 10px!important;">
											<?php 
												echo $archanai_detail['qty'];
											?>
										</td>
										<td style="padding: 5px 10px!important;text-align:right;">
											<?php 
												echo number_format($archanai_detail['amount'], 2);
											?>
										</td>
									</tr>
									<?php
										$ar_i++;
										}
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3">&nbsp;</td>
										<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($archanai_total, 2); ?></td>
									</tr>
								</tfoot>
							</table>
                        </div>
						<div class="col-md-12"><h3>Hall Booking Details</h3></div>
						<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
							<table class="table table-bordered table-striped table-hover">
								<thead style="background: #3F51B5;color: #fff;">
									<tr>
										<th style="padding: 5px 10px!important;">#</th>
										<th style="padding: 5px 10px!important;">Package</th>
										<th style="padding: 5px 10px!important;">Name</th>
										<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$hb_i = 1;
									$hallbooking_total = 0;
									if(count($hallbooking_details) > 0)
									{
										foreach($hallbooking_details as $hallbooking_detail)
										{
											$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];
									?>
									<tr>
										<td style="padding: 5px 10px!important;"><?php echo $hb_i; ?></td>
										<td style="padding: 5px 10px!important;">
											<?php 
											echo $hallbooking_detail['package_name'];
											?>
										</td>
										<td style="padding: 5px 10px!important;">
											<?php 
											echo $hallbooking_detail['person_name'];
											?>
										</td>
										<td style="padding: 5px 10px!important;text-align:right;">
											<?php 
											echo number_format($hallbooking_detail['paidamount'], 2);
											?>
										</td>
									</tr>
									<?php
										$hb_i++;
										}
									}
									?>
								</tbody>
								<tfoot >
									<tr>
										<td colspan="3">&nbsp;</td>
										<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($hallbooking_total, 2); ?></td>
									</tr>
								</tfoot>
							</table>
						</div>			
						<div class="col-md-12"><h3>Ubayam Details</h3></div>
						<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
							<table class="table table-bordered table-striped table-hover">
								<thead style="background: #3F51B5;color: #fff;">
									<tr>
										<th style="padding: 5px 10px!important;">#</th>
										<th style="padding: 5px 10px!important;">Type</th>
										<th style="padding: 5px 10px!important;">Name</th>
										<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$u_i = 1;
									$ubayam_total = 0;
									if(count($ubayam_details) > 0)
									{
										foreach($ubayam_details as $ubayam_detail)
										{
											$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];
									?>
									<tr>
										<td style="padding: 5px 10px!important;"><?php echo $u_i; ?></td>
										<td style="padding: 5px 10px!important;">
											<?php 
											echo $ubayam_detail['package_name'];
											?>
										</td>
										<td style="padding: 5px 10px!important;">
											<?php 
											echo $ubayam_detail['person_name'];
											?>
										</td>
										<td style="padding: 5px 10px!important;text-align:right;">
											<?php 
											echo number_format($ubayam_detail['paidamount'], 2);
											?>
										</td>
									</tr>
									<?php
										$u_i++;
										}
									}
									?>
								</tbody>
								<tfoot >
									<tr>
										<td colspan="3">&nbsp;</td>
										<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($ubayam_total, 2); ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="col-md-12"><h3>Cash Donation Details</h3></div>
						<div class="table-responsive col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">          
							<table class="table table-bordered table-striped table-hover">
								<thead style="background: #3F51B5;color: #fff;">
									<tr>
										<th style="padding: 5px 10px!important;">#</th>
										<th style="padding: 5px 10px!important;">Name</th>
										<th style="padding: 5px 10px!important;text-align:right;">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$d_i = 1;
									$donation_total = 0;
									if(count($donation_details) > 0)
									{
										foreach($donation_details as $donation_detail)
										{
											$donation_total = $donation_total + $donation_detail['paidamount'];
									?>
									<tr>
										<td style="padding: 5px 10px!important;"><?php echo $d_i; ?></td>
										<td style="padding: 5px 10px!important;">
											<?php 
											echo $donation_detail['person_name'];
											?>
										</td>
										<td style="padding: 5px 10px!important;text-align:right;">
											<?php 
											echo number_format($donation_detail['paidamount'], 2);
											?>
										</td>
									</tr>
									<?php
										$d_i++;
										}
									}
									?>
								</tbody>
								<tfoot >
									<tr>
										<td colspan="2">&nbsp;</td>
										<td style="padding: 5px 10px!important;text-align:right;font-weight:bold;"><?php echo number_format($donation_total, 2); ?></td>
									</tr>
								</tfoot>
							</table>
						</div>
						
						<div class="col-md-12 det" style="background:#FFF; float:none;margin-bottom:0px;">
							<h3 style="text-align:center;font-weight: bold;">
								TOTAL AMOUNT : 
								<?php 
									$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total;
									echo number_format($total, 2);
								?>
							</h3>
						</div>
                    </div>
                </div>
            </div>
        </div>
			</div>
		</div>
	</div>
</div>
</body>
</html>

