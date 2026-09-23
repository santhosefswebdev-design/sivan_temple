<?php global $lang; ?>
<style>
    /*.thead{
        color: #fff;
        background-color: red;
    }
    a:hover { text-decoration: none; }
    body { background:#fff; }
    .content { max-width: 100%; padding: 0 .2rem; }
    .bootstrap-select .bs-searchbox { margin-left: 30px; }
    .bootstrap-select.btn-group .dropdown-menu.inner { margin-left: 30px; }*/
</style>
<?php
$min_date = '';
$max_date = '';
/*if(!empty($financial_year['start_date'])) $min_date = ' min="' . $financial_year['start_date'] .'"';
if(!empty($financial_year['end_date'])) $max_date = ' max="' . $financial_year['end_date'] .'"';*/
?>
<section class="content">
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <form action="<?php echo base_url(); ?>/aging/" method="get">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <select class="form-control" data-live-search="true" name="ledger" id="ledger">
                                                <option value=""><?php echo $lang->select; ?> <?php echo $lang->option; ?></option>
                                                <?php if(count($ledger) > 0){foreach($ledger as $row) {
                                                    print_r($row);
                                                }}  ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php /* <div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;"><?php echo $lang->from; ?> <?php echo $lang->date; ?></label>
                                            <input type="date"  name="fdate" id="fdate" value="<?php echo $fdate; ?>" class="form-control" max="<?php echo $booking_calendar_range_year; ?>">
                                            <!--<label class="form-label">From Date</label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;"><?php echo $lang->to; ?> <?php echo $lang->date; ?></label>
                                            <input type="date" name="tdate" id="tdate" value="<?php echo $tdate; ?>" class="form-control" max="<?php echo $booking_calendar_range_year; ?>">
                                            <!--<label class="form-label">To Date</label>-->
                                        </div>
                                    </div>
                                </div> */ ?>
								<?php /* <div class="col-sm-2">
                                    <div class="form-group form-float">
										<select class="form-control search_box" data-live-search="true" name="fund_id" id="fund_id">
											<?php
											if(!empty($funds))
											{
												foreach($funds as $fund)
												{
											?>
												<option value="<?php echo $fund["id"]; ?>" <?php if($fund_id == $fund["id"]){ echo "selected"; } ?>><?php echo $fund['name'] . '(' . $fund['code'] . ")"; ?> </option>
											<?php
												}
											}
											?>
										</select>                                                   
									</div>
                                </div> */ ?>
								<div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;"><?php echo $lang->from; ?> <?php echo $lang->date; ?></label>
                                            <input type="date"  name="aging_from_date" id="aging_from_date" value="<?php echo $fdate; ?>" class="form-control"<?php echo $min_date.$max_date; ?>>
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-2 date">
                                    <div class="form-group">
                                        <div class="form-line" style="margin-top:-20px;">
                                            <label class="form-label" style="display: contents;"><?php echo $lang->to; ?> <?php echo $lang->date; ?></label>
                                            <input type="date"  name="aging_to_date" id="aging_to_date" value="<?php echo $tdate; ?>" class="form-control"<?php echo $min_date.$max_date; ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" align="right">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect"><?php echo $lang->submit; ?></button>
                                </div>
                                </div>
                                </div>
                        </form>
						
                        <form action="<?php echo base_url(); ?>/aging/save?ledger=<?php echo !empty($_REQUEST['ledger']) ? $_REQUEST['ledger'] : $_REQUEST['ledger']; ?>" method="post" target="frame" onsubmit="onFormSubmit();">         
							<input type="hidden" name="aging_from_date" value="<?php echo $fdate; ?>" class="form-control hidden">
							<input type="hidden" name="aging_to_date" value="<?php echo $tdate; ?>" class="form-control hidden">
							<input type="hidden" name="fund_id" value="<?php echo $fund_id; ?>" class="form-control hidden">
							<input type="hidden" name="variance_amt" id="variance_amt" class="form-control hidden variance_amt">
                            <?php
							if(!empty($_REQUEST['ledger'])){
							?>
								<div class="row">
									<div class="col-md-6">						
										<div class="form-group form-float">
											<div class="form-line">
												<input type="number" name="bank_balance" id="bank_balance" value="<?php echo $reconcil_bank_balance; ?>" class="form-control" min="0" step="0.01" required>
												<label class="form-label">Invoice amount <span style="color: red;"> *</span></label>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-float" style="margin-top:-20px;">
											<div class="form-line">
												<label class="form-label" style="display: contents;">Received <?php echo $lang->date; ?> <span style="color: red;"> *</span></label>
												<input type="date"  name="received_date" id="received_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo $booking_calendar_range_year; ?>" required>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group form-float" style="margin-top:-20px;">
											<div class="form-line">
												<label class="form-label" style="display: contents;">Receipt Details <span style="color: red;"> *</span></label>
												<textarea class="form-control" name="receipt_detail" id="receipt_detail" required></textarea>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="cleared_balance" id="cleared_balance" value="<?php echo (!empty($cleared_balance) ? $cleared_balance : 0.00) ?>" >
							<?php
							}
							?>     
                            <div class="table-responsive">
								<table class="table stripped">
									<thead><tr>
									<th><input style="opacity:1;position:inherit;" type="checkbox" id="all"></th>
									<th><?php echo $lang->date; ?></th>
									<th><?php echo $lang->number; ?></th>
									<th><?php echo $lang->ledger; ?></th>
									<th><?php echo $lang->details; ?></th>
									<th style="text-align:right" ><?php echo $lang->debit; ?> <?php echo $lang->amount; ?></th>
									<th style="text-align:right" ><?php echo $lang->credit; ?> <?php echo $lang->amount; ?></th>
									<?php /* <th><?php echo $lang->clearance; ?> <?php echo $lang->mode; ?></th>
									<th><?php echo $lang->reconciliation; ?> <?php echo $lang->date; ?></th> */ ?>
									</tr>
									</thead>
									<?php 
									if(count($res) > 0){
									$i = 0;	
									?>
									<tbody>
										<?php foreach($res as $rs){
                                            $ledgername = get_ledger_name($rs['ledger_id']);
                                            ?>
										<tr>
										<td><input style="opacity:1;position:inherit;" type="checkbox" class="rec_tick_cl" name="rec_tick[<?php echo $i; ?>]" value="<?php echo $rs['entryitem_id']; ?>" id="rec_<?php echo $rs['entryitem_id']; ?>"></td>
										<td><?php echo date('d-M-Y', strtotime($rs['date'])); ?></td>
										<td><?php echo $rs['number']; ?></td>
										<td><?php echo $ledgername; ?></td>
										<td><?php echo $rs['details']; ?></td>
										<td align="right"><?php echo ($rs['dc'] == 'D' ? number_format($rs['amount'], "2",".",",") : 0.00); ?><input type="hidden" class="ei_debit" id="ei_debit_amount" value="<?php echo ($rs['dc'] == 'D' ? $rs['amount'] : 0.00); ?>" /></td>
										<td align="right"><?php echo ($rs['dc'] == 'C' ? number_format($rs['amount'], "2",".",",") : 0.00); ?><input type="hidden" class="ei_credit" id="ei_credit_amount" value="<?php echo ($rs['dc'] == 'C' ? $rs['amount'] : 0.00); ?>" /></td>

										</tr>
										<?php 
										$i++;
										}
										?>
									</tbody>
									<?php 
									}
									?>
								</table>
								<div class="row">&nbsp;</div>
								<div class="row clearfix">
									<div class="col-sm-6">
										<div class="form-group form-float" style="margin-top:-20px;">
											<div class="form-line">
												<label class="form-label" style="display: contents;">Bank Account <span style="color: red;"> *</span></label>
												<select class="form-control" data-live-search="true" name="bank_ledger" id="bank_ledger" required>
													<option value=""><?php echo $lang->select; ?> Bank Account Ledger</option>
													<?php
													if(!empty($bank_ledgers))
													{
														foreach($bank_ledgers as $ledger)
														{
													?>
														<option value="<?php echo $ledger["id"]; ?>" ><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - " . $ledger["name"]; ?></option>

													<?php
														}
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group form-float" style="margin-top:-20px;">
											<div class="form-line">
												<label class="form-label" style="display: contents;">Charges <span style="color: red;"> *</span></label>
												<select class="form-control" data-live-search="true" name="charges_ledger" id="charges_ledger" required>
													<option value=""><?php echo $lang->select; ?> Charges Ledger</option>
													<?php
													if(!empty($charge_ledgers))
													{
														foreach($charge_ledgers as $cledger)
														{
													?>
														<option value="<?php echo $cledger["id"]; ?>" ><?php echo $cledger['left_code'] . '/' . $cledger['right_code'] . " - " . $cledger["name"]; ?></option>

													<?php
														}
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-12">&nbsp;</div>
                                </div>
								<div class="col-sm-12 variance_message" align="center">
									
								</div>
								<div class="col-sm-2" align="right">
                                    <input type="submit" class="btn btn-success btn-lg waves-effect" value="SAVE">
									<?php 
									if(!empty($ledger_id) && !empty($fund_id)&& !empty($fdate) && !empty($tdate)){
										echo '<a href="' . base_url() . '/aging/print/' . $ledger_id . '?fund_id=' . $fund_id . '&aging_from_date='.$fdate.'&aging_to_date='.$tdate.'" target="_blank" id="print" class="btn btn-primary">Print</a>';
									}
									?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
	function calc_checked_total(){
		var cleared_balance = parseFloat($('#cleared_balance').val());
		var bank_balance = parseFloat($('#bank_balance').val());
		var debit_balance = credit_balance = 0;
		$('.rec_tick_cl:checked').each(function(){
			debit_balance += parseFloat($(this).parent().parent().find('.ei_debit').val());
			credit_balance += parseFloat($(this).parent().parent().find('.ei_credit').val());
		});
		console.log(debit_balance);
		console.log(credit_balance);
		cleared_balance += Math.round((debit_balance + Number.EPSILON) * 100) / 100 - Math.round((credit_balance + Number.EPSILON) * 100) / 100;
		var variance = bank_balance - cleared_balance;
		variance = Math.round((variance + Number.EPSILON) * 100) / 100;
		console.log(Math.round((bank_balance + Number.EPSILON) * 100) / 100);
		console.log(Math.round((cleared_balance + Number.EPSILON) * 100) / 100);
		console.log(Math.round((variance + Number.EPSILON) * 100) / 100);
		
		if(variance){
			var msg = '<span style="color:red;font-size: 18px;">Variance Between received amount and debtor balance is ' + Math.abs(variance.toFixed(2)) + '</span>';
			$(".variance_amt").val(variance.toFixed(2));
		}else {
			var msg = '<span style="color:green;font-size: 18px;">Aging Successfully</span>';
			$(".variance_amt").val("0.00");
		}
		$('.variance_message').html(msg);
	}
	var rec_check = 0;
	$('#all').on('click', function(){
		$(".variance_amt").val("0.00");
		if($(this).prop('checked')) $('.rec_tick_cl').prop('checked', true);
		else $('.rec_tick_cl').prop('checked', false);
		calc_checked_total();
		rec_check++;
	});
	$('.rec_tick_cl').on('click', function(){
		$(".variance_amt").val("0.00");
		calc_checked_total();
	});
	$("#bank_balance").on("keyup change", function() {
		$(".variance_amt").val("0.00");
		calc_checked_total();
	});
});
/*function onFormSubmit() {
    location.refresh(true);
}*/
</script>