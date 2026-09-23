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
</style>
<?php
// Create a function for converting the amount in words
		if(!function_exists('AmountInWords')){
			function AmountInWords(float $amount)
			{
			  $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
			  $get_paise = ($amount_after_decimal > 0) ? " and Cents " . trim(NumToWords($amount_after_decimal)) : '';
			  return (NumToWords($amount) ? 'Ringgit ' . trim(NumToWords($amount)) . '' : '') . $get_paise . ' Only';

			}
		}
		if(!function_exists('NumToWords')){
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
		}

$paymentmode = $db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
$ricecategory = $db->table('annathanam_rice_category')->where('id', $data['rice_category_id'])->get()->getRowArray();
$kurumatype = $db->table('annathanam_kuruma_type')->where('id', $data['kuruma_id'])->get()->getRowArray();
$ricetype = $db->table('annathanam_rice_type')->where('id', $data['rice_type_id'])->get()->getRowArray();
?>
<table align="center" width="100%">
	<tr>
		<td colspan="2">
			<table style="width:100%">
				<tr><td width="100%" colspan="2" style="text-align:center;"><img src="<?php echo base_url(); ?>/uploads/header/temple_header.jpg"></td></tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<h2 style="text-align:center;"> Annathanam Voucher </h2>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1" style="width:100%" align="center">
				<tr>
					<th align="left">Date </th>
					<td>
						<?php $date = new DateTime($data['date']);
						echo $date->format('d-m-Y'); ?>
					</td>
					<th align="left">Invoice </th>
					<td>
						<?php echo $data['ref_no']; ?>
					</td>
				</tr>
				<tr>
					<th align="left">Name </th>
					<td>
						<?php echo $data['name']; ?>
					</td>
					<th align="left">H/P </th>
					<td>
						<?php echo $data['phone_no']; ?>
					</td>
				</tr>
				<tr>
					<th align="left">Slot Time </th>
					<td>
						<?php echo $data['slot_time']; ?>
					</td>
					<th align="left">Rice Type </th>
					<td>
						<?php echo !empty($ricetype['name']) ? $ricetype['name'] : ""; ?>
					</td>
				</tr>
				<tr>
					<th align="left">Rice Category </th>
					<td>
						<?php echo !empty($ricecategory['name_eng']) ? $ricecategory['name_eng'] : ""; ?>
					</td>
					<th align="left">Kuruma </th>
					<td>
						<?php echo !empty($kurumatype['name_eng']) ? $kurumatype['name_eng'] : ""; ?>
					</td>
				</tr>
				<tr>
					<th align="left">Amount </th>
					<td>
						<?php echo $data['amount']; ?>
					</td>
					<th align="left">No of Pax </th>
					<td>
						<?php echo $data['no_of_pax']; ?>
					</td>
				</tr>
				<tr>
					<th align="left">Total Amount </th>
					<td>
						<?php echo $data['total_amount']; ?>
					</td>
					<th align="left">Payment Mode </th>
					<td>
						<?php echo !empty($paymentmode['name']) ? $paymentmode['name'] : ""; ?>
					</td>
				</tr>
				<tr>
					<th align="left">Amount In words</th>
					<td colspan="3">
						<?php echo AmountInWords($data['total_amount']); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<h4 style="text-align:center;">TYPE OF VEGETABLES </h4>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table border="1" style="width:100%" align="center">
				<tr>
					<th width="15%" style="text-align:left">SNo</th>
					<th width="85%">Description</th>
				</tr>
				<?php
				$vi = 1;
				foreach ($annathanam_items as $row) {
					?>
					<tr>
						<td>
							<?php echo $vi++; ?>
						</td>
						<td>
							<?php echo $row['name_eng']; ?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	
</table>
<table align="center" width="100%">
    <tr>
        <td>AUTHORIZED BY - PRESIDENT</td>
        <td>PREPARED BY - SECRETARY</td>
        <td>RECEIVED BY - TREASURER</td>
    </tr>
</table>
<!-- <p class="dot_line" style="bottom:0;position:relative;margin-top: 100px;">
	  <span>---------------------------------</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---------------------------------</span>
	</p> -->
<script>
	window.print();
</script>