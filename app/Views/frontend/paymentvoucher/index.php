<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year_frend']); ?>
<?php
if ($view == true) {
	$readonly = 'readonly';
	$disabled = 'disabled';
}
?>
<?php $db = db_connect(); ?>
<!-- REPRINT SECTION END -->
<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.min.js"></script>
<!-- base:js -->
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="<?php echo base_url(); ?>/assets/archanai/vendors/chart.js/Chart.min.js"></script>
 <!-- inject:js -->
<script src="<?php echo base_url(); ?>/assets/archanai/js/off-canvas.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/hoverable-collapse.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/template.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/settings.js"></script>
<script src="<?php echo base_url(); ?>/assets/archanai/js/todolist.js"></script>
<!-- endinject -->
<script src="<?php echo base_url(); ?>/assets/archanai/js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/frontend/js/bootstrap.min.js"></script>

<!--<link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select-v4@1.12.4/dist/js/bootstrap-select.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-select-v4@1.12.4/dist/css/bootstrap-select.min.css" rel="stylesheet">
<style>
	.form-group {
		margin-bottom: 0px;
	}

	.form-group .form-control {
		border: 1px solid #CCC;
		padding-left: 5px;
	}

	.btn {
		padding: 6px 12px !important;
	}

	.dropdown-toggle {
		border-bottom: 0px solid #ddd !important;
	}

	.panel-primary {
		border-color: #d4aa00;
	}

	.bootstrap-select.btn-group .dropdown-menu.inner {
		padding-bottom: 50px;
	}

	label {
		display: inline-block;
		max-width: 100%;
		margin-bottom: 5px;
		font-weight: bold;

	}

	div {
		display: block;
	}

	.panel-heading {
		margin-top: 5px;
	}
	.dropdown-menu.show {
		display: block !important;
	}
.bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:active {
    color: #807b7b;
    background: transparent;
    width: 97%;
    font-weight: 600;
}
.btn-light:not([disabled]):not(.disabled).active, .btn-light:not([disabled]):not(.disabled):active, .show>.btn-light.dropdown-toggle {
    color: #807b7b;
    background-color: transparent;
    border-color: transparent;
    box-shadow: 0 0 0 0.2rem rgba(248,249,250,.5);
}
.btn-light:hover {
    color: #807b7b;
    background-color: #e2e6ea;
     border-color: transparent; 
}
.bootstrap-select .dropdown-toggle:focus {
    outline: 0 !important;
    outline: 0px auto -webkit-focus-ring-color !important;
    outline-offset: 0px;
}
.red {color:#FF0000; }
.btn-light {
    background-color: transparent;
    border-color: transparent;
    color: #807b7b !important;
}
</style>
<section class="content mt-3">
	<div class="container-fluid ">
		<!--<div class="block-header">
			<h2> ENTRIES <small style="font-size: 14px;">Account / <?php echo $sub_title; ?></small></h2>
		</div>-->
		<!-- Basic Examples -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<div class="row">
							<div class="col-md-8"><!--<h2>Ubayam</h2>--></div>
						</div>
					</div>
					<div class="body">
						<?php if ($_SESSION['succ'] != '') { ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="suc-alert">
									<span class="suc-closebtn"
										onclick="this.parentElement.style.display='none';">&times;</span>
									<p>
										<?php echo $_SESSION['succ']; ?>
									</p>
								</div>
							</div>
						<?php } ?>
						<?php if ($_SESSION['fail'] != '') { ?>
							<div class="row" style="padding: 0 30%;" id="content_alert">
								<div class="alert">
									<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
									<p>
										<?php echo $_SESSION['fail']; ?>
									</p>
								</div>
							</div>
						<?php } ?>
						<form id="payment_store_validation">
							<input type="hidden" id="entry_type_id" name="entry_type_id" value="<?= $en_id; ?>">
							<input type="hidden" id="entry_id" name="entry_id" value="<?php if (!empty ($entries['id'])) {
								echo $entries['id'];
							} ?>">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="floating-label" for="Text">Date <span class="red">*</span> </label>
												<input type="date" class="form-control" name="payment_date" required
													id="payment_date" value="<?php if (!empty ($entries['date']))
														echo date("Y-m-d", strtotime($entries['date']));
													else
														echo date("Y-m-d"); ?>" autocomplete="off" <?php echo $disabled; ?> max="<?php echo $booking_calendar_range_year; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="floating-label" for="Text">Payment Mode <span class="red">*</span></label>
												<select class="form-control" name="payment_paymode" id="payment_paymode" required
													<?php echo $disabled; ?>>
													<option value="">Select payment mode</option>
													<option value="cash" <?php if (!empty ($entries['payment'])) {
														if ($entries['payment'] == "cash") {
															echo "selected";
														}
													} ?>>Cash
													</option>
													<option value="qr" <?php if (!empty ($entries['payment'])) {
														if ($entries['payment'] == "qr") {
															echo "selected";
														}
													} ?>>QR</option>
													<option value="card" <?php if (!empty ($entries['payment'])) {
														if ($entries['payment'] == "card") {
															echo "selected";
														}
													} ?>>Card</option>
													<option value="online" <?php if (!empty ($entries['payment'])) {
														if ($entries['payment'] == "online") {
															echo "selected";
														}
													} ?>>Online</option>

												</select>
											</div>
										</div>

									</div>
									<div class="row mt-3">
										<div class="col-md-6">
											<div class="form-group">
												<label class="floating-label" for="Text">Entry Code <span class="red">*</span></label>
												<input type="text" class="form-control" name="payment_entrycode" required
													id="payment_entrycode" value="<?php echo $entry_code; ?>" readonly
													autocomplete="off">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="floating-label" for="Text">Paid To <span class="red">*</span></label>
												<input type="text" class="form-control" name="payment_receivedfrom" required
													id="payment_receivedfrom" autocomplete="off" <?php echo $readonly; ?>>
											</div>
										</div>
									</div>

									<div id="row_cheque" style="display:<?php if (!empty ($entries['payment'])) {
										if ($entries['payment'] == "cheque") {
											echo "block!important";
										} else {
											echo "none!important";
										}
									} else {
										echo "none!important";
									} ?>">
										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-primary">
													<div class="panel-heading"
														style="color: #fff;background-color: #d4aa00;border-color: #d4aa00;padding: 5px 15px;">
														Cheque Detail</div>
													<div class="panel-body"
														style="border: 1px solid #d4aa00;padding: 10px;">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="floating-label" for="Text">Cheque
																		No <span class="red">*</span></label>
																	<input type="text" class="form-control" required
																		name="payment_chequeno" id="payment_chequeno"
																		autocomplete="off" value="<?php if (!empty ($entries['cheque_no'])) {
																			echo $entries['cheque_no'];
																		} ?>" <?php echo $readonly; ?>>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="floating-label" for="Text">Cheque
																		Date <span class="red">*</span></label>
																	<input type="date" class="form-control" required
																		name="payment_chequedate"
																		id="payment_chequedate" autocomplete="off"
																		value="<?php if (!empty ($entries['cheque_date'])) {
																			echo $entries['cheque_date'];
																		} ?>" <?php echo $readonly; ?> max="<?php echo $booking_calendar_range_year; ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">&nbsp;</div>
									</div>
									<div id="row_transaction_online" style="display:<?php if (!empty ($entries['payment'])) {
										if ($entries['payment'] == "online") {
											echo "block!important";
										} else {
											echo "none!important";
										}
									} else {
										echo "none!important";
									} ?>">
										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-primary">
													<div class="panel-heading"
														style="color: #fff;background-color: #d4aa00;border-color: #d4aa00;padding: 5px 15px;"
														id="transaction_online_title"></div>
													<div class="panel-body"
														style="border: 1px solid #d4aa00;padding: 10px;">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="floating-label" for="Text">Ref.
																		No <span class="red">*</span></label>
																	<input type="text" class="form-control" required
																		name="payment_refno" id="payment_refno"
																		autocomplete="off" value="<?php if (!empty ($entries['cheque_no'])) {
																			echo $entries['cheque_no'];
																		} ?>" <?php echo $readonly; ?>>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="floating-label" for="Text">Transaction
																		Date <span class="red">*</span></label>
																	<input type="date" class="form-control" required
																		name="payment_transactiondate"
																		id="payment_transactiondate" autocomplete="off"
																		value="<?php if (!empty ($entries['cheque_date'])) {
																			echo $entries['cheque_date'];
																		} ?>" <?php echo $readonly; ?> max="<?php echo $booking_calendar_range_year; ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">&nbsp;</div>
									</div>

									<!-- <div class="row mt-2">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading"
													style="color: #fff;background-color: #d4aa00;border-color: #d4aa00;padding: 5px 15px;">
													Payment Particulars</div>
												<div class="panel-body"
													style="border: 1px solid #d4aa00;padding: 10px;">
													<textarea class="form-control" name="payment_particulars"
														id="payment_particulars" <?php echo $readonly; ?>><?php if (!empty ($credit_ledger['details'])) {
															   echo $credit_ledger['details'];
														   } ?></textarea>
												</div>
											</div>
										</div>
									</div> -->
									<div class="row">&nbsp;</div>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading"
													style="color: #fff;background-color: #d4aa00;border-color: #d4aa00;padding: 5px 15px;">
													Amount in Words</div>
												<div class="panel-body"
													style="border: 1px solid #d4aa00;padding: 10px;">
													<p style="margin: 0px;font-size: 20px;font-weight: bold;"><span> RM
														</span> <span id="tot_amt_parag">
															<?php if (!empty ($entries['dr_total'])) {
																echo $entries['dr_total'];
															} else {
																echo "0.00";
															} ?>
														</span>
														<input type="hidden" name="tot_amt_input" id="tot_amt_input"
															value="<?php if (!empty ($entries['dr_total'])) {
																echo $entries['dr_total'];
															} else {
																echo "0.00";
															} ?>">
													</p>
													<p style="margin: 0px;font-size: 20px;font-weight: bold;text-transform: uppercase;"
														id="tot_amt_txt"></p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<?php
									if ($view != true) {
										?>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="floating-label" for="Text">Debit A/C <span class="red">*</span></label>
													<select class="form-control selectpicker" data-live-search="true" required 
														name="payment_credit_ac" id="payment_credit_ac" <?php echo $disabled; ?>>
														<option value="">Select debit a/c</option>
														<?php
														if (!empty ($ledgers)) {
															foreach ($ledgers as $ledger) {
																?>
																<option value="<?php echo $ledger["id"]; ?>">
																	<?php echo '(' . $ledger['left_code'] . '/' . $ledger['right_code'] . ") - " . $ledger["name"]; ?>
																</option>
																<?php
															}
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label class="floating-label" for="Text">Amount <span class="red">*</span></label>
													<input type="number" min="0" step="any" value="0.00" required
														class="form-control" name="payment_amount" id="payment_amount"
														autocomplete="off" <?php echo $readonly; ?>>
												</div>
											</div>
											<div class="col-md-5" style="margin-top:34px;">
												<a class="btn btn-primary" id="addcreditdetail"
													style="padding: 5px 15px;color:#fff;cursor: pointer;">Add</a>
												<a class="btn btn-secondary" id="clear_credit_ac"
													style="padding: 5px 15px;cursor: pointer;"> Clear</a>
												<button type="button" class="btn btn-danger btn-lg ar_btn"
													onClick="rePrint();"
													style="background: #f44336;border: 1px solid #f44336;color: #fff;">Reprint</button>
											</div>
										</div>
										<div class="row">&nbsp;</div>
										<div class="row">
											<div class="col-md-12">
												<div class="panel panel-primary">
													<div class="panel-heading"
														style="color: #fff;background-color: #d4aa00;border-color: #d4aa00;padding: 5px 15px;">
														Detail Particulars</div>
													<div class="panel-body"
														style="border: 1px solid #d4aa00;padding: 10px;">
														<textarea class="form-control" name="payment_detail_particulars"
															id="payment_detail_particulars" <?php echo $readonly; ?>></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="row">&nbsp;</div>
										<?php
									}
									?>
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-heading"
													style="color: #fff;background-color: #d4aa00;border-color: #d4aa00;padding: 5px 15px;">
													Payment Details</div>
												<div class="panel-body scroll"
													style="border: 1px solid #d4aa00;padding: 10px;overflow-y: auto;height:250px;">
													<!--<div class="tableFixHead">-->
													<input type="hidden" class="tot" id="tot_amt" name="tot_amt"
														value="0.00">
													<table class="table table-bordered cart-table"
														style="overflow-y: scroll;height:150px;">
														<thead class="thead-light">
															<tr>
																<?php
																if ($view != true) {
																	?>
																	<th style="width: 10%;">#</th>
																	<?php
																}
																?>
																<th style="width: 50%;">Account</th>
																<th style="width: 10%;">Amount</th>
																<th style="width: 30%;">Details</th>
															</tr>
														</thead>
														<tbody>
															<?php
															if (!empty ($entrie_items)) {
																$j = 1;
																foreach ($entrie_items as $entrie_item) {
																	$ledger_name = $db->table('ledgers')->select('name')->where('id', $entrie_item['ledger_id'])->get()->getRowArray();
																	?>
																	<tr class="all_close"
																		data-id="<?php echo $entrie_item['ledger_id']; ?>">
																		<?php
																		if ($view != true) {
																			?>
																			<td><input type="hidden"
																					name="entries[<?php echo $j; ?>][entryitemid]"
																					value="<?php echo $entrie_item['id']; ?>"></td>
																			<?php
																		}
																		?>
																		<td><input type="hidden" style="text-align: center;"
																				class="row_amt"
																				name="entries[<?php echo $j; ?>][ledgerid]"
																				value="<?php echo $entrie_item['ledger_id']; ?>"><span
																				id="ledgername_<?php echo $j; ?>">
																				<?php echo $ledger_name['name']; ?>
																			</span></td>
																		<td><input type="hidden" style="text-align: center;"
																				class="row_tot" id="tot_<?php echo $j; ?>"
																				value="<?php echo $entrie_item['amount']; ?>"><input
																				type="hidden" style="text-align: center;"
																				class="row_qty"
																				name="entries[<?php echo $j; ?>][amount]"
																				id="qty_<?php echo $j; ?>"
																				value="<?php echo $entrie_item['amount']; ?>">
																			<?php echo $entrie_item['amount']; ?>
																		</td>
																		<td><input type="hidden" style="text-align: center;"
																				class=""
																				name="entries[<?php echo $j; ?>][particulars]"
																				id="particulars_<?php echo $j; ?>"
																				value="<?php echo $entrie_item['details']; ?>">
																			<?php echo $entrie_item['details']; ?>
																		</td>
																	</tr>
																	<?php
																	$j++;
																}
															}
															?>
														</tbody>
													</table>
													<!--</div>-->
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</form>
						<?php
						if ($view != true) {
							?>
							<div class="row mt-3">
								<div class="col-sm-12" align="center">
									<div class="form-group">
										<!--input  type="checkbox" checked="checked" id="print" name="print" value="Print">
										<label for ='print'> Print &nbsp;&nbsp; </label-->
										<label id="submit" class="btn btn-success btn-lg waves-effect">Save</label>

										<!--<button id="submit" class="btn btn-success">Save</button>-->
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="alertModal" class="modal fade" tabindex="-1" rele="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<!--div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div-->
				<div class="modal-body">
					<p style="text-align:center;"><br><i class="mdi mdi-alert-circle-outline"
							style="font-size:42px; color:red;"></i></p>
					<h5 style="text-align:center;" id="modalMsg"></h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
	<!--REPRINT SECTION START-->
	<div id="myModal_reprint" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body p-4" style="padding-bottom:10px;">
					<div class="text-center">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered" style="width:100%">
									<thead>
										<tr style="font-size: 13px;text-align: left;background: #3F51B5;color: #fff;">
											<th style="width: 10%;padding: 5px 10px;text-align:center;">S.No</th>
											<th style="width: 20%;padding: 5px 10px;text-align:center;">Invoice No</th>
											<th style="width: 40%;padding: 5px 10px;text-align:center;">Narration</th>
											<th style="width: 20%;padding: 5px 10px;text-align:center;">Amount</th>
											<th style="width: 10%;padding: 5px 10px;text-align:center;">Action</th>
										</tr>
									</thead>
									<tbody style="height:auto; margin-bottom:30px;">
										<?php
										if (count($reprintlists) > 0) {
											$ire = 1;
											foreach ($reprintlists as $reprintlist) {
												?>
												<tr>
													<td style="width: 10%;padding: 5px 0px!important;text-align:center;">
														<?php echo $ire; ?>
													</td>
													<td style="width: 20%;padding: 5px 0px!important;text-align:center;">
														<?php echo $reprintlist['entry_code']; ?>
													</td>
													<td style="width: 40%;padding: 5px 0px!important;text-align:center;">
														<?php echo $reprintlist['narration']; ?>
													</td>
													<td style="width: 20%;padding: 5px 0px!important;text-align:center;">
														<?php echo $reprintlist['amount']; ?>
													</td>
													<td style="width: 10%;padding: 5px 0px!important;text-align:center;">
														<a class='btn btn-primary'
															style='font-size: 13px;font-weight: bold;padding: 6px 10px;background: #2196F3;border: 1px solid #2196F3;'
															title='Print'
															href='<?php echo base_url(); ?>/payment_voucher/print_page/<?php echo $reprintlist['id']; ?>'
															target='_blank'>Print</a>
													</td>
												</tr>
												<?php
												$ire++;
											}
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<script>
$('#payment_amount').click(function() {
	if($(this).val()=='0.00') {
		$(this).val('');
	}
});

	function rePrint() {
		$("#myModal_reprint").modal("show");
	}
	$("#submit").click(function (e) {
		e.preventDefault();
		$.ajax
			({
				type: "POST",
				url: "<?php echo base_url(); ?>/payment_voucher/save_payment_entries",
				data: $("form").serialize(),
				success: function (data) {
					obj = jQuery.parseJSON(data);
					if (obj.err != '') {
						//$("#modalMsg").text(obj.err);
						alert(obj.err);
						//$('#alertModal').modal();
					} else {
					/*if($("#print").prop('checked'))	
					{
						printData(obj.id);
					}
					else 
					{
						window.location.replace("<?php echo base_url(); ?>/payment_voucher");
					}*/
					alert(obj.succ);
					//window.location.replace("<?php echo base_url(); ?>/payment_voucher");
					window.open("<?php echo base_url(); ?>/payment_voucher/print_page/" + obj.id);
					window.location.reload(true);
				}
			}
		});
	});

	function printData(id) {
		$.ajax({
			url: "<?php echo base_url(); ?>/payment_voucher/print_page/" + id,
			type: 'POST',
			success: function (result) {
				//console.log(result)	
				popup(result);
			}
		});
	}

	function popup(data) {
		var frame1 = $('<iframe />');
		frame1[0].name = "frame1";
		frame1.css({ "position": "absolute", "top": "-1000000px" });
		$("body").append(frame1);
		var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
		frameDoc.document.open();
		//Create a new HTML document.
		frameDoc.document.write('<html>');
		frameDoc.document.write('<head>');
		frameDoc.document.write('<title></title>');
		frameDoc.document.write('</head>');
		frameDoc.document.write('<body >');
		frameDoc.document.write(data);
		frameDoc.document.write('</body>');
		frameDoc.document.write('</html>');
		frameDoc.document.close();
		setTimeout(function () {
			window.frames["frame1"].focus();
			window.frames["frame1"].print();
			frame1.remove();
			window.location.reload(true);
		}, 500);

		frame1.remove();
		window.location.replace("<?php echo base_url(); ?>/payment_voucher");
		//return true;
	}

	$(document).ready(function () {
		$('#payment_debit_ac').change(function () {
			var payment_debit_ac = $("#payment_debit_ac").val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>/payment_voucher/payment_debit_ac",
				data: { rtdebit_ac: payment_debit_ac },
				success: function (data) {
					$("#payment_credit_ac").empty();
					$('#payment_credit_ac').html(data);
					//$('#payment_credit_ac').prop('selectedIndex',0);
					//$("#payment_credit_ac").selectpicker("refresh");
				}
			});
		});
	});


	$(function () {
		$('#row_cheque').hide();
		$('#row_transaction_online').hide();
		$('#transaction_online_title').html("");
		$("#payment_refno").val("");
		$("#payment_transactiondate").val("");
		$("#payment_transactionstatus").val("");
		$("#payment_chequeno").val("");
		$("#payment_chequedate").val("");
		$("#payment_chequestatus").val("");
		$('#payment_paymode').change(function () {

			var payment_paymode = $("#payment_paymode").val();
			if ($('#payment_paymode').val() == 'cheque') {
				$('#row_cheque').show();
				$("#payment_chequeno").val("");
				$("#payment_chequedate").val("");
				$("#payment_chequestatus").val("");

			} else {
				$('#row_cheque').hide();
				$("#payment_chequeno").val("");
				$("#payment_chequedate").val("");
				$("#payment_chequestatus").val("");
			}

			if ($('#payment_paymode').val() == 'online') {
				$('#row_transaction_online').show();
				if (payment_paymode == 'online') {
					$("#transaction_online_title").html("Online");
					$("#payment_refno").val("");
					$("#payment_transactiondate").val("");
					$("#payment_transactionstatus").val("");
				}
			} else {
				$('#row_transaction_online').hide();
				$('#transaction_online_title').html("");
				$("#payment_refno").val("");
				$("#payment_transactiondate").val("");
				$("#payment_transactionstatus").val("");
			}

		});

		$('#row_cheque_returned_status').hide();
		$('#row_cheque_completed_status').hide();
		$("#payment_returndate").val("");
		$("#payment_extracharge").val("");
		$("#payment_collectiondate").val("");
		$('#payment_chequestatus').change(function () {
			var payment_chequestatus = $("#payment_chequestatus").val();
			if (payment_chequestatus == "Returned") {
				$('#row_cheque_returned_status').show();
				$('#row_cheque_completed_status').hide();
				$("#payment_collectiondate").val("");
			}
			else if (payment_chequestatus == "Completed") {
				$('#row_cheque_completed_status').show();
				$('#row_cheque_returned_status').hide();
				$("#payment_returndate").val("");
				$("#payment_extracharge").val("");
			}
			else {
				$('#row_cheque_returned_status').hide();
				$('#row_cheque_completed_status').hide();
				$("#payment_returndate").val("");
				$("#payment_extracharge").val("");
				$("#payment_collectiondate").val("");
			}
		});
	});

	$(document).ready(function () {
		var i = 1;
		$('#addcreditdetail').click(function () {
			var payment_credit_ac = $("#payment_credit_ac").val();
			var payment_amount = $("#payment_amount").val();
			//  var cnt = parseInt($("#pay_row_count").val());
			if (payment_credit_ac != '' && payment_amount != "0.00" && payment_amount != "0" && payment_amount != 0 && payment_amount != 0.00 && payment_amount != '') {
				i++;
				var credit_ac = $("#payment_credit_ac").val();
				var ledgername = getladgerName(credit_ac, i);
				var payment_detail_particulars = $("#payment_detail_particulars").val();
				var amt = Number($("#payment_amount").val()).toFixed(2);

				var text1 = '<tr class="all_close" data-id="' + credit_ac + '" id="remov' + i + '"><td><input type="hidden" name="entries[' + i + '][entryitemid]"><a class="btn btn-info" style="font-size: 15px;cursor: pointer;color: #fff;font-weight: bold;padding: 0px 5px;" onclick="remove(' + i + ')" id="remove">X</a></td>';
				text1 += '<td><input type="hidden" style="text-align: center;" class="row_amt" name="entries[' + i + '][ledgerid]" value="' + credit_ac + '"><span id="ledgername_' + i + '"></span></td>';
				text1 += '<td><input type="hidden" style="text-align: center;" class="row_tot" id="tot_' + i + '" value="' + amt + '"><input type="hidden" style="text-align: center;" class="row_qty" name="entries[' + i + '][amount]" id="qty_' + i + '" value="' + amt + '">' + amt + '</td>';
				text1 += '<td><input type="hidden" style="text-align: center;" class="" name="entries[' + i + '][particulars]" id="particulars_' + i + '" value="' + payment_detail_particulars + '">' + payment_detail_particulars + '</td>';
				text1 += '</tr>';
				$(".cart-table").append(text1);
				sum_total();
				//$('#payment_credit_ac').prop('selectedIndex',0);
				//$("#payment_credit_ac").selectpicker("refresh");
				$("#payment_credit_ac").val("");
				$("#payment_detail_particulars").val("");
				$("#payment_amount").val("0.00");
			}
		});
	});

	function getladgerName(ledgerid, incid) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>/payment_voucher/getladgerName",
			data: { ledger_id: ledgerid },
			success: function (data) {
				$('#ledgername_' + incid).text(data);
			}
		});
	}

	function remove(id) {
		$(".cart-table #remov" + id).remove();
		sum_total();
	}
	$("#clear_credit_ac").click(function () {
		//$('#payment_credit_ac').prop('selectedIndex',0);
		//$("#payment_credit_ac").selectpicker("refresh");
		$("#payment_paymode").val("");
		$("#payment_receivedfrom").val("");
		$("#payment_particulars").val("");
		$("#payment_credit_ac").val("");
		$("#payment_detail_particulars").val("");
		$("#payment_amount").val("0.00");
		$(".cart-table .all_close").empty();
		sum_total();
	});

	function sum_total() {
		var total_qty = 0;
		$(".row_qty").each(function () {
			total_qty += parseFloat($(this).val());
		});
		/* $("#tot_qty").text(total_qty); */

		var total_amt = 0;
		$(".row_tot").each(function () {
			total_amt += parseFloat($(this).val());
		});
		$("#tot_amt").val(Number(total_amt).toFixed(2));
		$("#tot_amt_parag").text(Number(total_amt).toFixed(2));
		$("#tot_amt_input").val(Number(total_amt).toFixed(2));
		numberToWords(total_amt);
	}

	function numberToWords(number) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>/payment_voucher/AmountInWords",
			data: { number: number },
			success: function (data) {
				$('#tot_amt_txt').html(data);
				//console.log(data)
				//return str.trim() + "";  
			}
		});
	}

	$("#clear_all").click(function () {
		$(".cart-table .all_close").empty();
		$("#payment_paymode").val("");
		//$('#payment_debit_ac').prop('selectedIndex',0);
		//$("#payment_debit_ac").selectpicker("refresh");
		$("#payment_debit_ac").val("");
		$("#payment_receivedfrom").val("");
		$("#payment_chequeno").val("");
		$("#payment_chequedate").val("");
		$("#payment_chequestatus").val("");
		$("#payment_returndate").val("");
		$("#payment_extracharge").val("");
		$("#payment_collectiondate").val("");
		$("#payment_refno").val("");
		$("#payment_transactiondate").val("");
		$("#payment_transactionstatus").val("");
		$("#payment_particulars").val("");
		sum_total();
	});

</script>
</body>

</html>