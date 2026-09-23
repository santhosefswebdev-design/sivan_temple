<title>
	<?php echo $_SESSION['site_title']; ?>
</title>
<?php $db = db_connect(); ?>
<style>
	td {
		padding: 5px;
	}

	table {
		border-collapse: collapse;
		width: 100%;
	}

	div.head {
		text-align: center;
		margin-bottom: 30px;
	}

	h2,
	h5 {
		margin: 2px;
	}

	P {
		margin: 25px 0;
	}

	ol li {
		font-weight: bold;
		line-height: 20px;
		margin-bottom: 10px;
	}

	h2 {
		font-size: 20px;
	}
</style>

<head>

<body width="100%">
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
	<table align="center" width="100%">
		<tr>
			<td colspan="2">
				<table style="width:100%">
					<tr>
						<td width="15%" align="left">
							<img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>"
								style="width:120px; display:block;" align="left" />
						</td>
						<td width="85%" align="left">
							<h2 style="text-align:left;margin-bottom: 0;">
								<?php echo $_SESSION['site_title']; ?>
							</h2>
							<p style="text-align:left; font-size:16px; margin:5px;">
								<?php echo $_SESSION['address1']; ?>, <br>
								<?php echo $_SESSION['address2']; ?>,<br>
								<?php echo $_SESSION['city']; ?> -
								<?php echo $_SESSION['postcode']; ?><br>
								Tel :
								<?php echo $_SESSION['telephone']; ?>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<h4><b>OFFICIAL RENT RECEIPT </b></h4>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table style="width:100%" border="0">
					<tr>
						<td style="width:50%">
							<p>RM : <span style="border-bottom:1px solid #CCCCCC; width:27%;display: inline-grid;">
									<?php echo $rental['amount']; ?>
								</span> </p>
						</td>
						<td style="width:50%" align="right">
							<p>DATE : <span style="border-bottom:1px solid #CCCCCC; width:27%;display: inline-grid;">
									<?php echo date('d/m/Y', strtotime($rental['created_at'])); ?>
								</span> </p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p style="text-align:left;">RECEIVED FROM : <span
									style="border-bottom:1px solid #CCCCCC; width:75%;display: inline-grid;">
									<?php echo $rental['payee_name']; ?>
								</span> </p>
							<p style="text-align:left;">RINGGIT MALAYSIA : <span
									style="border-bottom:1px solid #CCCCCC; width:75%;display: inline-grid;">
									<?php echo AmountInWords($rental['amount']); ?>
								</span> </p>
							<p style="text-align:left;">HOUSE/LAND RENT NO : <span
									style="border-bottom:1px solid #CCCCCC; width:68%;display: inline-grid;">
									<?php echo $rental['lot_no']; ?>(
									<?php echo $rental['area']; ?>)
								</span> </p>
							<p style="text-align:left;">FOR THE MONTH : <span
									style="border-bottom:1px solid #CCCCCC; width:75%;display: inline-grid;">
									<?php echo $rental['month_year']; ?>
								</span> </p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<h4 style="text-align:center;text-transform: uppercase;"> Payment Details </h4>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="1" style="width:100%" align="center">
					<tr>
						<th width="33%" style="text-align:left;text-transform: uppercase;">Payment Date</th>
						<th width="33%" style="text-transform: uppercase;">Payment Mode</th>
						<th width="33%" style="text-align:left;text-transform: uppercase;">Amount</th>
					</tr>
					<?php
					foreach ($pay_details as $row) {
						$payment_mode = $db->table("payment_mode")->where('id', $row['payment_mode'])->get()->getRowArray();
						$payment_mode_name = !empty($payment_mode['name']) ? $payment_mode['name'] : "";
						?>
						<tr>
							<td>
								<?php echo date("d/m/Y", strtotime($row['date'])); ?>
							</td>
							<td align="center">
								<?php echo $payment_mode_name; ?>
							</td>
							<td>
								<?php echo $row['amount']; ?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<p style="text-align:center;"><b>REMINDER</b></p>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="width:100%">
				<ol>
					<li>THE BOARD'S PERMISSION SHOULD BE ASKED BEFORE THE LAND TENANT'S HOUSE IS CHANGED OR THE WAQF
						BOARD'S HOUSE IS CHANGED TENANT. </li>
					<li>RENT SHOULD BE CLARIFIED ON OR BEFORE THE 7TH OF THE EACH MONTH. </li>
				</ol>
			</td>
		</tr>

	</table>
	<!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
	  <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
	</p> -->
	<script>
		window.print();
	</script>
</body>