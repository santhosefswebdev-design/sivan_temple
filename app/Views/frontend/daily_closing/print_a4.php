<style>
	body {
		height: 100vh;
		width: 100%;
		background: #fff;
	}

	.page-body-wrapper {
		background: #fff;
	}

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

	a {
		text-decoration: none !important;
	}

	.table tr th {
		font-size: 14px;
		background: #f7ebbb;
		color: #333232;
	}

	.pack,
	.pay {
		margin-bottom: 15px;
	}

	.form-label {
		text-transform: uppercase;
		font-size: 13px;
		letter-spacing: 1px;
		color: #333333;
		text-align: left;
		width: 100%;
	}

	table tr td,
	table tr th {
		border-collapse: collapse;
		border: 1px solid;
	}

	.body_head table tr td,
	.body_head table tr th {
		border: 0;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	.input {
		width: 100%;
		text-align: left;
	}

	select.input {
		color: #000;
	}

	.sidebar-icon-only .sidebar .nav .nav-item .nav-link .menu-title {
		display: block !important;
		font-size: 11px;
		color: #FFFFFF;
	}

	.sidebar .nav .nav-item.active>.nav-link i.menu-icon {
		background: #edc10f;
		padding: 1px;
		list-style: outside;
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
		min-height: 120px;
	}

	.back h5 {
		min-height: 80px;
		font-size: 15px;
		font-weight: bold;
		color: #FFFFFF;
	}

	.greensubmit {
		background: #ab8a04 !important;
		font-weight: bold !important;
		color: #ffffff !important;
		box-shadow: -1px 10px 20px #ab8a04;
		background: #ab8a04 !important;
		background: -moz-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
		background: -webkit-linear-gradient(left, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
		background: linear-gradient(to right, #ab8a04 0%, #ab8a04 80%, #ab8a04 100%) !important;
	}

	.ar_btn {
		background: linear-gradient(179deg, rgb(0 126 212) 0%, rgb(16 197 180) 35%, rgb(59 134 209) 100%);
		border-radius: 15px;
		font-weight: bold;
		height: 2.75em;
		margin: 10px;
	}
</style>

<?php
$summary_total = array();
$summary_total['sales'] = array();
$summary_total['expense'] = array();
?>

<body class="sidebar-icon-only">
	<div class="container-scroller" style="width: 100%;max-width: 710px; margin:0 auto;">
		<div class="container-fluid page-body-wrapper">
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="row clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<!-- <div class="card"> -->
							<div class="">
								<div class="body_head">
									<table border="0">
										<tbody>
											<tr>
												<td style="width: 20%;">
													<p style="text-align:center;"><img
															src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>"
															style="width:120px;" align="center"></p>
												</td>
												<td style="width: 80%;">
													<p style="font-size:16px;text-align:center;">
														<?php echo $temp_details['name']; ?>
													</p>
													<p style="text-align:center;">
														<?php echo $temp_details['address1']; ?></br>
														<?php echo $temp_details['address2']; ?></br>
														<?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
														<br>Tel:
														<?= $temp_details['telephone']; ?>
														<br>
														Counter Login:
														<?= isset($counter_user['username']) ? strtoupper($counter_user['username']) : 'UNKNOWN'; ?>

													</p>
												</td>
											</tr>
										</tbody>
									</table>
									<hr>
								</div>
								<div class="body">
									<div class="col-md-12">
										<h3 style="text-transform: uppercase;text-align:center;">
											<?php
											if ($dailyclosing_start_date == $dailyclosing_end_date) {
												echo "Date - [" . date('d-m-Y', strtotime($dailyclosing_start_date)) . "]";
											} else {
												echo "Date - [" . date('d-m-Y', strtotime($dailyclosing_start_date)) . " - " . date('d-m-Y', strtotime($dailyclosing_end_date)) . "]";
											}
											?>
										</h3>
									</div>
									<div class="col-md-12">
										<h3>Archanai Selling Details</h3>
									</div>
									<div class="table-responsive col-md-12 det"
										style="background:#FFF; float:none;margin-bottom:0px;">
										<table class="table table-bordered table-striped table-hover">
											<thead style="background: #3F51B5;color: #fff;">
												<tr>
													<th style="padding: 5px 10px!important;">#</th>
													<th style="padding: 5px 10px!important;">Archanai</th>
													<th style="padding: 5px 10px!important;">Payment Mode</th>
													<th style="padding: 5px 10px!important;">Quantity</th>
													<th style="padding: 5px 10px!important;text-align:right;">Amount
													</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$archanai_total = 0;
												$archanai_qty = 0;
												if (count($archanai_group_details) > 0) {
													foreach ($archanai_group_details as $archanai_detail_data) {
														if (count($archanai_detail_data['data']) > 0) {
															$ar_i = 1;
															$sannathi_total = 0;
															$sannathi_qty = 0;
															echo '<tr><td colspan="5" style="text-align: center;"><h4>' . strtoupper($archanai_detail_data['title']) . '</h4></td></tr>';
															foreach ($archanai_detail_data['data'] as $archanai_detail) {
																$archanai_total = $archanai_total + $archanai_detail['amount'];
																$sannathi_total = $sannathi_total + $archanai_detail['amount'];
																$sannathi_qty = $sannathi_qty + $archanai_detail['qty'];
																$archanai_qty = $archanai_qty + $archanai_detail['qty'];
																if (empty($summary_total['sales'][$archanai_detail['paymentmode']]))
																	$summary_total['sales'][$archanai_detail['paymentmode']] = 0;
																$summary_total['sales'][$archanai_detail['paymentmode']] += $archanai_detail['amount'];
																?>
																<tr>
																	<td style="padding: 5px 10px!important;">
																		<?php echo $ar_i; ?>
																	</td>
																	<td style="padding: 5px 10px!important;">
																		<?php
																		echo $archanai_detail['name_in_english'] . " / " . $archanai_detail['name_in_tamil'];
																		?>
																	</td>
																	<td style="padding: 5px 10px!important;text-transform: uppercase;">
																		<?php echo $archanai_detail['paymentmode']; ?>
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
															echo '<tr><td colspan="3" style="text-align: center;"><h6>' . strtoupper($archanai_detail_data['title']) . ' Total</h4></td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . $sannathi_qty . '</td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . number_format($sannathi_total, 2) . '</td></tr>';
														}
													}
												}
												?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="3" style="text-align: center;">
														<h6>Overall Total</h6>
													</td>
													<td
														style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
														<?php echo $archanai_qty; ?>
													</td>
													<td
														style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
														<?php echo number_format($archanai_total, 2); ?>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
									<?php
									$hallbooking_total = 0;
									$sale_summary['hallbooking'] = array();
									$sale_summary['hallbooking']['total_amount'] = 0;
									$sale_summary['hallbooking']['paid_amount'] = 0;

									if (count($hallbooking_details) > 0) {
										?>
										<div class="col-md-12">
											<h3>Hall Booking Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Event date</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;

													foreach ($hallbooking_details as $hallbooking_detail) {
														$hallbooking_total += $hallbooking_detail['paidamount'];

														foreach ($hallbooking_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['hallbooking'][$productName])) {
																$sale_summary['hallbooking'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
															$sale_summary['hallbooking'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['hallbooking'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['hallbooking']['total_amount'] += $hallbooking_detail['amount'];
														$sale_summary['hallbooking']['paid_amount'] += $hallbooking_detail['paidamount'];


														if (empty($summary_total['sales'][$hallbooking_detail['paymentmode']]))
															$summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
														$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $hallbooking_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $hallbooking_detail['date']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($hallbooking_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($hallbooking_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($hallbooking_detail['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} elseif ($hallbooking_detail['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $hallbooking_detail['paymentmode']));

																echo $paymentname;
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $hallbooking_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($hallbooking_detail['amount'], 2);
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($hallbooking_detail['paidamount'], 2);
																?>
															</td>
														</tr>
														<?php
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="6">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($hallbooking_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$ubayam_total = 0;
									$sale_summary['ubayam'] = array();
									$sale_summary['ubayam']['total_amount'] = 0;
									$sale_summary['ubayam']['paid_amount'] = 0;

									if (count($ubayam_details) > 0) {
										?>
										<div class="col-md-12">
											<h3>Ubayam Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Event date</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount </th>
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;

													foreach ($ubayam_details as $ubayam_detail) {
														$ubayam_total += $ubayam_detail['paidamount'];

														foreach ($ubayam_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['ubayam'][$productName])) {
																$sale_summary['ubayam'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}
															$sale_summary['ubayam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['ubayam'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['ubayam']['total_amount'] += $ubayam_detail['amount'];
														$sale_summary['ubayam']['paid_amount'] += $ubayam_detail['paidamount'];


														if (empty($summary_total['sales'][$ubayam_detail['paymentmode']]))
															$summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
														$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $ubayam_detail['customer_name']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php echo $ubayam_detail['date']; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($ubayam_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($ubayam_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($ubayam_detail['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} elseif ($ubayam_detail['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $ubayam_detail['paymentmode']));

																echo $paymentname;
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $ubayam_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($ubayam_detail['amount'], 2);
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($ubayam_detail['paidamount'], 2);
																?>
															</td>
														</tr>
														<?php
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="6">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($ubayam_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$donation_total = 0;
									$sale_summary['donation'] = array();
									$sale_summary['donation']['total_amount'] = 0;
									if (count($donation_details) > 0) {
										?>
										<div class="col-md-12">
											<h3>Cash Donation Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;text-align:right;">Amount
															(S$)
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$d_i = 1;
													foreach ($donation_details as $donation_detail) {
														$donation_total = $donation_total + $donation_detail['paidamount'];
														if (empty($summary_total['sales'][$donation_detail['paymentmode']]))
															$summary_total['sales'][$donation_detail['paymentmode']] = 0;
														$summary_total['sales'][$donation_detail['paymentmode']] += $donation_detail['paidamount'];
														if (empty($sale_summary['donation'][$donation_detail['package_name']]['name_eng']))
															$sale_summary['donation'][$donation_detail['package_name']]['name_eng'] = $donation_detail['package_name'];
														if (empty($sale_summary['donation'][$donation_detail['package_name']]['name_tamil']))
															$sale_summary['donation'][$donation_detail['package_name']]['name_in_tamil'] = '';
														$sale_summary['donation'][$donation_detail['package_name']]['qty'] += 1;
														if (empty($sale_summary['donation'][$donation_detail['package_name']]['total']))
															$sale_summary['donation'][$donation_detail['package_name']]['total'] = 0;
														$sale_summary['donation'][$donation_detail['package_name']]['total'] += $donation_detail['paidamount'];
														if (empty($sale_summary['donation'][$donation_detail['package_name']]['ledger_code']))
															$sale_summary['donation'][$donation_detail['package_name']]['ledger_code'] = $donation_detail['ledger_code'];

														$sale_summary['donation']['total_amount'] += $donation_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $d_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $donation_detail['person_name'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($donation_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($donation_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($donation_detail['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} elseif ($donation_detail['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $donation_detail['paymentmode']));

																echo $paymentname;
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
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="3">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($donation_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$prasadam_total = 0;
									$sale_summary['prasadam'] = array();
									$sale_summary['prasadam']['total_amount'] = 0;
									$sale_summary['prasadam']['paid_amount'] = 0;
									if (count($prasadam_details) > 0) {
										?>
										<div class="col-md-12">
											<h3>Prasadam Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Payment Type</th>
														<th style="padding: 5px 10px!important;text-align:right;">Total
															Amount (S$)
														<th style="padding: 5px 10px!important;text-align:right;">Paid
															Amount (S$) </th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ps_i = 1;

													foreach ($prasadam_details as $prasadam_detail) {
														$prasadam_total += $prasadam_detail['paidamount'];

														foreach ($prasadam_detail['products'] as $product) {
															$productName = $product['package_name'];

															if (!isset($sale_summary['prasadam'][$productName])) {
																$sale_summary['prasadam'][$productName] = [
																	'name_eng' => $productName,
																	'ledger_code' => $product['ledger_code'],
																	'qty' => 0,
																	'total' => 0
																];
															}

															$sale_summary['prasadam'][$productName]['qty'] += $product['quantity'];  // Use actual quantity from the products array
															$sale_summary['prasadam'][$productName]['total'] += $product['amount'];
														}
														$sale_summary['prasadam']['total_amount'] += $prasadam_detail['amount'];
														$sale_summary['prasadam']['paid_amount'] += $prasadam_detail['paidamount'];

														if (empty($summary_total['sales'][$prasadam_detail['paymentmode']]))
															$summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
														$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];
														?>

														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ps_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $prasadam_detail['customer_name'];
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																if ($prasadam_detail['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($prasadam_detail['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($prasadam_detail['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} elseif ($prasadam_detail['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $prasadam_detail['paymentmode']));

																echo $paymentname;
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo $prasadam_detail['payment_type'];
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($prasadam_detail['amount'], 2);
																?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($prasadam_detail['paidamount'], 2);
																?>
															</td>
														</tr>
														<?php
														$ps_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="5">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($prasadam_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$total_grams = 0;
									if (!empty($product_offering_details)) {
										?>
										<div class="col-md-12">
											<h3>Product Offering Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">S.No</th>
														<th style="padding: 5px 10px!important;">Name</th>
														<th style="padding: 5px 10px!important;">Category</th>
														<th style="padding: 5px 10px!important;">Product </th>
														<th style="padding: 5px 10px!important;">Grams</th>
														<!-- <th style="padding: 5px 10px!important;text-align:right;">Amount (S$)  -->
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;
													foreach ($product_offering_details as $details) {
														$total_grams += $details['grams'];
														$productName = $details['category_name'];

														if (!isset($sale_summary['Product Offering'][$productName])) {
															$sale_summary['Product Offering'][$productName] = [
																'name_eng' => $productName,
																'ledger_code' => 0,
																'qty' => 0,
																'total' => 0
															];
														}

														$sale_summary['Product Offering'][$productName]['qty'] += 1;
														$sale_summary['Product Offering'][$productName]['total'] += $details['grams'];

														if (empty($summary_total['sales'][$details['paymentmode']]))
															$summary_total['sales'][$details['paymentmode']] = 0;
														$summary_total['sales'][$details['paymentmode']] += $details['grams'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php echo $details['customer_name']; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php echo $details['category_name']; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php echo $details['product_name']; ?>
															</td>


															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo $details['grams'];
																?>
															</td>
														</tr>
														<?php
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="4">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($total_grams, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>

									<?php
									$payment_voucher_total = 0;
									if (count($payment_voucher_details) > 0) {
										?>
										<div class="col-md-12">
											<h3>Payment Voucher Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="padding: 5px 10px!important;">#</th>
														<th style="padding: 5px 10px!important;">Paid To</th>
														<th style="padding: 5px 10px!important;">Payment Mode</th>
														<th style="padding: 5px 10px!important;">Remarks</th>
														<th style="padding: 5px 10px!important;text-align:right;">Amount
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$pv_i = 1;
													foreach ($payment_voucher_details as $payment_voucher_detail) {
														$payment_voucher_total = $payment_voucher_total + $payment_voucher_detail['paidamount'];
														if (empty($summary_total['expense'][$payment_voucher_detail['paymentmode']]))
															$summary_total['expense'][$payment_voucher_detail['paymentmode']] = 0;
														$summary_total['expense'][$payment_voucher_detail['paymentmode']] += $payment_voucher_detail['paidamount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $pv_i; ?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo strtoupper($payment_voucher_detail['paid_to']);
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																$paymentname = strtoupper($payment_voucher_detail['paymentmode']);
																echo $paymentname;
																?>
															</td>
															<td style="padding: 5px 10px!important;">
																<?php
																echo strtoupper($payment_voucher_detail['details'])
																	?>
															</td>
															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($payment_voucher_detail['paidamount'], 2);
																?>
															</td>
														</tr>
														<?php
														$pv_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="4">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($payment_voucher_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>
									<?php
									$repayment_total = 0;
									// echo '<pre>';
									// print_r($repayment_details);
									// echo '</pre>';
									$sale_summary['Repayment'] = array();
									$sale_summary['Repayment']['total_amount'] = 0;
									//$sale_summary['Repayment']['paid_amount'] = 0;
									
									if (!empty($repayment_details)) {
										?>
										<div class="col-md-12">
											<h3>Repayment Details</h3>
										</div>
										<div class="table-responsive col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<table class="table table-bordered table-striped table-hover">
												<thead style="background: #3F51B5;color: #fff;">
													<tr>
														<th style="width: 10%; padding: 5px 10px!important;">S.No</th>
														<th style="width: 20%; padding: 5px 10px!important;">Type</th>
														<th style="width: 25%; padding: 5px 10px!important;">Name</th>
														<th style="width: 15%; padding: 5px 10px!important;">Booked Date
														</th>
														<!-- <th style="padding: 5px 10px!important;">Paid Amount</th> -->
														<th style="width: 15%; padding: 5px 10px!important;">Payment Mode
														</th>
														<th
															style="width: 15%; padding: 5px 10px!important; text-align:right;">
															Booking Amount</th>
														<th
															style="width: 15%; padding: 5px 10px!important; text-align:right;">
															Amount
														</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$ans_i = 1;
													foreach ($repayment_details as $details) {
														$repayment_total += $details['repaid_amount'];
														$productName = $details['type'];

														if (!isset($sale_summary['Repayment'][$productName])) {
															$sale_summary['Repayment'][$productName] = [
																'name_eng' => $productName,
																'ledger_code' => 0,
																'qty' => 0,
																'total' => 0
															];
														}

														$sale_summary['Repayment'][$productName]['qty'] += 1;
														$sale_summary['Repayment'][$productName]['total'] += $details['repaid_amount'];

														$sale_summary['Repayment']['total_amount'] += $details['repaid_amount'];
														//$sale_summary['Repayment']['paid_amount'] += $details['repaid_amount'];
												
														if (empty($summary_total['sales'][$details['paymentmode']]))
															$summary_total['sales'][$details['paymentmode']] = 0;
														$summary_total['sales'][$details['paymentmode']] += $details['repaid_amount'];
														?>
														<tr>
															<td style="padding: 5px 10px!important;">
																<?php echo $ans_i; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php echo $details['type']; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php echo $details['customer_name']; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php echo $details['date']; ?>
															</td>

															<td style="padding: 5px 10px!important;">
																<?php
																if ($details['paymentmode'] == "ipay_merch_qr") {
																	$paymentname = "QR PAYMENT";
																} elseif ($details['paymentmode'] == "ipay_merch_online") {
																	$paymentname = "ONLINE PAYMENT";
																} elseif ($details['paymentmode'] == "cash") {
																	$paymentname = "CASH";
																} elseif ($details['paymentmode'] == "nets_pay") {
																	$paymentname = 'NETS';
																} else
																	$paymentname = strtoupper(str_replace('_', ' ', $details['paymentmode']));

																echo $paymentname;
																?>
															</td>

															<td style="padding: 5px 10px!important; text-align:right;">
																<?php echo $details['amount']; ?>
															</td>

															<td style="padding: 5px 10px!important;text-align:right;">
																<?php
																echo number_format($details['repaid_amount'], 2);
																?>
															</td>
														</tr>
														<?php
														$ans_i++;
													}
													?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="6">&nbsp;</td>
														<td
															style="padding: 5px 10px!important;text-align:right;font-weight:bold;">
															<?php echo number_format($repayment_total, 2); ?>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
										<?php
									}
									?>

									<div class="row">
										<div class="col-md-3 det" style="float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												Payment Summary
											</h3>
										</div>
										<div class="col-md-9"></div>
										<div class="col-md-3 det">
											<?php
											$cash_total = 0;
											$summary_totals_income = [];
											$summary_totals_expense = [];
											if (!empty($summary_total['sales'])) {
												foreach ($summary_total['sales'] as $vl => $st) {
													if ($vl == 'cash' || $vl == 'Cash') {
														$paymentname = 'CASH';
														$cash_total += $st;
													} elseif ($vl == "ipay_merch_qr") {
														$paymentname = "QR PAYMENT";
													} elseif ($vl == "ipay_merch_online") {
														$paymentname = "ONLINE PAYMENT";
													} elseif ($vl == "nets_pay" || $vl == "Nets Pay") {
														$paymentname = 'NETS';
													} elseif ($vl == "pay_now" || $vl == "Pay Now") {
														$paymentname = 'PAY NOW';
													} else {
														$paymentname = strtoupper(str_replace('_', ' ', $vl));
													}

													if (isset($summary_totals_income[$paymentname])) {
														$summary_totals_income[$paymentname] += $st;
													} else {
														$summary_totals_income[$paymentname] = $st;
													}
												}
											}

											if (count($summary_totals_income)) {
												echo '<h4 class>Incomes</h4>';
												foreach ($summary_totals_income as $paymentname => $total) {
													if ($total != 0 && !empty($total) && $total != '0.00') {
														if ($paymentname == 'GOLD' || $paymentname == 'SILVER') {
															echo '<p>' . $paymentname . ' : ' . number_format($total, 2) . ' grams ' . '</p>';
														} else {
															echo '<p>' . $paymentname . ' : ' . number_format($total, 2) . '</p>';
														}
													}
												}
											} ?>

										</div>
										<div class="col-md-3 det">
											<?php
											if (!empty($summary_total['expense'])) {
												foreach ($summary_total['expense'] as $vl => $st) {
													if ($vl == 'cash' || $vl == 'Cash') {
														$paymentname = 'CASH';
														$cash_total += $st;
													} elseif ($vl == "ipay_merch_qr") {
														$paymentname = "QR PAYMENT";
													} elseif ($vl == "ipay_merch_online") {
														$paymentname = "ONLINE PAYMENT";
													} elseif ($vl == "nets_pay" || $vl == "Nets Pay") {
														$paymentname = 'NETS';
													} elseif ($vl == "pay_now" || $vl == "Pay Now") {
														$paymentname = 'PAY NOW';
													} else {
														$paymentname = strtoupper(str_replace('_', ' ', $vl));
													}

													if (isset($summary_totals_expense[$paymentname])) {
														$summary_totals_expense[$paymentname] += $st;
													} else {
														$summary_totals_expense[$paymentname] = $st;
													}
												}
											}

											if (count($summary_totals_expense)) {
												echo '<h4 class>Expenses</h4>';
												foreach ($summary_totals_expense as $paymentname => $total) {
													if ($total != 0 && !empty($total) && $total != '0.00') {
														if ($paymentname == 'GOLD' || $paymentname == 'SILVER') {
															echo '<p>' . $paymentname . ' : ' . number_format($total, 2) . ' grams ' . '</p>';
														} else {
															echo '<p>' . $paymentname . ' : ' . number_format($total, 2) . '</p>';
														}
													}
												}
											}

											$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $repayment_total - $payment_voucher_total;
											echo '<br><p><strong>Sub Total:</strong> ' . number_format($total, 2) . '</p>';

											$float_cash = $floating_cash['amount'];
											$cash_drawer = $summary_totals_income['CASH'] + $float_cash;
											echo '<p><strong>Cash Drawer Balance:</strong> ' . number_format($cash_drawer, 2) . '</p>';
											echo '<p><strong>Less Float Cash:</strong> ' . number_format($float_cash, 2) . '</p>';
											?>

										</div>
										<div class="col-md-12 det"
											style="background:#FFF; float:none;margin-bottom:0px;">
											<h3 style="text-align:center;font-weight: bold;">
												GRAND TOTAL :
												<?php
												$grand_total = $total;
												echo number_format($grand_total, 2);
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
		<script>
			window.print();
		</script>
</body>

</html>