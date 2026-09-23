<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reconciliation</title>
<style>
body { text-transform:uppercase; }
.amt { border-bottom:1px solid #666666; }
table tr td { padding:2px 7px; }
hr { margin:0; }
</style>
</head>

<body>
	<table style="width:100%">
		<tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
		<td width="85%" align="center"><h2 style="text-align:center;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
		<p style="text-align:center; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <?php echo $_SESSION['address2']; ?>,
		<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
		Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
	</table>
<h2 style="text-align:center;">RECONCILIATION REPORT AT <?php echo date('M, Y', strtotime($recon_month . '-01')); ?></h2>
<table style="width:100%;">
	<thead>
		<tr>
			<td>ID#</td>
			<td>Date</td>
			<td>Memo/Payee</td>
			<td>Payments</td>
			<td>Charges</td>
		</tr>
	</thead>
	<tbody>
	<?php
	$outstanding_charges = 0;
	if(count($pending_credit_transactions) > 0){
		echo '<tr><td colspan="5">&nbsp;</td></tr>';
		echo '<tr><td colspan="5">Outstanding Charges</td></tr>';
		echo '<tr><td colspan="5">&nbsp;</td></tr>';
		foreach($pending_credit_transactions as $pct){
			echo '<tr><td>' . $pct['entry_code'] . '</td><td>' . date('d-m-Y', strtotime($pct['date'])) . '</td><td>' . $pct['entry_code'] . '</td><td>-</td><td>' . number_format(abs($pct['amount']), 2) . '</td></tr>';
			$outstanding_charges += $pct['amount'];
		}
	}
	?>
	<?php
	$outstanding_payments = 0;
	if(count($pending_debit_transactions) > 0){
		echo '<tr><td colspan="5">&nbsp;</td></tr>';
		echo '<tr><td colspan="5">Outstanding Payments</td></tr>';
		echo '<tr><td colspan="5">&nbsp;</td></tr>';
		foreach($pending_debit_transactions as $pbt){
			echo '<tr><td>' . $pbt['entry_code'] . '</td><td>' . date('d-m-Y', strtotime($pbt['date'])) . '</td><td>' . $pbt['entry_code'] . '</td><td>' .  number_format(abs($pbt['amount']), 2) . '</td><td>-</td></tr>';
			$outstanding_payments += $pbt['amount'];
		}
	}
	?>
	</tbody>
</table>
<hr>
<div class="reconciliation">
	<h3>Reconciliation</h3>
	<table>
		<tbody>
			<tr>
				<td>ABSS Balance on <?php echo date('d-m-Y', strtotime($tdate)); ?>:</td>
				<td align="right"><?php if($cleared_balance > 0) $cleared_balance_amount = number_format(abs($cleared_balance), 2); else $cleared_balance_amount = '(' . number_format(abs($cleared_balance), 2) . ')'; echo $cleared_balance_amount; ?></td>
			</tr>
			<tr>
				<td>Subtract: Outstanding Charges:</td>
				<td align="right"><?php echo number_format(abs($outstanding_charges), 2) ; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><hr></td>
			</tr>
			<tr>
				<td>Subtotal:</td>
				<td align="right"><?php $subtotal = $cleared_balance - $outstanding_charges; if($subtotal > 0) $subtotal_amount = number_format(abs($subtotal), 2); else $subtotal_amount = '(' . number_format(abs($subtotal), 2) . ')'; echo $subtotal_amount ; ?></td>
			</tr>
			<tr>
				<td>Add: Outstanding Payments:</td>
				<td align="right"><?php echo number_format(abs($outstanding_payments), 2) ; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><hr></td>
			</tr>
			<tr>
				<td>Expected Balance on Statement:</td>
				<td align="right"><?php $expected_total = $subtotal + $outstanding_payments; if($subtotal > 0) $expected_total_amount = number_format(abs($expected_total), 2); else $expected_total_amount = '(' . number_format(abs($expected_total), 2) . ')'; echo $expected_total_amount ; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><hr></td>
			</tr>
		</tbody>
	</table>
</div>
<script>
window.print();
</script>
</body>
</html>
