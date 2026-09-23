<?php
global $lang;
?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
     @media screen and (min-width: 320px) and (max-width: 768px) {
   section.content {
    margin: 117px auto 40px;
}
  }
    body{   overflow-x: hidden;}
a.con { cursor:pointer; text-decoration:none; }
.info-box { cursor: pointer !important; }
.btn { color:#FFFFFF; }
.total { background:#e91e63; /*padding:5px;*/ text-align:center; color:#FFFFFF; font-size:30px; font-weight:bold; }
.table tr td, .table tr th { padding:5px !important; }
.card .header { padding: 10px;}
.first::-webkit-scrollbar, .sec::-webkit-scrollbar, .thr::-webkit-scrollbar, .four::-webkit-scrollbar {
  width: 3px;
}
.first::-webkit-scrollbar-track, .sec::-webkit-scrollbar-track, .thr::-webkit-scrollbar-track, .four::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
.first::-webkit-scrollbar-thumb {
  background: #cd1a57; 
}
.first::-webkit-scrollbar-thumb:hover {
  background: #e91e63; 
}
.sec::-webkit-scrollbar-thumb {
  background: #00a5ba; 
}
.sec::-webkit-scrollbar-thumb:hover {
  background: #00bcd4; 
}
.thr::-webkit-scrollbar-thumb {
  background: #7aab41; 
}
.thr::-webkit-scrollbar-thumb:hover {
  background: #8bc34a; 
}
.four::-webkit-scrollbar-thumb {
  background: #e08600; 
}
.four::-webkit-scrollbar-thumb:hover {
  background: #ff9800; 
}
.grand_total { font-size:40px; color:#FFFFFF; font-weight:bold; text-align:center; background:#a1a09f; line-height:45px; }
/*section.content {
    margin: 80px auto 0;
}*/

.card .header {
    padding: 2px !important;
}
table.dataTable {
     margin-top: 0px !important; 
}
.table tr td, .table tr th {
    padding: 2px !important;
}
.card .body .col-xs-12, .card .body .col-sm-12, .card .body .col-md-12, .card .body .col-lg-12 {
    margin-bottom: 10px !important;
}
.table tr th { background:#FFF !important; color:#000 !important; }
</style>

<section class="content">
    
<?php
if ($_SESSION['role'] == 1 && $_SESSION['log_name'] == "admin") {
    if ($view) {
        ?>

                                    <div class="container-fluid">
                                        <!--<div class="block-header">
            <h2>DASHBOARD</h2>
        </div>-->

                                        <!-- Widgets -->
                                        <div class="row clearfix">
                                        <?php if ($_SESSION['succ'] != '') { ?>
                                                                            <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                                                                                <div class="suc-alert">
                                                                                    <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                                                                    <p><?php echo $_SESSION['succ']; ?></p> 
                                                                                </div>
                                                                            </div>
                                        <?php } ?>
                                        <?php if ($_SESSION['fail'] != '') { ?>
                                                                            <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                                                                                <div class="alert">
                                                                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                                                                    <p><?php echo $_SESSION['fail']; ?></p>
                                                                                </div>
                                                                            </div>
                                            <?php } ?>
                                            <?php /* <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="con" href="<?php echo base_url(); ?>/archanaibooking">
                            <div class="info-box bg-pink hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">playlist_add_check</i>
                                </div>
                                <div class="content">
                                    <div class="text">ARCHANAI BOOKING</div>
                                    <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div> 
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="con" href="<?php echo base_url(); ?>/hallbooking">
                            <div class="info-box bg-cyan hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">add_task</i>
                                </div>
                                <div class="content">
                                    <div class="text">HALL BOOKING</div>
                                    <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="con" href="<?php echo base_url(); ?>/donation">
                            <div class="info-box bg-light-green hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">credit_card</i>
                                </div>
                                <div class="content">
                                    <div class="text">CASH DONATION</div>
                                    <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                                </div>
                            </div
                            ></a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="con" href="<?php echo base_url(); ?>/ubayam">
                            <div class="info-box bg-orange hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">person_add</i>
                                </div>
                                <div class="content">
                                    <div class="text">UBAYAM</div>
                                    <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                                </div>
                            </div>
                            </a>
                        </div> */?>
                                        </div>
        
                                        <!--<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="body bg-pink">
                        <div class="sparkline" data-type="line" data-spot-Radius="4" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#fff"
                             data-min-Spot-Color="rgb(255,255,255)" data-max-Spot-Color="rgb(255,255,255)" data-spot-Color="rgb(255,255,255)"
                             data-offset="90" data-width="100%" data-height="92px" data-line-Width="2" data-line-Color="rgba(255,255,255,0.7)"
                             data-fill-Color="rgba(0, 188, 212, 0)">
                            12,10,9,6,5,6,10,5,7,5,12,13,7,12,11
                        </div>
                        <ul class="dashboard-stat-list">
                            <li>
                                TODAY
                                <span class="pull-right"><b>1 200</b> <small>USERS</small></span>
                            </li>
                            <li>
                                YESTERDAY
                                <span class="pull-right"><b>3 872</b> <small>USERS</small></span>
                            </li>
                            <li>
                                LAST WEEK
                                <span class="pull-right"><b>26 582</b> <small>USERS</small></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="body bg-cyan">
                        <div class="m-b--35 font-bold">LATEST SOCIAL TRENDS</div>
                        <ul class="dashboard-stat-list">
                            <li>
                                #socialtrends
                                <span class="pull-right">
                                    <i class="material-icons">trending_up</i>
                                </span>
                            </li>
                            <li>
                                #materialdesign
                                <span class="pull-right">
                                    <i class="material-icons">trending_up</i>
                                </span>
                            </li>
                            <li>#adminbsb</li>
                            <li>#freeadmintemplate</li>
                            <li>#bootstraptemplate</li>
                            <li>
                                #freehtmltemplate
                                <span class="pull-right">
                                    <i class="material-icons">trending_up</i>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="body bg-teal">
                        <div class="font-bold m-b--35">ANSWERED TICKETS</div>
                        <ul class="dashboard-stat-list">
                            <li>
                                TODAY
                                <span class="pull-right"><b>12</b> <small>TICKETS</small></span>
                            </li>
                            <li>
                                YESTERDAY
                                <span class="pull-right"><b>15</b> <small>TICKETS</small></span>
                            </li>
                            <li>
                                LAST WEEK
                                <span class="pull-right"><b>90</b> <small>TICKETS</small></span>
                            </li>
                            <li>
                                LAST MONTH
                                <span class="pull-right"><b>342</b> <small>TICKETS</small></span>
                            </li>
                            <li>
                                LAST YEAR
                                <span class="pull-right"><b>4 225</b> <small>TICKETS</small></span>
                            </li>
                            <li>
                                ALL
                                <span class="pull-right"><b>8 752</b> <small>TICKETS</small></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>-->
                                        </div>

                                        <div class="container-fluid" style="margin-bottom: 10px;">
                                            <div class="row clearfix">
                                                <div class="col-sm-2 col-md-2">
                                                    <div class="form-group form-float" style="margin-bottom: 0;">
                                                        <div class="form-line" id="bs_datepicker_container" >
                                                            <input type="date" name="dt" id="dt" class="form-control" value="<?php echo date('Y-m-d'); ?>"  max="<?php echo $booking_calendar_range_year; ?>">
                                                        </div>                                                        
                                                    </div>                                            
                                                </div>
                                                <?php
                                                ob_start();
                                                $hall_total = 0;
                                                if (!empty($hall) > 0) {
                                                    foreach ($hall as $ha) {
                                                        $hall_total += $ha['amount'];
                                                        echo '<tr>
								<td style="width: 75%;">' . $ha['event_name'] . '</th>
								<td>' . $ha['amount'] . '</th>
							</tr>';
                                                    }
                                                }
                                                $hall_html = ob_get_clean();
                                                ob_start();
                                                $archanai_total = 0;
                                                if (count($archanai) > 0) {
                                                    foreach ($archanai as $ar) {
                                                        $archanai_total += $ar['tAmt'];
                                                        echo '<tr>
								<td style="width: 50%;">' . $ar['name_eng'] . '</th>
								<td>' . $ar['tQty'] . '</th>
								<td>' . $ar['tAmt'] . '</th>
							</tr>';
                                                    }
                                                }
                                                $archanai_html = ob_get_clean();

                                                // ob_start();
                                                // $inventory_total = 0;
                                                // if(count($inventory) > 0){
                                                // 	foreach($archanai as $ar){
                                                // 		$inventory_total += $ar['tAmt'];
                                                // 		echo '<tr>
                                                // 				<td style="width: 50%;">' . $ar['name'] . '</th>
                                                // 				<td>' . $ar['quantity'] . '</th>
                                                // 				<td>' . $ar['amount'] . '</th>
                                                // 			</tr>';
                                                // 	}
                                                // }
                                                // $inventory_html = ob_get_clean();
                                        

                                                ob_start();
                                                $donation_total = 0;
                                                if (count($donation) > 0) {
                                                    foreach ($donation as $do) {
                                                        $donation_total += $do['amount'];
                                                        echo '<tr>
								<td style="width: 75%;">' . $do['dname'] . '</th>
								<td>' . $do['amount'] . '</th>
							</tr>';
                                                    }
                                                }
                                                $donation_html = ob_get_clean();
                                                ob_start();
                                                $ubayam_total = 0;
                                                if (!empty($ubayam) > 0) {
                                                    foreach ($ubayam as $ub) {
                                                        $ubayam_total += $ub['amount'];
                                                        echo '<tr>
								<td style="width: 75%;">' . $ub['ubname'] . '</th>
								<td>' . $ub['amount'] . '</th>
							</tr>';
                                                    }
                                                }
                                                $ubayam_html = ob_get_clean();
                                                ?>
                                                <div class="col-sm-10 col-md-10">
                                                    <div class="grand_total">
                                                        <div><?php echo $lang->grand; ?> : RM 
                                                        <span class="grand_total_amt"><?php echo number_format($ubayam_total + $donation_total + $hall_total + $archanai_total, 2, '.', ''); ?></span></div>
                                                    </div>                                           
                                                </div>
                
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <!-- Task Info -->
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="col-md-12"><div class="card">
                                                    <div class="header" style="background:#cd1a57;">
                                                        <div class="row">
                                                            <div class="col-md-8 col-xs-6 col-sm-8"><h2 style="color:#FFFFFF; padding:7px;"><?php echo $lang->archanai; ?></h2></div>
                                                            <div class="col-md-4 col-xs-6 col-sm-4" style="text-align:right;">
                                                            <!--<a class="btn btn-pink" href="<?php base_url() ?>/archanaibooking"><i class="material-icons">add</i></a>-->
                                                            <a class="btn btn-pink" href="<?php base_url() ?>/archanai"><i class="material-icons">settings</i></a>
                                                            <a class="btn btn-pink" id="arch_prt" href="<?php echo base_url() . '/report/print_archanaireport?fdt=' . date('Y-m-d') . '&tdt=' . date('Y-m-d'); ?>" target="_blank"><i class="material-icons">print</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="body" style="padding:0;">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped dataTable" id="rep_arch">       
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 45%;"><?php echo $lang->name; ?></th>
                                                                        <th><?php echo $lang->quantity; ?></th>
                                                                        <th><?php echo $lang->amount; ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="first over_fl">
                                                                    <?php
                                                                    echo $archanai_html;
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="total">
                                                            <div><?php echo $lang->total; ?> : RM <span class="ar_total"><?php echo number_format($archanai_total, 2, '.', ''); ?></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <!--div class="header">
                            <h2>Ubayam</h2>
                        </div-->
                                                        <div class="body">
                                                            <canvas id="line_chart" height="105"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #END# Task Info -->
                                            <!-- Browser Usage -->
                                            <div style="clear:both"></div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="col-md-12"><div class="card">
                                                    <div class="header" style="background:#00a5ba;">
                                                        <div class="row">
                                                            <div class="col-md-8 col-xs-6 col-sm-8"><h2 style="color:#FFFFFF; padding:7px;">Hall <?php echo $lang->booking; ?></h2></div>
                                                            <div class="col-md-4 col-xs-6 col-sm-4" style="text-align:right;">
                                                            <a class="btn btn-blue" href="<?php base_url() ?>/hallbooking"><i class="material-icons">add</i></a>
                                                            <a class="btn btn-blue" href="<?php base_url() ?>/master/hall"><i class="material-icons">settings</i></a>
                                                            <a class="btn btn-blue" id="hall_prt" href="<?php echo base_url() . '/report/print_hallbooking?fdt=' . date('Y-m-d') . '&tdt=' . date('Y-m-d'); ?>" target="_blank"><i class="material-icons">print</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="body" style="padding:0;">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped dataTable" id="rep_hall">       
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 70%;"><?php echo $lang->name; ?></th>
                                                                        <th><?php echo $lang->amount; ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="sec over_fl">
                                                                <?php
                                                                echo $hall_html;
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="total" style="background:#00bcd4;">
                                                            <div><?php echo $lang->total; ?> : RM <span class="ha_total"><?php echo number_format($hall_total, 2, '.', ''); ?></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <!--div class="header">
                            <h2>Ubayam</h2>
                        </div-->
                                                        <div class="body">
                                                            <canvas id="line_chart_two" height="105"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                                </div></div>
                                            </div>
                                            <!-- #END# Browser Usage -->
                                        </div>
                                        <div class="row clearfix">
                                            <!-- Task Info -->
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="col-md-12"><div class="card">
                                                    <div class="header" style="background:#7aab41;">
                                                        <div class="row">
                                                            <div class="col-md-8 col-xs-6 col-sm-8"><h2 style="color:#FFFFFF; padding:7px;"><?php echo $lang->donation; ?></h2></div>
                                                            <div class="col-md-4 col-xs-6 col-sm-4" style="text-align:right;">
                                                            <a class="btn btn-light_green" href="<?php base_url() ?>/donation"><i class="material-icons">add</i></a>
                                                            <a class="btn btn-light_green" href="<?php base_url() ?>/master/donation_setting"><i class="material-icons">settings</i></a>
                                                            <a class="btn btn-light_green" id="cash_don_prt" href="<?php echo base_url() . '/report/print_cashreport?fdt=' . date('Y-m-d') . '&tdt=' . date('Y-m-d'); ?>" target="_blank"><i class="material-icons">print</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="body" style="padding:0;">
                        
                                                        <div class="table-responsive">
                                                            <table class="table table-striped dataTable" id="rep_don">       
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 70%;"><?php echo $lang->name; ?></th>
                                                                        <th><?php echo $lang->amount; ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="thr over_fl">
                                                                <?php
                                                                echo $donation_html;
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="total col-md-12" style="background:#8bc34a;">
                                                            <div><?php echo $lang->total; ?> : RM <span class="do_total"><?php echo number_format($donation_total, 2, '.', ''); ?></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></div>
                                            <!-- #END# Task Info -->
                                            <!-- Browser Usage -->
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                <div class="col-md-12"><div class="card">
                                                    <div class="header" style="background:#e08600;">
                                                        <div class="row">
                                                            <div class="col-md-8 col-xs-6 col-sm-8"><h2 style="color:#FFFFFF; padding:7px;"><?php echo $lang->ubayam; ?></h2></div>
                                                            <div class="col-md-4 col-xs-6 col-sm-4" style="text-align:right;">
                                                            <a class="btn btn-orange" href="<?php base_url() ?>/ubayam"><i class="material-icons">add</i></a>
                                                            <a class="btn btn-orange" href="<?php base_url() ?>/master/ubayam_setting"><i class="material-icons">settings</i></a>
                                                            <a class="btn btn-orange" id="ubay_prt" href="<?php echo base_url() . '/report/print_ubayamreport?fdt=' . date('Y-m-d') . '&tdt=' . date('Y-m-d'); ?>" target="_blank"><i class="material-icons">print</i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="body" style="padding:0;">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped dataTable" id="rep_ubay">       
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 70%;"><?php echo $lang->name; ?></th>
                                                                        <th><?php echo $lang->amount; ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="four over_fl">
                                                                <?php
                                                                echo $ubayam_html;
                                                                ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="total" style="background:#ff9800;">
                                                            <div><?php echo $lang->total; ?> : RM <span class="ub_total"><?php echo number_format($ubayam_total, 2, '.', ''); ?></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div></div>
                                        </div>
        
        
        
        
        
        
        
        
        
        
<!--div class="row clearfix">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="col-md-12"><div class="card">
			<div class="header" style="background:#cd1a57;">
				<div class="row">
					<div class="col-md-8 col-xs-6 col-sm-8"><h2 style="color:#FFFFFF; padding:7px;">Inventory</h2></div>
					<div class="col-md-4 col-xs-6 col-sm-4" style="text-align:right;">
					<a class="btn btn-pink" href="<?php base_url() ?>/product"><i class="material-icons">settings</i></a>
					</div>
				</div>
			</div>
			<div class="body" style="padding:0;">
				<div class="table-responsive">
					<table class="table table-striped dataTable" id="rep_arch">       
						<thead>
							<tr>
                            <th style="width: 45%;">Name</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tbody class="first over_fl">
							<?php
							if (count($inventory_stock) > 0) {
								foreach ($inventory_stock as $ar) {
									//$archanai_inventory_total += $ar['tAmt'];
									echo '<tr>
											<td style="width: 50%;">' . $ar['item_name'] . '</th>
											<td>' . $ar['inventory_qty'] . '</th>
										</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="total">
					<div>&nbsp;</div>
					<div><?php echo $lang->total; ?> : RM <span class="ar_total"><?php echo number_format($archanai_inventory_total, 2, '.', ''); ?></span></div>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="col-md-12"><div class="card">
			<div class="header" style="background:#cd1a57;">
				<div class="row">
					<div class="col-md-8 col-xs-6 col-sm-8"><h2 style="color:#FFFFFF; padding:7px;">Minimum Stock</h2></div>
					<div class="col-md-4 col-xs-6 col-sm-4" style="text-align:right;">
					<a class="btn btn-pink" href="<?php base_url() ?>/product"><i class="material-icons">settings</i></a>
					</div>
				</div>
			</div>
			<div class="body" style="padding:0;">
				<div class="table-responsive">
					<table class="table table-striped dataTable" id="rep_arch">       
						<thead>
							<tr>
								<th style="width: 45%;">Type</th>
								<th>Name</th>
								<th>Available Stock</th>
							</tr>
						</thead>
						<tbody class="first over_fl">
							<?php
							if (count($minimum_stock) > 0) {
								foreach ($minimum_stock as $ms) {
									echo '<tr>';
									echo '<td>' . $ms['type'] . '</td>';
									echo '<td>' . $ms['name'] . '</td>';
									echo '<td>' . $ms['stock'] . '</td>';
									echo '</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="total">
					<div>&nbsp;</div>
				</div>
			</div>
		</div>
		</div>
	</div>

</div-->
        
        
        
        
        
                        <?php }
}
?>
        <?php /* <div class="row clearfix">
<div class="col-md-12">
  <div class="grand_total">
      <div>Grand Total: RM <span class="grand_total_amt"><?php echo number_format($ubayam_total + $donation_total + $hall_total + $archanai_total, 2, '.', ''); ?></span></div>
  </div>
</div>
</div> */?>
        
        
        
        
        
        
</section>
<!-- Chart Plugins Js -->
<script src="<?php echo base_url(); ?>/assets/plugins/chartjs/Chart.bundle.js"></script>
<script>
$(function () {
    new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
    new Chart(document.getElementById("line_chart_two").getContext("2d"), getChartJs('line_two'));
    //new Chart(document.getElementById("radar_chart").getContext("2d"), getChartJs('radar'));
    //new Chart(document.getElementById("pie_chart").getContext("2d"), getChartJs('pie'));
});
function getChartJs(type) {
    var config = null;
    if (type === 'line') {
        config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                    label: "ARCHANAI BOOKING COUNT",
                    data: <?php echo $archanai_charts; ?>,
                    borderColor: 'rgba(205, 26, 87, 0.75)',
                    backgroundColor: 'rgba(205, 26, 87, 0.3)',
                    pointBorderColor: 'rgba(205, 26, 87, 0)',
                    pointBackgroundColor: 'rgba(205, 26, 87, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    if (type === 'line_two') {
        config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [{
                    label: "HALLBOOKING COUNT",
                    data: <?php echo $hallbooking_charts; ?>,
                    borderColor: 'rgba(0, 165, 186, 0.75)',
                    backgroundColor: 'rgba(0, 165, 186, 0.3)',
                    pointBorderColor: 'rgba(0, 165, 186, 0)',
                    pointBackgroundColor: 'rgba(0, 165, 186, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    return config;
}

    $(document).ready
(
    function()
    {        
        /* rep_ubay = $('#rep_ubay').DataTable({
           
            "ajax":{
                url: "<?php echo base_url(); ?>/dashboard/ubayam_rep",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.dt = $('#dt').val();                    
                    }
            },
        });

        rep_don = $('#rep_don').DataTable({
            
            "ajax":{
                url: "<?php echo base_url(); ?>/dashboard/cash_don_rep",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.dt = $('#dt').val();                    
                    }
            },
        });

        rep_arch = $('#rep_arch').DataTable({
            
            "ajax":{
                url: "<?php echo base_url(); ?>/dashboard/arch_rep",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.dt = $('#dt').val();                    
                    }
            },
        });
        rep_hall = $('#rep_hall').DataTable({
            
            "ajax":{
                url: "<?php echo base_url(); ?>/dashboard/hall_rep",
                dataType: "json",
                type: "POST",
                data: function ( data ) {
                    data.dt = $('#dt').val();                    
                    }
            },
        }); */
        $('#dt').change(function() {

        $("#arch_prt").attr("href", '<?php base_url() ?>/report/print_archanaireport?fdt='+$('#dt').val()+'&tdt='+$('#dt').val());
        $("#hall_prt").attr("href", '<?php base_url() ?>/report/print_hallbooking?fdt='+$('#dt').val()+'&tdt='+$('#dt').val());
        $("#ubay_prt").attr("href", '<?php base_url() ?>/report/print_ubayamreport?fdt='+$('#dt').val()+'&tdt='+$('#dt').val());
        $("#cash_don_prt").attr("href", '<?php base_url() ?>/report/print_cashreport?fdt='+$('#dt').val()+'&tdt='+$('#dt').val());
        
        //
            var dt = $('#dt').val()
            $.ajax({
                url: "<?php echo base_url(); ?>/dashboard/reload_list",
                dataType: "json",
                type: "POST",
                data: {dt: dt},
                beforeSend: function(){
                    var load_html = '<tr><td colspan="3" class="loader"><img src="<?php base_url() ?>/assets/images/loader.gif" /></td></tr>';
                    $('.first').html(load_html);
                    $('.sec').html(load_html);
                    $('.thr').html(load_html);
                    $('.four').html(load_html);
                },
                success: function ( result ) {
                    console.log(result);
                    if(result.success){
                        var ar_html = '';
                        var hl_html = '';
                        var do_html = '';
                        var ub_html = '';
                        var ar_total = 0;
                        var ha_total = 0;
                        var do_total = 0;
                        var ub_total = 0;
                        if(result.data.archanai.length){
                            var archanai_data = result.data.archanai
                            for(var i=0; i<archanai_data.length; i++){
                                ar_html += '<tr><td style="width: 50%;">' + archanai_data[i]['name_eng'] + '</td><td>' + archanai_data[i]['tQty'] + '</td><td>' + archanai_data[i]['tAmt'] + '</td></tr>';
                                ar_total += parseFloat(archanai_data[i]['tAmt']);
                            }
                        }
                        if(result.data.hall.length){
                            var hall_data = result.data.hall
                            for(var i=0; i<hall_data.length; i++){
                                hl_html += '<tr><td style="width: 75%;">' + hall_data[i]['event_name'] + '</td><td>' + hall_data[i]['amount'] + '</td></tr>';
                                ha_total += parseFloat(hall_data[i]['amount']);
                            }
                        }
                        if(result.data.donation.length){
                            var donation_data = result.data.donation
                            for(var i=0; i<donation_data.length; i++){
                                do_html += '<tr><td style="width: 75%;">' + donation_data[i]['dname'] + '</td><td>' + donation_data[i]['amount'] + '</td></tr>';
                                do_total += parseFloat(donation_data[i]['amount']);
                            }
                        }
                        if(result.data.ubayam.length){
                            var ubayam_data = result.data.ubayam
                            for(var i=0; i<ubayam_data.length; i++){
                                ub_html += '<tr><td style="width: 75%;">' + ubayam_data[i]['ubname'] + '</td><td>' + ubayam_data[i]['amount'] + '</td></tr>';
                                ub_total += parseFloat(ubayam_data[i]['amount']);
                            }
                        }
                        $('.first').html(ar_html);
                        $('.sec').html(hl_html);
                        $('.thr').html(do_html);
                        $('.four').html(ub_html);
                        $('.ub_total').html(ub_total.toFixed(2));
                        $('.do_total').html(do_total.toFixed(2));
                        $('.ha_total').html(ha_total.toFixed(2));
                        $('.ar_total').html(ar_total.toFixed(2));
                        var grand_total = parseFloat(ub_total) + parseFloat(do_total) + parseFloat(ha_total) + parseFloat(ar_total);
                        $('.grand_total_amt').html(grand_total.toFixed(2));
                    }
                },
                error: function ( err ) {
                    console.log('err');
                    console.log(err);
                }
            });
        });
    });

</script>
<style>
tbody {
    display:block;
    height:50px;
    overflow:auto;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
thead tr th, tbody tr td{
    text-align: center;
}
.over_fl{
    overflow-y:scroll;
    overflow-x:hidden;
    height: 125px;
}
.loader{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 121px;
    padding: 0;
}
.table tr td.loader{
    padding: 0 !important;
}
input[type=date]::-webkit-datetime-edit {
    color: #555;
}
#dt{
    /*margin-top: 8px;*/
    height: 45px;
    /*height:60px;*/
    margin-bottom: 0;
    font-size: 20px;
}
.row .card{
    margin-bottom: 10px;
}
</style>