<?php $db = db_connect(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
	body {
		font-family: 'Barlow', sans-serif;
	}

	table {
		border-collapse: collapse;
	}

	table td {
		padding: 5px;
	}

	hr {
		border: none;
		border-top: 1px dashed #000;
		color: #fff;
		background-color: #fff;
		height: 1px;
	}

	p {
		font-size: 13px;
		font-family: monospace;
		margin: 0px
	}
</style>
<?php
$summary_total = array();
$summary_total['sales'] = array();
$summary_total['expense'] = array();
?>
<?php
// Create a function for converting the amount in words
function AmountInWords(float $amount)
{
	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
	$get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
	return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';

}
function NumToWords($num)
{
	$num = floor($num);
	$amt_hundred = null;
	$count_length = strlen($num);
	$x = 0;
	$string = array();
	$change_words = array(
		0 => '',
		1 => 'One',
		2 => 'Two',
		3 => 'Three',
		4 => 'Four',
		5 => 'Five',
		6 => 'Six',
		7 => 'Seven',
		8 => 'Eight',
		9 => 'Nine',
		10 => 'Ten',
		11 => 'Eleven',
		12 => 'Twelve',
		13 => 'Thirteen',
		14 => 'Fourteen',
		15 => 'Fifteen',
		16 => 'Sixteen',
		17 => 'Seventeen',
		18 => 'Eighteen',
		19 => 'Nineteen',
		20 => 'Twenty',
		30 => 'Thirty',
		40 => 'Forty',
		50 => 'Fifty',
		60 => 'Sixty',
		70 => 'Seventy',
		80 => 'Eighty',
		90 => 'Ninety'
	);
	$here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	while ($x < $count_length) {
		$get_divider = ($x == 2) ? 10 : 100;
		$amount = floor($num % $get_divider);
		$num = floor($num / $get_divider);
		$x += $get_divider == 10 ? 1 : 2;
		if ($amount) {
			$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
			$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
			$string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
		} else
			$string[] = null;
	}
	//$implode_to_Rupees = implode('', array_reverse($string));
	return (implode('', array_reverse($string)));
}
?>
<div style="max-width: 80mm;max-height: 355px;font-weight: 600;font-family: monospace;">

	<p style="text-align:center;"><img
			src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
			align="center"></p>
	<p style="font-size:16px;text-align:center;">
		<?php echo $temp_details['name']; ?>
	</p>
	<p style="text-align:center;">
		<?php echo $temp_details['address1']; ?></br>
		<?php echo $temp_details['address2']; ?></br>
		<?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>
		<br>Tel:
		<?= $temp_details['telephone']; ?>
			<!-- Display Logged-in Counter Username -->
<p style="text-align:center; font-weight: bold;">
    Counter Login: <?= isset($counter_user['username']) ? strtoupper($counter_user['username']) : 'UNKNOWN'; ?>
			</p>
	</p>
	<hr>
	<p style="text-align:center">
		<?php
		if ($dailyclosing_start_date == $dailyclosing_end_date) {
			echo "Date - [" . date('d-m-Y', strtotime($dailyclosing_start_date)) . "]";
		} else {
			echo "Date - [" . date('d-m-Y', strtotime($dailyclosing_start_date)) . " - " . date('d-m-Y', strtotime($dailyclosing_end_date)) . "]";
		}
		?>
	</p>
	<hr>

	<?php
	$archanai_total = 0;
	if (count($archanai_group_details) > 0) {
		?>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> ARCHANAI SELLING DETAILS </p>

		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Archanai</p>
				</th>
				<th align="center">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Quantity</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>


			<?php
			foreach ($archanai_group_details as $archanai_detail_data) {
				if (count($archanai_detail_data['data']) > 0) {
					$ar_i = 1;
					$sannathi_total = 0;
					$sannathi_qty = 0;
					echo '<tr><td colspan="5" style="text-align: center;"><hr><p style="text-align:center; text-transform: uppercase; font-weight: bold;">' . strtoupper($archanai_detail_data['title']) . '</p><hr></td></tr>';
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
							<td align="left">
								<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
									<?php echo $archanai_detail['name_in_english'] . "<br>" . $archanai_detail['name_in_tamil']; ?>
								</p>
							</td>
							<td align="center">
								<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
									<?php echo $archanai_detail['qty']; ?>
								</p>
							</td>
							<td align="right">
								<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
									<?php echo number_format($archanai_detail['amount'], 2); ?>
								</p>
							</td>
						</tr>
						<?php
						$ar_i++;
					}
					echo '<tr><td style="text-align: center;"><p>' . strtoupper($archanai_detail_data['title']) . ' Total</p></td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . $sannathi_qty . '</td><td style="padding: 5px 10px!important;text-align:right;font-weight:bold;">' . number_format($sannathi_total, 2) . '</td></tr>';
				}
			}
			?>
			<tr>
				<td colspan="3">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($archanai_total, 2); ?>
					</p>
				</td>
			</tr>
		</table>
		<hr>
	<?php }

	$hallbooking_total = 0;
	if (count($hallbooking_details) > 0) {
		?>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Hall Booking Details </p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Package Name</p>
				</th>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($hallbooking_details as $hallbooking_detail) {
				$hallbooking_total = $hallbooking_total + $hallbooking_detail['paidamount'];

				if (empty($summary_total['sales'][$hallbooking_detail['paymentmode']]))
					$summary_total['sales'][$hallbooking_detail['paymentmode']] = 0;
				$summary_total['sales'][$hallbooking_detail['paymentmode']] += $hallbooking_detail['paidamount'];

				foreach ($hallbooking_detail['products'] as $product) {
					$productName = $product['package_name'];
					?>
					<tr>
						<td align="left">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								<?php echo $productName; ?>
							</p>
						</td>
						<td align="left">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								<?php echo $hallbooking_detail['customer_name']; ?>
							</p>
						</td>
						<td align="right">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
								<?php echo number_format($hallbooking_detail['paidamount'], 2); ?>
							</p>
						</td>
					</tr>
					<?php
				}
			}
			?>
			<tr>
				<td colspan="3">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($hallbooking_total, 2); ?>
					</p>
				</td>
			</tr>
		</table>
		<?php
	}
	?>

	<?php
	$ubayam_total = 0;
	if (count($ubayam_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Ubayam Details </p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Package Name</p>
				</th>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Name</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($ubayam_details as $ubayam_detail) {
				$ubayam_total = $ubayam_total + $ubayam_detail['paidamount'];

				if (empty($summary_total['sales'][$ubayam_detail['paymentmode']]))
					$summary_total['sales'][$ubayam_detail['paymentmode']] = 0;
				$summary_total['sales'][$ubayam_detail['paymentmode']] += $ubayam_detail['paidamount'];

				foreach ($ubayam_detail['products'] as $product) {
					$productName = $product['package_name'];
					?>
					<tr>
						<td align="left">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								<?php echo $productName; ?>
							</p>
						</td>
						<td align="left">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								<?php echo $ubayam_detail['customer_name']; ?>
							</p>
						</td>
						<td align="right">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
								<?php echo number_format($ubayam_detail['paidamount'], 2); ?>
							</p>
						</td>
					</tr>
					<?php
				}
			}
			?>
			<tr>
				<td colspan="3">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($ubayam_total, 2); ?>
					</p>
				</td>
			</tr>
		</table>
		<?php
	}
	?>

	<?php
	$donation_total = 0;
	$sale_summary['donation'] = array();
	if (count($donation_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Cash Donation Details</p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Name</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
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
				?>
				<tr>
					<td align="left" colspan="2">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $donation_detail['person_name']; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($donation_detail['paidamount'], 2); ?>
						</p>
					</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="3">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($donation_total, 2); ?>
					</p>
				</td>
			</tr>
		</table>
		<?php
	}
	?>

	<?php
	$prasadam_total = 0;
	$sale_summary['prasadam'] = array();
	if (count($prasadam_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Prasadam Details</p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Product</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($prasadam_details as $prasadam_detail) {
				$prasadam_total = $prasadam_total + $prasadam_detail['paidamount'];

				if (empty($summary_total['sales'][$prasadam_detail['paymentmode']]))
					$summary_total['sales'][$prasadam_detail['paymentmode']] = 0;
				$summary_total['sales'][$prasadam_detail['paymentmode']] += $prasadam_detail['paidamount'];

				foreach ($prasadam_detail['products'] as $product) {
					$productName = $product['package_name'];

					if (empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['name_eng']))
						$sale_summary['prasadam'][$prasadam_detail['package_name']]['name_eng'] = $prasadam_detail['package_name'];
					if (empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['name_tamil']))
						$sale_summary['prasadam'][$prasadam_detail['package_name']]['name_in_tamil'] = '';
					$sale_summary['prasadam'][$prasadam_detail['package_name']]['qty'] += 1;
					if (empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['total']))
						$sale_summary['prasadam'][$prasadam_detail['package_name']]['total'] = 0;
					$sale_summary['prasadam'][$prasadam_detail['package_name']]['total'] += $prasadam_detail['paidamount'];
					if (empty($sale_summary['prasadam'][$prasadam_detail['package_name']]['ledger_code']))
						$sale_summary['prasadam'][$prasadam_detail['package_name']]['ledger_code'] = $prasadam_detail['ledger_code'];
					?>
					<tr>
						<td align="left" colspan="2">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
								<?php echo $productName; ?>
							</p>
						</td>
						<td align="right">
							<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
								<?php echo number_format($prasadam_detail['paidamount'], 2); ?>
							</p>
						</td>
					</tr>
					<?php
				}
			}
			?>
			<tr>
				<td colspan="3">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($prasadam_total, 2); ?>
					</p>
				</td>
			</tr>
		</table>
		<?php
	}
	?>
	<?php
	$total_grams = 0;
	if (count($product_offering_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Product Offering</p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Product</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($product_offering_details as $details) {
				$total_grams += $details['grams'];
				$productName = $details['product_name'];

				if (empty($summary_total['sales'][$details['paymentmode']]))
					$summary_total['sales'][$details['paymentmode']] = 0;
				$summary_total['sales'][$details['paymentmode']] += $details['grams'];
				?>
				<tr>
					<td align="left" colspan="2">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo $details['grams']; ?> Grams
						</p>
					</td>
				</tr>
				<?php
			}
			?>
			<!-- <tr>
			<td colspan="3">
				<hr>
			</td>
		</tr> -->
			<!-- <tr>
			<td colspan="2">
				<p style="text-align:left;text-transform: uppercase;font-weight:bold;font-size:11px;">SUB-TOTAL</p>
			</td>
			<td align="right">
				<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
					<?php //echo number_format($total_grams, 2); ?>
				</p>
			</td>
		</tr> -->
		</table>
		<?php
	}
	?>
	<hr>
	<?php
	$repayment_total = 0;
	if (count($repayment_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Repayment Details</p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;"> Type</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($repayment_details as $details) {
				$repayment_total += $details['repaid_amount'];
				$productName = $details['type'];

				if (empty($summary_total['sales'][$details['paymentmode']]))
					$summary_total['sales'][$details['paymentmode']] = 0;
				$summary_total['sales'][$details['paymentmode']] += $details['repaid_amount'];
				?>
				<tr>
					<td align="left" colspan="2">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo $productName; ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($details['repaid_amount'], 2); ?>
						</p>
					</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="3">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($repayment_total, 2); ?>
					</p>
				</td>

			</tr>
		</table>
		<?php
	}
	?>



	<?php
	$payment_voucher_total = 0;
	if (count($payment_voucher_details) > 0) {
		?>
		<hr>
		<p style="text-align:center; font-size:13px;text-transform: uppercase;"> Payment Voucher Details</p>
		<hr>
		<table style="width:100%;">
			<tr>
				<th align="left" colspan="2">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Name</p>
				</th>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Pay Mode</p>
				</th>
				<th align="left">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Remarks</p>
				</th>
				<th align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;text-transform: uppercase;">Amount</p>
				</th>
			</tr>
			<?php
			foreach ($payment_voucher_details as $payment_voucher_detail) {
				$payment_voucher_total = $payment_voucher_total + $payment_voucher_detail['paidamount'];
				if (empty($summary_total['expense'][$payment_voucher_detail['paymentmode']]))
					$summary_total['expense'][$payment_voucher_detail['paymentmode']] = 0;
				$summary_total['expense'][$payment_voucher_detail['paymentmode']] += $payment_voucher_detail['paidamount'];
				?>
				<tr>
					<td align="left" colspan="2" style="padding: 5px 10px!important;">
						<p>
							<?php echo strtoupper($payment_voucher_detail['paid_to']); ?>
						</p>
					</td>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo strtoupper($payment_voucher_detail['paymentmode']); ?>
						</p>
					</td>
					<td align="left">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">
							<?php echo strtoupper($payment_voucher_detail['details']); ?>
						</p>
					</td>
					<td align="right">
						<p style="margin:2px 0px;font-size:11px;text-transform: uppercase;font-weight:bold;">
							<?php echo number_format($payment_voucher_detail['paidamount'], 2); ?>
						</p>
					</td>
				</tr>

				<?php
			}
			?>
			<tr>
				<td colspan="5">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<p style="text-align:left;text-transform: uppercase;font-weight:bold;">SUB-TOTAL</p>
				</td>
				<td align="right">
					<p style="margin:2px 0px;font-size:11px;font-weight:bold;">
						<?php echo number_format($payment_voucher_total, 2); ?>
					</p>
				</td>
			</tr>
		</table>
	<?php
	}
	?>

	<?php
	// echo '<pre>';
	// print_r($summary_total['sales']);
	// exit;
	$summary_totals_income = [];
	$summary_totals_expense = [];
	if (count($summary_total['sales'])) {
		$cash_total = 0;
		echo '<hr><div class="col-md-12"><h3>Payment Summary</h3></div>
			<div class="table-responsive col-md-12" style="background:#FFF; float:none;margin-bottom:0px;">
			<table class="table-responsive col-md-12" style="width:100%;"><thead><tr><th align="left">Payment Mode</th><th align="right">Amount</th></tr></thead><tbody>';
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
			} elseif ($vl == "pay_pnow" || $vl == "Pay Now") {
				$paymentname = 'PAY NOW';
			} else
				$paymentname = strtoupper(str_replace('_', ' ', $vl));


			if (isset($summary_totals_income[$paymentname])) {
				$summary_totals_income[$paymentname] += $st;
			} else {
				$summary_totals_income[$paymentname] = $st;
			}
		}

		if (count($summary_totals_income)) {
			echo '<tr> <td><strong>Incomome: </strong></td></tr>';
			foreach ($summary_totals_income as $paymentname => $total) {
				echo '<tr>';
				if ($paymentname == 'GOLD' || $paymentname == 'SILVER') {
					echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $paymentname . '</p></td>';
					echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($total, 2) . ' grams ' . '</p></td>';
				} else {
					echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $paymentname . '</p></td>';
					echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($total, 2) . '</p></td>';
				}
				echo '</tr>';
			}
		}

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
			} elseif ($vl == "pay_pnow" || $vl == "Pay Now") {
				$paymentname = 'PAY NOW';
			} else
				$paymentname = strtoupper(str_replace('_', ' ', $vl));


			if (isset($summary_totals_expense[$paymentname])) {
				$summary_totals_expense[$paymentname] += $st;
			} else {
				$summary_totals_expense[$paymentname] = $st;
			}
		}

		if (count($summary_totals_expense)) {
			echo '<tr> <td><strong>Expenses: </strong></td></tr>';
			foreach ($summary_totals_expense as $paymentname => $total) {
				echo '<tr>';
				if ($paymentname == 'GOLD' || $paymentname == 'SILVER') {
					echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $paymentname . '</p></td>';
					echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($total, 2) . ' grams ' . '</p></td>';
				} else {
					echo '<td><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . $paymentname . '</p></td>';
					echo '<td align="right"><p style="margin:2px 0px;font-size:11px;text-transform: uppercase;">' . number_format($total, 2) . '</p></td>';
				}
				echo '</tr>';
			}
		}

		echo '</tbody></table></div>';
	}

	?>

	<table style="width:100%;">
		<tr>
			<hr>
			<td align="left" colsapn="2">
				<p style="text-align:left; font-size:13px;font-weight:bold;text-transform: uppercase;">GRAND TOTAL (RM)
				</p>
			</td>
			<td align="right">
				<p style="text-align: right;margin:2px 0px;font-size:13px;font-weight:bold;">
					<?php
					$float_cash = $floating_cash['amount'];
					$total = $archanai_total + $hallbooking_total + $ubayam_total + $donation_total + $prasadam_total + $repayment_total - $payment_voucher_total;
					$cash_drawer = $summary_totals_income['CASH'] + $float_cash;
					echo number_format($total - $float_cash, '2', '.', ',');
					?>
				</p>
			</td>
		</tr>
	</table>

	<hr>
	<br>
	<br>
	<br>
	<br>
	<!-- <p  class="dot_line"><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p> -->
</div>

<script>
	window.print();
	setTimeout(function () { window.close(); }, 60000);
</script>