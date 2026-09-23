<?php global $lang; ?>
<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
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
if (!empty($from_year_month))
	$min_date = ' min="' . $from_year_month . '"';
if (!empty($to_year_month))
	$max_date = ' max="' . $to_year_month . '"';
?>
<section class="content">
	<div class="container-fluid">
		<!-- Basic Examples -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="body">
						<form action="<?php echo base_url(); ?>/reconciliation/" method="get">
							<div class="container-fluid">
								<div class="row clearfix">
									<div class="col-sm-6">
										<div class="form-group form-float">
											<div class="form-line">
												<select class="form-control" data-live-search="true" name="ledger"
													id="ledger">
													<option value=""><?php echo $lang->select; ?>
														<?php echo $lang->option; ?></option>
													<?php foreach ($ledger as $row) {
														print_r($row);
													} ?>
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
												<label class="form-label"
													style="display: contents;"><?php echo $lang->month; ?></label>
												<input type="month" name="recon_month" id="recon_month"
													value="<?php echo $recon_month; ?>" class="form-control" >
											</div>
										</div>
									</div>
									<div class="col-sm-2" align="right">
										<button type="submit"
											class="btn btn-success btn-lg waves-effect"><?php echo $lang->submit; ?></button>
									</div>
								</div>
							</div>
						</form>
						<?php
						if (!empty($_REQUEST['ledger'])) {
							?>
							<form action="<?php echo base_url(); ?>/reconciliation/save_bank_balance" class="bank_form">
								<input type="hidden" name="ledger_id"
									value="<?php echo !empty($_REQUEST['ledger']) ? $_REQUEST['ledger'] : $_REQUEST['ledger']; ?>"
									class="form-control hidden">
								<input type="hidden" name="fund_id" value="<?php echo $fund_id; ?>"
									class="form-control hidden">
								<input type="hidden" name="recon_month" value="<?php echo $recon_month; ?>"
									class="form-control hidden">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="number" name="bank_balance" id="bank_balance"
													value="<?php echo $reconcil_bank_balance; ?>" class="form-control"
													step="0.01">
												<label class="form-label">Enter The Bank Statement Balance <span
														style="color: red;"> *</span></label>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<button type="submit"
											class="btn btn-success btn-lg waves-effect"><?php echo $lang->save; ?></button>
									</div>
								</div>
							</form>
							<?php
						}
						?>
						<form
							action="<?php echo base_url(); ?>/reconciliation/save?ledger=<?php echo !empty($_REQUEST['ledger']) ? $_REQUEST['ledger'] : $_REQUEST['ledger']; ?>"
							method="post" target="frame" onsubmit="onFormSubmit();">
							<?php /* <input type="date"  name="fdate" value="<?php echo $fdate; ?>" class="form-control hidden" >
											<input type="date" name="tdate" value="<?php echo $tdate; ?>" class="form-control hidden"> */ ?>
							<input type="hidden" name="recon_month" value="<?php echo $recon_month; ?>"
								class="form-control hidden">
							<input type="hidden" name="fund_id" value="<?php echo $fund_id; ?>"
								class="form-control hidden">
							<?php if (!empty($_REQUEST['ledger'])) { ?>

								<table border="1" style="margin-bottom:15px; width:45% !important;">
									<?php /* <tr><td style="width:85%;"><?php echo $lang->book; ?> <?php echo $lang->opening; ?> <?php echo $lang->balance; ?> <?php echo $lang->as; ?> <?php echo $lang->on; ?> <?php echo date('d-M-Y', strtotime($fdate)); ?></td><td style="width:15%;"><?php echo (!empty($opening_balance) ? number_format($opening_balance, "2",".",",") : 0.00) ?></td></tr>
													   <tr><td><?php echo $lang->book; ?> <?php echo $lang->closing; ?> <?php echo $lang->balance; ?> <?php echo $lang->as; ?> <?php echo $lang->on; ?><?php echo date('d-M-Y', strtotime($tdate)); ?></td><td><?php echo (!empty($closing_balance) ? number_format($closing_balance, "2",".",",") : 0.00) ?></td></tr> */ ?>
									<tr>
										<td><?php echo $lang->bank_statement_balance; ?> -
											<?php echo date('M, Y', strtotime($recon_month . '-01')); ?></td>
										<td>
											<input type="hidden" name="bank_balance" id="bank_balance_new"
												value="<?php echo (!empty($reconcil_bank_balance) ? $reconcil_bank_balance : 0.00) ?>">
											<?php echo (!empty($reconcil_bank_balance) ? number_format($reconcil_bank_balance, "2", ".", ",") : 0.00) ?>
										</td>
									</tr>
									<tr>
										<td><?php echo $lang->outstanding_charges; ?> -
											<?php echo date('M, Y', strtotime($recon_month . '-01')); ?></td>
										<td><?php echo (!empty($debit_balance) ? number_format($debit_balance, "2", ".", ",") : 0.00) ?>
										</td>
									</tr>
									<tr>
										<td><?php echo $lang->outstanding_payments; ?> -
											<?php echo date('M, Y', strtotime($recon_month . '-01')); ?></td>
										<td><?php echo (!empty($credit_balance) ? number_format($credit_balance, "2", ".", ",") : 0.00) ?>
										</td>
									</tr>
									<tr>
										<td><?php echo $lang->current; ?> 	<?php echo $lang->book; ?>
											<?php echo $lang->balance; ?> -
											<?php echo date('M, Y', strtotime($recon_month . '-01')); ?></td>
										<td><?php echo (!empty($closing_balance) ? number_format($closing_balance, "2", ".", ",") : 0.00) ?>
										</td>
									</tr>
									<tr>
										<td><?php echo $lang->reconciled_book_balance; ?> -
											<?php echo date('M, Y', strtotime($recon_month . '-01')); ?></td>
										<td>
											<input type="hidden" name="cleared_balance" id="cleared_balance"
												value="<?php echo (!empty($cleared_balance) ? $cleared_balance : 0.00) ?>">
											<?php echo (!empty($cleared_balance) ? number_format($cleared_balance, "2", ".", ",") : 0.00) ?>
										</td>
									</tr>
								</table>
							<?php } ?>

							<div class="table-responsive">
								<table class="table stripped">
									<thead>
										<tr>
											<th><input style="opacity:1;position:inherit;" type="checkbox" id="all">
											</th>
											<th><?php echo $lang->date; ?></th>
											<th><?php echo $lang->number; ?></th>
											<th><?php echo $lang->ledger; ?></th>
											<th><?php echo $lang->details; ?></th>
											<th align="right"><?php echo $lang->debit; ?> <?php echo $lang->amount; ?>
											</th>
											<th align="right"><?php echo $lang->credit; ?> <?php echo $lang->amount; ?>
											</th>
											<?php /* <th><?php echo $lang->clearance; ?> <?php echo $lang->mode; ?></th>
																<th><?php echo $lang->reconciliation; ?> <?php echo $lang->date; ?></th> */ ?>
										</tr>
									</thead>
									<?php
									if (count($res) > 0) {
										$i = 0;
										?>
										<tbody>
											<?php foreach ($res as $rs) {
												$ledgername = get_ledger_name($rs['ledger_id']);
												?>
												<tr>
													<td><input style="opacity:1;position:inherit;" type="checkbox"
															class="rec_tick_cl" name="rec_tick[<?php echo $i; ?>]"
															value="<?php echo $rs['entryitem_id']; ?>"
															id="rec_<?php echo $rs['entryitem_id']; ?>"></td>
													<td><?php echo date('d-M-Y', strtotime($rs['date'])); ?></td>
													<td><?php echo $rs['number']; ?></td>
													<td><?php echo $ledgername; ?></td>
													<td><?php echo $rs['details']; ?></td>
													<td align="right">
														<?php echo ($rs['dc'] == 'D' ? number_format($rs['amount'], "2", ".", ",") : 0.00); ?><input
															type="hidden" class="ei_debit" id="ei_debit_amount"
															value="<?php echo ($rs['dc'] == 'D' ? $rs['amount'] : 0.00); ?>" />
													</td>
													<td align="right">
														<?php echo ($rs['dc'] == 'C' ? number_format($rs['amount'], "2", ".", ",") : 0.00); ?><input
															type="hidden" class="ei_credit" id="ei_credit_amount"
															value="<?php echo ($rs['dc'] == 'C' ? $rs['amount'] : 0.00); ?>" />
													</td>
													<?php /* <td>
																			<select class="form-control" name="clearance[<?php echo $i; ?>]" id="clearance_<?php echo $rs['entryitem_id']; ?>">
																					<option value="FLOAT"<?php echo ($rs['clearancemode'] == 'FLOAT' ? ' slected="selected"' : ''); ?>><?php echo $lang->float; ?></option>
																					<option value="CLEARED"<?php echo ($rs['clearancemode'] == 'CLEARED' ? ' slected="selected"' : ''); ?>><?php echo $lang->cleared; ?></option>
																				</select>
																			</td>
																			<td><input type="date"  id="reconcil_date_<?php echo $rs['entryitem_id']; ?>" name="reconcil_date[<?php echo $i; ?>]" class="form-control" value="<?php echo $rs['reconciliation_date']; ?>"></td> */ ?>
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
								<div class="col-sm-12 variance_message" align="center">

								</div>
								<div class="col-sm-3" align="right">
									<input type="submit" class="btn btn-success btn-lg waves-effect" value="SAVE">
									<?php
									if (!empty($ledger_id) && !empty($recon_month)) {
										echo '<a href="' . base_url() . '/reconciliation/print/' . $ledger_id . '?fund_id=' . $fund_id . '&recon_month=' . $recon_month . '" target="_blank" id="print" class="btn btn-primary">Print</a>';
									}
									if (!empty($ledger_id) && !empty($recon_month)) {
										echo '<a href="' . base_url() . '/reconciliation/pdf/' . $ledger_id . '?fund_id=' . $fund_id . '&recon_month=' . $recon_month . '" target="_blank" id="pdf" class="btn btn-danger bg-danger" style="margin-left: 5px; background-colour:red">Pdf</a>';
									}
									if (!empty($ledger_id) && !empty($recon_month)) {
										echo '<a href="' . base_url() . '/reconciliation/excel/' . $ledger_id . '?fund_id=' . $fund_id . '&recon_month=' . $recon_month . '" target="_blank" id="excel" class="btn btn-success bg-success" style="margin-left: 5px; background-colour:red">Excel</a>';
									}
									if ($undo_reconcil == $recon_month) {
										echo '<a href="' . base_url() . '/reconciliation/undo_reconcil/' . $ledger_id . '?fund_id=' . $fund_id . '&recon_month=' . $recon_month . '" id="undo" style="margin-left:5px;" class="btn btn-warning">Undo</a>';
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
	$(document).ready(function () {
		function calc_checked_total() {
			var cleared_balance = parseFloat($('#cleared_balance').val());
			var bank_balance = parseFloat($('#bank_balance_new').val());
			var debit_balance = credit_balance = 0;
			$('.rec_tick_cl:checked').each(function () {
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
			if (variance) {
				var msg = '<span style="color:red;font-size: 18px;">Variance Between bank Statement and Book is ' + variance.toFixed(2) + '</span>';
			} else var msg = '<span style="color:green;font-size: 18px;">Reconciled Successfully</span>';
			$('.variance_message').html(msg);
		}
		var rec_check = 0;
		$('#all').on('click', function () {
			if ($(this).prop('checked')) $('.rec_tick_cl').prop('checked', true);
			else $('.rec_tick_cl').prop('checked', false);
			calc_checked_total();
			rec_check++;
		});
		$('.rec_tick_cl').on('click', function () {
			calc_checked_total();
		});
		$(document).on('click', '#bank_balance', function () {
			if ($(this).val() == '0.00') {
				$(this).val('');
			}
		});
	});
	/*function onFormSubmit() {
		location.refresh(true);
	}*/
</script>