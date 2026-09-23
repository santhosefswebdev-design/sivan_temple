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
		font-size: 11px;
		text-align: center;
		font-weight: 600;
		font-family: monospace;
		margin: 0px
	}
</style>
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


<p style="border-bottom: 3px dotted #9E9E9E;max-width: 80mm;"></p>
<h3 style="text-align: center;text-transform: uppercase;max-width: 80mm;margin: 5px 0;font-size: 16px;">Office Copy</h3>
<p style="border-bottom: 3px dotted #9E9E9E;max-width: 80mm;"></p>
<br>
<div style="max-width: 80mm;max-height:auto;font-weight: 600;font-family: monospace;">
	<p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
			align="center"></p>
	<p style="font-size:18px;">
		<?php echo $temp_details['name']; ?>
	</p>
	<p>
		<?php echo $_SESSION['address1_frend']; ?></br>
		<?php echo $_SESSION['address2_frend']; ?></br>
		<?php echo $_SESSION['city_frend'] . '-' . $_SESSION['postcode_frend']; ?>,
		Tel:
		<?= $_SESSION['telephone_frend']; ?>
	</p>
	<hr>
	<p style="text-align:center; font-size:17px;"> <b>Ubayam Voucher </b></p><br>
	<p><b>Date : </b>
		<?php $date = new DateTime($qry1['dt']);
		echo $date->format('d-m-Y'); ?>
	</p>
	<p><b>Invoice : </b>
		<?php echo $qry1['ref_no']; ?>
	</p>
	<p><b>Name : </b>
		<?php echo $qry1['name']; ?>
	</p>
	<p><b>Amount(RM) : </b>
		<?php echo number_format($qry1['amount'], '2', '.', ','); ?>
	</p>
	<p><b>Paid Amount(RM) : </b>
		<?php echo number_format($qry1['paidamount'], '2', '.', ','); ?>
	</p>
	<p><b>Balance Amount(RM) : </b>
		<?php echo ($qry1['balanceamount'] > 0) ? number_format($qry1['balanceamount'], '2', '.', ',') : 0.00; ?>
	</p>
	<br>
	<br>
	<!-- <p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p> -->
</div>
<br>
<p style="border-bottom: 3px dotted #9E9E9E;max-width: 80mm;"></p>
<h3 style="text-align: center;text-transform: uppercase;max-width: 80mm;margin: 5px 0;font-size: 16px;">Customer Copy
</h3>
<p style="border-bottom: 3px dotted #9E9E9E;max-width: 80mm;"></p>
<br>
<div style="max-width: 80mm;max-height:auto;font-weight: 600;font-family: monospace;">
	<p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;"
			align="center"></p>
	<p style="font-size:18px;">
		<?php echo $temp_details['name']; ?>
	</p>
	<p>
		<?php echo $_SESSION['address1_frend']; ?></br>
		<?php echo $_SESSION['address2_frend']; ?></br>
		<?php echo $_SESSION['city_frend'] . '-' . $_SESSION['postcode_frend']; ?>,
		Tel:
		<?= $_SESSION['telephone_frend']; ?>
	</p>
	<hr>
	<p style="text-align:center; font-size:17px;"> <b>Ubayam Voucher </b></p><br>
	<p><b>Date : </b>
		<?php $date = new DateTime($qry1['dt']);
		echo $date->format('d-m-Y'); ?>
	</p>
	<p><b>Invoice : </b>
		<?php echo $qry1['ref_no']; ?>
	</p>
	<p><b>Name : </b>
		<?php echo $qry1['name']; ?>
	</p>
	<p><b>Amount(RM) : </b>
		<?php echo number_format($qry1['amount'], '2', '.', ','); ?>
	</p>
	<p><b>Paid Amount(RM) : </b>
		<?php echo number_format($qry1['paidamount'], '2', '.', ','); ?>
	</p>
	<p><b>Balance Amount(RM) : </b>
		<?php echo ($qry1['balanceamount'] > 0) ? number_format($qry1['balanceamount'], '2', '.', ',') : 0.00; ?>
	</p>
	<br>
	<br>
	<!-- <p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p> -->
</div>

<script>
	window.print();
</script>