<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Barlow&display=swap" rel="stylesheet">
<style>
body { font-family: 'Barlow', sans-serif; }
table { border-collapse:collapse; }
table td { padding:2px; }
.mem_dets{  text-transform: uppercase; font-size: 11px; }
</style>
<?php
// Create a function for converting the amount in words
if(!function_exists('AmountInWords')){
	function AmountInWords(float $amount)
	{	$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
			$get_paise = ($amount_after_decimal > 0) ? " and Cents ". trim(NumToWords($amount_after_decimal)):'';
			return (NumToWords($amount) ? 'Ringgit '.trim(NumToWords($amount)).'' : ''). $get_paise. ' Only';
			
	}
}
if(!function_exists('NumToWords')){
	function NumToWords($num){
		$num=floor($num);
		$amt_hundred = null;
		$count_length = strlen($num);
		$x = 0;
		$string = array();
		$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
			$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
			while( $x < $count_length ) {
				$get_divider = ($x == 2) ? 10 : 100;
				$amount = floor($num % $get_divider);
				$num = floor($num / $get_divider);
				$x += $get_divider == 10 ? 1 : 2;
				if ($amount) {
					$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
					$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
					$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
				}else $string[] = null;
		}
		//$implode_to_Rupees = implode('', array_reverse($string));
		return(implode('', array_reverse($string)));
	}
}
?>

<table align="center" width="100%"  style="background-color: #d8b01d;border-radius: 5px;  width: 85.6mm; height: 54mm;" >
<tr> 
	<td style="padding-left: 4%; padding-top: 2%;" colspan="2"><h5 style="margin: 3px;">MEMBERSHIP CARD</h5></td>
</tr>
<tr style="background-color: black;"> 
	<td style="padding-left: 4%;color: #d8b01d;"><h5 style="margin: 5px;"><?php echo $temple_details['name']; ?></h5></td>
	<td style="padding-left: 4%;color: #d8b01d;"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temple_details['image']; ?>" align="center" style="width:40px; display:block; border-radius: 50%;" align="left" /></td>
</tr>
<tr><td colspan="2"></td></tr>
<tr><td colspan="2">
    <table width="90%" align="center">
    <tr><td width="40%" class="mem_dets"><b>NAME </b> </td><td class="mem_dets" width="60%"><b><?php echo $qry1['name']; ?></b></td></tr>
    <tr><td class="mem_dets"><b>M. NUMBER</b> </td><td class="mem_dets"><b><?php echo $qry1['member_no']; ?></b></td></tr>
    <tr><td class="mem_dets"><b>MEMBER TYPE</b> </td><td class="mem_dets"><b><?php echo $qry1['tname']; ?></b></td></tr>
	<tr><td colspan="2"><hr style="margin: 1px"></td></tr>
	<tr>
		<td colspan="2" class="mem_dets">
			<?php echo $temple_details['address1']; ?>,<?php echo $temple_details['address2']; ?>, <?php echo $temple_details['city']; ?> - <?php echo $temple_details['postcode']; ?>
		</td>
	</tr>
    </table>
</td></tr>
</table>

<br><br>
<table align="center" width="100%"  style="background-color: #d8b01d;border-radius: 5px; width: 85.6mm; height: 54mm;" >
<tr><td colspan="2">
<table style="width:85.6mm;  height: 53mm; background-color: #d8b01d;" align="center">
<tr style="background-color: black;"> 
	<td align="center" colspan="2" style="color: #d8b01d;"><h4 style="margin-bottom: 3px;">CONSTITUTION</h4></td>
</tr>
<tr><td class="mem_dets" style="width:40%;"><b>I/C NO </b> </td><td class="mem_dets" style="width:60%;"><b><?php echo $qry1['ic_no']; ?></b></td></tr>

<tr>
	<td class="mem_dets"><b>MOBILE</b> </td><td class="mem_dets"><b><?php echo $qry1['mobile']; ?></b></td>
</tr>
<tr>
	<td class="mem_dets"><b>ADDRESS</b> </td><td class="mem_dets"><b><?php echo $qry1['address']; ?></b></td>
</tr>
<tr>
	<td class="mem_dets"><b>START DATE</b> </td><td class="mem_dets"><b><?php echo date("d/m/Y", strtotime($qry1['start_date'])); ?></b></td>
</tr>
<tr><td colspan="2"><hr style="margin: 1px"></td></tr>
<tr>
	<td class="mem_dets">&nbsp;</td><td class="mem_dets"><b><br>General Secretary</br></td>
</tr>

</table>
</td></tr>
</table>


