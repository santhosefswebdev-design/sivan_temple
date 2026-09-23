<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<style>
    /*body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }*/
	.table1{ border:1px solid #CCCCCC; }
	.table1 tr th { background-color:#EFEFEF; padding:5px; min-width:130px; font-size:16px; }
	.table1 tr td:first-child { padding:5px; text-align:left; }
	.table1 tr td { padding:5px; }
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
.bootstrap-select.btn-group .dropdown-menu.inner {
    padding-bottom:50px;
}
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-4"><h2>Cash Expense</h2></div>
                        </div>
                    </div>
                    <div class="body" style="padding-top: 30px;"> 
                        <form action="<?php echo base_url(); ?>/reportaccount/cash_expense" method="get">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-3">
                                    <div class="form-group form-float">
                                        <div class="form-line"> <!--data-live-search-style="startsWith"-->
                                            <select class="form-control search_box" data-live-search="true" name="ledger" id="ledger"data-actions-box="true" data-selected-text-format="count">
                                                <?php foreach($ledger as $row){ ?>
                                                   <?php echo $row; ?>
                                              <?php  } // print_r($ledger); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;">Month</label>
                                            <input type="month"  name="month" id="month" class="form-control" value="<?php echo $month; ?>" max="<?php echo $booking_calendar_range_year; ?>">
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-2">
                                    <div class="form-group form-float">
                                        <div class="form-line"> <!--data-live-search-style="startsWith"-->
                                            <select class="form-control search_box" data-live-search="true" name="filter_option" id="filter_option" data-actions-box="true" data-selected-text-format="count">
                                                <option <?php echo ($filter_option == 'single' ? ' selected': ''); ?> value="single">Single</option>
                                                <option <?php echo ($filter_option == 'separate' ? ' selected': ''); ?> value="separate">Separate</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php if($view != true) { ?>
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">SUBMIT</button>
                                    <label id="print" class="btn btn-primary btn-lg waves-effect">Print</label>
                                </div>
                                <?php } ?>
                                </div>
                                </div>
                     </form>
                           
                    <form style="display: none;" target="_blank" action="<?php echo base_url(); ?>/reportaccount/print_cash_expense" method="GET" id="print_ledger">
                        <input type="hidden"  name="print" id="print" class="form-control" value="1" >
                        <input type="hidden"  name="ledger" id="ledger" class="form-control" value="<?php echo $ledger_id; ?>" >
                        <input type="hidden"  name="month" id="month" class="form-control" value="<?php echo $month; ?>" >
                        <input type="hidden"  name="filter_option" id="filter_option" class="form-control" value="<?php echo $filter_option; ?>" >
                        <button type="submit" id="print_sub" class="btn btn-success">Submit</button>
                    </form>
				<?php if(!empty($ledger_id)){ ?>
					<h3 style="text-transform: uppercase;font-size: 18px;margin:15px 0px;"><?php echo $ledgername_code; ?></h3>
					<div class="table-responsive">
						<table class="table1" border="1" width="1000" align="center" style="border-collapse:collapse; font-family: Arial, Helvetica, sans-serif; font-size: 15px;">
							<thead>
								<tr style="padding: 15px 0;">
									<?php if($filter_option == 'separate'){ ?>
									<td width="10%" align="left" style="padding: 15px 5px;"><strong>Date</strong></td>
									<?php } ?>
									<td width="30%" align="left" style="padding: 15px 5px;"><strong>Ledger</strong></td>
									<td width="40%" align="right" style="padding: 15px 5px;"><strong>Description</strong></td>
									<td width="20%" align="right" style="padding: 15px 5px;"><strong>Amount</strong></td>
								</tr>
							</thead>
							<tbody>
								<?php 
								$total_amount = 0;
								if(count($exp_list) > 0){
									foreach($exp_list as $row) { 
									?>
										<tr>
											<?php if($filter_option == 'separate'){ ?>
											<td style="padding: 6px 0;" ><?= date('d-m-Y',strtotime($row['date'])); ?></td>
											<?php } ?>
											<td style="padding: 6px 0;" ><?= '(' . $row['left_code'] . '/' . $row['right_code'] . ') - ' . $row['name']; ?></td>
											<td align="right" style="padding: 6px 0;" ><?= $row['narration']; ?></td>
											<td align="right" style="padding: 6px 0;" ><?php
											$total_amount += $row['amount'];
												if($row['amount'] < 0){
													echo "( ".number_format(abs($row['amount']),2)." )";
												}
												else{
													echo number_format($row['amount'],2);
												}
												?>
											</td>
										</tr>
									<?php 
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
								<?php if($filter_option == 'separate'){ ?>
								<td colspan="2"></td>
								<?php }else{ ?>
								<td colspan=""></td>
								<?php } ?>
									<td align="right"><b>Total</b></td>
									<td align="right"><?php
										if($total_amount < 0){
											echo "( ".number_format(abs($total_amount),2)." )";
										}
										else{
											echo number_format($total_amount,2);
										}
									?>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				<?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
$(document).ready(function(){
	$(".date_show").click(function(){ 
		$(".date").slideToggle();
	});
});

$("#clear").click(function(){
   $("input").val("");
});
</script>
<script type="text/javascript">
$(document).ready(function () {
	$("#print").click(function(){
		$("#print_sub").trigger('click');
	});
});
</script>